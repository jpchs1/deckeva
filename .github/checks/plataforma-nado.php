<?php
/**
 * El tarifario de la plataforma de nado es el que dijo JP, y cubre los mismos
 * largos que el piso.
 *
 * JP, 3-nov-2026: «ármate uno desde $450.000 + IVA hasta $650.000 + IVA según
 * los tamaños que tenemos en el tarifario por pies». Los dos extremos son
 * suyos y tienen que quedar EXACTOS; lo del medio es la recta que los une.
 *
 * Y el largo que cubre no se decide acá: se compara contra el
 * <select id="sizeSelect"> del home publicado, que es el tarifario del piso.
 * Si mañana el home agrega un largo, este chequeo lo dice en vez de dejar una
 * plataforma sin precio para una lancha que el piso sí cotiza.
 *
 * Con canario: si no puede leer el tarifario o la tabla del home, es ROJO.
 * Vacío no significa limpio.
 */
define('ABSPATH', __DIR__ . '/');
require __DIR__ . '/../../wp-content/mu-plugins/deckeva-plataforma-nado-valores.php';

$mal = 0;
$exigir = static function (bool $ok, string $que) use (&$mal): void {
    if ($ok) return;
    echo "  ✗ {$que}\n";
    $mal++;
};

// 0 · canario
$tabla = deckeva_plataforma_tabla();
// El canario sólo exige que haya tarifario. CUÁNTOS largos son lo decide la
// comparación contra el home, más abajo: si acá dijera «17» y el home algún
// día agrega un largo, el rojo saldría con el mensaje del canario («no pude
// leer») en vez del que de verdad explica qué pasó.
$exigir(count($tabla) >= 10, 'CANARIO · hay tarifario de plataforma');
$html = (string) @file_get_contents(__DIR__ . '/../../staging/index-cl.html');
$exigir(strlen($html) > 10000, 'CANARIO · se pudo leer el home publicado');
preg_match('/<select[^>]*id="sizeSelect"[^>]*>(.*?)<\/select>/s', $html, $m);
preg_match_all('/value="(\d{2})\|(\d+)"/', $m[1] ?? '', $ops, PREG_SET_ORDER);
$piesDelHome = array();
foreach ($ops as $o) $piesDelHome[] = (int) $o[1];
$exigir(count($piesDelHome) >= 10, 'CANARIO · se pudieron leer los largos del tarifario del piso');
if ($mal) { echo "::error::El chequeo no pudo leer lo que tiene que mirar. Vacío no es limpio.\n"; exit(1); }

// 1 · los dos extremos son los de JP, exactos
$exigir(deckeva_plataforma_neto(14) === 450000, '14 pies son 450.000 netos');
$exigir(deckeva_plataforma_neto(30) === 650000, '30 pies son 650.000 netos');

// 2 · la recta que los une: 12.500 por pie, sin saltos ni centavos
$paso = (DECKEVA_PLATAFORMA_MAX - DECKEVA_PLATAFORMA_MIN) / (DECKEVA_PLATAFORMA_PIES_MAX - DECKEVA_PLATAFORMA_PIES_MIN);
// PHP devuelve int cuando la división es exacta y float cuando no, así que
// esto se compara por valor y no por tipo: un === contra (float) daba rojo
// con el paso exacto, que es justo el caso bueno.
$exigir((float) $paso === floor((float) $paso), 'el paso por pie es un número entero de pesos');
$previo = null;
foreach ($tabla as $pies => $v) {
    $exigir(is_array($v), "{$pies} pies tiene valor");
    if (!is_array($v)) continue;
    $exigir($v['neto'] >= DECKEVA_PLATAFORMA_MIN && $v['neto'] <= DECKEVA_PLATAFORMA_MAX,
        "{$pies} pies queda dentro del rango que dio JP");
    $exigir($v['neto'] % 100 === 0, "{$pies} pies es un monto redondo");
    if ($previo !== null) $exigir($v['neto'] - $previo === (int) $paso, "de " . ($pies - 1) . " a {$pies} pies sube el paso");
    $previo = $v['neto'];
}

// 3 · fuera de rango no se inventa un precio
$exigir(deckeva_plataforma_neto(13) === null, 'menos de 14 pies no se cotiza solo');
$exigir(deckeva_plataforma_neto(31) === null, 'más de 30 pies no se cotiza solo');
$exigir(deckeva_plataforma_total(13) === null, 'y sin neto no hay total');

// 4 · los valores son NETOS y el IVA se suma aparte (JP, 3-nov-2026)
$exigir(DECKEVA_PLATAFORMA_IVA === 19, 'el IVA es 19%');
$v20 = deckeva_plataforma_total(20);
$exigir($v20['neto'] === 525000, '20 pies: 525.000 netos');
$exigir($v20['iva'] === 99750, '…más 99.750 de IVA');
$exigir($v20['total'] === 624750, '…total 624.750');
foreach ($tabla as $pies => $v) {
    $exigir($v['neto'] + $v['iva'] === $v['total'], "{$pies} pies: el total es el neto más el IVA");
    $exigir($v['total'] > $v['neto'], "{$pies} pies: el total con IVA no puede ser el neto");
}

// 5 · cubre los mismos largos que el piso, ni uno menos
foreach ($piesDelHome as $p) {
    $exigir(isset($tabla[$p]), "el piso cotiza {$p} pies y la plataforma también");
}
foreach (array_keys($tabla) as $p) {
    $exigir(in_array($p, $piesDelHome, true), "la plataforma cotiza {$p} pies y el piso también");
}

// 6 · una moto de agua no tiene plataforma de nado
$exigir(!isset($tabla['moto-normal']) && !isset($tabla['moto-grande']), 'no hay plataforma para una moto de agua');

// 7 · el valor no sale en el chat · la regla dura sigue en pie
$wa = (string) file_get_contents(__DIR__ . '/../../wp-content/mu-plugins/deckeva-whatsapp.php');
$exigir(strpos($wa, 'lleva un importe') !== false, 'un texto con importe sigue sin salir por WhatsApp');

// 8 · pedir SÓLO una parte no se cotiza con la tabla del piso (review del #180)
//
// Es el caso caro: el cliente nombra su lancha, Claude le pone tipo = lancha,
// y sin este freno el PDF sale con el piso entero — a los 20 pies, más del
// doble que la plataforma — y en automático se manda solo.
$exigir(function_exists('deckeva_es_parte_suelta'), 'CANARIO · existe el detector de «sólo una parte»');
if (function_exists('deckeva_es_parte_suelta')) {
    foreach (array(
        'Quiero cotizar sólo la plataforma de nado',
        'quiero cotizar por favor piso completo y solo la plataforma de nado',
        'Me interesa la plataforma de popa de mi lancha',
        'Hacen la zona de los esquís?',
        'solo plataforma por ahora',
        'Únicamente la plataforma, el resto después',
    ) as $q) $exigir(deckeva_es_parte_suelta($q), "«{$q}» es sólo una parte");

    // Y lo que NO es: el piso entero sigue cotizándose solo, que es el 99%.
    foreach (array(
        'Quiero un piso de goma EVA para mi lancha de 20 pies',
        'Quiero el piso completo',
        // «popa» sola NO cuenta: esto es el piso entero descrito de otra forma.
        'Quiero el piso de popa a proa',
        'La lancha está en el muelle flotante',
        'Hacen tapicería náutica?',
    ) as $q) $exigir(!deckeva_es_parte_suelta($q), "«{$q}» NO es sólo una parte");

    // El freno vive ANTES de mirar el tipo: con tipo = lancha tiene que cortar
    // igual, porque es justo ahí donde saldría el precio del piso entero.
    $cot = (string) file_get_contents(__DIR__ . '/../../wp-content/mu-plugins/deckeva-whatsapp-cotiza.php');
    $pos_parte = strpos($cot, 'deckeva_es_parte_suelta($escrito)');
    $pos_tipo  = strpos($cot, "if (\$tipo === 'otro') {");
    $exigir($pos_parte !== false && $pos_tipo !== false && $pos_parte < $pos_tipo,
        'el freno de «sólo una parte» se mira ANTES del tipo');
    $exigir(strpos($cot, "'falta' => 'pidió sólo una parte (plataforma de nado, popa o zona de esquís) · la cotiza JP con su tarifario',") !== false,
        'y el motivo dice que la cotiza JP');
    $exigir((bool) preg_match("/deckeva_es_parte_suelta\(\\\$escrito\)\) \{\s*\n\s*return array\(\s*\n\s*'ok' => false,\s*\n\s*'falta' => '[^']+',\s*\n\s*'jp' => true,/", $cot),
        'y se le escala a JP (jp => true), no se queda en silencio');

    // El prompt no puede volver a mandar la plataforma al flujo del piso.
    $exigir(strpos($wa, 'NO la cotiza la tabla del piso') !== false,
        'el prompt dice que la plataforma no la cotiza la tabla del piso');
    $exigir(!preg_match('/plataforma[^.]{0,80}se cotiza igual que el piso/iu', $wa),
        'y ya no dice que se cotiza igual que el piso');
}

// 9 · ningún dato de cliente en lo que se publica (el repo es PÚBLICO)
//
// Lo marcó el review del #180 sobre este mismo PR: la primera versión de
// CLAUDE.md traía el nombre, el teléfono, la lancha y la comuna de un cliente.
// Un tarifario se explica con un largo en pies; no hace falta nadie.
foreach (array('CLAUDE.md', 'wp-content/mu-plugins/deckeva-plataforma-nado-valores.php') as $rel) {
    $txt = (string) file_get_contents(__DIR__ . '/../../' . $rel);
    $exigir(!preg_match('/\+\s?56\s?9[\s\d]{8,}/u', $txt), "{$rel} no publica un teléfono de cliente");
}

if ($mal) {
    echo "::error::{$mal} reparo(s) en el tarifario de la plataforma de nado.\n";
    exit(1);
}
echo 'Plataforma de nado: ' . count($tabla) . " largos, de 450.000 a 650.000 netos, al día con el tarifario del piso.\n";
