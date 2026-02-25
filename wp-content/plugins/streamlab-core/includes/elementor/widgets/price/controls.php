<?php
namespace Elementor; 
use Streamlab_Core\Elementor_widgets\Streamlab_Core_Elementor_Init as SCEW;


if ( ! defined( 'ABSPATH' ) ) exit; 
class Streamlab_Core_Price extends Widget_Base {
	public function get_name() {
		return __( 'Streamlab_Core_Price', 'streamlab-core' );
	}
	
	public function get_title() {
		return __( 'Pricing Plan', 'streamlab-core' );
	}
	public function get_categories() {
		return [ SCEW::get_category() ];
    }
	/**
	 * Get widget icon.
	 *
	 * Retrieve heading widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-price-table';
	}
	protected function register_controls() {
		$this->start_controls_section(
			'section_imge',
			[
				'label' => __( 'Pricing Plan', 'streamlab-core' ),
			]
		);

		$this->add_control(
			'price_style',
			[
				'label' => __( 'Price Style', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'2'  => __( 'Style 1', 'plugin-domain' ),
					
					
					
				],
			]
		);
		$this->add_control(
			'title',
			[
				'label' => __( 'Title', 'streamlab-core' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				
				'label_block' => true,
				'default' => __( 'Your Sub Title Here', 'streamlab-core' ),
			]
		);
		$this->add_control(
			'dis_price',
			[
				'label' => __( 'discount Price', 'streamlab-core' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
				'default' => __( 'Your discount Here', 'streamlab-core' ),
				
			]
		);
		$this->add_control(
			'price',
			[
				'label' => __( 'Price', 'streamlab-core' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
				'default' => __( 'Your Title Here', 'streamlab-core' ),
				
			]
		);

		$this->add_control(
			'description',
			[
				'label' => __( 'Description', 'streamlab-core' ),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your title', 'streamlab-core' ),
				'default' => __( 'Add Your Description Text Here', 'streamlab-core' ),
			]
		);
	
		$this->add_control(
			'image_style',
			[
				'label'      => __( 'Choose Image/Icon', 'streamlab-core' ),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'none',
				'options'    => [
					'none'       => __( 'None', 'streamlab-core' ),
					'image'          => __( 'Image', 'streamlab-core' ),
					// 'icon'          => __( 'Icon', 'streamlab-core' ),
					
				],
			]
		);
		
		$this->add_control(
			'image',
			[
				'label' => _x( 'Background Image', 'Background Control', 'elementor-pro' ),
				'type' => Controls_Manager::MEDIA,
				
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'image_style' => 'image',
				]
			]
		);
		
		// $this->add_control(
		// 	'selected_icon',
		// 	[
		// 		'label' => __( 'Icon', 'streamlab-core' ),
		// 		'type' => Controls_Manager::ICONS,
		// 		'label_block' => true,
				
		// 		'fa4compatibility' => 'icon',
		// 		'separator' => 'before',
		// 		'condition' => [
		// 			'image_style' => 'icon',
		// 		]
				
		// 	]
		// );
		
		
		$this->add_control(
			'active',
			[
				'label' => __( 'Is Active?', 'elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'label_off',
				'yes' => __( 'yes', 'streamlab-core' ),
				'no' => __( 'no', 'streamlab-core' ),
			]
		);
		$this->add_control(
			'label_active',
			[
				'label' => __( 'label Active?', 'elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'yes' => __( 'yes', 'streamlab-core' ),
				'no' => __( 'no', 'streamlab-core' ),
				'return_value' => 'yes',

				'condition' => [
					'price_style' => '4',
				]
			]
		);
		$this->add_control(
			'label',
			[
				'label' => __( 'label', 'streamlab-core' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
				'condition' => [
					'label_active' => 'yes',
				]
				
			]
		);
		
		
		$repeater = new Repeater();
		$repeater->add_control(
			'tab_title',
			[
				'label' => __( 'Plan info List', 'streamlab-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'List Item', 'streamlab-core' ),
				'placeholder' => __( 'List Item', 'streamlab-core' ),
				'label_block' => true,
			]
		);
		
		$repeater->add_control(
			'enable_disable',
			[
				'label' => __( 'Enable ?', 'streamlab-core' ),
				'type' => Controls_Manager::SWITCHER ,
				'label_on' => __( 'Show', 'streamlab-core' ),
				'label_off' => __( 'Hide', 'streamlab-core' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		$repeater->add_control(
			'enable_icon',
			[
				'label' => __( 'Enable icon', 'streamlab-core' ),
				'type' => Controls_Manager::SWITCHER ,
				'label_on' => __( 'Show', 'streamlab-core' ),
				'label_off' => __( 'Hide', 'streamlab-core' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		$repeater->add_control(
			'selected_icons',
			[
				'label' => __( 'Icon', 'streamlab-core' ),
				'type' => Controls_Manager::ICONS,
				'label_block' => true,
				'default' => [
					'value' => 'far fa-check-circle',
					'library' => 'fa-solid',
				],
				'fa4compatibility' => 'icon',
				'separator' => 'before',
				'condition' => [
					'enable_icon' => 'yes',
				]
				
			]
		);
		
		$this->add_control(
			'tabs',
			[
				'label' => __( 'List Items', 'streamlab-core' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'tab_title' => __( 'Number Of Screen', 'streamlab-core' ),
						'enable_disable' => 'yes',
						
					],
					[
						'tab_title' => __( 'On how many device you can Download', 'streamlab-core' ),
						'enable_disable' => 'yes',
						
					],
					[
						'tab_title' => __( 'Unlimited TV shows and movies', 'streamlab-core' ),
						'enable_disable' => 'yes',
						
					],
					[
						'tab_title' => __( 'watch on mobile and tablet', 'streamlab-core' ),
						'enable_disable' => 'no',
						
					],
					[
						'tab_title' => __( 'watch on laptop and tv', 'streamlab-core' ),
						'enable_disable' => 'no',
						
					],

					[
						'tab_title' => __( 'HD available', 'streamlab-core' ),
						'enable_disable' => 'no',
						
					],
					[
						'tab_title' => __( 'ultra HD available', 'streamlab-core' ),
						'enable_disable' => 'no',
						
					],
					
				],
				'title_field' => '{{{ tab_title }}}',
			]
		);
		
		
		$this->add_responsive_control(
			'align',
			[
				'label' => __( 'Alignment', 'streamlab-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'text-left' => [
						'title' => __( 'Left', 'streamlab-core' ),
						'icon' => 'eicon-text-align-left',
					],
					'text-center' => [
						'title' => __( 'Center', 'streamlab-core' ),
						'icon' => 'eicon-text-align-center',
					],
					'text-right' => [
						'title' => __( 'Right', 'streamlab-core' ),
						'icon' => 'eicon-text-align-right',
					],
					'text-justify' => [
						'title' => __( 'Justified', 'streamlab-core' ),
						'icon' => 'eicon-text-align-justify',
					],
				]
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'section_Jdfnwt8d9QH5b77duo',
			[
				'label' => __( 'Button', 'streamlab-core' ),
			]
		);
			$btn = new Button_Controls();
			$btn->get_btn_controls($this);

	}
	
	protected function render() {
		$settings = $this->get_settings();
		
		if ($settings['price_style'] === "2")
		{
			require plugin_dir_path( __FILE__ ) . 'style-1.php';
		}
		
		
	}	    
	
}
Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Streamlab_Core_Price() );