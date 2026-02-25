<?php
namespace Elementor; 

if ( ! defined( 'ABSPATH' ) ) exit;
$theme_options = get_option('theme_options');  
?>
<div class=""> 
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
          // get_template_part( 'template-parts/post/content', 'post' , array('editor' => true));
          ?>
          <div class="gen-blog-post">
    <div class="gen-post-media">
      <?php
        if(has_post_thumbnail())
        {
          the_post_thumbnail();
      ?>
        
      <?php 
        } 
      ?>
    </div>
    <div class="gen-blog-contain">
      <?php
          $archive_year  = get_the_time( 'Y' ); 
          $archive_month = get_the_time( 'm' ); 
          $archive_day   = get_the_time( 'd' ); 
          ?>
    <div class="gen-post-meta">
      <ul>        
       <li class="gen-post-author"><i class="fa fa-user"></i><?php the_author(); ?></li>
        <li class="gen-post-meta"><a href="<?php echo esc_url( get_day_link( $archive_year, $archive_month, $archive_day ) ); ?>"><i class="fa fa-calendar"></i><?php echo esc_html( get_the_date( 'F Y', get_the_ID() ) ); ?></a>
        </li>
        <li class="gen-post-tag">
           <?php
          $i =0;
          $categories = get_the_category( get_the_ID() );
          foreach( $categories as $category ) {
            if($i==0)
            {
            ?>
           <a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>"><i class="fa fa-tag"></i><?php echo esc_attr( $category->name ) ?></a>
            <?php   
            $i++;     
          }}         
          ?> 
        </li>
       
      </ul>
    </div>
      <?php
      if(!is_single())
      {
      ?>
       <?php
      if(!is_single())
      {
      ?>
      <h5 class="gen-blog-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
      <?php } ?>
      <?php } ?>
     
          <?php
         
            the_excerpt();
            
            ?> 
            <div class="gen-btn-container">
        <a href="<?php echo esc_url(get_the_permalink()); ?>" <?php echo $this->get_render_attribute_string('btn_attr'); ?> >
          <div class="gen-button-block">
            <span class="gen-button-line-left"></span>
            <span  class="gen-button-text"><?php echo esc_html($settings['button_text']); ?></span>
            <span class="gen-button-line-right"></span>
            <?php echo $icon; ?>
          </div>  
      </a>
    </div>
            <?php 
          
          wp_link_pages( array(
            'before'      => '<div class="page-links">' . esc_html__( 'Pages:', 'architek' ),
            'after'       => '</div>',
            'link_before' => '<span class="page-number">',
            'link_after'  => '</span>',
          ) );
          ?>
     
          
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