<?php
namespace mb_elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Movie_List extends Widget_Base {

	public function get_name() {
		return 'movie_list';
	}

	public function get_title() {
		return esc_html__( 'Movies', 'moviebooking' );
	}

	public function get_icon() {
		return 'eicon-posts-grid';
	}

	public function get_categories() {
		return [ 'moviebooking' ];
	}

	public function get_script_depends() {
		return [''];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'moviebooking' ),
			]
		);

		$this->add_control(
			'show_only_featured',
			[
				'label' => esc_html__( 'Show Only Featured', 'moviebooking' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'moviebooking' ),
				'label_off' => esc_html__( 'Hide', 'moviebooking' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		// categories
		$categories = MB_Movie()->get_categories();
		$cate_array = array( 'all' => esc_html__('All categories','moviebooking') );

		if ($categories) {
			foreach ( $categories as $cate ) {
				$cate_array[$cate->slug] = $cate->cat_name;
			}
		} else {
			$cate_array["No content Category found"] = esc_html('No category found','moviebooking');
		}

		$this->add_control(
			'category',
			[
				'label'   => esc_html__( 'Category', 'moviebooking' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'all',
				'options' => $cate_array
			]
		);

		$this->add_control(
			'movie_status',
			[
				'label'   => esc_html__('Movie Status', 'moviebooking'),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'all' => esc_html__('All','moviebooking'),
					'now_playing'  => esc_html__('Now playing','moviebooking'),
					'coming_soon' => esc_html__('Coming soon','moviebooking'),
				],
				'default' => 'all',
			]
		);

		$this->add_control(
			'template',
			[
				'label' => esc_html__( 'Template', 'moviebooking' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'template1',
				'options' => [
					'template1' => esc_html__('Template 1', 'moviebooking'),
					'template2' => esc_html__('Template 2', 'moviebooking'),
					'template3' => esc_html__('Template 3', 'moviebooking'),
					'template4' => esc_html__('Template 4', 'moviebooking'),
				]
			]
		);

		$this->add_control(
			'number_column',
			[
				'label' => esc_html__( 'Number Column', 'moviebooking' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'three_column',
				'options' => [
					'two_column' => esc_html__('2 Column', 'moviebooking'),
					'three_column' => esc_html__('3 Column', 'moviebooking'),
					'four_column' => esc_html__('4 Column', 'moviebooking'),
				]
			]
		);

		$this->add_control(
			'total_count',
			[
				'label'   => esc_html__( 'Total', 'moviebooking' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3
			]
		);

		$this->add_control(
			'orderby',
			[
				'label' => esc_html__( 'OrderBy', 'moviebooking' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'ID',
				'options' => [
					'ID'  	=> esc_html__( 'ID', 'moviebooking' ),
					'title' => esc_html__( 'Title', 'moviebooking' ),
					'date'  => esc_html__( 'Date', 'moviebooking' ),
					'rand'  => esc_html__( 'Random', 'moviebooking' ),
					MB_PLUGIN_PREFIX_MOVIE.'release_date' => esc_html__( 'Release Date', 'moviebooking' ),
					MB_PLUGIN_PREFIX_MOVIE.'order' => esc_html__( 'Custom Order', 'moviebooking' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label' => esc_html__( 'Order', 'moviebooking' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'ASC'  => esc_html__( 'Ascending', 'moviebooking' ),
					'DESC'  => esc_html__( 'Descending', 'moviebooking' ),
				],
			]
		);

		$this->add_control(
			'offset',
			[
				'label'   => esc_html__( 'Offset', 'moviebooking' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 0
			]
		);

		$this->add_control(
			'item_background_image',
			[
				'label'   => esc_html__( 'Item Background Image', 'moviebooking' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'condition' => [
					'template' => 'template3',
				],
				'separator' => 'before'
			]
		);
		

        $this->end_controls_section();

        /* Begin Image Style */
		$this->start_controls_section(
            'movie_list_item_style',
            [
                'label' => esc_html__( 'Image', 'moviebooking' ),
                'tab' 	=> Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_responsive_control(
				'height_image',
				[
					'label' 		=> esc_html__( 'Height', 'moviebooking' ),
					'type' 			=> Controls_Manager::SLIDER,
					'size_units' 	=> [ 'px'],
					'range' => [
						'px' => [
							'min' => 320,
							'max' => 450,
							'step' => 1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .mb-movie-item .movie-image img' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'border_color_hover',
				[
					'label' 	=> esc_html__( 'Border Color Hover', 'moviebooking' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mb-movie-item:hover' => 'border-color: {{VALUE}};',
					],
					'condition' => [
	                	'template' => ['template1']
	                ]
				]
			);

	        $this->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'image_box_shadow',
					'selector' => '{{WRAPPER}} .mb-movie-item .movie-image',
				]
			);

        $this->end_controls_section();

        /* Begin title Style */
		$this->start_controls_section(
            'title_style_section',
            [
                'label' => esc_html__( 'Title', 'moviebooking' ),
                'tab' 	=> Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 		=> 'title_typography',
					'selector' 	=> '{{WRAPPER}} .mb-movie-item .movie-info .movie-title',
				]
			);

			$this->add_control(
				'title_color',
				[
					'label' 	=> esc_html__( 'Color', 'moviebooking' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mb-movie-item .movie-info .movie-title' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'title_color_hover',
				[
					'label' 	=> esc_html__( 'Color Hover', 'moviebooking' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mb-movie-item .movie-info .movie-title:hover' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_responsive_control(
	            'title_margin',
	            [
	                'label' 		=> esc_html__( 'Margin', 'moviebooking' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .mb-movie-item .movie-info .movie-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

        $this->end_controls_section();
		/* End title style */

		/* Begin meta tag Style */
		$this->start_controls_section(
            'meta_style_section',
            [
                'label' => esc_html__( 'Meta', 'moviebooking' ),
                'tab' 	=> Controls_Manager::TAB_STYLE,
                'condition' => [
                	'template!' => ['template4']
                ]
            ]
        );

            $this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 		=> 'meta_typography',
					'selector' 	=> '{{WRAPPER}} .mb-movie-item .categories-and-time',
				]
			);

			$this->add_control(
				'meta_color',
				[
					'label' 	=> esc_html__( 'Color', 'moviebooking' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mb-movie-item .categories-and-time' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'meta_link_color',
				[
					'label' 	=> esc_html__( 'Link Color', 'moviebooking' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mb-movie-item .categories-and-time .movie-category a' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'meta_link_color_hover',
				[
					'label' 	=> esc_html__( 'Link Color Hover', 'moviebooking' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mb-movie-item .categories-and-time .movie-category a:hover' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'icon_color',
				[
					'label' 	=> esc_html__( 'Icon Color', 'moviebooking' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mb-movie-item .movie-category:before, {{WRAPPER}} .mb-movie-item .running-time:before' => 'color: {{VALUE}};',
					],
					'condition' => [
	                	'template!' => ['template1']
	                ]
				]
			);

			$this->add_responsive_control(
	            'meta_margin',
	            [
	                'label' 		=> esc_html__( 'Margin', 'moviebooking' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .mb-movie-item .categories-and-time' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

        $this->end_controls_section();
		/* End meta style */

		/* Begin button Style */
		$this->start_controls_section(
            'button_style_section',
            [
                'label' => esc_html__( 'Button', 'moviebooking' ),
                'tab' 	=> Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 		=> 'button_typography',
					'selector' 	=> '{{WRAPPER}} .mb-movie-item .btn',
				]
			);

			$this->add_control(
				'button_color',
				[
					'label' 	=> esc_html__( 'Color', 'moviebooking' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mb-movie-item .btn' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'button_color_hover',
				[
					'label' 	=> esc_html__( 'Color Hover', 'moviebooking' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mb-movie-item .btn:hover' => 'color: {{VALUE}};',
					],
					'condition' => [
	                	'template!' => ['template1']
	                ]
				]
			);

			$this->add_control(
				'button_color_hover_template1',
				[
					'label' 	=> esc_html__( 'Color Hover', 'moviebooking' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mb-movie-item:hover .btn' => 'color: {{VALUE}};',
					],
					'condition' => [
	                	'template' => ['template1']
	                ]
				]
			);

			$this->add_control(
				'button_bgcolor',
				[
					'label' 	=> esc_html__( 'Background Color', 'moviebooking' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mb-movie-item .btn' => 'background-color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'button_bgcolor_hover',
				[
					'label' 	=> esc_html__( 'Background Color Hover', 'moviebooking' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mb-movie-item .btn:hover' => 'background-color: {{VALUE}};',
					],
					'condition' => [
	                	'template!' => ['template1']
	                ]
				]
			);

			$this->add_control(
				'button_bgcolor_hover_template1',
				[
					'label' 	=> esc_html__( 'Background Color Hover', 'moviebooking' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mb-movie-item:hover .btn' => 'background-color: {{VALUE}};',
					],
					'condition' => [
	                	'template' => ['template1']
	                ]
				]
			);

			$this->add_responsive_control(
	            'button_padding',
	            [
	                'label' 		=> esc_html__( 'Padding', 'moviebooking' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .mb-movie-item .btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

        $this->end_controls_section();
		/* End button style */

		
	}


	protected function render() {

		$settings = $this->get_settings();

		$template = apply_filters( 'elementor_movie_list', 'elementor/movie_list.php' );

		ob_start();
		mb_get_template( $template, $settings );
		echo ob_get_clean();
		
	}
}