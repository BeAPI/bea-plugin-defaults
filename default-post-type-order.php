<?php
/**
 * Add default options for post type order
 *
 * @author Maxime CULEA
 */
add_filter( 'pto/get_options', function () {
	return [
		'show_reorder_interfaces' => [
			'post'       => 'hide',
			'attachment' => 'hide',
			'promotion'  => 'hide',
			'marque'     => 'show'
		],
		'autosort'                => 1,
		'adminsort'               => 1,
		'archive_drag_drop'       => 1,
		'capability'              => 'edit_posts',
		'navigation_sort_apply'   => 1
	];
} );
