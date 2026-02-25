<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://gentechtreedesign.com/
 * @since      1.0.0
 *
 * @package    Streamlab_Core
 * @subpackage Streamlab_Core/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Streamlab_Core
 * @subpackage Streamlab_Core/admin
 * @author     Gentechtree <Gentechtree@gmail.com>
 */
class Streamlab_Core_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->load_dependencies();
		add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
		add_action('save_post', array($this, 'save_post'));

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/streamlab-core-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

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

		wp_enqueue_script( 'streamlab-core-admin', plugin_dir_url( __FILE__ ) . 'js/streamlab-core-admin.js', array( 'jquery' ), $this->version, false );
		$youtube_api = get_option( 'gen_youtube_api_key' );
		$vimoe_api_key = get_option( 'gen_vimoe_api_key' );
		$omdb_api_key = get_option( 'gen_omdb_api_key' );
		wp_localize_script('streamlab-core-admin', 'streamlab_obj', [
            'ajaxurl' => esc_js(admin_url('admin-ajax.php')),
            'youtube' => esc_js('https://www.googleapis.com/youtube/v3/search?part=snippet&maxResults=10&key='.$youtube_api.'&q='),
            'vimeo' => esc_js('https://api.vimeo.com/videos?per_page=10&page=1&query='),
            'omdb' => esc_js('https://www.omdbapi.com/?apikey='.$omdb_api_key.'&'),
            'ajax_nonce' => esc_js( wp_create_nonce('_notice_nonce') ),
            'vimoe_api_key' => esc_js( $vimoe_api_key ),
            'youtube_api_key' => esc_js( $youtube_api ),
            'omdb_api_key' => esc_js( $omdb_api_key ),
		]);

	}

	private function load_dependencies()
	{
		require_once plugin_dir_path( __FILE__  ) . 'classes/helpers.php';
		require_once plugin_dir_path( __FILE__  ) . 'classes/panel.php';
		require_once plugin_dir_path( __FILE__  ) . 'classes/admin_functions.php';
	}

	public function add_meta_boxes( ) {
		add_meta_box('streamlab-clear-post-view', __('Post Views', 'quiz-master-next'), array($this, 'plan_type_form_builder'), array('movie','video','tv_show','episode'));
	}

	public function save_post( $post_id ) {
		if (isset( $_POST['streamlab_custom_post_view'])) {
			update_post_meta($post_id, 'post_views_count', $_POST['streamlab_custom_post_view']);
		}
	}

	public function plan_type_form_builder( $post ) {
		$views = get_post_meta($post->ID, 'post_views_count', true);
		if ($views == 1) {
            $view = esc_html__(' View', 'streamlab');
         } else {
            $view = esc_html__(' Views', 'streamlab');
         }
		?>
		<strong><?php echo self::number_format_short($views) .' '.$view; ?></strong>
		<br/>
		<label>Adjust View</label>
		<input type="text" name="streamlab_custom_post_view"> 
		<br/>
		
		<?php 
	}

	public static function number_format_short($n, $precision = 1)
   {
      if(  $n == '') {
      	$n = 0;
      }
      if ($n < 900) {
         // 0 - 900
         $n_format = number_format($n, $precision);
         $suffix   = '';
      } else if ($n < 900000) {
         // 0.9k-850k
         $n_format = number_format($n / 1000, $precision);
         $suffix   = 'K';
      } else if ($n < 900000000) {
         // 0.9m-850m
         $n_format = number_format($n / 1000000, $precision);
         $suffix   = 'M';
      } else if ($n < 900000000000) {
         // 0.9b-850b
         $n_format = number_format($n / 1000000000, $precision);
         $suffix   = 'B';
      } else {
         // 0.9t+
         $n_format = number_format($n / 1000000000000, $precision);
         $suffix   = 'T';
      }

      if ($precision > 0) {
         $dotzero  = '.' . str_repeat('0', $precision);
         $n_format = str_replace($dotzero, '', $n_format);
      }

      return $n_format . $suffix;
   }

}
