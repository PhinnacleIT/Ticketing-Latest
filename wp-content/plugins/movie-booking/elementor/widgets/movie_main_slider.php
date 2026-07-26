<?php
namespace mb_elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Movie_Main_Slider extends Widget_Base {

	public function get_name() {
		return 'movie_main_slider';
	}

	public function get_title() {
		return esc_html__( 'Movie Main Slider', 'moviebooking' );
	}

	public function get_icon() {
		return 'eicon-slider-video';
	}

	public function get_categories() {
		return [ 'moviebooking' ];
	}

	public function get_script_depends() {
		// Carousel
		wp_enqueue_style( 'slick-carousel', MB_PLUGIN_URI.'assets/libs/slick/slick.css' );
		wp_enqueue_style( 'slick-carousel-theme', MB_PLUGIN_URI.'assets/libs/slick/slick-theme.css' );
		wp_enqueue_script( 'slick-carousel', MB_PLUGIN_URI.'assets/libs/slick/slick.min.js', array('jquery'), false, true );
		return [ 'script-elementor' ];
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
				]
			]
		);

		$this->add_control(
			'total_count',
			[
				'label'   => esc_html__( 'Total', 'moviebooking' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 5
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
			'content_options',
			[
				'label' => esc_html__( 'Options', 'moviebooking' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_control(
			'show_share_social',
			[
				'label'   => esc_html__( 'Show Share Social', 'moviebooking' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'options' => [
					'yes' => esc_html__( 'Yes', 'moviebooking' ),
					'no'  => esc_html__( 'No', 'moviebooking' ),
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'text_share',
			[
				'label' => esc_html__( 'Text Share', 'moviebooking' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Share', 'moviebooking' ),
				'description' => esc_html__( 'Text share social icon', 'moviebooking' ),
				'condition' => [
					'show_share_social' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_category',
			[
				'label'   => esc_html__( 'Show Category', 'moviebooking' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'options' => [
					'yes' => esc_html__( 'Yes', 'moviebooking' ),
					'no'  => esc_html__( 'No', 'moviebooking' ),
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'category_suffix',
			[
				'label' => esc_html__( 'Category Suffix', 'moviebooking' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Movie', 'moviebooking' ),
				'description' => esc_html__( 'Text after movie category', 'moviebooking' ),
				'condition' => [
					'show_category' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_release_date',
			[
				'label'   => esc_html__( 'Show Release date', 'moviebooking' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'options' => [
					'yes' => esc_html__( 'Yes', 'moviebooking' ),
					'no'  => esc_html__( 'No', 'moviebooking' ),
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'text_release',
			[
				'label' => esc_html__( 'Text Release', 'moviebooking' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'In theater', 'moviebooking' ),
				'description' => esc_html__( 'Text before release date', 'moviebooking' ),
				'condition' => [
					'show_release_date' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_trailer',
			[
				'label'   => esc_html__( 'Show Trailer', 'moviebooking' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'options' => [
					'yes' => esc_html__( 'Yes', 'moviebooking' ),
					'no'  => esc_html__( 'No', 'moviebooking' ),
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'text_trailer',
			[
				'label' => esc_html__( 'Text Trailer', 'moviebooking' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Trailers', 'moviebooking' ),
				'condition' => [
					'show_trailer' => 'yes',
				],
			]
		);

		$this->add_control(
			'text_more_info',
			[
				'label' => esc_html__( 'Text More Info', 'moviebooking' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'More Info', 'moviebooking' ),
				'description' => esc_html__( 'Text more info button', 'moviebooking' ),
				'condition' => [
					'template' => 'template1',
				],
			]
		);

        $this->end_controls_section();


        /*****************************************************************
						START SECTION ADDITIONAL
		******************************************************************/

		$this->start_controls_section(
			'section_additional_options',
			[
				'label' => esc_html__( 'Additional Options', 'moviebooking' ),
			]
		);

			$this->add_control(
				'infinite',
				[
					'label'   => esc_html__( 'Infinite Loop', 'moviebooking' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'no',
					'options' => [
						'yes' => esc_html__( 'Yes', 'moviebooking' ),
						'no'  => esc_html__( 'No', 'moviebooking' ),
					],
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'pause_on_hover',
				[
					'label'   => esc_html__( 'Pause on Hover', 'moviebooking' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'yes',
					'options' => [
						'yes' => esc_html__( 'Yes', 'moviebooking' ),
						'no'  => esc_html__( 'No', 'moviebooking' ),
					],
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'autoplay',
				[
					'label'   => esc_html__( 'Autoplay', 'moviebooking' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'yes',
					'options' => [
						'yes' => esc_html__( 'Yes', 'moviebooking' ),
						'no'  => esc_html__( 'No', 'moviebooking' ),
					],
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'autoplay_speed',
				[
					'label'     => esc_html__( 'Autoplay Speed', 'moviebooking' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 6900,
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
					'label'   => esc_html__( 'Smart Speed', 'moviebooking' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 500,
				]
			);

		$this->end_controls_section();

		/****************************  END SECTION ADDITIONAL *********************/


		$this->start_controls_section(
			'section_category_style',
			[
				'label' => esc_html__( 'Category', 'moviebooking' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_category' => 'yes',
				],
			]
		);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' 		=> 'typography_category',
					'label' 	=> esc_html__( 'Typography', 'moviebooking' ),
					'selector' 	=> '{{WRAPPER}} .mb-movie-main-slider .movie-main-item .movie-category',
				]
			);

			$this->add_control(
				'color_category',
				[
					'label'	 	=> esc_html__( 'Color', 'moviebooking' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mb-movie-main-slider .movie-main-item .movie-category' => 'color : {{VALUE}};'
					],
				]
			);

			$this->add_responsive_control(
				'category_bottom',
				[
					'label' => esc_html__( 'Bottom', 'moviebooking' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ '%', 'px' ],
					'range' => [
						'px' => [
							'min' => -200,
							'max' => 200,
							'step' => 5,
						],
						'%' => [
							'min' => -100,
							'max' => 100,
							'step' => 2,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .mb-movie-main-slider .movie-main-item .movie-category' => 'bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'category_left',
				[
					'label' => esc_html__( 'Left', 'moviebooking' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ '%','px' ],
					'range' => [
						'px' => [
							'min' => -200,
							'max' => 200,
							'step' => 5,
						],
						'%' => [
							'min' => -100,
							'max' => 100,
							'step' => 2,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .mb-movie-main-slider .movie-main-item .movie-category' => 'left: {{SIZE}}{{UNIT}};',
					],
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
					'selector' 	=> '{{WRAPPER}} .mb-movie-main-slider .movie-main-item .movie-title',
				]
			);

			$this->add_control(
				'title_color',
				[
					'label' 	=> esc_html__( 'Color', 'moviebooking' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mb-movie-main-slider .movie-main-item .movie-title' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'title_color_hover',
				[
					'label' 	=> esc_html__( 'Color Hover', 'moviebooking' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mb-movie-main-slider .movie-main-item .movie-title:hover' => 'color: {{VALUE}};',
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
	                    '{{WRAPPER}} .mb-movie-main-slider .movie-main-item .movie-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

        $this->end_controls_section();
		/* End title style */

		/* Begin excerpt Style */
		$this->start_controls_section(
            'excerpt_style_section',
            [
                'label' => esc_html__( 'Excerpt', 'moviebooking' ),
                'tab' 	=> Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 		=> 'excerpt_typography',
					'selector' 	=> '{{WRAPPER}} .mb-movie-main-slider .movie-main-item .movie-excerpt',
				]
			);

			$this->add_control(
				'excerpt_color',
				[
					'label' 	=> esc_html__( 'Color', 'moviebooking' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mb-movie-main-slider .movie-main-item .movie-excerpt' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_responsive_control(
	            'excerpt_margin',
	            [
	                'label' 		=> esc_html__( 'Margin', 'moviebooking' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .mb-movie-main-slider .movie-main-item .movie-excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

        $this->end_controls_section();
		/* End excerpt style */

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
					'selector' 	=> '{{WRAPPER}} .mb-movie-main-slider .movie-main-item .button-wrapper .btn',
				]
			);

			$this->add_control(
				'button_color',
				[
					'label' 	=> esc_html__( 'Color', 'moviebooking' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mb-movie-main-slider .movie-main-item .button-wrapper .btn' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'button_color_hover',
				[
					'label' 	=> esc_html__( 'Color Hover', 'moviebooking' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mb-movie-main-slider .movie-main-item .button-wrapper .btn:hover' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'button_bgcolor',
				[
					'label' 	=> esc_html__( 'Background Color', 'moviebooking' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mb-movie-main-slider .movie-main-item .button-wrapper .btn' => 'background-color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'button_bgcolor_hover',
				[
					'label' 	=> esc_html__( 'Background Color Hover', 'moviebooking' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mb-movie-main-slider .movie-main-item .button-wrapper .btn:hover' => 'background-color: {{VALUE}};',
					],
				]
			);

			$this->add_responsive_control(
	            'button_padding',
	            [
	                'label' 		=> esc_html__( 'Padding', 'moviebooking' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .mb-movie-main-slider .movie-main-item .button-wrapper .btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

        $this->end_controls_section();
		/* End button style */

		/* Begin background Style */
		$this->start_controls_section(
            'background_style_section',
            [
                'label' => esc_html__( 'Background', 'moviebooking' ),
                'tab' 	=> Controls_Manager::TAB_STYLE,
            ]
        ); 

            $this->add_control(
				'background_bgcolor',
				[
					'label' 	=> esc_html__( 'Overlay Color', 'moviebooking' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mb-movie-main-slider .movie-main-item-wrapper' => 'background-color: {{VALUE}};',
					],
				]
			);

            $this->add_responsive_control(
				'background_image_opacity',
				[
					'label' => esc_html__( 'Opacity', 'moviebooking' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1,
							'step' => 5,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .mb-movie-main-slider .movie-main-item-wrapper img' => 'opacity: {{SIZE}}!important;',
					],
				]
			);

			$this->add_responsive_control(
	            'top_spacing',
	            [
	                'label' 		=> esc_html__( 'Top Spacing', 'moviebooking' ),
	                'type' 			=> Controls_Manager::SLIDER,
	                'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 120,
							'max' => 400,
							'step' => 5,
						],
					],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .mb-movie-main-slider .movie-main-item .movie-heading' => 'margin-top: {{SIZE}}{{UNIT}};',
	                ],
	            ]
	        );

	        $this->add_responsive_control(
	            'bottom_spacing',
	            [
	                'label' 		=> esc_html__( 'Bottom Spacing', 'moviebooking' ),
	                'type' 			=> Controls_Manager::SLIDER,
	                'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 120,
							'max' => 400,
							'step' => 0.1,
						],
					],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .mb-movie-main-slider .movie-main-item .button-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
	                ],
	            ]
	        );

        $this->end_controls_section();
		/* End background style */
		
	}


	protected function render() {

		$settings = $this->get_settings();

		$template = apply_filters( 'elementor_movie_main_slider', 'elementor/movie_main_slider.php' );

		ob_start();
		mb_get_template( $template, $settings );
		echo ob_get_clean();
		
	}
}