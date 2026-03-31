<?php
/**
 * Plugin Name: Be API - Default Popup Maker
 * Description: Hide Popup Maker filesystem cache alert
 * Version: 1.0
 * Author: BE API Technical team
 * Author URI: https://www.beapi.fr
 */

namespace BEAPI\Plugin_Defaults\Popup_Maker;

add_filter( 'pum_alert_list', __NAMESPACE__ . '\\strip_filesystem_cache_alert', 999 );

/**
 * Hide Popup Maker filesystem cache alert
 *
 * @param array $alerts Popup Maker alerts returned by apply_filters( 'pum_alert_list', [] ).
 * @return array
 */
function strip_filesystem_cache_alert( $alerts ) {
	if ( empty( $alerts ) || ! is_array( $alerts ) ) {
		return $alerts;
	}

	return array_values(
		array_filter(
			$alerts,
			static function ( $alert ) {
				return ! isset( $alert['code'] ) || 'pum_writeable_notice' !== $alert['code'];
			}
		)
	);
}
