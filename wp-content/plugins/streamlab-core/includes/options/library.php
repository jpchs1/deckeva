<?php
/*
 * Sidebar Options
*/


// sidebar Page Settings
Redux::setSection( $options, array(
    'title' => esc_html__('User Library','stremlab-core'),
    'id'    => 'user-section',
    'icon' => 'fa fa-indent',
        
    'subsection' => false,
         
    'fields'=> array(

        array(
            'id' => 'info_general'.rand(10,1000),
            'type' => 'info',
            'style' => 'custom',
            'color' => sanitize_hex_color($color),
            'title' => __('User Library', 'stremlab-core') ,
            
        ) ,

        array(
            'id' => 'section-general'.rand(10,1000),
            'type' => 'section',
            'indent' => true
        ) ,  

         array(
            'id' => 'enable_user_menu',
            'type' => 'button_set',
            'title' => esc_html__('Enable User Menu In Header', 'stremlab-core') ,

            'options' => array(
                'yes' => esc_html__('Yes', 'stremlab-core') ,
                'no' => esc_html__('No', 'stremlab-core')

            ) ,
            'default' => 'yes',
        ) ,  

         array(
            'id' => 'enable_user_library',
            'type' => 'button_set',
            'title' => esc_html__('Enable Libray Menu For User In Header', 'stremlab-core') ,

            'options' => array(
                'yes' => esc_html__('Yes', 'stremlab-core') ,
                'no' => esc_html__('No', 'stremlab-core')

            ) ,
            'default' => 'yes',
        ) ,  

        array(
            'id' => 'enable_upload_video',
            'type' => 'button_set',
            'title' => esc_html__('Enable Upload Video', 'stremlab-core') ,

            'options' => array(
                'yes' => esc_html__('Yes', 'stremlab-core') ,
                'no' => esc_html__('No', 'stremlab-core')

            ) ,
            'default' => 'yes',
        ) ,
        array(
            'id' => 'enable_logout_button',
            'type' => 'button_set',
            'title' => esc_html__('Enable Logout Button', 'stremlab-core') ,

            'options' => array(
                'yes' => esc_html__('Yes', 'stremlab-core') ,
                'no' => esc_html__('No', 'stremlab-core')

            ) ,
            'default' => 'yes',
        ) ,
         array(
            'id'       => 'login_redirect_url',
            'type'     => 'text',
            'title'    => __('Redirect After Login', 'streamlab-core'),
            'label' => true,
        ),
        array(
            'id'       => 'logout_redirect_url',
            'type'     => 'text',
            'title'    => __('Redirect After Logout', 'streamlab-core'),
            'label' => true,
        ),

        array(
            'id' => 'info_general'.rand(10,1000),
            'type' => 'info',
            'style' => 'custom',
            'color' => sanitize_hex_color($color),
            'title' => __('User Actions', 'stremlab-core') ,
            
        ) ,

        array(
            'id' => 'section-general'.rand(10,1000),
            'type' => 'section',
            'indent' => true
        ) ,    

        array(
            'id' => 'enable_playlist_button',
            'type' => 'button_set',
            'title' => esc_html__('Enable Playlist Button', 'stremlab-core') ,

            'options' => array(
                'yes' => esc_html__('Yes', 'stremlab-core') ,
                'no' => esc_html__('No', 'stremlab-core')

            ) ,

            'default' => 'yes',
        ) ,

         array(
            'id' => 'enable_share_button',
            'type' => 'button_set',
            'title' => esc_html__('Enable Share Button', 'stremlab-core') ,

            'options' => array(
                'yes' => esc_html__('Yes', 'stremlab-core') ,
                'no' => esc_html__('No', 'stremlab-core')

            ) ,

            'default' => 'yes',
        ) ,

        array(
            'id' => 'enable_like_button',
            'type' => 'button_set',
            'title' => esc_html__('Enable Like Button', 'stremlab-core') ,

            'options' => array(
                'yes' => esc_html__('Yes', 'stremlab-core') ,
                'no' => esc_html__('No', 'stremlab-core')

            ) ,
            'default' => 'yes',
        ) ,

        array(
            'id' => 'info_general'.rand(10,1000),
            'type' => 'info',
            'style' => 'custom',
            'color' => sanitize_hex_color($color),
            'title' => __('Account Menu Labels', 'stremlab-core') ,
            
        ) ,

        array(
            'id' => 'section-general'.rand(10,1000),
            'type' => 'section',
            'indent' => true
        ) ,

         array(
            'id'        => 'mas_dashboard',
            'type'      => 'text',   
            'title'    => __('Dashboard', 'stremlab-core'),                      
            'default'   => esc_html__( 'Dashboard','stremlab-core' )
        ),

        array(
            'id'        => 'mas_videos',
            'type'      => 'text',   
            'title'    => __('Videos', 'stremlab-core'),                      
            'default'   => esc_html__( 'Videos','stremlab-core' )
        ),


        array(
            'id'        => 'mas_movie_playlists',
            'type'      => 'text',   
            'title'    => __('Movie playlists', 'stremlab-core'),                      
            'default'   => esc_html__( 'Movie playlists','stremlab-core' )
        ),

        array(
            'id'        => 'mas_tv_show_playlists',
            'type'      => 'text',   
            'title'    => __('TV Show playlists', 'stremlab-core'),                      
            'default'   => esc_html__( 'TV Show playlists','stremlab-core' )
        ),

        array(
            'id'        => 'mas_video_playlists',
            'type'      => 'text',   
            'title'    => __('Video playlists', 'stremlab-core'),                      
            'default'   => esc_html__( 'Video playlists','stremlab-core' )
        ),
        
        array(
            'id'        => 'mas_acc_details',
            'type'      => 'text',   
            'title'    => __('Account details', 'stremlab-core'),                      
            'default'   => esc_html__( 'Account details','stremlab-core' )
        ),

        array(
            'id'        => 'mas_logout',
            'type'      => 'text',   
            'title'    => __('Logout', 'stremlab-core'),                      
            'default'   => esc_html__( 'Logout','stremlab-core' )
        ),


           
    )
));