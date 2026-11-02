<?php
/**
 * Deckeva no hace sólo pisos, y el contestador no puede volver a decir que sí.
 *
 * El caso (26-oct-2026): José Miguel escribió «me gustaría retapizar esa
 * lancha, cambiarle el piso, y ponerle un toldo alto», con la lancha comprada
 * y llegando a Santiago. El contestador le respondió «tapiz y toldo no los
 * trabajamos» — y el tapiz SÍ se trabaja. La frase salía de una línea del
 * prompt («Deckeva hace SÓLO pisos de goma EVA antideslizante. No hace carpas,
 * toldos, lonas, tapicería ni pintura»), o sea que no fue el modelo
 * inventando: fue lo que le dijimos nosotros.
 *
 * JP, 26-oct-2026: «también realizamos tapicería, fibra de vidrio, detailing
 * náutico, pintado, restauraciones completas para dejar como nuevo y todo de
 * vuelta al 100%». Y: «todo se cotiza a medida según la realidad de cada
 * embarcación, siempre para poder cotizar es necesario saber ubicación; marca,
 * modelo y año; fotos y videos actuales».
 *
 * Este chequeo cobra las dos mitades: que el prompt ya no lo niegue y que
 * nombre los tres datos, y que el tarifario de tapicería calcule lo que JP
 * dijo. Tiene canario: si no puede leer el prompt o el tarifario, es ROJO —
 * un chequeo que recorre un archivo puede dejar de encontrar sin dejar de
 * pasar, y vacío no significa limpio.
 */
define('ABSPATH', __DIR__ . '/');
require __DIR__ . '/../../wp-content/mu-plugins/deckeva-tapiceria-valores.php';

$f = __DIR__ . '/../../wp-content/mu-plugins/deckeva-whatsapp.php';
$src = (string) file_get_contents($f);
$cot = (string) file_get_contents(__DIR__ . '/../../wp-content/mu-plugins/deckeva-whatsapp-cotiza.php');

$mal = 0;
$exigir = static function (bool $ok, string $que) use (&$mal): void {
    if ($ok) return;
    echo "  ✗ {$que}\n";
    $mal++;
};

// 0 · canario. Sin esto, un archivo vacío o renombrado pasaría todo en verde.
$exigir(strlen($src) > 20000, 'CANARIO · se pudo leer el prompt del contestador');
$exigir(strpos($src, 'function deckeva_wa_sistema') !== false, 'CANARIO · el prompt sigue en deckeva_wa_sistema()');
$exigir(strlen($cot) > 10000, 'CANARIO · se pudo leer el módulo de cotizaciones');
$exigir(deckeva_tapiceria_neto('sunbrella', DECKEVA_TAPICERIA_PIES_BASE) !== null, 'CANARIO · el tarifario responde');
if ($mal) { echo "::error::El chequeo no pudo leer lo que tiene que mirar. Vacío no es limpio.\n"; exit(1); }

// 1 · el prompt NO puede volver a negar lo que sí hacemos
$prohibidas = array(
    '/hace\s+S[\x{00D3}O]LO\s+pisos/iu'                             => 'dice que Deckeva hace SÓLO pisos',
    '/No\s+hace[^.\\\\]{0,80}tapicer[\x{00ED}i]a/iu'                => 'dice que no hace tapicería',
    '/No\s+hace[^.\\\\]{0,80}pintura/iu'                            => 'dice que no hace pintura',
    '/(no|nunca)[^.\\\\]{0,40}(trabajamos|hacemos)[^.\\\\]{0,40}(tapiz|tapicer)/iu' => 'dice que no trabajamos el tapiz',
);
foreach ($prohibidas as $re => $que) {
    $exigir(!preg_match($re, $src), "el prompt ya no {$que}");
}

// 2 · y SÍ tiene que nombrar lo que hacemos (JP, 26-oct-2026)
foreach (array('tapicer', 'fibra de vidrio', 'detailing', 'pintado', 'restauracion', 'restauraciones') as $q) {
    if ($q === 'restauracion') continue;
    $exigir(stripos($src, $q) !== false, "el prompt nombra «{$q}»");
}

// 3 · los tres datos obligatorios, en el prompt y en el tarifario
$datos = deckeva_trabajos_datos();
$exigir(count($datos) === 3, 'son tres los datos obligatorios');
foreach (array('nde est', 'marca, modelo y a', 'otos y videos') as $q) {
    $exigir(stripos($src, $q) !== false, "el prompt pide «…{$q}…»");
}

// 4 · el valor no sale en el chat · la regla dura sigue en pie
$exigir((bool) preg_match('/function deckeva_wa_validar/', $src), 'deckeva_wa_validar() sigue existiendo');
$exigir(strpos($src, 'lleva un importe') !== false, 'un texto con importe sigue sin salir');

// 5 · el tarifario calcula lo que dijo JP
$esperado = array('sunbrella' => 1500000, 'pranna' => 1300000, 'tevinil' => 1100000);
foreach ($esperado as $tela => $base) {
    $exigir(deckeva_tapiceria_neto($tela, 18) === $base, "18 pies en {$tela} son {$base} netos");
    $exigir(deckeva_tapiceria_neto($tela, 19) === $base + 90000, "19 pies en {$tela} suman 90.000");
    $exigir(deckeva_tapiceria_neto($tela, 20) === $base + 180000, "20 pies en {$tela} suman 180.000");
    $exigir(deckeva_tapiceria_neto($tela, 17) === $base - 60000, "17 pies en {$tela} bajan 60.000");
    $exigir(deckeva_tapiceria_neto($tela, 16) === $base - 120000, "16 pies en {$tela} bajan 120.000");
}
$exigir(deckeva_tapiceria_neto('sunbrella', 13) === null, 'menos de 14 pies no se cotiza solo');
$exigir(deckeva_tapiceria_neto('sunbrella', 31) === null, 'más de 30 pies no se cotiza solo');
$exigir(deckeva_tapiceria_neto('teca', 18) === null, 'una tela que no manejamos no tiene valor');
$exigir(deckeva_tapiceria_neto('SUNBRELLA', 18) === 1500000, 'la tela no distingue mayúsculas');

// 6 · los valores son NETOS y el IVA se suma aparte (JP, 26-oct-2026)
$exigir(DECKEVA_TAPICERIA_IVA === 19, 'el IVA es 19%');
$t = deckeva_tapiceria_total('sunbrella', 17);
$exigir($t !== null && $t['neto'] === 1440000, '17 pies en Sunbrella: 1.440.000 netos');
$exigir($t !== null && $t['iva'] === 273600, '…más 273.600 de IVA');
$exigir($t !== null && $t['total'] === 1713600, '…total 1.713.600');
$exigir($t !== null && $t['neto'] + $t['iva'] === $t['total'], 'el total es el neto más el IVA, siempre');
$exigir(deckeva_tapiceria_total('teca', 18) === null, 'sin valor no hay total');

// 7 · el logo va incluido
$exigir(DECKEVA_TAPICERIA_LOGO_INCLUIDO === true, 'el logo de la marca va incluido');
$exigir(stripos($src, 'incluido también en la tapicería') !== false, 'el prompt dice que el logo va incluido en la tapicería');

// 8 · las cotizaciones salen solas (JP, 26-oct-2026) y el selector sigue mandando
$exigir((bool) preg_match("/get_option\('deckeva_wa_cotiza_modo',\s*'automatico'\)/", $cot),
    'el modo por defecto de las cotizaciones es automático');
$exigir(strpos($cot, 'deckeva_wa_cotiza_auto_2026_10_26') !== false, 'está la marca de la migración de una sola vez');
$exigir((bool) preg_match("/get_option\('deckeva_wa_cotiza_auto_2026_10_26'\)\s*===\s*'listo'\)\s*return;/", $cot),
    'la migración no se repite: JP puede volver a borrador y queda');
$exigir(strpos($cot, "update_option('deckeva_wa_cotiza_modo', (\$_POST['modo'] ?? '') === 'automatico'") !== false,
    'el selector de wp-admin sigue guardando el modo que elija JP');
// Automático no es «sale cualquier cosa»: sin los datos obligatorios no se arma.
$exigir((bool) preg_match("/'estado' => \\\$auto \? 'aprobada' : 'lista'/", $cot),
    'sólo una cotización completa (listo.ok) pasa a aprobada');

if ($mal) {
    echo "::error::{$mal} reparo(s). El contestador puede estar diciéndole a un cliente que no hacemos algo que sí hacemos.\n";
    exit(1);
}
echo "Deckeva no dice «sólo pisos», pide los tres datos y el tarifario de tapicería calcula lo que dijo JP.\n";
