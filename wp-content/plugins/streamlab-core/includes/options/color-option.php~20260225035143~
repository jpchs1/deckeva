<?php
/*
 * Color Options
 */
Redux::setSection( $options, array(
    'title' => esc_html__('Color Option','stremlab-core'),
    'id'    => 'color-section',
    

    'fields'=> array(

        array(
            'id' => 'info_N7VD05',
            'type' => 'info',
            'style' => 'custom',
            'color' => sanitize_hex_color($color),
            'title' => __('This section contains options for site colors', 'stremlab-core') ,
        ) ,

        array(
            'id' => 'indent_N7VDM0M',
            'type' => 'section',
            'indent' => true
        ) ,

        array(
        'id'       => 'color_demo',
        'type'     => 'select',
        'title'    => __( 'Color Demo', 'stremlab-core'), 
       
        'options'  => array(
            'default' => 'default',
            'red' => 'Red',
            
            
        ),
        'default'  => 'default',
        ),

        array(
            'id'        => 'pt_custom_color',
            'type'      => 'button_set',
            'title'     => esc_html__( 'Use Custom Color','stremlab-core'),
            
            'options'   => array(
                            'yes' => esc_html__('Yes','stremlab-core'),
                            'no' => esc_html__('No','stremlab-core')
                        ),
            'default'   => esc_html__('no','stremlab-core')
        ),
        
       
        
        array(
            'id' => 'pt_primary_color',
            'type' => 'color',
            'title' => esc_html__('Primary Color', 'stremlab-core') ,         
            'subtitle' => esc_html__('Replace With Your Color', 'stremlab-core') ,       
            'mode' => 'background',
            'required' => array(
                'pt_custom_color',
                '=',
                'yes'
            ) ,
            'transparent' => false
        ) ,
        array(
            'id' => 'pt_secondary_color',
            'type' => 'color',
            'title' => esc_html__('Secondary Color', 'stremlab-core') ,         
            'subtitle' => esc_html__('Replace With Your Color', 'stremlab-core') ,       
            'mode' => 'background',
            'required' => array(
                'pt_custom_color',
                '=',
                'yes'
            ) ,
            'transparent' => false
        ) ,

        array(
            'id' => 'pt_dark_color',
            'type' => 'color',
            'title' => esc_html__('Dark Color', 'stremlab-core') ,         
            'subtitle' => esc_html__('Replace With Your Color', 'stremlab-core') ,       
            'mode' => 'background',
            'required' => array(
                'pt_custom_color',
                '=',
                'yes'
            ) ,
            'transparent' => false
        ) ,

        array(
            'id' => 'pt_grey_color',
            'type' => 'color',
            'title' => esc_html__('Gray Color', 'stremlab-core') ,        
            'subtitle' => esc_html__('Replace With Your Color', 'stremlab-core') ,       
            'mode' => 'background',
            'required' => array(
                'pt_custom_color',
                '=',
                'yes'
            ) ,
            'transparent' => false
        ) ,

        array(
            'id' => 'pt_white_color',
            'type' => 'color',
            'title' => esc_html__('White Color', 'stremlab-core') ,
            'subtitle' => esc_html__('Replace With Your Color', 'stremlab-core') ,       
            
            'mode' => 'background',
            'required' => array(
                'pt_custom_color',
                '=',
                'yes'
            ) ,
            'transparent' => false
        ) ,
    )
));