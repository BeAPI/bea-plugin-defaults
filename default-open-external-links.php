<?php
add_filter( 'option_' . 'external_links_in_new_windows_ignore', 'bea_do_not_open_links' );
add_filter( 'pre_option_' . 'external_links_in_new_windows_ignore', 'bea_do_not_open_links' );
add_filter( 'default_' . 'external_links_in_new_windows_ignore', 'bea_do_not_open_links' );
add_filter( 'default_option_' . 'external_links_in_new_windows_ignore', 'bea_do_not_open_links' );
add_filter( 'default_site_option_' . 'external_links_in_new_windows_ignore', 'bea_do_not_open_links' );

function bea_do_not_open_links() {
	return 'xxxxxxxxx';
}
