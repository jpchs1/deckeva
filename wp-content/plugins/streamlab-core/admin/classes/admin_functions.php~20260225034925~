<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
/**
* Streamlab_Core_Admin_Functions
*
*
* @class        Streamlab_Core_Admin_Functions
* @version      1.0
* @category Class
* @author       PeaceFulThemes
*/
if (!class_exists('Streamlab_Core_Admin_Functions')) {
    class Streamlab_Core_Admin_Functions{

        public function __construct()
        {
           add_action( 'widgets_init', array($this,'remove_some_widgets'), 11 ); 
           add_action('init', array($this,'add_custom_rewrite_rule'));

           add_action('admin_init', array($this,'add_permalink_settings_field'));
            
        }

        public function add_permalink_settings_field(){
             add_settings_field('movie_archive_page_slug', __('Movie Archive Page', 'txtdomain'), array($this,'movie_permalink_reference_slug_output'), 'permalink', 'optional');
             add_settings_field('tv_show_archive_page_slug', __('Tv show Archive Page', 'txtdomain'), array($this,'tv_show_permalink_reference_slug_output'), 'permalink', 'optional');
             add_settings_field('video_archive_page_slug', __('Video Archive Page', 'txtdomain'), array($this,'video_permalink_reference_slug_output'), 'permalink', 'optional');
              if (isset($_POST['permalink_structure'])) {
                update_option('movie_archive_page_slug', trim($_POST['movie_archive_page_slug']));
                update_option('tv_show_archive_page_slug', trim($_POST['tv_show_archive_page_slug']));
                update_option('video_archive_page_slug', trim($_POST['video_archive_page_slug']));
              }
        }

        public function movie_permalink_reference_slug_output(){
            ?>
                <input name="movie_archive_page_slug" type="text" class="regular-text code" value="<?php echo esc_attr(get_option('movie_archive_page_slug')); ?>" placeholder="Enter Custom Slug" />
               
            <?php
        }
         public function tv_show_permalink_reference_slug_output(){
            ?>               
                <input name="tv_show_archive_page_slug" type="text" class="regular-text code" value="<?php echo esc_attr(get_option('tv_show_archive_page_slug')); ?>" placeholder="Enter Custom Slug" />
               
            <?php
        }
         public function video_permalink_reference_slug_output(){
            ?>
              
                <input name="video_archive_page_slug" type="text" class="regular-text code" value="<?php echo esc_attr(get_option('video_archive_page_slug')); ?>" placeholder="Enter Custom Slug" />
            <?php
        }
        public function add_custom_rewrite_rule() {
   
            if( ($current_rules = get_option('rewrite_rules')) ) {
                
                foreach($current_rules as $key => $val) {
                    if(strpos($key, 'movies') !== false) {
                        if(!empty(get_option('movie_archive_page_slug'))){
                            add_rewrite_rule(str_ireplace('movies', get_option('movie_archive_page_slug'), $key), $val, 'top');
                        }                          
                    }
                    if(strpos($key, 'tv-shows') !== false) {
                        if(!empty(get_option('tv_show_archive_page_slug'))){
                            add_rewrite_rule(str_ireplace('tv-shows', get_option('tv_show_archive_page_slug'), $key), $val, 'top');
                        }                          
                    }
                    if(strpos($key, 'videos') !== false) {
                        if(!empty(get_option('video_archive_page_slug'))){
                            add_rewrite_rule(str_ireplace('videos', get_option('video_archive_page_slug'), $key), $val, 'top');
                        }                          
                    } 
                } 

            }     
            flush_rewrite_rules();
        } 

        public function remove_some_widgets(){ 
            
            //unregister_widget( 'MasVideos_Widget' );
            unregister_widget( 'MasVideos_Widget_Movies_Genres' );
            unregister_widget( 'MasVideos_Widget_Movies_Layered_Nav' );
            unregister_widget( 'MasVideos_Widget_Movies_Genres' );
            unregister_widget( 'MasVideos_Widget_Movies_Rating_Filter' );
            unregister_widget( 'MasVideos_Widget_Movies_Year_Filter' );
            unregister_widget( 'MasVideos_Movies_Widget' );
            unregister_widget( 'MasVideos_Movies_Genres_Filter_Widget' );
            unregister_widget( 'MasVideos_Widget_TV_Shows_Rating_Filter' );
            unregister_widget( 'MasVideos_Widget_TV_Shows_Genres' );
            unregister_widget( 'MasVideos_Widget_TV_Shows_Layered_Nav' );
            unregister_widget( 'MasVideos_TV_Shows_Widget' );
            unregister_widget( 'MasVideos_Widget_Videos_Rating_Filter' );
            unregister_widget( 'MasVideos_Widget_Videos_Categories' );
            unregister_widget( 'MasVideos_Widget_Videos_Layered_Nav' );
            unregister_widget( 'MasVideos_Videos_Widget' );
            unregister_widget( 'MasVideos_Videos_Categories_Filter_Widget' );
            unregister_widget( 'MasVideos_TV_Shows_Genres_Filter_Widget' );
            unregister_widget( 'MasVideos_Movies_Tags_Filter_Widget' );
            unregister_widget( 'MasVideos_TV_Shows_Tags_Filter_Widget' );
            unregister_widget( 'MasVideos_Videos_Tags_Filter_Widget' );
            
            
        }       

        
    }
    new Streamlab_Core_Admin_Functions;
}
