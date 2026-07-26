<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MB_Booking_Register' ) ) {
	class MB_Booking_Register {

		protected $prefix;

		public function __construct() {
			$this->prefix = MB_PLUGIN_PREFIX_BOOKING;

			// Init
	        add_action( 'init', array( $this, 'MB_Booking_register_post_types' ) );

	        // Columns in admin
            add_filter( 'manage_mb_booking_posts_columns', array( $this, 'MB_Booking_add_columns_for_ticket' ) );
            add_filter( 'manage_posts_custom_column', array( $this, 'MB_Booking_view_columns_for_ticket' ), 10, 2 );
	    }

	    public function MB_Booking_register_post_types() {
	    	$supports   = array( 'author', 'title'  );

			$args_booking = array(
				'labels' => array(
					'name'                  => _x( 'Bookings', 'post general name', 'moviebooking' ),
					'singular_name'         => _x( 'Booking', 'post singular name', 'moviebooking' ),
					'menu_name'             => _x( 'Bookings', 'Admin menu name', 'moviebooking' ),
					'all_items'             => esc_html__( 'All Bookings', 'moviebooking' ),
					'add_new'               => esc_html__( 'Add New', 'moviebooking' ),
					'add_new_item'          => esc_html__( 'Add New', 'moviebooking' ),
					'edit'                  => esc_html__( 'Edit', 'moviebooking' ),
					'edit_item'             => esc_html__( 'Edit Booking', 'moviebooking' ),
					'new_item'              => esc_html__( 'New Booking', 'moviebooking' ),
					'view_item'             => esc_html__( 'View Booking', 'moviebooking' ),
					'view_items'            => esc_html__( 'View Booking', 'moviebooking' ),
					'search_items'          => esc_html__( 'Search Bookings', 'moviebooking' ),
					'not_found'             => esc_html__( 'No Bookings found', 'moviebooking' ),
					'not_found_in_trash'    => esc_html__( 'No Bookings found in trash', 'moviebooking' ),
					'parent'                => esc_html__( 'Parent Bookings', 'moviebooking' ),
					'featured_image'        => esc_html__( 'Booking image', 'moviebooking' ),
					'set_featured_image'    => esc_html__( 'Set Booking image', 'moviebooking' ),
					'remove_featured_image' => esc_html__( 'Remove Booking image', 'moviebooking' ),
					'use_featured_image'    => esc_html__( 'Use as Booking image', 'moviebooking' ),
					'insert_into_item'      => esc_html__( 'Insert into Booking', 'moviebooking' ),
					'uploaded_to_this_item' => esc_html__( 'Uploaded to this Booking', 'moviebooking' ),
					'filter_items_list'     => esc_html__( 'Filter Bookings', 'moviebooking' ),
					'items_list_navigation' => esc_html__( 'Bookings navigation', 'moviebooking' ),
					'items_list'            => esc_html__( 'Bookings list', 'moviebooking' ),
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
				'supports'           => $supports,
				'hierarchical'       => false,
				'show_in_rest'       => false,
				'rewrite'            => array(
					'slug'       => _x('mb_booking','Booking Slug', 'moviebooking'),
					'with_front' => false,
					'feeds'      => true,
				),
				'menu_position'      => 5,
				'menu_icon'          => 'dashicons-products'
			);

			$args = apply_filters( 'mb_ft_register_post_type_mb_booking', $args_booking );
			register_post_type( 'mb_booking', $args );
	    }

	    public function MB_Booking_add_columns_for_ticket( $columns ) {
	    	unset( $columns['author'] );
	    	unset( $columns['date'] );

	    	$columns[$this->prefix.'date'] 			= esc_html__( 'Showtimes', 'moviebooking' );
	    	$columns[$this->prefix.'seat'] 			= esc_html__( 'Seats', 'moviebooking' );
	    	$columns[$this->prefix.'area'] 			= esc_html__( 'Areas', 'moviebooking' );
	    	$columns[$this->prefix.'subtotal'] 		= esc_html__( 'Subtotal', 'moviebooking' );
	    	$columns[$this->prefix.'discount'] 		= esc_html__( 'Discount', 'moviebooking' );
	    	$columns[$this->prefix.'tax'] 			= esc_html__( 'Tax', 'moviebooking' );
	    	$columns[$this->prefix.'ticket_fee'] 	= esc_html__( 'Ticket Fee', 'moviebooking' );
	    	$columns[$this->prefix.'total'] 		= esc_html__( 'Total', 'moviebooking' );
	    	$columns[$this->prefix.'status'] 		= esc_html__( 'Status', 'moviebooking' );
	    	$columns[$this->prefix.'customer'] 		= esc_html__( 'Customer', 'moviebooking' );
	    	$columns['author'] 						= esc_html__( 'Author', 'moviebooking' );
            $columns['date'] 						= esc_html__( 'Date', 'moviebooking' );

            return $columns;
	    }

	    public function MB_Booking_view_columns_for_ticket( $column, $post_id ) {
	    	switch ( $column ) {
	    		case $this->prefix.'date':
                    $date 			= get_post_meta( $post_id, $this->prefix.'date', true );
                    $showtime_id 	= get_post_meta( $post_id, $this->prefix.'showtime_id', true );

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
                case $this->prefix.'seat':
                	$seats = get_post_meta( $post_id, $this->prefix.'seat', true );

                	if ( mb_array_exists( $seats ) ) {
                		echo '<strong>'.join( ', ', $seats ).'</strong>';
                	}
                	break;
                case $this->prefix.'area':
                	$html_area 	= [];
                	$areas 		= get_post_meta( $post_id, $this->prefix.'area', true );
                	$person_type = get_post_meta( $post_id, $this->prefix.'person_type', true );

                	if ( ! empty( $areas ) && is_array( $areas ) ) {
                		foreach ( $areas as $area_id => $qty ) {
                			if ( ! empty( $person_type ) && array_key_exists($area_id, $person_type) ) {
                				foreach ( $person_type[$area_id] as $key => $value ) {
                					array_push( $html_area, $area_id.' - '.$value['id'].'(x'.absint( $value['qty'] ).')' );
                				}
                				
                			} else {
                				array_push( $html_area, $area_id.'(x'.absint( $qty ).')' );
                			}
                			
                		}
                	}

                	if ( mb_array_exists( $html_area ) ) {
                		echo '<strong>'.join( '<span>, </span></br>', $html_area ).'</strong>';
                	}
                	break;
                case $this->prefix.'subtotal':
                	$subtotal = get_post_meta( $post_id, $this->prefix.'subtotal', true );
                	$incl_tax = get_post_meta( $post_id, $this->prefix.'incl_tax', true );

                	if ( $incl_tax === 'yes' ) {
                		echo wc_price( floatval( $subtotal ) ).esc_html__( '(ex. tax)', 'moviebooking' );
                	} else {
                		echo wc_price( floatval( $subtotal ) );
                	}
                	break;
               	case $this->prefix.'discount':
                	$discount 		= get_post_meta( $post_id, $this->prefix.'discount', true );
                	$discount_code 	= get_post_meta( $post_id, $this->prefix.'discount_code', true );

                	if ( $discount ) {
                		echo '-'.wc_price( floatval( $discount ) ).'('.$discount_code.')';
                	}
                	break;
                case $this->prefix.'tax':
                	$tax = get_post_meta( $post_id, $this->prefix.'tax', true );

                	if ( $tax ) {
                		echo wc_price( floatval( $tax ) );
                	}
                	break;
                case $this->prefix.'ticket_fee':
                	$ticket_fee = get_post_meta( $post_id, $this->prefix.'ticket_fee', true );

                	if ( $ticket_fee ) {
                		echo wc_price( floatval( $ticket_fee ) );
                	}
                	break;
                case $this->prefix.'total':
                	$total = get_post_meta( $post_id, $this->prefix.'total', true );

                	if ( $total ) {
                		echo '<strong>'.wc_price( floatval( $total ) ).'</strong>';
                	}
                	break;
                case $this->prefix.'status':
                	$status = get_post_meta( $post_id, $this->prefix.'status', true );

                	if ( $status ) {
                		echo '<strong>'.$status.'</strong>';
                	}
                	break;
                case $this->prefix.'customer':
                	$name 	= get_post_meta( $post_id, $this->prefix.'customer_name', true );
                	$email 	= get_post_meta( $post_id, $this->prefix.'customer_email', true );
                	$phone 	= get_post_meta( $post_id, $this->prefix.'customer_phone', true );

                	if ( ! $name && ! $email && ! $phone ) {
                		$order_id = get_post_meta( $post_id, $this->prefix.'order_id', true );

                		if ( $order_id ) {
                			$order 		= wc_get_order( $order_id );
							$address 	= $order->get_address();
							$first_name = isset( $address['first_name'] ) ? $address['first_name'] : '';
							$last_name  = isset( $address['last_name'] ) ? $address['last_name'] : '';
							$name 		= $first_name . ' ' .$last_name;
							$email  	= isset( $address['email'] ) ? $address['email'] : '';
							$phone  	= isset( $address['phone'] ) ? $address['phone'] : '';
                		}
                	}

                	echo esc_html__( 'Name: ' ) . $name . '<br>' . esc_html__( 'Email: ' ) . $email . '<br>' . esc_html__( 'Phone: ' ) . $phone;
                	break;
                default:
                	break;
            }
	    }
	}

	return new MB_Booking_Register();
}