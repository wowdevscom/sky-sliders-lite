<?php

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'sky_sliders_file' ) ) {
	function sky_sliders_file() {
		if ( defined( 'SKY_SLIDERS_PRO_FILE' ) ) {
			return SKY_SLIDERS_PRO_FILE;
		}

		if ( defined( 'SKY_SLIDERS_LITE_FILE' ) ) {
			return SKY_SLIDERS_LITE_FILE;
		}

		return '';
	}
}

if ( ! function_exists( 'sky_sliders_dir' ) ) {
	function sky_sliders_dir() {
		return trailingslashit( plugin_dir_path( sky_sliders_file() ) );
	}
}

if ( ! function_exists( 'sky_sliders_url' ) ) {
	function sky_sliders_url() {
		return trailingslashit( plugin_dir_url( sky_sliders_file() ) );
	}
}

if ( ! function_exists( 'sky_sliders_assets_path' ) ) {
	function sky_sliders_assets_path() {
		return sky_sliders_dir() . 'assets/';
	}
}

if ( ! function_exists( 'sky_sliders_assets_url' ) ) {
	function sky_sliders_assets_url() {
		return sky_sliders_url() . 'assets/';
	}
}

if ( ! function_exists( 'sky_sliders_inc_path' ) ) {
	function sky_sliders_inc_path() {
		return sky_sliders_dir() . 'includes/';
	}
}

if ( ! function_exists( 'sky_sliders_modules_path' ) ) {
	function sky_sliders_modules_path() {
		return sky_sliders_dir() . 'modules/';
	}
}

if ( ! function_exists( 'sky_sliders_modules_url' ) ) {
	function sky_sliders_modules_url() {
		return sky_sliders_url() . 'modules/';
	}
}

if ( ! function_exists( 'sky_sliders_version' ) ) {
	function sky_sliders_version() {
		if ( defined( 'SKY_SLIDERS_PRO_VERSION' ) && defined( 'SKY_SLIDERS_PRO_ACTIVE' ) ) {
			return SKY_SLIDERS_PRO_VERSION;
		}

		if ( defined( 'SKY_SLIDERS_LITE_VERSION' ) ) {
			return SKY_SLIDERS_LITE_VERSION;
		}

		return defined( 'SKY_SLIDERS_VERSION' ) ? SKY_SLIDERS_VERSION : '';
	}
}

if ( ! function_exists( 'sky_sliders_slug' ) ) {
	function sky_sliders_slug() {
		return defined( 'SKY_SLIDERS_SLUG' ) ? SKY_SLIDERS_SLUG : '';
	}
}
