<?php
/**
 * Plugin Name: Deckeva Blog Carousel
 * Description: Converts the blog loop grid into a Swiper carousel
 * Version: 1.0
 */

if (!defined('ABSPATH')) exit;

add_action('wp_enqueue_scripts', function() {
    if (!is_front_page() && !is_home()) return;
    
    $swiper_css = plugins_url('elementor/assets/lib/swiper/v8/css/swiper.min.css');
    $swiper_js = plugins_url('elementor/assets/lib/swiper/v8/swiper.min.js');
    
    wp_enqueue_style('swiper-v8', $swiper_css, [], '8.0');
    wp_enqueue_script('swiper-v8', $swiper_js, [], '8.0', true);
});

add_action('wp_head', function() {
    if (!is_front_page() && !is_home()) return;
    ?>
    <style>
    .elementor-element-19c407ea .elementor-widget-container {
        position: relative;
        overflow: visible !important;
    }
    .elementor-element-19c407ea .blog-carousel-wrapper {
        position: relative;
        padding: 0 60px;
    }
    .elementor-element-19c407ea .elementor-loop-container.elementor-grid {
        display: flex !important;
        flex-wrap: nowrap !important;
        overflow: hidden !important;
    }
    .elementor-element-19c407ea .swiper {
        overflow: hidden;
        padding-bottom: 0;
    }
    .elementor-element-19c407ea .swiper-wrapper {
        display: flex !important;
        flex-wrap: nowrap !important;
        align-items: flex-start;
    }
    .elementor-element-19c407ea .swiper-slide {
        height: auto !important;
        flex-shrink: 0;
        box-sizing: border-box;
    }
    .elementor-element-19c407ea .swiper-slide > div,
    .elementor-element-19c407ea .swiper-slide > section,
    .elementor-element-19c407ea .swiper-slide .e-loop-item {
        width: 100% !important;
        max-width: 100% !important;
        box-sizing: border-box;
    }
    .elementor-element-19c407ea .swiper-slide .e-loop-item,
    .elementor-element-19c407ea .swiper-slide .elementor-section-wrap,
    .elementor-element-19c407ea .swiper-slide .elementor-top-section,
    .elementor-element-19c407ea .swiper-slide .elementor-top-section > .elementor-container {
        height: auto !important;
    }
    .elementor-element-1502efa3 {
        display: none !important;
    }
    .blog-carousel-prev,
    .blog-carousel-next {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #884A39;
        color: #fff;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(136,74,57,0.3);
        z-index: 10;
    }
    .blog-carousel-prev {
        left: 0;
    }
    .blog-carousel-next {
        right: 0;
    }
    .blog-carousel-prev:hover,
    .blog-carousel-next:hover {
        background: #6d3a2d;
        transform: translateY(-50%) scale(1.1);
        box-shadow: 0 4px 12px rgba(136,74,57,0.4);
    }
    .blog-carousel-prev svg,
    .blog-carousel-next svg {
        width: 20px;
        height: 20px;
        fill: none;
        stroke: currentColor;
        stroke-width: 2.5;
        stroke-linecap: round;
        stroke-linejoin: round;
    }
    .blog-carousel-pagination-wrap {
        display: flex;
        justify-content: center;
        margin-top: 12px;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    .elementor-element-19c407ea {
        margin-bottom: 0 !important;
        padding-bottom: 0 !important;
    }
    .elementor-element-22e604cc {
        padding-bottom: 15px !important;
    }
    .elementor-element-22e604cc > .elementor-container {
        margin-bottom: 0 !important;
    }
    .blog-carousel-pagination {
        display: flex;
        gap: 8px;
        align-items: center;
    }
    .blog-carousel-pagination .swiper-pagination-bullet {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #ccc;
        opacity: 1;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .blog-carousel-pagination .swiper-pagination-bullet-active {
        background: #884A39;
        width: 28px;
        border-radius: 5px;
    }
    @media (max-width: 767px) {
        .elementor-element-19c407ea .blog-carousel-wrapper {
            padding: 0 45px;
        }
        .blog-carousel-prev,
        .blog-carousel-next {
            width: 36px;
            height: 36px;
        }
    }

    /* ── FOOTER IMPROVEMENTS ── */
    .elementor-element-4bd1af6 {
        background: linear-gradient(135deg, #5C3D2E 0%, #884A39 50%, #6d3a2d 100%) !important;
        padding: 50px 0 40px !important;
        position: relative;
    }
    .elementor-element-4bd1af6::before {
        content: '';
        position: absolute;
        top: 0;
        left: 5%;
        right: 5%;
        height: 3px;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    }
    .elementor-element-4bd1af6 > .elementor-container {
        align-items: flex-start !important;
    }
    .elementor-element-4bd1af6 .elementor-column {
        padding: 0 20px !important;
    }
    .elementor-element-ef73903 img {
        max-width: 200px !important;
        filter: brightness(1.1);
        transition: filter 0.3s ease;
    }
    .elementor-element-ef73903 img:hover {
        filter: brightness(1.3);
    }
    .elementor-element-324b93d0 {
        margin-top: 15px !important;
    }
    .elementor-element-324b93d0 p,
    .elementor-element-324b93d0 .elementor-widget-container {
        color: rgba(255,255,255,0.75) !important;
        font-size: 14px !important;
        line-height: 1.7 !important;
        letter-spacing: 0.2px;
    }
    .elementor-element-5163a1af .elementor-widget-container,
    .elementor-element-1598a0b8 .elementor-widget-container {
        text-align: center !important;
    }
    .elementor-element-5163a1af .elementor-heading-title,
    .elementor-element-1598a0b8 .elementor-heading-title {
        color: #fff !important;
        font-size: 18px !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        letter-spacing: 1.5px !important;
        padding-bottom: 12px !important;
        margin-bottom: 10px !important;
        position: relative;
        display: inline-block;
    }
    .elementor-element-5163a1af .elementor-heading-title::after,
    .elementor-element-1598a0b8 .elementor-heading-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 40px;
        height: 2px;
        background: #D4956A;
        border-radius: 1px;
    }
    .elementor-element-5a6846b1 .elementor-widget-wrap {
        text-align: center !important;
    }
    .elementor-element-6e52ba1d .elementor-nav-menu--main {
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        width: 100% !important;
    }
    .elementor-element-6e52ba1d .elementor-nav-menu--layout-vertical {
        width: 100% !important;
    }
    .elementor-element-6e52ba1d .elementor-widget-container,
    .elementor-element-6e52ba1d nav {
        width: 100% !important;
    }
    .elementor-element-6e52ba1d ul.sm-vertical {
        width: 100% !important;
    }
    .elementor-element-6e52ba1d .elementor-nav-menu--main li {
        text-align: center !important;
        margin-bottom: 2px !important;
        width: 100% !important;
    }
    .elementor-element-6e52ba1d .elementor-nav-menu--main .elementor-item {
        color: rgba(255,255,255,0.8) !important;
        font-size: 15px !important;
        padding: 4px 0 !important;
        transition: all 0.3s ease !important;
        text-align: center !important;
        justify-content: center !important;
        display: block !important;
    }
    .elementor-element-6e52ba1d .elementor-nav-menu--main .elementor-item:hover {
        color: #fff !important;
    }
    .elementor-element-6e52ba1d .elementor-nav-menu .elementor-item.elementor-item-active {
        color: #fff !important;
    }
    .elementor-element-c8b6fce .elementor-icon-box-title,
    .elementor-element-6f03f61 .elementor-icon-box-title,
    .elementor-element-50d0c325 .elementor-icon-box-title {
        color: rgba(255,255,255,0.9) !important;
        font-size: 14px !important;
    }
    .elementor-element-c8b6fce .elementor-icon-box-description,
    .elementor-element-6f03f61 .elementor-icon-box-description,
    .elementor-element-50d0c325 .elementor-icon-box-description {
        color: rgba(255,255,255,0.75) !important;
        font-size: 14px !important;
    }
    .elementor-element-c8b6fce .elementor-icon-box-wrapper,
    .elementor-element-6f03f61 .elementor-icon-box-wrapper,
    .elementor-element-50d0c325 .elementor-icon-box-wrapper {
        transition: transform 0.3s ease;
    }
    .elementor-element-c8b6fce .elementor-icon-box-wrapper:hover,
    .elementor-element-6f03f61 .elementor-icon-box-wrapper:hover,
    .elementor-element-50d0c325 .elementor-icon-box-wrapper:hover {
        transform: translateX(4px);
    }
    .elementor-element-c8b6fce .elementor-icon i,
    .elementor-element-c8b6fce .elementor-icon svg,
    .elementor-element-6f03f61 .elementor-icon i,
    .elementor-element-6f03f61 .elementor-icon svg,
    .elementor-element-50d0c325 .elementor-icon i,
    .elementor-element-50d0c325 .elementor-icon svg {
        color: #D4956A !important;
        fill: #D4956A !important;
    }
    .elementor-element-c8b6fce,
    .elementor-element-6f03f61,
    .elementor-element-50d0c325 {
        margin-bottom: 8px !important;
    }
    .elementor-element-2ac5009a {
        background: #3E2723 !important;
        padding: 15px 0 !important;
        border-top: 1px solid rgba(255,255,255,0.1) !important;
    }
    .elementor-element-afb6b16 p,
    .elementor-element-afb6b16 .elementor-widget-container {
        color: rgba(255,255,255,0.5) !important;
        font-size: 13px !important;
        letter-spacing: 0.5px !important;
        text-align: center !important;
    }
    @media (max-width: 767px) {
        .elementor-element-4bd1af6 {
            padding: 35px 0 30px !important;
        }
        .elementor-element-4bd1af6 .elementor-column {
            margin-bottom: 25px !important;
            text-align: center !important;
        }
        .elementor-element-5163a1af .elementor-heading-title::after,
        .elementor-element-1598a0b8 .elementor-heading-title::after {
            left: 50%;
            transform: translateX(-50%);
        }
        .elementor-element-6e52ba1d .elementor-nav-menu--main .elementor-item::before {
            display: none;
        }
    }

    /* ── CONTACT FORM SECTION MODERNIZATION ── */
    .elementor-element-295091b5 {
        background: linear-gradient(180deg, #f8f4f1 0%, #ffffff 100%) !important;
        padding: 60px 0 !important;
    }
    .elementor-element-295091b5 > .elementor-container > .elementor-column > .elementor-widget-wrap {
        background: #ffffff !important;
        border-radius: 20px !important;
        box-shadow: 0 8px 40px rgba(136,74,57,0.1), 0 2px 12px rgba(0,0,0,0.04) !important;
        padding: 50px 60px 45px !important;
        max-width: 680px !important;
        margin: 0 auto !important;
        border: 1px solid rgba(136,74,57,0.08) !important;
    }
    .elementor-element-131bb619 {
        margin-bottom: 10px !important;
    }
    .elementor-element-51c58585 .elementor-heading-title {
        color: #884A39 !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        letter-spacing: 2.5px !important;
        text-transform: uppercase !important;
        margin-bottom: 8px !important;
    }
    .elementor-element-becb6d1 .elementor-heading-title {
        font-size: 28px !important;
        font-weight: 700 !important;
        line-height: 1.3 !important;
        margin-bottom: 8px !important;
    }
    .elementor-element-3ef5a951 {
        margin-bottom: 25px !important;
    }
    .elementor-element-3ef5a951 p,
    .elementor-element-3ef5a951 .elementor-widget-container {
        color: #6b7280 !important;
        font-size: 15px !important;
        line-height: 1.6 !important;
    }
    .elementor-element-76ecd7a1 .wpcf7 {
        max-width: 100% !important;
    }
    .elementor-element-76ecd7a1 fieldset {
        border: none !important;
        padding: 0 !important;
        margin: 0 !important;
    }
    .elementor-element-76ecd7a1 fieldset > label {
        font-size: 14px !important;
        font-weight: 600 !important;
        color: #374151 !important;
        letter-spacing: 0.3px !important;
        margin-bottom: 10px !important;
        display: block !important;
        background: none !important;
        padding: 0 !important;
        border-radius: 0 !important;
    }
    .elementor-element-76ecd7a1 select,
    .elementor-element-76ecd7a1 .wpcf7-form-control.wpcf7-select {
        width: 100% !important;
        padding: 14px 18px !important;
        border: 2px solid #e5e7eb !important;
        border-radius: 12px !important;
        font-size: 15px !important;
        color: #884A39 !important;
        background-color: #f9fafb !important;
        transition: all 0.3s ease !important;
        -webkit-appearance: none !important;
        -moz-appearance: none !important;
        appearance: none !important;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23884A39' d='M6 8L1 3h10z'/%3E%3C/svg%3E") !important;
        background-repeat: no-repeat !important;
        background-position: right 16px center !important;
        cursor: pointer !important;
        opacity: 1 !important;
        -webkit-text-fill-color: #884A39 !important;
        font-weight: 500 !important;
    }
    .elementor-element-76ecd7a1 select.has-value,
    .elementor-element-76ecd7a1 .wpcf7-form-control.wpcf7-select.has-value {
        color: #374151 !important;
        -webkit-text-fill-color: #374151 !important;
        font-weight: 400 !important;
    }
    .elementor-element-76ecd7a1 select option {
        color: #374151 !important;
        background-color: #fff !important;
        font-size: 15px !important;
        padding: 10px !important;
    }
    .elementor-element-76ecd7a1 select:hover {
        border-color: #D4956A !important;
    }
    .elementor-element-76ecd7a1 select:focus {
        border-color: #884A39 !important;
        box-shadow: 0 0 0 3px rgba(136,74,57,0.12) !important;
        outline: none !important;
        background-color: #fff !important;
    }
    .elementor-element-76ecd7a1 .wpcf7-form-control-wrap + p:not(:has(input[type="submit"])):not(:has(button)) {
        font-size: 13px !important;
        text-align: center !important;
        margin-top: 12px !important;
        background: linear-gradient(135deg, #884A39, #D4956A) !important;
        color: #fff !important;
        padding: 10px 20px !important;
        border-radius: 10px !important;
        font-weight: 500 !important;
    }
    .elementor-element-76ecd7a1 fieldset > p:has(input[type="submit"]),
    .elementor-element-76ecd7a1 fieldset > p:has(button[name="cf7mls_back"]) {
        background: none !important;
        background-color: transparent !important;
        padding: 0 !important;
        margin: 0 !important;
        border-radius: 0 !important;
    }
    .elementor-element-76ecd7a1 input[type="text"],
    .elementor-element-76ecd7a1 input[type="email"],
    .elementor-element-76ecd7a1 input[type="tel"],
    .elementor-element-76ecd7a1 input[type="number"],
    .elementor-element-76ecd7a1 textarea,
    .elementor-element-76ecd7a1 .wpcf7-text,
    .elementor-element-76ecd7a1 .wpcf7-email,
    .elementor-element-76ecd7a1 .wpcf7-tel {
        width: 100% !important;
        padding: 14px 18px !important;
        border: 2px solid #e5e7eb !important;
        border-radius: 12px !important;
        font-size: 15px !important;
        color: #374151 !important;
        background-color: #f9fafb !important;
        transition: all 0.3s ease !important;
        outline: none !important;
        box-sizing: border-box !important;
    }
    .elementor-element-76ecd7a1 input[type="text"]:hover,
    .elementor-element-76ecd7a1 input[type="email"]:hover,
    .elementor-element-76ecd7a1 input[type="tel"]:hover,
    .elementor-element-76ecd7a1 input[type="number"]:hover,
    .elementor-element-76ecd7a1 textarea:hover {
        border-color: #D4956A !important;
    }
    .elementor-element-76ecd7a1 input[type="text"]:focus,
    .elementor-element-76ecd7a1 input[type="email"]:focus,
    .elementor-element-76ecd7a1 input[type="tel"]:focus,
    .elementor-element-76ecd7a1 input[type="number"]:focus,
    .elementor-element-76ecd7a1 textarea:focus {
        border-color: #884A39 !important;
        box-shadow: 0 0 0 3px rgba(136,74,57,0.12) !important;
        background-color: #fff !important;
    }
    .elementor-element-76ecd7a1 fieldset label {
        font-size: 14px !important;
        font-weight: 600 !important;
        color: #374151 !important;
        letter-spacing: 0.3px !important;
        margin-bottom: 8px !important;
        display: block !important;
    }
    .elementor-element-76ecd7a1 .wpcf7-acceptance {
        display: block !important;
        background: #f0fdf4 !important;
        border: 1px solid #bbf7d0 !important;
        border-radius: 12px !important;
        padding: 16px 20px !important;
        margin: 15px 0 !important;
    }
    .elementor-element-76ecd7a1 .wpcf7-acceptance .wpcf7-list-item-label {
        font-size: 14px !important;
        color: #374151 !important;
        line-height: 1.5 !important;
    }
    .elementor-element-76ecd7a1 .wpcf7-acceptance input[type="checkbox"] {
        width: 20px !important;
        height: 20px !important;
        accent-color: #884A39 !important;
        margin-right: 10px !important;
        border-radius: 4px !important;
        vertical-align: middle !important;
    }
    .elementor-element-76ecd7a1 .wpcf7-recaptcha,
    .elementor-element-76ecd7a1 .g-recaptcha {
        margin: 15px 0 !important;
        display: flex !important;
        justify-content: center !important;
    }
    .elementor-element-76ecd7a1 .cf7mls_progress_bar {
        display: none !important;
    }
    .elementor-element-76ecd7a1 button[name="cf7mls_next"] {
        background: linear-gradient(135deg, #884A39, #a0583f) !important;
        color: #fff !important;
        border: none !important;
        padding: 14px 40px !important;
        border-radius: 12px !important;
        font-size: 16px !important;
        font-weight: 600 !important;
        letter-spacing: 0.5px !important;
        cursor: pointer !important;
        transition: all 0.3s ease !important;
        display: block !important;
        margin: 20px auto 0 !important;
        box-shadow: 0 4px 15px rgba(136,74,57,0.3) !important;
        float: none !important;
    }
    .elementor-element-76ecd7a1 button[name="cf7mls_next"]:hover {
        background: linear-gradient(135deg, #6d3a2d, #884A39) !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 20px rgba(136,74,57,0.4) !important;
    }
    .elementor-element-76ecd7a1 input[type="submit"] {
        background: #fff !important;
        color: #884A39 !important;
        border: 2px solid #884A39 !important;
        padding: 14px 50px !important;
        border-radius: 12px !important;
        font-size: 16px !important;
        font-weight: 700 !important;
        letter-spacing: 1px !important;
        text-transform: uppercase !important;
        cursor: pointer !important;
        transition: all 0.3s ease !important;
        display: block !important;
        margin: 20px auto 0 !important;
        box-shadow: none !important;
        float: none !important;
        width: auto !important;
        max-width: 280px !important;
    }
    .elementor-element-76ecd7a1 input[type="submit"]:hover {
        background: #884A39 !important;
        color: #fff !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 15px rgba(136,74,57,0.3) !important;
    }
    .elementor-element-76ecd7a1 button[name="cf7mls_back"] {
        background: transparent !important;
        color: #884A39 !important;
        border: 1px solid #e5e7eb !important;
        padding: 10px 24px !important;
        border-radius: 10px !important;
        font-size: 14px !important;
        font-weight: 500 !important;
        cursor: pointer !important;
        transition: all 0.3s ease !important;
        margin-top: 10px !important;
    }
    .elementor-element-76ecd7a1 button[name="cf7mls_back"]:hover {
        border-color: #884A39 !important;
        background: rgba(136,74,57,0.05) !important;
    }
    @media (max-width: 767px) {
        .elementor-element-295091b5 > .elementor-container > .elementor-column > .elementor-widget-wrap {
            padding: 30px 25px !important;
            border-radius: 16px !important;
            margin: 0 15px !important;
        }
        .elementor-element-becb6d1 .elementor-heading-title {
            font-size: 22px !important;
        }
        .elementor-element-76ecd7a1 button[name="cf7mls_next"],
        .elementor-element-76ecd7a1 input[type="submit"] {
            width: 100% !important;
            max-width: 100% !important;
        }
    }
    </style>
    <?php
});

add_action('wp_footer', function() {
    if (!is_front_page() && !is_home()) return;
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var formSelect = document.querySelector('.elementor-element-76ecd7a1 select[name="menu-size"]');
        if (formSelect && formSelect.options.length > 0) {
            formSelect.options[0].text = 'Selecciona el tamaño Aquí \u25B6';
            formSelect.options[0].value = '';
            formSelect.addEventListener('change', function() {
                if (formSelect.selectedIndex > 0) {
                    formSelect.classList.add('has-value');
                } else {
                    formSelect.classList.remove('has-value');
                }
            });
        }

        setTimeout(function() {
            var gridEl = document.querySelector('.elementor-element-19c407ea');
            if (!gridEl) return;

            var container = gridEl.querySelector('.elementor-loop-container.elementor-grid');
            if (!container) return;

            var items = Array.from(container.children);
            if (items.length < 2) return;

            var widgetContainer = gridEl.querySelector('.elementor-widget-container');

            var swiperEl = document.createElement('div');
            swiperEl.className = 'swiper blog-carousel-swiper';

            var wrapperEl = document.createElement('div');
            wrapperEl.className = 'swiper-wrapper';

            items.forEach(function(item) {
                item.style.width = '100%';
                item.style.maxWidth = '100%';
                var slide = document.createElement('div');
                slide.className = 'swiper-slide';
                slide.appendChild(item);
                wrapperEl.appendChild(slide);
            });

            swiperEl.appendChild(wrapperEl);

            var wrapperDiv = document.createElement('div');
            wrapperDiv.className = 'blog-carousel-wrapper';

            var prevBtn = '<button class="blog-carousel-prev" aria-label="Anterior"><svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg></button>';
            var nextBtn = '<button class="blog-carousel-next" aria-label="Siguiente"><svg viewBox="0 0 24 24"><polyline points="9 6 15 12 9 18"></polyline></svg></button>';
            container.parentNode.replaceChild(wrapperDiv, container);
            wrapperDiv.appendChild(swiperEl);
            wrapperDiv.insertAdjacentHTML('beforeend', prevBtn + nextBtn);
            wrapperDiv.insertAdjacentHTML('beforeend', '<div class="blog-carousel-pagination-wrap"><div class="blog-carousel-pagination"></div></div>');

            var parentCol = gridEl.closest('.elementor-column');
            if (parentCol) {
                parentCol.style.paddingBottom = '0';
                parentCol.style.display = '';
            }
            var parentSection = gridEl.closest('.elementor-section');
            if (parentSection) {
                parentSection.style.paddingBottom = '15px';
            }
            var verMasWidget = document.querySelector('.elementor-element-1502efa3');
            if (verMasWidget) verMasWidget.style.display = 'none';

            new Swiper('.blog-carousel-swiper', {
                slidesPerView: 1,
                spaceBetween: 20,
                loop: true,
                autoHeight: true,
                autoplay: {
                    delay: 4500,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true
                },
                speed: 600,
                grabCursor: true,
                pagination: {
                    el: '.blog-carousel-pagination',
                    clickable: true,
                    type: 'bullets'
                },
                navigation: {
                    nextEl: '.blog-carousel-next',
                    prevEl: '.blog-carousel-prev'
                },
                breakpoints: {
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 24
                    },
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 28
                    }
                }
            });
        }, 500);
    });
    </script>
    <?php
});
