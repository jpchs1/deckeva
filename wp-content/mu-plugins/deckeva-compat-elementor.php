<?php
/**
 * Plugin Name: Deckeva - Compatibilidad de Elementor 4 con Elementor Pro antiguo
 * Description: Evita que Elementor 4.3 tumbe todo WordPress por un experimento de
 *              Elementor Pro 3.12, y pausa las actualizaciones automáticas de
 *              Elementor mientras Pro siga en la 3.x. No toca archivos de terceros.
 *
 * El caso (23/09/2026): a las 01:28 UTC Elementor se actualizó solo de la 3.x a la
 * 4.3.0 y todo WordPress de deckeva.cl pasó a responder "Ha habido un error
 * crítico": escritorio, cotizador, el formulario de la home y los de Contact Form 7.
 *
 * Por qué: Elementor Pro 3.12 (de 2023, sin licencia para actualizarse) registra el
 * experimento "mega-menu" con dependencia de "nested-elements". Elementor 4.3 marca
 * "nested-elements" como oculto y lanza Dependency_Exception ("Depending on a hidden
 * experiment is not allowed") cuando algo depende de un experimento oculto. Nadie
 * la captura, así que cae la carga entera de WordPress, en cada visita.
 *
 * Arreglo: registrar "nested-elements" justo antes que Elementor, con sus mismos
 * datos pero visible. Elementor ignora un experimento que ya está registrado, se
 * queda con este y la dependencia de Pro vuelve a ser válida. El experimento sigue
 * igual de activo y sin poder desactivarse; solo aparece en la lista de funciones
 * de Elementor.
 *
 * Sobra cuando Elementor Pro se actualice a una versión hecha para Elementor 4, o
 * si se desactiva Pro: entonces se puede borrar este archivo.
 */

if (!defined('ABSPATH')) {
    exit;
}

// Se dispara al crear el gestor de experimentos, después de los experimentos base
// ("container" incluido) y antes de que Elementor registre los de sus módulos.
add_action('elementor/experiments/default-features-registered', 'deckeva_compat_elementor_nested', 10, 1);

function deckeva_compat_elementor_nested($experimentos) {
    // Solo hace falta con Elementor Pro activo: es Pro quien depende del experimento.
    if (!defined('ELEMENTOR_PRO_VERSION') || !is_object($experimentos) || !method_exists($experimentos, 'add_feature')) {
        return;
    }

    $clase = '\Elementor\Modules\NestedElements\Module';
    if (!class_exists($clase) || !method_exists($clase, 'get_experimental_data')) {
        return;
    }

    $datos = call_user_func(array($clase, 'get_experimental_data'));
    if (!is_array($datos) || empty($datos['name']) || empty($datos['hidden'])) {
        // Si esta versión de Elementor no lo oculta, no hay nada que corregir.
        return;
    }

    $datos['hidden'] = false;

    try {
        $experimentos->add_feature($datos);
    } catch (\Throwable $e) {
        // Mejor seguir sin el arreglo que convertirlo en otra caída.
        error_log('[Deckeva compat Elementor] No se pudo registrar nested-elements: ' . $e->getMessage());
    }
}

/*
 * Sin actualizaciones automáticas de Elementor mientras Pro sea de la generación
 * anterior (3.x frente a Elementor 4). La de la 4.3 tumbó el sitio sola, de
 * madrugada; la siguiente puede traer otra incompatibilidad que este archivo no
 * cubre. Decisión del dueño (23/09/2026). Se puede seguir actualizando a mano desde
 * Plugins, comprobando después que el sitio responde. Al actualizar Pro a la 4.x,
 * las automáticas vuelven solas.
 */
add_filter('auto_update_plugin', 'deckeva_compat_elementor_sin_autoactualizar', 20, 2);

function deckeva_compat_elementor_sin_autoactualizar($actualizar, $item) {
    $es_elementor = is_object($item) && (
        (isset($item->plugin) && $item->plugin === 'elementor/elementor.php')
        || (isset($item->slug) && $item->slug === 'elementor')
    );

    if ($es_elementor && defined('ELEMENTOR_PRO_VERSION') && version_compare(ELEMENTOR_PRO_VERSION, '4.0', '<')) {
        return false;
    }

    return $actualizar;
}
