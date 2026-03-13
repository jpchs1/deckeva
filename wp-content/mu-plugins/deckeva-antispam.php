<?php
/**
 * Plugin Name: Deckeva - Anti-Spam Protection
 * Description: Protección anti-spam para formularios: honeypot para CF7, rate limiting por IP,
 *              validación de campos, bloqueo de bots y protección del endpoint REST del tema.
 * Version: 1.0
 * Author: Deckeva
 */

if (!defined('ABSPATH')) exit;

/**
 * ==========================================================================
 * 1. RATE LIMITING POR IP (para todos los formularios)
 * ==========================================================================
 * Limita envíos de formularios a máximo 3 por IP cada 10 minutos.
 * Usa transients de WordPress (no requiere base de datos adicional).
 */
class Deckeva_Rate_Limiter {

    const MAX_SUBMISSIONS = 3;
    const WINDOW_SECONDS  = 600; // 10 minutos

    /**
     * Verifica si la IP actual excede el límite de envíos.
     *
     * @return bool True si está bloqueado (excede límite).
     */
    public static function is_rate_limited() {
        $ip  = self::get_client_ip();
        $key = 'deckeva_rl_' . md5($ip);

        $data = get_transient($key);

        if ($data === false) {
            // Primer envío de esta IP
            set_transient($key, array('count' => 1, 'first' => time()), self::WINDOW_SECONDS);
            return false;
        }

        if ($data['count'] >= self::MAX_SUBMISSIONS) {
            return true;
        }

        // Incrementar contador
        $data['count']++;
        $remaining = self::WINDOW_SECONDS - (time() - $data['first']);
        if ($remaining > 0) {
            set_transient($key, $data, $remaining);
        }

        return false;
    }

    /**
     * Obtiene la IP real del cliente (considera proxies/CDN).
     */
    public static function get_client_ip() {
        $headers = array(
            'HTTP_CF_CONNECTING_IP', // Cloudflare
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_REAL_IP',
            'REMOTE_ADDR',
        );

        foreach ($headers as $header) {
            if (!empty($_SERVER[$header])) {
                $ip = $_SERVER[$header];
                // X-Forwarded-For puede tener múltiples IPs
                if (strpos($ip, ',') !== false) {
                    $ip = trim(explode(',', $ip)[0]);
                }
                if (filter_var($ip, FILTER_VALIDATE_IP)) {
                    return $ip;
                }
            }
        }

        return '0.0.0.0';
    }
}

/**
 * ==========================================================================
 * 2. HONEYPOT PARA CONTACT FORM 7
 * ==========================================================================
 * Agrega un campo oculto (honeypot) a todos los formularios CF7.
 * Los bots lo llenan automáticamente; los humanos no lo ven.
 */

// Agregar campo honeypot al HTML del formulario CF7
add_filter('wpcf7_form_elements', 'deckeva_cf7_add_honeypot');
function deckeva_cf7_add_honeypot($content) {
    $honeypot = '<div style="position:absolute;left:-9999px;top:-9999px;height:0;width:0;overflow:hidden;" aria-hidden="true">';
    $honeypot .= '<label for="deckeva_website_url">Website</label>';
    $honeypot .= '<input type="text" name="deckeva_website_url" id="deckeva_website_url" value="" tabindex="-1" autocomplete="off" />';
    $honeypot .= '<input type="text" name="deckeva_phone_confirm" id="deckeva_phone_confirm" value="" tabindex="-1" autocomplete="off" />';
    $honeypot .= '</div>';

    // Agregar campo de timestamp para detectar envíos demasiado rápidos
    $honeypot .= '<input type="hidden" name="deckeva_form_ts" value="' . esc_attr(time()) . '" />';

    return $content . $honeypot;
}

/**
 * ==========================================================================
 * 3. VALIDACIÓN ANTI-SPAM EN CF7 (antes del envío)
 * ==========================================================================
 */
add_filter('wpcf7_validate', 'deckeva_cf7_antispam_validate', 1, 2);
function deckeva_cf7_antispam_validate($result, $tags) {

    // 3a. Verificar honeypot
    if (!empty($_POST['deckeva_website_url']) || !empty($_POST['deckeva_phone_confirm'])) {
        $result->invalidate(
            new WPCF7_FormTag(array('type' => 'text*', 'name' => 'your-name')),
            __('Error de validación. Intente nuevamente.', 'deckeva')
        );
        // Registrar intento de spam
        deckeva_log_spam('honeypot', Deckeva_Rate_Limiter::get_client_ip());
        return $result;
    }

    // 3b. Rate limiting
    if (Deckeva_Rate_Limiter::is_rate_limited()) {
        $result->invalidate(
            new WPCF7_FormTag(array('type' => 'text*', 'name' => 'your-name')),
            __('Demasiados envíos. Por favor espere unos minutos e intente nuevamente.', 'deckeva')
        );
        deckeva_log_spam('rate_limit', Deckeva_Rate_Limiter::get_client_ip());
        return $result;
    }

    // 3c. Verificar velocidad de envío (bots envían en < 3 segundos)
    if (isset($_POST['deckeva_form_ts'])) {
        $form_time = intval($_POST['deckeva_form_ts']);
        $elapsed   = time() - $form_time;
        if ($elapsed < 3) {
            $result->invalidate(
                new WPCF7_FormTag(array('type' => 'text*', 'name' => 'your-name')),
                __('Por favor complete el formulario con calma e intente nuevamente.', 'deckeva')
            );
            deckeva_log_spam('too_fast', Deckeva_Rate_Limiter::get_client_ip());
            return $result;
        }
    }

    // 3d. Verificar User-Agent (bots suelen tener UA vacío o sospechoso)
    $ua = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
    if (empty($ua) || strlen($ua) < 20) {
        $result->invalidate(
            new WPCF7_FormTag(array('type' => 'text*', 'name' => 'your-name')),
            __('Error de validación del navegador.', 'deckeva')
        );
        deckeva_log_spam('bad_ua', Deckeva_Rate_Limiter::get_client_ip());
        return $result;
    }

    // 3e. Verificar contenido spam en campos de texto
    $spam_patterns = array(
        '/\b(viagra|cialis|casino|lottery|bitcoin|crypto|prize|winner|click here|buy now)\b/i',
        '/\b(SEO|backlink|rank|traffic|web promotion|marketing offer)\b/i',
        '/https?:\/\/[^\s]+\.(ru|cn|tk|ml|ga|cf|gq|xyz|top|buzz|icu)\b/i', // Dominios spam comunes
        '/(http[s]?:\/\/.*){3,}/i', // 3+ URLs en un campo
    );

    $fields_to_check = array('your-message', 'your-name', 'message');
    foreach ($fields_to_check as $field_name) {
        if (isset($_POST[$field_name])) {
            $field_value = sanitize_text_field($_POST[$field_name]);
            foreach ($spam_patterns as $pattern) {
                if (preg_match($pattern, $field_value)) {
                    $result->invalidate(
                        new WPCF7_FormTag(array('type' => 'text*', 'name' => 'your-name')),
                        __('Su mensaje fue detectado como spam. Si es un error, contáctenos por WhatsApp.', 'deckeva')
                    );
                    deckeva_log_spam('content_spam', Deckeva_Rate_Limiter::get_client_ip());
                    return $result;
                }
            }
        }
    }

    return $result;
}

/**
 * ==========================================================================
 * 4. PROTECCIÓN DEL ENDPOINT REST DEL TEMA (The7 send-mail)
 * ==========================================================================
 * Agrega rate limiting al endpoint REST /wp-json/the7-*/send-mail
 */
add_filter('rest_pre_dispatch', 'deckeva_protect_rest_mail', 10, 3);
function deckeva_protect_rest_mail($result, $server, $request) {
    $route = $request->get_route();

    // Proteger el endpoint send-mail del tema The7
    if (strpos($route, '/send-mail') !== false) {
        // Rate limiting
        if (Deckeva_Rate_Limiter::is_rate_limited()) {
            deckeva_log_spam('rest_rate_limit', Deckeva_Rate_Limiter::get_client_ip());
            return new WP_Error(
                'too_many_requests',
                __('Demasiados envíos. Por favor espere unos minutos.', 'deckeva'),
                array('status' => 429)
            );
        }

        // Verificar User-Agent
        $ua = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        if (empty($ua) || strlen($ua) < 20) {
            deckeva_log_spam('rest_bad_ua', Deckeva_Rate_Limiter::get_client_ip());
            return new WP_Error(
                'invalid_request',
                __('Solicitud no válida.', 'deckeva'),
                array('status' => 403)
            );
        }
    }

    return $result;
}

/**
 * ==========================================================================
 * 5. BLOQUEAR ACCESO DIRECTO A wp-mail.php y xmlrpc.php
 * ==========================================================================
 */
add_action('init', 'deckeva_block_xmlrpc');
function deckeva_block_xmlrpc() {
    // Deshabilitar XML-RPC completamente
    add_filter('xmlrpc_enabled', '__return_false');

    // Remover el tag pingback del head
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');

    // Deshabilitar pingbacks
    add_filter('wp_headers', function($headers) {
        unset($headers['X-Pingback']);
        return $headers;
    });
}

/**
 * ==========================================================================
 * 6. PROTEGER COMENTARIOS DE WORDPRESS (si están habilitados)
 * ==========================================================================
 */
add_filter('pre_comment_on_post', 'deckeva_protect_comments');
function deckeva_protect_comments($comment_post_id) {
    if (Deckeva_Rate_Limiter::is_rate_limited()) {
        wp_die(
            __('Demasiados envíos. Espere unos minutos.', 'deckeva'),
            __('Rate Limited', 'deckeva'),
            array('response' => 429)
        );
    }
}

/**
 * ==========================================================================
 * 7. LOGGING DE SPAM
 * ==========================================================================
 */
function deckeva_log_spam($type, $ip) {
    if (defined('WP_DEBUG') && WP_DEBUG) {
        error_log(sprintf(
            '[Deckeva AntiSpam] Blocked: type=%s ip=%s ua=%s uri=%s',
            $type,
            $ip,
            isset($_SERVER['HTTP_USER_AGENT']) ? substr($_SERVER['HTTP_USER_AGENT'], 0, 100) : 'none',
            isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : 'unknown'
        ));
    }
}

/**
 * ==========================================================================
 * 8. AGREGAR HEADERS DE SEGURIDAD
 * ==========================================================================
 */
add_action('send_headers', 'deckeva_security_headers');
function deckeva_security_headers() {
    if (!is_admin()) {
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('X-XSS-Protection: 1; mode=block');
        header('Referrer-Policy: strict-origin-when-cross-origin');
    }
}

/**
 * ==========================================================================
 * 9. DESHABILITAR REST API USER ENUMERATION
 * ==========================================================================
 */
add_filter('rest_endpoints', 'deckeva_disable_user_enumeration');
function deckeva_disable_user_enumeration($endpoints) {
    if (isset($endpoints['/wp/v2/users'])) {
        unset($endpoints['/wp/v2/users']);
    }
    if (isset($endpoints['/wp/v2/users/(?P<id>[\d]+)'])) {
        unset($endpoints['/wp/v2/users/(?P<id>[\d]+)']);
    }
    return $endpoints;
}
