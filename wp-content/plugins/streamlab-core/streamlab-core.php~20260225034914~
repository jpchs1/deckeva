<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://gentechtreedesign.com/
 * @since             1.0.0
 * @package           Streamlab_Core
 *
 * @wordpress-plugin
 * Plugin Name:       Stream Lab Core
 * Plugin URI:        http://gentechtreedesign.com/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           2.0.6
 * Author:            Gentechtree
 * Author URI:        http://gentechtreedesign.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       streamlab-core
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'STREAMLAB_CORE_VERSION', '2.0.5' );
define( 'STREAMLAB_CORE_DIR', plugin_dir_path( __FILE__ ) );
define( 'STREAMLAB_CORE_URL', plugin_dir_url( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-streamlab-core-activator.php
 */
function activate_streamlab_core() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-streamlab-core-activator.php';
	Streamlab_Core_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-streamlab-core-deactivator.php
 */
function deactivate_streamlab_core() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-streamlab-core-deactivator.php';
	Streamlab_Core_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_streamlab_core' );
register_deactivation_hook( __FILE__, 'deactivate_streamlab_core' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-streamlab-core.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_streamlab_core() {

	$plugin = new Streamlab_Core();
	$plugin->run();

}
run_streamlab_core();

// remove_filter( 'the_content', 'wpautop' );
// remove_filter( 'the_excerpt', 'wpautop' );
