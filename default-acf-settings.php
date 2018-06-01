<?php
/*
 Plugin Name: BEA Default ACF
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
add_action( 'admin_init', 'bea_hide_acf_menu' );
function bea_hide_acf_menu() {

	if ( ! defined( 'WP_DEBUG' ) || ! WP_DEBUG ) {
		/**
		 * As ACF_LITE will be deprecated
		 * @see https://www.advancedcustomfields.com/resources/including-acf-in-a-plugin-theme/
		 */
		add_filter( 'acf/settings/show_admin', '__return_false' );
	}
}
