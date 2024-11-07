<?php
/*
Plugin Name: BeAPI Default - HTTP Headers
Version: 1.0.0
Plugin URI: https://beapi.fr
Description: Add custom http headers (CP, CSP, ....)
Author: Be API
Author URI: https://beapi.fr

----

Copyright 2024 Be API Technical team (humans@beapi.fr)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

*/

namespace BEAPI\Plugin_Defaults\Http_Header;

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Cannot access pages directly.' );
}

/**
 * Add custom behavior for headers
 *
 * @param array $headers
 *
 * @return array
 *
 * @author Alexandre Sadowski
 *
 */
function wp_headers( array $headers ): array {
	if ( is_admin() ) {
		return $headers;
	}

	$csp = get_csp_headers();

	if ( defined( 'CSP_REPORT_ONLY' ) && defined( 'WP_SENTRY_SECURITY_HEADER_ENDPOINT' ) ) {
		$csp['report-uri'] = WP_SENTRY_SECURITY_HEADER_ENDPOINT;
		$csp['report-to']  = 'csp-endpoint';
	}

	/**
	 * We rely on the CSP_REPORT_ONLY .env value to decide whether we apply the CSP or just report the errors
	 */
	$csp_header                       = defined( 'CSP_REPORT_ONLY' ) && CSP_REPORT_ONLY ? 'Content-Security-Policy-Report-Only' : 'Content-Security-Policy';
	$csp_headers_array[ $csp_header ] = get_prepare_csp( $csp );

	$custom_headers_array = [];

	/**$custom_headers_array = [
	 * 'X-Content-Type-Options'              => 'nosniff',
	 * 'X-Frame-Options'                     => 'SAMEORIGIN',
	 * 'X-XSS-Protection'                    => '1; mode=block',
	 * 'Referrer-Policy'                     => 'no-referrer-when-downgrade',
	 * 'Permissions-Policy'                  => 'accelerometer=(), geolocation=(), fullscreen=(), ambient-light-sensor=(), autoplay=(), battery=(), camera=(), display-capture=()',
	 * ];**/

	return wp_parse_args( $csp_headers_array, $custom_headers_array );
}

add_filter( 'wp_headers', __NAMESPACE__ . '\\wp_headers', 99 );

/**
 *
 * Prepare CSP attribute values
 *
 * @param array $csp
 *
 * @return string
 */
function get_prepare_csp( array $csp ): string {
	$csp_values = '';

	if ( empty( $csp ) ) {
		return $csp_values;
	}

	// Loop and not implode to add both key and value
	foreach ( $csp as $key => $value ) {
		if ( empty( $value ) ) {
			continue;
		}
		$csp_values .= $key . ' ' . $value . '; ';
	}

	// Remove last space
	return trim( $csp_values );
}

/**
 * Generate CSP headers array
 *
 * @return array
 * @author Alexandre Sadowski
 */
function get_csp_headers(): array {
	$csp = [
		'default-src'  => '\'self\'',
		'script-src'   => '\'self\'',
		'style-src'    => '\'self\'',
		'img-src'      => '\'self\'',
		'font-src'     => '\'self\'',
		'connect-src'  => '\'self\'',
		'frame-src'    => '\'self\'',
		'manifest-src' => '\'self\'',
		'worker-src'   => '\'self\'',
		'object-src'   => '\'none\'',
	];

	//if ( 'production' === WP_ENV ) {
		//$csp = [];
	//}

	return apply_filters( 'csp_headers', $csp );
}
