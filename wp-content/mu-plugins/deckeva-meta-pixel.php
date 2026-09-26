<?php
/**
 * Plugin Name: Deckeva — Pixel de Meta y API de Conversiones
 * Description: Mide en Meta Ads las visitas de deckeva.cl y cada cotización enviada, para que la publicidad optimice por clientes y no por clics.
 *
 * Dos piezas:
 *
 * 1. El Pixel en el navegador (PageView). La home de deckeva.cl es un HTML
 *    estático que no pasa por WordPress, así que no puede leer el ID de la base
 *    de datos: al guardar el ID se escribe uploads/deckeva-meta/pixel.js y la
 *    home lo carga. Sin ID ese archivo no existe y la home no mide nada.
 *
 * 2. El evento Lead, enviado desde el servidor (API de Conversiones) cada vez
 *    que deckeva_record_lead() registra un contacto real. Va desde el servidor
 *    y no desde el navegador porque así cubre los tres formularios (home,
 *    /cotizador/ y Contact Form 7) en un solo sitio, y no lo pierden los
 *    bloqueadores de anuncios. Sin token no se envía nada.
 *
 * Se configura en Ajustes → Meta Ads. El ID del Pixel es público; el token
 * no: vive en la base de datos (o en wp-config.php), nunca en el repo.
 *
 * Solo mide deckeva.cl: la campaña es para Chile, y el formulario de
 * deckeva.com usa el mismo endpoint, así que sus cotizaciones se descartan.
 */

if (!defined('ABSPATH')) {
    exit;
}

// Versión del Graph API. Meta mantiene cada una unos dos años; cuando avise
// que caduca, se sube aquí.
if (!defined('DECKEVA_META_GRAPH_VERSION')) {
    define('DECKEVA_META_GRAPH_VERSION', 'v23.0');
}

// =============================================
// CONFIGURACIÓN
// =============================================

function deckeva_meta_pixel_id() {
    $id = defined('DECKEVA_META_PIXEL_ID') ? DECKEVA_META_PIXEL_ID : get_option('deckeva_meta_pixel_id', '');
    $id = preg_replace('/\D/', '', (string) $id);
    return $id;
}

function deckeva_meta_capi_token() {
    return trim((string) (defined('DECKEVA_META_CAPI_TOKEN') ? DECKEVA_META_CAPI_TOKEN : get_option('deckeva_meta_capi_token', '')));
}

/**
 * Código de "Probar eventos" del Administrador de eventos. Mientras está puesto,
 * Meta muestra los eventos en esa pestaña y NO los cuenta para las campañas:
 * hay que borrarlo al terminar de probar.
 */
function deckeva_meta_test_code() {
    return trim((string) get_option('deckeva_meta_test_code', ''));
}

// =============================================
// PIXEL EN EL NAVEGADOR
// =============================================

function deckeva_meta_pixel_js($pixel_id) {
    return "/* Pixel de Meta de deckeva.cl. Lo genera deckeva-meta-pixel.php: no editar a mano. */\n"
        . "!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};"
        . "if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;"
        . "t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script','https://connect.facebook.net/en_US/fbevents.js');\n"
        . "fbq('init','" . $pixel_id . "');\n"
        . "fbq('track','PageView');\n";
}

/**
 * Etiqueta para las páginas que sí genera PHP (WordPress y /cotizador/).
 * Vacía si no hay Pixel o si la página no es de deckeva.cl.
 */
function deckeva_meta_pixel_tag() {
    $pixel_id = deckeva_meta_pixel_id();
    if ($pixel_id === '' || !deckeva_meta_es_host_cl(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '')) {
        return '';
    }
    return "<script>\n" . deckeva_meta_pixel_js($pixel_id) . "</script>\n";
}

add_action('wp_head', function () {
    echo deckeva_meta_pixel_tag();
}, 5);

function deckeva_meta_js_dir() {
    $upload = wp_upload_dir();
    if (!empty($upload['error'])) {
        return '';
    }
    return $upload['basedir'] . '/deckeva-meta';
}

/**
 * Escribe (o borra) el pixel.js que carga la home estática.
 *
 * @return bool true si el archivo quedó como corresponde a la configuración.
 */
function deckeva_meta_escribir_js() {
    $dir = deckeva_meta_js_dir();
    if ($dir === '') {
        return false;
    }
    $file = $dir . '/pixel.js';
    $pixel_id = deckeva_meta_pixel_id();

    if ($pixel_id === '') {
        // Sin Pixel no se deja un archivo vacío: el navegador podría guardarlo
        // en caché y seguir sin medir un tiempo después de configurar el ID.
        if (file_exists($file)) {
            @unlink($file);
        }
        return !file_exists($file);
    }

    if (!is_dir($dir) && !wp_mkdir_p($dir)) {
        return false;
    }
    return (bool) @file_put_contents($file, deckeva_meta_pixel_js($pixel_id), LOCK_EX);
}

function deckeva_meta_es_host_cl($host) {
    $host = strtolower(preg_replace('/:\d+$/', '', (string) $host));
    return $host === 'deckeva.cl' || substr($host, -strlen('.deckeva.cl')) === '.deckeva.cl';
}

// =============================================
// EVENTO LEAD POR LA API DE CONVERSIONES
// =============================================

/**
 * Orígenes de deckeva_record_lead() que son un cliente pidiendo cotización.
 * Quedan fuera lo bloqueado por antispam y los reenvíos que hace el propio
 * negocio (rescate, reactivación), que no vienen de ningún anuncio.
 */
function deckeva_meta_es_origen_cliente($source) {
    $source = (string) $source;
    return $source === 'cotizador'
        || strpos($source, 'cf7-cotizacion#') === 0
        || strpos($source, 'cf7-enviado#') === 0
        || strpos($source, 'cf7-FALLO-ENVIO#') === 0;
}

add_action('deckeva_lead_registrado', 'deckeva_meta_encolar_lead', 10, 2);
function deckeva_meta_encolar_lead($source, $data) {
    // Un envío de formulario = un Lead. El formulario 1031 se registra dos
    // veces en la misma petición (su propio registro y el genérico de CF7).
    static $ya = false;
    if ($ya || !deckeva_meta_es_origen_cliente($source)) {
        return;
    }
    if (deckeva_meta_pixel_id() === '' || deckeva_meta_capi_token() === '') {
        return;
    }

    $origen_url = isset($_SERVER['HTTP_REFERER']) ? (string) $_SERVER['HTTP_REFERER'] : '';
    if (!deckeva_meta_es_host_cl((string) parse_url($origen_url, PHP_URL_HOST))) {
        return;
    }

    $email = function_exists('deckeva_find_lead_email') ? deckeva_find_lead_email($data) : '';
    // Las pruebas propias no son clientes: contarlas enseñaría a Meta a buscar
    // gente como nosotros.
    if ($email !== '' && (
        (function_exists('deckeva_is_internal_address') && deckeva_is_internal_address($email))
        || (function_exists('deckeva_copia_oculta_address') && strcasecmp($email, deckeva_copia_oculta_address()) === 0)
    )) {
        return;
    }

    $ya = true;
    $evento = deckeva_meta_armar_lead($email, deckeva_meta_buscar_telefono($data), $origen_url);

    // Se envía al final de la petición, después de responder al cliente: si
    // Meta tarda, que no lo note quien está enviando el formulario.
    register_shutdown_function(function () use ($evento) {
        if (function_exists('fastcgi_finish_request')) {
            @fastcgi_finish_request();
        } elseif (function_exists('litespeed_finish_request')) {
            @litespeed_finish_request();
        }
        deckeva_meta_enviar(array($evento));
    });
}

function deckeva_meta_buscar_telefono($data) {
    foreach ((array) $data as $key => $value) {
        if (is_array($value)) {
            $value = isset($value[0]) ? $value[0] : '';
        }
        if (preg_match('/(tel|phone|fono|whats|celular|movil|móvil)/iu', (string) $key) && trim((string) $value) !== '') {
            return (string) $value;
        }
    }
    return '';
}

/**
 * Teléfono en el formato que pide Meta: solo dígitos y con código de país.
 * Los móviles chilenos se escriben casi siempre sin el 56 (9 1234 5678).
 */
function deckeva_meta_normalizar_telefono($telefono) {
    $digitos = preg_replace('/\D/', '', (string) $telefono);
    if (strlen($digitos) === 9 && $digitos[0] === '9') {
        $digitos = '56' . $digitos;
    }
    return strlen($digitos) >= 8 ? $digitos : '';
}

function deckeva_meta_armar_lead($email, $telefono, $origen_url) {
    $user = array(
        'client_ip_address' => function_exists('deckeva_get_client_ip') ? deckeva_get_client_ip() : (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : ''),
        'client_user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? (string) $_SERVER['HTTP_USER_AGENT'] : '',
    );

    // Email y teléfono van cifrados (SHA-256), como exige Meta: nunca salen en claro.
    $email = strtolower(trim((string) $email));
    if ($email !== '') {
        $user['em'] = array(hash('sha256', $email));
    }
    $telefono = deckeva_meta_normalizar_telefono($telefono);
    if ($telefono !== '') {
        $user['ph'] = array(hash('sha256', $telefono));
    }

    // Cookies que deja el Pixel: _fbc identifica el clic en el anuncio y es lo
    // que permite atribuir la cotización a la campaña.
    foreach (array('_fbp' => 'fbp', '_fbc' => 'fbc') as $cookie => $campo) {
        if (!empty($_COOKIE[$cookie]) && preg_match('/^fb\.\d\.\d+\.[A-Za-z0-9_\-\.]+$/', $_COOKIE[$cookie])) {
            $user[$campo] = $_COOKIE[$cookie];
        }
    }

    return array(
        'event_name'       => 'Lead',
        'event_time'       => time(),
        'event_id'         => 'lead-' . wp_generate_uuid4(),
        'action_source'    => 'website',
        'event_source_url' => esc_url_raw($origen_url),
        'user_data'        => array_filter($user),
    );
}

/**
 * Envía eventos a la API de Conversiones.
 *
 * @return array{ok:bool, mensaje:string}
 */
function deckeva_meta_enviar($eventos) {
    $pixel_id = deckeva_meta_pixel_id();
    $token    = deckeva_meta_capi_token();
    if ($pixel_id === '' || $token === '') {
        return array('ok' => false, 'mensaje' => 'Falta el ID del Pixel o el token.');
    }

    $cuerpo = array('data' => $eventos, 'access_token' => $token);
    $test = deckeva_meta_test_code();
    if ($test !== '') {
        $cuerpo['test_event_code'] = $test;
    }

    $respuesta = wp_remote_post(
        'https://graph.facebook.com/' . DECKEVA_META_GRAPH_VERSION . '/' . $pixel_id . '/events',
        array(
            'timeout' => 8,
            'headers' => array('Content-Type' => 'application/json'),
            'body'    => wp_json_encode($cuerpo),
        )
    );

    if (is_wp_error($respuesta)) {
        $mensaje = 'sin conexión con Meta: ' . $respuesta->get_error_message();
    } else {
        $codigo = (int) wp_remote_retrieve_response_code($respuesta);
        $json   = json_decode((string) wp_remote_retrieve_body($respuesta), true);
        if ($codigo === 200 && !empty($json['events_received'])) {
            return array('ok' => true, 'mensaje' => 'Meta recibió ' . (int) $json['events_received'] . ' evento(s).');
        }
        $mensaje = 'HTTP ' . $codigo . (isset($json['error']['message']) ? ': ' . $json['error']['message'] : '');
    }

    // Al log de PHP, que es lo que lee el workflow de diagnóstico. Sin datos del cliente.
    error_log('[Deckeva Meta] No se pudo enviar el Lead: ' . $mensaje);
    return array('ok' => false, 'mensaje' => $mensaje);
}

// =============================================
// AJUSTES → META ADS
// =============================================

add_action('admin_menu', function () {
    add_options_page('Meta Ads', 'Meta Ads', 'manage_options', 'deckeva-meta', 'deckeva_meta_pantalla');
});

function deckeva_meta_pantalla() {
    if (!current_user_can('manage_options')) {
        return;
    }

    $aviso = '';
    $tipo  = 'success';

    if (isset($_POST['deckeva_meta_accion']) && check_admin_referer('deckeva_meta_ajustes')) {
        $accion = sanitize_key(wp_unslash($_POST['deckeva_meta_accion']));

        if ($accion === 'guardar') {
            $pixel_id = preg_replace('/\D/', '', (string) wp_unslash(isset($_POST['pixel_id']) ? $_POST['pixel_id'] : ''));
            update_option('deckeva_meta_pixel_id', $pixel_id, true);
            update_option('deckeva_meta_test_code', sanitize_text_field(wp_unslash(isset($_POST['test_code']) ? $_POST['test_code'] : '')), false);

            // El token no se muestra nunca: si el campo llega vacío se conserva
            // el guardado, salvo que se marque "borrar".
            $token = trim((string) wp_unslash(isset($_POST['capi_token']) ? $_POST['capi_token'] : ''));
            if (!empty($_POST['borrar_token'])) {
                delete_option('deckeva_meta_capi_token');
            } elseif ($token !== '') {
                update_option('deckeva_meta_capi_token', preg_replace('/\s+/', '', $token), false);
            }

            $aviso = deckeva_meta_escribir_js()
                ? 'Guardado.'
                : 'Guardado, pero no se pudo escribir uploads/deckeva-meta/pixel.js: la home no medirá hasta que se pueda.';
            if (strpos($aviso, 'pero') !== false) {
                $tipo = 'error';
            }
        } elseif ($accion === 'probar') {
            if (deckeva_meta_test_code() === '') {
                $aviso = 'Pon primero el código de prueba del Administrador de eventos; sin él, el evento contaría como un cliente real.';
                $tipo  = 'error';
            } else {
                $evento = deckeva_meta_armar_lead('', '', home_url('/'));
                $evento['event_id'] = 'prueba-' . wp_generate_uuid4();
                $r = deckeva_meta_enviar(array($evento));
                $aviso = $r['ok'] ? $r['mensaje'] . ' Revísalo en la pestaña "Probar eventos".' : 'Falló: ' . $r['mensaje'];
                $tipo  = $r['ok'] ? 'success' : 'error';
            }
        }
    }

    $pixel_id  = deckeva_meta_pixel_id();
    $hay_token = deckeva_meta_capi_token() !== '';
    $test_code = deckeva_meta_test_code();
    $dir       = deckeva_meta_js_dir();
    $hay_js    = $dir !== '' && file_exists($dir . '/pixel.js');
    ?>
    <div class="wrap">
        <h1>Meta Ads</h1>
        <?php if ($aviso !== '') : ?>
            <div class="notice notice-<?php echo esc_attr($tipo); ?>"><p><?php echo esc_html($aviso); ?></p></div>
        <?php endif; ?>

        <p>Estado:
            Pixel <strong><?php echo $pixel_id !== '' ? esc_html($pixel_id) : 'sin configurar'; ?></strong> ·
            home <strong><?php echo $hay_js ? 'midiendo' : 'sin medir'; ?></strong> ·
            cotizaciones a Meta <strong><?php echo ($pixel_id !== '' && $hay_token) ? 'activas' : 'apagadas'; ?></strong>
            <?php if ($test_code !== '') : ?> · <strong style="color:#b32d2e">modo prueba (no cuentan para las campañas)</strong><?php endif; ?>
        </p>

        <form method="post">
            <?php wp_nonce_field('deckeva_meta_ajustes'); ?>
            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row"><label for="pixel_id">ID del Pixel</label></th>
                    <td><input name="pixel_id" id="pixel_id" type="text" class="regular-text" inputmode="numeric" value="<?php echo esc_attr($pixel_id); ?>" <?php disabled(defined('DECKEVA_META_PIXEL_ID')); ?>>
                        <p class="description">Administrador de eventos → el conjunto de datos → número de 15–16 dígitos.</p></td>
                </tr>
                <tr>
                    <th scope="row"><label for="capi_token">Token de la API de Conversiones</label></th>
                    <td><input name="capi_token" id="capi_token" type="password" class="regular-text" autocomplete="off" placeholder="<?php echo $hay_token ? 'Guardado (déjalo vacío para conservarlo)' : ''; ?>" <?php disabled(defined('DECKEVA_META_CAPI_TOKEN')); ?>>
                        <?php if ($hay_token && !defined('DECKEVA_META_CAPI_TOKEN')) : ?>
                            <label><input type="checkbox" name="borrar_token" value="1"> Borrar el token guardado</label>
                        <?php endif; ?>
                        <p class="description">Administrador de eventos → Configuración → API de Conversiones → Generar token de acceso.</p></td>
                </tr>
                <tr>
                    <th scope="row"><label for="test_code">Código de prueba</label></th>
                    <td><input name="test_code" id="test_code" type="text" class="regular-text" value="<?php echo esc_attr($test_code); ?>">
                        <p class="description">Solo mientras se prueba (pestaña "Probar eventos", p. ej. TEST12345). Bórralo al terminar: con él puesto, las cotizaciones no cuentan para las campañas.</p></td>
                </tr>
            </table>
            <p>
                <button type="submit" name="deckeva_meta_accion" value="guardar" class="button button-primary">Guardar</button>
                <button type="submit" name="deckeva_meta_accion" value="probar" class="button">Enviar un Lead de prueba</button>
            </p>
        </form>
    </div>
    <?php
}
