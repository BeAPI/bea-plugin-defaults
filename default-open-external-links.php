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
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Cannot access pages directly.' );
}

add_filter( 'option_' . 'external_links_in_new_windows_ignore', 'bea_default_do_not_open_links' );
add_filter( 'pre_option_' . 'external_links_in_new_windows_ignore', 'bea_default_do_not_open_links' );
add_filter( 'default_' . 'external_links_in_new_windows_ignore', 'bea_default_do_not_open_links' );
add_filter( 'default_option_' . 'external_links_in_new_windows_ignore', 'bea_default_do_not_open_links' );
add_filter( 'default_site_option_' . 'external_links_in_new_windows_ignore', 'bea_default_do_not_open_links' );

function bea_default_do_not_open_links() {
	return 'http://xxxx.fr';
}
