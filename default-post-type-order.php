<?php
/*
 Plugin Name: BEA Default - Post Type Order
 Version: 1.0.0
 Plugin URI: https://beapi.fr
 Description: Add default options for post type order
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

add_filter( 'pto/get_options', 'bea_default_pto' );

function bea_default_pto() {
	return [
		'show_reorder_interfaces' => [
			'post'       => 'hide',
			'attachment' => 'hide',
			'promotion'  => 'hide',
			'marque'     => 'show',
		],
		'autosort'                => 1,
		'adminsort'               => 1,
		'archive_drag_drop'       => 1,
		'capability'              => 'edit_posts',
		'navigation_sort_apply'   => 1,
	];
}
