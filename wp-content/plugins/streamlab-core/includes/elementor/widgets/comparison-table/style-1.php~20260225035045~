<?php
namespace Elementor; 
if ( ! defined( 'ABSPATH' ) ) exit; 
$table_header = $this->get_settings_for_display( 'table_header' );
$table_body = $this->get_settings_for_display( 'table_body' );

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

  $icon = sprintf('<i aria-hidden="true" class="%1$s"></i>',esc_attr($settings['selected_icon_1']['value'],'streamlab-core'));
}
?>
<div class="gen-comparison-table table-style-1 table-responsive">
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
            <?php
            foreach ($table_header as $key => $value) 
            {
                $icon = '';
                if ($value['image_style'] === "1") 
                 {
                    if (!empty($value['image']['url'])) 
                    {
                        $icon = '<div class="gen-plan-img"><img src="'.esc_url($value['image']['url']).'" alt="'.esc_attr(__('fancybox' , 'streamlab-core')).'" /></div>';
                    }
                 }
                 if ($value['image_style'] === "2")
                  {
                    if (!empty($value['header_icon']['value']))
                    {   
                        $icon = sprintf('<i class="%1$s"></i>', esc_attr($value['header_icon']['value']));
                    }
                  }
                if(!empty($value['header_back_color']))
                {
                  $style = 'style = background-color:'.$value['header_back_color'].';';
                }
                else
                {
                  $style = ''; 
                }

                 if(!empty($value['header_text_color']))
                {
                  $text_style = 'style = color:'.$value['header_text_color'].';';
                }
                else
                {
                  $text_style = ''; 
                }
            ?>
               <th <?php echo $style; ?>>
                  <div class="cell-inner">
                      
                      <?php 
                        if(!empty($value['header_text']))
                        {
                          echo '<span '.$text_style.'>' . esc_html($value['header_text']) . '</span>'; 
                        }
                         if(!empty($value['header_subtitle']))
                        {
                          echo '<span>' . esc_html($value['header_subtitle']) . '</span>'; 
                        }
                      ?>
                  </div>
                  <?php
                  if(!empty($value['header_tag'])) 
                  ?>
                  <div class="cell-tag">
                      <span><?php echo $value['header_tag'] ?></span>
                  </div>
                 
                </th>
           <?php 
            } 
            ?>  
        </tr>
      </thead>
      <tbody>
         <tr>
            <?php
            foreach ($table_body as $ind => $value) 
            {
              if($value['next_row'] == 'yes'){
                  echo '</tr><tr>';
                }
                $icon = '';
                if (!empty($value['body_icon']['value']))
                {
                     if(!empty($value['icon_color']))
                      {
                        $color = $value['icon_color'];
                      }
                      else
                      {
                        $color = '#606C7A';
                      }
                    
                    $icon = sprintf('<i class="%1$s" style="color:%2$s;"></i>', esc_attr($value['body_icon']['value']) , $color);
                }

                if ( ! empty( $value['btn_link']['url'] ) )
                {
                    $this->add_render_attribute( 'btn_attr_link'.$ind, 'href', $value['btn_link']['url'] );
                    if ( $value['btn_link']['is_external'] ) {
                        $this->add_render_attribute( 'btn_attr_link'.$ind, 'target', '_blank' );
                    }
                    if ( ! empty( $value['btn_link']['nofollow'] ) ) {
                        $this->add_render_attribute( 'btn_attr_link'.$ind, 'rel', 'nofollow' );
                    }
                }
                 if(!empty($value['body_back_color']))
                {
                  $style = 'style = background-color:'.$value['body_back_color'].';';
                }
                else
                {
                  $style = ''; 
                }

                if(!empty($value['body_text_color']))
                {
                  $text_style = 'style = color:'.$value['body_text_color'].';';
                }
                else
                {
                  $text_style = ''; 
                }
            ?>
               <td <?php echo $style; ?>> 
                  <div class="cell-inner">
                    
                      <?php echo $icon; ?>
                      <?php
                        if(!empty($value['body_text']))
                        {
                          echo '<span '.$text_style.'>'.esc_html($value['body_text']).'</span>'; 
                        } 
                        if(!empty($value['body_subtitle']))
                        {
                          echo '<span>'.esc_html($value['body_subtitle']).'</span>'; 
                        } 
                      ?>
                    
                  </div>
                  <?php 
                           $btn_text = '';
                            // if(!empty($settings['button_text'])) 
                            // {
                            //   $btn_text = $settings['button_text'];
                            // }
                            if(!empty($value['rep_btn_text'])) 
                            {
                              $btn_text = $value['rep_btn_text'];
                            }
                             if(!empty($btn_text))
                            {
                          ?>
                  <div class="cell-btn-holder">
                    <div class="gen-btn-container">
                        <div class="gen-button-block">
                         
                          <a <?php echo $this->get_render_attribute_string('btn_attr_1'); ?> <?php echo $this->get_render_attribute_string('btn_attr_link'.$ind); ?>>
                            <?php
                            
                           
                            ?>
                          <span class="text"><?php echo esc_html($btn_text); ?></span>
                       
                          </a>
                          
                        </div>
                    </div>
                  </div>
               
                  <?php } ?>
                    
                </td>
           <?php 
            } 
            ?>  
        </tr>
      </tbody>
    </table>
</div>