<?php
/*
Plugin Name: BEA Default - Open External Links
Version: 1.0.0
Plugin URI: https://beapi.fr
Description: Ignore some url for open external links plugin
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
namespace BEAPI\Plugin_Defaults\Open_External_Links;

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Cannot access pages directly.' );
}

add_filter( 'option_external_links_in_new_windows_ignore', __NAMESPACE__ . '\\ignore_links' );
add_filter( 'pre_option_external_links_in_new_windows_ignore', __NAMESPACE__ . '\\ignore_links' );
add_filter( 'default_external_links_in_new_windows_ignore', __NAMESPACE__ . '\\ignore_links' );
add_filter( 'default_option_external_links_in_new_windows_ignore', __NAMESPACE__ . '\\ignore_links' );
add_filter( 'default_site_option_external_links_in_new_windows_ignore', __NAMESPACE__ . '\\ignore_links' );

/**
 * Overwrite the ignored links for oel.
 *
 * @param $value
 *
 * @return string
 */
function ignore_links( $value ) :string {
	if ( ! defined( 'OPEN_EXTERNAL_LINKS_IGNORE' ) ) {
		return $value;
	}
	return OPEN_EXTERNAL_LINKS_IGNORE;
}
