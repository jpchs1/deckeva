<?php
namespace Elementor; 
if ( ! defined( 'ABSPATH' ) ) exit; 
$html = '';

$settings = $this->get_settings();
//$settings = $this->get_settings_for_display();


$title_html = $settings['button_text'];


$this->add_render_attribute( 'btn_attr', 'class', 'gen-button' ); 

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

?>


  <div class="gen-btn-container">
        <a <?php echo $this->get_render_attribute_string('btn_attr'); ?>>
            
            <span class="text"><?php echo esc_html($settings['button_text']); ?></span>
        </a>
  </div>

<?php
$this->add_render_attribute( 'btn_attr', 'href', '' ); 
?>