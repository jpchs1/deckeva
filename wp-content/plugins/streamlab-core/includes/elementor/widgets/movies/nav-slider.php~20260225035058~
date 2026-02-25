<?php
namespace Elementor; 
if ( ! defined( 'ABSPATH' ) ) exit; 
$this->add_render_attribute( 'btn_attr_1', 'class', 'gen-button' ); 
//$this->add_render_attribute( 'btn_attr_1', 'href', '#' );
if($settings['btn_style_1'] == 'btn-flat')
{
  
  $this->add_render_attribute( 'btn_attr_1', 'class', 'gen-button-flat' ); 
}
if($settings['btn_style_1'] == 'btn-outline')
{
  
  $this->add_render_attribute( 'btn_attr_1', 'class', 'gen-button-outline' ); 
}
if($settings['btn_style_1'] == 'btn-link')
{
  
  $this->add_render_attribute( 'btn_attr_1', 'class', 'gen-button-link' ); 
}
$icon = '';
if(!empty($settings['selected_icon_1']['value']))
{
 $icon = sprintf('<i aria-hidden="true" class="%1$s"></i>',esc_attr($settings['selected_icon_1']['value'],'hostingo-core'));
}
?>
<div class="gen-nav-movies gen-banner-movies"> 
	<div class="row">
		<div class="col-lg-12">
			<div class="slider slider-for">
				<?php
				if ($wp_query -> have_posts() ) 
				{
					while ($wp_query -> have_posts() ) 
					{
						$wp_query->the_post();
						if($settings['thumbnail_size'] != 'custom')
		               {
		                $size = $settings['thumbnail_size'];
		               }
		              else
		              {
		                
		               
		                $custom = $settings['thumbnail_custom_dimension'];
		                
		                 $size = array($custom['width'] , $custom['height']);
		                      
		              }
						?>
					<div class="slider-item" style="background: url('<?php echo get_the_post_thumbnail_url(get_the_ID()); ?>')">
						<div class="gen-slick-slider h-100">
							
					<div class="gen-movie-contain h-100">
						<div class="container h-100">
							<div class="row align-items-center h-100">
								<div class="col-lg-8 col-xl-6 ">
									<div class="gen-movie-info">
										<h3><?php the_title(); ?></h3>
										<?php the_excerpt(); ?>
									</div>
									
									
									<div class="gen-movie-action">
										<div class="gen-btn-container button-1">
									        <a href="<?php the_permalink(); ?>" <?php echo $this->get_render_attribute_string('btn_attr_1'); ?>>
									             <?php echo $icon; ?>
									            <span class="text"><?php echo esc_html($settings['button_text_1']); ?></span>
									        </a>
  										</div>
										
										
										</div>
								</div>
							</div>
						</div>
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
						<div class="slider-nav-contain">
							<div class="gen-nav-img">
							<?php 
								the_post_thumbnail(); 
								
							?>
						</div>
						<div class="movie-info">
							<h3><?php echo get_the_title(); ?></h3>
							<div class="gen-movie-meta-holder">
										<ul>
											
											<li><?php echo get_post_meta(get_the_ID() , '_movie_run_time' , true); ?></li>
											
											<li>
												
												<?php

												$wp_object = wp_get_post_terms(get_the_ID(), 'movie_genre');
												if ( ! empty( $wp_object ) ) {
													
													foreach ( $wp_object as $val ) {
														echo '<a href="'.esc_url(get_category_link( $val->term_id )).'">';
														 echo esc_html($val->name); 
														 echo '</a>';
														 break;
													}
													
												}
												?>
											</li>
										</ul>
										
										
									</div>
							
						</div>
						</div>
						
						<?php 
					}
					wp_reset_query();
				}
				?>
			</div>
		</div>
		
	</div>
</div>