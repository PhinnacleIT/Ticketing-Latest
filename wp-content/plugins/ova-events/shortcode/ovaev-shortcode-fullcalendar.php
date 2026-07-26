<?php defined( 'ABSPATH' ) || exit;

if( !class_exists( 'ovaev_shortcode_fullcalendar' ) ) {

	class ovaev_shortcode_fullcalendar {

		public $shortcode = 'ovaev_fullcalendar';

		public function __construct() {
			//add shortcode
			add_shortcode( $this->shortcode, array( $this, 'init_shortcode' ) );
		}

		function init_shortcode( $args, $content = null ) {
			//get content
			$content = get_the_content( get_the_ID() );

			//check shortcode
			if ( is_page() && has_shortcode( $content, 'ovaev_fullcalendar') ) {
				wp_enqueue_script( 'moment', OVAEV_PLUGIN_URI. 'assets/libs/calendar/moment.min.js', [ 'jquery' ], false, true );
				wp_enqueue_script( 'clndr', OVAEV_PLUGIN_URI.'assets/libs/calendar/clndr.min.js', [ 'jquery' ], true, false );
			}
			
			//check variable shortcode
			if ( !empty($args) ) {
				$attr = [
					'category' 		=> isset( $args['category'] ) ? $args['category'] : 'all',
					'filter_event' 	=> isset( $args['filter_event'] ) ? $args['filter_event'] : 'all',
					'show_filter' 	=> isset( $args['show_filter'] ) ? $args['show_filter'] : 'no',
				];
			} else {
				$attr = [
					'category' 		=> 'all',
					'filter_event' 	=> 'all',
					'show_filter' 	=> 'no',
				];
			}

			//get template
			$template = apply_filters( 'shortcode_ovaev_simple_fullcalendar', 'elements/ovaev_events_calendar_content.php' );

			ob_start();
			ovaev_get_template( $template, $attr );
			return ob_get_clean();
		}
	}

	new ovaev_shortcode_fullcalendar();
}
