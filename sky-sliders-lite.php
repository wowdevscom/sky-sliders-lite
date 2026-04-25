<?php
/**
 * Plugin Name: Sky Sliders — Free Elementor Slider Widgets
 * Description: Free slider widgets for Elementor by Sky Sliders.
 * Version: 1.0.1
 * Author: wowdevs
 * Author URI: https://wowdevs.com
 * Text Domain: sky-sliders-lite
 * Domain Path: /languages/
 * License: GPLv3 or later
 * License URI: https://opensource.org/licenses/GPL-3.0
 * Elementor requires at least: 3.0.0
 * Elementor tested up to: 3.33.0
 *
 * @package SkySlidersLite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'sky_sliders_lite_should_stay_passive' ) ) {
	function sky_sliders_lite_should_stay_passive() {
		$active_plugins = (array) get_option( 'active_plugins', [] );

		if ( is_multisite() ) {
			$network_plugins = array_keys( (array) get_site_option( 'active_sitewide_plugins', [] ) );
			$active_plugins  = array_merge( $active_plugins, $network_plugins );
		}

		$requested_plugin = isset( $_REQUEST['plugin'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['plugin'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

		return defined( 'SKY_SLIDERS_PRO_ACTIVE' )
			|| in_array( 'sky-sliders/sky-sliders.php', $active_plugins, true )
			|| 'sky-sliders/sky-sliders.php' === $requested_plugin;
	}
}

if ( sky_sliders_lite_should_stay_passive() ) {
	return;
}

define( 'SKY_SLIDERS_LITE_ACTIVE', true );
define( 'SKY_SLIDERS_LITE_VERSION', '1.0.1' );
define( 'SKY_SLIDERS_LITE_SLUG', 'sky-sliders-lite' );
define( 'SKY_SLIDERS_LITE_FILE', __FILE__ );
define( 'SKY_SLIDERS_LITE_PATH', plugin_dir_path( SKY_SLIDERS_LITE_FILE ) );
define( 'SKY_SLIDERS_LITE_URL', plugins_url( '/', SKY_SLIDERS_LITE_FILE ) );
define( 'SKY_SLIDERS_LITE_ASSETS_PATH', SKY_SLIDERS_LITE_PATH . 'assets/' );
define( 'SKY_SLIDERS_LITE_ASSETS_URL', SKY_SLIDERS_LITE_URL . 'assets/' );
define( 'SKY_SLIDERS_LITE_MODULES_PATH', SKY_SLIDERS_LITE_PATH . 'modules/' );
define( 'SKY_SLIDERS_LITE_MODULES_URL', SKY_SLIDERS_LITE_URL . 'modules/' );

if ( ! defined( 'SKY_SLIDERS_VERSION' ) ) {
	define( 'SKY_SLIDERS_VERSION', SKY_SLIDERS_LITE_VERSION );
}
if ( ! defined( 'SKY_SLIDERS_SLUG' ) ) {
	define( 'SKY_SLIDERS_SLUG', SKY_SLIDERS_LITE_SLUG );
}
if ( ! defined( 'SKY_SLIDERS__FILE__' ) ) {
	define( 'SKY_SLIDERS__FILE__', SKY_SLIDERS_LITE_FILE );
}
if ( ! defined( 'SKY_SLIDERS_PLUGIN_BASE' ) ) {
	define( 'SKY_SLIDERS_PLUGIN_BASE', plugin_basename( SKY_SLIDERS_LITE_FILE ) );
}
if ( ! defined( 'SKY_SLIDERS_PATH' ) ) {
	define( 'SKY_SLIDERS_PATH', SKY_SLIDERS_LITE_PATH );
}
if ( ! defined( 'SKY_SLIDERS_MODULES_PATH' ) ) {
	define( 'SKY_SLIDERS_MODULES_PATH', SKY_SLIDERS_LITE_MODULES_PATH );
}
if ( ! defined( 'SKY_SLIDERS_INC_PATH' ) ) {
	define( 'SKY_SLIDERS_INC_PATH', SKY_SLIDERS_LITE_PATH . 'includes/' );
}
if ( ! defined( 'SKY_SLIDERS_URL' ) ) {
	define( 'SKY_SLIDERS_URL', SKY_SLIDERS_LITE_URL );
}
if ( ! defined( 'SKY_SLIDERS_ASSETS_URL' ) ) {
	define( 'SKY_SLIDERS_ASSETS_URL', SKY_SLIDERS_LITE_ASSETS_URL );
}
if ( ! defined( 'SKY_SLIDERS_ASSETS_PATH' ) ) {
	define( 'SKY_SLIDERS_ASSETS_PATH', SKY_SLIDERS_LITE_ASSETS_PATH );
}
if ( ! defined( 'SKY_SLIDERS_MODULES_URL' ) ) {
	define( 'SKY_SLIDERS_MODULES_URL', SKY_SLIDERS_LITE_MODULES_URL );
}
if ( ! defined( 'SKY_SLIDERS_PATH_NAME' ) ) {
	define( 'SKY_SLIDERS_PATH_NAME', basename( dirname( SKY_SLIDERS_LITE_FILE ) ) );
}

require_once SKY_SLIDERS_LITE_PATH . 'includes/bootstrap.php';

function sky_sliders_lite_load_plugin() {
	require_once SKY_SLIDERS_LITE_PATH . 'class-core.php';
	\SkySliders\Core::instance();

	require_once SKY_SLIDERS_LITE_PATH . 'plugin.php';

	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notices', 'sky_sliders_lite_fail_load' );
		return;
	}

	if ( ! defined( 'ELEMENTOR_VERSION' ) || ! version_compare( ELEMENTOR_VERSION, '3.0.0', '>=' ) ) {
		add_action( 'admin_notices', 'sky_sliders_lite_fail_load_out_of_date' );
	}
}

add_action( 'plugins_loaded', 'sky_sliders_lite_load_plugin' );

function sky_sliders_lite_fail_load() {
	if ( ! current_user_can( 'activate_plugins' ) ) {
		return;
	}

	printf(
		'<div class="error"><p>%s</p></div>',
		esc_html__( 'Sky Sliders Lite requires Elementor to be installed and active.', 'sky-sliders-lite')
	);
}

function sky_sliders_lite_fail_load_out_of_date() {
	if ( ! current_user_can( 'update_plugins' ) ) {
		return;
	}

	printf(
		'<div class="error"><p>%s</p></div>',
		esc_html__( 'Sky Sliders Lite requires Elementor 3.0.0 or later.', 'sky-sliders-lite')
	);
}
