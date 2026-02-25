<?php
namespace Elementor; 
if ( ! defined( 'ABSPATH' ) ) exit;
$args = array();
if($settings['thumbnail_size'] != 'custom')
{
	$size = $settings['thumbnail_size'];
	$args = array ( 'size' => $size );
}
else
{
	$custom = $settings['thumbnail_custom_dimension'];
	$args = array('size_dimention' => array('width' => $custom['width'] , 'height' => $custom['height']));
}
$box_style = '1';
if($settings['tv_show_box_style'] == 'inherit')
{
	$theme_options = get_option('theme_options');
	$box_style = $theme_options['tv_show_box_style'];
}
else 
{
	$box_style = $settings['tv_show_box_style'];
}
?>
<div class="gen-style-<?php echo $box_style; ?>"> 
	<div class="owl-carousel" <?php echo $this->get_render_attribute_string('slider'); ?>>
		<?php
		if ($wp_query -> have_posts() ) 
		{
			while ($wp_query -> have_posts() ) 
			{
				$wp_query->the_post();
				?>
				<div class="item">
					<?php
					//masvideos_get_template_part( 'content', 'movie' );
					get_template_part( "template-parts/tv_show/content", "style-{$box_style}" , $args ); 
					?>
				</div>
				<?php 
			}
			wp_reset_query();
		}
		?>
	</div>
	 
</div>