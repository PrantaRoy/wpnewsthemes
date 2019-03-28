<?php

/**
 * Recent posts type B widget
 *
 */

class NewsAnchor_Recent_B extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'recent_posts_b clearfix', 'description' => __( 'Recent posts widget Type B (front page)', 'newsanchor') );
		parent::__construct('recent_posts_b', __('NewsAnchor: Recent posts type B', 'newsanchor'), $widget_ops);
		$this->alt_option_name = 'recent_posts_b';

		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );
	}

	public function widget($args, $instance) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'recent_posts_b', 'widget' );
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

		$cat_one 	= isset( $instance['cat_one'] ) ? esc_attr($instance['cat_one']) : '';
		$cat_two 	= isset( $instance['cat_two'] ) ? esc_attr($instance['cat_two']) : '';

		$left_query = new WP_Query( array(
			'posts_per_page'      => 4,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
			'category_name' 	  => $cat_one,

		) );

		$right_query = new WP_Query( array(
			'posts_per_page'      => 4,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
			'category_name' 	  => $cat_two,

		) );		

?>
		<?php echo $args['before_widget']; ?>

		<div class="row-custom">

		<div class="one-half">

		<?php $cat = get_term_by('slug', $cat_one, 'category') ?>
		<?php if ($cat) {
			echo '<h3 class="roll-title"><a href="' . esc_url(get_category_link(get_cat_ID($cat -> name))) . '">' . $cat -> name . '</a></h3>';
		} ?>

		<?php $counter = 1; ?>	
		<?php while ( $left_query->have_posts() ) : $left_query->the_post(); ?>

		<?php if( $counter == 1 ) : ?>
			<div class="post">
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="thumb">
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" >
						<?php the_post_thumbnail('newsanchor-medium-thumb'); ?>
					</a>							
				</div>	
			<?php endif; ?>
				<div class="recent-content">					
					<?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
					<div class="activity">
						<?php newsanchor_posted_on(); ?>
					</div>					
				</div>
			</div>
		<?php else : ?>	
			<div class="sub-post clearfix">
				<div class="thumb">
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" >
						<?php if ( has_post_thumbnail() ) : ?>
							<?php the_post_thumbnail('newsanchor-small-thumb'); ?>
						<?php endif; ?>	
					</a>			
				</div>
				<div class="content">
					<?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
				</div>
			</div>
		<?php endif; ?>
		<?php  $counter++; ?>
		<?php endwhile; ?>
		</div>

		<div class="one-half">

		<?php $cat = get_term_by('slug', $cat_two, 'category') ?>
		<?php if ($cat) {
			echo '<h3 class="roll-title"><a href="' . esc_url(get_category_link(get_cat_ID($cat -> name))) . '">' . $cat -> name . '</a></h3>';
		} ?>

		<?php $counter = 1; ?>	
		<?php while ( $right_query->have_posts() ) : $right_query->the_post(); ?>
		<?php if( $counter == 1 ) : ?>
			<div class="post">
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="thumb">
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" >
						<?php the_post_thumbnail('newsanchor-medium-thumb'); ?>
					</a>							
				</div>	
			<?php endif; ?>
				<div class="recent-content">					
					<?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
					<div class="activity">
						<?php newsanchor_posted_on(); ?>
					</div>					
				</div>
			</div>
		<?php else : ?>	
			<div class="sub-post clearfix">
				<div class="thumb">
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" >
						<?php if ( has_post_thumbnail() ) : ?>
							<?php the_post_thumbnail('newsanchor-small-thumb'); ?>
						<?php endif; ?>	
					</a>			
				</div>
				<div class="content">
					<?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
				</div>
			</div>
		<?php endif; ?>
		<?php  $counter++; ?>
		<?php endwhile; ?>	

		</div>	

		<?php echo $args['after_widget']; ?>
<?php
		wp_reset_postdata();

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'recent_posts_b', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['cat_one'] 	= strip_tags($new_instance['cat_one']);
		$instance['cat_two'] 	= strip_tags($new_instance['cat_two']);
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['recent_posts_b']) )
			delete_option('recent_posts_b');

		return $instance;
	}

	public function flush_widget_cache() {
		wp_cache_delete('recent_posts_b', 'widget');
	}

	public function form( $instance ) {
		$cat_one  	= isset( $instance['cat_one'] ) ? esc_attr( $instance['cat_one'] ) : '';
		$cat_two  	= isset( $instance['cat_two'] ) ? esc_attr( $instance['cat_two'] ) : '';
?>

		<p><label for="<?php echo $this->get_field_id( 'cat_one' ); ?>"><?php _e( 'Enter the slug for your first category.', 'newsanchor' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'cat_one' ); ?>" name="<?php echo $this->get_field_name( 'cat_one' ); ?>" type="text" value="<?php echo $cat_one; ?>" size="3" /></p>

		<p><label for="<?php echo $this->get_field_id( 'cat_two' ); ?>"><?php _e( 'Enter the slug for your second category.', 'newsanchor' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'cat_two' ); ?>" name="<?php echo $this->get_field_name( 'cat_two' ); ?>" type="text" value="<?php echo $cat_two; ?>" size="3" /></p>

<?php
	}
}