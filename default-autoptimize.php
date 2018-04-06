<?php
/*
  Plugin Name: Autoptimize - Default
  Plugin URI: http://www.beapi.fr
  Description: Set options on autoptimize
  Author: BeAPI
  Author URI: http://www.beapi.fr
  Version: 1.0.0
 */

/**
 * HTML
 */
add_filter( 'option_autoptimize_html', '__return_true' );
add_filter( 'default_option_autoptimize_html', '__return_true' );
add_filter( 'pre_option_autoptimize_html', '__return_true' );

/**
 * JS
 */
add_filter( 'option_autoptimize_js', '__return_true' );
add_filter( 'default_option_autoptimize_js', '__return_true' );
add_filter( 'pre_option_autoptimize_js', '__return_true' );
	// Fix Flow Flow inline JS
	add_filter( 'option_autoptimize_js_include_inline', '__return_true' );
	add_filter( 'default_option_autoptimize_js_include_inline', '__return_true' );
	add_filter( 'pre_option_autoptimize_js_include_inline', '__return_true' );

/**
 * CSS
 */
add_filter( 'option_autoptimize_css', '__return_true' );
add_filter( 'default_option_autoptimize_css', '__return_true' );
add_filter( 'pre_option_autoptimize_css', '__return_true' );
