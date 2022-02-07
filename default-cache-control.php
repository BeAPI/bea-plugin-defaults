<?php
/**
 * Plugin Name: Be API - Cache-control
 * Description: Add must-revalidate to the cache-control directive.
 * Version: 1.0
 * Author: BE API Technical team
 * Author URI: https://www.beapi.fr
 */

namespace BEAPI\Plugin_Defaults\cache_control;

add_action( 'plugins_loaded', __NAMESPACE__ . '\\cache_control_default_settings' );

/**
 * Add default setting for the cache control plugin
 */
function cache_control_default_settings() {
	global $cache_control_options;

	if ( empty( $cache_control_options ) ) {
		return;
	}

	foreach ( $cache_control_options as $index => $options ) {
		$options['s_maxage']             = $options['max_age'];
		$options['max_age']              = 0;
		$options['staleerror']           = 50;
		$cache_control_options[ $index ] = $options;
	}
}