<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MB_Ticket_Register' ) ) {
	class MB_Ticket_Register {

		protected $prefix;

		public function __construct() {
			$this->prefix = MB_PLUGIN_PREFIX_TICKET;

			// Init
	        add_action( 'init', array( $this, 'MB_Ticket_register_post_types' ) );

	        // Columns in admin
            add_filter( 'manage_mb_ticket_posts_columns', array( $this, 'MB_Ticket_add_columns_for_ticket' ) );
            add_filter( 'manage_edit-mb_ticket_sortable_columns', array( $this, 'MB_Ticket_sortable_ticket') , 10 );
	        add_filter( 'manage_posts_custom_column', array( $this, 'MB_Ticket_view_columns_for_ticket' ), 10, 2 );
	    }

	    public function MB_Ticket_register_post_types() {
	    	$supports   = array( 'author', 'title'  );

			$args_ticket = array(
				'labels' => array(
					'name'                  => _x( 'Tickets', 'post general name', 'moviebooking' ),
					'singular_name'         => _x( 'Ticket', 'post singular name', 'moviebooking' ),
					'menu_name'             => _x( 'Tickets', 'Admin menu name', 'moviebooking' ),
					'all_items'             => esc_html__( 'All Tickets', 'moviebooking' ),
					'add_new'               => esc_html__( 'Add New', 'moviebooking' ),
					'add_new_item'          => esc_html__( 'Add New', 'moviebooking' ),
					'edit'                  => esc_html__( 'Edit', 'moviebooking' ),
					'edit_item'             => esc_html__( 'Edit Ticket', 'moviebooking' ),
					'new_item'              => esc_html__( 'New Ticket', 'moviebooking' ),
					'view_item'             => esc_html__( 'View Ticket', 'moviebooking' ),
					'view_items'            => esc_html__( 'View Ticket', 'moviebooking' ),
					'search_items'          => esc_html__( 'Search Tickets', 'moviebooking' ),
					'not_found'             => esc_html__( 'No Tickets found', 'moviebooking' ),
					'not_found_in_trash'    => esc_html__( 'No Tickets found in trash', 'moviebooking' ),
					'parent'                => esc_html__( 'Parent Tickets', 'moviebooking' ),
					'featured_image'        => esc_html__( 'Ticket image', 'moviebooking' ),
					'set_featured_image'    => esc_html__( 'Set Ticket image', 'moviebooking' ),
					'remove_featured_image' => esc_html__( 'Remove Ticket image', 'moviebooking' ),
					'use_featured_image'    => esc_html__( 'Use as Ticket image', 'moviebooking' ),
					'insert_into_item'      => esc_html__( 'Insert into Ticket', 'moviebooking' ),
					'uploaded_to_this_item' => esc_html__( 'Uploaded to this Ticket', 'moviebooking' ),
					'filter_items_list'     => esc_html__( 'Filter Tickets', 'moviebooking' ),
					'items_list_navigation' => esc_html__( 'Tickets navigation', 'moviebooking' ),
					'items_list'            => esc_html__( 'Tickets list', 'moviebooking' ),
				),
				
				'public'             => false,
				'query_var'          => true,
				'publicly_queryable' => false,
				'show_ui'            => true,
				'has_archive'        => false,
				'capability_type'    => 'post',
				'capabilities' 		 => array( 'create_posts' => false ),
				'map_meta_cap'       => true,
				'show_in_menu'       => true,	
				'show_in_nav_menus'  => false,
				'show_in_admin_bar'  => true,
				'supports'           => $supports,
				'hierarchical'       => false,
				'show_in_rest'       => false,
				'rewrite'            => array(
					'slug'       => _x('mb_ticket','Ticket Slug', 'moviebooking'),
					'with_front' => false,
					'feeds'      => true,
				),
				'menu_position'      => 5,
				'menu_icon'          => 'dashicons-tickets-alt'
			);

			$args = apply_filters( 'mb_ft_register_post_type_mb_ticket', $args_ticket );
			register_post_type( 'mb_ticket', $args );
	    }

	    public function MB_Ticket_add_columns_for_ticket( $columns ) {
	    	unset( $columns['title'] );
	    	unset( $columns['author'] );
	    	unset( $columns['date'] );

            $columns[$this->prefix.'ticket_id'] 	= esc_html__( 'Ticket Number', 'moviebooking' );
            $columns[$this->prefix.'booking_id'] 	= esc_html__( 'Booking ID', 'moviebooking' );
            $columns[$this->prefix.'movie'] 		= esc_html__( 'Movie', 'moviebooking' );
            $columns[$this->prefix.'date'] 			= esc_html__( 'Showtimes', 'moviebooking' );
            $columns[$this->prefix.'customer'] 		= esc_html__( 'Customer', 'moviebooking' );
            $columns[$this->prefix.'seat'] 			= esc_html__( 'Seat', 'moviebooking' );
            $columns[$this->prefix.'qr_code'] 		= esc_html__( 'QR code', 'moviebooking' );
            $columns[$this->prefix.'status'] 		= esc_html__( 'Status', 'moviebooking' );
            $columns['author']    					= esc_html__( 'Author', 'moviebooking' );
            $columns['date'] 						= esc_html__( 'Date', 'moviebooking' );

            return $columns;
	    }

	    public function MB_Ticket_sortable_ticket( $columns ) {
	    	$columns[$this->prefix.'ticket_id'] 	= $this->prefix.'ticket_id';
	    	$columns[$this->prefix.'booking_id'] 	= $this->prefix.'booking_id';

			return $columns;
	    }

	    public function MB_Ticket_view_columns_for_ticket( $column, $post_id ) {
	    	switch ( $column ) {
	    		case $this->prefix.'ticket_id':
                    $ticket_number 		= get_post_meta( $post_id, $this->prefix.'ticket_id', true );
                    $ticket_edit_url 	= get_edit_post_link( $ticket_number ) ? get_edit_post_link( $ticket_number ) : '#';

                    echo '<a href="'.esc_url( $ticket_edit_url ).'" target="_blank">'.esc_html( $ticket_number ).'</a>';
                    break;
                case $this->prefix.'booking_id':
                    $booking_id 		= get_post_meta( $post_id, $this->prefix.'booking_id', true );
                    $booking_edit_url 	= get_edit_post_link( $booking_id ) ? get_edit_post_link( $booking_id ) : '#';

                    echo '<a href="'.esc_url( $booking_edit_url ).'" target="_blank">'.esc_html( $booking_id ).'</a>';
                    break;
                case $this->prefix.'movie':
                    $movie_id 		= get_post_meta( $post_id, $this->prefix.'movie_id', true );
                    $movie_title 	= get_the_title( $movie_id );
                    $movie_edit_url = get_edit_post_link( $movie_id ) ? get_edit_post_link( $movie_id ) : '#';

                    echo '<a href="'.esc_url( $movie_edit_url ).'" target="_blank">'.esc_html( $movie_title ).'</a>';
                    break;
                case $this->prefix.'date':
                    $date 			= get_post_meta( $post_id, $this->prefix.'date', true );
                    $booking_id 	= get_post_meta( $post_id, $this->prefix.'booking_id', true );
                    $showtime_id 	= get_post_meta( $booking_id, MB_PLUGIN_PREFIX_BOOKING.'showtime_id', true );

                    if ( $date ) {
                    	$date_format = MBC()->mb_get_date_time_format();

                    	if ( $showtime_id ) {
                    		$showtime_edit_url = get_edit_post_link( $showtime_id ) ? get_edit_post_link( $showtime_id ) : '#';
                    		echo '<a href="'.esc_url( $showtime_edit_url ).'" target="_blank"><strong>'.date( $date_format, $date ).'</strong></a>';
                    	} else {
                    		echo '<strong>'.date( $date_format, $date ).'</strong>';
                    	}
                    }
                    break;
                case $this->prefix.'customer':
                    $customer_id 	= get_post_meta( $post_id, $this->prefix.'customer_id', true );
                    $customer_name 	= get_post_meta( $post_id, $this->prefix.'customer_name', true );

                    if ( $customer_id ) {
                    	$customer_edit_url = get_edit_user_link( $customer_id );
                    	echo '<a href="'.esc_url( $customer_edit_url ).'" target="_blank">'.esc_html( $customer_name ).'</a>';
                    } else {
                    	echo esc_html( $customer_name );
                    }
                    break;
                case $this->prefix.'seat':
                    $seat 			= get_post_meta( $post_id, $this->prefix.'seat', true );
                    $person_type 	= get_post_meta( $post_id, $this->prefix.'person_type', true );
                    $booking_id 	= get_post_meta( $post_id, $this->prefix.'booking_id', true );
                    $room_id 		= get_post_meta( $booking_id, MB_PLUGIN_PREFIX_BOOKING.'room_id', true );
                    	
                    if ( ! empty( $person_type ) ) {
                    	$seat .= ' - '.$person_type;
                    }

                    if ( $room_id ) {
                    	$room_edit_url = get_edit_post_link( $room_id ) ? get_edit_post_link( $room_id ) : '#';
                    	echo '<a href="'.esc_url( $room_edit_url ).'" target="_blank">'.esc_html( $seat ).'</a>';
                    } else {
                    	echo esc_html( $seat );
                    }
                    break;
                case $this->prefix.'qr_code':
                    $qr_code = get_post_meta( $post_id, $this->prefix.'qr_code', true );
                    
                    echo esc_html( $qr_code );
                    break;
                case $this->prefix.'status':
                    $status = get_post_meta( $post_id, $this->prefix.'ticket_status', true );
                    echo esc_html( $status );
                    break;
                default:
                	break;
            }
	    }
	}

	return new MB_Ticket_Register();
}