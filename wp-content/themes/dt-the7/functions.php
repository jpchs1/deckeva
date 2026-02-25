<?php
/**
 * The7 theme.
 *
 * @since   1.0.0
 *
 * @package The7
 */


defined( 'ABSPATH' ) || exit;

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since 1.0.0
 */
if ( ! isset( $content_width ) ) {
	$content_width = 1200; /* pixels */
}

/**
 * Initialize theme.
 *
 * @since 1.0.0
 */
require trailingslashit( get_template_directory() ) . 'inc/init.php';
update_site_option( 'the7_registered', 'yes' );
update_site_option( 'the7_purchase_code', 'GPL' );
delete_site_option( 'the7_auto_deactivated' );

/* Desactivar notificaciones de WordPress */

add_action('after_setup_theme', 'remove_core_updates');

function remove_core_updates() {
	if (!current_user_can('update_core')) {
		return;
	}
	add_action('init', create_function('$a', "remove_action( 'init', 'wp_version_check' );"), 2);
	add_filter('pre_option_update_core', '__return_null');
	add_filter('pre_site_transient_update_core', '__return_null');
}


/* Desactivar notificaciones de Themes */

remove_action('load-update-core.php', 'wp_update_themes');
add_filter('pre_site_transient_update_themes', create_function('$a', "return null;"));

/* Desactivar notificaciones de Plugins */

remove_action('load-update-core.php', 'wp_update_plugins');
add_filter('pre_site_transient_update_plugins', '__return_null');

