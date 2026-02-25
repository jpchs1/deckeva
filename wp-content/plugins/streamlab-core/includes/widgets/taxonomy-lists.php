<?php

add_action( 'widgets_init', 'Stremlab_core_Streamlab_Taxonomy_Lists' );
function Stremlab_core_Streamlab_Taxonomy_Lists()
{
	register_widget( 'Streamlab_Taxonomy_Lists' );
}
class Streamlab_Taxonomy_Lists extends \WP_Widget
{
	function __construct()
	{
		$opts = array(
			'classname' => 'Streamlab_Taxonomy_Lists',
			'description' => __( 'Streanlab Videos Genre And Tags' )
		);
		
		parent::__construct( 'Streamlab_Taxonomy_Lists', __( 'Videos Genre And Tags' ), $opts );
	}

	function get_selected( $args1 , $args2 )
	{
		
		if($args1 == $args2)
		{
			echo "selected";
		}
		
	}
	
	function form( $instance )
	{
		
		$defaults = array(
			'title'		=> '',
			'video_type' 	=> 'movie',
			'taxo_type' 	=> 'genre',
		);
		
		$instance = wp_parse_args( $instance, $defaults );
		$display = array( 
			'twitter' 	=> __( 'Your Latest Tweet' ),
			'custom'	=> __( 'A Custom Mesage' )
		);
		?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title' ); ?></label>
				<input type="text" name="<?php echo $this->get_field_name( 'title' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
			</p>
			
		
			<p>
				<label for="<?php echo $this->get_field_id( 'video_type' ); ?>"><?php _e( 'Video Type' ); ?></label>
				<select name="<?php echo $this->get_field_name( 'video_type' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'video_type' ); ?>">

					<option value="movie" <?php $this->get_selected($instance['video_type'] , 'movie' ) ?> >Movies</option>
					<option value="tv_show" <?php $this->get_selected( $instance['video_type'] , 'tv_show' ) ?> >Tv Shows</option>
					<option value="video" <?php $this->get_selected( $instance['video_type'] , 'video' ) ?>>Videos</option>
					
				</select>
				
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'show_count' ); ?>"><?php _e( 'Show Count' ); ?></label>
				<input type="checkbox" name="<?php echo $this->get_field_name( 'show_count' ); ?>" id="<?php echo $this->get_field_id( 'show_count' ); ?>" class="widefat" value="yes" <?php echo $instance['show_count'] == 'yes' ? 'checked' : '' ?>>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'taxo_type' ); ?>"><?php _e( 'Video Type' ); ?></label>
				<select name="<?php echo $this->get_field_name( 'taxo_type' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'taxo_type' ); ?>">

					<option value="genre" <?php $this->get_selected($instance['taxo_type'] , 'genre' ) ?> >Genre</option>
					<option value="tag" <?php $this->get_selected( $instance['taxo_type'] , 'tag' ) ?> >Tag</option>
					
					
				</select>
				
			</p>
		
		<?php
	}
	
	function update( $new, $old )
	{	
		$clean = $old;
		$clean['title'] = isset( $new['title'] ) ? strip_tags( esc_html( $new['title'] ) ) : '';
	

		$clean['video_type'] = isset( $new['video_type'] ) ? esc_attr( $new['video_type'] ) : '';

		$clean['taxo_type'] = isset( $new['taxo_type'] ) ? esc_attr( $new['taxo_type'] ) : '';
		$clean['show_count'] = isset( $new['show_count'] ) ? esc_attr( $new['show_count'] ) : '';

		return $clean;
	}
	
	function widget( $args, $instance )
	{
		extract( $args );
		echo $before_widget;
		if( $instance['title'] ) 
		{
			echo $before_title . strip_tags( $instance['title'] ) . $after_title;
		}

		$taxo = '';
		if( $instance['video_type']) 
		{
			$taxo = $instance['video_type']."_".$instance['taxo_type'];
		}

		if( $instance['video_type'] == 'video' && $instance['taxo_type'] == 'genre') 
		{
			$taxo = 'video_cat';
		}

		if($instance['taxo_type'] == 'genre')
		{
			$ul_class = 'gen-genre';
		}
		if($instance['taxo_type'] == 'tag')
		{
			$ul_class = 'gen-tag';
		}
		
		 $args = array(
	    	'taxonomy' => $taxo,
	    	'hide_empty' => true,
	    	'hierarchical' => 1,
	    	'parent' => 0
	    );
	    $wp_object =  get_categories($args);

		?>
			<div class="gen-taxo-filter-widget">
				<ul class="<?php echo $ul_class; ?>">

				<?php 
				 if (!empty($wp_object)) {
	    			foreach ($wp_object as $val) {
	    				?>
	    				<li>
	    					<a href="<?php echo get_category_link( $val->term_id ); ?>"><span><?php echo $val->name; ?></span></a>
	    					<?php 
	    					if($instance['show_count'] == 'yes')
	    					{
	    					?>
	    					<span>(<?php echo $val->count; ?>)</span>
	    					<?php } ?>
	    				</li>
	    				

	    				<?php 
	    			}
	    		}
	    ?>
				
	    	</ul>
			</div>
		<?php
		echo $after_widget;
	}

	
	

} // end class

