<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Aovis_Elementor_Blog extends Widget_Base {

	public function get_name() {
		return 'aovis_elementor_blog';
	}

	public function get_title() {
		return esc_html__( 'Blog', 'aovis' );
	}

	public function get_icon() {
		return 'eicon-posts-grid';
	}

	public function get_categories() {
		return [ 'aovis' ];
	}

	public function get_script_depends() {
		return [ '' ];
	}
	
	// Add Your Controll In This Function
	protected function register_controls() {

		$args = array(
			'orderby' => 'name',
			'order' => 'ASC'
		);

		$categories 	= get_categories($args);
		$cate_array 	= array( 'all' => esc_html__( 'All categories', 'aovis' ) );

		if ($categories) {
			foreach ( $categories as $cate ) {
				$cate_array[$cate->slug] = $cate->cat_name;
			}
		} else {
			$cate_array[ esc_html__( 'No content Category found', 'aovis' ) ] = 0;
		}

		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'aovis' ),
			]
		);	
			
			$this->add_control(
				  'category',
				[
					'label' => esc_html__( 'Category', 'aovis' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'all',
					'options' => $cate_array
				]
			);
  
			$this->add_control(
				'total_count',
				[
					'label' => esc_html__( 'Post Total', 'aovis' ),
					'type' => Controls_Manager::NUMBER,
					'default' => 3,
				]
			);
  
			$this->add_control(
				'number_column',
				[
					'label' => esc_html__( 'Columns', 'aovis' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'column_3',
					'options' => [
						'column_2' => esc_html__( '2 Columns', 'aovis' ),
						'column_3' => esc_html__( '3 Columns', 'aovis' ),
						'column_4' => esc_html__( '4 Columns', 'aovis' ),
					],
				]
			);
  
			$this->add_control(
				'order',
				[
					'label' => esc_html__('Order', 'aovis'),
					'type' => Controls_Manager::SELECT,
					'default' => 'desc',
					'options' => [
						'asc' => esc_html__('Ascending', 'aovis'),
						'desc' => esc_html__('Descending', 'aovis'),
					]
				]
			);

			$this->add_control(
				'order_by',
				[
					'label' 	=> esc_html__('Order By', 'aovis'),
					'type' 		=> \Elementor\Controls_Manager::SELECT,
					'default' 	=> 'ID',
					'options' 	=> [
						'none' => esc_html__('None', 'aovis'),
						'ID' 	=> esc_html__('ID', 'aovis'),
						'title' => esc_html__('Title', 'aovis'),
						'date' 	=> esc_html__('Date', 'aovis'),
						'modified' => esc_html__('Modified', 'aovis'),
						'rand' 	=> esc_html__('Rand', 'aovis'),
					]
				]
			);
  
			$this->add_control(
				'text_readmore',
				[
					'label' => esc_html__( 'Text Read More', 'aovis' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__('Read More', 'aovis'),
				]
			);
  
			$this->add_control(
				'show_comment',
				[
					'label' => esc_html__( 'Show Comment', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'aovis' ),
					'label_off' => esc_html__( 'Hide', 'aovis' ),
					'return_value' => 'yes',
					'default' => 'yes',
				]
			);
  
			$this->add_control(
				'show_date',
				[
					'label' => esc_html__( 'Show Date', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'aovis' ),
					'label_off' => esc_html__( 'Hide', 'aovis' ),
					'return_value' => 'yes',
					'default' => 'yes',
				]
			);
  
			$this->add_control(
				'show_author',
			 	[
					'label' => esc_html__( 'Show Author', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'aovis' ),
					'label_off' => esc_html__( 'Hide', 'aovis' ),
					'return_value' => 'yes',
				 'default' => 'yes',
				]
			);
 
			$this->add_control(
				'show_title',
				[
					'label' => esc_html__( 'Show Title', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'aovis' ),
					'label_off' => esc_html__( 'Hide', 'aovis' ),
					'return_value' => 'yes',
					'default' => 'yes',
				]
			);
  
			$this->add_control(
				'show_read_more',
				[
					'label' => esc_html__( 'Show Read More', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'aovis' ),
					'label_off' => esc_html__( 'Hide', 'aovis' ),
					'return_value' => 'yes',
					'default' => 'yes',
				]
			);

		$this->end_controls_section();

		/* Begin General Style */
		$this->start_controls_section(
			'general',
			[
				'label' => esc_html__( 'General', 'aovis' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
  
			$this->add_responsive_control(
				'general_align',
				[
					'label' 	=> esc_html__( 'Alignment', 'aovis' ),
					'type' 		=> \Elementor\Controls_Manager::CHOOSE,
					'options' 	=> [
						'left' => [
							'title' => esc_html__( 'Left', 'aovis' ),
							'icon' 	=> 'eicon-text-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'aovis' ),
							'icon' 	=> 'eicon-text-align-center',
						],
						'right' => [
							'title' => esc_html__( 'Right', 'aovis' ),
							'icon' 	=> 'eicon-text-align-right',
						],
						  
					],
					'toggle' 	=> true,
					'selectors' => [
						'{{WRAPPER}} .ova-blog .item .content' => 'text-align: {{VALUE}};',
					],
				]
			);

		  	$this->add_control(
				'general_spacing',
				[
					'label' => esc_html__( 'Spacing', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 60,
							'step' => 1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .ova-blog' => 'gap: {{SIZE}}{{UNIT}};',
					],
				]
			);

		  	$this->add_responsive_control(
			  	'general_padding',
			  	[
				  	'label' => esc_html__( 'Padding', 'aovis' ),
				  	'type' => Controls_Manager::DIMENSIONS,
				  	'size_units' => [ 'px', 'em', '%' ],
				  	'selectors' => [
					  	'{{WRAPPER}} .ova-blog .item .content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				  	],
			  	]
		  	);

		  	$this->start_controls_tabs(
				'general_tabs',
			);

				$this->start_controls_tab(
					'general_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'aovis' ),
					]
				);

					$this->add_control(
						'general_overlay',
						[
							'label' => esc_html__( 'Overlay Color', 'aovis' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ova-blog .item .media .box-img .overlay' => 'background-color: {{VALUE}}',
							],
						]
					);

					$this->add_group_control(
						\Elementor\Group_Control_Box_Shadow::get_type(),
						[
							'name' => 'general_box_shadow',
							'selector' => '{{WRAPPER}} .ova-blog .item',
						]
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'general_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'aovis' ),
					]
				);

					$this->add_control(
						'general_overlay_hover',
						[
							'label' => esc_html__( 'Overlay Color', 'aovis' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ova-blog .item:hover .media .box-img .overlay' => 'background-color: {{VALUE}}',
							],
						]
					);

					$this->add_group_control(
						\Elementor\Group_Control_Box_Shadow::get_type(),
						[
							'name' => 'general_box_shadow_hover',
							'selector' => '{{WRAPPER}} .ova-blog .item:hover',
						]
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();

		// DATE TAB
		$this->start_controls_section(
		'date_section',
		    [
			    'label' => esc_html__( 'Date', 'aovis' ),
			    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
		    ]
	    );

			$this->add_group_control(
			    \Elementor\Group_Control_Typography::get_type(),
			    [
				    'name' => 'date_typography',
				    'selector' => '{{WRAPPER}} .ova-blog .item .media .post-date .date', 
			    ]
		    );

		    $this->add_control(
			    'date_color',
			    [
				    'label' => esc_html__( 'Color', 'aovis' ),
				    'type' => \Elementor\Controls_Manager::COLOR,
				    'selectors' => [
					    '{{WRAPPER}} .ova-blog .item .media .post-date .date' => 'color : {{VALUE}};',
				    ],
			    ]
		    );
  
			$this->add_control(
				  'date_background_color',
				  [
					  'label' => esc_html__( 'Background', 'aovis' ),
					  'type' => \Elementor\Controls_Manager::COLOR,
					  'selectors' => [
						  '{{WRAPPER}} .ova-blog .item .media .post-date .date' => 'background-color : {{VALUE}};',
					  ],
				  ]
			);

			$this->add_control(
				'date_padding',
				[
					'label' => esc_html__( 'Padding', 'aovis' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em', 'rem' ],
					'selectors' => [
						'{{WRAPPER}} .ova-blog .item .media .post-date .date' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'date_position_heading',
				[
					'label' => esc_html__( 'Position', 'aovis' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_control(
				'date_position_right',
				[
					'label' => esc_html__( 'Right', 'aovis' ),
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
						'{{WRAPPER}} .ova-blog .item .media .post-date' => 'right: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'date_position_bottom',
				[
					'label' => esc_html__( 'Bottom', 'aovis' ),
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
						'{{WRAPPER}} .ova-blog .item .media .post-date' => 'bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);

		$this->end_controls_section(); 
		// END date Tab

		$this->start_controls_section(
			    'section_author',
			    [
				    'label' => esc_html__( 'Author', 'aovis' ),
				    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			    ]
			);

			$this->add_control(
				'author_spacing',
				[
					'label' => esc_html__( 'Spacing', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%' ],
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
						'{{WRAPPER}} .ova-blog .item .content .post-meta .item-meta.wp-author' => 'gap: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'author_padding',
				[
					'label' => esc_html__( 'Padding', 'aovis' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em', 'rem' ],
					'selectors' => [
						'{{WRAPPER}} .ova-blog .item .content .post-meta .item-meta.wp-author' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'author_border',
					'selector' => '{{WRAPPER}} .ova-blog .item .content .post-meta .item-meta.wp-author',
				]
			);

			$this->add_control(
				'author_image_heading',
				[
					'label' => esc_html__( 'Image', 'aovis' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_control(
				'author_image_size',
				[
					'label' => esc_html__( 'Size', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%' ],
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
						'{{WRAPPER}} .ova-blog .item .content .post-meta .item-meta.wp-author .author img' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'author_image_border',
					'selector' => '{{WRAPPER}} .ova-blog .item .content .post-meta .item-meta.wp-author .author img',
				]
			);

			$this->add_control(
				'author_image_border_radius',
				[
					'label' => esc_html__( 'Border Radius', 'aovis' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em', 'rem' ],
					'selectors' => [
						'{{WRAPPER}} .ova-blog .item .content .post-meta .item-meta.wp-author .author img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'author_image_box_shadow',
					'selector' => '{{WRAPPER}} .ova-blog .item .content .post-meta .item-meta.wp-author .author img',
				]
			);

			$this->add_control(
				'author_info_heading',
				[
					'label' => esc_html__( 'Info', 'aovis' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'author_info_typography',
					'selector' => '{{WRAPPER}} .ova-blog .item .content .post-meta .item-meta.wp-author .post-author',
				]
			);

			$this->add_control(
				'author_info_color',
				[
					'label' => esc_html__( 'Color', 'aovis' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-blog .item .content .post-meta .item-meta.wp-author .post-author' => 'color: {{VALUE}}',
						'{{WRAPPER}} .ova-blog .item .content .post-meta .item-meta.wp-author .post-author a' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'author_info_color_hover',
				[
					'label' => esc_html__( 'Hover Color', 'aovis' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-blog .item .content .post-meta .item-meta.wp-author .post-author a:hover' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'author_info_margin',
				[
					'label' => esc_html__( 'Margin', 'aovis' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em', 'rem' ],
					'selectors' => [
						'{{WRAPPER}} .ova-blog .item .content .post-meta .item-meta.wp-author .post-author' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
		'section_comment',
		    [
			    'label' => esc_html__( 'Comment', 'aovis' ),
			    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
		    ]
		);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'comment_typography',
					'selector' => '{{WRAPPER}} .ova-blog .item .content .post-meta .item-meta.post-comment',
				]
			);

			$this->add_control(
				'icon_comment_color',
				[
					'label' => esc_html__( 'Icon Color', 'aovis' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-blog .item .content .post-meta .item-meta.post-comment .left i' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'link_comment_color',
				[
					'label' => esc_html__( 'Link Color', 'aovis' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-blog .item .content .post-meta .item-meta.post-comment .right a' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'comment_color_hover',
				[
					'label' => esc_html__( 'Link Color Hover', 'aovis' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-blog .item .content .post-meta .item-meta.post-comment .right a:hover' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'comment_margin',
				[
					'label' => esc_html__( 'Margin', 'aovis' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em', 'rem' ],
					'selectors' => [
						'{{WRAPPER}} .ova-blog .item .content .post-meta .item-meta.post-comment' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

		$this->end_controls_section();

		//SECTION TAB STYLE TITLE
		  	$this->start_controls_section(
			  	'section_title',
			  	[
				  	'label' => esc_html__( 'Title', 'aovis' ),
				  	'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			  	]
		  	);
  
				$this->add_group_control(
					\Elementor\Group_Control_Typography::get_type(),
					[
						'name' => 'title_typography',
						'selector' => '{{WRAPPER}} .ova-blog .item .content .post-title a',
					]
				);
  
				$this->add_control(
					  'color_title',
					  [
						  'label' => esc_html__( 'Color', 'aovis' ),
						  'type' => \Elementor\Controls_Manager::COLOR,
						  'selectors' => [
							  '{{WRAPPER}} .ova-blog .item .content .post-title a' => 'color : {{VALUE}};',
						  ],
					  ]
				);
		  
				$this->add_control(
					  'color_title_hover',
					  [
						  'label' => esc_html__( 'Color Hover', 'aovis' ),
						  'type' => \Elementor\Controls_Manager::COLOR,
						  'selectors' => [
							  '{{WRAPPER}} .ova-blog .item .content .post-title a:hover ' => 'color : {{VALUE}};',
						  ],
					  ]
				);
		  
				$this->add_responsive_control(
					  'margin_title',
					  [
						  'label' => esc_html__( 'Margin', 'aovis' ),
						  'type' => \Elementor\Controls_Manager::DIMENSIONS,
						  'size_units' => [ 'px', 'em', '%' ],
						  'selectors' => [
							  '{{WRAPPER}} .ova-blog .item .content .post-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						  ],
					  ]
				);
  
		    $this->end_controls_section();
	  
		    //SECTION TAB STYLE READMORE
		    $this->start_controls_section(
			    'section_readmore',
			    [
				    'label' => esc_html__( 'Read More', 'aovis' ),
				    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			    ]
		    );
  
				$this->add_group_control(
					\Elementor\Group_Control_Typography::get_type(),
					[
					  'name' => 'readmore_typography',
					  'selector' => '{{WRAPPER}} .ova-blog .item .content .read-more a', 
					]
				);

				$this->add_responsive_control(
				  	'padding_read_more',
					[
						'label' => esc_html__( 'Padding', 'aovis' ),
						'type' => \Elementor\Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', 'em', '%' ],
						'selectors' => [
							'{{WRAPPER}} .ova-blog .item .content .read-more a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
  
			  	$this->add_responsive_control(
				  	'margin_read_more',
					[
						'label' => esc_html__( 'Margin', 'aovis' ),
						'type' => \Elementor\Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', 'em', '%' ],
						'selectors' => [
							'{{WRAPPER}} .ova-blog .item .content .read-more' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);

			  	$this->start_controls_tabs(
					'read_more_tabs'
				);

					$this->start_controls_tab(
						'style_normal_tab',
						[
							'label' => esc_html__( 'Normal', 'aovis' ),
						]
					);

						$this->add_control(
							'color_read_more',
							[
								'label' => esc_html__( 'Color', 'aovis' ),
								'type' => \Elementor\Controls_Manager::COLOR,
								'selectors' => [
									'{{WRAPPER}} .ova-blog .item .content .read-more a' => 'color : {{VALUE}};',
								],
							]
						);

						$this->add_control(
							'background_color_read_more',
							[
								'label' => esc_html__( 'Background', 'aovis' ),
								'type' => \Elementor\Controls_Manager::COLOR,
								'selectors' => [
									'{{WRAPPER}} .ova-blog .item .content .read-more ' => 'background-color : {{VALUE}};',
								],
							]
						);

						$this->add_control(
							'line_decoration_color',
							[
								'label' => esc_html__( 'Line Decoration Color', 'aovis' ),
								'type' => \Elementor\Controls_Manager::COLOR,
								'selectors' => [
									'{{WRAPPER}}  .ova-blog .item .content .read-more:after' => 'background-color : {{VALUE}};',
									'{{WRAPPER}}  .ova-blog .item .content .read-more:before' => 'background-color : {{VALUE}};',
								],
							]
						);

					$this->end_controls_tab();

					$this->start_controls_tab(
						'style_hover_tab',
						[
							'label' => esc_html__( 'Hover', 'aovis' ),
						]
					);

						$this->add_control(
							'color_read_more_hover',
							[
								'label' => esc_html__( 'Color', 'aovis' ),
								'type' => \Elementor\Controls_Manager::COLOR,
								'selectors' => [
									'{{WRAPPER}} .ova-blog .item .content .read-more:hover a' => 'color : {{VALUE}};',
								],
							]
						);

						$this->add_control(
							'background_color_read_more_hover',
							[
								'label' => esc_html__( 'Background', 'aovis' ),
								'type' => \Elementor\Controls_Manager::COLOR,
								'selectors' => [
									'{{WRAPPER}} .ova-blog .item .content .read-more:hover ' => 'background-color : {{VALUE}};',
								],
							]
						);

						$this->add_control(
							'line_decoration_color_hover',
							[
								'label' => esc_html__( 'Line Decoration Color', 'aovis' ),
								'type' => \Elementor\Controls_Manager::COLOR,
								'selectors' => [
									'{{WRAPPER}}  .ova-blog .item .content .read-more:hover:after' => 'background-color : {{VALUE}};',
									'{{WRAPPER}}  .ova-blog .item .content .read-more:hover:before' => 'background-color : {{VALUE}};',
								],
							]
						);
						
					$this->end_controls_tab();

				$this->end_controls_tabs();
  
		  $this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings();

		$category 			= 	$settings['category'];
		$total_count 		= 	$settings['total_count'];
		$order 				= 	$settings['order'];
		$order_by 			= 	$settings['order_by'];
		$number_column 		= 	$settings['number_column'];

		$show_date 			= 	$settings['show_date'];
		$show_author 		= 	$settings['show_author'];
		$show_title 		= 	$settings['show_title'];
		$show_comment 		= 	$settings['show_comment'];
		$show_read_more		= 	$settings['show_read_more'];
		$text_readmore 		= 	$settings['text_readmore'];

		$args = [];
			
		if ($category == 'all') {
		  	$args = [
			  	'post_type' 		=> 'post',
			  	'post_status'       => 'publish',
			  	'posts_per_page' 	=> $total_count,
			  	'order' 			=> $order,
			  	'orderby' 			=> $order_by,
		  	];
		} else {
		  	$args = [
			  	'post_type' 		=> 	'post',
			  	'post_status'       => 'publish',
			  	'category_name'		=>	$category,
			  	'posts_per_page' 	=> 	$total_count,
			  	'order' 			=> 	$order,
			  	'orderby' 			=> $order_by,
			  	'fields'			=> 	'ids'
		  	];
		}

		$blog = new \WP_Query($args);

		?>
			<ul class="ova-blog ova-<?php echo esc_attr( $number_column ); ?>">
				<?php
				  	if($blog->have_posts()) : while($blog->have_posts()) : $blog->the_post();
			  	?>
				  	<li class="item">

				  		<div class="media">

						  	<?php
						  	    $post_id   = get_the_ID();
						  		$size_img  = 'large' ;
							  	$thumbnail = wp_get_attachment_image_url(get_post_thumbnail_id() , $size_img );
							  	$url_thumb = $thumbnail ? $thumbnail : \Elementor\Utils::get_placeholder_image_src();
						  	?>
						  	<div class="box-img">

						  		<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
								  	<img src="<?php echo esc_url( $url_thumb ) ?>" alt="<?php the_title(); ?>">
							  	</a>

							  	<div class="overlay"></div>

						  	</div>

							<?php if( $show_date == 'yes' ){ ?>
								<div class="post-date">
									<span class="date"><?php the_time(' j M, Y ');?></span>
								</div>
							<?php  } ?>

					  	</div>

					  	<div class="content">

					  		<ul class="post-meta">
							
							  	<?php if( $show_author == 'yes' ){ ?>
								    <li class="item-meta wp-author">
									    <span class="left author">
										     <?php  echo get_avatar(get_the_author_meta('ID')); ?>
									    </span>
									    <span class="right post-author">
									  		<span class="by"><?php echo esc_html__('by', 'aovis'); ?></span>
									  		
										  	<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
											  	<?php the_author_meta( 'display_name' ); ?>
										  	</a>
									    </span>
								    </li>
						  		<?php } ;?>

							  	<?php if( $show_comment == 'yes' ): ?>
								  	<li class="item-meta  post-comment">
									  	<span class="left comment">
										  	<i class="fas fa-comments"></i>
									  	</span>
									  	<span class="right comment">
										  	<?php
										  		comments_popup_link(
											  	esc_html__('0 Comments', 'aovis'), 
											  	esc_html__('1 Comments', 'aovis'), 
											  	'%',
											  	'Comments',
											  	esc_html__( 'Comment off', 'aovis' ) )
										  	; ?> 
									  	</span>            
								  	</li>
							  	<?php endif; ?>

						  	</ul>
					  		
					  		<?php if( $show_title == 'yes' ){ ?>

								<h2 class="post-title">

									<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
										<?php the_title(); ?>
									</a>

								</h2>

							<?php } ?>

							<?php if( $show_read_more == 'yes' ){ ?>	

								<div class="read-more" >

									<a href="<?php the_permalink(); ?>">
										<?php echo esc_html( $text_readmore ); ?>		
									</a>	

								</div>

							<?php }?>	

					  	</div>
				  		
				  	</li>
				<?php
				  	endwhile; endif; wp_reset_postdata();
			    ?>
			</ul>
		<?php
	}
}
$widgets_manager->register( new Aovis_Elementor_Blog() );