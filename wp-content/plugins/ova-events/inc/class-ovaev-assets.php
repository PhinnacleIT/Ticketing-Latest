<?php
defined( 'ABSPATH' ) || exit();

if( !class_exists( 'OVAEV_Assets' ) ){
	class OVAEV_Assets{

		public function __construct(){

			add_action( 'wp_enqueue_scripts', array( $this, 'ovaev_enqueue_style' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'ovaev_admin_enqueue_scripts' ) );

			/* Add JS for Elementor */
			add_action( 'elementor/frontend/after_register_scripts', array( $this, 'ovaev_enqueue_scripts_elementor_event' ) );

		}

		public function ovaev_enqueue_style(){
			// Frontend 
			if ( is_singular( 'event' ) ){
				wp_enqueue_script( 'google','https://maps.googleapis.com/maps/api/js?key='.OVAEV_Settings::google_key_map().'&libraries=places', false, true );
			}

			// wp_enqueue_style( 'calendar', OVAEV_PLUGIN_URI.'assets/libs/calendar/main.min.css', array(), null );

			wp_enqueue_style( 'event-frontend', OVAEV_PLUGIN_URI.'assets/css/frontend/event.css', array(), null );

			// Customize Css
			wp_add_inline_style( 'event-frontend', $this->ovaev_customize_css() );
            
            // Script
			wp_enqueue_script( 'event-frontend-js', OVAEV_PLUGIN_URI.'assets/js/frontend/event.js', array('jquery'), false, true );

			

			// wp_enqueue_script( 'calendar', OVAEV_PLUGIN_URI.'assets/libs/calendar/main.min.js', array('jquery'), false, true );

			// wp_enqueue_script( 'popper', OVAEV_PLUGIN_URI.'assets/libs/popper.min.js', array('jquery'), false, true );

			// wp_enqueue_script( 'tooltip', OVAEV_PLUGIN_URI.'assets/libs/tooltip.min.js', array('jquery'), false, true );
			

			// Carousel & font libs
			if ( is_singular( 'event' ) || is_post_type_archive( array( 'event' ) ) ){ 
				wp_enqueue_style( 'carousel', OVAEV_PLUGIN_URI.'assets/libs/owl-carousel/assets/owl.carousel.min.css' );
				wp_enqueue_script( 'carousel', OVAEV_PLUGIN_URI.'assets/libs/owl-carousel/owl.carousel.min.js', array('jquery'), false, true );
				wp_enqueue_style( 'fontawesome', OVAEV_PLUGIN_URI.'assets/libs/fontawesome/css/all.css', array(), null );
				wp_enqueue_style( 'elegant_font', OVAEV_PLUGIN_URI.'assets/libs/elegant_font/ele_style.css', array(), null );
			}

			/*** Jquery Datetimepicker & select2 ***/
			if ( is_post_type_archive( 'event' ) || is_tax( 'event_category' ) || is_tax( 'event_tag' ) ){
				wp_enqueue_style( 'datetimepicker', OVAEV_PLUGIN_URI.'assets/libs/datetimepicker/jquery.datetimepicker.css' );
				wp_enqueue_script( 'datetimepicker', OVAEV_PLUGIN_URI.'assets/libs/datetimepicker/jquery.datetimepicker.js', array('jquery'), false, true );
				wp_enqueue_style( 'select2', OVAEV_PLUGIN_URI.'assets/libs/dist/css/select2.min.css', array(), null );
				wp_enqueue_script( 'select2', OVAEV_PLUGIN_URI.'assets/libs/dist/js/select2.min.js', array('jquery'), false, true );
			}

			/*** Pretty Photo ***/
			if( is_singular( 'event' ) ){
				wp_enqueue_style('prettyphoto', OVAEV_PLUGIN_URI.'assets/libs/prettyphoto/css/prettyPhoto.css');
				if (is_ssl()) {
					wp_enqueue_script('prettyphoto', OVAEV_PLUGIN_URI.'assets/libs/prettyphoto/jquery.prettyPhoto_https.js', array('jquery'),null,true);
				}
				else{
					wp_enqueue_script('prettyphoto', OVAEV_PLUGIN_URI.'assets/libs/prettyphoto/jquery.prettyPhoto.js', array('jquery'),null,true);
				}
			}

			/* Add JS */
			// wp_localize_script( 'event-frontend-js', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
		}

		/* Add JS for elementor */
		public function ovaev_enqueue_scripts_elementor_event(){
			wp_enqueue_script( 'underscore', OVAEV_PLUGIN_URI. 'assets/libs/calendar/underscore-min.js', [ 'jquery' ], false, true );
			wp_enqueue_script( 'script-elementor-event', OVAEV_PLUGIN_URI. 'assets/js/script-elementor.js', [ 'jquery' ], false, true );
		}

		public function ovaev_admin_enqueue_scripts() {
			wp_enqueue_style( 'select2', OVAEV_PLUGIN_URI.'assets/libs/dist/css/select2.min.css', array(), null );
			wp_enqueue_script( 'select2', OVAEV_PLUGIN_URI.'assets/libs/dist/js/select2.min.js', array('jquery'), false, true );
		}

		public function ovaev_customize_css(){

		    $general = include 'ovaev-customize-css.php';

		    return $general;
		    
		}
	}
	new OVAEV_Assets();
}