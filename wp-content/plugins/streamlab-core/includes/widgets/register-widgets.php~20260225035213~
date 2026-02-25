<?php 
namespace Streamlab_Core\Widgets; 
class Register_Sidebar
{

	public function __construct (){
		//add_action( 'widgets_init', array($this,'register_sidebar') );
	}

	public function register_sidebar(){

		register_sidebar( array(
			'name'          => esc_html__( 'Movie Sidebar', 'streamlab-core' ),
			'id'            => 'movie_sidebar',
			'description'   => esc_html__( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'streamlab-core' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );


		register_sidebar( array(
			'name'          => esc_html__( 'Tv Show Sidebar', 'streamlab-core' ),
			'id'            => 'tv_show_sidebar',
			'description'   => esc_html__( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'streamlab-core' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Video Sidebar', 'streamlab-core' ),
			'id'            => 'video_sidebar',
			'description'   => esc_html__( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'streamlab-core' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
	}	
}

new Register_Sidebar;
