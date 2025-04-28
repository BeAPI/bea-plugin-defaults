<?php
/*
Plugin Name: BeAPI Default - HTTP Headers
Version: 1.1.0
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
 */
function wp_headers( array $headers ): array {
	if ( is_admin() ) {
		return $headers;
	}

	$csp            = get_csp_headers();
	$has_report_url = defined( 'WP_SENTRY_SECURITY_HEADER_ENDPOINT' ) && ! empty( WP_SENTRY_SECURITY_HEADER_ENDPOINT );
	$report_only    = defined( 'CSP_REPORT_ONLY' ) && CSP_REPORT_ONLY;

	if ( $report_only && $has_report_url ) {
		$report_url = WP_SENTRY_SECURITY_HEADER_ENDPOINT;
		// include env name in the URL if available.
		if ( defined( 'WP_SENTRY_ENV' ) && ! empty( WP_SENTRY_ENV ) ) {
			$report_url = add_query_arg( array( 'sentry_environment' => WP_SENTRY_ENV ), $report_url );
		}

		/**
		 * Setup CSP violation reporting.
		 *
		 * @see https://docs.sentry.io/platforms/go/security-policy-reporting/#content-security-policy Sentry documentation on setting the CSP reporting.
		 */
		// CSP directives use for reporting CSP violations.
		$csp['report-to'] = [ 'csp-endpoint' ];

		// Deprecated CSP directive for reporting, kept for compatibility with old browsers.
		$csp['report-uri'] = [ $report_url ];

		// Include reporting endpoint domain to the list of allowed host
		$csp['connect-src'][] = wp_parse_url( $report_url, PHP_URL_HOST );

		// Additional headers required by the "report-to" CSP directive.
		$headers['Report-To']           = wp_json_encode(
			[
				'group'     => 'csp-endpoint',
				'max_age'   => 10886400,
				'endpoints' => [
					'url'                => $report_url,
					'include_subdomains' => true,
				]
			]
		);
		$headers['Reporting-Endpoints'] = sprintf( 'csp-endpoint="%s"', $report_url );
	}

	/**
	 * We rely on the CSP_REPORT_ONLY .env value to decide whether we apply the CSP or just report the errors
	 */
	$csp_header             = $report_only ? 'Content-Security-Policy-Report-Only' : 'Content-Security-Policy';
	$headers[ $csp_header ] = get_prepare_csp( $csp );

	/**
	 * Additional security headers.
	 *
	 * Example :
	 * $headers['X-Content-Type-Options'] = 'nosniff';
	 * $headers['X-Frame-Options']        = 'SAMEORIGIN';
	 * $headers['Referrer-Policy']        = 'no-referrer-when-downgrade';
	 * $headers['Permissions-Policy']     = 'accelerometer=(), geolocation=(), fullscreen=(), ambient-light-sensor=(), autoplay=(), battery=(), camera=(), display-capture=()';
	 */
	$headers['X-Content-Type-Options'] = 'nosniff';
	$headers['X-Frame-Options']        = 'SAMEORIGIN';

	return $headers;
}

add_filter( 'wp_headers', __NAMESPACE__ . '\\wp_headers', 99 );

/**
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

		// add space between values.
		if ( ! empty( $csp_values ) ) {
			$csp_values .= ' ';
		}

		$csp_values .= sprintf(
			'%s %s;',
			$key,
			implode( ' ', $value )
		);
	}

	return $csp_values;
}

/**
 * Get CSP headers directives.
 *
 * Add specific values for each directive in the corresponding array.
 *
 * Some values MUST be wrap with single quote : `'self'`, `'unsafe-inline'` and `'unsafe-eval'`. Use double quotes
 * when you want to add them in the array (e.g. `"'self'"`).
 *
 * @return array<string, array>
 * @author Alexandre Sadowski
 */
function get_csp_headers(): array {

	$csp = [
		'default-src'     => [ "'self'" ],
		'script-src'      => [ "'self'" ],
		'style-src'       => [ "'self'" ],
		'img-src'         => [ "'self'" ],
		'font-src'        => [ "'self'" ],
		'connect-src'     => [ "'self'" ],
		'media-src'       => [ "'self'" ],
		'frame-src'       => [ "'self'" ],
		'manifest-src'    => [ "'self'" ],
		'worker-src'      => [ "'self'" ],
		'object-src'      => [ "'self'" ],
		'base-uri'        => [ "'self'" ],
		'frame-ancestors' => [ "'self'" ],
	];

	//if ( 'production' === WP_ENV ) {
	//    $csp = [];
	//}

	/**
	 * Filter CSP values.
	 *
	 * @param array $csp The array of CSP values keyed by their directives.
	 */
	return apply_filters( 'csp_headers', $csp );
}
