<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MB_Booking_Metabox' ) ) {
    class MB_Booking_Metabox extends MB_Abstract_Metabox {

        public function __construct() {
            $this->_id = 'metabox_booking';
            $this->_title = esc_html__( 'Booking Detail','moviebooking' );
            $this->_screen = array( 'mb_booking' );
            $this->_output = MB_PLUGIN_INC . 'admin/views/metaboxes/metabox-booking.php';
            $this->_prefix = MB_PLUGIN_PREFIX_BOOKING;

            parent::__construct();

            add_action( 'mb_ac_proccess_update_meta', array( $this, 'update' ), 10, 2 );
        }

        public function update( $post_id, $post_data ) {
            if ( empty( $post_data ) ) exit();

            if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
                return;
            }

            if ( !isset( $post_data ) )
                return;

            if ( !isset( $post_data['ova_metaboxes'] ) || !wp_verify_nonce( $post_data['ova_metaboxes'], 'ova_metaboxes' ) )
                return;

            if ( isset( $post_data['post_type'] ) && $post_data['post_type'] === 'mb_booking' ) {
                $cart = [];
                $seats_price = $areas_price = [];
                $extra_service = [];

                if ( isset( $post_data['mb_booking_seats_price'] ) && $post_data['mb_booking_seats_price'] ) {
                    $seats_price = $post_data['mb_booking_seats_price'];
                }

                if ( isset( $post_data['mb_booking_areas_price'] ) && $post_data['mb_booking_areas_price'] ) {
                    $areas_price = $post_data['mb_booking_areas_price'];
                }

                if ( ! isset( $post_data['ova_mb_booking_seats'] ) ) {
                    update_post_meta( $post_id, 'ova_mb_booking_seat', [] );
                }

                if ( ! isset( $post_data['ova_mb_booking_areas'] ) ) {
                    update_post_meta( $post_id, 'ova_mb_booking_area', [] );
                }

                if ( isset( $post_data['ova_mb_booking_extra_service'] ) && $post_data['ova_mb_booking_extra_service'] ) {
                    $extra_service = $post_data['ova_mb_booking_extra_service'];
                }



                foreach ( $post_data as $name => $value ) {
                    if ( strpos( $name, $this->_prefix ) !== 0 ) continue;
                    
                    if ( $name === 'ova_mb_booking_seats' ) {
                        $seats = array();
                        // Seat
                        if ( mb_array_exists( $value ) ) {
                            foreach ( $value as $seat ) {
                                if ( isset( $seat['id'] ) && $seat['id'] ) {
                                    array_push( $seats , $seat['id'] );

                                    $cart[] = [
                                        'id'    => $seat['id'],
                                        'price' => isset( $seats_price[$seat['id']] ) ? $seats_price[$seat['id']] : 0,
                                    ];
                                }
                            }
                        }
                        
                        update_post_meta( $post_id, 'ova_mb_booking_seat', $seats );
                    } elseif ( $name === 'ova_mb_booking_areas' ) {
                        $areas = [];

                        if ( mb_array_exists( $value ) ) {
                            $area_qty = isset( $post_data['ova_mb_booking_area_qty'] ) && $post_data['ova_mb_booking_area_qty'] ? $post_data['ova_mb_booking_area_qty'] : [];
                            $person_type_booking = isset( $post_data['ova_mb_booking_person_type'] ) ? $post_data['ova_mb_booking_person_type'] : array();
                            // Area
                            foreach ( $value as $area ) {
                                if ( isset( $area['id'] ) && $area['id'] ) {
                                    $qty = isset( $area_qty[$area['id']] ) && $area_qty[$area['id']] ? $area_qty[$area['id']] : 1;
                                    $areas[$area['id']] = $qty;

                                    $data = [
                                        'id'    => $area['id'],
                                        'price' => isset( $areas_price[$area['id']] ) ? $areas_price[$area['id']] : 0,
                                        'qty'   => $qty
                                    ];
                                    // Person Type
                                    if ( array_key_exists( $area['id'], $person_type_booking ) ) {
                                        $data['data_person'] = $person_type_booking[$area['id']];
                                    }
                                    // Extra Service
                                    if ( array_key_exists( $area['id'], $extra_service ) ) {

                                        if ( isset( $data['data_person'] ) && $data['data_person'] ) {

                                            foreach ( $data['data_person'] as $key => $item ) {
                                                $extra_service_data = array();
                                                if ( absint( $item['qty'] ) > 0 ) {
                                                    for ($i=0; $i < absint( $item['qty'] ); $i++) {
                                                        if ( ! empty( $extra_service[$area['id']][0] ) ) {
                                                            $extra_service_data[] = $extra_service[$area['id']][0];
                                                            array_splice($extra_service[$area['id']], 0, 1);
                                                        }
                                                    }
                                                    
                                                }
                                                // save extra service
                                                $data['data_person'][$key]['extra_service'] = $extra_service_data;
                                            }

                                        } else {
                                            $data['extra_service'] = $extra_service[$area['id']];
                                        }
                                    }

                                    $cart[] = $data;
                                }
                            }
                        }

                        update_post_meta( $post_id, 'ova_mb_booking_area', $areas );
                        
                    } elseif ( $name === 'ova_mb_booking_area_qty' ) {
                        continue;
                    } elseif ( $name === 'ova_mb_booking_customer_email' ) {
                        update_post_meta( $post_id, $name, $value );

                        $user = get_user_by( 'email', $value );
                        
                        if ( $user ) {
                            update_post_meta( $post_id, 'ova_mb_booking_customer', $user->ID );
                        }
                    } elseif ( $name === 'ova_mb_booking_address' ) {
                        $address    = get_post_meta( $post_id, 'ova_mb_booking_customer_address', true );
                        $first_name = isset( $post_data['customer_first_name'] ) ? trim( $post_data['customer_first_name'] ) : '';
                        $last_name  = isset( $post_data['customer_last_name'] ) ? trim( $post_data['customer_last_name'] ) : '';

                        $customer_name = '';

                        if ( $first_name && $last_name ) {
                            $customer_name = $first_name . ' ' . $last_name;
                        } elseif ( $first_name && ! $last_name ) {
                            $customer_name = $first_name;
                        } elseif ( ! $first_name && $last_name ) {
                            $customer_name = $last_name;
                        } else {
                            $customer_name = '';
                        }

                        if ( ! empty( $address ) && is_array( $address ) ) {
                            $address['first_name']  = $first_name;
                            $address['last_name']   = $last_name;
                            $address['address_1']   = $value;
                        } else {
                            $address = array(
                                'first_name'    => $first_name,
                                'last_name'     => $last_name,
                                'company'       => '',
                                'address_1'     => $value,
                                'address_2'     => '',
                                'city'          => '',
                                'state'         => '',
                                'postcode'      => '',
                                'country'       => '',
                                'email'         => isset( $post_data['ova_mb_booking_customer_email'] ) ? $post_data['ova_mb_booking_customer_email'] : '',
                                'phone'         => isset( $post_data['ova_mb_booking_customer_phone'] ) ? $post_data['ova_mb_booking_customer_phone'] : '',
                            );
                        }

                        update_post_meta( $post_id, 'ova_mb_booking_customer_name', $customer_name );
                        update_post_meta( $post_id, 'ova_mb_booking_customer_address', $address );
                    } elseif ( $name === 'ova_mb_booking_showtime_id' ) {
                        if ( absint( $value ) ) {
                            $city_id    = get_post_meta( $value, MB_PLUGIN_PREFIX_SHOWTIME.'city_id', true );
                            $venue_id   = get_post_meta( $value, MB_PLUGIN_PREFIX_SHOWTIME.'venue_id', true );

                            update_post_meta( $post_id, MB_PLUGIN_PREFIX_BOOKING.'showtime_id', $value );
                            update_post_meta( $post_id, MB_PLUGIN_PREFIX_BOOKING.'city_id', $city_id );
                            update_post_meta( $post_id, MB_PLUGIN_PREFIX_BOOKING.'venue_id', $venue_id );
                        }
                    } else {
                        update_post_meta( $post_id, $name, $value );
                    }
                }

                // Update Cart
                update_post_meta( $post_id, 'ova_mb_booking_cart', $cart );

                // Update Coupon
                $action = 'update';
                $has_updated = get_post_meta( $post_id, 'ova_mb_booking_coupon_updated', true );

                if ( isset( $post_data['post-status'] ) && $post_data['post-status'] === 'auto-draft' ) {
                    $action = 'create';
                }

                if ( $action === 'create' && isset( $post_data['ova_mb_booking_discount_code'] ) && $post_data['ova_mb_booking_discount_code'] && ! $has_updated ) {
                    MB_Movie()->update_coupon( $post_id );
                    update_post_meta( $post_id, 'ova_mb_booking_coupon_updated', 1 );
                }
                // End

                // Cancel Booking
                $enable_cancel_email = MB()->options->mail->get( 'enable_cancel_email', 'yes' );

                if ( $action === 'update' && isset( $post_data['ova_mb_booking_status'] ) && $post_data['ova_mb_booking_status'] === 'Canceled' && $enable_cancel_email === 'yes' ) {

                    $send_mail = MB_Email()->mb_sendmail_cancel_booking( $post_id );
                }
                // End

                if ( ! get_the_title( $post_id ) ) {
                    $movie_id = get_post_meta( $post_id, 'ova_mb_booking_movie_id', true );

                    wp_update_post(array(
                        'ID'            => $post_id,
                        'post_title'    => sprintf( esc_html__( '#%s - %s', 'moviebooking' ), $post_id, get_the_title( $movie_id ) ),
                    ));
                }
            }
        }
    }
}