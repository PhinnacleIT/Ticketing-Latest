<?php defined( 'ABSPATH' ) || exit;

if( !class_exists( 'ovaev_shortcode_tabs' ) ) {

	class ovaev_shortcode_tabs {

		public $shortcode = 'ovaev_shortcode_tabs';

		public function __construct() {
			//add shortcode
			add_shortcode( $this->shortcode, array( $this, 'init_shortcode' ) );
		}

		function init_shortcode( $args, $content = null ) {

			$content = get_the_content( get_the_ID() );
			
			if ( is_page() && has_shortcode( $content, 'ovaev_shortcode_tabs') ) {
				wp_enqueue_script( 'google','https://maps.googleapis.com/maps/api/js?key='.OVAEV_Settings::google_key_map().'&libraries=places', false, true );
				wp_enqueue_style('prettyphoto', OVAEV_PLUGIN_URI.'assets/libs/prettyphoto/css/prettyPhoto.css');
				if ( is_ssl() ) {
					wp_enqueue_script('prettyphoto', OVAEV_PLUGIN_URI.'assets/libs/prettyphoto/jquery.prettyPhoto_https.js', array('jquery'),null,true);  
				}
				else{
					wp_enqueue_script('prettyphoto', OVAEV_PLUGIN_URI.'assets/libs/prettyphoto/jquery.prettyPhoto.js', array('jquery'),null,true);
				}
			}

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

			$template = apply_filters( 'shortcode_ovaev_title', 'shortcode/ovaev_event_tabs.php' );

			ob_start();
			ovaev_get_template( $template, $args );
			return ob_get_clean();
		}
	}

	new ovaev_shortcode_tabs();
}
