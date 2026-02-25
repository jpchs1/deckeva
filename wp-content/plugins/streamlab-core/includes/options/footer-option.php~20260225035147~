<?php
/*
 * Footer Options
 */

Redux::setSection( $options, array(
    'title' => esc_html__( 'Footer', 'stremlab-core' ),
    'id'    => 'footer-editor',
    'icon'  => 'eicon-footer',
    'customizer_width' => '500px',
) );

Redux::setSection( $options, array(
    'title' => esc_html__('Footer Logo','stremlab-core'),
    'id'    => 'footer-logo',
    
    'subsection' => true,
    'desc'  => esc_html__('This section contains options for footer.','stremlab-core'),
    'fields'=> array(

      array(
            'id' => 'info_L6N7VDM05M',
            'type' => 'info',
            'style' => 'custom',
            'color' => sanitize_hex_color($color),
            'title' => __('This sectin contain options for Footer logo', 'stremlab-core-core') ,
        ) ,

        array(
            'id' => 'indentL6N7VDM05M',
            'type' => 'section',
            'indent' => true
        ) ,
        
        array(
            'id'       => 'logo_footer',         
            'type'     => 'media',
            'url'      => false,
            'title'    => esc_html__( 'Footer Logo','stremlab-core'),
            'read-only'=> false,
            
        ), 

        array(
            'id'       => 'logo_playstore',         
            'type'     => 'media',
            'url'      => false,
            'title'    => esc_html__( 'Play Store Logo','stremlab-core'),
            'read-only'=> false,
            
        ),
        array(
            'id'       => 'link_playstore',         
            'type'     => 'text',
            'url'      => false,
            'title'    => esc_html__( 'Play Store Link','stremlab-core'),
            'read-only'=> false,
            'default'=> '#',
            
        ), 

        array(
            'id'       => 'logo_appstore',         
            'type'     => 'media',
            'url'      => false,
            'title'    => esc_html__( 'App Store Logo','stremlab-core'),
            'read-only'=> false,
            
         ), 

        array(
            'id'       => 'link_appstore',         
            'type'     => 'text',
            'url'      => false,
            'title'    => esc_html__( 'App Store Link','stremlab-core'),
            'read-only'=> false,
            'default'=> '#',
            
        ), 

       

    )
)); 



Redux::setSection( $options, array(
    'title' => esc_html__('Footer Option','stremlab-core'),
    'id'    => 'footer-section',
    
    'subsection' => true,    
    'fields'=> array(

        array(
            'id' => 'info_N7VDM05M',
            'type' => 'info',
            'style' => 'custom',
            'color' => sanitize_hex_color($color),
            'title' => __('This section contains options for footer', 'stremlab-core') ,
        ) ,

        array(
            'id' => 'indent_N7VDM05M',
            'type' => 'section',
            'indent' => true
        ) ,

       
        
        array(
            'id'        => 'footer_layout',
            'type'      => 'image_select',
            'title'     => esc_html__( 'Footer Layout Type','stremlab-core' ),
            'subtitle'  => wp_kses( __( '<br />Choose among these structures (1column, 2column and 3column) for your footer section.<br />To filling these column sections you should go to appearance > widget.<br />And put every widget that you want in these sections.','stremlab-core' ), array( 'br' => array() ) ),            
            'options'   => array(
                                '1' => array( 'title' => esc_html__( 'Footer Layout 1','stremlab-core' ), 'img' => STREAMLAB_CORE_URL. 'public/img/options/footer_first.png' ),
                                '2' => array( 'title' => esc_html__( 'Footer Layout 2','stremlab-core' ), 'img' => STREAMLAB_CORE_URL. 'public/img/options/footer_second.png' ),
                                '3' => array( 'title' => esc_html__( 'Footer Layout 3','stremlab-core' ), 'img' => STREAMLAB_CORE_URL. 'public/img/options/footer_third.png' ),
                                '4' => array( 'title' => esc_html__( 'Footer Layout 4','stremlab-core' ), 'img' => STREAMLAB_CORE_URL. 'public/img/options/footer_four.png' ),    
                                                           
                            ),
            'default'   => '4',
        ),
         array(
            'id' => 'footer_back_opt_switch',
            'type' => 'button_set',
            'title' => esc_html__('Background', 'stremlab-core') ,
            
            'options' => array(
                'none' => esc_html__('none', 'stremlab-core') ,
                'image' => esc_html__('Image', 'stremlab-core') ,
                'color' => esc_html__('Color', 'stremlab-core'),                
            ) ,
            'default' => esc_html__('none', 'stremlab-core')
        ) ,
         array(
            'id' => 'footer_back_img',
            'type' => 'media',
            'url' => true,
            'title' => esc_html__('Image', 'stremlab-core') ,
            'read-only' => false,
            'required' => array(
                'footer_back_opt_switch',
                '=',
                'image'
            ) ,
        ) ,        

        array(
            'id' => 'footer_back_color',
            'type' => 'color',
            'title' => esc_html__('Color', 'stremlab-core') ,         
            
            'mode' => 'background',
            'required' => array(
                'footer_back_opt_switch',
                '=',
                'color'
            ) ,
            'transparent' => false
        ) ,
    )
));

Redux::setSection( $options, array(
    'title'      => esc_html__( 'Footer Copyright', 'stremlab-core' ),
    'id'         => 'footer-copyright',
    
    'subsection' => true,
    'fields'     => array(
        array(
            'id' => 'info_7VDM05M',
            'type' => 'info',
            'style' => 'custom',
            'color' => sanitize_hex_color($color),
            'title' => __('This section contains options Footer Copyright', 'stremlab-core') ,
        ) ,

        array(
            'id' => 'indent_7VDM05M',
            'type' => 'section',
            'indent' => true
        ) ,
        array(
            'id'        => 'enable_footer_copyright',
            'type'      => 'button_set',
            'title'     => esc_html__( 'Enable Footer Copyright','stremlab-core'),
            'options'   => array(
                            'yes' => esc_html__('Yes','stremlab-core'),
                            'no' => esc_html__('No','stremlab-core')
                        ),
            'default'   => 'yes'
        ),
        array(
            'id'        => 'streamlab_copyright_text',
            'type'      => 'textarea',
            'title'     => esc_html__( 'Copyright Text','stremlab-core'),
            'default'   => esc_html__( 'Copyright '.date('Y').' stremlab All Rights Reserved.','stremlab-core'),
        ),

        array(
            'id'        => 'streamlab_copyright_link',
            'type'      => 'text',
            'title'     => esc_html__( 'Copyright Link','stremlab-core'),
            'default'   => '#',
        ),

    )) 
);

