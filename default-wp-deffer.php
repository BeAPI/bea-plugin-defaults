<?php
/*
 Plugin Name: BEA Default - WP Deferred JavaScripts
 Version: 1.1.0
 Plugin URI: https://beapi.fr
 Description: Force to no defer some scripts
 Author: Be API
 Author URI: https://beapi.fr

 ----

 Copyright 2020 Be API Technical team (humans@beapi.fr)

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

add_filter( 'do_not_defer', 'beapi_do_not_deffer' );
/**
 * @param $do_not_defer
 *
 * @return array
 *
 * @author Romain DORR <rdorr@beapi.fr>
 */
function beapi_do_not_deffer( $do_not_defer ) {
	$do_not_defer[] = 'jquery';
	$do_not_defer[] = 'jQuery';
	$do_not_defer[] = 'flow-flow-plugin-script';
	$do_not_defer[] = 'gmap';
	$do_not_defer[] = 'recette';
	$do_not_defer[] = 'wpforms';

	return $do_not_defer;
}
