<?php
/**
 * Plugin Name: FitLife
 * Description: Fitness Management Plugin
 * Version: 1.0
 * Author: Deepak Kumar Singh
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define(
	'FITLIFE_PLUGIN_PATH',
	plugin_dir_path( __FILE__ )
);

require_once FITLIFE_PLUGIN_PATH . 'includes/class-fitlife-cpt.php';
require_once FITLIFE_PLUGIN_PATH . 'includes/class-fitlife-meta-boxes.php';
require_once FITLIFE_PLUGIN_PATH . 'includes/class-fitlife-admin-columns.php';
require_once FITLIFE_PLUGIN_PATH . 'includes/class-fitlife-rest-api.php';
require_once FITLIFE_PLUGIN_PATH . 'includes/class-fitlife-settings.php';
require_once FITLIFE_PLUGIN_PATH . 'includes/class-fitlife-shortcodes.php';
require_once FITLIFE_PLUGIN_PATH . 'includes/class-fitlife-woocommerce.php';
require_once FITLIFE_PLUGIN_PATH . 'includes/class-fitlife-blocks.php';

new FitLife_Blocks();
new FitLife_CPT();
new FitLife_Meta_Boxes();
new FitLife_Admin_Columns();
new FitLife_REST_API();
new FitLife_Settings();
new FitLife_Shortcodes();
new FitLife_WooCommerce();


add_filter(
	'xmlrpc_enabled',
	'__return_false'
);

add_filter(
	'wp_headers',
	function( $headers ) {

		unset(
			$headers['X-Pingback']
		);

		return $headers;
	}
);