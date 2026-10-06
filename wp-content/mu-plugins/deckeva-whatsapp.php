<?php
/**
 * Plugin Name: Deckeva - Respuestas por WhatsApp
 * Description: Contesta el WhatsApp de Deckeva con demora (5 a 40 minutos, 8:00 a 20:00) y con la aprobación de JP.
 * Version: 1.0.0
 * Author: Deckeva
 *
 * ── POR QUÉ EXISTE ───────────────────────────────────────────────────────
 *
 * El +56 9 4021 1459 atiende a Tourevo, Deckeva e Imporlan, y cada negocio se
 * atiende y se cotiza desde su propio sistema (JP, 28-sep-2026). La IA de Meta
 * contesta al instante y no se puede demorar, y la regla es que a un cliente
 * nunca se le contesta al instante: se espera 5, 7, 9, 12, 15, 25 o 40 minutos (nunca menos de 5).
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
 * - Nunca un precio escrito en el chat: la cotización formal va en PDF, por
 *   WhatsApp (como documento) y por correo.
 * - Un texto con importe, guion largo o voseo no sale nunca, ni en automático.
 * - Si alguien le contestó al cliente después de su mensaje, lo nuestro no sale.
 * - Pasadas 23 horas no sale: Meta sólo acepta texto libre dentro de 24 h.
 *
 * Sin la llave de Claude y el secreto de la puerta no hace nada.
 */

if (!defined('ABSPATH')) exit;

const DECKEVA_WA_PUERTA_SALIDA = 'https://tourevo.cl/api/whatsapp-puerta.php?negocio=deckeva';
const DECKEVA_WA_ESPERAS = array(5, 7, 9, 12, 15, 25, 40); // nunca menos de 5 min (JP, 29-sep)
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
/**
 * Borrador o automático.
 *
 * Por defecto AUTOMÁTICO desde el 6-oct-2026 (JP): «pon a Deckeva en modo
 * automático, y lo que no sepa responder que me lo pregunte por WhatsApp».
 * Lo que la IA no sabe sigue pasando por él: `necesita_humano`, lo que suena
 * a robot y lo que no pasa las reglas quedan en borrador y se le piden por
 * WhatsApp con su código D-XXXX. Automático no es «sale cualquier cosa»: es
 * «lo que ya sabe contestar no te espera».
 *
 * El selector de wp-admin sigue mandando: si JP elige «borrador», se guarda y
 * esto lee eso.
 */
function deckeva_wa_modo() { return deckeva_wa_opcion('modo', 'automatico') === 'borrador' ? 'borrador' : 'automatico'; }

/**
 * El cambio a automático, una sola vez.
 *
 * Cambiar el default no alcanza: el formulario de wp-admin guarda SIEMPRE la
 * clave `deckeva_wa_modo` al apretar «Guardar» (incluso si nadie tocó el
 * selector), así que en la base ya dice «borrador» y el default no se mira.
 * Esto lo pone en automático una vez y deja la marca; después el selector
 * vuelve a mandar y JP puede volver a borrador cuando quiera, sin que esto se
 * lo pise en la carga siguiente.
 */
add_action('init', function () {
    if (defined('DECKEVA_WA_MODO')) return;                       // una constante manda sobre todo
    if (get_option('deckeva_wa_auto_2026_10_06') === 'listo') return;
    update_option('deckeva_wa_auto_2026_10_06', 'listo', false);
    if (get_option('deckeva_wa_modo', '') !== 'automatico') update_option('deckeva_wa_modo', 'automatico', false);
});
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

/**
 * ¿El cliente pregunta por muelles flotantes? (JP, 29-sep · T-017) Es el
 * único producto que no se cotiza ni se le pone precio en el chat: se escala
 * a JP al tiro. Lista cerrada de palabras, sobre lo que escribió el cliente.
 *
 * Sólo mira el pedido vigente: los mensajes del cliente desde `$desde`, o si
 * no se da, las últimas 6 h antes de su último mensaje. Un muelle que pidió
 * la semana pasada no bloquea el piso que pide hoy.
 *
 * Y la ubicación no es un pedido: «está en el muelle flotante de Pucón» dice
 * dónde está la lancha. Esas frases se sacan antes de mirar.
 */
function deckeva_wa_es_muelle($mensajes, $desde = null) {
    $in = array();
    foreach ((array) $mensajes as $m) if (($m['dir'] ?? '') === 'in') $in[] = $m;
    if (!$in) return false;
    if ($desde === null) {
        $ult = 0;
        foreach ($in as $m) $ult = max($ult, (int) ($m['ts'] ?? 0));
        $desde = $ult - 6 * 3600;
    }
    foreach ($in as $m) {
        if ((int) ($m['ts'] ?? 0) < (int) $desde) continue;
        $t = (string) ($m['texto'] ?? '');
        // Dónde está la embarcación: «en el muelle…», «amarrada al muelle…», «at the dock».
        $t = preg_replace('/\b(en|al|del|desde|junto\s+al|amarrad[ao]s?\s+(en|a|al)|at|in|on)\s+(el|la|un|una|the|a|our|my)?\s*(floating\s+)?(muelles?|pantal[aá]n(es)?|embarcaderos?|marina|docks?)\b(\s+(flotantes?|modular(es)?|floating))?/iu', ' ', $t) ?? $t;
        if (preg_match('/\b(muelles?|pantal[aá]n(es)?|embarcaderos?)\s+(flotantes?|modular(es)?)\b|\bfloating\s+docks?\b/iu', $t)) return true;
        if (preg_match('/\b(cotiz\w*|precios?|valor(es)?|cu[aá]nto|compr\w*|quiero|necesito|venden|hacen|fabrican)\b[^.?!\n]{0,20}\bmuelles?\b/iu', $t)) return true;
    }
    return false;
}

/** Espera antes de contestar: 5 a 40 min, distinta por mensaje, sin patrón. */
function deckeva_wa_demora($semilla) {
    $h = hexdec(substr(hash('sha256', $semilla . '|espera'), 0, 8));
    $base = DECKEVA_WA_ESPERAS[$h % count(DECKEVA_WA_ESPERAS)] * 60;
    $extra = hexdec(substr(hash('sha256', $semilla . '|seg'), 0, 8)) % max(30, (int) ($base * 0.3));
    return min($base + $extra, 40 * 60); // la regla dice «hasta 40 minutos», y la variación no la pasa
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

function deckeva_wa_chats() {
    // Lectura fresca: otra petición pudo escribir recién (la caché de opciones no se entera).
    wp_cache_delete('deckeva_wa_chats', 'options');
    $c = get_option('deckeva_wa_chats', array());
    return is_array($c) ? $c : array();
}

/**
 * Toda escritura pasa por acá, con un candado corto: la entrada, el panel y la
 * pasada escriben la misma opción, y sin esto la última en guardar pisaba a
 * las otras (un mensaje nuevo o una aprobación desaparecían). Lo lento, la
 * llamada a Claude, queda FUERA del candado.
 */
function deckeva_wa_con_candado($cambio) {
    $dir = wp_upload_dir(null, false);
    $f = @fopen(trailingslashit($dir['basedir']) . '.deckeva-wa.lock', 'c');
    if ($f) flock($f, LOCK_EX);
    try {
        deckeva_wa_guardar($cambio(deckeva_wa_chats()));
    } finally {
        if ($f) { flock($f, LOCK_UN); fclose($f); }
    }
}

/** Lo que importa de un chat: si cambia entre leer y guardar, no se guarda. */
function deckeva_wa_huella($chat) {
    return md5(wp_json_encode(array($chat['mensajes'] ?? array(), $chat['pendiente'] ?? null)));
}
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
    if (!in_array($ruta, array('entrada', 'tick', 'aprobar'), true)) return;
    if (!defined('DONOTCACHEPAGE')) define('DONOTCACHEPAGE', true);
    nocache_headers();
    header('Content-Type: application/json; charset=UTF-8');

    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') { status_header(405); echo '{"ok":false}'; exit; }
    $raw = (string) file_get_contents('php://input');
    if (strlen($raw) > 262144 || !deckeva_wa_firma_valida($raw, $_SERVER['HTTP_X_PUERTA_FIRMA'] ?? '', $_SERVER['HTTP_X_PUERTA_TS'] ?? '')) {
        status_header(401); echo '{"ok":false,"error":"firma"}'; exit;
    }
    // Una firma sirve UNA vez: el tick ahora devuelve borradores con números y
    // mensajes, y un pedido capturado no se puede repetir dentro de los 5 min
    // en que su fecha todavía vale.
    if (!deckeva_wa_firma_nueva((string) ($_SERVER['HTTP_X_PUERTA_FIRMA'] ?? ''))) {
        status_header(409); echo '{"ok":false,"error":"repetido"}'; exit;
    }
    $datos = json_decode($raw, true);
    if (!is_array($datos)) { status_header(400); echo '{"ok":false}'; exit; }

    if ($ruta === 'entrada') {
        deckeva_wa_entrada($datos);
    } elseif ($ruta === 'aprobar') {
        // JP contestó «ok D-XXXX» (o «D-XXXX: texto») en el WhatsApp y Tourevo
        // lo trae acá. 409 = no se puede y no se va a poder: Tourevo no reintenta.
        $r = deckeva_wa_aprobar_remoto($datos);
        if (!$r['ok']) status_header(409);
        echo wp_json_encode($r);
        exit;
    } else {
        // Una pasada a la vez, durante TODA la pasada: un candado de archivo
        // que se suelta cuando termina, no un transient que vence a los N
        // minutos aunque la pasada siga (llamadas lentas a Claude).
        // Se contesta al tiro y la pasada sigue después: con varios chats
        // nuevos son minutos de Claude, Tourevo cuelga a los 20 s, y un
        // hosting que corta el script cuando el cliente se va dejaría la
        // pasada a medias.
        // De vuelta van los borradores que esperan a JP: Tourevo se los pide
        // por WhatsApp, en dos mensajes (JP, 29-sep).
        // Y queda anotado que Tourevo está pidiendo: mientras lo haga, las
        // aprobaciones le llegan a JP por WhatsApp y el correo no sale.
        update_option('deckeva_wa_tick_ts', time(), false);
        deckeva_wa_contestar_y_seguir(wp_json_encode(array('ok' => true, 'pendientes' => deckeva_wa_pendientes_para_jp())));
        $dir = wp_upload_dir(null, false);
        $lock = @fopen(trailingslashit($dir['basedir']) . '.deckeva-wa-pasada.lock', 'c');
        if (!$lock || !flock($lock, LOCK_EX | LOCK_NB)) exit;
        try { deckeva_wa_pasada(); } finally { flock($lock, LOCK_UN); fclose($lock); }
        exit;
    }
    echo '{"ok":true}';
    exit;
}, 1);

/** Manda la respuesta y cierra la conexión; el script sigue corriendo. */
function deckeva_wa_contestar_y_seguir($json) {
    ignore_user_abort(true);
    @set_time_limit(600);
    while (ob_get_level() > 0) @ob_end_clean();
    header('Content-Length: ' . strlen($json));
    header('Connection: close');
    echo $json;
    if (function_exists('litespeed_finish_request')) litespeed_finish_request();
    elseif (function_exists('fastcgi_finish_request')) fastcgi_finish_request();
    else flush();
}

/** Tourevo derivó un chat: se guarda tal cual llegó (el hilo manda). */
function deckeva_wa_entrada($d) {
    $num = preg_replace('/\D+/', '', (string) ($d['numero'] ?? ''));
    if (!preg_match('/^\d{8,15}$/', $num)) return;
    $msgs = array();
    foreach ((array) ($d['mensajes'] ?? array()) as $m) {
        $ts = (int) ($m['ts'] ?? 0);
        // Una hora en el futuro alargaría la ventana de 24 h: no se acepta.
        if ($ts <= 0 || $ts > time() + 300) continue;
        $msgs[] = array('ts' => $ts, 'dir' => ($m['dir'] ?? '') === 'in' ? 'in' : 'out', 'texto' => mb_substr((string) ($m['texto'] ?? ''), 0, 2000));
    }
    if (!$msgs) return;
    $ultimo = max(array_column($msgs, 'ts'));
    deckeva_wa_con_candado(function ($chats) use ($num, $msgs, $ultimo) {
        $chat = $chats[$num] ?? array('numero' => $num, 'pendiente' => null, 'historial' => array(), 'mensajes' => array());
        $antes = !empty($chat['mensajes']) ? max(array_column($chat['mensajes'], 'ts')) : 0;
        // Una foto más vieja que la que ya hay (entregas desordenadas) no pisa.
        if ($ultimo < $antes) return $chats;
        $chat['mensajes'] = array_slice($msgs, -80);
        $chat['actualizado'] = time();
        $chats[$num] = $chat;
        return $chats;
    });
}

// =============================================
// APROBAR DESDE EL WHATSAPP DE JP (29-sep-2026)
// =============================================

/** true la primera vez que se ve esta firma en los últimos 10 minutos. */
function deckeva_wa_firma_nueva($firma) {
    if ($firma === '') return false;
    $k = md5($firma);
    $vistas = get_option('deckeva_wa_firmas_vistas', array());
    if (!is_array($vistas)) $vistas = array();
    $ahora = time();
    foreach ($vistas as $h => $t) if ($ahora - (int) $t > 600) unset($vistas[$h]);
    if (isset($vistas[$k])) return false;
    $vistas[$k] = $ahora;
    update_option('deckeva_wa_firmas_vistas', $vistas, false);
    return true;
}

/**
 * ¿Este borrador todavía puede salir? Lo mismo que decide la pasada, mirado
 * AHORA: si el cliente volvió a escribir, si alguien ya le contestó o si
 * pasaron 23 h, aprobarlo no mandaría nada. Se mira al listarlo y al aprobarlo,
 * porque la entrada guarda mensajes nuevos antes de que la pasada lo marque.
 */
function deckeva_wa_borrador_vigente($chat) {
    $p = $chat['pendiente'] ?? null;
    if (!is_array($p) || ($p['estado'] ?? '') !== 'borrador' || empty($p['id'])) return false;
    $ultIn = 0; $ultOut = 0;
    foreach ((array) ($chat['mensajes'] ?? array()) as $m) {
        if (($m['dir'] ?? '') === 'in') $ultIn = max($ultIn, (int) $m['ts']); else $ultOut = max($ultOut, (int) $m['ts']);
    }
    return $ultIn > 0 && (int) ($p['para_ts'] ?? 0) === $ultIn && $ultOut < $ultIn && time() - $ultIn <= DECKEVA_WA_VENCE;
}

/**
 * «¿Estas solicitudes me pueden llegar a mi WhatsApp para aprobar desde el
 * WhatsApp?» (JP). El borrador sigue viviendo acá; Tourevo, que tiene el
 * número, se lo pide a JP en dos mensajes (el detalle y «ok D-XXXX») y
 * trae su respuesta por la ruta `aprobar`. Mientras Tourevo pida (el tick
 * de los últimos 15 min) el correo no sale: JP lo pidió por WhatsApp y no en
 * los dos lados (30-sep). Si Tourevo deja de pedir, vuelve el correo.
 */
function deckeva_wa_pendientes_para_jp() {
    $out = array();
    $entregados = array(); // número → id que Tourevo se lleva: su correo diferido ya no hace falta
    foreach (deckeva_wa_chats() as $num => $chat) {
        $p = $chat['pendiente'] ?? null;
        // Lo escalado («lo ves tú») también le llega por WhatsApp, sin texto
        // propuesto, durante el día en que el cliente escribió.
        $escalado = deckeva_wa_escalado_vigente($chat);
        if (!$escalado && !deckeva_wa_borrador_vigente($chat)) continue;
        if (!empty($p['correo_diferido'])) $entregados[$num] = (string) $p['id'];
        $cliente = '';
        foreach ((array) ($chat['mensajes'] ?? array()) as $m) if (($m['dir'] ?? '') === 'in' && trim((string) $m['texto']) !== '') $cliente = (string) $m['texto'];
        $out[] = array(
            'id' => (string) $p['id'], 'numero' => (string) $num,
            'texto' => $escalado ? '' : mb_substr((string) ($p['texto'] ?? ''), 0, 1000) . (($p['valores'] ?? '') !== '' ? "\n\n[va con la captura del cotizador para " . $p['valores'] . ']' : ''), 'cliente' => mb_substr($cliente, 0, 300),
            'idioma' => deckeva_wa_es_castellano((string) ($p['texto'] ?? '')) ? 'es' : 'otro',
            'en' => (int) ($p['en'] ?? 0), 'regla' => (string) ($p['regla'] ?? ''),
            'necesita_humano' => !empty($p['necesita_humano']), 'motivo' => (string) ($p['motivo'] ?? ''),
            'para_ts' => (int) $p['para_ts'],
        );
    }
    // Los más nuevos primero y un tope holgado: un borrador viejo sin aprobar
    // no le quita el lugar a uno recién redactado.
    usort($out, function ($a, $b) { return $b['para_ts'] <=> $a['para_ts']; });
    $out = array_slice($out, 0, 40);
    $enLista = array();
    foreach ($out as $x) $enLista[$x['numero']] = $x['id'];
    $entregados = array_intersect_assoc($entregados, $enLista);
    if ($entregados) {
        // Tourevo los recibe en esta respuesta y, si WhatsApp no le llega a JP,
        // manda él el correo de respaldo.
        deckeva_wa_con_candado(function ($chats) use ($entregados) {
            foreach ($entregados as $n => $id) {
                if ((string) ($chats[$n]['pendiente']['id'] ?? '') === $id) unset($chats[$n]['pendiente']['correo_diferido']);
            }
            return $chats;
        });
    }
    return $out;
}

/** Un «lo ves tú» que todavía nadie atendió: es de su último mensaje, nadie le escribió después, y es de hoy. */
function deckeva_wa_escalado_vigente($chat) {
    $p = $chat['pendiente'] ?? null;
    if (!is_array($p) || ($p['estado'] ?? '') !== 'escalado' || empty($p['id'])) return false;
    $ultIn = 0; $ultOut = 0;
    foreach ((array) ($chat['mensajes'] ?? array()) as $m) {
        if (($m['dir'] ?? '') === 'in') $ultIn = max($ultIn, (int) $m['ts']); else $ultOut = max($ultOut, (int) $m['ts']);
    }
    return $ultIn > 0 && (int) ($p['para_ts'] ?? 0) === $ultIn && $ultOut < $ultIn && time() - $ultIn <= DAY_IN_SECONDS;
}

/**
 * El respaldo del correo diferido. La pasada sólo corre cuando Tourevo pide,
 * así que si Tourevo deja de pedir justo después de crear un borrador, nadie
 * más lo avisaría: esto corre en cualquier visita al sitio (a lo más cada 5
 * min) y, con el tick de Tourevo parado hace 15 min, manda el correo de lo
 * que Tourevo nunca se llevó.
 */
function deckeva_wa_correos_diferidos() {
    if (time() - (int) get_option('deckeva_wa_tick_ts', 0) < 15 * MINUTE_IN_SECONDS) return;
    if (get_transient('deckeva_wa_diferidos')) return;
    set_transient('deckeva_wa_diferidos', 1, 5 * MINUTE_IN_SECONDS);
    $hay = false;
    foreach (deckeva_wa_chats() as $c) if (!empty($c['pendiente']['correo_diferido'])) { $hay = true; break; }
    if (!$hay) return;
    $mandar = array();
    deckeva_wa_con_candado(function ($chats) use (&$mandar) {
        foreach ($chats as $n => $c) {
            if (empty($c['pendiente']['correo_diferido'])) continue;
            unset($chats[$n]['pendiente']['correo_diferido']);
            if (deckeva_wa_borrador_vigente($c) || deckeva_wa_escalado_vigente($c)) $mandar[] = $chats[$n];
        }
        return $chats;
    });
    foreach ($mandar as $c) {
        if (($c['pendiente']['estado'] ?? '') === 'escalado') deckeva_wa_avisar_escalado($c); else deckeva_wa_avisar_jp($c);
    }
}
add_action('init', 'deckeva_wa_correos_diferidos', 20);

/**
 * ¿La propuesta está en castellano? JP no quiere otros idiomas en su WhatsApp:
 * lo que no lo parezca se le muestra sin texto y sin «ok», para verlo acá.
 */
function deckeva_wa_es_castellano($t) {
    // Se cuentan palabras de los dos lados sobre la respuesta entera: un nombre
    // propio con tilde no vuelve castellano un texto en inglés. Sin pistas
    // suficientes NO es castellano: se ve en wp-admin, no en el WhatsApp de JP.
    $t = ' ' . preg_replace('/[^\p{L}]+/u', ' ', mb_strtolower($t)) . ' ';
    $es = preg_match_all('/\s(el|la|los|las|de|del|que|para|con|tu|te|tus|un|una|y|es|está|son|piso|lancha|cotización|gracias|hola|perfecto|entonces|claro|listo|ya|bien|sí|por|favor|envío|te|mando|queda|todo|tengo|muy)(?=\s)/u', $t);
    $en = preg_match_all('/\s(the|and|you|your|for|with|is|are|to|of|boat|thanks|hello|hi|i|can|will|sure|check|tomorrow|please|we|it|this|that|then|perfect|send|quote)(?=\s)/u', $t);
    return $es >= 2 && $es > $en;
}

/** Lo aprueba Tourevo en nombre de JP: mismas reglas que el botón de wp-admin. */
function deckeva_wa_aprobar_remoto($d) {
    $num = preg_replace('/\D+/', '', (string) ($d['numero'] ?? ''));
    $id = preg_replace('/[^A-Z0-9-]/', '', strtoupper((string) ($d['id'] ?? '')));
    $texto = isset($d['texto']) && $d['texto'] !== null ? trim((string) $d['texto']) : '';
    $quien = mb_substr(trim((string) ($d['quien'] ?? 'JP · WhatsApp')), 0, 60);
    $res = array('ok' => false, 'error' => 'no hay un borrador ' . $id . ' esperando');
    deckeva_wa_con_candado(function ($chats) use ($num, $id, $texto, $quien, &$res) {
        $chat = $chats[$num] ?? null;
        $p = is_array($chat) ? ($chat['pendiente'] ?? null) : null;
        if (!is_array($p) || ($p['id'] ?? '') !== $id) return $chats;
        if (!deckeva_wa_borrador_vigente($chat)) { $res = array('ok' => false, 'error' => $id . ' ya no puede salir (el cliente volvió a escribir, ya le contestaron o pasaron 23 h)'); return $chats; }
        $t = $texto !== '' ? $texto : (string) ($p['texto'] ?? '');
        $v = deckeva_wa_validar($t);
        if ($v !== '') { $res = array('ok' => false, 'error' => 'no pasa las reglas · ' . $v); return $chats; }
        // Si JP lo reescribió, su texto es la respuesta correcta a un caso
        // real: queda para el prompt de las próximas (deckeva_wa_aprender).
        if ($texto !== '') deckeva_wa_aprender($chat, (string) ($p['texto'] ?? ''), $texto);
        $p['texto'] = $t; $p['estado'] = 'aprobado'; $p['aprobado_por'] = $quien;
        deckeva_wa_anotar($chat, $id . ' aprobado por WhatsApp' . ($texto !== '' ? ' con el texto de JP · aprendido' : ''));
        $chat['pendiente'] = $p;
        $chats[$num] = $chat;
        $res = array('ok' => true, 'en' => max((int) $p['en'], time()));
        return $chats;
    });
    return $res;
}

// =============================================
// LA PASADA
// =============================================

function deckeva_wa_pasada() {
    if (deckeva_wa_llave() === '' || strlen(deckeva_wa_secreto()) < 24) return;
    // Tope de trabajo por pasada: a lo más 5 llamadas a Claude. Lo que quede
    // lo toma la pasada del minuto siguiente; así una pasada nunca se estira.
    $GLOBALS['deckeva_wa_redacciones'] = 0;
    foreach (array_keys(deckeva_wa_chats()) as $num) {
        deckeva_wa_un_chat((string) $num); // un número como clave de array PHP lo vuelve entero
    }
    // La cotización formal en PDF (deckeva-whatsapp-cotiza.php).
    if (function_exists('deckeva_wa_cotiza_pasada')) deckeva_wa_cotiza_pasada();
}

/**
 * Un chat: se lee, se decide (Claude, si toca, FUERA del candado) y se guarda
 * sólo si nadie lo tocó mientras tanto. Si entró un mensaje o JP aprobó en el
 * medio, no se guarda nada y la próxima pasada lo mira con lo nuevo.
 */
function deckeva_wa_un_chat($num) {
    $ahora = time();
    $chats = deckeva_wa_chats();
    if (!isset($chats[$num])) return;
    $chat = $chats[$num];
    $original = $chat;
    $huella = deckeva_wa_huella($chat);
    $salida = null;
    $avisar = false;
    $escalar = false;
    do {
            $ultIn = 0; $ultOut = 0;
            foreach ((array) ($chat['mensajes'] ?? array()) as $m) {
                if ($m['dir'] === 'in') $ultIn = max($ultIn, (int) $m['ts']); else $ultOut = max($ultOut, (int) $m['ts']);
            }
            $p = $chat['pendiente'] ?? null;
            $activo = is_array($p) && in_array($p['estado'] ?? '', array('borrador', 'aprobado'), true);

            if ($ultIn === 0) break;
            if ($ultOut >= $ultIn) {
                if ($activo) { $p['estado'] = 'superado'; $chat['pendiente'] = $p; deckeva_wa_anotar($chat, $p['id'] . ' no sale · alguien le contestó antes'); }
                break;
            }
            if ($ahora - $ultIn > DECKEVA_WA_VENCE) {
                if ($activo) { $p['estado'] = 'vencido'; $chat['pendiente'] = $p; deckeva_wa_anotar($chat, $p['id'] . ' vencido · más de 23 h'); }
                break;
            }
            if ($activo && (int) $p['para_ts'] < $ultIn) {
                $p['estado'] = 'reemplazado'; deckeva_wa_anotar($chat, $p['id'] . ' reemplazado · el cliente volvió a escribir'); $activo = false;
            }

            // ¿Hay que redactar?
            if (!is_array($p) || (int) $p['para_ts'] < $ultIn) {
                if ($ahora - $ultIn < DECKEVA_WA_SILENCIO) break;
                if (($GLOBALS['deckeva_wa_redacciones'] ?? 0) >= 5) break;
                $GLOBALS['deckeva_wa_redacciones'] = ($GLOBALS['deckeva_wa_redacciones'] ?? 0) + 1;
                $id = 'D-' . strtoupper(substr(base_convert(substr(hash('sha256', $num . '|' . $ultIn), 0, 10), 16, 36), 0, 4));
                // Pregunta si es un bot, o mandó un audio: lo contesta JP, siempre.
                // Se sabe mirando el chat, sin la IA: se decide ANTES de redactar,
                // para que ni una caída de la API ni un «no hace falta contestar»
                // lo archiven callado (Codex, tourevo-cl#1698 y deckeva#157).
                $persona = '';
                $ultimoIn = '';
                foreach ((array) ($chat['mensajes'] ?? array()) as $m) if (($m['dir'] ?? '') === 'in') $ultimoIn = (string) ($m['texto'] ?? '');
                if (deckeva_wa_pregunta_si_es_bot($chat['mensajes'] ?? array())) $persona = 'pregunta si habla con un bot · lo contestas tú';
                elseif (strpos($ultimoIn, '[mandó un audio]') === 0) $persona = 'mandó un audio · escúchalo tú';
                $r = deckeva_wa_redactar((array) $chat['mensajes'], deckeva_wa_nota_chat($chat));
                if (!$r['ok']) {
                    deckeva_wa_anotar($chat, 'no se pudo redactar · ' . $r['error']);
                    if ($persona === '') break;
                    $r = array('ok' => true, 'responder' => false, 'texto' => '', 'necesita_humano' => false, 'motivo' => 'no se pudo redactar');
                }
                // Lo que el que redacta marcó por su cuenta sin escribir nada es un
                // cliente que no quiere que le escriban (molesto, «no me manden la
                // cotización»): eso retiene la cotización aunque además pregunte si
                // es un bot.
                $optOut = !empty($r['necesita_humano']) && (!$r['responder'] || $r['texto'] === '');
                if ($persona !== '') { $r['necesita_humano'] = true; $r['motivo'] = $persona . ($r['motivo'] !== '' ? ' · ' . $r['motivo'] : ''); }
                if ($persona !== '' && (!$r['responder'] || $r['texto'] === '')) {
                    $chat['pendiente'] = array('id' => $id, 'para_ts' => $ultIn, 'estado' => 'escalado', 'necesita_humano' => true, 'motivo' => $r['motivo']);
                    if ($optOut) $chat['no_cotizar'] = array('ts' => $ahora, 'motivo' => $r['motivo']);
                    deckeva_wa_anotar($chat, $id . ' no se le escribe · lo ve JP · ' . $r['motivo']);
                    $escalar = true;
                    break;
                }
                if (!$r['responder'] || $r['texto'] === '') {
                    // No se le escribe, pero si necesita a una persona (el cliente
                    // está molesto, pidió que no le manden nada) JP se entera, y la
                    // cotización formal queda retenida hasta que él decida: no se le
                    // manda por correo el PDF que acaba de rechazar (30-sep, Gustavo).
                    if (!empty($r['necesita_humano'])) {
                        $chat['pendiente'] = array('id' => $id, 'para_ts' => $ultIn, 'estado' => 'escalado', 'necesita_humano' => true, 'motivo' => $r['motivo']);
                        $chat['no_cotizar'] = array('ts' => $ahora, 'motivo' => $r['motivo']);
                        deckeva_wa_anotar($chat, $id . ' no se le escribe · lo ve JP · ' . $r['motivo']);
                        $escalar = true;
                        break;
                    }
                    $chat['pendiente'] = array('id' => $id, 'para_ts' => $ultIn, 'estado' => 'sin_respuesta', 'motivo' => $r['motivo']);
                    deckeva_wa_anotar($chat, 'no hace falta contestar · ' . $r['motivo']);
                    break;
                }
                // Muelles flotantes: nunca sale solo, lo ve JP (T-017).
                if (deckeva_wa_es_muelle($chat['mensajes'] ?? array())) {
                    $r['necesita_humano'] = true;
                    $r['motivo'] = 'MUELLE FLOTANTE · no se cotiza, lo ve JP al tiro' . ($r['motivo'] !== '' ? ' · ' . $r['motivo'] : '');
                }
                // Los valores por largo (JP, 1-oct): la captura del cotizador
                // para el tamaño que dio el cliente. Sólo si la captura sigue
                // mostrando el precio publicado y no se le mandó antes; si no,
                // el texto promete una imagen que no va: lo ve JP.
                $imagen = '';
                $valores = '';
                if (($r['valores'] ?? '') !== '' && function_exists('deckeva_wa_valores_clave')) {
                    $valores = deckeva_wa_valores_clave($r['valores']);
                    $imagen = $valores !== '' && empty($chat['valores_enviados'][$valores]) ? deckeva_wa_valores_url($valores) : '';
                    if ($imagen === '') {
                        $r['necesita_humano'] = true;
                        $r['motivo'] = 'iba con los valores de ' . ($valores !== '' ? $valores : $r['valores']) . ' y no hay captura vigente (o ya se mandó) · revisa' . ($r['motivo'] !== '' ? ' · ' . $r['motivo'] : '');
                    }
                }
                $regla = deckeva_wa_validar($r['texto']);
                if ($regla === '') $regla = deckeva_wa_suena_a_robot($r['texto']);
                $auto = deckeva_wa_modo() === 'automatico' && !$r['necesita_humano'] && $regla === '';
                $semilla = $num . '|' . $ultIn;
                $p = array(
                    'id' => $id, 'para_ts' => $ultIn, 'texto' => $r['texto'],
                    'en' => deckeva_wa_en_horario($ultIn + deckeva_wa_demora($semilla), $semilla),
                    'estado' => $auto ? 'aprobado' : 'borrador', 'necesita_humano' => $r['necesita_humano'],
                    'motivo' => $r['motivo'], 'regla' => $regla,
                );
                if ($auto) $p['aprobado_por'] = 'automático';
                if ($imagen !== '') { $p['imagen'] = $imagen; $p['valores'] = $valores; }
                $chat['pendiente'] = $p;
                deckeva_wa_anotar($chat, $id . ' redactado · ' . ($auto ? 'sale solo ' . deckeva_wa_legible($p['en']) : 'espera a JP'));
                $avisar = !$auto;
            }

            // A su hora, mandar lo aprobado por la puerta de tourevo.cl.
            if (($p['estado'] ?? '') === 'aprobado' && (int) $p['para_ts'] === $ultIn && $ahora >= (int) $p['en'] && deckeva_wa_habil($ahora)) {
                $salida = $p;
            }
    } while (false);

    $guardado = false;
    // Con Tourevo pidiendo, le llega a JP por WhatsApp (deckeva_wa_pendientes_para_jp)
    // y el correo queda DIFERIDO, no descartado: si Tourevo no lo retira en la
    // lista, sale igual (deckeva_wa_correos_diferidos). Codex, #158.
    $porWhatsApp = time() - (int) get_option('deckeva_wa_tick_ts', 0) < 15 * MINUTE_IN_SECONDS;
    if ($porWhatsApp && ($avisar || $escalar) && is_array($chat['pendiente'] ?? null)) $chat['pendiente']['correo_diferido'] = time();
    if ($chat !== $original) {
        deckeva_wa_con_candado(function ($chats) use ($num, $chat, $huella, &$guardado) {
            if (!isset($chats[$num]) || deckeva_wa_huella($chats[$num]) !== $huella) return $chats;
            $chats[$num] = $chat;
            $guardado = true;
            return $chats;
        });
        // El correo a JP sale DESPUÉS de guardar: si el chat cambió en el medio
        // no se guardó nada, y la próxima pasada redacta y avisa una sola vez.
        if ($guardado && $avisar && !$porWhatsApp) deckeva_wa_avisar_jp($chat);
        if ($guardado && $escalar && !$porWhatsApp) deckeva_wa_avisar_escalado($chat);
        if (!$guardado) return;
    }
    if ($salida === null) return;

    // A su hora, lo aprobado sale por la puerta de tourevo.cl. El ref es el id
    // del borrador y la puerta no encola dos veces el mismo: reintentar después
    // de una caída no duplica el mensaje.
    $w = deckeva_wa_mandar($num, (string) $salida['texto'], (string) $salida['id'], (string) ($salida['aprobado_por'] ?? 'JP'), null, (string) ($salida['imagen'] ?? ''));
    deckeva_wa_con_candado(function ($chats) use ($num, $salida, $w, $ahora) {
        $c = $chats[$num] ?? null;
        if (!is_array($c) || ($c['pendiente']['id'] ?? '') !== $salida['id']) return $chats;
        $p = $c['pendiente'];
        if ($w['ok']) {
            $p['estado'] = 'enviado';
            $p['enviado_ts'] = $ahora;
            // Los valores de ese tamaño ya van: no se le vuelven a mandar.
            if (($p['valores'] ?? '') !== '') $c['valores_enviados'][(string) $p['valores']] = $ahora;
            deckeva_wa_anotar($c, $p['id'] . ' entregado a la puerta · sale en el próximo minuto');
        } else {
            // Una caída de la puerta no pierde la respuesta: sigue aprobada y se
            // reintenta en las pasadas siguientes, hasta 10 veces.
            $p['intentos'] = (int) ($p['intentos'] ?? 0) + 1;
            $p['error'] = $w['error'];
            if ($p['intentos'] >= 10) $p['estado'] = 'error';
            deckeva_wa_anotar($c, $p['id'] . ' no salió (intento ' . $p['intentos'] . ') · ' . $w['error']);
        }
        $c['pendiente'] = $p;
        $chats[$num] = $c;
        return $chats;
    });
}

// =============================================
// CLAUDE · redacta, no decide
// =============================================

/**
 * Cómo escribe Juan Pablo por WhatsApp, y cómo vende. Sale del informe de la
 * IA de Meta del 30-sep-2026: 108 conversaciones reales, con lo que contestó
 * la IA y lo que contestó JP desde el teléfono. Lo que delataba a la máquina:
 * hablar de «Juan Pablo» en tercera persona desde el número de Juan Pablo,
 * «te conecté con nuestro equipo», el embudo de un dato por mensaje, repetir
 * lo que el cliente acaba de decir y agradecer foto por foto. Mismo texto que
 * `Core/VozHumana` de tourevo.cl.
 *
 * Si alguien pregunta en serio si habla con una persona o con una máquina, no
 * se le dice ni que sí ni que no: lo contesta JP en persona.
 */
function deckeva_wa_voz() {
    return "Quién escribe:\n"
        . "- Escribes como Juan Pablo, el dueño, desde su celular, en primera persona: «te la mando», «lo reviso y te confirmo», «te llamo». Nunca hables de Juan Pablo en tercera persona, ni de «el equipo», «un encargado», «un asesor», «el sistema», «la ficha», «el tarifario», «mis registros» o «un asistente».\n"
        . "- Si el cliente pregunta en serio si habla con una persona, con un bot o con una IA, no lo contestes tú: responder = false, necesita_humano = true, motivo «pregunta si es un bot». Nunca digas que eres una persona ni que eres un bot.\n\n"
        . "Cómo suena (así escribe Juan Pablo de verdad):\n"
        . "- Saludo con el nombre y cercano, sólo si todavía no se saludaron hoy: «Hola Cristian, buen día! cómo estás?». Si ya conversaron, entra directo al tema.\n"
        . "- Frases cortas y conversadas: «Buenísimo», «Genial», «Dale», «Claro que sí», «Te parece?», «Te acomoda?», «Te tinca?». A lo más un emoji, al final: 👍 👌 😉 🙌. Muchas veces ninguno.\n"
        . "- Contesta PRIMERO lo que te preguntaron, directo, y después da un solo paso hacia adelante.\n"
        . "- Un comentario propio sobre la lancha o el proyecto, como alguien que sabe, cuando calce: «Buena lancha la Monterey 196». Una vez en la conversación, no en cada mensaje.\n"
        . "- Los datos que faltan se piden juntos y de forma natural, nunca de a uno como formulario: «Me pasas tu nombre completo y correo y te la mando?». Nunca más de dos cosas por mensaje.\n"
        . "- No repitas ni resumas lo que el cliente acaba de escribir. Si hace falta confirmar un dato, en media frase.\n"
        . "- Si mandó fotos, una sola respuesta para todas, sin describirlas. Nunca agradezcas foto por foto.\n"
        . "- No repitas una pregunta que ya hiciste y quedó sin respuesta, y no termines siempre igual: ni todos los mensajes con «Perfecto» al comienzo ni con «Quedo atento» al final.\n"
        . "- El largo se adapta al del cliente: si escribe dos palabras, contestas corto.\n"
        . "- Si el cliente dijo que no quiere la cotización, que así está bien o que lo va a pensar: respétalo, una frase amable y nada más.\n"
        . "- Si mandó un audio (no lo puedes escuchar), responder = false, necesita_humano = true, motivo «mandó un audio».\n"
        . "- Si pide hablar o que lo llamen: necesita_humano = true y un texto corto como «Dale, te llamo en un rato 👍».\n"
        . "- Nunca digas que no puedes abrir un link o ver algo: si no lo sabes, «lo reviso y te confirmo» y necesita_humano.\n\n"
        . "Cómo vende (cotizar y cerrar):\n"
        . "- Tu trabajo es llevar la conversación a una cotización y de la cotización a agendar la toma de medidas, con naturalidad y sin presionar.\n"
        . "- Casi siempre termina con una pregunta simple que lleve al paso siguiente y se conteste con una palabra.\n"
        . "- Si hay que elegir, ofrece dos opciones concretas en vez de una pregunta abierta: «Te acomoda más medirla en Santiago o en Rapel?».\n"
        . "- Vende lo que el cliente gana, con sus palabras, no la ficha técnica: una razón que le importe a ESE cliente (que no resbale mojado con los niños a bordo, que no queme al sol).\n"
        . "- Si el cliente ya decidió («dale», «hagámoslo», «cuándo pueden medir?»), no le vuelvas a vender: pide lo único que falta y dile qué pasa después.\n"
        . "- Con la cotización ya enviada, el paso siguiente es cerrar: si le llegó bien, si le acomoda avanzar con la toma de medidas, o qué le falta para decidir.\n"
        . "- Si dice que está comparando otras opciones o que le parece caro, no contestes sólo con un 👍: pregúntale qué es lo que más le importa. Si es el precio, una alternativa real: hacer sólo una parte, o medir e instalar él con los videos. Descuentos o cambiar un precio los decide Juan Pablo: necesita_humano.\n"
        . "- Urgencia, sólo la verdadera. Nunca inventes cupos, clientes agendados, viajes a una zona ni ofertas que vencen.\n"
        . "- Si algo no lo hacemos, dilo claro y, si puedes, recomienda a quién ir.\n\n";
}

/** ¿Lo último que escribió el cliente pregunta si habla con una máquina? Entonces contesta JP, no la IA. */
function deckeva_wa_pregunta_si_es_bot($mensajes) {
    $ult = '';
    foreach ((array) $mensajes as $m) {
        if (($m['dir'] ?? '') === 'in') $ult .= ' ' . (string) ($m['texto'] ?? '');
        else $ult = '';
    }
    return (bool) preg_match('/\b(bot|robot|chatbot|ia|inteligencia artificial|m[aá]quina|autom[aá]tic[oa]s?|humano|persona real|AI|human|real person)\b|\b(eres|es|hablo con|habla con|hablando con) (un |una )?persona\b/iu', $ult);
}

/** '' si suena a persona; si no, qué lo delata. Lista cerrada: puede no reconocer una frase robótica, no puede marcar una normal. */
function deckeva_wa_suena_a_robot($txt) {
    $reglas = array(
        '/\bJuan Pablo (te|le|les|lo|la|se|va|ve|atiende|confirma|prepara|env[ií]a|manda|revisa|coordina|cotiza|detalla)\b/iu' => 'habla de Juan Pablo en tercera persona',
        '/\b(un miembro del equipo|nuestro equipo|el encargado|un encargado|un asesor|un ejecutivo)\b/iu' => 'deriva a «el equipo» o «un encargado»',
        '/\b(asistente virtual|soy (el|la|un|una) asistente|chatbot|inteligencia artificial)\b/iu' => 'se presenta como asistente o IA',
        '/(en (mis|nuestros) (archivos|registros)|en la ficha|la ficha que|en el tarifario|en nuestro sistema|no tengo (esa|ese) (informaci[oó]n|dato))/iu' => 'habla de fichas o registros',
        '/(gracias por ponerte en contacto|te he conectado|te conect[eé] con|hemos pasado la conversaci[oó]n|no puedo ayudarte con eso|no puedo abrir (enlaces|links))/iu' => 'frase de respuesta automática',
        // Decir qué es: ni negar ser un bot ni jurar ser una persona. Eso lo contesta JP.
        '/(no soy (un |una )?(bot|robot|ia|m[aá]quina|programa)|soy (una )?persona|soy (un )?humano|persona real|de carne y hueso|not a (bot|robot)|real person|I\'m human|I am human)/iu' => 'dice qué es (bot o persona) · eso lo contesta JP',
    );
    foreach ($reglas as $re => $por) if (preg_match($re, (string) $txt)) return 'suena a robot: ' . $por;
    return '';
}

function deckeva_wa_sistema() {
    return "Contestas el WhatsApp de Deckeva, en Chile. Te paso la conversación con un cliente y redactas UNA respuesta a lo último que escribió.\n\n"
        . "Lo que sabes de Deckeva:\n"
        . "- Fabrica pisos de goma EVA antideslizante a medida para lanchas, veleros, motos de agua y embarcaciones. Sitio: deckeva.cl, con cotizador en la web. Correo: contacto@deckeva.cl.\n"
        . "- Para cotizar un piso hace falta: marca, modelo, año y largo en pies de la embarcación, el color o diseño que quiere, dónde está la embarcación (ciudad o marina), y el nombre y el email del cliente. Para una moto de agua: marca, modelo y año (el tamaño lo sacamos del largo de sus especificaciones), el color, dónde está, y el nombre y el email.\n"
        . "- La toma de medidas y la instalación son servicios opcionales de Deckeva, con un valor fijo que va en la cotización formal (PDF), aparte del total del piso. El cliente también las puede hacer él mismo, fácil, con el video explicativo que le mandamos: como prefiera. Nunca digas su valor en el chat: si lo pregunta, dile que va en la cotización.\n"
        . "- La toma de medidas y la instalación pueden ser en lugares distintos: por ejemplo, medir en Rapel e instalar en Pucón, o medir en Santiago e instalar en la marina. Si el cliente lo plantea, dile que sí se puede y anota los dos lugares.\n"
        . "- Si la embarcación está en Curacaví, la toma de medidas y la instalación llevan un recargo por traslado que va en la cotización formal. Nunca digas el monto en el chat.\n"
        . "- El logo de la marca de la embarcación (por ejemplo Cobalt o Sea Ray) se puede grabar en el piso sin costo extra: va incluido. Si el cliente lo pide, dile que sí y anótalo para la cotización.\n"
        . "- Muelles flotantes: nunca des precio ni ofrezcas cotizarlos. Dile que lo revisas personalmente y le escribes, y marca necesita_humano.\n"
        . "- Deckeva hace SÓLO pisos de goma EVA antideslizante. No hace carpas, toldos, lonas, tapicería ni pintura. Si el cliente pide otra cosa, díselo claro y amable en una frase y, si calza, ofrécele el piso para esa misma embarcación. No lo marques necesita_humano por eso.\n"
        . "- La cotización formal le llega en PDF por acá mismo, por WhatsApp, y también a su correo. También la puede sacar solo en el cotizador de deckeva.cl.\n"
            . "- Si pregunta dónde conviene tener la embarcación para la toma de medidas y la instalación, o duda entre dos lugares: si tiene la posibilidad de traerla a Santiago, es lo ideal, porque ahí la trabajamos de forma más rápida. Díselo así, sin obligarlo: si no puede, se coordina donde esté.\n"
        . "- El piso: espesor de 6 mm y vida útil de 5 a 7 años. La garantía es de 1 año, al costo: dilo siempre así, con «al costo». Si pregunta qué cubre la garantía o qué significa al costo, dile que lo revisas y le confirmas, y marca necesita_humano.\n"
        . "- Desde la toma de medidas hasta la instalación son 12 días corridos.\n"
        . "- Estamos en Santiago, en La Dehesa. No hay sala de venta: vamos a medir donde esté la embarcación (en Santiago, en La Dehesa o Los Dominicos). No se vende por metro cuadrado: el piso se fabrica a la medida exacta.\n"
        . "- Colores: en stock tenemos café claro y gris claro, y los dos se pueden hacer con líneas negras, que es parte del diseño que trabajamos. No manejamos otros colores: si el cliente pide beige, negro, teca, azul u otro, dile con cariño que trabajamos esos dos y ofrécele el más parecido. Nunca ofrezcas un color que no sea café claro o gris claro. Se puede grabar el nombre o la patente. Fotos de trabajos hechos: deckeva.cl/#proyectos.\n"
        . "- Se puede hacer sólo una parte (la plataforma de nado, la popa, la zona de los esquís): se cotiza aparte, con fotos de esa zona.\n"
        . "- Los valores por largo (JP, 1-oct): si el cliente quiere un piso para su lancha y todavía no sabes el largo en pies, lo primero es preguntárselo, corto. Si te dio la marca y el modelo, puedes confirmarlo tú: «¿Es de 20 pies, correcto?». Apenas tengas el largo confirmado (de 14 a 30 pies), o sepas que es una moto de agua normal o mediana a grande, y todavía no le mandaste los valores de ese tamaño (mira la nota del equipo), pon en «valores» el tamaño («20», «moto-normal» o «moto-grande») y en «texto» algo como «Te mando los valores para una lancha de 20 pies. Si quieres avanzar, te preparo la cotización formal». Con eso se le adjunta la captura del cotizador de la web. Nunca escribas el monto. Si mide menos de 14 o más de 30 pies, «valores» va vacío y necesita_humano. En cualquier otra respuesta, «valores» va vacío.\n"
        . "- Si el cliente mide o instala él: videos paso a paso en deckeva.com/guia/medir y deckeva.com/guia/instalar. Fuera de Chile se manda embalado con el video de instalación.\n"
        . "- No vendemos seguros para embarcaciones: si preguntan, recomienda Mapfre Seguros.\n\n"
        . "Ejemplos del tono de Juan Pablo (el tono, no los datos; nunca los copies literal):\n"
        . "- «Cuánto vale el m2?» → «Hola! No lo vendemos por m2, lo fabricamos a la medida exacta de tu lancha. Qué lancha tienes y de cuántos pies es?»\n"
        . "- [mandó varias fotos] → «Buenísimas las fotos, se ve clarita la cubierta. Me pasas tu nombre y correo y te mando la cotización?»\n"
        . "- «Dónde están ustedes?» → «Estamos en La Dehesa, pero vamos a medir donde tengas la lancha. Dónde la tienes?»\n"
        . "- «Eso es instalado?» → «Sí, te lo dejamos instalado. La toma de medidas y la instalación van aparte en la cotización, o si prefieres las haces tú con nuestros videos, es bien fácil 👌»\n\n"
        . deckeva_wa_voz()
        . "Reglas fijas:\n"
        . "- En el idioma del cliente. En castellano, chileno y con tú: tienes, puedes, cuéntame. Nunca vos, tenés, podés.\n"
        . "- Corto, como desde el celular: una a tres frases. Sin listas, sin guiones largos (— o –).\n"
        . "- Nunca escribas un precio ni un importe. Si pregunta cuánto cuesta, dile que le mandas la cotización en PDF por acá y al correo, y pide lo que falte.\n"
        . "- No inventes. Plazos distintos de los de arriba, stock, fechas de instalación, formas de pago, un cambio, un reclamo o un pago: responde que lo revisas y le confirmas, y marca necesita_humano.\n"
        . "- ANTES de preguntar algo, lee el chat entero, desde el primer mensaje: lo que el cliente ya dijo, aunque haya sido hace días o con otras palabras, NO se vuelve a pedir. Úsalo. Preguntarle dos veces lo mismo es lo peor que le puede pasar a un cliente: le hace sentir que habla con una máquina que no lo escucha. Si ya tienes un dato, confírmalo en media frase y pide sólo lo que de verdad falta.\n"
        . "- Si en el chat se le dijeron dos cosas distintas (por ejemplo, sobre el traslado o el plazo), no elijas una: dile que lo revisas y le confirmas, y marca necesita_humano.\n"
        . "- Si el cliente dice que está molesto o que no quiere hablar con una máquina, no le mandes nada más: responder = false y necesita_humano = true, con el motivo.\n"
        . "- Si lo último no necesita respuesta (un gracias, un ok, un sticker), responder = false y texto vacío.\n"
        . "- motivo: una línea para el equipo, no para el cliente."
        . deckeva_wa_correcciones_prompt();
}

// =============================================
// LO QUE JP CORRIGE, LA IA LO APRENDE (6-oct-2026)
// =============================================
//
// «Lo que no sepa responder que me lo pregunte por WhatsApp, así yo le voy
// contestando y él va aprendiendo y respondiendo a clientes» (JP, 6-oct).
//
// Cuando JP no aprueba el borrador tal cual sino que lo reescribe —«D-XXXX:
// su texto» desde el WhatsApp, o el textarea de wp-admin—, esa corrección es
// la respuesta correcta a un caso real. Se guarda el trío (lo que preguntó el
// cliente · lo que propuso la IA · lo que mandó JP) y entra en el prompt de
// las respuestas siguientes.
//
// LO QUE NO ES: no cambia ninguna regla del código. Lo que sale sigue pasando
// por `deckeva_wa_validar()` (sin importes, sin guiones largos, largo máximo)
// y por `deckeva_wa_suena_a_robot()`. Una corrección enseña a REDACTAR, no
// abre la puerta a decir un precio.
//
// Se guardan las 20 últimas: el prompt no puede crecer sin techo, y una
// corrección de hace tres meses vale menos que la de ayer. Lo que se repite
// se escribe en `deckeva_wa_sistema()`, que es donde vive lo permanente.

const DECKEVA_WA_CORRECCIONES_MAX = 20;
const DECKEVA_WA_CORRECCION_LARGO = 400;

function deckeva_wa_correcciones() {
    $x = get_option('deckeva_wa_correcciones', array());
    return is_array($x) ? $x : array();
}

/** Guarda la corrección de JP · sólo si de verdad cambió el texto. */
function deckeva_wa_aprender($chat, $propuesta, $jp) {
    $jp = trim((string) $jp);
    $propuesta = trim((string) $propuesta);
    if ($jp === '' || $jp === $propuesta) return;          // aprobó tal cual: no hay nada que aprender
    $cliente = '';
    foreach ((array) ($chat['mensajes'] ?? array()) as $m) {
        if (($m['dir'] ?? '') === 'in' && trim((string) ($m['texto'] ?? '')) !== '') $cliente = (string) $m['texto'];
    }
    $corta = function ($t) { return mb_substr(trim(preg_replace('/\s+/u', ' ', (string) $t)), 0, DECKEVA_WA_CORRECCION_LARGO); };
    $todas = deckeva_wa_correcciones();
    $todas[] = array('ts' => time(), 'cliente' => $corta($cliente), 'antes' => $corta($propuesta), 'jp' => $corta($jp));
    update_option('deckeva_wa_correcciones', array_slice($todas, -DECKEVA_WA_CORRECCIONES_MAX), false);
}

/** El bloque que va al prompt, o '' si JP todavía no corrigió nada. */
function deckeva_wa_correcciones_prompt() {
    $todas = deckeva_wa_correcciones();
    if (!$todas) return '';
    $t = "\n\nCómo contesta Juan Pablo cuando corrige, de casos reales. Lo último manda: si una de éstas contradice un ejemplo de arriba, vale ésta. No las copies literal, copia el criterio.\n";
    foreach ($todas as $c) {
        $t .= '- Cliente: «' . $c['cliente'] . '»';
        if (($c['antes'] ?? '') !== '') $t .= ' · la IA iba a decir: «' . $c['antes'] . '»';
        $t .= ' · JP mandó: «' . $c['jp'] . "»\n";
    }
    return $t;
}

/** Lo que el que redacta tiene que saber de este chat: los valores ya mandados y la cotización formal. */
function deckeva_wa_nota_chat($chat) {
    $notas = array();
    $v = array_keys((array) ($chat['valores_enviados'] ?? array()));
    if ($v) $notas[] = 'Ya se le mandaron los valores (la captura del cotizador) para: ' . implode(', ', $v) . '. No los vuelvas a mandar.';
    $c = deckeva_wa_nota_cotizacion($chat);
    if ($c !== '') $notas[] = $c;
    return implode(' ', $notas);
}

/** Lo que el que redacta tiene que saber de la cotización formal de este chat. */
function deckeva_wa_nota_cotizacion($chat) {
    $c = $chat['cotizacion'] ?? null;
    if (!is_array($c)) return '';
    switch ($c['estado'] ?? '') {
        case 'enviada': return 'La cotización formal ' . $c['numero'] . ' ya se le mandó (' . deckeva_wa_legible((int) $c['enviada_ts']) . ')' . (!empty($c['wa_ts']) ? ' en PDF por este WhatsApp y a su correo' : ' a su correo') . '. No digas el monto.';
        case 'lista': case 'aprobada': return 'Su cotización formal ya está armada y le llega en breve en PDF por este WhatsApp y a su correo. No digas el monto.';
        case 'incompleta':
            // Pidió algo que no es un piso EVA: no le falta un dato, no se cotiza.
            if (strpos((string) ($c['falta'] ?? ''), 'no es un piso EVA') === 0) return 'Lo que pidió no es un piso EVA: no se cotiza. Dile en una frase que Deckeva hace sólo pisos de goma EVA.';
            return ($c['falta'] ?? '') !== '' ? 'Para su cotización formal falta: ' . $c['falta'] . '.' : '';
    }
    return '';
}

function deckeva_wa_redactar($mensajes, $nota = '') {
    $tz = new DateTimeZone('America/Santiago');
    $txt = '';
    foreach ($mensajes as $m) {
        $t = trim((string) $m['texto']);
        if ($t === '') continue;
        $txt .= '[' . (new DateTimeImmutable('@' . (int) $m['ts']))->setTimezone($tz)->format('Y-m-d H:i') . '] ' . ($m['dir'] === 'in' ? 'Cliente' : 'Deckeva') . ': ' . $t . "\n";
    }
    if ($txt === '') return array('ok' => false, 'error' => 'chat sin texto');
    $esquema = array('type' => 'object', 'additionalProperties' => false,
        'required' => array('responder', 'texto', 'necesita_humano', 'motivo', 'valores'),
        'properties' => array('responder' => array('type' => 'boolean'), 'texto' => array('type' => 'string'), 'necesita_humano' => array('type' => 'boolean'), 'motivo' => array('type' => 'string'),
            // El tamaño cuyos valores van con esta respuesta («20», «moto-normal») o ''.
            'valores' => array('type' => 'string')));
    $res = wp_remote_post('https://api.anthropic.com/v1/messages', array(
        'timeout' => 60,
        'headers' => array('x-api-key' => deckeva_wa_llave(), 'anthropic-version' => '2023-06-01', 'anthropic-beta' => 'server-side-fallback-2026-07-01', 'content-type' => 'application/json'),
        'body' => wp_json_encode(array(
            'model' => DECKEVA_WA_MODELO, 'max_tokens' => 2000, 'fallbacks' => 'default',
            'output_config' => array('effort' => 'low', 'format' => array('type' => 'json_schema', 'schema' => $esquema)),
            'system' => deckeva_wa_sistema(),
            'messages' => array(array('role' => 'user', 'content' => "<conversacion>\n" . $txt . '</conversacion>' . ($nota !== '' ? "\n<nota_del_equipo>" . $nota . '</nota_del_equipo>' : ''))),
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
    return array('ok' => true, 'responder' => !empty($d['responder']), 'texto' => trim((string) ($d['texto'] ?? '')), 'necesita_humano' => !empty($d['necesita_humano']), 'motivo' => trim((string) ($d['motivo'] ?? '')), 'valores' => trim((string) ($d['valores'] ?? '')));
}

// =============================================
// SALIDA · por la puerta de tourevo.cl, que tiene el número
// =============================================

/**
 * Manda por la puerta de Tourevo. Con `$pdf` (la ruta de la cotización formal)
 * el archivo viaja dentro del pedido firmado y sale como documento de
 * WhatsApp, con `$texto` de pie (JP, 30-sep: «Deckeva averigua y luego envía
 * la cotización formal PDF por WhatsApp»). No va por un link: el PDF trae el
 * nombre, el correo y el teléfono del cliente, y la carpeta está cerrada.
 */
function deckeva_wa_mandar($num, $texto, $ref, $aprobo, $pdf = null, $imagen = '') {
    $pedido = array('para' => (string) $num, 'texto' => $texto, 'ref' => $ref, 'aprobo' => $aprobo);
    // La captura del cotizador por link (deckeva-whatsapp-valores.php): sale como
    // foto con el texto de pie. No trae datos del cliente.
    if ((string) $imagen !== '') $pedido['imagen'] = array('url' => (string) $imagen);
    if ($pdf !== null) {
        $bytes = is_readable((string) $pdf) ? (string) file_get_contents((string) $pdf) : '';
        if (strncmp($bytes, '%PDF', 4) !== 0) return array('ok' => false, 'error' => 'el PDF no se puede leer');
        if (strlen($bytes) > 4 * 1024 * 1024) return array('ok' => false, 'error' => 'el PDF pasa de 4 MB');
        $pedido['documento'] = array('nombre' => basename((string) $pdf), 'base64' => base64_encode($bytes));
    }
    $v = (($pdf !== null || (string) $imagen !== '') && trim((string) $texto) === '') ? '' : deckeva_wa_validar($texto);
    if ($v !== '') return array('ok' => false, 'error' => 'el texto no pasa las reglas · ' . $v);
    $cuerpo = wp_json_encode($pedido);
    $ts = time();
    $res = wp_remote_post(DECKEVA_WA_PUERTA_SALIDA, array('timeout' => $pdf !== null ? 45 : 20, 'headers' => array(
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

/** Un chat que no se contesta pero que JP tiene que mirar: correo corto, con el final del chat. */
function deckeva_wa_avisar_escalado($chat) {
    $p = $chat['pendiente'];
    $chatH = '';
    foreach (array_slice((array) $chat['mensajes'], -8) as $m) {
        $chatH .= '<p style="margin:4px 0"><span style="color:#666">' . ($m['dir'] === 'in' ? 'Cliente' : 'Deckeva') . ' ' . esc_html(deckeva_wa_legible($m['ts'])) . ' ·</span> ' . nl2br(esc_html($m['texto'])) . '</p>';
    }
    $html = '<div style="font-family:Arial,sans-serif;font-size:14px;color:#111">'
        . '<p><b>No le escribimos nada a +' . esc_html($chat['numero']) . ' (Deckeva). Necesita que lo mires tú.</b></p>'
        . '<p style="color:#b45309">' . esc_html($p['motivo']) . '</p>'
        . (!empty($chat['no_cotizar']) ? '<p>Su cotización formal quedó retenida: no sale sola hasta que decidas.</p>' : '') . $chatH . '</div>';
    wp_mail(deckeva_wa_aprobador(), '⚠ Lo ves tú · ' . $p['id'] . ' · Deckeva · +' . $chat['numero'], $html, deckeva_mail_headers());
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
        $id = sanitize_text_field(wp_unslash($_POST['id'] ?? ''));
        $texto = trim((string) wp_unslash($_POST['texto'] ?? ''));
        deckeva_wa_con_candado(function ($chats) use ($num, $id, $texto, $accion, &$msg) {
            $chat = $chats[$num] ?? null;
            $p = is_array($chat) ? ($chat['pendiente'] ?? null) : null;
            // Se aprueba EL borrador que JP estaba mirando: si el cliente volvió
            // a escribir y ya hay otro, el formulario viejo no lo aprueba.
            if (!is_array($p) || ($p['estado'] ?? '') !== 'borrador' || ($p['id'] ?? '') !== $id) {
                $msg = 'Ese borrador ya no está esperando (el cliente pudo volver a escribir). Mira el nuevo.';
                return $chats;
            }
            if ($accion === 'descartar') {
                $p['estado'] = 'descartado';
                deckeva_wa_anotar($chat, $p['id'] . ' descartado');
                $msg = 'Descartado · no sale nada.';
            } elseif ($accion === 'aprobar') {
                $v = deckeva_wa_validar($texto);
                if ($v !== '') { $msg = 'No se aprobó: ' . $v . '.'; return $chats; }
                $cambio = $texto !== trim((string) ($p['texto'] ?? ''));
                if ($cambio) deckeva_wa_aprender($chat, (string) ($p['texto'] ?? ''), $texto);
                $p['texto'] = $texto; $p['estado'] = 'aprobado'; $p['aprobado_por'] = 'JP · wp-admin';
                deckeva_wa_anotar($chat, $p['id'] . ' aprobado' . ($cambio ? ' con el texto de JP · aprendido' : ''));
                $msg = 'Aprobado · sale ' . deckeva_wa_legible(max((int) $p['en'], time())) . '.';
            }
            $chat['pendiente'] = $p;
            $chats[$num] = $chat;
            return $chats;
        });
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
    echo '<p>Los chats de Deckeva que llegan al +56 9 4021 1459. Se contestan entre 5 y 40 minutos después del mensaje del cliente, de 8:00 a 20:00. '
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
        echo '<input type="hidden" name="action" value="deckeva_wa"><input type="hidden" name="numero" value="' . esc_attr($num) . '"><input type="hidden" name="id" value="' . esc_attr($p['id']) . '">'
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

    // Lo que aprendió de JP · a la vista, porque si no es una caja negra: lo
    // que la IA usa para contestar tiene que poder leerlo una persona.
    $corr = deckeva_wa_correcciones();
    if ($corr) {
        echo '<h2>Lo que aprendió de ti · ' . count($corr) . ' de ' . DECKEVA_WA_CORRECCIONES_MAX . '</h2>'
            . '<p>Cada vez que corriges un borrador en vez de aprobarlo tal cual, tu texto queda acá y entra en las respuestas siguientes. Las más nuevas abajo; al llegar al tope se cae la más vieja.</p>'
            . '<table class="widefat striped"><thead><tr><th>Cuándo</th><th>El cliente dijo</th><th>Iba a decir</th><th>Tú dijiste</th></tr></thead><tbody>';
        foreach ($corr as $c) {
            echo '<tr><td>' . esc_html(deckeva_wa_legible((int) $c['ts'])) . '</td><td>' . esc_html($c['cliente']) . '</td><td style="color:#666">' . esc_html($c['antes']) . '</td><td><b>' . esc_html($c['jp']) . '</b></td></tr>';
        }
        echo '</tbody></table>';
    }

    if (function_exists('deckeva_wa_cotiza_pantalla')) deckeva_wa_cotiza_pantalla();

    echo '<h2>Configuración</h2><form method="post" action="' . esc_url(admin_url('admin-post.php')) . '">';
    wp_nonce_field('deckeva_wa');
    echo '<input type="hidden" name="action" value="deckeva_wa"><input type="hidden" name="accion" value="config"><table class="form-table">'
        . '<tr><th>Secreto de la puerta</th><td><input type="password" name="secreto" class="regular-text" autocomplete="off" placeholder="' . (deckeva_wa_secreto() !== '' ? 'cargado · déjalo vacío para no cambiarlo' : '') . '"><p class="description">El mismo valor que el secret PUERTA_DECKEVA_SECRETO del repo de Tourevo.</p></td></tr>'
        . '<tr><th>Llave de Claude</th><td><input type="password" name="anthropic_key" class="regular-text" autocomplete="off" placeholder="' . (deckeva_wa_llave() !== '' ? 'cargada · déjala vacía para no cambiarla' : '') . '"></td></tr>'
        . '<tr><th>Modo</th><td><select name="modo"><option value="borrador"' . selected(deckeva_wa_modo(), 'borrador', false) . '>Borrador · nada sale sin aprobación</option><option value="automatico"' . selected(deckeva_wa_modo(), 'automatico', false) . '>Automático</option></select></td></tr>'
        . '<tr><th>Aprueba</th><td><input type="email" name="aprobador" class="regular-text" value="' . esc_attr(deckeva_wa_aprobador()) . '"></td></tr>'
        . '</table><p><button class="button button-primary">Guardar</button></p></form></div>';
}
