<?php
/**
 * TargetWeb 3 theme functions
 *
 * @package TargetWeb3
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'TW3_VERSION', '1.0.3' );
define( 'TW3_DIR', get_template_directory() );
define( 'TW3_URI', get_template_directory_uri() );

function tw3_setup() {
	load_theme_textdomain( 'targetweb3', TW3_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support(
		'custom-logo',
		array( 'height' => 60, 'width' => 220, 'flex-height' => true, 'flex-width' => true )
	);

	register_nav_menus(
		array(
			'primary'         => __( 'Primary Menu', 'targetweb3' ),
			'footer-equipment' => __( 'Footer — Equipment Column', 'targetweb3' ),
		)
	);

	add_image_size( 'tw3-hero', 1600, 900, true );
	add_image_size( 'tw3-card', 500, 600, true );
	add_image_size( 'tw3-wide', 1200, 700, true );
}
add_action( 'after_setup_theme', 'tw3_setup' );

function tw3_scripts() {
	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'tw3-google-fonts', 'https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap', array(), null );
	wp_enqueue_style( 'tw3-style', TW3_URI . '/style.css', array(), TW3_VERSION );
	wp_enqueue_style( 'tw3-main', TW3_URI . '/assets/css/main.css', array( 'tw3-style' ), TW3_VERSION );

	wp_enqueue_script( 'tw3-main', TW3_URI . '/assets/js/main.js', array(), TW3_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_add_inline_style( 'tw3-main', tw3_get_color_vars() );

	// Feed category popup content to JS without a page reload.
	wp_localize_script( 'tw3-main', 'tw3CategoryData', tw3_get_repeater( 'tw3_categories_repeater' ) );
}
add_action( 'wp_enqueue_scripts', 'tw3_scripts' );

function tw3_get_color_vars() {
	$map = array(
		'--tw-dark'        => tw3_opt( 'tw3_color_dark', '#0D110D' ),
		'--tw-dark-alt'    => tw3_opt( 'tw3_color_dark_alt', '#141810' ),
		'--tw-light'       => tw3_opt( 'tw3_color_light', '#F4F5F1' ),
		'--tw-light-alt'   => tw3_opt( 'tw3_color_light_alt', '#E9EBE4' ),
		'--tw-green'       => tw3_opt( 'tw3_color_green', '#2F7D46' ),
		'--tw-green-bright'=> tw3_opt( 'tw3_color_green_bright', '#4CAF50' ),
		'--tw-text-dark'   => tw3_opt( 'tw3_color_text_dark', '#151A13' ),
		'--tw-text-onlight-muted' => tw3_opt( 'tw3_color_text_onlight_muted', '#5B6058' ),
		'--tw-text-ondark' => '#F4F5F1',
		'--tw-text-ondark-muted' => tw3_opt( 'tw3_color_text_ondark_muted', '#9CA39A' ),
		'--tw-border-dark' => 'rgba(255,255,255,.12)',
		'--tw-border-light'=> tw3_opt( 'tw3_color_border_light', '#DEE1D7' ),
	);
	$css = ':root{';
	foreach ( $map as $var => $val ) {
		$css .= esc_attr( $var ) . ':' . esc_attr( $val ) . ';';
	}
	$css .= '}';
	return $css;
}

/**
 * Shorthand theme_mod lookup. Falls back to the centralized default in
 * inc/field-defaults.php when no explicit $default is passed, so a fresh
 * site is fully populated without needing every field opened & saved first.
 */
function tw3_opt( $key, $default = null ) {
	if ( null === $default ) {
		$default = tw3_text_default( $key );
	}
	return get_theme_mod( $key, $default );
}

function tw3_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Blog Sidebar', 'targetweb3' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'tw3_widgets_init' );

require TW3_DIR . '/inc/field-defaults.php';
require TW3_DIR . '/inc/repeaters.php';
require TW3_DIR . '/inc/customizer.php';
require TW3_DIR . '/inc/demo-content.php';
require TW3_DIR . '/inc/template-tags.php';
require TW3_DIR . '/inc/form-handler.php';
require TW3_DIR . '/inc/seo.php';
require TW3_DIR . '/inc/maintenance.php';

function tw3_excerpt_length( $length ) { return 30; }
add_filter( 'excerpt_length', 'tw3_excerpt_length' );

function tw3_editor_color_palette() {
	add_theme_support( 'editor-color-palette', array(
		array( 'name' => 'Green',       'slug' => 'tw3-green',        'color' => tw3_opt( 'tw3_color_green', '#2F7D46' ) ),
		array( 'name' => 'Bright Green','slug' => 'tw3-green-bright', 'color' => tw3_opt( 'tw3_color_green_bright', '#4CAF50' ) ),
		array( 'name' => 'Dark',        'slug' => 'tw3-dark',         'color' => tw3_opt( 'tw3_color_dark', '#0D110D' ) ),
		array( 'name' => 'Light',       'slug' => 'tw3-light',        'color' => tw3_opt( 'tw3_color_light', '#F4F5F1' ) ),
	) );
}
add_action( 'after_setup_theme', 'tw3_editor_color_palette' );
