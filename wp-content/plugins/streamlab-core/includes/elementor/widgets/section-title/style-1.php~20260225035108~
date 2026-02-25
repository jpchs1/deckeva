<?php
namespace Elementor; 
if ( ! defined( 'ABSPATH' ) ) exit; 
$settings = $this->get_settings();
$title = '';
$sub_title = '';
$description_text = '';
$text_align = '';

$title = sprintf( '<%1$s class="gen-section-title">%2$s</%1$s>', $settings['title_tag'] , esc_html($settings['title_text']));
// if ( 'yes' === $settings['show_sub_title'] ) 
// {
// 	$sub_title = sprintf( '<span class="gen-section-sub-title">%1$s</span>', esc_html($settings['sub_title_text']));	
// }

if ( 'yes' === $settings['show_description'] ) 
{
	$description_text = sprintf( '<p class="gen-section-description">%1$s', $this->parse_text_editor($settings['description_text']));	
}
if($settings['text_align'] == 'center')
{
	$text_align = 'text-center';
}



?>




<div class="gen-section-title-1 <?php echo esc_attr($text_align); ?>">   
   		
     	<?php echo $title; ?>
     	<?php echo $description_text; ?>   
</div>