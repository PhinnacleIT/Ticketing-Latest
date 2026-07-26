<?php defined( 'ABSPATH' ) || exit;

if( !class_exists( 'ovaev_shortcode_categories' ) ) {

	class ovaev_shortcode_categories {

		public $shortcode = 'ovaev_shortcode_categories';

		public function __construct() {
			//add shortcode
			add_shortcode( $this->shortcode, array( $this, 'init_shortcode' ) );
		}

		function init_shortcode( $args, $content = null ) {

			if ( !empty( $args ) ) {
				$args = [
					'id' 	=> isset( $args['id'] ) 	? (int)$args['id'] 	: get_the_id(),
					'class' => isset( $args['class'] ) 	? $args['class'] 	: '',
					'icon' 	=> isset( $args['icon'] ) 	? $args['icon'] 	: 'fas fa-map-marker-alt',
				];
			} else {
				$args = [
					'id' 	=> get_the_id(),
					'class' => '',
					'icon' 	=> 'fas fa-map-marker-alt',
				];
			}

			$template = apply_filters( 'shortcode_ovaev_title', 'shortcode/ovaev_event_categories.php' );

			ob_start();
			ovaev_get_template( $template, $args );
			return ob_get_clean();
		}
	}

	new ovaev_shortcode_categories();
}
