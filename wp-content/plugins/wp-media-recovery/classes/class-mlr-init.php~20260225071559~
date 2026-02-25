<?php

namespace MLR\Media_Library_Recovery;

! defined( ABSPATH ) || exit;

if ( ! class_exists( 'MLR_Init' ) ) {

	class MLR_Init extends Media_Library_Recovery {

		public function __construct() {
			parent::__construct();
			$this->view = new MLR_View();
		}

		public function init() {
			add_action( 'activated_plugin', array( $this, 'activate_plugin' ) );
			add_action( 'deactivated_plugin', array( $this, 'deactivate_plugin' ) );
			add_action( 'wp_loaded', array( $this, 'on_loaded' ) );
		}

		public function on_loaded() {
			// Rating notices
			add_action( 'admin_notices', array( $this, 'rating_notice_display' ) );
			add_action( 'admin_init', array( $this, 'rating_notice_dismiss' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'localize_plugin_urls' ) );
			add_action( 'admin_init', array( $this, 'add_plugin_links' ) );
			add_submenu_page(
				'upload.php',
				'Media Library Recovery',
				'Library Recovery',
				'manage_options',
				'media-library-recovery',
				array( $this, 'add_plugin_page' )
			);
		}

		public function activate_plugin( $plugin ) {
			if ( $plugin === $this->settings['plugin_basename'] ) {
				$this->activate_media_library_recovery();
			}
		}

		public function deactivate_plugin( $plugin ) {
			if ( $plugin === $this->settings['plugin_basename'] ) {
				$this->deactivate_media_library_recovery();
			}
		}

		public function enqueue_admin_scripts() {
			wp_enqueue_media();
			wp_enqueue_script( 'media-grid' );
			wp_enqueue_script( 'media' );

			if ( true === $this->settings['dev_mode'] ) {
				wp_register_script(
					'media-library-recovery',
					$this->settings['plugin_url'] . 'assets/js/media-library-recovery-init.js',
					array( 'jquery' ),
					'1.0',
					true
				);
				wp_register_style(
					'media-library-recovery',
					$this->settings['plugin_url'] . 'assets/css/media-library-recovery.css',
					array(),
					'1.0',
					'all'
				);
			} else {
				wp_register_script(
					'media-library-recovery',
					$this->settings['plugin_url'] . 'assets/build/js/media-library-recovery.min.js',
					array( 'jquery' ),
					'1.0',
					true
				);
				wp_register_style(
					'media-library-recovery',
					$this->settings['plugin_url'] . 'assets/build/css/media-library-recovery.min.css',
					array(),
					'1.0',
					'all'
				);
			}

			wp_enqueue_script( 'media-library-recovery' );
			wp_enqueue_style( 'media-library-recovery' );
		}

		public function localize_plugin_urls() {
			wp_localize_script(
				'media-library-recovery',
				'mlr',
				array(
					'plugin_url' => $this->settings['plugin_url'],
					'ajax_url'   => admin_url( 'admin-ajax.php' ),
				)
			);
		}

		public function add_plugin_links() {
			add_action( 'plugin_action_links', array( $this, 'add_action_links' ), 10, 2 );
			add_action( 'plugin_row_meta', array( $this, 'add_meta_links' ), 10, 2 );
		}

		public function add_action_links( $links, $file_path ) {
			if ( $file_path === $this->settings['plugin_basename'] ) {
				$links['settings'] = '<a href="' . esc_url( admin_url( 'upload.php?page=media-library-recovery' ) ) . '">Settings</a>';
				return array_reverse( $links );
			}
			return $links;
		}

		public function add_meta_links( $links, $file_path ) {
			if ( $file_path === $this->settings['plugin_basename'] ) {
				$links['docmentation'] = '<a href="' . esc_url( $this->settings['plugin_docurl'] ) . '" target="_blank">Documentation</a>';
			}
			return $links;
		}

		public function add_plugin_page() {
			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die( 'You do not have sufficient permissions to access this page.' );
			}
			$this->view->load_media_explorer();
		}

		// Add temporary plugin options.
		private function activate_media_library_recovery() {
			// Activate plugin for the first time add default permanent options.
			if ( get_option( 'media_library_recovery' ) === false ) {
				add_option( 'media_library_recovery', 1 );
			}
		}

		// Remove temporary plugin options.
		private function deactivate_media_library_recovery() {
			if ( get_option( 'mlr_rating_notice' ) ) {
				delete_option( 'mlr_rating_notice' );
			}
		}
	}

	$mlr = new MLR_Init();
	$mlr->init();
}
