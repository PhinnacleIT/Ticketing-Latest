<?php
namespace mb_elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class movie_filter_ajax extends Widget_Base {

	public function get_name() {
		return 'movie_filter_ajax';
	}

	public function get_title() {
		return esc_html__( 'Movie Filter Ajax', 'moviebooking' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_categories() {
		return [ 'moviebooking' ];
	}

	public function get_script_depends() {
		return [ 'script-elementor' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'moviebooking' ),
			]
		);

		// City
		$cities 	= MB_Showtime()->get_all_city();
		$city_array = array( 0 => esc_html__('All Cities','moviebooking') );
		$city_ids 	= array();

		if ($cities) {
			foreach ( $cities as $city ) {
				$city_array[$city->term_id] = $city->name;
				array_push($city_ids, $city->term_id);
			}
		} else {
			$city_array["No content city found"] = esc_html('No city found','moviebooking');
		}


		$this->add_control(
			'city',
			[
				'label'   => esc_html__( 'City', 'moviebooking' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 0,
				'options' => $city_array
			]
		);

		if ( $city_ids ) {
			foreach( $city_ids as $city_id ) {

				$data_venue = array();

				if ( $city_id ) {	

					$args_venue = array( 
			            'parent' => $city_id, 
			            'orderby' => 'title', 
                		'order' => 'DESC',
			            'hide_empty' => false 
			        );

					$venues = get_terms( 'movie_location', $args_venue );

					if ( $venues && is_array( $venues ) ) {
						foreach ( $venues as $venue ) {
							if ( is_object( $venue ) ) {
								$data_venue[$venue->term_id] = $venue->name;
							}
						}
					}				
				}

				if( empty($data_venue) ) {
					$data_venue = array( 0 => esc_html__('No venue found','moviebooking') );
				}
                
                // Venue
				$this->add_control(
					'city_value_'.esc_html($city_id),
					[
						'label' 	=> esc_html__( 'Venue', 'moviebooking' ),
						'type' 		=> \Elementor\Controls_Manager::SELECT,
						'default' 	=> array_key_first($data_venue),
						'options' 	=> $data_venue,
						'condition' => [
							'city' => (string)$city_id,
						]
					]
				);
			}
		}	

		$this->add_control(
			'date_filter_type',
			[
				'label'   => esc_html__('Date Filter Type', 'moviebooking'),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'weekdays' => esc_html__('Weekdays','moviebooking'),
					'fixed_period'  => esc_html__('Fixed Period','moviebooking'),	
				],
				'default' => 'weekdays',
			]
		);

		$this->add_control(
			'number_of_days',
			[
				'label'   => esc_html__('Number of Days', 'moviebooking'),
				'type'    => Controls_Manager::NUMBER,
				'min' => 3,
				'max' => 7,
				'default' => 5,
				'condition' => [
					'date_filter_type' => 'weekdays'
				]
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
				'default' => 6
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
			'demo_data_mode',
			[
				'label' => esc_html__( 'Demo Data Mode - Date Filter', 'moviebooking' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'moviebooking' ),
				'label_off' => esc_html__( 'Hide', 'moviebooking' ),
				'description' => esc_html__('Note*: ( This mode used for preview purpose only, when turned off will automatically get current date as today)', 'moviebooking'),
				'return_value' => 'yes',
				'default' => 'no',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'currentDate_demo',
			[
				'label' => esc_html__( 'Current Date', 'moviebooking' ),
				'type' => \Elementor\Controls_Manager::DATE_TIME,
				'description' => esc_html__('You can specify the current date instead of today', 'moviebooking'),
				'default' => '2023-03-28 00:00',
				'condition' => [
					'demo_data_mode' => 'yes'
				]
			]
		);

		$this->add_control(
			'text_today',
			[
				'label'   => esc_html__('Text Today', 'moviebooking'),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__('Today', 'moviebooking'),
				'condition' => [
					'date_filter_type' => 'fixed_period'
				],
				'separator' => 'before'
			]
		);

		$this->add_control(
			'text_this_week',
			[
				'label'   => esc_html__('Text This week', 'moviebooking'),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__('This week', 'moviebooking'),
				'condition' => [
					'date_filter_type' => 'fixed_period'
				]
			]
		);

		$this->add_control(
			'text_this_month',
			[
				'label'   => esc_html__('Text This month', 'moviebooking'),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__('This month', 'moviebooking'),
				'condition' => [
					'date_filter_type' => 'fixed_period'
				]
			]
		);
		

        $this->end_controls_section();

        /* Begin Filter Tabs Style */
		$this->start_controls_section(
            'filter_tabs_style',
            [
                'label' => esc_html__( 'Filter', 'moviebooking' ),
                'tab' 	=> Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_responsive_control(
				'filter_tabs_bottom_spacing',
				[
					'label' 		=> esc_html__( 'Bottom Spacing', 'moviebooking' ),
					'type' 			=> Controls_Manager::SLIDER,
					'size_units' 	=> [ 'px'],
					'range' => [
						'px' => [
							'min' => 35,
							'max' => 85,
							'step' => 1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .mb-button-filter-ajax.mb-date-tabs' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);

        $this->end_controls_section();

        /* Begin Image Style */
		$this->start_controls_section(
            'movie_filter_image_style',
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
				'image_border_color_hover',
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
        
        $city_id  = $settings['city'];
		$venue    = isset($settings['city_value_'.$city_id]) ? $settings['city_value_'.$city_id] : '';
		
		$settings['venue'] = $venue;

		$template = apply_filters( 'elementor_movie_filter_ajax', 'elementor/movie_filter_ajax.php' );

		ob_start();
		mb_get_template( $template, $settings );
		echo ob_get_clean();
		
	}
}