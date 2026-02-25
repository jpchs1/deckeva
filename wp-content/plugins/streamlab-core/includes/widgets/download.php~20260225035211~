<?php
function streamlab_core_download() {
    register_widget( 'Gen_Download' );
}
add_action( 'widgets_init', 'streamlab_core_download' );

/*-------------------------------------------
		streamlab-core Contact Information widget 
--------------------------------------------*/
class Gen_Download extends WP_Widget {
 
	function __construct() {
		parent::__construct(
 
			// Base ID of your widget
			'Gen_Download', 
			
			// Widget name will appear in UI
			esc_html('Downlaod App', 'streamlab-core'), 
 
			// Widget description
			array( 'description' => esc_html( 'Downlaod App. ', 'streamlab-core' ), ) 
		);
	}
 
	// Creating widget front-end
	
	public function widget( $args, $instance ) {

		global $wp_registered_sidebars;
		$theme_options = get_option('theme_options');

		// print_r($theme_options['hostingo_social']);

		
        if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : false;
		
		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$footer_about = isset( $instance['footer_about'] ) ? $instance['footer_about'] : false;

		
		$logo_playstore = '';
		$logo_appstore = '';
		$link_appstore = '';
		$link_playstore = '';
		
		if(!empty($theme_options['logo_playstore']['url']))
		{
			$logo_playstore = $theme_options['logo_playstore']['url'];
		}

		if(!empty($theme_options['logo_appstore']['url']))
		{
			$logo_appstore = $theme_options['logo_appstore']['url'];
		}

		if(!empty($theme_options['link_playstore']))
		{
			$link_playstore = $theme_options['link_playstore'];
		}

		if(!empty($theme_options['link_appstore']))
		{
			$link_appstore = $theme_options['link_appstore'];
		}

		
		

		/* here add extra display item  */ 
		?>
		<div class="widget">
			<?php if ( $title ) {
			echo ($args['before_title'] . $title . $args['after_title']);
			} ?>
			<div class="row">
				<div class="col-sm-12">
					  <?php
					if($footer_about)
					{ 
					?>
					<p><?php echo esc_html($footer_about); ?></p>
				<?php } ?>
					<a href="<?php echo esc_url($link_playstore); ?>">
					
					<img src="<?php echo esc_url($logo_playstore) ?>" class="gen-playstore-logo" alt="<?php esc_attr_e('playstore','streamlab-core'); ?>">
					</a>
					<a href="<?php echo esc_url($link_appstore); ?>">
					<img src="<?php echo esc_url($logo_appstore) ?>" class="gen-appstore-logo" alt="<?php esc_attr_e('appstore','streamlab-core'); ?>">
				  </a>

			   
			
			</div>
		</div>
			</div>	
		
	<?php	
	}
         
	// Widget Backend 
	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$footer_about = isset( $instance['footer_about'] ) ? esc_html($instance['footer_about'])  : false;	
		
		?>
		
		<p><label for="<?php echo esc_html($this->get_field_id( 'title','streamlab-core' )); ?>"><?php esc_html_e( 'Title:','streamlab-core' ); ?></label>
		<input class="widefat" id="<?php echo esc_html($this->get_field_id( 'title','streamlab-core' )); ?>" name="<?php echo esc_html($this->get_field_name( 'title','streamlab-core')); ?>" type="text" value="<?php echo esc_html($title,'streamlab-core'); ?>" /></p>

		<p>
			<textarea class="widefat" id="<?php echo esc_html($this->get_field_id( 'footer_about','streamlab-core' )); ?>" name="<?php echo esc_html($this->get_field_name( 'footer_about','streamlab-core')); ?>" placeholder="<?php esc_attr__('Enter description text here' , 'streamlab-core') ?>"><?php echo esc_html($footer_about); ?></textarea>
		</p>
		
	
		
		<?php 					
	}

	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = sanitize_text_field( $new_instance['title'] );

		$instance['footer_about'] = sanitize_text_field( $new_instance['footer_about'] );
		
		
        return $instance;
	}
} 
/*---------------------------------------
		Class wpb_widget ends here
----------------------------------------*/	
