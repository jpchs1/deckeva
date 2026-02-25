<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
/**
* Streamlab_Core_Helper
*
*
* @class        Streamlab_Core_Helper
* @version      1.0
* @category Class
* @author       PeaceFulThemes
*/
if (!class_exists('Streamlab_Core_Helper')) {
    class Streamlab_Core_Helper{
        /**
        * @access      private
        * @var         \Streamlab_Core_Helper $instance
        * @since       3.0.0
        */
        private static $instance;
        /**
        * Get active instance
        *
        * @access      public
        * @since       3.1.3
        * @return      self::$instance
        */
        // Shim since we changed the function name. Deprecated.
        public static function get_instance() {
            if ( ! self::$instance ) {
                self::$instance = new self;
                self::$instance->hooks();
            }
            return self::$instance;
        }
        private function hooks(){
            add_action( 'admin_menu', array( $this, 'theme_panel_admin_menu' ));
            
            
        }
        public function theme_panel_admin_menu(){
            if(Gtech_Theme_Helper::gtech_purchase_verify())
            {
                $icon_path = 'dashicons-format-video';
            }  
            else
            {
               $icon_path =  'dashicons-format-video';
            }
            add_menu_page (
                esc_html__('Import Videos', 'streamlab-core'),
                esc_html__('Import Videos', 'streamlab-core'), 
                'manage_options', // capability
                'gentech-import-panel',  // menu-slug
                array( $this, 'theme_panel_welcome_render' ),   // function that will render its output
                $icon_path,    // link to the icon that will be displayed in the sidebar
                2    // position of the menu option
            );
            $submenu = array();
            $submenu[] = array(
                esc_html__('Welcome', 'streamlab-core'),    //page_title
                esc_html__('Welcome', 'streamlab-core'),    //menu_title
                'manage_options',                               //capability
                'gentech-import-panel',                          //menu_slug
                array( $this, 'theme_panel_welcome_render' ),   // function that will render its output
            );
            $submenu[] = array(
                esc_html__('Youtube video Importer', 'streamlab-core'),   //page_title
                esc_html__('Youtube video Importer', 'streamlab-core'),   //menu_title
                'edit_posts',                           //capability
                'gentech-youtube',             //menu_slug
                array( $this, 'youtube_import' ),       // function that will render its output
            );
             $submenu[] = array(
                esc_html__('Vimeo Video Importor', 'streamlab-core'),   //page_title
                esc_html__('Vimeo Video Importor', 'streamlab-core'),   //menu_title
                'edit_posts',                          //capability
                'gentech-vimeo',                   //menu_slug
                array( $this, 'vimeo_import' ),       // function that will render its output
            ); 
             $submenu[] = array(
                esc_html__('Omdb Importor', 'streamlab-core'),   //page_title
                esc_html__('Omdb Importor', 'streamlab-core'),   //menu_title
                'edit_posts',                          //capability
                'gentech-omdb',                   //menu_slug
                array( $this, 'omdb_import' ),       // function that will render its output
            );    
              
            $submenu = apply_filters('Gtech_panel_submenu', array( $submenu ) );
            foreach ($submenu[0] as $key => $value) {
                add_submenu_page(
                    'gentech-import-panel',               //parent menu slug
                    $value[0],                           //page_title
                    $value[1],                           //menu_title
                    $value[2],                           //capability
                    $value[3],                           //menu_slug
                    $value[4]                            //function that will render its output
                );
            }
        }
        public function dashboard_menu_tab(){
            global $submenu;
            $menu_items = '';
            if (isset($submenu['gentech-import-panel'])):
              $menu_items = $submenu['gentech-import-panel'];
            endif;
            if (!empty($menu_items)) : 
            ?>
              <div class="wrap gentech-wrapper-notify">
                <div class="nav-tab-wrapper">
                  <?php foreach ($menu_items as $item): 
                    $class = isset($_GET['page']) && $_GET['page'] == $item[2] ? ' nav-tab-active' : '';
                    ?>
                    <a href="<?php echo esc_url(admin_url('admin.php?page='.$item[2].''));?>" 
                        class="nav-tab<?php echo esc_attr($class);?>"
                    >
                        <?php echo esc_html($item[0]); ?>
                    </a>
                  <?php endforeach; ?>
                </div>
              </div> 
            <?php endif;             
        }
        public function theme_panel_welcome_render(){
            $this->dashboard_menu_tab();
            /**
             * Template View Welcome
             */
            require_once plugin_dir_path( __FILE__  )  . 'template/tpl_welcome.php';
        }
          
        public function youtube_import(){
            $this->dashboard_menu_tab();
             /**
             * Template View Plugin
             */
            
            require_once plugin_dir_path( __FILE__  ) . 'template/tpl_youtube.php';
        }     

         public function vimeo_import(){
            $this->dashboard_menu_tab();
            /**
             * Template View Plugin
             */
            require_once plugin_dir_path( __FILE__  ) . 'template/tpl_vimeo.php';
        }   

         public function omdb_import(){
            $this->dashboard_menu_tab();
            /**
             * Template View Plugin
             */
            require_once plugin_dir_path( __FILE__  ) . 'template/tpl_omdb.php';
        }          
       

       
        
    }
}
Streamlab_Core_Helper::get_instance();