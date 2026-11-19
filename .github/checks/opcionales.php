<?php
/**
 * El tarifario de la toma de medidas y la instalación tiene TODO lo de eso.
 *
 * JP, 19-nov-2026: «revisa el tarifario de instalación y toma de medidas, ahí
 * debe estar todo lo respectivo a eso».
 *
 * Hasta ese día el archivo tenía sólo los dos montos. El resto —el recargo por
 * traslado de Curacaví, el plazo de 12 días, que se puede medir en un lugar e
 * instalar en otro, que lo ideal es traerla a Santiago— estaba escrito a mano
 * dentro del prompt del contestador: cuatro líneas de texto que ningún chequeo
 * miraba, en el único lugar donde cambiarlas no deja un diff que se entienda.
 * Agregar un segundo lugar con recargo habría sido editar el prompt y rezar.
 *
 * Ahora las reglas salen de `deckeva_opcionales_reglas()` y el prompt las pega.
 * Este chequeo cobra las dos mitades: que las reglas las arme el tarifario con
 * sus constantes, y que el prompt no las vuelva a escribir a mano.
 *
 * Tiene canario: un archivo que no se pudo leer es ROJO. «No encontré el lugar
 * escrito a mano» y «no leí nada» se ven igual, y éste es justo el chequeo que
 * tiene que distinguirlos.
 */
define('ABSPATH', __DIR__ . '/');
require __DIR__ . '/../../wp-content/mu-plugins/deckeva-00-opcionales.php';

$fallas = 0;
$exigir = function ($cond, $msg) use (&$fallas) {
    if ($cond) return;
    $fallas++;
    fwrite(STDERR, "✗ {$msg}\n");
};

$prompt = (string) @file_get_contents(__DIR__ . '/../../wp-content/mu-plugins/deckeva-whatsapp.php');
$exigir(strlen($prompt) > 20000, 'canario · se leyó el prompt del contestador (' . strlen($prompt) . ' bytes)');
$exigir(function_exists('deckeva_opcionales_reglas'), 'canario · el tarifario expone deckeva_opcionales_reglas()');
if ($fallas) { fwrite(STDERR, "\nCanario en rojo: no se midió nada.\n"); exit(1); }

/* ── 1 · los dos montos siguen viviendo acá, netos ──────────────────── */
$ops = deckeva_opcionales();
$exigir(count($ops) === 2, 'el tarifario tiene los dos opcionales');
foreach ($ops as $o) {
    $exigir($o['neto'] > 0, $o['clave'] . ': tiene neto');
    $exigir($o['iva'] === (int) round($o['neto'] * 0.19) && $o['total'] === $o['neto'] + $o['iva'], $o['clave'] . ': el IVA va APARTE del neto, como lo escribe JP');
}

/* ── 2 · las reglas las arma el tarifario, con sus constantes ───────── */
$reglas = deckeva_opcionales_reglas();
$exigir(substr_count($reglas, "\n") === 5, 'las reglas son cinco líneas · ' . substr_count($reglas, "\n"));
foreach (DECKEVA_UBICACION_RECARGO as $slug => $nombre) {
    $exigir(strpos($reglas, $nombre) !== false, "las reglas nombran el lugar con recargo · {$nombre}");
    $exigir(deckeva_ubicacion_con_recargo('está en ' . $nombre) === $slug, "y el freno lo reconoce escrito con acento · {$nombre}");
}
$exigir(count(DECKEVA_UBICACION_RECARGO) >= 1, 'hay al menos un lugar con recargo declarado');
$exigir(deckeva_ubicacion_con_recargo('Algarrobo') === '', 'un lugar sin recargo no se marca');
$exigir(strpos($reglas, (string) DECKEVA_OPCIONALES_DIAS . ' días corridos') !== false, 'las reglas dicen el plazo, sacado de la constante');
$exigir(strpos($reglas, 'lugares distintos') !== false, 'y que se puede medir en un lugar e instalar en otro');
$exigir(strpos($reglas, 'traerla a Santiago') !== false, 'y qué conviene si duda entre dos lugares');

/* ── 3 · NINGÚN monto en el chat, tampoco acá ───────────────────────── */
$exigir(!preg_match('/\d[\d.,]{4,}/', $reglas), 'las reglas no traen ningún monto: el valor va en la cotización, nunca en el chat');
$exigir(stripos($reglas, 'Nunca digas su valor en el chat') !== false, 'y lo dicen con todas las letras');

/* ── 4 · el prompt las PEGA, no las reescribe ───────────────────────── */
$exigir(strpos($prompt, 'deckeva_opcionales_reglas()') !== false, 'el prompt pega las reglas del tarifario');
foreach (array_values(DECKEVA_UBICACION_RECARGO) as $nombre) {
    $exigir(strpos($prompt, $nombre) === false, "el prompt NO escribe a mano el lugar con recargo · {$nombre}");
}
$exigir(!preg_match('/\d+ d[ií]as corridos/u', $prompt), 'el prompt NO escribe a mano el plazo de la instalación');
$exigir(strpos($prompt, 'instalar en la marina') === false, 'el prompt NO escribe a mano la regla de los dos lugares');
$exigir(strpos($prompt, (string) number_format(DECKEVA_PRECIO_MEDICION, 0, ',', '.')) === false, 'el prompt no trae el valor de los opcionales');

if ($fallas) {
    fwrite(STDERR, "\n{$fallas} problema(s) en el tarifario de medir e instalar.\n");
    exit(1);
}
echo "Opcionales: los dos montos, el recargo, el plazo y los dos lugares viven en el tarifario, y el prompt los pega.\n";
