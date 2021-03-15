<?php
/*
Plugin Name: BEA Default - Force GMAPS API KEY ( ACF )
Version: 1.0.0
Plugin URI: https://beapi.fr
Description: Add API KEY for ACF Google Maps
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
namespace BEAPI\Plugin_Defaults\ACF;

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Cannot access pages directly.' );
}

function default_api_key( $api ) {
	if ( ! defined( 'ACF_GMAPS_API_KEY' ) ) {
		return $api;
	}
	$api['key'] = ACF_GMAPS_API_KEY;

	return $api;
}

add_filter( 'acf/fields/google_map/api', __NAMESPACE__ . '\\default_api_key' );
