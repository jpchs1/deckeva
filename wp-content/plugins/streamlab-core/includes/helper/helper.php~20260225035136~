<?php 
class Plugin_Helper
{
	protected static $instance = null;
	private  $theme_options = array();
	public static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	public function __construct (){
		$this->theme_options = get_option('theme_options'); 
		add_filter('pms_register_subscription_success_message',array($this,'pms_register_success_message') ,9999,1);
		add_filter('login_redirect',array($this,'login_redirect'),10,3);
		add_action( 'pre_get_posts', array($this,'pre_get_posts_video') );

	}

	public function pre_get_posts_video( $query ) {

		$post_name = $query->get('post_type');
		//echo $post_name = $query->get('video_cat');
		if ( is_tax( 'video_cat' ) ) {
			$post_name = 'video';
		}

        

		$order = 'DESC';
		
		if ( ! is_admin() && $query->is_main_query() ) 
		{
			
			
			if( isset( $this->theme_options['video_order'] ) && !empty( $this->theme_options['video_order'] )) {
				$order = $this->theme_options['video_order'];
				$query->set( 'order', 'ASC');
			}
			
        	
       		
        
 		}
	}


	public function login_redirect( $url, $request, $user )
	{
		 if ( isset( $user->roles ) && is_array( $user->roles ) ) { 

            if ( in_array( 'subscriber', $user->roles ) ) {
            	if(isset($this->theme_options['login_redirect_url']) && !empty($this->theme_options['login_redirect_url'])) {
            		$url = $this->theme_options['login_redirect_url'];	
            	}
            }
         }
         return $url;
	}

	public function pms_register_success_message($message)
	{
		//wp_die($this->theme_options['register_success_message']);
		if( isset($this->theme_options['register_success_message']) && !empty($this->theme_options['register_success_message']))
		{
			$message = esc_html($this->theme_options['register_success_message']);
		}
		return $message;
	}
	public static function  get_attachment_data($attachment_id = '' , $size = '' )
	{
	     $attachment = get_post( $attachment_id );
	        $data =  array(
	            'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
	            
	        );
	       
	       		echo wp_get_attachment_image($attachment_id , $size , $data); 	
	        
	        
	       
	}

	public static function  get_attachment_data_html($attachment_id = '' , $classes= array())
	{
	     $attachment = get_post( $attachment_id );
	     $class = '';
	     if(!empty($classes))
	     {
	       $class = 'class='.implode(" " , $classes);
	     }
	     $alt = (!empty(get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ))) ? get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ) : 'woo-image';
	        $data =  array(
	            'alt' => $alt,
	            'caption' => $attachment->post_excerpt,
	            'description' => $attachment->post_content,
	            'href' => get_permalink( $attachment->ID ),
	            'src' => $attachment->guid,
	            'title' => $attachment->post_title
	        );
	        ?>
	        <img src="<?php echo esc_url($data['src']) ?>" title="<?php echo esc_attr($data['title']) ?>" alt="<?php echo esc_attr($data['alt']); ?>" <?php echo $class; ?> >
	        <?php 
	}
}

new Plugin_Helper;
Plugin_Helper::instance();