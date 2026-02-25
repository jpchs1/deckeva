<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


bhpreloader_version_compare();

/**
 * Custome core required version message
 *
 * @since 1.8
 */
function bhpreloader_version_compare() {
	
	$bhpreloader_file = WP_PLUGIN_DIR . '/bh-custom-preloader-pro/plugin_main.php';
	
	if (!class_exists( 'bh_custom_preloader_pro_main' )) {
		
		// Adding css and jquery files
		function bh_custom_preloader_files(){
			
			wp_enqueue_style('bh-preloader-style' , BHCUSTOMPRELOADERASSETS .'css/style.css' );		
			wp_enqueue_script('jquery');

		}

		add_action('wp_enqueue_scripts' , 'bh_custom_preloader_files');	

		// Add main files
		include_once(BHCUSTOMPREPLUGINDIR. '/preloader.php');
		
		// Add main files
		if( !class_exists( 'CSF' ) ) {	
			include_once(BHCUSTOMPREPLUGINDIR. '/options/codestar-framework.php');
		}
		
		include_once(BHCUSTOMPREPLUGINDIR. '/options.php');	
		
		
	}
}


