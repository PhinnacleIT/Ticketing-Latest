<?php

class Aovis_Elementor {
	
	function __construct() {
            
		// Register Header Footer Category in Pane
	    add_action( 'elementor/elements/categories_registered', array( $this, 'aovis_add_category' ) );

	    add_action( 'elementor/frontend/after_register_scripts', array( $this, 'aovis_enqueue_scripts' ) );
		
		add_action( 'elementor/widgets/register', array( $this, 'aovis_include_widgets' ) );
		
		add_filter( 'elementor/controls/animations/additional_animations', array( $this, 'aovis_add_animations'), 10 , 0 );

		add_action( 'wp_print_footer_scripts', array( $this, 'aovis_enqueue_footer_scripts' ) );

		// load icons
		add_filter( 'elementor/icons_manager/additional_tabs', array( $this, 'aovis_icons_filters_new' ), 9999999, 1 );

		// customize social icon control style
		add_action( 'elementor/element/social-icons/section_social_hover/after_section_end', array( $this, 'aovis_social_icons_custom' ), 10, 2 );

		// customize button control style
		add_action( 'elementor/element/button/section_button/after_section_end', array( $this, 'aovis_button_custom' ), 10, 2 );

		// customize text editor control style
		add_action( 'elementor/element/text-editor/section_style/after_section_end', array( $this, 'aovis_text_editor_custom' ), 10, 2 );

		// customize image box control style
		add_action( 'elementor/element/image-box/section_style_image/after_section_end', array( $this, 'aovis_image_box_custom' ), 10, 2 );

		// customize accordion control style
		add_action( 'elementor/element/accordion/section_toggle_style_content/after_section_end', array( $this, 'aovis_accordion_custom' ), 10, 2 );
	}

	
	function aovis_add_category(  ) {

	    \Elementor\Plugin::instance()->elements_manager->add_category(
	        'hf',
	        [
	            'title' => __( 'Header Footer', 'aovis' ),
	            'icon' => 'fa fa-plug',
	        ]
	    );

	    \Elementor\Plugin::instance()->elements_manager->add_category(
	        'aovis',
	        [
	            'title' => __( 'Aovis', 'aovis' ),
	            'icon' => 'fa fa-plug',
	        ]
	    );

	}

	function aovis_enqueue_scripts(){
        
        $files = glob(get_theme_file_path('/assets/js/elementor/*.js'));
        
        foreach ($files as $file) {
            $file_name = wp_basename($file);
            $handle    = str_replace(".js", '', $file_name);
            $src       = get_theme_file_uri('/assets/js/elementor/' . $file_name);
            if (file_exists($file)) {
                wp_register_script( 'aovis-elementor-' . $handle, $src, ['jquery'], false, true );
            }
        }


	}

	function aovis_include_widgets( $widgets_manager ) {
        $files = glob(get_theme_file_path('elementor/widgets/*.php'));
        foreach ($files as $file) {
            $file = get_theme_file_path('elementor/widgets/' . wp_basename($file));
            if (file_exists($file)) {
                require_once $file;
            }
        }
    }

    function aovis_add_animations(){
    	$animations = array(
            'Aovis' => array(
                'ova-move-up' 		=> esc_html__('Move Up', 'aovis'),
                'ova-move-down' 	=> esc_html__( 'Move Down', 'aovis' ),
                'ova-move-left'     => esc_html__('Move Left', 'aovis'),
                'ova-move-right'    => esc_html__('Move Right', 'aovis'),
                'ova-scale-up'      => esc_html__('Scale Up', 'aovis'),
                'ova-flip'          => esc_html__('Flip', 'aovis'),
                'ova-helix'         => esc_html__('Helix', 'aovis'),
                'ova-popup'			=> esc_html__( 'PopUp','aovis' )
            ),
        );

        return $animations;
    }

   

	function aovis_enqueue_footer_scripts(){
		// Font Icon
	    wp_enqueue_style('ovaicon', AOVIS_URI.'/assets/libs/ovaicon/font/ovaicon.css', array(), null);

	    // Flaticon
	    wp_enqueue_style('flaticon-aovis', AOVIS_URI.'/assets/libs/flaticon/font/flaticon_aovis.css', array(), null);
	}
	
	

	public function aovis_icons_filters_new( $tabs = array() ) {

		$newicons = [];
		$font_data['json_url'] = AOVIS_URI.'/assets/libs/ovaicon/ovaicon.json';
		$font_data['name'] = 'ovaicon';

		$newicons[ $font_data['name'] ] = [
			'name'          => $font_data['name'],
			'label'         => esc_html__( 'Default', 'aovis' ),
			'url'           => '',
			'enqueue'       => '',
			'prefix'        => 'ovaicon-',
			'displayPrefix' => '',
			'ver'           => '1.0',
			'fetchJson'     => $font_data['json_url'],	
		];
		
		// Flaticon
		$flaticon_data['json_url'] = AOVIS_URI.'/assets/libs/flaticon/flaticon_aovis.json';
		$flaticon_data['name'] = 'flaticon';

		$newicons[ $flaticon_data['name'] ] = [
			'name'          => $flaticon_data['name'],
			'label'         => esc_html__( 'Flaticon', 'aovis' ),
			'url'           => '',
			'enqueue'       => '',
			'prefix'        => 'flaticon-',
			'displayPrefix' => '',
			'ver'           => '1.0',
			'fetchJson'     => $flaticon_data['json_url'],
		];


		return array_merge( $tabs, $newicons );

	}

	function aovis_social_icons_custom ( $element, $args ) {
		/** @var \Elementor\Element_Base $element */
		$element->start_controls_section(
			'ova_social_icons',
			[
				'tab' 	=> \Elementor\Controls_Manager::TAB_STYLE,
				'label' => esc_html__( 'Ova Social Icon', 'aovis' ),
			]
		);

			$element->add_responsive_control(
	            'ova_social_icons_display',
	            [
	                'label' 	=> esc_html__( 'Display', 'aovis' ),
	                'type' 		=> \Elementor\Controls_Manager::CHOOSE,
	                'options' 	=> [
	                    'inline-block' => [
	                        'title' => esc_html__( 'Block', 'aovis' ),
	                        'icon' 	=> 'eicon-h-align-left',
	                    ],
	                    'inline-flex' => [
	                        'title' => esc_html__( 'Flex', 'aovis' ),
	                        'icon' 	=> 'eicon-h-align-center',
	                    ],
	                ],
	                'selectors' => [
	                    '{{WRAPPER}} .elementor-icon.elementor-social-icon' => 'display: {{VALUE}}',
	                ],
	            ]
	        );

		$element->end_controls_section();
	}

	function aovis_button_custom ( $element, $args ) {
		/** @var \Elementor\Element_Base $element */
		$element->start_controls_section(
			'ova_buton',
			[
				'tab' 	=> \Elementor\Controls_Manager::TAB_STYLE,
				'label' => esc_html__( 'Ova Button', 'aovis' ),
			]
		);  

		    $element->add_responsive_control(
	            'button_heading',
	            [
	                'label' 	=> esc_html__( 'Button', 'aovis' ),
	                'type' 		=> \Elementor\Controls_Manager::HEADING,
	            ]
	        );

			$element->add_responsive_control(
	            'button_display',
	            [
	                'label' 	=> esc_html__( 'Display', 'aovis' ),
	                'type' 		=> \Elementor\Controls_Manager::CHOOSE,
	                'options' 	=> [
	                    'block' => [
	                        'title' => esc_html__( 'Block', 'aovis' ),
	                        'icon' 	=> 'eicon-h-align-left',
	                    ],
	                    'flex' => [
	                        'title' => esc_html__( 'Flex', 'aovis' ),
	                        'icon' 	=> 'eicon-h-align-center',
	                    ],
	                ],
	                'selectors' => [
	                    '{{WRAPPER}} .elementor-button-wrapper' => 'display: {{VALUE}}',
	                ],
	            ]
	        );

	        $element->add_responsive_control(
				'button_width',
				[
					'label' => esc_html__( 'Width', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px','%' ],
					'range' => [
						'px' => [
							'min' => 100,
							'max' => 250,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .elementor-button-wrapper .elementor-button' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$element->add_responsive_control(
	            'button_icon_heading',
	            [
	                'label' 	=> esc_html__( 'Icon', 'aovis' ),
	                'type' 		=> \Elementor\Controls_Manager::HEADING,
	                'separator' => 'before'
	            ]
	        );

	        $element->add_responsive_control(
				'icon_size',
				[
					'label' => esc_html__( 'Size (px)', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 40,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .elementor-button-wrapper .elementor-button .elementor-button-icon i' => 'font-size: {{SIZE}}{{UNIT}}',
					],
				]
			);

			$element->add_control(
	            'icon_bg_color',
	            [
	                'label' 	=> esc_html__( 'Background Color', 'aovis' ),
	                'type' 		=> \Elementor\Controls_Manager::COLOR,
	                'selectors' => [
	                    '{{WRAPPER}} .elementor-button-wrapper .elementor-button .elementor-button-icon' => 'background-color: {{VALUE}};',
	                ],
	            ]
	        );

	        $element->add_control(
	            'icon_bg_color_hover',
	            [
	                'label' 	=> esc_html__( 'Background Color Hover', 'aovis' ),
	                'type' 		=> \Elementor\Controls_Manager::COLOR,
	                'selectors' => [
	                    '{{WRAPPER}} .elementor-button-wrapper .elementor-button:hover .elementor-button-icon' => 'background-color: {{VALUE}};',
	                ],
	            ]
	        );

	        $element->add_control(
	            'icon_bg_padding',
	            [
	                'label' 		=> esc_html__( 'Padding', 'aovis' ),
	                'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .elementor-button-wrapper .elementor-button .elementor-button-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

	        $element->add_control(
	            'icon_bg_border_radius',
	            [
	                'label' 		=> esc_html__( 'Border Radius', 'aovis' ),
	                'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .elementor-button-wrapper .elementor-button .elementor-button-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

		$element->end_controls_section();
	}

	// text-editor custom 
    function aovis_text_editor_custom( $element, $args ) {
		/** @var \Elementor\Element_Base $element */
		$element->start_controls_section(
			'ova_tabs',
			[
				'tab' 	=> \Elementor\Controls_Manager::TAB_STYLE,
				'label' => esc_html__( 'Ova Text Editor', 'aovis' ),
			]
		);

		   $element->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'link_typography',
					'selector' => '{{WRAPPER}} a',
				]
			);
            
            $element->add_control(
	            'link_color',
	            [
	                'label' 	=> esc_html__( 'Link Color', 'aovis' ),
	                'type' 		=> \Elementor\Controls_Manager::COLOR,
	                'selectors' => [
	                    '{{WRAPPER}} a' => 'color: {{VALUE}};',
	                ],
	            ]
	        );

	        $element->add_control(
	            'link_color_hover',
	            [
	                'label' 	=> esc_html__( 'Link Color Hover', 'aovis' ),
	                'type' 		=> \Elementor\Controls_Manager::COLOR,
	                'selectors' => [
	                    '{{WRAPPER}} a:hover' => 'color: {{VALUE}};',
	                ],
	            ]
	        );

			$element->add_responsive_control(
				'text_margin',
				[
					'label' 		=> esc_html__( 'Margin', 'aovis' ),
					'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px', '%', 'em' ],
					'selectors' 	=> [
					'{{WRAPPER}} p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$element->add_responsive_control(
		        'text_padding',
		        [
		            'label' 		=> esc_html__( 'Padding', 'aovis' ),
		            'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
		            'size_units' 	=> [ 'px', '%', 'em' ],
		            'selectors' 	=> [
		             '{{WRAPPER}}  p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		            ],
		         ]
		    );


		$element->end_controls_section();
	}

	// image box custom 
    function aovis_image_box_custom( $element, $args ) {
		/** @var \Elementor\Element_Base $element */
		$element->start_controls_section(
			'ova_image_box',
			[
				'tab' 	=> \Elementor\Controls_Manager::TAB_STYLE,
				'label' => esc_html__( 'Ova Image Box', 'aovis' ),
			]
		);   

		    $element->add_responsive_control(
				'image_box_size',
				[
					'label' => esc_html__( 'Image Size (px)', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 40,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .elementor-image-box-wrapper .elementor-image-box-img img' => 'width: {{SIZE}}{{UNIT}};min-width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$element->add_responsive_control(
				'object-fit',
				[
					'label' => esc_html__( 'Object Fit', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => [
						'' => esc_html__( 'Default', 'aovis' ),
						'fill' => esc_html__( 'Fill', 'aovis' ),
						'cover' => esc_html__( 'Cover', 'aovis' ),
						'contain' => esc_html__( 'Contain', 'aovis' ),
					],
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .elementor-image-box-wrapper .elementor-image-box-img img' => 'object-fit: {{VALUE}};',
					],
				]
			);

			$element->add_responsive_control(
				'image_padding',
				[
					'label' 		=> esc_html__( 'Image Padding', 'aovis' ),
					'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px', '%', 'em' ],
					'selectors' 	=> [
					'{{WRAPPER}} .elementor-image-box-wrapper .elementor-image-box-img img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$element->add_responsive_control(
				'title_margin',
				[
					'label' 		=> esc_html__( 'Title Margin', 'aovis' ),
					'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px', '%', 'em' ],
					'selectors' 	=> [
					'{{WRAPPER}} .elementor-image-box-wrapper .elementor-image-box-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

		$element->end_controls_section();
	}

	
    function aovis_accordion_custom( $element, $args ) {
		/** @var \Elementor\Element_Base $element */
		$element->start_controls_section(
			'ova_accordion',
			[
				'tab' 	=> \Elementor\Controls_Manager::TAB_STYLE,
				'label' => esc_html__( 'Ova Accordion', 'aovis' ),
			]
		); 

			$element->add_control(
				'title',
				[
					'label' => esc_html__( 'Title', 'aovis' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

				$element->add_group_control(
					\Elementor\Group_Control_Border::get_type(),
					[
						'name' => 'title_border',
						'selector' => '{{WRAPPER}} .elementor-accordion .elementor-tab-title , {{WRAPPER}} .elementor-accordion .elementor-tab-title.elementor-active', 
					]
				);
			$element->add_control(
				'content',
				[
					'label' => esc_html__( 'Active Content', 'aovis' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

				$element->add_group_control(
					\Elementor\Group_Control_Border::get_type(),
					[
						'name' => 'content_border',
						'selector' => '{{WRAPPER}} .elementor-accordion .elementor-tab-content.elementor-active',
					]
				);

			$element->add_control(
				'icon',
				[
					'label' => esc_html__( 'Icon', 'aovis' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

				$element->add_control(
					'icon_size',
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
							'{{WRAPPER}} .elementor-accordion .elementor-tab-title .elementor-accordion-icon' => 'font-size: {{SIZE}}{{UNIT}};',
						],
					]
				);

				$element->add_control(
					'icon_background_color',
					[
						'label' => esc_html__( 'Background Color', 'aovis' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .elementor-accordion .elementor-tab-title .elementor-accordion-icon i' => 'background-color: {{VALUE}}',
						],
					]
				);

				$element->add_control(
					'icon_background_color_active',
					[
						'label' => esc_html__( 'Background Color Active', 'aovis' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .elementor-accordion .elementor-tab-title .elementor-accordion-icon .elementor-accordion-icon-opened i' => 'background-color: {{VALUE}}',
						],
					]
				);

				$element->add_responsive_control(
					'icon_padding',
					[
						'label' 		=> esc_html__( 'Padding', 'aovis' ),
						'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
						'size_units' 	=> [ 'px', '%', 'em' ],
						'selectors' 	=> [
						'{{WRAPPER}} .elementor-accordion .elementor-tab-title .elementor-accordion-icon i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);

				$element->add_responsive_control(
					'icon_border_radius',
					[
						'label' 		=> esc_html__( 'Background Border Radius', 'aovis' ),
						'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
						'size_units' 	=> [ 'px', '%', 'em' ],
						'selectors' 	=> [
						'{{WRAPPER}} .elementor-accordion .elementor-tab-title .elementor-accordion-icon i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);

		$element->end_controls_section();  
	}
}

return new Aovis_Elementor();