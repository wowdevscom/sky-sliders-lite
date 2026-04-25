<?php
/**
 * Core File — Admin Bootstrap
 *
 * Responsible for all admin matters: menu, dashboard REST API,
 * and React dashboard asset enqueuing.
 * Runs with or without Elementor.
 *
 * @package SkySliders
 * @since   1.0.0
 */

namespace SkySliders;

defined( 'ABSPATH' ) || exit;

/**
 * Plugin Core
 *
 * @since 1.0.0
 */
final class Core {

	/**
	 * @var Core
	 */
	private static $instance;

	/**
	 * @return Core
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
			self::$instance->init();
		}

		return self::$instance;
	}

	public function __construct() {}

	/**
	 * Boot admin subsystems.
	 *
	 * @return void
	 */
	public function init() {
		$this->include_files();
		$this->setup_hooks();
	}

	/**
	 * Load all admin-only PHP files.
	 * None of these files have an Elementor dependency.
	 *
	 * @return void
	 */
	public function include_files() {
		require_once sky_sliders_inc_path() . 'admin.php';
		require_once sky_sliders_inc_path() . 'admin/Classes/class-dashboard.php';
		require_once sky_sliders_inc_path() . 'admin/Classes/class-widgets-settings.php';
		require_once sky_sliders_inc_path() . 'admin/class-menu.php';
		require_once sky_sliders_inc_path() . 'admin/class-admin.php';
		new Admin();
	}

	/**
	 * Register admin-facing hooks.
	 *
	 * @return void
	 */
	private function setup_hooks() {
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_styles' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_scripts' ] );
	}

	// -------------------------------------------------------------------------
	// Asset enqueuing
	// -------------------------------------------------------------------------

	/**
	 * React dashboard — CSS.
	 *
	 * @param string $hook_suffix
	 * @return void
	 */
	public function enqueue_admin_styles( $hook_suffix ) {
		if ( 'toplevel_page_sky-sliders' !== $hook_suffix && 'sky-sliders_page_sky-sliders-pro' !== $hook_suffix ) {
			return;
		}
		wp_enqueue_style( 'wp-components' );
		wp_register_style( 'sky-sliders', sky_sliders_url() . 'build/admin/index.css', [], sky_sliders_version() );
		wp_enqueue_style( 'sky-sliders' );
	}

	/**
	 * React dashboard — JS + SkySlidersConfig.
	 *
	 * @param string $hook_suffix
	 * @return void
	 */
	public function enqueue_admin_scripts( $hook_suffix ) {
		if ( 'toplevel_page_sky-sliders' !== $hook_suffix ) {
			return;
		}

		$asset_file = sky_sliders_dir() . 'build/admin/index.asset.php';
		if ( ! file_exists( $asset_file ) ) {
			return;
		}

		$asset = include $asset_file;
		wp_register_script( 'sky-sliders', sky_sliders_url() . 'build/admin/index.js', $asset['dependencies'], $asset['version'], true );
		wp_enqueue_script( 'sky-sliders' );
		wp_localize_script( 'sky-sliders', 'SkySlidersConfig', $this->localize_config() );
	}

	/**
	 * Shared JS config passed to the admin React app.
	 *
	 * @return array
	 */
	public function localize_config() {
		return [
			'web_url'      => esc_url( home_url() ),
			'ajax_url'     => esc_url( admin_url( 'admin-ajax.php' ) ),
			'rest_url'     => esc_url( rest_url() ),
			'version'      => sky_sliders_version(),
			'plugin_name'  => esc_html__( 'Sky Sliders', 'sky-sliders-lite'),
			'plugin_slug'  => sky_sliders_slug(),
			'admin_url'    => esc_url( admin_url() ),
			'nonce'        => wp_create_nonce( 'sky_sliders_nonce' ),
			'assets_url'   => sky_sliders_assets_url(),
			'logo'         => sky_sliders_assets_url() . 'images/sky-logo-gradient.png',
			'root_url'     => sky_sliders_url(),
			'pro_init'     => apply_filters( 'sky_sliders_pro_init', false ),
			'lite_active'  => defined( 'SKY_SLIDERS_LITE_VERSION' ),
			'current_user' => [
				'domain'       => esc_url( home_url() ),
				'display_name' => wp_get_current_user()->display_name,
				'email'        => wp_get_current_user()->user_email,
				'id'           => wp_get_current_user()->ID,
				'avatar'       => get_avatar_url( wp_get_current_user()->ID ),
			],
		];
	}
}
