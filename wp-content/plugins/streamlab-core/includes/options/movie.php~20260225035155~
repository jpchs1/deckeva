<?php
/*
 * Sidebar Options
*/


// sidebar Page Settings
Redux::setSection( $options, array(
    'title' => esc_html__('Movies','stremlab-core'),
    'id'    => 'movies-section',
    'icon' => ' eicon-video-camera',
        
    'subsection' => false,
         
    'fields'=> array(

        array(
            'id' => 'info_general'.rand(10,1000),
            'type' => 'info',
            'style' => 'custom',
            'color' => sanitize_hex_color($color),
            'title' => __('Movies Page Settings', 'stremlab-core') ,
            
        ),

        array(
            'id' => 'section-general'.rand(10,1000),
            'type' => 'section',
            'indent' => true
        ) ,   

        array(
            'id'       => 'movie_title',
            'type'     => 'text',
            'title'    => __('Movie Page Title', 'streamlab-core'),
            'label' => true,
        ),
        array(
            'id'       => 'no_movie_found_message',
            'type'     => 'text',
            'title'    => __('No Movie Found Message', 'streamlab-core'),
            'label' => true,
            'default'=> __('No movies were found matching your selection.', 'streamlab-core'),
        ),
    

        array(
        'id'       => 'movie_box_style',
        'type'     => 'select',
        'title'    => __( 'Movie Box Style', 'stremlab-core'), 
        
        'options'  => array(
            '1' => 'Style 1',
            '2' => 'Style 2',
            '3' => 'Style 3',
        ),
        'default'  => '1',
    ),

     

      streamlab_core_get_layout_options( 'movie' , 'column' , 'Movie Page Layout' ),
      streamlab_core_get_post_load_type( 'movie' , 'Movie Load Type'  ),

        array(
            'id' => 'info_general'.rand(10,1000),
            'type' => 'info',
            'style' => 'custom',
            'color' => sanitize_hex_color($color),
            'title' => __('Movie Page Sidebar Options', 'stremlab-core') ,
            
        ) ,

        array(
            'id' => 'section-general'.rand(10,1000),
            'type' => 'section',
            'indent' => true
        ) ,      

      streamlab_core_get_layout_options( 'movie' , 'sidebar' , '' ),

      array(
            'id' => 'movie_dimensions',
            'type' => 'dimensions',
            'units_extended' => false, // Allow users to select any type of unit
            'title' => esc_html__('Specify Movie Image Dimention', 'stremlab-core') ,  
        ) ,     

       array(
            'id' => 'info_general'.rand(10,1000),
            'type' => 'info',
            'style' => 'custom',
            'color' => sanitize_hex_color($color),
            'title' => __('Single Movies Page Settings', 'stremlab-core') ,
            
        ),

        array(
            'id' => 'section-general'.rand(10,1000),
            'type' => 'section',
            'indent' => true
        ) ,
        streamlab_core_get_post_excerpt_content( 'movie' ),
        streamlab_core_get_post_social_share( 'movie' ),

        array(
            'id'       => 'movie_social_share',
            'type'     => 'text',
            'title'    => __('Social share title', 'streamlab-core'),
            'default' => 'Social Share :',
            'label' => true,
        ),
        array(
        'id'       => 'single_movie_load_type',
        'type'     => 'select',
        'title'    => __( 'More Like Movie Load', 'stremlab-core'), 
       
        'options'  => array(
           
            'loadmore' => 'loadmore',
            'infscroll' => 'Infinity Scroll'
        ),
        'default'  => 'loadmore',
        ),

        array(
        'id'       => 'single_movie_load_title',
        'type'     => 'text',
        'title'    => __( 'Title', 'stremlab-core'), 
       
        
        'default'  => 'More Like This',
        ),

        array(
            'id'       => 'single_movie_load_filter',
            'type'     => 'select',
            'title'    => __( 'More Like Movie Filter', 'stremlab-core'), 
           
            'options'  => array(
               
                'all' => 'All Movie',
                'recommanded' => 'Recommaned',
                'related' => 'Related',
               
            ),
            'default'  => 'all',
        ),

        array(
        'id'       => 'movie_hide_view',
        'type'     => 'button_set',
        'title'    => __('Hide View', 'redux-framework-demo'),
        
        //Must provide key => value pairs for options
        'options' => array(
            'yes' => 'yes', 
            'no' => 'no', 
         ), 
        'default' => 'yes'
    ),
        array(
        'id'       => 'movie_hide_censor',
        'type'     => 'button_set',
        'title'    => __('Hide Censor', 'redux-framework-demo'),
        
        //Must provide key => value pairs for options
        'options' => array(
            'yes' => 'yes', 
            'no' => 'no', 
         ), 
        'default' => 'yes'
        ),

        array(
            'id'       => 'movie_lang_title',
            'type'     => 'text',
            'title'    => __('Language Title', 'streamlab-core'),
            'label' => true,
            'default' => 'Language'
        ),
        array(
            'id'       => 'movie_subtitle',
            'type'     => 'text',
            'title'    => __('Subtitles  Title', 'streamlab-core'),
            'label' => true,
            'default' => 'Subtitles'
        ),
        array(
            'id'       => 'movie_audio_language',
            'type'     => 'text',
            'title'    => __('Audio Languages  Title', 'streamlab-core'),
            'label' => true,
            'default' => 'Audio Languages'
        ),
         array(
            'id'       => 'movie_genre_title',
            'type'     => 'text',
            'title'    => __('Genre Title', 'streamlab-core'),
            'label' => true,
            'default' => 'Genre'
        ),
         array(
            'id'       => 'movie_run_time_title',
            'type'     => 'text',
            'title'    => __('Run Time', 'streamlab-core'),
            'label' => true,
            'default' => 'Run Time'
        ),
         array(
            'id'       => 'movie_release_date',
            'type'     => 'text',
            'title'    => __('Release Date Title', 'streamlab-core'),
            'label' => true,
            'default' => 'Release Date'
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
        
        streamlab_core_get_post_load_type( 'movie_playlist' , 'Play List Movie Load Type'  ),
    )
));