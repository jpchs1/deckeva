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

// 9 · automático no manda una cotización que necesita a JP (review del #179)
//
// Las tres salieron del mismo sitio: el modo automático saca del medio al
// único que miraba el PDF antes de que saliera. Se cobran corriendo
// `deckeva_wa_cotiza_freno()` de verdad, no buscando su nombre en el archivo:
// un grep dice que la función está escrita, no que con un descuento pendiente
// la respuesta sea «no sale».
// Stubs de WordPress: el módulo registra un hook al cargarse y acá no hay WP.
// Son los mínimos para poder correr la función de verdad en vez de grepearla.
if (!function_exists('add_action')) { function add_action() { return true; } }
if (!function_exists('get_option')) { function get_option($k, $d = false) { return $d; } }
if (!function_exists('update_option')) { function update_option() { return true; } }
if (!function_exists('remove_accents')) { function remove_accents($t) { return strtr($t, array('á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u', 'ü' => 'u', 'ñ' => 'n')); } }
require __DIR__ . '/../../wp-content/mu-plugins/deckeva-whatsapp-cotiza.php';
$exigir(function_exists('deckeva_wa_cotiza_freno'), 'CANARIO · existe el freno');
if (function_exists('deckeva_wa_cotiza_freno')) {
    $listo = array('ok' => true, 'clave' => '20', 'precio' => 1000000, 'ubicacion' => 'Lago Rapel');
    $sinNada = array('mensajes' => array());
    $exigir(deckeva_wa_cotiza_freno($sinNada, $listo) === '', 'un chat sin reparos no tiene freno');

    // a) la respuesta espera a JP (un descuento, un reclamo, «que me llamen»)
    foreach (array('borrador', 'escalado') as $est) {
        $chat = array('pendiente' => array('estado' => $est, 'necesita_humano' => true, 'motivo' => 'pidió descuento'));
        $f = deckeva_wa_cotiza_freno($chat, $listo);
        $exigir($f !== '', "con la respuesta en {$est} esperando a JP, la cotización no sale sola");
        $exigir(strpos($f, 'descuento') !== false, "…y el motivo lo dice ({$est})");
    }
    // …pero una que JP ya resolvió no congela la cotización para siempre
    foreach (array('aprobado', 'enviado', 'descartado', 'superado', 'vencido') as $est) {
        $chat = array('pendiente' => array('estado' => $est, 'necesita_humano' => true, 'motivo' => 'pidió descuento'));
        $exigir(deckeva_wa_cotiza_freno($chat, $listo) === '', "una respuesta ya {$est} NO frena la cotización");
    }
    // una respuesta normal en borrador (sin necesita_humano) tampoco frena
    $exigir(deckeva_wa_cotiza_freno(array('pendiente' => array('estado' => 'borrador', 'necesita_humano' => false)), $listo) === '',
        'un borrador sin reparos no frena la cotización');

    // b) un lugar con recargo por traslado que el PDF no calcula
    foreach (array('Curacaví', 'curacavi', 'Lago Rapel, Curacaví') as $u) {
        $f = deckeva_wa_cotiza_freno($sinNada, array('ok' => true, 'ubicacion' => $u));
        $exigir($f !== '' && stripos($f, 'recargo') !== false, "una embarcación en «{$u}» no sale sola: falta el recargo");
    }
    $exigir(deckeva_wa_cotiza_freno($sinNada, array('ok' => true, 'ubicacion' => 'Algarrobo')) === '',
        'un lugar sin recargo sí sale solo');
    $exigir(deckeva_wa_cotiza_freno($sinNada, array('ok' => true, 'ubicacion' => 'Puerto Varas')) === '',
        'y otro tampoco se marca de más');
    $exigir(count(DECKEVA_UBICACION_RECARGO) >= 1, 'hay al menos un lugar con recargo declarado');

    // c) la ubicación tiene que llegarle al freno, o no puede mirarla
    $cot = (string) file_get_contents(__DIR__ . '/../../wp-content/mu-plugins/deckeva-whatsapp-cotiza.php');
    $exigir(strpos($cot, "'ubicacion' => \$ubicacion") !== false, 'deckeva_wa_cotiza_listo devuelve la ubicación');
    $exigir((bool) preg_match('/\$freno = deckeva_wa_cotiza_freno\(\$chat, \$listo\);\s*\n\s*\$auto = deckeva_wa_cotiza_modo\(\) === .automatico. && \$freno === ..;/', $cot),
        'el freno se mide ANTES de aprobar, no después');
    $exigir(strpos($cot, "'falta' => \$freno, 'jp' => \$freno !== ''") !== false, 'con freno, la cotización queda para JP con el motivo');
}

// 10 · un trabajo a medida se le escala a JP (review del #179)
//
// Antes, un pedido que no era un piso se quedaba «no se cotiza» sin avisarle a
// nadie. Con la tapicería, la fibra, el detailing, el pintado y las
// restauraciones adentro del negocio, ese silencio es un cliente perdido.
$exigir(function_exists('deckeva_es_trabajo_a_medida'), 'CANARIO · existe el reconocedor de trabajos a medida');
if (function_exists('deckeva_es_trabajo_a_medida')) {
    foreach (array(
        'Me gustaría retapizar la lancha',
        'Quiero tapicería nueva, en Sunbrella',
        'Hay que reparar la fibra de vidrio',
        'Me interesa un detailing',
        'Quiero pintar la lancha',
        'Necesito restaurarla completa',
        'Me das el pack completo?',
    ) as $q) $exigir(deckeva_es_trabajo_a_medida($q), "«{$q}» es un trabajo a medida de Deckeva");
    foreach (array(
        'Quiero un piso de goma EVA para mi lancha de 20 pies',
        'Me interesa un muelle flotante',
        'Hacen carpas?',
    ) as $q) $exigir(!deckeva_es_trabajo_a_medida($q), "«{$q}» NO es un trabajo a medida");
    $exigir((bool) preg_match('/\$aMedida = function_exists\(.deckeva_es_trabajo_a_medida.\) && deckeva_es_trabajo_a_medida\(\$escrito\);/', $cot ?? (string) file_get_contents(__DIR__ . '/../../wp-content/mu-plugins/deckeva-whatsapp-cotiza.php')),
        'se mira lo que ESCRIBIÓ el cliente, no lo que dedujo Claude');
    $exigir(strpos((string) file_get_contents(__DIR__ . '/../../wp-content/mu-plugins/deckeva-whatsapp-cotiza.php'), "'jp' => \$aMedida,") !== false,
        'y con eso el pedido le llega a JP');
}

// 11 · las cotizaciones que YA esperaban el clic de JP se sueltan (Codex, #179)
//
// Es el punto del cambio: si una `lista` se queda `lista`, el correo «Revisar
// y enviar» que lo motivó sigue pidiendo el clic para siempre. Esto sí se
// cobra por el texto del archivo, y no corriendo nada: la promoción vive
// dentro del recorrido de los chats y moverla a su propia función para poder
// llamarla acá sería cambiar el código para que el test exista. La DECISIÓN
// —el freno— sí se corre, arriba, que es la parte que puede equivocarse.
$trozos = array(
    '$c[\'estado\'] ?? \'\') === \'lista\' && $vigente && empty($c[\'jp\'])'
        => 'una cotización ya en «lista» se promueve, y sólo si es vigente y no quedó para JP',
    'deckeva_wa_cotiza_freno($chat, array(\'ubicacion\' => (string) ($c[\'ubicacion\'] ?? $escrito))) === \'\''
        => 'al promoverla se le pasa el MISMO freno, con la ubicación guardada o lo que escribió el cliente',
    '$chats[$num][\'cotizacion\'][\'aprobada_por\'] = \'automático\';'
        => 'y queda anotado que la aprobó el modo automático',
    '\'ubicacion\' => (string) ($listo[\'ubicacion\'] ?? \'\')'
        => 'la ubicación se guarda en el registro, así que el freno no necesita otra lectura de Claude',
    'if (($chats[$num][\'cotizacion\'][\'estado\'] ?? \'\') !== \'lista\') return $chats;'
        => 'la promoción va con candado: si alguien la movió mientras tanto, no se pisa',
);
foreach ($trozos as $trozo => $que) $exigir(strpos($cot, $trozo) !== false, $que);

if ($mal) {
    echo "::error::{$mal} reparo(s). El contestador puede estar diciéndole a un cliente que no hacemos algo que sí hacemos.\n";
    exit(1);
}
echo "Deckeva no dice «sólo pisos», pide los tres datos y el tarifario de tapicería calcula lo que dijo JP.\n";
