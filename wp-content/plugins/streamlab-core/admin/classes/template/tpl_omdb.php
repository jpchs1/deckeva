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
					<a href="http://www.omdbapi.com/apikey.aspx" target="_blank"><?php esc_html_e('How to get API Key?', 'streamlab-core');?></a>
				</div>
				<div class="form-row">
					
					<div class="form-group">
						<label class="form-label" for="purchase_item"><?php esc_html_e( 'Enter Youtube Developer Api Key', 'streamlab-core' ); ?></label>
						<input class="form-control" placeholder="<?php esc_attr_e( 'Enter Youtube Developer Api Key', 'streamlab-core' ); ?>" type="password" name="api_key" data-type="omdb" value="<?php echo get_option( 'gen_omdb_api_key' ); ?>">
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

			<div class="gen-tab-wrapper">
				 <nav class="nav-tab-wrapper" style="display: none;">
				      <a href="#gen-movie" class="nav-tab nav-tab-active">Movie</a>
				      
				</nav>

				<div id="gen-movie" class="tab-content show active">
					<br>
					<div class="form-row">
					
						<div class="form-group">
							<select class="gen-movie-type-select">
								<option value="Select Search Preference">Select Search Preference</option>
								<option value="imdbid">A valid IMDb ID (e.g. tt1285016)</option>
								<option value="title">Movie title to search for (e.g. The Godfather)</option>
								<option value="keyword">KeyWord</option>
							</select>
						</div>	

						<div class="form-group">
							<input class="form-control" placeholder="<?php esc_attr_e( 'Select Search Preference', 'streamlab-core' ); ?>" type="text" name="gen-movie-id-title" data-type="omdb" value="">
						</div>

						<div class="form-group">
							<a type="submit" class="button button-primary gen-movie-id-title-btn" value="submit">
								<span class="gen-loading-icon dashicons dashicons-update"></span>
								<span class="text-btn"><?php esc_html_e( 'Search', 'streamlab-core' ); ?></span>
							</a>
						</div>
						<div class="form-group">
							<a type="submit" class="button button-primary gen-movie-id-title-import-btn" value="submit">
								<span class="gen-loading-icon dashicons dashicons-update"></span>
								<span class="text-btn"><?php esc_html_e( 'Import', 'streamlab-core' ); ?></span>
							</a>
							<div class="gen-import-notice">
								</div>
						</div>
					</div>
					
				</div>
				<div id="gen-series" class="tab-content">
					<h1>Series</h1>
					
				</div>
				<div id="gen-edpisode" class="tab-content">
					<p>Episode</p>
				</div>
				
			</div>

			
			
		
		
		
		
	</div>
	<div class="gen-search-container">
		<table class="omdb-videos">
					
					<tbody>
						
					</tbody>
				</table>
	</div>

</div>
</div>



