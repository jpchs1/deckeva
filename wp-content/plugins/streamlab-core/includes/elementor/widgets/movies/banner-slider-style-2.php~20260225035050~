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
<div class="gen-banner-movies banner-style-2"> 
	<div class="slider" <?php echo $this->get_render_attribute_string('slider'); ?>>
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

				?>
				<div class="slider-item" style="background: url('<?php echo get_the_post_thumbnail_url(get_the_ID()); ?>')">
					<div class="gen-movie-contain-style-2 h-100">
						<div class="container h-100">
							<div class="row flex-row-reverse align-items-center h-100">
								<div class="col-xl-6">
									<div class="gen-front-image">
										<?php
										if($settings['show_front_image'] == 'yes')
										{ 
										?>
										<img src="<?php  echo get_the_post_thumbnail_url(get_the_ID()); ?>">
									<?php } ?>

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

									<span>Watch Trailer</span>
									
								</a>
									</div>
						
							</div>
								<div class="col-xl-6">
									
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
											<li class="gen-sen-rating"><?php echo get_post_meta(get_the_ID() , '_movie_censor_rating' , true); ?></li>
											
											
											<li> <img src="<?php echo STREAMLAB_CORE_URL.'public/img/imdb.png' ?>"> 
												<span>
													<?php
													echo $imdb_rating; 
													?>
												</span>
												
											</li>
											
										</ul>
										
										<?php the_excerpt(); ?>
										<div class="gen-meta-info">
											<ul class="gen-meta-after-excerpt">
												<li>
													<strong>Cast :</strong>	
													<?php
											$cast =  get_post_meta(get_the_ID() , '_cast' , true);
											$i = 0;

											
											if(is_array($cast))
											{
												$numItems = count($cast);
												foreach($cast as $val)
												{
													if(++$i === $numItems)
													{
														echo get_the_title($val['id']);
													}
													else
													{
														echo get_the_title($val['id']).",";
													}
													
												}
											} 
											?>
												</li>

												<li>
													<strong>Genre :</strong>

											<?php 
				   				
							$wp_object = wp_get_post_terms(get_the_ID(), 'movie_genre');
							$numItems = count($wp_object);
							$i = 0;

							if ( ! empty( $wp_object ) ) {
								foreach ( $wp_object as $val ) {
									?>
									<span>
										<a href="<?php echo esc_url(get_category_link( $val->term_id )); ?>">
									<?php 
									if(++$i === $numItems)
									{

									    echo esc_html($val->name); 
									}
									else
									{
										echo esc_html($val->name . ","); 	
									}

									?>
								     </a>
									</span>
									<?php 
								}
							}

											?>
												</li>

						<li>
													<strong>Tag :</strong>

											<?php 
				   				
							$wp_object = wp_get_post_terms(get_the_ID(), 'movie_tag');
							$numItems = count($wp_object);
							$i = 0;

							if ( ! empty( $wp_object ) ) {
								foreach ( $wp_object as $val ) {
									?>
									<span>
										<a href="<?php echo esc_url(get_category_link( $val->term_id )); ?>">
									<?php 
									if(++$i === $numItems)
									{

									    echo esc_html($val->name); 
									}
									else
									{
										echo esc_html($val->name . ","); 	
									}

									?>
								     </a>
									</span>
									<?php 
								}
							}

											?>
												</li>

											</ul>
											
											

											
										</div>
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