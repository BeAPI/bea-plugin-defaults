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
