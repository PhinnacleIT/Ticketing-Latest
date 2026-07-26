<?php
namespace ova_ovaev_elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class ova_event_meta extends Widget_Base {

	public function get_name() {		
		return 'ova_event_meta';
	}

	public function get_title() {
		return esc_html__( 'Event Meta', 'ovaev' );
	}

	public function get_icon() {
		return 'eicon-meta-data';
	}

	public function get_categories() {
		return [ 'ovaev_template' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_meta_style',
			[
				'label' => esc_html__( 'Meta', 'ovaev' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
	            'meta_color',
	            [
	                'label' 	=> esc_html__( 'Color', 'ovaev' ),
	                'type' 		=> Controls_Manager::COLOR,
	                'selectors' => [
	                    '{{WRAPPER}} .ovaev-meta-event .time-date-child' => 'color: {{VALUE}};',
	                    '{{WRAPPER}} .ovaev-meta-event .author a' => 'color: {{VALUE}};',
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

		?>
		    <div class="ovaev-meta-event">
            	<!-- Author -->
            	<?php do_action( 'ovaev_loop_author_event', $id ); ?>
            	<!-- Date -->
			    <?php do_action( 'ovaev_loop_date_event', $id ); ?>
			</div>
		<?php
	}
}
