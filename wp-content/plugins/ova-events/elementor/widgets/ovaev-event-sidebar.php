<?php
namespace ova_ovaev_elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class ova_event_sidebar extends Widget_Base {

	public function get_name() {		
		return 'ova_event_sidebar';
	}

	public function get_title() {
		return esc_html__( 'Event Sidebar', 'ovaev' );
	}

	public function get_icon() {
		return 'eicon-sidebar';
	}

	public function get_categories() {
		return [ 'ovaev_template' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_sidebar_style',
			[
				'label' => esc_html__( 'Sidebar', 'ovaev' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
	            'sidebar_background',
	            [
	                'label' 	=> esc_html__( 'Background', 'ovaev' ),
	                'type' 		=> Controls_Manager::COLOR,
	                'selectors' => [
	                    '{{WRAPPER}} .ovaev-event-sidebar #sidebar-event .widget' => 'background-color: {{VALUE}}',
	                ],
	            ]
	        );

			$this->add_responsive_control(
	            'sidebar_margin',
	            [
	                'label' 		=> esc_html__( 'Margin', 'ovaev' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .ovaev-event-sidebar #sidebar-event .widget' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

	        $this->add_responsive_control(
	            'sidebar_padding',
	            [
	                'label' 		=> esc_html__( 'Padding', 'ovaev' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .ovaev-event-sidebar #sidebar-event .widget' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

	        $this->add_group_control(
	            Group_Control_Border::get_type(), [
	                'name' 		=> 'sidebar_border',
	                'selector' 	=> '{{WRAPPER}} .ovaev-event-sidebar #sidebar-event .widget',
	                'separator' => 'before',
	            ]
	        );

	        $this->add_control(
	            'sidebar_border_radius',
	            [
	                'label' 		=> esc_html__( 'Border Radius', 'ovaev' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .ovaev-event-sidebar #sidebar-event .widget' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

		$this->end_controls_section();

	}

	protected function render() {

		$settings 	= $this->get_settings();

		$id 		= get_the_ID();
		$post_type 	= get_post_type( $id );
		
		if ( empty( $post_type ) || 'event' != $post_type ) {
			echo '<div class="ovaev_elementor_none"><span>' . esc_html( $this->get_title() ) . '</span></div>';
			return;
		}

		$template = apply_filters( 'elementor_ovaev_navigation', 'sidebar-event.php' );

		ob_start();
		?>
		<div class="ovaev-event-sidebar">
		<?php
			ovaev_get_template( $template, $settings );
			echo ob_get_clean();
		?>
		</div>
		<?php
	}
}
