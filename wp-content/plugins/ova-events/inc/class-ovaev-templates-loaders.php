<?php

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class OVAEV_templates_loader {
	
	/**
	 * The Constructor
	 */
	public function __construct() {
		add_filter( 'template_include', array( $this, 'template_loader' ) );
	}

	

	public function template_loader( $template ) {

		$post_type = isset($_REQUEST['post_type'] ) ? $_REQUEST['post_type'] : get_post_type();
		$search = isset( $_REQUEST['search_event'] ) ? $_REQUEST['search_event'] : '';
		
		
		if( is_tax( 'event_category' ) ||  get_query_var( 'event_category' ) != '' || is_tax( 'event_tag' ) ||  get_query_var( 'event_tag' ) != '' ){
			
			ovaev_get_template( 'archive-event.php' );
			return false;
		}

		
		// Is Event Post Type
		if(  $post_type == 'event' ){


			if ( $search != '' || is_post_type_archive( 'event' )  ) { 

				ovaev_get_template( 'archive-event.php' );
				return false;

			} else if ( is_single() ) {

				ovaev_get_template( 'single-event.php' );
				return false;

			}
		}


		if ( $post_type !== 'event' ){
			return $template;
		}
	}
}

new OVAEV_templates_loader();
