<?php
/**
 * Plugin Name: Deckeva - Núcleo de Correo y Leads
 * Description: Punto único de configuración del correo saliente y de los avisos internos:
 *              destinatarios del negocio, remitente alineado al dominio, notificación con
 *              Reply-To al cliente y registro en disco de TODOS los contactos (incluidos los
 *              que el antispam bloquea) para que ningún lead se pierda en silencio.
 * Version: 1.0
 * Author: Deckeva
 *
 * Se llama "00" para que cargue antes que el resto de mu-plugins de Deckeva.
 */

if (!defined('ABSPATH')) exit;

/**
 * Dominios propios. Cualquier dirección de estos dominios se considera interna.
 */
function deckeva_owned_domains() {
    return apply_filters('deckeva_owned_domains', array('deckeva.cl', 'deckeva.com'));
}

/**
 * Remitente de todo el correo que genera el sitio.
 *
 * Debe ser una casilla del MISMO dominio desde el que envía el servidor
 * (deckeva.cl); si no, SPF/DKIM no cuadran y Gmail/Outlook mandan el correo
 * a spam o lo rechazan directamente.
 */
function deckeva_mail_from_address() {
    return apply_filters('deckeva_mail_from_address', 'contacto@deckeva.cl');
}

function deckeva_mail_from_name() {
    return apply_filters('deckeva_mail_from_name', 'Deckeva');
}

/**
 * Casillas del negocio que deben recibir TODOS los avisos de contacto/cotización.
 *
 * Antes cada formulario decidía por su cuenta a quién avisar (unas veces por Bcc,
 * otras a get_option('admin_email')), y bastaba con que una de esas rutas fallara
 * para quedarse sin el aviso. Ahora la lista vive en un solo sitio.
 */
function deckeva_lead_recipients() {
    $recipients = array(
        'contacto@deckeva.cl',
        'jpchs1@gmail.com',
    );

    // El correo del administrador de WordPress, si es distinto de los anteriores.
    $admin_email = get_option('admin_email');
    if ($admin_email) {
        $recipients[] = $admin_email;
    }

    $recipients = apply_filters('deckeva_lead_recipients', $recipients);

    // Normalizar: validar, minúsculas y sin duplicados.
    $clean = array();
    foreach ((array) $recipients as $email) {
        $email = strtolower(trim($email));
        if (is_email($email) && !in_array($email, $clean, true)) {
            $clean[] = $email;
        }
    }

    return $clean;
}

/**
 * ¿Es una dirección interna del negocio? (dominio propio o lista de avisos)
 * La usa el filtro antispam de wp_mail para no borrar nuestras propias copias.
 */
function deckeva_is_internal_address($email) {
    $email = strtolower(trim($email));
    if (!is_email($email)) {
        return false;
    }

    foreach (deckeva_owned_domains() as $domain) {
        if (substr($email, -strlen('@' . $domain)) === '@' . $domain) {
            return true;
        }
    }

    return in_array($email, deckeva_lead_recipients(), true);
}

/**
 * Cabeceras estándar para el correo saliente del sitio.
 *
 * $reply_to permite que, al responder el aviso interno, la respuesta salga
 * directo al cliente en vez de a nosotros mismos.
 */
function deckeva_mail_headers($reply_to_email = '', $reply_to_name = '') {
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . deckeva_mail_from_name() . ' <' . deckeva_mail_from_address() . '>',
    );

    if ($reply_to_email && is_email($reply_to_email)) {
        $name = trim(preg_replace('/[\r\n]+/', ' ', (string) $reply_to_name));
        $headers[] = $name
            ? 'Reply-To: ' . $name . ' <' . $reply_to_email . '>'
            : 'Reply-To: ' . $reply_to_email;
    }

    return $headers;
}

/**
 * Casilla que recibe copia oculta de todo correo que el sitio le manda a un cliente.
 *
 * Pedido del dueño (23/09/2026): ver exactamente lo que recibe cada cliente, con su
 * PDF. Es una copia, no el aviso: el aviso interno sigue llegando aparte
 * (deckeva_notify_lead), con los datos del lead y el Reply-To del cliente.
 */
function deckeva_copia_oculta_address() {
    return apply_filters('deckeva_copia_oculta_address', 'jpchs1@gmail.com');
}

/**
 * Cabeceras de un correo a un cliente: sale de contacto@deckeva.cl y con copia
 * oculta al dueño.
 *
 * Es un Bcc a una casilla interna, así que el filtro de wp_mail del antispam lo
 * conserva. Si el destinatario ya es esa misma casilla (una prueba), no se duplica.
 *
 * @param string|array $para Destinatario(s) del correo, para no duplicar la copia.
 */
function deckeva_mail_headers_cliente($para = '', $reply_to_email = '', $reply_to_name = '') {
    $headers = deckeva_mail_headers($reply_to_email, $reply_to_name);

    $copia = strtolower(trim((string) deckeva_copia_oculta_address()));
    $destinatarios = array_map('deckeva_email_de_direccion', is_array($para) ? $para : explode(',', (string) $para));

    if (is_email($copia) && !in_array($copia, $destinatarios, true)) {
        $headers[] = 'Bcc: ' . $copia;
    }

    return $headers;
}

/**
 * "Nombre <correo@x.cl>" o "correo@x.cl" → "correo@x.cl" en minúsculas ('' si no lo es).
 */
function deckeva_email_de_direccion($direccion) {
    $direccion = trim((string) $direccion);
    if (preg_match('/<([^>]+)>/', $direccion, $m)) {
        $direccion = $m[1];
    }
    $direccion = strtolower(trim($direccion));

    return is_email($direccion) ? $direccion : '';
}

/**
 * Envía el aviso interno de un lead a todas las casillas del negocio.
 *
 * Va en el "Para:" (no en Bcc) a propósito: el Bcc se puede perder por filtros,
 * por el proveedor de correo o por reglas antispam, y ese fue exactamente el
 * fallo que dejó sin avisar las cotizaciones de la home.
 *
 * @return bool true si al menos una casilla recibió el aviso.
 */
function deckeva_notify_lead($subject, $html_body, $reply_to_email = '', $reply_to_name = '', $attachments = array()) {
    $recipients = deckeva_lead_recipients();
    if (empty($recipients)) {
        deckeva_mail_log('AVISO INTERNO SIN DESTINATARIOS: ' . $subject);
        return false;
    }

    $subject = trim(preg_replace('/[\r\n]+/', ' ', (string) $subject));
    $headers = deckeva_mail_headers($reply_to_email, $reply_to_name);

    $sent = wp_mail($recipients, $subject, $html_body, $headers, (array) $attachments);

    if (!$sent) {
        // Segundo intento sin adjuntos: un PDF pesado o ilegible no puede costar el aviso.
        if (!empty($attachments)) {
            $sent = wp_mail($recipients, $subject, $html_body, $headers);
        }
    }

    if (!$sent) {
        deckeva_mail_log('FALLO el aviso interno (' . implode(', ', $recipients) . '): ' . $subject);
    }

    return $sent;
}

/**
 * Deja el lead escrito en disco pase lo que pase con el correo.
 *
 * Una línea JSON por contacto en wp-content/uploads/deckeva-leads/leads-AAAA-MM.log,
 * con el directorio cerrado al acceso web. Es la red de seguridad: aunque el correo
 * falle o el antispam se pase de listo, el contacto queda registrado y recuperable.
 */
function deckeva_record_lead($source, $data, $note = '') {
    $dir = deckeva_lead_log_dir();
    if (!$dir) {
        return false;
    }

    $file = $dir . '/leads-' . date('Y-m') . '.log';

    // Tope de tamaño para que una oleada de spam no llene el disco.
    if (file_exists($file) && filesize($file) > 5 * MB_IN_BYTES) {
        return false;
    }

    $entry = array(
        'fecha'  => current_time('mysql'),
        'origen' => $source,
        'ip'     => function_exists('deckeva_get_client_ip') ? deckeva_get_client_ip() : (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : ''),
        'datos'  => deckeva_flatten_lead_data($data),
    );
    if ($note !== '') {
        $entry['nota'] = $note;
    }

    $line = wp_json_encode($entry, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    return (bool) @file_put_contents($file, $line . "\n", FILE_APPEND | LOCK_EX);
}

/**
 * Directorio protegido para el registro de leads. Lo crea si hace falta.
 */
function deckeva_lead_log_dir() {
    $upload = wp_upload_dir();
    if (!empty($upload['error'])) {
        return '';
    }

    $dir = $upload['basedir'] . '/deckeva-leads';
    if (!is_dir($dir) && !wp_mkdir_p($dir)) {
        return '';
    }

    // Sin acceso web: son datos personales de clientes.
    $htaccess = $dir . '/.htaccess';
    if (!file_exists($htaccess)) {
        @file_put_contents($htaccess, "Order deny,allow\nDeny from all\n<IfModule mod_authz_core.c>\n    Require all denied\n</IfModule>\n");
    }
    $index = $dir . '/index.html';
    if (!file_exists($index)) {
        @file_put_contents($index, '');
    }

    return $dir;
}

/**
 * Aplana los datos del formulario a pares clave => texto legible.
 */
function deckeva_flatten_lead_data($data) {
    $flat = array();
    foreach ((array) $data as $key => $value) {
        if (is_array($value)) {
            $value = implode(', ', array_map('strval', $value));
        }
        $value = trim((string) $value);
        if ($value === '') {
            continue;
        }
        // Campos internos que no aportan nada al seguimiento comercial.
        if (in_array($key, array('_wpcf7', '_wpcf7_version', '_wpcf7_locale', '_wpcf7_unit_tag', '_wpcf7_container_post', '_wpcf7_posted_data_hash', '_wpnonce', 'deckeva_form_time'), true)) {
            continue;
        }
        $flat[$key] = mb_substr($value, 0, 2000);
    }
    return $flat;
}

function deckeva_mail_log($msg) {
    error_log('[Deckeva Correo] ' . $msg);
}

/**
 * Busca el email del cliente dentro de los datos de un formulario.
 */
function deckeva_find_lead_email($data) {
    $fallback = '';

    foreach ((array) $data as $key => $value) {
        if (is_array($value)) {
            $value = isset($value[0]) ? $value[0] : '';
        }
        $value = trim((string) $value);
        if ($value === '' || !is_email($value)) {
            continue;
        }
        // Preferir el campo que se llama "email"/"correo"; si no, el primero válido.
        if (preg_match('/(e-?mail|correo)/i', (string) $key)) {
            return $value;
        }
        if ($fallback === '') {
            $fallback = $value;
        }
    }

    return $fallback;
}

// =============================================
// RED DE SEGURIDAD PARA CONTACT FORM 7
// =============================================

/**
 * Registrar todo mensaje enviado por CF7, sea del formulario que sea.
 *
 * CF7 manda su correo al destinatario configurado dentro del propio formulario
 * (en la base de datos). Si esa casilla está mal escrita, llena o sin revisar,
 * el mensaje desaparece sin dejar rastro. Con esto queda siempre el registro.
 */
add_action('wpcf7_mail_sent', 'deckeva_record_cf7_submission', 5);
function deckeva_record_cf7_submission($contact_form) {
    if (!class_exists('WPCF7_Submission')) {
        return;
    }
    $submission = WPCF7_Submission::get_instance();
    if (!$submission) {
        return;
    }
    deckeva_record_lead(
        'cf7-enviado#' . $contact_form->id(),
        $submission->get_posted_data()
    );
}

/**
 * Si CF7 no logró enviar el correo, además de registrarlo avisamos al negocio
 * por nuestra propia vía para no enterarnos cuando el cliente reclama.
 */
add_action('wpcf7_mail_failed', 'deckeva_handle_cf7_mail_failed', 5);
function deckeva_handle_cf7_mail_failed($contact_form) {
    if (!class_exists('WPCF7_Submission')) {
        return;
    }
    $submission = WPCF7_Submission::get_instance();
    if (!$submission) {
        return;
    }

    $data = $submission->get_posted_data();
    deckeva_record_lead('cf7-FALLO-ENVIO#' . $contact_form->id(), $data);
    deckeva_mail_log('CF7 no pudo enviar el formulario ' . $contact_form->id() . ' (' . $contact_form->title() . ')');

    $email = deckeva_find_lead_email($data);
    $html  = deckeva_lead_notification_html(
        'Mensaje recibido que el formulario NO pudo enviar',
        'El formulario «' . esc_html($contact_form->title()) . '» recibió este mensaje pero WordPress no consiguió enviarlo por correo. Estos son los datos para responder igualmente.',
        $data
    );

    deckeva_notify_lead(
        '⚠️ Mensaje recibido sin enviar — ' . $contact_form->title(),
        $html,
        $email
    );
}

/**
 * Contact Form 7: sus correos también salen de contacto@deckeva.cl y, cuando van a
 * un cliente (la respuesta automática de un formulario), con copia oculta al dueño.
 *
 * El remitente de cada formulario vive en la base de datos y se puede cambiar desde
 * el panel; se fuerza aquí para que SPF/DKIM cuadren siempre. Si un formulario usaba
 * la dirección del cliente como remitente (para responderle directo desde el aviso),
 * esa dirección pasa a Reply-To y no se pierde.
 */
add_filter('wpcf7_mail_components', 'deckeva_cf7_componentes_correo', 20, 3);
function deckeva_cf7_componentes_correo($components, $contact_form = null, $mail = null) {
    if (!is_array($components)) {
        return $components;
    }

    $cabeceras = isset($components['additional_headers']) ? trim((string) $components['additional_headers']) : '';

    $remitente_original = deckeva_email_de_direccion(isset($components['sender']) ? $components['sender'] : '');
    if ($remitente_original !== '' && !deckeva_is_internal_address($remitente_original)
        && !preg_match('/^\s*reply-to\s*:/im', $cabeceras)) {
        $cabeceras = trim($cabeceras . "\nReply-To: " . $remitente_original);
    }
    $components['sender'] = deckeva_mail_from_name() . ' <' . deckeva_mail_from_address() . '>';

    $para_cliente = false;
    $destinatario = isset($components['recipient']) ? (string) $components['recipient'] : '';
    foreach (explode(',', $destinatario) as $direccion) {
        $email = deckeva_email_de_direccion($direccion);
        if ($email !== '' && !deckeva_is_internal_address($email)) {
            $para_cliente = true;
        }
    }

    $copia = deckeva_copia_oculta_address();
    if ($para_cliente && is_email($copia) && stripos($cabeceras, $copia) === false) {
        $cabeceras = trim($cabeceras . "\nBcc: " . $copia);
    }

    $components['additional_headers'] = $cabeceras;

    return $components;
}

/**
 * Tabla HTML simple y legible para los avisos internos.
 */
function deckeva_lead_notification_html($titulo, $intro, $data) {
    $rows = '';
    foreach (deckeva_flatten_lead_data($data) as $key => $value) {
        $rows .= '<tr>'
            . '<td style="padding:8px 12px;border-bottom:1px solid #e5e7eb;font-weight:600;color:#1a2a3a;vertical-align:top;white-space:nowrap;">' . esc_html($key) . '</td>'
            . '<td style="padding:8px 12px;border-bottom:1px solid #e5e7eb;color:#334155;">' . nl2br(esc_html($value)) . '</td>'
            . '</tr>';
    }

    return '<!DOCTYPE html><html lang="es"><body style="margin:0;padding:24px;background:#f4f6f8;font-family:Arial,Helvetica,sans-serif;">'
        . '<div style="max-width:620px;margin:0 auto;background:#fff;border-radius:10px;overflow:hidden;border:1px solid #e5e7eb;">'
        . '<div style="background:#0d2137;color:#fff;padding:18px 20px;font-size:17px;font-weight:700;">' . esc_html($titulo) . '</div>'
        . '<div style="padding:18px 20px;color:#334155;font-size:14px;line-height:1.5;">' . wp_kses_post($intro) . '</div>'
        . '<table style="width:100%;border-collapse:collapse;font-size:14px;">' . $rows . '</table>'
        . '<div style="padding:16px 20px;color:#64748b;font-size:12px;">Aviso automático de deckeva.cl · responde este correo para contestarle directamente al cliente.</div>'
        . '</div></body></html>';
}
