<?php
/**
 * Plugin Name: Deckeva - Tarifario de Tapicería Náutica
 * Description: Los valores de un tapizado completo por tela y por largo de la
 *              embarcación, en un solo lugar y versionados (JP, 26-oct-2026).
 *
 * De dónde salen (JP, 26-oct-2026, textual):
 *
 *   «Tapizado completo para lancha de 18 pies en Sunbrella $1.500.000 / en
 *    Pranna $1.300.000 / en Tevinil Náutico $1.100.000. Y debes sumar
 *    CLP $90.000 por cada pie que vaya creciendo la lancha o bajando $60.000
 *    por cada pie que vaya bajando la lancha/embarcación.»
 *   «Los valores son netos, el IVA se suma aparte.»
 *   «Recuerda señalar que logo de la marca está incluido, para mantener
 *    originalidad de diseño.»
 *
 * Tres cosas que no se negocian:
 *
 * 1. LOS VALORES SON NETOS. El IVA (19%) se suma aparte. El cotizador del home
 *    muestra los pisos con IVA incluido en el total, así que un valor de
 *    tapicería puesto al lado de uno de piso sin decir que es neto son dos
 *    números que no se pueden comparar. Lo que se le dice al cliente es el
 *    total con IVA, con el neto y el IVA desglosados.
 * 2. EL VALOR NO SALE EN EL CHAT. `deckeva_wa_validar()` bloquea cualquier
 *    texto con un importe y eso no cambia acá: el tarifario existe para armar
 *    la cotización y para que JP conteste, no para que el contestador escriba
 *    un monto. La regla del dueño del 26-oct es explícita: el valor se entrega
 *    recién con los tres datos de abajo.
 * 3. ES UN VALOR DE REFERENCIA. «Todo se cotiza a medida según la realidad de
 *    cada embarcación» (JP). La escala por pie ordena la conversación; el
 *    número final sale de ver las fotos.
 *
 * Para cotizar CUALQUIER trabajo que no sea el piso hacen falta tres datos
 * (JP, 26-oct-2026), y son los de `deckeva_trabajos_datos()`.
 *
 * El repo es público: acá no hay ningún dato de cliente.
 */

if (!defined('ABSPATH')) {
    exit;
}

/** Tapizado completo, 18 pies, NETO en CLP. La base de la escala. */
const DECKEVA_TAPICERIA_BASE = array(
    'sunbrella' => 1500000,
    'pranna'    => 1300000,
    'tevinil'   => 1100000,
);

/** El largo sobre el que están escritos los valores de arriba. */
const DECKEVA_TAPICERIA_PIES_BASE = 18;

/** Cada pie POR ARRIBA de la base suma esto. */
const DECKEVA_TAPICERIA_SUBE = 90000;

/** Cada pie POR DEBAJO de la base resta esto. */
const DECKEVA_TAPICERIA_BAJA = 60000;

/** El IVA chileno, en porcentaje. Los valores de arriba NO lo incluyen. */
const DECKEVA_TAPICERIA_IVA = 19;

/**
 * El mismo rango que el piso: fuera de ahí no se cotiza solo, se escala a JP.
 * Con la escala de 60.000 hacia abajo, 14 pies es además el punto donde los
 * tres valores siguen siendo sanos; más corto que eso es otra conversación.
 */
const DECKEVA_TAPICERIA_PIES_MIN = 14;
const DECKEVA_TAPICERIA_PIES_MAX = 30;

/**
 * Las telas con el nombre con que se le dicen al cliente.
 */
const DECKEVA_TAPICERIA_TELAS = array(
    'sunbrella' => 'Sunbrella',
    'pranna'    => 'Pranna',
    'tevinil'   => 'Tevinil Náutico',
);

/**
 * El neto de un tapizado completo, o null si la tela o el largo no están.
 *
 * @param string $tela  sunbrella · pranna · tevinil
 * @param int    $pies  14 a 30
 * @return int|null CLP neto, sin IVA
 */
function deckeva_tapiceria_neto($tela, $pies) {
    $tela = strtolower(trim((string) $tela));
    $pies = (int) $pies;
    if (!isset(DECKEVA_TAPICERIA_BASE[$tela])) return null;
    if ($pies < DECKEVA_TAPICERIA_PIES_MIN || $pies > DECKEVA_TAPICERIA_PIES_MAX) return null;
    $d = $pies - DECKEVA_TAPICERIA_PIES_BASE;
    $base = DECKEVA_TAPICERIA_BASE[$tela];
    return $base + ($d >= 0 ? $d * DECKEVA_TAPICERIA_SUBE : $d * DECKEVA_TAPICERIA_BAJA);
}

/**
 * Neto, IVA y total de un tapizado completo. null si no se puede cotizar.
 *
 * @return array{neto:int,iva:int,total:int}|null
 */
function deckeva_tapiceria_total($tela, $pies) {
    $neto = deckeva_tapiceria_neto($tela, $pies);
    if ($neto === null) return null;
    $iva = (int) round($neto * DECKEVA_TAPICERIA_IVA / 100);
    return array('neto' => $neto, 'iva' => $iva, 'total' => $neto + $iva);
}

/**
 * Lo que SIEMPRE hace falta para cotizar un trabajo en una embarcación
 * (JP, 26-oct-2026). No es una lista de deseos: sin los tres no hay valor.
 */
function deckeva_trabajos_datos() {
    return array(
        'Dónde está la embarcación (ciudad, marina o lugar).',
        'Marca, modelo y año, para saber exactamente qué embarcación es.',
        'Fotos y videos actuales, para ver qué es lo que hay que hacer.',
    );
}

/**
 * Lo que Deckeva hace, además del piso de goma EVA (JP, 26-oct-2026).
 * El piso sigue siendo lo principal y lo que más se hace.
 */
function deckeva_trabajos_lista() {
    return array(
        'Tapicería náutica (Sunbrella, Pranna o Tevinil Náutico)',
        'Fibra de vidrio',
        'Detailing náutico',
        'Pintado de la embarcación',
        'Restauraciones completas, para dejarla como nueva',
        'Pack completo',
        'Revisión eléctrica y mecánica, según el caso',
    );
}

/**
 * El logo de la marca va incluido, para mantener la originalidad del diseño
 * (JP, 26-oct-2026). Vale para el piso y para la tapicería.
 */
const DECKEVA_TAPICERIA_LOGO_INCLUIDO = true;

/**
 * ¿Lo que pidió el cliente es un trabajo a medida de Deckeva?
 *
 * Lista cerrada sobre lo que ESCRIBIÓ el cliente. Acá no hace falta una
 * palabra de embarcación al lado —a diferencia del enrutador de Tourevo, que
 * decide de qué negocio es un chat— porque este chat ya es de Deckeva: si
 * alguien acá dice «pintar» o «restaurar», está hablando de su lancha.
 *
 * Sirve para una cosa sola: un pedido de estos NO lo cotiza la tabla de pisos,
 * y antes se quedaba en silencio («no es un piso EVA · no se cotiza», sin
 * avisarle a nadie). Desde el 26-oct-2026 estos trabajos SON de Deckeva, así
 * que el pedido se le escala a JP para que lo cotice a medida. Misma regla que
 * siempre: puede no reconocer uno, no puede reconocer mal.
 */
function deckeva_es_trabajo_a_medida($texto) {
    $t = mb_strtolower((string) $texto);
    $t = function_exists('remove_accents') ? remove_accents($t) : strtr($t, array('á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u', 'ñ' => 'n'));
    $re = '/\b(re)?tapiz\w*\b|\btapicer[ií]a\b|\bsunbrella\b|\btevinil\b|\bpranna\b'
        . '|\bfibra\s+de\s+vidrio\b|\bgelcoat\b'
        . '|\bdetailing\b|\bpulid\w*\b'
        . '|\bpint(ar|ada|ado|arla|arlo|ura)\b'
        // Las formas de restaurar, UNA POR UNA: «restaur\w*» casa «restaurante»,
        // y un «¿hay un restaurante cerca?» no es un pedido de trabajo. Lo marcó
        // un bot de review sobre el gemelo de esta lista en Tourevo.
        . '|\brestaura(?:r|rla|rlo|rlas|rlos|ci[oó]n|ciones|da|do|das|dos)\b'
        . '|\bpack\s+completo\b/u';
    return (bool) preg_match($re, $t);
}

/**
 * Lugares donde la toma de medidas y la instalación llevan un recargo por
 * traslado que ESTE PDF no calcula (hoy Curacaví, la regla del prompt).
 *
 * Mientras el recargo no esté en el cálculo, una cotización de esos lugares no
 * puede salir sola: le llegaría al cliente con los opcionales al valor
 * estándar y sin el traslado. Con el modo borrador lo agregaba JP mirando el
 * PDF; en automático no hay quién. Así que se retiene para él.
 *
 * El monto NO está acá a propósito: JP nunca lo dio. Inventarlo sería peor que
 * no tenerlo — este archivo existe justamente para que un precio no viva en la
 * cabeza de nadie.
 */
const DECKEVA_UBICACION_RECARGO = array('curacavi');

function deckeva_ubicacion_con_recargo($ubicacion) {
    $t = mb_strtolower((string) $ubicacion);
    $t = function_exists('remove_accents') ? remove_accents($t) : strtr($t, array('á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u', 'ñ' => 'n'));
    $t = ' ' . preg_replace('/[^a-z0-9]+/', ' ', $t) . ' ';
    foreach (DECKEVA_UBICACION_RECARGO as $lugar) {
        if (strpos($t, ' ' . $lugar . ' ') !== false) return $lugar;
    }
    return '';
}
