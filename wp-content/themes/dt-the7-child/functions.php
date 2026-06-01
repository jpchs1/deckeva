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
 */
function deckeva_cross_domain_backlinks() {
    ?>
    <div id="cross-domain-links" style="background:#111827;border-top:1px solid rgba(255,255,255,0.1);padding:30px 20px;text-align:center;">
        <div style="max-width:1200px;margin:0 auto;">
            <p style="color:#a0aec0;font-size:0.9rem;margin-bottom:12px;font-weight:600;">Nuestras Empresas &amp; Partners</p>
            <div style="display:flex;flex-wrap:wrap;gap:12px 32px;justify-content:center;">
                <a href="https://www.imporlan.cl/" target="_blank" rel="noopener" style="color:#718096;text-decoration:none;font-size:0.85rem;transition:color 0.3s;">Importación de lanchas desde USA</a>
                <a href="https://www.deckeva.com/" target="_blank" rel="noopener" style="color:#718096;text-decoration:none;font-size:0.85rem;transition:color 0.3s;">Deckeva Internacional</a>
                <a href="https://www.muelleflotante.cl/" target="_blank" rel="noopener" style="color:#718096;text-decoration:none;font-size:0.85rem;transition:color 0.3s;">Muelles flotantes en Chile</a>
                <a href="https://www.nauticalacustre.cl/" target="_blank" rel="noopener" style="color:#718096;text-decoration:none;font-size:0.85rem;transition:color 0.3s;">Náutica Lacustre - Pucón &amp; Villarrica</a>
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
            "https://www.muelleflotante.cl",
            "https://www.nauticalacustre.cl"
        ]
    }
    </script>
    <?php
}
add_action( 'wp_footer', 'deckeva_cross_domain_backlinks', 99 );

/**
 * Strategic Partners section – displayed only on the home/front page.
 * Renders above the footer with SEO-optimized structured data.
 */
function deckeva_strategic_partners_section() {
    if ( ! is_front_page() && ! is_home() ) return;
    ?>
    <style>
    .deckeva-partners{background:linear-gradient(135deg,#0f2240 0%,#1a365d 100%);padding:70px 20px;text-align:center}
    .deckeva-partners__inner{max-width:1100px;margin:0 auto}
    .deckeva-partners__badge{display:inline-block;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.15);border-radius:20px;padding:6px 18px;font-size:.8rem;color:#90cdf4;letter-spacing:1.5px;text-transform:uppercase;margin-bottom:16px}
    .deckeva-partners h2{color:#fff;font-size:2rem;margin:0 0 10px;font-weight:700}
    .deckeva-partners__sub{color:#a0aec0;font-size:1.05rem;margin:0 0 45px;max-width:650px;margin-left:auto;margin-right:auto;line-height:1.6}
    .deckeva-partners__grid{display:grid;grid-template-columns:repeat(3,1fr);gap:28px}
    @media(max-width:768px){.deckeva-partners__grid{grid-template-columns:1fr;gap:20px}.deckeva-partners h2{font-size:1.5rem}}
    .deckeva-partner-card{background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.1);border-radius:16px;padding:36px 28px;transition:transform .3s,border-color .3s,box-shadow .3s;text-decoration:none;display:flex;flex-direction:column;align-items:center}
    .deckeva-partner-card:hover{transform:translateY(-6px);border-color:rgba(144,205,244,.4);box-shadow:0 12px 40px rgba(0,0,0,.3)}
    .deckeva-partner-card__logo{height:70px;max-width:200px;object-fit:contain;margin-bottom:20px;filter:brightness(1.1)}
    .deckeva-partner-card__logo--svg{width:60px;height:60px;margin-bottom:20px}
    .deckeva-partner-card h3{color:#fff;font-size:1.15rem;margin:0 0 6px;font-weight:600}
    .deckeva-partner-card__loc{color:#90cdf4;font-size:.82rem;margin:0 0 14px;font-weight:500}
    .deckeva-partner-card p{color:#a0aec0;font-size:.92rem;line-height:1.55;margin:0 0 18px;text-align:center}
    .deckeva-partner-card__link{color:#63b3ed;font-size:.85rem;font-weight:600;letter-spacing:.3px;margin-top:auto}
    .deckeva-partner-card:hover .deckeva-partner-card__link{color:#90cdf4}
    </style>

    <section class="deckeva-partners" aria-label="Partners Estratégicos">
        <div class="deckeva-partners__inner">
            <span class="deckeva-partners__badge">Red de Confianza</span>
            <h2>Partners Estrat&eacute;gicos</h2>
            <p class="deckeva-partners__sub">Trabajamos junto a las mejores empresas del sector n&aacute;utico y de infraestructura lacustre en Chile para ofrecer soluciones integrales de calidad.</p>

            <div class="deckeva-partners__grid">

                <a href="https://www.imporlan.cl/" target="_blank" rel="noopener" class="deckeva-partner-card" title="Imporlan - Importadora de lanchas y botes en Santiago, Chile">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" class="deckeva-partner-card__logo--svg" aria-hidden="true"><rect width="48" height="48" rx="8" fill="#0a1628"/><g transform="translate(6, 5)" fill="none" stroke="#00d4ff" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 31c1 .8 2 1.5 4 1.5 3.5 0 3.5-3 7-3 2 0 3 .7 4 1.5 1 .8 2 1.5 4 1.5 3.5 0 3.5-3 7-3 2 0 3 .7 4 1.5"/><path d="M29 29.5A17 17 0 0 0 31.5 20L18 14 4.5 20a17 17 0 0 0 4 11.5"/><path d="M28 19V10a3 3 0 0 0-3-3H11a3 3 0 0 0-3 3v9"/><path d="M18 14v6"/></g></svg>
                    <h3>Imporlan</h3>
                    <p class="deckeva-partner-card__loc">Santiago, Chile</p>
                    <p>Importadora l&iacute;der de lanchas, botes y embarcaciones desde Estados Unidos. Amplio cat&aacute;logo de embarcaciones nuevas y usadas con env&iacute;o a todo Chile.</p>
                    <span class="deckeva-partner-card__link">Visitar imporlan.cl &rarr;</span>
                </a>

                <a href="https://www.muelleflotante.cl/" target="_blank" rel="noopener" class="deckeva-partner-card" title="MuelleFlotante - Muelles flotantes modulares en Santiago, Chile">
                    <img src="/assets/partners/muelleflotante-logo.png" alt="MuelleFlotante - Muelles flotantes modulares Chile" class="deckeva-partner-card__logo" width="501" height="255" loading="lazy">
                    <h3>MuelleFlotante</h3>
                    <p class="deckeva-partner-card__loc">Santiago, Chile</p>
                    <p>Especialistas en dise&ntilde;o, fabricaci&oacute;n e instalaci&oacute;n de muelles flotantes modulares para lagos, r&iacute;os y marinas en todo Chile.</p>
                    <span class="deckeva-partner-card__link">Visitar muelleflotante.cl &rarr;</span>
                </a>

                <a href="https://www.nauticalacustre.cl/" target="_blank" rel="noopener" class="deckeva-partner-card" title="Náutica Lacustre - Servicios náuticos en Pucón y Villarrica, Chile">
                    <img src="/assets/partners/nauticalacustre-logo.jpg" alt="Náutica Lacustre - Servicios náuticos Pucón y Villarrica Chile" class="deckeva-partner-card__logo" width="500" height="299" loading="lazy">
                    <h3>N&aacute;utica Lacustre</h3>
                    <p class="deckeva-partner-card__loc">Puc&oacute;n &amp; Villarrica, Chile</p>
                    <p>Servicios n&aacute;uticos especializados en la zona lacustre del sur de Chile. Arriendo, mantenci&oacute;n y asesor&iacute;a para embarcaciones en lagos y r&iacute;os.</p>
                    <span class="deckeva-partner-card__link">Visitar nauticalacustre.cl &rarr;</span>
                </a>

            </div>
        </div>
    </section>

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "ItemList",
        "name": "Partners Estratégicos de DECKEVA",
        "description": "Red de empresas asociadas del sector náutico y lacustre en Chile",
        "numberOfItems": 3,
        "itemListElement": [
            {
                "@type": "ListItem",
                "position": 1,
                "item": {
                    "@type": "Organization",
                    "name": "Imporlan",
                    "url": "https://www.imporlan.cl/",
                    "logo": "https://www.imporlan.cl/images/imporlan-favicon.svg",
                    "description": "Importadora de lanchas y embarcaciones desde USA en Santiago, Chile",
                    "address": {
                        "@type": "PostalAddress",
                        "addressLocality": "Santiago",
                        "addressCountry": "CL"
                    }
                }
            },
            {
                "@type": "ListItem",
                "position": 2,
                "item": {
                    "@type": "Organization",
                    "name": "MuelleFlotante",
                    "url": "https://www.muelleflotante.cl/",
                    "logo": "https://muelleflotante.cl/wp-content/uploads/2023/08/logo-muelle-flotante-menu.png",
                    "description": "Diseño, fabricación e instalación de muelles flotantes modulares en Chile",
                    "address": {
                        "@type": "PostalAddress",
                        "addressLocality": "Santiago",
                        "addressCountry": "CL"
                    }
                }
            },
            {
                "@type": "ListItem",
                "position": 3,
                "item": {
                    "@type": "Organization",
                    "name": "Náutica Lacustre",
                    "url": "https://www.nauticalacustre.cl/",
                    "logo": "https://www.nauticalacustre.cl/wp-content/uploads/2025/09/logo-01.jpg",
                    "description": "Servicios náuticos especializados en la zona lacustre de Pucón y Villarrica, Chile",
                    "address": {
                        "@type": "PostalAddress",
                        "addressLocality": "Pucón",
                        "addressRegion": "Araucanía",
                        "addressCountry": "CL"
                    }
                }
            }
        ]
    }
    </script>
    <?php
}
add_action( 'wp_footer', 'deckeva_strategic_partners_section', 90 );

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
