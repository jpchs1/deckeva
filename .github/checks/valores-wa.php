<?php
/**
 * Las capturas de valores para WhatsApp siguen mostrando el precio del home.
 *
 * deckeva-whatsapp-valores.php dice qué precio muestra cada captura de
 * staging/img/valores-wa/. Si el home cambia un precio y las capturas no se
 * vuelven a sacar, el contestador dejaría de mandarlas (y lo vería JP); este
 * chequeo lo avisa antes, en el PR. Para arreglarlo: correr
 * .github/capturas-valores/capturas.js contra el sitio publicado y actualizar
 * el arreglo DECKEVA_WA_VALORES con su manifiesto.
 */
define('ABSPATH', __DIR__ . '/');
require __DIR__ . '/../../wp-content/mu-plugins/deckeva-whatsapp-valores.php';
$html = (string) file_get_contents(__DIR__ . '/../../staging/index-cl.html');
preg_match('/<select[^>]*id="sizeSelect"[^>]*>(.*?)<\/select>/s', $html, $m);
preg_match_all('/value="(\d{2}|moto-normal|moto-grande)\|(\d+)"/', $m[1] ?? '', $ops, PREG_SET_ORDER);
$tabla = array();
foreach ($ops as $o) $tabla[$o[1]] = (int) $o[2];
$mal = 0;
if (!$tabla) { echo "No se pudo leer la tabla del home.\n"; exit(1); }
foreach ($tabla as $k => $clp) {
    if (!isset(DECKEVA_WA_VALORES[$k])) { echo "Falta la captura de {$k}.\n"; $mal++; continue; }
    if (DECKEVA_WA_VALORES[$k] !== $clp) { echo "La captura de {$k} muestra " . DECKEVA_WA_VALORES[$k] . " y el home dice {$clp}.\n"; $mal++; }
    if (!is_file(__DIR__ . '/../../staging/img/valores-wa/' . $k . '.jpg')) { echo "No está la imagen {$k}.jpg.\n"; $mal++; }
}
foreach (DECKEVA_WA_VALORES as $k => $clp) if (!isset($tabla[$k])) { echo "La captura de {$k} ya no está en el home.\n"; $mal++; }
if ($mal) { echo "::error::{$mal} captura(s) de valores para WhatsApp no calzan con el home. Vuelve a sacarlas (.github/capturas-valores/capturas.js).\n"; exit(1); }
echo count($tabla) . " capturas de valores al día con el home.\n";
