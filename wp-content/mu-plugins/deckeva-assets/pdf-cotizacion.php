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

// El valor de la toma de medidas y de la instalación vive en un solo lugar.
require_once dirname(__DIR__) . '/deckeva-00-opcionales.php';

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
    $icono_regla = $svg('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="1.5" y="7" width="21" height="10" rx="2" fill="none" stroke="#0e6ba8" stroke-width="1.8"/><path d="M6 7 V11.5 M10 7 V13 M14 7 V11.5 M18 7 V13" stroke="#0e6ba8" stroke-width="1.6" stroke-linecap="round"/></svg>');
    $icono_llave = $svg('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="16" cy="8" r="4.6" fill="none" stroke="#0e6ba8" stroke-width="2"/><path d="M12.8 11.2 L3.5 20.5 M6.5 17.5 L8.8 19.8" stroke="#0e6ba8" stroke-width="2.2" stroke-linecap="round"/></svg>');
    $icono_video = $svg('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="1.5" y="5" width="21" height="14" rx="3" fill="none" stroke="#00875a" stroke-width="1.8"/><path d="M10 9 L15.5 12 L10 15 Z" fill="#00875a"/></svg>');
    $icono_soporte = $svg('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M4 13 V11 A8 8 0 0 1 20 11 V13" fill="none" stroke="#00875a" stroke-width="1.9"/><rect x="2.5" y="12" width="4.5" height="7" rx="1.5" fill="#00875a"/><rect x="17" y="12" width="4.5" height="7" rx="1.5" fill="#00875a"/></svg>');
    $icono_mano = $svg('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" fill="none" stroke="#00875a" stroke-width="1.8"/><path d="M7.5 12.4 L10.6 15.4 L16.6 9" fill="none" stroke="#00875a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>');
    $icono_wa = $svg('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 2.5 A9.5 9.5 0 0 0 3.8 16.8 L2.6 21.4 L7.3 20.2 A9.5 9.5 0 1 0 12 2.5 Z" fill="none" stroke="#ffffff" stroke-width="1.8" stroke-linejoin="round"/><path d="M8.6 7.9 C8.3 8.6 8.4 10.2 10 12.2 C11.7 14.2 13.6 15.3 15 15.3 C15.8 15.3 16.4 14.6 16.4 14 L14.6 13 L13.6 13.9 C12.5 13.5 11 12.1 10.4 10.8 L11.2 9.9 L10.3 8 C9.6 7.6 9 7.5 8.6 7.9 Z" fill="#ffffff"/></svg>');
    $ola = $svg('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 600 40" preserveAspectRatio="none"><path d="M0 24 C 100 6 200 40 310 22 C 420 4 510 34 600 18 L600 40 L0 40 Z" fill="#0e6ba8"/><path d="M0 32 C 120 18 230 44 340 30 C 450 16 530 38 600 28 L600 40 L0 40 Z" fill="#1a9be3"/></svg>');

    $precio = $d['precio'];

    // Campos opcionales para cotizaciones hechas a mano (no los usa el
    // formulario web): servicios extra en el detalle, forma de pago, y la
    // variante en que la toma de medidas y la instalación ya van incluidas
    // (sin ella, salen como opcionales aparte, fuera del total).
    $servicios = isset($d['servicios']) && is_array($d['servicios']) ? $d['servicios'] : array();
    $forma_pago = isset($d['forma_pago']) && is_array($d['forma_pago']) ? $d['forma_pago'] : array();
    $servicios_incluidos = isset($d['servicios_incluidos']) ? trim((string) $d['servicios_incluidos']) : '';
    $proximos = isset($d['proximos_pasos']) && is_array($d['proximos_pasos']) ? $d['proximos_pasos'] : array();
    $consultar = !empty($precio['a_consultar']);
    $en_chile = deckeva_opcionales_en_pais($d['cliente']['pais'] ?? '');

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

    // Lo que trae cada piso. Sólo lo que la web de Deckeva ya dice del
    // producto (deckeva.com y el correo del cotizador): aquí no se promete
    // nada que no esté publicado.
    $incluye = array(
        array('EVA de celdas cerradas', 'Premium closed-cell EVA foam'),
        array('Antideslizante, también mojado', 'Non-slip, even when wet'),
        array('Resistente a UV y agua salada', 'UV and saltwater resistant'),
        array('Adhesivo 3M incluido', '3M adhesive backing included'),
        array('Diseño a medida: colores, nombre', 'Custom design: colours, name'),
        array('Absorbe ruido y vibraciones', 'Absorbs noise and vibration'),
    );

    // Próximos pasos. Sin plazos: los plazos los confirma una persona.
    if ($consultar) {
        $pasos = array(
            array('Te confirmamos el valor', 'We confirm your price'),
            array('Medidas de tu embarcación', 'Measuring your boat'),
            array($en_chile ? 'Fabricación e instalación' : 'Fabricación a medida', $en_chile ? 'Manufacturing & install' : 'Custom manufacturing'),
        );
    } else {
        $pasos = array(
            array('Confirmas tu cotización', 'Confirm your quote'),
            array($en_chile ? 'Medimos o lo haces tú' : 'Mides con nuestro video', $en_chile ? 'We measure, or you do' : 'Measure with our video'),
            array('Fabricamos a medida', 'Custom manufacturing'),
        );
    }

    // Una sola página, siempre. DOMPDF no parte la hoja cuando se pasa: dibuja
    // lo que sobra debajo del pie. Con datos largos (un nombre que ocupa dos
    // líneas, un modelo largo, el ≈ USD) se saca la nota en inglés de los
    // opcionales, que es lo que menos falta hace. Antes de tocar el alto de
    // cualquier bloque, correr .github/pdf/matriz.php y medir.py.
    $largos = 0;
    $largos += mb_strlen($d['cliente']['nombre'], 'UTF-8') > 26 ? 1 : 0;
    $largos += mb_strlen($contacto, 'UTF-8') > 64 ? 1 : 0;
    $largos += (!empty($d['saludo']) && mb_strlen($d['saludo'], 'UTF-8') > 140) ? 1 : 0;
    $largos += !empty($precio['ref_usd']) ? 1 : 0;
    foreach ($ficha as $i => $campo) {
        if (mb_strlen((string) $campo[1], 'UTF-8') > 16 * $anchos[$i]) { $largos++; break; }
    }
    $compacta = $largos >= 2;

    // Medios de pago habilitados, tal como los publica el portal de pago
    // (deckeva.cl/pago: Webpay Plus y Mercado Pago en CLP, PayPal en USD) y
    // la página de transferencias internacionales (deckeva.com/wiretransfers).
    // Aquí no se agrega un medio que no esté en esos portales.
    if ($en_chile) {
        $medios = array(
            array('Webpay Plus', 'Transbank · débito y crédito', 'https://deckeva.cl/pago/'),
            array('Mercado Pago', 'Tarjetas y saldo · CLP', 'https://deckeva.cl/pago/'),
            array('PayPal', 'Tarjeta internacional · USD', 'https://deckeva.cl/pago/'),
        );
        $pago_url = 'https://deckeva.cl/pago/';
        $pago_txt = 'deckeva.cl/pago';
    } else {
        $medios = array(
            // PayPal está en el portal de pago; la página de transferencias
            // sólo tiene los datos bancarios. Cada tarjeta lleva a su destino.
            array('PayPal', 'Card or PayPal balance · USD', 'https://deckeva.cl/pago/'),
            array('Wire Transfer / ACH', 'Bank details · deckeva.com/wiretransfers', 'https://www.deckeva.com/wiretransfers/'),
        );
        $pago_url = 'https://deckeva.cl/pago/';
        $pago_txt = 'deckeva.cl/pago';
    }
    $icono_candado = $svg('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><rect x="2.5" y="7" width="11" height="8" rx="1.6" fill="#00875a"/><path d="M5 7 V5 A3 3 0 0 1 11 5 V7" fill="none" stroke="#00875a" stroke-width="1.6"/></svg>');

    $wa_link = 'https://wa.me/56940211459?text=' . rawurlencode('Hola, quiero avanzar con mi cotización ' . $d['numero']);
    $mail_link = 'mailto:contacto@deckeva.cl?subject=' . rawurlencode('Cotización ' . $d['numero']);

    ob_start();
    ?><!DOCTYPE html>
<html lang="es"><head><meta charset="UTF-8">
<style>
@font-face { font-family: 'dk-texto';   src: url('<?php echo $f; ?>Barlow-Regular.ttf') format('truetype'); font-weight: normal; }
@font-face { font-family: 'dk-texto';   src: url('<?php echo $f; ?>Barlow-SemiBold.ttf') format('truetype'); font-weight: bold; }
@font-face { font-family: 'dk-medio';   src: url('<?php echo $f; ?>Barlow-Medium.ttf') format('truetype'); font-weight: normal; }
@font-face { font-family: 'dk-medio';   src: url('<?php echo $f; ?>Barlow-SemiBold.ttf') format('truetype'); font-weight: bold; }
@font-face { font-family: 'dk-titular'; src: url('<?php echo $f; ?>BarlowCondensed-SemiBold.ttf') format('truetype'); font-weight: normal; }
@font-face { font-family: 'dk-titular'; src: url('<?php echo $f; ?>BarlowCondensed-ExtraBold.ttf') format('truetype'); font-weight: bold; }
@font-face { font-family: 'dk-mono';    src: url('<?php echo $f; ?>SpaceMono-Regular.ttf') format('truetype'); font-weight: normal; }
@font-face { font-family: 'dk-mono';    src: url('<?php echo $f; ?>SpaceMono-Bold.ttf') format('truetype'); font-weight: bold; }

@page { margin: 0 0 34pt 0; }
* { margin: 0; padding: 0; }
body { font-family: 'dk-texto'; font-size: 8.6pt; line-height: 11.5pt; color: #1a2744; }
table { border-collapse: collapse; width: 100%; }
td { vertical-align: top; }
a { text-decoration: none; }

/* ── Cabecera ─────────────────────────────────────────── */
.cabecera { background: #0a1628; padding: 20pt 38pt 0 38pt; height: 72pt; position: relative; }
.ola   { position: absolute; left: 0; bottom: 0; width: 100%; height: 18pt; }
.marca { font-family: 'dk-titular'; font-weight: bold; font-size: 25pt; line-height: 25pt; letter-spacing: 3.5pt; color: #ffffff; }
.lema  { font-family: 'dk-mono'; font-size: 5.4pt; line-height: 8pt; letter-spacing: 0.9pt; color: #8fa3bd; margin-top: 5pt; }
.doc   { font-family: 'dk-titular'; font-weight: bold; font-size: 17pt; line-height: 17pt; letter-spacing: 1.5pt; color: #ffffff; }
.doc span { font-family: 'dk-mono'; font-weight: bold; font-size: 6.4pt; letter-spacing: 2pt; color: #f5a623; }
.numero { font-family: 'dk-mono'; font-size: 7.4pt; line-height: 10pt; color: #cbd5e1; margin-top: 5pt; }
.fecha  { font-size: 8pt; line-height: 10pt; color: #8fa3bd; margin-top: 1pt; }

/* ── Cuerpo ───────────────────────────────────────────── */
.cuerpo { padding: 15pt 38pt 0 38pt; }
.sobre    { font-family: 'dk-mono'; font-size: 5.9pt; line-height: 8pt; letter-spacing: 1.5pt; color: #64748b; }
.nombre   { font-family: 'dk-titular'; font-weight: bold; font-size: 23pt; line-height: 24pt; color: #0a1628; margin-top: 3pt; }
.nombre-largo { font-size: 17pt; line-height: 19pt; }
.contacto { font-family: 'dk-medio'; font-size: 7.9pt; line-height: 10.5pt; color: #0e6ba8; margin-top: 3pt; }
.saludo   { font-size: 8.4pt; line-height: 12pt; color: #475569; margin-top: 7pt; }

.tarjeta-total { background: #0a1628; border-radius: 9pt; padding: 13pt 15pt 11pt 15pt; }
.acento { width: 24pt; height: 3pt; background: #f5a623; border-radius: 1.5pt; margin-bottom: 7pt; }
.total-lbl   { font-family: 'dk-mono'; font-weight: bold; font-size: 5.9pt; line-height: 8pt; letter-spacing: 1.5pt; color: #f5a623; }
.total-monto { font-family: 'dk-titular'; font-weight: bold; font-size: 27pt; line-height: 29pt; color: #ffffff; margin-top: 5pt; }
.total-consultar { font-family: 'dk-titular'; font-weight: bold; font-size: 22pt; line-height: 24pt; color: #ffffff; margin-top: 5pt; }
.total-nota  { font-size: 7.6pt; line-height: 10pt; color: #8fa3bd; margin-top: 2pt; }
.total-desglose { margin-top: 8pt; border-top: 0.6pt solid #24344f; }
.total-desglose td { padding-top: 5pt; font-size: 7.4pt; line-height: 9.5pt; color: #8fa3bd; }
.total-desglose .m { font-family: 'dk-medio'; color: #e2e8f0; text-align: right; white-space: nowrap; }
.total-ref   { font-family: 'dk-medio'; font-size: 8pt; line-height: 10pt; color: #ffffff; margin-top: 3pt; }

.seccion { font-family: 'dk-mono'; font-weight: bold; font-size: 6.1pt; line-height: 8pt; letter-spacing: 1.8pt; color: #0e6ba8; margin: 11pt 0 5pt 0; }
.seccion span { color: #94a3b8; font-weight: normal; }

.ficha { background: #f3f6f9; border-radius: 7pt; }
.ficha td { padding: 8pt 12pt; }
.ficha .sep { border-left: 0.6pt solid #dde3ea; }
.lbl { font-family: 'dk-mono'; font-size: 5.6pt; line-height: 7pt; letter-spacing: 1pt; color: #64748b; }
.val { font-family: 'dk-titular'; font-size: 12pt; line-height: 13.5pt; color: #0a1628; margin-top: 3pt; }

/* ── Detalle + lo que incluye ─────────────────────────── */
.detalle td { padding: 5.5pt 0; border-bottom: 0.6pt solid #e2e8f0; vertical-align: middle; }
.detalle .cab td { font-family: 'dk-mono'; font-weight: bold; font-size: 5.6pt; line-height: 7pt; letter-spacing: 1.2pt; color: #94a3b8; padding: 0 0 4pt 0; border-bottom: 0.9pt solid #0a1628; }
.detalle .desc  { font-family: 'dk-medio'; font-size: 8.8pt; line-height: 11pt; color: #1a2744; }
.detalle .sub   { font-size: 7.1pt; line-height: 9pt; color: #94a3b8; }
.detalle .monto { font-family: 'dk-medio'; font-size: 8.8pt; line-height: 11pt; color: #1a2744; text-align: right; white-space: nowrap; }
.detalle .fila-total td { border-bottom: 0; padding-top: 7pt; }
.detalle .fila-total .desc  { font-family: 'dk-titular'; font-weight: bold; font-size: 13pt; line-height: 14pt; color: #0a1628; }
.detalle .fila-total .monto { font-family: 'dk-titular'; font-weight: bold; font-size: 13pt; line-height: 14pt; color: #0e6ba8; }
.letra-chica { font-size: 6.8pt; line-height: 9pt; color: #94a3b8; margin-top: 4pt; }

.incluye-caja { background: #f3f6f9; border-radius: 8pt; padding: 10pt 12pt 8pt 12pt; }
.incluye-tit { font-family: 'dk-mono'; font-weight: bold; font-size: 5.8pt; line-height: 8pt; letter-spacing: 1.5pt; color: #0e6ba8; }
.incluye-tit span { color: #94a3b8; font-weight: normal; }
.incluye { margin-top: 4pt; }
.incluye td { padding: 2.4pt 0; vertical-align: middle; }
.incluye .celda-check { width: 14pt; }
.incluye .es { font-family: 'dk-medio'; font-size: 7.9pt; line-height: 9.6pt; color: #1a2744; }
.incluye .en { font-size: 6.5pt; line-height: 8pt; color: #94a3b8; }
.check { width: 9pt; height: 9pt; }

/* ── Tarjetas de servicios ────────────────────────────── */
.bajada { font-size: 7.8pt; line-height: 10.5pt; color: #475569; margin: -2pt 0 7pt 0; }
.tarjetas td.hueco { width: 8pt; }
.tarjetas { page-break-inside: avoid; }
.tarjeta { border: 0.8pt solid #dbe4ee; border-radius: 8pt; padding: 8pt 11pt 7pt 11pt; height: 66pt; }
.tarjeta-gratis { border-color: #bfe8d6; background: #f2fbf7; }
.t-ico { width: 13pt; height: 13pt; }
.t-nombre { font-family: 'dk-titular'; font-weight: bold; font-size: 11.5pt; line-height: 12.5pt; color: #0a1628; margin-top: 5pt; }
.t-en { font-family: 'dk-mono'; font-size: 5.4pt; line-height: 7pt; letter-spacing: 0.8pt; color: #94a3b8; }
.t-precio { font-family: 'dk-titular'; font-weight: bold; font-size: 14pt; line-height: 15pt; color: #0e6ba8; margin-top: 6pt; }
.t-precio span { font-family: 'dk-texto'; font-weight: normal; font-size: 7pt; color: #64748b; }
.t-gratis { color: #00875a; }
.t-det { font-size: 6.9pt; line-height: 9pt; color: #64748b; margin-top: 2pt; }
.nota-en { font-size: 6.6pt; line-height: 9pt; color: #94a3b8; margin-top: 6pt; }

.aviso-ok { background: #effaf5; border-left: 3pt solid #00b87a; border-radius: 0 8pt 8pt 0; padding: 10pt 14pt 9pt 14pt; }
.aviso-tit { font-family: 'dk-titular'; font-weight: bold; font-size: 12pt; line-height: 14pt; color: #0b5d43; }
.aviso-tit span { font-family: 'dk-mono'; font-weight: bold; font-size: 5.8pt; letter-spacing: 1.4pt; color: #00875a; }
.aviso-ok p { font-size: 7.9pt; line-height: 11pt; color: #3d3d3d; margin-top: 4pt; }
.pasos-lista td { padding: 2pt 0; font-size: 7.9pt; line-height: 10.5pt; color: #3d3d3d; vertical-align: middle; }

/* ── Medios de pago ───────────────────────────────────── */
.pagos { margin-top: 10pt; border: 0.8pt solid #dbe4ee; border-radius: 8pt; padding: 0 10pt 0 12pt; }
.pagos td { vertical-align: middle; }
.pagos-izq { padding: 8pt 0; }
.pagos-tit { font-family: 'dk-mono'; font-weight: bold; font-size: 5.8pt; line-height: 8pt; letter-spacing: 1.4pt; color: #0e6ba8; }
.pagos-seg { font-size: 6.8pt; line-height: 9pt; color: #64748b; margin-top: 2pt; }
.pagos-seg img { width: 7pt; height: 7pt; }
.medio { border: 0.8pt solid #dbe4ee; border-radius: 5pt; padding: 4pt 7pt 3pt 7pt; background: #f8fafc; }
.medio-n { font-family: 'dk-medio'; font-weight: bold; font-size: 8pt; line-height: 9.5pt; color: #0a1628; white-space: nowrap; }
.medio-d { font-size: 6.2pt; line-height: 8pt; color: #64748b; white-space: nowrap; }
.pagos-link { font-family: 'dk-medio'; font-size: 7pt; line-height: 9pt; color: #0e6ba8; text-align: right; white-space: nowrap; }

/* ── Llamada a la acción y pie ────────────────────────── */
.cta { page-break-inside: avoid; margin-top: 10pt; background: #0e6ba8; border-radius: 9pt; padding: 11pt 14pt; }
.cta td { vertical-align: middle; }
.cta-tit { font-family: 'dk-titular'; font-weight: bold; font-size: 13pt; line-height: 15pt; color: #ffffff; }
.cta-txt { font-size: 7.8pt; line-height: 10.5pt; color: #cfe6f7; margin-top: 1pt; }
.cta-pasos { font-family: 'dk-medio'; font-size: 7.3pt; line-height: 10.5pt; color: #e6f2fb; margin-top: 3pt; }
.cta-n { font-family: 'dk-titular'; font-weight: bold; color: #f5a623; }
.boton { display: block; background: #ffffff; border-radius: 6pt; padding: 6pt 10pt; font-family: 'dk-medio'; font-weight: bold; font-size: 8pt; line-height: 10pt; color: #0a1628; text-align: center; white-space: nowrap; }
.boton-wa { background: #25d366; color: #ffffff; }
.boton img { width: 9pt; height: 9pt; }

.pie { position: fixed; left: 0; right: 0; bottom: 0; height: 22pt; background: #0a1628; padding: 12pt 38pt 0 38pt; }
.pie td { vertical-align: middle; }
.pie-txt { font-size: 7pt; line-height: 10pt; color: #cbd5e1; }
.pie-web { font-family: 'dk-mono'; font-size: 6.2pt; line-height: 10pt; letter-spacing: 0.5pt; color: #8fa3bd; text-align: right; }
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
    <td style="width:64%;">
      <table style="width:auto;"><tr>
        <?php if ($emblema): ?>
        <td style="width:50pt;vertical-align:middle;"><img src="<?php echo $emblema; ?>" style="width:40pt;height:40pt;"></td>
        <?php endif; ?>
        <td style="vertical-align:middle;">
          <div class="marca">DECKEVA</div>
          <div class="lema">PISOS NÁUTICOS A MEDIDA · CUSTOM MARINE EVA FLOORING</div>
        </td>
      </tr></table>
    </td>
    <td style="width:36%;text-align:right;vertical-align:middle;">
      <div class="doc">COTIZACIÓN <span>QUOTE</span></div>
      <div class="numero">N.º <?php echo $e($d['numero']); ?></div>
      <div class="fecha"><?php echo $e($d['fecha']); ?></div>
    </td>
  </tr></table>
  <img class="ola" src="<?php echo $ola; ?>">
</div>

<div class="cuerpo">

  <table><tr>
    <td style="width:56%;padding-right:20pt;">
      <div class="sobre">PREPARADA PARA · PREPARED FOR</div>
      <div class="nombre<?php echo mb_strlen($d['cliente']['nombre'], 'UTF-8') > 24 ? ' nombre-largo' : ''; ?>"><?php echo $e($d['cliente']['nombre']); ?></div>
      <?php if ($contacto !== ''): ?>
      <div class="contacto"><?php echo $e($contacto); ?></div>
      <?php endif; ?>
      <div class="saludo"><?php echo !empty($d['saludo']) ? $e($d['saludo']) : 'Gracias por cotizar con Deckeva. Aquí tienes el valor de tu piso náutico EVA a medida y todo lo que necesitas saber para avanzar.'; ?></div>
    </td>
    <td style="width:44%;">
      <div class="tarjeta-total">
        <div class="acento"></div>
        <div class="total-lbl">TOTAL ESTIMADO · ESTIMATED TOTAL</div>
        <?php if ($consultar): ?>
          <div class="total-consultar">A consultar</div>
          <div class="total-nota">Te confirmamos el valor · Quote on request</div>
        <?php else: ?>
          <div class="total-monto"><?php echo $e($precio['total']); ?></div>
          <div class="total-nota">IVA 19% incluido · VAT included</div>
          <?php if (!empty($precio['ref_usd'])): ?>
            <div class="total-ref">≈ <?php echo $e($precio['ref_usd']); ?></div>
          <?php endif; ?>
          <table class="total-desglose">
            <tr><td><?php echo $servicios ? 'Piso · neto' : 'Neto · Net'; ?></td><td class="m"><?php echo $e($precio['subtotal']); ?></td></tr>
            <tr><td><?php echo $servicios ? 'IVA 19% del piso' : 'IVA 19% · VAT'; ?></td><td class="m"><?php echo $e($precio['iva']); ?></td></tr>
            <?php // Los servicios extra van en el total: el desglose los muestra, o no suma. ?>
            <?php foreach ($servicios as $sv): ?>
            <tr><td><?php echo $e($sv['desc']); ?></td><td class="m"><?php echo $e($sv['monto']); ?></td></tr>
            <?php endforeach; ?>
          </table>
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

  <table style="margin-top:11pt;"><tr>
    <td style="width:57%;padding-right:16pt;">
      <table class="detalle">
        <tr class="cab"><td>DETALLE · BREAKDOWN</td><td style="text-align:right;">MONTO · AMOUNT</td></tr>
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
        <?php foreach ($servicios as $sv): ?>
        <tr>
          <td><div class="desc"><?php echo $e($sv['desc']); ?></div><?php if (!empty($sv['sub'])): ?><div class="sub"><?php echo $e($sv['sub']); ?></div><?php endif; ?></td>
          <td class="monto"><?php echo $e($sv['monto']); ?></td>
        </tr>
        <?php endforeach; ?>
        <tr class="fila-total">
          <td><div class="desc">Total</div></td>
          <td class="monto"><?php echo $e($precio['total']); ?></td>
        </tr>
        <?php endif; ?>
      </table>
      <div class="letra-chica">* Precio referencial · Reference quote. Se confirma al hacer el pedido · Final confirmation upon order.<?php
        echo !empty($precio['tipo_cambio']) ? ' Tipo de cambio ref. · Reference rate: ' . $e($precio['tipo_cambio']) . '.' : '';
      ?></div>
    </td>
    <td style="width:43%;">
      <div class="incluye-caja">
        <div class="incluye-tit">TU PISO INCLUYE <span>· INCLUDED</span></div>
        <table class="incluye">
          <?php foreach ($incluye as $it): ?>
          <tr><td class="celda-check"><img class="check" src="<?php echo $icono_check; ?>"></td><td><div class="es"><?php echo $e($it[0]); ?></div><div class="en"><?php echo $e($it[1]); ?></div></td></tr>
          <?php endforeach; ?>
        </table>
      </div>
    </td>
  </tr></table>

  <?php if ($forma_pago): ?>
  <div class="seccion">FORMA DE PAGO <span>· PAYMENT TERMS</span></div>
  <table class="detalle">
    <?php foreach ($forma_pago as $fp): ?>
    <tr>
      <td><div class="desc"><?php echo $e($fp['etiqueta']); ?></div><?php if (!empty($fp['detalle'])): ?><div class="sub"><?php echo $e($fp['detalle']); ?></div><?php endif; ?></td>
      <td class="monto"><?php echo $e($fp['monto']); ?></td>
    </tr>
    <?php endforeach; ?>
  </table>
  <?php endif; ?>

  <?php if ($servicios_incluidos !== ''): ?>
  <div class="seccion">TOMA DE MEDIDAS E INSTALACIÓN <span>· MEASUREMENT &amp; INSTALLATION</span></div>
  <div class="aviso-ok">
    <div class="aviso-tit">Las hacemos nosotros &nbsp;<span>INCLUIDAS · INCLUDED</span></div>
    <p><?php echo $e($servicios_incluidos); ?></p>
    <?php if ($proximos): ?>
    <table class="pasos-lista">
      <?php foreach ($proximos as $paso): ?>
      <tr><td style="width:14pt;"><img class="check" src="<?php echo $icono_check; ?>"></td><td><?php echo $e($paso); ?></td></tr>
      <?php endforeach; ?>
      <tr><td style="width:14pt;"><img class="check" src="<?php echo $icono_check; ?>"></td><td>Soporte <strong>24/7 por WhatsApp y teléfono (+56 9 4021 1459)</strong>.</td></tr>
    </table>
    <?php endif; ?>
  </div>
  <?php elseif (!$en_chile): ?>
  <?php // Fuera de Chile no se ofrece ir a medir ni a instalar: se hace con el video. ?>
  <div class="seccion">TOMA DE MEDIDAS E INSTALACIÓN <span>· LO HACES TÚ · DO IT YOURSELF</span></div>
  <div class="bajada">La toma de medidas y la instalación las puedes hacer tú mismo fácilmente. Deckeva te entrega todo esto <strong>sin costo</strong>:</div>
  <table class="tarjetas"><tr>
    <td style="width:32%;"><div class="tarjeta tarjeta-gratis">
      <img class="t-ico" src="<?php echo $icono_video; ?>">
      <div class="t-nombre">Video de medición</div><div class="t-en">MEASUREMENT VIDEO</div>
      <div class="t-precio t-gratis">Sin costo <span>· Free</span></div>
      <div class="t-det">Paso a paso para medir tu embarcación.</div>
    </div></td>
    <td class="hueco"></td>
    <td style="width:32%;"><div class="tarjeta tarjeta-gratis">
      <img class="t-ico" src="<?php echo $icono_video; ?>">
      <div class="t-nombre">Video de instalación</div><div class="t-en">INSTALLATION VIDEO</div>
      <div class="t-precio t-gratis">Sin costo <span>· Free</span></div>
      <div class="t-det">Paso a paso para instalar tu piso.</div>
    </div></td>
    <td class="hueco"></td>
    <td style="width:32%;"><div class="tarjeta tarjeta-gratis">
      <img class="t-ico" src="<?php echo $icono_soporte; ?>">
      <div class="t-nombre">Soporte 24/7</div><div class="t-en">24/7 SUPPORT</div>
      <div class="t-precio t-gratis">Sin costo <span>· Free</span></div>
      <div class="t-det">WhatsApp y teléfono +56 9 4021 1459.</div>
    </div></td>
  </tr></table>
  <div class="nota-en"><strong>EN:</strong> You can easily measure and install your flooring yourself with our free step-by-step videos and 24/7 WhatsApp &amp; phone support (+56 9 4021 1459).</div>
  <?php else: ?>
  <?php
    // Decisión de JP (29-sep-2026): son opcionales y NO se suman al total del
    // piso. Cada uno con su neto y su total con IVA. El valor sale de
    // deckeva-00-opcionales.php, no se escribe aquí.
    // Sin <u>: con fontHeightRatio 0,83 DOMPDF dibuja el subrayado a media
    // altura y «no están sumados al total» se leía tachado.
    $opcionales = deckeva_opcionales();
  ?>
  <div class="seccion">SERVICIOS OPCIONALES <span>· OPTIONAL SERVICES</span></div>
  <div class="bajada">Si prefieres que lo hagamos nosotros, tomamos las medidas e instalamos tu piso. Son <strong>opcionales</strong> y <strong>no están sumados al total</strong> de tu piso; mismo valor en todas las regiones y también para motos de agua. O hazlo tú mismo fácilmente con nuestro video, como prefieras.</div>
  <table class="tarjetas"><tr>
    <?php foreach ($opcionales as $i => $item): ?>
    <td style="width:32%;"><div class="tarjeta">
      <img class="t-ico" src="<?php echo $i === 0 ? $icono_regla : $icono_llave; ?>">
      <div class="t-nombre"><?php echo $e($item['nombre']); ?></div><div class="t-en"><?php echo $e(mb_strtoupper($item['nombre_en'], 'UTF-8') . ' · ' . mb_strtoupper($item['tiempo'], 'UTF-8')); ?></div>
      <div class="t-precio"><?php echo $e(deckeva_opcional_clp($item['neto'])); ?> <span>+ IVA</span></div>
      <div class="t-det">Total con IVA <strong><?php echo $e(deckeva_opcional_clp($item['total'])); ?></strong> · IVA <?php echo $e(deckeva_opcional_clp($item['iva'])); ?></div>
    </div></td>
    <td class="hueco"></td>
    <?php endforeach; ?>
    <td style="width:32%;"><div class="tarjeta tarjeta-gratis">
      <img class="t-ico" src="<?php echo $icono_mano; ?>">
      <div class="t-nombre">Lo haces tú</div><div class="t-en">DO IT YOURSELF</div>
      <div class="t-precio t-gratis">Sin costo <span>· Free</span></div>
      <div class="t-det">Videos paso a paso y soporte 24/7.</div>
    </div></td>
  </tr></table>
  <?php if (!$compacta): ?><div class="nota-en"><strong>EN:</strong> Measurement and installation (<?php echo $e(deckeva_opcional_clp($opcionales[0]['neto'], true)); ?> + VAT each) are optional and not added to your flooring total; same price in every region, jet skis included. Or do it yourself with our free videos and 24/7 support.</div><?php endif; ?>
  <?php endif; ?>

  <div class="pagos"><table><tr>
    <td class="pagos-izq">
      <div class="pagos-tit">MEDIOS DE PAGO · PAYMENT</div>
      <div class="pagos-seg"><img src="<?php echo $icono_candado; ?>"> Pago seguro · SSL 256-bit</div>
      <div class="pagos-seg" style="margin-top:0;">Procesadores certificados</div>
    </td>
    <?php foreach ($medios as $m): ?>
    <td style="padding:7pt 0 7pt 6pt;width:<?php echo $en_chile ? 94 : 128; ?>pt;"><a href="<?php echo $e($m[2]); ?>" style="display:block;"><div class="medio"><div class="medio-n"><?php echo $e($m[0]); ?></div><div class="medio-d"><?php echo $e($m[1]); ?></div></div></a></td>
    <?php endforeach; ?>
    <td class="pagos-link" style="width:70pt;"><a href="<?php echo $e($pago_url); ?>" style="color:#0e6ba8;">Pagar online &rsaquo;<br><?php echo $e($pago_txt); ?></a></td>
  </tr></table></div>

  <div class="cta">
    <table><tr>
      <td>
        <div class="cta-tit">¿Listo para avanzar? · Ready to go?</div>
        <?php if (!$proximos): ?>
        <div class="cta-pasos"><?php foreach ($pasos as $i => $paso): ?><span style="white-space:nowrap;"><span class="cta-n"><?php echo $i + 1; ?></span> <?php echo $e($paso[0]); ?></span><?php echo $i < count($pasos) - 1 ? ' &nbsp;&rsaquo; ' : ''; ?><?php endforeach; ?></div>
        <?php else: ?>
        <div class="cta-txt">Respóndenos por WhatsApp o correo y seguimos con tu piso.</div>
        <?php endif; ?>
      </td>
      <td style="width:112pt;padding-left:8pt;"><a class="boton boton-wa" href="<?php echo $e($wa_link); ?>"><img src="<?php echo $icono_wa; ?>"> &nbsp;+56 9 4021 1459</a></td>
      <td style="width:108pt;padding-left:6pt;"><a class="boton" href="<?php echo $e($mail_link); ?>">contacto@deckeva.cl</a></td>
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
