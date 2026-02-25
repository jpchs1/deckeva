<?php
/*
* Header Options
*/

Redux::setSection($options, array(
    'title' => esc_html__('Header', 'stremlab-core') ,
    'id' => 'section_230ac35',
    'icon' => 'eicon-header',
    'customizer_width' => '500px',
));

Redux::setSection($options, array(
    'title' => esc_html__('Layout', 'stremlab-core') ,
    'id' => 'section_09d4601',
    'subsection' => true,
    'desc' => esc_html__('Section For Customize Header', 'stremlab-core') ,
    'fields' => array(

        array(
            'id' => 'info__09d4601',
            'type' => 'info',
            'style' => 'custom',
            'color' => sanitize_hex_color($color),
            'title' => __('Header Layout Options', 'stremlab-core') ,
        ) ,

        array(
            'id' => 'indent_09d4601',
            'type' => 'section',
            'indent' => true
        ) ,

     

        array(
            'id' => 'header_search_enable',
            'type' => 'button_set',
            'title' => esc_html__('Enable Search Button', 'stremlab-core') ,

            'options' => array(
                'yes' => esc_html__('Yes', 'stremlab-core') ,
                'no' => esc_html__('No', 'stremlab-core')

            ) ,
            'default' => esc_html__('yes', 'stremlab-core'),
            'required' => array('pt_header_layout', '=', array('default' ,'style-two' ) ) ,
        ) ,

         array(
            'id'        => 'search_text',
            'type'      => 'text',   
            'title'    => __('Search Placeholder Text', 'stremlab-core'),                      
            'default'   => esc_html__( 'Search ..','stremlab-core' ),
            'desc' => esc_html__('Enter Text', 'stremlab-core') ,
        ),

        array(
            'id' => 'default_post_to_search',
            'type' => 'button_set',
            'title' => esc_html__('Default Post to Search', 'stremlab-core') ,

            'options' => array(
                'all' => esc_html__('All', 'stremlab-core') ,
                'movie' => esc_html__('movie', 'stremlab-core') ,
                'tv_show' => esc_html__('Tv show', 'stremlab-core'),
                'video' => esc_html__('video', 'stremlab-core'),
                'video' => esc_html__('video', 'stremlab-core')

            ) ,
            'default' => esc_html__('all', 'stremlab-core'),
            
        ) ,

       

     
//Sidebar
        // array(
        //     'id' => 'header_sidebar_enable',
        //     'type' => 'button_set',
        //     'title' => esc_html__('Enable Siderbar', 'stremlab-core') ,

        //     'options' => array(
        //         'yes' => esc_html__('Yes', 'stremlab-core') ,
        //         'no' => esc_html__('No', 'stremlab-core')

        //     ) ,
        //     'default' => esc_html__('yes', 'stremlab-core'),
           
        // ) ,
       
        

    // action button
 array(
            'id' => 'header_action_enable',
            'type' => 'button_set',
            'title' => esc_html__('Enable Action Button', 'stremlab-core') ,
            
            'options' => array(
                'yes' => esc_html__('Yes', 'stremlab-core') ,
                'no' => esc_html__('No', 'stremlab-core')
                
            ) ,
            'default' => esc_html__('yes', 'stremlab-core'),
            // 'required' => array('pt_header_layout', '=', 'style-one'  ) ,
        ) ,

           array(
            'id' => 'action_btn_text',
            'type' => 'text',
            'title' => esc_html__('Action Button Text', 'stremlab-core') ,
             'required' => array('header_action_enable', '=', array('yes' ) ) ,

        ) ,

        array(
            'id' => 'action_button_color',
            'type' => 'Action Button Background color',
            'title' => esc_html__('Color', 'stremlab-core') ,         
             'type' => 'color',
            'mode' => 'background',
            'transparent' => false
        ) ,

           array(
            'id' => 'action_btn_url',
            'type' => 'text',
            'title' => esc_html__('Action Button Url', 'stremlab-core') ,
             'required' => array('header_action_enable', '=', array('yes' ) ) ,

        ) ,

//Sidebar


        array(
            'id' => 'header_back_opt_switch',
            'type' => 'button_set',
            'title' => esc_html__('Background', 'stremlab-core') ,

            'options' => array(
                'none' => esc_html__('none', 'stremlab-core') ,
                'image' => esc_html__('Image', 'stremlab-core') ,
                'color' => esc_html__('Color', 'stremlab-core'),
                'transparent' => esc_html__('Transparent', 'stremlab-core'),
                'dark' => esc_html__('Dark', 'stremlab-core'),
                'white' => esc_html__('White', 'stremlab-core')
            ) ,
            'default' => esc_html__('none', 'stremlab-core')
        ) ,
        array(
            'id' => 'header_back_img',
            'type' => 'media',
            'url' => true,
            'title' => esc_html__('Image', 'stremlab-core') ,
            'read-only' => false,
            'required' => array(
                'header_back_opt_switch',
                '=',
                'image'
            ) ,
        ) ,        

        array(
            'id' => 'header_back_color',
            'type' => 'color',
            'title' => esc_html__('Color', 'stremlab-core') ,         

            'mode' => 'background',
            'required' => array(
                'header_back_opt_switch',
                '=',
                'color'
            ) ,
            'transparent' => false
        ) ,
        array(
            'id' => 'info__09d461',
            'type' => 'info',
            'style' => 'custom',
            'color' => sanitize_hex_color($color),
            'title' => __('Header Menu Color Options', 'stremlab-core') ,
        ) ,

        array(
            'id' => 'indent_09d601',
            'type' => 'section',
            'indent' => true
        ) ,
        array(
            'id' => 'menu_normal_color',
            'type' => 'color',
            'title' => esc_html__('Normal Color', 'stremlab-core') ,         

            'mode' => 'background',

            'transparent' => false
        ) ,
        array(
            'id' => 'menu_hover_color',
            'type' => 'color',
            'title' => esc_html__('Hover Color', 'stremlab-core') ,         

            'mode' => 'background',

            'transparent' => false
        ) ,

        array(
            'id' => 'menu_active_color',
            'type' => 'color',
            'title' => esc_html__('Active Color', 'stremlab-core') ,         

            'mode' => 'background',

            'transparent' => false
        ) ,

        array(
            'id' => 'info__09d61',
            'type' => 'info',
            'style' => 'custom',
            'color' => sanitize_hex_color($color),
            'title' => __('Header Sub Menu Color Options', 'stremlab-core') ,
        ) ,

        array(
            'id' => 'indent_09d01',
            'type' => 'section',
            'indent' => true
        ) ,

        array(
            'id' => 'sub_menu_normal_color',
            'type' => 'color',
            'title' => esc_html__('Normal Color', 'stremlab-core') ,         

            'mode' => 'background',

            'transparent' => false
        ) ,
        array(
            'id' => 'sub_menu_hover_color',
            'type' => 'color',
            'title' => esc_html__('Hover Color', 'stremlab-core') ,         

            'mode' => 'background',

            'transparent' => false
        ) ,

        array(
            'id' => 'sub_menu_active_color',
            'type' => 'color',
            'title' => esc_html__('Active Color', 'stremlab-core') ,         

            'mode' => 'background',

            'transparent' => false
        ) ,

        array(
            'id' => 'sub_menu_background_color',
            'type' => 'color',
            'title' => esc_html__('Background Color', 'stremlab-core') ,         

            'mode' => 'background',

            'transparent' => false
        ) ,

        array(
            'id' => 'sub_menu_background_hover_color',
            'type' => 'color',
            'title' => esc_html__('Background Hover Color', 'stremlab-core') ,        

            'mode' => 'background',            
            'transparent' => false
        ) ,

        array(
            'id' => 'sub_menu_background_active_color',
            'type' => 'color',
            'title' => esc_html__('Background Active Color', 'stremlab-core') ,        

            'mode' => 'background',            
            'transparent' => false
        ) ,






    )
));

