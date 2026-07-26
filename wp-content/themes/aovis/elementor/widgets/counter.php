<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Border;

/**
 * Elementor counter widget.
 *
 * Elementor widget that displays stats and numbers in an escalating manner.
 *
 * @since 1.0.0
 */
class Aovis_Elementor_Counter extends Widget_Counter {

	/**
	 * Register counter widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 3.1.0
	 * @access protected
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'section_counter',
			[
				'label' => esc_html__( 'Counter', 'aovis' ),
			]
		);

		$this->add_control(
			'starting_number',
			[
				'label' 	=> esc_html__( 'Starting Number', 'aovis' ),
				'type' 		=> Controls_Manager::NUMBER,
				'default' 	=> 0,
				'dynamic' 	=> [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'ending_number',
			[
				'label' 	=> esc_html__( 'Ending Number', 'aovis' ),
				'type' 		=> Controls_Manager::NUMBER,
				'default' 	=> 100,
				'dynamic' 	=> [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'prefix',
			[
				'label' 	=> esc_html__( 'Number Prefix', 'aovis' ),
				'type' 		=> Controls_Manager::TEXT,
				'dynamic' 	=> [
					'active' => true,
				],
				'default' => '',
				'placeholder' => 1,
			]
		);

		$this->add_control(
			'suffix',
			[
				'label' 	=> esc_html__( 'Number Suffix', 'aovis' ),
				'type' 		=> Controls_Manager::TEXT,
				'dynamic' 	=> [
					'active' => true,
				],
				'default' 	=> '',
				'placeholder' => esc_html__( 'Plus', 'aovis' ),
			]
		);

		$this->add_control(
			'behind',
			[
				'label' 	=> esc_html__( 'Number behind', 'aovis' ),
				'type' 		=> Controls_Manager::TEXT,
				'dynamic' 	=> [
					'active' => false,
				],
				'default' 	=> '',
				'placeholder' => esc_html__( '01', 'aovis' ),
			]
		);

		$this->add_control(
			'duration',
			[
				'label' 	=> esc_html__( 'Animation Duration', 'aovis' ),
				'type' 		=> Controls_Manager::NUMBER,
				'default' 	=> 2000,
				'min' 		=> 100,
				'step' 		=> 100,
			]
		);

		$this->add_control(
			'thousand_separator',
			[
				'label' 	=> esc_html__( 'Thousand Separator', 'aovis' ),
				'type' 		=> Controls_Manager::SWITCHER,
				'default' 	=> 'yes',
				'label_on' 	=> esc_html__( 'Show', 'aovis' ),
				'label_off' => esc_html__( 'Hide', 'aovis' ),
			]
		);

		$this->add_control(
			'thousand_separator_char',
			[
				'label' 	=> esc_html__( 'Separator', 'aovis' ),
				'type' 		=> Controls_Manager::SELECT,
				'condition' => [
					'thousand_separator' => 'yes',
				],
				'options' => [
					'' 	=> 'Default',
					'.' => 'Dot',
					' ' => 'Space',
				],
			]
		);

		$this->add_control(
			'title',
			[
				'label' 		=> esc_html__( 'Title', 'aovis' ),
				'type' 			=> Controls_Manager::TEXT,
				'label_block' 	=> true,
				'dynamic' 		=> [
					'active' => true,
				],
				'default' 		=> esc_html__( 'Cool Number', 'aovis' ),
				'placeholder' 	=> esc_html__( 'Cool Number', 'aovis' ),
			]
		);

		$this->add_control(
			'view',
			[
				'label' 	=> esc_html__( 'View', 'aovis' ),
				'type' 		=> Controls_Manager::HIDDEN,
				'default' 	=> 'traditional',
			]
		);

		// Add Icon/Image
		$this->add_control(
            'counter_media',
            [
                'label' 	=> esc_html__( 'Icon/Image', 'aovis' ),
                'type' 		=> Controls_Manager::CHOOSE,
                'options' 	=> [
                    'none' => [
                        'title' => esc_html__( 'None', 'aovis' ),
                        'icon' 	=> 'eicon-ban',
                    ],
                    'icon' => [
                        'title' => esc_html__( 'Icon', 'aovis' ),
                        'icon' 	=> 'eicon-caret-right',
                    ],
                    'image' => [
                        'title' => esc_html__( 'Image', 'aovis' ),
                        'icon' 	=> 'eicon-image',
                    ],
                ],
                'default'   => 'none',
                'toggle'    => false,
            ]
        );

        $this->add_control(
            'counter_icon',
            [
                'label'     => esc_html__( 'Choose Icon', 'aovis' ),
                'type'      => Controls_Manager::ICONS,
                'condition' => [
                    'counter_media' => 'icon',
                ],
            ]
        );

        $this->add_control(
            'counter_image',
            [
                'label'     => esc_html__( 'Choose Image', 'aovis' ),
                'type'      => Controls_Manager::MEDIA,
                'condition' => [
                    'counter_media' => 'image',
                ],
            ]
        );


		$this->end_controls_section();

		/* Begin Ova Counter Style */
        $this->start_controls_section(
            'section_ova_counter_style',
            [
                'label' => esc_html__( 'Counter', 'aovis' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        	$this->start_controls_tabs(
                'style_ova_counter_tabs'
            );

                $this->start_controls_tab(
                    'ova_counter_normal_tab',
                    [
                        'label' => esc_html__( 'Normal', 'aovis' ),
                    ]
                );

                	$this->add_control(
                        'ova_counter_background_normal',
                        [
                            'label'     => esc_html__( 'Background', 'aovis' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}}.elementor-widget-counter .elementor-counter' => 'background-color: {{VALUE}}',
                            ],
                        ]
                    );

                $this->end_controls_tab();

                $this->start_controls_tab(
                    'ova_counter_hover_tab',
                    [
                        'label' => esc_html__( 'Hover', 'aovis' ),
                    ]
                );

                	$this->add_control(
                        'ova_counter_background_hover',
                        [
                            'label'     => esc_html__( 'Background', 'aovis' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}}.elementor-widget-counter .elementor-counter:hover' => 'background-color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_control(
                        'ova_counter_border_color_hover',
                        [
                            'label'     => esc_html__( 'Border Color', 'aovis' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}}.elementor-widget-counter .elementor-counter:hover' => 'border-color: {{VALUE}}',
                            ],
                        ]
                    );

                $this->end_controls_tab();
            $this->end_controls_tabs();

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name'      => 'ova_counter_border',
                    'label'     => esc_html__( 'Border', 'aovis' ),
                    'selector'  => '{{WRAPPER}}.elementor-widget-counter .elementor-counter',
                ]
            );

            $this->add_responsive_control(
                'ova_counter_border_radius',
                [
                    'label'         => esc_html__( 'Border Radius', 'aovis' ),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', '%', 'em' ],
                    'selectors'     => [
                        '{{WRAPPER}}.elementor-widget-counter .elementor-counter' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'ova_counter_padding',
                [
                    'label'         => esc_html__( 'Padding', 'aovis' ),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', '%', 'em' ],
                    'selectors'     => [
                        '{{WRAPPER}}.elementor-widget-counter .elementor-counter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_controls_section();
        /* End Ova Counter Style */

		$this->start_controls_section(
			'section_number',
			[
				'label' => esc_html__( 'Number', 'aovis' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs(
            'style_counter_number_tabs'
        );

            $this->start_controls_tab(
                'counter_number_normal_tab',
                [
                    'label' => esc_html__( 'Normal', 'aovis' ),
                ]
            );

            	$this->add_control(
					'number_color_normal',
					[
						'label' => esc_html__( 'Color', 'aovis' ),
						'type' => Controls_Manager::COLOR,
						'global' => [
							'default' => Global_Colors::COLOR_PRIMARY,
						],
						'selectors' => [
							'{{WRAPPER}}.elementor-widget-counter .elementor-counter .elementor-counter-number-wrapper' => 'color: {{VALUE}};',
						],
						'separator' => 'after',
					]
				);

            $this->end_controls_tab();

            $this->start_controls_tab(
                'counter_number_hover_tab',
                [
                    'label' => esc_html__( 'Hover', 'aovis' ),
                ]
            );

            	$this->add_control(
					'number_color_hover',
					[
						'label' => esc_html__( 'Color', 'aovis' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}}.elementor-widget-counter .elementor-counter:hover .elementor-counter-number-wrapper' => 'color: {{VALUE}};',
						],
						'separator' => 'after',
					]
				);

            $this->end_controls_tab();
        $this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography_number',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .elementor-counter-number-wrapper',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'number_shadow',
				'selector' => '{{WRAPPER}} .elementor-counter-number-wrapper',
			]
		);

		$this->add_responsive_control(
            'counter_number_margin',
            [
                'label'         => esc_html__( 'Margin', 'aovis' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '{{WRAPPER}}.elementor-widget-counter .elementor-counter .elementor-counter-number-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

    	$this->add_control(
			'underline_style',
			[
				'label' 	=> esc_html__( 'Underline Style', 'aovis' ),
				'type' 		=> Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

			$this->start_controls_tabs(
	            'style_underline_tabs'
	        );

	            $this->start_controls_tab(
	                'underline_normal_tab',
	                [
	                    'label' => esc_html__( 'Normal', 'aovis' ),
	                ]
	            );

	            	$this->add_control(
						'underline_background_normal',
						[
							'label' => esc_html__( 'Background', 'aovis' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}}.elementor-widget-counter .elementor-counter .elementor-counter-number-wrapper:before' => 'background-color: {{VALUE}};',
							],
							'separator' => 'after',
						]
					);

	            $this->end_controls_tab();

	            $this->start_controls_tab(
	                'underline_hover_tab',
	                [
	                    'label' => esc_html__( 'Hover', 'aovis' ),
	                ]
	            );

	            	$this->add_control(
						'underline_background_hover',
						[
							'label' => esc_html__( 'Background', 'aovis' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}}.elementor-widget-counter .elementor-counter:hover .elementor-counter-number-wrapper:before' => 'background-color: {{VALUE}};',
							],
							'separator' => 'after',
						]
					);

	            $this->end_controls_tab();
	        $this->end_controls_tabs();

			$this->add_responsive_control(
				'underlined_width',
				[
					'label' 		=> esc_html__( 'Width', 'aovis' ),
					'type' 			=> Controls_Manager::SLIDER,
					'size_units' 	=> [ 'px', '%', 'vw' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 500,
							'step' => 5,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
						'vw' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}}.elementor-widget-counter .elementor-counter .elementor-counter-number-wrapper:before' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'underlined_height',
				[
					'label' 		=> esc_html__( 'Height', 'aovis' ),
					'type' 			=> Controls_Manager::SLIDER,
					'size_units' 	=> [ 'px', '%', 'vh' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 500,
							'step' => 5,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
						'vh' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}}.elementor-widget-counter .elementor-counter .elementor-counter-number-wrapper:before' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'underlined_bottom',
				[
					'label' 		=> esc_html__( 'Bottom', 'aovis' ),
					'type' 			=> Controls_Manager::SLIDER,
					'size_units' 	=> [ 'px', '%' ],
					'range' => [
						'px' => [
							'min' => -500,
							'max' => 500,
							'step' => 5,
						],
						'%' => [
							'min' => -100,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}}.elementor-widget-counter .elementor-counter .elementor-counter-number-wrapper:before' => 'bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'underlined_left',
				[
					'label' 		=> esc_html__( 'Left', 'aovis' ),
					'type' 			=> Controls_Manager::SLIDER,
					'size_units' 	=> [ 'px', '%' ],
					'range' => [
						'px' => [
							'min' => -500,
							'max' => 500,
							'step' => 5,
						],
						'%' => [
							'min' => -100,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}}.elementor-widget-counter .elementor-counter .elementor-counter-number-wrapper:before' => 'left: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'underlined_margin',
				[
					'label' 		=> esc_html__( 'Margin', 'aovis' ),
					'type' 			=> Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px', '%', 'em' ],
					'selectors' 	=> [
						'{{WRAPPER}}.elementor-widget-counter .elementor-counter .elementor-counter-number-wrapper:before' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_title',
			[
				'label' => esc_html__( 'Title', 'aovis' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs(
            'style_counter_title_tabs'
        );

            $this->start_controls_tab(
                'counter_tile_normal_tab',
                [
                    'label' => esc_html__( 'Normal', 'aovis' ),
                ]
            );

            	$this->add_control(
					'title_color_normal',
					[
						'label' => esc_html__( 'Color', 'aovis' ),
						'type' => Controls_Manager::COLOR,
						'global' => [
							'default' => Global_Colors::COLOR_SECONDARY,
						],
						'selectors' => [
							'{{WRAPPER}}.elementor-widget-counter .elementor-counter .elementor-counter-title' => 'color: {{VALUE}};',
						],
						'separator' => 'after',
					]
				);

            $this->end_controls_tab();

            $this->start_controls_tab(
                'counter_title_hover_tab',
                [
                    'label' => esc_html__( 'Hover', 'aovis' ),
                ]
            );

            	$this->add_control(
					'title_color_hover',
					[
						'label' => esc_html__( 'Color', 'aovis' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}}.elementor-widget-counter .elementor-counter:hover .elementor-counter-title' => 'color: {{VALUE}};',
						],
						'separator' => 'after',
					]
				);

            $this->end_controls_tab();
        $this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography_title',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
				'selector' => '{{WRAPPER}} .elementor-counter-title',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_shadow',
				'selector' => '{{WRAPPER}} .elementor-counter-title',
			]
		);

		$this->add_responsive_control(
            'counter_title_padding',
            [
                'label'         => esc_html__( 'Padding', 'aovis' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '{{WRAPPER}}.elementor-widget-counter .elementor-counter .elementor-counter-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->add_responsive_control(
            'counter_title_margin',
            [
                'label'         => esc_html__( 'Margin', 'aovis' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '{{WRAPPER}}.elementor-widget-counter .elementor-counter .elementor-counter-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->end_controls_section();

		/* Begin Ova Behind Style */
        $this->start_controls_section(
            'section_ova_behind_style',
            [
                'label' 	=> esc_html__( 'Behind', 'aovis' ),
                'tab'   	=> Controls_Manager::TAB_STYLE,
                'condition' => [
                	'behind!' => '',
                ],
            ]
        );

        	$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'typography_behind',
					'selector' => '{{WRAPPER}}.elementor-widget-counter .elementor-counter .ova-counter-behind',
				]
			);

        	$this->start_controls_tabs(
	            'style_ova_behind_tabs'
	        );

	            $this->start_controls_tab(
	                'ova_behind_normal_tab',
	                [
	                    'label' => esc_html__( 'Normal', 'aovis' ),
	                ]
	            );

	            	$this->add_control(
						'ova_behind_color_normal',
						[
							'label' => esc_html__( 'Color', 'aovis' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}}.elementor-widget-counter .elementor-counter .ova-counter-behind' => 'color: {{VALUE}};',
							],
							'separator' => 'after',
						]
					);

	            $this->end_controls_tab();

	            $this->start_controls_tab(
	                'ova_behind_hover_tab',
	                [
	                    'label' => esc_html__( 'Hover', 'aovis' ),
	                ]
	            );

	            	$this->add_control(
						'ova_behind_color_hover',
						[
							'label' => esc_html__( 'Color', 'aovis' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}}.elementor-widget-counter .elementor-counter:hover .ova-counter-behind' => 'color: {{VALUE}};',
							],
							'separator' => 'after',
						]
					);

	            $this->end_controls_tab();
	        $this->end_controls_tabs();

	        $this->add_responsive_control(
				'ova_behind_top',
				[
					'label' 		=> esc_html__( 'Top', 'aovis' ),
					'type' 			=> Controls_Manager::SLIDER,
					'size_units' 	=> [ 'px', '%' ],
					'range' => [
						'px' => [
							'min' => -500,
							'max' => 500,
							'step' => 5,
						],
						'%' => [
							'min' => -100,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}}.elementor-widget-counter .elementor-counter .ova-counter-behind' => 'top: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'ova_behind_left',
				[
					'label' 		=> esc_html__( 'Left', 'aovis' ),
					'type' 			=> Controls_Manager::SLIDER,
					'size_units' 	=> [ 'px', '%' ],
					'range' => [
						'px' => [
							'min' => -500,
							'max' => 500,
							'step' => 5,
						],
						'%' => [
							'min' => -100,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}}.elementor-widget-counter .elementor-counter .ova-counter-behind' => 'left: {{SIZE}}{{UNIT}};',
					],
				]
			);

        $this->end_controls_section();
        /* End Ova Behind Style */
	}

	/**
	 * Render counter widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 2.9.0
	 * @access protected
	 */
	protected function content_template() {
		?>
		<# view.addRenderAttribute( 'counter-title', {
			'class': 'elementor-counter-title'
		} );

		view.addInlineEditingAttributes( 'counter-title' );

		counter_icon = settings.counter_icon.value;
		counter_img = settings.counter_image.url;
		#>
		<div class="elementor-counter">
			<div class="elementor-counter-number-wrapper">

				<# if ( settings.counter_media === 'icon' ){ #>
					<div class="icon">
						<i class="{{ counter_icon }}"></i>
					</div>
				<# } else if ( settings.counter_media === 'image' ){ #>
					<div class="image">
						<img src="{{ counter_img }}" alt="{{ settings.title }}">
					</div>
				<# } #>

				<div class="elementor-counter-number-wrapper">
					<span class="elementor-counter-number-prefix">{{{ settings.prefix }}}</span>
					<span class="elementor-counter-number" data-duration="{{ settings.duration }}" data-to-value="{{ settings.ending_number }}" data-delimiter="{{ settings.thousand_separator ? settings.thousand_separator_char || ',' : '' }}">{{{ settings.starting_number }}}</span>
					<span class="elementor-counter-number-suffix">{{{ settings.suffix }}}</span>
				</div>
			</div>
			<# if ( settings.title ) {
				#><div {{{ view.getRenderAttributeString( 'counter-title' ) }}}>{{{ settings.title }}}</div><#
			} #>
			<# if ( settings.behind ) {
				#><div class="ova-counter-behind">{{{ settings.behind }}}</div><#
			} #>
		</div>
		<?php
	}

	/**
	 * Render counter widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'counter', [
			'class' => 'elementor-counter-number',
			'data-duration' => $settings['duration'],
			'data-to-value' => $settings['ending_number'],
			'data-from-value' => $settings['starting_number'],
		] );

		if ( ! empty( $settings['thousand_separator'] ) ) {
			$delimiter = empty( $settings['thousand_separator_char'] ) ? ',' : $settings['thousand_separator_char'];
			$this->add_render_attribute( 'counter', 'data-delimiter', $delimiter );
		}

		$this->add_render_attribute( 'counter-title', 'class', 'elementor-counter-title' );

		$this->add_inline_editing_attributes( 'counter-title' );
		?>
		<div class="elementor-counter">

			<?php 
				$counter_icon = isset( $settings['counter_icon']['value'] ) ? $settings['counter_icon']['value'] : '';
				$counter_img = isset( $settings['counter_image']['url'] ) ? $settings['counter_image']['url'] : '';
			?>

			<?php  if ( 'icon' === $settings['counter_media'] && $counter_icon ) { ?>

				<div class="icon">
					<i class="<?php echo esc_attr( $counter_icon ); ?>"></i>
				</div>

			<?php }else if ( 'image' === $settings['counter_media'] && $counter_img ) { ?>
				<div class="image">
					<img src="<?php echo esc_url( $counter_img ); ?>" alt="<?php $this->print_unescaped_setting( 'title' ); ?>">
				</div>
			<?php } ?>
			
			<div class="elementor-counter-number-wrapper">
				<span class="elementor-counter-number-prefix"><?php $this->print_unescaped_setting( 'prefix' ); ?></span>
				<span <?php $this->print_render_attribute_string( 'counter' ); ?>><?php $this->print_unescaped_setting( 'starting_number' ); ?></span>
				<span class="elementor-counter-number-suffix"><?php $this->print_unescaped_setting( 'suffix' ); ?></span>
			</div>

			<?php if ( $settings['title'] ) : ?>
				<div <?php $this->print_render_attribute_string( 'counter-title' ); ?>><?php $this->print_unescaped_setting( 'title' ); ?></div>
			<?php endif; ?>

			<?php if ( $settings['behind'] ): ?>
				<div class="ova-counter-behind"><?php echo esc_html( $settings['behind'] ); ?></div>
			<?php endif; ?>
		</div>
		<?php
	}
}
$widgets_manager->register(new Aovis_Elementor_Counter());
