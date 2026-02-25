<?php
namespace Elementor; 
use gentechtree\streamlab\Helper;
if ( ! defined( 'ABSPATH' ) ) exit;

$this->add_render_attribute( 'btn_attr_1', 'class', 'gen-button' ); 
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
<div class="gen-banner-movies banner-style-3"> 
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
				$imdb_rating = 0;
				if(function_exists('get_field') && !empty(get_field('field_5d6d'))) 
				{
					$imdb_rating = get_field('field_5d6d');
				}

				

				

				?>
				<div class="item" style="background: url('<?php echo get_the_post_thumbnail_url(get_the_ID()); ?>')">
					<div class="gen-movie-contain-style-3 h-100">
						<div class="container  h-100">
							<div class="row justify-content-center h-100">
								<div class="col-xl-6">
									<?php
										
										?>
								

									<a href="<?php echo the_permalink(); ?>" class="playBut">
										
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
									
										
									
									<div class="gen-movie-info">
										<h3><?php the_title(); ?></h3>
										
									</div>
									<div class="gen-movie-meta-holder">
										 <ul class="gen-meta-after-title">
                  <li><?php echo human_time_diff( strtotime( get_the_date() ), current_time( 'timestamp', 1 ) ); ?>
                  	
                  </li>
                  
                  
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