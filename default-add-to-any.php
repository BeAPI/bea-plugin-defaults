<?php
/*
 Plugin Name: BEA Default - Add To Any
 Version: 1.0.0
 Plugin URI: https://beapi.fr
 Description: Disable Sharing on custom post type
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
 * Disable Sharing Custom Post Type
 *
 * @return bool
 *
 */
function bea_default_addtoany() {
	return true;
}

add_filter( 'addtoany_sharing_disabled', 'bea_default_addtoany' );
