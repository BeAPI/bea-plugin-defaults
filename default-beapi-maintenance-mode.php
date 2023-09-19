<?php
/*
Plugin Name: BEA Default - Be API - Maintenance Mode
Version: 1.0.0
Plugin URI: https://beapi.fr
Description: Set Be API Maintenance Mode default
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

namespace BEAPI\Plugin_Defaults\Beapi_Maintenance_Mode;

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Cannot access pages directly.' );
}

/**
 * Add some random ip address to the whitelist
 */
add_filter(
	'beapi.maintenance_mode.whitelist_ips',
	function ( array $ips = [] ): array {
		if( ! defined( 'BEAPI_MAINTENANCE_MODE_IPS' ) || empty( BEAPI_MAINTENANCE_MODE_IPS ) ) {
			return $ips;
		}

		$ips[] = BEAPI_MAINTENANCE_MODE_IPS;

		return $ips;
	}
);

/**
 * Localize the custom template which can be situated wherever you want
 */
add_filter(
	'beapi.maintenance_mode.template.path',
	function (): string {
		return WPMU_PLUGIN_DIR . '/templates/template.php';
	}
);
