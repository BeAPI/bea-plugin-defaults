<?php
/*
Plugin Name: BEA Default - Imagify
Version: 1.0.0
Plugin URI: https://beapi.fr
Description: Default optimal settings for Imagify plugin
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

namespace BEAPI\Plugin_Defaults\Imagify;

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Cannot access pages directly.' );
}

add_filter( 'pre_option_imagify_settings', __NAMESPACE__ . '\\default_options' );

/**
 * Overwrite Imagify default options
 *
 * @return int[]
 */
function default_options(): array {
	return [
		'api_key'                => '',
		'optimization_level'     => 2,
		'lossless'               => 0,
		'auto_optimize'          => 1,
		'backup'                 => 1,
		'resize_larger'          => 1,
		'resize_larger_w'        => 2560,
		'display_nextgen'        => 1,
		'display_nextgen_method' => 'rewrite',
		'display_webp'           => 1,
		'display_webp_method'    => 'rewrite',
		'cdn_url'                => '',
		'disallowed-sizes'       => [],
		'admin_bar_menu'         => 0,
		'partner_links'          => 0,
		'convert_to_avif'        => 1,
		'convert_to_webp'        => 1,
		'optimization_format'    => 'avif',
	];
}
