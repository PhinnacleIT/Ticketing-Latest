<?php
namespace mb_elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Movie_Cast_List extends Widget_Base {

	public function get_name() {
		return 'movie_cast_list';
	}

	public function get_title() {
		return esc_html__( 'Movie Cast List', 'moviebooking' );
	}

	public function get_icon() {
		return 'eicon-person';
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
			'number_column',
			[
				'label' => esc_html__( 'Number Column', 'moviebooking' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'four_column',
				'options' => [
					'three_column' => esc_html__('3 Column', 'moviebooking'),
					'four_column' => esc_html__('4 Column', 'moviebooking'),
				]
			]
		);

		$this->add_control(
			'total_number',
			[
				'label'   => esc_html__( 'Total', 'moviebooking' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 8,
				'description' => esc_html__( '( set is 0 to get all movie cast )', 'moviebooking' ),
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
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label' => esc_html__( 'Order', 'moviebooking' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'ASC',
				'options' => [
					'ASC'  => esc_html__( 'Ascending', 'moviebooking' ),
					'DESC'  => esc_html__( 'Descending', 'moviebooking' ),
				],
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
				'size_image',
				[
					'label' 		=> esc_html__( 'Size', 'moviebooking' ),
					'type' 			=> Controls_Manager::SLIDER,
					'size_units' 	=> [ 'px'],
					'range' => [
						'px' => [
							'min' =>60,
							'max' => 120,
							'step' => 1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .mb-movie-cast-list .cast-thumbnail img' => 'width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
	            'image_margin',
	            [
	                'label' 		=> esc_html__( 'Margin', 'moviebooking' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .mb-movie-cast-list .cast-thumbnail' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );


        $this->end_controls_section();

        /* Begin name Style */
		$this->start_controls_section(
            'name_style_section',
            [
                'label' => esc_html__( 'Cast Name', 'moviebooking' ),
                'tab' 	=> Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 		=> 'name_typography',
					'selector' 	=> '{{WRAPPER}} .mb-movie-cast-list .cast-info .cast-name',
				]
			);

			$this->add_control(
				'name_color',
				[
					'label' 	=> esc_html__( 'Color', 'moviebooking' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mb-movie-cast-list .cast-info .cast-name' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_responsive_control(
	            'name_margin',
	            [
	                'label' 		=> esc_html__( 'Margin', 'moviebooking' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .mb-movie-cast-list .cast-info .cast-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

        $this->end_controls_section();
		/* End name style */

		/* Begin description Style */
		$this->start_controls_section(
            'description_style_section',
            [
                'label' => esc_html__( 'Description', 'moviebooking' ),
                'tab' 	=> Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 		=> 'description_typography',
					'selector' 	=> '{{WRAPPER}} .mb-movie-cast-list .cast-info .cast-description',
				]
			);

			$this->add_control(
				'description_color',
				[
					'label' 	=> esc_html__( 'Color', 'moviebooking' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mb-movie-cast-list .cast-info .cast-description' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_responsive_control(
	            'description_margin',
	            [
	                'label' 		=> esc_html__( 'Margin', 'moviebooking' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .mb-movie-cast-list .cast-info .cast-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

        $this->end_controls_section();
		/* End description style */
		
	}


	protected function render() {

		$settings = $this->get_settings();

		$template = apply_filters( 'elementor_movie_cast_list', 'elementor/movie_cast_list.php' );

		ob_start();
		mb_get_template( $template, $settings );
		echo ob_get_clean();
		
	}
}