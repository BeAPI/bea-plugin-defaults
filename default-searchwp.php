<?php
/*
Plugin Name: Be API - Default SearchWP
Version: 1.0.0
Plugin URI: https://beapi.fr
Description: Fix Basic Auth with SearchWP
Author: Be API
Author URI: https://beapi.fr

----

Copyright 2023 Be API Technical team (humans@beapi.fr)

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
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Cannot access pages directly.' );
}

if ( defined( 'WP_ENV' ) && WP_ENV === 'production' ) {
	return;
}

const HTTP_USER = 'XXXXXXXX';
const HTTP_PWD  = 'ZZZZZZZZ';

add_filter( 'searchwp\indexer\alternate', '__return_true' );


add_filter(
	'searchwp\background_process\http_basic_auth_credentials',
	function () {
		return [
			// Customize with basic auth credentials
			'username' => HTTP_USER,
			'password' => HTTP_PWD,
		];
	}
);

add_filter(
	'cron_request',
	function ( $cron_request ) {
		if ( ! isset( $cron_request['args']['headers'] ) ) {
			$cron_request['args']['headers'] = [];
		}

		if ( isset( $cron_request['args']['headers']['Authorization'] ) ) {
			return $cron_request;
		}

		$cron_request['args']['headers']['Authorization'] = sprintf(
			'Basic %s',
			// Customize with basic auth credentials
			base64_encode( HTTP_USER . ':' . HTTP_PWD ) //phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_encode
		);

		return $cron_request;
	},
	999
);
