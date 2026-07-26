<?php
namespace ova_ovaev_elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class ova_event_navigation extends Widget_Base {

	public function get_name() {		
		return 'ova_event_navigation';
	}

	public function get_title() {
		return esc_html__( 'Event Navigation', 'ovaev' );
	}

	public function get_icon() {
		return 'eicon-post-navigation';
	}

	public function get_categories() {
		return [ 'ovaev_template' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Title', 'ovaev' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->start_controls_tabs( 'tabs_title_style' );
				
				$this->start_controls_tab(
		            'tab_title_normal',
		            [
		                'label' => esc_html__( 'Normal', 'ovaev' ),
		            ]
		        );

		        	$this->add_control(
			            'title_color_normal',
			            [
			                'label' 	=> esc_html__( 'Color', 'ovaev' ),
			                'type' 		=> Controls_Manager::COLOR,
			                'selectors' => [
			                    '{{WRAPPER}} .ovaev-event-navigation .content-event .ova-next-pre-post .pre .num-2 .title' 	=> 'color: {{VALUE}};',
			                    '{{WRAPPER}} .ovaev-event-navigation .content-event .ova-next-pre-post .next .num-2 .title' => 'color: {{VALUE}};',
			                ],
			            ]
			        );

		        $this->end_controls_tab();

		        $this->start_controls_tab(
		            'tab_title_hover',
		            [
		                'label' 	=> esc_html__( 'Hover', 'ovaev' ),
		            ]
		        );

		        	$this->add_control(
			            'title_color_hover',
			            [
			                'label' 	=> esc_html__( 'Color', 'ovaev' ),
			                'type' 		=> Controls_Manager::COLOR,
			                'selectors' => [
			                    '{{WRAPPER}} .ovaev-event-navigation .content-event .ova-next-pre-post .pre .num-2 .title:hover' 	=> 'color: {{VALUE}};',
			                    '{{WRAPPER}} .ovaev-event-navigation .content-event .ova-next-pre-post .next .num-2 .title:hover' 	=> 'color: {{VALUE}};',
			                ],
			            ]
			        );

		        $this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 		=> 'title_typography',
					'selector' 	=> '{{WRAPPER}} .ovaev-event-navigation .content-event .ova-next-pre-post .pre .num-2 .title, .ovaev-event-navigation .content-event .ova-next-pre-post .next .num-2 .title',
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_icon_style',
			[
				'label' => esc_html__( 'Icon', 'ovaev' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->start_controls_tabs( 'tabs_icon_style' );
				
				$this->start_controls_tab(
		            'tab_icon_normal',
		            [
		                'label' => esc_html__( 'Normal', 'ovaev' ),
		            ]
		        );

		        	$this->add_control(
			            'icon_color_normal',
			            [
			                'label' 	=> esc_html__( 'Color', 'ovaev' ),
			                'type' 		=> Controls_Manager::COLOR,
			                'selectors' => [
			                    '{{WRAPPER}} .ovaev-event-navigation .content-event .ova-next-pre-post .pre .num-1 .icon i' 	=> 'color: {{VALUE}};',
			                    '{{WRAPPER}} .ovaev-event-navigation .content-event .ova-next-pre-post .next .num-1 .icon i' 	=> 'color: {{VALUE}};',
			                ],
			            ]
			        );

			        $this->add_control(
			            'icon_bg_normal',
			            [
			                'label' 	=> esc_html__( 'Background', 'ovaev' ),
			                'type' 		=> Controls_Manager::COLOR,
			                'selectors' => [
			                    '{{WRAPPER}} .ovaev-event-navigation .content-event .ova-next-pre-post .pre .num-1 .icon' 	=> 'background-color: {{VALUE}};',
			                    '{{WRAPPER}} .ovaev-event-navigation .content-event .ova-next-pre-post .next .num-1 .icon' 	=> 'background-color: {{VALUE}};',
			                ],
			            ]
			        );

		        $this->end_controls_tab();

		        $this->start_controls_tab(
		            'tab_icon_hover',
		            [
		                'label' 	=> esc_html__( 'Hover', 'ovaev' ),
		            ]
		        );

		        	$this->add_control(
			            'icon_color_hover',
			            [
			                'label' 	=> esc_html__( 'Color', 'ovaev' ),
			                'type' 		=> Controls_Manager::COLOR,
			                'selectors' => [
			                    '{{WRAPPER}} .ovaev-event-navigation .content-event .ova-next-pre-post .pre:hover .num-1 .icon i' 	=> 'color: {{VALUE}};',
			                    '{{WRAPPER}} .ovaev-event-navigation .content-event .ova-next-pre-post .next:hover .num-1 .icon i' 	=> 'color: {{VALUE}};',
			                ],
			            ]
			        );

			        $this->add_control(
			            'icon_bg_hover',
			            [
			                'label' 	=> esc_html__( 'Background', 'ovaev' ),
			                'type' 		=> Controls_Manager::COLOR,
			                'selectors' => [
			                    '{{WRAPPER}} .ovaev-event-navigation .content-event .ova-next-pre-post .pre:hover .num-1 .icon' 	=> 'background-color: {{VALUE}};',
			                    '{{WRAPPER}} .ovaev-event-navigation .content-event .ova-next-pre-post .next:hover .num-1 .icon' 	=> 'background-color: {{VALUE}};',
			                ],
			            ]
			        );

		        $this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 		=> 'icon_typography',
					'selector' 	=> '{{WRAPPER}} .ovaev-event-navigation .content-event .ova-next-pre-post .pre .num-1 .icon i, .ovaev-event-navigation .content-event .ova-next-pre-post .next .num-1 .icon i',
				]
			);

			$this->add_group_control(
	            Group_Control_Border::get_type(), [
	                'name' 		=> 'button_border',
	                'selector' 	=> '{{WRAPPER}} .ovaev-event-navigation .content-event .ova-next-pre-post .pre .num-1 .icon, .ovaev-event-navigation .content-event .ova-next-pre-post .next .num-1 .icon',
	                'separator' => 'before',
	            ]
	        );

	        $this->add_control(
	            'icon_border_hover',
	            [
	                'label' 	=> esc_html__( 'Color Border Hover', 'ovaev' ),
	                'type' 		=> Controls_Manager::COLOR,
	                'selectors' => [
	                    '{{WRAPPER}} .ovaev-event-navigation .content-event .ova-next-pre-post .pre:hover .num-1 .icon' 	=> 'border-color: {{VALUE}};',
	                    '{{WRAPPER}} .ovaev-event-navigation .content-event .ova-next-pre-post .next:hover .num-1 .icon' 	=> 'border-color: {{VALUE}};',
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

		$template = apply_filters( 'elementor_ovaev_navigation', 'single/nav.php' );

		ob_start();
		?>
		<div class="ovaev-event-navigation single_event">
			<div class="content-event">
		<?php
			ovaev_get_template( $template, $settings );
			echo ob_get_clean();
		?>
			</div>
		</div>
		<?php
	}
}
