<?php
/**
 * Plugin Name: Deckeva - Reenvío de cotizaciones perdidas
 * Description: Campaña única. Escribe a los clientes cuyas cotizaciones de la home nunca
 *              llegaron al negocio y les reenvía su cotización con el diseño nuevo y el
 *              precio que se les dio. Primero manda una muestra a las casillas internas.
 *
 * El caso: hasta septiembre de 2026 el aviso de cada cotización de la home viajaba
 * como copia oculta del correo al cliente y se perdía. Doce clientes reales cotizaron
 * entre abril y septiembre y nadie les contestó (FIXES_SESSION9.md). El dueño aprobó
 * escribirles con un texto transparente, respetar el precio que se les cotizó y ver
 * antes una muestra.
 *
 * Se controla con DECKEVA_RESCATE_FASE:
 * - 'muestra': una sola vez, manda a las casillas internas el correo tal como lo
 *   recibirían dos de los clientes (uno en español y el de EE. UU., en inglés) y la
 *   lista de a quién se le escribirá. No escribe a ningún cliente.
 * - 'enviar': escribe a los clientes, de a DECKEVA_RESCATE_POR_VISITA por visita a
 *   WordPress y como mucho una vez a cada uno. Al terminar manda un resumen interno.
 *   No arranca si la muestra no salió antes.
 * - 'pausa': no hace nada.
 * Pasar a 'enviar' es un cambio de código con su propio PR: la aprobación del dueño
 * queda registrada y nadie lo activa sin querer.
 *
 * En este archivo solo hay números de cotización (el repo es público). Nombre, correo,
 * embarcación y montos se leen en el servidor de los PDF originales y se guardan en
 * uploads/deckeva-leads, cerrada a la web: el cotizador borra de vez en cuando los PDF
 * de más de 30 días y la campaña no puede quedarse sin datos a mitad de camino.
 *
 * Cuando termine se puede borrar este archivo; el registro queda en el log de leads.
 */

if (!defined('ABSPATH')) {
    exit;
}

// 'enviar' aprobado por el dueño el 23/09/2026, tras revisar la muestra en su Gmail.
const DECKEVA_RESCATE_FASE = 'enviar';

// Todo el estado cuelga de esta versión: cambiarla empezaría la campaña de cero y
// volvería a escribir a los mismos clientes. No tocar.
const DECKEVA_RESCATE_VERSION = 'v1';

// Cada correo lleva un PDF generado en el momento: de a pocos por visita para no
// alargar ninguna petición más de unos segundos.
const DECKEVA_RESCATE_POR_VISITA = 3;

// Reintentos ante un fallo de envío. Después, queda para revisarlo a mano.
const DECKEVA_RESCATE_INTENTOS = 3;

/**
 * Las doce, de la más reciente a la más antigua. De quien cotizó dos veces va la
 * última; quedan fuera las pruebas (@example.com) y las de verificación del sitio.
 */
function deckeva_rescate_cotizaciones() {
    return array(
        'DCK-INT-20260910191427-5B955',
        'DCK-INT-20260907220440-6D13F',
        'DCK-INT-20260824013254-45F5A',
        'DCK-INT-20260822154120-8AA9A',
        'DCK-INT-20260817180707-2263A',
        'DCK-INT-20260708172250-03CB6',
        'DCK-INT-20260615234845-6D8C5',
        'DCK-INT-20260527150243-CC3AC',
        'DCK-INT-20260520231533-47AD3',
        'DCK-INT-20260512132216-E78AA',
        'DCK-INT-20260429120204-0F0AC',
        'DCK-INT-20260423015228-78FED',
    );
}

/**
 * Las de la muestra: una en pesos chilenos y la de EE. UU., que sale en inglés.
 */
function deckeva_rescate_muestras() {
    return array(
        'DCK-INT-20260907220440-6D13F',
        'DCK-INT-20260429120204-0F0AC',
    );
}

/* ──────────────────────────────────────────
   CUÁNDO SE TRABAJA
────────────────────────────────────────── */

add_action('wp_loaded', 'deckeva_rescate_programar');
function deckeva_rescate_programar() {
    if (!in_array(DECKEVA_RESCATE_FASE, array('muestra', 'enviar'), true)) {
        return;
    }

    // Marca rápida de "fase terminada", para no abrir el archivo de estado en cada visita.
    // En "enviar", lo último es la copia al dueño de lo ya enviado: la campaña queda
    // inerte cuando esa copia también salió.
    $terminada = (DECKEVA_RESCATE_FASE === 'enviar')
        ? get_option(deckeva_rescate_opcion_copias())
        : get_option(deckeva_rescate_opcion_hecho());
    if ($terminada) {
        return;
    }

    // Al final de la petición y, si el servidor lo permite, con la página ya
    // entregada: quien esté visitando no espera a que se generen los PDF.
    add_action('shutdown', 'deckeva_rescate_trabajar', 1000);
}

function deckeva_rescate_opcion_hecho() {
    return 'deckeva_rescate_' . DECKEVA_RESCATE_VERSION . '_' . DECKEVA_RESCATE_FASE . '_hecho';
}

function deckeva_rescate_opcion_copias() {
    return 'deckeva_rescate_' . DECKEVA_RESCATE_VERSION . '_copias_hecho';
}

/**
 * Todo lo que hace falta de los otros mu-plugins. Si falta algo (por ejemplo, a mitad
 * de una subida por FTP), no se toca nada y se reintenta en la siguiente visita.
 */
function deckeva_rescate_listo() {
    return function_exists('deckeva_lead_log_dir')
        && function_exists('deckeva_lead_recipients')
        && function_exists('deckeva_is_internal_address')
        && function_exists('deckeva_mail_headers')
        && function_exists('deckeva_notify_lead')
        && function_exists('deckeva_record_lead')
        && function_exists('deckeva_mail_log')
        && function_exists('deckeva_leads_datos_pdf')
        && function_exists('deckeva_leads_ya_contactado')
        && function_exists('deckeva_leads_marcar_contactado')
        && function_exists('deckeva_leads_fecha_legible')
        && class_exists('Deckeva_Cotizador')
        && method_exists('Deckeva_Cotizador', 'pdf_diseno_nuevo')
        && defined('Deckeva_Cotizador::MONEDAS');
}

function deckeva_rescate_trabajar() {
    if (!deckeva_rescate_listo()) {
        return;
    }

    $dir = deckeva_lead_log_dir();
    if ($dir === '') {
        deckeva_mail_log('Reenvío de cotizaciones: no se puede escribir en uploads/deckeva-leads.');
        return;
    }

    // Un solo proceso a la vez. Si otra visita ya está en ello, esta no hace nada:
    // es lo que impide que dos peticiones simultáneas escriban dos veces al mismo cliente.
    $cerrojo = @fopen($dir . '/rescate-' . DECKEVA_RESCATE_VERSION . '.lock', 'c');
    if (!$cerrojo) {
        return;
    }
    if (!flock($cerrojo, LOCK_EX | LOCK_NB)) {
        fclose($cerrojo);
        return;
    }

    if (function_exists('fastcgi_finish_request')) {
        fastcgi_finish_request();
    } elseif (function_exists('litespeed_finish_request')) {
        litespeed_finish_request();
    }
    ignore_user_abort(true);
    if (function_exists('set_time_limit')) {
        @set_time_limit(180);
    }

    try {
        $estado = deckeva_rescate_estado_leer($dir);
        if ($estado === null) {
            // Un estado ilegible no puede leerse como "a nadie se le escribió todavía".
            deckeva_mail_log('Reenvío de cotizaciones: el archivo de estado no se puede leer; no se envía nada.');
        } elseif (DECKEVA_RESCATE_FASE === 'muestra') {
            deckeva_rescate_fase_muestra($dir, $estado);
        } elseif (!empty($estado['resumen'])) {
            deckeva_rescate_fase_copias($dir, $estado);
        } else {
            deckeva_rescate_fase_enviar($dir, $estado);
        }
    } catch (\Throwable $e) {
        deckeva_mail_log('Reenvío de cotizaciones: error inesperado: ' . $e->getMessage());
    }

    flock($cerrojo, LOCK_UN);
    fclose($cerrojo);
}

/* ──────────────────────────────────────────
   ESTADO (uploads/deckeva-leads, cerrada a la web)
────────────────────────────────────────── */

function deckeva_rescate_estado_archivo($dir) {
    return $dir . '/rescate-' . DECKEVA_RESCATE_VERSION . '.json';
}

/**
 * @return array|null null si el archivo existe pero no se entiende.
 */
function deckeva_rescate_estado_leer($dir) {
    $vacio = array('datos' => array(), 'muestra' => array(), 'envios' => array(), 'resumen' => '');
    $archivo = deckeva_rescate_estado_archivo($dir);

    if (!file_exists($archivo)) {
        return $vacio;
    }

    $estado = json_decode((string) file_get_contents($archivo), true);
    if (!is_array($estado)) {
        return null;
    }

    return $estado + $vacio;
}

/**
 * Se escribe a un temporal y se renombra: si el proceso muere a mitad, queda el
 * estado anterior entero y no un JSON cortado que haría olvidar a quién se le escribió.
 */
function deckeva_rescate_estado_guardar($dir, array $estado) {
    $archivo = deckeva_rescate_estado_archivo($dir);
    $tmp     = $archivo . '.tmp';
    $json    = wp_json_encode($estado, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

    if ($json === false || @file_put_contents($tmp, $json) === false || !@rename($tmp, $archivo)) {
        deckeva_mail_log('Reenvío de cotizaciones: no se pudo guardar el estado.');
        return false;
    }

    return true;
}

/**
 * Lee de los PDF originales los datos que aún no estén guardados. Lo ya guardado no se
 * vuelve a leer: los PDF pueden desaparecer, los datos guardados no.
 */
function deckeva_rescate_completar_datos(array $estado) {
    $upload = wp_upload_dir();
    if (!empty($upload['error'])) {
        return $estado;
    }

    foreach (deckeva_rescate_cotizaciones() as $numero) {
        if (!empty($estado['datos'][$numero])) {
            continue;
        }

        $archivos = glob($upload['basedir'] . '/cotizaciones-intl/DECKEVA-Quote-' . $numero . '-*.pdf');
        if (!$archivos) {
            continue;
        }

        $lead = deckeva_leads_datos_pdf($archivos[0]);
        if (is_array($lead) && $lead['numero'] === $numero && is_email($lead['email'])) {
            $estado['datos'][$numero] = $lead;
        }
    }

    return $estado;
}

/* ──────────────────────────────────────────
   FASE "muestra"
────────────────────────────────────────── */

function deckeva_rescate_fase_muestra($dir, array $estado) {
    $muestra = $estado['muestra'] + array('estado' => '', 'intentos' => 0);

    if ($muestra['estado'] === 'enviada') {
        update_option(deckeva_rescate_opcion_hecho(), deckeva_rescate_ahora(), true);
        return;
    }
    if ($muestra['intentos'] >= DECKEVA_RESCATE_INTENTOS) {
        return;
    }

    $estado = deckeva_rescate_completar_datos($estado);
    $muestra['intentos']++;
    $estado['muestra'] = $muestra;
    if (!deckeva_rescate_estado_guardar($dir, $estado)) {
        return;
    }

    // Solo a las casillas del negocio. Ningún cliente en esta fase.
    $internos = deckeva_lead_recipients();
    $salieron = 0;
    foreach (deckeva_rescate_muestras() as $numero) {
        if (empty($estado['datos'][$numero])) {
            continue;
        }
        $lead    = $estado['datos'][$numero];
        $prefijo = '[MUESTRA para ' . deckeva_rescate_nombre_propio($lead['nombre']) . '] ';
        if (deckeva_rescate_enviar($dir, $lead, $internos, $prefijo)) {
            $salieron++;
        }
    }

    $lista = deckeva_notify_lead(
        '[MUESTRA] Reenvío de cotizaciones: a quién se le escribirá',
        deckeva_rescate_tabla_html(
            'Reenvío de cotizaciones: lista para aprobar',
            'Todavía no se ha escrito a ningún cliente. Arriba tienes dos muestras exactas de lo que '
                . 'recibirían (una en español y la de EE. UU. en inglés). Esta es la lista completa, '
                . 'con el valor que se le cotizó a cada uno y que se respeta en la cotización reemitida.',
            $estado,
            false
        )
    );

    if ($salieron === count(deckeva_rescate_muestras()) && $lista) {
        $estado['muestra'] = array(
            'estado'   => 'enviada',
            'fecha'    => deckeva_rescate_ahora(),
            'intentos' => $muestra['intentos'],
        );
        deckeva_rescate_estado_guardar($dir, $estado);
        update_option(deckeva_rescate_opcion_hecho(), deckeva_rescate_ahora(), true);
        deckeva_record_lead('rescate-muestra', array(
            'Muestras' => implode(', ', deckeva_rescate_muestras()),
            'Con datos' => count($estado['datos']) . ' de ' . count(deckeva_rescate_cotizaciones()),
        ));
    } else {
        deckeva_mail_log('Reenvío de cotizaciones: la muestra no salió completa ('
            . $salieron . ' de ' . count(deckeva_rescate_muestras()) . ', lista '
            . ($lista ? 'sí' : 'no') . '); intento ' . $muestra['intentos'] . '.');
    }
}

/* ──────────────────────────────────────────
   FASE "enviar"
────────────────────────────────────────── */

function deckeva_rescate_fase_enviar($dir, array $estado) {
    if (empty($estado['muestra']['estado']) || $estado['muestra']['estado'] !== 'enviada') {
        deckeva_mail_log('Reenvío de cotizaciones: fase "enviar" sin muestra previa; no se escribe a nadie.');
        return;
    }
    if (!empty($estado['resumen'])) {
        update_option(deckeva_rescate_opcion_hecho(), deckeva_rescate_ahora(), true);
        return;
    }

    $estado = deckeva_rescate_completar_datos($estado);
    $hechos = 0;

    foreach (deckeva_rescate_cotizaciones() as $numero) {
        if ($hechos >= DECKEVA_RESCATE_POR_VISITA) {
            break;
        }

        $envio = isset($estado['envios'][$numero]) ? $estado['envios'][$numero] : array();
        $envio += array('estado' => '', 'intentos' => 0, 'fecha' => '', 'detalle' => '');
        if (deckeva_rescate_envio_cerrado($envio)) {
            continue;
        }

        if (empty($estado['datos'][$numero])) {
            $envio['intentos']++;
            $envio['estado']  = 'fallido';
            $envio['detalle'] = 'sin datos: no se encontró el PDF original';
            $estado['envios'][$numero] = $envio;
            deckeva_rescate_estado_guardar($dir, $estado);
            continue;
        }

        $lead = $estado['datos'][$numero];

        // Nunca dos veces a la misma persona, tampoco si ya se le escribió desde el panel.
        $ya = deckeva_leads_ya_contactado($lead['email']);
        if ($ya) {
            $envio['estado']  = 'omitido';
            $envio['fecha']   = deckeva_rescate_ahora();
            $envio['detalle'] = 'ya se le había escrito el ' . $ya;
            $estado['envios'][$numero] = $envio;
            deckeva_rescate_estado_guardar($dir, $estado);
            continue;
        }

        // Primero queda anotado "enviando" y solo después se manda. Si el proceso muere
        // en medio, ese cliente queda para revisarlo a mano en vez de recibir dos correos.
        $envio['estado'] = 'enviando';
        $envio['fecha']  = deckeva_rescate_ahora();
        $envio['intentos']++;
        $estado['envios'][$numero] = $envio;
        if (!deckeva_rescate_estado_guardar($dir, $estado)) {
            return;
        }

        $hechos++;
        if (deckeva_rescate_enviar($dir, $lead, $lead['email'])) {
            $envio['estado'] = 'enviado';
            $envio['fecha']  = deckeva_rescate_ahora();
            // Con copia oculta al dueño: el paso de copias no tiene que repetirlo.
            $envio['copia_oculta'] = function_exists('deckeva_mail_headers_cliente');
            deckeva_leads_marcar_contactado($lead['email']);
            deckeva_record_lead('rescate-enviado', array(
                'Cotización' => $numero,
                'Nombre'     => $lead['nombre'],
                'Email'      => $lead['email'],
            ));
        } else {
            $envio['estado']  = 'fallido';
            $envio['detalle'] = 'no se pudo enviar';
        }
        $estado['envios'][$numero] = $envio;
        deckeva_rescate_estado_guardar($dir, $estado);
    }

    if (!deckeva_rescate_terminada($estado)) {
        return;
    }

    $enviados = 0;
    foreach ($estado['envios'] as $envio) {
        if ($envio['estado'] === 'enviado') {
            $enviados++;
        }
    }

    $total = count(deckeva_rescate_cotizaciones());
    $ok = deckeva_notify_lead(
        'Reenvío de cotizaciones: ' . $enviados . ' de ' . $total . ' clientes contactados',
        deckeva_rescate_tabla_html(
            'Reenvío de cotizaciones: resumen',
            'Se escribió a ' . $enviados . ' de ' . $total . ' clientes. Las respuestas llegan a '
                . 'contacto@deckeva.cl. Los que aparezcan como "enviando", "fallido" u "omitido" '
                . 'no recibieron este correo: conviene revisarlos a mano.',
            $estado,
            true
        )
    );

    if ($ok) {
        $estado['resumen'] = deckeva_rescate_ahora();
        deckeva_rescate_estado_guardar($dir, $estado);
        update_option(deckeva_rescate_opcion_hecho(), deckeva_rescate_ahora(), true);
    }
}

/**
 * Un envío que ya no se toca: enviado, omitido, "enviando" de un proceso que murió
 * (no se reintenta: pudo haber salido) o fallido sin más intentos.
 */
function deckeva_rescate_envio_cerrado(array $envio) {
    if (in_array($envio['estado'], array('enviado', 'omitido', 'enviando'), true)) {
        return true;
    }

    return $envio['estado'] === 'fallido' && $envio['intentos'] >= DECKEVA_RESCATE_INTENTOS;
}

function deckeva_rescate_terminada(array $estado) {
    foreach (deckeva_rescate_cotizaciones() as $numero) {
        if (empty($estado['envios'][$numero])) {
            return false;
        }
        $envio = $estado['envios'][$numero] + array('estado' => '', 'intentos' => 0);
        if (!deckeva_rescate_envio_cerrado($envio)) {
            return false;
        }
    }

    return true;
}

/* ──────────────────────────────────────────
   COPIA AL DUEÑO DE LO YA ENVIADO
────────────────────────────────────────── */

/**
 * Los 12 correos salieron antes de que el dueño pidiera copia oculta de todo lo que
 * va a un cliente (23/09/2026). Esto le manda, una sola vez, la copia que habría
 * recibido: el mismo correo con el mismo PDF, solo a él y nunca a los clientes.
 * Lleva el Reply-To del cliente, para que al responder la copia le escriba directo.
 */
function deckeva_rescate_fase_copias($dir, array $estado) {
    $copia = function_exists('deckeva_copia_oculta_address') ? deckeva_copia_oculta_address() : '';
    if (!is_email($copia)) {
        return;
    }
    if (!isset($estado['copias']) || !is_array($estado['copias'])) {
        $estado['copias'] = array();
    }

    $pendiente = function ($numero) use (&$estado) {
        $envio = isset($estado['envios'][$numero]) ? $estado['envios'][$numero] : array();
        if (empty($envio['estado']) || $envio['estado'] !== 'enviado' || empty($estado['datos'][$numero])) {
            return false;
        }
        // Si ya salió con copia oculta, el dueño la tiene.
        if (!empty($envio['copia_oculta'])) {
            return false;
        }
        $hecha = isset($estado['copias'][$numero]) ? $estado['copias'][$numero] : array();
        $hecha += array('estado' => '', 'intentos' => 0);

        return $hecha['estado'] !== 'enviada' && $hecha['intentos'] < DECKEVA_RESCATE_INTENTOS;
    };

    $hechas = 0;
    foreach (deckeva_rescate_cotizaciones() as $numero) {
        if ($hechas >= DECKEVA_RESCATE_POR_VISITA) {
            break;
        }
        if (!$pendiente($numero)) {
            continue;
        }

        $lead  = $estado['datos'][$numero];
        $hecha = isset($estado['copias'][$numero]) ? $estado['copias'][$numero] : array();
        $hecha += array('estado' => '', 'intentos' => 0);
        $hecha['intentos']++;
        $hechas++;

        $prefijo = '[Copia para ' . deckeva_rescate_nombre_propio($lead['nombre']) . '] ';
        if (deckeva_rescate_enviar($dir, $lead, $copia, $prefijo, $lead['email'])) {
            $hecha['estado'] = 'enviada';
            $hecha['fecha']  = deckeva_rescate_ahora();
        }
        $estado['copias'][$numero] = $hecha;
        deckeva_rescate_estado_guardar($dir, $estado);
    }

    foreach (deckeva_rescate_cotizaciones() as $numero) {
        if ($pendiente($numero)) {
            return;
        }
    }
    update_option(deckeva_rescate_opcion_copias(), deckeva_rescate_ahora(), true);
}

/* ──────────────────────────────────────────
   EL CORREO
────────────────────────────────────────── */

/**
 * Genera el PDF con el diseño nuevo y manda el correo. $para es el cliente, o las
 * casillas internas en la muestra. Sin PDF no sale nada: el correo dice que lo adjunta.
 */
function deckeva_rescate_enviar($dir, array $lead, $para, $prefijo_asunto = '', $reply_to = '') {
    $idioma = deckeva_rescate_idioma($lead['pais']);

    $pdf = Deckeva_Cotizador::pdf_diseno_nuevo(deckeva_rescate_datos_pdf($lead, $idioma));
    if (!is_string($pdf) || strncmp($pdf, '%PDF', 4) !== 0) {
        deckeva_mail_log('Reenvío ' . $lead['numero'] . ': no se pudo generar el PDF; no se manda el correo.');
        return false;
    }

    $adjunto = $dir . '/' . ($idioma === 'en' ? 'Deckeva-Quote-' : 'Deckeva-Cotizacion-') . $lead['numero'] . '.pdf';
    if (@file_put_contents($adjunto, $pdf) === false) {
        deckeva_mail_log('Reenvío ' . $lead['numero'] . ': no se pudo guardar el PDF temporal.');
        return false;
    }

    $texto = deckeva_rescate_texto($lead, $idioma);
    $html  = '<div style="font-family:Arial,Helvetica,sans-serif;font-size:15px;line-height:1.6;color:#1a2a3a;max-width:620px;">'
        . wpautop(esc_html($texto['cuerpo']))
        . '</div>';

    // A un cliente: con copia oculta al dueño. A las casillas internas (muestra y
    // copias) no, porque ya son el dueño.
    $interno = is_array($para) || deckeva_is_internal_address($para);
    $headers = (!$interno && function_exists('deckeva_mail_headers_cliente'))
        ? deckeva_mail_headers_cliente($para)
        : deckeva_mail_headers($reply_to);

    $enviado = wp_mail($para, $prefijo_asunto . $texto['asunto'], $html, $headers, array($adjunto));
    @unlink($adjunto);

    if (!$enviado) {
        deckeva_mail_log('Reenvío ' . $lead['numero'] . ': wp_mail no pudo enviarlo.');
    }

    return $enviado;
}

/**
 * El texto que aprobó el dueño, más una línea sobre la cotización adjunta. El de
 * inglés es su traducción, para el cliente de EE. UU.
 */
function deckeva_rescate_texto(array $lead, $idioma) {
    $nombre    = deckeva_rescate_nombre_propio($lead['nombre']);
    $partes    = explode(' ', $nombre);
    $pila      = $partes[0];
    $fecha     = deckeva_rescate_fecha_contacto($lead['numero']);
    $ts        = strtotime($fecha);
    $consultar = !empty($lead['a_consultar']);

    if ($idioma === 'en') {
        $adjunto = $consultar
            ? "I've attached your quote {numero} again."
            : "I've attached your quote {numero} again, at the same price we gave you back then.";

        $cuerpo = "Hi {nombre},\n\n"
            . "This is Deckeva. You contacted us on {fecha} and never heard back. That was our fault: "
            . "a problem with the form on our website meant your message never reached our inbox. "
            . "It has now been fixed.\n\n"
            . "If you're still interested, we'll pick up right where you left off. Just reply to this "
            . "email or message us on WhatsApp at +56 9 4021 1459 and we'll guide you through the "
            . "measurements, design and installation.\n\n"
            . $adjunto . "\n\n"
            . "Best regards,\nJuan Pablo · Deckeva";

        return array(
            'asunto' => 'Picking up your Deckeva quote — sorry for the delay',
            'cuerpo' => strtr($cuerpo, array(
                '{nombre}' => $pila,
                '{fecha}'  => $ts ? date('F j', $ts) : $fecha,
                '{numero}' => $lead['numero'],
            )),
        );
    }

    $adjunto = $consultar
        ? 'Te adjunto de nuevo tu cotización {numero}.'
        : 'Te adjunto de nuevo tu cotización {numero}, con el mismo valor que te dimos entonces.';

    $cuerpo = "Hola {nombre}:\n\n"
        . "Te escribo de Deckeva. Nos contactaste el {fecha} y no recibiste respuesta. "
        . "La causa fue nuestra: una falla en el formulario de la web hizo que tu mensaje "
        . "nunca llegara a nuestra bandeja. Ya está corregido.\n\n"
        . "Si todavía te interesa, retomamos justo donde quedaste. Responde este correo o "
        . "escríbenos por WhatsApp al +56 9 4021 1459 y te acompañamos con las medidas, el "
        . "diseño y la instalación.\n\n"
        . $adjunto . "\n\n"
        . "Un saludo,\nJuan Pablo · Deckeva";

    return array(
        'asunto' => 'Retomamos tu cotización — disculpa la demora',
        'cuerpo' => strtr($cuerpo, array(
            '{nombre}' => $pila,
            '{fecha}'  => deckeva_leads_fecha_legible($fecha),
            '{numero}' => $lead['numero'],
        )),
    );
}

/**
 * Día en que el cliente cotizó, en la hora de Chile. El número se arma con date() de
 * PHP, que en WordPress va en UTC: una cotización de las 21:00 en Chile lleva ya la
 * fecha del día siguiente, y al cliente no se le puede decir que escribió otro día.
 * No se usa la zona del WordPress porque no es la de Chile (va en UTC+2).
 */
function deckeva_rescate_fecha_contacto($numero) {
    if (!preg_match('/^DCK-INT-(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})-/', $numero, $m)) {
        return '';
    }

    try {
        $fecha = new DateTime($m[1] . '-' . $m[2] . '-' . $m[3] . ' ' . $m[4] . ':' . $m[5] . ':' . $m[6], new DateTimeZone('UTC'));
        $fecha->setTimezone(new DateTimeZone('America/Santiago'));
        return $fecha->format('Y-m-d');
    } catch (\Exception $e) {
        return $m[1] . '-' . $m[2] . '-' . $m[3];
    }
}

/**
 * Hoy en Chile, para la fecha de reemisión.
 */
function deckeva_rescate_hoy() {
    try {
        return new DateTime('now', new DateTimeZone('America/Santiago'));
    } catch (\Exception $e) {
        return new DateTime('now');
    }
}

/**
 * Hora de Chile para el estado y el resumen, que lee el dueño.
 */
function deckeva_rescate_ahora() {
    return deckeva_rescate_hoy()->format('Y-m-d H:i:s');
}

/**
 * Inglés para quien escribió desde un país de habla inglesa; español para el resto.
 */
function deckeva_rescate_idioma($pais) {
    $ingles = array('united states', 'usa', 'estados unidos', 'canada', 'united kingdom', 'australia');

    return in_array(strtolower(trim((string) $pais)), $ingles, true) ? 'en' : 'es';
}

/**
 * "CRISTOBAL ESPINOSA" → "Cristobal Espinosa", "frank Sims" → "Frank Sims",
 * "NICOLAS DE LA FUENTE" → "Nicolas de la Fuente". Solo se tocan las palabras que
 * vienen enteras en mayúsculas o en minúsculas: "Peña" o "McDonald" quedan como las
 * escribió el cliente. Tildes no se agregan: no sabemos cómo escribe su nombre.
 */
function deckeva_rescate_nombre_propio($nombre) {
    $nombre = trim(preg_replace('/\s+/u', ' ', (string) $nombre));
    if ($nombre === '' || !function_exists('mb_convert_case')) {
        return $nombre;
    }

    $particulas = array('de', 'del', 'la', 'las', 'los', 'y', 'da', 'das', 'do', 'dos', 'van', 'von', 'der');
    $palabras   = explode(' ', $nombre);

    foreach ($palabras as $i => $palabra) {
        $minusculas = mb_strtolower($palabra, 'UTF-8');
        if ($palabra !== $minusculas && $palabra !== mb_strtoupper($palabra, 'UTF-8')) {
            continue;
        }
        $palabras[$i] = ($i > 0 && in_array($minusculas, $particulas, true))
            ? $minusculas
            : mb_convert_case($minusculas, MB_CASE_TITLE, 'UTF-8');
    }

    return implode(' ', $palabras);
}

/* ──────────────────────────────────────────
   LA COTIZACIÓN REEMITIDA
────────────────────────────────────────── */

/**
 * Datos para la plantilla del PDF nuevo con los montos tal como se cotizaron: el
 * texto sale del PDF original, no se recalcula con la tabla de precios de hoy.
 */
function deckeva_rescate_datos_pdf(array $lead, $idioma) {
    $hoy   = deckeva_rescate_hoy();
    $meses = array(1 => 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio',
        'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');

    $fecha = ($idioma === 'en')
        ? 'Reissued · ' . $hoy->format('F j, Y')
        : 'Reemitida · ' . $hoy->format('j') . ' de ' . $meses[(int) $hoy->format('n')] . ' de ' . $hoy->format('Y');

    $consultar   = !empty($lead['a_consultar']);
    $referencias = deckeva_rescate_referencias($lead['moneda'], $lead['total'], $consultar);

    return array(
        'numero' => $lead['numero'],
        'fecha'  => $fecha,
        'cliente' => array(
            'nombre'   => deckeva_rescate_nombre_propio($lead['nombre']),
            'email'    => $lead['email'],
            'telefono' => $lead['telefono'],
            'pais'     => $lead['pais'],
        ),
        'embarcacion' => array(
            'tamano' => $lead['tamano'],
            'modelo' => $lead['modelo'],
            'anio'   => $lead['anio'],
            'color'  => $lead['color'],
        ),
        'precio' => array(
            'a_consultar' => $consultar,
            'subtotal'    => $lead['subtotal'],
            'iva'         => $lead['iva'],
            'total'       => $lead['total'],
            'ref_usd'     => $referencias['ref_usd'],
            'tipo_cambio' => $referencias['tipo_cambio'],
        ),
    );
}

/**
 * "≈ USD" y tipo de cambio de referencia, igual que los calcula el cotizador
 * (international_pdf_data) y con su misma tabla de monedas, a partir del total que se
 * le dio al cliente.
 */
function deckeva_rescate_referencias($moneda, $total, $consultar) {
    $vacio   = array('ref_usd' => '', 'tipo_cambio' => '');
    $monedas = Deckeva_Cotizador::MONEDAS;

    if ($consultar || $moneda === 'CLP' || !isset($monedas[$moneda], $monedas['USD'])) {
        return $vacio;
    }

    $tasa = (float) $monedas[$moneda]['rate'];
    if ($tasa <= 0) {
        return $vacio;
    }

    $tipo_cambio = ($tasa >= 1)
        ? '1 ' . $moneda . ' ≈ ' . number_format($tasa, 0, ',', '.') . ' CLP'
        : '1 CLP ≈ ' . number_format(1 / $tasa, 2, ',', '.') . ' ' . $moneda;

    $ref_usd = '';
    if ($moneda !== 'USD') {
        $usd       = $monedas['USD'];
        $total_clp = (float) preg_replace('/\D/', '', (string) $total) * $tasa;
        $ref_usd   = 'USD ' . $usd['symbol'] . number_format((int) round($total_clp / (float) $usd['rate']), 0, ',', $usd['thousands']);
    }

    return array('ref_usd' => $ref_usd, 'tipo_cambio' => $tipo_cambio);
}

/* ──────────────────────────────────────────
   LISTA PARA EL DUEÑO (muestra y resumen)
────────────────────────────────────────── */

function deckeva_rescate_tabla_html($titulo, $intro, array $estado, $con_estado) {
    $celda = 'padding:8px 10px;border-bottom:1px solid #e5e7eb;vertical-align:top;';
    $filas = '';
    $i = 0;

    foreach (deckeva_rescate_cotizaciones() as $numero) {
        $i++;
        $lead = isset($estado['datos'][$numero]) ? $estado['datos'][$numero] : null;

        if (!$lead) {
            $filas .= '<tr><td style="' . $celda . '">' . $i . '</td>'
                . '<td style="' . $celda . 'color:#b91c1c;" colspan="' . ($con_estado ? 5 : 4) . '">'
                . esc_html($numero) . ': no se encontró el PDF original en el servidor.</td></tr>';
            continue;
        }

        $idioma = deckeva_rescate_idioma($lead['pais']);
        $filas .= '<tr>'
            . '<td style="' . $celda . '">' . $i . '</td>'
            . '<td style="' . $celda . '"><strong>' . esc_html(deckeva_rescate_nombre_propio($lead['nombre'])) . '</strong><br>'
            . esc_html($lead['email']) . '<br><span style="color:#64748b;">' . esc_html($lead['pais'])
            . ($idioma === 'en' ? ' · en inglés' : '') . '</span></td>'
            . '<td style="' . $celda . '">' . esc_html(deckeva_leads_fecha_legible(deckeva_rescate_fecha_contacto($numero))) . '</td>'
            . '<td style="' . $celda . '">' . esc_html(trim($lead['modelo'] . ' ' . $lead['anio'])) . '<br>'
            . '<span style="color:#64748b;">' . esc_html($lead['tamano']) . '</span></td>'
            . '<td style="' . $celda . 'white-space:nowrap;">' . esc_html(!empty($lead['a_consultar']) ? 'A consultar' : $lead['total']) . '</td>';

        if ($con_estado) {
            $envio = isset($estado['envios'][$numero]) ? $estado['envios'][$numero] : array();
            $envio += array('estado' => 'pendiente', 'fecha' => '', 'detalle' => '');
            $color = ($envio['estado'] === 'enviado') ? '#047857' : '#b91c1c';
            $filas .= '<td style="' . $celda . 'color:' . $color . ';">' . esc_html($envio['estado'])
                . ($envio['fecha'] ? '<br><span style="color:#64748b;">' . esc_html($envio['fecha']) . '</span>' : '')
                . ($envio['detalle'] ? '<br>' . esc_html($envio['detalle']) : '') . '</td>';
        }

        $filas .= '</tr>';
    }

    $cabecera = '<tr style="background:#f1f5f9;text-align:left;">'
        . '<th style="padding:8px 10px;">#</th><th style="padding:8px 10px;">Cliente</th>'
        . '<th style="padding:8px 10px;">Cotizó el</th><th style="padding:8px 10px;">Embarcación</th>'
        . '<th style="padding:8px 10px;">Total cotizado</th>'
        . ($con_estado ? '<th style="padding:8px 10px;">Estado</th>' : '') . '</tr>';

    return '<!DOCTYPE html><html lang="es"><body style="margin:0;padding:24px;background:#f4f6f8;font-family:Arial,Helvetica,sans-serif;">'
        . '<div style="max-width:760px;margin:0 auto;background:#fff;border-radius:10px;overflow:hidden;border:1px solid #e5e7eb;">'
        . '<div style="background:#0d2137;color:#fff;padding:18px 20px;font-size:17px;font-weight:700;">' . esc_html($titulo) . '</div>'
        . '<div style="padding:18px 20px;color:#334155;font-size:14px;line-height:1.5;">' . esc_html($intro) . '</div>'
        . '<table style="width:100%;border-collapse:collapse;font-size:13px;color:#1a2a3a;">' . $cabecera . $filas . '</table>'
        . '<div style="padding:16px 20px;color:#64748b;font-size:12px;">Aviso automático de deckeva.cl · campaña de reenvío '
        . esc_html(DECKEVA_RESCATE_VERSION) . '</div>'
        . '</div></body></html>';
}
