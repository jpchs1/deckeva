<?php

namespace MLR\Media_Library_Recovery;

! defined( ABSPATH ) || exit;

if ( ! class_exists( 'MLR_Recover' ) ) {

	class MLR_Recover extends Media_Library_Recovery {

		public function __construct() {
			parent::__construct();
		}

		public function init() {
			add_action( 'wp_loaded', array( $this, 'on_loaded' ) );
		}

		public function on_loaded() {
			add_action( 'wp_ajax_recover_media_library', array( $this, 'recover_media_library' ) );
		}

		public function recover_media_library() {
			$sanitized_images = $_REQUEST['images']; // array_map( 'esc_url_raw', $_REQUEST['images'] );
			$selected_images  = json_decode( str_replace( '\\', '', $sanitized_images ) );

			if ( is_array( $selected_images ) ) {
				foreach ( $selected_images as $selected_image_url ) {
					if ( null !== $selected_image_url ) {
						$image_urls[] = esc_url( $selected_image_url );
					}
				}
				$this->rebuild_media_library( $image_urls );
				echo 1;
				exit;
			}
			echo 0;
			exit;
		}

		private function rebuild_media_library( $image_urls ) {
			foreach ( $image_urls as $image_url ) {
				if ( ! empty( $image_url ) ) {
					$image_partials = pathinfo( $image_url );
					$upload_dir     = wp_upload_dir();
					$abs_filepath   = str_replace( home_url( '/' ), ABSPATH, $image_url ); // absolute path
					$rel_filepath   = str_replace( $upload_dir['basedir'] . '/', '', $abs_filepath ); // relative path

					$attachment = array(
						'guid'           => $image_url, // image basename
						'post_mime_type' => 'image/' . $image_partials['extension'], // image extension
						'post_title'     => ucwords( str_replace( '-', ' ', $image_partials['filename'] ) ),
						'post_content'   => '',
						'post_status'    => 'inherit',
					);

					$attachment_id = wp_insert_attachment( $attachment, $rel_filepath );

					if ( ! is_wp_error( $attachment_id ) ) {
						require_once ABSPATH . 'wp-admin/includes/image.php';
						require_once ABSPATH . 'wp-admin/includes/media.php';
						$attach_data = wp_generate_attachment_metadata( $attachment_id, $abs_filepath );
						wp_update_attachment_metadata( $attachment_id, $attach_data );
					}
				}
			}
		}
	}

	$mlr = new MLR_Recover();
	$mlr->init();
}
