<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package NewsAnchor
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div class="preloader">
    <div class="spinner">
        <div class="pre-bounce1"></div>
        <div class="pre-bounce2"></div>
    </div>
</div>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'newsanchor' ); ?></a>

   	<header id="header" class="header">
	   	<div class="top-header">
	   		<div class="container">
				<?php if ( has_nav_menu( 'social' ) ) : ?>
					<nav class="social-navigation clearfix">
						<?php wp_nav_menu( array( 'theme_location' => 'social', 'link_before' => '<span class="screen-reader-text">', 'link_after' => '</span>', 'menu_class' => 'menu clearfix', 'fallback_cb' => false ) ); ?>
					</nav>
				<?php endif; ?>		   					
			</div>
	   	</div><!-- /.top-header -->

	   	<div class="main-header">
			<div class="container">
				<div class="row">
					<div class="col-md-4">
		              	<div id="logo" class="logo">
				        <?php if ( get_theme_mod('site_logo') ) : ?>
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo('name'); ?>"><img class="site-logo" src="<?php echo esc_url(get_theme_mod('site_logo')); ?>" alt="<?php bloginfo('name'); ?>" /></a>
				        <?php else : ?>
							<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
							<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>	        
				        <?php endif; ?>
		            	</div>
		            </div>

		            <?php if ( is_active_sidebar( 'sidebar-header' ) ) : ?>
		            <div class="col-md-8">
		            	<div class="banner_ads">
							<?php dynamic_sidebar( 'sidebar-header' ); ?>
		            	</div>
		            </div>
		            <?php endif; ?>
	            </div>
	         </div>
	   	</div><!-- /.main-header -->

		<div class="bottom-header">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="header-nav clearfix">
							<div class="btn-menu"></div><!-- //mobile menu button -->
							<nav id="mainnav" class="mainnav">
								<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', 'container' => false, 'menu_class' => 'clearfix', 'fallback_cb' => 'newsanchor_menu_fallback',) ); ?>
							</nav><!-- /nav -->
							<div class="search-header">
								<?php get_search_form(); ?>
							</div>
						</div>
					</div><!-- /.col-md-12 -->
				</div><!-- /.row -->
			</div><!-- /.container -->
		</div><!-- /.bottom-header -->
	</header>

	<div class="page-content">
		<div class="container content-wrapper">
			<div class="row">
				<?php echo newsanchor_carousel(); ?>
