<?php
namespace Streamlab_Core\Elementor_widgets; 

class Custom_Post_Data
{
	public function get_custom_post($post_type = '' , $return = '')
	{
		$array = array();
		global $post;
		$args = array(
			'post_type'         => $post_type,
			'post_status'       => 'publish',
			'posts_per_page' => -1
		);
		$wp_query = new \WP_Query($args);
		if ($wp_query->have_posts()) {
			while ($wp_query->have_posts()) {
				$wp_query->the_post();
				if ($return == 'id') {
					$array[get_the_ID()] = get_the_title();
				}
				if ($return == 'slug') {
					$array[$post->post_name] = get_the_title();
				}
			}
		}
		return $array;
	}
	
	public function get_taxonony($taxonony = '')
	{
		if (empty($taxonony)) {
			return;
		}
	    $show_count = 0; // 1 for yes, 0 for no
	    $pad_counts = 0; // 1 for yes, 0 for no
	    $hierarchical = 1; // 1 for yes, 0 for no
	    $title = '';
	    $empty = 0;
	    $array = array();
	    $args = array(
	    	'taxonomy' => $taxonony,
	    	'show_count' => $show_count,
	    	'pad_counts' => $pad_counts,
	    	'hierarchical' => $hierarchical,
	    	'hide_empty' => false,
	    	'parent' => 0
	    );
	    $wp_object =  get_categories($args);
	    $array[0] = 'select taxonomy';
	    if (!empty($wp_object)) {
	    	foreach ($wp_object as $val) {
	    		
	    		$array[$val->term_id] = $val->name;
	    	}
	    }
	    return $array;
	}
	public function build_args( $post_type = '' , $settings = array() , $taxos = array())
	{
		$tax_query = array();
   
   		$taxargs = array();
   		// global $paged;
	    //  if (empty($paged)) {
	    // 	 $paged = 1;
	    //  }
	    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

		$args = array(
	       'post_type'         => $post_type,
	       'post_status'       => 'publish', 
	       'paged' => $paged
   		);
   		if(!empty($settings['post_ids']))
   		{
   			$args['post__in'] = $settings['post_ids'];	
   		}
   		if(!empty($settings['posts_per_page']))
   		{
   			$args['posts_per_page'] = $settings['posts_per_page'];	
   		}
   		if(!empty($settings['order']))
   		{
   			$args['order'] = $settings['order'];	
   		}
   		if(!empty($taxos))
   		{
   			foreach($taxos as $key=>$val)
   			{
   			if(!empty($settings[$key]))
   			{
			   $tax_query['taxonomy'] = $val;
		       $tax_query['field'] = 'term_id';
		       $tax_query['terms'] = $settings[$key];
		       $tax_query['operator'] = 'IN';
		       array_push($taxargs, $tax_query);
   			}	
   			}
	   		if(!empty($tax_query))
	   		{
		       $args['tax_query'] = $taxargs;
		       $args['tax_query']['relation'] = 'AND';
	   		}
   		}
   		if(!empty($settings['meta_filter']))
   		{
   			if($settings['meta_filter'] == 'liked')
   			{
   				$args['meta_key'] = '_post_like_count'; 
     			$args['orderby'] = 'meta_value_num';
     			$args['order'] = 'DESC';	
   			}

   			if($settings['meta_filter'] == 'view')
   			{
   				$args['meta_key'] = 'post_views_count'; 
     			$args['orderby'] = 'meta_value_num';
     			$args['order'] = 'DESC';	
   			}

   			if($settings['meta_filter'] == 'new')
   			{
   				$args['meta_key'] = 'post_views_count'; 
     			$args['orderby'] = 'post_date';
     			$args['order'] = 'DESC';	
   			}
   			
   		}
   		return $args;
   		
	}

	public function get_layout_controls($obj)
	{
		$obj->add_control(
			'layout',
			[
				'label' => __( 'Grid', 'streamlab-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'multiple' => false,
				'default' => '3',
				'options' => [
					'1'  => __( 'One Column', 'streamlab-core' ),
					
					'2'  => __( 'Two Column', 'streamlab-core' ),
					'3'  => __( 'Three Column', 'streamlab-core' ),
					'4'  => __( 'Four Column', 'streamlab-core' ),
					'5'  => __( 'Six Column', 'streamlab-core' ),
					
				],
				'condition' => ['layout_style' => ['grid']]	
							
			]
		);

		$obj->add_control(
			'load_type',
			[
				'label' => __( 'Load Type', 'streamlab-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'multiple' => false,
				'default' => 'pagination',
				'options' => [
					'pagination' => 'pagination',
            		'loadmore' => 'loadmore',
            		'infscroll' => 'Infinity Scroll',
            		
				],
				'condition' => ['layout_style' => ['grid']]	
							
			]
		);

		$obj->add_control(
			'posts_per_page',
			[
				'label' => __( 'Posts Per Page', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => -1,
				
				'step' => 1,
				'default' => 10,
			]
		);

		$obj->add_control(
			'order',
			[
				'label' => __( 'Order', 'streamlab-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'multiple' => false,
				'default' => 'inherit',
				'options' => [
					'DESC' => 'DESC',
            		'ASC' => 'ASC',
				],
				
							
			]
		);

		$obj->add_control(
			'meta_filter',
			[
				'label' => __( 'Filter', 'streamlab-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'multiple' => false,
				'default' => '',
				'options' => [
					'none' => 'none',
					'liked' => 'Most Liked',
            		'view' => 'Most Viewed',
            		'new' => 'Newly Added',
				],
				
							
			]
		);

		$obj->add_control(
			'watch_trailer',
			[
				'label' => __( 'Watch Traielr Text | Watch Now Text', 'streamlab-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'multiple' => false,
				'default' => 'Watch Trailor',
				'label_block' => true,

				'condition' => ['layout_style' => [ 'banner-slider-style-3' , 'banner-slider-style-1']]
			]
		);

		

		$obj->add_control(
			'cast_title',
			[
				'label' => __( 'Cast title', 'streamlab-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'multiple' => false,
				'default' => 'Cast',

				'condition' => ['layout_style' => [  'banner-slider-style-1']]
							
			]
		);
		$obj->add_control(
			'genre_title',
			[
				'label' => __( 'Genre title', 'streamlab-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'multiple' => false,
				'default' => 'Genre',

				'condition' => ['layout_style' => [  'banner-slider-style-1']]
							
			]
		);
		$obj->add_control(
			'tag_title',
			[
				'label' => __( 'Tag title', 'streamlab-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'multiple' => false,
				'default' => 'Tags',

				'condition' => ['layout_style' => [  'banner-slider-style-1']]
							
			]
		);


	}

	public function get_load_type($type , $id)
	{
		if(isset( $type ))
		{
			if( $type  == 'loadmore')
			{
				echo esc_attr( 'row post-loadmore-wrapper-'.$id ) ;
			}
			else if( $type == 'infscroll')
			{
				echo esc_attr( 'row post-infscroll-wrapper-'.$id );
			}
			else if( $type == 'pagination')
			{
				echo esc_attr( 'row' );
			}
			
		}
		else
		{
			echo esc_attr( 'row' );
		}
	} 

	public function get_layout($layout = '')
	{
		if($layout == '5')
		{
			$get_layout = esc_attr('col-xl-2 col-lg-4 col-md-6');
		}
		else if($layout == '4')
		{
			$get_layout = esc_attr('col-xl-3 col-lg-4 col-md-6');
		}
		else if($layout == '3')
		{
			$get_layout = esc_attr('col-xl-4 col-lg-4 col-md-6');
		}
		else if($layout == '2')
		{
			$get_layout = esc_attr('col-xl-6 col-lg-6 col-md-6');
		}
		else if($layout == '1')
		{
			$get_layout = esc_attr('col-xl-12 col-lg-12 col-md-12');
		}
		else
		{
			$get_layout = esc_attr('col-xl-3 col-lg-4 col-md-6');
		}

		echo esc_attr($get_layout);
	}

	public function pagination( $wp_query,$paged = '' )
	{
		  global $paged;
		  if (empty($paged)) 
		  {
		  	$paged = 1;
		  }
		  
		
		   $pagination_args = array(
		    //'base'            => get_pagenum_link(1) . '%_%',
		    'format'      => '?paged=%#%',
		    'total'           => $wp_query->max_num_pages,
		    'current'         => $paged,
		    'show_all'        => False,
		    'end_size'        => 1,
		    'mid_size'        => 2,
		    'prev_next'       => True,
		    'prev_text'       =>  esc_html__( 'Previous page', 'streamlabcore' ),
		    'next_text'       => esc_html__( 'Next page', 'streamlabcore' ),
		    'type'            => 'list',
		    'add_args'        => false,
		    'add_fragment'    => ''
    		); 

    		
   			$paginate_links = paginate_links($pagination_args);

   			if ($paginate_links) {
  
		        echo '<div class="col-lg-12 col-md-12">
						<div class="gen-pagination">				
							<nav aria-label="Page navigation">';
							printf( esc_html__('%s','streamlab-core'),$paginate_links);
							echo '</nav>
						</div>
					</div>';
    		}
	}
}
