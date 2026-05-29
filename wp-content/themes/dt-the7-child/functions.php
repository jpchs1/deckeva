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
 * Cross-domain backlinks SEO - Nuestras Empresas
 * Adds visible footer links to partner sites for SEO cross-linking
 */
function deckeva_cross_domain_backlinks() {
    ?>
    <div id="cross-domain-links" style="background:#111827;border-top:1px solid rgba(255,255,255,0.1);padding:30px 20px;text-align:center;">
        <div style="max-width:1200px;margin:0 auto;">
            <p style="color:#a0aec0;font-size:0.9rem;margin-bottom:12px;font-weight:600;">Nuestras Empresas</p>
            <div style="display:flex;flex-wrap:wrap;gap:12px 32px;justify-content:center;">
                <a href="https://www.imporlan.cl/" target="_blank" rel="noopener" style="color:#718096;text-decoration:none;font-size:0.85rem;transition:color 0.3s;">Importación de lanchas desde USA</a>
                <a href="https://www.deckeva.com/" target="_blank" rel="noopener" style="color:#718096;text-decoration:none;font-size:0.85rem;transition:color 0.3s;">Deckeva Internacional</a>
                <a href="https://www.muelleflotante.cl/" target="_blank" rel="noopener" style="color:#718096;text-decoration:none;font-size:0.85rem;transition:color 0.3s;">Muelles flotantes en Chile</a>
            </div>
        </div>
    </div>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "DECKEVA Chile",
        "url": "https://www.deckeva.cl",
        "sameAs": [
            "https://www.deckeva.com",
            "https://www.imporlan.cl",
            "https://www.muelleflotante.cl"
        ]
    }
    </script>
    <?php
}
add_action( 'wp_footer', 'deckeva_cross_domain_backlinks', 99 );

/**
 * DECKEVA favicons / web-app icons.
 *
 * Outputs the authoritative brand icon set (boat emblem) served from the site
 * root, so the favicon shows consistently in browser tabs, Google search
 * results, iOS home screen, Android and Windows tiles across every
 * WordPress-rendered page (blog, categorías, productos, etc.). The default
 * WordPress Site Icon output is removed to avoid a competing/older favicon.
 */
function deckeva_remove_default_site_icon() {
    remove_action( 'wp_head', 'wp_site_icon', 99 );
}
add_action( 'init', 'deckeva_remove_default_site_icon' );

function deckeva_favicons() {
    echo '
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="48x48" href="/favicon-48x48.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="manifest" href="/site.webmanifest">
    <meta name="msapplication-TileColor" content="#0f2240">
    <meta name="msapplication-config" content="/browserconfig.xml">
    <meta name="theme-color" content="#0f2240">
';
}
add_action( 'wp_head', 'deckeva_favicons', 2 );
