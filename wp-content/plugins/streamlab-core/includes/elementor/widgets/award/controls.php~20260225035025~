<?php
namespace Elementor; 
use Streamlab_Core\Elementor_widgets\Streamlab_Core_Elementor_Init as SCEW;

if ( ! defined( 'ABSPATH' ) ) exit; 

class award_slider extends Widget_Base {

	public function get_name() {
		return __( 'award_slider', 'streamlab-core' );
	}
	
	public function get_title() {
		return __( 'Award slider', 'streamlab-core' );
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
		$this->start_controls_section(
			'section',
			[
				'label' => __( 'award_slider', 'streamlab-core' ),
			]
		);
		$this->add_control(
			'layout_style',
			[
				'label' => __( 'ShoW Style', 'streamlab-core' ),
				'type' => Controls_Manager::SELECT,
				'multiple' => true,
				'default' => 'slider',
				'options' => [
					'slider'  => __( 'Slider', 'streamlab-core' ),
					'grid' => __( 'Grid', 'streamlab-core' ),
					
				],
			]
		);

		$this->add_control(
			'grid_style',
			[
				'label' => __( 'Show Elements', 'streamlab-core' ),
				'type' => Controls_Manager::SELECT,
				'multiple' => true,
				'default' => 'two',
				'options' => [
					'12'  => __( 'One Column', 'streamlab-core' ),
					'6'  => __( 'Two Column', 'streamlab-core' ),
					'4'  => __( 'Three Column', 'streamlab-core' ),
					'3'  => __( 'Four Column', 'streamlab-core' ),
				],
				'condition' => ['layout_style' => 'grid']
			]
		);
		$repeater = new Repeater();


		$repeater->add_control(
			'img_title', [
				'label' => __( 'Title', 'streamlab-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'image Title' , 'streamlab-core' ),
				'label_block' => true,
			]
		);
		 
		
		$repeater->add_control(
					'tab_image',
					[
						'label' => __( 'Choose Image 1', 'streamlab-core' ),
						'type' => Controls_Manager::MEDIA,
						'dynamic' => [
		                    'active' => true,
		                    
		                ],                        

		                
						'default' => [
							'url' => Utils::get_placeholder_image_src(),
						],
					]
				);
		$repeater->add_control(
			'title_text',
			[
				'label' => __( 'Title', 'streamlab-core' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Award title', 'streamlab-core' ),
				'label_block' => true,
			]
        );
       
		// $repeater->add_control(
		// 			'tab_image_1',
		// 			[
		// 				'label' => __( 'Choose Image 2', 'streamlab-core' ),
		// 				'type' => Controls_Manager::MEDIA,
		// 				'dynamic' => [
		//                     'active' => true,
		                    
		//                 ],                           

		                
		// 				'default' => [
		// 					'url' => Utils::get_placeholder_image_src(),
		// 				],
		// 			]
		// 		);
		$repeater->add_control(
			'btn_link',
			[
				'label' => __( 'Link', 'industrie-core' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __( 'https://your-link.com', 'industrie-core' ),
				'separator' => 'before',
			]
		);
		$this->add_control(
			'tabs',
			[
				'label' => __( 'Repeater List', 'streamlab-core' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'img_title' => __( 'Title #1', 'streamlab-core' ),
						'tab_image' => __('get_placeholder_image_src()','streamlab-core')
						// 'tab_image1' => __('get_placeholder_image_src()','streamlab-core')
					],
					
				],
				'title_field' => '{{{ img_title }}}',
			]
		);

		

		$this->add_control(
			'custom_dimension',
			[
				'label' => __( 'Image Dimension', 'plugin-domain' ),
				'type' => Controls_Manager::IMAGE_DIMENSIONS,
				'description' => __( 'Crop the original image size to any custom size. Set custom width or height to keep the original size ratio.', 'plugin-name' ),
				'default' => [
					'width' => '',
					'height' => '',
				],
			]
		);


		$this->end_controls_section();
		  $this->start_controls_section(
			'section__194d0c0232',
			[
				'label' => __( 'Slider Control', 'streamlab-core' ),
				
				
			]
		);

        // require HOSTINGO_PLUGIN_DIR . '/includes/elementor/common/swiper-control.php';

        $this->end_controls_section();

	}
	
	protected function render() {
		$settings = $this->get_settings();

		// render
		if($settings['layout_style'] == 'slider')
		{
			require plugin_dir_path( __FILE__ ) . 'award/slider-style.php';	
		}
       
    }	    
		
}

Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\award_slider() );
