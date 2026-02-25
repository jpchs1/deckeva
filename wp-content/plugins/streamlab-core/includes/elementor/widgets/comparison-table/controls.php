<?php
namespace Elementor; 
use Streamlab_Core\Elementor_widgets\Streamlab_Core_Elementor_Init as SCEW;
if ( ! defined( 'ABSPATH' ) ) exit; 
class Comparison_table extends Widget_Base {
	public function get_name() {
		return __( 'Comparison_table', 'streamlab-core' );
	}
	
	public function get_title() {
		return __( 'Comparison_table', 'streamlab-core' );
	}
	public function get_categories() {
		return [ SCEW::get_category() ];
    }
 //    public function get_script_depends() {
	// 	return [ 'jquery-slick' ];
	// }
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
			'section_table_header',
			[
				'label' => __( 'Table Header', 'streamlab-core' ),
			]
		);
		
		$repeater = new Repeater();
		$repeater->add_control(
			'header_text', [
				'label' => __( 'Title', 'streamlab-core' ),
				'type' => Controls_Manager::TEXT,
				
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'header_subtitle', [
				'label' => __( 'Sub Title', 'streamlab-core' ),
				'type' => Controls_Manager::TEXT,
				
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'header_tag', [
				'label' => __( 'Tag', 'streamlab-core' ),
				'type' => Controls_Manager::TEXT,
				
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'image_style',
			[
				'label'      => __( 'Choose Image/Icon', 'streamlab-core' ),
				'type'       => Controls_Manager::SELECT,
				'default'    => '2',
				'options'    => [
					'none'       => __( 'None', 'streamlab-core' ),
					'1'          => __( 'Image', 'streamlab-core' ),
					'2'          => __( 'Icon', 'streamlab-core' ),
					
				],
			]
		);
		$repeater->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'streamlab-core'),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				
				'condition' => [
					'image_style' => '1',
				],
			]
		);
	
		$repeater->add_control(
			'header_icon',
			[
				'label' => __( 'Icon', 'streamlab-core' ),
				'type' => Controls_Manager::ICONS,
				'label_block' => true,
				
                'fa4compatibility' => 'icon',
				'separator' => 'before',
				'condition' => [
					'image_style' => '2',
				]
				
			]
		);

		$repeater->add_control(
			'header_back_color',
			[
				'label' => __( 'Background Color', 'plugin-domain' ),
				'type' => Controls_Manager::COLOR,
				// 'scheme' => [
				// 	'type' => Scheme_Color::get_type(),
				// 	'value' => Scheme_Color::COLOR_1,
				// ],
				
				
			]
		);

		$repeater->add_control(
			'header_text_color',
			[
				'label' => __( 'Text Color', 'plugin-domain' ),
				'type' => Controls_Manager::COLOR,
				// 'scheme' => [
				// 	'type' => Scheme_Color::get_type(),
				// 	'value' => Scheme_Color::COLOR_1,
				// ],
				
				
			]
		);
	
		$this->add_control(
			'table_header',
			[
				'label' => __( 'Table Header', 'streamlab-core' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'header_text' => __( 'Title #1', 'streamlab-core' ),
						
						// 'tab_image1' => __('get_placeholder_image_src()','streamlab-core')
					],
					
				],
				'title_field' => '{{{ header_text }}}',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'section_table_body',
			[
				'label' => __( 'Table Body', 'streamlab-core' ),
			]
		);
		$rep = new Repeater();
		$rep->add_control(
			'next_row', 
			[
				'label' => __( 'New Row', '' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'No', '' ),
				'label_on' => __( 'Yes', '' ),
			]
		);
		$rep->add_control(
			'body_text', [
				'label' => __( 'Title', 'streamlab-core' ),
				'type' => Controls_Manager::TEXT,
				
				'label_block' => true,
			]
		);
		$rep->add_control(
			'body_subtitle', [
				'label' => __( 'Sub Title', 'streamlab-core' ),
				'type' => Controls_Manager::TEXT,
				
				'label_block' => true,
			]
		);
		$rep->add_control(
			'body_icon',
			[
				'label' => __( 'Icon', 'streamlab-core' ),
				'type' => Controls_Manager::ICONS,
				'label_block' => true,
				
                'fa4compatibility' => 'icon',
				'separator' => 'before',
				
			]
		);
		$rep->add_control(
			'icon_color',
			[
				'label' => __( 'Icon Color', 'plugin-domain' ),
				'type' => Controls_Manager::COLOR,
				// 'scheme' => [
				// 	'type' => Scheme_Color::get_type(),
				// 	'value' => Scheme_Color::COLOR_1,
				// ],
				
				
			]
		);

		$rep->add_control(
			'body_back_color',
			[
				'label' => __( 'Background Color', 'plugin-domain' ),
				'type' => Controls_Manager::COLOR,
				// 'scheme' => [
				// 	'type' => Scheme_Color::get_type(),
				// 	'value' => Scheme_Color::COLOR_1,
				// ],
				
				
			]
		);
		$rep->add_control(
			'body_text_color',
			[
				'label' => __( 'Text Color', 'plugin-domain' ),
				'type' => Controls_Manager::COLOR,
				// 'scheme' => [
				// 	'type' => Scheme_Color::get_type(),
				// 	'value' => Scheme_Color::COLOR_1,
				// ],
				
				
			]
		);
		$rep->add_control(
			'rep_btn_text', [
				'label' => __( 'Button Text', 'streamlab-core' ),
				'type' => Controls_Manager::TEXT,
				
				'label_block' => true,
			]
		);
		
		$rep->add_control(
			'btn_link',
			[
				'label' => __( 'Link', 'streamlab-core' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __( 'https://your-link.com', 'streamlab-core' ),
				'separator' => 'before',
			]
		);	
	
		$this->add_control(
			'table_body',
			[
				'label' => __( 'Table Body', 'streamlab-core' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $rep->get_controls(),
				'default' => [
					[
						'body_text' => __( 'Title #1', 'streamlab-core' ),
						
						// 'tab_image1' => __('get_placeholder_image_src()','streamlab-core')
					],
					
				],
				'title_field' => '{{{ body_text }}}',
			]
		);
		$this->end_controls_section();
		// Button Style Section
			$this->start_controls_section(
			'section_JdfnH5b77duo',
			[
				'label' => __( 'Button', 'streamlab-core' ),
			]
		);
			$btn = new Button_Controls();
			$btn->get_btn_1_controls($this);
        //$this->end_controls_section();

			$this->start_controls_section(
			'section_dsdsstyle',
			[
				'label' => __( 'colour', 'streamlab-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
			
		   $this->end_controls_section();
		 
	}
	
	protected function render() {
		$settings = $this->get_settings();
        require plugin_dir_path( __FILE__ ) . 'style-1.php';	
    	    
		
}
}
Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Comparison_table() );
