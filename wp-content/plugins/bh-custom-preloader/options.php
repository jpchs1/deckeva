<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
define('BHPREDIRURI' , WP_PLUGIN_URL .'/' . plugin_basename(dirname(__FILE__)) . '/');

// Control core classes for avoid errors
if( class_exists( 'CSF' ) ) {

  // Set a unique slug-like ID
  $prefix = 'bh_preloader';

  //
  // Create options
  CSF::createOptions( $prefix, array(
    'menu_title' => 'BH Preloader',
    'menu_slug'  => 'bh-preloader',
	'menu_position'  => 3,
  ) );

  // Create a section
  CSF::createSection( $prefix, array(
    'title'  => 'Preloader',
    'fields' => array(

      // add field
      array(
        'id'    => 'bh-preloader-opt',
        'type'  => 'switcher',
        'title' => 'Preloader On/Off',
		'default' => true
      ),
	  
      // add field
      array(
        'id'    => 'bh-preloader-homepage-opt',
        'type'  => 'switcher',
        'title' => 'Active Home Page Only',
		'default' => false,
		'text_on'  => 'Yes',
		'text_off' => 'No',
      ),
	  
      // add field
      array(
		  'id'          => 'bh-preloader-type',
		  'type'        => 'select',
		  'title'       => 'Preloader Style',
		  'options'     => array(
			'pre-1'  => 'Image',
			'pre-2'  => 'CSS3',
		  ),
		  'default'     => 'pre-2'
		),
		
      // add field
      array(
		  'id'        => 'bh-image-preloaders',
		  'type'      => 'image_select',
		  'title'     => 'Image Preloaders',
		  'options'   => array(
			'preloader1' => BHPREDIRURI . 'img/preview/1.png',
			'preloader2' => BHPREDIRURI . 'img/preview/2.png',
			'preloader3' => BHPREDIRURI . 'img/preview/3.png',
			'preloader4' => BHPREDIRURI . 'img/preview/4.png',
			'preloader5' => BHPREDIRURI . 'img/preview/5.png',
			'preloader6' => BHPREDIRURI . 'img/preview/6.png',
			'preloader7' => BHPREDIRURI . 'img/preview/7.png',
			'preloader8' => BHPREDIRURI . 'img/preview/8.png',
			'preloader9' => BHPREDIRURI . 'img/preview/9.png',
			'preloader10' => BHPREDIRURI . 'img/preview/10.png',
			'preloader11' => BHPREDIRURI . 'img/preview/11.png',
			'preloader12' => BHPREDIRURI . 'img/preview/12.png',
			'preloader13' => BHPREDIRURI . 'img/preview/13.png',
			'preloader14' => BHPREDIRURI . 'img/preview/14.png',
			'preloader15' => BHPREDIRURI . 'img/preview/15.png',
			'preloader16' => BHPREDIRURI . 'img/preview/16.png',
			'preloader17' => BHPREDIRURI . 'img/preview/17.png',
			'preloader18' => BHPREDIRURI . 'img/preview/18.png',
			'preloader19' => BHPREDIRURI . 'img/preview/19.png',
			'preloader20' => BHPREDIRURI . 'img/preview/20.png',
			'preloader21' => BHPREDIRURI . 'img/preview/21.png',
			'preloader22' => BHPREDIRURI . 'img/preview/22.png',
			'preloader23' => BHPREDIRURI . 'img/preview/23.png',
			'preloader24' => BHPREDIRURI . 'img/preview/24.png',
			'preloader25' => BHPREDIRURI . 'img/preview/25.png',
			'preloader26' => BHPREDIRURI . 'img/preview/26.png',
			'preloader27' => BHPREDIRURI . 'img/preview/27.png',
			'preloader28' => BHPREDIRURI . 'img/preview/28.png',
			'preloader29' => BHPREDIRURI . 'img/preview/29.gif',
			'preloader30' => BHPREDIRURI . 'img/preview/30.gif',
			'preloader31' => BHPREDIRURI . 'img/preview/31.gif',
			'preloader32' => BHPREDIRURI . 'img/preview/32.gif',
			'preloader33' => BHPREDIRURI . 'img/preview/33.gif',
			'preloader34' => BHPREDIRURI . 'img/preview/34.gif',
			'preloader35' => BHPREDIRURI . 'img/preview/35.gif',
			'preloader36' => BHPREDIRURI . 'img/preview/36.gif',
			'preloader37' => BHPREDIRURI . 'img/preview/37.gif',
			'preloader38' => BHPREDIRURI . 'img/preview/38.gif',
			'preloader39' => BHPREDIRURI . 'img/preview/39.gif',
			'preloader40' => BHPREDIRURI . 'img/preview/40.gif',
		  ),
		  'default'   => 'preloader1'
		),
		
	// add field
      array(
		  'id'          => 'bh-preloader-bg-color',
		  'type'        => 'color',
		  'title'       => 'Preloader Background Color',
		  'default'   => '#fff'
		),		
		
	// add field
      array(
		  'id'          => 'bh-preloader-color',
		  'type'        => 'color',
		  'title'       => 'CSS Preloader Color',
		  'default'   => '#0ecad4'
		),
		
	  // add field
      array(
		  'id'          => 'bh-opacity',
		  'type'        => 'text',
		  'title'       => 'Opacity',
		  'default'   => '1'
		),	  
		
		// add field
      array(
		  'id'          => 'bh-delay-time',
		  'type'        => 'text',
		  'title'       => 'Preloader Delay Time',
		  'default'   => '350'
		),
	  
    )
  ) );
  
  // CSS3 Preloader
  CSF::createSection( $prefix, array(
    'title'  => 'CSS3 Preloader',
    'fields' => array(

	   // add field
      array(
		  'id'          => 'bh-preloader-pro-css3-style',
		  'type'        => 'select',
		  'title'       => 'Preloader CSS3 Style',
		  'options'     => array(
			'ppc-1'  => 'Style 1',
			'ppc-2'  => 'Style 2',
			'ppc-3'  => 'Style 3',
			'ppc-4'  => 'Style 4',
			'ppc-5'  => 'Style 5',
			'ppc-6'  => 'Style 6',
			'ppc-7'  => 'Style 7',
			'ppc-8'  => 'Style 8',
		  ),
		  'default'     => 'ppc-1'
		),	

		// A text field
      array(
        'id'    => '25css3_style',
        'type'       => 'heading',
        'content' => 'Please Upgrade To Pro Version Get 25+ CSS3 Style <a href="https://themesvila.com/item/bh-custom-preloader-pro/ " target="_blank">Click Here</a>
		' 
	  ),		
    )
  ) );
  
  // Image Preloader
  CSF::createSection( $prefix, array(
    'title'  => 'Image Preloader',
    'fields' => array(

      // A text field
      array(
        'id'    => 'img-option',
        'type'       => 'heading',
        'content' => '<img src="'.BHPREDIRURI.'img/preview/bh_img.jpg'.'" > <br><br>
		
			Please Upgrade To Pro Version For These Options <a href="https://themesvila.com/item/bh-custom-preloader-pro/ " target="_blank">Click Here</a>
		' 
	  ),

    )
  ) );  
  
  // Image with CSS3 Preloader
  CSF::createSection( $prefix, array(
    'title'  => 'Image with CSS3 Preloader',
    'fields' => array(

       // A text field
      array(
        'id'    => 'img-css3-option',
        'type'  => 'heading',
         'content' => 'This Option Only for Pro Version <a href="https://themesvila.com/item/bh-custom-preloader-pro/ " target="_blank">Click Here</a>'
	  ),
    )
  ) );




}