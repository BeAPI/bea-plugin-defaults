<?php
/*
 Plugin Name: BEA Default - Custom Taxonomy Order NE
 Version: 1.0.0
 Plugin URI: https://beapi.fr
 Description: Add default options for Custom Taxonomy Order NE
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
 * {taxonomy} => {order_type} with order type :
 * 0 : Ordre par ID (par défaut).
 * 1 : Ordre personnalisé (tel que défini ci-dessus).
 * 2 : Ordre alphabétique.
 *
 * @return array
 */
function bea_default_custom_order_taxonomy_ne() {
	return [
		'category'         => 0,
		'document_support' => 1,
		'document_type'    => 0,
		'media'            => 1,
		'offer_type'       => 0,
		'program_kind'     => 0,
		'post_tag'         => 0,
		'post_format'      => 0
	];
}

add_filter( 'option_customtaxorder_settings', 'bea_default_custom_order_taxonomy_ne' );
add_filter( 'default_option_customtaxorder_settings', 'bea_default_custom_order_taxonomy_ne' );
add_filter( 'pre_option_customtaxorder_settings', 'bea_default_custom_order_taxonomy_ne' );
