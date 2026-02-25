<?php
/*
 * Blog Page Options
*/
Redux::setSection($options, array(
    'title' => esc_html__('Page', 'stremlab-core') ,
    'id' => 'section_dab925e',
    'icon' => 'eicon-product-pages',
    'customizer_width' => '1000px',
));

// Blog Page Settings
Redux::setSection( $options, array(
    'title' => esc_html__('Blog Page Settings','stremlab-core'),
    'id'    => 'section_0beceba',
    'subsection' => true,
    'desc'  => esc_html__('This section contains options for Pages.','stremlab-core'),
    'fields'=> array(
        array(
            'id' => 'info__0beceba',
            'type' => 'info',
            'style' => 'custom',
            'color' => sanitize_hex_color($color),

            'title' => __('Blog Page Options', 'stremlab-core') ,
        ) ,

        array(
            'id' => 'indent_0beceba',
            'type' => 'section',
            'indent' => true
        ) ,      

        array(
            'id'       => 'blog_btn_text',
            'type'     => 'text',
            'title'    => esc_html__( 'Blog Button Name', 'stremlab-core' ),
            'subtitle' => esc_html__( 'Change Blog Button Name in blog page and singal blog page', 'stremlab-core' ),
            'default'  => esc_html__('Read More','stremlab-core' ),
        ),
        array(
            'id' => 'post_dimensions',
            'type' => 'dimensions',
            'units_extended' => false, // Allow users to select any type of unit
            'title' => esc_html__('Specify post Image Dimention', 'stremlab-core') ,  
        ) ,  
        array(
            'id' => 'info_general'.rand(10,1000),
            'type' => 'info',
            'style' => 'custom',
            'color' => sanitize_hex_color($color),
            'title' => __('Blog Page Column Option', 'stremlab-core') ,
            
        ) ,

        array(
            'id' => 'section-general'.rand(10,1000),
            'type' => 'section',
            'indent' => true
        ) ,   

        streamlab_core_get_post_load_type( 'post' , 'Blog Load Type'  ),

        streamlab_core_get_layout_options( 'post' , 'column' , ''),
        
         array(
            'id' => 'info_general'.rand(10,1000),
            'type' => 'info',
            'style' => 'custom',
            'color' => sanitize_hex_color($color),
            'title' => __('Blog Page Sidebar Options', 'stremlab-core') ,
            
        ) ,

        array(
            'id' => 'section-general'.rand(10,1000),
            'type' => 'section',
            'indent' => true
        ) ,       

      streamlab_core_get_layout_options( 'post' , 'sidebar' , '' ),

        array(
            'id' => 'info_general'.rand(10,1000),
            'type' => 'info',
            'style' => 'custom',
            'color' => sanitize_hex_color($color),

            'title' => __('Blog Single Page Sider Options', 'stremlab-core') ,
        ) ,

        array(
            'id' => 'section-general'.rand(10,1000),
            'type' => 'section',
            'indent' => true
        ) ,

        streamlab_core_get_layout_options( 'single_blog' , 'sidebar' , '' ),   

        array(
            'id'        => 'enable_comment',
            'type'      => 'button_set',
            'title'     => esc_html__( 'Comments','stremlab-core'),
            'subtitle' => esc_html__( 'Turn on to display comments.','stremlab-core'),
            'options'   => array(
                            'yes' => esc_html__('On','stremlab-core'),
                            'no' => esc_html__('Off','stremlab-core')
                        ),
            'default'   => esc_html__('yes','stremlab-core')
        ),

        array(
            'id'        => 'display_author_name',
            'type'      => 'button_set',
            'title'     => esc_html__( 'Display Author Name','stremlab-core'),            
            'options'   => array(
                            'yes' => esc_html__('Yes','stremlab-core'),
                            'no' => esc_html__('No','stremlab-core')
                        ),
            'default'   => esc_html__('yes','stremlab-core')
        ),

        array(
            'id'        => 'display_publish_date',
            'type'      => 'button_set',
            'title'     => esc_html__( 'Display Publish Date','stremlab-core'),            
            'options'   => array(
                            'yes' => esc_html__('Yes','stremlab-core'),
                            'no' => esc_html__('No','stremlab-core')
                        ),
            'default'   => esc_html__('yes','stremlab-core')
        ),
        array(
            'id'        => 'display_tags',
            'type'      => 'button_set',
            'title'     => esc_html__( 'Display Tag','stremlab-core'),            
            'options'   => array(
                            'yes' => esc_html__('Yes','stremlab-core'),
                            'no' => esc_html__('No','stremlab-core')
                        ),
            'default'   => esc_html__('yes','stremlab-core')
        ),

        array(
            'id'        => 'display_title',
            'type'      => 'button_set',
            'title'     => esc_html__( 'Display Title','stremlab-core'),            
            'options'   => array(
                            'yes' => esc_html__('Yes','stremlab-core'),
                            'no' => esc_html__('No','stremlab-core')
                        ),
            'default'   => esc_html__('no','stremlab-core')
        ),

        
    )
    ));
Redux::setSection( $options, array(
        'title' => esc_html__('404','stremlab-core'),
        'id'    => 'fourzerofour-section',
        
        'subsection' => true,
        'desc'  => esc_html__('This section contains options for 404.','stremlab-core'),
        'fields'=> array(
            array(
                'id' => 'info_general'.rand(10,1000),
                'type' => 'info',
                'style' => 'custom',
                'color' => sanitize_hex_color($color),
    
                'title' => __('404 Page Options', 'stremlab-core') ,
            ) ,
    
            array(
                'id' => 'section-general'.rand(10,1000),
                'type' => 'section',
                'indent' => true
            ) ,   
            
    
            array(
                'id'        => 'title_404',
                'type'      => 'text',
                'title'     => esc_html__( '404 Page Title','stremlab-core'),
                'default'   => esc_html__( '404 Error','stremlab-core' )
            ),
            array(
                'id'        => 'description_404',
                'type'      => 'textarea',
                'title'     => esc_html__( '404 Page Description','stremlab-core'),
                'default'   => esc_html__( 'Oops! This Page is Not Found.','stremlab-core' )
            ),
        )) 
    );   
?>