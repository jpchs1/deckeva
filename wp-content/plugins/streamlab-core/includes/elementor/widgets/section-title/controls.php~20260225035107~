<?php
namespace Elementor; 
use Streamlab_Core\Elementor_widgets\Streamlab_Core_Elementor_Init as SCEW;
if ( ! defined( 'ABSPATH' ) ) exit; 

class Sectiontitle extends Widget_Base {

	public function get_name() {
		return __( 'section_title', 'stremlab-core' );
	}
	
	public function get_title() {
		return __( 'Section Title', 'stremlab-core' );
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
		return 'eicon-site-title';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_image',
			[
				'label' => __( 'Section Title', 'stremlab-core' ),
			]
		);

		

		
		$this->add_control(
			'title_text',
			[
				'label' => __( 'Title & Description', 'stremlab-core' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => __( 'This is Title', 'stremlab-core' ),
				'placeholder' => __( 'Enter your title', 'stremlab-core' ),
				'label_block' => true,
			]
		);

		 $this->add_control(
			'title_tag',
			[
				'label' => __( 'Title Tag', 'plugin-domain' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'h5',
				'options' => [
					'h1'  => 'h1',
					'h2'  => 'h2',
					'h3'  => 'h3',
					'h4'  => 'h4',
					'h5'  => 'h5',
					'h6'  => 'h6',
					'p'  => 'p',
					'span'  => 'span',
					
				],
				
			]
			
		);

         $this->add_control(
			'show_description',
			[
				'label' => __( 'Show Description', 'stremlab-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'stremlab-core' ),
				'label_off' => __( 'Hide', 'stremlab-core' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'description_text',
			[
				'label' => __( 'Content', 'stremlab-core' ),
				'type' => Controls_Manager::WYSIWYG,
				'dynamic' => [
					'active' => true,
				],
				'default' => __( 'Enter Your Subtitle Here.', 'stremlab-core' ),
				'placeholder' => __( 'Enter your description', 'stremlab-core' ),
				'separator' => 'none',
				'rows' => 10,
				'show_label' => false,
				'condition' => [ 'show_description' => 'yes']
			]
		);
		$this->add_responsive_control(
			'text_align',
			[
				'label' => __( 'Alignment', 'stremlab-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'stremlab-core' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'stremlab-core' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'stremlab-core' ),
						'icon' => 'eicon-text-align-right',
					],
					
				],
				'selectors' => [
					'{{WRAPPER}} .gen-section-title-1' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
		 $this->start_controls_section(
			'section_a820g2u',
			[
				'label' => __( 'Title Box', 'stremlab-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

         $this->start_controls_tabs( 'tabs_2a0sGfU' );
         $this->start_controls_tab(
            'tabs_tJ74N2F',
            [
                'label' => __( 'Normal', 'streamlab-core' ),
            ]
        );

         $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'box_background_WA2ebwa',
                'label' => __( 'Background', 'stremlab-core' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .gen-section-title-1',
            ]
        );
         $this->end_controls_tab();

         $this->start_controls_tab(
            'tabs__Ax450ea',
            [
                'label' => __( 'Hover', 'streamlab-core' ),
            ]
        );
         $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'box_background__o5Pa8H8',
                'label' => __( 'Background', 'stremlab-core' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .gen-section-title-1:hover',
            ]
        );
         $this->end_controls_tab();
         $this->end_controls_tabs();

		 $this->end_controls_section();

		 // Title Style
		 $this->start_controls_section(
			'section__2p08cZ1',
			[
				'label' => __( 'Title', 'stremlab-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

         $this->start_controls_tabs( 'tabs__WZbRxd5' );
         $this->start_controls_tab(
            'tabs_eCc902a',
            [
                'label' => __( 'Normal', 'streamlab-core' ),
            ]
        );

 		$this->add_control(
			'title_color__BbYUJF3',
			[
				'label' => __( 'Normal Color', 'stremlab-core' ),
				
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gen-section-title-1 .gen-section-title' => 'color: {{VALUE}};',
		 		],
				
				
			]
		);

		

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography_kpscb63',
				'label' => __( 'Typography', 'stremlab-core' ),				
				'selector' => '{{WRAPPER}} .gen-section-title-1 .gen-section-title',
			]
		);

		// word colour
		$this->add_control(
			'title_color__BbYUaaJF3',
			[
				'label' => __( 'Word Color', 'stremlab-core' ),
				
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gen-section-title-1 .gen-section-title span' => 'color: {{VALUE}};',
		 		],
				
				
			]
		);

         $this->end_controls_tab();

         $this->start_controls_tab(
            'tabs_Ax450ea',
            [
                'label' => __( 'Hover', 'streamlab-core' ),
            ]
        );
		$this->add_control(
			'title_color_s3w1o04',
			[
				'label' => __( 'Hover Color', 'stremlab-core' ),
				
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gen-section-title-1 .gen-section-title:hover' => 'color: {{VALUE}};',
		 		],
				
				
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography_e38xupd',
				'label' => __( 'Typography', 'stremlab-core' ),				
				'selector' => '{{WRAPPER}} .gen-section-title-1 .gen-section-title:hover',
			]
		);
         $this->end_controls_tab();
         $this->end_controls_tabs();
         $this->end_controls_section();
         // Title Style End

		 // Description Style Start
		  $this->start_controls_section(
			'section__74ile76',
			[
				'label' => __( 'Description', 'stremlab-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

         $this->start_controls_tabs( 'tabs__74ile76' );
         $this->start_controls_tab(
            'tab_74ile76',
            [
                'label' => __( 'Normal', 'streamlab-core' ),
            ]
        );

 		$this->add_control(
			'color__74ile76',
			[
				'label' => __( 'Normal Color', 'stremlab-core' ),
				
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gen-section-title-1 .gen-section-description' => 'color: {{VALUE}};',
		 		],
				
				
			]
		);

		

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography__74ile76',
				'label' => __( 'Typography', 'stremlab-core' ),				
				'selector' => '{{WRAPPER}} .gen-section-title-1 .gen-section-description',
			]
		);
         $this->end_controls_tab();

         $this->start_controls_tab(
            'tab_dwL4Svd',
            [
                'label' => __( 'Hover', 'streamlab-core' ),
            ]
        );
		$this->add_control(
			'color__dwL4Svd',
			[
				'label' => __( 'Hover Color', 'stremlab-core' ),
				
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gen-section-title-1 .gen-section-description:hover' => 'color: {{VALUE}};',
		 		],
				
				
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography__dwL4Svd',
				'label' => __( 'Typography', 'stremlab-core' ),				
				'selector' => '{{WRAPPER}} .gen-section-title-1 .gen-section-description:hover',
			]
		);
         $this->end_controls_tab();
         $this->end_controls_tabs();        
		 $this->end_controls_section();
		 // Description Style End


	}
	
	protected function render() {
		$settings = $this->get_settings();
        require plugin_dir_path( __FILE__ ) . 'style-1.php';	
         if ( Plugin::$instance->editor->is_edit_mode() ) : ?>
         	
        <?php  endif; 
    }	    
		
}

Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Sectiontitle() );