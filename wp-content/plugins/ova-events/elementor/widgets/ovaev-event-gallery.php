<?php
namespace ova_ovaev_elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class ova_event_gallery extends Widget_Base {

	public function get_name() {		
		return 'ova_event_gallery';
	}

	public function get_title() {
		return esc_html__( 'Event Gallery', 'ovaev' );
	}

	public function get_icon() {
		return 'eicon-gallery-group';
	}

	public function get_categories() {
		return [ 'ovaev_template' ];
	}

	protected function register_controls() {

        $this->start_controls_section(
            'gallery_style',
            [
                'label' => esc_html__( 'Gallery', 'ovaev' ),
                'tab' 	=> Controls_Manager::TAB_STYLE,
            ]
        );

        	$this->add_responsive_control(
				'thumbnail_spacing',
				[
					'label' 	=> esc_html__( 'Space Between', 'ovaev' ),
					'type' 		=> Controls_Manager::SLIDER,
					'range' 	=> [
						'px' 	=> [
							'min' => 0,
							'max' => 500,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .ovaev-event-gallery .event_row' => 'grid-gap: {{SIZE}}{{UNIT}};',
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

		$gallery     	= get_post_meta( $id, 'ovaev_gallery_id', true);

		?>
			
	  		<?php if ( !empty( $gallery ) ) : ?>
	 		 	<div class="ovaev-event-gallery" id="gallery">
	 		 		<div class="event_row">
	 		 			<?php
	 		 			foreach ( $gallery as $items ): ?>
	 		 				<div class="event_col-6">
								<div class="gallery-items">
									<?php
										$img_url = wp_get_attachment_image_url( $items, 'large' );
									?>
									<a 
										href="<?php echo esc_url( $img_url ); ?>" 
										data-gal="prettyPhoto[gal]">
										<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo get_the_title(); ?>" />
									</a> 
								</div>
							</div>
	 		 			<?php endforeach; ?>
	 		 		</div>
	 		 	</div>
		 	<?php endif; ?>

		<?php
	}
}
