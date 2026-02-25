<?php

namespace MLR\Media_Library_Recovery;

! defined( ABSPATH ) || exit;

if ( ! class_exists( 'MLR_View' ) ) {

	require_once WP_PLUGIN_DIR . '/wp-media-recovery/classes/events/class-mlr-explorer.php';

	class MLR_View extends Media_Library_Recovery {

		public function __construct() {
			parent::__construct();
			$this->explorer = new MLR_Explorer();
		}

		public function load_media_explorer() {
			?>
				<div class="mlr">
					<div class="mlr-container">
						<h1>
							<?php esc_html_e( 'Media Library Recovery', $this->settings['textdomain'] ); ?>
							<hr />
						</h1>
						<p>
							<?php
								printf(
									wp_kses(
										__( 'A tool that helps you recover older and existing images from your <strong>/wp-content/uploads</strong> folder after database reset.', $this->settings['textdomain'] ),
										$this->settings['allowed_html_arr']
									)
								)
							?>
						</p>
						<p>
							<?php esc_html_e( 'Click on any of the media items below to mark it up for recovery:', $this->settings['textdomain'] ); ?>
						</p>
						<p>
							<label>
								<input type="checkbox" name="mlr-hide-existing-media" /> 
								<?php esc_html_e( 'Hide all existing media already found in the media library.', $this->settings['textdomain'] ); ?>
							</label>
						</p>
						<div class="mlr-media-explorer">
							<?php echo $this->explorer->media_explorer(); ?>
						</div>
						<p>
							<div class="mlr-media-explore-nav">
								<div class="button-action">
									<button class="button button-primary button-large" name="mlr-recover-media-button">
										<i class="dashicons dashicons-backup"></i>
										<?php esc_html_e( 'Recover Media', $this->settings['textdomain'] ); ?>
									</button>
									<span></span>
								</div>
								<div class="button-group">
									<a href="?page=media-library-recovery&p=<?php echo ( isset( $_GET['p'] ) && $_GET['p'] > 1 ) ? ( $_GET['p'] - 1 ) : 1; ?>" class="button button-primary button-large">
										<?php esc_html_e( '&larr; Previous Page', $this->settings['textdomain'] ); ?>
									</a>
									<a href="?page=media-library-recovery&p=<?php echo ( isset( $_GET['p'] ) && $_GET['p'] > 0 ) ? ( $_GET['p'] + 1 ) : 2; ?>" class="button button-primary button-large">
										<?php esc_html_e( 'Next Page &rarr;', $this->settings['textdomain'] ); ?>
									</a>
								</div>
							</div>
						</p>
						<hr />
						<p>
							<a href="javascript:void();" class="button" onclick="window.location.reload(true);"><strong>Reload...</strong></a>
						</p>
						<p>
							<?php
								printf(
									wp_kses(
										__( '<em>Note: Refresh this page manually if the recovering process doesn\'t complete successfully within a couple of minutes.</em>', $this->settings['textdomain'] ),
										$this->settings['allowed_html_arr']
									)
								)
							?>
						</p>
						<hr />
						<p>
							<?php
								printf(
									wp_kses(
										__( '<strong>This tool DOES NOT re-upload any media on the server</strong>, and it will only scan the existing media folders and display all the media. Then you will have the ability to individually select the media files you want to recover or use the filters to speed up the process.', $this->settings['textdomain'] ),
										$this->settings['allowed_html_arr']
									)
								)
							?>
						</p>
						<p>
							<?php
								printf(
									wp_kses(
										__( 'When you delete an image or any media file from your library, it will only remove it from the database. However, you might decide to use this media again, and instead of uploading it and using up your server storage with <em>Media Library Recovery</em>, you can restore the existing media from the uploads directory and re-insert it into the WordPress database.', $this->settings['textdomain'] ),
										$this->settings['allowed_html_arr']
									)
								)
							?>
						</p>
						<p>
							<?php
								printf(
									wp_kses(
										__( '<em>Note: If you choose to retrieve any existing media, it will create a duplicate one.</em>', $this->settings['textdomain'] ),
										$this->settings['allowed_html_arr']
									)
								)
							?>
						</p>
						<hr />
						<p>
							<?php
								printf(
									wp_kses(
										__( 'If something is not clear, please open a ticket on the official plugin %1$s. All tickets should be addressed within a couple of working days.', $this->settings['textdomain'] ),
										$this->settings['allowed_html_arr']
									),
									'<a href="' . esc_url( $this->settings['plugin_wporgurl'] ) . '" target="_blank">'
									. esc_html__( 'Support Forum', $this->settings['textdomain'] ) . '</a>'
								)
							?>
						</p>
						<p>
							<i class="dashicons dashicons-visibility"></i> 
							<?php esc_html_e( 'Files already recovered and found in the media library.', $this->settings['textdomain'] ); ?>
							<br />
							<i class="dashicons dashicons-hidden"></i> 
							<?php esc_html_e( 'Hidden files not currently showing up in the media library and availble for recovery.', $this->settings['textdomain'] ); ?>
							<br />
							<i class="dashicons dashicons-yes"></i> 
							<?php esc_html_e( 'Selected files that you want to recover and show in your media library.', $this->settings['textdomain'] ); ?>
						</p>
						<hr />
						<div class="mlr-notice">
							<p>
								<strong>
								<?php esc_html_e( 'Please rate us', $this->settings['textdomain'] ); ?>
								</strong>
								<a href="<?php echo esc_url( $this->settings['plugin_wporgrate'] ); ?>" target="_blank"><img src="<?php echo esc_url( $this->settings['plugin_url'] ); ?>assets/img/rate.png" alt="Rate us @ WordPress.org" /></a>
							</p>
							<p>
								<strong>
									<?php esc_html_e( 'Having issues?', $this->settings['textdomain'] ); ?>
								</strong>
								<a href="<?php echo esc_url( $this->settings['plugin_wporgurl'] ); ?>" target="_blank">
									<?php esc_html_e( 'Create a Support Ticket', $this->settings['textdomain'] ); ?>
								</a>
							</p>
							<p>
								<strong>
									<?php esc_html_e( 'Developed by', $this->settings['textdomain'] ); ?>
								</strong>
								<a href="https://krasenslavov.com/" target="_blank">
									<?php esc_html_e( 'Krasen Slavov', $this->settings['textdomain'] ); ?>
								</a>
							</p>
						</div>
					</div>
				</div>
			<?php
		}
	}
}
