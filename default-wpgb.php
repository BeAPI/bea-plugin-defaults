<?php
/*
Plugin Name: BeAPI Default - WP Grid Builder
Version: 1.0.0
Plugin URI: https://beapi.fr
Description: Add default settings for WP Grid Builder
Author: Be API
Author URI: https://beapi.fr

----

Copyright 2024 Be API Technical team (humans@beapi.fr)

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

namespace BEAPI\Plugin_Defaults\WP_Grid_Builder;

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Cannot access pages directly.' );
}

add_filter( 'wp_grid_builder/facet/title_tag', __NAMESPACE__ . '\\facet_title_tag', 10, 1 );

/**
 * Change the title tag for facets labels in front office (by default h2)
 * See https://docs.wpgridbuilder.com/resources/filter-facet-title-tag/
 *
 * @param string $title_tag
 *
 * @return string
 */
function facet_title_tag( string $title_tag ): string {
	return 'p';
}
