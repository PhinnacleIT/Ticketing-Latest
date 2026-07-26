<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MB_Booking' ) ) {
    class MB_Booking {
        /**
         * instance
         * @var null
         */
        protected static $_instance = null;

        protected $_prefix = MB_PLUGIN_PREFIX_BOOKING;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        public function add_booking( $data ) {
            if ( ! empty( $data ) && is_array( $data ) ) {
                $showtime_id    = isset( $data['showtime_id'] ) ? sanitize_text_field( $data['showtime_id'] ) : '';
                $city_id        = get_post_meta( $showtime_id, MB_PLUGIN_PREFIX_SHOWTIME.'city_id', true );
                $venue_id       = get_post_meta( $showtime_id, MB_PLUGIN_PREFIX_SHOWTIME.'venue_id', true );
                $room_id        = isset( $data['room_id'] ) ? sanitize_text_field( $data['room_id'] ) : '';
                $movie_id       = MB_Movie()->get_id_by_showtime( $showtime_id );

                if ( ! $showtime_id || ! $room_id || ! $movie_id ) {
                    return false;
                }

                $movie_title    = get_the_title( $movie_id );
                $movie_author   = get_post_field( 'post_author', $movie_id );

                // Settings
                $enable_tax = MB()->options->tax_fee->get( 'enable_tax' );
                $tax_type   = MB()->options->tax_fee->get( 'type_tax' );
                $tax_fee    = 0;
                $incl_tax   = MB()->options->tax_fee->get( 'prices_include_tax', 'no' );

                if ( $enable_tax === 'yes' ) {
                    if ( $tax_type === 'percent' ) {
                        $tax_fee = MB()->options->tax_fee->get( 'pecent_tax' );
                    }

                    if ( $tax_type === 'amount' ) {
                        $tax_fee = MB()->options->tax_fee->get( 'amount_tax' );
                    }
                }

                // Cart
                $cart = isset( $data['cart'] ) ? (array)$data['cart'] : array();
                $cart = MB_Cart()->sanitize_cart_map( $cart );
                $data_extra_service = array();

                // Date
                $date = get_post_meta( $showtime_id, MB_PLUGIN_PREFIX_SHOWTIME.'date', true );
                
                // Seats
                $seat_booked = array();

                // Areas
                $area_booked = array();

                $person_type_booked = array();

                // Add Seat and Qty
                if ( ! empty( $cart ) && is_array( $cart ) ) {
                    foreach( $cart as $item ) {

                        $extra_service = isset( $item['extra_service'] ) ? $item['extra_service'] : array();
                        if ( ! empty( $extra_service ) ) {
                            $data_extra_service[$item['id']] = $extra_service;
                        }
                        
                        if ( isset( $item['qty'] ) && absint( $item['qty'] ) ) {
                            $data_person = isset( $item['data_person'] ) ? $item['data_person'] : '';
                            // add person type item
                            if ( ! empty( $data_person ) ) {
                                foreach ( $data_person as $k => $person ) {
                                    $qty = absint( $person['qty'] );
                                    $price = (float)$person['price'];
                                    $extra_service = isset( $person['extra_service'] ) ? $person['extra_service'] : array();

                                    if ( $qty > 0 ) {
                                        $person_type_booked[$item['id']][] = array( 'id' => $person['id'], 'price' => $price ,'qty' => $qty );

                                        if ( ! empty( $extra_service ) ) {
                                            if ( empty( $data_extra_service[$item['id']] ) ) {
                                                $data_extra_service[$item['id']] = $extra_service;
                                            } else {
                                                $data_extra_service[$item['id']] = array_merge_recursive( $data_extra_service[$item['id']],$extra_service );
                                            }
                                            
                                        }
                                        
                                    }
                                }
                            }
                            $area_booked[$item['id']] = absint( $item['qty'] );

                        } else {
                            $seat_booked[] = $item['id'];
                        }
                    }
                }

                // Quantity
                $qty = isset( $data['qty'] ) ? absint( $data['qty'] ) : 0;

                // Sub Total
                $subtotal = isset( $data['subtotal'] ) ? floatval( $data['subtotal'] ) : 0;

                // Discount
                $discount       = isset( $data['discount'] ) ? floatval( $data['discount'] ) : 0;
                $discount_code  = isset( $data['discount_code'] ) ? sanitize_text_field( $data['discount_code'] ) : '';
                $discount_value = isset( $data['discount_value'] ) ? sanitize_text_field( $data['discount_value'] ) : '';
                $discount_type  = isset( $data['discount_type'] ) ? sanitize_text_field( $data['discount_type'] ) : '';

                // Tax
                $tax = isset( $data['tax'] ) ? floatval( $data['tax'] ) : 0;

                // Ticket Fee
                $ticket_fee = isset( $data['ticket_fee'] ) ? floatval( $data['ticket_fee'] ) : 0;

                // Total
                $total = isset( $data['total'] ) ? floatval( $data['total'] ) : 0;

                // Booking data
                $post_data['post_type']     = 'mb_booking';
                $post_data['post_title']    = $movie_title;
                $post_data['post_status']   = 'publish';
                $post_data['post_name']     = $movie_title;
                $post_data['post_author']   = $movie_author;

                $meta_input = array(
                    $this->_prefix.'customer'           => '',
                    $this->_prefix.'customer_name'      => '',
                    $this->_prefix.'customer_email'     => '',
                    $this->_prefix.'customer_phone'     => '',
                    $this->_prefix.'customer_address'   => '',
                    $this->_prefix.'order_id'           => '',
                    $this->_prefix.'showtime_id'        => $showtime_id,
                    $this->_prefix.'city_id'            => $city_id,
                    $this->_prefix.'venue_id'           => $venue_id,
                    $this->_prefix.'room_id'            => $room_id,
                    $this->_prefix.'movie_id'           => $movie_id,
                    $this->_prefix.'cart'               => $cart,
                    $this->_prefix.'seat'               => $seat_booked,
                    $this->_prefix.'area'               => $area_booked,
                    $this->_prefix.'person_type'        => $person_type_booked,
                    $this->_prefix.'extra_service'      => $data_extra_service,
                    $this->_prefix.'date'               => $date,
                    $this->_prefix.'qty'                => $qty,
                    $this->_prefix.'subtotal'           => $subtotal,
                    $this->_prefix.'discount'           => $discount,
                    $this->_prefix.'discount_code'      => $discount_code,
                    $this->_prefix.'discount_value'     => $discount_value,
                    $this->_prefix.'discount_type'      => $discount_type,
                    $this->_prefix.'incl_tax'           => $incl_tax,
                    $this->_prefix.'tax'                => $tax,
                    $this->_prefix.'ticket_fee'         => $ticket_fee,
                    $this->_prefix.'total'              => $total,
                    $this->_prefix.'status'             => 'Pending',
                );

                // Check Holding Ticket
                $holding_ticket = MB()->options->checkout->get('enable_holding_ticket', 'yes');

                if ( 'yes' === $holding_ticket ) {
                    $meta_input[$this->_prefix.'time_countdown_checkout']   = current_time( 'timestamp' );
                    $meta_input[$this->_prefix.'status_holding_ticket']     = 'Pending';
                }

                if ( $enable_tax == 'yes' && $incl_tax != 'no' ) {
                    $meta_input[$this->_prefix.'tax_type'] = $tax_type;
                    $meta_input[$this->_prefix.'tax_fee'] = $tax_fee;
                }

                $post_data['meta_input'] = apply_filters( 'mb_ft_booking_metabox_input', $meta_input );

                if ( $booking_id = wp_insert_post( $post_data, true ) ) {
                    
                    $arr_post = array(
                        'ID'            => $booking_id,
                        'post_title'    => '#' . $booking_id . ' - ' . $movie_title,
                    );

                    wp_update_post( $arr_post );

                    return $booking_id;
                }
            }

            return false;
        }

        public function mb_create_holding_ticket( $data = array(), $booking_id = null ) {
            $showtime_id    = isset( $data['showtime_id'] ) ? sanitize_text_field( $data['showtime_id'] ) : '';
            $room_id        = isset( $data['room_id'] ) ? sanitize_text_field( $data['room_id'] ) : '';
            $movie_id       = MB_Movie()->get_id_by_showtime( $showtime_id );
            $cart           = isset( $data['cart'] ) ? mb_sanitize_cart( $data['cart'] ) : array();
            $extra_service = get_post_meta( $booking_id, MB_PLUGIN_PREFIX_BOOKING.'extra_service', true );
            // Movie Author
            $movie_obj          = get_post( $movie_id );
            $movie_author_id    = $movie_obj->post_author;

            if ( mb_array_exists( $cart ) ) {
                foreach ( $cart as $items ) {
                    if ( isset( $items['id'] ) && $items['id'] ) {
                        $qty    = isset( $items['qty'] ) && absint( $items['qty'] ) ? absint( $items['qty'] ) : '';
                        $code   = $movie_id . '_' . $showtime_id . '_' . $room_id . '_' . trim( $items['id'] );

                        $data = array(
                            'post_type'     => 'holding_ticket',
                            'post_title'    => $code,
                            'post_status'   => 'publish',
                            'post_name'     => $code,
                            'post_author'   => $movie_author_id,
                        );

                        $meta_input = array(
                            $this->_prefix.'movie_id'       => $movie_id,
                            $this->_prefix.'showtime_id'    => $showtime_id,
                            $this->_prefix.'room_id'        => $room_id,
                            $this->_prefix.'booking_id'     => $booking_id,
                            $this->_prefix.'seat'           => trim( $items['id'] ),
                            $this->_prefix.'qty'            => $qty,
                            $this->_prefix.'cart'           => $cart,
                            $this->_prefix.'extra_service'  => $extra_service,
                            $this->_prefix.'current_time'   => current_time( 'timestamp' ),
                            $this->_prefix.'code_checkout'  => $code,
                        );

                        $data['meta_input'] = apply_filters( 'mb_ft_create_holding_ticket_metabox_input', $meta_input );
                        $holding_ticket_id  = wp_insert_post( $data, true );
                    }
                }
            }
        }

        public function mb_get_holding_ticket_ids( $data = array() ) {
            $result         = array();
            $showtime_id    = isset( $data['showtime_id'] ) ? sanitize_text_field( $data['showtime_id'] ) : '';
            $room_id        = isset( $data['room_id'] ) ? sanitize_text_field( $data['room_id'] ) : '';
            $movie_id       = MB_Movie()->get_id_by_showtime( $showtime_id );
            $cart           = isset( $data['cart'] ) ? mb_sanitize_cart( $data['cart'] ) : [];

            if ( mb_array_exists( $cart ) ) {
                $code_arr = array();

                foreach ( $cart as $items ) {
                    if ( isset( $items['id'] ) && $items['id'] ) {
                        $code = $movie_id . '_' . $showtime_id . '_' . $room_id . '_' . trim( $items['id'] );
                        array_push( $code_arr, $code );
                    }
                }

                if ( mb_array_exists( $code_arr ) ) {
                    $seats_regexp = implode( '|', $code_arr );

                    $agrs = [
                        'post_type'         => 'holding_ticket',
                        'post_status'       => 'publish',
                        'posts_per_page'    => -1,
                        'fields'            => 'ids',
                        'meta_query'        => array(
                            array(
                                'key'       => $this->_prefix.'code_checkout',
                                'value'     => $seats_regexp,
                                'compare'   => 'REGEXP' 
                            ),
                        ),
                    ];

                    $holding_tickets = get_posts( $agrs );

                    if ( mb_array_exists( $holding_tickets ) ) {
                        return $holding_tickets;
                    }
                }
            }

            return $result;
        }

        public function success( $booking_id, $order_id = null ) {
            $prefix = MB_PLUGIN_PREFIX_BOOKING;

            // Update Status in booking
            if ( apply_filters( 'mb_ft_new_order_update_status_completed', true ) ) {
                update_post_meta( $booking_id, $prefix.'status', 'Completed', 'Pending' );
            }

            // Update Discount
            $update_coupon = MB_Movie()->update_coupon( $booking_id );

            // Restrict when Reload page while ajax are processing checkout
            if ( ! isset( $_SESSION['booking_id_current'] ) || $_SESSION['booking_id_current'] != $booking_id ) {
                // Add Ticket
                $ticket_ids = MB_Ticket()->add_ticket( $booking_id );

                // Update Record ticket ids to Booking 
                update_post_meta( $booking_id, $prefix.'ticket_ids', $ticket_ids );

                // Update ticket
                if ( ! empty( $ticket_ids ) && is_array( $ticket_ids ) ) {
                    $data_update = array();

                    $customer_id        = get_post_meta( $booking_id, $prefix . 'customer', true );
                    $customer_name      = get_post_meta( $booking_id, $prefix . 'customer_name', true );
                    $customer_email     = get_post_meta( $booking_id, $prefix . 'customer_email', true );
                    $customer_phone     = get_post_meta( $booking_id, $prefix . 'customer_phone', true );
                    $customer_address   = get_post_meta( $booking_id, $prefix . 'customer_address', true );

                    $data_update['customer_id']         = $customer_id;
                    $data_update['customer_name']       = $customer_name;
                    $data_update['customer_email']      = $customer_email;
                    $data_update['customer_phone']      = $customer_phone;
                    $data_update['customer_address']    = $customer_address;

                    foreach( $ticket_ids as $ticket_id ) {
                        $update = MB_Ticket()->update_ticket( $ticket_id, $data_update );
                    }
                }

                $enable_send_booking_email = MB()->options->mail->get( 'enable_send_booking_email', 'yes' );

                if ( $enable_send_booking_email === 'yes' && apply_filters( 'mb_ft_new_order_use_system_mail', true ) ) {
                    MB_Email()->mb_sendmail_by_booking_id( $booking_id );
                }

                $_SESSION['booking_id_current'] = $booking_id;

                MB()->cart_session->remove();
            }

            return true;
        }

        public function get_data_booked( $movie_id = null, $showtime_id = null, $room_id = null ) {
            if ( ! $movie_id || ! $showtime_id || ! $room_id ) return array();

            $movie_ids  = MB_Movie()->get_ids_multi_lang( $movie_id );

            $args = array(
                'post_type'     => 'mb_booking',
                'post_status'   => 'publish',
                'meta_query'    => array(
                    'relation'  => 'AND',
                    array(
                        'key'       => $this->_prefix . 'movie_id',
                        'value'     => $movie_ids,
                        'compare'   => 'IN',
                    ),
                    array(
                        'key'       => $this->_prefix . 'showtime_id',
                        'value'     => $showtime_id,
                    ),
                    array(
                        'key'       => $this->_prefix . 'room_id',
                        'value'     => $room_id,
                    ),
                    array(
                        'key'       => $this->_prefix . 'status',
                        'value'     => 'Completed',
                    ),
                ),
                'posts_per_page'    => -1, 
                'numberposts'       => -1,
                'nopaging'          => true,
            );

            $bookings       = get_posts( $args );
            $area_data_qty  = $this->mb_get_area_qty( $room_id );

            $results = [
                'seat_booked'       => [],
                'area_booked'       => [],
                'area_outofstock'   => []
            ];

            // Get seats and areas booked
            if ( mb_array_exists( $bookings ) ) {
                foreach( $bookings as $booking ) {
                    $seats = get_post_meta( $booking->ID, $this->_prefix . 'seat', true );
                    $areas = get_post_meta( $booking->ID, $this->_prefix . 'area', true );

                    if ( mb_array_exists( $seats ) ) {
                        foreach ( $seats as $seat ) {
                            if ( ! in_array( $seat , $results['seat_booked'] ) ) {
                                $results['seat_booked'][] = $seat;
                            }
                        }
                    }

                    if ( mb_array_exists( $areas ) ) {
                        foreach ( $areas as $area_id => $area_qty ) {
                            if ( array_key_exists( $area_id , $results['area_booked'] ) ) {
                                $results['area_booked'][$area_id] += absint( $area_qty );
                            } else {
                                $results['area_booked'][$area_id] = absint( $area_qty );
                            }

                            if ( ! in_array( $area_id , $results['area_outofstock'] ) && isset( $area_data_qty[$area_id] ) && absint( $area_data_qty[$area_id] ) && absint( $results['area_booked'][$area_id] ) >= absint( $area_data_qty[$area_id] ) ) {
                                $results['area_outofstock'][] = $area_id;
                            }
                        }
                    }
                }
            }

            return $results;
        }

        public function mb_get_area_qty( $room_id = null ) {
            if ( ! $room_id ) return [];

            $area_qty   = [];
            $areas      = get_post_meta( $room_id, MB_PLUGIN_PREFIX_ROOM.'areas', true );

            if ( mb_array_exists( $areas ) ) {
                foreach ( $areas as $area_item ) {
                    $area_qty[trim($area_item['id'])] = absint( $area_item['qty'] );
                }
            }

            return $area_qty;
        }

        public function validate_before_booking( $data ) {
            $showtime_id    = isset( $data['showtime_id'] ) ? sanitize_text_field( $data['showtime_id'] ) : '';
            $room_id        = isset( $data['room_id'] ) ? sanitize_text_field( $data['room_id'] ) : '';
            $movie_id       = MB_Movie()->get_id_by_showtime( $showtime_id );
            $cart           = isset( $data['cart'] ) ? mb_sanitize_cart( $data['cart'] ) : [];
            $discount_code  = isset( $data['discountCode'] ) ? sanitize_text_field( $data['discountCode'] ) : '';

            // Check seat and discount
            $validate = MB_Room()->check_seat_exist( $movie_id, $showtime_id, $room_id, $cart, $discount_code );

            return $validate;
        }

        public function check_available_tickets( $data ) {
            $showtime_id        = isset( $data['showtime_id'] ) ? sanitize_text_field( $data['showtime_id'] ) : '';
            $room_id            = isset( $data['room_id'] ) ? sanitize_text_field( $data['room_id'] ) : '';
            $movie_id           = MB_Movie()->get_id_by_showtime( $showtime_id );
            $cart               = isset( $data['cart'] ) ? mb_sanitize_cart( $data['cart'] ) : [];
            $data_booked        = $this->get_data_booked( $movie_id, $showtime_id, $room_id );
            $seat_booked        = $data_booked['seat_booked'];
            $area_booked        = $data_booked['area_booked'];
            $area_outofstock    = $data_booked['area_outofstock'];
            $area_qty           = $this->mb_get_area_qty( $room_id );
            $cart_needs         = [];

            if ( mb_array_exists( $cart ) ) {
                foreach ( $cart as $cart_item ) {
                    if ( in_array( $cart_item['id'], $seat_booked ) ) {
                        MB()->msg_session->set( 'mb_message', sprintf( esc_html__( 'Seat %s has been booked!', 'moviebooking' ), $cart_item['id'] ) );
                        MB()->msg_session->set( 'mb_reload', '' );

                        return false;
                    } elseif ( in_array( $cart_item['id'], $area_outofstock ) ) {
                        MB()->msg_session->set( 'mb_message', sprintf( esc_html__( '%s out of stock!', 'moviebooking' ), $cart_item['id'] ) );
                        MB()->msg_session->set( 'mb_reload', '' );

                        return false;
                    } else {
                        if ( isset( $cart_item['qty'] ) && absint( $cart_item['qty'] ) ) {
                            if ( array_key_exists( $cart_item['id'], $cart_needs ) ) {
                                $cart_needs[$cart_item['id']] += absint( $cart_item['qty'] );
                            } else {
                                $cart_needs[$cart_item['id']] = absint( $cart_item['qty'] );
                            }

                            // Check available
                            $total_qty  = isset( $area_qty[$cart_item['id']] ) ? absint( $area_qty[$cart_item['id']] ) : 0;
                            $booked_qty = isset( $area_booked[$cart_item['id']] ) ? absint( $area_booked[$cart_item['id']] ) : 0;
                            $available_qty = $total_qty - $booked_qty;

                            if ( $available_qty < absint( $cart_item['qty'] ) ) {
                                if ( $available_qty > 0 ) {
                                    MB()->msg_session->set( 'mb_message', sprintf( esc_html__( 'Maximum %s: %s', 'moviebooking' ), $cart_item['id'], $available_qty ) );
                                } else {
                                    MB()->msg_session->set( 'mb_message', sprintf( esc_html__( '%s out of stock!', 'moviebooking' ), $cart_item['id'] ) );
                                }

                                return false;
                            }                            
                        } else {
                            $cart_needs[$cart_item['id']] = 1;
                        }
                    }
                }
            }

            // Check Holding Ticket
            $holding_ticket = MB()->options->checkout->get('enable_holding_ticket', 'yes');

            if ( 'yes' === $holding_ticket ) {
                $holding_ticket_ids = MB_Booking()->mb_get_holding_ticket_ids( $data );

                if ( mb_array_exists( $holding_ticket_ids ) ) {
                    $time_countdown_checkout = absint( MB()->options->checkout->get('max_time_complete_payment', 600) );

                    foreach ( $holding_ticket_ids as $ht_id ) {
                        $seat = get_post_meta( $ht_id, $this->_prefix.'seat', true );

                        if ( ! $seat || ! array_key_exists( $seat, $cart_needs ) ) continue;

                        $qty            = get_post_meta( $ht_id, $this->_prefix.'qty', true );
                        $time_checkout  = get_post_meta( $ht_id, $this->_prefix.'current_time', true );
                        $past_time      = absint( current_time( 'timestamp' ) ) - absint( $time_checkout );
                        
                        if ( $past_time < $time_countdown_checkout ) {
                            if ( absint( $qty ) ) {
                                $total_qty      = isset( $area_qty[$seat] ) ? absint( $area_qty[$seat] ) : 0;
                                $booked_qty     = isset( $area_booked[$seat] ) ? absint( $area_booked[$seat] ) : 0;
                                $available_qty  = $total_qty - $booked_qty - $qty;

                                if ( $available_qty < $cart_needs[$seat] ) {
                                    MB()->msg_session->set( 'mb_message', sprintf( esc_html__( '%s has been selected(pending payment)!', 'moviebooking' ), $seat ) );
                                    MB()->msg_session->set( 'mb_reload', sprintf( esc_html__( 'Click here to reload the page or the page will automatically reload after %s seconds.', 'moviebooking' ), '<span class="time">10</span>' ) );

                                    return false;
                                }
                            } else {
                                MB()->msg_session->set( 'mb_message', sprintf( esc_html__( '%s has been selected(pending payment)!', 'moviebooking' ), $seat ) );
                                MB()->msg_session->set( 'mb_reload', sprintf( esc_html__( 'Click here to reload the page or the page will automatically reload after %s seconds.', 'moviebooking' ), '<span class="time">10</span>' ) );

                                return false;
                            }
                        }
                    }
                }
            }

            return true;
        }

        public function mb_get_total_booking( $movie_id = null, $status = '', $from = false, $to = false, $city_id = null, $venue_id = null, $room_id = null ) {
            $args = array(
                'post_type'      => 'mb_booking',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'fields'         => 'ids',
                'meta_query'     => array(
                    'relation'   => 'AND',
                ),
            );

            // Movie
            if ( $movie_id ) {
                array_push( $args['meta_query'] , array(
                    'key'     => $this->_prefix.'movie_id',
                    'value'   => $movie_id,
                    'compare' => '=',
                ));
            }

            // Status
            if ( $status ) {
                array_push( $args['meta_query'] , array(
                    'key'     => $this->_prefix.'status',
                    'value'   => $status,
                    'compare' => '=',
                ));
            }

            if ( $from && $to ) {
                array_push( $args['meta_query'], array(
                    'key'     => $this->_prefix.'date',
                    'value'   => array( $from, $to ),
                    'type'    => 'numeric',
                    'compare' => 'BETWEEN',
                ));
            } elseif ( $from && ! $to ) {
                array_push( $args['meta_query'], array(
                    'key'     => $this->_prefix.'date',
                    'value'   => $from,
                    'type'    => 'numeric',
                    'compare' => '>=',
                ));
            } elseif ( ! $from && $to ) {
                array_push( $args['meta_query'], array(
                    'key'     => $this->_prefix.'date',
                    'value'   => $to,
                    'type'    => 'numeric',
                    'compare' => '<=',
                ));
            } else {
                // nothing
            }

            // City
            if ( $city_id ) {
                array_push( $args['meta_query'] , array(
                    'key'     => $this->_prefix.'city_id',
                    'value'   => $city_id,
                    'compare' => '=',
                ));
            }

            // Venue
            if ( $venue_id ) {
                array_push( $args['meta_query'] , array(
                    'key'     => $this->_prefix.'venue_id',
                    'value'   => $venue_id,
                    'compare' => '=',
                ));
            }

            // Room
            if ( $room_id ) {
                array_push( $args['meta_query'] , array(
                    'key'     => $this->_prefix.'room_id',
                    'value'   => $room_id,
                    'compare' => '=',
                ));
            }

            $booking_query  = apply_filters( 'mb_ft_get_total_booking_query', $args );
            $bookings       = get_posts( $booking_query );

            $result = array(
                'subtotal'      => 0,
                'discount'      => 0,
                'tax'           => 0,
                'ticket_fee'    => 0,
                'total'         => 0,
            );

            if ( ! empty( $bookings ) && is_array( $bookings ) ) {
                foreach ( $bookings as $booking_id ) {
                    $result['subtotal']     += floatval( get_post_meta( $booking_id, $this->_prefix.'subtotal', true ) );
                    $result['discount']     += floatval( get_post_meta( $booking_id, $this->_prefix.'discount', true ) );
                    $result['tax']          += floatval( get_post_meta( $booking_id, $this->_prefix.'tax', true ) );
                    $result['ticket_fee']   += floatval( get_post_meta( $booking_id, $this->_prefix.'ticket_fee', true ) );
                    $result['total']        += floatval( get_post_meta( $booking_id, $this->_prefix.'total', true ) );
                }
            }

            return $result;
        }
    }

    return new MB_Booking();
}