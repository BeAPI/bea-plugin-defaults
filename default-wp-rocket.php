<?php
/**
 * Plugin Name:       Be API - WP Rocket config
 * Plugin URI:        https://github.com/BeAPI/bea-plugin-defaults
 * Description:       Default options for WP Rocket (caching, minification, preload, etc.).
 * Version:           1.0.0
 * Requires at least: 5.9
 * Requires PHP:      7.4
 * Author:            BeAPI
 * Author URI:        https://beapi.fr
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       bea-plugin-defaults
 *
 * =============================================================================
 * >>> REMINDER: This file MUST be customized per project. <<<
 * =============================================================================
 * Review and adjust every option below (enable/disable, comment/uncomment)
 * according to the project's hosting, cache layer, and performance requirements.
 * =============================================================================
 *
 * All options below use the pre_get_rocket_option_{option_name} filter system.
 *
 * @see https://docs.wp-rocket.me/article/1564-list-of-pre-get-rocket-option-filters
 * @see https://docs.wp-rocket.me/article/1677-how-to-programmatically-configure-wp-rocket-options
 */

namespace BEAPI\Plugin_Defaults\WP_Rocket;

/**
 * Enable mobile cache (WP Rocket will apply cache rules for mobile user agents).
 * Used together with do_caching_mobile_files below.
 *
 * @see https://docs.wp-rocket.me/article/708-mobile-cache
 * @see https://github.com/wp-media/wp-rocket-helpers/blob/master/cache/wp-rocket-customize-mobile-cache/wp-rocket-customize-mobile-cache.php
 */
add_filter( 'pre_get_rocket_option_cache_mobile', '__return_true' );

/**
 * Enable separate cache files for mobile (split cache by device).
 * WP Rocket serves a distinct cache for mobile user agents; enables above-the-fold,
 * LRC and preconnect optimizations for mobile. Use more storage.
 */
add_filter( 'pre_get_rocket_option_do_caching_mobile_files', '__return_true' );

/**
 * Load CSS files asynchronously to prevent render-blocking.
 * Improves LCP; critical CSS can be inlined while other styles load async.
 *
 * @see https://docs.wp-rocket.me/article/1266-load-css-asynchronously
 */
add_filter( 'pre_get_rocket_option_async_css', '__return_true' );

/**
 * Disable Remove Unused CSS (no automatic removal of unused CSS from stylesheets).
 * If you enable this option: it only works for public sites (crawlable by WP Rocket),
 * read the WP Rocket documentation carefully, enable it together with preload (sitemap
 * or manual) so the critical CSS is generated correctly, and disable async CSS
 * (pre_get_rocket_option_async_css) when using this feature.
 *
 * @see https://docs.wp-rocket.me/article/1529-remove-unused-css
 */
add_filter( 'pre_get_rocket_option_remove_unused_css', '__return_zero' );

/**
 * Minify CSS files to reduce size and number of requests.
 */
add_filter( 'pre_get_rocket_option_minify_css', '__return_true' );

/**
 * Minify JavaScript files to reduce size and parse time.
 */
add_filter( 'pre_get_rocket_option_minify_js', '__return_true' );

/**
 * Defer parsing of JavaScript so it does not block initial page render.
 * Scripts load after the page is interactive; exclude any that must run immediately if needed.
 *
 * @see https://docs.wp-rocket.me/article/976-exclude-files-from-defer-js
 */
add_filter( 'pre_get_rocket_option_defer_all_js', '__return_true' );

/**
 * Optimize CSS delivery (e.g. remove unused CSS / critical CSS).
 * Reduces render-blocking and improves First Contentful Paint.
 */
add_filter( 'pre_get_rocket_option_optimize_css_delivery', '__return_true' );

/**
 * Disable sitemap-based cache preloading (WP Rocket will NOT crawl sitemap URLs to warm cache).
 * Key pages will NOT be cached via sitemap preload after clearing or on a schedule.
 */
add_filter( 'pre_get_rocket_option_sitemap_preload_url_crawl', '__return_zero' );

/**
 * Disable manual cache preload via WP Rocket admin.
 *
 * For advanced or configurable preloading, consider the WP Rocket Smart Preload helper:
 * @see https://github.com/wp-media/wp-rocket-smart-preload
 */
add_filter( 'pre_get_rocket_option_manual_preload', '__return_zero' );

/**
 * Enable preload for links (prefetch on hover or in viewport).
 * Speeds up navigation when users click preloaded links.
 */
add_filter( 'pre_get_rocket_option_preload_links', '__return_true' );

/**
 * Enable Heartbeat API control (throttle or disable in admin/frontend).
 * Reduces CPU and requests from the WordPress Heartbeat.
 */
add_filter( 'pre_get_rocket_option_control_heartbeat', '__return_true' );

/**
 * Prevent WP Rocket from writing define( 'WP_CACHE', true ) into wp-config.php.
 * Use when WP_CACHE is already defined (e.g. Bedrock, custom config) to avoid fatal errors.
 *
 * @see https://docs.wp-rocket.me/article/958-how-to-use-wp-rocket-with-bedrock-wordpress-boilerplate
 * @see https://docs.wp-rocket.me/article/1518-wpcache-is-set-to-false
 */
add_filter( 'rocket_set_wp_cache_constant', '__return_false' );

/**
 * Completely disable page caching in WP Rocket.
 *
 * Use this if full page caching is already handled by a reverse proxy such as Varnish, Cloudflare, or Batcache.
 * Prevents WP Rocket from generating static HTML cache files to avoid duplicate or conflicting cache layers.
 *
 * @see   https://docs.wp-rocket.me/article/61-disable-page-caching
 *
 * Uncomment the line below to activate.
 * add_filter( 'do_rocket_generate_caching_files', '__return_false' );
 */

/*
 * Completely disable WP Rocket writing to advanced-cache.php
 *
 * @see: https://github.com/wp-media/wp-rocket/issues/4707
 *
 * Uncomment the line below to activate.
 * add_filter( 'rocket_generate_advanced_cache_file', '__return_false' );
 */

/*
 * Completely disable WP Rocket writing to .htaccess (e.g. Nginx, or .htaccess managed elsewhere).
 *
 * @see: https://github.com/wp-media/wp-rocket-helpers/blob/master/htaccess/wp-rocket-no-htaccess/wp-rocket-no-htaccess.php
 *
 * Uncomment the line below to activate.
 * add_filter( 'rocket_disable_htaccess', '__return_true' );
 */
