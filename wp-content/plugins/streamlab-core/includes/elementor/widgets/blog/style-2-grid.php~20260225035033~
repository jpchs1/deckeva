<?php
namespace Elementor; 
use gentechtree\streamlab\Helper;
use gentechtree\streamlab\Options;
if ( ! defined( 'ABSPATH' ) ) exit;
$theme_options = get_option('theme_options');  
if($settings['blog_style'] === "1")
    {
        $col = 'col-lg-12';
        $grid = 'gen-blog-col-1';
    }
    if($settings['blog_style'] === "2")
    {
        $col = 'col-lg-6';
        $grid = 'gen-blog-col-2';
    }
    if($settings['blog_style'] === "3")
    {
        $col = 'col-lg-4';
        $grid = 'gen-blog-col-3';
    }
  
?>
<div class="gen-blog <?php echo esc_attr($grid); ?>">
  <div class="row">
    <?php

 
     
    if ($wp_query -> have_posts() ) 
    {
      while ($wp_query -> have_posts() ) 
      {
        $wp_query->the_post();
          
        ?>
        <div class="<?php echo esc_attr($col); ?>">
          <?php
          //masvideos_get_template_part( 'content', 'movie' );
          // get_template_part( 'template-parts/post/content', 'post' , array('editor' => true));

       
          ?>
          <div class="gen-blog-post">
   
      <?php
        if(has_post_thumbnail())
        {
          ?>
           <div class="gen-post-media">
          <?php
          the_post_thumbnail();
          ?>
      
         </div>
      <?php 
        } 
      ?>
   
    <div class="gen-blog-contain">
      <?php
          $archive_year  = get_the_time( 'Y' ); 
          $archive_month = get_the_time( 'm' ); 
          $archive_day   = get_the_time( 'd' ); 
          ?>
    <div class="gen-post-meta">
       <?php 
      if(is_sticky() && !is_single())
        {
        ?>
        <span class="gen-sticky-post-label"><i class="fa fa-star" aria-hidden="true"></i><?php echo esc_html__('Featured', 'streamlab-core') ?></span>
        <?php } ?>
      <ul>
               
       <li class="gen-post-author"><i class="fa fa-user"></i><?php the_author(); ?></li>

        <li class="gen-post-meta"><a href="<?php echo esc_url( get_day_link( $archive_year, $archive_month, $archive_day ) ); ?>"><i class="fa fa-calendar"></i><?php the_time( get_option( 'date_format' ) ); ?></a>
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

      
        <h5 class="gen-blog-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
        <p><?php the_excerpt(); ?></p>
        <?php 
           

            $btn_text = 'Read More';
            if(isset($theme_options['blog_btn_text']) && !empty($theme_options['blog_btn_text']))
            {
              $btn_text = $theme_options['blog_btn_text'];
            } 
            ?>            

            <div class="gen-btn-container">
              <a href="<?php the_permalink(); ?>" class="gen-button">
                <div class="gen-button-block">
                  <span  class="gen-button-text"><?php echo esc_html($btn_text); ?></span>
                </div>  
              </a>
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
  <div class="row">
    
      <?php 
       if ($paginate_links) {
  
        echo '<div class="col-lg-12 col-md-12 col-sm-12">
          <div class="gen-pagination">       
              <nav aria-label="Page navigation">';
              printf( esc_html__('%s','hostingo-core'),$paginate_links);
              echo '</nav>
            </div>
          </div>';
    }
      ?>
   
  </div>
</div>
