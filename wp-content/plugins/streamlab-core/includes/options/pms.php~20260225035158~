<?php
/*
 * Sidebar Options
*/


// sidebar Page Settings
Redux::setSection( $options, array(
    'title' => esc_html__('Paid Member Subscriptions','stremlab-core'),
    'id'    => 'pms-section',
    'icon' => 'eicon-lock-user',
        
    'subsection' => false,
         
    'fields'=> array(

        array(
            'id' => 'info_general'.rand(10,1000),
            'type' => 'info',
            'style' => 'custom',
            'color' => sanitize_hex_color($color),
            'title' => __('Background Images', 'stremlab-core') ,
            
        ) ,

        array(
            'id' => 'section-general'.rand(10,1000),
            'type' => 'section',
            'indent' => true
        ) ,    

        array(
            'id' => 'pms_enable',
            'type' => 'button_set',
            'title' => esc_html__('Enable Paid Member Subscriptions', 'stremlab-core') ,

            'options' => array(
                'yes' => esc_html__('Yes', 'stremlab-core') ,
                'no' => esc_html__('No', 'stremlab-core')

            ) ,
            'default' => esc_html__('no', 'stremlab-core'),
            
        ) ,


           array(
            'id'       => 'my_account_url',         
            'type'     => 'text',
            'title'    => esc_html__( 'My Account Page Url','stremlab-core'),
            'read-only'=> false,
             'required' => array('pms_enable', '=', array('yes' ,'style-two' ) ) ,
            
        ),  

        array(
            'id'       => 'login_url',         
            'type'     => 'text',
            'title'    => esc_html__( 'Login Page Url','stremlab-core'),
            'read-only'=> false,
             'required' => array('pms_enable', '=', array('yes' ,'style-two' ) ) ,
            
        ), 

        array(
            'id'       => 'success_login_url',         
            'type'     => 'text',
            'title'    => esc_html__( 'Login Success Page Url','stremlab-core'),
            'read-only'=> false,
             'required' => array('pms_enable', '=', array('yes' ,'style-two' ) ) ,
            
        ), 

        array(
            'id'       => 'register_url',         
            'type'     => 'text',
            'title'    => esc_html__( 'Register Page Url','stremlab-core'),
            'read-only'=> false,
             'required' => array('pms_enable', '=', array('yes' ,'style-two' ) ) ,
            
        ), 


        array(
            'id'       => 'login_form_title',         
            'type'     => 'text',
            'title'    => esc_html__( 'Login form Title','stremlab-core'),
            'default' => 'Sign In',
            'read-only'=> false,
            'required' => array('pms_enable', '=', array('yes' ,'style-two' ) ) ,
            
        ),  

        array(
            'id'       => 'login_back_image',         
            'type'     => 'media',
            'url'      => false,
            'title'    => esc_html__( 'Login Page Background Image','stremlab-core'),
            'read-only'=> false,
            'required' => array('pms_enable', '=', array('yes' ,'style-two' ) ) ,
            
        ),

        array(
            'id'       => 'register_form_title',         
            'type'     => 'text',
            'title'    => esc_html__( 'Register form Title','stremlab-core'),
            'default' => 'Register',
            'read-only'=> false,
            'required' => array('pms_enable', '=', array('yes' ,'style-two' ) ) ,
            
        ),  
         array(
            'id'       => 'register_success_message',         
            'type'     => 'text',
            'title'    => esc_html__( 'Register Sucess Message','stremlab-core'),
            'default' => esc_html__( 'Congratulations, your account has been successfully created.','stremlab-core'),
            'read-only'=> false,
            'required' => array('pms_enable', '=', array('yes' ,'style-two' ) ) ,
            
        ), 
        
        array(
            'id'       => 'register_back_image',         
            'type'     => 'media',
            'url'      => false,
            'title'    => esc_html__( 'Register Page Background Image','stremlab-core'),
            'read-only'=> false,
            'required' => array('pms_enable', '=', array('yes' ,'style-two' ) ) ,
        ),  

        array(
            'id'       => 'recover_form_title',         
            'type'     => 'text',
            'title'    => esc_html__( 'Recover form Title','stremlab-core'),
            'default' => 'Recover Password',
            'read-only'=> false,
            'required' => array('pms_enable', '=', array('yes' ,'style-two' ) ) ,
        ),

        array(
            'id'       => 'recover_back_image',         
            'type'     => 'media',
            'url'      => false,
            'title'    => esc_html__( 'Recover Password Page Background Image','stremlab-core'),
            'read-only'=> false,
            'required' => array('pms_enable', '=', array('yes' ,'style-two' ) ) ,
            
        ),  

       

    )
));