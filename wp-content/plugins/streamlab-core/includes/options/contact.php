<?php
/*
 * Footer Options
 */
Redux::setSection( $options, array(
    'title'      => esc_html__( 'Contact', 'stremlab-core' ),
    'id'         => 'contact_section',
    'icon'       => 'el el-address-book',    
    'fields'     => array(
       
        array(
            'id'        => 'phone',
            'type'      => 'text',
            'title'     => esc_html__( 'Contact Number','stremlab-core'),
            
            
        ),
         array(
            'id'        => 'email',
            'type'      => 'text',
            'title'     => esc_html__( 'Email','stremlab-core'),
            
            
        ),
        array(
            'id'        => 'address',
            'type'      => 'textarea',
            'title'     => esc_html__( 'Address','stremlab-core'),
            // 'required'  => array( 'streamlab_footer_subscribe', '=', 'yes' ),
            
        ),
        
       
       
    )
));