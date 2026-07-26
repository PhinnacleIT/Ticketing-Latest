<?php defined( 'ABSPATH' ) || exit;

if( !class_exists( 'ovaev_shortcode_simple_calendar' ) ) {

	class ovaev_shortcode_simple_calendar {

		public $shortcode = 'ovaev_calendar';

		public function __construct() {
			//add shortcode
			add_shortcode( $this->shortcode, array( $this, 'init_shortcode' ) );
		}

		function init_shortcode( $args, $content = null ) {
			//get content
			$content = get_the_content( get_the_ID() );

			//check shortcode
			if ( is_page() && has_shortcode( $content, 'ovaev_calendar') ) {
				wp_enqueue_script( 'moment', OVAEV_PLUGIN_URI. 'assets/libs/calendar/moment.min.js', [ 'jquery' ], false, true );
				wp_enqueue_script( 'clndr', OVAEV_PLUGIN_URI.'assets/libs/calendar/clndr.min.js',  [ 'jquery' ], false, true );
			}
			
			//check variable shortcode
			if ( !empty($args) ) {
				$attr = [
					'category' 		=> isset( $args['category'] ) ? $args['category'] : 'all',
					'filter_event' 	=> isset( $args['filter_event'] ) ? $args['filter_event'] : 'all',
				];
			} else {
				$attr = [
					'category' 		=> 'all',
					'filter_event' 	=> 'all',
				];
			}

			//get template
			$template = apply_filters( 'shortcode_ovaev_simple_calendar', 'elements/ovaev_events_simple_calendar.php' );

			ob_start();
			ovaev_get_template( $template, $attr );
			return ob_get_clean();
		}
	}

	new ovaev_shortcode_simple_calendar();
}
