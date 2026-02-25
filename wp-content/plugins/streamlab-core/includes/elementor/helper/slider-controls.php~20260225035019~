<?php 
namespace Elementor; 
Class Slider_Controls
{
	public  function slider_control($obj)
	{
		$obj->add_control(
			'desk_num',
			[
				'label' => __( 'Desktop number', 'streamlab-core' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => __( '3', 'streamlab-core' ),				
				'separator' => 'before',

			]
		);
		$obj->add_control(
			'lap_num',
			[
				'label' => __( 'Laptop number', 'streamlab-core' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => __( '3', 'streamlab-core' ),				
				'separator' => 'before',

			]
		);
		$obj->add_control(
			'tab_num',
			[
				'label' => __( 'Tablet number', 'streamlab-core' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => __( '2', 'streamlab-core' ),				
				'separator' => 'before',

			]
		);
		$obj->add_control(
			'mob_num',
			[
				'label' => __( 'Mobile number', 'streamlab-core' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => __( '1', 'streamlab-core' ),				
				'separator' => 'before',

			]
		);
		$obj->add_control(
			'autoplay',
			[
				'label'      => __( 'Autoplay', 'streamlab-core' ),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'false',
				'options'    => [
					'true'       => __( 'True', 'streamlab-core' ),
					'false'          => __( 'False', 'streamlab-core' ),				

				],

			]
		);
		$obj->add_control(
			'loop',
			[
				'label'      => __( 'Loop', 'streamlab-core' ),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'false',
				'options'    => [
					'true'       => __( 'True', 'streamlab-core' ),
					'false'          => __( 'False', 'streamlab-core' ),				

				],

			]
		);
		$obj->add_control(
			'nav_arrow',
			[
				'label'      => __( 'Navigation Arrow', 'streamlab-core' ),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'true',
				'options'    => [
					'true'       => __( 'True', 'streamlab-core' ),
					'false'          => __( 'False', 'streamlab-core' ),				

				],

			]
		);
		$obj->add_control(
			'dots',
			[
				'label'      => __( 'Dots', 'streamlab-core' ),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'true',
				'options'    => [
					'true'       => __( 'True', 'streamlab-core' ),
					'false'          => __( 'False', 'streamlab-core' ),				

				],

			]
		);
		$obj->add_responsive_control(
			'margin',
			[
				'label' => __( 'Space', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],


			]
		);

		
	}

	public function add_render_attribute($obj , $settings = array())
	{
		$obj->add_render_attribute('slider', 'data-dots', $settings['dots']);
	  $obj->add_render_attribute('slider', 'data-nav', $settings['nav_arrow']);
	  $obj->add_render_attribute('slider', 'data-desk_num', $settings['desk_num']);
	  $obj->add_render_attribute('slider', 'data-lap_num', $settings['lap_num']);
	  $obj->add_render_attribute('slider', 'data-tab_num', $settings['tab_num']);
	  $obj->add_render_attribute('slider', 'data-mob_num', $settings['mob_num']);
	  $obj->add_render_attribute('slider', 'data-mob_sm', $settings['mob_num']);
	  $obj->add_render_attribute('slider', 'data-autoplay', $settings['autoplay']);
	  $obj->add_render_attribute('slider', 'data-loop', $settings['loop']);
	  $obj->add_render_attribute('slider', 'data-margin', $settings['margin']['size']);
	}

	public function load_owl_js()
	{
		?>
		<script type="text/javascript">
			jQuery('.owl-carousel').each(function() {
                var app_slider = jQuery(this);
                var rtl = false;
                var prev = 'ion-ios-arrow-back';
                var next = 'ion-ios-arrow-forward';
                var prev_text = 'Prev';
                var next_text = 'Next';
                if (jQuery('body').hasClass('gen-is-rtl')) {
                    rtl = true;
                    prev = 'ion-ios-arrow-forward';
                    next = 'ion-ios-arrow-back';
                }
                if (app_slider.data('prev_text') && app_slider.data('prev_text') != '') {
                    prev_text = app_slider.data('prev_text');
                }
                if (app_slider.data('next_text') && app_slider.data('next_text') != '') {
                    next_text = app_slider.data('next_text');
                }
                app_slider.owlCarousel({
                    rtl: rtl,
                    items: app_slider.data("desk_num"),
                    loop: app_slider.data("loop"),
                    margin: app_slider.data("margin"),
                    nav: app_slider.data("nav"),
                    dots: app_slider.data("dots"),
                    loop: app_slider.data("loop"),
                    autoplay: app_slider.data("autoplay"),
                    autoplayTimeout: app_slider.data("autoplay-timeout"),
                    navText: ["<i class='" + prev + "'></i>", "<i class='" + next + "'></i>"],
                    responsiveClass: true,
                    responsive: {
                        // breakpoint from 0 up
                        0: {
                            items: app_slider.data("mob_sm"),
                            nav: false,
                            dots: true
                        },
                        // breakpoint from 480 up
                        480: {
                            items: app_slider.data("mob_num"),
                            nav: false,
                            dots: true
                        },
                        // breakpoint from 786 up
                        786: {
                            items: app_slider.data("tab_num")
                        },
                        // breakpoint from 1023 up
                        1023: {
                            items: app_slider.data("lap_num")
                        },
                        1199: {
                            items: app_slider.data("desk_num")
                        }
                    }
                });
            });
            jQuery('.gen-movie-contain .movie-actions--link_add-to-playlist .dropdown-toggle').html('<i class="fa fa-plus"></i>');
            jQuery('.gen-movie-contain .tv-show-actions--link_add-to-playlist .dropdown-toggle').html('<i class="fa fa-plus"></i>');
            jQuery('.gen-movie-contain .video-actions--link_add-to-playlist .dropdown-toggle').html('<i class="fa fa-plus"></i>');


          jQuery('.movie-actions--link_add-to-playlist.dropdown ,.tv-show-actions--link_add-to-playlist.dropdown , .video-actions--link_add-to-playlist.dropdown').on('mouseover',function(e){
        jQuery('.dropdown-menu').removeClass('show');
        e.preventDefault();
       
        jQuery(this).find('.dropdown-menu').toggleClass('show');
         e.stopPropagation();
      });
      jQuery('body').on('click' , function(){
        jQuery('.dropdown-menu').removeClass('show');
      });

      jQuery('.movie-actions--link_add-to-playlist.dropdown').on('mouseout',function(e){
        jQuery('.dropdown-menu').removeClass('show');
        e.preventDefault();
       
      });
       jQuery('.dropdown-menu').addClass('mCustomScrollbar');

     asyncloader.require(['jquery.mCustomScrollbar'], function () {

        
        jQuery('.dropdown-menu').mCustomScrollbar({
              scrollInertia: 0,
              mouseWheel: {preventDefault: true}
        });
        
      });
		</script>
		<?php 
	}

	public function load_slick_js()
	{
		?>
		<script type="text/javascript">
			jQuery('.slider-for').each(function() {
                 jQuery('.slider-for').slick({
                       slidesToShow: 1,
                       slidesToScroll: 1,
                       arrows: false,
                       fade: true,
                       asNavFor: '.slider-nav'
                     });
                });
           
             jQuery('.slider-nav').each(function() {
                 var prev = 'ion-chevron-up';
                var next = 'ion-chevron-down';
                jQuery('.slider-nav').slick({
                   slidesToShow: 3,
                   slidesToScroll: 1,
                   asNavFor: '.slider-for',
                   dots: true,
                   vertical: true,
                   focusOnSelect: true,
                    centerMode: true,
                   prevArrow: '<div class="prev"><span class="'+prev+'"></span></div>',

                   nextArrow: '<div class="next"><span class="'+next+'"></span></div>',
                   responsive: [
                        {
                          breakpoint: 1024,
                          settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2,
                            adaptiveHeight: true,
                          },
                        },
                        {
                          breakpoint: 600,
                          settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                          },
                        },
                    ],
             });
             });

            
		</script>
		<?php 
	}
}



