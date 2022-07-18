<?php
/**
 * Plugin Name: Be API - Disable Gutenberg
 * Description: Disable default option
 * Version: 1.0
 * Author: BE API Technical team
 * Author URI: https://www.beapi.fr
 */

namespace BEAPI\Plugin_Defaults\Disable_Gutenberg;

add_filter( 'pre_option_disable_gutenberg_options', __NAMESPACE__ . '\\disable_gutenberg_options' );

/**
 * Pre disable gutenberg options
 *
 * @param $options_gutenberg
 *
 * @return array
 * @author Egidio CORICA
 */
function disable_gutenberg_options( $options_gutenberg ): array {
	return [
		'disable-all'                => 0,  // Disable Gutenberg everywhere
		'disable-nag'                => 0,  // Disable Gutenberg admin notice
		'hide-menu'                  => 0,  // Option to hide the plugin menu item
		'hide-gut'                   => 0,  // Option to hide the Gutenberg plugin menu item (settings link)
		'templates'                  => '', // Disable Gutenberg to specific template (ex : templates/jobs.php)
		'post-ids'                   => '', // Disable for Post IDs
		'acf-enable'                 => 0,  // Option to enable Custom Fields Meta Box for ACF
		'links-enable'               => 0,  // Display Edit Links
		'whitelist-id'               => '', // Whitelist any ID
		'whitelist-slug'             => '', // Whitelist any slug
		'whitelist-title'            => '', // Whitelist any post title
		'whitelist'                  => 0,  // Whitelist any post title, slug, or ID
		'styles-enable'              => 0,  // Option to enable/disable frontend Gutenberg stylesheet
		'classic-widgets'            => 0,  // Option to restore Classic Widgets
		'post-type_post'             => 0,  // Disable Gutenberg for Posts
		'post-type_page'             => 0,  // Disable Gutenberg for Pages
		'post-type_wp_template'      => 0,  // Disable Gutenberg for Templates
		'post-type_wp_template_part' => 0,  // Disable Gutenberg for Template Parts
		'post-type_wp_global_styles' => 0,  // Disable Gutenberg for Global Styles
		'post-type_wp_navigation'    => 0,  // Disable Gutenberg for Navigation Menus
		'post-type_acf-field-group'  => 0,  // Disable Gutenberg for ACF Field Group
		'post-type_acf-field'        => 0,  // Disable Gutenberg for ACF Field
		'user-role_administrator'    => 0,  // Disable Gutenberg for Administrator
		'user-role_editor'           => 0,  // Disable Gutenberg for Editor
		'user-role_author'           => 0,  // Disable Gutenberg for Author
		'user-role_contributor'      => 0,  // Disable Gutenberg for Contributor
		'user-role_subscriber'       => 0,  // Disable Gutenberg for Subscriber
		'user-role_wpseo_manager'    => 0,  // Disable Gutenberg for Seo Manager
		'user-role_wpseo_editor'     => 0,  // Disable Gutenberg for Seo Editor
	];
}
