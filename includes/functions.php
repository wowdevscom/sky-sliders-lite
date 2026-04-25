<?php

defined( 'ABSPATH' ) || exit;

use SkySliders\SkySliders_Plugin;

if ( ! function_exists( 'sky_sliders_core' ) ) {

	function sky_sliders_core() {
		$obj = new \stdClass();
		$obj->includes_dir = sky_sliders_inc_path();
		$obj->controls_dir = sky_sliders_dir() . 'controls/';
		$obj->images = sky_sliders_assets_url() . 'images/';
		$obj->traits_dir = sky_sliders_dir() . 'traits/';
		return $obj;
	}
}

if ( ! function_exists( 'sky_sliders_get_icon' ) ) {
	function sky_sliders_get_icon() {
		return '<span class="sky-ctrl-section-icon-wrapper"><img src="' . sky_sliders_core()->images . 'sky-logo-gradient.png" class="sky-ctrl-section-icon" alt="Sky Sliders" title="Sky Sliders"></span>';
	}
}

if ( ! function_exists( 'sky_sliders_init_pro' ) ) {
	function sky_sliders_init_pro() {
		return apply_filters( 'sky_sliders_pro_init', false );
	}
}


if ( ! function_exists( 'sky_sliders_control_indicator_pro' ) ) {
	function sky_sliders_control_indicator_pro() {
		if ( sky_sliders_init_pro() !== true ) {
			return '<span class="ss-control-indicator-badge ss-pro-badge">' . esc_html__( 'Pro', 'sky-sliders-lite') . '<span>';
		}
	}
}


if ( ! function_exists( 'sky_sliders_title_tags' ) ) {
	function sky_sliders_title_tags() {

		$title_tags = [
			'h1'   => 'H1',
			'h2'   => 'H2',
			'h3'   => 'H3',
			'h4'   => 'H4',
			'h5'   => 'H5',
			'h6'   => 'H6',
			'div'  => 'div',
			'span' => 'span',
			'p'    => 'p',
		];

		return $title_tags;
	}
}

/**
 * Check you are in Editor
 */

if ( ! function_exists( 'sky_sliders_editor_mode' ) ) {
	function sky_sliders_editor_mode() {
		if ( SkySliders_Plugin::elementor()->preview->is_preview_mode() || SkySliders_Plugin::elementor()->editor->is_edit_mode() ) {
			return true;
		}
		return false;
	}
}

/**
 * Disable unserializing of the class
 *
 * @since 1.0.0
 * @return void
 */
if ( ! function_exists( 'sky_sliders_template_modify_link' ) ) {
	function sky_sliders_template_modify_link( $template_id ) {
		if ( SkySliders_Plugin::elementor()->editor->is_edit_mode() ) {

			$final_url = add_query_arg( [ 'elementor' => '' ], get_permalink( $template_id ) );

			$output = sprintf( '<a class="ss-elementor-template-modify-link" href="%s" title="%s" target="_blank"><i class="eicon-edit"></i></a>', esc_url( $final_url ), esc_html__( 'Edit Template', 'sky-sliders-lite') );

			return $output;
		}
	}
}

/**
 * @return array of elementor template
 */
if ( ! function_exists( 'sky_sliders_elementor_template_settings' ) ) {
	function sky_sliders_elementor_template_settings() {

		$templates = SkySliders_Plugin::elementor()->templates_manager->get_source( 'local' )->get_items();
		$types = [];

		if ( empty( $templates ) ) {
			$template_settings = [ '0' => esc_html__( 'Template Not Found!', 'sky-sliders-lite') ];
		} else {
			$template_settings = [ '0' => esc_html__( 'Select Template', 'sky-sliders-lite') ];

			foreach ( $templates as $template ) {
				$template_settings[ $template['template_id'] ] = $template['title'] . ' (' . $template['type'] . ')';
				$types[ $template['template_id'] ] = $template['type'];
			}
		}

		return $template_settings;
	}
}

/**
 * @return array of anywhere templates
 */
if ( ! function_exists( 'sky_sliders_anywhere_template_settings' ) ) {
	function sky_sliders_anywhere_template_settings() {

		if ( post_type_exists( 'ae_global_templates' ) ) {
			$anywhere = get_posts( array(
				'fields'         => 'ids', // Only get post IDs
				'posts_per_page' => -1,
				'post_type'      => 'ae_global_templates',
			) );

			$anywhere_settings = [ '0' => esc_html__( 'Select Template', 'sky-sliders-lite') ];

			foreach ( $anywhere as $key => $value ) {
				$anywhere_settings[ $value ] = get_the_title( $value );
			}
		} else {
			$anywhere_settings = [ '0' => esc_html__( 'AE Plugin Not Installed', 'sky-sliders-lite') ];
		}

		return $anywhere_settings;
	}
}
if ( ! function_exists( 'sky_sliders_get_post_category' ) ) {
	function sky_sliders_get_post_category( $post_type ) {
		switch ( $post_type ) {
			case 'campaign':
				$taxonomy = 'campaign_category';
				break;
			case 'give_forms':
				$taxonomy = 'give_forms_category';
				break;
			case 'lightbox_library':
				$taxonomy = 'ngg_tag';
				break;
			case 'product':
				$taxonomy = 'product_cat';
				break;
			case 'tribe_events':
				$taxonomy = 'tribe_events_cat';
				break;
			case 'knowledge-base':
				$taxonomy = 'knowledge-base-category';
				break;

			default:
				$taxonomy = 'category';
				break;
		}

		$categories = get_the_terms( get_the_ID(), $taxonomy );
		$_categories = [];
		if ( $categories ) {
			foreach ( $categories as $category ) {
				$link = '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . wp_kses_post( $category->name ) . '</a>';
				$_categories[ $category->slug ] = $link;
			}
		}
		return implode( ' ', $_categories );
	}
}

if ( ! function_exists( 'sky_sliders_post_time_ago_kit' ) ) {
	function sky_sliders_post_time_ago_kit( $from, $to = '' ) {
		$diff = human_time_diff( $from, $to );
		$replace = array(
			' hour'    => 'h',
			' hours'   => 'h',
			' day'     => 'd',
			' days'    => 'd',
			' minute'  => 'm',
			' minutes' => 'm',
			' second'  => 's',
			' seconds' => 's',
		);

		return strtr( $diff, $replace );
	}
}

if ( ! function_exists( 'sky_sliders_post_time_ago' ) ) {
	function sky_sliders_post_time_ago( $format = '' ) {
		$display_ago = esc_html__( 'ago', 'sky-sliders-lite');

		if ( 'short' === $format ) {
			$output = sky_sliders_post_time_ago_kit( strtotime( get_the_date() ), current_time( 'timestamp' ) );
		} else {
			$output = human_time_diff( strtotime( get_the_date() ), current_time( 'timestamp' ) );
		}

		$output = $output . ' ' . $display_ago;

		return $output;
	}
}

if ( ! function_exists( 'sky_sliders_custom_excerpt' ) ) {
	function sky_sliders_custom_excerpt( $limit = 25, $strip_shortcode = false, $trail = '' ) {

		$output = get_the_content();

		if ( $limit ) {
			$output = wp_trim_words( $output, $limit, $trail );
		}

		if ( $strip_shortcode ) {
			$output = strip_shortcodes( $output );
		}

		return wpautop( $output );
	}
}


/**
 * Display an Elementor template by its ID.
 *
 * @param int $template_id The ID of the Elementor template.
 */
if ( ! function_exists( 'sky_sliders_display_el_tem_by_id' ) ) {
	function sky_sliders_display_el_tem_by_id( int $template_id ) {
		$posts = get_posts( [
			'post_type'   => 'elementor_library',
			'post_status' => 'publish',
			'p'           => $template_id,
		] );

		if ( ! empty( $posts ) && $posts[0]->ID === $template_id ) {
      //phpcs:ignore
			echo SkySliders_Plugin::elementor()->frontend->get_builder_content_for_display( $template_id );
		} else {
			echo esc_html__( 'The post is not published or does not exist.', 'sky-sliders-lite');
		}
	}
}


/**
 * Render Elementor Content
 *
 * @param $content_id
 *
 * Used in Themes Builder
 */
if ( ! function_exists( 'sky_sliders_render_elementor_content' ) ) {
	function sky_sliders_render_elementor_content( $content_id ) {

		$elementor_instance = \Elementor\Plugin::instance();
		$has_css            = false;

		/**
		 * CSS Print Method Internal and Exteral option support for Header and Footer Builder.
		 */
		if ( ( 'internal' === get_option( 'elementor_css_print_method' ) ) || \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			$has_css = true;
		}

		return $elementor_instance->frontend->get_builder_content_for_display( $content_id, $has_css );
	}
}


/**
 * Get plugin missing notice
 *
 * @param string $plugin
 * @return void
 */
if ( ! function_exists( 'sky_sliders_show_plugin_missing_alert' ) ) {
	function sky_sliders_show_plugin_missing_alert( $plugin ) {
		if ( current_user_can( 'activate_plugins' ) && $plugin ) {
			printf(
				'<div %s>%s</div>',
				'style="margin: 1rem;padding: 1rem 1.25rem;border-left: 5px solid #f5c848;color: #856404;background-color: #fff3cd;"',
				wp_kses_post( $plugin ) . esc_html__( ' is missing! Please install and activate ', 'sky-sliders-lite') . wp_kses_post( $plugin ) . '.'
			);
		}
	}
}

/**
 * Sanitize html class string
 *
 * @param $class
 * @return string
 */
function sky_sliders_sanitize_html_class_param( $class ) {
	$classes   = ! empty( $class ) ? explode( ' ', $class ) : [];
	$sanitized = [];
	if ( ! empty( $classes ) ) {
		$sanitized = array_map(function ( $cls ) {
			return sanitize_html_class( $cls );
		}, $classes);
	}
	return implode( ' ', $sanitized );
}
