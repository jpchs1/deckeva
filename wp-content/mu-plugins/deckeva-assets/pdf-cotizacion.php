<?php
/**
 * Plantilla del PDF de cotización que recibe el cliente (formulario de la home).
 *
 * Vive en una subcarpeta a propósito: WordPress solo carga los PHP de la raíz de
 * mu-plugins, así que esto no se ejecuta solo; lo incluye el cotizador cuando
 * genera un PDF. Y como es una función pura (datos ya formateados → HTML), se
 * puede previsualizar sin WordPress.
 *
 * Escrita para DOMPDF 2.0.8, que es lo que corre en el servidor. Eso manda:
 * - Nada de flexbox ni grid: DOMPDF los ignora y todo se apila. Maquetación con tablas.
 * - Nada de emojis: ninguna fuente del PDF los tiene y salen como "?". Iconos en SVG.
 * - Nada de recursos remotos (isRemoteEnabled está apagado): el emblema va
 *   incrustado en base64 y las fuentes se leen de deckeva-assets/fonts.
 * - Una familia por grosor. DOMPDF solo distingue normal/negrita, así que
 *   declarar 500/600/800 dentro de la misma familia haría que se pisaran.
 * - Interlineado en puntos, y DOMPDF creado con fontHeightRatio 0.83. En 2.0.8
 *   cada línea mide "interlineado × altura de la fuente × fontHeightRatio"; con
 *   Barlow (1,2 em) y el 1,1 por defecto, todo salía un 32 % más alto de lo
 *   escrito y la cotización se iba a dos páginas. 1,2 × 0,83 ≈ 1: así el
 *   interlineado que se escribe aquí es el que se imprime.
 * - El pie es "position: fixed" en el margen inferior de la página: DOMPDF no le
 *   reserva sitio, así que sin ese margen el texto le pasaba por debajo.
 *
 * Tipografías y colores son los de la web (Barlow Condensed, Barlow, Space Mono;
 * navy #0a1628, océano #0e6ba8, dorado #f5a623), todas con licencia OFL.
 */

if (!defined('ABSPATH')) exit;

/**
 * @param array  $d       Datos ya formateados. Ver deckeva_pdf_cotizacion_datos_ejemplo().
 * @param string $assets  Ruta absoluta a deckeva-assets (fuentes y emblema).
 * @return string HTML listo para DOMPDF.
 */
function deckeva_pdf_cotizacion_html(array $d, $assets) {
    $e = function ($s) {
        return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8');
    };

    $f = rtrim($assets, '/') . '/fonts/';
    $emblema = '';
    $png = rtrim($assets, '/') . '/emblema-deckeva.png';
    if (is_readable($png)) {
        $emblema = 'data:image/png;base64,' . base64_encode(file_get_contents($png));
    }

    // Iconos en SVG: los emojis del diseño anterior salían como "?".
    $svg = function ($markup) {
        return 'data:image/svg+xml;base64,' . base64_encode($markup);
    };
    $icono_check = $svg('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><circle cx="8" cy="8" r="8" fill="#00b87a"/><path d="M4.6 8.4 L7 10.7 L11.6 5.8" fill="none" stroke="#ffffff" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"/></svg>');
    $icono_regla = $svg('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><rect x="1" y="5" width="14" height="6" rx="1.2" fill="none" stroke="#b7791f" stroke-width="1.3"/><path d="M4 5 V8 M7 5 V9 M10 5 V8 M13 5 V9" stroke="#b7791f" stroke-width="1.2"/></svg>');
    $icono_llave = $svg('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><circle cx="11" cy="5" r="3.2" fill="none" stroke="#b7791f" stroke-width="1.4"/><path d="M8.8 7.2 L2.6 13.4" stroke="#b7791f" stroke-width="1.8" stroke-linecap="round"/></svg>');
    $ola = $svg('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 600 40" preserveAspectRatio="none"><path d="M0 24 C 100 6 200 40 310 22 C 420 4 510 34 600 18 L600 40 L0 40 Z" fill="#0e6ba8"/><path d="M0 32 C 120 18 230 44 340 30 C 450 16 530 38 600 28 L600 40 L0 40 Z" fill="#1a9be3"/></svg>');

    $precio = $d['precio'];
    $consultar = !empty($precio['a_consultar']);

    // Solo se pintan los datos que existen, para no dejar "—" sueltos.
    $ficha = array();
    foreach (array(
        array('TAMAÑO · SIZE', $d['embarcacion']['tamano']),
        array('MODELO · MODEL', $d['embarcacion']['modelo']),
        array('AÑO · YEAR', $d['embarcacion']['anio']),
        array('COLOR', $d['embarcacion']['color']),
    ) as $campo) {
        if (trim((string) $campo[1]) !== '') {
            $ficha[] = $campo;
        }
    }
    // El modelo suele ser lo más largo: se le da más ancho.
    $anchos = array();
    foreach ($ficha as $campo) {
        $anchos[] = (strpos($campo[0], 'MODELO') === 0) ? 2 : 1;
    }
    $unidad = $anchos ? 100 / array_sum($anchos) : 100;

    $contacto = implode('   ·   ', array_filter(array(
        $d['cliente']['email'],
        $d['cliente']['telefono'],
        $d['cliente']['pais'],
    ), function ($v) { return trim((string) $v) !== ''; }));

    ob_start();
    ?><!DOCTYPE html>
<html lang="es"><head><meta charset="UTF-8">
<style>
@font-face { font-family: 'dk-texto';   src: url('<?php echo $f; ?>Barlow-Regular.ttf') format('truetype'); font-weight: normal; }
@font-face { font-family: 'dk-texto';   src: url('<?php echo $f; ?>Barlow-SemiBold.ttf') format('truetype'); font-weight: bold; }
@font-face { font-family: 'dk-medio';   src: url('<?php echo $f; ?>Barlow-Medium.ttf') format('truetype'); font-weight: normal; }
@font-face { font-family: 'dk-titular'; src: url('<?php echo $f; ?>BarlowCondensed-SemiBold.ttf') format('truetype'); font-weight: normal; }
@font-face { font-family: 'dk-titular'; src: url('<?php echo $f; ?>BarlowCondensed-ExtraBold.ttf') format('truetype'); font-weight: bold; }
@font-face { font-family: 'dk-mono';    src: url('<?php echo $f; ?>SpaceMono-Regular.ttf') format('truetype'); font-weight: normal; }
@font-face { font-family: 'dk-mono';    src: url('<?php echo $f; ?>SpaceMono-Bold.ttf') format('truetype'); font-weight: bold; }

@page { margin: 0 0 38pt 0; }
* { margin: 0; padding: 0; }
body { font-family: 'dk-texto'; font-size: 9pt; line-height: 12pt; color: #1a2744; }
table { border-collapse: collapse; width: 100%; }
td { vertical-align: top; }

/* ── Cabecera ─────────────────────────────────────────── */
.cabecera { background: #0a1628; padding: 26pt 40pt 0 40pt; height: 86pt; position: relative; }
.ola   { position: absolute; left: 0; bottom: 0; width: 100%; height: 22pt; }
.marca { font-family: 'dk-titular'; font-weight: bold; font-size: 26pt; line-height: 26pt; letter-spacing: 3.5pt; color: #ffffff; }
.lema  { font-family: 'dk-mono'; font-size: 5.6pt; line-height: 8pt; letter-spacing: 0.9pt; color: #8fa3bd; margin-top: 5pt; }
.etiqueta-oro { font-family: 'dk-mono'; font-weight: bold; font-size: 6.6pt; line-height: 9pt; letter-spacing: 2pt; color: #f5a623; }
.numero { font-family: 'dk-mono'; font-weight: bold; font-size: 8.6pt; line-height: 11pt; color: #ffffff; margin-top: 4pt; }
.fecha  { font-size: 8.4pt; line-height: 11pt; color: #8fa3bd; margin-top: 1pt; }

/* ── Cuerpo ───────────────────────────────────────────── */
.cuerpo { padding: 20pt 40pt 0 40pt; }
.sobre    { font-family: 'dk-mono'; font-size: 6.2pt; line-height: 8pt; letter-spacing: 1.5pt; color: #64748b; }
.nombre   { font-family: 'dk-titular'; font-weight: bold; font-size: 24pt; line-height: 25pt; color: #0a1628; margin-top: 4pt; }
.nombre-largo { font-size: 18pt; line-height: 20pt; }
.contacto { font-family: 'dk-medio'; font-size: 8.2pt; line-height: 11pt; color: #0e6ba8; margin-top: 4pt; }
.saludo   { font-size: 8.8pt; line-height: 12.5pt; color: #475569; margin-top: 8pt; }

.tarjeta-total { background: #0e6ba8; border-radius: 10pt; padding: 14pt 16pt 13pt 16pt; }
.total-lbl   { font-family: 'dk-mono'; font-weight: bold; font-size: 6.2pt; line-height: 8pt; letter-spacing: 1.5pt; color: #cfe6f7; }
.total-monto { font-family: 'dk-titular'; font-weight: bold; font-size: 28pt; line-height: 30pt; color: #ffffff; margin-top: 6pt; }
.total-consultar { font-family: 'dk-titular'; font-weight: bold; font-size: 22pt; line-height: 24pt; color: #ffffff; margin-top: 6pt; }
.total-nota  { font-size: 7.8pt; line-height: 10pt; color: #cfe6f7; margin-top: 3pt; }
.total-ref   { font-family: 'dk-medio'; font-size: 8.2pt; line-height: 10pt; color: #ffffff; margin-top: 7pt; padding-top: 6pt; border-top: 0.6pt solid #3d8cc0; }

.seccion { font-family: 'dk-mono'; font-weight: bold; font-size: 6.4pt; line-height: 8pt; letter-spacing: 1.8pt; color: #0e6ba8; margin: 16pt 0 6pt 0; }
.seccion span { color: #94a3b8; font-weight: normal; }

.ficha { background: #f5f7fa; border-radius: 8pt; }
.ficha td { padding: 9pt 12pt; }
.ficha .sep { border-left: 0.6pt solid #dde3ea; }
.lbl { font-family: 'dk-mono'; font-size: 5.8pt; line-height: 7pt; letter-spacing: 1pt; color: #64748b; }
.val { font-family: 'dk-titular'; font-size: 12.5pt; line-height: 14pt; color: #0a1628; margin-top: 3pt; }

.detalle td { padding: 5pt 0; border-bottom: 0.6pt solid #e2e8f0; vertical-align: middle; }
.detalle .desc  { font-size: 9.2pt; line-height: 11pt; color: #1a2744; }
.detalle .sub   { font-size: 7.4pt; line-height: 9pt; color: #94a3b8; }
.detalle .monto { font-family: 'dk-mono'; font-size: 8.8pt; line-height: 11pt; color: #1a2744; text-align: right; white-space: nowrap; }
.detalle .fila-total td { border-bottom: 0; border-top: 1.2pt solid #0a1628; padding-top: 8pt; }
.detalle .fila-total .desc  { font-family: 'dk-titular'; font-weight: bold; font-size: 13pt; line-height: 14pt; color: #0a1628; }
.detalle .fila-total .monto { font-family: 'dk-mono'; font-weight: bold; font-size: 10.4pt; line-height: 13pt; color: #0a1628; }
.letra-chica { font-size: 7.2pt; line-height: 9.5pt; color: #94a3b8; margin-top: 5pt; }

/* ── Medición e instalación ───────────────────────────── */
.aviso { background: #fff8ec; border-left: 3pt solid #f5a623; border-radius: 0 8pt 8pt 0; padding: 11pt 15pt 10pt 15pt; margin-top: 16pt; }
.aviso-tit { font-family: 'dk-titular'; font-weight: bold; font-size: 12.5pt; line-height: 14pt; color: #7a4a00; }
.aviso-tit span { font-family: 'dk-mono'; font-weight: bold; font-size: 6pt; letter-spacing: 1.4pt; color: #b7791f; }
.aviso p { font-size: 8pt; line-height: 11.4pt; color: #4a4a4a; margin-top: 5pt; }
.costos { margin-top: 7pt; }
.costos td { padding: 4.5pt 8pt; font-size: 8pt; line-height: 10pt; color: #4a4a4a; border-bottom: 0.6pt solid #f1dfbf; vertical-align: middle; }
.costos .cab td { font-family: 'dk-mono'; font-weight: bold; font-size: 5.8pt; line-height: 7pt; letter-spacing: 1pt; color: #7a4a00; background: #fdebc8; border-bottom: 0; }
.ico { width: 10pt; height: 10pt; }
.incluye { margin-top: 5pt; }
.incluye td { padding: 2.2pt 0; font-size: 8pt; line-height: 10.5pt; color: #3d3d3d; vertical-align: middle; }
.incluye .celda-check { width: 15pt; }
.check { width: 9.5pt; height: 9.5pt; }
.aviso p.en { font-size: 7.1pt; line-height: 9.8pt; color: #7c7c7c; margin-top: 7pt; }

/* ── Llamada a la acción y pie ────────────────────────── */
.cta { margin-top: 12pt; border: 0.8pt solid #d7e6f2; border-radius: 8pt; padding: 10pt 14pt; }
.cta td { vertical-align: middle; }
.cta-tit { font-family: 'dk-titular'; font-weight: bold; font-size: 12pt; line-height: 14pt; color: #0a1628; }
.cta-txt { font-size: 8.2pt; line-height: 11pt; color: #475569; margin-top: 1pt; }
.cta-num { font-family: 'dk-mono'; font-weight: bold; font-size: 10pt; line-height: 12pt; color: #0e6ba8; text-align: right; white-space: nowrap; }

.pie { position: fixed; left: 0; right: 0; bottom: 0; height: 25pt; background: #0a1628; padding: 13pt 40pt 0 40pt; }
.pie td { vertical-align: middle; }
.pie-txt { font-size: 7.4pt; line-height: 10pt; color: #cbd5e1; }
.pie-web { font-family: 'dk-mono'; font-size: 6.4pt; line-height: 10pt; letter-spacing: 0.5pt; color: #8fa3bd; text-align: right; }
</style>
</head>
<body>

<div class="pie">
  <table><tr>
    <td class="pie-txt">Cotización válida por 15 días hábiles · This quote is valid for 15 business days.</td>
    <td class="pie-web">deckeva.cl · deckeva.com · contacto@deckeva.cl</td>
  </tr></table>
</div>

<div class="cabecera">
  <table><tr>
    <td style="width:66%;">
      <table style="width:auto;"><tr>
        <?php if ($emblema): ?>
        <td style="width:52pt;vertical-align:middle;"><img src="<?php echo $emblema; ?>" style="width:42pt;height:42pt;"></td>
        <?php endif; ?>
        <td style="vertical-align:middle;">
          <div class="marca">DECKEVA</div>
          <div class="lema">PISOS NÁUTICOS A MEDIDA · CUSTOM MARINE EVA FLOORING</div>
        </td>
      </tr></table>
    </td>
    <td style="width:34%;text-align:right;vertical-align:middle;">
      <div class="etiqueta-oro">COTIZACIÓN · QUOTE</div>
      <div class="numero"><?php echo $e($d['numero']); ?></div>
      <div class="fecha"><?php echo $e($d['fecha']); ?></div>
    </td>
  </tr></table>
  <img class="ola" src="<?php echo $ola; ?>">
</div>

<div class="cuerpo">

  <table><tr>
    <td style="width:57%;padding-right:20pt;">
      <div class="sobre">PREPARADA PARA · PREPARED FOR</div>
      <div class="nombre<?php echo mb_strlen($d['cliente']['nombre'], 'UTF-8') > 24 ? ' nombre-largo' : ''; ?>"><?php echo $e($d['cliente']['nombre']); ?></div>
      <?php if ($contacto !== ''): ?>
      <div class="contacto"><?php echo $e($contacto); ?></div>
      <?php endif; ?>
      <div class="saludo">Gracias por cotizar con Deckeva. Aquí tienes el valor referencial de tu piso náutico EVA a medida y todo lo que necesitas saber para avanzar.</div>
    </td>
    <td style="width:43%;">
      <div class="tarjeta-total">
        <div class="total-lbl">TOTAL ESTIMADO · ESTIMATED TOTAL</div>
        <?php if ($consultar): ?>
          <div class="total-consultar">A consultar</div>
          <div class="total-nota">Quote on request</div>
        <?php else: ?>
          <div class="total-monto"><?php echo $e($precio['total']); ?></div>
          <div class="total-nota">IVA 19% incluido · VAT included</div>
          <?php if (!empty($precio['ref_usd'])): ?>
            <div class="total-ref">≈ <?php echo $e($precio['ref_usd']); ?></div>
          <?php endif; ?>
        <?php endif; ?>
      </div>
    </td>
  </tr></table>

  <?php if ($ficha): ?>
  <div class="seccion">TU EMBARCACIÓN <span>· YOUR VESSEL</span></div>
  <table class="ficha"><tr>
    <?php foreach ($ficha as $i => $campo): ?>
    <td class="<?php echo $i ? 'sep' : ''; ?>" style="width:<?php echo round($unidad * $anchos[$i], 2); ?>%;">
      <div class="lbl"><?php echo $e($campo[0]); ?></div>
      <div class="val"><?php echo $e($campo[1]); ?></div>
    </td>
    <?php endforeach; ?>
  </tr></table>
  <?php endif; ?>

  <div class="seccion">DETALLE <span>· BREAKDOWN</span></div>
  <table class="detalle">
    <tr>
      <td>
        <div class="desc">Piso náutico EVA a medida</div>
        <div class="sub">Custom marine EVA flooring<?php echo $d['embarcacion']['tamano'] ? ' · ' . $e($d['embarcacion']['tamano']) : ''; ?></div>
      </td>
      <td class="monto"><?php echo $consultar ? 'A consultar' : $e($precio['subtotal']); ?></td>
    </tr>
    <?php if (!$consultar): ?>
    <tr>
      <td><div class="desc">IVA 19%</div><div class="sub">VAT</div></td>
      <td class="monto"><?php echo $e($precio['iva']); ?></td>
    </tr>
    <tr class="fila-total">
      <td><div class="desc">Total</div></td>
      <td class="monto"><?php echo $e($precio['total']); ?></td>
    </tr>
    <?php endif; ?>
  </table>
  <div class="letra-chica">* Precio referencial / Reference quote · Final confirmation upon order.<?php
    echo !empty($precio['tipo_cambio']) ? ' Tipo de cambio ref. / Reference rate: ' . $e($precio['tipo_cambio']) . '.' : '';
  ?></div>

  <div class="aviso">
    <div class="aviso-tit">Toma de medidas e instalación &nbsp;<span>IMPORTANTE · IMPORTANT</span></div>
    <p><strong>ES:</strong> La <strong>toma de medidas</strong> (para envíos dentro de Chile) y la <strong>instalación</strong> del piso deben ser contratadas por el cliente con un técnico o persona de su confianza. Deckeva no realiza estas tareas presencialmente. Estos costos <u>no están incluidos</u> en la cotización y deben ser considerados aparte.</p>

    <table class="costos">
      <tr class="cab"><td>ÍTEM · ITEM</td><td>COSTO REF. · REF. COST</td><td>TIEMPO · TIME</td></tr>
      <tr>
        <td><img class="ico" src="<?php echo $icono_regla; ?>"> &nbsp;Toma de medidas · Measurement</td>
        <td><strong>USD $120</strong></td>
        <td>4–6 hrs aprox.</td>
      </tr>
      <tr>
        <td><img class="ico" src="<?php echo $icono_llave; ?>"> &nbsp;Instalación · Installation</td>
        <td><strong>USD $120</strong></td>
        <td>3–5 hrs aprox.</td>
      </tr>
    </table>

    <p>Para acompañarte en ambos procesos, Deckeva entrega <strong>sin costo</strong>:</p>
    <table class="incluye">
      <tr><td class="celda-check"><img class="check" src="<?php echo $icono_check; ?>"></td><td>Video explicativo paso a paso para la <strong>toma de medidas</strong>.</td></tr>
      <tr><td class="celda-check"><img class="check" src="<?php echo $icono_check; ?>"></td><td>Video explicativo paso a paso para la <strong>instalación</strong>.</td></tr>
      <tr><td class="celda-check"><img class="check" src="<?php echo $icono_check; ?>"></td><td>Soporte <strong>24/7 por WhatsApp y teléfono (+56 9 4021 1459)</strong> para resolver dudas o asesorar a tu técnico en vivo.</td></tr>
    </table>

    <p class="en"><strong>EN:</strong> Measurement (shipments to Chile) and installation must be arranged by the customer with a technician or trusted person. These costs are <u>not included</u> in the quote. Reference: <strong>USD $120</strong> each, measurement ~4–6 hrs, installation ~3–5 hrs (varies per vessel). Deckeva provides <strong>step-by-step explainer videos</strong> and <strong>24/7 WhatsApp &amp; phone support (+56 9 4021 1459)</strong> at no extra cost.</p>
  </div>

  <div class="cta">
    <table><tr>
      <td>
        <div class="cta-tit">¿Listo para avanzar?</div>
        <div class="cta-txt">Escríbenos por WhatsApp o a contacto@deckeva.cl y seguimos con tu piso.</div>
      </td>
      <td class="cta-num">+56 9 4021 1459</td>
    </tr></table>
  </div>

</div>
</body></html>
<?php
    return ob_get_clean();
}

/**
 * Datos de ejemplo con la forma que espera la plantilla. Sirve para
 * previsualizar el diseño y como documentación del contrato de datos.
 * Son inventados: aquí nunca van datos de clientes reales.
 */
function deckeva_pdf_cotizacion_datos_ejemplo() {
    return array(
        'numero' => 'DCK-INT-20260923001334-636DE',
        'fecha'  => '23 de septiembre de 2026',
        'cliente' => array(
            'nombre'   => 'Camila Rojas',
            'email'    => 'camila.rojas@ejemplo.cl',
            'telefono' => '+56 9 1234 5678',
            'pais'     => 'Chile',
        ),
        'embarcacion' => array(
            'tamano' => '22 pies',
            'modelo' => 'Sea Ray 240 Sundeck',
            'anio'   => '2019',
            'color'  => 'Gris / Gray',
        ),
        'precio' => array(
            'a_consultar' => false,
            'subtotal'    => 'CLP $1.189.018',
            'iva'         => 'CLP $225.913',
            'total'       => 'CLP $1.414.931',
            'ref_usd'     => '',
            'tipo_cambio' => '',
        ),
    );
}
