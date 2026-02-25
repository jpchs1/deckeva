<?php
namespace Elementor; 
use gentechtree\streamlab\Helper;
if ( ! defined( 'ABSPATH' ) ) exit;
$title_html = $settings['button_text_1'];
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
////

?>
<div class="gen-banner-movies"> 
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
				?>
				<div class="item" style="background: url('<?php echo get_the_post_thumbnail_url(get_the_ID()); ?>')">
					<div class="gen-movie-contain h-100">
						<div class="container  h-100">
							<div class="row align-items-center h-100">
								<div class="col-xl-6">
									<div class="gen-movie-info">
										<h3><?php the_title(); ?></h3>
										
									</div>
								<div class="gen-movie-meta-holder">
                <ul>

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
				
				<?php 
			}
			wp_reset_query();
		}
		?>
	</div>
</div>