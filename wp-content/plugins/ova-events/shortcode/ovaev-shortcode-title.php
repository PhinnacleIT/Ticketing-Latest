<?php defined( 'ABSPATH' ) || exit;

if( !class_exists( 'ovaev_shortcode_title' ) ) {

	class ovaev_shortcode_title {

		public $shortcode = 'ovaev_shortcode_title';

		public function __construct() {
			//add shortcode
			add_shortcode( $this->shortcode, array( $this, 'init_shortcode' ) );
		}

		function init_shortcode( $args, $content = null ) {

			if ( !empty( $args ) ) {
				$args = [
					'id' 	=> isset( $args['id'] ) 	? (int)$args['id'] 	: get_the_id(),
					'class' => isset( $args['class'] ) 	? $args['class'] 	: '',
				];
			} else {
				$args = [
					'id' 	=> get_the_id(),
					'class' => '',
				];
			}

			$template = apply_filters( 'shortcode_ovaev_title', 'shortcode/ovaev_event_title.php' );

			ob_start();
			ovaev_get_template( $template, $args );
			return ob_get_clean();
		}
	}

	new ovaev_shortcode_title();
}
