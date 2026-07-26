<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Aovis_Elementor_Testimonial extends Widget_Base {

	public function get_name() {
		return 'aovis_elementor_testimonial';
	}

	public function get_title() {
		return esc_html__( 'Ova Testimonial', 'aovis' );
	}

	public function get_icon() {
		return 'eicon-testimonial-carousel';
	}

	public function get_categories() {
		return [ 'aovis' ];
	}

	public function get_script_depends() {
		return [ 'aovis-elementor-testimonial' ];
	}
	
	// Add Your Controll In This Function
	protected function register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'aovis' ),
			]
		);	

			$this->add_control(
				'template',
				[
					'label' => esc_html__( 'Template', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'template1',
					'options' => [
						'template1' => esc_html__( 'Template 1', 'aovis' ),
						'template2' => esc_html__( 'Template 2', 'aovis' ),
					],
				]
			);

			$this->add_control(
				'icon',
				[
					'label' => esc_html__( 'Icon Quote', 'aovis' ),
					'type' => \Elementor\Controls_Manager::ICONS,
					'default' => [
						'value' => 'flaticon flaticon-quotes',
						'library' => 'flaticon',
					],
				]
			);

			$this->add_control(
				'show_background_quote',
				[
					'label' => esc_html__( 'Show Background Quote', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'aovis' ),
					'label_off' => esc_html__( 'Hide', 'aovis' ),
					'return_value' => 'yes',
					'default' => 'yes',
					'condition' => [
						'template' => 'template2',
					],
				]
			);
			
			// Add Class control
			$repeater = new \Elementor\Repeater();

			$repeater->add_control(
				'content',
				[
					'label' => esc_html__( 'Content', 'aovis' ),
					'type' => \Elementor\Controls_Manager::TEXTAREA,
					'default' => esc_html__( 'This is due to their excellent service, competitive pricing and customer support. It’s refresing to get such a personal touch. Duis aute lorem ipsum is simply free text available in the market reprehen.', 'aovis' ),
					'placeholder' => esc_html__( 'Type your content here', 'aovis' ),
				]
			);

			$repeater->add_control(
				'author',
				[
					'label' => esc_html__( 'Author', 'aovis' ),
					'type' => \Elementor\Controls_Manager::MEDIA,
					'default' => [
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					],
					'separator' => 'before',
				]
			);

			$repeater->add_control(
				'name',
				[
					'label' => esc_html__( 'Name', 'aovis' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'Default title', 'aovis' ),
					'placeholder' => esc_html__( 'Type your title here', 'aovis' ),
				]
			);

			$repeater->add_control(
				'job',
				[
					'label' => esc_html__( 'Job', 'aovis' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'Default title', 'aovis' ),
					'placeholder' => esc_html__( 'Type your title here', 'aovis' ),
				]
			);

			$this->add_control(
				'items_testimonial',
				[
					'label' => esc_html__( 'Items Testimonial', 'aovis' ),
					'type' => \Elementor\Controls_Manager::REPEATER,
					'fields' => $repeater->get_controls(),
					'default' => [
						[
							'name' => esc_html__( 'Mike Hardson', 'aovis' ),
							'job' => esc_html__( 'Customer', 'aovis' ),
						],
						[
							'name' => esc_html__( 'Hubert J. Johnso', 'aovis' ),
							'job' => esc_html__( 'Customer', 'aovis' ),
						],
						[
							'name' => esc_html__( 'Pacific D. Lee', 'aovis' ),
							'job' => esc_html__( 'Customer', 'aovis' ),
						],
					],
					'title_field' => '{{{ name }}}',
				]
			);

			$this->add_control(
				'show_rating',
				[
					'label'   => esc_html__( 'Show Rating', 'aovis' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'yes',
					'options' => [
						'yes' => esc_html__( 'Yes', 'aovis' ),
						'no'  => esc_html__( 'No', 'aovis' ),
					],
					'condition' => [
						'template' => 'template1',
					]
				]
			);

		$this->end_controls_section();

		/*****************************************************************
						START SECTION ADDITIONAL
		******************************************************************/

		$this->start_controls_section(
			'section_additional_options',
			[
				'label' => esc_html__( 'Additional Options', 'aovis' ),
			]
		);

			$this->add_control(
				'margin_items',
				[
					'label'   => esc_html__( 'Margin Right Items', 'aovis' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 30,
				]	
			);

			$this->add_control(
				'item_number',
				[
					'label'       => esc_html__( 'Item Number', 'aovis' ),
					'type'        => Controls_Manager::NUMBER,
					'description' => esc_html__( 'Number Item', 'aovis' ),
					'default'     => 1,
				]
			);

			$this->add_control(
				'slides_to_scroll',
				[
					'label'       => esc_html__( 'Slides to Scroll', 'aovis' ),
					'type'        => Controls_Manager::NUMBER,
					'description' => esc_html__( 'Set how many slides are scrolled per swipe.', 'aovis' ),
					'default'     => 1,
				]
			);

			$this->add_control(
				'pause_on_hover',
				[
					'label'   => esc_html__( 'Pause on Hover', 'aovis' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'yes',
					'options' => [
						'yes' => esc_html__( 'Yes', 'aovis' ),
						'no'  => esc_html__( 'No', 'aovis' ),
					],
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'infinite',
				[
					'label'   => esc_html__( 'Infinite Loop', 'aovis' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'yes',
					'options' => [
						'yes' => esc_html__( 'Yes', 'aovis' ),
						'no'  => esc_html__( 'No', 'aovis' ),
					],
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'autoplay',
				[
					'label'   => esc_html__( 'Autoplay', 'aovis' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'yes',
					'options' => [
						'yes' => esc_html__( 'Yes', 'aovis' ),
						'no'  => esc_html__( 'No', 'aovis' ),
					],
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'autoplay_speed',
				[
					'label'     => esc_html__( 'Autoplay Speed', 'aovis' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 3000,
					'step'      => 500,
					'condition' => [
						'autoplay' => 'yes',
					],
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'smartspeed',
				[
					'label'   => esc_html__( 'Smart Speed', 'aovis' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 500,
				]
			);

			$this->add_control(
				'dot_control',
				[
					'label'   => esc_html__( 'Show Dots', 'aovis' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'yes',
					'options' => [
						'yes' => esc_html__( 'Yes', 'aovis' ),
						'no'  => esc_html__( 'No', 'aovis' ),
					],
					'frontend_available' => true,
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'general_section',
			[
				'label' => esc_html__( 'General', 'aovis' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'background_color',
				[
					'label' => esc_html__( 'Background Color', 'aovis' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-testimonial.template2 .slide-testimonials .item .wrap-content' => 'background-color: {{VALUE}}',
						'{{WRAPPER}} .ova-testimonial.template2 .slide-testimonials .item .triangle-2' => 'border-top-color: {{VALUE}}',
						'{{WRAPPER}} .ova-testimonial .slide-testimonials .item' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'general_padding',
				[
					'label' => esc_html__( 'Padding', 'aovis' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em'],
					'selectors' => [
						'{{WRAPPER}} .ova-testimonial .slide-testimonials .item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition' => [
						'template' => 'template1',
					],
				]
			);

			$this->add_control(
				'general_margin',
				[
					'label' => esc_html__( 'Margin', 'aovis' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em'],
					'selectors' => [
						'{{WRAPPER}} .ova-testimonial .slide-testimonials .item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition' => [
						'template' => 'template2',
					],
				]
			);

			$this->add_control(
				'border_color',
				[
					'label' => esc_html__( 'Border Color', 'aovis' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-testimonial.template2 .slide-testimonials .item .wrap-content' => 'border-color: {{VALUE}}',
						'{{WRAPPER}} .ova-testimonial.template2 .slide-testimonials .item .triangle-1' => 'border-top-color: {{VALUE}}',
					],
					'condition' => [
						'template' => 'template2',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'general_border',
					'selector' => '{{WRAPPER}} .ova-testimonial .slide-testimonials .item',
					'condition' => [
						'template' => 'template1',
					],
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_style',
			[
				'label' => esc_html__( 'Content', 'aovis' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'content_typography',
					'selector' => '{{WRAPPER}} .ova-testimonial .slide-testimonials .item .content',
				]
			);

			$this->add_control(
				'content_color',
				[
					'label' => esc_html__( 'Color', 'aovis' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-testimonial .slide-testimonials .item .content' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'content_margin',
				[
					'label' => esc_html__( 'Margin', 'aovis' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em'],
					'selectors' => [
						'{{WRAPPER}} .ova-testimonial .slide-testimonials .item .content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_author_style',
			[
				'label' => esc_html__( 'Author Image', 'aovis' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'author_image_size',
				[
					'label' => esc_html__( 'Size', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%', 'em', 'rem' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 300,
							'step' => 1,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .ova-testimonial .slide-testimonials .item .author .image img' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'author_image_border_radius',
				[
					'label' => esc_html__( 'Border Radius', 'aovis' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em'],
					'selectors' => [
						'{{WRAPPER}} .ova-testimonial .slide-testimonials .item .author .image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'author_image_background',
				[
					'label' => esc_html__( 'Background', 'aovis' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_control(
				'author_image_background_size',
				[
					'label' => esc_html__( 'Background Size', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%', 'em', 'rem' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 300,
							'step' => 1,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .ova-testimonial .slide-testimonials .item .author .image' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'author_background_color',
				[
					'label' => esc_html__( 'Background Color', 'aovis' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-testimonial .slide-testimonials .item .author .image' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'author_background_border_radius',
				[
					'label' => esc_html__( 'Border Radius', 'aovis' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em'],
					'selectors' => [
						'{{WRAPPER}} .ova-testimonial .slide-testimonials .item .author .image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'image_border',
					'selector' => '{{WRAPPER}} .ova-testimonial .slide-testimonials .item .author .image',
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_author_info_style',
			[
				'label' => esc_html__( 'Author Infomation', 'aovis' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'rating_heading',
				[
					'label' => esc_html__( 'Rating', 'aovis' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'condition' => [
						'template' => 'template1',
						'show_rating' => 'yes',
					],
				]
			);

			$this->add_control(
				'rating_size',
				[
					'label' => esc_html__( 'Size', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%', 'em', 'rem' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
							'step' => 1,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .ova-testimonial .slide-testimonials .item .author .info .rating i' => 'font-size: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'template' => 'template1',
						'show_rating' => 'yes',
					],
				]
			);

			$this->add_control(
				'rating_spacing',
				[
					'label' => esc_html__( 'Spacing', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%', 'em', 'rem' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
							'step' => 1,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .ova-testimonial .slide-testimonials .item .author .info .rating i' => 'margin-right: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'template' => 'template1',
						'show_rating' => 'yes',
					],
				]
			);

			$this->add_control(
				'rating_color',
				[
					'label' => esc_html__( 'Color', 'aovis' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-testimonial .slide-testimonials .item .author .info .rating i' => 'color: {{VALUE}}',
					],
					'condition' => [
						'template' => 'template1',
						'show_rating' => 'yes',
					],
				]
			);

			$this->add_control(
				'rating_margin',
				[
					'label' => esc_html__( 'Margin', 'aovis' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em'],
					'selectors' => [
						'{{WRAPPER}} .ova-testimonial .ova-testimonial .slide-testimonials .item .author .info .rating' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator' => 'after',
					'condition' => [
						'template' => 'template1',
						'show_rating' => 'yes',
					],
				]
			);

			$this->add_control(
				'name_heading',
				[
					'label' => esc_html__( 'Name', 'aovis' ),
					'type' => \Elementor\Controls_Manager::HEADING,
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'name_typography',
					'selector' => '{{WRAPPER}} .ova-testimonial .slide-testimonials .item .author .info .name',
				]
			);

			$this->add_control(
				'name_color',
				[
					'label' => esc_html__( 'Color', 'aovis' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-testimonial .slide-testimonials .item .author .info .name' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'name_margin',
				[
					'label' => esc_html__( 'Margin', 'aovis' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em'],
					'selectors' => [
						'{{WRAPPER}} .ova-testimonial .slide-testimonials .item .author .info .name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'job_heading',
				[
					'label' => esc_html__( 'Job', 'aovis' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'job_typography',
					'selector' => '{{WRAPPER}} .ova-testimonial .slide-testimonials .item .author .info .job',
				]
			);

			$this->add_control(
				'job_color',
				[
					'label' => esc_html__( 'Color', 'aovis' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-testimonial .slide-testimonials .item .author .info .job' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'job_margin',
				[
					'label' => esc_html__( 'Margin', 'aovis' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em'],
					'selectors' => [
						'{{WRAPPER}} .ova-testimonial .slide-testimonials .item .author .info .job' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_quote_style',
			[
				'label' => esc_html__( 'Quote', 'aovis' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'quote_size',
				[
					'label' => esc_html__( 'Size', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%', 'em', 'rem' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 300,
							'step' => 1,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .ova-testimonial.template1 .owl-stage-outer .item .quote i' => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .ova-testimonial.template2 .slide-testimonials .item .wrap-content .author .quote i' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'quote_color',
				[
					'label' => esc_html__( 'Color', 'aovis' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-testimonial.template1 .owl-stage-outer .item .quote i' => 'color: {{VALUE}}',
						'{{WRAPPER}} .ova-testimonial.template2 .slide-testimonials .item .wrap-content .author .quote i' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'quote_position_bottom',
				[
					'label' => esc_html__( 'Top Position', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%', 'em', 'rem' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1000,
							'step' => 1,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .ova-testimonial.template1 .owl-stage-outer .item .quote' => 'bottom: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'template' => 'template1',
					],
				]
			);

			$this->add_control(
				'quote_position_right',
				[
					'label' => esc_html__( 'Right Position', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%', 'em', 'rem' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1000,
							'step' => 1,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .ova-testimonial.template1 .owl-stage-outer .item .quote' => 'right: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'template' => 'template1',
					],
				]
			);

			$this->add_control(
				'quote_background',
				[
					'label' => esc_html__( 'Background', 'aovis' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'template' => 'template2',
					],
				]
			);

			$this->add_control(
				'quote_background_size',
				[
					'label' => esc_html__( 'Size', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%', 'em', 'rem' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1000,
							'step' => 1,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .ova-testimonial.template2 .slide-testimonials .item .wrap-content .author .background' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'template' => 'template2',
					],
				]
			);

			$this->add_control(
				'quote_background_color',
				[
					'label' => esc_html__( 'Background Color', 'aovis' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-testimonial.template2 .slide-testimonials .item .wrap-content .author .background' => 'background-color: {{VALUE}}',
					],
					'condition' => [
						'template' => 'template2',
					],
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_dot_style',
			[
				'label' => esc_html__( 'Dot', 'aovis' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'template' => 'template1',
					'dot_control' => 'yes',
				],
			]
		);

			$this->add_control(
				'dot_size',
				[
					'label' => esc_html__( 'Size', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%', 'em', 'rem' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 200,
							'step' => 1,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .ova-testimonial.template1 .owl-dots .owl-dot' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'dot_color',
				[
					'label' => esc_html__( 'Color', 'aovis' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-testimonial.template1 .owl-dots .owl-dot' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'dot_color_active',
				[
					'label' => esc_html__( 'Color Active', 'aovis' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-testimonial.template1 .owl-dots .owl-dot.active' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'dot_position_top',
				[
					'label' => esc_html__( 'Top Position', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%', 'em', 'rem' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1000,
							'step' => 1,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .ova-testimonial.template1 .owl-dots' => 'top: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'dot_position_right',
				[
					'label' => esc_html__( 'Right Position', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%', 'em', 'rem' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1000,
							'step' => 1,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .ova-testimonial.template1 .owl-dots' => 'right: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'dot_border_radius',
				[
					'label' => esc_html__( 'Border Radius', 'aovis' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em'],
					'selectors' => [
						'{{WRAPPER}} .ova-testimonial.template1 .owl-dots .owl-dot' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

		$this->end_controls_section();

	}

	// Render Template Here
	protected function render() {
		$settings = $this->get_settings();

		$template  = $settings['template'];
		$items_testimonial = $settings['items_testimonial'];

		$icon = $settings['icon']['value'];
		$show_background_quote = $settings['show_background_quote'];

		$show_rating = $settings['show_rating'];
			
		$data_options['items'] 				= $settings['item_number'];
		$data_options['slideBy']            = $settings['slides_to_scroll'];
		$data_options['margin']             = $settings['margin_items'];
		$data_options['autoplayHoverPause'] = $settings['pause_on_hover'] === 'yes' ? true : false;
		$data_options['loop']               = $settings['infinite'] === 'yes' ? true : false;
		$data_options['autoplay']           = $settings['autoplay'] === 'yes' ? true : false;
		$data_options['autoplayTimeout']    = $settings['autoplay_speed'];
		$data_options['smartSpeed']         = $settings['smartspeed'];
		$data_options['dots']               = $settings['dot_control'] === 'yes' ? true : false;
		$data_options['rtl']				= is_rtl() ? true: false;

		?>

			<div class="ova-testimonial <?php echo esc_attr($template); ?>">
				<div class="slide-testimonials owl-carousel owl-theme" data-options="<?php echo esc_attr(json_encode($data_options)); ?>" >
					<?php if ($items_testimonial ) { ?>

						<?php foreach ($items_testimonial as $items) { 
							$image_alt = (isset($items['author']['alt']) && $items['author']['alt'] != '') ? $items['author']['alt'] : $items['name']; 
						?>
							<div class="item">

								<?php if( $template == 'template1') : ?>

									<?php if( !empty( $icon ) ) : ?>
										<div class="quote">

											<i class="<?php echo esc_attr( $icon ); ?>"></i>

										</div>
									<?php endif; ?>

									<div class="author">
											
										<?php if( !empty( $items['author']['url']) ) : ?>
											<div class="image">

												<img src="<?php echo esc_url($items['author']['url']); ?>" alt="<?php echo esc_attr($image_alt); ?>">

											</div>
										<?php endif; ?>

										<div class="info">

											<?php if( $show_rating == 'yes') : ?>
												<div class="rating">
													<i aria-hidden="true" class="fas fa-star"></i>
													<i aria-hidden="true" class="fas fa-star"></i>
													<i aria-hidden="true" class="fas fa-star"></i>
													<i aria-hidden="true" class="fas fa-star"></i>
													<i aria-hidden="true" class="fas fa-star"></i>
												</div>
											<?php endif; ?>

											<?php if( !empty( $items['name'] ) ) : ?>
												<h3 class="name"><?php echo esc_html($items['name']); ?></h3>
											<?php endif; ?>

											<?php if( !empty( $items['job'] ) ) : ?>
												<p class="job"><?php echo esc_html($items['job']); ?></p>
											<?php endif; ?>

										</div>

									</div>

									<?php if( !empty( $items['content'] ) ) : ?>
										<p class="content"><?php echo esc_html($items['content']); ?></p>
									<?php endif; ?>
									
								<?php endif; ?>


								<?php if( $template == 'template2') : ?>

									<div class="wrap-content">
										
										<?php if( !empty( $items['content'] ) ) : ?>
											<p class="content"><?php echo esc_html( $items['content']); ?></p>
										<?php endif; ?>

										<div class="author">

											<div class="wrap-image-info">
											
												<?php if( !empty( $items['author']['url']) ) : ?>
													<div class="image">

														<img src="<?php echo esc_url($items['author']['url']); ?>" alt="<?php echo esc_attr($image_alt); ?>">

													</div>
												<?php endif; ?>

												<div class="info">

													<?php if( !empty( $items['name'] ) ) : ?>
														<h3 class="name"><?php echo esc_html($items['name']); ?></h3>
													<?php endif; ?>

													<?php if( !empty( $items['job'] ) ) : ?>
														<p class="job"><?php echo esc_html($items['job']); ?></p>
													<?php endif; ?>

												</div>
											
											</div>

											<?php if( !empty( $icon ) ) : ?>
												<div class="quote">
													<i class="<?php echo esc_attr( $icon ); ?>"></i>
												</div>
											<?php endif; ?>

											<?php if( $show_background_quote == 'yes' ) : ?>
												<div class="background"></div>
											<?php endif; ?>

										</div>
								
									</div>

									<div class="triangle-1"></div>
									<div class="triangle-2"></div>

								<?php endif; ?>

							</div>

						<?php } ?>

					<?php } ?>

				</div>

			</div>

		<?php
	}
}
$widgets_manager->register( new Aovis_Elementor_Testimonial() );