<?php
/*
 * Color Options
 */
Redux::setSection( $options, array(
    'title' => esc_html__('CSS','repairer'),
    'id'    => 'custom-css-section',
    'icon'       => '',     

    'fields'=> array(

        array(
            'id' => 'info_N7VD051',
            'type' => 'info',
            'style' => 'custom',
            'color' => sanitize_hex_color($color),
            'title' => __('', 'repairer-core') ,
        ) ,

        array(
            'id' => 'indent_N7VDM0M1',
            'type' => 'section',
            'indent' => true
        ) ,  
        array(
        'id'       => 'streamlab_custom_css',
        'type'     => 'ace_editor',
        'title'    => __('CSS Code', 'redux-framework-demo'),
        'subtitle' => __('Paste your CSS code here.', 'redux-framework-demo'),
        'mode'     => 'css',
        'theme'    => 'monokai',
        
        ) 
        
    )
));

