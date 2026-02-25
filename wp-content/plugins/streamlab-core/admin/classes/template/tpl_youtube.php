<?php
/**
 * Template Activate Theme
 *
 * @link       https://themeforest.net/user/gentechtreedesign
 * @since      1.0.0
 *
 * 
 * 
 */
/**
 * @since      1.0.0
 * 
 * 
 * @author     PeaceFulThemes
 */
?>

<div class="gen-video-import-section wrap">
	<div class="gentech-activation-theme_form">
	<div class="container-form">

			<div class="gen-notices">
				
			</div>
			
			<form class="form gentech-import" action="<?php echo esc_url( admin_url( 'admin.php?page=gentech-activate-theme-panel' ) ); ?>" method="post">
				<div class="help-description">
					<a href="https://developers.google.com/youtube/v3/getting-started" target="_blank"><?php esc_html_e('How to get API Key?', 'streamlab-core');?></a>
				</div>
				<div class="form-row">
					
					<div class="form-group">
						<label class="form-label" for="purchase_item"><?php esc_html_e( 'Enter Youtube Developer Api Key', 'streamlab-core' ); ?></label>
						<input class="form-control" placeholder="<?php esc_attr_e( 'Enter Youtube Developer Api Key', 'streamlab-core' ); ?>" type="password" name="api_key" data-type="youtube" value="<?php echo get_option( 'gen_youtube_api_key' ); ?>">
					</div>	

				<div class="form-group">
					<a type="submit" class="button button-primary gen-save-api-key" value="submit">
						<span class="gen-loading-icon dashicons dashicons-update"></span>
						<span class="text-btn"><?php esc_html_e( 'Save', 'streamlab-core' ); ?></span>
					</a>
				</div>


				</div>
				<?php wp_nonce_field( 'purchase-activation', 'security' ); ?>
				
				
			</form>	

			<form method="post" action="#">
			<div class="gen-data-wraper">
				<div class="form-row">
					<div class="form-group">
						<input class="form-control" placeholder="<?php esc_attr_e( 'Enter Video Name', 'streamlab-core' ); ?>" type="text" name="video_name">

					</div>	

					<div class="form-group">
						<a  class="button button-primary search-youtube" value="submit">
							<span class="gen-loading-icon dashicons dashicons-update"></span>
							<span class="text-btn"><?php esc_html_e( 'Search', 'streamlab-core' ); ?></span>
							
						</a>

						<a  class="button button-primary youtube-import" value="submit">
							<span class="gen-loading-icon dashicons dashicons-update"></span>
							<span class="text-btn"><?php esc_html_e( 'Import', 'streamlab-core' ); ?></span>
							
						</a>

						<div class="gen-import-notice">
						</div>
					</div>
				</div>

				
			</div>
		</form>
	
		
		
	</div>
	<div class="gen-search-container">
		<table class="youtube-videos">
					
					<tbody>
						
					</tbody>
				</table>
	</div>
</div>
</div>


