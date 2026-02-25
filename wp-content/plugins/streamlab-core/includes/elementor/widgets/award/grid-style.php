<?php
namespace Elementor; 
if ( ! defined( 'ABSPATH' ) ) exit; 
$tabs = $this->get_settings_for_display( 'tabs' );
$settings = $this->get_settings();
$style = '';
if(!empty($settings['custom_dimension']['width']))
{
    $width = $settings['custom_dimension']['width'];
    $this->add_render_attribute('custom_width', 'style', 'width:'.$width.'px;');
}
if(!empty($settings['custom_dimension']['height']))
{
  $height = $settings['custom_dimension']['height'];
  $this->add_render_attribute('custom_width', 'style', 'height:'.$height.'px;'); 
}
     
if($settings['layout_style'] == 'grid')
 {
  ?>
<div class="gen-award">
  <div class="row">
 <?php 
  foreach ( $tabs as $index => $item )
  {
  ?>
  <div class="col-lg-<?php echo esc_attr($settings['grid_style']); ?> col-md-4">
    <div class="gen-award-grid">
      <img class="gen-award-img" src="<?php echo $item['tab_image']['url']; ?>" alt="gen-award-img" <?php echo $this->get_render_attribute_string('custom_width'); ?>>
    </div>
    
  </div>
     
 <?php } 
  
  ?>
</div>
</div>
<?php }