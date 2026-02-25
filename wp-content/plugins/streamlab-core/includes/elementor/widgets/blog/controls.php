<?php
namespace Elementor; 
use Streamlab_Core\Elementor_widgets\Streamlab_Core_Elementor_Init as SCEW;
use Streamlab_Core\Elementor_widgets\Custom_Post_Data; 

use Elementor\Slider_Controls; 
if ( ! defined( 'ABSPATH' ) ) exit; 
class blogers extends Widget_Base {
	public function get_name() {
		return __( 'blog', 'hostingo-core' );
	}
	
	public function get_title() {
		return __( 'Blog', 'hostingo-core' );
	}

	public function get_categories() {
		return [ SCEW::get_category() ];
    }
	/**
	 * Get widget icon.
	 *
	 * Retrieve counter widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-post';
	}
	protected function register_controls() {
		$this->start_controls_section(
			'section_slider',
			[
				'label' => __( 'Blog', 'hostingo-core' ),
			]
		);
		 
		$this->add_control(
			'blog_style',
			[
				'label'      => __( 'Blog Style', 'hostingo-core' ),
				'type'       => Controls_Manager::SELECT,
				'default'    => '1',
				'options'    => [
					'slider'       => __( 'slider', 'hostingo-core' ),
					'1'          => __( '1 Column', 'hostingo-core' ),
					'2'          => __( '2 Column', 'hostingo-core' ),
					'3'          => __( '3 Column', 'hostingo-core' ),
					
				],
			]
		);
		
		 
		 
        $this->add_responsive_control(
			'text_align',
			[
				'label' => __( 'Alignment', 'hostingo-core' ),
                'type' => Controls_Manager::CHOOSE,
                'separator' => 'after',
                'default' => __( 'left', 'hostingo-core' ),
				'options' => [
					'left' => [
						'title' => __( 'Left', 'hostingo-core' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'hostingo-core' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'hostingo-core' ),
						'icon' => 'eicon-text-align-right',
					]
				]
			]
		);
        
        $this->end_controls_section();
         $this->start_controls_section(
			'section__194d0c0232',
			[
				'label' => __( 'Slider Control', 'seozie-core' ),
				
				
			]
		);
         $slider = new Slider_Controls;
		  $slider->slider_control($this);
        $this->end_controls_section();
        
      
		
	}
	
	protected function render() {
		$settings = $this->get_settings();
		$custom_post  = new Custom_Post_Data();

		$slider = new Slider_Controls;
		$slider->add_render_attribute($this , $settings);

		// Buid Args elementor_key  => taxonomy_name

		//$args = $custom_post->build_args('post' , $settings , array('post_genre' => 'movie_genre' ,  'post_tag' => 'movie_tag' ));
		 global $paged;
     if (empty($paged)) {
     $paged = 1;
     }
     $args = array(
     'post_type'         => 'post',
     'post_status'       => 'publish',    
     'suppress_filters'  => 0,
     'paged' => $paged
     );
    $wp_query = new \WP_Query($args);

     $pagination_args = array(
    //'base'            => get_pagenum_link(1) . '%_%',
    'format'      => '?paged=%#%',
    'total'           => $wp_query->max_num_pages,
    'current'         => $paged,
    'show_all'        => False,
    'end_size'        => 1,
    'mid_size'        => 2,
    'prev_next'       => True,
    'prev_text'       =>  esc_html__( 'Previous page', 'hostingo-core' ),
    'next_text'       => esc_html__( 'Next page', 'hostingo-core' ),
    'type'            => 'list',
    'add_args'        => false,
    'add_fragment'    => ''
    );    
   $paginate_links = paginate_links($pagination_args);

		

       
		if($settings['blog_style'] == 'slider')
		{
			require plugin_dir_path( __FILE__ ) . 'style-1-slider.php';
		}

		if($settings['blog_style'] == '1' || $settings['blog_style'] == '2' || $settings['blog_style'] == '3')
		{
			require plugin_dir_path( __FILE__ ) . 'style-2-grid.php';
		}
        
         if ( Plugin::$instance->editor->is_edit_mode() ) : 
				//require HOSTINGO_PLUGIN_DIR . '/includes/elementor/common/slick-common-js.php'; 
		endif; 
    }	    
		
}
Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\blogers() );