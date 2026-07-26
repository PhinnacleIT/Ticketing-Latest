<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Aovis_Elementor_Our_Team extends Widget_Base {

	public function get_name() {
		return 'aovis_elementor_our_team';
	}

	public function get_title() {
		return esc_html__( 'Our Team', 'aovis' );
	}

	public function get_icon() {
		return ' eicon-person';
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
			'section_content',
			[
				'label' => esc_html__( 'Content', 'aovis' ),
			]
		);	
			
			// Add Class control
			$this->add_control(
				'image',
				[
					'label' => esc_html__( 'Choose Image', 'aovis' ),
					'type' => \Elementor\Controls_Manager::MEDIA,
					'default' => [
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					],
				]
			);

			$this->add_control(
				'name',
				[
					'label' => esc_html__( 'Name', 'aovis' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'Kevin Martin', 'aovis' ),
					'placeholder' => esc_html__( 'Type name here', 'aovis' ),
				]
			);

			$this->add_control(
				'link',
				[
					'label' => esc_html__( 'Link', 'aovis' ),
					'type' => \Elementor\Controls_Manager::URL,
					'placeholder' => esc_html__( 'https://your-link.com', 'aovis' ),
					'options' => [ 'url', 'is_external', 'nofollow' ],
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
				'job',
				[
					'label' => esc_html__( 'Job', 'aovis' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'Film Director', 'aovis' ),
					'placeholder' => esc_html__( 'Type job here', 'aovis' ),
				]
			);

			$repeater = new \Elementor\Repeater();

			$repeater->add_control(
				'icon',
				[
					'label' => esc_html__( 'Icon', 'aovis' ),
					'type' => \Elementor\Controls_Manager::ICONS,
					'default' => [
						'value' => 'fab fa-twitter',
						'library' => 'all',
					],
				]
			);

			$repeater->add_control(
				'social_link',
				[
					'label' => esc_html__( 'Link', 'aovis' ),
					'type' => \Elementor\Controls_Manager::URL,
					'placeholder' => esc_html__( 'https://your-link.com', 'aovis' ),
					'options' => [ 'url', 'is_external', 'nofollow' ],
					'default' => [
						'url' => '#',
						'is_external' => true,
						'nofollow' => false,
					],
				]
			);

			$this->add_control(
				'list_icon',
				[
					'label' => esc_html__( 'Icon List', 'aovis' ),
					'type' => \Elementor\Controls_Manager::REPEATER,
					'fields' => $repeater->get_controls(),
					'default' => [
						[
							'icon' => [
								'value' => 'fab fa-twitter',
								'library' => 'all',
							],
							'social_link' => [
								'url' => "https://twitter.com/",
							],
						],
						[
							'icon' => [
								'value' => 'fab fa-facebook',
								'library' => 'all',
							],
							'social_link' => [
								'url' => "https://www.facebook.com/",
							],
						],
						[
							'icon' => [
								'value' => 'fab fa-instagram',
								'library' => 'all',
							],
							'social_link' => [
								'url' => "https://www.instagram.com/",
							],
						],
					],
				]
			);

			$this->add_control(
				'background',
				[
					'label' => esc_html__( 'Background', 'aovis' ),
					'type' => \Elementor\Controls_Manager::MEDIA,
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
				'wrap_image_heading',
				[
					'label' => esc_html__( 'Wrap Image', 'aovis' ),
					'type' => \Elementor\Controls_Manager::HEADING,
				]
			);

			$this->add_control(
				'wrap_image_padding',
				[
					'label' => esc_html__( 'Padding', 'aovis' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .ova-our-team .author-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'wrap_image_margin',
				[
					'label' => esc_html__( 'Margin', 'aovis' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .ova-our-team .author-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'line_decoration_heading',
				[
					'label' => esc_html__( 'Line Decoration', 'aovis' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->start_controls_tabs(
			'line_decoration_tabs'
			);

				$this->start_controls_tab(
					'line_decoration_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'aovis' ),
					]
				);

					$this->add_control(
						'line_decoration_width',
						[
							'label' => esc_html__( 'Width', 'aovis' ),
							'type' => \Elementor\Controls_Manager::SLIDER,
							'size_units' => [ 'px', '%', 'em', 'rem' ],
							'range' => [
								'px' => [
									'min' => 0,
									'max' => 500,
									'step' => 1,
								],
								'%' => [
									'min' => 0,
									'max' => 100,
								],
							],
							'selectors' => [
								'{{WRAPPER}} .ova-our-team .author-image:after' => 'width: {{SIZE}}{{UNIT}};',
							],
						]
					);

					$this->add_control(
						'line_decoration_height',
						[
							'label' => esc_html__( 'Height', 'aovis' ),
							'type' => \Elementor\Controls_Manager::SLIDER,
							'size_units' => [ 'px', '%', 'em', 'rem' ],
							'range' => [
								'px' => [
									'min' => 0,
									'max' => 500,
									'step' => 1,
								],
								'%' => [
									'min' => 0,
									'max' => 100,
								],
							],
							'selectors' => [
								'{{WRAPPER}} .ova-our-team .author-image:before' => 'height: {{SIZE}}{{UNIT}};',
							],
						]
					);

					$this->add_control(
						'line_decoration_weight',
						[
							'label' => esc_html__( 'Weight', 'aovis' ),
							'type' => \Elementor\Controls_Manager::SLIDER,
							'size_units' => [ 'px', '%', 'em', 'rem' ],
							'range' => [
								'px' => [
									'min' => 0,
									'max' => 500,
									'step' => 1,
								],
								'%' => [
									'min' => 0,
									'max' => 100,
								],
							],
							'selectors' => [
								'{{WRAPPER}} .ova-our-team .author-image:before' => 'width: {{SIZE}}{{UNIT}};',
								'{{WRAPPER}} .ova-our-team .author-image:after' => 'height: {{SIZE}}{{UNIT}};',
							],
						]
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'line_decoration_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'aovis' ),
					]
				);

					$this->add_control(
						'line_decoration_width_hover',
						[
							'label' => esc_html__( 'Width', 'aovis' ),
							'type' => \Elementor\Controls_Manager::SLIDER,
							'size_units' => [ 'px', '%', 'em', 'rem' ],
							'range' => [
								'px' => [
									'min' => 0,
									'max' => 500,
									'step' => 1,
								],
								'%' => [
									'min' => 0,
									'max' => 100,
								],
							],
							'selectors' => [
								'{{WRAPPER}} .ova-our-team:hover .author-image:after' => 'width: {{SIZE}}{{UNIT}};',
							],
						]
					);

					$this->add_control(
						'line_decoration_height_hover',
						[
							'label' => esc_html__( 'Height', 'aovis' ),
							'type' => \Elementor\Controls_Manager::SLIDER,
							'size_units' => [ 'px', '%', 'em', 'rem' ],
							'range' => [
								'px' => [
									'min' => 0,
									'max' => 500,
									'step' => 1,
								],
								'%' => [
									'min' => 0,
									'max' => 100,
								],
							],
							'selectors' => [
								'{{WRAPPER}} .ova-our-team:hover .author-image:before' => 'height: {{SIZE}}{{UNIT}};',
							],
						]
					);

					$this->add_control(
						'line_decoration_weight_hover',
						[
							'label' => esc_html__( 'Weight', 'aovis' ),
							'type' => \Elementor\Controls_Manager::SLIDER,
							'size_units' => [ 'px', '%', 'em', 'rem' ],
							'range' => [
								'px' => [
									'min' => 0,
									'max' => 500,
									'step' => 1,
								],
								'%' => [
									'min' => 0,
									'max' => 100,
								],
							],
							'selectors' => [
								'{{WRAPPER}} .ova-our-team:hover .author-image:before' => 'width: {{SIZE}}{{UNIT}};',
								'{{WRAPPER}} .ova-our-team:hover .author-image:after' => 'height: {{SIZE}}{{UNIT}};',
							],
						]
					);

				$this->end_controls_tab();

		$this->end_controls_tabs();

			

		$this->end_controls_section();

		$this->start_controls_section(
			'image_section',
			[
				'label' => esc_html__( 'Image', 'aovis' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

			$this->start_controls_tabs(
			'image_tabs'
			);

				$this->start_controls_tab(
					'image_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'aovis' ),
					]
				);

					$this->add_group_control(
						\Elementor\Group_Control_Css_Filter::get_type(),
						[
							'name' => 'filters_image',
							'selector' => '{{WRAPPER}} .ova-our-team .author-image .author',
						]
					);

					$this->add_group_control(
						\Elementor\Group_Control_Border::get_type(),
						[
							'name' => 'border_image',
							'selector' => '{{WRAPPER}} .ova-our-team .author-image .author',
						]
					);

					$this->add_group_control(
						\Elementor\Group_Control_Box_Shadow::get_type(),
						[
							'name' => 'box_shadow_image',
							'selector' => '{{WRAPPER}} .ova-our-team .author-image .author',
						]
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'image_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'aovis' ),
					]
				);

					$this->add_group_control(
						\Elementor\Group_Control_Css_Filter::get_type(),
						[
							'name' => 'filters_image_hover',
							'selector' => '{{WRAPPER}} .ova-our-team:hover .author-image .author',
						]
					);

					$this->add_group_control(
						\Elementor\Group_Control_Border::get_type(),
						[
							'name' => 'border_image_hover',
							'selector' => '{{WRAPPER}} .ova-our-team:hover .author-image .author',
						]
					);

					$this->add_group_control(
						\Elementor\Group_Control_Box_Shadow::get_type(),
						[
							'name' => 'box_shadow_image_hover',
							'selector' => '{{WRAPPER}} .ova-our-team:hover .author-image .author',
						]
					);

				$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();


		$this->start_controls_section(
			'name_section',
			[
				'label' => esc_html__( 'Name', 'aovis' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'name_typography',
					'selector' => '{{WRAPPER}} .ova-our-team .author-info .name-job .name',
				]
			);

			$this->add_control(
				'name_color',
				[
					'label' => esc_html__( 'Color', 'aovis' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-our-team .author-info .name-job .name' => 'color: {{VALUE}}',
					],
					'condition' => [
						'link[url]' => '',
					],
				]
			);

			$this->add_control(
				'link_name_color',
				[
					'label' => esc_html__( 'Color', 'aovis' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-our-team .author-info .name-job a .name' => 'color: {{VALUE}}',
					],
					'condition' => [
						'link[url]!' => '',
					],
				]
			);

			$this->add_control(
				'link_name_color_hover',
				[
					'label' => esc_html__( 'Color Hover', 'aovis' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-our-team .author-info .name-job a:hover .name' => 'color: {{VALUE}}',
					],
					'condition' => [
						'link[url]!' => '',
					],
				]
			);

			$this->add_control(
				'name_margin',
				[
					'label' => esc_html__( 'Margin', 'aovis' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .ova-our-team .author-info .name-job .name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'job_section',
			[
				'label' => esc_html__( 'Job', 'aovis' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'job_typography',
					'selector' => '{{WRAPPER}} .ova-our-team .author-info .name-job .job',
				]
			);

			$this->add_control(
				'job_color',
				[
					'label' => esc_html__( 'Color', 'aovis' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-our-team .author-info .name-job .job' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'job_margin',
				[
					'label' => esc_html__( 'Margin', 'aovis' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .ova-our-team .author-info .name-job .job' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'social_icon_section',
			[
				'label' => esc_html__( 'Social Icon', 'aovis' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'social_icon_margin',
				[
					'label' => esc_html__( 'Margin', 'aovis' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em'],
					'selectors' => [
						'{{WRAPPER}} .ova-our-team .author-info .socials' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'icon_option',
				[
					'label' => esc_html__( 'Icon', 'aovis' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_control(
				'icon_size',
				[
					'label' => esc_html__( 'Size', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%'],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
							'step' => 5,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .ova-our-team .author-info .socials .icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'icon_color',
				[
					'label' => esc_html__( 'Color', 'aovis' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-our-team .author-info .socials .icon i' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'icon_color_hover',
				[
					'label' => esc_html__( 'Color Hover', 'aovis' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-our-team .author-info .socials .icon:hover i' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'background_icon_option',
				[
					'label' => esc_html__( 'Background', 'aovis' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_control(
				'background_icon_size',
				[
					'label' => esc_html__( 'Size', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%'],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
							'step' => 5,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .ova-our-team .author-info .socials .icon' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'background_icon_color',
				[
					'label' => esc_html__( 'Background Color', 'aovis' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-our-team .author-info .socials .icon' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'background_icon_border_radius',
				[
					'label' => esc_html__( 'Border Radius', 'aovis' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em', 'rem'],
					'selectors' => [
						'{{WRAPPER}} .ova-our-team .author-info .socials .icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

		$this->end_controls_section();
	}

	// Render Template Here
	protected function render() {
		$settings = $this->get_settings();

		$image 					= 	$settings['image'];
		$background 			= 	$settings['background'];
		$name 					= 	$settings['name'];
		$img_alt 				= 	isset($image['alt']) ? $image['alt'] : $name;
		$link 					= 	$settings['link'];
		$nofollow      			= 	( isset( $link['nofollow'] ) && $link['nofollow'] ) ? 'rel=nofollow' : '';
		$target           		=   ( isset( $link['is_external'] ) && $link['is_external'] == 'on' ) ? '_blank' : '_self';
		$tag 					= 	$settings['html_tag'];
		$job 					= 	$settings['job'];
		
		?>
		<div class="ova-our-team">

			<div class="author-image">

				<div class="background" 
					style="background-image: url(<?php echo esc_attr( $background['url'] ); ?>);" 
				>	
				</div>

				<?php if( !empty( $link['url'] )) : ?>
					<a href="<?php echo esc_attr( $link['url'] ); ?>"  target="<?php echo esc_attr( $target ); ?>"  <?php echo esc_html( $nofollow ); ?>>
				<?php endif; ?>	

					<img class="author" src="<?php echo esc_attr( $image['url'] ); ?>" alt="<?php echo esc_attr( $img_alt ); ?>">

				<?php if( !empty( $link['url'] )) : ?>
					</a>
				<?php endif; ?>

			</div>
			
			<div class="author-info">
				
				<div class="name-job">

					<?php if( !empty( $name )) : ?>

						<?php if( !empty( $link['url'] )) : ?>
							<a href="<?php echo esc_attr( $link['url'] ); ?>"  target="<?php echo esc_attr( $target ); ?>"  <?php echo esc_html( $nofollow ); ?>>
						<?php endif; ?>	

							<<?php echo esc_html( $tag ); ?> class="name" >

								<?php echo esc_html( $name ); ?>

							</<?php echo esc_html( $tag ); ?>>

						<?php if( !empty( $link['url'] )) : ?>
							</a>
						<?php endif; ?>

					<?php endif; ?>


					<?php if( !empty( $job )) : ?>
						<p class="job">
							<?php echo esc_html( $job ); ?>
						</p>
					<?php endif; ?> 

				</div>

				<div class="socials">

					<?php  foreach (  $settings['list_icon'] as $item ) { 

						$icon = $item['icon'];

						$social_link 			= 	$item['social_link'];
						$social_nofollow      	= 	( isset( $social_link['nofollow'] ) && $social_link['nofollow'] ) ? 'rel=nofollow' : '';
						$social_target          =   ( isset( $social_link['is_external'] ) && $social_link['is_external'] == 'on' ) ? '_blank' : '';
					?>

					<span class="<?php echo esc_attr( 'elementor-repeater-item-' . $item['_id'] ); ?>">

						<?php if( !empty( $social_link['url'] )) : ?>

							<a class="icon" href="<?php echo esc_attr( $social_link['url'] ); ?>"   target="<?php echo esc_attr( $social_target ); ?>"  
								<?php echo esc_html( $social_nofollow ); ?>>

								<i class="<?php echo esc_attr( $icon['value'] ); ?>"></i>

							</a>

						<?php endif; ?>

					</span>

					<?php } ?>

				</div>

			</div>

		</div>
		<?php
	}
}
$widgets_manager->register( new Aovis_Elementor_Our_Team() );