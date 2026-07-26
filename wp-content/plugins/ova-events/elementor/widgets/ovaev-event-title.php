<?php
namespace ova_ovaev_elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class ova_event_title extends Widget_Base {

	public function get_name() {		
		return 'ova_event_title';
	}

	public function get_title() {
		return esc_html__( 'Event Title', 'ovaev' );
	}

	public function get_icon() {
		return 'eicon-archive-title';
	}

	public function get_categories() {
		return [ 'ovaev_template' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_title',
			[
				'label' => esc_html__( 'Title', 'ovaev' ),
			]
		);
		
			$this->add_control(
				'link',
				[
					'label' => esc_html__( 'Link', 'ovaev' ),
					'type' 	=> Controls_Manager::URL,
					'dynamic' => [
						'active' => true,
					],
					'default' => [
						'url' => '',
					],
				]
			);

			$this->add_control(
				'header_size',
				[
					'label' => esc_html__( 'HTML Tag', 'ovaev' ),
					'type' 	=> Controls_Manager::SELECT,
					'options' => [
						'h1' 	=> 'H1',
						'h2' 	=> 'H2',
						'h3' 	=> 'H3',
						'h4' 	=> 'H4',
						'h5' 	=> 'H5',
						'h6' 	=> 'H6',
						'div' 	=> 'div',
						'span' 	=> 'span',
						'p' 	=> 'p',
					],
					'default' => 'h2',
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
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .ovaev-event-title' => 'text-align: {{VALUE}};',
					],
				]
			);

			$this->end_controls_section();

		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Title', 'ovaev' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		    $this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 		=> 'title_typography',
					'selector' 	=> '{{WRAPPER}} .ovaev-event-title',
				]
			);

		    $this->add_control(
	            'title_color_normal',
	            [
	                'label' 	=> esc_html__( 'Color', 'ovaev' ),
	                'type' 		=> Controls_Manager::COLOR,
	                'selectors' => [
	                    '{{WRAPPER}} .ovaev-event-title, {{WRAPPER}} .ovaev-event-title a' => 'color: {{VALUE}};',
	                ],
	            ]
	        );

	        $this->add_control(
	            'title_color_hover',
	            [
	                'label' 	=> esc_html__( 'Color Hover', 'ovaev' ),
	                'type' 		=> Controls_Manager::COLOR,
	                'selectors' => [
	                    '{{WRAPPER}} .ovaev-event-title:hover, {{WRAPPER}} .ovaev-event-title a:hover' => 'color: {{VALUE}};',
	                ],  
	            ]
	        );


			$this->add_responsive_control(
	            'title_padding',
	            [
	                'label' 		=> esc_html__( 'Padding', 'ovaev' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .ovaev-event-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

	        $this->add_responsive_control(
	            'title_margin',
	            [
	                'label' 		=> esc_html__( 'Margin', 'ovaev' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .ovaev-event-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

		// Get link
		$link 	  	= $settings['link']['url'];
		$target 	= 'target="_blank"';
		$target_url = $settings['link']['is_external'];
		if ( empty( $target_url ) ) {
			$target = '';
		}

		// Get header_size
		$header_size = $settings['header_size'];

		?>

		<<?php echo $header_size; ?> class="ovaev-event-title">
			<?php if ( !empty( $link ) ): ?>
				<a href="<?php echo esc_url( $link ); ?>"<?php echo ' '.$target; ?>>
					<?php the_title(); ?>
				</a>
			<?php else: ?>
				<?php the_title(); ?>
			<?php endif; ?>
		</<?php echo $header_size; ?>>

		<?php

	}
}
