<?php
/*
  Plugin Name: Cookie Notice - Default
  Plugin URI: https://beapi.fr
  Description: Remove CSS from plugin
  Author: BeAPI
  Author URI: https://beapi.fr
  Version: 1.0.0
 */

add_action( 'wp_enqueue_scripts', 'bea_cookie_wp_enqueue_scripts', 11 );

function bea_cookie_wp_enqueue_scripts() {
	wp_dequeue_style( 'cookie-notice-front' );
}
