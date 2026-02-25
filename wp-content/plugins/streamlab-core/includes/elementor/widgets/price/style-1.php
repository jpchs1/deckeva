<?php
namespace Elementor;
if (!defined('ABSPATH')) {
 exit;
}
//$this->add_render_attribute( 'list_item', 'class', 'elementor-icon-list-item' );
$settings   = $this->get_settings();
$tabs       = $this->get_settings_for_display('tabs');
$align      = $settings['align'];
$image_html = '';
// $title_html = $settings['button_text'];
$this->add_render_attribute( 'btn_attr', 'class', 'gen-button' ); 
if($settings['btn_style'] == 'btn-flat')
{
  $this->add_render_attribute( 'btn_attr', 'class', 'gen-button-flat' ); 
}
if($settings['btn_style'] == 'btn-outline')
{
  $this->add_render_attribute( 'btn_attr', 'class', 'gen-button-outline' ); 
}
if($settings['btn_style'] == 'btn-link')
{
  $this->add_render_attribute( 'btn_attr', 'class', 'gen-button-link' ); 
}
$icon = '';
if(!empty($settings['selected_icon']['value']))
{
  $icon = sprintf('<i aria-hidden="true" class="%1$s"></i>',esc_attr($settings['selected_icon']['value'],'hostingo-core'));
}
if ($settings['image_style'] == 'icon') {
 if (!empty($settings['selected_icon']['value'])) {
  $this->add_render_attribute('selected_icon', 'class', esc_attr($settings['selected_icon']['value']));
  $image_html .= '<div class="gen-service-media">';
  $image_html .= sprintf('<i %1$s></i>', $this->get_render_attribute_string('selected_icon'));
  $image_html .= '</div>';
}
} else if ($settings['image_style'] == 'image') {
 if (!empty($settings['image']['url'])) {
  $this->add_render_attribute('image', 'src', $settings['image']['url']);
  $this->add_render_attribute('image', 'srcset', $settings['image']['url']);
  $this->add_render_attribute('image', 'alt', Control_Media::get_image_alt($settings['image']));
  $this->add_render_attribute('image', 'title', Control_Media::get_image_title($settings['image']));
  $image_html = Group_Control_Image_Size::get_attachment_image_html($settings, 'thumbnail', 'image');
}
}
$active = $settings['active'];
if ($active === "yes") {
 $align .= ' active';
}

if ( ! empty( $settings['btn_link']['url'] ) ) 
{
    $this->add_render_attribute( 'btn_attr', 'href', $settings['btn_link']['url'] );

    if ( $settings['btn_link']['is_external'] ) {
        $this->add_render_attribute( 'btn_attr', 'target', '_blank' );
    }

    if ( ! empty( $settings['btn_link']['nofollow'] ) ) {
        $this->add_render_attribute( 'btn_attr', 'rel', 'nofollow' );
    }
}
?>
<div  class="gen-price-block <?php echo esc_attr($align); ?>">
  <div class="gen-price-detail">
    <span class="gen-price-title"> <?php echo esc_html($settings['title']);  ?> </span>
    <h2 class="price"><?php echo esc_html($settings['price']);  ?></h2>
    <p class="gen-price-duration"><?php echo esc_html($settings['description']);  ?></p>
    <?php 
    if(! empty( $settings['image']['url']))
    {
      ?>
      <div class="gen-bg-effect">
        <img src="<?php echo esc_attr($settings['image']['url']); ?>" alt="architek-image" />
      </div>
    <?php   }  ?>
  </div>  
  <ul class="gen-list-info">
    <?php       
    foreach ( $tabs as $index => $item )
    {    
    $plan_icon = '';  
    if (!empty($item['selected_icons']['value'])) {
      $this->add_render_attribute('selected_icons', 'class', esc_attr($item['selected_icons']['value']));
      $plan_icon .= '<div class="gen-service-media">';
      $plan_icon .= sprintf('<i %1$s></i>', $this->get_render_attribute_string('selected_icons'));
    }
                       
      ?>
      <li>
        <?php echo $plan_icon; ?>
          <?php 

                        if($item['enable_disable'] == 'yes'){

                            ?>

                             <?php echo esc_html($item['tab_title']); ?>

                            <?php 

                        }else{

                          ?>
                          <del><?php echo esc_html($item['tab_title']); ?></del>
                           

                        <?php }

                        ?>
        
        
      </li>
    <?php  } ?>
  </ul>
  <div class="gen-btn-container button-1">
     <a  <?php echo $this->get_render_attribute_string('btn_attr');  ?>>
      <span class="text"><?php echo esc_html($settings['button_text']); ?></span>
    </a>

    
  </div>
</div>
