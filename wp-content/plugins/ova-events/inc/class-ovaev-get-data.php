<?php

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class OVAEV_get_data {
	public function __construct() {

		// add_filter( 'OVAEV_event', array( $this, 'OVAEV_event' ), 10, 0 );
		add_filter( 'OVAEV_event_type', array( $this, 'OVAEV_event_type' ), 10, 1 );

		add_filter( 'OVAEV_search_event', array( $this, 'OVAEV_search_event' ), 10, 1 );

		// hook to wp_query in archive event
		add_action( 'pre_get_posts', array( $this, 'ovaev_pre_get_events_archive' ) );

		// hook to wp_query in search event
		add_action( 'pre_get_posts', array( $this, 'ovaev_pre_get_events_search' ) );
		
	}


	public function ovaev_pre_get_events_search( $query ){

		$search_event = isset( $_GET['search_event'] ) ? esc_html( $_GET['search_event'] ) : '' ;

		if( $search_event != ''){

			$cat = isset( $_GET['ovaev_type'] ) ? esc_html( $_GET['ovaev_type'] ) : '' ;
			$ovaev_start_date_search = isset( $_GET['ovaev_start_date_search'] ) ? esc_html( $_GET['ovaev_start_date_search'] ) : '' ;
			$ovaev_end_date_search 	= isset( $_GET['ovaev_end_date_search'] ) ? esc_html( $_GET['ovaev_end_date_search'] ) : '' ;
			
			$paged     = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
			$show_past = OVAEV_Settings::ovaev_show_past();
			$order     = OVAEV_Settings::archive_event_order();
			$orderby   = OVAEV_Settings::archive_event_orderby();


			if( $paged != '' ){
				$query->set( 'paged', $paged );
			}

			$query->set( 'post_type', 'event' );
			$query->set( 'order', $order );

			switch ($orderby) {
				case 'title':
				$query->set( 'orderby', 'title' );
				break;

				case 'event_custom_sort':
				$query->set( 'orderby' , 'meta_value' );
				$query->set( 'meta_key', $orderby );
				break;

				case 'ovaev_start_date':
				$query->set( 'orderby' , 'meta_value' );
				$query->set( 'meta_key', 'ovaev_start_date_time' );
				break;
				
				case 'ID':
				$query->set( 'orderby', 'ID');
				break;
				
				default:
				break;
			}


			// Query Taxonomy
			if($cat){
				$query->set( 
					'tax_query',
					array(
						array(
							'taxonomy' => 'event_category',
							'field'    => 'slug',
							'terms'    => $cat,
						)
					)		
				);
			}


			// Query Date
			if( $ovaev_start_date_search && $ovaev_end_date_search ){

				$query->set( 
					'meta_query',
					array(

						array(
							'relation' => 'OR',
							array(
								'key' 		=> 'ovaev_start_date_time',
								'value' 	=> array( strtotime($ovaev_start_date_search)-1, strtotime($ovaev_end_date_search)+(24*60*60)+1 ),
								'type' 		=> 'numeric',
								'compare' 	=> 'BETWEEN'	
							),
							array(
								'relation' 	=> 'AND',
								array(
									'key' 		=> 'ovaev_start_date_time',
									'value' 	=> strtotime($ovaev_start_date_search),
									'compare' 	=> '<'
								),
								array(
									'key' 		=> 'ovaev_end_date_time',
									'value' 	=> strtotime($ovaev_start_date_search),
									'compare' 	=> '>='
								)
							)
						)
					)
				);
			}
			else if ( $ovaev_start_date_search && !$ovaev_end_date_search ){

				$query->set(
					'meta_query',
					array(

						array(
							'relation' => 'OR',
							array(
								'key' 		=> 'ovaev_start_date_time',
								'value' 	=> [strtotime($ovaev_start_date_search), strtotime($ovaev_start_date_search)+24*60*60],
								'compare' 	=> 'BETWEEN'
							),
							array(
								'relation' 	=> 'AND',
								array(
									'key' 		=> 'ovaev_start_date_time',
									'value' 	=> strtotime($ovaev_start_date_search),
									'compare' 	=> '<'
								),
								array(
									'key' 		=> 'ovaev_end_date_time',
									'value' 	=> strtotime($ovaev_start_date_search),
									'compare' 	=> '>='
								)
							)
						)
					)
				);
			}
			else if ( !$ovaev_start_date_search && $ovaev_end_date_search ){

				$query->set(
					'meta_query',
					array(
						'key' 		=> 'ovaev_end_date_time',
						'value' 	=> strtotime($ovaev_end_date_search)+(24*60*60),
						'compare' 	=> '<='
					)

				);
			}
		}
		remove_action( 'pre_get_posts', array( $this, 'ovaev_pre_get_events_search' ) );

	}
	
	public function ovaev_pre_get_events_archive( $query ) {

		if ( (is_post_type_archive( 'event' )  && !is_admin())  || ( is_tax('event_category') && !is_admin() )  || ( is_tax('event_tag') && !is_admin() ) ) {

			$paged     = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
			$show_past = OVAEV_Settings::ovaev_show_past();
			$order     = OVAEV_Settings::archive_event_order();
			$orderby   = OVAEV_Settings::archive_event_orderby();
			
			if( $show_past == 'no' ){
				$query->set(
					'meta_query',
					array(
						array(
							'key' => 'ovaev_end_date_time',
							'value' => current_time( 'timestamp' ),
							'compare' => '>'
						)
					)
				);
			}

			if( $paged != '' ){
				$query->set( 'paged', $paged );
			}
			
			$query->set( 'post_type', 'event' );
			$query->set( 'order', $order );

			switch ($orderby) {
				case 'title':
				$query->set( 'orderby', 'title' );
				break;

				case 'event_custom_sort':
				$query->set( 'orderby' , 'meta_value' );
				$query->set( 'meta_key', $orderby );
				break;

				case 'ovaev_start_date':
				$query->set( 'orderby' , 'meta_value' );
				$query->set( 'meta_key', 'ovaev_start_date_time' );
				break;
				
				case 'ID':
				$query->set( 'orderby', 'ID');
				break;
			}

		}

		remove_action( 'pre_get_posts', array( $this, 'ovaev_pre_get_events_archive' ) );
	}	
	

	/**
	 * Categories Event Type
	 */
	public function OVAEV_event_type($selected){

		$args = array(
			'show_option_all'   => '' ,
			'show_option_none'   => esc_html__( 'All Categories', 'ovaev' ),
			'post_type'         => 'event',
			'post_status'       => 'publish',
			'posts_per_page'    => '-1',
			'option_none_value' => '',
			'orderby'           => 'ID',
			'order'             => 'ASC',
			'show_count'        => 0,
			'hide_empty'        => 0,
			'child_of'          => 0,
			'exclude'           => '',
			'include'           => '',
			'echo'              => 1,
			'selected'          => $selected,
			'hierarchical'      => 1,
			'name'              => 'ovaev_type',
			'id'                => '',
			'depth'             => 0,
			'tab_index'         => 0,
			'taxonomy'          => 'event_category',
			'hide_if_empty'     => false,
			'value_field'       => 'slug',
			'class' 			=> 'ovaev_type',
		);
		
		return wp_dropdown_categories($args);
	}

	

	public static function get_events_simple_calendar( $category, $filter_event ){

		if( ! $category ) return [];

		if( $category == 'all' ){
			$args_base = array(
				'post_type' 	 => 'event',
				'post_status' 	 => 'publish',
				'orderby'		 => 'id',
				'order'			 => 'ASC',
				'posts_per_page' => '-1'
			);
		} else {
			$args_base = array(
				'post_type' 		=> 'event',
				'post_status' 		=> 'publish',
				'orderby'			=> 'id',
				'order'				=> 'ASC',
				'posts_per_page' 	=> '-1',
				'tax_query' => array(
					array(
						'taxonomy' => 'event_category',
						'field'    => 'slug',
						'terms'    => $category,
					)
				),
			);
		}

		//filter event
		if ( $filter_event == 'past_event' ) {
			$args_base['meta_query'] = [
				[
					'key' => 'ovaev_end_date_time',
					'value' => current_time( 'timestamp' ),
					'compare' => '<'
				],
			];
		} elseif ( $filter_event == 'upcoming_event' ) {
			$args_base['meta_query'] = [
				[
					'key' => 'ovaev_end_date_time',
					'value' => current_time( 'timestamp' ),
					'compare' => '>'
				],
			];
		} else {
			if ( $filter_event == 'special_event' ) {
				$args_base['meta_query'] = [
					[
						'key' => 'ovaev_special',
						'value' => 'checked',
						'compare' => '='
					],
				];
			}
		}

		$events = new WP_Query( $args_base );

		$events_array = array();

		if($events->have_posts() ) : while ( $events->have_posts() ) : $events->the_post();
				
			$id 		= get_the_id();
			$start_date = get_post_meta( $id, 'ovaev_start_date', true );
			$end_date 	= get_post_meta( $id, 'ovaev_end_date', true );	
			$item 		=  array(  
				'endDate' 	=> date( 'Y-m-d', strtotime( $end_date ) ) ,
				'startDate' => date( 'Y-m-d', strtotime( $start_date ) ) ,
				'url' 		=> get_post_type_archive_link( 'event' ).'?ovaev_start_date_search='.$start_date.'&ovaev_end_date_search=&ovaev_type=&post_type=event&search_event=search-event',
				
			);

	   		array_push($events_array, $item);

		endwhile; endif; wp_reset_postdata();
	    return json_encode( $events_array );
	}

	public static function get_events_calendar( $category, $filter_event ){
		if( ! $category ) return [];
		
		if( $category == 'all' ){
			$args_base = [
				'post_type' 	 => 'event',
				'post_status' 	 => 'publish',
				'orderby'		 => 'id',
				'order'			 => 'ASC',
				'posts_per_page' => '-1',
			];
		} else {
			$args_base = [
				'post_type' 		=> 'event',
				'post_status' 		=> 'publish',
				'orderby'			=> 'id',
				'order'				=> 'ASC',
				'posts_per_page' 	=> '-1',
				'tax_query' => [
					[
						'taxonomy' => 'event_category',
						'field'    => 'slug',
						'terms'    => $category,
					]
				],
			];
		}

		//filter event
		if ( $filter_event == 'past_event' ) {
			$args_base['meta_query'] = [
				[
					'key' => 'ovaev_end_date_time',
					'value' => current_time( 'timestamp' ),
					'compare' => '<'
				],
			];
		} elseif ( $filter_event == 'upcoming_event' ) {
			$args_base['meta_query'] = [
				[
					'key' => 'ovaev_end_date_time',
					'value' => current_time( 'timestamp' ),
					'compare' => '>'
				],
			];
		} else {
			if ( $filter_event == 'special_event' ) {
				$args_base['meta_query'] = [
					[
						'key' => 'ovaev_special',
						'value' => 'checked',
						'compare' => '='
					],
				];
			}
		}

		$events 	  = new WP_Query( $args_base );

		$events_array = array();

		if($events->have_posts() ) : while ( $events->have_posts() ) : $events->the_post();
				
			$id 				= get_the_id();
			$start_date 		= get_post_meta( $id, 'ovaev_start_date', true );
			$end_date 			= get_post_meta( $id, 'ovaev_end_date', true );	

			$special_event 		= get_post_meta( $id, 'ovaev_special', true );	

			$time_format 		= OVAEV_Settings::archive_event_format_time();

			$ovaev_start_date 	= get_post_meta( $id, 'ovaev_start_date_time', true );
			$ovaev_end_date   	= get_post_meta( $id, 'ovaev_end_date_time', true );

			$date_start    		= $ovaev_start_date != '' ? date_i18n(get_option('date_format'), $ovaev_start_date) : '';
			$date_end      		= $ovaev_end_date != '' ? date_i18n(get_option('date_format'), $ovaev_end_date) : '';

			$time_start    		= $ovaev_start_date != '' ? date_i18n( 'H:i', $ovaev_start_date ) : '';
			$time_end      		= $ovaev_end_date != '' ? date_i18n( 'H:i', $ovaev_end_date ) : '';

			$item = [
				'start' 	=> date( 'Y-m-d', strtotime( $start_date ) ) .' '.$time_start,
				'end' 		=> date( 'Y-m-d', strtotime( $end_date ) ) .' '.$time_end,
				'url' 		=> get_the_permalink(),
				'title' 	=> get_the_title(),
				'desc' 		=> '<a href='.get_the_permalink().'>'.get_the_post_thumbnail().'</a>'
								.'<p><a href='.get_the_permalink().'>'.get_the_title().'</a></p>',
				'special' 	=> $special_event,

			];
			array_push($events_array, $item);

		endwhile; endif; wp_reset_postdata();
	    return json_encode( $events_array );
	}

}
new OVAEV_get_data();