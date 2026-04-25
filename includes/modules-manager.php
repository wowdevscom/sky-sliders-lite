<?php

namespace SkySliders;

use Elementor\Element_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

final class Managers {

	private $_modules = null;

	const WIDGETS_DB_KEY = 'sky_sliders_inactive_widgets';
	const EXTENSIONS_DB_KEY = 'sky_sliders_inactive_extensions';

	public static function get_inactive_widgets() {
		return get_option( self::WIDGETS_DB_KEY, [] );
	}
	public static function get_inactive_extensions() {
		return get_option( self::EXTENSIONS_DB_KEY, [] );
	}
	private function is_module_active( $module_id ) {
		$module_data      = $this->get_module_data( $module_id );
		$inactive_widgets = self::get_inactive_widgets();

		if ( ! $inactive_widgets ) {
			return $module_data['default_activation'];
		} elseif ( ! in_array( $module_id, $inactive_widgets ) ) {
				return true;
		} else {
			return false;
		}
	}

	private function has_module_style( $module_id ) {
		$module_data = $this->get_module_data( $module_id );
		return isset( $module_data['has_style'] ) ? (bool) $module_data['has_style'] : false;
	}

	private function has_module_script( $module_id ) {
		$module_data = $this->get_module_data( $module_id );
		return isset( $module_data['has_script'] ) ? (bool) $module_data['has_script'] : false;
	}

	private function get_module_data( $module_id ) {
		return isset( $this->_modules[ $module_id ] ) ? $this->_modules[ $module_id ] : false;
	}

	public function __construct() {
		$free_modules = [
			'minimal',
			'photography',
		];

		$pro_modules = [
			'advanced',
			'creative',
			'elegant-carousel',
			'vibrant',
			'lucid',
			'fluid',
		];

		$modules = apply_filters( 'sky_sliders_pro_init', false )
			? array_merge( $pro_modules, $free_modules )
			: $free_modules;

		/**
	 * All Extensions
	 */

		// if ( ! in_array( 'animated-gradient-bg', self::get_inactive_extensions() ) ) {
		// $modules[] = 'animated-gradient-bg';
		// }

		// Fetch all modules data
		foreach ( $modules as $module ) {
			$module_info = sky_sliders_modules_path() . $module . '/module.info.php';

			if ( ! file_exists( $module_info ) ) {
				continue;
			}

			$this->_modules[ $module ] = require $module_info;
		}

		$direction_suffix = is_rtl() ? '-rtl' : '';

		foreach ( $this->_modules as $module_id => $module_data ) {

			if ( ! $this->is_module_active( $module_id ) ) {
				continue;
			}

			$class_name = str_replace( '-', ' ', $module_id );
			$class_name = str_replace( ' ', '', ucwords( $class_name ) );
			$class_name = __NAMESPACE__ . '\\Modules\\' . $class_name . '\Module';

			if ( $this->has_module_style( $module_id ) ) {
				wp_register_style( 'ss-' . $module_id, sky_sliders_assets_url() . 'css/ss-' . $module_id . $direction_suffix . '.css', [], sky_sliders_version() );
			}

			if ( $this->has_module_script( $module_id ) ) {
				$script_suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
				wp_register_script( 'ss-' . $module_id, sky_sliders_assets_url() . 'js/modules/ss-' . $module_id . $script_suffix . '.js', [ 'jquery', 'elementor-frontend' ], sky_sliders_version(), true );
			}

			$class_name::instance();
		}
	}
}

// Managers::init();
