<?php defined( 'ABSPATH' ) || exit;

if( !class_exists( 'ovaev_shortcode_search_ajax' ) ) {

	class ovaev_shortcode_search_ajax {

		public $shortcode = 'ovaev_search_ajax';

		public function __construct() {
			//add shortcode
			add_shortcode( $this->shortcode, array( $this, 'init_shortcode' ) );
		}

		public function get_data_shortcode( $settings ) {
			
			$posts_per_page = $settings['posts_per_page'];
			$order_post 	= $settings['order'];
			$orderby 		= $settings['order_by'];
			$category_slug 	= $settings['category'];
			$time_event 	= $settings['time_event'];

			$args = array(
				'post_type' 		=> 'event',
				'post_status' 		=> 'publish',
				'posts_per_page' 	=> $posts_per_page,
				'order' 			=> $order_post,
				'offset'			=> 0,
			);

			switch ( $orderby ) {
				case 'title':
					$args['orderby'] = $orderby;
				break;

				case 'event_custom_sort':
					$args['orderby'] 	= 'meta_value';
					$args['meta_key'] 	= $orderby;
				break;

				case 'ovaev_start_date_time':
					$args['orderby'] 	= 'meta_value';
					$args['meta_key'] 	= $orderby;
				break;
				
				case 'ID':
					$args['orderby'] = $orderby;
				break;	
			}


			if ( 'all' != $category_slug ) {
				$args['tax_query'] = array(
					array(
	                    'taxonomy' => 'event_category',
	                    'field'    => 'slug',
	                    'terms'    => $category_slug,
	                ),
				);
	        }

	        if ( 'current' === $time_event ) {
	        	$args['meta_query'] = array(
	                array(
	                    'relation' => 'OR',
	                    array(
	                        'key'     => 'ovaev_start_date_time',
	                        'value'   => array( current_time('timestamp' )-1, current_time('timestamp' )+(24*60*60)+1 ),
	                        'type'    => 'numeric',
	                        'compare' => 'BETWEEN'  
	                    ),
	                    array(
	                        'relation' => 'AND',
	                        array(
	                            'key'     => 'ovaev_start_date_time',
	                            'value'   => current_time('timestamp' ),
	                            'compare' => '<'
	                        ),
	                        array(
	                            'key'     => 'ovaev_end_date_time',
	                            'value'   => current_time('timestamp' ),
	                            'compare' => '>='
	                        ),
	                    ),
	                ),
	            );
	        } elseif ( 'upcoming' === $time_event ) {
	        	$args['meta_query'] = array(
	                array(
	                    array(
	                        'key'     => 'ovaev_start_date_time',
	                        'value'   => current_time( 'timestamp' ),
	                        'compare' => '>'
	                    ),  
	                ),
	            );
	        } elseif ( 'past' === $time_event ) {
	        	$args['meta_query'] = array(
	                array(
	                    'key'     => 'ovaev_end_date_time',
	                    'value'   => current_time('timestamp' ),
	                    'compare' => '<',                   
	                ),
	            );
	        }

			$events = new \WP_Query( $args );

			$data = [
				'events' 	=> $events,
				'settings' 	=> $settings,
			];

			return $data;
		}

		function init_shortcode( $args, $content = null ) {
			//get content
			$content = get_the_content( get_the_ID() );

			//check shortcode
			if ( is_page() && has_shortcode( $content, 'ovaev_search_ajax') ) {
				wp_enqueue_style( 'datetimepicker', OVAEV_PLUGIN_URI.'assets/libs/datetimepicker/jquery.datetimepicker.css' );
				wp_enqueue_script( 'datetimepicker', OVAEV_PLUGIN_URI.'assets/libs/datetimepicker/jquery.datetimepicker.js', array('jquery'), false, true );
			}
			//check variable shortcode

			if ( !empty($args) ) {
				$attr = [
					//query events
					'layout' 			=> isset($args['layout']) 			? (int)$args['layout'] 		: 1,
					'column' 			=> isset($args['column']) 			? $args['column'] 			: 'col3',
					'posts_per_page' 	=> isset($args['posts_per_page']) 	? $args['posts_per_page'] 	: 9,
					'order' 			=> isset($args['order']) 			? $args['order'] 			: 'DESC',
					'order_by' 			=> isset($args['order_by']) 		? $args['order_by'] 		: 'title',
					'category' 			=> isset($args['category']) 		? $args['category'] 		: 'all',
					'time_event' 		=> isset($args['time_event']) 		? $args['time_event'] 		: 'all',
				];
			} else {
				$attr = [
					'layout' 			=> 1, 			// 1, 2, 3, 4, 5, 6
					'column' 			=> 'col3',		// col1, col2, col3
					'posts_per_page' 	=> 9,
					'order' 			=> 'DESC',		// DESC, ASC
					'order_by' 			=> 'title',     // title, event_custom_sort, ovaev_start_date_time, ID
					'category' 			=> 'all',		// all or slug
					'time_event' 		=> 'all',		// all, current, upcoming, past
				];
			}
			
			$data = $this->get_data_shortcode($attr);
			
			//get template
			$template = apply_filters( 'shortcode_ovaev_ajax', 'elements/ovaev_events_search_ajax.php' );

			ob_start();
			ovaev_get_template( $template, $data );
			return ob_get_clean();
		}
	}

	new ovaev_shortcode_search_ajax();
}
