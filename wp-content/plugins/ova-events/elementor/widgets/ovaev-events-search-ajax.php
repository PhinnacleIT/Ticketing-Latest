<?php
namespace ova_ovaev_elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class ova_events_search_ajax extends Widget_Base {

	public function get_name() {
		return 'ova_events_search_ajax';
	}

	public function get_title() {
		return esc_html__( 'Search Ajax', 'ovaev' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_categories() {
		return [ 'ovatheme' ];
	}

	public function get_script_depends() {
		wp_enqueue_style( 'datetimepicker', OVAEV_PLUGIN_URI.'assets/libs/datetimepicker/jquery.datetimepicker.css' );
		wp_enqueue_script( 'datetimepicker', OVAEV_PLUGIN_URI.'assets/libs/datetimepicker/jquery.datetimepicker.js', array('jquery'), false, true );
		return [ 'script-elementor' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_setting',
			[
				'label' => esc_html__( 'Settings', 'ovaev' ),
			]
		);

			$this->add_control(
				'layout',
				[
					'label'   => esc_html__('Layout', 'ovaev'),
					'type'    => Controls_Manager::SELECT,
					'options' => [
						'1'   => esc_html__('Layout 1','ovaev'),
						'2'   => esc_html__('Layout 2','ovaev'),
					],
					'default' => '2',
				]
			);

			$this->add_control(
				'column',
				[
					'label'   => esc_html__('Column', 'ovaev'),
					'type'    => Controls_Manager::SELECT,
					'options' => [
						'col1'   => esc_html__('1 Column','ovaev'),
						'col2'   => esc_html__('2 Columns','ovaev'),
						'col3'   => esc_html__('3 Columns','ovaev'),
					],
					'default' => 'col3',
				]
			);

			$this->add_control(
				'heading_setting_post',
				[
					'label' 	=> esc_html__( 'Setting Post', 'ovaev' ),
					'type' 		=> Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$args = array(
	           'taxonomy' => 'event_category',
	           'orderby' => 'name',
	           'order'   => 'ASC'
	       	);
		
			$categories 	= get_categories($args);
			$categories_all = array( 'all' => 'All');
			$category_data 	= array();

			if ( $categories ) {
				foreach ( $categories as $category ) {
					$category_data[$category->slug] = $category->cat_name;
				}
			} else {
				$category_data["No content Category found"] = 0;
			}

			$this->add_control(
				'category',
				[
					'label'   => esc_html__( 'Category', 'ovaev' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'all',
					'options' => array_merge( $categories_all, $category_data )
				]
			);

			$this->add_control(
				'time_event',
				[
					'label'   => esc_html__('Choose time', 'ovaev'),
					'type'    => Controls_Manager::SELECT,
					'options' => [
						'all'    	=> esc_html__('All','ovaev'),
						'current'  	=> esc_html__('Current','ovaev'),
						'upcoming' 	=> esc_html__('Upcoming','ovaev'),
						'past'     	=> esc_html__('Past','ovaev'),
					],
					'default'   => 'all',
				]
			);

			$this->add_control(
				'posts_per_page',
				[
					'label' 	=> esc_html__( 'Posts Per Page', 'ovaev' ),
					'type' 		=> Controls_Manager::NUMBER,
					'default' 	=> 9,
				]
			);

			$this->add_control(
				'order_by',
				[
					'label'   => esc_html__( 'Order By', 'ovaev' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'ID',
					'options' => [
						'ID'  => esc_html__( 'ID', 'ovaev' ),			
						'title' => esc_html__( 'Title', 'ovaev' ),
						'event_custom_sort' => esc_html__( 'Custom Sort', 'ovaev' ),
						'ovaev_start_date_time' => esc_html__( 'Start Date', 'ovaev' ),			
					],
				]
			);

			$this->add_control(
				'order',
				[
					'label' 	=> esc_html__( 'Order Post', 'ovaev' ),
					'type' 		=> Controls_Manager::SELECT,
					'default' 	=> 'DESC',
					'options' 	=> [
						'ASC' 	=> esc_html__( 'Ascending', 'ovaev' ),
						'DESC'  => esc_html__( 'Descending', 'ovaev' ),
					],
				]
			);
		
		$this->end_controls_section();

		$this->start_controls_section(
			'section_filters_style',
			[
				'label' => esc_html__( 'Filters', 'ovaev' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
	            'filters_background',
	            [
	                'label' 	=> esc_html__( 'Background', 'ovaev' ),
	                'type' 		=> Controls_Manager::COLOR,
	                'selectors' => [
	                    '{{WRAPPER}} .ovaev-wrapper-search-ajax .search_archive_event' => 'background-color: {{VALUE}};',
	                ],
	            ]
	        );

	        $this->add_group_control(
	            Group_Control_Border::get_type(), [
	                'name' 		=> 'filters_border',
	                'selector' 	=> '{{WRAPPER}} .ovaev-wrapper-search-ajax .search_archive_event',
	                'separator' => 'before',
	            ]
	        );

	        $this->add_control(
	            'filters_border_radius',
	            [
	                'label' 		=> esc_html__( 'Border Radius', 'ovaev' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .ovaev-wrapper-search-ajax .search_archive_event' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

	        $this->add_responsive_control(
	            'filters_padding',
	            [
	                'label' 		=> esc_html__( 'Padding', 'ovaev' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .ovaev-wrapper-search-ajax .search_archive_event' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

	        $this->add_responsive_control(
	            'filters_margin',
	            [
	                'label' 		=> esc_html__( 'Margin', 'ovaev' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .ovaev-wrapper-search-ajax .search_archive_event' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

	        $this->add_control(
				'filter_label',
				[
					'label' 	=> esc_html__( 'Label', 'ovaev' ),
					'type' 		=> \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

		        $this->add_control(
		            'filters_color',
		            [
		                'label' 	=> esc_html__( 'Color', 'ovaev' ),
		                'type' 		=> Controls_Manager::COLOR,
		                'selectors' => [
		                    '{{WRAPPER}} .ovaev-wrapper-search-ajax .search_archive_event form .ova-label-search' => 'color: {{VALUE}};',
		                ],
		            ]
		        );

		        $this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'name' 		=> 'labels_typography',
						'selector' 	=> '{{WRAPPER}} .ovaev-wrapper-search-ajax .search_archive_event form .ova-label-search',
					]
				);

		        $this->add_responsive_control(
		            'filters_label_margin',
		            [
		                'label' 		=> esc_html__( 'Margin', 'ovaev' ),
		                'type' 			=> Controls_Manager::DIMENSIONS,
		                'size_units' 	=> [ 'px', '%', 'em' ],
		                'selectors' 	=> [
		                    '{{WRAPPER}} .ovaev-wrapper-search-ajax .search_archive_event form .ova-label-search' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		                ],
		            ]
		        );

		$this->end_controls_section();

	}

	public function get_data_ajax() {
		$settings = $this->get_settings();
		
		//data post
		$posts_per_page = $settings['posts_per_page'];
		$order_post 	= $settings['order'];
		$orderby 		= $settings['order_by'];
		$category_slug 	= $settings['category'];
		$time_event 	= $settings['time_event'];

		$args = array(
			'post_type' 		=> 'event',
			'post_status' 		=> 'publish',
			'posts_per_page' 	=> $posts_per_page,
			'order' 			=> $order_post,
			'offset'			=> 0,
		);

		switch ( $orderby ) {
			case 'title':
				$args['orderby'] = $orderby;
			break;

			case 'event_custom_sort':
				$args['orderby'] 	= 'meta_value';
				$args['meta_key'] 	= $orderby;
			break;

			case 'ovaev_start_date_time':
				$args['orderby'] 	= 'meta_value';
				$args['meta_key'] 	= $orderby;
			break;
			
			case 'ID':
				$args['orderby'] = $orderby;
			break;	
		}


		if ( 'all' != $category_slug ) {
			$args['tax_query'] = array(
				array(
                    'taxonomy' => 'event_category',
                    'field'    => 'slug',
                    'terms'    => $category_slug,
                ),
			);
        }

        if ( 'current' === $time_event ) {
        	$args['meta_query'] = array(
                array(
                    'relation' => 'OR',
                    array(
                        'key'     => 'ovaev_start_date_time',
                        'value'   => array( current_time('timestamp' )-1, current_time('timestamp' )+(24*60*60)+1 ),
                        'type'    => 'numeric',
                        'compare' => 'BETWEEN'  
                    ),
                    array(
                        'relation' => 'AND',
                        array(
                            'key'     => 'ovaev_start_date_time',
                            'value'   => current_time('timestamp' ),
                            'compare' => '<'
                        ),
                        array(
                            'key'     => 'ovaev_end_date_time',
                            'value'   => current_time('timestamp' ),
                            'compare' => '>='
                        ),
                    ),
                ),
            );
        } elseif ( 'upcoming' === $time_event ) {
        	$args['meta_query'] = array(
                array(
                    array(
                        'key'     => 'ovaev_start_date_time',
                        'value'   => current_time( 'timestamp' ),
                        'compare' => '>'
                    ),  
                ),
            );
        } elseif ( 'past' === $time_event ) {
        	$args['meta_query'] = array(
                array(
                    'key'     => 'ovaev_end_date_time',
                    'value'   => current_time('timestamp' ),
                    'compare' => '<',                   
                ),
            );
        }

		$events = new \WP_Query( $args );

		$data = [
			'events' 	=> $events,
			'settings' 	=> $settings,
		];

		return $data;
	}

	protected function render() {

		$settings = $this->get_data_ajax();

		$template = apply_filters( 'elementor_ovaev_search_ajax', 'elements/ovaev_events_search_ajax.php' );
		ob_start();
		ovaev_get_template( $template, $settings );
		echo ob_get_clean();
	}
}