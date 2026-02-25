<?php

namespace MLR\Media_Library_Recovery;

! defined( ABSPATH ) || exit;

if ( ! class_exists( 'MLR_Explorer' ) ) {

	class MLR_Explorer extends Media_Library_Recovery {

		public function __construct() {
			parent::__construct();
		}

		public function init() {
			add_action( 'wp_loaded', array( $this, 'on_loaded' ) );
		}

		public function on_loaded() {
			add_action( 'admin_init', array( $this, 'media_explorer' ) );
		}

		public function media_explorer() {
			// Pagination.
			$current_page = 1;

			if ( array_key_exists( 'p', $_REQUEST ) ) {
				$current_page = sanitize_text_field( $_REQUEST['p'] );
			}

			$has_recover_media = false;
			$results_per_page  = 20;
			$results_counter   = 0;
			$results_from      = ( 0 === $current_page ) ? 1 : ( $current_page * $results_per_page ) - $results_per_page;
			$results_to        = $current_page * $results_per_page;

			// WP upload directory and files.
			$images         = $this->get_upload_dir_contents();
			$upload_dir     = wp_upload_dir();
			$upload_baseurl = $upload_dir['baseurl'];
			$upload_basedir = $upload_dir['basedir'];
			$html_output    = '';

			foreach ( $images as $image_var ) {
				$has_recover_media = true;
				$results_counter++;

				if ( $results_counter >= $results_from
					&& $results_counter <= $results_to ) {

						// Get image thumbnail URL.
					foreach ( $image_var as $dimension => $image_data ) {
						$image_thumbnail_url = $upload_baseurl . '' . str_replace( $upload_basedir, '', $image_data[0] ) . '/' . $image_data[1];
						// if ( preg_match( '/(150|300)/', $dimension ) ) {}
					}

					if ( array_key_exists( 'parent', $image_var ) ) {
						$image_url = $upload_baseurl . '' . str_replace( $upload_basedir, '', $image_var['parent'][0] ) . '/' . $image_var['parent'][1];

						if ( ! $image_thumbnail_url ) {
							$image_thumbnail_url = $image_url;
						}

						if ( ! $this->has_attachment( $image_url ) ) {
							$html_output .= "<div class=\"mlr-media-thumbnail\"><label><input type=\"checkbox\" name=\"images[]\" value=\"{$image_url}\" data-selected=\"0\" /><img src=\"{$image_thumbnail_url}\" alt=\"\" /> <i class=\"dashicons dashicons-hidden\"></i></label></div>";
						} else {
							$html_output .= "<div class=\"mlr-media-thumbnail in-library\"><img src=\"{$image_thumbnail_url}\" alt=\"\" /> <i class=\"dashicons dashicons-visibility\"></i></div>";
						}
					}
				}
			}

			if ( $current_page > ceil( sizeof( $images ) / 20 ) ) {
				$has_recover_media = false;
			}

			if ( ! $has_recover_media ) {
				$html_output .= '<p><strong>No results found.</strong><br />Go back to the previous page.</p>';
			}

			return $html_output;
		}

		private function get_upload_dir_contents() {
			$contents   = array();
			$upload_dir = wp_upload_dir();

			$iterator = new \RecursiveDirectoryIterator( $upload_dir['basedir'] );

			foreach ( new \RecursiveIteratorIterator( $iterator ) as $path ) {
				if ( @is_array( getimagesize( $path ) ) ) {
					$path_parts = pathinfo( $path ); // path partials

					// Add resized and cropped versions of the media file.
					if ( preg_match( '/\d+x\d+$/i', $path_parts['filename'], $matches ) ) {
						$parent_file_name = str_replace( '-' . $matches[0], '', $path_parts['filename'] );

						$contents[ $parent_file_name ][ $matches[0] ] = @array(
							$path_parts['dirname'],
							$path_parts['basename'],
							$path_parts['extension'],
							$path,
						);
					} else {
						// Add the originally uploaded media file.
						$contents[ $path_parts['filename'] ]['parent'] = @array(
							$path_parts['dirname'],
							$path_parts['basename'],
							$path_parts['extension'],
							$path,
						);
					}
				}
			}
			return $contents;
		}

		private function has_attachment( $url ) {
			global $wpdb;
			$url = str_replace( '\\', '/', $url );
			$sql = $wpdb->prepare( "SELECT ID FROM {$wpdb->posts} WHERE guid = %s", $url );
			if ( $wpdb->get_results( $sql ) ) {
				return true;
			}
			return false;
		}
	}
}
