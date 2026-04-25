<?php
/**
 * Menu class
 *
 * @package SkySliders\Admin
 * @since 2.7.0
 */

namespace SkySliders\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Description of Menu
 *
 * @since 2.7.0
 */
class Menu {
	/**
	 * Constructor
	 *
	 * @return void
	 * @since 2.7.0
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
	}

	/**
	 * Register admin menu
	 *
	 * @return void
	 * @since 2.6.5
	 */
	public function admin_menu() {
		$parent_slug = 'sky-sliders';
		$capability  = 'manage_options';
		add_menu_page( 'Sky Sliders', 'Sky Sliders', $capability, $parent_slug, array( $this, 'plugin_layout' ), $this->get_b64_icon(), 59 );

		add_submenu_page( $parent_slug, esc_html__( 'Dashboard', 'sky-sliders-lite'), esc_html__( 'Dashboard', 'sky-sliders-lite'), $capability, $parent_slug, [
			$this,
			'plugin_layout',
		] );

		add_submenu_page( $parent_slug, esc_html__( 'Widgets', 'sky-sliders-lite'), esc_html__( 'Widgets', 'sky-sliders-lite'), $capability, $parent_slug . '#widgets', [
			$this,
			'plugin_layout',
		] );

		if ( sky_sliders_init_pro() ) {
			add_submenu_page( $parent_slug, esc_html__( 'License', 'sky-sliders-lite'), esc_html__( 'License', 'sky-sliders-lite'), $capability, $parent_slug . '#license', [
				$this,
				'plugin_layout',
			] );
		}
	}

	/**
	 * Plugin Layout
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function plugin_layout() {
		echo '<div id="sky-sliders" class="wrap sky-sliders"> <h2>Loading...</h2> </div>';
	}

	public static function get_dashboard_link( $suffix = '#' ) {
		return add_query_arg( array( 'page' => 'sky-sliders' . $suffix ), admin_url( 'admin.php' ) );
	}

	public static function get_b64_icon() {
		return 'data:image/svg+xml;base64,' . base64_encode( file_get_contents( sky_sliders_assets_path() . 'images/slider-icon.svg' ) );
	}
}
