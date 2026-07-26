<?php
namespace ova_ovaev_elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class ova_event_time extends Widget_Base {

	public function get_name() {		
		return 'ova_event_time';
	}

	public function get_title() {
		return esc_html__( 'Event Time', 'ovaev' );
	}

	public function get_icon() {
		return 'eicon-date';
	}

	public function get_categories() {
		return [ 'ovaev_template' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_time',
			[
				'label' => esc_html__( 'Time', 'ovaev' ),
			]
		);

			$this->add_control(
				'time_format',
				[
					'label' 	=> esc_html__( 'Time Format', 'ovaev' ),
					'type' 		=> Controls_Manager::SELECT,
					'options' 	=> [
						'H:i' 		=> esc_html__( 'H:i 24 Hour	', 'ovaev' ),
						'g:i A' 	=> esc_html__( 'g:i A 12 Hour', 'ovaev' ),
						'g:i a' 	=> esc_html__( 'g:i a 12 hour', 'ovaev' ),
					],
					'default' 	=> 'H:i',
				]
			);
			
			$this->add_control(
				'separator',
				[
					'label' 	=> esc_html__( 'Separator', 'ovaev' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> esc_html__( ' - ', 'ovaev' ),
				]
			);

			$this->add_control(
				'icon',
				[
					'label' 	=> esc_html__( 'Icon', 'ovaev' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> 'far fa-clock',
				]
			);

			$this->add_responsive_control(
				'align',
				[
					'label' => esc_html__( 'Alignment', 'ovaev' ),
					'type' 	=> Controls_Manager::CHOOSE,
					'options' => [
						'left' => [
							'title' => esc_html__( 'Left', 'ovaev' ),
							'icon' 	=> 'eicon-text-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'ovaev' ),
							'icon' 	=> 'eicon-text-align-center',
						],
						'right' => [
							'title' => esc_html__( 'Right', 'ovaev' ),
							'icon' 	=> 'eicon-text-align-right',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .ovaev-event-time' => 'text-align: {{VALUE}};',
					],
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

			$this->add_control(
	            'icon_color',
	            [
	                'label' 	=> esc_html__( 'Color', 'ovaev' ),
	                'type' 		=> Controls_Manager::COLOR,
	                'selectors' => [
	                    '{{WRAPPER}} .ovaev-event-time i' => 'color: {{VALUE}};',
	                ],
	            ]
	        );

	        $this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 		=> 'icon_typography',
					'selector' 	=> '{{WRAPPER}} .ovaev-event-time i',
				]
			);

	        $this->add_responsive_control(
	            'icon_margin',
	            [
	                'label' 		=> esc_html__( 'Margin', 'ovaev' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .ovaev-event-time i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_time_style',
			[
				'label' => esc_html__( 'Time', 'ovaev' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
	            'time_color',
	            [
	                'label' 	=> esc_html__( 'Color', 'ovaev' ),
	                'type' 		=> Controls_Manager::COLOR,
	                'selectors' => [
	                    '{{WRAPPER}} .ovaev-event-time span' => 'color: {{VALUE}};',
	                ],
	            ]
	        );

	        $this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 		=> 'time_typography',
					'selector' 	=> '{{WRAPPER}} .ovaev-event-time span',
				]
			);

	        $this->add_responsive_control(
	            'time_margin',
	            [
	                'label' 		=> esc_html__( 'Margin', 'ovaev' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .ovaev-event-time span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

		$icon 			= $settings['icon'];
		$separator 		= $settings['separator'];
		$time_format 	= $settings['time_format'];

		$post_start_time 	= get_post_meta( $id, 'ovaev_start_time', true );
		$post_end_time   	= get_post_meta( $id, 'ovaev_end_time', true );

		$start_time    		= $post_start_time 	? date( $time_format, strtotime( $post_start_time ) ) 	: '';
		$end_time      		= $post_end_time 	? date( $time_format, strtotime( $post_end_time ) ) 		: '';

		?>
		<?php if ( ! empty( $start_time ) && ! empty( $end_time ) ): ?>
			<div class="ovaev-event-time">
				<?php if ( $icon ): ?>
					<i class="<?php echo esc_attr( $icon ); ?>"></i>
				<?php endif; ?>
				<span class="second_font"><?php echo esc_html( $start_time ); ?></span>
				<span class="second_font separator"><?php echo esc_html( $separator ); ?></span>
				<span class="second_font"><?php echo esc_html( $end_time ); ?></span>
			</div>
		<?php
		endif;
	}
}
