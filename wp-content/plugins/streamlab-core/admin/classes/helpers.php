<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
/**
* Streamlab_Core_Import_Panel
*
*
* @class        Streamlab_Core_Import_Panel
* @version      1.0
* @category Class
* @author       PeaceFulThemes
*/
if (!class_exists('Streamlab_Core_Import_Panel')) {
    class Streamlab_Core_Import_Panel{
        /**
        * @access      private
        * @var         \Streamlab_Core_Import_Panel $instance
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
                self::$instance->load_dependancies();
               
                
            }
            return self::$instance;
        }

        public function load_dependancies()
        {
        	add_action('wp_ajax_import_data_from_youtube',          array( $this, 'import_data_from_youtube' ) );
			add_action('wp_ajax_nopriv_import_data_from_youtube',   array( $this, 'import_data_from_youtube' ) );


            add_action('wp_ajax_import_data_from_vimeo',          array( $this, 'import_data_from_vimeo' ) );
            add_action('wp_ajax_nopriv_import_data_from_vimeo',   array( $this, 'import_data_from_vimeo' ) );

            add_action('wp_ajax_import_movie_from_omdb',          array( $this, 'import_movie_from_omdb' ) );
            add_action('wp_ajax_nopriv_import_movie_from_omdb',   array( $this, 'import_movie_from_omdb' ) );

            add_action('wp_ajax_import_search_omdb_data',          array( $this, 'import_search_omdb_data' ) );
            add_action('wp_ajax_nopriv_import_search_omdb_data',   array( $this, 'import_search_omdb_data' ) );

            add_action('wp_ajax_save_api_key',          array( $this, 'save_api_key' ) );
            add_action('wp_ajax_nopriv_save_api_key',   array( $this, 'save_api_key' ) );
			
        }
       public function import_data_from_youtube()
       {
        $response = array();

        try {
            
             if(isset($_POST['response']))
            {
                foreach ($_POST['response'] as $key => $value) {
                     $post_id = wp_insert_post(array(
                        'post_title'    => $value['snippet']['title'],
                        'post_type'     => 'video',
                        'post_content'  => $value['snippet']['description'],
                        'post_status'   => 'publish',
                        'post_date'     =>   $value['snippet']['publishedAt']
                    ));

                    $attach_id =  $this->upload_media_from_url($value['snippet']['thumbnails']['medium']['url'] , $post_id);

                    add_post_meta( $post_id, '_thumbnail_id' , $attach_id );
                    add_post_meta( $post_id, '_video_choice' , 'video_embed' );
                    add_post_meta( $post_id, '_video_embed_content' , '<iframe width="1024" height="574" src="https://www.youtube.com/embed/' . $value['id']['videoId'] . '" allowfullscreen ></iframe>' );
                }
              
            }

            $response = array(
                'code' => 200,
                'messagge' => 'videos are imported',
            );

        }

        
        catch(Exception $e) {
           $response = array(
                'code' => 403,
                'messagge' => 'videos are not imported',
            );
        }
           
           echo json_encode($response);

        
            wp_die();
       }

      public function import_data_from_vimeo()
       {
        $response = array();
            
        try {
            
             if(isset($_POST['response']))
            {
                foreach ($_POST['response'] as $key => $value) {
                     $post_id = wp_insert_post(array(
                        'post_title'    => $value['name'],
                        'post_type'     => 'video',
                        'post_content'  => $value['description'],
                        'post_status'   => 'publish',
                        'post_date'     =>   $value['release_time']
                    ));

                     $position = strpos($value['pictures']['sizes'][8]['link'], "?");

                    $img_url = substr($value['pictures']['sizes'][8]['link'], 0, $position);

                    $attach_id =  $this->upload_media_from_url($img_url , $post_id);

                    add_post_meta( $post_id, '_thumbnail_id' , $attach_id );
                    add_post_meta( $post_id, '_video_choice' , 'video_embed' );
                    add_post_meta( $post_id, '_video_embed_content' , $value['embed']['html'] );
                  
                }
              
            }

            $response = array(
                'code' => 200,
                'messagge' => 'videos are imported',
            );

        }

        
        catch(Exception $e) {
           $response = array(
                'code' => 403,
                'messagge' => 'videos are not imported',
            );
        }
           
           echo json_encode($response);

        
            wp_die();
       }

        public function import_movie_from_omdb()
       {
        $response = array();
            
        try {
            
          
             if(isset($_POST['response']))
            {
                
                
                    $post_id = wp_insert_post(array(
                        'post_title'    => $_POST['response']['Title'],
                        'post_type'     => 'movie',
                        'post_content'  => $_POST['response']['Plot'],
                        'post_status'   => 'publish',
                        'post_date'     =>   date('Y-m-d H:i:s')
                    ));

                     

                    
                    $attach_id =  $this->upload_media_from_url($_POST['response']['Poster'] , $post_id);
                    add_post_meta( $post_id, 'imdb_rating' , $_POST['response']['imdbRating'] );
                    add_post_meta( $post_id, '_thumbnail_id' , $attach_id );
                    add_post_meta( $post_id, '_movie_release_date' , $_POST['response']['Released'] );
                    add_post_meta( $post_id, '_movie_run_time' , $_POST['response']['Runtime'] );
                    add_post_meta( $post_id, '_imdb_id' , $_POST['response']['imdbID'] );
                    add_post_meta( $post_id, 'imdb_rating' , $_POST['response']['imdbRating'] );
                    
                    add_post_meta( $post_id, '_movie_censor_rating' , $_POST['response']['Rated'] );

                    $genre = explode(',' , $_POST['response']['Genre']);
                    $ids = [];
                    foreach ($genre as $key => $value) {
                        if (!term_exists( $value, 'movie_genre') ){
                            $id = wp_insert_term( $value, 'movie_genre' );
                            wp_set_object_terms( $post_id, array($value), 'movie_genre' );
                        }
                    }
                
              
            }

            $response = array(
                'code' => 200,
                'messagge' => 'videos are imported',
            );

        }

        
        catch(Exception $e) {
           $response = array(
                'code' => 403,
                'messagge' => 'videos are not imported',
            );
        }
           
           echo json_encode($response);

        
            wp_die();
       }

       public function import_search_omdb_data()
       {
            $response = array();
            
        try {
            
             if(isset($_POST['response']))
            {
               
            

                foreach ($_POST['response'] as $key => $value) {
                   
                    $res = $this->get_search_omdb_data($value['imdbID']);


                    $body = (array) json_decode($res['body'] , true);

                  

                     $post_id = wp_insert_post(array(
                        'post_title'    => $body['Title'],
                        'post_type'     => 'movie',
                        'post_content'  => $body['Plot'],
                        'post_status'   => 'publish',
                        'post_date'     =>   date('Y-m-d H:i:s')
                    ));

                    $attach_id =  $this->upload_media_from_url($body['Poster'] , $post_id);
                    add_post_meta( $post_id, 'imdb_rating' , $body['imdbRating'] );
                    add_post_meta( $post_id, '_thumbnail_id' , $attach_id );

                    add_post_meta( $post_id, '_movie_release_date' , $body['Released'] );
                    add_post_meta( $post_id, '_movie_run_time' , $body['Runtime'] );
                    add_post_meta( $post_id, '_imdb_id' , $body['imdbID'] );
                    add_post_meta( $post_id, 'imdb_rating' , $body['imdbRating'] );
                    
                    add_post_meta( $post_id, '_movie_censor_rating' , $body['Rated'] );


                  
                }
              
            }

            $response = array(
                'code' => 200,
                'messagge' => 'videos are imported',
            );

        }

        
        catch(Exception $e) {
           $response = array(
                'code' => 403,
                'messagge' => 'videos are not imported',
            );
        }
           
           echo json_encode($response);

        
            wp_die();
       }  

       public function get_search_omdb_data($imdbID)
       {
            $omdb_api_key = get_option( 'gen_omdb_api_key' );
            $url = 'https://www.omdbapi.com/?apikey='.$omdb_api_key.'&i='.$imdbID;

             $request = wp_remote_post( $url, $args );
            if ( is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) !== 200 ) {
                return false;
            }
            return $request;
       }  

       public function save_api_key()
       {
            $response = array();
            try{
                 if(isset($_POST['api_key']))
                 {
                    if(isset($_POST['type']) && $_POST['type'] == 'youtube')
                    {
                        update_option( 'gen_youtube_api_key', $_POST['api_key'] );    
                    }

                    if(isset($_POST['type']) && $_POST['type'] == 'vimoe')
                    {
                        update_option( 'gen_vimoe_api_key', $_POST['api_key'] );    
                    }
                    if(isset($_POST['type']) && $_POST['type'] == 'omdb')
                    {
                        update_option( 'gen_omdb_api_key', $_POST['api_key'] );    
                    }
                }
                $response = array(
                'code' => 200,
                'messagge' => 'Key Saved',
                );
            }
            catch(Exception $e)
            {
                $response = array(
                'code' => 403,
                'messagge' => 'Key Not Saved. Please try again',
                );
            }

             echo json_encode($response);

        
            wp_die();
           

       }

       public function upload_media_from_url($url , $post_id)
       {
             $media = download_url( $url, 10 );

            if ( !is_wp_error( $media ) ) 
            {
                $wp_file_type = wp_check_filetype($media);;
                $args = array(
                    'name'     => basename($url),
                    'type'     => $wp_file_type['type'],
                    'tmp_name' => $media,
                    'error'    => 0,
                    'size'     => filesize($media),
                );

                $attach_id = media_handle_sideload( $args, $post_id);

            if ( is_wp_error( $attach_id ) ) 
            {
                @unlink( $args['tmp_name'] );
                return $attach_id;
            }
            else
            {
                return $attach_id;
            }
        }
       }

       

      
       
        
    }
}
Streamlab_Core_Import_Panel::get_instance();