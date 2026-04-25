<?php

namespace SkySliders;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Elements_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/**
 * Main class plugin -> SkySliders
 */
class SkySliders_Plugin {

	/**
	 * @var Plugin -> SkySliders
	 */
	private static $_instance;

	/**
	 * Modules Manager
	 *
	 * @var Managers
	 */
	private $_modules_manager;

	/**
	 * @var array
	 */
	private $_localize_settings = array();

	/**
	 * @return string
	 */
	public function get_version() {
		return sky_sliders_version();
	}

	/**
	 * Throw error on object clone
	 *
	 * The whole idea of the singleton design pattern is that there is a single
	 * object therefore, we don't want the object to be cloned.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function __clone() {
		// Cloning instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'sky-sliders-lite'), '1.0.0' );
	}

	/**
	 * Disable unserializing of the class
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function __wakeup() {
		// Unserializing instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'sky-sliders-lite'), '1.0.0' );
	}

	/**
	 * @return Plugin
	 */
	public static function elementor() {
		return Plugin::$instance;
	}

	/**
	 * @return Plugin -> SkySliders
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();

			/**
			 * Fire this action on the load time
			 * This method will catch by PRO
			 * Pro will not work without this method
			 */
			do_action( 'sky_sliders_loaded' );
			self::$_instance->add_actions();
			self::$_instance->includes();
		}

		return self::$_instance;
	}

	private function includes() {

		require sky_sliders_dir() . 'includes/modules-manager.php';
		/**
		 * Utils Files
		 */
		require sky_sliders_dir() . 'includes/utils.php';

		require_once sky_sliders_core()->includes_dir . 'custom-meta-box.php';

		require_once sky_sliders_core()->traits_dir . 'global-swiper-controls.php';
		require_once sky_sliders_core()->traits_dir . 'global-widget-controls.php';
		require_once sky_sliders_core()->traits_dir . 'global-widget-functions.php';

		/**
		 * Select Control
		 *
		 * @since 1.1.0
		 */
		require_once sky_sliders_inc_path() . 'controls/select-input/dynamic-input-module.php';
		require_once sky_sliders_inc_path() . 'controls/select-input/dynamic-select.php';

		if ( ! sky_sliders_init_pro() ) {
			require_once sky_sliders_inc_path() . 'pro-widget-map.php';
		}

		/**
	 * Admin Files Only
	*/
		/**
			 * Features
			 */
		require_once sky_sliders_inc_path() . 'features/class-init.php';
		\SkySliders\Features\Init::get_instance();
	}

	public function autoload( $_class ) {
		if ( 0 !== strpos( $_class, __NAMESPACE__ ) ) {
			return;
		}

		$filename = strtolower(
			preg_replace(
				array( '/^' . __NAMESPACE__ . '\\\/', '/([a-z])([A-Z])/', '/_/', '/\\\/' ),
				array(
					'',
					'$1-$2',
					'-',
					DIRECTORY_SEPARATOR,
				),
				$_class
			)
		);
		$filename = sky_sliders_dir() . $filename . '.php';

		if ( is_readable( $filename ) ) {
			include $filename;
		}
	}

	public function get_localize_settings() {
		return $this->_localize_settings;
	}

	public function add_localize_settings( $setting_key, $setting_value = null ) {
		if ( is_array( $setting_key ) ) {
			$this->_localize_settings = array_replace_recursive( $this->_localize_settings, $setting_key );

			return;
		}

		if ( ! is_array( $setting_value ) || ! isset( $this->_localize_settings[ $setting_key ] ) || ! is_array( $this->_localize_settings[ $setting_key ] ) ) {
			$this->_localize_settings[ $setting_key ] = $setting_value;

			return;
		}

		$this->_localize_settings[ $setting_key ] = array_replace_recursive( $this->_localize_settings[ $setting_key ], $setting_value );
	}

	public function enqueue_styles() {
		$direction_suffix = is_rtl() ? '.rtl' : '';

		wp_register_style(
			'sky-sliders',
			sky_sliders_assets_url() . 'css/sky-sliders' . $direction_suffix . '.css',
			array(),
			sky_sliders_version()
		);

		wp_enqueue_style( 'sky-sliders' );
	}

	public function enqueue_styles_backend() {
		$direction_suffix = is_rtl() ? '.rtl' : '';

		wp_enqueue_style(
			'sky-sliders-icons',
			sky_sliders_assets_url() . 'css/sky-editor' . $direction_suffix . '.css',
			array(),
			sky_sliders_version()
		);
	}

	public function enqueue_scripts() {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		wp_register_script(
			'sky-sliders',
			sky_sliders_assets_url() . 'js/sky-sliders' . $suffix . '.js',
			array(
				'jquery',
				'elementor-frontend',
			),
			sky_sliders_version(),
			true
		);

		if ( self::elementor()->preview->is_preview_mode() || self::elementor()->editor->is_edit_mode() ) {
			// todo condition check
			wp_enqueue_script( 'anime' );
			wp_enqueue_script( 'tippyjs' );
			wp_enqueue_script( 'equal-height' );
			wp_enqueue_script( 'granim' );
			wp_enqueue_script( 'ripples' );
			wp_enqueue_script( 'revealFx' );
			wp_enqueue_script( 'simple-parallax' );
		}

		wp_localize_script(
			'sky-sliders',
			'SkySlidersFrontendConfig', // This is used in the js file to group all of your scripts together
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'sky-sliders' ),
			)
		);

		wp_enqueue_script( 'sky-sliders' );
	}

	public function register_site_scripts() {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		wp_register_script(
			'ss-image-compare',
			sky_sliders_assets_url() . 'vendor/js/image-compare-viewer' . $suffix . '.js',
			array(
				'jquery',
				'elementor-frontend',
			),
			'1.0.0',
			true
		);
		wp_register_script( 'momentum', sky_sliders_assets_url() . 'vendor/js/momentum-slider' . $suffix . '.js', array(), '1.0.0', true );
		wp_register_script(
			'ss-reading-progress',
			sky_sliders_assets_url() . 'vendor/js/jquery.reading-progress' . $suffix . '.js',
			array(
				'jquery',
			),
			'1.0.0',
			true
		);
		wp_register_script( 'ss-accordion', sky_sliders_assets_url() . 'vendor/js/accordion' . $suffix . '.js', array(), '3.1.1', true );
		/**
		 * No need Suffix on Anime JS
		 */
		wp_register_script(
			'anime',
			sky_sliders_assets_url() . 'vendor/js/anime.min.js',
			array(
				'jquery',
			),
			'3.2.1',
			true
		);
		wp_register_script( 'popper', sky_sliders_assets_url() . 'vendor/js/popper' . $suffix . '.js', array(), '2.10.1', true );
		wp_register_script( 'tippyjs', sky_sliders_assets_url() . 'vendor/js/tippy-bundle.umd' . $suffix . '.js', array(), '6.3.1', true );

		wp_register_script( 'countUp', sky_sliders_assets_url() . 'vendor/js/countUp' . $suffix . '.js', array(), '2.0.4', true );
		wp_register_script( 'sweetalert2', sky_sliders_assets_url() . 'vendor/js/sweetalert2' . $suffix . '.js', array(), '2.0.0', true );
		wp_register_script( 'metis-menu', sky_sliders_assets_url() . 'vendor/js/metis-menu' . $suffix . '.js', array( 'jquery' ), '3.0.7', true );
		wp_register_script( 'equal-height', sky_sliders_assets_url() . 'vendor/js/jquery.matchHeight' . $suffix . '.js', array( 'jquery' ), '0.7.2', true );
		wp_register_script( 'pdfobject', sky_sliders_assets_url() . 'vendor/js/pdfobject' . $suffix . '.js', array( 'jquery' ), 'v2.2.7', true );
		wp_register_script( 'granim', sky_sliders_assets_url() . 'vendor/js/granim' . $suffix . '.js', array(), 'v2.0.0', true );
		wp_register_script( 'ripples', sky_sliders_assets_url() . 'vendor/js/jquery.ripples' . $suffix . '.js', array( 'jquery' ), 'v0.5.3', true );
		wp_register_script( 'slinky', sky_sliders_assets_url() . 'vendor/js/slinky' . $suffix . '.js', array( 'jquery' ), '1.0.0', true );
		wp_register_script( 'revealFx', sky_sliders_assets_url() . 'vendor/js/revealFx' . $suffix . '.js', array( 'jquery' ), '0.0.2', true );
		wp_register_script( 'typed', sky_sliders_assets_url() . 'vendor/js/typed' . $suffix . '.js', array(), 'v2.0.12', true );
		wp_register_script( 'morphext', sky_sliders_assets_url() . 'vendor/js/morphext' . $suffix . '.js', array(), 'v2.4.4', true );
		wp_register_script( 'plyr', sky_sliders_assets_url() . 'vendor/js/plyr' . $suffix . '.js', array(), '3.7.2', true );
		wp_register_script( 'simple-parallax', sky_sliders_assets_url() . 'vendor/js/simpleParallax.min.js', array(), '5.6.2', true );
	}

	public function register_site_styles() {
		$direction_suffix = is_rtl() ? '.rtl' : '.min';
		wp_register_style( 'ss-accordion', sky_sliders_assets_url() . 'vendor/css/accordion' . $direction_suffix . '.css', array(), '3.1.1' );
		wp_register_style( 'tippy', sky_sliders_assets_url() . 'vendor/css/tippy-animation' . $direction_suffix . '.css', array(), '6.3.1' );
		wp_register_style( 'momentum', sky_sliders_assets_url() . 'vendor/css/momentum-slider' . $direction_suffix . '.css', array(), '1.0.0' );
		wp_register_style( 'metis-menu', sky_sliders_assets_url() . 'vendor/css/metis-menu' . $direction_suffix . '.css', array(), '13.0.7' );
		wp_register_style( 'slinky', sky_sliders_assets_url() . 'vendor/css/slinky' . $direction_suffix . '.css', array(), '1.0.0' );
		wp_register_style( 'plyr', sky_sliders_assets_url() . 'vendor/css/plyr' . $direction_suffix . '.css', array(), '6.3.1' );
	}

	public function enqueue_editor_scripts() {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		wp_register_script(
			'sky-sliders-editor',
			sky_sliders_assets_url() . 'js/sky-sliders-editor' . $suffix . '.js',
			array(
				'backbone-marionette',
				'elementor-common-modules',
				'elementor-editor-modules',
			),
			sky_sliders_version(),
			true
		);

		$localize_data = array(
			'promotional_widgets' => array(),
		);

		if ( ! sky_sliders_init_pro() ) {
			$pro_widget_map                       = new \SkySliders\Includes\Pro_Widget_Map();
			$localize_data['promotional_widgets'] = $pro_widget_map->get_pro_widget_map();
		}

		wp_localize_script( 'sky-sliders-editor', 'SkyAddonsEditorConfig', $localize_data );

		wp_enqueue_script( 'sky-sliders-editor' );
	}

	public function enqueue_editor_style() {
		$direction_suffix = is_rtl() ? '.rtl' : '';
		wp_register_style( 'sky-widget-icons', sky_sliders_assets_url() . 'css/sky-widget-icons' . $direction_suffix . '.css', array(), sky_sliders_version() );
		wp_enqueue_style( 'sky-widget-icons' );
	}

	public function elementor_init() {
		$this->_modules_manager = new Managers();

		/**
		 * Add element category in panel
		 */
		Plugin::instance()->elements_manager->add_category(
			'sky-sliders',
			array(
				'title' => esc_html__( 'Sky Sliders', 'sky-sliders-lite'),
				'icon'  => 'font',
			)
		);

		if ( class_exists( 'SkySliders\Templates\Init_Templates' ) ) {
			\SkySliders\Templates\Import_Template::instance()->load();
			\SkySliders\Templates\Library_Load::instance()->load();
			\SkySliders\Templates\Init_Templates::instance()->init();
		}
	}

	public static function sky_sliders_file() {
		return sky_sliders_file();
	}

	public static function sky_sliders_url() {
		return sky_sliders_url();
	}

	public static function sky_sliders_dir() {
		return sky_sliders_dir();
	}

	protected function add_actions() {

		add_action( 'elementor/init', array( $this, 'elementor_init' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_site_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ), 998 );

		add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'enqueue_editor_style' ) );
		add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'enqueue_styles_backend' ), 991 );
		add_action( 'elementor/editor/after_enqueue_scripts', array( $this, 'enqueue_editor_scripts' ) );

		add_action( 'elementor/frontend/before_enqueue_scripts', array( $this, 'enqueue_scripts' ), 998 );
		add_action( 'elementor/frontend/before_register_styles', array( $this, 'register_site_styles' ) );
	}

	/**
	 * Plugin -> SkySliders constructor.
	 */
	private function __construct() {
		spl_autoload_register( array( $this, 'autoload' ) );
	}
}

/**
 * Helper functions — always available, no Elementor dependency at load time.
 */
require_once __DIR__ . '/includes/functions.php';

/**
 * Initializes the Elementor-dependent part of the plugin.
 * Only runs when Elementor is confirmed loaded and meets the minimum version.
 */
function sky_sliders_boot() {
	if ( defined( 'SKY_SLIDERS_TEST' ) ) {
		return;
	}
	if ( ! did_action( 'elementor/loaded' ) ) {
		return;
	}
	if ( ! defined( 'ELEMENTOR_VERSION' ) || ! version_compare( ELEMENTOR_VERSION, '3.0.0', '>=' ) ) {
		return;
	}
	SkySliders_Plugin::instance();
}

// kick-off the plugin
sky_sliders_boot();
