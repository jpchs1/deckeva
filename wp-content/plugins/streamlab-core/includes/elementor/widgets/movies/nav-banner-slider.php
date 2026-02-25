<?php
namespace Elementor; 
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div class="gen-nav-banner-movies"> 
	
	<div class="slider slider-for">
		<?php
		if ($wp_query -> have_posts() ) 
		{
			while ($wp_query -> have_posts() ) 
			{
				$wp_query->the_post();
				
				
				?>
				<div class="gen-movie-contain">
					<div class="gen-movie-img">
						<?php the_post_thumbnail(); ?>
					</div>
					<div class="gen-movie-meta-holder">
						<span class="ratings"><i class="fa fa-star"></i>
							<?php echo get_post_meta(get_the_ID() , '_masvideos_average_rating' , true); ?>
						</span>
						<span class="release-dat"><?php echo get_post_meta(get_the_ID() , '_movie_run_time' , true); ?></span>
						<span class="duration">
							<?php 
							echo gmdate("Y",get_post_meta(get_the_ID() , '_movie_release_date' , true)); 
							?>
							
						</span>
						<span class="movie-genre">
							<?php 
							$wp_object = wp_get_post_terms(get_the_ID(), 'movie_genre');
							
							if ( ! empty( $wp_object ) ) {
								foreach ( $wp_object as $val ) {
									
									?>
									<span><?php echo esc_html($val->name); ?></span>
									<?php
								}
							}
							?>
						</span>
						
					</div>
					<div class="gen-movie-info">
						<h3><?php the_title(); ?></h3>
						<?php echo get_the_excerpt(); ?>
					</div>
					<div class="gen-movie-action">
						<div class="gen-btn-container">
							<a href="#" class="gen-button">
								<div class="gen-button-block">
									<i class="fa fa-play"></i>
									<span class="gen-button-text">Play Now</span>
								</div>  
							</a>
						</div>
						<div class="gen-btn-container">
							<a href="#" class="gen-button">
								<div class="gen-button-block">
									<i class="fa fa-play"></i>
									<span class="gen-button-text">Watch Trailer</span>
								</div>  
							</a>
						</div>
					</div>
				</div>
				<?php
				
			}
			wp_reset_query();
		}
		?>
	</div>
	
	<div class="slider slider-nav">
		<?php
		if ($wp_query -> have_posts() ) 
		{
			while ($wp_query -> have_posts() ) 
			{
				$wp_query->the_post();
				?>
				<div class="gen-nav-img">
					<?php the_post_thumbnail(); ?>
				</div>
				<?php 
				
				
			}
			wp_reset_query();
		}
		?>
	</div>
	
	
	
	
</div>