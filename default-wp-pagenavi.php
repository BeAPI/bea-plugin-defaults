<?php
/*
  Plugin Name: WP Pagenavi - Default
  Plugin URI: https://beapi.fr
  Description: Set options
  Author: Be API
  Author URI: https://beapi.fr
  Version: 1.0.0
 */

/**
 * Default options
 */
add_filter( 'pre_' . 'pagenavi_options', 'bea_pagenavi_options' );
add_filter( 'option_' . 'pagenavi_options', 'bea_pagenavi_options' );

function bea_pagenavi_options() {
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
