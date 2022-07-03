<?php
/**
 * CoolTech functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage CoolTech
 * @since CoolTech 1.0000001
 */


if ( ! function_exists( 'cooltech_support' ) ) :

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * @since CoolTech 1.0
	 *
	 * @return void
	 */
	function cooltech_support() {

		// Add support for block styles.
		add_theme_support( 'wp-block-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style.css' );

	}

endif;

add_action( 'after_setup_theme', 'cooltech_support' );

add_filter( 'get_the_archive_title_prefix', '__return_empty_string' );

add_filter( 'excerpt_length', function($length) {
    return 20;
},999 );

add_action( 'the_tags', function( $html){
	return "<span>Tags</span>".$html;
} );


if ( ! function_exists( 'cooltech_styles' ) ) :

	/**
	 * Enqueue styles.
	 *
	 * @since CoolTech 1.0
	 *
	 * @return void
	 */
	function cooltech_styles() {
		// Register theme stylesheet.
		$theme_version = wp_get_theme()->get( 'Version' );

		$version_string = is_string( $theme_version ) ? $theme_version : false;
		wp_register_style(
			'cooltech-style',
			get_template_directory_uri() . '/style.css',
			array(),
			$version_string
		);

		// Enqueue theme stylesheet.
		wp_enqueue_style( 'cooltech-style' );

	}

endif;

add_action( 'wp_enqueue_scripts', 'cooltech_styles' );


