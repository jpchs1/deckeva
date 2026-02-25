<?php
namespace Elementor; 
use gentechtree\streamlab\Helper;
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div class="gen-banner-movies banner-style-2"> 
	<div class="owl-carousel" <?php echo $this->get_render_attribute_string('slider'); ?>>
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
				if(function_exists('get_field')) 
				{
					$back_image = get_field('field_5d6d0656');
					 if(!empty($back_image['url']))
					 {
					 	$image_url = $back_image['url'];
					 }
					 else
					 {
					 	$image_url = get_the_post_thumbnail_url(get_the_ID());
					 }
				}
				?>
				<div class="item" style="background: url('<?php echo $image_url; ?>')">
					<div class="gen-movie-contain-style-2 h-100">
						<div class="container h-100">
							<div class="row flex-row-reverse align-items-center h-100">
								<div class="col-xl-6">
									<?php
									$class = '';
										if($settings['show_front_image'] == 'no')
										{
											$class = "no-image";
										} 
										?>

									<div class="gen-front-image <?php echo $class ?>">
										<?php
										if($settings['show_front_image'] == 'yes')
										{ 											
											$front_image_url = get_the_post_thumbnail_url(get_the_ID());
										?>
										 <img src="<?php echo $front_image_url; ?>">
									<?php } ?>								
								
									<?php
									if( isset( $settings['hide_watch_trailor']) && $settings['hide_watch_trailor'] == 'yes' ) {
										$hide_class = 'd-none';
									} 
									else {
										$hide_class = '';
									}
									?>
									<a href="<?php the_permalink(); ?>" class="playBut <?php echo $hide_class; ?>">
										
										<!-- Generator: Adobe Illustrator 19.0.0, SVG Export Plug-In  -->
										<svg version="1.1"
										xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/"
										x="0px" y="0px" width="213.7px" height="213.7px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7"
										xml:space="preserve">

										<polygon class='triangle' id="XMLID_18_" fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="
										73.5,62.5 148.5,105.8 73.5,149.1 "/>
										
										<circle class='circle' id="XMLID_17_" fill="none"  stroke-width="7" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3"/>
									</svg>

									<span><?php echo esc_html($settings['watch_trailer']) ?></span>
									
									</a>
								
									</div>
						
							</div>
								<div class="col-xl-6">
									
										
									
									<div class="gen-movie-info">
										<h3>
											<a href="<?php the_permalink(); ?>">
											<?php the_title(); ?>
											</a>	
											</h3>
										
									</div>
									<div class="gen-movie-meta-holder">

										<ul class="gen-meta-after-title">
                  <li><?php echo human_time_diff( strtotime( get_the_date() ), current_time( 'timestamp', 1 ) ); ?></li>
                  
                   <?php
                   $wp_object = wp_get_post_terms(get_the_ID(), 'video_cat');
                    if ( ! empty( $wp_object ) ) { 
                  ?>
                  
                  <li>
                    <?php 
                   
                      foreach ( $wp_object as $val ) {
                        ?>
                        <a href="<?php echo esc_url(get_category_link( $val->term_id )); ?>"><?php ?><span><?php  echo esc_html($val->name);  ?></span></a>
                        <?php
                       
                        break;
                      }
                    
                    ?>
                    
                  </li>
              <?php } ?>
              
                  <li>
					<i class="fas fa-eye">
						
					</i>
					<span><?php  Helper::get_post_view_count(get_the_ID()); ?></span>
				</li>
                </ul>
									

										
										
										<?php the_excerpt(); ?>
										
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
</div>