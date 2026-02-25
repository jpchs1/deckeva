<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://gentechtreedesign.com/
 * @since      1.0.0
 *
 * @package    Streamlab_Core
 * @subpackage Streamlab_Core/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Streamlab_Core
 * @subpackage Streamlab_Core/public
 * @author     Gentechtree <Gentechtree@gmail.com>
 */
class Streamlab_Core_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Streamlab_Core_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Streamlab_Core_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( 'slick', plugin_dir_url( __FILE__ ) . 'css/vendor/slick.min.css', array(), $this->version, 'all' );
		
		wp_enqueue_style( 'slick-theme', plugin_dir_url( __FILE__ ) . 'css/vendor/slick-theme.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'magnific-popup', plugin_dir_url( __FILE__ ) . 'css/vendor/magnific-popup.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'jquery.mCustomScrollbar', plugin_dir_url( __FILE__ ) . 'css/vendor/jquery.mCustomScrollbar.min.css', array(), $this->version, 'all' );

		// wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/streamlab-core-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		$min = (defined('SCRIPT_DEBUG') &&  SCRIPT_DEBUG ) ? '' : '.min'; 

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Streamlab_Core_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Streamlab_Core_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( 'asyncloader', plugin_dir_url( __FILE__ ) . '/js/vendor/asyncloader.min.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script( 'slick', plugin_dir_url( __FILE__ ) . '/js/vendor/slick.min.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/streamlab-core.js', array( 'jquery' , 'asyncloader' ), $this->version, false );

		$vendor_script = array();
		$vendor_scripts_url = plugin_dir_url( __FILE__ ) . '/js/vendor/';

		foreach( glob( plugin_dir_path( __FILE__ ) . '/js/vendor/*.js') as $dependency ) {
				$current_index = basename( $dependency, '.min' . '.js' );
				$cur_dep = add_query_arg( 'ver',  '1.0', $vendor_scripts_url . basename( $dependency ) );
				$vendor_script[ $current_index ] = esc_url( $cur_dep );
			}

	wp_localize_script( $this->plugin_name, 'simpleLikes', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'like' => __( 'Like', 'streamlab-core' ),
		'unlike' => __( 'Unlike', 'streamlab-core' )
	) );
			

		wp_localize_script(
			$this->plugin_name, 
			'PluginJsConfig', 
			array(
				
				'js_dependencies'     => $vendor_script,
				
			) 
		);

	}

}
