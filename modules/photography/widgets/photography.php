<?php

namespace SkySliders\Modules\Photography\Widgets;

use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Photography extends Widget_Base {

	public function get_name() {
		return 'sky-sliders-photography';
	}

	public function get_title() {
		return esc_html__( 'Photography', 'sky-sliders-lite');
	}

	public function get_icon() {
		return 'sky-icon-photography';
	}

	public function get_categories() {
		return [ 'sky-sliders' ];
	}

	public function get_keywords() {
		return [ 'sliders', 'sky' ];
	}

	public function get_style_depends() {
		return [ 'swiper', 'ss-photography' ];
	}

	public function get_script_depends() {
		return [ 'swiper', 'ss-photography' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_sliders',
			[
				'label' => esc_html__( 'Sliders', 'sky-sliders-lite'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'sky-sliders-lite'),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 2,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'title_span',
			[
				'label'       => esc_html__( 'Title Span', 'sky-sliders-lite'),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'outline_text',
			[
				'label'       => esc_html__( 'Outline Text', 'sky-sliders-lite'),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'slider_image',
			[
				'label'   => esc_html__( 'Image', 'sky-sliders-lite'),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [ 'active' => true ],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		// $repeater->add_control(
		// 'layer_image',
		// [
		// 'label'   => esc_html__( 'Layer Image', 'sky-sliders-lite'),
		// 'type'    => Controls_Manager::MEDIA,
		// 'dynamic' => [ 'active' => true ],
		// 'default' => [
		// 'url' => sky_sliders_assets_url() . 'images/creative/creative-slider-layer.png',
		// ],
		// ]
		// );

		$repeater->add_control(
			'link',
			[
				'label'         => esc_html__( 'Link', 'sky-sliders-lite'),
				'type'          => Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'sky-sliders-lite'),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				],
				'dynamic'       => [ 'active' => true ],
			]
		);

		$this->add_control(
			'slider_list',
			[
				'label'       => '',
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'title'        => esc_html__( 'Desert', 'sky-sliders-lite'),
						'title_span'   => esc_html__( 'Lonliness', 'sky-sliders-lite'),
						'outline_text' => esc_html__( 'Folio', 'sky-sliders-lite'),
					],
					[
						'title'        => esc_html__( 'Mountain', 'sky-sliders-lite'),
						'title_span'   => esc_html__( 'Adventure', 'sky-sliders-lite'),
						'outline_text' => esc_html__( 'Folio', 'sky-sliders-lite'),
					],
					[
						'title'        => esc_html__( 'Ocean', 'sky-sliders-lite'),
						'title_span'   => esc_html__( 'Beauty', 'sky-sliders-lite'),
						'outline_text' => esc_html__( 'Folio', 'sky-sliders-lite'),
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'thumbnail',
				'default'   => 'full',
				'separator' => 'none',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_social_links',
			[
				'label' => esc_html__( 'Social Links', 'sky-sliders-lite'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$social_repeater = new Repeater();

		$social_repeater->add_control(
			'social_text',
			[
				'label'       => esc_html__( 'Text', 'sky-sliders-lite'),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$social_repeater->add_control(
			'social_link',
			[
				'label'         => esc_html__( 'Link', 'sky-sliders-lite'),
				'type'          => Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'sky-sliders-lite'),
				'show_external' => true,
				'default'       => [
					'url'         => '#',
					'is_external' => true,
					'nofollow'    => false,
				],
				'dynamic'       => [ 'active' => true ],
			]
		);

		$this->add_control(
			'social_list',
			[
				'label'       => '',
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $social_repeater->get_controls(),
				'default'     => [
					[
						'social_text' => esc_html__( 'FB', 'sky-sliders-lite'),
						'social_link' => [ 'url' => '#' ],
					],
					[
						'social_text' => esc_html__( 'IG', 'sky-sliders-lite'),
						'social_link' => [ 'url' => '#' ],
					],
					[
						'social_text' => esc_html__( 'YT', 'sky-sliders-lite'),
						'social_link' => [ 'url' => '#' ],
					],
					[
						'social_text' => esc_html__( 'DR', 'sky-sliders-lite'),
						'social_link' => [ 'url' => '#' ],
					],
				],
				'title_field' => '{{{ social_text }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_additional',
			[
				'label' => esc_html__( 'Additional', 'sky-sliders-lite'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		/*
		$this->add_responsive_control(
		'height',
		[
		'label'      => esc_html__( 'Slider Height', 'sky-sliders-lite'),
		'type'       => Controls_Manager::SLIDER,
		'size_units' => [ 'px', 'em', '%', 'vh' ],
		'range'      => [
		'px' => [
		'min' => 200,
		'max' => 1000,
		],
		'%' => [
		'min' => 0,
		'max' => 100,
		],
		],
		'selectors'  => [
		'{{WRAPPER}} .sky-sliders--photography' => 'height: {{SIZE}}{{UNIT}};',
		],
		]
		);
		*/

		$this->add_control(
			'title_tag',
			[
				'label'   => esc_html__( 'Title HTML Tag', 'sky-sliders-lite'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h2',
				'options' => sky_sliders_title_tags(),
			]
		);

		$this->add_control(
			'outline_tag',
			[
				'label'   => esc_html__( 'Outline Text HTML Tag', 'sky-sliders-lite'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h2',
				'options' => sky_sliders_title_tags(),
			]
		);

		$this->add_control(
			'show_social',
			[
				'label'     => esc_html__( 'Show Sidebar', 'sky-sliders-lite'),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'show_pagination',
			[
				'label'   => esc_html__( 'Show Pagination', 'sky-sliders-lite'),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_slider_settings',
			[
				'label' => esc_html__( 'Settings', 'sky-sliders-lite'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'   => esc_html__( 'Autoplay', 'sky-sliders-lite'),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label'       => esc_html__( 'Autoplay Speed (sec)', 'sky-sliders-lite'),
				'type'        => Controls_Manager::SLIDER,
				'description' => esc_html__( 'Set the delay between slides during autoplay. Default is 5 seconds.', 'sky-sliders-lite'),
				'range'       => [
					'px' => [
						'min'  => 1,
						'max'  => 20,
						'step' => 0.5,
					],
				],
				'default'     => [
					'unit' => 'px',
					'size' => 5,
				],
				'condition'   => [
					'autoplay' => 'yes',
				],
			]
		);

		$this->add_control(
			'loop',
			[
				'label'   => esc_html__( 'Loop', 'sky-sliders-lite'),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'speed',
			[
				'label'       => esc_html__( 'Slide Speed (sec)', 'sky-sliders-lite'),
				'type'        => Controls_Manager::SLIDER,
				'description' => esc_html__( 'Set the speed of slide transition. Default is 2.5 seconds.', 'sky-sliders-lite'),
				'range'       => [
					'px' => [
						'min'  => 0.1,
						'max'  => 10,
						'step' => 0.1,
					],
				],
				'default'     => [
					'unit' => 'px',
					'size' => 2.5,
				],
			]
		);

		$this->add_control(
			'parallax',
			[
				'label'   => esc_html__( 'Parallax', 'sky-sliders-lite'),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_layout_style',
			[
				'label' => esc_html__( 'Layout', 'sky-sliders-lite'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Title', 'sky-sliders-lite'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'sky-sliders-lite'),
				'selector' => '{{WRAPPER}} .photography-item--title',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Stroke::get_type(),
			[
				'name'     => 'title_text_stroke',
				'selector' => '{{WRAPPER}} .photography-item--title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Text Color', 'sky-sliders-lite'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .photography-item--title, {{WRAPPER}} .photography-item--title *' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'title_color_hover',
			[
				'label'     => esc_html__( 'Text Color Hover', 'sky-sliders-lite'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .photography-item--title:hover, {{WRAPPER}} .photography-item--title:hover *' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'title_text_shadow',
				'label'    => esc_html__( 'Text Shadow', 'sky-sliders-lite'),
				'selector' => '{{WRAPPER}} .photography-item--title',
			]
		);

		$this->add_control(
			'title_span_heading',
			[
				'label'     => esc_html__( 'S P A N', 'sky-sliders-lite'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_span_typography',
				'label'    => esc_html__( 'Typography', 'sky-sliders-lite'),
				'selector' => '{{WRAPPER}} .photography-item--title span',
			]
		);

		$this->add_control(
			'title_span_color',
			[
				'label'     => esc_html__( 'Text Color', 'sky-sliders-lite'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .photography-item--title span' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_outline_style',
			[
				'label' => esc_html__( 'Outline Text', 'sky-sliders-lite'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'outline_typography',
				'label'    => esc_html__( 'Typography', 'sky-sliders-lite'),
				'selector' => '{{WRAPPER}} .photography-item--title-outline',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Stroke::get_type(),
			[
				'name'     => 'outline_text_stroke',
				'selector' => '{{WRAPPER}} .photography-item--title-outline',
			]
		);

		$this->add_control(
			'outline_color',
			[
				'label'     => esc_html__( 'Text Color', 'sky-sliders-lite'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .photography-item--title-outline' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'outline_text_shadow',
				'label'    => esc_html__( 'Text Shadow', 'sky-sliders-lite'),
				'selector' => '{{WRAPPER}} .photography-item--title-outline',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_pagination_style',
			[
				'label'     => esc_html__( 'Pagination', 'sky-sliders-lite'),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_pagination' => 'yes' ],
			]
		);

		$this->add_control(
			'pagination_text_heading',
			[
				'label'     => esc_html__( 'T E X T', 'sky-sliders-lite'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'pagination_text_color',
			[
				'label'     => esc_html__( 'Color', 'sky-sliders-lite'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet::after' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'pagination_text_typography',
				'label'    => esc_html__( 'Typography', 'sky-sliders-lite'),
				'selector' => '{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet::after',
			]
		);

		$this->start_controls_tabs( 'pagination_style_tabs' );
		$this->start_controls_tab(
			'pagination_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'sky-sliders-lite'),
			]
		);

		$this->add_control(
			'pagination_color',
			[
				'label'     => esc_html__( 'Color', 'sky-sliders-lite'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination span' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();
		$this->start_controls_tab(
			'pagination_active_tab',
			[
				'label' => esc_html__( 'Active', 'sky-sliders-lite'),
			]
		);

		$this->add_control(
			'pagination_active_color',
			[
				'label'     => esc_html__( 'Active Color', 'sky-sliders-lite'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination span.swiper-pagination-bullet-active' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_social_style',
			[
				'label'     => esc_html__( 'Social Links', 'sky-sliders-lite'),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_social' => 'yes' ],
			]
		);

		$this->add_control(
			'social_color',
			[
				'label'     => esc_html__( 'Text Color', 'sky-sliders-lite'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .photography--sidebar a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'social_color_hover',
			[
				'label'     => esc_html__( 'Text Color Hover', 'sky-sliders-lite'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .photography--sidebar a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'social_typography',
				'label'    => esc_html__( 'Typography', 'sky-sliders-lite'),
				'selector' => '{{WRAPPER}} .photography--sidebar a',
			]
		);

		$this->end_controls_section();
	}

	protected function render_title( array $item ) {
		$settings = $this->get_settings_for_display();

		if ( empty( $item['title'] ) ) {
			return;
		}

		$title_content = $item['title'];
		if ( ! empty( $item['title_span'] ) ) {
			$title_content .= ' <br> <span>' . esc_html( $item['title_span'] ) . '</span>';
		}

		if ( isset( $item['link']['url'] ) && ! empty( $item['link']['url'] ) ) {
			$this->add_render_attribute( 'title-link-' . $item['_id'], 'href', esc_url( $item['link']['url'] ), true );

			if ( $item['link']['is_external'] ) {
				$this->add_render_attribute( 'title-link-' . $item['_id'], 'target', '_blank', true );
			}

			if ( $item['link']['nofollow'] ) {
				$this->add_render_attribute( 'title-link-' . $item['_id'], 'rel', 'nofollow', true );
			}
			$title_content = '<a ' . $this->get_render_attribute_string( 'title-link-' . $item['_id'] ) . '>' . $title_content . '</a>';
		}

		printf(
			'<%1$s class="photography-item--title">%2$s</%1$s>',
			esc_attr( Utils::validate_html_tag( $settings['title_tag'] ) ),
			wp_kses_post( $title_content )
		);
	}

	protected function render_outline_text( array $item ) {
		$settings = $this->get_settings_for_display();

		if ( empty( $item['outline_text'] ) ) {
			return;
		}

		printf(
			'<%1$s class="photography-item--title-outline">%2$s</%1$s>',
			esc_attr( Utils::validate_html_tag( $settings['outline_tag'] ) ),
			esc_html( $item['outline_text'] )
		);
	}

	protected function slide_items( $item ) {
		$settings = $this->get_settings_for_display();
		$img       = ! empty( $item['slider_image']['id'] ) ? wp_get_attachment_image_url( $item['slider_image']['id'], $settings['thumbnail_size'] ) : $item['slider_image']['url'];
		// $layer_img = ! empty( $item['layer_image']['id'] ) ? wp_get_attachment_image_url( $item['layer_image']['id'], 'full' ) : $item['layer_image']['url'];
		$layer_img = sky_sliders_assets_url() . 'images/sliders/photography-slider-layer.png';

		?>
		<div class="swiper-slide">
			<div class="photography-slider--item">
				<?php if ( ! empty( $layer_img ) ) : ?>
				<div class="photography-slider--layer">
					<img src="<?php echo esc_url( $layer_img ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>">
				</div>
				<?php endif; ?>
				<div class="photography-slider--content">
					<div class="photography-slider--image">
						<?php if ( ! empty( $img ) ) : ?>
						<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>">
						<?php endif; ?>
						<div class="photography-slider--inner">
							<div class="photography-heading">
								<div class="photography-item--inner">
									<?php
									$this->render_title( $item );
									$this->render_outline_text( $item );
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$id       = 'sky-sliders--photography-' . $this->get_id();

		$this->add_render_attribute([
			'photography' => [
				'class'         => [ 'sky-sliders--photography' ],
				'id'            => esc_attr( $id ),
				'data-settings' => [
					wp_json_encode(array_filter([
						'loop'       => ( 'yes' === $settings['loop'] ) ? true : false,
						'parallax'   => ( 'yes' === $settings['parallax'] ) ? true : false,
						'autoplay'   => ( 'yes' === $settings['autoplay'] ) ? [
							'delay' => ( ! empty( $settings['autoplay_speed']['size'] ) ) ? $settings['autoplay_speed']['size'] * 1000 : 5000,
						] : false,
						'effect'     => 'fade',
						'autoHeight' => true,
						'speed'      => ( ! empty( $settings['speed']['size'] ) ) ? $settings['speed']['size'] * 1000 : 2500,
						'pagination' => ( 'yes' === $settings['show_pagination'] ) ? [
							'el'        => "#$id .swiper-pagination",
							'clickable' => true,
						] : false,
					])),
				],
			],
		]);

		?>
		<div <?php $this->print_render_attribute_string( 'photography' ); ?>>
			<div class="swiper-container photography-swiper--slider">
				<div class="swiper-wrapper">
					<?php
					if ( ! empty( $settings['slider_list'] ) ) {
						foreach ( $settings['slider_list'] as $item ) {
							$this->slide_items( $item );
						}
					}
					?>
					<?php if ( 'yes' === $settings['show_pagination'] ) : ?>
					<div class="creative-swiper--dots">
						<div class="swiper-pagination"></div>
					</div>
					<?php endif; ?>
				</div>
			</div>
			<?php if ( 'yes' === $settings['show_social'] ) : ?>
			<div class="photography--sidebar">
				<div class="social-box">
					<ul>
						<?php
						if ( ! empty( $settings['social_list'] ) ) {
							foreach ( $settings['social_list'] as $social ) {
								$social_url      = ! empty( $social['social_link']['url'] ) ? $social['social_link']['url'] : '#';
								$social_target   = ! empty( $social['social_link']['is_external'] ) ? '_blank' : '_self';
								$social_nofollow = ! empty( $social['social_link']['nofollow'] ) ? 'nofollow' : '';

								$this->add_render_attribute( 'social-link-' . $social['_id'], 'href', esc_url( $social_url ), true );
								$this->add_render_attribute( 'social-link-' . $social['_id'], 'target', esc_attr( $social_target ), true );
								if ( ! empty( $social_nofollow ) ) {
									$this->add_render_attribute( 'social-link-' . $social['_id'], 'rel', esc_attr( $social_nofollow ), true );
								}
								?>
								<li>
									<a <?php $this->print_render_attribute_string( 'social-link-' . $social['_id'] ); ?>>
										<?php echo esc_html( $social['social_text'] ); ?>
									</a>
								</li>
								<?php
							}
						}
						?>
					</ul>
				</div>
			</div>
			<?php endif; ?>
		</div>
		<?php
	}
}
