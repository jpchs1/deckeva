<?php
add_action('wp_head', 'streamlab_core_banner_style');
add_action('wp_head', 'streamlab_core_header_style');
add_action('wp_head', 'streamlab_core_top_heder_style');
add_action('wp_head', 'streamlab_core_loader_style');
add_action('wp_head', 'streamlab_core_back_to_top_style');
add_action('wp_head', 'streamlab_core_logo_style');
add_action('wp_head', 'streamlab_core_top_menu_style');
add_action('wp_head', 'streamlab_core_footer_style');
add_action('wp_head', 'streamlab_core_pms_page_data');
add_action('wp_head', 'streamlab_typo');

function streamlab_typo()
{
   $theme_options = get_option('theme_options');
   $inline_css    = '';

   if (isset($theme_options['custom_typo']) && $theme_options['custom_typo'] == 'yes') {
      if ($theme_options['h1_typo']) {
         $typo = $theme_options['h1_typo'];
         if (!empty($typo['font-family'])) {
            $inline_css .= 'font-family:' . $typo['font-family'] . ';';
         }
         if (!empty($typo['text-transform'])) {
            $inline_css .= 'text-transform:' . $typo['text-transform'] . ';';
         }
         if (!empty($typo['font-size'])) {
            $inline_css .= 'font-size:' . $typo['font-size'] . ';';
         }
         wp_register_style('h1-handle', false);
         wp_enqueue_style('h1-handle');

         wp_add_inline_style('h1-handle', 'body h1 { ' . $inline_css . ' }');
          $inline_css    = '';

      }
      if ($theme_options['h2_typo']) {
         $typo = $theme_options['h2_typo'];
         if (!empty($typo['font-family'])) {
            $inline_css .= 'font-family:' . $typo['font-family'] . ';';
         }
         if (!empty($typo['text-transform'])) {
            $inline_css .= 'text-transform:' . $typo['text-transform'] . ';';
         }
         if (!empty($typo['font-size'])) {
            $inline_css .= 'font-size:' . $typo['font-size'] . ';';
         }
         wp_register_style('h2-handle', false);
         wp_enqueue_style('h2-handle');

         wp_add_inline_style('h2-handle', 'body h2 { ' . $inline_css . ' }');
          $inline_css    = '';

      }
      if ($theme_options['h3_typo']) {
         $typo = $theme_options['h3_typo'];
         if (!empty($typo['font-family'])) {
            $inline_css .= 'font-family:' . $typo['font-family'] . ';';
         }
         if (!empty($typo['text-transform'])) {
            $inline_css .= 'text-transform:' . $typo['text-transform'] . ';';
         }
         if (!empty($typo['font-size'])) {
            $inline_css .= 'font-size:' . $typo['font-size'] . ';';
         }
         wp_register_style('h3-handle', false);
         wp_enqueue_style('h3-handle');

         wp_add_inline_style('h3-handle', 'body h3 { ' . $inline_css . ' }');
          $inline_css    = '';

      }
      if ($theme_options['h4_typo']) {
         $typo = $theme_options['h4_typo'];
         if (!empty($typo['font-family'])) {
            $inline_css .= 'font-family:' . $typo['font-family'] . ';';
         }
         if (!empty($typo['text-transform'])) {
            $inline_css .= 'text-transform:' . $typo['text-transform'] . ';';
         }
         if (!empty($typo['font-size'])) {
            $inline_css .= 'font-size:' . $typo['font-size'] . ';';
         }
         wp_register_style('h4-handle', false);
         wp_enqueue_style('h4-handle');

         wp_add_inline_style('h4-handle', 'body h4 { ' . $inline_css . ' }');
          $inline_css    = '';

      }
      if ($theme_options['h5_typo']) {
         $typo = $theme_options['h5_typo'];
         if (!empty($typo['font-family'])) {
            $inline_css .= 'font-family:' . $typo['font-family'] . ';';
         }
         if (!empty($typo['text-transform'])) {
            $inline_css .= 'text-transform:' . $typo['text-transform'] . ';';
         }
         if (!empty($typo['font-size'])) {
            $inline_css .= 'font-size:' . $typo['font-size'] . ';';
         }
         wp_register_style('h5-handle', false);
         wp_enqueue_style('h5-handle');

         wp_add_inline_style('h5-handle', 'body h5 { ' . $inline_css . ' }');
          $inline_css    = '';

      }
      if ($theme_options['h6_typo']) {
         $typo = $theme_options['h6_typo'];
         if (!empty($typo['font-family'])) {
            $inline_css .= 'font-family:' . $typo['font-family'] . ';';
         }
         if (!empty($typo['text-transform'])) {
            $inline_css .= 'text-transform:' . $typo['text-transform'] . ';';
         }
         if (!empty($typo['font-size'])) {
            $inline_css .= 'font-size:' . $typo['font-size'] . ';';
         }
         wp_register_style('h6-handle', false);
         wp_enqueue_style('h6-handle');

         wp_add_inline_style('h6-handle', 'body h6 { ' . $inline_css . ' }');
          $inline_css    = '';
      }
      if ($theme_options['body_typo']) {
         $typo = $theme_options['body_typo'];
         if (!empty($typo['font-family'])) {
            $inline_css .= 'font-family:' . $typo['font-family'] . ';';
         }
         if (!empty($typo['text-transform'])) {
            $inline_css .= 'text-transform:' . $typo['text-transform'] . ';';
         }
         if (!empty($typo['font-size'])) {
            $inline_css .= 'font-size:' . $typo['font-size'] . ';';
         }
         wp_register_style('body-handle', false);
         wp_enqueue_style('body-handle');

         wp_add_inline_style('body-handle', 'body { ' . $inline_css . ' }');
          $inline_css    = '';

      }

      if ($theme_options['mov_tv_vid_typo']) {
         $typo = $theme_options['mov_tv_vid_typo'];
         if (!empty($typo['font-family'])) {
            $inline_css .= 'font-family:' . $typo['font-family'] . ' !important;';
         }
         if (!empty($typo['text-transform'])) {
            $inline_css .= 'text-transform:' . $typo['text-transform'] . ' !important;';
         }
         if (!empty($typo['font-size'])) {
            $inline_css .= 'font-size:' . $typo['font-size'] . ' !important;';
         }
         if (!empty($typo['line-height'])) {
            $inline_css .= 'line-height:' . $typo['line-height'] . ' !important;';
         }
         wp_register_style('mov_tv_vid_typo-handle', false);
         wp_enqueue_style('mov_tv_vid_typo-handle');

         wp_add_inline_style('mov_tv_vid_typo-handle', '.gen-movie-info h3 { ' . $inline_css . ' }');
          $inline_css    = '';

      }
      if ($theme_options['genre_typo']) {

         $typo = $theme_options['genre_typo'];
         if (!empty($typo['font-family'])) {
            $inline_css .= 'font-family:' . $typo['font-family'] . ' !important;';
         }
         if (!empty($typo['text-transform'])) {
            $inline_css .= 'text-transform:' . $typo['text-transform'] . ' !important;';
         }
         if (!empty($typo['font-size'])) {
            $inline_css .= 'font-size:' . $typo['font-size'] . ' !important;';
         }
         if (!empty($typo['line-height'])) {
            $inline_css .= 'line-height:' . $typo['line-height'] . ' !important;';
         }
         wp_register_style('genre_typo-handle', false);
         wp_enqueue_style('genre_typo-handle');

         wp_add_inline_style('genre_typo-handle', '.gen-movie-contain .gen-movie-meta-holder ul li a span { ' . $inline_css . ' }');
          $inline_css    = '';

      }

      if (isset( $theme_options['streamlab_custom_css'] ) && !empty($theme_options['streamlab_custom_css'])) { 

         wp_register_style('streamlab_custom_css-handle', false);
         wp_enqueue_style('streamlab_custom_css-handle');

         wp_add_inline_style('streamlab_custom_css-handle', wp_filter_nohtml_kses( $theme_options['streamlab_custom_css'] ) );

         $inline_css    = '';

      }

   }

}

function streamlab_core_pms_page_data()
{
   $theme_options = get_option('theme_options');
   if (isset($theme_options['login_back_image']) && !empty($theme_options['login_back_image']['url'])) {
      $url   = $theme_options['login_back_image']['url'];
      $title = $theme_options['login_form_title'];
      echo '<div id="gen-login-page-url" data-title="' . $title . '" data-url="' . esc_url($url) . '"></div>';
   }
   if (isset($theme_options['register_back_image']) && !empty($theme_options['register_back_image']['url'])) {
      $url   = $theme_options['register_back_image']['url'];
      $title = $theme_options['register_form_title'];
      echo '<div id="gen-register-page-url" data-title="' . $title . '" data-url="' . esc_url($url) . '"></div>';
   }
   if (isset($theme_options['recover_back_image']) && !empty($theme_options['recover_back_image']['url'])) {
      $url   = $theme_options['recover_back_image']['url'];
      $title = $theme_options['recover_form_title'];
      echo '<div id="gen-recover-page-url" data-title="' . $title . '" data-url="' . esc_url($url) . '"></div>';
   }

}
function streamlab_core_footer_style()
{
   $theme_options = get_option('theme_options');
   $css           = array();

   if (function_exists('get_field') && get_field('field_QnFEb565') != 'inherit') {
      if (get_field('field_QnFEb565') == 'yes') {
         $css[] = array(
            'element'  => 'footer#gen-footer',
            'property' => 'display',
            'value'    => 'none !important',
         );
      }
   }

   if (isset($theme_options['footer_back_opt_switch']) && $theme_options['footer_back_opt_switch'] != 'none') {
      if ($theme_options['footer_back_opt_switch'] == 'image') {
         if (!empty($theme_options['footer_back_img']['url'])) {
            $data  = $theme_options['footer_back_img']['url'];
            $css[] = array(
               'element'  => 'footer#gen-footer',
               'property' => 'background',
               'value'    => 'url(' . $data . ')!important',
            );
         }
      }
      if ($theme_options['footer_back_opt_switch'] == 'color') {
         if (!empty($theme_options['footer_back_color'])) {
            $data  = $theme_options['footer_back_color'];
            $css[] = array(
               'element'  => 'footer#gen-footer',
               'property' => 'background',
               'value'    => $data . '!important',
            );
         }
      }
   }
   if (isset($theme_options['enable_footer_copyright']) && $theme_options['enable_footer_copyright'] == 'no') {
      $css[] = array(
         'element'  => 'footer#gen-footer .gen-copyright-footer',
         'property' => 'display',
         'value'    => 'none !important',
      );
   }
   if (count($css)) {
      streamlab_core_print_css($css);
   }
}
function streamlab_core_top_menu_style()
{
   $theme_options = get_option('theme_options');
   $css           = array();
   if (isset($theme_options['menu_normal_color']) && !empty($theme_options['menu_normal_color'])) {
      $data  = $theme_options['menu_normal_color'];
      $css[] = array(
         'element'  => 'header#gen-header .gen-bottom-header .navbar .navbar-nav li a, header#gen-header .gen-bottom-header .navbar .navbar-nav li i',
         'property' => 'color',
         'value'    => $data . '!important',
      );
   }
   if (isset($theme_options['menu_hover_color']) && !empty($theme_options['menu_hover_color'])) {
      $data  = $theme_options['menu_hover_color'];
      $css[] = array(
         'element'  => 'header#gen-header .gen-bottom-header .navbar .navbar-nav li:hover a , header#gen-header .gen-bottom-header .navbar .navbar-nav li:hover i',
         'property' => 'color',
         'value'    => $data . '!important',
      );
   }
   if (isset($theme_options['menu_active_color']) && !empty($theme_options['menu_active_color'])) {
      $data  = $theme_options['menu_active_color'];
      $css[] = array(
         'element'  => 'header#gen-header .gen-bottom-header .navbar .navbar-nav li.current-menu-item a, header#gen-header .gen-bottom-header .navbar .navbar-nav li.current_page_item a,header#gen-header .gen-bottom-header .navbar .navbar-nav li.current-menu-item i, header#gen-header .gen-bottom-header .navbar .navbar-nav li.current_page_item i',
         'property' => 'color',
         'value'    => $data . '!important',
      );
   }
   // sub menu color
   if (isset($theme_options['sub_menu_normal_color']) && !empty($theme_options['sub_menu_normal_color'])) {
      $data  = $theme_options['sub_menu_normal_color'];
      $css[] = array(
         'element'  => 'header#gen-header .gen-bottom-header .navbar .navbar-nav li .sub-menu li a',
         'property' => 'color',
         'value'    => $data . '!important',
      );
   }
   if (isset($theme_options['sub_menu_hover_color']) && !empty($theme_options['sub_menu_hover_color'])) {
      $data  = $theme_options['sub_menu_hover_color'];
      $css[] = array(
         'element'  => 'header#gen-header .gen-bottom-header .navbar .navbar-nav li .sub-menu li a:hover',
         'property' => 'color',
         'value'    => $data . '!important',
      );
   }
   if (isset($theme_options['sub_menu_active_color']) && !empty($theme_options['sub_menu_active_color'])) {
      $data  = $theme_options['sub_menu_active_color'];
      $css[] = array(
         'element'  => 'header#gen-header .gen-bottom-header .navbar .navbar-nav li .sub-menu li.current-menu-item a',
         'property' => 'color',
         'value'    => $data . '!important',
      );
   }

   if (isset($theme_options['sub_menu_background_color']) && !empty($theme_options['sub_menu_background_color'])) {
      $data  = $theme_options['sub_menu_background_color'];
      $css[] = array(
         'element'  => 'header#gen-header .gen-bottom-header .navbar .navbar-nav li .sub-menu',
         'property' => 'background',
         'value'    => $data . '!important',
      );
   }
   if (isset($theme_options['sub_menu_background_active_color']) && !empty($theme_options['sub_menu_background_active_color'])) {
      $data  = $theme_options['sub_menu_background_active_color'];
      $css[] = array(
         'element'  => 'header#gen-header .gen-bottom-header .navbar .navbar-nav li .sub-menu li.current-menu-item a',
         'property' => 'background',
         'value'    => $data . '!important',
      );
   }
   if (isset($theme_options['sub_menu_background_hover_color']) && !empty($theme_options['sub_menu_background_hover_color'])) {
      $data  = $theme_options['sub_menu_background_hover_color'];
      $css[] = array(
         'element'  => 'header#gen-header .gen-bottom-header .navbar .navbar-nav li .sub-menu li a:hover',
         'property' => 'background',
         'value'    => $data . '!important',
      );
   }
   if (count($css)) {
      streamlab_core_print_css($css);
   }
}
function streamlab_core_logo_style()
{
   $theme_options = get_option('theme_options');
   $css           = array();
   if (isset($theme_options['logo_type'])) {
      if ($theme_options['logo_type'] == 'image') {
         if (!empty($theme_options['logo_url']['url'])) {
            if (!empty($theme_options['logo_dimensions']['height']) && preg_match('~[0-9]+~', $theme_options['logo_dimensions']['height'])) {
               $data = $theme_options['logo_dimensions']['height'];

               $css[] = array(
                  'element'  => '#gen-header img.logo',
                  'property' => 'height',
                  'value'    => $data . '!important',
               );
            }
            if (!empty($theme_options['logo_dimensions']['width']) && preg_match('~[0-9]+~', $theme_options['logo_dimensions']['width'])) {
               $data = $theme_options['logo_dimensions']['width'];

               $css[] = array(
                  'element'  => '#gen-header img.logo',
                  'property' => 'width',
                  'value'    => $data . '!important',
               );
            }

         }
      }
      if ($theme_options['logo_type'] == 'text') {
         if (!empty($theme_options['header_logo_text'])) {
            if (!empty($theme_options['header_logo_color'])) {
               $data  = $theme_options['header_logo_color'];
               $css[] = array(
                  'element'  => '#gen-header .gen-logo-text',
                  'property' => 'color',
                  'value'    => $data . '!important',
               );
            }

         }
      }
   }
   if (count($css)) {
      streamlab_core_print_css($css);
   }

}
function streamlab_core_back_to_top_style()
{
   $theme_options = get_option('theme_options');
   $css           = array();
   if (isset($theme_options['back_to_top'])) {
      if ($theme_options['back_to_top'] == 'no') {

         $css[] = array(
            'element'  => '#back-to-top',
            'property' => 'display',
            'value'    => 'none !important',
         );
      }
      if ($theme_options['back_to_top'] == 'yes') {

         if (!empty($theme_options['back_top_background_color'])) {

            $data  = $theme_options['back_top_background_color'];
            $css[] = array(
               'element'  => '#back-to-top .top',
               'property' => 'background',
               'value'    => $data . '!important',
            );

         }
         if (!empty($theme_options['back_top_background_color_hover'])) {
            $data  = $theme_options['back_top_background_color_hover'];
            $css[] = array(
               'element'  => '#back-to-top .top:hover',
               'property' => 'background',
               'value'    => $data . '!important',
            );
         }
      }

   }
   if (count($css)) {
      streamlab_core_print_css($css);
   }
}
function streamlab_core_loader_style()
{
   $theme_options = get_option('theme_options');
   $css           = array();
   if (!empty($theme_options['loader_background_color'])) {
      $data  = $theme_options['loader_background_color'];
      $css[] = array(
         'element'  => '#gen-loading',
         'property' => 'background',
         'value'    => $data . '!important',
      );
   }
   if (isset($theme_options['loader_switch'])) {
      if ($theme_options['loader_switch'] == 'text') {
         if (!empty($theme_options['loader_text'])) {
            $data  = $theme_options['loader_color'];
            $css[] = array(
               'element'  => '#gen-loading .gen-loader-text',
               'property' => 'color',
               'value'    => $data . '!important',
            );
         }
      }
      if ($theme_options['loader_switch'] == 'image') {

         if (!empty($theme_options['background_loader']['url'])) {
            if (!empty($theme_options['loader_dimensions']['height']) && preg_match('~[0-9]+~', $theme_options['loader_dimensions']['height'])) {
               $data = $theme_options['loader_dimensions']['height'];

               $css[] = array(
                  'element'  => '#gen-loading img',
                  'property' => 'height',
                  'value'    => $data . '!important',
               );
            }
            if (!empty($theme_options['loader_dimensions']['width']) && preg_match('~[0-9]+~', $theme_options['loader_dimensions']['width'])) {
               $data = $theme_options['loader_dimensions']['width'];

               $css[] = array(
                  'element'  => '#gen-loading img',
                  'property' => 'width',
                  'value'    => $data . '!important',
               );
            }

         }
      }
   }
   if (count($css)) {
      streamlab_core_print_css($css);
   }
}
function streamlab_core_banner_style()
{
   $theme_options = get_option('theme_options');
   $css           = array();

   if (function_exists('get_field') && get_field('field_QnFE45b565') != 'inherit') {
      if (get_field('field_QnFE45b565') == 'yes') {

         $css[] = array(
            'element'  => '.gen-breadcrumb',
            'property' => 'display',
            'value'    => 'none !important;',
         );

         $css[] = array(
            'element'  => '.content-area .site-main',
            'property' => 'padding',
            'value'    => '0 !important;',
         );

      }
   } else if (isset($theme_options['enable_banner']) && $theme_options['enable_banner'] == 'no') {
      $css[] = array(
         'element'  => '.gen-breadcrumb',
         'property' => 'display',
         'value'    => 'none !important',
      );
   }
   if (isset($theme_options['display_breadcrumbs']) && $theme_options['display_breadcrumbs'] == 'no') {
      $css[] = array(
         'element'  => '.gen-breadcrumb .gen-breadcrumb-container',
         'property' => 'display',
         'value'    => 'none !important',
      );
   }
   if (isset($theme_options['breadcrumbs_color']) && !empty($theme_options['breadcrumbs_color'])) {
      $data  = $theme_options['breadcrumbs_color'];
      $css[] = array(
         'element'  => '.gen-breadcrumb-container .breadcrumb li a',
         'property' => 'color',
         'value'    => $data . '!important',
      );
   }
   if (isset($theme_options['breadcrumbs_hover_color']) && !empty($theme_options['breadcrumbs_hover_color'])) {
      $data  = $theme_options['breadcrumbs_hover_color'];
      $css[] = array(
         'element'  => '.gen-breadcrumb-container .breadcrumb li a:hover',
         'property' => 'color',
         'value'    => $data . '!important',
      );
   }
   if (isset($theme_options['breadcrumbs_active_color']) && !empty($theme_options['breadcrumbs_active_color'])) {
      $data  = $theme_options['breadcrumbs_active_color'];
      $css[] = array(
         'element'  => '.gen-breadcrumb-container .breadcrumb li.active',
         'property' => 'color',
         'value'    => $data . '!important',
      );
   }
   if (isset($theme_options['breadcrumbs_indicator_color']) && !empty($theme_options['breadcrumbs_indicator_color'])) {
      $data  = $theme_options['breadcrumbs_indicator_color'];
      $css[] = array(
         'element'  => '.gen-breadcrumb-container .breadcrumb .breadcrumb-item + .breadcrumb-item::before',
         'property' => 'color',
         'value'    => $data . '!important',
      );
   }
   if (isset($theme_options['display_title']) && $theme_options['display_title'] == 'no') {
      $css[] = array(
         'element'  => '.gen-breadcrumb .gen-breadcrumb-title',
         'property' => 'display',
         'value'    => 'none !important',
      );
   }
   if (isset($theme_options['title_color']) && !empty($theme_options['title_color'])) {
      $data  = $theme_options['title_color'];
      $css[] = array(
         'element'  => '.gen-breadcrumb-container .breadcrumb li',
         'property' => 'color',
         'value'    => $data . '!important',
      );
   }

   if (isset($theme_options['banner_back_type'])) {
      if ($theme_options['banner_back_type'] == 'color') {
         if (!empty($theme_options['banner_back_color'])) {
            $data  = $theme_options['banner_back_color'];
            $css[] = array(
               'element'  => '.gen-breadcrumb',
               'property' => 'background',
               'value'    => $data . '!important',
            );
         }
      }
      if ($theme_options['banner_back_type'] == 'image') {
         if (!empty($theme_options['banner_image']['url'])) {
            $data  = $theme_options['banner_image']['url'];
            $css[] = array(
               'element'  => '.gen-breadcrumb',
               'property' => 'background-image',
               'value'    => 'url(' . $data . ')!important',
            );
         }
      }
   }
   if (count($css)) {
      streamlab_core_print_css($css);
   }

}
function streamlab_core_header_style()
{
   $theme_options = get_option('theme_options');
   $css           = array();

   if (function_exists('get_field') && get_field('field_QnF1Eb565') != 'inherit') {
      if (get_field('field_QnF1Eb565') == 'yes') {
         $css[] = array(
            'element'  => 'header#gen-header',
            'property' => 'display',
            'value'    => 'none !important',
         );

      }
   }
   if (isset($theme_options['header_back_opt_switch']) && $theme_options['header_back_opt_switch'] != 'none') {
      if ($theme_options['header_back_opt_switch'] == 'image') {
         if (!empty($theme_options['header_back_img']['url'])) {
            $data  = $theme_options['header_back_img']['url'];
            $css[] = array(
               'element'  => 'header .gen-bottom-header',
               'property' => 'background',
               'value'    => 'url(' . $data . ')!important',
            );
         }
      }
      if ($theme_options['header_back_opt_switch'] == 'color') {
         if (!empty($theme_options['header_back_color'])) {
            $data  = $theme_options['header_back_color'];
            $css[] = array(
               'element'  => 'header .gen-bottom-header',
               'property' => 'background',
               'value'    => $data . '!important',
            );
         }
      }
      if ($theme_options['header_back_opt_switch'] == 'transparent') {

         $css[] = array(
            'element'  => 'header .gen-bottom-header',
            'property' => 'background',
            'value'    => 'transparent !important',
         );

      }
      if ($theme_options['header_back_opt_switch'] == 'dark') {

         $css[] = array(
            'element'  => 'header .gen-bottom-header',
            'property' => 'background',
            'value'    => 'black !important',
         );

      }
      if ($theme_options['header_back_opt_switch'] == 'white') {

         $css[] = array(
            'element'  => 'header .gen-bottom-header',
            'property' => 'background',
            'value'    => 'white !important',
         );

      }

   }
   if (isset($theme_options['action_button_color']) && !empty($theme_options['action_button_color'])) {
      $data  = $theme_options['action_button_color'];
      $css[] = array(
         'element'  => 'header#gen-header.gen-header-style-1 .gen-button',
         'property' => 'background',
         'value'    => $data . '!important',
      );
   }
   if (isset($theme_options['header_search_enable']) && $theme_options['header_search_enable'] == 'no') {
      $css[] = array(
         'element'  => '#gen-header .gen-menu-search-block',
         'property' => 'display',
         'value'    => 'none !important',
      );
   }
   if (isset($theme_options['header_action_enable']) && $theme_options['header_action_enable'] == 'no') {
      $css[] = array(
         'element'  => '#gen-header .gen-btn-container',
         'property' => 'display',
         'value'    => 'none !important',
      );
   }

   if (isset($theme_options['header_contact_enable']) && $theme_options['header_contact_enable'] == 'no') {
      $css[] = array(
         'element'  => '#gen-header .gen-header-call',
         'property' => 'display',
         'value'    => 'none !important',
      );
   }
   if (count($css)) {
      streamlab_core_print_css($css);
   }
}
function streamlab_core_top_heder_style()
{
   $theme_options = get_option('theme_options');
   $css           = array();
   if (isset($theme_options['streamlab_core_social_switch'])) {
      if (!$theme_options['streamlab_core_social_switch']) {
         $css[] = array(
            'element'  => 'header .gen-top-header .gen-header-social',
            'property' => 'display',
            'value'    => 'none !important',
         );

      }
   }
   if (isset($theme_options['streamlab_core_contact_switch'])) {
      if (!$theme_options['streamlab_core_contact_switch']) {
         $css[] = array(
            'element'  => 'header .gen-top-header .gen-header-contact',
            'property' => 'display',
            'value'    => 'none !important',
         );

      }
   }
   if (isset($theme_options['top_header_enable'])) {
      if ($theme_options['top_header_enable'] == 'no') {

         $css[] = array(
            'element'  => 'header .gen-top-header',
            'property' => 'display',
            'value'    => 'none !important',
         );

      }
   }
   if (isset($theme_options['top_header_back_type']) && $theme_options['enable_banner'] != 'none') {
      if ($theme_options['top_header_back_type'] == 'image') {
         if (!empty($theme_options['top_header_back_img']['url'])) {
            $data  = $theme_options['top_header_back_img']['url'];
            $css[] = array(
               'element'  => 'header .gen-top-header',
               'property' => 'background',
               'value'    => 'url(' . $data . ')!important',
            );
         }
      }
      if ($theme_options['top_header_back_type'] == 'color') {
         if (!empty($theme_options['top_header_back_color'])) {
            $data  = $theme_options['top_header_back_color'];
            $css[] = array(
               'element'  => 'header .gen-top-header',
               'property' => 'background',
               'value'    => $data . '!important',
            );
         }
      }
      if ($theme_options['top_header_back_type'] == 'transparent') {

         $css[] = array(
            'element'  => 'header .gen-top-header',
            'property' => 'background',
            'value'    => 'transparent !important',
         );

      }
      if ($theme_options['top_header_back_type'] == 'dark') {

         $css[] = array(
            'element'  => 'header .gen-top-header',
            'property' => 'background',
            'value'    => 'black !important',
         );

      }
      if ($theme_options['top_header_back_type'] == 'white') {

         $css[] = array(
            'element'  => 'header .gen-top-header',
            'property' => 'background',
            'value'    => 'white !important',
         );

      }
      if (isset($theme_options['top_header_text_color']) && !empty($theme_options['top_header_text_color'])) {
         $data  = $theme_options['top_header_text_color'];
         $css[] = array(
            'element'  => 'header .gen-top-header ul li a',
            'property' => 'color',
            'value'    => $data . '!important',
         );
      }
      if (isset($theme_options['top_header_text_hover_color']) && !empty($theme_options['top_header_text_hover_color'])) {
         $data  = $theme_options['top_header_text_hover_color'];
         $css[] = array(
            'element'  => 'header .gen-top-header ul li a:hover',
            'property' => 'color',
            'value'    => $data . '!important',
         );
      }
      if (isset($theme_options['top_header_icon_color']) && !empty($theme_options['top_header_icon_color'])) {
         $data  = $theme_options['top_header_icon_color'];
         $css[] = array(
            'element'  => 'header .gen-top-header ul li i',
            'property' => 'color',
            'value'    => $data . '!important',
         );
      }
      if (isset($theme_options['top_header_icon_hover_color']) && !empty($theme_options['top_header_icon_hover_color'])) {
         $data  = $theme_options['top_header_icon_hover_color'];
         $css[] = array(
            'element'  => 'header .gen-top-header ul li i:hover',
            'property' => 'color',
            'value'    => $data . '!important',
         );
      }

   }
   if (count($css)) {
      streamlab_core_print_css($css);
   }
}
function streamlab_core_print_css($css)
{
   $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
   $id         = substr(str_shuffle(md5($str_result)), 0, 5);

   echo '<style id="streamlab-custom-style-' . $id . '">';
   foreach ($css as $val) {
      if (!empty($val['element'])) {
         echo "\n" . esc_attr($val['element']) . "{\n";
         echo esc_attr($val['property']) . ":" . esc_attr($val['value']) . ";\n";
         echo "}\n\n";
      }

   }
   echo '</style>';
}
