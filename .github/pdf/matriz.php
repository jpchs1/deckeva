<?php
/**
 * Renderiza la cotización PDF con el mismo DOMPDF y las mismas opciones del
 * servidor, sobre los datos de ejemplo y todas las combinaciones de datos
 * largos (nombre, contacto, saludo, ≈ USD, modelo/color) × Chile/extranjero ×
 * precio/a consultar. Después, medir.py dice si algo quedó bajo el pie.
 *
 * Sólo CLI. Vive en .github/ para que el deploy no lo publique.
 *
 *   composer require dompdf/dompdf:2.0.8 -d /tmp/dk
 *   php .github/pdf/matriz.php /tmp/dk/vendor/autoload.php /tmp/dk/salida
 *   python3 .github/pdf/medir.py /tmp/dk/salida      (pip install pymupdf)
 *
 * Los datos son inventados: aquí nunca van datos de clientes reales.
 */
if (PHP_SAPI !== 'cli') exit;
define('ABSPATH', '/');
[$yo, $autoload, $out] = $argv + [null, null, null];
if (!$autoload || !$out) { fwrite(STDERR, "uso: php matriz.php <vendor/autoload.php> <carpeta-salida>\n"); exit(1); }
require $autoload;
$assets = dirname(__DIR__, 2) . '/wp-content/mu-plugins/deckeva-assets';
require_once $assets . '/pdf-cotizacion.php';
@mkdir($out, 0777, true);
$fuentes = $out . '/.fuentes'; @mkdir($fuentes);

$base = deckeva_pdf_cotizacion_datos_ejemplo();
$extras = array(
    'nombre'   => function ($d) { return array_replace_recursive($d, array('cliente' => array('nombre' => 'María Fernanda de los Ángeles Valenzuela Etchegaray'))); },
    'contacto' => function ($d) { return array_replace_recursive($d, array('cliente' => array('email' => 'maria.fernanda.valenzuela.etchegaray@empresa-ejemplo.cl'))); },
    'saludo'   => function ($d) { return $d + array('saludo' => str_repeat('Gracias por cotizar con Deckeva, conversamos por WhatsApp. ', 3)); },
    'usd'      => function ($d) { return array_replace_recursive($d, array('precio' => array('ref_usd' => 'USD $1,512', 'tipo_cambio' => '1 USD = CLP $935'))); },
    'ficha'    => function ($d) { return array_replace_recursive($d, array('embarcacion' => array('modelo' => 'Chaparral 267 SSX Sport Deck Outboard Edition', 'color' => 'Arena con borde negro / Sand with black'))); },
);
$claves = array_keys($extras);
$n = 0;
for ($m = 0; $m < (1 << count($claves)); $m++) {
    foreach (array('Chile' => 'Chile', 'USA' => 'United States') as $pn => $pais) {
        foreach (array(false, true) as $consultar) {
            $d = $base; $d['cliente']['pais'] = $pais; $d['precio']['a_consultar'] = $consultar; $tag = array();
            foreach ($claves as $i => $k) if ($m & (1 << $i)) { $d = $extras[$k]($d); $tag[] = $k; }
            $pdf = new \Dompdf\Dompdf(array(
                'isRemoteEnabled' => false, 'isPhpEnabled' => false, 'chroot' => array($assets),
                'fontDir' => $fuentes, 'fontCache' => $fuentes, 'defaultFont' => 'dk-texto', 'fontHeightRatio' => 0.83,
            ));
            $pdf->loadHtml(deckeva_pdf_cotizacion_html($d, $assets), 'UTF-8');
            $pdf->setPaper('A4', 'portrait');
            $pdf->render();
            file_put_contents($out . '/' . $pn . ($consultar ? '-consultar' : '') . '-' . ($tag ? implode('+', $tag) : 'base') . '.pdf', $pdf->output());
            $n++;
        }
    }
}
echo "{$n} PDF en {$out}\n";
