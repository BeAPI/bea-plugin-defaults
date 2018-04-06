<?php
/*
  Plugin Name: Optimus - Default
  Plugin URI: https://beapi.fr
  Description: Set options dans keys
  Author: BeAPI
  Author URI: https://beapi.fr
  Version: 1.0.0
 */

/**
 * Default options
 */
add_filter( 'pre_option_optimus', function () {
	return [
		'copy_markers'     => 0,
		'webp_convert'     => 0,
		'keep_original'    => 0,
		'secure_transport' => 1,
		'manual_optimize'  => 0,
	];
} );
