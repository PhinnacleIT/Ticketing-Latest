<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Aovis_Elementor_Icon_Box extends Widget_Base {

	public function get_name() {
		return 'aovis_elementor_icon_box';
	}

	public function get_title() {
		return esc_html__( 'Ova Icon Box', 'aovis' );
	}

	public function get_icon() {
		return 'eicon-icon-box';
	}

	public function get_categories() {
		return [ 'aovis' ];
	}

	public function get_script_depends() {
		return [ '' ];
	}
	
	// Add Your Controll In This Function
	protected function register_controls() {

		$this->start_controls_section(
			'section_icon_box',
			[
				'label' => esc_html__( 'Icon Box', 'aovis' ),
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
			
			// Add Class control
			$this->add_control(
				'icon',
				[
					'label' => esc_html__( 'Icon', 'aovis' ),
					'type' => \Elementor\Controls_Manager::ICONS,
					'default' => [
						'value' => 'flaticon flaticon-carnival-mask',
						'library' => 'flaticon',
					],
				]
			);

			$this->add_control(
				'sub_title',
				[
					'label' => esc_html__( 'Sub Title', 'aovis' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'Join Now', 'aovis' ),
					'placeholder' => esc_html__( 'Type your sub title here', 'aovis' ),
					'condition' => [
						'template!' => 'template2',
					],
				]
			);

			$this->add_control(
				'title',
				[
					'label' => esc_html__( 'Title', 'aovis' ),
					'type' => \Elementor\Controls_Manager::TEXTAREA,
					'default' => esc_html__( 'Upcoming Film Festivals', 'aovis' ),
					'placeholder' => esc_html__( 'Type your title here', 'aovis' ),
					'dynamic' => [
						'active' => true,
					],
				]
			);

			$this->add_control(
				'link',
				[
					'label' => esc_html__( 'Link', 'aovis' ),
					'type' => \Elementor\Controls_Manager::URL,
					'placeholder' => esc_html__( 'https://your-link.com', 'aovis' ),
					'options' => [ 'url', 'is_external', 'nofollow' ],
					'default' => [
						'url' => '',
						'is_external' => false,
						'nofollow' => false,
					],
				]
			);

			$this->add_control(
				'html_tag',
				[
					'label' => esc_html__( 'HTML Tag', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'h3',
					'options' => [
						'h1' => esc_html__( 'H1', 'aovis' ),
						'h2' => esc_html__( 'H2', 'aovis' ),
						'h3' => esc_html__( 'H3', 'aovis' ),
						'h4' => esc_html__( 'H4', 'aovis' ),
						'h5' => esc_html__( 'H5', 'aovis' ),
						'h6' => esc_html__( 'H6', 'aovis' ),
						'div' => esc_html__( 'div', 'aovis' ),
						'span' => esc_html__( 'span', 'aovis' ),
						'p' => esc_html__( 'p', 'aovis' ),
					],
				]
			);

			$this->add_control(
				'background_image',
				[
					'label' => esc_html__( 'Background Image', 'aovis' ),
					'type' => \Elementor\Controls_Manager::MEDIA,
					'default' => [
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					],
					'separator' => 'before',
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

			$this->add_responsive_control(
				'general_padding',
				[
					'label' => esc_html__( 'Padding', 'aovis' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .ova-icon-box ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'general_margin',
				[
					'label' => esc_html__( 'Margin', 'aovis' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .ova-icon-box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'general_border',
					'selector' => '{{WRAPPER}} .ova-icon-box',
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'general_box_shadow',
					'selector' => '{{WRAPPER}} .ova-icon-box',
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'background_section',
			[
				'label' => esc_html__( 'Background', 'aovis' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'background_color',
				[
					'label' => esc_html__( 'Color', 'aovis' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-icon-box .overlay' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_responsive_control(
				'background_opacity',
				[
					'label' => esc_html__( 'Opacity', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1,
							'step' => 0.01,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .ova-icon-box .background' => 'opacity: {{SIZE}};',
					],
				]
			);

			$this->add_control(
				'background_blend_mode',
				[
					'label' => esc_html__( 'Blend Mode', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'luminosity',
					'options' => [
						'normal' => esc_html__( 'Normal', 'aovis' ),
						'multiply' => esc_html__( 'Multiply', 'aovis' ),
						'screen' => esc_html__( 'Screen', 'aovis' ),
						'overlay' => esc_html__( 'Overlay', 'aovis' ),
						'darken' => esc_html__( 'Darken', 'aovis' ),
						'lighten' => esc_html__( 'Lighten', 'aovis' ),
						'color-dodge' => esc_html__( 'Color-dodge', 'aovis' ),
						'color-burn' => esc_html__( 'Color-burn', 'aovis' ),
						'difference' => esc_html__( 'Difference', 'aovis' ),
						'exclusion' => esc_html__( 'Exclusion', 'aovis' ),
						'hue' => esc_html__( 'Hue', 'aovis' ),
						'saturation' => esc_html__( 'Saturation', 'aovis' ),
						'color' => esc_html__( 'Color', 'aovis' ),
						'luminosity' => esc_html__( 'Luminosity', 'aovis' ),
					],
					'selectors' => [
						'{{WRAPPER}} .ova-icon-box.template2 .background' => 'mix-blend-mode: {{VALUE}};',
					],
					'condition' => [
						'template' => 'template2',
					],
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'wrap_icon_section',
			[
				'label' => esc_html__( 'Wrap Icon', 'aovis' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_responsive_control(
				'icon_margin',
				[
					'label' => esc_html__( 'Margin', 'aovis' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .ova-icon-box .icon ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'icon_border',
					'selector' => '{{WRAPPER}} .ova-icon-box .icon',
					'condition' => [
						'template' => 'template1',
					],
				]
			);

			$this->add_control(
				'more_options',
				[
					'label' => esc_html__( 'Icon', 'aovis' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_responsive_control(
				'icon_size',
				[
					'label' => esc_html__( 'Size', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%' ],
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
						'{{WRAPPER}} .ova-icon-box .icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'icon_color',
				[
					'label' => esc_html__( 'Color', 'aovis' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-icon-box .icon i' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'icon_color_hover',
				[
					'label' => esc_html__( 'Color Hover', 'aovis' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-icon-box:hover .icon i' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'icon_background_heading',
				[
					'label' => esc_html__( 'Background', 'aovis' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_responsive_control(
				'icon_background_size',
				[
					'label' => esc_html__( 'Size', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%' ],
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
						'{{WRAPPER}} .ova-icon-box .icon ' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'icon_background_color',
				[
					'label' => esc_html__( 'Color', 'aovis' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-icon-box .icon ' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'icon_background_color_hover',
				[
					'label' => esc_html__( 'Color Hover', 'aovis' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-icon-box:hover .icon ' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_responsive_control(
				'icon_background_border_radius',
				[
					'label' => esc_html__( 'Border Radius', 'aovis' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .ova-icon-box .icon ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			
			$this->add_control(
				'border_heading',
				[
					'label' => esc_html__( 'Border', 'aovis' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'template' => 'template2',
					],
				]
			);

				$this->add_group_control(
					\Elementor\Group_Control_Border::get_type(),
					[
						'name' => 'border',
						'selector' => '{{WRAPPER}} .ova-icon-box.template2 .icon:after',
						'condition' => [
							'template' => 'template2',
						],
					]
				);

				$this->add_responsive_control(
					'icon_border_size',
					[
						'label' => esc_html__( 'Border Size', 'aovis' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'size_units' => [ 'px', '%' ],
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
							'{{WRAPPER}} .ova-icon-box.template2 .icon:after' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
						],
						'condition' => [
							'template' => 'template2',
						],
					]
				);

				$this->add_responsive_control(
					'icon_border_size_hover',
					[
						'label' => esc_html__( 'Border Size Hover', 'aovis' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'size_units' => [ 'px', '%' ],
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
							'{{WRAPPER}} .ova-icon-box.template2:hover .icon:after' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
						],
						'condition' => [
							'template' => 'template2',
						],
					]
				);

				$this->add_responsive_control(
					'border_border_radius',
					[
						'label' => esc_html__( 'Border Radius', 'aovis' ),
						'type' => \Elementor\Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em' ],
						'selectors' => [
							'{{WRAPPER}} .ova-icon-box.template2 .icon:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
						'condition' => [
							'template' => 'template2',
						],
					]
				);
			
		$this->end_controls_section();

		$this->start_controls_section(
			'sub_title_section',
			[
				'label' => esc_html__( 'Sub Title', 'aovis' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'template' => 'template1',
				],
			]
		);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'sub_title_typography',
					'selector' => '{{WRAPPER}} .ova-icon-box .sub-title',
				]
			);

			$this->add_control(
				'sub_title_color',
				[
					'label' => esc_html__( 'Color', 'aovis' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-icon-box .sub-title' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_responsive_control(
				'sub_title_margin',
				[
					'label' => esc_html__( 'Margin', 'aovis' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .ova-icon-box .sub-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'title_section',
			[
				'label' => esc_html__( 'Title', 'aovis' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'title_typography',
					'selector' => '{{WRAPPER}} .ova-icon-box .title',
				]
			);

			$this->add_control(
				'title_color',
				[
					'label' => esc_html__( 'Color', 'aovis' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-icon-box .title, {{WRAPPER}} .ova-icon-box a .title' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'link_color_hover',
				[
					'label' => esc_html__( 'Color Hover', 'aovis' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-icon-box a:hover .title, {{WRAPPER}} .ova-icon-box .title:hover' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_responsive_control(
				'title_margin',
				[
					'label' => esc_html__( 'Margin', 'aovis' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .ova-icon-box .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

		$this->end_controls_section();
	}

	// Render Template Here
	protected function render() {
		$settings = $this->get_settings();

		$template 			=  	$settings['template'];
		$icon 				= 	$settings['icon'];
		$sub_title 			= 	$settings['sub_title'];
		$title 				= 	$settings['title'];
		$html_tag 			= 	$settings['html_tag'];
		$link             	=   $settings['link']; 
		$nofollow      		= 	( isset( $link['nofollow'] ) && $link['nofollow'] ) ? 'rel=nofollow' : '';
		$target           	=   ( isset( $link['is_external'] ) && $link['is_external'] == 'on' ) ? '_blank' : '_self';	

		$background_image 	= 	$settings['background_image'];

		?>

		

			<div class="ova-icon-box <?php echo esc_attr( $template ); ?> ">

				<div class="background" style="background-image: url(<?php echo esc_attr( $background_image['url'] ); ?>);" ></div>
				<div class="overlay"></div>

				<div class="content">

					<?php if( !empty($sub_title) && $template == 'template1' ) { ?>
						<p class="sub-title"><?php echo esc_html( $sub_title ); ?></p> 
					<?php } ?>

					<?php if( !empty( $link['url'] ) ) { ?>
						<a href="<?php echo esc_attr( $link['url'] ); ?>" target="<?php echo esc_attr( $target ); ?>" <?php echo esc_attr( $nofollow ); ?> >
					<?php } ?>

					<?php if( !empty($title) ) { ?>
						<<?php echo esc_html( $html_tag ); ?> class="title"><?php echo esc_html( $title ); ?></<?php echo esc_html( $html_tag ); ?>>
					<?php } ?>

					<?php if( !empty( $link['url'] ) ) { ?>
						</a>
					<?php } ?>

				</div>

				<?php if( !empty($icon) ) { ?>
					<span class="icon">
						<?php \Elementor\Icons_Manager::render_icon( $icon , [ 'aria-hidden' => 'true' ] ); ?>	
					</span> 
				<?php } ?>	

			</div>		
		
		<?php
	}
}
$widgets_manager->register( new Aovis_Elementor_Icon_Box() );