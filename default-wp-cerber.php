<?php
/**
 * Plugin Name: Be API - Default WP Cerber
 * Description: Fix WP Cerber bug features
 * Version: 1.0
 * Author: BE API Technical team
 * Author URI: https://www.beapi.fr
 */

namespace BEAPI\Plugin_Defaults\Wp_Cerber;

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Cannot access pages directly.' );
}

add_filter( 'rest_url_prefix', __NAMESPACE__ . '\\fix_prefix_to_check' );
add_filter( 'rest_request_before_callbacks', __NAMESPACE__ . '\\fix_prefix_endpoint' );
add_filter( 'application_password_is_api_request', __NAMESPACE__ . '\\application_password_is_api_request' );

/**
 * Modifies the REST API prefix from `/wp-json/` to `/json` based on the requested URL on WP-Cerber cerber_is_rest_url() check
 *
 * This filter intercepts the default REST URL prefix via the `rest_url_prefix` hook
 * and applies a custom prefix if the current URL starts with `/wp-json/`.
 *
 * @param string $prefix The default REST API prefix.
 * @return string The modified REST API prefix (or unchanged if not applicable).
 *
 */
function fix_prefix_to_check( string $prefix ): string {
	// Retrieve the requested URL
	$url = $_SERVER['REQUEST_URI'] ?? '';

	// If no URL is available, return the default prefix
	if ( empty( $url ) ) {
		return $prefix;
	}

	// If the URL starts with `/wp-json/`, change the prefix to `json`. Because it consider current /wp like a subfolder
	if ( str_starts_with( $url, '/wp-json/' ) ) {
		return 'json';
	}

	// Otherwise, keep the default prefix
	return $prefix;
}

/**
 * Removes the REST prefix filter after a REST API request is processed.
 *
 * This function is hooked into the `rest_request_before_callbacks` filter
 * to ensure the prefix modification does not persist beyond its intended scope.
 *
 * @param mixed $response The current REST response or null.
 * @return mixed The original REST response, unchanged.
 *
 */
function fix_prefix_endpoint( $response ) {
	// Remove the custom prefix filter to avoid side effects
	remove_filter( 'rest_url_prefix', __NAMESPACE__ . '\\fix_prefix_to_check' );

	return $response;
}


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
