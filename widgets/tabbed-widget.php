<?php

/**
 * Recent posts type B widget
 *
 */

class NewsAnchor_Tabbed extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'tabbed_widget clearfix', 'description' => __( 'Tabbed widget', 'newsanchor') );
		parent::__construct('tabbed_widget', __('NewsAnchor: Tabbed', 'newsanchor'), $widget_ops);
		$this->alt_option_name = 'tabbed_widget';

		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );
	}

	public function widget($args, $instance) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'tabbed_widget', 'widget' );
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

?>
		<?php echo $args['before_widget']; ?>

		<div class="tabs">
			<ul class="menu-tab">
				<li class="active"><a href="#"><?php echo __('Tags','newsanchor'); ?></a></li>
				<li><a href="#"><?php echo __('Latest','newsanchor'); ?></a></li>
				<li><a href="#"><?php echo __('Comments','newsanchor'); ?></a></li>
			</ul>
			<div class="content-tab">
				<div class="content">
					<?php the_widget( 'WP_Widget_Tag_Cloud', 'title= ' ); ?>	
				</div>
				<div class="content">
					<?php the_widget( 'NewsAnchor_Recent_Posts', 'title= &number=3&show_date=1' ); ?>
				</div>
				<div class="content">
					<?php the_widget( 'NewsAnchor_Recent_Comments', 'title= &number=3' ); ?>
				</div>
			</div>
		</div>

		<?php echo $args['after_widget']; ?>
<?php


		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'tabbed_widget', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['tabbed_widget']) )
			delete_option('tabbed_widget');

		return $instance;
	}

	public function flush_widget_cache() {
		wp_cache_delete('tabbed_widget', 'widget');
	}

	public function form( $instance ) {
?>

		<p><?php echo __('There are no settings for this widget. Simply add it in your sidebar', 'newsanchor'); ?></p>

<?php
	}
}