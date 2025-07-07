<?php
/**
 * Plugin Name: Be API - Cache-control Defaults
 * Description: Configure default cache-control settings for the cache-control plugin.
 * Version: 2.0
 * Author: BE API Technical team
 * Author URI: https://www.beapi.fr
 * License: GPL v2 or later
 */

namespace BEAPI\Plugin_Defaults\cache_control;

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default cache control configuration
 * 
 * This array defines the default settings for each cache control option.
 * The structure follows the same pattern as the cache-control plugin.
 * 
 * Available options for each entry:
 * - max_age: Cache duration in seconds for browsers (defined only 1 time on cache_control_default_settings function)
 * - s_maxage: Cache duration in seconds for CDN/proxies
 * - staleerror: Duration to serve stale content on server errors (auto-defined x3 s_maxage)
 * - stalereval: Duration to serve stale content while revalidating (auto-defined x5 s_maxage)
 * - paged: Pagination factor (only for paginated content)
 * - mmulti: Enable age multiplier based on last modification (only for singles)
 * 
 * @return array Default cache control settings
 */
function get_default_cache_control_settings() {
	return array(
		'front_page' => array(
			's_maxage'   => 36000, // 10 hours
		),
		'singles' => array(
			's_maxage'   => 36000, // 10 hours
			'mmulti'     => 1,     // Enable age multiplier
		),
		'pages' => array(
			's_maxage'   => 36000, // 10 hours
		),
		'home' => array(
			's_maxage'   => 36000, // 10 hours
			'paged'      => 5,     // 5 seconds pagination factor. Example : 10 pages * 5 seconds = 50 seconds
		),
		'categories' => array(
			's_maxage'   => 36000, // 10 hours
			'paged'      => 8,     // 8 seconds pagination factor
		),
		'tags' => array(
			's_maxage'   => 36000, // 10 hours
			'paged'      => 10,    // 10 seconds pagination factor
		),
		'authors' => array(
			's_maxage'   => 36000, // 10 hours
			'paged'      => 10,    // 10 seconds pagination factor
		),
		'dates' => array(
			's_maxage'   => 43200, // 12 hours
		),
		'feeds' => array(
			's_maxage'   => 36000, // 10 hours
		),
		'attachment' => array(
			's_maxage'   => 43200, // 12 hours
		),
		'search' => array(
			's_maxage'   => 36000, // 10 hours
		),
		'notfound' => array(
			's_maxage'   => 36000, // 10 hours
		),
		'redirect_permanent' => array(
			's_maxage'   => 604800, // 1 week
		),
		// WooCommerce specific settings (if WooCommerce is active)
		'woocommerce_product' => array(
			's_maxage'   => 36000, // 10 hours
		),
		'woocommerce_category' => array(
			's_maxage'   => 36000, // 10 hours
		),
	);
}

/**
 * Apply default cache control settings
 */
function cache_control_default_settings() {
	global $cache_control_options;

	if ( empty( $cache_control_options ) ) {
		return;
	}

	$default_settings = get_default_cache_control_settings();

	foreach ( $cache_control_options as $index => $options ) {
		// Allow cache on browser for 5 seconds
		$options['max_age']  = 5;
		
		// If default settings for this option, set them
		if ( isset( $default_settings[ $index ] ) ) {
			$defaults = $default_settings[ $index ];

			// Set s_maxage
			$options['s_maxage'] = $defaults['s_maxage'];

			// Set staleerror
			// On Server error, the page can be served 3 times the original value
			$options['staleerror'] = $defaults['s_maxage'] * 3;
	
			// The stored by Varnish will be served for 5 times the original value even if the page is expired.
			// Server will get the new version as soon as one new user get it.
			$options['stalereval'] = $defaults['s_maxage'] * 5;
		}
		
		$cache_control_options[ $index ] = $options;
	}
}

// Hook to apply default settings after plugins are loaded
add_action( 'plugins_loaded', __NAMESPACE__ . '\\cache_control_default_settings' );

/**
 * Filter cache-control options when they are read from database
 * 
 * @param mixed  $pre          Pre-filtered value
 * @param string $option       Option name
 * @param mixed  $default_value Default value
 * @return mixed Filtered value
 */
function cache_control_filter_option( $pre, $option, $default_value ) {
	// Use always default value for cache-control options
	if ( str_contains( $option, 'cache_control_' ) ) {
		return $default_value;
	}
	
	return $pre;
}

// Hook to filter options when they are read
add_filter( 'pre_option', __NAMESPACE__ . '\\cache_control_filter_option', 10, 3 );

/**
 * Disable cache-control admin page
 */
function cache_control_disable_admin_page() {
    // Remove the admin menu page
    remove_submenu_page( 'options-general.php', 'cache_control' );
    
    // Remove action links from plugin list
    remove_filter( 'plugin_action_links_' . plugin_basename( 'cache-control/cache-control.php' ), 'cache_control_admin_action_links' );
    
    // Remove meta links from plugin list
    remove_filter( 'plugin_row_meta', 'cache_control_admin_actions', 10 );
}

// Hook to disable admin page after it's been added
add_action( 'admin_menu', __NAMESPACE__ . '\\cache_control_disable_admin_page', 999 );

/**
 * Add warning notice on cache-control admin page
 */
function cache_control_add_admin_notice() {
    // Only show on cache-control admin page
    if ( ! isset( $_GET['page'] ) || $_GET['page'] !== 'cache_control' ) {
        return;
    }
    
    ?>
    <div class="notice notice-warning is-dismissible">
        <p>
            <strong>⚠️ Configuration locked</strong><br>
            This page is displayed but no action is possible. Cache settings are automatically managed by the mu-plugin <code>default-cache-control.php</code>.
        </p>
    </div>
    <?php
}

// Hook to add notice on admin pages
add_action( 'admin_notices', __NAMESPACE__ . '\\cache_control_add_admin_notice' );
