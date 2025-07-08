<?php
/*
Plugin Name: WP Saml Auth - SSO config
Version: 1.0.0
Plugin URI: https://beapi.fr
Description: SSO configuration
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

namespace BEAPI\Plugin_Defaults\Wp_Saml_Auth;

// Constants to be defined as env vars
if ( ! defined( 'SAML_IDP_ENTITY_ID' ) || ! defined( 'SAML_IDP_URL' ) || ! defined( 'SAML_LOGOUT_URL' ) || ! defined( 'SAML_CERT_PATH' ) || ! file_exists( SAML_CERT_PATH ) ) {
	return;
}

add_filter( 'wp_saml_auth_option', __NAMESPACE__ . '\\wp_saml_filter_option', 10, 2 );

/**
 * Set options for SAML
 * xxxx_attribute items might need to be adapted to the contents of the SAML response
 *
 * @param $value
 * @param $option_name
 *
 * @return mixed
 *
 */
function wp_saml_filter_option( $value, $option_name ) {

	$defaults = [
		/**
		 * Type of SAML connection bridge to use.
		 *
		 * 'internal' uses OneLogin bundled library; 'simplesamlphp' uses SimpleSAMLphp.
		 *
		 * Defaults to SimpleSAMLphp for backwards compatibility.
		 *
		 * @param string
		 */
		'connection_type'        => 'internal',
		/**
		 * Configuration options for OneLogin library use.
		 *
		 * See comments with "Required:" for values you absolutely need to configure.
		 *
		 * @param array
		 */
		'internal_config'        => [
			// Validation of SAML responses is required.
			'strict'   => true,
			'debug'    => defined( 'WP_DEBUG' ) && WP_DEBUG,
			'baseurl'  => home_url(),
			'sp'       => [
				'entityId'                 => 'urn:' . parse_url( home_url(), PHP_URL_HOST ), //phpcs:ignore WordPress.WP.AlternativeFunctions.parse_url_parse_url
				'assertionConsumerService' => [
					'url'     => wp_login_url(),
					'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
				],
			],
			'idp'      => [
				// Required: Set based on provider's supplied value.
				'entityId'                 => SAML_IDP_ENTITY_ID,
				'singleSignOnService'      => [
					// Required: Set based on provider's supplied value.
					'url'     => SAML_IDP_URL,
					'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
				],
				'singleLogoutService'      => [
					// Required: Set based on provider's supplied value.
					'url'     => SAML_LOGOUT_URL,
					'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
				],
				// Required: Contents of the IDP's public x509 certificate.
				// Use file_get_contents() to load certificate contents into scope.
				'x509cert'                 => file_get_contents( SAML_CERT_PATH ), //phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
				// Optional: Instead of using the x509 cert, you can specify the fingerprint and algorithm.
				'certFingerprint'          => '',
				'certFingerprintAlgorithm' => '',
			],
			'security' => [
				'nameIdEncrypted'            => false,
				'requestedAuthnContext'      => [
					'urn:oasis:names:tc:SAML:2.0:ac:classes:Unspecified', // Not specify password for use MFA
				],
				'authnRequestsSigned'        => false,
				'logoutRequestSigned'        => false,
				'logoutResponseSigned'       => false,
				'signMetadata'               => false,
				'wantMessagesSigned'         => false,
				'wantAssertionsSigned'       => false,
				'wantNameId'                 => true,
				'relaxDestinationValidation' => false,
				'destinationStrictlyMatches' => false,
				'allowRepeatAttributeName'   => false,
				'rejectUnsolicitedResponsesWithInResponseTo' => false,
				'wantAssertionsEncrypted'    => false,
				'wantNameIdEncrypted'        => false,
				'wantXMLValidation'          => true,
				'signatureAlgorithm'         => 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha256',
				'digestAlgorithm'            => 'http://www.w3.org/2001/04/xmlenc#sha256',
				'encryption_algorithm'       => 'http://www.w3.org/2001/04/xmlenc#aes128-cbc',
				'lowercaseUrlencoding'       => false,
			],
		],
		/**
		 * Path to SimpleSAMLphp autoloader.
		 *
		 * Follow the standard implementation by installing SimpleSAMLphp
		 * alongside the plugin, and provide the path to its autoloader.
		 * Alternatively, this plugin will work if it can find the
		 * `SimpleSAML_Auth_Simple` class.
		 *
		 * @param string
		 */
		'simplesamlphp_autoload' => __DIR__ . '/simplesamlphp/lib/_autoload.php',
		/**
		 * Authentication source to pass to SimpleSAMLphp
		 *
		 * This must be one of your configured identity providers in
		 * SimpleSAMLphp. If the identity provider isn't configured
		 * properly, the plugin will not work properly.
		 *
		 * @param string
		 */
		'auth_source'            => 'default-sp',
		/**
		 * Whether or not to automatically provision new WordPress users.
		 *
		 * When WordPress is presented with a SAML user without a
		 * corresponding WordPress account, it can either create a new user
		 * or display an error that the user needs to contact the site
		 * administrator.
		 *
		 * @param bool
		 */
		'auto_provision'         => true,
		/**
		 * Whether or not to permit logging in with username and password.
		 *
		 * If this feature is disabled, all authentication requests will be
		 * channeled through SimpleSAMLphp.
		 *
		 * @param bool
		 */
		'permit_wp_login'        => true,
		/**
		 * Attribute by which to get a WordPress user for a SAML user.
		 *
		 * @param string Supported options are 'email' and 'login'.
		 */
		'get_user_by'            => 'email',
		/**
		 * SAML attribute which includes the user_login value for a user.
		 *
		 * @param string
		 */
		'user_login_attribute'   => 'emailaddress',
		/**
		 * SAML attribute which includes the user_email value for a user.
		 *
		 * @param string
		 */
		'user_email_attribute'   => 'emailaddress',
		/**
		 * SAML attribute which includes the display_name value for a user.
		 *
		 * @param string
		 */
		'display_name_attribute' => 'display_name',
		/**
		 * SAML attribute which includes the first_name value for a user.
		 *
		 * @param string
		 */
		'first_name_attribute'   => 'first_name',
		/**
		 * SAML attribute which includes the last_name value for a user.
		 *
		 * @param string
		 */
		'last_name_attribute'    => 'last_name',
		/**
		 * Default WordPress role to grant when provisioning new users.
		 *
		 * @param string
		 */
		'default_role'           => get_option( 'default_role' ),
	];

	$value = isset( $defaults[ $option_name ] ) ? $defaults[ $option_name ] : $value;

	return $value;
}
