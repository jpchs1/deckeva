<?php
/*
 * Sidebar Options
*/


// sidebar Page Settings
Redux::setSection( $options, array(
    'title' => esc_html__('Tv Shows','stremlab-core'),
    'id'    => 'tv-show-section',
    'icon' => ' eicon-video-camera',
        
    'subsection' => false,
         
    'fields'=> array(

        array(
            'id' => 'info_general'.rand(10,1000),
            'type' => 'info',
            'style' => 'custom',
            'color' => sanitize_hex_color($color),
            'title' => __('Tv Shows Page Settings', 'stremlab-core') ,
            
        ) ,

        array(
            'id' => 'section-general'.rand(10,1000),
            'type' => 'section',
            'indent' => true
        ) ,   

        array(
            'id'       => 'tv_show_title',
            'type'     => 'text',
            'title'    => __('Tv Show Page Title', 'streamlab-core'),
            'label' => true,
        ),

        array(
            'id'       => 'no_tv_show_found_message',
            'type'     => 'text',
            'title'    => __('No Tv shows Found Message', 'streamlab-core'),
            'label' => true,
            'default'=> __('No tv shows were found matching your selection.', 'streamlab-core'),
        ),

         array(
        'id'       => 'tv_show_box_style',
        'type'     => 'select',
        'title'    => __( 'Tv Show Box Style', 'stremlab-core'), 
        
        'options'  => array(
            '1' => 'Style 1',
            '2' => 'Style 2',
            '3' => 'Style 3',
           
            
        ),
        'default'  => '1',
    ),    

     

      streamlab_core_get_layout_options( 'tv_show' , 'column' , 'tv-show Page Layout' ),

      streamlab_core_get_post_load_type( 'tv_show' , 'Tv Shows Load Type'  ),

      array(
            'id' => 'info_general'.rand(10,1000),
            'type' => 'info',
            'style' => 'custom',
            'color' => sanitize_hex_color($color),
            'title' => __('Tv Show Page Sidebar Options', 'stremlab-core') ,
            
        ) ,

        array(
            'id' => 'section-general'.rand(10,1000),
            'type' => 'section',
            'indent' => true
        ) ,      

      streamlab_core_get_layout_options( 'tv_show' , 'sidebar' , '' ),

       array(
            'id' => 'tv_show_dimensions',
            'type' => 'dimensions',
          
            'units_extended' => false, // Allow users to select any type of unit
            'title' => esc_html__('Specify Tv Show Image Dimention', 'stremlab-core') ,  
        ) ,     

       array(
            'id' => 'episode_dimensions',
            'type' => 'dimensions',
          
            'units_extended' => false, // Allow users to select any type of unit
            'title' => esc_html__('Specify Episode Image Dimention', 'stremlab-core') ,    
        ) ,  

        array(
            'id' => 'info_general'.rand(10,1000),
            'type' => 'info',
            'style' => 'custom',
            'color' => sanitize_hex_color($color),
            'title' => __('Single Tv Shows Page Settings', 'stremlab-core') ,
            
        ) ,

        array(
            'id' => 'section-general'.rand(10,1000),
            'type' => 'section',
            'indent' => true
        ) ,    
        streamlab_core_get_post_excerpt_content( 'tv_show' ),
        streamlab_core_get_post_social_share( 'tv_show' ),
        array(
            'id'       => 'tv_show_hide_season',
            'type' => 'button_set',
            'title' => esc_html('Hide Number Of Season', 'stremlab-core') ,

            'options' => array(
                'show' => esc_html__('Show', 'stremlab-core'),
                'hide' => esc_html__('Hide', 'stremlab-core'),

            ) ,
            'default' => 'show',
        ),
        array(
            'id'       => 'tv_show_hide_episode',
            'type' => 'button_set',
            'title' => esc_html('Hide Number Of Episode', 'stremlab-core') ,

            'options' => array(
                'show' => esc_html__('Show', 'stremlab-core'),
                'hide' => esc_html__('Hide', 'stremlab-core'),

            ) ,
            'default' => 'show',
        ),
         array(
            'id'       => 'tv_show_hide_year',
            'type' => 'button_set',
            'title' => esc_html('Hide Release Year', 'stremlab-core') ,

            'options' => array(
                'show' => esc_html__('Show', 'stremlab-core'),
                'hide' => esc_html__('Hide', 'stremlab-core'),

            ) ,
            'default' => 'show',
        ),
        array(
            'id'       => 'tv_show_hide_genre',
            'type' => 'button_set',
            'title' => esc_html('Hide Genre', 'stremlab-core') ,

            'options' => array(
                'show' => esc_html__('Show', 'stremlab-core'),
                'hide' => esc_html__('Hide', 'stremlab-core'),

            ) ,
            'default' => 'show',
        ),
        array(
            'id'       => 'tv_show_hide_views',
            'type' => 'button_set',
            'title' => esc_html('Hide Views', 'stremlab-core') ,

            'options' => array(
                'show' => esc_html__('Show', 'stremlab-core'),
                'hide' => esc_html__('Hide', 'stremlab-core'),

            ) ,
            'default' => 'show',
        ),
        array(
            'id'       => 'tv_show_social_share',
            'type'     => 'text',
            'title'    => __('Social share title', 'streamlab-core'),
            'default' => 'Social Share :',
            'label' => true,
        ),
        array(
        'id'       => 'single_tv_show_load_type',
        'type'     => 'select',
        'title'    => __( 'More Like tv show Load', 'stremlab-core'), 
       
        'options'  => array(
           
            'loadmore' => 'loadmore',
            'infscroll' => 'Infinity Scroll'
        ),
        'default'  => 'loadmore',
        ),

        array(
        'id'       => 'single_tv_show_load_title',
        'type'     => 'text',
        'title'    => __( 'Title', 'stremlab-core'), 
       
        
        'default'  => 'More Like This',
        ),

        array(
            'id'       => 'single_tv_show_load_filter',
            'type'     => 'select',
            'title'    => __( 'More Like tv show Filter', 'stremlab-core'), 
           
            'options'  => array(
               
                'all' => 'All tv show',
                
                'related' => 'Related',
               
            ),
            'default'  => 'all',
        ),   

         array(
            'id' => 'info_general'.rand(10,1000),
            'type' => 'info',
            'style' => 'custom',
            'color' => sanitize_hex_color($color),
            'title' => __('Episode Page Settings', 'stremlab-core') ,
            
        ),

        array(
            'id' => 'section-general'.rand(10,1000),
            'type' => 'section',
            'indent' => true
        ) ,
        streamlab_core_get_post_social_share( 'episode', 'Episode Social Share' ),
         array(
            'id'       => 'edpisode_hide_run_time',
            'type' => 'button_set',
            'title' => esc_html('Hide Runtime', 'stremlab-core') ,

            'options' => array(
                'show' => esc_html__('Show', 'stremlab-core'),
                'hide' => esc_html__('Hide', 'stremlab-core'),

            ) ,
            'default' => 'show',
        ),
        array(
            'id'       => 'edpisode_hide_views',
            'type' => 'button_set',
            'title' => esc_html('Hide Views', 'stremlab-core') ,

            'options' => array(
                'show' => esc_html__('Show', 'stremlab-core'),
                'hide' => esc_html__('Hide', 'stremlab-core'),

            ) ,
            'default' => 'show',
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
        
        streamlab_core_get_post_load_type( 'tv_show_playlist' , 'PlayList Tv Show Load Type'  ),

    )
));