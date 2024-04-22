<?php
/*
Plugin Name: BEA Default - Gravity forms
Version: 1.0.0
Plugin URI: https://beapi.fr
Description: Change submit form behavior
Author: Be API
Author URI: https://beapi.fr

----

Copyright 2022 Be API Technical team (humans@beapi.fr)

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
namespace BEAPI\Plugin_Defaults\Gravity_Forms;

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Cannot access pages directly.' );
}

add_filter( 'gform_submit_button', __NAMESPACE__ . '\\form_submit_button', 10, 2 );

/**
 * Replace submit input to button
 *
 * @param string $button
 * @param array $form
 *
 * @return string
 *
 * @author Léonard Phoumpakka
 */
function form_submit_button( string $button, array $form ): string {
	return sprintf( "<button class='button gform_button' id='gform_submit_button_%d'><span>%s</span></button>", $form['id'], esc_html__( 'Submit', 'gravityforms' ) );
}

add_filter( 'pre_option_rg_gforms_key', __NAMESPACE__ . '\\default_options', 999 );

/**
 * Append automatically the gravity forms license key from constant
 *
 *
 * @param $value
 *
 * @return mixed
 */
function default_options( $value ) {
	return defined( 'GF_LICENSE_KEY' ) ? GF_LICENSE_KEY : $value;
}

add_action( 'gform_after_save_form', __NAMESPACE__ . '\\configuration_default_forms', 10, 2 );

/**
 * Default configuration when creating a form
 *
 * @param array $form
 * @param bool $is_new
 *
 * @return void
 * @author Egidio CORICA
 */
function configuration_default_forms( array $form, bool $is_new ): void {
	if ( ! $is_new ) {
		return;
	}

	$form['enableHoneypot'] = true;
	$form['personalData']   = [
		'preventIP' => true, // the IP address of the user submitting the form will not be saved
		'retention' => [ // form data is deleted after 90 days
			'policy'              => 'delete',
			'retain_entries_days' => '90',
		],
	];

	\GFAPI::update_form( $form );
}
