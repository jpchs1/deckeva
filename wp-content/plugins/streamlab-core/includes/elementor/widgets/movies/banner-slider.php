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
<div class="gen-banner-movies"> 
	<div class="owl-carousel" <?php echo $this->get_render_attribute_string('slider'); ?>>
		<?php
		
		if ($wp_query -> have_posts() ) 
		{
			while ($wp_query -> have_posts() ) 
			{
				$wp_query->the_post();

				$tag_line = '';
				if($settings['thumbnail_size'] != 'custom')
				{
					$size = $settings['thumbnail_size'];
				}
				else
				{
					$custom = $settings['thumbnail_custom_dimension'];
					$size = array($custom['width'] , $custom['height']);
				}
				$imdb_rating = '';
				$imdb_link = '';
				if(function_exists('get_field') && !empty(get_field('field_5d6d'))) 
				{
					$imdb_rating = get_field('field_5d6d');
					$imdb_link = get_field('field_5d6d55');
				}
				
				if(function_exists('get_field')) 
				{
					if(get_field('field_QnF15656b565') == 'text')
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
					<div class="gen-movie-contain h-100">
						<div class="container  h-100">
							<div class="row align-items-center h-100">
								<div class="col-xl-6">
									
										<?php 
										if(!empty($tag_line))
										{
											echo $tag_line;
										}
										$info = '';

										$movie_censor_rating = get_post_meta(get_the_ID() , '_movie_censor_rating' , true);
										$movie_run_time = get_post_meta(get_the_ID() , '_movie_run_time' , true);
										$movie_release_date = get_post_meta(get_the_ID() , '_movie_release_date' , true);
										$movie_genre = '';

										if(!empty($movie_censor_rating))
										{
											$info.='<li class="gen-sen-rating">
														<span>'.get_post_meta(get_the_ID() , '_movie_censor_rating' , true).'</span>
													</li>';
										}
										if(!empty($movie_run_time))
										{
											$info.= '<li>'.get_post_meta(get_the_ID() , '_movie_run_time' , true).'</li>';
										}
										if(!empty($imdb_rating))
										{
											$info .= '<li> 
												
												<a target="_blank" class="gen-imgb-link" href="'.esc_url($imdb_link).'">
													<img src="'.STREAMLAB_CORE_URL.'public/img/imdb.png'.'"> 
												
													
													<span>
														'.$imdb_rating.'
													</span>
													</a>
											</li>';
										}

										if(!empty($movie_release_date))
										{
											$info.='	<li>
												'.gmdate("Y",get_post_meta(get_the_ID() , '_movie_release_date' , true)).'
												
											</li>';
										}
										$wp_object = wp_get_post_terms(get_the_ID(), 'movie_genre');
											if ( ! empty( $wp_object ) ) {
												foreach ( $wp_object as $val ) {
                    							$info.= '	<li>
                    								<a href="'.esc_url(get_category_link( $val->term_id )).'"><span>'. esc_html($val->name).'</span></a>
                    							</li>';
                    							
													break;
												}
											}

										?>
									
									<div class="gen-movie-info">
										<h3><?php the_title(); ?></h3>
										
									</div>
									<div class="gen-movie-meta-holder">
										<ul>
											<?php
												echo $info;
											?>
											
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
										<?php
										$link = '#';
										if(function_exists('get_field')) 
										{
											$link = get_field('field_5d6d06');
										}
										
										?>
										<div class="gen-btn-container button-2">
											<a href="<?php the_permalink(); ?>" <?php echo $this->get_render_attribute_string('btn_attr_2'); ?>>
												<?php echo $icon_2; ?>
												<span class="text"><?php echo esc_html($settings['button_text_2']); ?></span>
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
