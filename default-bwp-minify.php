<?php
/**
 * Plugin name: Fix BWP
 * Author: Be API
 */
/**
 * Use the native filter BWP
 * to exclude selectivizr in all themes (we use the same handle)
 * cause it breaks the main menu
 * @author Julien Maury
 */
add_filter( 'bwp_minify_script_ignore', function ( $scripts ){
	$scripts[] = 'selectivizr';
	return $scripts;
});
