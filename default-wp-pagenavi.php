<?php
/*
 Plugin Name: BEA Default - WP Pagenavi
 Version: 1.0.0
 Plugin URI: https://beapi.fr
 Description: Set options
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


/**
 * Default options
 */
add_filter( 'pre_' . 'pagenavi_options', 'bea_default_pagenavi_options' );
add_filter( 'option_' . 'pagenavi_options', 'bea_default_pagenavi_options' );

function bea_default_pagenavi_options() {
	return [
		'pages_text'                   => '',
		'current_text'                 => '%PAGE_NUMBER%',
		'page_text'                    => '%PAGE_NUMBER%',
		'first_text'                   => '',
		'last_text'                    => '',
		'prev_text'                    => '%%PREVIOUS_PAGE%%',
		'next_text'                    => '%%NEXT_PAGE%%',
		'dotleft_text'                 => '...',
		'dotright_text'                => '...',
		'num_pages'                    => 3,
		'num_larger_page_numbers'      => 3,
		'larger_page_numbers_multiple' => 0,
		'always_show'                  => 0,
		'use_pagenavi_css'             => 0,
		'style'                        => 1,
	];
}


add_filter( 'wp_pagenavi', 'bea_wp_pagination', 10, 2 );

/**
 * Customize output html for "Amazon pagination like"
 *
 * @param $html
 *
 * @return mixed
 * @author Alexandre Sadowski
 */
function bea_wp_pagination( $html ) {
	global $wp_query;

	$html = str_replace( '%%PREVIOUS_PAGE%%', '<svg class="icon" aria-hidden="true" role="img">
			<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-arrow-left"></use>
		</svg>', $html );

	$html = str_replace( '%%NEXT_PAGE%%', '<svg class="icon" aria-hidden="true" role="img">
			<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-arrow-right"></use>
		</svg>', $html );

	$total_pages = max( 1, absint( $wp_query->max_num_pages ) );

	$html = str_replace( '<a class="nextpostslink"', '<span class="extend">' . $total_pages . '</span><a class="nextpostslink"', $html );

	return $html;
}