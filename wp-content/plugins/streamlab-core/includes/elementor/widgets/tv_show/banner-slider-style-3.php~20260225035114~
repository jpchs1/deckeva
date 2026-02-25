<?php
namespace Elementor; 
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
////
$this->add_render_attribute( 'btn_attr_2', 'class', 'gen-button popup-youtube popup-vimeo popup-gmaps' ); 
if($settings['btn_style_2'] == 'btn-flat')
{
	$this->add_render_attribute( 'btn_attr_2', 'class', 'gen-button-flat' ); 
}
if($settings['btn_style_2'] == 'btn-outline')
{
	$this->add_render_attribute( 'btn_attr_2', 'class', 'gen-button-outline' ); 
}
if($settings['btn_style_2'] == 'btn-link')
{
	$this->add_render_attribute( 'btn_attr_2', 'class', 'gen-button-link' ); 
}
$icon_2 = '';
if(!empty($settings['selected_icon_2']['value']))
{
	$icon_2 = sprintf('<i aria-hidden="true" class="%1$s"></i>',esc_attr($settings['selected_icon_2']['value'],'hostingo-core'));
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
				$seasons = get_post_meta( get_the_ID() , '_seasons' );
				
				$episodes = get_post_meta( get_the_ID() , '_episodes' );
				$count_episodes = 0;
				$count_seasons = 0;
				$sea_string = '';
				$epi_string = '';
				$year_string = '';
				if(isset($seasons[0]) && is_array($seasons[0]))
				{
					foreach ($seasons[0] as $key => $season) {
						foreach ($season as $k => $sea) {
							if($k == 'episodes')
							{
								$count_episodes +=  count($season['episodes']);
							}
							if($k == 'year')
							{
								if(empty($year_string))
								{
									$year_string .= $season['year']; 
								}
							}
						}
						$count_seasons++;
					}
				}
				if(isset($count_seasons))
				{
					if($count_seasons != 1)
					{
						$sea_string = $count_seasons . esc_html__(' Seasons', 'streamlab-core');  
					}
					else
					{
						$sea_string = $count_seasons . esc_html__(' Season', 'streamlab-core');  
					}
				}
				if(isset($count_episodes))
				{
					if($count_episodes != 1)
					{
						$epi_string = $count_episodes . esc_html__(' Episodes', 'streamlab-core');  
					}
					else
					{
						$epi_string = $count_episodes . esc_html__(' Episode', 'streamlab-core');  
					}
				}
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

				if(function_exists('get_field')) 
				{
					if(get_field('field_QnF15656b565') == 'text' && !empty(get_field('field_5d6d56')))
					{
					$tag_line = '<div class="gen-tag-line"><span>'.get_field('field_5d6d56').'</span></div>';
					}
					if(get_field('field_QnF15656b565') == 'image')
					{
						$image_data = get_field('field_5d6d065656');
						if(!empty($image_data['url']))
						{
							$tag_line = '<div class="gen-tag-img"><img src="'.esc_url($image_data['url']).'"/></div>';
						}
					
					}

				}

				

				?>
				<div class="item" style="background: url('<?php echo get_the_post_thumbnail_url(get_the_ID()); ?>')">
					<div class="gen-movie-contain-style-3 h-100">
						<div class="container  h-100">
							<div class="row justify-content-center h-100">
								<div class="col-xl-6">
									<?php
										$link = '#';
										if(function_exists('get_field')) 
										{
											$link = get_field('field_5d6d06');
										}
										
										?>
								

									<a href="<?php echo esc_attr($link); ?>" class="playBut popup-youtube popup-vimeo popup-gmaps">
										
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
									
										<?php 
										if(!empty($tag_line))
										{
											echo $tag_line;
										}
										
										?>
									
									<div class="gen-movie-info">
										<h3><?php the_title(); ?></h3>
										
									</div>
									<div class="gen-movie-meta-holder">
		         <ul class="gen-meta-after-title">
                  <?php
                	if(!empty($sea_string))
                	{
                		echo '<li>'.esc_html($sea_string).'</li>';
                	}
                	if(!empty($epi_string))
                	{
                		echo '<li>'.esc_html($epi_string).'</li>';
                	}
                	if(!empty($year_string))
                	{
                		echo '<li>'.esc_html($year_string).'</li>';
                	}
                	?>
                  
                  <?php
                   $wp_object = wp_get_post_terms(get_the_ID(), 'tv_show_genre');
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