<?php
namespace ova_ovaev_elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class ova_event_location extends Widget_Base {

	public function get_name() {		
		return 'ova_event_location';
	}

	public function get_title() {
		return esc_html__( 'Event Location', 'ovaev' );
	}

	public function get_icon() {
		return 'eicon-map-pin';
	}

	public function get_categories() {
		return [ 'ovaev_template' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_location',
			[
				'label' => esc_html__( 'Location', 'ovaev' ),
			]
		);

	        $this->add_control(
				'map_zoom',
				[
					'label' 	=> esc_html__( 'Map Zoom', 'ovaev' ),
					'type' 		=> Controls_Manager::NUMBER,
					'default' 	=> 18,
				]
			);

			$this->add_responsive_control(
				'map_height',
				[
					'label' 	=> esc_html__( 'Map Height (px)', 'ovaev' ),
					'type' 		=> Controls_Manager::NUMBER,
					'min'       => 300,
					'max'       => 600,
					'default' 	=> 430
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
        
        $map_height 	= isset( $settings['map_height'] ) ? $settings['map_height'] : 390;
        $map_address 	= get_post_meta( $id, 'ovaev_map_address', true );
		$map_lat 		= get_post_meta( $id, 'ovaev_map_lat', true );
		$map_lng     	= get_post_meta( $id, 'ovaev_map_lng', true );
		$map_zoom    	= $settings['map_zoom'] ? $settings['map_zoom'] : 18;

		?>
		    <div class="ovaev-location" 
				id="location" 
				style="height: <?php echo esc_attr( $map_height ); ?>px;" 
				data-address="<?php echo esc_attr( $map_address ); ?>" 
				data-lat="<?php echo esc_attr( $map_lat ); ?>" 
				data-lng="<?php echo esc_attr( $map_lng ); ?>" 
				data-zoom="<?php echo esc_attr( $map_zoom ); ?>">
			</div>
		<?php
	}
}
