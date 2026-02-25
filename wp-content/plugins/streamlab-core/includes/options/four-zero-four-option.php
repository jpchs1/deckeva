<?php
/*
 * 404 Options
 */
$options;
Redux::setSection( $options, array(
    'title' => esc_html__('404','streamlab-core'),
    'id'    => 'fourzerofour-section',
    'icon'  => 'el-icon-error',
    'desc'  => esc_html__('This section contains options for 404.','streamlab-core'),
    'fields'=> array(

        array(
            'id'       => 'streamlab_404_banner_image',         
            'type'     => 'media',
            'url'      => true,
            'title'    => esc_html__( '404 Page Default Banner Image','streamlab-core'),
            'read-only'=> false,
            'subtitle' => esc_html__( 'Upload banner image for your Website. Otherwise blank field will be displayed in place of this section.','streamlab-core'),
        ),

        array(
            'id'        => 'streamlab_fourzerofour_title',
            'type'      => 'text',
            'title'     => esc_html__( '404 Page Title','streamlab-core'),
            'default'   => esc_html__( '404 Error','streamlab-core' )
        ),
        array(
            'id'        => 'streamlab_four_description',
            'type'      => 'textarea',
            'title'     => esc_html__( '404 Page Description','streamlab-core'),
            'default'   => esc_html__( 'Oops! This Page is Not Found.','streamlab-core' )
        ),
    )) 
);
?>