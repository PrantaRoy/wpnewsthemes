<?php

/**
 * Recent posts type A widget
 *
 */

class NewsAnchor_Recent_A extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'recent_posts_a clearfix', 'description' => __( 'Recent posts widget Type A (front page)', 'newsanchor') );
		parent::__construct('recent_posts_a', __('NewsAnchor: Recent posts type A', 'newsanchor'), $widget_ops);
		$this->alt_option_name = 'recent_posts_a';

		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );
	}

	public function widget($args, $instance) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'recent_posts_a', 'widget' );
		}

		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();

		$title 		= ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
		$title 		= apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$category 	= isset( $instance['category'] ) ? esc_attr($instance['category']) : '';

		$left_query = new WP_Query( array(
			'posts_per_page'      => 1,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
			'category_name' 	  => $category,

		) );

		$right_query = new WP_Query( array(
			'offset'			  => 1,
			'posts_per_page'      => 6,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
			'category_name' 	  => $category,

		) );		

		if ($left_query->have_posts()) :
?>
		<?php echo $args['before_widget']; ?>

		<div class="lastest-posts">
		<?php if ( $title ) { echo $args['before_title'] . $title . $args['after_title']; } ?>


		<div class="content-left">
		<?php while ( $left_query->have_posts() ) : $left_query->the_post(); ?>

			<div class="post">
				<div class="recent-thumb">
				<?php if ( has_post_thumbnail() ) : ?>
					<?php the_post_thumbnail('newsanchor-large-thumb'); ?>
				<?php endif; ?>											
				</div>	
				<div class="recent-content">
					<?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>				
					<?php the_excerpt(); ?>
					<div class="post-meta activity">
						<?php newsanchor_posted_on(); ?>
					</div>					
				</div>
			</div>

		<?php endwhile; ?>
		</div>

		<div class="content-right clearfix">
		<?php while ( $right_query->have_posts() ) : $right_query->the_post(); ?>

			<div class="post">
				<div class="thumb">
				<?php if ( has_post_thumbnail() ) : ?>
					<?php the_post_thumbnail('newsanchor-small-thumb'); ?>
				<?php endif; ?>											
				</div>	
				<div class="content">
					<?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>				
				</div>			
			</div>

		<?php endwhile; ?>	
		</div>
		
		</div>	
		<?php echo $args['after_widget']; ?>
<?php
		wp_reset_postdata();

		endif;

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'recent_posts_a', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] 		= strip_tags($new_instance['title']);
		$instance['category'] 	= strip_tags($new_instance['category']);
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['recent_posts_a']) )
			delete_option('recent_posts_a');

		return $instance;
	}

	public function flush_widget_cache() {
		wp_cache_delete('recent_posts_a', 'widget');
	}

	public function form( $instance ) {
		$title  	= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$category  	= isset( $instance['category'] ) ? esc_attr( $instance['category'] ) : '';
?>

		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php _e( 'Title:', 'newsanchor' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Enter the slug for your category or leave empty to show posts from all categories.', 'newsanchor' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>" type="text" value="<?php echo $category; ?>" size="3" /></p>
<?php
	}
}