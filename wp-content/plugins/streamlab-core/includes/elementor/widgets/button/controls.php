<?php

namespace Elementor; 

use Streamlab_Core\Elementor_widgets\Streamlab_Core_Elementor_Init as SCEW;





if ( ! defined( 'ABSPATH' ) ) exit; 



class Button extends Widget_Base {



	public function get_name() {

		return __( 'Button', 'streamlab-core' );

	}

	

	public function get_title() {

		return __( 'Button', 'streamlab-core' );

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

		return 'eicon-button';

	}



	protected function register_controls() {

		$this->start_controls_section(

			'section_Jnza43wt8d9QH5b77duo',

			[

				'label' => __( 'Button', 'streamlab-core' ),

			]

		);

		$btn = new Button_Controls();

		$btn->get_btn_controls($this);

			//require HOSTINGO_PLUGIN_DIR . '/includes/elementor/common/btn_controls.php';



		//$this->end_controls_section();


		

	}

	

	protected function render() {

		$settings = $this->get_settings();

        require plugin_dir_path( __FILE__ ) . 'style.php';	

    }	    

		

}



Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Button() );