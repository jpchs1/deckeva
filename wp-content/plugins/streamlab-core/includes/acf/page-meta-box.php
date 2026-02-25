<?php
if (function_exists('acf_add_local_field_group')):
    // Page Options
    acf_add_local_field_group(array(
        'key' => 'group_46Cg7N74rVLFfR6',
        'title' => 'Advance Options',
        'fields' => array(
            array(
                'key' => 'field_7a2p3jB7c4cciu',
                'label' => 'Header Options',
                'name' => 'tab_VLFfR6',
                'type' => 'tab',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ) ,
                'placement' => 'left',
                'endpoint' => 0,
            ) ,
           
            
             array(
                'key' => 'field_QnF1Eb565',
                'label' => 'Hide Header',
                'name' => 'hide_header',
                'type' => 'button_group',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'choices' => array(
                            'inherit' => 'inherit',
                            'yes' => 'yes',
                            'no' => 'no',                            
                        ) ,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ) ,
                'message' => '',
                'default_value' => 'inherit',
                'ui' => 1,
                'ui_on_text' => '',
                'ui_off_text' => '',
            ) ,

             array(
                'key' => 'field_7a2p3jB7c4iu',
                'label' => 'Banner Options',
                'name' => 'tab_VLFf45R6',
                'type' => 'tab',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ) ,
                'placement' => 'left',
                'endpoint' => 0,
            ) ,

            array(
                'key' => 'field_QnFE45b565',
                'label' => 'Hide Banner',
                'name' => 'hide_banner',
                'type' => 'button_group',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'choices' => array(
                            'inherit' => 'inherit',
                            'yes' => 'yes',
                            'no' => 'no',                            
                        ) ,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ) ,
                'message' => '',
                'default_value' => 'inherit',
                'ui' => 1,
                'ui_on_text' => '',
                'ui_off_text' => '',
            ) ,

            array(
                'key' => 'field_7a2p3jB7c456iu',
                'label' => 'Footer Options',
                'name' => 'tab_VLFf45R655',
                'type' => 'tab',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ) ,
                'placement' => 'left',
                'endpoint' => 0,
            ) ,

             array(
                'key' => 'field_QnFEb565',
                'label' => 'Hide Footer',
                'name' => 'hide_footer',
                'type' => 'button_group',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'choices' => array(
                            'inherit' => 'inherit',
                            'yes' => 'yes',
                            'no' => 'no',                            
                        ) ,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ) ,
                'message' => '',
                'default_value' => 'inherit',
                'ui' => 1,
                'ui_on_text' => '',
                'ui_off_text' => '',
            ) ,
          

            

            
        ) ,
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page',
                ) ,
            ) ,

            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'post',
                ) ,
            ) ,

             array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'movie',
                ) ,
            ) ,
          
          
        ) ,
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));
    
endif;
