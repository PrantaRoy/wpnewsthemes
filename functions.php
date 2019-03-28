<?php
/**
 * NewsAnchor functions and definitions
 *
 * @package NewsAnchor
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 1170; /* pixels */
}

if ( ! function_exists( 'newsanchor_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function newsanchor_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on NewsAnchor, use a find and replace
	 * to change 'newsanchor' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'newsanchor', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size('newsanchor-large-thumb', 730);
	add_image_size('newsanchor-carousel-thumb', 410, 260, true);
	add_image_size('newsanchor-medium-thumb', 435);
	add_image_size('newsanchor-small-thumb', 80, 60, true);

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'newsanchor' ),
		'social'  => esc_html__( 'Social Menu', 'newsanchor' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'newsanchor_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // newsanchor_setup
add_action( 'after_setup_theme', 'newsanchor_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function newsanchor_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'newsanchor' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5 class="widget-title">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Home page', 'newsanchor' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'This widget area is displayed on the Front Page template', 'newsanchor' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside><div class="roll-spacer"></div>',
		'before_title'  => '<h4 class="roll-title">',
		'after_title'   => '</h4>',
	) );	

	register_sidebar( array(
		'name'          => esc_html__( 'Header widget area', 'newsanchor' ),
		'id'            => 'sidebar-header',
		'description'   => esc_html__( 'You can use this widget area to display ads inserted in a text widget. Use responsive ads for best results.', 'newsanchor' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="roll-title">',
		'after_title'   => '</h4>',
	) );

	//Footer widget areas
	$widget_areas = get_theme_mod('footer_widget_areas', '3');
	for ($i=1; $i<=$widget_areas; $i++) {
		register_sidebar( array(
			'name'          => __( 'Footer ', 'newsanchor' ) . $i,
			'id'            => 'footer-' . $i,
			'description'   => '',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	}	

	//Custom widgets
	register_widget( 'NewsAnchor_Recent_A' );
	register_widget( 'NewsAnchor_Recent_B' );
	register_widget( 'NewsAnchor_Recent_C' );
	register_widget( 'NewsAnchor_Tabbed' );
	register_widget( 'NewsAnchor_Recent_Comments' );
	register_widget( 'NewsAnchor_Recent_Posts' );
	register_widget( 'NewsAnchor_Video' );
}
add_action( 'widgets_init', 'newsanchor_widgets_init' );

//Custom widgets
require get_template_directory() . "/widgets/recent-posts-a.php";
require get_template_directory() . "/widgets/recent-posts-b.php";
require get_template_directory() . "/widgets/recent-posts-c.php";
require get_template_directory() . "/widgets/recent-comments.php";
require get_template_directory() . "/widgets/recent-posts.php";
require get_template_directory() . "/widgets/tabbed-widget.php";
require get_template_directory() . "/widgets/video-widget.php";

/**
 * Enqueue scripts and styles.
 */
function newsanchor_scripts() {

	if ( get_theme_mod('body_font_name') !='' ) {
	    wp_enqueue_style( 'newsanchor-body-fonts', '//fonts.googleapis.com/css?family=' . esc_attr(get_theme_mod('body_font_name')) ); 
	} else {
	    wp_enqueue_style( 'newsanchor-body-fonts', '//fonts.googleapis.com/css?family=PT+Sans:400,700');
	}

	if ( get_theme_mod('headings_font_name') !='' ) {
	    wp_enqueue_style( 'newsanchor-headings-fonts', '//fonts.googleapis.com/css?family=' . esc_attr(get_theme_mod('headings_font_name')) ); 
	} else {
	    wp_enqueue_style( 'newsanchor-headings-fonts', '//fonts.googleapis.com/css?family=Droid+Serif:400,700'); 
	}

	wp_enqueue_style( 'newsanchor-style', get_stylesheet_uri() );

	wp_enqueue_style( 'newsanchor-font-awesome', get_template_directory_uri() . '/fonts/font-awesome.min.css' );	

	wp_enqueue_script( 'newsanchor-fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', array('jquery'), '', true );

	wp_enqueue_script( 'newsanchor-imagesloaded', get_template_directory_uri() . '/js/imagesloaded.min.js', array(), '', true );				

	wp_enqueue_script( 'newsanchor-main', get_template_directory_uri() . '/js/main.js', array('jquery'), '', true );	

	wp_enqueue_script( 'newsanchor-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( get_theme_mod('blog_layout') == 'masonry-layout' && (is_home() || is_archive()) ) {

		wp_enqueue_script( 'newsanchor-masonry-init', get_template_directory_uri() . '/js/masonry-init.js', array('masonry'), '', true );		
	}	
}
add_action( 'wp_enqueue_scripts', 'newsanchor_scripts' );

/**
 * Enqueue Bootstrap
 */
function newsanchor_bootstrap() {
	wp_enqueue_style( 'newsanchor-bootstrap', get_template_directory_uri() . '/css/bootstrap/bootstrap.min.css', array(), true );
}
add_action( 'wp_enqueue_scripts', 'newsanchor_bootstrap', 9 );

/**
 * Menu fallback
 */
function newsanchor_menu_fallback() {
	echo '<a class="menu-fallback" href="' . admin_url('nav-menus.php') . '">' . __( 'Create your menu here', 'newsanchor' ) . '</a>';
}

/**
 * Load html5shiv
 */
function newsanchor_html5shiv() {
    echo '<!--[if lt IE 9]>' . "\n";
    echo '<script src="' . esc_url( get_template_directory_uri() . '/js/html5shiv.js' ) . '"></script>' . "\n";
    echo '<![endif]-->' . "\n";
}
add_action( 'wp_head', 'newsanchor_html5shiv' ); 

/**
 * Excerpt length
 */
function newsanchor_excerpt_length( $length ) {
	return 30;
}
add_filter( 'excerpt_length', 'newsanchor_excerpt_length', 11 );

/**
 * Set custom classes for the top menu items.
 */
function newsanchor_nav_menu_css_class( $classes = array(), $item, $args ) {
	static $top_level_count = 0;

    if($args->theme_location == 'primary'){

        if ( $item->menu_item_parent == 0 ) {
			$top_level_count++;

            if ($item->menu_order >= 0) {
                $classes[] = 'top-menu-item-' . $top_level_count % 6;
            }
        }
    }
    return $classes;
}
add_filter( 'nav_menu_css_class', 'newsanchor_nav_menu_css_class', 10, 3 );

/**
 * Blog layout
 */
function newsanchor_blog_layout() {
	$layout = get_theme_mod('blog_layout','classic');
	return $layout;
}

/**
 * Single layout
 */
function newsanchor_single_layout() {
	if ( get_theme_mod('fullwidth_single') ) {
		return 'fullwidth';
	}
}

/**
 * Posts class
 */
function newsanchor_posts_clearfix( $classes ) {
	$classes[] = 'clearfix';
	return $classes;
}
add_filter( 'post_class', 'newsanchor_posts_clearfix' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load the carousel
 */
require get_template_directory() . '/inc/carousel.php';

/**
 * Dynamic styles
 */
require get_template_directory() . '/inc/styles.php';