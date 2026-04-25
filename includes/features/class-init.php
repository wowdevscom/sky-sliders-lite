<?php

namespace SkySliders\Features;

defined( 'ABSPATH' ) || exit;

class Init {
	private static $instance = null;

	private function __construct() {
		$features = get_option( 'sky_sliders_inactive_extensions', [] );

		/**
		 * Duplicator
		 */
		if ( ! in_array( 'duplicator', $features ) ) {
			require_once sky_sliders_inc_path() . 'features/class-duplicator.php';
			\SkySliders\Features\Duplicator::get_instance();
		}
	}

	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}
