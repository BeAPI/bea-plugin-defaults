<?php
/*
Plugin Name: Be API - PDA Activation for BeAPI usage
Version: 1.0.0
Plugin URI:
Description: Disable Prevent Direct Access (PDA) licence using for all environments except for production env
Author: Be API Technical team
Author URI: https://beapi.fr
Domain Path: languages
Text Domain: default-prevent-direct-access

--------

Copyright 2018 Be API Technical team (human@beapi.fr)

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

namespace BEAPI\Plugin_Defaults\PDA;

add_action( 'wp_ajax_Prevent_Direct_Access_Gold_Check_Licensed', __NAMESPACE__ . '\\force_activation', 1 );

/**
 * Disable PDA licence using for all environments except production
 * Require to define "WP_ENV" in prod env
 * By default don't use licence
 *
 *
 * @author Léonard Phoumpakka
 *
 */
function force_activation() {

	if ( ! class_exists( '\PDA_v3_Constants' ) ) {
		return;
	}

	// Active licence only if is prod env
	if ( defined( 'WP_ENV' ) && 'prod' === WP_ENV ) {
		return;
	}

	$nonce = $_REQUEST['security_check']; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( ! wp_verify_nonce( $nonce, \PDA_v3_Constants::LICENSE_FORM_NONCE ) ) {
		error_log( 'not verify nonce', 0 ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
		wp_die( 'invalid_nonce' );
	}

	$license = $_REQUEST['license'];
	if ( empty( $license ) ) {
		update_option( \PDA_v3_Constants::LICENSE_ERROR, 'Invalid license', 'no' );
		wp_send_json( false );
	}

	update_option( \PDA_v3_Constants::LICENSE_KEY, $license, 'no' );
	update_option( \PDA_v3_Constants::LICENSE_OPTIONS, true, 'no' );
	update_option( \PDA_v3_Constants::LICENSE_ERROR, '', 'no' );
	delete_option( \PDA_v3_Constants::LICENSE_EXPIRED );

	\Pda_v3_Gold_Helper::set_default_settings_for_multisite();

	$service = new \PDA_Services();
	$service->handle_license_info();
	$cronjob_handler = new \PDA_Cronjob_Handler();
	$cronjob_handler->unschedule_ls_cron_job();
	$cronjob_handler->schedule_ls_cron_job();

	$db = new \PDA_v3_DB();
	$db->run();

	wp_send_json( true );
	exit();
}
