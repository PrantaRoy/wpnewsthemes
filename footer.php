<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package NewsAnchor
 */
?>

			</div>
		</div>		
	</div><!-- .page-content -->

    <a class="go-top">
        <i class="fa fa-angle-up"></i>
    </a>

	<footer id="colophon" class="site-info" role="contentinfo">
		<div class="go-top2"></div>

		<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
			<?php get_sidebar('footer'); ?>
		<?php endif; ?>

		<div class="container">
			<a href="<?php echo esc_url( __( 'https://www.facebook.com/pranta.roy1995', 'MHC' ) ); ?>"><?php printf( esc_html__( 'Design & Developed by %s', 'MHC' ), 'Pranta Roy' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( esc_html__( 'Copyright @ 2019: %2$s by %1$s.', 'Meherpurer Chokh' ), 'Meherpurer Chokh', '<a href="http://www.mchokh.com" rel="designer"Pranta Roy</a>' ); ?>
		</div><!-- /.container -->
	</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
