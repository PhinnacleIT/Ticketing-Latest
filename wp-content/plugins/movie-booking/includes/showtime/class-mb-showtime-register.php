<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MB_Showtime_Register' ) ) {
	class MB_Showtime_Register {

		protected $prefix;

		public function __construct() {
			$this->prefix = MB_PLUGIN_PREFIX_SHOWTIME;

			// Init
	        add_action( 'init', array( $this, 'MB_Showtime_register_post_types' ) );
	        add_action( 'init', array( $this, 'MB_Showtime_register_taxonomies' ) );

	        // Location
	        add_filter( 'taxonomy_parent_dropdown_args', array( $this, 'MB_Showtime_taxonomy_parent_dropdown_args' ), 10, 3 );

	        // Columns in admin
            add_filter( 'manage_showtime_posts_columns', array( $this, 'MB_Showtime_add_columns_for_showtime' ) );
            add_filter( 'manage_edit-showtime_sortable_columns', array( $this, 'MB_Showtime_sortable_ticket') , 10 );
	        add_filter( 'manage_posts_custom_column', array( $this, 'MB_Showtime_view_columns_for_showtime' ), 10, 2 );
	    }

	    public function MB_Showtime_register_post_types() {
	    	$supports   = array( 'author', 'title'  );
			$taxonomies = array( 'movie_location' );

			$args_showtime = array(
				'labels' => array(
					'name'                  => _x( 'Showtimes', 'post general name', 'moviebooking' ),
					'singular_name'         => _x( 'Time', 'post singular name', 'moviebooking' ),
					'menu_name'             => _x( 'Showtimes', 'Admin menu name', 'moviebooking' ),
					'all_items'             => esc_html__( 'All Times', 'moviebooking' ),
					'add_new'               => esc_html__( 'Add New', 'moviebooking' ),
					'add_new_item'          => esc_html__( 'Add New', 'moviebooking' ),
					'edit'                  => esc_html__( 'Edit', 'moviebooking' ),
					'edit_item'             => esc_html__( 'Edit Time', 'moviebooking' ),
					'new_item'              => esc_html__( 'New Time', 'moviebooking' ),
					'view_item'             => esc_html__( 'View Time', 'moviebooking' ),
					'view_items'            => esc_html__( 'View Time', 'moviebooking' ),
					'search_items'          => esc_html__( 'Search Times', 'moviebooking' ),
					'not_found'             => esc_html__( 'No Times found', 'moviebooking' ),
					'not_found_in_trash'    => esc_html__( 'No Times found in trash', 'moviebooking' ),
					'parent'                => esc_html__( 'Parent Times', 'moviebooking' ),
					'featured_image'        => esc_html__( 'Time image', 'moviebooking' ),
					'set_featured_image'    => esc_html__( 'Set Time image', 'moviebooking' ),
					'remove_featured_image' => esc_html__( 'Remove Time image', 'moviebooking' ),
					'use_featured_image'    => esc_html__( 'Use as Time image', 'moviebooking' ),
					'insert_into_item'      => esc_html__( 'Insert into Time', 'moviebooking' ),
					'uploaded_to_this_item' => esc_html__( 'Uploaded to this Time', 'moviebooking' ),
					'filter_items_list'     => esc_html__( 'Filter times', 'moviebooking' ),
					'items_list_navigation' => esc_html__( 'Times navigation', 'moviebooking' ),
					'items_list'            => esc_html__( 'Times list', 'moviebooking' ),
				),
				
				'public'             => false,
				'query_var'          => true,
				'publicly_queryable' => false,
				'show_ui'            => true,
				'has_archive'        => false,
				'capability_type'    => 'post',
				'map_meta_cap'       => true,
				'show_in_menu'       => true,	
				'show_in_nav_menus'  => false,
				'show_in_admin_bar'  => true,
				'taxonomies'         => $taxonomies,
				'supports'           => $supports,
				'hierarchical'       => false,
				'show_in_rest'       => false,
				'rewrite'            => array(
					'slug'       => _x('showtime','Showtimes Slug', 'moviebooking'),
					'with_front' => false,
					'feeds'      => true,
				),
				'menu_position'      => 5,
				'menu_icon'          => 'dashicons-schedule'
			);

			$args = apply_filters( 'mb_ft_register_post_type_showtime', $args_showtime );
			register_post_type( 'showtime', $args );
	    }

	    public function MB_Showtime_register_taxonomies() {
	    	$labels = array(
				'name'              => _x( 'Locations', 'taxonomy general name', 'moviebooking' ),
				'singular_name'     => _x( 'Location', 'taxonomy singular name', 'moviebooking' ),
				'menu_name'         => _x( 'Locations', 'Admin menu name', 'moviebooking' ),
				'search_items'      => esc_html__( 'Search Location', 'moviebooking' ),
				'all_items'         => esc_html__( 'All Locations', 'moviebooking' ),
				'parent_item'       => esc_html__( 'Parent Location', 'moviebooking' ),
				'parent_item_colon' => esc_html__( 'Parent Location:', 'moviebooking' ),
				'edit_item'         => esc_html__( 'Edit Location', 'moviebooking' ),
				'update_item'       => esc_html__( 'Update Location', 'moviebooking' ),
				'add_new_item'      => esc_html__( 'Add New', 'moviebooking' ),
				'new_item_name'     => esc_html__( 'New Location', 'moviebooking' ),
				'not_found'     	=> esc_html__( 'No Locations found.', 'moviebooking' ),
			);

			$args = array(
				'hierarchical'       	=> true,
				'label'              	=> esc_html__( 'Locations', 'moviebooking' ),
				'labels'             	=> $labels,
				'public'             	=> false,
				'show_ui'            	=> true,
				'show_admin_column'  	=> true,
				'query_var'          	=> true,
				'show_in_rest'       	=> true,
				'meta_box_cb' 		 	=> false,
				'show_admin_column' 	=> false,
				'show_in_quick_edit' 	=> false,
				'rewrite'            	=> array(
					'slug'       => _x( 'movie_location','Movies Location Slug', 'moviebooking' ),
					'with_front' => false,
					'feeds'      => true,
				),
				
			);

			$args = apply_filters( 'mb_ft_register_taxonomy_movie_location', $args );
			register_taxonomy( 'movie_location', array( 'showtime' ), $args );
	    }

	    public function MB_Showtime_taxonomy_parent_dropdown_args( $dropdown_args, $taxonomy, $action ) {
	    	if ( $taxonomy === 'movie_location' ) {
	    		$dropdown_args['parent'] = 0;
	    	}

	    	return $dropdown_args;
	    }

	    public function MB_Showtime_sortable_ticket( $columns ) {
	    	$columns[$this->prefix.'date'] 		= $this->prefix.'date';

			return $columns;
	    }

	    public function MB_Showtime_add_columns_for_showtime( $columns ) {
	    	$prefix = MB_PLUGIN_PREFIX_SHOWTIME;

	    	unset( $columns['author'] );
	    	unset( $columns['date'] );

            $columns[$prefix.'movie_id'] 	= esc_html__( 'Movie', 'moviebooking' );
            $columns[$prefix.'date'] 		= esc_html__( 'Showtimes', 'moviebooking' );
            $columns[$prefix.'city_id'] 	= esc_html__( 'City', 'moviebooking' );
            $columns[$prefix.'venue_id'] 	= esc_html__( 'Venue', 'moviebooking' );
            $columns[$prefix.'room_ids'] 	= esc_html__( 'Rooms', 'moviebooking' );
            $columns['author']    			= esc_html__( 'Author', 'moviebooking' );
            $columns['date'] 				= esc_html__( 'Date', 'moviebooking' );

            return $columns;
	    }

	    public function MB_Showtime_view_columns_for_showtime( $column, $post_id ) {
	    	$prefix = MB_PLUGIN_PREFIX_SHOWTIME;

	    	switch ( $column ) {
	    		case $prefix.'movie_id':
                    $movie_id 	= get_post_meta( $post_id, $prefix.'movie_id', true );
                    $movie_url 	= get_edit_post_link( $movie_id ) ? get_edit_post_link( $movie_id ) : '#';

                    if ( $movie_id ) {
                    	echo '<a href="'.esc_url( $movie_url ).'" target="_blank">'.esc_html( get_the_title( $movie_id ) ).'</a>';
                    }
                    break;
	    		case $prefix.'date':
                    $date = get_post_meta( $post_id, $prefix.'date', true );

                    if ( $date ) {
                    	$date_format = MBC()->mb_get_date_time_format();
                    	echo date( $date_format, $date );
                    }
                    break;
                case $prefix.'city_id':
                    $city_id 	= get_post_meta( $post_id, $prefix.'city_id', true );
                    $city_name 	= MBC()->mb_get_taxonomy_name( $city_id, 'movie_location' );

                    if ( $city_name ) {
                    	$city_link = get_edit_term_link( $city_id, 'movie_location' );
                    	echo '<a href="'.esc_url( $city_link ).'" target="_blank">'.esc_html( $city_name ).'</a>';
                    }
                    break;
                case $prefix.'venue_id':
                    $venue_id 	= get_post_meta( $post_id, $prefix.'venue_id', true );
                    $venue_name = MBC()->mb_get_taxonomy_name( $venue_id, 'movie_location' );

                    if ( $venue_name ) {
                    	$venue_link = get_edit_term_link( $venue_id, 'movie_location' );
                    	echo '<a href="'.esc_url( $venue_link ).'" target="_blank">'.esc_html( $venue_name ).'</a>';
                    }
                    break;
                case $prefix.'room_ids':
                    $room_ids 	= get_post_meta( $post_id, $prefix.'room_ids', true );

                    if ( ! empty( $room_ids ) && is_array( $room_ids ) ) {
                    	$room_data = array();

                    	foreach( $room_ids as $room_id ) {
                    		$room_name = get_the_title( $room_id );
                    		$room_link = get_edit_post_link( $room_id ) ? get_edit_post_link( $room_id ) : '#';
                    		$room_html = '<a href="'.esc_url( $room_link ).'" title="'.esc_html( $room_name ).'" target="_blank">'.esc_html( $room_name ).'</a>';

                    		if ( $room_name && $room_link ) {
                    			array_push( $room_data , $room_html );
                    		}
                    	}

                    	if ( ! empty( $room_data ) && is_array( $room_data ) ) {
                    		echo join( ', ', $room_data );
                    	}
                    }
                    break;
            }
	    }
	}

	return new MB_Showtime_Register();
}