<?php
/**
 * Plugin Name: Deckeva - Recuperar leads perdidos
 * Description: Panel en Escritorio → Herramientas → "Leads perdidos" que reúne los contactos
 *              que no llegaron por correo: los mensajes que Contact Form 7 marcó como spam
 *              (guardados por Flamingo), las cotizaciones internacionales cuyo PDF sigue en el
 *              servidor y el registro propio de leads. Permite exportarlos a CSV o recibirlos
 *              por correo para retomar el contacto.
 * Version: 1.0
 * Author: Deckeva
 */

if (!defined('ABSPATH')) exit;

const DECKEVA_LEADS_CAP = 'manage_options';

add_action('admin_menu', 'deckeva_leads_menu');
function deckeva_leads_menu() {
    add_management_page(
        'Leads perdidos',
        'Leads perdidos',
        DECKEVA_LEADS_CAP,
        'deckeva-leads',
        'deckeva_leads_page'
    );
}

/* ──────────────────────────────────────────
   RECOLECCIÓN
────────────────────────────────────────── */

/**
 * Mensajes guardados por Flamingo, incluidos los que el antispam marcó como spam.
 * Ahí están los formularios de contacto y de cotización de la web.
 */
function deckeva_leads_from_flamingo($desde = '') {
    if (!post_type_exists('flamingo_inbound')) {
        return null; // Flamingo no está activo
    }

    $args = array(
        'post_type'      => 'flamingo_inbound',
        'post_status'    => array('publish', 'spam', 'trash'),
        'posts_per_page' => 500,
        'orderby'        => 'date',
        'order'          => 'DESC',
    );
    if ($desde) {
        $args['date_query'] = array(array('after' => $desde));
    }

    $leads = array();
    foreach (get_posts($args) as $post) {
        $fields = get_post_meta($post->ID, '_fields', true);
        $fields = is_array($fields) ? $fields : array();

        $mensaje = '';
        foreach ($fields as $k => $v) {
            if (preg_match('/(message|mensaje|consulta|comentario)/i', $k)) {
                $mensaje = is_array($v) ? implode(' ', $v) : $v;
                break;
            }
        }

        $leads[] = array(
            'origen'   => 'Formulario web',
            'estado'   => ($post->post_status === 'spam')
                ? 'MARCADO COMO SPAM (no se envió)'
                : ($post->post_status === 'trash' ? 'papelera' : 'recibido'),
            'fecha'    => get_the_date('Y-m-d H:i', $post),
            'nombre'   => (string) get_post_meta($post->ID, '_from_name', true),
            'email'    => (string) get_post_meta($post->ID, '_from_email', true),
            'telefono' => deckeva_leads_pick_field($fields, '/(tel|phone|fono|celular|whats)/i'),
            'asunto'   => (string) get_post_meta($post->ID, '_subject', true),
            'detalle'  => wp_trim_words($mensaje, 60, '…'),
            'enlace'   => admin_url('admin.php?page=flamingo_inbound&post=' . $post->ID . '&action=edit'),
        );
    }

    return $leads;
}

function deckeva_leads_pick_field($fields, $pattern) {
    foreach ((array) $fields as $k => $v) {
        if (preg_match($pattern, $k)) {
            return is_array($v) ? implode(' ', $v) : (string) $v;
        }
    }
    return '';
}

/**
 * Cotizaciones internacionales (formulario de la home) cuyo PDF sigue en el servidor.
 * Es la única huella que dejaron: el aviso por correo nunca salió.
 */
function deckeva_leads_from_pdfs() {
    $upload = wp_upload_dir();
    if (!empty($upload['error'])) {
        return array();
    }

    $dir = $upload['basedir'] . '/cotizaciones-intl';
    if (!is_dir($dir)) {
        return array();
    }

    $leads = array();
    foreach ((array) glob($dir . '/*.pdf') as $path) {
        $nombre_archivo = basename($path);
        $datos = deckeva_leads_parse_pdf($path);

        // El número de cotización lleva la fecha: DECKEVA-Quote-DCK-INT-AAAAMMDDHHMMSS-uuid.pdf
        $fecha = date('Y-m-d H:i', filemtime($path));
        if (preg_match('/DCK-INT-(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})/', $nombre_archivo, $m)) {
            $fecha = "$m[1]-$m[2]-$m[3] $m[4]:$m[5]";
        }

        $leads[] = array(
            'origen'   => 'Cotizador de la home',
            'estado'   => 'SIN AVISO (el Bcc se perdía)',
            'fecha'    => $fecha,
            'nombre'   => $datos['nombre'],
            'email'    => $datos['email'],
            'telefono' => $datos['telefono'],
            'asunto'   => $nombre_archivo,
            'detalle'  => $datos['detalle'],
            'enlace'   => $upload['baseurl'] . '/cotizaciones-intl/' . rawurlencode($nombre_archivo),
        );
    }

    usort($leads, function ($a, $b) { return strcmp($b['fecha'], $a['fecha']); });

    return $leads;
}

/**
 * Saca el texto de un PDF de DOMPDF (streams FlateDecode) para leer email y teléfono.
 * Es best-effort: si el PDF no se puede descomprimir, se devuelve lo que haya.
 */
function deckeva_leads_parse_pdf($path) {
    $vacio = array('nombre' => '', 'email' => '', 'telefono' => '', 'detalle' => '');

    $raw = @file_get_contents($path);
    if ($raw === false) {
        return $vacio;
    }

    $texto = '';
    if (preg_match_all('/stream\r?\n(.*?)\r?\nendstream/s', $raw, $streams)) {
        foreach ($streams[1] as $stream) {
            $plano = @gzuncompress($stream);
            if ($plano === false) {
                $plano = @gzinflate(substr($stream, 2));
            }
            if ($plano === false) {
                continue;
            }
            // Operadores de texto: (contenido) Tj
            if (preg_match_all('/\(((?:\\\\.|[^\\\\()])*)\)\s*Tj/', $plano, $trozos)) {
                foreach ($trozos[1] as $t) {
                    $texto .= str_replace(array('\\(', '\\)', '\\\\'), array('(', ')', '\\'), $t) . ' ';
                }
            }
        }
    }

    $texto = trim(preg_replace('/\s+/', ' ', $texto));

    $email = '';
    if (preg_match('/[\w.+-]+@[\w-]+\.[\w.-]+/', $texto, $m)) {
        $email = rtrim($m[0], '.');
    }

    // Telefono: primero el que va junto a su etiqueta ("Phone / Telefono"), y solo
    // si no aparece, uno que empiece por "+". Asi no se confunde con el numero de
    // cotizacion, que es una tira larga de digitos.
    $telefono = '';
    if (preg_match('/(?:phone|tel[eé]fono|tel|fono|whats)[^\d+]{0,15}(\+?\d[\d\s().-]{6,})/i', $texto, $m)) {
        $telefono = trim($m[1]);
    } elseif (preg_match('/\+\d[\d\s().-]{6,}/', $texto, $m)) {
        $telefono = trim($m[0]);
    }

    // Nombre: lo que sigue a la etiqueta "Name / Nombre" o "Client / Cliente".
    $nombre = '';
    if (preg_match('/(?:name|nombre|client|cliente)[^\p{L}]{0,6}([\p{L}][\p{L}\s\'.-]{2,60}?)(?=\s+(?:email|phone|tel|pa[ií]s|country|[\w.+-]+@)|$)/iu', $texto, $m)) {
        $nombre = trim($m[1]);
    }

    return array(
        'nombre'   => $nombre,
        'email'    => $email,
        'telefono' => $telefono,
        'detalle'  => mb_substr($texto, 0, 300),
    );
}

/**
 * Registro propio de leads (a partir de esta corrección).
 */
function deckeva_leads_from_log() {
    if (!function_exists('deckeva_lead_log_dir')) {
        return array();
    }
    $dir = deckeva_lead_log_dir();
    if (!$dir) {
        return array();
    }

    $leads = array();
    foreach ((array) glob($dir . '/leads-*.log') as $file) {
        foreach ((array) file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            $row = json_decode($line, true);
            if (!is_array($row)) {
                continue;
            }
            $datos = isset($row['datos']) && is_array($row['datos']) ? $row['datos'] : array();
            $leads[] = array(
                'origen'   => isset($row['origen']) ? $row['origen'] : 'registro',
                'estado'   => isset($row['nota']) ? $row['nota'] : 'registrado',
                'fecha'    => isset($row['fecha']) ? $row['fecha'] : '',
                'nombre'   => deckeva_leads_pick_field($datos, '/(name|nombre)/i'),
                'email'    => deckeva_leads_pick_field($datos, '/(e-?mail|correo)/i'),
                'telefono' => deckeva_leads_pick_field($datos, '/(tel|phone|fono|celular|whats)/i'),
                'asunto'   => '',
                'detalle'  => wp_trim_words(implode(' · ', array_map(
                    function ($k, $v) { return $k . ': ' . $v; },
                    array_keys($datos),
                    array_values($datos)
                )), 60, '…'),
                'enlace'   => '',
            );
        }
    }

    usort($leads, function ($a, $b) { return strcmp($b['fecha'], $a['fecha']); });

    return $leads;
}

/**
 * Todo junto, lo más reciente primero.
 */
function deckeva_leads_recopilar($desde = '') {
    $flamingo = deckeva_leads_from_flamingo($desde);

    return array(
        'flamingo' => $flamingo,              // null si Flamingo no está activo
        'pdfs'     => deckeva_leads_from_pdfs(),
        'log'      => deckeva_leads_from_log(),
    );
}

/* ──────────────────────────────────────────
   PANEL
────────────────────────────────────────── */

function deckeva_leads_page() {
    if (!current_user_can(DECKEVA_LEADS_CAP)) {
        wp_die('Sin permisos.');
    }

    $desde = isset($_GET['desde']) ? sanitize_text_field(wp_unslash($_GET['desde'])) : '2026-05-01';
    $grupos = deckeva_leads_recopilar($desde);

    echo '<div class="wrap"><h1>Leads perdidos</h1>';
    echo '<p>Contactos que entraron por la web y de los que no llegó aviso por correo. '
        . 'Están agrupados por dónde quedó la huella.</p>';

    echo '<form method="get" style="margin:16px 0;">';
    echo '<input type="hidden" name="page" value="deckeva-leads" />';
    echo '<label>Desde: <input type="date" name="desde" value="' . esc_attr($desde) . '" /></label> ';
    submit_button('Filtrar', 'secondary', '', false);
    echo ' <a class="button button-primary" href="' . esc_url(wp_nonce_url(
        admin_url('admin-post.php?action=deckeva_leads_csv&desde=' . urlencode($desde)),
        'deckeva_leads_csv'
    )) . '">Descargar CSV</a>';
    echo ' <a class="button" href="' . esc_url(wp_nonce_url(
        admin_url('admin-post.php?action=deckeva_leads_mail&desde=' . urlencode($desde)),
        'deckeva_leads_mail'
    )) . '">Enviármelo por correo</a>';
    echo '</form>';

    if ($grupos['flamingo'] === null) {
        echo '<div class="notice notice-warning"><p>El plugin <strong>Flamingo</strong> no está activo, '
            . 'así que no se pueden leer los mensajes de los formularios. Actívalo en Plugins para verlos.</p></div>';
    } else {
        deckeva_leads_tabla(
            'Mensajes de formularios (Flamingo)',
            'Los marcados como <strong>SPAM</strong> son los que el antispam descartó por error: nunca se enviaron por correo.',
            $grupos['flamingo']
        );
    }

    deckeva_leads_tabla(
        'Cotizaciones del formulario de la home',
        'PDF todavía en el servidor. Son solicitudes de las que no salió ningún aviso; los datos se leen del propio PDF.',
        $grupos['pdfs']
    );

    deckeva_leads_tabla(
        'Registro propio de leads',
        'Se llena a partir de esta corrección: cada contacto queda aquí aunque el correo falle.',
        $grupos['log']
    );

    echo '</div>';
}

function deckeva_leads_tabla($titulo, $descripcion, $filas) {
    echo '<h2 style="margin-top:28px;">' . esc_html($titulo) . ' <span style="color:#666;font-weight:400;">('
        . count((array) $filas) . ')</span></h2>';
    echo '<p style="color:#555;margin-top:-6px;">' . wp_kses_post($descripcion) . '</p>';

    if (empty($filas)) {
        echo '<p><em>Nada aquí.</em></p>';
        return;
    }

    echo '<table class="wp-list-table widefat striped"><thead><tr>'
        . '<th>Fecha</th><th>Estado</th><th>Nombre</th><th>Email</th><th>Teléfono</th><th>Detalle</th><th></th>'
        . '</tr></thead><tbody>';

    foreach ($filas as $f) {
        $destacar = (stripos($f['estado'], 'spam') !== false || stripos($f['estado'], 'sin aviso') !== false);
        echo '<tr' . ($destacar ? ' style="background:#fff4f4;"' : '') . '>';
        echo '<td>' . esc_html($f['fecha']) . '</td>';
        echo '<td>' . esc_html($f['estado']) . '</td>';
        echo '<td>' . esc_html($f['nombre']) . '</td>';
        echo '<td>' . ($f['email'] ? '<a href="mailto:' . esc_attr($f['email']) . '">' . esc_html($f['email']) . '</a>' : '—') . '</td>';
        echo '<td>' . esc_html($f['telefono']) . '</td>';
        echo '<td style="max-width:420px;">' . esc_html($f['detalle']) . '</td>';
        echo '<td>' . ($f['enlace'] ? '<a href="' . esc_url($f['enlace']) . '" target="_blank" rel="noopener">ver</a>' : '') . '</td>';
        echo '</tr>';
    }

    echo '</tbody></table>';
}

/* ──────────────────────────────────────────
   EXPORTAR
────────────────────────────────────────── */

add_action('admin_post_deckeva_leads_csv', 'deckeva_leads_csv');
function deckeva_leads_csv() {
    if (!current_user_can(DECKEVA_LEADS_CAP)) {
        wp_die('Sin permisos.');
    }
    check_admin_referer('deckeva_leads_csv');

    $desde = isset($_GET['desde']) ? sanitize_text_field(wp_unslash($_GET['desde'])) : '';

    nocache_headers();
    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename=deckeva-leads-' . date('Y-m-d') . '.csv');

    $out = fopen('php://output', 'w');
    fwrite($out, "\xEF\xBB\xBF"); // BOM para que Excel respete las tildes
    fputcsv($out, array('Fecha', 'Origen', 'Estado', 'Nombre', 'Email', 'Teléfono', 'Detalle'));

    foreach (deckeva_leads_filas_planas($desde) as $f) {
        fputcsv($out, array($f['fecha'], $f['origen'], $f['estado'], $f['nombre'], $f['email'], $f['telefono'], $f['detalle']));
    }

    fclose($out);
    exit;
}

add_action('admin_post_deckeva_leads_mail', 'deckeva_leads_mail');
function deckeva_leads_mail() {
    if (!current_user_can(DECKEVA_LEADS_CAP)) {
        wp_die('Sin permisos.');
    }
    check_admin_referer('deckeva_leads_mail');

    $desde = isset($_GET['desde']) ? sanitize_text_field(wp_unslash($_GET['desde'])) : '';
    $filas = deckeva_leads_filas_planas($desde);

    $html = '<p>Listado de contactos web sin respuesta, desde ' . esc_html($desde ? $desde : 'el principio') . '.</p>'
        . '<table border="1" cellpadding="6" cellspacing="0" style="border-collapse:collapse;font-family:Arial,sans-serif;font-size:13px;">'
        . '<tr><th>Fecha</th><th>Origen</th><th>Estado</th><th>Nombre</th><th>Email</th><th>Teléfono</th></tr>';
    foreach ($filas as $f) {
        $html .= '<tr><td>' . esc_html($f['fecha']) . '</td><td>' . esc_html($f['origen']) . '</td><td>'
            . esc_html($f['estado']) . '</td><td>' . esc_html($f['nombre']) . '</td><td>'
            . esc_html($f['email']) . '</td><td>' . esc_html($f['telefono']) . '</td></tr>';
    }
    $html .= '</table>';

    $asunto = 'Deckeva — ' . count($filas) . ' contactos web sin respuesta';
    $enviado = function_exists('deckeva_notify_lead')
        ? deckeva_notify_lead($asunto, $html)
        : wp_mail(get_option('admin_email'), $asunto, $html, array('Content-Type: text/html; charset=UTF-8'));

    wp_safe_redirect(add_query_arg(
        array('page' => 'deckeva-leads', 'desde' => $desde, 'enviado' => $enviado ? '1' : '0'),
        admin_url('tools.php')
    ));
    exit;
}

function deckeva_leads_filas_planas($desde = '') {
    $grupos = deckeva_leads_recopilar($desde);
    $filas = array_merge(
        (array) $grupos['flamingo'],
        (array) $grupos['pdfs'],
        (array) $grupos['log']
    );
    usort($filas, function ($a, $b) { return strcmp($b['fecha'], $a['fecha']); });
    return $filas;
}

add_action('admin_notices', function () {
    if (!isset($_GET['page']) || $_GET['page'] !== 'deckeva-leads' || !isset($_GET['enviado'])) {
        return;
    }
    $ok = $_GET['enviado'] === '1';
    printf(
        '<div class="notice notice-%s is-dismissible"><p>%s</p></div>',
        $ok ? 'success' : 'error',
        $ok ? 'Listado enviado a las casillas del negocio.' : 'No se pudo enviar el listado.'
    );
});
