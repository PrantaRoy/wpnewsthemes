<?php
/*
Template Name: Front page
*/

get_header(); ?>

	<div id="primary" class="content-area col-md-8">

			<?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
			 	<?php dynamic_sidebar( 'sidebar-2' ); ?>
			<?php endif; ?>	

	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
