<?php
/**
 * OceanWP Child Theme Functions
 *
 * When running a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions will be used.
 *
 * Text Domain: oceanwp
 * @link http://codex.wordpress.org/Plugin_API
 *
 */

/**
 * Load the parent style.css file
 *
 * @link http://codex.wordpress.org/Child_Themes
 */
function oceanwp_child_enqueue_parent_style() {

	// Dynamically get version number of the parent stylesheet (lets browsers re-cache your stylesheet when you update the theme).
	$theme   = wp_get_theme( 'OceanWP' );
	$version = $theme->get( 'Version' );

	// Load the stylesheet.
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'oceanwp-style' ), $version );
	
}

add_action( 'wp_enqueue_scripts', 'oceanwp_child_enqueue_parent_style' );

// include bootstrap css and js library files
/*function bootstrap_enqueue_styles() {
    wp_register_style('bootstrap', get_stylesheet_directory_uri() . '/bootstrap/css/bootstrap.min.css' );
    $dependencies = array('bootstrap');
    wp_enqueue_style( 'bootstrap-style', get_stylesheet_directory_uri(), $dependencies); 
}

function bootstrap_enqueue_scripts() {
    $dependencies = array('jquery');
    wp_enqueue_script('bootstrap-script', get_stylesheet_directory_uri().'/bootstrap/js/bootstrap.min.js', $dependencies, '5.1.3', true );
}

add_action( 'wp_enqueue_scripts', 'bootstrap_enqueue_styles' ,1);
add_action( 'wp_enqueue_scripts', 'bootstrap_enqueue_scripts',1 ); */

function header_custom_enqueue_scripts() {
    $dependencies = array('jquery');
    wp_enqueue_script( 'custom-header-script', get_stylesheet_directory_uri().'/js/header-custom.js', $dependencies, '', true );
}

add_action( 'wp_enqueue_scripts', 'header_custom_enqueue_scripts',1 );

function footer_custom_enqueue_scripts() {
    $dependencies = array('jquery');
    wp_enqueue_script( 'custom-footer-script', get_stylesheet_directory_uri().'/js/footer-custom.js', $dependencies, '', false );
}

add_action( 'wp_enqueue_scripts', 'footer_custom_enqueue_scripts',1 );

/* Disable WordPress Admin Bar for all users */
add_filter( 'show_admin_bar', '__return_false' );

// Add custom font to font settings
function ocean_add_custom_fonts() {
	return array( 'AvertaStd' ); // You can add more then 1 font to the array!
}

// change mobile menu icon
// function my_mobile_menu_open_button_icon( $return ) {
// 	return '<i class="fa fa-caret-square-o-down" aria-hidden="true"></i>';
// }
// add_filter( 'ocean_mobile_menu_navbar_open_icon', 'my_mobile_menu_open_button_icon' );

// Homepage calling customer's review
include( 'custom-shortcodes.php' );
