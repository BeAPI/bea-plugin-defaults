<?php
/**
 * Plugin Name:       Be API - Default WP Cerber
 * Plugin URI:        https://github.com/BeAPI/bea-plugin-defaults
 * Description:       Compatibility layer for WP Cerber and the WordPress REST API. Adjusts REST URL prefix detection so Cerber correctly identifies REST requests when the site uses a custom prefix or subfolder structure.
 * Version:           1.0.1
 * Requires at least: 5.9
 * Requires PHP:      7.4
 * Author:            BeAPI Technical team
 * Author URI:        https://beapi.fr
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       bea-plugin-defaults
 */

namespace BEAPI\Plugin_Defaults\Wp_Cerber;

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Cannot access pages directly.' );
}

add_filter( 'application_password_is_api_request', __NAMESPACE__ . '\\application_password_is_api_request' );

/**
 * Determines if the current request is an API request and fixes WP Cerber REST API blocking too early.
 *
 * This function checks if the request URI indicates a REST API route,
 * validates the request method against a set of allowed methods, and
 * ensures that authentication credentials are provided.
 *
 * @param bool $is_api_request The initial determination of whether the request is an API request.
 *
 * @return bool True if the request is a valid API request; otherwise, the original $is_api_request value.
 */
function application_password_is_api_request( $is_api_request ) {
	$request_uri = $_SERVER['REQUEST_URI'] ?? '';
	if ( empty( $request_uri ) ) {
		return $is_api_request;
	}
	// Check if it's an API route
	if ( ! str_contains( $request_uri, '/wp-json/' ) ) {
		return $is_api_request;
	}
	$request_method         = $_SERVER['REQUEST_METHOD'] ?? '';
	$request_method_allowed = [ 'GET', 'POST', 'PUT', 'DELETE', 'PATCH' ];
	// Check if method REQUEST is allowed
	if ( ! in_array( $request_method, $request_method_allowed, true ) ) {
		return $is_api_request;
	}
	// Check if authentication is sent
	if ( ! isset( $_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'] ) ) {
		return $is_api_request;
	}
	return true;
}
