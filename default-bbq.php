<?php
/*
 Plugin Name: BEA Default - Block Bad Queries Pro
 Version: 1.0.0
 Plugin URI: https://beapi.fr
 Description: Set options dans keys + Allow bot Jakarta (for Linkedin)
 Author: Be API
 Author URI: https://beapi.fr

 ----

 Copyright 2018 Be API Technical team (humans@beapi.fr)

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
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Cannot access pages directly.' );
}

/**
 * This allow to set key in code
 * cause it's a lifetime license
 */
if ( ! defined( 'BBQ_CODE' ) ) {
	// licence BBQ pro
	define( 'BBQ_CODE', 'xxxxxx' );// replace with license key
}

/**
 * Linkedin share is not allowed
 * a 403 error is generated
 * because of the pattern array('enable' => true, 'count' => 0, 'pattern' => 'jakarta'),
 * "Fortunately" we can disable this pattern
 */
add_filter( 'bbq_patterns', function( $patterns ) {

	if ( ! empty( $patterns['advanced']['user_agent'] ) ) {
		foreach ( $patterns['advanced']['user_agent'] as $agent => $rules ) {
			if ( 'jakarta' !== $rules['pattern'] ) {
				continue;
			}

			$patterns['advanced']['user_agent'][ $agent ]['enable'] = false;
		}
	}

	return $patterns;
} );

