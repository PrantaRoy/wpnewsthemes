<?php
/**
 * @package NewsAnchor
 */

//Dynamic styles
function newsanchor_custom_styles($custom) {

	$custom = '';

	//Fonts
	$body_fonts 	= get_theme_mod('body_font_family');	
	$headings_fonts = get_theme_mod('headings_font_family');
	if ( $body_fonts !='' ) {
		$custom .= "body, .roll-title { font-family:" . wp_kses_post($body_fonts) . ";}"."\n";
	}
	if ( $headings_fonts !='' ) {
		$custom .= "h1, h2, h3, h4, h5, h6, .widget-categories li a, .roll-posts-carousel .item .text-over a, blockquote, .newsanchor_recent_comments .comment, .tabs .comments .comment { font-family:" . wp_kses_post($headings_fonts) . ";}"."\n";
	}

    //Site title
    $site_title_size = get_theme_mod( 'site_title_size', '26' );
    if ($site_title_size) {
        $custom .= ".site-title { font-size:" . intval($site_title_size) . "px; }"."\n";
    }
    //Site description
    $site_desc_size = get_theme_mod( 'site_desc_size', '16' );
    if ($site_desc_size) {
        $custom .= ".site-description { font-size:" . intval($site_desc_size) . "px; }"."\n";
    }
	//H1 size
	$h1_size = get_theme_mod( 'h1_size','52' );
	if ($h1_size) {
		$custom .= "h1 { font-size:" . intval($h1_size) . "px; }"."\n";
	}
    //H2 size
    $h2_size = get_theme_mod( 'h2_size','42' );
    if ($h2_size) {
        $custom .= "h2 { font-size:" . intval($h2_size) . "px; }"."\n";
    }
    //H3 size
    $h3_size = get_theme_mod( 'h3_size','32' );
    if ($h3_size) {
        $custom .= "h3 { font-size:" . intval($h3_size) . "px; }"."\n";
    }
    //H4 size
    $h4_size = get_theme_mod( 'h4_size','25' );
    if ($h4_size) {
        $custom .= "h4 { font-size:" . intval($h4_size) . "px; }"."\n";
    }
    //H5 size
    $h5_size = get_theme_mod( 'h5_size','20' );
    if ($h5_size) {
        $custom .= "h5 { font-size:" . intval($h5_size) . "px; }"."\n";
    }
    //H6 size
    $h6_size = get_theme_mod( 'h6_size','18' );
    if ($h6_size) {
        $custom .= "h6 { font-size:" . intval($h6_size) . "px; }"."\n";
    }
    //Body size
    $body_size = get_theme_mod( 'body_size', '14' );
    if ($body_size) {
        $custom .= "body { font-size:" . intval($body_size) . "px; }"."\n";
    }

	//__COLORS
	//Primary color
	$primary_color = get_theme_mod( 'primary_color', '#16a1e7' );
	if ( $primary_color != '#16a1e7' ) {
		$custom .= ".site-title a,.site-title a:hover,.roll-title a:hover,.lastest-posts .content-left h3 a:hover,.lastest-posts .content-right h3 a:hover,.activity span a:hover,.activity span a:hover:before,.recent_posts_b .post h3 a:hover,.recent_posts_b .sub-post .content h3 a:hover,.recent_posts_b .sub-post .date a:hover,.recent_posts_b.type2 .sub-post h3 a:hover,.video-post .content h3 a:hover,.social-navigation li a:hover,a,.btn-menu:hover:before,.post-item .content-entry h3 a:hover,.site-main .content-entry h3 a:hover,.newsanchor_recent_posts_widget ul h3 a:hover,.newsanchor_recent_posts_widget ul .date a:hover,.tabs .comments p a:hover,.tabs .pop-posts .text h3 a:hover,.tabs .pop-posts .text .date a:hover,.widget-socials .socials li a:hover,.widget-most-popular h3 a:hover,.widget-categories li a:hover,.single .meta-post span a:hover,.single .meta-post span a:hover:before,.single .related-posts .content h3 a:hover,.single .related-posts .date a:hover,.comments-list .comment-text .author a:hover,.footer-widgets .widget-list li a:hover,.top-header .toplink li a:hover { color:" . esc_attr($primary_color) . "}"."\n";
		$custom .= ".roll-posts-carousel .item:hover .text-over,.roll-posts-carousel .owl-nav [class*=owl-],.roll-contact-form .send-wrap input,.roll-title:after,#mainnav ul .top-menu-item-1:hover,button,input[type=\"button\"],input[type=\"reset\"],input[type=\"submit\"],.preloader .pre-bounce1,.preloader .pre-bounce2,#mainnav > ul > li:first-of-type,#login-modal .submit-login input,#signup-modal .submit-login input,.sidebar .widget-title:before,.tabs .menu-tab li.active a:after,.widget-subscribe #subscribe-button,.single .tags-post a:hover,.single .share-post .socials a,.comment-respond .submit-comment input,.footer-widgets .widget-social .social-list a:hover,.tagcloud a:hover,.go-top,.search-header .mobi-searchform { background-color:" . esc_attr($primary_color) . "}"."\n";
		$custom .= "blockquote,.tagcloud a:hover { border-color:" . esc_attr($primary_color) . "}"."\n";
	}
	//Site desc
	$site_desc = get_theme_mod( 'site_desc_color', '#424347' );
	$custom .= ".site-description { color:" . esc_attr($site_desc) . "}"."\n";
	//Site header
	$site_header = get_theme_mod( 'site_header_bg', '#ffffff' );
	$custom .= ".top-header,.main-header { background-color:" . esc_attr($site_header) . "}"."\n";
	//Menu background
	$menu_bg_color = get_theme_mod( 'menu_bg_color', '#222' );
	$custom .= ".bottom-header .header-nav { background-color:" . esc_attr($menu_bg_color) . ";}" . "\n";
	//Menu color scheme
	$menu_color_1 = get_theme_mod( 'menu_color_1', '#fe2d18' );
	$custom .= "#mainnav ul .top-menu-item-2:hover { background-color:" . esc_attr($menu_color_1) . ";}" . "\n";
	$menu_color_2 = get_theme_mod( 'menu_color_2', '#91ce29' );
	$custom .= "#mainnav ul .top-menu-item-3:hover { background-color:" . esc_attr($menu_color_2) . ";}" . "\n";
	$menu_color_3 = get_theme_mod( 'menu_color_3', '#ff9600' );
	$custom .= "#mainnav ul .top-menu-item-4:hover { background-color:" . esc_attr($menu_color_3) . ";}" . "\n";
	$menu_color_4 = get_theme_mod( 'menu_color_4', '#b22234' );
	$custom .= "#mainnav ul .top-menu-item-5:hover { background-color:" . esc_attr($menu_color_4) . ";}" . "\n";
	$menu_color_5 = get_theme_mod( 'menu_color_5', '#c71c77' );
	$custom .= "#mainnav ul .top-menu-item-0:hover { background-color:" . esc_attr($menu_color_5) . ";}" . "\n";
	//Body
	$body_text = get_theme_mod( 'body_text_color', '#767676' );
	$custom .= "body { color:" . esc_attr($body_text) . "}"."\n";

	//Footer background
	$footer_background = get_theme_mod( 'footer_background', '#1e1e1e' );
	$custom .= ".site-info { background-color:" . esc_attr($footer_background) . "}"."\n";	
	//Footer color
	$footer_color = get_theme_mod( 'footer_widgets_color', '#949494' );
	$custom .= ".footer-widgets.widget-area,.footer-widgets.widget-area a { color:" . esc_attr($footer_color) . "}"."\n";	
	//Footer widget area background
	$footer_widgets_background = get_theme_mod( 'footer_widgets_background', '#222' );
	$custom .= ".footer-widgets { background-color:" . esc_attr($footer_widgets_background) . "}"."\n";

	//Output all the styles
	wp_add_inline_style( 'newsanchor-style', $custom );	
}
add_action( 'wp_enqueue_scripts', 'newsanchor_custom_styles' );