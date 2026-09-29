<?php
/**
 * Plugin Name: Deckeva - Cotización formal desde WhatsApp
 * Description: Cuando un chat de WhatsApp ya trae lo necesario, arma la cotización
 *              formal en PDF con el mismo diseño y el mismo precio que el cotizador
 *              de la home, y se la manda al cliente por correo desde contacto@deckeva.cl.
 *
 * El caso (28-sep-2026): once clientes pidieron cotización por WhatsApp en un día,
 * cinco dejaron todos sus datos (nombre, correo, largo, color) y a ninguno le llegó
 * nada. La IA de Meta les dijo que se la mandaban por correo; nadie la mandó.
 *
 * El precio NO se escribe acá. Sale de la tabla del home publicado
 * (ABSPATH/index.html, el <select id="sizeSelect"> con «pies|clp»), que es la misma
 * que usa el cliente cuando se cotiza solo. Si esa tabla no se puede leer, o el largo
 * no está en ella, no se cotiza: queda para JP. Nunca se adivina un precio.
 *
 * Lo que queda para JP (su mandato del 28-sep, punto 3): un largo que no es un
 * número entero de pies, «otro», precios fuera de la tabla, descuentos, reclamos.
 *
 * Modo (Ajustes → WhatsApp Deckeva → Cotizaciones):
 * - borrador (por defecto): la cotización se arma y se le manda a JP con el PDF;
 *   sale al cliente cuando JP aprieta «Enviar».
 * - automático: sale sola, 5 a 40 minutos después del último mensaje del cliente,
 *   de 8:00 a 20:00. Lo prende JP, no el código.
 *
 * El repo es público: acá no hay ningún dato de cliente. Todo vive en la opción
 * deckeva_wa_chats, en el servidor.
 */

if (!defined('ABSPATH')) {
    exit;
}

function deckeva_wa_cotiza_modo() {
    if (defined('DECKEVA_WA_COTIZA_MODO')) return DECKEVA_WA_COTIZA_MODO === 'automatico' ? 'automatico' : 'borrador';
    return get_option('deckeva_wa_cotiza_modo', 'borrador') === 'automatico' ? 'automatico' : 'borrador';
}

/**
 * La tabla de precios del home publicado: array('14' => 658337, …, 'moto-normal' => …).
 * Vacía si no se puede leer. Se lee del archivo que ve el cliente, no de una copia.
 */
function deckeva_wa_cotiza_tabla($html = null) {
    if ($html === null) {
        $f = ABSPATH . 'index.html';
        $html = is_readable($f) ? (string) file_get_contents($f) : '';
    }
    if (!preg_match('/<select[^>]*id="sizeSelect"[^>]*>(.*?)<\/select>/s', $html, $m)) return array();
    preg_match_all('/value="(\d{2}|moto-normal|moto-grande)\|(\d+)"/', $m[1], $ops, PREG_SET_ORDER);
    $out = array();
    foreach ($ops as $o) if ((int) $o[2] > 0) $out[$o[1]] = (int) $o[2];
    return $out;
}

function deckeva_wa_cotiza_clp($n) {
    return 'CLP $' . number_format((int) $n, 0, ',', '.');
}

/**
 * Qué dice el chat · Claude pasa la conversación a un JSON fijo. Lo completo lo
 * decide el código (deckeva_wa_cotiza_listo), no Claude.
 */
function deckeva_wa_cotiza_leer($mensajes) {
    $tz = new DateTimeZone('America/Santiago');
    $txt = '';
    foreach ($mensajes as $m) {
        $t = trim((string) $m['texto']);
        if ($t === '' || ($m['dir'] ?? '') !== 'in') continue;
        $txt .= '[' . (new DateTimeImmutable('@' . (int) $m['ts']))->setTimezone($tz)->format('Y-m-d H:i') . '] Cliente: ' . $t . "\n";
    }
    if ($txt === '') return array('ok' => false, 'error' => 'chat sin texto');
    $str = array('type' => 'string');
    $esquema = array('type' => 'object', 'additionalProperties' => false,
        'required' => array('nombre', 'apellido', 'email', 'largo', 'tipo', 'marca', 'modelo', 'anio', 'color', 'ubicacion', 'pais', 'quiere_cotizacion'),
        'properties' => array(
            'nombre' => $str, 'apellido' => $str, 'email' => $str, 'largo' => $str,
            'tipo' => array('type' => 'string', 'enum' => array('lancha', 'moto', 'moto_normal', 'moto_grande', 'otro', 'no_dice')),
            'marca' => $str, 'modelo' => $str, 'anio' => $str, 'color' => $str, 'ubicacion' => $str, 'pais' => $str,
            'quiere_cotizacion' => array('type' => 'boolean'),
        ));
    $sistema = "Te paso lo que escribió un cliente de Deckeva (pisos de goma EVA para embarcaciones) por WhatsApp. "
        . "Devuelve SOLO lo que el cliente escribió, sin deducir nada. Si un dato no está escrito, déjalo vacío.\n"
        . "- largo: el largo en pies TAL COMO LO ESCRIBIÓ el cliente (\"19\", \"22,4\", \"21 pies\"). Nunca lo deduzcas del modelo (una Sea Ray 185 NO es un dato de largo). Si dio metros, déjalo vacío.\n"
        . "- tipo: lancha si habla de lancha/bote/yate/embarcación/pontón; moto si es moto de agua; moto_normal o moto_grande sólo si además el cliente dijo el tamaño; otro si pide algo que no es un piso EVA (una carpa, tapiz); no_dice si no se sabe.\n"
        . "- email: exacto, como lo escribió.\n"
        . "- color: el que eligió (gris, beige, negro...).\n"
        . "- anio: el año de la embarcación tal como lo escribió (\"2019\", \"98\").\n"
        . "- ubicacion: dónde está la embarcación o la moto (ciudad, lago o marina), tal como lo escribió. El país solo no es una ubicación.\n"
        . "- pais: Chile salvo que diga otro.\n"
        . "- quiere_cotizacion: true si pidió precio o cotización.";
    $res = wp_remote_post('https://api.anthropic.com/v1/messages', array(
        'timeout' => 60,
        'headers' => array('x-api-key' => deckeva_wa_llave(), 'anthropic-version' => '2023-06-01', 'anthropic-beta' => 'server-side-fallback-2026-07-01', 'content-type' => 'application/json'),
        'body' => wp_json_encode(array(
            'model' => DECKEVA_WA_MODELO, 'max_tokens' => 1500, 'fallbacks' => 'default',
            'output_config' => array('effort' => 'low', 'format' => array('type' => 'json_schema', 'schema' => $esquema)),
            'system' => $sistema,
            'messages' => array(array('role' => 'user', 'content' => "<cliente>\n" . $txt . '</cliente>')),
        )),
    ));
    if (is_wp_error($res)) return array('ok' => false, 'error' => $res->get_error_message());
    $j = json_decode((string) wp_remote_retrieve_body($res), true);
    if ((int) wp_remote_retrieve_response_code($res) !== 200 || !is_array($j)) return array('ok' => false, 'error' => 'Claude HTTP ' . (int) wp_remote_retrieve_response_code($res));
    $out = '';
    foreach ((array) ($j['content'] ?? array()) as $b) if (($b['type'] ?? '') === 'text') $out .= (string) $b['text'];
    $d = json_decode($out, true);
    return is_array($d) ? array('ok' => true, 'd' => $d) : array('ok' => false, 'error' => 'respuesta no es JSON');
}

/**
 * ¿Alcanza para cotizar? Devuelve array('ok' => true, 'clave' => '19', 'precio' => …)
 * o array('ok' => false, 'falta' => '…'). Cada dato que decide el precio o el
 * destinatario se vuelve a buscar en lo que ESCRIBIÓ el cliente: si Claude lo
 * inventó, no está, y no se cotiza.
 *
 * Regla de JP (29-sep-2026): sin los datos obligatorios no se crea la
 * cotización. Lancha: marca, modelo, año, largo (LOA o el que escribió),
 * color, dónde está, nombre y correo. Moto de agua: el tamaño, color, dónde
 * está, nombre y correo. Lo que falte se le pide al cliente ('falta' es lo
 * que lee quien le contesta: «Para su cotización formal falta: …»).
 */
/**
 * Moto de agua «normal» o «mediana a grande»: lo decide el largo total (LOA)
 * de las especificaciones, buscado con marca, modelo y año (JP, 29-sep ·
 * T-017: «el criterio es el largo»). La tabla que sostiene el corte, medida
 * en las fichas de los fabricantes:
 *
 *   normal            Sea-Doo Spark 2,8–3,05 m · Kawasaki STX 160 3,15 m
 *                     (124 in) · Yamaha EX ~3,1 m
 *   mediana a grande  Sea-Doo GTI 3,32 m · Kawasaki Ultra 310 3,44–3,58 m
 *                     · Yamaha FX 3,58 m (141 in) · Sea-Doo GTX/RXT ~3,5 m+
 *
 * Entre 3,15 y 3,32 m no hay modelos de catálogo: el corte va al medio.
 */
const DECKEVA_MOTO_CORTE_M = 3.25;

function deckeva_wa_cotiza_listo(array $d, array $mensajes, array $tabla, $loa = null) {
    // Muelles flotantes: no se cotizan, se escalan a JP (T-017).
    if (function_exists('deckeva_wa_es_muelle') && deckeva_wa_es_muelle($mensajes)) return array('ok' => false, 'falta' => 'muelle flotante · no se cotiza, lo ve JP', 'jp' => true);

    $escrito = ''; $lineas = array();
    foreach ($mensajes as $m) if (($m['dir'] ?? '') === 'in') { $escrito .= ' ' . mb_strtolower((string) $m['texto']); $lineas[] = mb_strtolower(trim((string) $m['texto'])); }
    // Sólo a quien la pidió: un cliente que dejó sus datos para otra cosa no
    // recibe un PDF que nunca pidió.
    if (empty($d['quiere_cotizacion'])) return array('ok' => false, 'falta' => 'que la pida (no pidió cotización)');
    // El correo: el ÚLTIMO que escribió. Si corrigió uno mal escrito, gana el nuevo.
    preg_match_all('/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}/', $escrito, $mails);
    $ultimo = $mails[0] ? end($mails[0]) : '';
    $email = strtolower(trim((string) ($d['email'] ?? '')));
    if (!is_email($email) || $email !== $ultimo) return array('ok' => false, 'falta' => 'el correo');
    if (trim((string) ($d['nombre'] ?? '')) === '') return array('ok' => false, 'falta' => 'el nombre');
    if (empty($tabla)) return array('ok' => false, 'falta' => 'la tabla de precios del home (no se pudo leer)', 'jp' => true);
    $tipo = (string) ($d['tipo'] ?? '');
    if ($tipo === 'otro') return array('ok' => false, 'falta' => 'no es un piso EVA · lo ve JP', 'jp' => true);
    if ($tipo === 'moto' || $tipo === 'moto_normal' || $tipo === 'moto_grande') {
        // Con marca y modelo escritos por el cliente y el LOA encontrado, el
        // tamaño lo decide el largo (DECKEVA_MOTO_CORTE_M), aunque el cliente
        // haya dicho otro. Sin LOA, vale el tamaño que el cliente dijo con sus
        // palabras. Sin ninguno de los dos, se le pide marca y modelo.
        // El modelo acepta dos letras (Yamaha EX, FX): son familias de la tabla.
        $conModelo = deckeva_wa_cotiza_en_texto($d['marca'] ?? '', $escrito) && deckeva_wa_cotiza_en_texto($d['modelo'] ?? '', $escrito, false, 2);
        if ($conModelo && is_array($loa) && (float) ($loa['pies'] ?? 0) > 0) {
            $pies = (float) $loa['pies'];
            $fuente = 'specs';
            $clave = $pies * 0.3048 < DECKEVA_MOTO_CORTE_M ? 'moto-normal' : 'moto-grande';
        } else {
            // Vale lo ÚLTIMO que dijo: «es normal… perdón, es grande» es grande.
            $ultNormal = preg_match_all('/\b(normal|est[aá]ndar|chica|peque[nñ]a)\b/u', $escrito, $mn, PREG_OFFSET_CAPTURE) ? end($mn[0])[1] : -1;
            $ultGrande = preg_match_all('/\b(grande|mediana)\b/u', $escrito, $mg, PREG_OFFSET_CAPTURE) ? end($mg[0])[1] : -1;
            if (!preg_match('/\bmoto/u', $escrito) || $ultNormal === $ultGrande) {
                return array('ok' => false, 'falta' => $conModelo ? 'el tamaño de la moto de agua (no se encontró su largo) · lo ve JP' : 'la marca y el modelo de la moto de agua', 'jp' => $conModelo);
            }
            $clave = $ultNormal > $ultGrande ? 'moto-normal' : 'moto-grande';
            $fuente = 'cliente';
        }
    } else {
        // Marca, modelo y año: sin ellos no se busca el LOA ni se cotiza.
        // Igual que el correo y el año: tienen que estar en lo que escribió el
        // cliente. Una marca o un modelo que Claude dedujo buscan otro LOA.
        if (!deckeva_wa_cotiza_en_texto($d['marca'] ?? '', $escrito)) return array('ok' => false, 'falta' => 'la marca de la embarcación');
        if (!deckeva_wa_cotiza_en_texto($d['modelo'] ?? '', $escrito)) return array('ok' => false, 'falta' => 'el modelo de la embarcación');
        // El año se vuelve a buscar en lo escrito, como el largo: un año que
        // Claude dedujo cambia el LOA que se busca. Vale entero («2019») o
        // corto sólo si se nota que es un año («del 98», «año 98», «'98»): un
        // «19» suelto casi siempre es el largo.
        $anio = trim((string) ($d['anio'] ?? ''));
        $anioOk = preg_match('/^(?:19|20)?(\d{2})$/', $anio, $am)
            && preg_match('/(?<!\d)(?:19|20)' . $am[1] . '(?!\d)|(?:(?:\bdel|\ba[nñ]o|\bmodelo|\byear)\s*|[\'’])' . $am[1] . '(?!\d)/u', $escrito);
        // Un «98» suelto vale si es la respuesta a una pregunta por el año
        // (Codex): el mensaje anterior nuestro preguntó el año y el cliente
        // contestó sólo eso.
        if (!$anioOk && isset($am[1])) {
            $preguntoAnio = false;
            foreach ($mensajes as $m) {
                $txt = trim(mb_strtolower((string) ($m['texto'] ?? '')));
                if (($m['dir'] ?? '') !== 'in') { $preguntoAnio = (bool) preg_match('/\ba[nñ]o\b|\byear\b/u', $txt); continue; }
                if ($preguntoAnio && preg_match('/^(?:del\s+)?(?:19|20)?' . $am[1] . '\.?$/u', $txt)) { $anioOk = true; break; }
                $preguntoAnio = false;
            }
        }
        if (!$anioOk) return array('ok' => false, 'falta' => 'el año de la embarcación');
        // Regla de JP (29-sep): el largo lo dan las especificaciones del
        // fabricante (LOA), buscadas con marca, modelo y año, y mandan sobre lo
        // que diga el cliente. Sin specs, el largo que ESCRIBIÓ el cliente
        // (leído del texto, no de lo que devolvió Claude). En los dos casos:
        // hasta ,4 baja al entero anterior y desde ,5 sube al siguiente.
        if (is_array($loa) && (float) ($loa['pies'] ?? 0) > 0) {
            $pies = (float) $loa['pies'];
            $fuente = 'specs';
        } else {
            $pies = deckeva_wa_cotiza_largo_escrito($escrito, $lineas);
            $fuente = 'cliente';
            if ($pies === null) return array('ok' => false, 'falta' => 'el largo en pies de la embarcación');
        }
        $clave = (string) deckeva_wa_cotiza_redondear($pies);
    }
    if (!isset($tabla[$clave])) return array('ok' => false, 'falta' => $clave . ' no está en la tabla · lo ve JP', 'jp' => true);
    if (trim((string) ($d['color'] ?? '')) === '') return array('ok' => false, 'falta' => 'el color');
    // Dónde está (ciudad, lago o marina): lo pide JP para lancha y para moto de
    // agua. Es lo que decide cómo se hace la toma de medidas y la instalación.
    $ubicacion = trim((string) ($d['ubicacion'] ?? ''));
    if ($ubicacion === '' || in_array(mb_strtolower($ubicacion), array('chile', 'no dice', 'no_dice'), true) || !deckeva_wa_cotiza_en_texto($ubicacion, $escrito, true)) {
        return array('ok' => false, 'falta' => 'dónde está la ' . ($clave === 'moto-normal' || $clave === 'moto-grande' ? 'moto de agua' : 'embarcación') . ' (ciudad, lago o marina)');
    }
    return array('ok' => true, 'clave' => $clave, 'precio' => $tabla[$clave], 'pies' => $pies ?? null, 'fuente_largo' => $fuente ?? 'moto');
}

/**
 * ¿Este dato está en lo que escribió el cliente? Al menos una palabra suya
 * (3+ letras, o con un dígito: «195», «LS2») aparece tal cual, sin tildes ni
 * mayúsculas. Con $minimo = 2 vale también una palabra de dos letras, para
 * modelos como el Yamaha EX o FX. Para un lugar no cuentan las palabras genéricas («lago»,
 * «marina», «región»): «Lago Rapel» vale por «rapel».
 */
function deckeva_wa_cotiza_en_texto($valor, $escrito, $esLugar = false, $minimo = 3) {
    $norm = static function ($t) {
        $t = mb_strtolower((string) $t);
        $t = function_exists('remove_accents') ? remove_accents($t) : strtr($t, array('á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u', 'ü' => 'u', 'ñ' => 'n'));
        return ' ' . preg_replace('/[^a-z0-9]+/', ' ', $t) . ' ';
    };
    $texto = $norm($escrito);
    $genericas = array('lago', 'laguna', 'marina', 'region', 'chile', 'ciudad', 'puerto', 'bahia', 'playa', 'club', 'nautico', 'costa', 'sector', 'provincia', 'comuna');
    foreach (preg_split('/\s+/', trim($norm($valor))) as $w) {
        if ($w === '' || (strlen($w) < $minimo && !preg_match('/\d/', $w))) continue;
        if ($esLugar && in_array($w, $genericas, true)) continue;
        if (strpos($texto, ' ' . $w . ' ') !== false) return true;
    }
    return false;
}

/** Regla de JP: hasta ,4 baja al entero anterior; desde ,5 sube al siguiente. */
function deckeva_wa_cotiza_redondear($pies) {
    $pies = (float) $pies;
    $entero = floor($pies);
    // Tolerancia mínima, sólo para el ruido de coma flotante (24 + 6/12).
    return (int) (($pies - $entero) >= 0.5 - 1e-9 ? $entero + 1 : $entero);
}

/**
 * El largo que escribió el cliente, como largo: «19 pies», «22,4 ft», «19'»,
 * «24' 6\"» (pies y pulgadas), o el número solo en un mensaje. Si lo dijo más
 * de una vez, vale el último en el orden de la conversación (se corrigió:
 * «perdón, son 22,4 pies»). null si no hay ninguno.
 */
function deckeva_wa_cotiza_largo_escrito($escrito, array $lineas) {
    if (!$lineas) $lineas = array((string) $escrito);
    $ultimo = null;
    $re = '/(?<![\d.,])(\d{1,2}(?:[.,]\d{1,2})?)\s*(?:pies|pie|ft|feet|\'|’)(?:\s*(\d{1,2}(?:[.,]\d{1,2})?)\s*(?:"|”|\'\'|’’|pulgadas|pulgada|pulg|in)(?![\p{L}]))?/u';
    foreach ($lineas as $l) {
        $l = trim((string) $l);
        // Un número solo vale como largo si puede ser un largo: un «98» que
        // contesta «¿de qué año es?» no pisa los «19 pies» de antes.
        if (preg_match('/^(\d{1,2}(?:[.,]\d{1,2})?)$/u', $l, $mm)) { $v = (float) str_replace(',', '.', $mm[1]); if ($v >= 8 && $v <= 60) $ultimo = $v; continue; }
        if (preg_match_all($re, $l, $m, PREG_SET_ORDER)) {
            $u = end($m);
            $v = (float) str_replace(',', '.', $u[1]);
            // Pulgadas: sólo si el pie es entero y son menos de 12.
            if (isset($u[2]) && $u[2] !== '') {
                $pul = (float) str_replace(',', '.', $u[2]);
                if ($pul < 12 && floor($v) == $v) $v += $pul / 12;
            }
            $ultimo = $v;
        }
    }
    return ($ultimo !== null && $ultimo >= 8 && $ultimo <= 60) ? $ultimo : null;
}

/**
 * El largo total (LOA) según las especificaciones, buscado en internet con
 * marca, modelo y año. Se guarda por modelo: el mismo bote no se busca dos
 * veces. Devuelve array('pies' => 24.5, 'como_figura' => "24' 6\"", 'fuente' =>
 * url) o array('pies' => 0, ...) si no hay un dato seguro.
 */
function deckeva_wa_cotiza_loa($marca, $modelo, $anio) {
    $marca = trim((string) $marca); $modelo = trim((string) $modelo); $anio = trim((string) $anio);
    if ($marca === '' || $modelo === '' || deckeva_wa_llave() === '') return array('pies' => 0);
    $clave = 'deckeva_wa_loa_' . md5(mb_strtolower($marca . '|' . $modelo . '|' . $anio));
    $cache = get_option($clave, null);
    if (is_array($cache) && (($cache['pies'] ?? 0) > 0 || time() - (int) ($cache['ts'] ?? 0) < 7 * 86400)) return $cache;

    $pedido = "Embarcación: marca «{$marca}», modelo «{$modelo}»" . ($anio !== '' ? ", año {$anio}" : ', año no informado') . ".\n"
        . "Busca en internet su largo total (LOA, length overall) según las especificaciones del fabricante o de fichas técnicas confiables. "
        . "Si el año cambia el largo y no está informado, o las fuentes no coinciden, o no encuentras ese modelo exacto, marca seguro=false.\n"
        . "Termina tu respuesta con UN objeto JSON y nada después: "
        . "{\"loa_pies\": número en pies decimales (las pulgadas divididas por 12) o null, \"como_figura\": el largo tal como aparece en la fuente, \"fuente\": la URL, \"seguro\": true o false}";
    $mensajes = array(array('role' => 'user', 'content' => $pedido));
    $texto = '';
    for ($vuelta = 0; $vuelta < 3; $vuelta++) {
        $res = wp_remote_post('https://api.anthropic.com/v1/messages', array(
            'timeout' => 90,
            'headers' => array('x-api-key' => deckeva_wa_llave(), 'anthropic-version' => '2023-06-01', 'anthropic-beta' => 'server-side-fallback-2026-07-01', 'content-type' => 'application/json'),
            'body' => wp_json_encode(array(
                'model' => DECKEVA_WA_MODELO, 'max_tokens' => 4000, 'fallbacks' => 'default',
                'output_config' => array('effort' => 'medium'),
                'tools' => array(array('type' => 'web_search_20260209', 'name' => 'web_search', 'max_uses' => 4)),
                'messages' => $mensajes,
            )),
        ));
        if (is_wp_error($res) || (int) wp_remote_retrieve_response_code($res) !== 200) return array('pies' => 0);
        $j = json_decode((string) wp_remote_retrieve_body($res), true);
        if (!is_array($j) || ($j['stop_reason'] ?? '') === 'refusal') return array('pies' => 0);
        foreach ((array) ($j['content'] ?? array()) as $b) if (($b['type'] ?? '') === 'text') $texto .= (string) $b['text'];
        // Una búsqueda larga puede volver en pausa: se sigue donde quedó.
        if (($j['stop_reason'] ?? '') !== 'pause_turn') break;
        $mensajes[] = array('role' => 'assistant', 'content' => $j['content']);
    }
    $out = array('pies' => 0, 'ts' => time());
    if (preg_match_all('/\{[^{}]*"loa_pies"[^{}]*\}/s', $texto, $m)) {
        $d = json_decode(end($m[0]), true);
        $pies = is_array($d) ? (float) ($d['loa_pies'] ?? 0) : 0;
        $fuente = is_array($d) ? trim((string) ($d['fuente'] ?? '')) : '';
        if (is_array($d) && !empty($d['seguro']) && $pies >= 8 && $pies <= 60 && preg_match('#^https?://#', $fuente)) {
            // Sin recortar decimales: 22,499 redondeado a 2 daría 22,50 y subiría de tarifa.
            $out = array('pies' => $pies, 'como_figura' => substr((string) ($d['como_figura'] ?? ''), 0, 40), 'fuente' => $fuente, 'ts' => time());
        }
    }
    update_option($clave, $out, false);
    return $out;
}

/** Los datos del PDF, con la misma forma que usa el cotizador de la home. */
function deckeva_wa_cotiza_datos_pdf(array $d, array $listo, $numero, $telefono) {
    $meses = array(1 => 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
    $hoy = new DateTimeImmutable('now', new DateTimeZone('America/Santiago'));
    $iva = (int) round($listo['precio'] * 0.19);
    $tamano = ctype_digit($listo['clave']) ? $listo['clave'] . ' pies' : ($listo['clave'] === 'moto-normal' ? 'Moto de agua normal' : 'Moto de agua mediana a grande');
    if (class_exists('Deckeva_Cotizador') && method_exists('Deckeva_Cotizador', 'tamano_texto')) {
        $t = Deckeva_Cotizador::tamano_texto($listo['clave']);
        if (is_string($t) && $t !== '') $tamano = $t;
    }
    return array(
        'numero' => $numero,
        'fecha' => $hoy->format('j') . ' de ' . $meses[(int) $hoy->format('n')] . ' de ' . $hoy->format('Y'),
        'cliente' => array('nombre' => trim($d['nombre'] . ' ' . ($d['apellido'] ?? '')), 'email' => strtolower(trim($d['email'])), 'telefono' => '+' . $telefono, 'pais' => trim((string) ($d['pais'] ?? '')) ?: 'Chile'),
        'embarcacion' => array('tamano' => $tamano, 'modelo' => trim(($d['marca'] ?? '') . ' ' . ($d['modelo'] ?? '')), 'anio' => (string) ($d['anio'] ?? ''), 'color' => (string) ($d['color'] ?? '')),
        'precio' => array('a_consultar' => false, 'subtotal' => deckeva_wa_cotiza_clp($listo['precio']), 'iva' => deckeva_wa_cotiza_clp($iva), 'total' => deckeva_wa_cotiza_clp($listo['precio'] + $iva), 'ref_usd' => '', 'tipo_cambio' => ''),
    );
}

/**
 * Una pasada · la llama deckeva_wa_pasada() cada minuto. A lo más dos lecturas de
 * Claude por pasada. Todo lo que cambia un chat se guarda con el candado y sólo si
 * nadie lo tocó mientras tanto.
 */
function deckeva_wa_cotiza_pasada() {
    $lecturas = 0;
    $tabla = null;
    foreach (array_keys(deckeva_wa_chats()) as $num) {
        $num = (string) $num;
        $chat = deckeva_wa_chats()[$num] ?? null;
        if (!is_array($chat)) continue;
        $c = $chat['cotizacion'] ?? null;
        $ultIn = 0; $escrito = '';
        foreach ((array) $chat['mensajes'] as $m) if (($m['dir'] ?? '') === 'in') { $ultIn = max($ultIn, (int) $m['ts']); $escrito .= ' ' . $m['texto']; }
        // ¿Escribió algo desde la última vez que se leyó este chat? Si corrigió
        // el largo, el color o el correo, la cotización se rehace (abajo).
        $nuevo = !is_array($c) || $ultIn > (int) ($c['leido_hasta'] ?? 0);
        // Una cotización sin enviar armada con las reglas de antes (29-sep:
        // marca, modelo, año y ubicación obligatorios) se relee antes de salir.
        // v3 (29-sep, T-017): el tamaño de la moto lo decide el largo. Una moto
        // armada con v2 (el tamaño que dijo el cliente) se rehace; una lancha
        // v2 no cambió de regla y se queda.
        $firmaC = (string) ($c['firma'] ?? '');
        $vigente = strpos($firmaC, 'v3|') === 0 || (strpos($firmaC, 'v2|') === 0 && strpos($firmaC, 'v2|moto-') !== 0);
        $legado = is_array($c) && in_array($c['estado'] ?? '', array('lista', 'aprobada'), true) && !$vigente;
        $nuevo = $nuevo || $legado;

        // 0 · Pidió un muelle flotante DESPUÉS de que se armó su cotización:
        // la que estaba no sale, la ve JP (T-017). Queda «retenida» y no vuelve
        // a lista/aprobada sola: si pide el piso otra vez, se arma una nueva.
        if (is_array($c) && in_array($c['estado'] ?? '', array('lista', 'aprobada'), true)
            && deckeva_wa_es_muelle((array) $chat['mensajes'], (int) ($c['creada'] ?? 0) + 1)) {
            deckeva_wa_con_candado(function ($chats) use ($num) {
                if (isset($chats[$num]['cotizacion']) && in_array($chats[$num]['cotizacion']['estado'] ?? '', array('lista', 'aprobada'), true)) {
                    $chats[$num]['cotizacion']['estado'] = 'retenida';
                    $chats[$num]['cotizacion']['falta'] = 'pidió un muelle flotante · lo ve JP';
                    $chats[$num]['cotizacion']['jp'] = true;
                    deckeva_wa_anotar($chats[$num], 'cotización ' . ($chats[$num]['cotizacion']['numero'] ?? '') . ' retenida · pidió un muelle flotante');
                }
                return $chats;
            });
            continue;
        }

        // 1 · Mandar lo aprobado, a su hora · sólo si no escribió nada después.
        if (is_array($c) && ($c['estado'] ?? '') === 'aprobada' && !$nuevo) {
            if (time() >= (int) $c['en'] && deckeva_wa_habil(time()) && deckeva_wa_cotiza_cupo()) deckeva_wa_cotiza_enviar($num);
            continue;
        }
        if (!$nuevo) continue;

        // 2 · Leer, sólo si el cliente dejó un correo y ya terminó de escribir.
        if ($ultIn === 0 || time() - $ultIn < DECKEVA_WA_SILENCIO || time() - $ultIn > 7 * 86400) continue;
        if (!preg_match('/[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}/', $escrito)) continue;
        if ($lecturas >= 2) break;
        $lecturas++;

        if ($tabla === null) $tabla = deckeva_wa_cotiza_tabla();
        $huella = deckeva_wa_huella($chat);
        $r = deckeva_wa_cotiza_leer((array) $chat['mensajes']);
        if (!$r['ok']) continue;
        $loa = null;
        if (in_array($r['d']['tipo'] ?? '', array('lancha', 'no_dice', 'moto', 'moto_normal', 'moto_grande'), true)) $loa = deckeva_wa_cotiza_loa($r['d']['marca'] ?? '', $r['d']['modelo'] ?? '', $r['d']['anio'] ?? '');
        $listo = deckeva_wa_cotiza_listo($r['d'], (array) $chat['mensajes'], $tabla, $loa);
        // Todo lo que cambia el PDF: si el cliente corrige el año o dónde está,
        // la cotización se rehace aunque el precio sea el mismo.
        $firma = $listo['ok'] ? 'v3|' . implode('|', array($listo['clave'], strtolower(trim($r['d']['email'])), mb_strtolower(trim($r['d']['color'])), mb_strtolower(trim($r['d']['nombre'] . ' ' . $r['d']['apellido'])),
            mb_strtolower(trim((string) ($r['d']['marca'] ?? ''))), mb_strtolower(trim((string) ($r['d']['modelo'] ?? ''))), trim((string) ($r['d']['anio'] ?? '')), mb_strtolower(trim((string) ($r['d']['ubicacion'] ?? ''))))) : '';
        $armada = is_array($c) && in_array($c['estado'] ?? '', array('lista', 'aprobada', 'enviada', 'descartada'), true);
        // Ya hay una cotización y lo nuevo no cambia nada (un «gracias», una
        // pregunta): se queda la que está, sin otro PDF ni otro correo. Si lo
        // nuevo no alcanza para cotizar, tampoco se deshace la que había.
        // Una legada que ya no alcanza sí se deshace: no puede salir con las reglas de antes.
        if ($armada && !$legado && ($firma === '' || $firma === ($c['firma'] ?? ''))) {
            deckeva_wa_con_candado(function ($chats) use ($num, $ultIn) {
                if (isset($chats[$num]['cotizacion'])) $chats[$num]['cotizacion']['leido_hasta'] = max($ultIn, (int) ($chats[$num]['cotizacion']['leido_hasta'] ?? 0));
                return $chats;
            });
            continue;
        }
        $nueva = array('estado' => 'incompleta', 'leido_hasta' => $ultIn, 'falta' => $listo['falta'] ?? '', 'jp' => !empty($listo['jp']));
        $pdfBytes = null;
        if ($listo['ok']) {
            $numero = 'DCK-WA-' . (new DateTimeImmutable('now', new DateTimeZone('America/Santiago')))->format('YmdHis') . '-' . strtoupper(substr(md5($num . '|' . $ultIn), 0, 5));
            $datos = deckeva_wa_cotiza_datos_pdf($r['d'], $listo, $numero, $num);
            $pdfBytes = (class_exists('Deckeva_Cotizador') && method_exists('Deckeva_Cotizador', 'pdf_diseno_nuevo')) ? Deckeva_Cotizador::pdf_diseno_nuevo($datos) : null;
            if (!is_string($pdfBytes) || strncmp($pdfBytes, '%PDF', 4) !== 0) {
                $nueva = array('estado' => 'incompleta', 'leido_hasta' => $ultIn, 'falta' => 'no se pudo generar el PDF · lo ve JP', 'jp' => true);
            } else {
                // Fuera de la web: la carpeta de leads está cerrada (Deny from all).
                // El PDF tiene nombre, correo y teléfono; a JP y al cliente les
                // llega adjunto, no por un link.
                $up = wp_upload_dir(null, false);
                $dir = trailingslashit($up['basedir']) . 'deckeva-leads/cotizaciones-wa';
                if (!is_dir($dir)) wp_mkdir_p($dir);
                if (!file_exists($dir . '/.htaccess')) @file_put_contents($dir . '/.htaccess', "Order deny,allow\nDeny from all\n<IfModule mod_authz_core.c>\n    Require all denied\n</IfModule>\n");
                $archivo = 'DECKEVA-Cotizacion-' . $numero . '.pdf';
                file_put_contents($dir . '/' . $archivo, $pdfBytes);
                $auto = deckeva_wa_cotiza_modo() === 'automatico';
                $semilla = $num . '|' . $ultIn . '|cotiza';
                $nueva = array(
                    'estado' => $auto ? 'aprobada' : 'lista', 'numero' => $numero, 'leido_hasta' => $ultIn,
                    'pdf' => $dir . '/' . $archivo,
                    'datos' => $datos, 'creada' => time(),
                    'en' => deckeva_wa_en_horario($ultIn + deckeva_wa_demora($semilla), $semilla),
                    'aprobada_por' => $auto ? 'automático' : '', 'firma' => $firma,
                    'largo' => array('pies' => $listo['pies'], 'clave' => $listo['clave'], 'fuente' => $listo['fuente_largo'], 'como_figura' => $loa['como_figura'] ?? '', 'url' => $loa['fuente'] ?? ''),
                    // La que reemplaza (el cliente cambió un dato), para que se vea.
                    'reemplaza' => ($armada && ($c['estado'] ?? '') !== 'enviada') ? (string) ($c['numero'] ?? '') : '',
                );
            }
        }
        $guardado = false;
        deckeva_wa_con_candado(function ($chats) use ($num, $huella, $nueva, &$guardado) {
            if (!isset($chats[$num]) || deckeva_wa_huella($chats[$num]) !== $huella) return $chats;
            $chats[$num]['cotizacion'] = $nueva;
            deckeva_wa_anotar($chats[$num], ($nueva['numero'] ?? 'cotización') . ' · ' . $nueva['estado'] . (($nueva['falta'] ?? '') !== '' ? ' · falta ' . $nueva['falta'] : ''));
            $guardado = true;
            return $chats;
        });
        if (!$guardado && isset($nueva['pdf'])) @unlink($nueva['pdf']);
        if ($guardado && $armada && isset($nueva['pdf']) && ($c['estado'] ?? '') !== 'enviada' && !empty($c['pdf'])) @unlink((string) $c['pdf']);
        if ($guardado && ($nueva['estado'] === 'lista' || !empty($nueva['jp']))) deckeva_wa_cotiza_avisar_jp($num, $nueva);
    }
}

/**
 * El hosting deja de entregar correos externos pasados unos 25 por hora, y no
 * avisa (CLAUDE.md). Cada cotización son dos (cliente y copia oculta), y hay
 * formularios y avisos que comparten el cupo: a lo más 6 cotizaciones por hora.
 * Las que no entran esperan a la hora siguiente.
 */
const DECKEVA_WA_COTIZA_POR_HORA = 6;
function deckeva_wa_cotiza_cupo() {
    $clave = 'deckeva_wa_cotiza_' . gmdate('YmdH');
    return (int) get_transient($clave) < DECKEVA_WA_COTIZA_POR_HORA;
}
function deckeva_wa_cotiza_contar() {
    $clave = 'deckeva_wa_cotiza_' . gmdate('YmdH');
    set_transient($clave, (int) get_transient($clave) + 1, 2 * HOUR_IN_SECONDS);
}

/** El correo al cliente · desde contacto@deckeva.cl, con copia oculta a JP. */
function deckeva_wa_cotiza_enviar($num) {
    $c = deckeva_wa_chats()[$num]['cotizacion'] ?? null;
    if (!is_array($c) || ($c['estado'] ?? '') !== 'aprobada' || !is_readable((string) $c['pdf'])) return false;
    $d = $c['datos'];
    $nombre = strtok((string) $d['cliente']['nombre'], ' ');
    $bote = trim((string) $d['embarcacion']['modelo']) !== '' ? 'tu ' . $d['embarcacion']['modelo'] : 'tu embarcación';
    $cuerpo = "Hola {$nombre},\n\n"
        . "Te adjunto la cotización del piso de goma EVA para {$bote}, en {$d['embarcacion']['color']}, como me contaste por WhatsApp.\n\n"
        . "La toma de medidas y la instalación son opcionales: en el PDF va su valor por si prefieres que las hagamos nosotros, y si quieres hacerlas tú mismo, te mandamos el video explicativo paso a paso.\n\n"
        . "Cualquier duda, respóndeme este correo o escríbeme por WhatsApp.\n\n"
        . "Juan Pablo\nDeckeva";
    $html = '<div style="font-family:Arial,Helvetica,sans-serif;font-size:15px;line-height:1.6;color:#1a2a3a">' . wpautop(esc_html($cuerpo)) . '</div>';
    $headers = function_exists('deckeva_mail_headers_cliente') ? deckeva_mail_headers_cliente($d['cliente']['email']) : array('Content-Type: text/html; charset=UTF-8');
    deckeva_wa_cotiza_contar();
    $ok = wp_mail($d['cliente']['email'], 'Tu cotización Deckeva · ' . $c['numero'], $html, $headers, array($c['pdf']));
    deckeva_wa_con_candado(function ($chats) use ($num, $c, $ok) {
        $x = $chats[$num]['cotizacion'] ?? null;
        if (!is_array($x) || ($x['numero'] ?? '') !== $c['numero']) return $chats;
        if ($ok) { $x['estado'] = 'enviada'; $x['enviada_ts'] = time(); }
        else { $x['intentos'] = (int) ($x['intentos'] ?? 0) + 1; if ($x['intentos'] >= 5) $x['estado'] = 'error'; }
        $chats[$num]['cotizacion'] = $x;
        deckeva_wa_anotar($chats[$num], $c['numero'] . ($ok ? ' enviada al correo del cliente' : ' no salió el correo (intento ' . $x['intentos'] . ')'));
        return $chats;
    });
    if ($ok && function_exists('deckeva_record_lead')) {
        deckeva_record_lead('whatsapp', array('Cotización' => $c['numero'], 'Nombre' => $d['cliente']['nombre'], 'Email' => $d['cliente']['email'], 'Teléfono' => $d['cliente']['telefono'], 'Embarcación' => $d['embarcacion']['modelo'] . ' · ' . $d['embarcacion']['tamano'], 'Total' => $d['precio']['total'], 'Vía' => 'WhatsApp · ' . ($c['aprobada_por'] ?: 'JP')));
    }
    return $ok;
}

/** De dónde salió el largo, para que JP lo pueda revisar. */
function deckeva_wa_cotiza_largo_html(array $c) {
    $l = $c['largo'] ?? null;
    if (!is_array($l) || empty($l['pies'])) return '';
    $txt = ($l['fuente'] ?? '') === 'specs'
        ? 'Largo según especificaciones: ' . ($l['como_figura'] !== '' ? $l['como_figura'] . ' = ' : '') . str_replace('.', ',', (string) $l['pies']) . ' pies'
        : 'Largo según lo que escribió el cliente: ' . str_replace('.', ',', (string) $l['pies']) . ' pies (no se encontraron especificaciones seguras)';
    // Una moto no se cotiza por pies: el largo decide normal o mediana/grande.
    if (strpos((string) ($l['clave'] ?? ''), 'moto-') === 0) {
        $m = round((float) $l['pies'] * 0.3048, 2);
        $txt .= ' (' . str_replace('.', ',', (string) $m) . ' m) → ' . ($m < DECKEVA_MOTO_CORTE_M ? 'bajo' : 'sobre') . ' el corte de ' . str_replace('.', ',', (string) DECKEVA_MOTO_CORTE_M) . ' m: se cotiza como moto ' . ($l['clave'] === 'moto-normal' ? 'normal' : 'mediana a grande') . '.';
    } else {
        $txt .= ' → se cotiza a ' . deckeva_wa_cotiza_redondear($l['pies']) . ' pies.';
    }
    return '<p style="color:#555">' . esc_html($txt) . (($l['url'] ?? '') !== '' ? ' <a href="' . esc_url($l['url']) . '">Fuente</a>' : '') . '</p>';
}

function deckeva_wa_cotiza_avisar_jp($num, array $c) {
    $lnk = admin_url('options-general.php?page=deckeva-whatsapp');
    if (($c['estado'] ?? '') === 'lista') {
        $d = $c['datos'];
        $html = '<div style="font-family:Arial,sans-serif;font-size:14px;color:#111">'
            . '<p>Cotización lista para +' . esc_html($num) . ', armada con los datos que dejó por WhatsApp y el precio de la tabla del home.</p>'
            . '<p><b>' . esc_html($d['cliente']['nombre']) . '</b> · ' . esc_html($d['embarcacion']['modelo']) . ' · ' . esc_html($d['embarcacion']['tamano']) . ' · ' . esc_html($d['embarcacion']['color']) . '<br>Total ' . esc_html($d['precio']['total']) . ' (IVA incluido)</p>'
            . deckeva_wa_cotiza_largo_html($c)
            . '<p>Sale al cliente cuando apretes «Enviar». El PDF va adjunto para que lo revises.</p>'
            . '<p><a href="' . esc_url($lnk) . '" style="background:#0e6ba8;color:#fff;padding:9px 16px;border-radius:6px;text-decoration:none">Revisar y enviar</a></p></div>';
        wp_mail(deckeva_wa_aprobador(), 'Cotización ' . $c['numero'] . ' lista · ' . $d['cliente']['nombre'], $html, deckeva_mail_headers(), array($c['pdf']));
    } else {
        $html = '<div style="font-family:Arial,sans-serif;font-size:14px;color:#111"><p>El chat de +' . esc_html($num) . ' pidió cotización y no se puede armar sola: ' . esc_html($c['falta']) . '.</p>'
            . '<p><a href="' . esc_url($lnk) . '">WhatsApp Deckeva</a></p></div>';
        wp_mail(deckeva_wa_aprobador(), '⚠ Cotización para revisar · +' . $num, $html, deckeva_mail_headers());
    }
}

/** Enviar o descartar desde wp-admin · la cotización que JP estaba mirando. */
add_action('admin_post_deckeva_wa_cotiza', function () {
    if (!current_user_can('manage_options')) wp_die('No autorizado');
    check_admin_referer('deckeva_wa_cotiza');
    $accion = sanitize_key($_POST['accion'] ?? '');
    $msg = '';
    if ($accion === 'modo') {
        update_option('deckeva_wa_cotiza_modo', ($_POST['modo'] ?? '') === 'automatico' ? 'automatico' : 'borrador', false);
        $msg = 'Guardado.';
    } else {
        $num = preg_replace('/\D+/', '', (string) ($_POST['numero'] ?? ''));
        $numero = sanitize_text_field(wp_unslash($_POST['cotizacion'] ?? ''));
        deckeva_wa_con_candado(function ($chats) use ($num, $numero, $accion, &$msg) {
            $c = $chats[$num]['cotizacion'] ?? null;
            if (!is_array($c) || ($c['estado'] ?? '') !== 'lista' || ($c['numero'] ?? '') !== $numero) { $msg = 'Esa cotización ya no está esperando.'; return $chats; }
            if ($accion === 'enviar') { $c['estado'] = 'aprobada'; $c['aprobada_por'] = 'JP · wp-admin'; $c['en'] = max((int) $c['en'], time()); $msg = 'Aprobada · sale en el próximo minuto hábil.'; }
            elseif ($accion === 'descartar') { $c['estado'] = 'descartada'; $msg = 'Descartada · no sale.'; }
            $chats[$num]['cotizacion'] = $c;
            deckeva_wa_anotar($chats[$num], $numero . ' ' . ($accion === 'enviar' ? 'aprobada por JP' : 'descartada'));
            return $chats;
        });
    }
    wp_safe_redirect(add_query_arg('msg', rawurlencode($msg), admin_url('options-general.php?page=deckeva-whatsapp')));
    exit;
});

/** La sección de cotizaciones en Ajustes → WhatsApp Deckeva. */
function deckeva_wa_cotiza_pantalla() {
    echo '<h2>Cotizaciones desde WhatsApp</h2><p>' . (deckeva_wa_cotiza_modo() === 'automatico'
        ? '<b>Automático</b>: la cotización sale sola al correo del cliente, 5 a 40 minutos después de su último mensaje.'
        : '<b>Borrador</b>: se arma sola y te espera acá; sale cuando aprietas «Enviar».') . '</p>';
    foreach (deckeva_wa_chats() as $num => $chat) {
        $c = $chat['cotizacion'] ?? null;
        if (!is_array($c) || ($c['estado'] ?? '') !== 'lista') continue;
        $d = $c['datos'];
        echo '<div class="card" style="max-width:780px"><h3>+' . esc_html($num) . ' · ' . esc_html($c['numero']) . '</h3><p>'
            . esc_html($d['cliente']['nombre'] . ' · ' . $d['cliente']['email']) . '<br>' . esc_html($d['embarcacion']['modelo'] . ' · ' . $d['embarcacion']['tamano'] . ' · ' . $d['embarcacion']['color'])
            . '<br><b>Total ' . esc_html($d['precio']['total']) . '</b> · el PDF te llegó al correo</p>'
            . '<form method="post" action="' . esc_url(admin_url('admin-post.php')) . '">';
        wp_nonce_field('deckeva_wa_cotiza');
        echo '<input type="hidden" name="action" value="deckeva_wa_cotiza"><input type="hidden" name="numero" value="' . esc_attr($num) . '"><input type="hidden" name="cotizacion" value="' . esc_attr($c['numero']) . '">'
            . '<button class="button button-primary" name="accion" value="enviar">Enviar al cliente</button> <button class="button" name="accion" value="descartar">Descartar</button></form></div>';
    }
    echo '<form method="post" action="' . esc_url(admin_url('admin-post.php')) . '">';
    wp_nonce_field('deckeva_wa_cotiza');
    echo '<input type="hidden" name="action" value="deckeva_wa_cotiza"><input type="hidden" name="accion" value="modo"><p>Modo de las cotizaciones: <select name="modo">'
        . '<option value="borrador"' . selected(deckeva_wa_cotiza_modo(), 'borrador', false) . '>Borrador · salen cuando las envío</option>'
        . '<option value="automatico"' . selected(deckeva_wa_cotiza_modo(), 'automatico', false) . '>Automático · salen solas</option></select> '
        . '<button class="button">Guardar</button></p></form>';
}
