<?php

namespace SkySliders\Admin;

use Elementor\Modules\Usage\Module;
use Elementor\Tracker;

defined( 'ABSPATH' ) || exit;

/**
 * The Admin class
 */
class SkySliders_Admin {

	const WIDGETS_DB_KEY = 'sky_sliders_inactive_widgets';
	const WIDGETS_3RD_PARTY_DB_KEY = 'sky_sliders_inactive_3rd_party_widgets';
	const EXTENSIONS_DB_KEY = 'sky_sliders_inactive_extensions';
	const API_DB_KEY = 'sky_sliders_api';

	public static $widget_list = null;
	public static $widgets_name = null;

	private function __construct() {
		$this->dispatch_actions();
	}

	public function dispatch_actions() {

		add_action( 'admin_enqueue_scripts', [ $this, 'load_admin_scripts' ] );
		add_filter( 'plugin_action_links_' . plugin_basename( sky_sliders_file() ), [ $this, 'add_action_links' ] );
	}

	public function load_admin_scripts() {
		wp_enqueue_script( 'sky-admin-js', sky_sliders_assets_url() . 'admin/sky-admin.js', [
			'jquery',
		], sky_sliders_version(), true );

		$direction_suffix = is_rtl() ? '.rtl' : '';

		// wp_enqueue_style( 'sky-admin-css', sky_sliders_assets_url() . 'admin/sky-admin' . $direction_suffix . '.css', [], sky_sliders_version() );
		wp_enqueue_style( 'sky-widget-icons', sky_sliders_assets_url() . 'css/sky-widget-icons' . $direction_suffix . '.css', [], sky_sliders_version() );
	}

	public static function modules_demo_server() {
		return 'https://skysliders.com/';
	}

	public static function get_inactive_widgets() {
		return get_option( self::WIDGETS_DB_KEY, [] );
	}

	public static function get_inactive_3rd_party_widgets() {
		return get_option( self::WIDGETS_3RD_PARTY_DB_KEY, [] );
	}

	public static function get_inactive_extensions() {
		return get_option( self::EXTENSIONS_DB_KEY, [] );
	}

	public static function get_saved_api() {
		return get_option( self::API_DB_KEY, [] );
	}

	public static function add_action_links( $links ) {
		if ( ! current_user_can( 'manage_options' ) ) {
			return $links;
		}

		$links = array_merge( [
			sprintf(
				'<a href="%s">%s</a>',
				add_query_arg( [ 'page' => 'sky-sliders' ], admin_url( 'admin.php' ) ),
				esc_html__( 'Settings', 'sky-sliders-lite')
			),
		], $links );
		if ( sky_sliders_init_pro() !== true ) {
			$links = array_merge( $links, [
				sprintf(
					'<a target="_blank" style="color:#E0528D; font-weight: bold;" href="%s" title="%s">%s</a>',
					'https://skysliders.com/pricing/?coupon=SKYADDONS30',
					esc_html__( 'Get 30% OFF!', 'sky-sliders-lite'),
					esc_html__( 'Get Discount', 'sky-sliders-lite')
				),
			] );
		}
		return $links;
	}

	/**
	 * Get Used modules.
	 *
	 * @access public
	 * @return array
	 * @since 1.0.6
	 */
	public static function get_used_widgets() {

		$used_widgets = array();

		if ( class_exists( 'Elementor\Modules\Usage\Module' ) ) {

			$module = Module::instance();
			$elements = $module->get_formatted_usage( 'raw' );
			$widgets = self::get_widgets_names();

			if ( is_array( $elements ) || is_object( $elements ) ) {

				foreach ( $elements as $post_type => $data ) {
					foreach ( $data['elements'] as $element => $count ) {
						if ( in_array( $element, $widgets, true ) ) {
							if ( isset( $used_widgets[ $element ] ) ) {
								$used_widgets[ $element ] += $count;
							} else {
								$used_widgets[ $element ] = $count;
							}
						}
					}
				}
			}
		}

		return $used_widgets;
	}

	/**
	 * Get Unused Widgets.
	 *
	 * @access public
	 * @return array
	 * @since 1.0.6
	 */
	public static function get_unused_widgets() {

		if ( ! current_user_can( 'install_plugins' ) ) {
			die();
		}

		$widgets = self::get_widgets_names();

		$used_widgets = self::get_used_widgets();

		$unused_widgets = array_diff( $widgets, array_keys( $used_widgets ) );

		return $unused_widgets;
	}

	/**
	 * Get Widgets Name
	 *
	 * @access public
	 * @return array
	 * @since 1.0.6
	 */
	public static function get_widgets_names() {
		$names = self::$widgets_name;

		if ( null === $names ) {
			$names = array_map(
				function ( $item ) {
					return isset( $item['name'] ) ? 'sky-sliders-' . str_replace( '_', '-', $item['name'] ) : 'none';
				},
				self::$widget_list
			);
		}

		return $names;
	}

	/**
	 * Elements List
	 */
	public static function get_element_list() {

		$inactive_widgets = self::get_inactive_widgets();
		$inactive_3rd_party_widgets = self::get_inactive_3rd_party_widgets();
		$inactive_extensions = self::get_inactive_extensions();
		$saved_api = self::get_saved_api();

		$widgets_fields = [
			'sky_sliders_widgets' => [
				[
					'name'         => 'advanced',
					'label'        => esc_html__( 'Advanced Slider', 'sky-sliders-lite'),
					'type'         => 'checkbox',
					'value'        => ! in_array( 'advanced', $inactive_widgets ) ? 'on' : 'off',
					'default'      => 'on',
					'video_url'    => '#',
					'content_type' => 'custom',
					'feature_type' => 'pro',
					'demo_url'     => 'http://skysliders.com/elementor/advanced-slider/',
				],
				[
					'name'         => 'creative',
					'label'        => esc_html__( 'Creative Slider', 'sky-sliders-lite'),
					'type'         => 'checkbox',
					'value'        => ! in_array( 'creative', $inactive_widgets ) ? 'on' : 'off',
					'default'      => 'on',
					'video_url'    => '#',
					'content_type' => 'custom',
					'feature_type' => 'pro',
					'demo_url'     => 'http://skysliders.com/elementor/creative-slider/',
				],
				[
					'name'         => 'elegant-carousel',
					'label'        => esc_html__( 'Elegant Carousel', 'sky-sliders-lite'),
					'type'         => 'checkbox',
					'value'        => ! in_array( 'elegant-carousel', $inactive_widgets ) ? 'on' : 'off',
					'default'      => 'on',
					'video_url'    => '#',
					'content_type' => 'custom',
					'feature_type' => 'pro',
					'demo_url'     => 'http://skysliders.com/elementor/elegant-carousel/',
				],
				[
					'name'         => 'fluid',
					'label'        => esc_html__( 'Fluid Slider', 'sky-sliders-lite'),
					'type'         => 'checkbox',
					'value'        => ! in_array( 'fluid', $inactive_widgets ) ? 'on' : 'off',
					'default'      => 'on',
					'video_url'    => '#',
					'content_type' => 'custom',
					'feature_type' => 'pro',
					'demo_url'     => 'http://skysliders.com/elementor/fluid-slider/',
				],
				[
					'name'         => 'lucid',
					'label'        => esc_html__( 'Lucid Slider', 'sky-sliders-lite'),
					'type'         => 'checkbox',
					'value'        => ! in_array( 'lucid', $inactive_widgets ) ? 'on' : 'off',
					'default'      => 'on',
					'video_url'    => '#',
					'content_type' => 'custom',
					'feature_type' => 'pro',
					'demo_url'     => 'http://skysliders.com/elementor/lucid-slider/',
				],
				[
					'name'         => 'minimal',
					'label'        => esc_html__( 'Minimal Slider', 'sky-sliders-lite'),
					'type'         => 'checkbox',
					'value'        => ! in_array( 'minimal', $inactive_widgets ) ? 'on' : 'off',
					'default'      => 'on',
					'video_url'    => '#',
					'content_type' => 'custom',
					'feature_type' => 'free',
					'demo_url'     => 'http://skysliders.com/elementor/minimal-slider/',
				],
				[
					'name'         => 'photography',
					'label'        => esc_html__( 'Photography Slider', 'sky-sliders-lite'),
					'type'         => 'checkbox',
					'value'        => ! in_array( 'photography', $inactive_widgets ) ? 'on' : 'off',
					'default'      => 'on',
					'video_url'    => '#',
					'content_type' => 'custom',
					'feature_type' => 'free',
					'demo_url'     => 'http://skysliders.com/elementor/photography-slider/',
				],
				[
					'name'         => 'vibrant',
					'label'        => esc_html__( 'Vibrant Slider', 'sky-sliders-lite'),
					'type'         => 'checkbox',
					'value'        => ! in_array( 'vibrant', $inactive_widgets ) ? 'on' : 'off',
					'default'      => 'on',
					'video_url'    => '#',
					'content_type' => 'custom',
					'feature_type' => 'pro',
					'demo_url'     => 'http://skysliders.com/elementor/vibrant-slider/',
				],
			],
			'sky_sliders_3rd_party_widget' => [
				[
					'name'         => 'ae-templates',
					'label'        => esc_html__( 'AE Templates', 'sky-sliders-lite'),
					'type'         => 'checkbox',
					'value'        => ! in_array( 'ae-templates', $inactive_3rd_party_widgets ) ? 'on' : 'off',
					'default'      => 'on',
					'video_url'    => '#',
					'content_type' => 'custom',
					'feature_type' => 'free',
					'demo_url'     => self::modules_demo_server() . 'ae-templates-widget/',
				],
			],
			'sky_sliders_extensions'       => [
				[
					'name'         => 'test',
					'label'        => esc_html__( 'test Slider', 'sky-sliders-lite'),
					'type'         => 'checkbox',
					'value'        => ! in_array( 'test', $inactive_extensions ) ? 'on' : 'off',
					'default'      => 'on',
					'video_url'    => '#',
					'content_type' => 'custom',
					'feature_type' => 'free',
					'demo_url'     => self::modules_demo_server() . 'elementor-test-widget/',
				],
			],
			'sky_sliders_api'              => [
				'form_builder_group' => [
					'input_box'    => [
						[
							'name'        => 'form_builder_email_to',
							'label'       => esc_html__( 'Form Builder Emails Receiver', 'sky-sliders-lite'),
							'placeholder' => esc_html__( 'Email Address', 'sky-sliders-lite'),
							'description' => esc_html__( 'By default, the form builder sends emails to the admin email. If you\'d like to send emails to a different address, you can configure it here.', 'sky-sliders-lite'),
							'type'        => 'input',
							'value'       => ! empty( $saved_api['form_builder_email_to'] ) ? $saved_api['form_builder_email_to'] : null,
						],
					],
					'feature_type' => 'pro',
				],
				'sky_sliders_api_google_map_group' => [
					'input_box'    => [
						[
							'name'        => 'google_map_key',
							'label'       => esc_html__( 'Google Map', 'sky-sliders-lite'),
							'placeholder' => esc_html__( 'API Key', 'sky-sliders-lite'),
							'description' => esc_html__( 'Google Maps API is a service that offers detailed maps and other geographic information for use in online and offline map applications, and websites.', 'sky-sliders-lite'),
							'type'        => 'input',
							'value'       => ! empty( $saved_api['google_map_key'] ) ? $saved_api['google_map_key'] : null,
						],
					],
					'feature_type' => 'pro',
				],
				'sky_sliders_api_mailchimp_group' => [
					'input_box'    => [
						[
							'name'        => 'mailchimp_api_key',
							'label'       => esc_html__( 'Mailchimp API Key', 'sky-sliders-lite'),
							'placeholder' => esc_html__( 'Access Key', 'sky-sliders-lite'),
							'description' => esc_html__( 'Mailchimp is a popular marketing and automation platform for small businesses.', 'sky-sliders-lite'),
							'type'        => 'input',
							'value'       => ! empty( $saved_api['mailchimp_api_key'] ) ? $saved_api['mailchimp_api_key'] : null,
						],
						[
							'name'        => 'mailchimp_list_id',
							'label'       => esc_html__( 'Audience ID', 'sky-sliders-lite'),
							'placeholder' => esc_html__( 'Audience ID', 'sky-sliders-lite'),
							'description' => esc_html__( 'Each Mailchimp audience has a unique audience ID (sometimes called a list ID) .', 'sky-sliders-lite'),
							'type'        => 'input',
							'value'       => ! empty( $saved_api['mailchimp_list_id'] ) ? $saved_api['mailchimp_list_id'] : null,
						],
					],
					'feature_type' => 'pro',
				],
				'sky_sliders_api_instagram_group' => [
					'input_box'    => [
						[

							'name'        => 'instagram_app_id',
							'label'       => esc_html__( 'Instagram', 'sky-sliders-lite'),
							'placeholder' => esc_html__( 'App Id', 'sky-sliders-lite'),
							'description' => '',
							'type'        => 'input',
							'value'       => ! empty( $saved_api['instagram_app_id'] ) ? $saved_api['instagram_app_id'] : null,
						],
						[

							'name'        => 'instagram_app_secret',
							'label'       => esc_html__( 'App Secret', 'sky-sliders-lite'),
							'placeholder' => esc_html__( 'App Secret', 'sky-sliders-lite'),
							'description' => '',
							'type'        => 'input',
							'value'       => ! empty( $saved_api['instagram_app_secret'] ) ? $saved_api['instagram_app_secret'] : null,
						],
						[

							'name'        => 'instagram_access_token',
							'label'       => esc_html__( 'Access Token', 'sky-sliders-lite'),
							'placeholder' => esc_html__( 'Access Token', 'sky-sliders-lite'),
							'description' => '',
							'type'        => 'input',
							'value'       => ! empty( $saved_api['instagram_access_token'] ) ? $saved_api['instagram_access_token'] : null,
						],
					],
					'feature_type' => 'pro',
				],
			],
		];

			self::$widget_list = $widgets_fields['sky_sliders_widgets'];
			self::$widget_list = array_merge( self::$widget_list, $widgets_fields['sky_sliders_3rd_party_widget'] );

			$used_widgets = self::get_used_widgets();
			$widgets_fields['sky_sliders_widgets'] = array_map(function( $widget ) use ( $used_widgets ) {
				$widget_name = $widget['name'];
				$widget['total_used'] = isset( $used_widgets[ 'sky-sliders-' . $widget_name ] ) ? $used_widgets[ 'sky-sliders-' . $widget_name ] : 0;
				return $widget;
			}, $widgets_fields['sky_sliders_widgets']);

		$widgets_fields['sky_sliders_3rd_party_widget'] = array_map(
			function ( $widget ) use ( $used_widgets ) {
				$widget_name          = $widget['name'];
				$widget['total_used'] = isset( $used_widgets[ 'sky-sliders-' . $widget_name ] ) ? $used_widgets[ 'sky-sliders-' . $widget_name ] : 0;
				return $widget;
			},
			$widgets_fields['sky_sliders_3rd_party_widget']
		);

		return $widgets_fields;
	}

	public static function init() {
		static $instance = false;

		if ( ! $instance ) {
			$instance = new self();
		}

		return $instance;
	}
}

function sky_sliders_admin() {
	return SkySliders_Admin::init();
}

// kick-off the admin class
sky_sliders_admin();
