<?php
/*
Plugin Name: No transients in database
Version: 1.1.1
Description: Keep transients out of wp_options when WordPress uses object cache storage (wp_using_ext_object_cache() || wp_installing()), with cleanup on native wp_scheduled_delete.
Plugin URI: https://beapi.fr
Author: Be API
Author URI: https://beapi.fr

----

Copyright 2025 Be API Technical team (humans@beapi.fr)

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

namespace BeAPI;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Class to prevent transients from being stored in the database
 * since we're using Redis for object caching
 */
class NoTransients {
	/**
	 * Initialize the class and set up hooks
	 */
	public function __construct() {
		// Mirror WordPress core transient storage condition.
		if ( ! $this->should_handle_transients() ) {
			return;
		}

		// Prevent transients from being retrieved
		add_filter( 'pre_option', [ $this, 'prevent_transient_retrieval' ], 10, 2 );

		// Remove transients from alloptions
		add_filter( 'alloptions', [ $this, 'remove_transients_from_alloptions' ] );

		// Prevent new transients from being added
		add_action( 'added_option', [ $this, 'delete_transient_option' ] );

		// Prevent transients from being updated
		add_action( 'updated_option', [ $this, 'delete_transient_option' ] );

		// Use WordPress native cleanup cron event.
		add_action( 'wp_scheduled_delete', [ $this, 'cleanup_transients' ] );
	}

	/**
	 * Make transients appear expired by returning 0 for timeout options
	 *
	 * @param mixed $pre The pre-option value
	 * @param string $option The option name
	 *
	 * @return mixed The modified pre-option value
	 */
	public function prevent_transient_retrieval( $pre, $option ) {
		// If it's a transient timeout, return 0 to make it appear expired
		if ( str_starts_with( $option, '_transient_timeout' ) ) {
			return 0;
		}

		return $pre;
	}

	/**
	 * Remove transient entries from the alloptions cache.
	 *
	 * WordPress may bypass timeout checks when a transient is present in alloptions.
	 * By unsetting these keys here, transient reads follow the normal path.
	 *
	 * @param array $alloptions The array of all autoloaded options.
	 * @return array The filtered options array.
	 */
	public function remove_transients_from_alloptions( $alloptions ) {
		// Unhook first to avoid re-entrancy while alloptions is being resolved.
		remove_filter( 'alloptions', [ $this, 'remove_transients_from_alloptions' ] );

		foreach ( $alloptions as $option => $value ) {
			if ( ! str_starts_with( $option, '_transient' ) ) {
				continue;
			}

			unset( $alloptions[ $option ] );
		}

		return $alloptions;
	}

	/**
	 * Delete transient options when they're added or updated
	 *
	 * @param string $option The option name
	 * @param mixed $value The option value
	 */
	public function delete_transient_option( $option ) {
		if ( str_starts_with( $option, '_transient' ) ) {
			delete_option( $option );
		}
	}

	/**
	 * Clean up all transients from the database.
	 *
	 * Runs on WordPress native cron hook `wp_scheduled_delete`,
	 * which is scheduled once per day.
	 */
	public function cleanup_transients() {
		if ( ! $this->should_handle_transients() ) {
			return;
		}

		global $wpdb;

		// Delete all transients
		$wpdb->query( "DELETE FROM $wpdb->options WHERE option_name LIKE '_transient_%'" );
	}

	/**
	 * Match WordPress core transient behavior gate.
	 *
	 * Core uses object cache storage when external object cache is enabled
	 * or while WordPress is installing.
	 *
	 * @return bool
	 */
	private function should_handle_transients() {
		return wp_using_ext_object_cache() || wp_installing();
	}
}

new NoTransients();
