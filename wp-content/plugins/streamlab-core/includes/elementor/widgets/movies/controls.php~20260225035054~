<?php
namespace Elementor; 
use Streamlab_Core\Elementor_widgets\Streamlab_Core_Elementor_Init as SCEW;
use Streamlab_Core\Elementor_widgets\Custom_Post_Data; 
use Elementor\Slider_Controls; 
if ( ! defined( 'ABSPATH' ) ) exit; 
class Movies extends Widget_Base {
	public function get_name() {
		return __( 'Movies', 'streamlab-core' );
	}
	
	public function get_title() {
		return __( 'Movies', 'streamlab-core' );
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
		return '';
	}
	protected function register_controls()
	{
		$custom_post  = new Custom_Post_Data();
		$this->start_controls_section(
			'section',
			[
				'label' => __( 'Movies', 'streamlab-core' ),
			]
		);
		$this->add_control(
			'layout_style',
			[
				'label' => __( 'Style', 'streamlab-core' ),
				'type' => Controls_Manager::SELECT,
				'multiple' => true,
				'default' => 'banner-slider',
				'options' => [
					'carousel-slider'  => __( 'Carousel Slider', 'streamlab-core' ),
					'banner-slider'  => __( 'Banner Slider', 'streamlab-core' ),
					'banner-slider-style-1'  => __( 'Banner Slider Style 1', 'streamlab-core' ),
					
					'banner-slider-style-3'  => __( 'Banner Slider Style 3', 'streamlab-core' ),
					'vertical-nav-slider'  => __( 'Vertical Nav Slider', 'streamlab-core' ),
					'grid'  => __( 'Grid', 'streamlab-core' ),
					
				],
			]
		);
		$custom_post->get_layout_controls($this);

		$this->add_control(
			'post_type',
			[
				'label' => __( 'Post Type', 'plugin-domain' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'movie',
			]
		);
		
		$this->add_control(
			'movie_box_style',
			[
				'label' => __( 'Movie Box Style', 'streamlab-core' ),
				'type' => Controls_Manager::SELECT,
				'multiple' => false,
				'default' => '1',
				'options' => [
					'1'  => __( 'Style 1', 'streamlab-core' ),
					
					'2'  => __( 'Style 2', 'streamlab-core' ),
					'3'  => __( 'Style 3', 'streamlab-core' ),
					'inherit'  => __( 'Inherit', 'streamlab-core' ),
				],
				'condition' => ['layout_style' => ['carousel-slider' , 'grid' ]]				
			]
		);
		$this->add_control(
			'show_front_image',
			[
				'label' => __( 'Show Front Image', 'streamlab-core' ),
				'type' => Controls_Manager::SELECT,
				'multiple' => false,
				'default' => 'yes',
				'options' => [
					'yes'  => __( 'yes', 'streamlab-core' ),
					'no'  => __( 'no', 'streamlab-core' ),
					
					
				],
				'condition' => ['layout_style' => ['banner-slider-style-1']]				
			]
		);
		$this->add_control(
			'post_ids',
			[
				'label' => __( 'Select Movies','streamlab-core' ),
				'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' => $custom_post->get_custom_post('movie' ,  'id'),
				
			]
		);
		$this->add_control(
			'post_genre',
			[
				'label' => __( 'Select Genre','streamlab-core' ),
				'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' => $custom_post->get_taxonony('movie_genre'),
				
			]
		);
		$this->add_control(
			'post_tag',
			[
				'label' => __( 'Select Tag','streamlab-core' ),
				'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' => $custom_post->get_taxonony('movie_tag'),
				
			]
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail', 
				'default' => 'full',
				
				'separator' => 'none',
				'condition' => ['layout_style' => ['carousel-slider' , 'grid']]				
			]
			
		);  
		$this->end_controls_section();

		 $this->start_controls_section(
			'section__194d0c0232',
			[
				'label' => __( 'Slider Control', 'streamlab-core' ),
				'condition' => ['layout_style' => ['carousel-slider','banner-slider' ,  'banner-slider-style-1' , 'banner-slider-style-3']]
				
				
			]
		);
		  $slider = new Slider_Controls;
		  $slider->slider_control($this);
      
       
        $this->end_controls_section();

        $this->start_controls_section(
			'section_Jnza43wt8d9QH5b77duo',
			[
				'label' => __( 'Button 1', 'streamlab-core' ),
				'condition' => ['layout_style' => ['banner-slider' , 'vertical-nav-slider' , 'banner-slider-style-1' , 'banner-slider-style-3']]
			]
		);
		 $btn = new Button_Controls();
		 $btn->get_btn_1_controls($this);
		   
        //$this->end_controls_section();

         




		 //// Button 2 section start
        $this->start_controls_section(
			'section_Jnza43wt8db77duo',
			[
				'label' => __( 'Button 2', 'streamlab-core' ),
				'condition' => ['layout_style' => ['banner-slider']]
			]
		);
			$btn = new Button_Controls();
			$btn->get_btn_2_controls($this);
        //$this->end_controls_section();
	}
	
	protected function render() {
		$settings = $this->get_settings();
		$custom_post  = new Custom_Post_Data();
		$slider = new Slider_Controls;
		$slider->add_render_attribute($this , $settings);
		
		// Buid Args elementor_key  => taxonomy_name
		$args = $custom_post->build_args('movie' , $settings , array('post_genre' => 'movie_genre' ,  'post_tag' => 'movie_tag' ));
		
        $wp_query = new \WP_Query($args);

     
		
		if($settings['layout_style'] == 'banner-slider')
		{
		
		
			require plugin_dir_path( __FILE__ ) . 'banner-slider.php';	
			 
		}
		if($settings['layout_style'] == 'carousel-slider')
		{
			
			require plugin_dir_path( __FILE__ ) . 'slider.php';	
			 
		}
		if($settings['layout_style'] == 'vertical-nav-slider')
		{
			
			require plugin_dir_path( __FILE__ ) . 'nav-slider.php';	
			 
		}
		if($settings['layout_style'] == 'banner-slider-style-1')
		{
			require plugin_dir_path( __FILE__ ) . 'banner-slider-style-1.php';	
		}
		
		if($settings['layout_style'] == 'banner-slider-style-2')
		{
			require plugin_dir_path( __FILE__ ) . 'banner-slider-style-2.php';	
		}
		

		if($settings['layout_style'] == 'banner-slider-style-3')
		{
			require plugin_dir_path( __FILE__ ) . 'banner-slider-style-3.php';	
		}

		if($settings['layout_style'] == 'grid')
		{
			require plugin_dir_path( __FILE__ ) . 'grid.php';	
		}
		
		 if (Plugin::$instance->editor->is_edit_mode())
		 {
       	   $slider->load_owl_js();
       	   $slider->load_slick_js();
      	 }
      
    }	    
		
}
Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Movies() );
