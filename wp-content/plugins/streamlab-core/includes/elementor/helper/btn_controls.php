<?php
namespace Elementor; 
use Streamlab_Core\Elementor_widgets\Custom_Post_Data; 
if ( ! defined( 'ABSPATH' ) ) exit; 
class Button_Controls
{
	public function get_btn_controls($obj)
	{
		$custom_post  = new Custom_Post_Data();
		$obj->add_control(
			'button_text',
			[
				'label' => __( 'Button Text', 'streamlab-core' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => __( 'Click Here', 'streamlab-core' ),
				'placeholder' => __( 'Enter your title', 'streamlab-core' ),
				'label_block' => true,
			]
        );
    
        $obj->add_control(
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
	
		
	
        $obj->add_responsive_control(
			'button_text_align',
			[
				'label' => __( 'Alignment', 'streamlab-core' ),
				'type' => Controls_Manager::CHOOSE,
				'default'    => 'left',
				'options' => [
					'left' => [
						'title' => __( 'Left', 'streamlab-core' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'streamlab-core' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'streamlab-core' ),
						'icon' => 'eicon-text-align-right',
					]				
		 		],
		 		'selectors' => [
					'{{WRAPPER}} .gen-btn-container' => 'text-align: {{VALUE}};',
				]
			]
        );
        $obj->add_control(
			'button_padding',
			[
				'label' => __( 'Padding', 'stremlab-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .gen-btn-container .gen-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$obj->end_controls_section();
		
	
		// Button Style Section
		$obj->start_controls_section(
			'section_y8ubBfbAH1e2VwpN5be9',
			[
				'label' => __( 'Button Style', 'streamlab-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
				
			]
		);
		$obj->add_control(
			'btn_style',
			[
				'label' => __( 'Button Style', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'btn-flat',
				'options' => [
					'btn-flat'  => __( 'Flat', 'plugin-domain' ),
					'btn-outline' => __( 'Outline', 'plugin-domain' ),
					'btn-link' => __( 'Link', 'plugin-domain' ),
					
				],
			]
		);
		
        
         
		$obj->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __( 'Typography', 'plugin-domain' ),
				'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .gen-button span.text',
			]
		);
		$obj->start_controls_tabs( 'tabs_button_style' );
		$obj->start_controls_tab(
			'tab_button_normal',
			[
				'label' => __( 'Normal', 'elementor' ),
			]
		);
		$obj->add_control(
			'button_text_color',
			[
				'label' => __( 'Text Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .gen-button span.text , {{WRAPPER}} .gen-button i' => 'color: {{VALUE}};',
				],
			]
		);
		
		$obj->add_control(
			'background_color',
			[
				'label' => __( 'Background Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gen-btn-container .gen-button' => 'background: {{VALUE}};',
				],
			]
		);
	
		
		$obj->end_controls_tab();
		$obj->start_controls_tab(
			'tab_button_hover',
			[
				'label' => __( 'Hover', 'elementor' ),
			]
		);
		$obj->add_control(
			'hover_color',
			[
				'label' => __( 'Text Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gen-button:hover span.text , {{WRAPPER}} .gen-button:hover i' => 'color: {{VALUE}};',
				],
			]
		);
		
		$obj->add_control(
			'button_background_hover_color',
			[
				'label' => __( 'Background Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gen-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);
		
		
		
		$obj->end_controls_tab();
		$obj->end_controls_tabs();
		$obj->end_controls_section();
	}
	public function get_btn_1_controls($obj)
	{
		$custom_post  = new Custom_Post_Data();
		$obj->add_control(
			'button_text_1',
			[
				'label' => __( 'Button Text', 'streamlab-core' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => __( 'Click Here', 'streamlab-core' ),
				'placeholder' => __( 'Enter your title', 'streamlab-core' ),
				'label_block' => true,
			]
        );
    
       
	
		$obj->add_control(
			'selected_icon_1',
			[
				'label' => __( 'Icon', 'hostingo-core' ),
				'type' => Controls_Manager::ICONS,
				'label_block' => true,
				'default' => [
					'value' => 'ion ion-play',
					
				],
                'fa4compatibility' => 'icon',
				'separator' => 'before',
				
			]
		);
	
        $obj->add_responsive_control(
			'button_text_align_1',
			[
				'label' => __( 'Alignment', 'streamlab-core' ),
				'type' => Controls_Manager::CHOOSE,
				'default'    => 'left',
				'options' => [
					'left' => [
						'title' => __( 'Left', 'streamlab-core' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'streamlab-core' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'streamlab-core' ),
						'icon' => 'eicon-text-align-right',
					]				
		 		],
		 		'selectors' => [
					'{{WRAPPER}} .gen-btn-container.button-1' => 'text-align: {{VALUE}};',
				]
			]
        );
		$obj->end_controls_section();
		
	
		// Button Style Section
		$obj->start_controls_section(
			'section_y8ubBfbAH1wpN5',
			[
				'label' => __( 'Button Style 1', 'streamlab-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
				
			]
		);
		$obj->add_control(
			'btn_style_1',
			[
				'label' => __( 'Button Style', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'btn-flat',
				'options' => [
					'btn-flat'  => __( 'Flat', 'plugin-domain' ),
					'btn-outline' => __( 'Outline', 'plugin-domain' ),
					'btn-link' => __( 'Link', 'plugin-domain' ),
					
				],
			]
		);
		
        
         
		$obj->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography_1',
				'label' => __( 'Typography', 'plugin-domain' ),
				'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .gen-btn-container.button-1 .gen-button span.text',
			]
		);
		$obj->start_controls_tabs( 'tabs_button_style_1' );
		$obj->start_controls_tab(
			'tab_button_normal_1',
			[
				'label' => __( 'Normal', 'elementor' ),
			]
		);
		$obj->add_control(
			'button_text_color_1',
			[
				'label' => __( 'Text Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .gen-btn-container.button-1 .gen-button span.text , {{WRAPPER}} .gen-btn-container.button-1 .gen-button i' => 'color: {{VALUE}};',
				],
			]
		);
		
		$obj->add_control(
			'background_color_1',
			[
				'label' => __( 'Background Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gen-btn-container.button-1 .gen-button' => 'background: {{VALUE}};',
				],
			]
		);
	
		
		$obj->end_controls_tab();
		$obj->start_controls_tab(
			'tab_button_hover_1',
			[
				'label' => __( 'Hover', 'elementor' ),
			]
		);
		$obj->add_control(
			'hover_color_1',
			[
				'label' => __( 'Text Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gen-btn-container.button-1 .gen-button:hover span.text , {{WRAPPER}} .gen-button:hover i' => 'color: {{VALUE}};',
				],
			]
		);
		
		$obj->add_control(
			'button_background_hover_color_1',
			[
				'label' => __( 'Background Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gen-btn-container.button-1 .gen-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);
		
		
		
		$obj->end_controls_tab();
		$obj->end_controls_tabs();
		$obj->end_controls_section();
	}
	public function get_btn_2_controls($obj)
	{
		$custom_post  = new Custom_Post_Data();
		$obj->add_control(
			'button_text_2',
			[
				'label' => __( 'Button Text', 'streamlab-core' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => __( 'Click Here', 'streamlab-core' ),
				'placeholder' => __( 'Enter your title', 'streamlab-core' ),
				'label_block' => true,
			]
        );
    
      
	
		$obj->add_control(
			'selected_icon_2',
			[
				'label' => __( 'Icon', 'hostingo-core' ),
				'type' => Controls_Manager::ICONS,
				'label_block' => true,
				'default' => [
					'value' => 'ion ion-play',
					
				],
                'fa4compatibility' => 'icon',
				'separator' => 'before',
				
			]
		);
	
        $obj->add_responsive_control(
			'button_text_align_2',
			[
				'label' => __( 'Alignment', 'streamlab-core' ),
				'type' => Controls_Manager::CHOOSE,
				'default'    => 'left',
				'options' => [
					'left' => [
						'title' => __( 'Left', 'streamlab-core' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'streamlab-core' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'streamlab-core' ),
						'icon' => 'eicon-text-align-right',
					]				
		 		],
		 		'selectors' => [
					'{{WRAPPER}} .gen-btn-container.button-2' => 'text-align: {{VALUE}};',
				]
			]
        );
		$obj->end_controls_section();
		
	
		// Button Style Section
		$obj->start_controls_section(
			'section_y8ubBfbAH2Vwe9',
			[
				'label' => __( 'Button Style 2', 'streamlab-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => ['layout_style' => ['banner-slider']]
				
			]
		);
		$obj->add_control(
			'btn_style_2',
			[
				'label' => __( 'Button Style', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'btn-flat',
				'options' => [
					'btn-flat'  => __( 'Flat', 'plugin-domain' ),
					'btn-outline' => __( 'Outline', 'plugin-domain' ),
					'btn-link' => __( 'Link', 'plugin-domain' ),
					
				],
			]
		);
		
        
         
		$obj->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography_2',
				'label' => __( 'Typography', 'plugin-domain' ),
				'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .gen-btn-container.button-2 .gen-button span.text',
			]
		);
		$obj->start_controls_tabs( 'tabs_button_style_2' );
		$obj->start_controls_tab(
			'tab_button_normal_2',
			[
				'label' => __( 'Normal', 'elementor' ),
			]
		);
		$obj->add_control(
			'button_text_color_2',
			[
				'label' => __( 'Text Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .gen-btn-container.button-2 .gen-button span.text , {{WRAPPER}} .gen-btn-container.button-2 .gen-button i' => 'color: {{VALUE}};',
				],
			]
		);
		
		$obj->add_control(
			'background_color_2',
			[
				'label' => __( 'Background Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gen-btn-container.button-2 .gen-button' => 'background: {{VALUE}};',
				],
			]
		);
	
		
		$obj->end_controls_tab();
		$obj->start_controls_tab(
			'tab_button_hover_2',
			[
				'label' => __( 'Hover', 'elementor' ),
			]
		);
		$obj->add_control(
			'hover_color_2',
			[
				'label' => __( 'Text Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gen-btn-container.button-2 .gen-button:hover span.text , {{WRAPPER}} .gen-button:hover i' => 'color: {{VALUE}};',
				],
			]
		);
		
		$obj->add_control(
			'button_background_hover_color_2',
			[
				'label' => __( 'Background Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gen-btn-container.button-2 .gen-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);
		
		
		
		$obj->end_controls_tab();
		$obj->end_controls_tabs();
		$obj->end_controls_section();
	}
}
		