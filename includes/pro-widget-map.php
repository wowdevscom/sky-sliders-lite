<?php

namespace SkySliders\Includes;

use SkySliders\Admin\SkySliders_Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class Pro_Widget_Map {

	public function get_pro_widget_map() {

		$widgets_fields = SkySliders_Admin::get_element_list();

		$core_widgets        = $widgets_fields['sky_sliders_widgets'];

		$arr = [];

		foreach ( $core_widgets as $key => $widget ) {
			if ( 'pro' === $widget['feature_type'] ) {
				$ar = [
					'categories'    => [ 'sky-sliders-pro' ],
					'name'          => $widget['name'],
					'title'         => $widget['label'],
					'icon'          => 'sky-sliders-icon--' . $widget['name'] . ' ss-pro-widget-unlock-icon',
					'action_button' => [
						'classes' => [ 'elementor-button', 'elementor-button-success' ],
						'text'    => esc_html__( 'See it in Action', 'sky-sliders-lite'),
						'url'     => esc_url( $widget['demo_url'] ),
					],
				];
				array_push( $arr, $ar );
			}
		}
		return $arr;
	}
}
