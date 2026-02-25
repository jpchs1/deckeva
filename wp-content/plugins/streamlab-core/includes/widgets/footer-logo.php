<?php
function streamlab_core_footer_logo() {
    register_widget( 'Gen_Footer_Logo' );
}
add_action( 'widgets_init', 'streamlab_core_footer_logo' );

/*-------------------------------------------
		streamlab-core Contact Information widget 
--------------------------------------------*/
class Gen_Footer_Logo extends WP_Widget {
 
	function __construct() {
		parent::__construct(
 
			// Base ID of your widget
			'Gen_Footer_Logo', 
			
			// Widget name will appear in UI
			esc_html('Footer Logo', 'streamlab-core'), 
 
			// Widget description
			array( 'description' => esc_html( 'Footer Logo. ', 'streamlab-core' ), ) 
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
		$social = $theme_options['social_link'];
		
		if(!empty($theme_options['logo_footer']['url']))
		{
			$logo = $theme_options['logo_footer']['url'];
		}
		else
		{
			$logo = '';
		}

		/* here add extra display item  */ 
		?>
		<div class="widget">
			<?php if ( $title ) {
			echo ($args['before_title'] . $title . $args['after_title']);
			} ?>
			<div class="row">
				<div class="col-sm-12">
					<img src="<?php echo esc_url($logo) ?>" class="gen-footer-logo" alt="<?php esc_attr_e('gen-footer-logo','streamlab-core'); ?>">
					<?php
					if($footer_about)
					{ 
					?>
					<p><?php echo esc_html($footer_about); ?></p>
				<?php } ?>
				
				<ul class="social-link">
                <?php 
              	foreach($social as $key=>$val)
              	{

              		if(!empty($val))
              		{
              	?>
                <li><a href="<?php echo esc_url($val); ?>" class="facebook"><i class="fab <?php echo esc_attr($key); ?>"></i></a></li>
                <?php } } ?>
             </ul>
				
			
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
