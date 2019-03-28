<?php
/**
 * @package NewsAnchor
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( has_post_thumbnail() && ( get_theme_mod( 'index_feat_image' ) != 1 ) ) : ?>
		<div class="thumb">
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail('newsanchor-large-thumb'); ?></a>
		</div>
	<?php endif; ?>

	<div class="content-entry">
		<header class="entry-header">
			<?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
		</header><!-- .entry-header -->
		<div class="excerpt-entry">
			<?php the_excerpt(); ?>
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'newsanchor' ),
					'after'  => '</div>',
				) );
			?>
		</div>
		<?php if ( 'post' == get_post_type() && get_theme_mod('hide_meta_index') != 1 ) : ?>
		<div class="post-meta activity">
			<?php newsanchor_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>		
	</div>

</article><!-- #post-## -->
