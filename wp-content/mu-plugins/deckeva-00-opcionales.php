<?php
/**
 * Plugin Name: Deckeva - Servicios opcionales (toma de medidas e instalación)
 * Description: El valor de la toma de medidas y de la instalación, en un solo lugar.
 *
 * Decisión de JP (29-sep-2026): la toma de medidas y la instalación son dos
 * servicios OPCIONALES de Deckeva, a $155.000 + IVA cada uno. Mismo valor en
 * todas las regiones y también para motos de agua. Son opcionales porque el
 * cliente puede medir e instalar él mismo con el video explicativo que le
 * mandamos.
 *
 * Hasta esa fecha la cotización decía lo contrario: que el cliente tenía que
 * contratar a un técnico por su cuenta, con una referencia de $145.000 en
 * Santiago. Ese texto ya no va en ninguna parte.
 *
 * Dos reglas que no se negocian:
 * - Los opcionales NO se suman al total del piso. Van en su propia sección
 *   («Opcionales»), cada uno con su neto, su IVA y su total con IVA.
 * - El valor se escribe SOLO aquí. El PDF (deckeva-assets/pdf-cotizacion.php),
 *   el PDF de respaldo y el correo del cotizador lo leen de estas constantes.
 *   El chat de WhatsApp no dice montos: dice que van en la cotización.
 *
 * Lleva «00» para cargar antes que los demás mu-plugins, y la plantilla del
 * PDF lo incluye con require_once para poder previsualizarse sin WordPress.
 */

if (!defined('ABSPATH')) {
    exit;
}

const DECKEVA_PRECIO_MEDICION    = 155000;
const DECKEVA_PRECIO_INSTALACION = 155000;

/**
 * Los dos opcionales, con el IVA ya calculado. El redondeo del IVA es el mismo
 * que el del piso (round de neto × 0,19).
 *
 * @return array<int, array{clave:string, nombre:string, nombre_en:string, tiempo:string, neto:int, iva:int, total:int}>
 */
function deckeva_opcionales() {
    $items = array(
        array('clave' => 'medicion',    'nombre' => 'Toma de medidas', 'nombre_en' => 'Measurement',  'tiempo' => '4–6 h aprox.', 'neto' => DECKEVA_PRECIO_MEDICION),
        array('clave' => 'instalacion', 'nombre' => 'Instalación',     'nombre_en' => 'Installation', 'tiempo' => '3–5 h aprox.', 'neto' => DECKEVA_PRECIO_INSTALACION),
    );
    foreach ($items as $i => $item) {
        $items[$i]['iva']   = (int) round($item['neto'] * 0.19);
        $items[$i]['total'] = $item['neto'] + $items[$i]['iva'];
    }
    return $items;
}

/**
 * Un monto en pesos chilenos, con el formato de la cotización: «CLP $155.000».
 * Con $en = true usa la coma de miles del inglés: «CLP $155,000».
 */
function deckeva_opcional_clp($monto, $en = false) {
    return 'CLP $' . number_format((int) $monto, 0, $en ? '.' : ',', $en ? ',' : '.');
}

/**
 * ¿Se ofrecen los opcionales en este país? Sólo en Chile: «mismo valor en
 * todas las regiones» son las regiones de Chile. A un cliente de afuera no se
 * le promete ir a medir ni a instalar a precio chileno; se le ofrece hacerlo
 * él con el video y el soporte. Sin país (WhatsApp, formulario de Chile) es
 * Chile.
 */
function deckeva_opcionales_en_pais($pais) {
    $p = strtolower(trim((string) $pais));
    $p = function_exists('remove_accents') ? remove_accents($p) : $p;
    return $p === '' || in_array($p, array('chile', 'cl'), true);
}
