<?php
/**
 * Plugin Name: Be API - WP Rocket config
 * Description: Default option for WP Rocket
 * Version: 1.0
 * Author: BeAPI
 * Author URI: http://beapi.fr/
 */

namespace BEAPI\Plugin_Defaults\WP_Rocket;

// Enable caching for mobile devices
add_filter( 'pre_get_rocket_option_cache_mobile', '__return_true' );

// Load async css
add_filter( 'pre_get_rocket_option_async_css', '__return_true' );

// Minifying css files
add_filter( 'pre_get_rocket_option_minify_css', '__return_true' );

// Minifying js files
add_filter( 'pre_get_rocket_option_minify_js', '__return_true' );

// Defer all js
add_filter( 'pre_get_rocket_option_defer_all_js', '__return_true' );

// Optimizing css loading by default
add_filter( 'pre_get_rocket_option_optimize_css_delivery', '__return_true' );

// Activate preloading
add_filter( 'pre_get_rocket_option_sitemap_preload_url_crawl', '__return_true' );

// Enable preloading of links
add_filter( 'pre_get_rocket_option_preload_links', '__return_true' );

// Enable control Heartbeat
add_filter( 'pre_get_rocket_option_control_heartbeat', '__return_true' );
