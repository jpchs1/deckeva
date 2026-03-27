<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );

if ( !function_exists( 'chld_thm_cfg_parent_css' ) ):
    function chld_thm_cfg_parent_css() {
        wp_enqueue_style( 'chld_thm_cfg_parent', trailingslashit( get_template_directory_uri() ) . 'style.css', array( 'the7-admin-bar','dt-main','the7-font','the7-awesome-fonts' ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'chld_thm_cfg_parent_css', 30 );

// END ENQUEUE PARENT ACTION

/**
 * Add Open Graph meta tags for search engines and social media previews.
 * Provides a default OG image for all pages, including the homepage.
 */
function deckeva_og_meta_tags() {
	// Default OG image for the site.
	$og_image_url = 'https://deckeva.com/wp-content/uploads/2023/08/pisos-antideslizante.jpg';
	$og_image_alt = 'DECKEVA pisos antideslizantes para embarcaciones';

	// Determine title, description, URL, and type based on the current page.
	if ( is_front_page() || is_home() ) {
		$og_title       = get_bloginfo( 'name' ) . ' — ' . get_bloginfo( 'description' );
		$og_description = 'Pisos antideslizantes de EVA para embarcaciones. Diseño personalizado, envío a todo el mundo.';
		$og_url         = home_url( '/' );
		$og_type        = 'website';
	} elseif ( is_singular() ) {
		global $post;
		if ( ! $post ) {
			return;
		}
		setup_postdata( $post );
		$og_title       = get_the_title();
		$og_description = has_excerpt() ? get_the_excerpt() : wp_trim_words( strip_tags( $post->post_content ), 30 );
		$og_url         = get_the_permalink();
		$og_type        = 'article';

		// Use the post's featured image if available.
		$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
		if ( ! empty( $thumbnail[0] ) ) {
			$og_image_url = $thumbnail[0];
		}
	} else {
		$og_title       = wp_get_document_title();
		$og_description = get_bloginfo( 'description' );
		$og_url         = home_url( $_SERVER['REQUEST_URI'] );
		$og_type        = 'website';
	}

	echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '" />' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( $og_title ) . '" />' . "\n";
	echo '<meta property="og:description" content="' . esc_attr( $og_description ) . '" />' . "\n";
	echo '<meta property="og:url" content="' . esc_url( $og_url ) . '" />' . "\n";
	echo '<meta property="og:type" content="' . esc_attr( $og_type ) . '" />' . "\n";
	echo '<meta property="og:image" content="' . esc_url( $og_image_url ) . '" />' . "\n";
	echo '<meta property="og:image:alt" content="' . esc_attr( $og_image_alt ) . '" />' . "\n";
	echo '<meta property="og:locale" content="es_CL" />' . "\n";
	echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
	echo '<meta name="twitter:title" content="' . esc_attr( $og_title ) . '" />' . "\n";
	echo '<meta name="twitter:description" content="' . esc_attr( $og_description ) . '" />' . "\n";
	echo '<meta name="twitter:image" content="' . esc_url( $og_image_url ) . '" />' . "\n";
}

// Remove the theme's default OG tags to avoid duplicates.
remove_action( 'wp_head', 'presscore_opengraph_tags' );

// Add our custom OG tags.
add_action( 'wp_head', 'deckeva_og_meta_tags', 5 );
