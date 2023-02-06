<?php
/**
 * Plugin Name: Be API - WP Rocket handles Varnish
 * Description: Tweaks config for Varnish flush cache
 * Version: 1.0
 * Author: BeAPI
 * Author URI: http://beapi.fr/
 */

namespace BEAPI\Plugin_Defaults\WP_Rocket_Varnish;

add_filter( 'rocket_varnish_http_purge_scheme', __NAMESPACE__ . '\\purge_rocket_varnish_scheme' );

/**
 * Force HTTP.
 */
function purge_rocket_varnish_scheme() {
	return 'http';
}

add_filter( 'rocket_varnish_purge_request_args', __NAMESPACE__ . '\\purge_rocket_varnish_args' );

/**
 * Defines purge method for rocket/varnish (default = PURGE)
 */
function purge_rocket_varnish_args( $args ) {
	$args['method'] = 'BAN';

	return $args;
}

add_filter( 'rocket_varnish_ip', __NAMESPACE__ . '\\set_custom_varnish_ip' );

/**
 * Return custom Varnish IP
 *
 * @param (array) $ips Array containing custom Varnish IP's
 *
 * @return array
 *
 * @author Arun Basil Lal
 *
 */
function set_custom_varnish_ip( $ips ) {
	if ( ! is_array( $ips ) ) {
		$ips = (array) $ips;
	}

	if ( ! defined( 'VARNISH_IPS' ) ) {
		return $ips;
	}

	$env_ips = constant( 'VARNISH_IPS' );
	$env_ips = array_filter( explode( ',', $env_ips ) );

	if ( empty( $env_ips ) ) {
		return $ips;
	}

	foreach ( $env_ips as $env_ip ) {
		$ips[] = $env_ip . ':6081'; // Append custom port for each IP
	}

	return $ips;
}

/**
 * Disable page caching in WP Rocket.
 *
 * Varnish handles cache
 *
 * @link http://docs.wp-rocket.me/article/61-disable-page-caching
 */

add_filter(
	'do_rocket_generate_caching_files',
	function () {
		return empty( set_custom_varnish_ip( [] ) );
	}
);

/***
 * Enable features by default
 * @see https://docs.wp-rocket.me/article/1561-programmatically-toggle-wp-rocket-options-under-specific-conditions
 */
// Enable varnish purge auto
add_filter(
	'pre_get_rocket_option_varnish_auto_purge',
	function ( $active ) {
		if ( ! empty( set_custom_varnish_ip( [] ) ) ) {
			return true;
		}

		return $active;
	}
);
