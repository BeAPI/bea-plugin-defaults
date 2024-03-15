<?php
/*
Plugin Name: BEA Default - Max Srcset Image Width
Version: 1.0.0
Plugin URI: https://beapi.fr
Description: Set maximum srcset of image width for images markup
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
namespace BEAPI\Plugin_Defaults\Max_Srcset_Image_Width;

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Cannot access pages directly.' );
}

add_filter( 'max_srcset_image_width',  __NAMESPACE__ . '\\optimize_srcset_maximum_width', 10, 2 );

/**
 * Optimize srcset maximum width contextually
 * @see https://developer.wordpress.org/reference/hooks/wp_calculate_image_sizes/
 * instead of using the default max_srcset_image_width of 2048px, we can use a custom value
 * based on the current image size and multiply it by 2 (or 3) for retina displays
 * example : In request a 'medium' size of 300px, the max_srcset_image_width will be 600px
 * in this case, the browser will only load images up to 600px wide if retina.
 * @param $max_srcset_image_width
 * @param $sizes_array
 *
 * @return float|int
 */
function optimize_srcset_maximum_width( $max_srcset_image_width, $sizes_array ) {
	return $sizes_array[0] * 2;
}
