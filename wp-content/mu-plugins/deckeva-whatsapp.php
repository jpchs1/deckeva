<?php
/**
 * Plugin Name: Deckeva - Respuestas por WhatsApp
 * Description: Contesta el WhatsApp de Deckeva con demora (1 a 40 minutos, 8:00 a 20:00) y con la aprobación de JP.
 * Version: 1.0.0
 * Author: Deckeva
 *
 * ── POR QUÉ EXISTE ───────────────────────────────────────────────────────
 *
 * El +56 9 4021 1459 atiende a Tourevo, Deckeva e Imporlan, y cada negocio se
 * atiende y se cotiza desde su propio sistema (JP, 28-sep-2026). La IA de Meta
 * contesta al instante y no se puede demorar, y la regla es que a un cliente
 * nunca se le contesta al instante: se espera 1, 2, 3, 5, 7, 15 o 40 minutos.
 *
 * Meta entrega los mensajes del número a tourevo.cl, que reconoce los chats de
 * Deckeva y los DERIVA acá, firmados. Acá se redacta, se espera, JP aprueba en
 * wp-admin (Ajustes → WhatsApp Deckeva) y lo aprobado vuelve firmado a la
 * puerta de tourevo.cl, que lo manda por el mismo número. Tourevo no redacta
 * ni cotiza nada de Deckeva: sólo es el cable.
 *
 *   POST /whatsapp-puerta/entrada   el chat, cuando el cliente escribe
 *   POST /whatsapp-puerta/tick      cada minuto: acá se decide qué sale
 *
 * Rutas propias interceptadas en init (como el cotizador), no REST: el
 * antispam cierra /wp-json a los que no tienen sesión.
 *
 * ── LO QUE NO SE NEGOCIA ─────────────────────────────────────────────────
 *
 * - Modo borrador por defecto: nada sale sin que JP lo apruebe.
 * - Nunca un precio por WhatsApp: la cotización formal va por correo, en PDF.
 * - Un texto con importe, guion largo o voseo no sale nunca, ni en automático.
 * - Si alguien le contestó al cliente después de su mensaje, lo nuestro no sale.
 * - Pasadas 23 horas no sale: Meta sólo acepta texto libre dentro de 24 h.
 *
 * Sin la llave de Claude y el secreto de la puerta no hace nada.
 */

if (!defined('ABSPATH')) exit;

const DECKEVA_WA_PUERTA_SALIDA = 'https://tourevo.cl/api/whatsapp-puerta.php?negocio=deckeva';
const DECKEVA_WA_ESPERAS = array(1, 2, 3, 5, 7, 15, 40);
const DECKEVA_WA_SILENCIO = 90;
const DECKEVA_WA_VENCE = 82800; // 23 h
const DECKEVA_WA_MODELO = 'claude-opus-5';

// =============================================
// CONFIGURACIÓN
// =============================================

function deckeva_wa_opcion($clave, $def = '') {
    $const = 'DECKEVA_WA_' . strtoupper($clave);
    if (defined($const)) return trim((string) constant($const));
    return trim((string) get_option('deckeva_wa_' . $clave, $def));
}
function deckeva_wa_secreto() { return deckeva_wa_opcion('secreto'); }
function deckeva_wa_llave() { return deckeva_wa_opcion('anthropic_key'); }
function deckeva_wa_modo() { return deckeva_wa_opcion('modo', 'borrador') === 'automatico' ? 'automatico' : 'borrador'; }
function deckeva_wa_aprobador() { $a = deckeva_wa_opcion('aprobador', 'jpchs1@gmail.com'); return is_email($a) ? $a : 'jpchs1@gmail.com'; }

// =============================================
// LA FIRMA · la misma que admin/src/Core/WhatsAppPuertas.php de Tourevo
// =============================================

function deckeva_wa_firmar($cuerpo, $ts) {
    return 'sha256=' . hash_hmac('sha256', $ts . '.' . $cuerpo, deckeva_wa_secreto());
}
function deckeva_wa_firma_valida($cuerpo, $firma, $ts) {
    if (strlen(deckeva_wa_secreto()) < 24 || !ctype_digit((string) $ts)) return false;
    if (abs(time() - (int) $ts) > 300) return false;
    return hash_equals(deckeva_wa_firmar($cuerpo, (int) $ts), (string) $firma);
}

// =============================================
// LAS REGLAS DEL TEXTO · iguales a Core/Respuesta::validarTexto de Tourevo
// =============================================

function deckeva_wa_validar($txt) {
    $t = trim((string) $txt);
    if ($t === '') return 'vacío';
    if (mb_strlen($t) > 600) return 'pasa de 600 caracteres';
    if (preg_match('/[\x{2014}\x{2013}\x{2012}\x{2015}]/u', $t)) return 'lleva guion largo';
    if (preg_match('/(USD|US\$|CLP|R\$|\$)\s?\d|\d[\d.,]*\s?(USD|CLP|d[oó]lares|pesos|reais)/iu', $t)) return 'lleva un importe · la cotización va por correo';
    if (preg_match('/\b(vos|tenés|podés|querés|escribinos|avisanos|contame|decime|mirá)(?!\p{L})/iu', $t)) return 'no es chileno (vos/tenés)';
    return '';
}

/** Espera antes de contestar: 1 a 40 min, distinta por mensaje, sin patrón. */
function deckeva_wa_demora($semilla) {
    $h = hexdec(substr(hash('sha256', $semilla . '|espera'), 0, 8));
    $base = DECKEVA_WA_ESPERAS[$h % count(DECKEVA_WA_ESPERAS)] * 60;
    $extra = hexdec(substr(hash('sha256', $semilla . '|seg'), 0, 8)) % max(30, (int) ($base * 0.3));
    return $base + $extra;
}

/** La hora, llevada a 8:00–20:00 de Chile. */
function deckeva_wa_en_horario($t, $semilla) {
    $tz = new DateTimeZone('America/Santiago');
    $d = (new DateTimeImmutable('@' . (int) $t))->setTimezone($tz);
    $h = (int) $d->format('G');
    if ($h >= 8 && $h < 20) return (int) $t;
    $dia = $h >= 20 ? $d->modify('+1 day') : $d;
    $abre = $dia->setTime(8, 0)->getTimestamp();
    return $abre + 300 + (hexdec(substr(hash('sha256', $semilla . '|abre'), 0, 8)) % 3000);
}
function deckeva_wa_habil($t) {
    $h = (int) (new DateTimeImmutable('@' . (int) $t))->setTimezone(new DateTimeZone('America/Santiago'))->format('G');
    return $h >= 8 && $h < 20;
}
function deckeva_wa_legible($t) {
    return (new DateTimeImmutable('@' . (int) $t))->setTimezone(new DateTimeZone('America/Santiago'))->format('d-m H:i');
}

// =============================================
// LOS CHATS · una opción, sin autoload
// =============================================

function deckeva_wa_chats() { $c = get_option('deckeva_wa_chats', array()); return is_array($c) ? $c : array(); }
function deckeva_wa_guardar($chats) {
    // Se guardan los 200 chats más recientes: un historial infinito en una opción no escala.
    uasort($chats, function ($a, $b) { return ((int) ($b['actualizado'] ?? 0)) <=> ((int) ($a['actualizado'] ?? 0)); });
    update_option('deckeva_wa_chats', array_slice($chats, 0, 200, true), false);
}
function deckeva_wa_anotar(&$chat, $que) {
    $chat['historial'][] = array('ts' => time(), 'que' => $que);
    $chat['historial'] = array_slice($chat['historial'], -40);
    $chat['actualizado'] = time();
}

// =============================================
// LAS RUTAS
// =============================================

add_action('init', function () {
    $uri = trim((string) parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH), '/');
    if (strpos($uri, 'whatsapp-puerta/') !== 0) return;
    $ruta = substr($uri, strlen('whatsapp-puerta/'));
    if (!in_array($ruta, array('entrada', 'tick'), true)) return;
    if (!defined('DONOTCACHEPAGE')) define('DONOTCACHEPAGE', true);
    nocache_headers();
    header('Content-Type: application/json; charset=UTF-8');

    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') { status_header(405); echo '{"ok":false}'; exit; }
    $raw = (string) file_get_contents('php://input');
    if (strlen($raw) > 65536 || !deckeva_wa_firma_valida($raw, $_SERVER['HTTP_X_PUERTA_FIRMA'] ?? '', $_SERVER['HTTP_X_PUERTA_TS'] ?? '')) {
        status_header(401); echo '{"ok":false,"error":"firma"}'; exit;
    }
    $datos = json_decode($raw, true);
    if (!is_array($datos)) { status_header(400); echo '{"ok":false}'; exit; }

    if ($ruta === 'entrada') {
        deckeva_wa_entrada($datos);
    } else {
        // Una pasada a la vez: la llamada a Claude puede tardar más que el minuto.
        if (get_transient('deckeva_wa_lock')) { echo '{"ok":true,"ocupado":true}'; exit; }
        set_transient('deckeva_wa_lock', 1, 240);
        try { deckeva_wa_pasada(); } finally { delete_transient('deckeva_wa_lock'); }
    }
    echo '{"ok":true}';
    exit;
}, 1);

/** Tourevo derivó un chat: se guarda tal cual llegó (el hilo manda). */
function deckeva_wa_entrada($d) {
    $num = preg_replace('/\D+/', '', (string) ($d['numero'] ?? ''));
    if (!preg_match('/^\d{8,15}$/', $num)) return;
    $msgs = array();
    foreach ((array) ($d['mensajes'] ?? array()) as $m) {
        $msgs[] = array('ts' => (int) ($m['ts'] ?? 0), 'dir' => ($m['dir'] ?? '') === 'in' ? 'in' : 'out', 'texto' => mb_substr((string) ($m['texto'] ?? ''), 0, 2000));
    }
    $chats = deckeva_wa_chats();
    $chat = $chats[$num] ?? array('numero' => $num, 'pendiente' => null, 'historial' => array());
    $chat['mensajes'] = array_slice($msgs, -30);
    $chat['actualizado'] = time();
    $chats[$num] = $chat;
    deckeva_wa_guardar($chats);
}

// =============================================
// LA PASADA
// =============================================

function deckeva_wa_pasada() {
    if (deckeva_wa_llave() === '' || strlen(deckeva_wa_secreto()) < 24) return;
    $ahora = time();
    $chats = deckeva_wa_chats();
    foreach ($chats as $num => $chat) {
        $num = (string) $num; // un número como clave de array PHP lo vuelve entero
        $ultIn = 0; $ultOut = 0;
        foreach ((array) ($chat['mensajes'] ?? array()) as $m) {
            if ($m['dir'] === 'in') $ultIn = max($ultIn, (int) $m['ts']); else $ultOut = max($ultOut, (int) $m['ts']);
        }
        $p = $chat['pendiente'] ?? null;
        $activo = is_array($p) && in_array($p['estado'] ?? '', array('borrador', 'aprobado'), true);

        if ($ultIn === 0) continue;
        if ($ultOut >= $ultIn) {
            if ($activo) { $p['estado'] = 'superado'; $chat['pendiente'] = $p; deckeva_wa_anotar($chat, $p['id'] . ' no sale · alguien le contestó antes'); }
            $chats[$num] = $chat; continue;
        }
        if ($ahora - $ultIn > DECKEVA_WA_VENCE) {
            if ($activo) { $p['estado'] = 'vencido'; $chat['pendiente'] = $p; deckeva_wa_anotar($chat, $p['id'] . ' vencido · más de 23 h'); }
            $chats[$num] = $chat; continue;
        }
        if ($activo && (int) $p['para_ts'] < $ultIn) {
            $p['estado'] = 'reemplazado'; deckeva_wa_anotar($chat, $p['id'] . ' reemplazado · el cliente volvió a escribir'); $activo = false;
        }

        // ¿Hay que redactar?
        if (!is_array($p) || (int) $p['para_ts'] < $ultIn) {
            if ($ahora - $ultIn < DECKEVA_WA_SILENCIO) { $chats[$num] = $chat; continue; }
            $r = deckeva_wa_redactar((array) $chat['mensajes']);
            if (!$r['ok']) { deckeva_wa_anotar($chat, 'no se pudo redactar · ' . $r['error']); $chats[$num] = $chat; continue; }
            $id = 'D-' . strtoupper(substr(base_convert(substr(hash('sha256', $num . '|' . $ultIn), 0, 10), 16, 36), 0, 4));
            if (!$r['responder'] || $r['texto'] === '') {
                $chat['pendiente'] = array('id' => $id, 'para_ts' => $ultIn, 'estado' => 'sin_respuesta', 'motivo' => $r['motivo']);
                deckeva_wa_anotar($chat, 'no hace falta contestar · ' . $r['motivo']);
                $chats[$num] = $chat; continue;
            }
            $regla = deckeva_wa_validar($r['texto']);
            $auto = deckeva_wa_modo() === 'automatico' && !$r['necesita_humano'] && $regla === '';
            $semilla = $num . '|' . $ultIn;
            $p = array(
                'id' => $id, 'para_ts' => $ultIn, 'texto' => $r['texto'],
                'en' => deckeva_wa_en_horario($ultIn + deckeva_wa_demora($semilla), $semilla),
                'estado' => $auto ? 'aprobado' : 'borrador', 'necesita_humano' => $r['necesita_humano'],
                'motivo' => $r['motivo'], 'regla' => $regla,
            );
            if ($auto) $p['aprobado_por'] = 'automático';
            $chat['pendiente'] = $p;
            deckeva_wa_anotar($chat, $id . ' redactado · ' . ($auto ? 'sale solo ' . deckeva_wa_legible($p['en']) : 'espera a JP'));
            if (!$auto) deckeva_wa_avisar_jp($chat);
        }

        // A su hora, mandar lo aprobado por la puerta de tourevo.cl.
        if (($p['estado'] ?? '') === 'aprobado' && (int) $p['para_ts'] === $ultIn && $ahora >= (int) $p['en'] && deckeva_wa_habil($ahora)) {
            $w = deckeva_wa_mandar($num, (string) $p['texto'], (string) $p['id'], (string) ($p['aprobado_por'] ?? 'JP'));
            $p['estado'] = $w['ok'] ? 'enviado' : 'error';
            if (!$w['ok']) $p['error'] = $w['error'];
            $p['enviado_ts'] = $ahora;
            $chat['pendiente'] = $p;
            deckeva_wa_anotar($chat, $p['id'] . ($w['ok'] ? ' entregado a la puerta · sale en el próximo minuto' : ' NO salió · ' . $w['error']));
        }
        $chats[$num] = $chat;
    }
    deckeva_wa_guardar($chats);
}

// =============================================
// CLAUDE · redacta, no decide
// =============================================

function deckeva_wa_sistema() {
    return "Contestas el WhatsApp de Deckeva, en Chile. Te paso la conversación con un cliente y redactas UNA respuesta a lo último que escribió.\n\n"
        . "Lo que sabes de Deckeva:\n"
        . "- Fabrica pisos de goma EVA antideslizante a medida para lanchas, veleros, motos de agua y embarcaciones. Sitio: deckeva.cl, con cotizador en la web. Correo: contacto@deckeva.cl.\n"
        . "- Para cotizar un piso hace falta: marca, modelo, año y largo en pies de la embarcación, el color o diseño que quiere, dónde está la embarcación (ciudad o marina), y el nombre y el email del cliente.\n"
        . "- La toma de medidas y la instalación se cobran aparte y su valor depende de dónde esté la embarcación; van detalladas en la cotización.\n"
        . "- También hace remodelación y reacondicionamiento de lanchas en Santiago (pisos, tapicería, pintura) y servicio técnico eléctrico náutico.\n"
        . "- La cotización formal llega por correo, en PDF. También la puede sacar solo en el cotizador de deckeva.cl.\n\n"
        . "Cómo se escribe:\n"
        . "- En el idioma del cliente. En castellano, chileno y con tú: tienes, puedes, cuéntame. Nunca vos, tenés, podés.\n"
        . "- Corto, como desde el celular: una a tres frases. Sin listas, sin guiones largos (— o –), a lo más un emoji.\n"
        . "- Nunca escribas un precio ni un importe. Si pregunta cuánto cuesta, dile que le mandas la cotización por correo y pide lo que falte.\n"
        . "- No inventes. Plazos, stock, fechas de instalación, fotos, formas de pago, un cambio, un reclamo o un pago: responde que lo revisas y le confirmas, y marca necesita_humano.\n"
        . "- No saludes de nuevo si ya se saludaron. No repitas lo ya dicho.\n"
        . "- Si lo último no necesita respuesta (un gracias, un ok), responder = false y texto vacío.\n"
        . "- motivo: una línea para el equipo, no para el cliente.";
}

function deckeva_wa_redactar($mensajes) {
    $tz = new DateTimeZone('America/Santiago');
    $txt = '';
    foreach ($mensajes as $m) {
        $t = trim((string) $m['texto']);
        if ($t === '') continue;
        $txt .= '[' . (new DateTimeImmutable('@' . (int) $m['ts']))->setTimezone($tz)->format('Y-m-d H:i') . '] ' . ($m['dir'] === 'in' ? 'Cliente' : 'Deckeva') . ': ' . $t . "\n";
    }
    if ($txt === '') return array('ok' => false, 'error' => 'chat sin texto');
    $esquema = array('type' => 'object', 'additionalProperties' => false,
        'required' => array('responder', 'texto', 'necesita_humano', 'motivo'),
        'properties' => array('responder' => array('type' => 'boolean'), 'texto' => array('type' => 'string'), 'necesita_humano' => array('type' => 'boolean'), 'motivo' => array('type' => 'string')));
    $res = wp_remote_post('https://api.anthropic.com/v1/messages', array(
        'timeout' => 60,
        'headers' => array('x-api-key' => deckeva_wa_llave(), 'anthropic-version' => '2023-06-01', 'anthropic-beta' => 'server-side-fallback-2026-07-01', 'content-type' => 'application/json'),
        'body' => wp_json_encode(array(
            'model' => DECKEVA_WA_MODELO, 'max_tokens' => 2000, 'fallbacks' => 'default',
            'output_config' => array('effort' => 'low', 'format' => array('type' => 'json_schema', 'schema' => $esquema)),
            'system' => deckeva_wa_sistema(),
            'messages' => array(array('role' => 'user', 'content' => "<conversacion>\n" . $txt . '</conversacion>')),
        )),
    ));
    if (is_wp_error($res)) return array('ok' => false, 'error' => $res->get_error_message());
    $j = json_decode((string) wp_remote_retrieve_body($res), true);
    if ((int) wp_remote_retrieve_response_code($res) !== 200 || !is_array($j)) return array('ok' => false, 'error' => 'Claude HTTP ' . (int) wp_remote_retrieve_response_code($res));
    if (in_array($j['stop_reason'] ?? '', array('refusal', 'max_tokens'), true)) return array('ok' => false, 'error' => (string) $j['stop_reason']);
    $out = '';
    foreach ((array) ($j['content'] ?? array()) as $b) if (($b['type'] ?? '') === 'text') $out .= (string) $b['text'];
    $d = json_decode($out, true);
    if (!is_array($d)) return array('ok' => false, 'error' => 'respuesta no es JSON');
    return array('ok' => true, 'responder' => !empty($d['responder']), 'texto' => trim((string) ($d['texto'] ?? '')), 'necesita_humano' => !empty($d['necesita_humano']), 'motivo' => trim((string) ($d['motivo'] ?? '')));
}

// =============================================
// SALIDA · por la puerta de tourevo.cl, que tiene el número
// =============================================

function deckeva_wa_mandar($num, $texto, $ref, $aprobo) {
    $v = deckeva_wa_validar($texto);
    if ($v !== '') return array('ok' => false, 'error' => 'el texto no pasa las reglas · ' . $v);
    $cuerpo = wp_json_encode(array('para' => (string) $num, 'texto' => $texto, 'ref' => $ref, 'aprobo' => $aprobo));
    $ts = time();
    $res = wp_remote_post(DECKEVA_WA_PUERTA_SALIDA, array('timeout' => 20, 'headers' => array(
        'Content-Type' => 'application/json', 'X-Puerta-Ts' => (string) $ts, 'X-Puerta-Firma' => deckeva_wa_firmar($cuerpo, $ts),
    ), 'body' => $cuerpo));
    if (is_wp_error($res)) return array('ok' => false, 'error' => $res->get_error_message());
    $code = (int) wp_remote_retrieve_response_code($res);
    return $code === 200 ? array('ok' => true) : array('ok' => false, 'error' => 'puerta HTTP ' . $code . ' ' . substr((string) wp_remote_retrieve_body($res), 0, 120));
}

function deckeva_wa_avisar_jp($chat) {
    $p = $chat['pendiente'];
    $lnk = admin_url('options-general.php?page=deckeva-whatsapp');
    $chatH = '';
    foreach (array_slice((array) $chat['mensajes'], -6) as $m) {
        $chatH .= '<p style="margin:4px 0"><span style="color:#666">' . ($m['dir'] === 'in' ? 'Cliente' : 'Deckeva') . ' ' . esc_html(deckeva_wa_legible($m['ts'])) . ' ·</span> ' . nl2br(esc_html($m['texto'])) . '</p>';
    }
    $avisos = '';
    if (!empty($p['necesita_humano'])) $avisos .= '<p style="color:#b45309">Necesita que lo mires: ' . esc_html($p['motivo']) . '</p>';
    if (!empty($p['regla'])) $avisos .= '<p style="color:#b45309">No pasa las reglas (' . esc_html($p['regla']) . '): corrígelo antes de aprobar.</p>';
    $html = '<div style="font-family:Arial,sans-serif;font-size:14px;color:#111">'
        . '<p>Borrador de respuesta al WhatsApp de +' . esc_html($chat['numero']) . ' · Deckeva.</p>' . $chatH
        . '<p style="margin-top:14px"><b>Respuesta propuesta</b></p><p style="background:#eef6fb;padding:10px;border-radius:6px">' . nl2br(esc_html($p['texto'])) . '</p>'
        . $avisos . '<p>Sale ' . esc_html(deckeva_wa_legible($p['en'])) . ' si la apruebas antes.</p>'
        . '<p><a href="' . esc_url($lnk) . '" style="background:#0e6ba8;color:#fff;padding:9px 16px;border-radius:6px;text-decoration:none">Revisar, corregir o aprobar</a></p></div>';
    wp_mail(deckeva_wa_aprobador(), (($avisos !== '') ? '⚠ ' : '') . 'Respuesta ' . $p['id'] . ' · Deckeva · +' . $chat['numero'], $html, deckeva_mail_headers());
}

// =============================================
// WP-ADMIN · Ajustes → WhatsApp Deckeva
// =============================================

add_action('admin_menu', function () {
    add_options_page('WhatsApp Deckeva', 'WhatsApp Deckeva', 'manage_options', 'deckeva-whatsapp', 'deckeva_wa_pantalla');
});

add_action('admin_post_deckeva_wa', function () {
    if (!current_user_can('manage_options')) wp_die('No autorizado');
    check_admin_referer('deckeva_wa');
    $accion = sanitize_key($_POST['accion'] ?? '');
    $msg = '';
    if ($accion === 'config') {
        foreach (array('secreto', 'anthropic_key') as $k) {
            $v = trim((string) wp_unslash($_POST[$k] ?? ''));
            if ($v !== '') update_option('deckeva_wa_' . $k, $v, false);
        }
        update_option('deckeva_wa_modo', ($_POST['modo'] ?? '') === 'automatico' ? 'automatico' : 'borrador', false);
        $a = sanitize_email(wp_unslash($_POST['aprobador'] ?? ''));
        if ($a !== '') update_option('deckeva_wa_aprobador', $a, false);
        $msg = 'Guardado.';
    } else {
        $num = preg_replace('/\D+/', '', (string) ($_POST['numero'] ?? ''));
        $chats = deckeva_wa_chats();
        $chat = $chats[$num] ?? null;
        $p = is_array($chat) ? ($chat['pendiente'] ?? null) : null;
        if (!is_array($p) || ($p['estado'] ?? '') !== 'borrador') {
            $msg = 'Ese borrador ya no está esperando.';
        } elseif ($accion === 'descartar') {
            $p['estado'] = 'descartado'; $chat['pendiente'] = $p; deckeva_wa_anotar($chat, $p['id'] . ' descartado'); $msg = 'Descartado · no sale nada.';
        } elseif ($accion === 'aprobar') {
            $texto = trim((string) wp_unslash($_POST['texto'] ?? ''));
            $v = deckeva_wa_validar($texto);
            if ($v !== '') {
                $msg = 'No se aprobó: ' . $v . '.';
            } else {
                $p['texto'] = $texto; $p['estado'] = 'aprobado'; $p['aprobado_por'] = 'JP · wp-admin';
                $chat['pendiente'] = $p; deckeva_wa_anotar($chat, $p['id'] . ' aprobado · sale ' . deckeva_wa_legible(max((int) $p['en'], time())));
                $msg = 'Aprobado · sale ' . deckeva_wa_legible(max((int) $p['en'], time())) . '.';
            }
        }
        if (is_array($chat)) { $chats[$num] = $chat; deckeva_wa_guardar($chats); }
    }
    wp_safe_redirect(add_query_arg('msg', rawurlencode($msg), admin_url('options-general.php?page=deckeva-whatsapp')));
    exit;
});

function deckeva_wa_pantalla() {
    if (!current_user_can('manage_options')) return;
    $chats = deckeva_wa_chats();
    $listo = deckeva_wa_llave() !== '' && strlen(deckeva_wa_secreto()) >= 24;
    echo '<div class="wrap"><h1>WhatsApp Deckeva</h1>';
    if (!empty($_GET['msg'])) echo '<div class="notice notice-info"><p>' . esc_html(wp_unslash($_GET['msg'])) . '</p></div>';
    echo '<p>Los chats de Deckeva que llegan al +56 9 4021 1459. Se contestan entre 1 y 40 minutos después del mensaje del cliente, de 8:00 a 20:00. '
        . (deckeva_wa_modo() === 'automatico' ? '<b>Modo automático</b>: salen solos; lo que necesita una persona te espera acá.' : '<b>Modo borrador</b>: ninguno sale sin que lo apruebes.') . '</p>';
    if (!$listo) echo '<div class="notice notice-warning"><p>Falta la llave de Claude o el secreto de la puerta: no se procesa ningún chat.</p></div>';

    foreach ($chats as $num => $chat) {
        $p = $chat['pendiente'] ?? null;
        if (!is_array($p) || ($p['estado'] ?? '') !== 'borrador') continue;
        echo '<div class="card" style="max-width:780px"><h2>+' . esc_html($num) . ' · ' . esc_html($p['id']) . '</h2>';
        foreach (array_slice((array) $chat['mensajes'], -6) as $m) {
            echo '<p style="margin:4px 0"><span style="color:#666">' . ($m['dir'] === 'in' ? 'Cliente' : 'Deckeva') . ' ' . esc_html(deckeva_wa_legible($m['ts'])) . ':</span> ' . esc_html($m['texto']) . '</p>';
        }
        if (!empty($p['necesita_humano'])) echo '<p style="color:#b45309">Necesita que lo mires: ' . esc_html($p['motivo']) . '</p>';
        if (!empty($p['regla'])) echo '<p style="color:#b45309">No pasa las reglas: ' . esc_html($p['regla']) . '</p>';
        echo '<form method="post" action="' . esc_url(admin_url('admin-post.php')) . '">';
        wp_nonce_field('deckeva_wa');
        echo '<input type="hidden" name="action" value="deckeva_wa"><input type="hidden" name="numero" value="' . esc_attr($num) . '">'
            . '<textarea name="texto" rows="4" style="width:100%">' . esc_textarea($p['texto']) . '</textarea>'
            . '<p><button class="button button-primary" name="accion" value="aprobar">Aprobar · sale ' . esc_html(deckeva_wa_legible(max((int) $p['en'], time()))) . '</button> '
            . '<button class="button" name="accion" value="descartar">Descartar</button></p></form></div>';
    }

    echo '<h2>Últimos movimientos</h2><table class="widefat striped"><tbody>';
    foreach (array_slice($chats, 0, 30, true) as $num => $chat) {
        $p = $chat['pendiente'] ?? array();
        $h = end($chat['historial']) ?: array('ts' => 0, 'que' => '');
        echo '<tr><td>+' . esc_html($num) . '</td><td>' . esc_html($p['estado'] ?? 'nuevo') . '</td><td>' . esc_html($h['que']) . '</td><td>' . esc_html($h['ts'] ? deckeva_wa_legible($h['ts']) : '') . '</td></tr>';
    }
    echo '</tbody></table>';

    echo '<h2>Configuración</h2><form method="post" action="' . esc_url(admin_url('admin-post.php')) . '">';
    wp_nonce_field('deckeva_wa');
    echo '<input type="hidden" name="action" value="deckeva_wa"><input type="hidden" name="accion" value="config"><table class="form-table">'
        . '<tr><th>Secreto de la puerta</th><td><input type="password" name="secreto" class="regular-text" autocomplete="off" placeholder="' . (deckeva_wa_secreto() !== '' ? 'cargado · déjalo vacío para no cambiarlo' : '') . '"><p class="description">El mismo valor que el secret PUERTA_DECKEVA_SECRETO del repo de Tourevo.</p></td></tr>'
        . '<tr><th>Llave de Claude</th><td><input type="password" name="anthropic_key" class="regular-text" autocomplete="off" placeholder="' . (deckeva_wa_llave() !== '' ? 'cargada · déjala vacía para no cambiarla' : '') . '"></td></tr>'
        . '<tr><th>Modo</th><td><select name="modo"><option value="borrador"' . selected(deckeva_wa_modo(), 'borrador', false) . '>Borrador · nada sale sin aprobación</option><option value="automatico"' . selected(deckeva_wa_modo(), 'automatico', false) . '>Automático</option></select></td></tr>'
        . '<tr><th>Aprueba</th><td><input type="email" name="aprobador" class="regular-text" value="' . esc_attr(deckeva_wa_aprobador()) . '"></td></tr>'
        . '</table><p><button class="button button-primary">Guardar</button></p></form></div>';
}
