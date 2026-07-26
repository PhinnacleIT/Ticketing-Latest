<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Border;

/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class Aovis_Elementor_Tabs extends Widget_Tabs {

   
    /**
     * Register tabs widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 3.1.0
     * @access protected
     */
    protected function register_controls() {

        /**
         * Content Tab
         */

        $this->start_controls_section(
            'section_tabs',
            [
                'label' => esc_html__( 'Tabs', 'aovis' ),
            ]
        );

        // Tab Item
        $repeater = new Repeater();

        $repeater->add_control(
            'tab_icon_image',
            [
                'label' => esc_html__( 'Icon/Image', 'aovis' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'none' => [
                        'title' => esc_html__( 'None', 'aovis' ),
                        'icon' => 'eicon-ban',
                    ],
                    'icon' => [
                        'title' => esc_html__( 'Icon', 'aovis' ),
                        'icon' => 'eicon-caret-right',
                    ],
                    'image' => [
                        'title' => esc_html__( 'Image', 'aovis' ),
                        'icon' => 'eicon-image',
                    ],
                ],
                'default'   => 'none',
                'toggle'    => false,
            ]
        );

        $repeater->add_control(
            'ova_icon',
            [
                'label'     => esc_html__( 'Choose Icon', 'aovis' ),
                'type'      => Controls_Manager::ICONS,
                'condition' => [
                    'tab_icon_image' => 'icon',
                ],
            ]
        );

        $repeater->add_control(
            'ova_image',
            [
                'label'     => esc_html__( 'Choose Image', 'aovis' ),
                'type'      => Controls_Manager::MEDIA,
                'condition' => [
                    'tab_icon_image' => 'image',
                ],
            ]
        );

        $repeater->add_control(
            'tab_title',
            [
                'label' => esc_html__( 'Title & Description', 'aovis' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Tab Title', 'aovis' ),
                'placeholder' => esc_html__( 'Tab Title', 'aovis' ),
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
                'default' => esc_html__( 'Tab Content', 'aovis' ),
                'placeholder' => esc_html__( 'Tab Content', 'aovis' ),
                'type' => Controls_Manager::WYSIWYG,
                'show_label' => false,
            ]
        );

        $this->add_control(
            'tabs',
            [
                'label' => esc_html__( 'Tabs Items', 'aovis' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'tab_title' => esc_html__( 'Tab #1', 'aovis' ),
                        'tab_content' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'aovis' ),
                    ],
                    [
                        'tab_title' => esc_html__( 'Tab #2', 'aovis' ),
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
            'type',
            [
                'label' => esc_html__( 'Position', 'aovis' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'horizontal',
                'options' => [
                    'horizontal' => esc_html__( 'Horizontal', 'aovis' ),
                    'vertical' => esc_html__( 'Vertical', 'aovis' ),
                ],
                'prefix_class' => 'elementor-tabs-view-',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'tabs_align_horizontal',
            [
                'label' => esc_html__( 'Alignment', 'aovis' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    '' => [
                        'title' => esc_html__( 'Start', 'aovis' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'aovis' ),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'end' => [
                        'title' => esc_html__( 'End', 'aovis' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                    'stretch' => [
                        'title' => esc_html__( 'Justified', 'aovis' ),
                        'icon' => 'eicon-h-align-stretch',
                    ],
                ],
                'prefix_class' => 'elementor-tabs-alignment-',
                'condition' => [
                    'type' => 'horizontal',
                ],
            ]
        );

        $this->add_control(
            'tabs_align_vertical',
            [
                'label' => esc_html__( 'Alignment', 'aovis' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    '' => [
                        'title' => esc_html__( 'Start', 'aovis' ),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'aovis' ),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'end' => [
                        'title' => esc_html__( 'End', 'aovis' ),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                    'stretch' => [
                        'title' => esc_html__( 'Justified', 'aovis' ),
                        'icon' => 'eicon-v-align-stretch',
                    ],
                ],
                'prefix_class' => 'elementor-tabs-alignment-',
                'condition' => [
                    'type' => 'vertical',
                ],
            ]
        );

        $this->end_controls_section();


        /**
         * General in Style tab
         */
        $this->start_controls_section(
            'section_tabs_style',
            [
                'label' => esc_html__( 'General', 'aovis' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'navigation_width',
            [
                'label' => esc_html__( 'Navigation Width', 'aovis' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 33,
                    'unit' => '%',
                ],
                'range' => [
                    '%' => [
                        'min' => 10,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-tabs-wrapper' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'type' => 'vertical',
                ],
            ]
        );

        $this->add_control(
            'border_width',
            [
                'label' => esc_html__( 'Border Width', 'aovis' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-title, {{WRAPPER}} .elementor-tab-title:before, {{WRAPPER}} .elementor-tab-title:after, {{WRAPPER}} .elementor-tab-content, {{WRAPPER}} .elementor-tabs-content-wrapper' => 'border-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'border_color',
            [
                'label' => esc_html__( 'Border Color', 'aovis' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-mobile-title, {{WRAPPER}} .elementor-tab-desktop-title.elementor-active, {{WRAPPER}} .elementor-tab-title:before, {{WRAPPER}} .elementor-tab-title:after, {{WRAPPER}} .elementor-tab-content, {{WRAPPER}} .elementor-tabs-content-wrapper' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label' => esc_html__( 'Background Color', 'aovis' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-desktop-title.elementor-active' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-tabs-content-wrapper' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        

        /* Begin Ova Tabs Navigation Style */
        $this->start_controls_section(
            'section_ova_tabs_style',
            [
                'label' => esc_html__( 'Navigation', 'aovis' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_responsive_control(
                'ova_tabs_wrapper_displaya',
                [
                    'label' => esc_html__( 'Alignment', 'aovis' ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'flex' => [
                            'title' => esc_html__( 'Flex', 'aovis' ),
                            'icon' => 'eicon-h-align-left',
                        ],
                        'block' => [
                            'title' => esc_html__( 'Block', 'aovis' ),
                            'icon' => 'eicon-h-align-stretch',
                        ],
                        'none' => [
                            'title' => esc_html__( 'None', 'aovis' ),
                            'icon' => 'eicon-h-align-right',
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-wrapper' => 'display: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name'      => 'ova_tabs_wrapper_border',
                    'label'     => esc_html__( 'Border', 'aovis' ),
                    'selector'  => '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-wrapper',
                ]
            );

            $this->add_responsive_control(
                'ova_tabs_wrapper_border_radius',
                [
                    'label'         => esc_html__( 'Border Radius', 'aovis' ),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', '%', 'em' ],
                    'selectors'     => [
                        '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'ova_tabs_wrapper_padding',
                [
                    'label'         => esc_html__( 'Padding', 'aovis' ),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', '%', 'em' ],
                    'selectors'     => [
                        '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'ova_tabs_wrapper_margin',
                [
                    'label'         => esc_html__( 'Margin', 'aovis' ),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', '%', 'em' ],
                    'selectors'     => [
                        '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'ova_tabs_wrapper_box_shadow',
                    'selector' => '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-wrapper, {{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-mobile-title',
                ]
            );

        $this->end_controls_section();
        /* End Ova Navigation Style */

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
                    'selector'  => '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-wrapper > .elementor-tab-desktop-title, {{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-mobile-title',
                ]
            );

            $this->add_group_control(
                Group_Control_Text_Shadow::get_type(),
                [
                    'name' => 'ova_title_shadow',
                    'selector' => '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-wrapper > .elementor-tab-desktop-title, {{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-mobile-title',
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
                                '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-wrapper > .elementor-tab-desktop-title' => 'color: {{VALUE}}',
                                '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-mobile-title' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_control(
                        'ova_title_background_normal',
                        [
                            'label'     => esc_html__( 'Background', 'aovis' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-wrapper > .elementor-tab-desktop-title' => 'background-color: {{VALUE}}',
                                '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-mobile-title' => 'background-color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_control(
                        'ova_title_mobile_color_normal',
                        [
                            'label'     => esc_html__( 'Color Mobile', 'aovis' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-mobile-title' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_control(
                        'ova_title_mobile_background_normal',
                        [
                            'label'     => esc_html__( 'Background Mobile', 'aovis' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-mobile-title' => 'background-color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        \Elementor\Group_Control_Box_Shadow::get_type(),
                        [
                            'name' => 'ova_title_box_shadow_normal',
                            'selector' => '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-wrapper > .elementor-tab-desktop-title ,
                                {{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-mobile-title 
                             ',
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
                                '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-wrapper > .elementor-tab-desktop-title:hover' => 'color: {{VALUE}}',
                                '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-mobile-title:hover' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_control(
                        'ova_title_background_hover',
                        [
                            'label'     => esc_html__( 'Background', 'aovis' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-wrapper > .elementor-tab-desktop-title:hover' => 'background-color: {{VALUE}}',
                                '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-mobile-title:hover' => 'background-color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_control(
                        'ova_title_mobile_color_hover',
                        [
                            'label'     => esc_html__( 'Color Mobile', 'aovis' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-mobile-title:hover' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_control(
                        'ova_title_mobile_background_hover',
                        [
                            'label'     => esc_html__( 'Background Mobile', 'aovis' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-mobile-title:hover' => 'background-color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        \Elementor\Group_Control_Box_Shadow::get_type(),
                        [
                            'name' => 'ova_title_box_shadow_hover',
                            'selector' => '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-wrapper > .elementor-tab-desktop-title:hover ,
                                {{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-mobile-title:hover 
                             ',
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
                                '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-wrapper > .elementor-tab-desktop-title.elementor-active' => 'color: {{VALUE}}',
                                '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-mobile-title.elementor-active' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_control(
                        'ova_title_background_active',
                        [
                            'label'     => esc_html__( 'Background', 'aovis' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-wrapper > .elementor-tab-desktop-title.elementor-active' => 'background-color: {{VALUE}}',
                                '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-mobile-title.elementor-active' => 'background-color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_control(
                        'ova_title_mobile_color_active',
                        [
                            'label'     => esc_html__( 'Color Mobile', 'aovis' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-mobile-title.elementor-active' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_control(
                        'ova_title_mobile_background_active',
                        [
                            'label'     => esc_html__( 'Background Mobile', 'aovis' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-mobile-title.elementor-active' => 'background-color: {{VALUE}}',
                            ],
                        ]
                    );

                     $this->add_group_control(
                        \Elementor\Group_Control_Box_Shadow::get_type(),
                        [
                            'name' => 'ova_title_box_shadow_active',
                            'selector' => '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-wrapper > .elementor-tab-desktop-title.elementor-active ,
                                {{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-mobile-title.elementor-active 
                             ',
                        ]
                    );

                $this->end_controls_tab();
            $this->end_controls_tabs();

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name'      => 'ova_title_border',
                    'label'     => esc_html__( 'Border', 'aovis' ),
                    'selector'  => '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-wrapper > .elementor-tab-desktop-title, {{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-mobile-title',
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'ova_title_border_color_hover',
                [
                    'label'     => esc_html__( 'Border Color Hover', 'aovis' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-wrapper > .elementor-tab-desktop-title:hover' => 'border-color: {{VALUE}}',
                        '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-mobile-title:hover' => 'border-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'ova_title_border_color_active',
                [
                    'label'     => esc_html__( 'Border Color Active', 'aovis' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-wrapper > .elementor-tab-desktop-title.elementor-active' => 'border-color: {{VALUE}}',
                        '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-mobile-title.elementor-active' => 'border-color: {{VALUE}}',
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
                        '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-wrapper > .elementor-tab-desktop-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-mobile-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                        '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-wrapper > .elementor-tab-desktop-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-mobile-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                        '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-wrapper > .elementor-tab-desktop-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-mobile-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'ova_first_title_border_radius',
                [
                    'label'         => esc_html__( 'Border Radius (first-child)', 'aovis' ),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', '%', 'em' ],
                    'selectors'     => [
                        '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-wrapper > .elementor-tab-desktop-title:first-child' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'ova_last_title_border_radius',
                [
                    'label'         => esc_html__( 'Border Radius (last-child)', 'aovis' ),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', '%', 'em' ],
                    'selectors'     => [
                        '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-wrapper > .elementor-tab-desktop-title:last-child' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_controls_section();
        /* End Ova Title Style */

        /* Begin Ova Cotent Style */
        $this->start_controls_section(
            'section_ova_content_style',
            [
                'label' => esc_html__( 'Content', 'aovis' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_control(
                'content_color',
                [
                    'label' => esc_html__( 'Color', 'aovis' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-content' => 'color: {{VALUE}};',
                        '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-content h1' => 'color: {{VALUE}};',
                        '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-content h2' => 'color: {{VALUE}};',
                        '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-content h3' => 'color: {{VALUE}};',
                        '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-content h4' => 'color: {{VALUE}};',
                        '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-content h5' => 'color: {{VALUE}};',
                        '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-content h6' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name'      => 'ova_content_border',
                    'label'     => esc_html__( 'Border', 'aovis' ),
                    'selector'  => '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-content',
                ]
            );

            $this->add_group_control(
                Group_Control_Text_Shadow::get_type(),
                [
                    'name'      => 'ova_content_shadow',
                    'selector'  => '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-content',
                ]
            );

            $this->add_responsive_control(
                'ova_content_padding',
                [
                    'label'         => esc_html__( 'Padding', 'aovis' ),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', '%', 'em' ],
                    'selectors'     => [
                        '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-content .elementor-column-gap-default>.elementor-column>.elementor-element-populated' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-content .elementor-section .elementor-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'ova_content_margin',
                [
                    'label'         => esc_html__( 'Margin', 'aovis' ),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => [ 'px', '%', 'em' ],
                    'selectors'     => [
                        '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-content p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_controls_section();
        /* End Ova Title Style */

        /* Begin Ova Icon Style */
        $this->start_controls_section(
            'section_ova_icon_image_style',
            [
                'label'     => esc_html__( 'Icon/Image', 'aovis' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_control(
                'icon_image_align',
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
                    'default'   => 'left',
                    'toggle'    => false,
                ]
            );

            $this->add_control(
                'ova_tab_icon',
                [
                    'label'     => esc_html__( 'Icon', 'aovis' ),
                    'type'      => \Elementor\Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

                $this->add_group_control(
                    Group_Control_Typography::get_type(),
                    [
                        'name'      => 'ova_tab_icon_typography',
                        'selector'  => '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-wrapper > .elementor-tab-desktop-title span.ova-tab-icon i, {{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-mobile-title span.ova-tab-icon i',
                    ]
                );

                 $this->add_control(
                    'ova_background_icon_size',
                    [
                        'label' => esc_html__( 'Background Icon Size', 'aovis' ),
                        'type' => \Elementor\Controls_Manager::SLIDER,
                        'size_units' => [ 'px', '%', 'em', 'rem'],
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
                            '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-wrapper > .elementor-tab-desktop-title span.ova-tab-icon' => 'min-width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                            '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-mobile-title span.ova-tab-icon' => 'min-width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                $this->start_controls_tabs(
                    'style_ova_tab_icon_tabs'
                );

                    $this->start_controls_tab(
                        'ova_tab_icon_normal_tab',
                        [
                            'label' => esc_html__( 'Normal', 'aovis' ),
                        ]
                    );

                        $this->add_control(
                            'ova_tab_icon_color_normal',
                            [
                                'label'     => esc_html__( 'Color', 'aovis' ),
                                'type'      => Controls_Manager::COLOR,
                                'selectors' => [
                                    '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-wrapper > .elementor-tab-desktop-title span.ova-tab-icon i' => 'color: {{VALUE}}',
                                    '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-mobile-title span.ova-tab-icon i' => 'color: {{VALUE}}',
                                ],
                            ]
                        );

                        $this->add_control(
                            'ova_tab_background_icon_color_normal',
                            [
                                'label'     => esc_html__( 'Background Color', 'aovis' ),
                                'type'      => Controls_Manager::COLOR,
                                'selectors' => [
                                    '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-wrapper > .elementor-tab-desktop-title span.ova-tab-icon' => 'background-color: {{VALUE}}',
                                    '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-mobile-title span.ova-tab-icon' => 'background-color: {{VALUE}}',
                                ],
                            ]
                        );

                    $this->end_controls_tab();

                    $this->start_controls_tab(
                        'ova_tab_icon_hover_tab',
                        [
                            'label' => esc_html__( 'Hover', 'aovis' ),
                        ]
                    );

                        $this->add_control(
                            'ova_tab_icon_color_hover',
                            [
                                'label'     => esc_html__( 'Color', 'aovis' ),
                                'type'      => Controls_Manager::COLOR,
                                'selectors' => [
                                    '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-wrapper > .elementor-tab-desktop-title:hover span.ova-tab-icon i' => 'color: {{VALUE}}',
                                    '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-mobile-title:hover span.ova-tab-icon i' => 'color: {{VALUE}}',
                                ],
                            ]
                        );

                        $this->add_control(
                            'ova_tab_background_icon_color_hover',
                            [
                                'label'     => esc_html__( 'Background Color', 'aovis' ),
                                'type'      => Controls_Manager::COLOR,
                                'selectors' => [
                                    '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-wrapper > .elementor-tab-desktop-title:hover span.ova-tab-icon ' => 'background-color: {{VALUE}}',
                                    '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-mobile-title:hover span.ova-tab-icon ' => 'background-color: {{VALUE}}',
                                ],
                            ]
                        );

                    $this->end_controls_tab();

                    $this->start_controls_tab(
                        'ova_tab_icon_active_tab',
                        [
                            'label' => esc_html__( 'Active', 'aovis' ),
                        ]
                    );

                        $this->add_control(
                            'ova_tab_icon_color_active',
                            [
                                'label'     => esc_html__( 'Color', 'aovis' ),
                                'type'      => Controls_Manager::COLOR,
                                'selectors' => [
                                    '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-wrapper > .elementor-tab-desktop-title.elementor-active span.ova-tab-icon i' => 'color: {{VALUE}}',
                                    '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-mobile-title.elementor-active span.ova-tab-icon i' => 'color: {{VALUE}}',
                                ],
                            ]
                        );

                        $this->add_control(
                            'ova_tab_background_icon_color_active',
                            [
                                'label'     => esc_html__( 'Background Color', 'aovis' ),
                                'type'      => Controls_Manager::COLOR,
                                'selectors' => [
                                    '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-wrapper > .elementor-tab-desktop-title.elementor-active span.ova-tab-icon ' => 'background-color: {{VALUE}}',
                                    '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-mobile-title.elementor-active span.ova-tab-icon ' => 'background-color: {{VALUE}}',
                                ],
                            ]
                        );

                    $this->end_controls_tab();
                $this->end_controls_tabs();

                $this->add_responsive_control(
                    'ova_tab_icon_padding',
                    [
                        'label'         => esc_html__( 'Padding', 'aovis' ),
                        'type'          => Controls_Manager::DIMENSIONS,
                        'size_units'    => [ 'px', '%', 'em' ],
                        'selectors'     => [
                            '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-wrapper > .elementor-tab-desktop-title span.ova-tab-icon ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-mobile-title span.ova-tab-icon ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_responsive_control(
                    'ova_tab_icon_margin',
                    [
                        'label'         => esc_html__( 'Margin', 'aovis' ),
                        'type'          => Controls_Manager::DIMENSIONS,
                        'size_units'    => [ 'px', '%', 'em' ],
                        'selectors'     => [
                            '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-wrapper > .elementor-tab-desktop-title span.ova-tab-icon ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-mobile-title span.ova-tab-icon ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        ],
                    ]
                );



            $this->add_control(
                'ova_tab_image',
                [
                    'label'     => esc_html__( 'Image', 'aovis' ),
                    'type'      => \Elementor\Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

                $this->add_responsive_control(
                    'ova_tab_image_width',
                    [
                        'label'         => esc_html__( 'Width', 'aovis' ),
                        'type'          => Controls_Manager::SLIDER,
                        'size_units'    => [ 'px', '%', 'vw' ],
                        'range' => [
                            'px' => [
                                'min' => 0,
                                'max' => 1000,
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
                            '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-wrapper > .elementor-tab-desktop-title span.ova-tab-image img' => 'width: {{SIZE}}{{UNIT}};min-width: {{SIZE}}{{UNIT}};',
                            '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-mobile-title span.ova-tab-image img' => 'width: {{SIZE}}{{UNIT}};min-width: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_responsive_control(
                    'ova_tab_image_height',
                    [
                        'label'         => esc_html__( 'Height', 'aovis' ),
                        'type'          => Controls_Manager::SLIDER,
                        'size_units'    => [ 'px', '%', 'vh' ],
                        'range' => [
                            'px' => [
                                'min' => 0,
                                'max' => 1000,
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
                            '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-wrapper > .elementor-tab-desktop-title span.ova-tab-image img' => 'height: {{SIZE}}{{UNIT}};',
                            '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-mobile-title span.ova-tab-image img' => 'height: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_responsive_control(
                    'ova_tab_image_border_radius',
                    [
                        'label'         => esc_html__( 'Border Radius', 'aovis' ),
                        'type'          => Controls_Manager::DIMENSIONS,
                        'size_units'    => [ 'px', '%', 'em' ],
                        'selectors'     => [
                            '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-wrapper > .elementor-tab-desktop-title span.ova-tab-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-mobile-title span.ova-tab-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_responsive_control(
                    'ova_tab_image_padding',
                    [
                        'label'         => esc_html__( 'Padding', 'aovis' ),
                        'type'          => Controls_Manager::DIMENSIONS,
                        'size_units'    => [ 'px', '%', 'em' ],
                        'selectors'     => [
                            '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-wrapper > .elementor-tab-desktop-title span.ova-tab-image img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-mobile-title span.ova-tab-image img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_responsive_control(
                    'ova_tab_image_margin',
                    [
                        'label'         => esc_html__( 'Margin', 'aovis' ),
                        'type'          => Controls_Manager::DIMENSIONS,
                        'size_units'    => [ 'px', '%', 'em' ],
                        'selectors'     => [
                            '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-wrapper > .elementor-tab-desktop-title span.ova-tab-image img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            '{{WRAPPER}}.elementor-widget-tabs .elementor-tabs .elementor-tabs-content-wrapper > .elementor-tab-mobile-title span.ova-tab-image img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        ],
                    ]
                );

        $this->end_controls_section();
        /* End Ova Icon Style */
    }

    /**
     * Render tabs widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        $tabs = $this->get_settings_for_display( 'tabs' );

        $id_int = substr( $this->get_id_int(), 0, 3 );

        $a11y_improvements_experiment = Plugin::$instance->experiments->is_feature_active( 'a11y_improvements' );

        $this->add_render_attribute( 'elementor-tabs', 'class', 'elementor-tabs' );

        ?>
        <div <?php $this->print_render_attribute_string( 'elementor-tabs' ); ?>>
            <div class="elementor-tabs-wrapper" role="tablist" >
                <?php
                foreach ( $tabs as $index => $item ) :
                    $tab_count = $index + 1;
                    $tab_title_setting_key = $this->get_repeater_setting_key( 'tab_title', 'tabs', $index );
                    $tab_title = $a11y_improvements_experiment ? $item['tab_title'] : '<a href="">' . $item['tab_title'] . '</a>';

                    $tab_icon   = isset( $item['ova_icon']['value'] ) ? $item['ova_icon']['value'] : '';

                    $img_url    = isset( $item['ova_image']['url'] ) ? $item['ova_image']['url'] : '';
                    $img_alt    = isset( $item['ova_image']['alt'] ) ? $item['ova_image']['alt'] : '';

                    $this->add_render_attribute( $tab_title_setting_key, [
                        'id' => 'elementor-tab-title-' . $id_int . $tab_count,
                        'class' => [ 'elementor-tab-title', 'elementor-tab-desktop-title' ],
                        'aria-selected' => 1 === $tab_count ? 'true' : 'false',
                        'data-tab' => $tab_count,
                        'role' => 'tab',
                        'tabindex' => 1 === $tab_count ? '0' : '-1',
                        'aria-controls' => 'elementor-tab-content-' . $id_int . $tab_count,
                        'aria-expanded' => 'false',
                    ] );
                    ?>
                    <div <?php $this->print_render_attribute_string( $tab_title_setting_key ); ?>><?php
                        if ( 'icon' === $item['tab_icon_image'] && $tab_icon ) {
                            if ( 'left' === $settings['icon_image_align'] ) { ?>
                                <span class="ova-tab-icon"><i class="<?php echo esc_attr( $tab_icon ); ?>"></i></span>
                            <?php
                            } ?>

                            <div class="right"><?php printf( $tab_title ); ?></div> 
                            
                            <?php
                            if ( 'right' === $settings['icon_image_align'] ) { ?>
                                <span class="ova-tab-icon"><i class="<?php echo esc_attr( $tab_icon ); ?>"></i></span>
                            <?php }
                        } elseif ( 'image' === $item['tab_icon_image'] && $img_url ) {
                            if ( 'left' === $settings['icon_image_align'] ) { ?>
                                <span class="ova-tab-image">
                                    <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $img_alt ); ?>">
                                </span>
                            <?php
                            }
                            ?>

                            <div class="right"><?php printf( $tab_title ); ?></div> 
                            
                            <?php
                            
                            if ( 'right' === $settings['icon_image_align'] ) { ?>
                                <span class="ova-tab-image">
                                    <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $img_alt ); ?>">
                                </span>
                            <?php }
                        } else {
                            // PHPCS - the main text of a widget should not be escaped.
                            printf( $tab_title );
                            
                        }
                    ?></div>
                <?php endforeach; ?>
            </div>
            <div class="elementor-tabs-content-wrapper" role="tablist" aria-orientation="vertical">
                <?php
                foreach ( $tabs as $index => $item ) :
                    $tab_count = $index + 1;
                    $hidden = 1 === $tab_count ? 'false' : 'hidden';
                    $tab_content_setting_key = $this->get_repeater_setting_key( 'tab_content', 'tabs', $index );

                    $tab_title_mobile_setting_key = $this->get_repeater_setting_key( 'tab_title_mobile', 'tabs', $tab_count );

                    $tab_icon   = isset( $item['ova_icon']['value'] ) ? $item['ova_icon']['value'] : '';

                    $img_url    = isset( $item['ova_image']['url'] ) ? $item['ova_image']['url'] : '';
                    $img_alt    = isset( $item['ova_image']['alt'] ) ? $item['ova_image']['alt'] : '';

                    $this->add_render_attribute( $tab_content_setting_key, [
                        'id' => 'elementor-tab-content-' . $id_int . $tab_count,
                        'class' => [ 'elementor-tab-content', 'elementor-clearfix' ],
                        'data-tab' => $tab_count,
                        'role' => 'tabpanel',
                        'aria-labelledby' => 'elementor-tab-title-' . $id_int . $tab_count,
                        'tabindex' => '0',
                        'hidden' => $hidden,
                    ] );

                    $this->add_render_attribute( $tab_title_mobile_setting_key, [
                        'class' => [ 'elementor-tab-title', 'elementor-tab-mobile-title' ],
                        'aria-selected' => 1 === $tab_count ? 'true' : 'false',
                        'data-tab' => $tab_count,
                        'role' => 'tab',
                        'tabindex' => 1 === $tab_count ? '0' : '-1',
                        'aria-controls' => 'elementor-tab-content-' . $id_int . $tab_count,
                        'aria-expanded' => 'false',
                    ] );

                    $this->add_inline_editing_attributes( $tab_content_setting_key, 'advanced' );
                    ?>
                    <div <?php $this->print_render_attribute_string( $tab_title_mobile_setting_key ); ?>><?php

                        if ( 'icon' === $item['tab_icon_image'] && $tab_icon ) {
                            if ( 'left' === $settings['icon_image_align'] ) { ?>
                                <span class="ova-tab-icon"><i class="<?php echo esc_attr( $tab_icon ); ?>"></i></span>
                            <?php }
                            ?>

                            <div class="left">
                                <?php
                                $this->print_unescaped_setting( 'tab_title', 'tabs', $index );
                                ?>
                            </div>
                            
                            <?php
                            if ( 'right' === $settings['icon_image_align'] ) { ?>
                                <span class="ova-tab-icon"><i class="<?php echo esc_attr( $tab_icon ); ?>"></i></span>
                            <?php }
                        } elseif ( 'image' === $item['tab_icon_image'] && $img_url ) {
                            if ( 'left' === $settings['icon_image_align'] ) { ?>
                                <span class="ova-tab-image">
                                    <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $img_alt ); ?>">
                                </span>
                            <?php }

                            $this->print_unescaped_setting( 'tab_title', 'tabs', $index );

                            if ( 'right' === $settings['icon_image_align'] ) { ?>
                                <span class="ova-tab-image">
                                    <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $img_alt ); ?>">
                                </span>
                            <?php }

                        } else {
                            $this->print_unescaped_setting( 'tab_title', 'tabs', $index );
                        }
                    ?></div>
                    <div <?php $this->print_render_attribute_string( $tab_content_setting_key ); ?>><?php
                        $this->print_text_editor( $item['tab_content'] );
                    ?></div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }

    /**
     * Render tabs widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 2.9.0
     * @access protected
     */
    protected function content_template() {
        ?>
        <div class="elementor-tabs" role="tablist" aria-orientation="vertical">
            <# if ( settings.tabs ) {
                var elementUid = view.getIDInt().toString().substr( 0, 3 ); #>
                <div class="elementor-tabs-wrapper" role="tablist">
                    <# _.each( settings.tabs, function( item, index ) {
                        var tabCount = index + 1,
                            tabUid = elementUid + tabCount,
                            tabTitleKey = 'tab-title-' + tabUid;

                    view.addRenderAttribute( tabTitleKey, {
                        'id': 'elementor-tab-title-' + tabUid,
                        'class': [ 'elementor-tab-title','elementor-tab-desktop-title' ],
                        'data-tab': tabCount,
                        'role': 'tab',
                        'tabindex': 1 === tabCount ? '0' : '-1',
                        'aria-controls': 'elementor-tab-content-' + tabUid,
                        'aria-expanded': 'false',
                        } );
                    #>
                        <div {{{ view.getRenderAttributeString( tabTitleKey ) }}}>
                            <#
                                if ( 'icon' === item.tab_icon_image && item.ova_icon.value ) {
                                    if ( 'left' === settings.icon_image_align ) { #>
                                        <span class="ova-tab-icon"><i class="{{{ item.ova_icon.value }}}"></i></span>
                                    <# } #>

                                    {{{ item.tab_title }}}

                                    <# if ( 'right' === settings.icon_image_align ) { #>
                                        <span class="ova-tab-icon"><i class="{{{ item.ova_icon.value }}}"></i></span>
                                    <# } #>
                                <# } else if ( 'image' === item.tab_icon_image && item.ova_image.url ) { 
                                    if ( 'left' === settings.icon_image_align ) { #>
                                        <span class="ova-tab-image">
                                            <img src="{{{ item.ova_image.url }}}" alt="{{{ item.ova_image.alt }}}">
                                        </span>
                                    <# } #>

                                    {{{ item.tab_title }}}

                                    <# if ( 'right' === settings.icon_image_align ) { #>
                                        <span class="ova-tab-image">
                                            <img src="{{{ item.ova_image.url }}}" alt="{{{ item.ova_image.alt }}}">
                                        </span>
                                    <# } #>

                                <# } else { #>
                                    {{{ item.tab_title }}}
                            <# } #>
                        </div>
                    <# } ); #>
                </div>
                <div class="elementor-tabs-content-wrapper">
                    <# _.each( settings.tabs, function( item, index ) {
                        var tabCount = index + 1,
                            tabContentKey = view.getRepeaterSettingKey( 'tab_content', 'tabs',index );

                        view.addRenderAttribute( tabContentKey, {
                            'id': 'elementor-tab-content-' + elementUid + tabCount,
                            'class': [ 'elementor-tab-content', 'elementor-clearfix', 'elementor-repeater-item-' + item._id ],
                            'data-tab': tabCount,
                            'role' : 'tabpanel',
                            'aria-labelledby' : 'elementor-tab-title-' + elementUid + tabCount
                        } );

                        view.addInlineEditingAttributes( tabContentKey, 'advanced' ); #>
                        <div class="elementor-tab-title elementor-tab-mobile-title" data-tab="{{ tabCount }}" role="tab">
                        <#
                            if ( 'icon' === item.tab_icon_image && item.ova_icon.value ) {
                                if ( 'left' === settings.icon_image_align ) { #>
                                    <span class="ova-tab-icon"><i class="{{{ item.ova_icon.value }}}"></i></span>
                                <# } #>

                                {{{ item.tab_title }}}

                                <# if ( 'right' === settings.icon_image_align ) { #>
                                    <span class="ova-tab-icon"><i class="{{{ item.ova_icon.value }}}"></i></span>
                                <# } #>
                            <# } else if ( 'image' === item.tab_icon_image && item.ova_image.url ) { 
                                if ( 'left' === settings.icon_image_align ) { #>
                                    <span class="ova-tab-image">
                                        <img src="{{{ item.ova_image.url }}}" alt="{{{ item.ova_image.alt }}}">
                                    </span>
                                <# } #>

                                {{{ item.tab_title }}}

                                <# if ( 'right' === settings.icon_image_align ) { #>
                                    <span class="ova-tab-image">
                                        <img src="{{{ item.ova_image.url }}}" alt="{{{ item.ova_image.alt }}}">
                                    </span>
                                <# } #>

                            <# } else { #>
                                {{{ item.tab_title }}}
                        <# } #>
                        </div>
                        <div {{{ view.getRenderAttributeString( tabContentKey ) }}}>{{{ item.tab_content }}}</div>
                    <# } ); #>
                </div>
            <# } #>
        </div>
        <?php
    }
}

$widgets_manager->register(new Aovis_Elementor_Tabs());