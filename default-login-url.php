<?php
/*
Plugin Name: BEA Default - Login URL
Version: 1.0.0
Plugin URI: https://beapi.fr
Description: Change the default logo url in WordPress login page
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
namespace BEAPI\Plugin_Defaults\Login_Url;

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Cannot access pages directly.' );
}

add_filter( 'login_headerurl', __NAMESPACE__ . '\\custom_login_url' );

/**
 * Change the default logo url in WordPress login page
 *
 * @param $url
 *
 * @return string
 * @author Milan RICOUL
 */
function custom_login_url( $url ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
	return 'https://beapi.fr/';
}
