<?php
/**
 * El valor de la toma de medidas y de la instalación vive en
 * deckeva-00-opcionales.php, y el PDF lo lee de ahí. La home de deckeva.cl es
 * HTML estático: no puede leerlo, así que lo lleva escrito. Este chequeo
 * falla si los dos dicen cosas distintas, para que un cambio de precio no
 * publique un valor en la web y otro en la cotización.
 *
 * Sólo CLI. Lo corre ci.yml.   php .github/checks/precios-web.php
 */
if (PHP_SAPI !== 'cli') exit;
define('ABSPATH', '/');
$raiz = dirname(__DIR__, 2);
require $raiz . '/wp-content/mu-plugins/deckeva-00-opcionales.php';

$validos = array();
foreach (deckeva_opcionales() as $o) {
    $validos[] = number_format($o['neto'], 0, ',', '.');   // 155.000 (castellano)
    $validos[] = number_format($o['neto'], 0, '.', ',');   // 155,000 (inglés)
}

$errores = 0;
$vistos = 0;
foreach (array('staging/index-cl.html') as $rel) {
    $html = (string) file_get_contents($raiz . '/' . $rel);
    // Todo «CLP $N + IVA/VAT» de la página es el precio de un opcional.
    preg_match_all('/CLP \$([\d.,]+) \+ (?:IVA|VAT)/u', $html, $m);
    foreach ($m[1] as $monto) {
        $vistos++;
        if (!in_array($monto, $validos, true)) {
            echo "::error file={$rel}::dice CLP \${$monto} + IVA, pero deckeva-00-opcionales.php dice " . implode(' / ', array_unique($validos)) . "\n";
            $errores++;
        }
    }
    if (preg_match('/145[.,]000|t[ée]cnico de (mi|su) confianza/u', $html)) {
        echo "::error file={$rel}::sigue el texto viejo (\$145.000 o «técnico de confianza»)\n";
        $errores++;
    }
    if ($vistos === 0) {
        echo "::error file={$rel}::no encontré ningún «CLP \$N + IVA»: si se sacó el precio de la web, sacar también este chequeo\n";
        $errores++;
    }
}
echo "Precios de opcionales revisados en la web: {$vistos}\n";
exit($errores ? 1 : 0);
