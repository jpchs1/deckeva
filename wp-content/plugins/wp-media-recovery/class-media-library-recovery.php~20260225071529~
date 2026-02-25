<?php
/**
 * Plugin Name: Media Library Recovery
 * Plugin URI: https://krasenslavov.com/plugins/wp-media-recovery
 * Description: A tool that helps you to recover older and existing images from your <code>/wp-content/uploads</code> folder after database reset.
 * Version: 1.3.3
 * Author: Krasen Slavov
 * Author URI: https://krasenslavov.com/
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: media-library-recovery
 * Domain Path: /lang
 *
 * Copyright 2018-2022 Krasen Slavov (email: hello@krasenslavov.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

namespace MLR\Media_Library_Recovery;

! defined( ABSPATH ) || exit;

if ( ! class_exists( 'Media_Library_Recovery' ) ) {

	class Media_Library_Recovery {

		const DEV_MODE         = false;
		const VERSION          = '1.3.3';
		const PHP_MIN_VERSION  = '7.2';
		const WP_MIN_VERSION   = '5.0';
		const UUID             = 'mlr';
		const TEXTDOMAIN       = 'media-library-recovery';
		const PLUGIN_NAME      = 'Media Library Recovery';
		const PLUGIN_DOCURL    = 'https://krasenslavov.com/plugins/media-library-recovery/';
		const PLUGIN_WPORGURL  = 'https://wordpress.org/support/plugin/wp-media-recovery/';
		const PLUGIN_WPORGRATE = 'https://wordpress.org/support/plugin/wp-media-recovery/reviews/?filter=5';
		const ALLOWED_HTML_ARR = array(
			'br'     => array(),
			'strong' => array(),
			'small'  => array(),
			'em'     => array(),
			'a'      => array(
				'href'   => array(),
				'target' => array(),
				'name'   => array(),
			),
		);

		protected $settings;

		public function __construct() {
			$this->settings = array(
				'dev_mode'         => self::DEV_MODE,
				'version'          => self::VERSION,
				'php_min_version'  => self::PHP_MIN_VERSION,
				'wp_min_version'   => self::WP_MIN_VERSION,
				'uuid'             => self::UUID,
				'textdomain'       => self::TEXTDOMAIN,
				'plugin_name'      => self::PLUGIN_NAME,
				'plugin_docurl'    => self::PLUGIN_DOCURL,
				'plugin_wporgurl'  => self::PLUGIN_WPORGURL,
				'plugin_wporgrate' => self::PLUGIN_WPORGRATE,
				'allowed_html_arr' => self::ALLOWED_HTML_ARR,
				'plugin_url'       => plugin_dir_url( __FILE__ ),
				'plugin_basename'  => plugin_basename( __FILE__ ),
				'plugin_path'      => plugin_dir_path( __FILE__ ),
			);

			if ( $this->check_dependencies() ) {
				load_plugin_textdomain( $this->settings['textdomain'], false, $this->settings['plugin_basename'] . 'lang' );
			}
		}

		public function rating_notice_display() {
			if ( ! get_option( 'mlr_rating_notice' ) ) {
				?>
					<?php if ( did_action( 'elementor/loaded' ) ) : ?>
						<div class="notice notice-info is-dismissible">
							<h3>
								<?php esc_html_e( 'Search & Replace for Elementor', $this->settings['textdomain'] ); ?>
							</h3>
							<p>
								<?php 
									printf( 
										wp_kses( 
											__( 'Since you have <em>Elementor</em> installed you might want to check one of our other free plugins, <a href="https://wordpress.org/plugins/search-replace-for-elementor/" target="_blank"><strong>Search & Replace for Elementor</strong></a>.', $this->settings['textdomain'] ), 
											$this->settings['allowed_html_arr']
										)
									); 
								?>
							</p>
							<p>
								<a href="https://wordpress.org/plugins/search-replace-for-elementor/" target="_blank" class="button button-primary">
									<?php esc_html_e( 'Learn More', $this->settings['textdomain'] ); ?>
								</a>
								<a href="<?php echo admin_url( 'plugins.php?mlr_rating_notice_dismiss' ); ?>" class="button">
									<strong><?php esc_html_e( 'Don\'t show this notice again!', $this->settings['textdomain'] ); ?></strong>
								</a>
							</p>
						</div>
					<?php endif; ?>
					<div class="notice notice-success is-dismissible">
						<h3>
							<?php esc_html_e( 'Media Library Recovery', $this->settings['textdomain'] ); ?>
						</h3>
						<p>
						<?php esc_html_e( 'Could you please kindly help the plugin in your turn by giving it 5 stars rating? (Thank you in advance)', $this->settings['textdomain'] ); ?>
						</p>
						<p>
							<a href="<?php echo esc_url( $this->settings['plugin_wporgrate'] ); ?>" target="_blank" class="button button-primary">
								<?php esc_html_e( 'Rate Us', $this->settings['textdomain'] ); ?>
							</a>
							<a href="<?php echo admin_url( 'plugins.php?mlr_rating_notice_dismiss' ); ?>" class="button">
								<strong><?php esc_html_e( 'I already did', $this->settings['textdomain'] ); ?></strong>
							</a>
							<a href="<?php echo admin_url( 'plugins.php?mlr_rating_notice_dismiss' ); ?>" class="button">
								<strong><?php esc_html_e( 'Don\'t show this notice again!', $this->settings['textdomain'] ); ?></strong>
							</a>
						</p>
					</div>
				<?php
			}
		}

		public function rating_notice_dismiss() {
			if ( isset( $_GET['mlr_rating_notice_dismiss'] ) ) {
				add_option( 'mlr_rating_notice', 1 );
			}
		}

		public function check_dependencies() {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';

			if ( version_compare( PHP_VERSION, $this->settings['php_min_version'] ) >= 0
				&& version_compare( $GLOBALS['wp_version'], $this->settings['wp_min_version'] ) >= 0 ) {
				$check = true;
			} else {
				$check = false;
				add_action( 'admin_notices', array( $this, 'display_min_requirements_notice' ) );
			}

			if ( $check ) {
				return true;
			}

			deactivate_plugins( $this->settings['plugin_basename'] );

			return false;
		}

		public function display_min_requirements_notice() {
			?>
				<div class="notice notice-error">
					<p>
						<?php
							printf(
								wp_kses(
									__( '<strong>%1$s</strong> requires a minimum of <em>PHP %2$s</em> and <em>WordPress %3$s</em>.', $this->settings['textdomain'] ),
									$this->settings['allowed_html_arr']
								),
								$this->settings['plugin_name'],
								$this->settings['php_min_version'],
								$this->settings['wp_min_version']

							);
						?>
					</p>
					<p>
						<?php
							printf(
								wp_kses(
									__( 'You are currently running <strong>PHP %1$s</strong> and <strong>WordPress %2$s</strong>.', $this->settings['textdomain'] ),
									$this->settings['allowed_html_arr']
								),
								PHP_VERSION,
								$GLOBALS['wp_version']
							);
						?>
					</p>
				</div>
			<?php
		}
	}

	new Media_Library_Recovery();

	// Core
	require_once 'classes/core/class-mlr-view.php';

	// Init
	require_once 'classes/class-mlr-init.php';

	// Events
	require_once 'classes/events/class-mlr-explorer.php';
	require_once 'classes/events/class-mlr-recover.php';
}
