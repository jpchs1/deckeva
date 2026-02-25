<?php
use gentechtree\streamlab\Helper;
use gentechtree\streamlab\Options;
use \Streamlab_Core\Elementor_widgets\Custom_Post_Data; 

class Streamlab_Load_More {
	protected static $instance = null;
	
	private function __construct() {
		add_action('wp_ajax_loadmore_post_page',          array( $this, 'loadmore' ) );
		add_action('wp_ajax_nopriv_loadmore_post_page',   array( $this, 'loadmore' ) );
	}
	public static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	public function init( $obj , $settings , $wp_query  ) {

	 $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
		$nonce =  wp_create_nonce( 'loadmore_nonce' );
		$box_style = $settings[ $settings['post_type'].'_box_style' ];

		if($settings['thumbnail_size'] != 'custom')
		{
			$size = $settings['thumbnail_size'];
			$args = array ( 'size' => $size );
		}
		else
		{
			$custom = $settings['thumbnail_custom_dimension'];
			$args = array('size_dimention' => array('width' => $custom['width'] , 'height' => $custom['height']));
		}

	echo '<div id="page-post-loadmore-'.$obj->get_id().'"  class="page-post-'.$settings['load_type'].'-data" data-query="'.esc_attr( json_encode( $wp_query->query_vars ) ).'" data-box_style="'.esc_attr($box_style).'" data-paged="'.esc_attr( $paged ).'" data-max="'.esc_attr( $wp_query->max_num_pages ).'" data-nonce="'.esc_attr( $nonce ).'" data-post_type="'.$settings['post_type'].'" data-dimentions='.esc_attr(json_encode($args)).' data-layout="'.$settings['layout'].'" data-id="'.$obj->get_id().'">';

		if($settings['load_type'] == 'loadmore')
		{
			$this->print_btn_html( $obj );
			
		}
		if($settings['load_type'] == 'infscroll')
		{
			$this->print_spinner_html( $obj );
			
		}
		if($settings['load_type'] == 'pagination')
		{
			$custom_post  = new Custom_Post_Data();
			$paged = $wp_query->query_vars['paged'];
			$custom_post->pagination( $wp_query,$paged );
			
		}
	echo '</div>';
		
	}
	public function loadmore() {
		check_ajax_referer( 'loadmore_nonce', 'nonce' );
		$args = json_decode( stripslashes( $_POST['query'] ), true );
		$args['paged'] = intval( $_POST['paged'] ) + 1;
		
		$view = !empty($_POST['view']) && 'list' === $_POST['view'] ? 'list' : 'grid';
		
		$filter_terms = $_REQUEST['taxonomy'];
		$post_type = $_REQUEST['post_type'];
		$box_style = $_REQUEST['box_style'];
		$taxo_type = $_REQUEST['taxo_type'];
		$dimentions = array();
		$taxo = $_REQUEST['post_type'].'_'.$_REQUEST['taxo_type'];
		$tax_query = array();
		$layout = '';
   
   		$taxargs = array();
   		$block_args = array();
		
		if(isset($_REQUEST['dimentions']))
		{
			$dimentions = $_REQUEST['dimentions'];
			if(isset($dimentions['size_dimention']))
			{
				$block_args['size_dimention'] = $dimentions['size_dimention'];
			}
			if(isset($dimentions['size']))
			{
				$block_args['size'] = $dimentions['size'];
			}
		}

		if(isset($_REQUEST['layout']))
		{
			$layout = $_REQUEST['layout'];
			
		}

		$block_args['box_style'] = $box_style;

		if( $post_type == 'video' && $taxo_type== 'genre') 
		{
			$taxo = 'video_cat';
		}
		$query = new \WP_Query($args);
		if( $query->have_posts() ) :
			while( $query->have_posts() ): $query->the_post();
				if($post_type == 'post')
				{
					echo '<div class="'.esc_attr( Options::get_main_column_number_class( $post_type) ).'">';
								get_template_part( 'template-parts/post/content', get_post_format() );
					echo '</div>'; 
				}
				else
				{
					
				
					if($layout == '5')
					{
						 $layout =  esc_attr('col-xl-2 col-lg-4 col-md-6');

					}
					if($layout == '4')
					{
						$layout =  esc_attr('col-xl-3 col-lg-4 col-md-6');
					}
					if($layout == '3')
					{
						$layout =  esc_attr('col-xl-4 col-lg-4 col-md-6');
					}
					if($layout == '2')
					{
						$layout =  esc_attr('col-xl-6 col-lg-6 col-md-6');
					}
					if($layout == '1')
					{
						$layout =  esc_attr('col-xl-12 col-lg-12 col-md-12');
					}
					
					 echo '<div class="'.$layout.'">';
                         get_template_part( "template-parts/{$post_type}/{$post_type}", "block" , $block_args );
                     echo '</div>';
				}
				
			endwhile;
		endif;
		wp_die();
	}
	private function print_data_html() {
		global $wp_query;
		$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
		$nonce =  wp_create_nonce( 'loadmore_nonce' );
		$box_style = Options::get_box_style(get_post_type());
		echo '<div class="post-loadmore-data" data-query="'.esc_attr( json_encode( $wp_query->query_vars ) ).'" data-box_style="'.esc_attr($box_style).'" data-paged="'.esc_attr( $paged ).'" data-max="'.esc_attr( $wp_query->max_num_pages ).'" data-nonce="'.esc_attr( $nonce ).'" data-post_type="'.get_post_type().'"></div>';
	}
	private function print_btn_html( $obj ) {
		?>
		<div class="col-lg-12">
			<div id="gen-load-more-button-<?php echo $obj->get_id(); ?>" class="gen-load-more-button">
			<div class="gen-btn-container">
        		<a id="gen-button-<?php echo $obj->get_id() ?>" class="gen-button gen-button-flat" href="#">
                    <span class="button-text-<?php echo $obj->get_id(); ?>"><?php echo esc_html__('Load More' , 'streamlab-core') ?></span>
                    <span id="loadmore-icon-<?php echo $obj->get_id(); ?>" class="loadmore-icon"><i class="fa fa-spinner fa-spin"></i></span>
                    
        		</a>
  			</div>
		</div>
		</div>
		
			
		
		<?php
	}
	private function print_spinner_html($obj) {
		?>
		<div class="col-lg-12">
			<div id="loadmore-icon-<?php echo $obj->get_id(); ?>" class="loadmore-icon"><i class="fa fa-spinner fa-spin"></i></div>
		</div>
		
		<?php
	}
	
}
Streamlab_Load_More::instance();