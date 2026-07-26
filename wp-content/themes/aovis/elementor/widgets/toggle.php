<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 * Elementor toggle widget.
 *
 * Elementor widget that displays a collapsible display of content in an toggle
 * style, allowing the user to open multiple items.
 *
 * @since 1.0.0
 */
class Aovis_Elementor_Toggle extends Widget_Toggle {

	/**
	 * Register toggle widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 3.1.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_toggle',
			[
				'label' => esc_html__( 'Toggle', 'aovis' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'tab_title',
			[
				'label' => esc_html__( 'Title & Description', 'aovis' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Toggle Title', 'aovis' ),
				'label_block' => true,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'tab_content',
			[
				'label' => esc_html__( 'Content', 'aovis' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'Toggle Content', 'aovis' ),
				'show_label' => false,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'tabs',
			[
				'label' => esc_html__( 'Toggle Items', 'aovis' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'tab_title' => esc_html__( 'Toggle #1', 'aovis' ),
						'tab_content' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'aovis' ),
					],
					[
						'tab_title' => esc_html__( 'Toggle #2', 'aovis' ),
						'tab_content' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'aovis' ),
					],
				],
				'title_field' => '{{{ tab_title }}}',
			]
		);

		$this->add_control(
			'view',
			[
				'label' => esc_html__( 'View', 'aovis' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);

		$this->add_control(
			'selected_icon',
			[
				'label' => esc_html__( 'Icon', 'aovis' ),
				'type' => Controls_Manager::ICONS,
				'separator' => 'before',
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fas fa-caret' . ( is_rtl() ? '-left' : '-right' ),
					'library' => 'fa-solid',
				],
				'recommended' => [
					'fa-solid' => [
						'chevron-down',
						'angle-down',
						'angle-double-down',
						'caret-down',
						'caret-square-down',
					],
					'fa-regular' => [
						'caret-square-down',
					],
				],
				'label_block' => false,
				'skin' => 'inline',
			]
		);

		$this->add_control(
			'selected_active_icon',
			[
				'label' => esc_html__( 'Active Icon', 'aovis' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon_active',
				'default' => [
					'value' => 'fas fa-caret-up',
					'library' => 'fa-solid',
				],
				'recommended' => [
					'fa-solid' => [
						'chevron-up',
						'angle-up',
						'angle-double-up',
						'caret-up',
						'caret-square-up',
					],
					'fa-regular' => [
						'caret-square-up',
					],
				],
				'skin' => 'inline',
				'label_block' => false,
				'condition' => [
					'selected_icon[value]!' => '',
				],
			]
		);

		$this->add_control(
			'title_html_tag',
			[
				'label' => esc_html__( 'Title HTML Tag', 'aovis' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
				],
				'default' => 'div',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'faq_schema',
			[
				'label' => esc_html__( 'FAQ Schema', 'aovis' ),
				'type' => Controls_Manager::SWITCHER,
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_toggle_style',
			[
				'label' => esc_html__( 'Toggle', 'aovis' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'border_width',
			[
				'label' => esc_html__( 'Border Width', 'aovis' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-tab-title' => 'border-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elementor-tab-content' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'border_color',
			[
				'label' => esc_html__( 'Border Color', 'aovis' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-tab-content' => 'border-bottom-color: {{VALUE}};',
					'{{WRAPPER}} .elementor-tab-title' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'space_between',
			[
				'label' => esc_html__( 'Space Between', 'aovis' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-toggle-item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'selector' => '{{WRAPPER}} .elementor-toggle-item',
			]
		);

		$this->add_responsive_control(
            'ova_toggle_padding',
            [
                'label'         => esc_html__( 'Padding', 'aovis' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '{{WRAPPER}}.elementor-widget-toggle .elementor-toggle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->add_responsive_control(
            'ova_toggle_margin',
            [
                'label'         => esc_html__( 'Margin', 'aovis' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '{{WRAPPER}}.elementor-widget-toggle .elementor-toggle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->end_controls_section();

		/* Begin Ova Title Style */
        $this->start_controls_section(
            'section_ova_title_style',
            [
                'label' => esc_html__( 'Title', 'aovis' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        	$this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'      => 'ova_title_typography',
                    'selector'  => '{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-title .elementor-toggle-title',
                ]
            );

            $this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				[
					'name' => 'ova_title_shadow',
					'selector' => '{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-title .elementor-toggle-title',
				]
			);

            $this->start_controls_tabs(
                'style_ova_title_tabs'
            );

                $this->start_controls_tab(
                    'ova_title_normal_tab',
                    [
                        'label' => esc_html__( 'Normal', 'aovis' ),
                    ]
                );

                    $this->add_control(
                        'ova_title_color_normal',
                        [
                            'label'     => esc_html__( 'Color', 'aovis' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-title .elementor-toggle-title' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_control(
                        'ova_title_background_normal',
                        [
                            'label'     => esc_html__( 'Background', 'aovis' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-title' => 'background-color: {{VALUE}}',
                            ],
                        ]
                    );

                $this->end_controls_tab();

                $this->start_controls_tab(
                    'ova_title_hover_tab',
                    [
                        'label' => esc_html__( 'Hover', 'aovis' ),
                    ]
                );

                    $this->add_control(
                        'ova_title_color_hover',
                        [
                            'label'     => esc_html__( 'Color', 'aovis' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-title:hover .elementor-toggle-title' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_control(
                        'ova_title_background_hover',
                        [
                            'label'     => esc_html__( 'Background', 'aovis' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-title:hover' => 'background-color: {{VALUE}}',
                            ],
                        ]
                    );

                $this->end_controls_tab();

                $this->start_controls_tab(
                    'ova_title_active_tab',
                    [
                        'label' => esc_html__( 'Active', 'aovis' ),
                    ]
                );

                    $this->add_control(
                        'ova_title_color_active',
                        [
                            'label'     => esc_html__( 'Color', 'aovis' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-title.elementor-active .elementor-toggle-title' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_control(
                        'ova_title_background_active',
                        [
                            'label'     => esc_html__( 'Background', 'aovis' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-title.elementor-active' => 'background-color: {{VALUE}}',
                            ],
                        ]
                    );

                $this->end_controls_tab();
            $this->end_controls_tabs();

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name'      => 'ova_title_border',
                    'label'     => esc_html__( 'Border', 'aovis' ),
                    'selector'  => '{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item:not(:last-child) .elementor-tab-title',
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'ova_title_border_color_hover',
                [
                    'label'     => esc_html__( 'Border Color Hover', 'aovis' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item:not(:last-child) .elementor-tab-title:hover' => 'border-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'ova_title_border_color_active',
                [
                    'label'     => esc_html__( 'Border Color Active', 'aovis' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item:not(:last-child) .elementor-tab-title.elementor-active' => 'border-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_responsive_control(
                'ova_title_border_radius',
                [
                    'label'         => esc_html__( 'Border Radius', 'aovis' ),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', '%', 'em' ],
                    'selectors'     => [
                        '{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'ova_title_border_radius_active',
                [
                    'label'         => esc_html__( 'Border Radius Active', 'aovis' ),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', '%', 'em' ],
                    'selectors'     => [
                        '{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-title.elementor-active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'ova_title_padding',
                [
                    'label'         => esc_html__( 'Padding', 'aovis' ),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', '%', 'em' ],
                    'selectors'     => [
                        '{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'ova_title_margin',
                [
                    'label'         => esc_html__( 'Margin', 'aovis' ),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', '%', 'em' ],
                    'selectors'     => [
                        '{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
				'show_before_title',
				[
					'label' 	=> esc_html__( 'Show Before Title', 'aovis' ),
					'type' 		=> \Elementor\Controls_Manager::SWITCHER,
					'label_on' 	=> esc_html__( 'Show', 'aovis' ),
					'label_off' => esc_html__( 'Hide', 'aovis' ),
					'default' 	=> 'no',
					'separator' => 'before',
				]
			);

            $this->add_control(
                'ova_before_title',
                [
                    'label'     => esc_html__( 'Before Title Style', 'aovis' ),
                    'type'      => \Elementor\Controls_Manager::HEADING,
                    'condition' => [
                    	'show_before_title' => 'yes',
                    ],
                ]
            );

		        $this->start_controls_tabs(
	                'style_ova_before_title_tabs',
	                [
	                	'condition' => [
	                    	'show_before_title' => 'yes',
	                    ],
	                ]
	            );

	                $this->start_controls_tab(
	                    'ova_before_title_normal_tab',
	                    [
	                        'label' => esc_html__( 'Normal', 'aovis' ),
	                    ]
	                );

	                    $this->add_control(
				            'ova_before_title_background_normal',
				            [
				                'label' => esc_html__( 'Background', 'aovis' ),
				                'type' => Controls_Manager::COLOR,
				                'selectors' => [
				                    '{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-title .ova-before-title:before' => 'background-color: {{VALUE}};',
				                ],
				            ]
				        );

	                $this->end_controls_tab();

	                $this->start_controls_tab(
	                    'ova_before_title_hover_tab',
	                    [
	                        'label' => esc_html__( 'Hover', 'aovis' ),
	                    ]
	                );

	                	$this->add_control(
				            'ova_before_title_background_hover',
				            [
				                'label' => esc_html__( 'Background', 'aovis' ),
				                'type' => Controls_Manager::COLOR,
				                'selectors' => [
				                    '{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-title:hover .ova-before-title:before' => 'background-color: {{VALUE}};',
				                ],
				            ]
				        );

	                $this->end_controls_tab();

	                $this->start_controls_tab(
	                    'ova_before_title_active_tab',
	                    [
	                        'label' => esc_html__( 'Active', 'aovis' ),
	                    ]
	                );

	                	$this->add_control(
				            'ova_before_title_background_active',
				            [
				                'label' => esc_html__( 'Background', 'aovis' ),
				                'type' => Controls_Manager::COLOR,
				                'selectors' => [
				                    '{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-title.elementor-active .ova-before-title:before' => 'background-color: {{VALUE}};',
				                ],
				            ]
				        );

	                $this->end_controls_tab();
	            $this->end_controls_tabs();

            	$this->add_responsive_control(
                    'ova_before_title_width',
                    [
                        'label'         => esc_html__( 'Width', 'aovis' ),
                        'type'          => Controls_Manager::SLIDER,
                        'size_units'    => [ 'px', '%', 'vw' ],
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
                            'vw' => [
                                'min' => 0,
                                'max' => 100,
                            ],
                        ],
                        'selectors' => [
                            '{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-title .ova-before-title:before' => 'width: {{SIZE}}{{UNIT}};',
                        ],
                        'condition' => [
	                    	'show_before_title' => 'yes',
	                    ],
                    ]
                );

                $this->add_responsive_control(
                    'ova_before_title_height',
                    [
                        'label'         => esc_html__( 'Height', 'aovis' ),
                        'type'          => Controls_Manager::SLIDER,
                        'size_units'    => [ 'px', '%', 'vh' ],
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
                            'vh' => [
                                'min' => 0,
                                'max' => 100,
                            ],
                        ],
                        'selectors' => [
                            '{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-title .ova-before-title:before' => 'height: {{SIZE}}{{UNIT}};',
                        ],
                        'condition' => [
	                    	'show_before_title' => 'yes',
	                    ],
                    ]
                );

                $this->add_responsive_control(
                    'ova_before_title_top',
                    [
                        'label'         => esc_html__( 'Top', 'aovis' ),
                        'type'          => Controls_Manager::SLIDER,
                        'size_units'    => [ 'px', '%' ],
                        'range' => [
                            'px' => [
                                'min' => -100,
                                'max' => 100,
                                'step' => 5,
                            ],
                            '%' => [
                                'min' => -100,
                                'max' => 100,
                            ],
                        ],
                        'selectors' => [
                            '{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-title .ova-before-title:before' => 'top: {{SIZE}}{{UNIT}};',
                        ],
                        'condition' => [
	                    	'show_before_title' => 'yes',
	                    ],
                    ]
                );

                $this->add_responsive_control(
                    'ova_before_title_left',
                    [
                        'label'         => esc_html__( 'Left', 'aovis' ),
                        'type'          => Controls_Manager::SLIDER,
                        'size_units'    => [ 'px', '%' ],
                        'range' => [
                            'px' => [
                                'min' => -100,
                                'max' => 100,
                                'step' => 5,
                            ],
                            '%' => [
                                'min' => -100,
                                'max' => 100,
                            ],
                        ],
                        'selectors' => [
                            '{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-title .ova-before-title:before' => 'left: {{SIZE}}{{UNIT}};',
                        ],
                        'condition' => [
	                    	'show_before_title' => 'yes',
	                    ],
                    ]
                );

                $this->add_responsive_control(
                    'ova_before_title_margin',
                    [
                        'label'         => esc_html__( 'Margin', 'aovis' ),
                        'type'          => Controls_Manager::DIMENSIONS,
                        'size_units'    => [ 'px', '%', 'em' ],
                        'selectors'     => [
                            '{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-title .ova-before-title:before' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        ],
                        'condition' 	=> [
	                    	'show_before_title' => 'yes',
	                    ],
                    ]
                );

        $this->end_controls_section();
        /* End Ova Title Style */

		$this->start_controls_section(
			'section_toggle_style_icon',
			[
				'label' => esc_html__( 'Icon', 'aovis' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'selected_icon[value]!' => '',
				],
			]
		);

		$this->add_control(
			'icon_align',
			[
				'label' => esc_html__( 'Alignment', 'aovis' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Start', 'aovis' ),
						'icon' => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__( 'End', 'aovis' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => is_rtl() ? 'right' : 'left',
				'toggle' => false,
			]
		);

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'icon_typography',
                'selector'  => '{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-title .elementor-toggle-icon i',
            ]
        );

		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Color', 'aovis' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-tab-title .elementor-toggle-icon i:before' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-tab-title .elementor-toggle-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_hover_color',
			[
				'label' => esc_html__( 'Hover Color', 'aovis' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-tab-title:hover .elementor-toggle-icon i:before' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-tab-title:hover .elementor-toggle-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_active_color',
			[
				'label' => esc_html__( 'Active Color', 'aovis' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-tab-title.elementor-active .elementor-toggle-icon i:before' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-tab-title.elementor-active .elementor-toggle-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_space',
			[
				'label' => esc_html__( 'Spacing', 'aovis' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-toggle-icon.elementor-toggle-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elementor-toggle-icon.elementor-toggle-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
            'icon_padding',
            [
                'label'         => esc_html__( 'Padding', 'aovis' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-title .elementor-toggle-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_margin',
            [
                'label'         => esc_html__( 'Margin', 'aovis' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-title .elementor-toggle-icon i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->add_control(
			'ova_before_icon',
			[
				'label' 	=> esc_html__( 'Before Icon', 'aovis' ),
				'type' 		=> Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

			$this->add_control(
				'ova_icon',
				[
					'label' 	=> esc_html__( 'Icon', 'aovis' ),
					'type' 		=> Controls_Manager::ICONS,
				]
			);

			$this->add_group_control(
	            Group_Control_Typography::get_type(),
	            [
	                'name'      => 'ova_icon_typography',
	                'selector'  => '{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-title .ova-icon i',
	                'condition' => [
	                	'ova_icon[value]!' => '',
	                ],
	            ]
	        );

			$this->add_control(
				'ova_icon_color',
				[
					'label' 	=> esc_html__( 'Color', 'aovis' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-title .ova-icon i' => 'color: {{VALUE}};',
						'{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-title .ova-icon svg' => 'fill: {{VALUE}};',
					],
					'condition' => [
	                	'ova_icon[value]!' => '',
	                ],
				]
			);

			$this->add_control(
				'ova_icon_hover_color',
				[
					'label' 	=> esc_html__( 'Hover Color', 'aovis' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-title:hover .ova-icon i' => 'color: {{VALUE}};',
						'{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-title:hover .ova-icon svg' => 'fill: {{VALUE}};',
					],
					'condition' => [
	                	'ova_icon[value]!' => '',
	                ],
				]
			);

			$this->add_control(
				'ova_icon_active_color',
				[
					'label' 	=> esc_html__( 'Active Color', 'aovis' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-title.elementor-active .ova-icon i' => 'color: {{VALUE}};',
						'{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-title.elementor-active .ova-icon svg' => 'fill: {{VALUE}};',
					],
					'condition' => [
	                	'ova_icon[value]!' => '',
	                ],
				]
			);

			$this->add_responsive_control(
	            'ova_icon_padding',
	            [
	                'label'         => esc_html__( 'Padding', 'aovis' ),
	                'type'          => Controls_Manager::DIMENSIONS,
	                'size_units'    => [ 'px', '%', 'em' ],
	                'selectors'     => [
	                    '{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-title .ova-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	                'condition' 	=> [
	                	'ova_icon[value]!' => '',
	                ],
	            ]
	        );

	        $this->add_responsive_control(
	            'ova_icon_margin',
	            [
	                'label'         => esc_html__( 'Margin', 'aovis' ),
	                'type'          => Controls_Manager::DIMENSIONS,
	                'size_units'	=> [ 'px', '%', 'em' ],
	                'selectors'     => [
	                    '{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-title .ova-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	                'condition' 	=> [
	                	'ova_icon[value]!' => '',
	                ],
	            ]
	        );

	        $this->add_control(
				'show_boxes_icon',
				[
					'label' 	=> esc_html__( 'Show Border Icon', 'aovis' ),
					'type' 		=> \Elementor\Controls_Manager::SWITCHER,
					'label_on' 	=> esc_html__( 'Show', 'aovis' ),
					'label_off' => esc_html__( 'Hide', 'aovis' ),
					'default' 	=> 'no',
					'separator' => 'before',
				]
			);

				$this->add_responsive_control(
					'boxes_icon_width',
					[
						'label' => esc_html__( 'Width', 'aovis' ),
						'type' => Controls_Manager::SLIDER,
						'range' => [
							'px' => [
								'min' => 0,
								'max' => 100,
							],
						],
						'selectors' => [
							'.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-title .ova-boxes-icon' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
						],
						'condition' => [
							'show_boxes_icon' => 'yes',
						],
					]
				);

				$this->start_controls_tabs(
	                'style_boxes_icon_tabs',
	                [
	                	'condition' => [
							'show_boxes_icon' => 'yes',
						],
	                ]
	            );

	                $this->start_controls_tab(
	                    'boxes_icon_normal_tab',
	                    [
	                        'label' => esc_html__( 'Normal', 'aovis' ),
	                    ]
	                );

	                    $this->add_control(
	                        'boxes_icon_background_normal',
	                        [
	                            'label'     => esc_html__( 'Background', 'aovis' ),
	                            'type'      => Controls_Manager::COLOR,
	                            'selectors' => [
	                                '{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-title .ova-boxes-icon' => 'background-color: {{VALUE}}',
	                            ],
	                        ]
	                    );

	                $this->end_controls_tab();

	                $this->start_controls_tab(
	                    'boxes_icon_hover_tab',
	                    [
	                        'label' => esc_html__( 'Hover', 'aovis' ),
	                    ]
	                );

	                	$this->add_control(
	                        'boxes_icon_background_hover',
	                        [
	                            'label'     => esc_html__( 'Background', 'aovis' ),
	                            'type'      => Controls_Manager::COLOR,
	                            'selectors' => [
	                                '{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-title:hover .ova-boxes-icon' => 'background-color: {{VALUE}}',
	                            ],
	                        ]
	                    );

	                $this->end_controls_tab();

	                $this->start_controls_tab(
	                    'boxes_icon_active_tab',
	                    [
	                        'label' => esc_html__( 'Active', 'aovis' ),
	                    ]
	                );

	                	$this->add_control(
	                        'boxes_icon_background_active',
	                        [
	                            'label'     => esc_html__( 'Background', 'aovis' ),
	                            'type'      => Controls_Manager::COLOR,
	                            'selectors' => [
	                                '{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-title.elementor-active .ova-boxes-icon' => 'background-color: {{VALUE}}',
	                            ],
	                        ]
	                    );

	                $this->end_controls_tab();
	            $this->end_controls_tabs();

	            $this->add_responsive_control(
	                'boxes_icon_border_radius',
	                [
	                    'label'         => esc_html__( 'Border Radius', 'aovis' ),
	                    'type'          => Controls_Manager::DIMENSIONS,
	                    'size_units'    => [ 'px', '%', 'em' ],
	                    'selectors'     => [
	                        '{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-title .ova-boxes-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                    ],
	                    'condition' 	=> [
							'show_boxes_icon' => 'yes',
						],
	                ]
	            );

	            $this->add_responsive_control(
	                'boxes_icon_margin',
	                [
	                    'label'         => esc_html__( 'Margin', 'aovis' ),
	                    'type'          => Controls_Manager::DIMENSIONS,
	                    'size_units'    => [ 'px', '%', 'em' ],
	                    'selectors'     => [
	                        '{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-title .ova-boxes-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                    ],
	                    'condition' 	=> [
							'show_boxes_icon' => 'yes',
						],
	                ]
	            );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_toggle_style_content',
			[
				'label' => esc_html__( 'Content', 'aovis' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'content_background_color',
			[
				'label' => esc_html__( 'Background', 'aovis' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-tab-content' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'content_color',
			[
				'label' => esc_html__( 'Color', 'aovis' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-tab-content' => 'color: {{VALUE}};',
				],
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'selector' => '{{WRAPPER}} .elementor-tab-content',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'content_shadow',
				'selector' => '{{WRAPPER}} .elementor-tab-content',
			]
		);

		$this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'ova_content_border',
                'label'     => esc_html__( 'Border', 'aovis' ),
                'selector'  => '{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-content',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
			'ova_content_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'aovis' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label' => esc_html__( 'Padding', 'aovis' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-tab-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ova_content_margin',
			[
				'label' => esc_html__( 'Margin', 'aovis' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ova_content_margin_tags',
			[
				'label' => esc_html__( 'Margin (p, h1... h6)', 'aovis' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-content p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-content h1' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-content h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-content h3' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-content h4' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-content h5' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}}.elementor-widget-toggle .elementor-toggle .elementor-toggle-item .elementor-tab-content h6' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render toggle widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$id_int = substr( $this->get_id_int(), 0, 3 );
		$migrated = isset( $settings['__fa4_migrated']['selected_icon'] );

		if ( ! isset( $settings['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// @todo: remove when deprecated
			// added as bc in 2.6
			// add old default
			$settings['icon'] = 'fa fa-caret' . ( is_rtl() ? '-left' : '-right' );
			$settings['icon_active'] = 'fa fa-caret-up';
			$settings['icon_align'] = $this->get_settings( 'icon_align' );
		}

		$is_new = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
		$has_icon = ( ! $is_new || ! empty( $settings['selected_icon']['value'] ) );

		$class_before_title = ( 'yes' == $settings['show_before_title'] ) ? ' ova-before-title' : '';
		$class_boxes_icon 	= ( 'yes' == $settings['show_boxes_icon'] ) ? ' ova-boxes-icon' : '';

		?>
		<div class="elementor-toggle" role="tablist">
			<?php
			foreach ( $settings['tabs'] as $index => $item ) :
				$tab_count = $index + 1;

				$tab_title_setting_key = $this->get_repeater_setting_key( 'tab_title', 'tabs', $index );

				$tab_content_setting_key = $this->get_repeater_setting_key( 'tab_content', 'tabs', $index );

				$this->add_render_attribute( $tab_title_setting_key, [
					'id' => 'elementor-tab-title-' . $id_int . $tab_count,
					'class' => [ 'elementor-tab-title' ],
					'data-tab' => $tab_count,
					'role' => 'tab',
					'aria-controls' => 'elementor-tab-content-' . $id_int . $tab_count,
					'aria-expanded' => 'false',
				] );

				$this->add_render_attribute( $tab_content_setting_key, [
					'id' => 'elementor-tab-content-' . $id_int . $tab_count,
					'class' => [ 'elementor-tab-content', 'elementor-clearfix' ],
					'data-tab' => $tab_count,
					'role' => 'tabpanel',
					'aria-labelledby' => 'elementor-tab-title-' . $id_int . $tab_count,
				] );

				$this->add_inline_editing_attributes( $tab_content_setting_key, 'advanced' );
				?>
				<div class="elementor-toggle-item">
					<<?php Utils::print_validated_html_tag( $settings['title_html_tag'] ); ?> <?php $this->print_render_attribute_string( $tab_title_setting_key ); ?>>
						<?php if ( $has_icon ) : ?>
						<span class="elementor-toggle-icon elementor-toggle-icon-<?php echo esc_attr( $settings['icon_align'] ); ?><?php echo esc_attr( $class_boxes_icon ); ?>" aria-hidden="true">
							<?php
							if ( $is_new || $migrated ) { ?>
								<span class="elementor-toggle-icon-closed">
									<?php Icons_Manager::render_icon( $settings['selected_icon'] ); ?>
								</span>
								<span class="elementor-toggle-icon-opened">
									<?php Icons_Manager::render_icon( $settings['selected_active_icon'], [ 'class' => 'elementor-toggle-icon-opened' ] ); ?>
								</span>
							<?php } else { ?>
								<i class="elementor-toggle-icon-closed <?php echo esc_attr( $settings['icon'] ); ?>"></i>
								<i class="elementor-toggle-icon-opened <?php echo esc_attr( $settings['icon_active'] ); ?>"></i>
							<?php } ?>
						</span>
						<?php endif; ?>
						<div class="ova-toggle-title">
							<?php if ( $settings['ova_icon'] ): ?>
								<span class="ova-icon">
									<i class="<?php echo esc_attr( $settings['ova_icon']['value'] ); ?>"></i>
								</span>
							<?php endif; ?>
							<a href="" class="elementor-toggle-title<?php echo esc_attr( $class_before_title ); ?>">
								<?php $this->print_unescaped_setting( 'tab_title', 'tabs', $index ); ?>
							</a>
						</div>
					</<?php Utils::print_validated_html_tag( $settings['title_html_tag'] ); ?>>

					<div <?php $this->print_render_attribute_string( $tab_content_setting_key ); ?>>
						<?php Utils::print_unescaped_internal_string( $this->parse_text_editor( $item['tab_content'] ) ); ?>
					</div>
				</div>
			<?php endforeach; ?>
			<?php
			if ( isset( $settings['faq_schema'] ) && 'yes' === $settings['faq_schema'] ) {
				$json = [
					'@context' => 'https://schema.org',
					'@type' => 'FAQPage',
					'mainEntity' => [],
				];

				foreach ( $settings['tabs'] as $index => $item ) {
					$json['mainEntity'][] = [
						'@type' => 'Question',
						'name' => wp_strip_all_tags( $item['tab_title'] ),
						'acceptedAnswer' => [
							'@type' => 'Answer',
							'text' => $this->parse_text_editor( $item['tab_content'] ),
						],
					];
				}
				?>
				<script type="application/ld+json"><?php echo wp_json_encode( $json ); ?></script>
			<?php } ?>
		</div>
		<?php
	}

	/**
	 * Render toggle widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 2.9.0
	 * @access protected
	 */
	protected function content_template() {
		?>
		<div class="elementor-toggle" role="tablist">
			<#
			if ( settings.tabs ) {
				var tabindex = view.getIDInt().toString().substr( 0, 3 ),
					iconHTML = elementor.helpers.renderIcon( view, settings.selected_icon, {}, 'i' , 'object' ),
					iconActiveHTML = elementor.helpers.renderIcon( view, settings.selected_active_icon, {}, 'i' , 'object' ),
					migrated = elementor.helpers.isIconMigrated( settings, 'selected_icon' ),
					titleHTMLTag = elementor.helpers.validateHTMLTag( settings.title_html_tag );

				_.each( settings.tabs, function( item, index ) {
					var tabCount = index + 1,
						tabTitleKey = view.getRepeaterSettingKey( 'tab_title', 'tabs', index ),
						tabContentKey = view.getRepeaterSettingKey( 'tab_content', 'tabs', index );

					view.addRenderAttribute( tabTitleKey, {
						'id': 'elementor-tab-title-' + tabindex + tabCount,
						'class': [ 'elementor-tab-title' ],
						'data-tab': tabCount,
						'role': 'tab',
						'aria-controls': 'elementor-tab-content-' + tabindex + tabCount,
						'aria-expanded': 'false',
					} );

					view.addRenderAttribute( tabContentKey, {
						'id': 'elementor-tab-content-' + tabindex + tabCount,
						'class': [ 'elementor-tab-content', 'elementor-clearfix' ],
						'data-tab': tabCount,
						'role': 'tabpanel',
						'aria-labelledby': 'elementor-tab-title-' + tabindex + tabCount
					} );

					view.addInlineEditingAttributes( tabContentKey, 'advanced' );
					#>
					<div class="elementor-toggle-item">
						<{{{ titleHTMLTag }}} {{{ view.getRenderAttributeString( tabTitleKey ) }}}>
							<# if ( settings.icon || settings.selected_icon ) { #>
								<# if ( 'yes' == settings.show_boxes_icon ) { #>
									<span class="elementor-toggle-icon elementor-toggle-icon-{{ settings.icon_align }} ova-boxes-icon" aria-hidden="true">
								<# } else { #>
									<span class="elementor-toggle-icon elementor-toggle-icon-{{ settings.icon_align }}" aria-hidden="true">
								<# } #>

								<# if ( iconHTML && iconHTML.rendered && ( ! settings.icon || migrated ) ) { #>
									<span class="elementor-toggle-icon-closed">{{{ iconHTML.value }}}</span>
									<span class="elementor-toggle-icon-opened">{{{ iconActiveHTML.value }}}</span>
								<# } else { #>
									<i class="elementor-toggle-icon-closed {{ settings.icon }}"></i>
									<i class="elementor-toggle-icon-opened {{ settings.icon_active }}"></i>
								<# } #>
							</span>
							<# } #>
							<div class="ova-toggle-title">
								<# if ( settings.ova_icon ) { #>
									<span class="ova-icon">
										<i class="{{{ settings.ova_icon.value }}}"></i>
									</span>
								<# } #>
								<# if ( 'yes' == settings.show_before_title ) { #>
									<a href="" class="elementor-toggle-title ova-before-title">{{{ item.tab_title }}}</a>
								<# } else { #>
									<a href="" class="elementor-toggle-title">{{{ item.tab_title }}}</a>
								<# } #>
							</div>
						</{{{ titleHTMLTag }}}>
						<div {{{ view.getRenderAttributeString( tabContentKey ) }}}>{{{ item.tab_content }}}</div>
					</div>
					<#
				} );
			} #>
		</div>
		<?php
	}
}
$widgets_manager->register(new Aovis_Elementor_Toggle());
