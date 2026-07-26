<?php
namespace ova_ovaev_elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class ova_events_simple_calendar extends Widget_Base {


	public function get_name() {		
		return 'ova_events_simple_calendar';
	}

	public function get_title() {
		return esc_html__( 'Simple Calendar', 'ovaev' );
	}

	public function get_icon() {
		return 'eicon-posts-grid';
	}

	public function get_categories() {
		return [ 'ovatheme' ];
	}
	public function get_script_depends() {
		wp_enqueue_script( 'moment', OVAEV_PLUGIN_URI. 'assets/libs/calendar/moment.min.js', [ 'jquery' ], false, true );
		wp_enqueue_script( 'clndr', OVAEV_PLUGIN_URI.'assets/libs/calendar/clndr.min.js',  [ 'jquery' ], false, true );
		
		return [ 'script-elementor' ];
	}
	protected function register_controls() {

		$args = array(
           'taxonomy' 	=> 'event_category',
           'orderby' 	=> 'name',
           'order'   	=> 'ASC'
       	);
	
		$categories 	= get_categories($args);
		$categories_all = array( 'all' => 'All categories');
		$category_data 	= array();

		if ($categories) {
			foreach ( $categories as $category ) {
				$category_data[$category->slug] = $category->cat_name;
			}
		} else {
			$category_data["No content Category found"] = 0;
		}

	   
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'ovaev' ),
			]
		);

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
				'filter_event',
				[
					'label'   => esc_html__( 'Filter Event', 'ovaev' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'all',
					'options' => [
						'all'            => esc_html__( 'All', 'ovaev' ),
						'past_event' 	 => esc_html__( 'Past Event', 'ovaev' ),
						'upcoming_event' => esc_html__( 'Upcoming Event', 'ovaev' ),
						'special_event'  => esc_html__( 'Special Event', 'ovaev' ),					
					],
				]
			);
			
		$this->end_controls_section();

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Style', 'ovaev' ),
				'tab' 	=> \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'today_bg',
				[
					'label' 	=> esc_html__( 'Background Today', 'ovaev' ),
					'type' 		=> \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .cal1 .clndr .clndr-table tr .day.today.event' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'today_color',
				[
					'label' 	=> esc_html__( 'Today Color', 'ovaev' ),
					'type' 		=> \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .cal1 .clndr .clndr-table tr .day.today.event .day-contents' => 'color: {{VALUE}} !important',
					],
				]
			);

			$this->add_control(
				'event_bg',
				[
					'label' 	=> esc_html__( 'Background Event', 'ovaev' ),
					'type' 		=> \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .cal1 .clndr .clndr-table tr .day.event' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'event_color',
				[
					'label' 	=> esc_html__( 'Event Color', 'ovaev' ),
					'type' 		=> \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .cal1 .clndr .clndr-table tr .day.event .day-contents' => 'color: {{VALUE}} !important',
					],
				]
			);

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings();
		
		$template = apply_filters( 'elementor_ovaev_simple_calendar', 'elements/ovaev_events_simple_calendar.php' );

		ob_start();
		ovaev_get_template( $template, $settings );
		echo ob_get_clean();

	}
}
