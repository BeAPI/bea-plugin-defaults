<?php
/*
Plugin Name: BEA Default - Expire User Passwords
Version: 1.0.0
Plugin URI: https://beapi.fr
Description: Enable & force user passwords expiration for admin (by default) 
Author: Be API
Author URI: https://beapi.fr

----

Copyright 2022 Be API Technical team (humans@beapi.fr)

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
namespace BEAPI\Plugin_Defaults\Expire_Passwords;

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Cannot access pages directly.' );
}

add_filter( 'option_user_expass_settings', __NAMESPACE__ . '\\default_roles' );
add_filter( 'default_option_user_expass_settings', __NAMESPACE__ . '\\default_roles' );

/**
 * Activate the administrator at minimum (forced)
 *
 * @param $settings
 *
 * @return array
 * @author Nicolas JUEN
 */
function default_roles( $settings = [] ) {
	$settings['roles']['administrator'] = 1;
	$settings['send_email']             = 0;

	return $settings;
}
