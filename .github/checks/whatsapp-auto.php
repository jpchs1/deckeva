<?php
/**
 * El contestador queda en automático, y automático sigue sin ser «sale todo».
 *
 * JP lo pidió el 6-oct-2026: «pon a Deckeva en modo automático, y lo que no
 * sepa responder que me lo pregunte por WhatsApp, así yo le voy contestando y
 * él va aprendiendo». Las dos mitades de esa frase son este chequeo:
 *
 *  1. El modo por defecto es automático, y hay una migración de una sola vez
 *     (el formulario de wp-admin guarda SIEMPRE la clave, así que cambiar el
 *     default no alcanzaba).
 *  2. Lo que la IA no sabe sigue yendo a JP: `necesita_humano`, lo que suena a
 *     robot y lo que no pasa las reglas NO pueden salir solos. Si alguien saca
 *     una de esas tres condiciones del `$auto`, el contestador empieza a
 *     mandarle al cliente justo lo que había que mirar.
 *  3. Lo que JP corrige se guarda y entra al prompt, con tope.
 */
define('ABSPATH', __DIR__ . '/');
$f = __DIR__ . '/../../wp-content/mu-plugins/deckeva-whatsapp.php';
$src = (string) file_get_contents($f);
$mal = 0;
$exigir = static function (bool $ok, string $que) use (&$mal): void {
    if ($ok) return;
    echo "  ✗ {$que}\n";
    $mal++;
};

// 1 · automático, y la migración de una sola vez
$exigir((bool) preg_match("/deckeva_wa_opcion\('modo',\s*'automatico'\)/", $src), 'el modo por defecto es automático');
$exigir(strpos($src, "deckeva_wa_auto_2026_10_06") !== false, 'está la marca de la migración de una sola vez');
$exigir((bool) preg_match('/add_action\(\s*.init.,\s*function\s*\(\)\s*\{[^}]*deckeva_wa_auto_2026_10_06/s', $src), 'la migración corre en init y deja su marca');
$exigir((bool) preg_match("/get_option\('deckeva_wa_auto_2026_10_06'\)\s*===\s*'listo'\)\s*return;/", $src),
    'la migración no se repite: si la marca está, no toca el modo (JP puede volver a borrador)');
// El selector de wp-admin tiene que seguir mandando.
$exigir(strpos($src, "update_option('deckeva_wa_modo', (\$_POST['modo'] ?? '') === 'automatico'") !== false,
    'el selector de wp-admin sigue guardando el modo que elija JP');

// 2 · automático NO es «sale cualquier cosa»
if (preg_match('/\$auto = deckeva_wa_modo\(\) === .automatico.(.*?);\n/s', $src, $m)) {
    $cond = $m[1];
    $exigir(strpos($cond, '!$r[\'necesita_humano\']') !== false, 'lo que necesita una persona NO sale solo');
    $exigir(strpos($cond, '$regla === \'\'') !== false, 'lo que no pasa las reglas (importes, guion largo, largo) NO sale solo');
} else {
    $exigir(false, 'se encontró la condición de salida automática');
}
$exigir((bool) preg_match('/\$regla = deckeva_wa_suena_a_robot\(/', $src), 'lo que suena a robot sigue frenando el borrador');

// 3 · aprende de las correcciones de JP, con techo
$exigir(strpos($src, 'function deckeva_wa_aprender(') !== false, 'existe deckeva_wa_aprender()');
$exigir(substr_count($src, 'deckeva_wa_aprender(') >= 3, 'se aprende por los DOS caminos: el WhatsApp de JP y el textarea de wp-admin');
$exigir(strpos($src, 'deckeva_wa_correcciones_prompt()') !== false && strpos($src, '. deckeva_wa_correcciones_prompt();') !== false,
    'las correcciones entran en el prompt del sistema');
$exigir((bool) preg_match('/const DECKEVA_WA_CORRECCIONES_MAX = \d+;/', $src), 'las correcciones tienen tope (el prompt no crece sin techo)');
$exigir(strpos($src, 'array_slice($todas, -DECKEVA_WA_CORRECCIONES_MAX)') !== false, 'al pasar el tope se cae la más vieja, no la más nueva');
// Aprender no puede ser una puerta trasera para saltarse las reglas.
$exigir((bool) preg_match('/\$v = deckeva_wa_validar\(\$t\);/', $src), 'el texto que aprueba JP por WhatsApp sigue pasando por validar()');

if ($mal) {
    echo "::error::{$mal} condición(es) del contestador automático no se cumplen.\n";
    exit(1);
}
echo "El contestador queda en automático, lo que no sabe sigue yendo a JP, y lo que él corrige se aprende.\n";
