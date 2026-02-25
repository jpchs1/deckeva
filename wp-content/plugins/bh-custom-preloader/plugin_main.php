<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/*
Plugin Name: BH Custom Preloader
Plugin URI: https://wordpress.org/plugins/bh-custom-preloader/
Description: This is BH Custom Preloader WordPress plugin.It will be enable Preloader on your web site. You can change Every things from settings
Author: Masum Billah
Author URI: https://themesvila.com/
Version: 2.6
*/


//define

define( 'BHCUSTOMPREPLUGINDIR', dirname( __FILE__ ) ); 

// Some configure
define('BHCUSTOMPRELOADERASSETS' , WP_PLUGIN_URL .'/' . plugin_basename(dirname(__FILE__)) . '/');



// Added Setting Link
add_filter( 'plugin_action_links_'.plugin_basename(__FILE__), 'bh_custom_preloader_settings_link' );
function bh_custom_preloader_settings_link($links) {
	$newlink = sprintf("<a href='%s'>%s</a>",'admin.php?page=bh-preloader',__('Settings','custom-preloader'));
	$links[] = $newlink;
	return $links;
}

include_once(BHCUSTOMPREPLUGINDIR. '/inc/init.php');