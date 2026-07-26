<?php
namespace ova_ovaev_elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class ova_event_thumbnail extends Widget_Base {

	public function get_name() {		
		return 'ova_event_thumbnail';
	}

	public function get_title() {
		return esc_html__( 'Event Thumbnail', 'ovaev' );
	}

	public function get_icon() {
		return 'eicon-image';
	}

	public function get_categories() {
		return [ 'ovaev_template' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_thumbnail',
			[
				'label' => esc_html__( 'Thumbnail', 'ovaev' ),
			]
		);

			$this->add_control(
				'thumbnail_size',
				[
					'label' 	=> esc_html__( 'Size', 'ovaev' ),
					'type' 		=> Controls_Manager::SELECT,
					'options' 	=> [
						'thumbnail' 	=> esc_html__( 'Thumbnail', 'ovaev' ),
						'medium' 		=> esc_html__( 'Medium', 'ovaev' ),
						'medium_large' 	=> esc_html__( 'Medium Large', 'ovaev' ),
						'large' 		=> esc_html__( 'Large', 'ovaev' ),
						'full' 			=> esc_html__( 'Full', 'ovaev' ),
					],
					'default' => 'full',
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
					'separator' => 'before',
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
						'{{WRAPPER}} .ovaev-event-thumbnail' => 'text-align: {{VALUE}};',
					],
				]
			);

			$this->end_controls_section();

		$this->start_controls_section(
			'section_thumbnail_style',
			[
				'label' => esc_html__( 'Thumbnail', 'ovaev' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_responsive_control(
				'thumbnail_width',
				[
					'label' 	=> esc_html__( 'Width', 'ovaev' ),
					'type' 		=> Controls_Manager::SLIDER,
					'default' 	=> [
						'unit' 	=> '%',
					],
					'tablet_default' => [
						'unit' => '%',
					],
					'mobile_default' => [
						'unit' => '%',
					],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 2000,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'size_units' 	=> [ '%', 'px' ],
					'selectors' 	=> [
						'{{WRAPPER}} .ovaev-event-thumbnail img' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'thumbnail_height',
				[
					'label' 	=> esc_html__( 'Width', 'ovaev' ),
					'type' 		=> Controls_Manager::SLIDER,
					'default' 	=> [
						'unit' 	=> '%',
					],
					'tablet_default' => [
						'unit' => '%',
					],
					'mobile_default' => [
						'unit' => '%',
					],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1000,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'size_units' 	=> [ '%', 'px' ],
					'selectors' 	=> [
						'{{WRAPPER}} .ovaev-event-thumbnail img' => 'height: {{SIZE}}{{UNIT}};',
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

		// Image size
		$size 		= $settings['thumbnail_size'];

		?>
		<div class="ovaev-event-thumbnail">
			<?php if ( !empty( $link ) ): ?>
				<a href="<?php echo esc_url( $link ); ?>"<?php echo ' '.$target; ?>>
					<?php the_post_thumbnail( $size ); ?>
				</a>
			<?php else: ?>
				<?php the_post_thumbnail( $size ); ?>
			<?php endif; ?>
		</div>
		<?php

	}
}
