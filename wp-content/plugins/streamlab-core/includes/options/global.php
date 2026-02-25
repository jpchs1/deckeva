<?php
/*
 * Global Options
*/

Redux::setSection($options, array(
    'title' => esc_html__('Global', 'stremlab-core') ,
    'id' => 'section_0026e62',
    'icon' => 'eicon-global-settings',
    'customizer_width' => '500px',
));


//Favicon Option
Redux::setSection($options, array(
    'title' => esc_html__('Favicon', 'stremlab-core') ,
    'id' => 'section_08d42cd',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'info_b470602',
            'type' => 'info',
            'style' => 'custom',
            'color' => sanitize_hex_color($color),
            'title' => __('Favicon', 'stremlab-core') ,
            'desc' => __('Upload .ico File For Favicon Icon', 'stremlab-core')
        ) ,
        array(
            'id' => 'indent_0026e62',
            'type' => 'section',
            'indent' => true
        ) ,

        array(
            'id' => 'background_favicon',
            'type' => 'media',            
            'url' => true,
            'read-only' => false,
            

        ) ,
    )
));

//Loader Options
Redux::setSection($options, array(
    'title' => esc_html__('Loader', 'stremlab-core') ,
    'id' => 'section_06c6c5e',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'info_01ec772',
            'type' => 'info',
            'style' => 'custom',
            'color' => sanitize_hex_color($color),
            'title' => __('Loader Options', 'stremlab-core') ,
        ) ,
        array(
            'id' => 'section_7b84de1',
            'type' => 'section',
            'indent' => true
        ) ,

        array(
            'id' => 'loader_switch',
            'type' => 'button_set',
            'title' => __('', 'stremlab-core') ,
            'subtitle' => __('', 'stremlab-core') ,
            'desc' => __('', 'stremlab-core') ,
            //Must provide key => value pairs for options
            'options' => array(
                'none' => esc_html__('none','stremlab-core'),
                'image' => esc_html__('Image','stremlab-core'),
                'text' => esc_html__('text', 'stremlab-core'),
                
            ) ,
            'default' => esc_html__('image','stremlab-core')
            
        ) ,


        array(
            'id' => 'background_loader',
            'type' => 'media',
            'title'    => __('Upload Loader Image', 'stremlab-core'),               
            
            'desc' => 'upload gif image here',
            'url' => false,
            'read-only' => false,
            'required' => array(
                'loader_switch',
                '=',
                'image'
            ) ,
        ) ,   
          
      array(
            'id' => 'loader_dimensions',
            'type' => 'dimensions',
            'units' => array(
                'em',
                'px',
                '%'
            ) , // You can specify a unit value. Possible: px, em, %
            'units_extended' => 'true', // Allow users to select any type of unit
            'title' => esc_html__('Loader (Width/Height) Option', 'stremlab-core') ,            
            'required' => array(
                'loader_switch',
                '=',
                'image'
            ) ,

        ) ,     
        array(
            'id'        => 'loader_text',
            'type'      => 'text',   
            'title'    => __('Enter Loader Text', 'stremlab-core'),                      
            'default'   => esc_html__( 'Loading....','stremlab-core' ),
            'desc' => esc_html__('Enter Text', 'stremlab-core') ,
            'required' => array(
                'loader_switch',
                '=',
                'text'
            ) ,
        ),
        array(
            'id'       => 'loader_tag',
            'type'     => 'select',
            'title'    => __('Select Html Tag', 'stremlab-core'),             
            'desc'     => __('Select Tag For Loader Text.', 'stremlab-core'),
            // Must provide key => value pairs for select options
            'options'  => array(
                'h1' => esc_html__('h1', 'stremlab-core'),
                'h2' => esc_html__('h2', 'stremlab-core'),
                'h3' => esc_html__('h3', 'stremlab-core'),
                'h4' => esc_html__('h4', 'stremlab-core'),
                'h5' => esc_html__('h5', 'stremlab-core'),
                'h6' => esc_html__('h6', 'stremlab-core'),
                
            ),
            'required' => array(
                'loader_switch',
                '=',
                'text'
            ) ,
            'default' => esc_html__('h2', 'stremlab-core'),
        ),

        array(
            'id' => 'loader_color',
            'type' => 'color', 
            'title'    => __('Choose Color Loader Text', 'stremlab-core'),                                 
            'desc' => esc_html__('Choose Color For Loader Text .', 'stremlab-core') ,
            
            'mode' => 'background',            
            'transparent' => false,
            'required' => array(
                'loader_switch',
                '=',
                'text'
            ) ,
        ),

        array(
            'id' => 'loader_background_color',
            'type' => 'color',   
            'title'    => __('Background Color', 'stremlab-core'),                        
            'desc' => esc_html__('Choose Background Color For  Loader.', 'stremlab-core') ,
            
            'mode' => 'background',            
            'transparent' => false,
           
        ) ,
        
    )
));
// Back To Top Options
Redux::setSection($options, array(
    'title' => esc_html__('Back To Top', 'stremlab-core') ,
    'id' => 'section_4afd0c7',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'info_4afd0c7',
            'type' => 'info',
            'style' => 'custom',
            'color' => sanitize_hex_color($color),
            'title' => __('Enable Back To Top', 'stremlab-core') ,
        ) ,
        array(
            'id' => 'indent_4afd0c7',
            'type' => 'section',
            'indent' => true
        ) ,

        array(
            'id'       => 'back_to_top',
            'type'     => 'button_set',
            'options'  => array(
                'yes' => 'Yes',
                'no' => 'No'
            ),
            'default'  => 'yes'
        ),

         array(
            'id' => 'back_top_background_color',
            'type' => 'color',   
            'title'    => __('Background Color', 'stremlab-core'),                        
            'desc' => esc_html__('Choose Background Color For Back To Top.', 'stremlab-core') ,
            
            'mode' => 'background',            
            'transparent' => false,
            'required' => array(
                'back_to_top',
                '=',
                'yes'
            ) ,
           
        ) ,

        array(
            'id' => 'back_top_background_color_hover',
            'type' => 'color',   
            'title'    => __('Background Hover Color', 'stremlab-core'),                        
            'desc' => esc_html__('Choose Background Hover Color For Back To Top.', 'stremlab-core') ,            
            'mode' => 'background',            
            'transparent' => false,
            'required' => array(
                'back_to_top',
                '=',
                'yes'
            ) ,
           
        ) ,

       
    )
));


// Logo Options
Redux::setSection($options, array(
    'title' => esc_html__('Logo', 'stremlab-core') ,
    'id' => 'section_9584bc8',
    'icon' => 'eicon-logo',
    'customizer_width' => '500px',
));
Redux::setSection($options, array(
    'title' => esc_html__('Header Logo', 'stremlab-core') ,
    'id' => 'section_b5687c6',
    'subsection' => true,
    'fields' => array(

        array(
            'id' => 'info_c50e968',
            'type' => 'info',
            'style' => 'custom',
            'color' => sanitize_hex_color($color),
            'title' => __('Header Logo Options', 'stremlab-core') ,
        ) ,

        array(
            'id' => 'indent_9658318',
            'type' => 'section',
            'indent' => true
        ) ,

        array(
            'id' => 'logo_type',
            'type' => 'button_set',
            'title' => __('Header Logo Type', 'stremlab-core') ,            
            'desc' => __('', 'stremlab-core') ,
            //Must provide key => value pairs for options
            'options' => array(
                'image' => esc_html__('Image','stremlab-core'),
                'text' => esc_html__('text', 'stremlab-core'),
                
            ) ,
            'default' => esc_html__('image','stremlab-core')
            
        ) ,

        array(
            'id' => 'logo_url',
            'type' => 'media',
            'url' => true,
            'title' => esc_html__('Image', 'stremlab-core') ,
            'read-only' => false,
            'indent' => true,
            'required' => array(
                'logo_type',
                '=',
                'image'
            ) ,
            
        ) ,
        array(
            'id' => 'logo_dimensions',
            'type' => 'dimensions',
            'units' => array(
                'em',
                'px',
                '%'
            ) , // You can specify a unit value. Possible: px, em, %
            'units_extended' => 'true', // Allow users to select any type of unit
            'title' => esc_html__('Header Logo (Width/Height) Option', 'stremlab-core') ,
            
            'required' => array(
                'logo_type',
                '=',
                'image'
            ) ,

        ) ,

        array(
            'id' => 'header_logo_text',
            'type' => 'text',
            'title' => esc_html__('Header Logo Text', 'stremlab-core') ,
            'required' => array(
                'logo_type',
                '=',
                'text'
            ) ,

        ) ,
         array(
            'id'       => 'header_logo_tag',
            'type'     => 'select',
            'title'    => __('Select Html Tag', 'stremlab-core'),             
            'desc'     => __('Select Tag For Text.', 'stremlab-core'),
            // Must provide key => value pairs for select options
            'options'  => array(
                'h1' => esc_html__('h1', 'stremlab-core'),
                'h2' => esc_html__('h2', 'stremlab-core'),
                'h3' => esc_html__('h3', 'stremlab-core'),
                'h4' => esc_html__('h4', 'stremlab-core'),
                'h5' => esc_html__('h5', 'stremlab-core'),
                'h6' => esc_html__('h6', 'stremlab-core'),
                
            ),
            'required' => array(
                'logo_type',
                '=',
                'text'
            ) ,
            'default' => esc_html__('h2', 'stremlab-core'),
        ),

       

        array(
            'id' => 'header_logo_color',
            'type' => 'color',
            'title' => esc_html__('Set Header Logo Color', 'stremlab-core') ,
            'subtitle' => esc_html__('Choose Header Logo Color', 'stremlab-core') ,
            'default' => '#ffffff',
            'mode' => 'background',
            'transparent' => false,
            'required' => array(
                'logo_type',
                '=',
                'text'
            ) ,
        ) ,
      
    )
));


?>