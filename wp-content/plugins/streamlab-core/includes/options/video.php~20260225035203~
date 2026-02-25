<?php
/*
 * Sidebar Options
*/


// sidebar Page Settings
Redux::setSection( $options, array(
    'title' => esc_html__('Videos','stremlab-core'),
    'id'    => 'Videos-section',
    'icon' => ' eicon-video-camera',
        
    'subsection' => false,
         
    'fields'=> array(

        array(
            'id' => 'info_general'.rand(10,1000),
            'type' => 'info',
            'style' => 'custom',
            'color' => sanitize_hex_color($color),
            'title' => __('Videos Page Settings', 'stremlab-core') ,
            
        ) ,

        array(
            'id' => 'section-general'.rand(10,1000),
            'type' => 'section',
            'indent' => true
        ) ,    

        array(
            'id'       => 'video_title',
            'type'     => 'text',
            'title'    => __('Video Page Title', 'streamlab-core'),
            'label' => true,
        ),

         array(
            'id'       => 'no_video_found_message',
            'type'     => 'text',
            'title'    => __('No video Found Message', 'streamlab-core'),
            'label' => true,
            'default'=> __('No video were found matching your selection.', 'streamlab-core'),
        ),

        array(
        'id'       => 'video_box_style',
        'type'     => 'select',
        'title'    => __( 'Video Box Style', 'stremlab-core'), 
        
        'options'  => array(
            '1' => 'Style 1',
            '2' => 'Style 2',
            '3' => 'Style 3',
           
            
        ),
        'default'  => '1',
    ),   

     

      streamlab_core_get_layout_options( 'video' , 'column' , 'video Page Layout' ),

      streamlab_core_get_post_load_type( 'video' , 'Video Load Type'  ),
      array(
            'id' => 'info_general'.rand(10,1000),
            'type' => 'info',
            'style' => 'custom',
            'color' => sanitize_hex_color($color),
            'title' => __('Video Page Sidebar Options', 'stremlab-core') ,
            
        ) ,

        array(
            'id' => 'section-general'.rand(10,1000),
            'type' => 'section',
            'indent' => true
        ) ,      

      streamlab_core_get_layout_options( 'video' , 'sidebar' , '' ),
      streamlab_core_get_post_order( 'video' ),
      array(
            'id' => 'video_dimensions',
            'type' => 'dimensions',
          
            'units_extended' => false, // Allow users to select any type of unit
            'title' => esc_html__('Specify Video Image Dimention', 'stremlab-core') , 
        ) ,  

      array(
            'id' => 'info_general'.rand(10,1000),
            'type' => 'info',
            'style' => 'custom',
            'color' => sanitize_hex_color($color),
            'title' => __('Single Video Page Settings', 'stremlab-core') ,
            
        ),

        array(
            'id' => 'section-general'.rand(10,1000),
            'type' => 'section',
            'indent' => true
        ) ,
        streamlab_core_get_post_excerpt_content( 'video' ),
        streamlab_core_get_post_social_share( 'video' ),        
        array(
            'id'       => 'video_hide_date',
            'type' => 'button_set',
            'title' => esc_html('Hide Date', 'stremlab-core') ,

            'options' => array(
                'show' => esc_html__('Show', 'stremlab-core'),
                'hide' => esc_html__('Hide', 'stremlab-core'),

            ) ,
            'default' => 'show',
        ),
        array(
            'id'       => 'video_hide_category',
            'type' => 'button_set',
            'title' => esc_html('Hide Category', 'stremlab-core') ,

            'options' => array(
                'show' => esc_html__('Show', 'stremlab-core'),
                'hide' => esc_html__('Hide', 'stremlab-core'),

            ) ,
            'default' => 'show',
        ),
         array(
            'id'       => 'video_hide_views',
            'type' => 'button_set',
            'title' => esc_html__('Hide Views', 'stremlab-core') ,

            'options' => array(
                'show' => esc_html__('Show', 'stremlab-core'),
                'hide' => esc_html__('Hide', 'stremlab-core'),

            ) ,
            'default' => 'show',
        ),
        array(
            'id'       => 'video_social_share',
            'type'     => 'text',
            'title'    => __('Social share title', 'streamlab-core'),
            'default' => 'Social Share :',
            'label' => true,
        ),
        array(
        'id'       => 'single_video_load_type',
        'type'     => 'select',
        'title'    => __( 'More Like Video Load', 'stremlab-core'), 
       
        'options'  => array(
           
            'loadmore' => 'loadmore',
            'infscroll' => 'Infinity Scroll'
        ),
        'default'  => 'loadmore',
        ),

        array(
        'id'       => 'single_video_load_title',
        'type'     => 'text',
        'title'    => __( 'Title', 'stremlab-core'), 
       
        
        'default'  => 'More Like This',
        ),

        array(
            'id'       => 'single_video_load_filter',
            'type'     => 'select',
            'title'    => __( 'More Like video Filter', 'stremlab-core'), 
           
            'options'  => array(
               
                'all' => 'All Video',
                
                'related' => 'Related',
               
            ),
            'default'  => 'all',
        ),

         array(
            'id' => 'info_general'.rand(10,1000),
            'type' => 'info',
            'style' => 'custom',
            'color' => sanitize_hex_color($color),
            'title' => __('Playlist Page Settings', 'stremlab-core') ,
            
        ),

        array(
            'id' => 'section-general'.rand(10,1000),
            'type' => 'section',
            'indent' => true
        ) ,
        
        streamlab_core_get_post_load_type( 'video_playlist' , 'PlayList Video Load Type'  ),

    )
));