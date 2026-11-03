<?php
/**
 * Plugin Name: Deckeva - Tarifario de la plataforma de nado
 * Description: El valor del piso EVA de la plataforma de nado sola, por largo
 *              de la embarcación, en un solo lugar y versionado (JP, 3-nov-2026).
 *
 * De dónde sale (JP, 3-nov-2026, textual):
 *
 *   «¿Tienes tarifario de las plataformas de nado? Si no lo tienes ármate uno
 *    desde $450.000 + IVA hasta $650.000 + IVA según los tamaños que tenemos
 *    en el tarifario por pies. Así cuando te pregunten puedas responder los
 *    valores de las plataformas de nado.»
 *
 * Es el caso que el prompt ya nombraba —«se puede hacer sólo una parte (la
 * plataforma de nado, la popa, la zona de los esquís): se cotiza aparte»— y
 * que hasta hoy no tenía ni un número: el valor salía de la cabeza de JP, una
 * vez por cliente, y el siguiente podía salir distinto.
 *
 * ── LA ESCALA ────────────────────────────────────────────────────────────
 *
 * Los mismos largos que el piso completo (14 a 30 pies, los del
 * <select id="sizeSelect"> del home), repartidos LINEALMENTE entre los dos
 * extremos que dio JP:
 *
 *   14 pies → $450.000 neto     30 pies → $650.000 neto
 *   paso = (650.000 − 450.000) / (30 − 14) = $12.500 por pie
 *
 * Lineal y no siguiendo la curva del piso —que de 14 a 30 se multiplica por
 * 3,3— porque el rango que dio JP se multiplica por 1,44: son dos curvas
 * distintas, y repartir el rango de un producto sobre la forma del otro sería
 * inventar algo que él no dijo. Lineal deja los dos extremos EXACTOS en sus
 * números y cada celda en un múltiplo redondo de 12.500.
 *
 * ── TRES COSAS QUE NO SE NEGOCIAN ────────────────────────────────────────
 *
 * 1. LOS VALORES SON NETOS. El IVA (19%) se suma aparte, igual que en el
 *    tarifario de tapicería y que en lo que JP escribe por WhatsApp
 *    («$460.000 + IVA»). El cotizador del piso completo muestra el TOTAL con
 *    IVA, así que un valor de plataforma puesto al lado del de un piso sin
 *    decir que es neto son dos números que no se pueden comparar.
 * 2. EL VALOR NO SALE EN EL CHAT. `deckeva_wa_validar()` bloquea cualquier
 *    texto con un importe y eso no cambia acá: este tarifario existe para
 *    armar la cotización y para que JP conteste.
 * 3. SÓLO LANCHAS. Una moto de agua no tiene plataforma de nado, así que las
 *    claves `moto-normal` y `moto-grande` del tarifario del piso no existen
 *    en éste.
 *
 * El repo es público: acá no hay ningún dato de cliente.
 */

if (!defined('ABSPATH')) {
    exit;
}

/** Plataforma de nado de una lancha de 14 pies, NETO en CLP. */
const DECKEVA_PLATAFORMA_MIN = 450000;

/** Y la de 30 pies. Entre las dos se reparte el resto, linealmente. */
const DECKEVA_PLATAFORMA_MAX = 650000;

/** Los mismos largos que el piso completo. */
const DECKEVA_PLATAFORMA_PIES_MIN = 14;
const DECKEVA_PLATAFORMA_PIES_MAX = 30;

/** El IVA chileno, en porcentaje. Los valores de arriba NO lo incluyen. */
const DECKEVA_PLATAFORMA_IVA = 19;

/**
 * El neto de la plataforma de nado, o null si el largo no está en el rango.
 *
 * Fuera de 14 a 30 pies no se cotiza solo y lo ve JP, igual que el piso: el
 * tarifario del home tampoco llega más allá, y estirar una recta más allá de
 * donde alguien la decidió es inventar un precio.
 *
 * @param int $pies 14 a 30
 * @return int|null CLP neto, sin IVA
 */
function deckeva_plataforma_neto($pies) {
    $pies = (int) $pies;
    if ($pies < DECKEVA_PLATAFORMA_PIES_MIN || $pies > DECKEVA_PLATAFORMA_PIES_MAX) return null;
    $tramos = DECKEVA_PLATAFORMA_PIES_MAX - DECKEVA_PLATAFORMA_PIES_MIN;
    $paso = (DECKEVA_PLATAFORMA_MAX - DECKEVA_PLATAFORMA_MIN) / $tramos;
    return (int) round(DECKEVA_PLATAFORMA_MIN + ($pies - DECKEVA_PLATAFORMA_PIES_MIN) * $paso);
}

/**
 * Neto, IVA y total de la plataforma de nado. null si no se puede cotizar.
 *
 * @return array{neto:int,iva:int,total:int}|null
 */
function deckeva_plataforma_total($pies) {
    $neto = deckeva_plataforma_neto($pies);
    if ($neto === null) return null;
    $iva = (int) round($neto * DECKEVA_PLATAFORMA_IVA / 100);
    return array('neto' => $neto, 'iva' => $iva, 'total' => $neto + $iva);
}

/**
 * El tarifario entero, de 14 a 30 pies: array(pies => array(neto, iva, total)).
 * Lo usa el chequeo de CI, y sirve para imprimirlo cuando hace falta.
 */
function deckeva_plataforma_tabla() {
    $out = array();
    for ($p = DECKEVA_PLATAFORMA_PIES_MIN; $p <= DECKEVA_PLATAFORMA_PIES_MAX; $p++) {
        $out[$p] = deckeva_plataforma_total($p);
    }
    return $out;
}

/**
 * ¿El cliente está pidiendo sólo UNA PARTE del piso?
 *
 * Importa por una razón concreta y cara: `deckeva_wa_cotiza_listo()` cotiza
 * con la tabla del PISO COMPLETO del home, y a un pedido que nombra una
 * lancha le pone `tipo = lancha` aunque el cliente haya pedido nada más que
 * la plataforma. Con las cotizaciones en automático, ese PDF sale solo — y a
 * los 20 pies el piso entero son $1.051.823 netos contra los $525.000 de la
 * plataforma: al cliente le llega, sin que nadie lo mire, un valor del doble
 * por algo que no pidió. Lo marcó el review del #180.
 *
 * Así que un pedido así no se cotiza solo: se le escala a JP, que tiene el
 * tarifario de arriba para ponerle precio.
 *
 * Lista cerrada sobre lo que ESCRIBIÓ el cliente, con la regla de siempre:
 * puede no reconocer una forma, no puede reconocer mal. Por eso «popa» sola
 * queda AFUERA —«el piso de popa a proa» es el piso entero— y sólo entra
 * «plataforma de popa», que es el nombre del producto.
 */
function deckeva_es_parte_suelta($texto) {
    $t = mb_strtolower((string) $texto);
    $t = function_exists('remove_accents') ? remove_accents($t) : strtr($t, array('á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u', 'ü' => 'u', 'ñ' => 'n'));
    return (bool) preg_match(
        '/\bplataforma\s+de\s+nado\b'
        . '|\bplataforma\s+de\s+popa\b'
        . '|\bzona\s+de\s+(los\s+)?esqui\w*\b'
        . '|\b(solo|unicamente)\s+(la\s+)?plataforma\b/u',
        $t
    );
}
