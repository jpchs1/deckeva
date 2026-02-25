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
     
 
 if($settings['layout_style'] == 'slider')
 {
    // $this->add_render_attribute('slider', 'data-dots', $settings['dots']);
    $this->add_render_attribute('slider', 'data-nav', $settings['nav_arrow']);
    $this->add_render_attribute('slider', 'data-pagination_type', $settings['pagination_type']);
    $this->add_render_attribute('slider', 'data-desk_num', $settings['desk_num']);
    $this->add_render_attribute('slider', 'data-lap_num', $settings['lap_num']);
    $this->add_render_attribute('slider', 'data-tab_num', $settings['tab_num']);
    $this->add_render_attribute('slider', 'data-mob_num', $settings['mob_num']);
    $this->add_render_attribute('slider', 'data-mob_sm', $settings['mob_num']);
    $this->add_render_attribute('slider', 'data-autoplay', $settings['autoplay']);
    $this->add_render_attribute('slider', 'data-loop', $settings['loop']);
    $this->add_render_attribute('slider', 'data-margin', $settings['margin']['size']);
  ?>
<div class="gen-award">
   <div class="swiper-container" <?php echo $this->get_render_attribute_string('slider'); ?>>
     <div class="swiper-wrapper">
 <?php 
  foreach ( $tabs as $index => $item )
  {
        //echo Group_Control_Image_Size::get_attachment_image_html( $item, 'thumbnail', 'tab_image' );
    if (!empty($item['title_text'])) 
            {
                $title ='<span class="gen-award-title">'.esc_attr($item['title_text']).'</span>';
            }
  
      
    if ( ! empty( $item['btn_link']['url'] ) ) 
    {
        $this->add_render_attribute( 'btn_attr_link'.$index, 'href', $item['btn_link']['url'] );
        if ( $item['btn_link']['is_external'] ) {
            $this->add_render_attribute( 'btn_attr_link'.$index, 'target', '_blank' );
        }
        if ( ! empty( $item['btn_link']['nofollow'] ) ) {
            $this->add_render_attribute( 'btn_attr_link'.$index, 'rel', 'nofollow' );
        }
    }
  ?>
  <div class="swiper-slide">
    <div class="gen-awardbox-1">
    <a  <?php echo $this->get_render_attribute_string('btn_attr_link'.$index); ?>>
    <img class="gen-award-img" src="<?php echo $item['tab_image']['url']; ?>" alt="gen-award-img" <?php echo $this->get_render_attribute_string('custom_width'); ?>>
        <?php echo ( $title ); ?>
    </a>
    </div>
  </div>
     
 <?php } 
  
  ?>
</div>
 <?php
    if($settings['nav_arrow'] == "true")
    { 
    ?>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
    <?php } ?>
    <?php
    if($settings['slider_pagination'] == 'true') 
    {
    ?>
    <div class="swiper-pagination"></div>
  <?php } ?>
</div>
</div>
<?php } ?>

