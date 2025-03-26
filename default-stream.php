<?php
/**
 * Plugin Name: Be API - Default Stream
 * Description: Default option for Stream
 * Version: 1.0
 * Author: BE API Technical team
 * Author URI: https://www.beapi.fr
 */

namespace BEAPI\Plugin_Defaults\Stream;

add_filter( 'default_site_option_wp_stream_network', __NAMESPACE__ . '\\stream_settings' );
add_filter( 'default_option_wp_stream', __NAMESPACE__ . '\\stream_settings' );
add_filter( 'wp_stream_client_ip_address', __NAMESPACE__ . '\\stream_client_ip_address' );

/**
 * Default setting for Stream plugin
 *
 * @return array
 * @author Egidio CORICA
 */
function stream_settings(): array {
	return [
		'general_keep_records_indefinitely' => '0',
		'general_role_access'               => [
			'administrator',
		],
		'general_records_ttl'               => 90,
		'general_site_access'               => 1,
		'exclude_rules'                     => [],
		'advanced_comment_flood_tracking'   => 0,
		'advanced_wp_cron_tracking'         => 0,
		'advanced_delete_all_records'       => 0,
	];
}

/**
 * In case of reverse proxy, we need to log the real IP address
 *
 * @param $ip_address
 *
 * @return string
 * @author Jules Fell
 */
function stream_client_ip_address( $ip_address ): string {
	if ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
		$xff = $_SERVER['HTTP_X_FORWARDED_FOR'];

		if ( strpos( $xff, ',' ) ) {
			$ip_list   = explode( ',', $xff );
			$ip_address = trim( $ip_list[0] ); // First IP of the list is the original client IP
		} else {
			$ip_address = trim( $xff ); // If only one IP in HTTP_X_FORWARDED_FOR
		}
	}

	return $ip_address;
}
