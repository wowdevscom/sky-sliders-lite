<?php

namespace SkySliders\Modules\Minimal\Widgets;

use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Repeater;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Minimal extends Widget_Base {

	public function get_name() {
		return 'sky-sliders-minimal';
	}

	public function get_title() {
		return esc_html__( 'Minimal', 'sky-sliders-lite');
	}

	public function get_icon() {
		return 'sky-icon-minimal';
	}

	public function get_categories() {
		return [ 'sky-sliders' ];
	}

	public function get_keywords() {
		return [ 'sky', 'slider', 'minimal', 'creative', 'parallax', 'showcase', 'portfolio' ];
	}

	public function get_style_depends() {
		return [ 'swiper', 'ss-minimal' ];
	}

	public function get_script_depends() {
		return [ 'swiper', 'ss-minimal' ];
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
			'sub_title',
			[
				'label'       => esc_html__( 'Sub Title', 'sky-sliders-lite'),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 2,
				'label_block' => true,
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'sky-sliders-lite'),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 2,
				'label_block' => true,
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'desc_text',
			[
				'label'       => esc_html__( 'Text', 'sky-sliders-lite'),
				'type'        => Controls_Manager::WYSIWYG,
				'placeholder' => esc_html__( 'Type your description here', 'sky-sliders-lite'),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'slider_image',
			[
				'label'   => esc_html__( 'Slider Image', 'sky-sliders-lite'),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [ 'active' => true ],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'button_heading',
			[
				'label'     => esc_html__( 'B U T T O N', 'sky-sliders-lite'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'button_text',
			[
				'label'       => esc_html__( 'Button Text', 'sky-sliders-lite'),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'link',
			[
				'label'       => esc_html__( 'Button Link', 'sky-sliders-lite'),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'sky-sliders-lite'),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'video_external_url',
			[
				'label'       => esc_html__( 'Video URL', 'sky-sliders-lite'),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [ 'active' => true ],
				'separator'   => 'before',
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
						'sub_title'   => esc_html__( 'Creative Portfolio', 'sky-sliders-lite'),
						'title'       => esc_html__( 'Photo Retouch', 'sky-sliders-lite'),
						'desc_text'   => esc_html__( 'Transform your images with professional retouching techniques and creative enhancement.', 'sky-sliders-lite'),
						'button_text' => esc_html__( 'View Work', 'sky-sliders-lite'),
					],
					[
						'sub_title'   => esc_html__( 'Brand Design', 'sky-sliders-lite'),
						'title'       => esc_html__( 'Earthmade Aroma', 'sky-sliders-lite'),
						'desc_text'   => esc_html__( 'Packaging design that captures the essence of natural ingredients and organic beauty.', 'sky-sliders-lite'),
						'button_text' => esc_html__( 'Explore', 'sky-sliders-lite'),
					],
					[
						'sub_title'   => esc_html__( 'Corporate Identity', 'sky-sliders-lite'),
						'title'       => esc_html__( 'Access Bank Rebranding', 'sky-sliders-lite'),
						'desc_text'   => esc_html__( 'A complete visual identity transformation for a modern financial institution.', 'sky-sliders-lite'),
						'button_text' => esc_html__( 'Case Study', 'sky-sliders-lite'),
					],
					[
						'sub_title'   => esc_html__( 'Digital Art', 'sky-sliders-lite'),
						'title'       => esc_html__( 'The Joy of Music', 'sky-sliders-lite'),
						'desc_text'   => esc_html__( 'Visual storytelling through vibrant colors and emotional compositions.', 'sky-sliders-lite'),
						'button_text' => esc_html__( 'Discover', 'sky-sliders-lite'),
					],
					[
						'sub_title'   => esc_html__( 'Motion Graphics', 'sky-sliders-lite'),
						'title'       => esc_html__( 'Abstract Animation', 'sky-sliders-lite'),
						'desc_text'   => esc_html__( 'Bringing ideas to life through dynamic motion design and creative video production.', 'sky-sliders-lite'),
						'button_text' => esc_html__( 'Watch Now', 'sky-sliders-lite'),
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
			'section_additional',
			[
				'label' => esc_html__( 'Additional', 'sky-sliders-lite'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'slider_height',
			[
				'label'      => esc_html__( 'Slider Height', 'sky-sliders-lite'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh', '%' ],
				'range'      => [
					'px' => [
						'min' => 300,
						'max' => 1200,
					],
					'vh' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => 'vh',
					'size' => 100,
				],
				'selectors'  => [
					'{{WRAPPER}} .swiper' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

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
			'show_sub_title',
			[
				'label'   => esc_html__( 'Show Sub Title', 'sky-sliders-lite'),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'sub_title_tag',
			[
				'label'     => esc_html__( 'Sub Title HTML Tag', 'sky-sliders-lite'),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'h4',
				'options'   => sky_sliders_title_tags(),
				'condition' => [
					'show_sub_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_text',
			[
				'label'   => esc_html__( 'Show Text', 'sky-sliders-lite'),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_button',
			[
				'label'   => esc_html__( 'Show Button', 'sky-sliders-lite'),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_navigation',
			[
				'label'     => esc_html__( 'Show Navigation', 'sky-sliders-lite'),
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
				'label' => esc_html__( 'Slider Settings', 'sky-sliders-lite'),
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
				'description' => esc_html__( 'Set the speed of slide transition. Default is 1 second.', 'sky-sliders-lite'),
				'range'       => [
					'px' => [
						'min'  => 0.1,
						'max'  => 10,
						'step' => 0.1,
					],
				],
				'default'     => [
					'unit' => 'px',
					'size' => 1,
				],
			]
		);

		$this->add_control(
			'parallax',
			[
				'label'   => esc_html__( 'Parallax Effect', 'sky-sliders-lite'),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_navigation',
			[
				'label'     => esc_html__( 'Navigation', 'sky-sliders-lite'),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'show_navigation' => 'yes',
				],
			]
		);

		$this->add_control(
			'prev_text',
			[
				'label'       => esc_html__( 'Previous Text', 'sky-sliders-lite'),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Prev', 'sky-sliders-lite'),
				'label_block' => true,
			]
		);

		$this->add_control(
			'prev_icon',
			[
				'label' => esc_html__( 'Previous Icon', 'sky-sliders-lite'),
				'type'  => Controls_Manager::ICONS,
			]
		);

		$this->add_control(
			'next_text',
			[
				'label'       => esc_html__( 'Next Text', 'sky-sliders-lite'),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Next', 'sky-sliders-lite'),
				'label_block' => true,
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'next_icon',
			[
				'label' => esc_html__( 'Next Icon', 'sky-sliders-lite'),
				'type'  => Controls_Manager::ICONS,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_button_button',
			[
				'label'     => esc_html__( 'CTA Button', 'sky-sliders-lite'),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'show_button' => 'yes',
				],
			]
		);

		$this->add_control(
			'button_note',
			[
				'label'           => '',
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'Note: The button settings defined here will override individual slide button settings.', 'sky-sliders-lite'),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);

		$this->add_control(
			'button_text_global',
			[
				'label'       => esc_html__( 'Button Text', 'sky-sliders-lite'),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		/**
		 * Style Tab
		 */

		$this->start_controls_section(
			'section_slider_style',
			[
				'label' => esc_html__( 'Slider', 'sky-sliders-lite'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'content_alignment',
			[
				'label'     => esc_html__( 'Content Alignment', 'sky-sliders-lite'),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left' => [
						'title' => esc_html__( 'Left', 'sky-sliders-lite'),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'sky-sliders-lite'),
						'icon'  => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'sky-sliders-lite'),
						'icon'  => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justified', 'sky-sliders-lite'),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ss--slide-content' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'           => 'slider_overlay_bg',
				'label'          => esc_html__( 'Background', 'sky-sliders-lite'),
				'types'          => [ 'classic', 'gradient' ],
				'fields_options' => [
					'background' => [
						'label' => esc_html__( 'Overlay Color', 'sky-sliders-lite'),
					],
				],
				'selector'       => '{{WRAPPER}} .ss-overlay-dark:before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_sub_title_style',
			[
				'label'     => esc_html__( 'Sub Title', 'sky-sliders-lite'),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_sub_title' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'sub_title_spacing',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'sky-sliders-lite'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ss--sub-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'sub_title_typography',
				'label'    => esc_html__( 'Typography', 'sky-sliders-lite'),
				'selector' => '{{WRAPPER}} .ss--sub-title',
			]
		);

		$this->add_control(
			'sub_title_color',
			[
				'label'     => esc_html__( 'Color', 'sky-sliders-lite'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ss--sub-title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'sub_title_text_shadow',
				'label'    => esc_html__( 'Text Shadow', 'sky-sliders-lite'),
				'selector' => '{{WRAPPER}} .ss--sub-title',
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

		$this->add_responsive_control(
			'title_spacing',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'sky-sliders-lite'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ss--title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'sky-sliders-lite'),
				'selector' => '{{WRAPPER}} .ss--title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'sky-sliders-lite'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ss--title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'title_color_hover',
			[
				'label'     => esc_html__( 'Hover Color', 'sky-sliders-lite'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ss--title:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'title_text_shadow',
				'label'    => esc_html__( 'Text Shadow', 'sky-sliders-lite'),
				'selector' => '{{WRAPPER}} .ss--title',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Stroke::get_type(),
			[
				'name'     => 'title_text_stroke',
				'label'    => esc_html__( 'Text Stroke', 'sky-sliders-lite'),
				'selector' => '{{WRAPPER}} .ss--title',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_text_style',
			[
				'label'     => esc_html__( 'Text', 'sky-sliders-lite'),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_text' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'text_spacing',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'sky-sliders-lite'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ss--text' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'text_typography',
				'label'    => esc_html__( 'Typography', 'sky-sliders-lite'),
				'selector' => '{{WRAPPER}} .ss--text',
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => esc_html__( 'Color', 'sky-sliders-lite'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ss--text' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'text_text_shadow',
				'label'    => esc_html__( 'Text Shadow', 'sky-sliders-lite'),
				'selector' => '{{WRAPPER}} .ss--text',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_button_button_style',
			[
				'label'     => esc_html__( 'Button / CTA', 'sky-sliders-lite'),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_button' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'button_spacing',
			[
				'label'      => esc_html__( 'Top Spacing', 'sky-sliders-lite'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ss--cta-wrap' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'sky-sliders-lite'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ss--btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'sky-sliders-lite'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ss--btn, {{WRAPPER}} .ss--btn::before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_text_typography',
				'label'    => esc_html__( 'Typography', 'sky-sliders-lite'),
				'selector' => '{{WRAPPER}} .ss--btn-text',
			]
		);

		$this->add_responsive_control(
			'button_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'sky-sliders-lite'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 50,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ss--btn svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_icon_spacing',
			[
				'label'      => esc_html__( 'Icon Spacing', 'sky-sliders-lite'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ss--btn-text' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'button_tabs' );

		$this->start_controls_tab(
			'button_tab_normal',
			[
				'label' => esc_html__( 'Normal', 'sky-sliders-lite'),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'sky-sliders-lite'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ss--btn-text' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'sky-sliders-lite'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ss--btn svg' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'sky-sliders-lite'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ss--btn' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button_accent_color',
			[
				'label'     => esc_html__( 'Accent Color', 'sky-sliders-lite'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ss--btn::before' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'button_tab_hover',
			[
				'label' => esc_html__( 'Hover', 'sky-sliders-lite'),
			]
		);

		$this->add_control(
			'button_text_color_hover',
			[
				'label'     => esc_html__( 'Text Color', 'sky-sliders-lite'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ss--btn:hover .ss--btn-text' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button_icon_color_hover',
			[
				'label'     => esc_html__( 'Icon Color', 'sky-sliders-lite'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ss--btn:hover svg' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button_hover_animation_speed',
			[
				'label'     => esc_html__( 'Animation Speed (sec)', 'sky-sliders-lite'),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 0.1,
						'max'  => 2,
						'step' => 0.05,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ss--btn, {{WRAPPER}} .ss--btn svg, {{WRAPPER}} .ss--btn::before' => 'transition-duration: {{SIZE}}s;',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_navigation_style',
			[
				'label'     => esc_html__( 'Navigation', 'sky-sliders-lite'),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_navigation' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'navigation_gap',
			[
				'label'      => esc_html__( 'Gap Icon', 'sky-sliders-lite'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'navigation_padding',
			[
				'label'      => esc_html__( 'Padding', 'sky-sliders-lite'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'navigation_typography',
				'label'    => esc_html__( 'Typography', 'sky-sliders-lite'),
				'selector' => '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev',
			]
		);

		$this->start_controls_tabs( 'navigation_tabs' );

		$this->start_controls_tab(
			'navigation_tab_normal',
			[
				'label' => esc_html__( 'Normal', 'sky-sliders-lite'),
			]
		);

		$this->add_control(
			'navigation_color',
			[
				'label'     => esc_html__( 'Color', 'sky-sliders-lite'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'navigation_background',
				'label'    => esc_html__( 'Background', 'sky-sliders-lite'),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'navigation_tab_hover',
			[
				'label' => esc_html__( 'Hover', 'sky-sliders-lite'),
			]
		);

		$this->add_control(
			'navigation_color_hover',
			[
				'label'     => esc_html__( 'Color', 'sky-sliders-lite'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-button-next:hover, {{WRAPPER}} .swiper-button-prev:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'navigation_background_hover',
				'label'    => esc_html__( 'Background', 'sky-sliders-lite'),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .swiper-button-next:hover, {{WRAPPER}} .swiper-button-prev:hover',
			]
		);

		$this->add_control(
			'navigation_border_hover_color',
			[
				'name'     => 'navigation_border_hover_color',
				'label'    => esc_html__( 'Border', 'sky-sliders-lite'),
				'selector' => '{{WRAPPER}} .ss-draw-border:hover::before, {{WRAPPER}} .ss-draw-border:hover::after',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_pagination_style',
			[
				'label'     => esc_html__( 'Pagination', 'sky-sliders-lite'),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_pagination' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'pagination_size',
			[
				'label'      => esc_html__( 'Size', 'sky-sliders-lite'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 5,
						'max' => 30,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'pagination_tabs' );

		$this->start_controls_tab(
			'pagination_tab_normal',
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
					'{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pagination_tab_active',
			[
				'label' => esc_html__( 'Active', 'sky-sliders-lite'),
			]
		);

		$this->add_control(
			'pagination_active_color',
			[
				'label'     => esc_html__( 'Color', 'sky-sliders-lite'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet-active' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render_sub_title( $item ) {
		$settings = $this->get_settings_for_display();

		if ( 'yes' !== $settings['show_sub_title'] || empty( $item['sub_title'] ) ) {
			return;
		}

		printf(
			'<%1$s class="ss--sub-title" data-swiper-parallax="-1000">%2$s</%1$s>',
			esc_attr( Utils::validate_html_tag( $settings['sub_title_tag'] ) ),
			wp_kses_post( $item['sub_title'] )
		);
	}

	protected function render_title( array $item ) {
		$settings = $this->get_settings_for_display();

		$title_content = $item['title'];

		if ( isset( $item['link']['url'] ) && ! empty( $item['link']['url'] ) ) :
			$this->add_render_attribute( 'title-link-attr', 'href', esc_url( $item['link']['url'] ), true );

			if ( $item['link']['is_external'] ) {
				$this->add_render_attribute( 'title-link-attr', 'target', '_blank', true );
			}

			if ( $item['link']['nofollow'] ) {
				$this->add_render_attribute( 'title-link-attr', 'rel', 'nofollow', true );
			}
			$title_content = '<a ' . $this->get_render_attribute_string( 'title-link-attr' ) . '>' . $title_content . '</a>';
			endif;
		printf(
			'<%1$s class="ss--title" data-swiper-parallax="-1500">%2$s</%1$s>',
			esc_attr( Utils::validate_html_tag( $settings['title_tag'] ) ),
			wp_kses_post( $title_content )
		);
	}

	protected function render_text( $item ) {
		$settings = $this->get_settings_for_display();

		if ( 'yes' !== $settings['show_text'] || empty( $item['desc_text'] ) ) {
			return;
		}

		printf(
			'<div class="ss--text"  data-swiper-parallax="-2500">%s</div>',
			wp_kses_post( $item['desc_text'] )
		);
	}

	protected function render_button( $item ) {
		$settings = $this->get_settings_for_display();

		if ( 'yes' !== $settings['show_button'] ) {
			return;
		}

		// Use global button text and icon if set
		if ( ! empty( $settings['button_text_global'] ) ) {
			$item['button_text'] = $settings['button_text_global'];
		}

		if ( empty( $item['button_text'] ) ) {
			return;
		}

		if ( ! empty( $item['link']['url'] ) ) {
			$this->add_link_attributes( 'link_' . $item['_id'], $item['link'] );
		} else {
			$this->add_render_attribute( 'link_' . $item['_id'], 'href', '#' );
		}

		$this->add_render_attribute( 'link_' . $item['_id'], 'class', 'ss--btn ss--btn-light' );
		?>
	<div class="ss--cta-wrap" data-swiper-parallax="-3500">
		<a <?php $this->print_render_attribute_string( 'link_' . $item['_id'] ); ?>>
			<span class="ss--btn-text"><?php echo esc_html( $item['button_text'] ); ?></span>
			<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M4.66669 11.3334L11.3334 4.66669" stroke="currentColor" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
				<path d="M4.66669 4.66669H11.3334V11.3334" stroke="currentColor" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
			</svg>
		</a>
	</div>
		<?php
	}

	protected function slide_items() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['slider_list'] ) ) {
			return;
		}

		foreach ( $settings['slider_list'] as $item ) :
			$image_url = ! empty( $item['slider_image']['id'] ) ? wp_get_attachment_image_url( $item['slider_image']['id'], $settings['thumbnail_size'] ) : ( ! empty( $item['slider_image']['url'] ) ? $item['slider_image']['url'] : '' );
			$image_alt = ! empty( $item['slider_image']['id'] ) ? get_post_meta( $item['slider_image']['id'], '_wp_attachment_image_alt', true ) : $item['title'];

			if ( empty( $image_url ) ) {
				$image_url = 'transparent';
			}

			?>
			<div class="swiper-slide">
				<div class="ss--slide-bg ss-overlay-dark" <?php if ( ! empty( $image_url ) ) :
					?>style="background-image: url(<?php echo esc_url( $image_url ); ?>);"<?php endif; ?> data-swiper-parallax="1152">
							<div class="ss--slide-content">
								<?php
								$this->render_sub_title( $item );
								$this->render_title( $item );
								$this->render_text( $item );
								$this->render_button( $item );
								?>
							</div>
					<?php if ( ! empty( $item['video_external_url'] ) ) : ?>
						<div class="ss--video-container">
							<video autoplay loop muted playsinline>
								<source src="<?php echo esc_url( $item['video_external_url'] ); ?>" type="video/mp4">
							</video>
						</div>
					<?php endif; ?>
				</div>
			</div>
			<?php
		endforeach;
	}

	protected function render_navigation() {
		$settings = $this->get_settings_for_display();
		?>
	<div class="swiper-navigation">
		<div class="swiper-button-next ss-draw-border">
		<?php echo esc_html( $settings['next_text'] ); ?>
		<span class="ss-icon-wrap">
			<?php
			if ( ! empty( $settings['next_icon']['value'] ) ) :
				Icons_Manager::render_icon( $settings['next_icon'], [
					'aria-hidden' => 'true',
				] );
			else :
				?>
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 27 44">
				<path d="M27,22L27,22L5,44l-2.1-2.1L22.8,22L2.9,2.1L5,0L27,22L27,22z"></path>
			</svg>
				<?php
			endif;
			?>
		</span>
		</div>
		<div class="swiper-button-prev ss-draw-border">
		<span class="ss-icon-wrap">
			<?php
			if ( ! empty( $settings['prev_icon']['value'] ) ) :
				Icons_Manager::render_icon( $settings['prev_icon'], [
					'aria-hidden' => 'true',
				] );
			else :
				?>
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 27 44">
				<path d="M0,22L22,0l2.1,2.1L4.2,22l19.9,19.9L22,44L0,22L0,22L0,22z"></path>
			</svg>
				<?php
			endif;
			?>
		</span>
		<?php echo esc_html( $settings['prev_text'] ); ?>
		</div>
	</div>
		<?php
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$id       = 'sky-sliders--minimal-' . $this->get_id();

		$this->add_render_attribute([
			'minimal' => [
				'class'         => [ 'sky-sliders--minimal' ],
				'id'            => esc_attr( $id ),
				'data-settings' => [
					wp_json_encode([
						'autoplay'   => ( 'yes' === $settings['autoplay'] ) ? [
							'delay'                => ( ! empty( $settings['autoplay_speed']['size'] ) ) ? $settings['autoplay_speed']['size'] * 1000 : 5000,
							'disableOnInteraction' => false,
						] : false,
						'speed'      => ( ! empty( $settings['speed']['size'] ) ) ? $settings['speed']['size'] * 1000 : 1000,
						'parallax'   => ( 'yes' === $settings['parallax'] ) ? true : false,
						'loop'       => ( 'yes' === $settings['loop'] ) ? true : false,
						'navigation' => ( 'yes' === $settings['show_navigation'] ) ? [
							'nextEl' => "#$id .swiper-button-next",
							'prevEl' => "#$id .swiper-button-prev",
						] : false,
					]),
				],
			],
		]);

		?>
		<div <?php $this->print_render_attribute_string( 'minimal' ); ?>>
			<div class="swiper swiper-container">
				<div class="swiper-wrapper">
					<?php $this->slide_items(); ?>
				</div>
				<?php
				if ( 'yes' === $settings['show_navigation'] ) :
					$this->render_navigation();
				endif;
				?>
				<?php if ( 'yes' === $settings['show_pagination'] ) : ?>
					<div class="swiper-pagination"></div>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}
}
