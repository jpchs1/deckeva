<?php
/**
 * Plugin Name: Deckeva - Valores por largo para WhatsApp
 * Description: Las capturas del cotizador de deckeva.cl/#cotizar, una por tamaño, para
 *              mandarle al cliente por WhatsApp apenas dice el largo de su lancha.
 *
 * JP, 1-oct-2026: «cuando detectes que es para piso de lancha, pregúntale al
 * cliente qué tamaño es su lancha, y una vez te dé el largo le envías el
 * screenshot de lo que aparece en deckeva.cl/#cotizar según el tamaño. Y luego le
 * preguntas: en caso de querer avanzar, podemos enviar cotización formal.»
 *
 * Las imágenes viven en staging/img/valores-wa/ y se sirven desde deckeva.com
 * (igual que las fotos de proyectos). Las saca .github/capturas-valores/capturas.js
 * del sitio publicado.
 *
 * El número de cada captura está escrito acá (el precio que muestra la imagen).
 * Antes de mandar una, se compara con la tabla del home publicado
 * (deckeva_wa_cotiza_tabla): si el precio cambió, la imagen quedó vieja y NO
 * sale; el chat queda para JP. Una captura con un precio que ya no existe es
 * peor que no mandar nada. En CI, .github/checks/valores-wa.php hace la misma
 * comparación contra staging/index-cl.html y falla si una quedó vieja: ahí se
 * vuelven a sacar.
 */

if (!defined('ABSPATH')) {
    exit;
}

const DECKEVA_WA_VALORES_URL = 'https://deckeva.com/staging/img/valores-wa/';

/** clave del cotizador → precio (CLP, sin IVA) que muestra su captura. */
const DECKEVA_WA_VALORES = array(
    '14' => 658337,
    '15' => 780071,
    '16' => 827327,
    '17' => 877889,
    '18' => 931992,
    '19' => 989881,
    '20' => 1051823,
    '21' => 1118101,
    '22' => 1189018,
    '23' => 1264898,
    '24' => 1346092,
    '25' => 1432968,
    '26' => 1525926,
    '27' => 1668018,
    '28' => 1824362,
    '29' => 1996253,
    '30' => 2185378,
    'moto-normal' => 350000,
    'moto-grande' => 450000,
);

/**
 * La clave del cotizador para lo que dijo el cliente: «20», «20,5 pies»,
 * «moto-normal». '' si no es un tamaño del cotizador.
 */
function deckeva_wa_valores_clave($largo) {
    $t = mb_strtolower(trim((string) $largo));
    if ($t === 'moto-normal' || $t === 'moto-grande') return $t;
    if (!preg_match('/^(\d{1,2})(?:[.,](\d+))?/', $t, $m)) return '';
    $pies = (float) ($m[1] . '.' . ($m[2] ?? '0'));
    $clave = function_exists('deckeva_wa_cotiza_redondear') ? (string) deckeva_wa_cotiza_redondear($pies) : (string) (int) ceil($pies);
    return isset(DECKEVA_WA_VALORES[$clave]) ? $clave : '';
}

/**
 * La URL de la captura para esa clave, sólo si su precio sigue siendo el del
 * home publicado. '' si no hay captura o quedó vieja.
 *
 * @param array|null $tabla la del home (deckeva_wa_cotiza_tabla) · se inyecta en las pruebas
 */
function deckeva_wa_valores_url($clave, $tabla = null) {
    $clave = (string) $clave;
    if (!isset(DECKEVA_WA_VALORES[$clave])) return '';
    if ($tabla === null) $tabla = function_exists('deckeva_wa_cotiza_tabla') ? deckeva_wa_cotiza_tabla() : array();
    if ((int) ($tabla[$clave] ?? 0) !== (int) DECKEVA_WA_VALORES[$clave]) return '';
    return DECKEVA_WA_VALORES_URL . $clave . '.jpg';
}
