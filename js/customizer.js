/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	//Site desc
	wp.customize('site_desc_color',function( value ) {
		value.bind( function( newval ) {
			$('.site-description').css('color', newval );
		} );
	});	
	//Site header
	wp.customize('site_header_bg',function( value ) {
		value.bind( function( newval ) {
			$('.top-header,.main-header').css('background-color', newval );
		} );
	});	
	//Menu
	wp.customize('menu_bg_color',function( value ) {
		value.bind( function( newval ) {
			$('.bottom-header .header-nav').css('background-color', newval );
		} );
	});	
	// Body text color
	wp.customize('body_text_color',function( value ) {
		value.bind( function( newval ) {
			$('body').css('color', newval );
		} );
	});	
	//Footer widgets background
	wp.customize('footer_widgets_background',function( value ) {
		value.bind( function( newval ) {
			$('.footer-widgets').css('background-color', newval );
		} );
	});	
	//Footer widgets color
	wp.customize('footer_widgets_color',function( value ) {
		value.bind( function( newval ) {
			$('.footer-widgets.widget-area,.footer-widgets.widget-area a').css('color', newval );
		} );
	});	
	//Footer background
	wp.customize('footer_background',function( value ) {
		value.bind( function( newval ) {
			$('.site-info').css('background-color', newval );
		} );
	});	

} )( jQuery );
