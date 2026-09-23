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

    // Las cotizaciones posteriores al arreglo ya avisaron y quedaron en el
    // registro propio, con todos sus datos: aquí sobran y además no son "sin aviso".
    $registradas = deckeva_leads_numeros_registrados();

    $leads = array();
    foreach ((array) glob($dir . '/*.pdf') as $path) {
        $nombre_archivo = basename($path);
        if (preg_match('/(DCK-INT-\d{14}-[A-F0-9]{5})/', $nombre_archivo, $num) && isset($registradas[$num[1]])) {
            continue;
        }
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
 * Todos los datos de una cotización antigua, campo por campo, para poder
 * reemitirla con el diseño nuevo y exactamente los mismos montos que vio el
 * cliente. Devuelve null si el PDF no se puede leer o no trae email.
 *
 * Los montos se guardan tal cual se imprimieron ("CLP $1.251.669",
 * "MXN $23,040"): así se respeta el precio cotizado aunque la lista haya
 * cambiado después.
 */
function deckeva_leads_datos_pdf($path) {
    $raw = @file_get_contents($path);
    if ($raw === false) {
        return null;
    }
    $t = deckeva_leads_texto_pdf($raw);

    $campo = function ($patron) use ($t) {
        return preg_match($patron, $t, $m) ? trim($m[1]) : '';
    };

    $email = $campo('/Email\s+(\S+@\S+\.\S+)/u');
    if ($email === '') {
        return null;
    }

    // "20 ft / pies" → "20 pies"; "Otro / Other" → "Otro".
    $tamano = $campo('/Size \/ Tamaño\s+(.+?)\s+(?:Make|Color|PRICING)/u');
    if (preg_match('/^(\d+)\s*ft/i', $tamano, $m)) {
        $tamano = $m[1] . ' pies';
    } elseif (stripos($tamano, 'otro') === 0) {
        $tamano = 'Otro';
    }

    // "Glastron 205 GTS (2013)" → modelo y año por separado.
    $modelo = $campo('/Make & Model\s+(.+?)\s+(?:Color|PRICING)/u');
    $anio = '';
    if (preg_match('/^(.*?)\s*\((\d{4})\)$/u', $modelo, $m)) {
        $modelo = $m[1];
        $anio = $m[2];
    }

    $total = $campo('/TOTAL\s*([A-Z]{3}\s*\S+)/u');
    $numero = preg_match('/(DCK-INT-(\d{4})(\d{2})(\d{2})\d{6}-[A-F0-9]{5})/', basename($path), $n) ? $n[1] : '';

    return array(
        'numero'   => $numero,
        'fecha'    => $numero ? "$n[2]-$n[3]-$n[4]" : '',
        'nombre'   => $campo('/Name \/ Nombre\s+(.+?)\s+Email\b/u'),
        'email'    => rtrim($email, '.'),
        'telefono' => $campo('/Tel[eé]fono\s+(.+?)\s+Shipping/u'),
        'pais'     => $campo('/Shipping \/ Envío\s+(.+?)\s+VESSEL/u'),
        'tamano'   => $tamano,
        'modelo'   => $modelo,
        'anio'     => $anio,
        'color'    => $campo('/Color\s+(.+?)\s+PRICING/u'),
        'subtotal' => $campo('/Base \/ Subtotal\s*([A-Z]{3}\s*\S+)/u'),
        'iva'      => $campo('/IVA \/ VAT 19%\s*([A-Z]{3}\s*\S+)/u'),
        'total'    => $total,
        'moneda'   => substr($total, 0, 3),
        // Tamaño "Otro" se cotizaba en cero: eso es "a consultar", no gratis.
        'a_consultar' => ($tamano === 'Otro' || preg_match('/\$0$/', $total)),
    );
}

/**
 * Lee cliente y embarcación de un PDF de cotización de los que generaba el
 * formulario de la home antes del arreglo: son lo único que quedó de esas
 * solicitudes. Se apoya en las etiquetas fijas de aquella plantilla
 * ("Name / Nombre", "Email", "Phone / Teléfono"…).
 */
function deckeva_leads_parse_pdf($path) {
    $vacio = array('nombre' => '', 'email' => '', 'telefono' => '', 'detalle' => '');

    $raw = @file_get_contents($path);
    if ($raw === false) {
        return $vacio;
    }

    $t = deckeva_leads_texto_pdf($raw);
    if ($t === '') {
        return $vacio;
    }

    $campo = function ($patron) use ($t) {
        return preg_match($patron, $t, $m) ? trim($m[1]) : '';
    };

    $email = $campo('/Email\s+(\S+@\S+\.\S+)/u');
    if ($email === '' && preg_match('/[\w.+-]+@[\w-]+\.[\w.-]+/', $t, $m)) {
        $email = $m[0];
    }

    $detalle = array_filter(array(
        $campo('/Make & Model\s+(.+?)\s+(?:Color|PRICING)/u'),
        $campo('/Size \/ Tamaño\s+(.+?)\s+(?:Make|Color|PRICING)/u'),
        $campo('/TOTAL\s*([A-Z]{3}\s*\S+)/u'),
        $campo('/Shipping \/ Envío\s+(.+?)\s+VESSEL/u'),
    ));

    return array(
        'nombre'   => $campo('/Name \/ Nombre\s+(.+?)\s+Email\b/u'),
        'email'    => rtrim($email, '.'),
        'telefono' => $campo('/Tel[eé]fono\s+(\+?\d[\d\s().-]{5,}?)\s+(?:Shipping|Env)/u'),
        'detalle'  => implode(' · ', $detalle),
    );
}

/**
 * Texto plano de un PDF de DOMPDF.
 *
 * DOMPDF 2.x escribe cada trozo como un arreglo: "[(Mario Henriquez)] TJ". La
 * primera versión de este lector solo entendía la forma "(texto) Tj" y, con los
 * PDF reales del servidor, devolvía nombre, email y teléfono vacíos. Se aceptan
 * las dos.
 */
function deckeva_leads_texto_pdf($raw) {
    if (!preg_match_all('/stream\r?\n(.*?)\r?\nendstream/s', $raw, $streams)) {
        return '';
    }

    $texto = '';
    foreach ($streams[1] as $stream) {
        $plano = @gzuncompress($stream);
        if ($plano === false) {
            $plano = @gzinflate(substr($stream, 2));
        }
        if ($plano === false) {
            continue;
        }

        if (!preg_match_all('/\[(.*?)\]\s*TJ|\(((?:\\\\.|[^\\\\()])*)\)\s*Tj/s', $plano, $ops, PREG_SET_ORDER)) {
            continue;
        }
        foreach ($ops as $op) {
            if (isset($op[2]) && $op[2] !== '') {
                $trozos = array($op[2]);
            } else {
                preg_match_all('/\(((?:\\\\.|[^\\\\()])*)\)/', $op[1], $m);
                $trozos = $m[1];
            }
            $texto .= implode('', array_map('deckeva_leads_desescapar_pdf', $trozos)) . ' ';
        }
    }

    return trim(preg_replace('/\s+/u', ' ', $texto));
}

/**
 * Deshace el escapado de las cadenas de un PDF y lo deja en UTF-8.
 *
 * Con las fuentes base (Helvetica), DOMPDF escribe los acentos en WinAnsi y en
 * octal: "Henr\355quez". Sin esto, los nombres con tilde o eñe salían rotos.
 */
function deckeva_leads_desescapar_pdf($s) {
    $s = preg_replace_callback('/\\\\([0-7]{1,3}|.)/s', function ($m) {
        if (ctype_digit($m[1])) {
            return chr(octdec($m[1]) & 0xFF);
        }
        return in_array($m[1], array('n', 'r', 't'), true) ? ' ' : $m[1];
    }, $s);

    if (preg_match('//u', $s)) {
        return $s; // ya es UTF-8 válido
    }
    if (function_exists('mb_convert_encoding')) {
        return mb_convert_encoding($s, 'UTF-8', 'Windows-1252');
    }
    return function_exists('iconv') ? (string) @iconv('Windows-1252', 'UTF-8//IGNORE', $s) : $s;
}

/**
 * Números de cotización que ya están en el registro propio.
 */
function deckeva_leads_numeros_registrados() {
    $numeros = array();
    foreach (deckeva_leads_from_log() as $fila) {
        if (preg_match('/(DCK-INT-\d{14}-[A-F0-9]{5})/', $fila['detalle'], $m)) {
            $numeros[$m[1]] = true;
        }
    }
    return $numeros;
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
   REACTIVACIÓN: escribir de vuelta a los clientes
────────────────────────────────────────── */

const DECKEVA_LEADS_ENVIADOS = 'deckeva_leads_reactivados';

/**
 * Texto del correo de reactivación. Editable desde el panel antes de enviar.
 */
function deckeva_leads_plantilla() {
    $guardada = get_option('deckeva_leads_plantilla');
    if (is_array($guardada) && !empty($guardada['cuerpo'])) {
        return $guardada;
    }

    return array(
        'asunto' => 'Retomamos tu cotización — disculpa la demora',
        'cuerpo' => "Hola {nombre}:\n\n"
            . "Te escribo de Deckeva. Nos contactaste el {fecha} y no recibiste respuesta. "
            . "La causa fue nuestra: una falla en el formulario de la web hizo que tu mensaje "
            . "nunca llegara a nuestra bandeja. Ya está corregido.\n\n"
            . "Si todavía te interesa, retomamos justo donde quedaste. Responde este correo o "
            . "escríbenos por WhatsApp al +56 9 4021 1459 y te acompañamos con las medidas, el "
            . "diseño y la instalación.\n\n"
            . "Un saludo,\nJuan Pablo · Deckeva",
    );
}

/**
 * Registro de a quién ya se le escribió, para no mandar el mismo correo dos veces.
 */
function deckeva_leads_ya_contactado($email) {
    $enviados = get_option(DECKEVA_LEADS_ENVIADOS, array());
    $clave = md5(strtolower(trim($email)));
    return (is_array($enviados) && isset($enviados[$clave])) ? $enviados[$clave] : '';
}

function deckeva_leads_marcar_contactado($email) {
    $enviados = get_option(DECKEVA_LEADS_ENVIADOS, array());
    if (!is_array($enviados)) {
        $enviados = array();
    }
    $enviados[md5(strtolower(trim($email)))] = current_time('mysql');
    update_option(DECKEVA_LEADS_ENVIADOS, $enviados, false);
}

/**
 * Personaliza la plantilla para un lead concreto.
 */
function deckeva_leads_personalizar($texto, $lead) {
    $texto = strtr($texto, array(
        '{nombre}' => isset($lead['nombre']) ? $lead['nombre'] : '',
        '{fecha}'  => isset($lead['fecha']) ? deckeva_leads_fecha_legible($lead['fecha']) : '',
    ));

    // Si no sabíamos el nombre, que el saludo no quede cojo ("Hola :").
    return preg_replace('/Hola\s+([:,])/u', 'Hola$1', $texto);
}

/**
 * "2026-09-10 14:35" → "10 de septiembre".
 *
 * Con nombres de mes fijos en español: el correo está escrito en español y la fecha
 * tiene que acompañarlo, dependa o no el WordPress de otro idioma.
 */
function deckeva_leads_fecha_legible($fecha) {
    $ts = strtotime($fecha);
    if (!$ts) {
        return $fecha;
    }

    $meses = array(
        1 => 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio',
        'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre',
    );

    return date('j', $ts) . ' de ' . $meses[(int) date('n', $ts)];
}

/**
 * Envía la reactivación a los leads marcados en el panel.
 *
 * Sale del propio sitio, así que el remitente es contacto@deckeva.cl con el SPF y el
 * DKIM del dominio: no hacen falta credenciales de la casilla en ningún otro sitio.
 */
add_action('admin_post_deckeva_leads_reactivar', 'deckeva_leads_reactivar');
function deckeva_leads_reactivar() {
    if (!current_user_can(DECKEVA_LEADS_CAP)) {
        wp_die('Sin permisos.');
    }
    check_admin_referer('deckeva_leads_reactivar');

    $asunto = isset($_POST['asunto']) ? sanitize_text_field(wp_unslash($_POST['asunto'])) : '';
    $cuerpo = isset($_POST['cuerpo']) ? sanitize_textarea_field(wp_unslash($_POST['cuerpo'])) : '';
    $desde  = isset($_POST['desde']) ? sanitize_text_field(wp_unslash($_POST['desde'])) : '';

    // Guardar el texto para la próxima tanda.
    update_option('deckeva_leads_plantilla', array('asunto' => $asunto, 'cuerpo' => $cuerpo), false);

    $seleccion = isset($_POST['leads']) ? (array) wp_unslash($_POST['leads']) : array();
    $enviados = 0;
    $omitidos = 0;
    $fallidos = 0;

    foreach ($seleccion as $token) {
        $lead = json_decode(base64_decode($token), true);
        if (!is_array($lead) || empty($lead['email'])) {
            continue;
        }

        $email = sanitize_email($lead['email']);
        if (!is_email($email)) {
            continue;
        }

        // Nunca dos veces a la misma persona.
        if (deckeva_leads_ya_contactado($email)) {
            $omitidos++;
            continue;
        }

        $datos = array(
            'nombre' => isset($lead['nombre']) ? sanitize_text_field($lead['nombre']) : '',
            'fecha'  => isset($lead['fecha']) ? sanitize_text_field($lead['fecha']) : '',
        );

        $html = '<div style="font-family:Arial,Helvetica,sans-serif;font-size:15px;line-height:1.6;color:#1a2a3a;">'
            . wpautop(esc_html(deckeva_leads_personalizar($cuerpo, $datos)))
            . '</div>';

        // Desde contacto@deckeva.cl y con copia oculta al dueño.
        $headers = function_exists('deckeva_mail_headers_cliente')
            ? deckeva_mail_headers_cliente($email)
            : array('Content-Type: text/html; charset=UTF-8', 'From: Deckeva <contacto@deckeva.cl>');

        if (wp_mail($email, deckeva_leads_personalizar($asunto, $datos), $html, $headers)) {
            deckeva_leads_marcar_contactado($email);
            if (function_exists('deckeva_record_lead')) {
                deckeva_record_lead('reactivacion-enviada', array('email' => $email, 'nombre' => $datos['nombre']));
            }
            $enviados++;
        } else {
            $fallidos++;
        }
    }

    wp_safe_redirect(add_query_arg(
        array(
            'page'        => 'deckeva-leads',
            'desde'       => $desde,
            'reactivados' => $enviados,
            'omitidos'    => $omitidos,
            'fallidos'    => $fallidos,
        ),
        admin_url('tools.php')
    ));
    exit;
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

    // A partir de aquí todo va dentro del formulario de reactivación: se marcan
    // los clientes a los que escribir y se envía desde el propio sitio.
    echo '<form method="post" action="' . esc_url(admin_url('admin-post.php')) . '">';
    wp_nonce_field('deckeva_leads_reactivar');
    echo '<input type="hidden" name="action" value="deckeva_leads_reactivar" />';
    echo '<input type="hidden" name="desde" value="' . esc_attr($desde) . '" />';

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

    deckeva_leads_formulario_envio();

    echo '</form>';
    echo '</div>';
}

/**
 * Editor del correo de reactivación + botón de envío.
 */
function deckeva_leads_formulario_envio() {
    $plantilla = deckeva_leads_plantilla();

    echo '<h2 style="margin-top:34px;">Escribirles de vuelta</h2>';
    echo '<p style="color:#555;margin-top:-6px;">Marca arriba a quién escribir y revisa el texto. '
        . 'El correo sale desde <strong>contacto@deckeva.cl</strong>, uno por persona. '
        . '<code>{nombre}</code> y <code>{fecha}</code> se reemplazan por los datos de cada uno, '
        . 'y a nadie se le escribe dos veces.</p>';

    echo '<table class="form-table"><tbody>';
    echo '<tr><th scope="row"><label for="deckeva-asunto">Asunto</label></th><td>'
        . '<input type="text" id="deckeva-asunto" name="asunto" class="large-text" value="'
        . esc_attr($plantilla['asunto']) . '" /></td></tr>';
    echo '<tr><th scope="row"><label for="deckeva-cuerpo">Mensaje</label></th><td>'
        . '<textarea id="deckeva-cuerpo" name="cuerpo" rows="12" class="large-text code">'
        . esc_textarea($plantilla['cuerpo']) . '</textarea></td></tr>';
    echo '</tbody></table>';

    echo '<p><button type="submit" class="button button-primary button-hero" '
        . 'onclick="return confirm(\'Se enviará el correo a cada cliente marcado. ¿Confirmas?\');">'
        . 'Enviar a los seleccionados</button></p>';
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
        . '<th style="width:32px;"><input type="checkbox" onclick="this.closest(\'table\')'
        . '.querySelectorAll(\'tbody input[type=checkbox]:not(:disabled)\').forEach(c=>c.checked=this.checked);" '
        . 'title="Marcar todos" /></th>'
        . '<th>Fecha</th><th>Estado</th><th>Nombre</th><th>Email</th><th>Teléfono</th><th>Detalle</th><th></th>'
        . '</tr></thead><tbody>';

    foreach ($filas as $f) {
        $destacar = (stripos($f['estado'], 'spam') !== false || stripos($f['estado'], 'sin aviso') !== false);
        echo '<tr' . ($destacar ? ' style="background:#fff4f4;"' : '') . '>';
        echo '<td>' . deckeva_leads_casilla($f) . '</td>';
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

/**
 * Casilla para marcar un lead como destinatario de la reactivación.
 * Se desactiva si no hay email utilizable o si a esa persona ya se le escribió.
 */
function deckeva_leads_casilla($fila) {
    if (empty($fila['email']) || !is_email($fila['email'])) {
        return '<span title="Sin email utilizable" style="color:#999;">—</span>';
    }

    $contactado = deckeva_leads_ya_contactado($fila['email']);
    if ($contactado) {
        return '<span title="Ya contactado el ' . esc_attr($contactado) . '" style="color:#2b8a3e;">✓</span>';
    }

    $token = base64_encode(wp_json_encode(array(
        'email'  => $fila['email'],
        'nombre' => $fila['nombre'],
        'fecha'  => $fila['fecha'],
    )));

    return '<input type="checkbox" name="leads[]" value="' . esc_attr($token) . '" />';
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
    $enviado = deckeva_leads_enviar_informe($desde);

    wp_safe_redirect(add_query_arg(
        array('page' => 'deckeva-leads', 'desde' => $desde, 'enviado' => $enviado ? '1' : '0'),
        admin_url('tools.php')
    ));
    exit;
}

/**
 * Arma el informe de contactos y lo manda a las casillas del negocio.
 *
 * Incluye un extracto de cada mensaje: sin él no se puede distinguir a un
 * cliente real de un bot, que es lo primero que hay que hacer con el listado.
 *
 * @return bool true si salió el correo.
 */
function deckeva_leads_enviar_informe($desde = '', $titulo = '') {
    $filas = deckeva_leads_filas_planas($desde);
    $total = count($filas);

    // Tope para que una avalancha de spam no produzca un correo imposible de abrir.
    $tope = 400;
    $mostradas = array_slice($filas, 0, $tope);

    $celda = 'padding:6px 8px;border:1px solid #d7dde3;vertical-align:top;';
    $html = '<div style="font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#1a2a3a;">'
        . '<p style="font-size:15px;"><strong>' . esc_html($titulo ? $titulo : 'Contactos web') . '</strong><br>'
        . esc_html($total) . ' registro(s) desde ' . esc_html($desde ? $desde : 'el principio') . '. '
        . 'En rojo, los que nunca generaron aviso: el antispam los descartó o la copia al negocio se perdió.</p>'
        . '<table cellpadding="0" cellspacing="0" style="border-collapse:collapse;">'
        . '<tr style="background:#0d2137;color:#fff;">'
        . '<th style="' . $celda . '">Fecha</th><th style="' . $celda . '">Estado</th>'
        . '<th style="' . $celda . '">Nombre</th><th style="' . $celda . '">Email</th>'
        . '<th style="' . $celda . '">Teléfono</th><th style="' . $celda . '">Mensaje</th></tr>';

    foreach ($mostradas as $f) {
        $perdido = (stripos($f['estado'], 'spam') !== false || stripos($f['estado'], 'sin aviso') !== false);
        $mensaje = trim(($f['asunto'] ? $f['asunto'] . ' — ' : '') . $f['detalle']);

        $html .= '<tr' . ($perdido ? ' style="background:#fff4f4;"' : '') . '>'
            . '<td style="' . $celda . 'white-space:nowrap;">' . esc_html($f['fecha']) . '</td>'
            . '<td style="' . $celda . '">' . esc_html($f['origen'] . ' · ' . $f['estado']) . '</td>'
            . '<td style="' . $celda . '">' . esc_html($f['nombre']) . '</td>'
            . '<td style="' . $celda . '">' . esc_html($f['email']) . '</td>'
            . '<td style="' . $celda . 'white-space:nowrap;">' . esc_html($f['telefono']) . '</td>'
            . '<td style="' . $celda . 'max-width:420px;">' . esc_html(mb_substr($mensaje, 0, 280)) . '</td>'
            . '</tr>';
    }

    $html .= '</table>';
    if ($total > $tope) {
        $html .= '<p>Se muestran los ' . $tope . ' más recientes. El resto está en Herramientas → Leads perdidos.</p>';
    }
    $html .= '</div>';

    $asunto = 'Deckeva — ' . $total . ' contactos web' . ($titulo ? ' · ' . $titulo : '');

    return function_exists('deckeva_notify_lead')
        ? deckeva_notify_lead($asunto, $html)
        : wp_mail(get_option('admin_email'), $asunto, $html, array('Content-Type: text/html; charset=UTF-8'));
}

/* ──────────────────────────────────────────
   INFORME ÚNICO TRAS PUBLICAR
────────────────────────────────────────── */

/**
 * Manda el informe una sola vez por versión, sin que nadie entre al panel.
 *
 * Existe porque quien publica (por FTP, desde GitHub) no tiene sesión en
 * WordPress para pulsar "Enviármelo por correo", y el dueño pidió recibir el
 * listado. Para volver a mandarlo más adelante basta con subir la versión.
 */
const DECKEVA_LEADS_INFORME_VERSION = 1;

// wp_loaded y no init: Flamingo registra sus tipos de contenido en init, y sin
// ellos el informe saldría sin los mensajes de los formularios.
add_action('wp_loaded', 'deckeva_leads_informe_unico');
function deckeva_leads_informe_unico() {
    $clave = 'deckeva_leads_informe_v' . DECKEVA_LEADS_INFORME_VERSION;

    if (get_option($clave)) {
        return;
    }

    // add_option falla si la opción ya existe: si llegan dos visitas a la vez,
    // solo una manda el correo.
    if (!add_option($clave, 'enviando', '', 'no')) {
        return;
    }

    if (deckeva_leads_enviar_informe('2026-01-01', 'Rescate de contactos sin respuesta')) {
        update_option($clave, current_time('mysql'), true);
    } else {
        // Que lo reintente la siguiente visita en vez de darlo por enviado.
        delete_option($clave);
        if (function_exists('deckeva_mail_log')) {
            deckeva_mail_log('No se pudo enviar el informe único de leads; se reintentará.');
        }
    }
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
    if (!isset($_GET['page']) || $_GET['page'] !== 'deckeva-leads') {
        return;
    }

    if (isset($_GET['enviado'])) {
        $ok = $_GET['enviado'] === '1';
        printf(
            '<div class="notice notice-%s is-dismissible"><p>%s</p></div>',
            $ok ? 'success' : 'error',
            $ok ? 'Listado enviado a las casillas del negocio.' : 'No se pudo enviar el listado.'
        );
    }

    if (isset($_GET['reactivados'])) {
        $enviados = intval($_GET['reactivados']);
        $omitidos = isset($_GET['omitidos']) ? intval($_GET['omitidos']) : 0;
        $fallidos = isset($_GET['fallidos']) ? intval($_GET['fallidos']) : 0;

        $partes = array(sprintf('%d correo(s) enviado(s) a clientes.', $enviados));
        if ($omitidos) {
            $partes[] = sprintf('%d omitido(s) por haber sido contactado(s) antes.', $omitidos);
        }
        if ($fallidos) {
            $partes[] = sprintf('%d no se pudo(ieron) enviar.', $fallidos);
        }

        printf(
            '<div class="notice notice-%s is-dismissible"><p>%s</p></div>',
            $fallidos ? 'warning' : 'success',
            esc_html(implode(' ', $partes))
        );
    }
});
