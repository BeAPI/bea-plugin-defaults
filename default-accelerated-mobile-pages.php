<?php
/*
Plugin Name: BEA Default - Accelerated Mobile Pages
Version: 1.0.0
Plugin URI: https://beapi.fr
Description: Force default options for Accelerated Mobile Pages
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

namespace BEAPI\Plugin_Defaults\AMP;

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Cannot access pages directly.' );
}

/**
 * Set by default AMP metabox to be on "Hide" for posts and pages
 *
 * @author Maxime CULEA
 */
add_action(
	'admin_print_footer_scripts',
	function () {
		$screen = get_current_screen();
		if ( empty( $screen ) ) {
			return;
		}

		if ( 'add' !== $screen->action || 'post' !== $screen->base ) {
			return;
		}

		if ( ! in_array( $screen->post_type, [ 'post', 'page' ], true ) ) {
			return;
		}

		echo '<script type="text/javascript">jQuery("#ampforwp-on-off-meta-radio-two").attr("checked",true);</script>';
	}
);
