<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MB_Room' ) ) {
    class MB_Room {
        /**
         * instance
         * @var null
         */
        protected static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        public function get_all_room() {
            $args = array(
                'post_type'      => 'room',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'fields'         => 'ids',
                'order'          => 'DESC',
                'orderby'        => 'date',
            );

            $room_query = apply_filters( 'mb_ft_get_all_room', $args );
            $rooms      = get_posts( $room_query );

            return $rooms;
        }

        public function get_room_with_taxonomy() {
            $result = array();
            $rooms  = $this->get_all_room();
            $prefix = MB_PLUGIN_PREFIX_ROOM;

            if ( ! empty( $rooms ) && is_array( $rooms ) ) {
                foreach( $rooms as $room_id ) {
                    $type_id    = get_post_meta( $room_id, $prefix.'type_id', true );
                    $type_name  = MBC()->mb_get_taxonomy_name( $type_id, 'room_type' );

                    if ( $type_name ) {
                        if ( isset( $result[$type_id] ) && is_array( $result[$type_id] ) ) {
                            array_push( $result[$type_id]['rooms'] , $room_id );
                        } else {
                            $result[$type_id] = array(
                                'name'  => $type_name,
                                'rooms' => array( $room_id ),
                            );
                        }
                    } else {
                        if ( isset( $result['no_type'] ) && is_array( $result['no_type'] ) ) {
                            array_push( $result['no_type']['rooms'] , $room_id );
                        } else {
                            $result['no_type'] = array(
                                'name'  => esc_html__( 'No Type', 'moviebooking' ),
                                'rooms' => array( $room_id ),
                            );
                        }
                    }
                }
            }

            return apply_filters( 'mb_ft_get_room_with_taxonomy', $result );
        }

        public function get_room_type_by_city( $city_id, $data_city ) {
            $prefix     = MB_PLUGIN_PREFIX_ROOM;
            $room_type  = array();

            if ( ! empty( $data_city ) && is_array( $data_city ) ) {
                foreach( $data_city as $item_city ) {
                    $room_ids = isset( $item_city['room_ids'] ) && $item_city['room_ids'] ? $item_city['room_ids'] : array();

                    if ( ! empty( $room_ids ) && is_array( $room_ids ) ) {
                        foreach( $room_ids as $room_id ) {
                            $type_id = get_post_meta( $room_id, $prefix.'type_id', true );

                            if ( $type_id ) {
                                $room_type_arr = array(
                                    'city_id'       => $city_id,
                                    'room_id'       => $room_id,
                                    'showtime_id'   => $item_city['showtime_id'],
                                    'movie_id'      => $item_city['movie_id'],
                                    'date'          => $item_city['date'],
                                    'venue_id'      => $item_city['venue_id'],
                                );

                                if ( isset( $room_type[$type_id] ) && is_array( $room_type[$type_id] ) ) {
                                    array_push( $room_type[$type_id], $room_type_arr );
                                } else {
                                    $room_type[$type_id] = array();
                                    array_push( $room_type[$type_id], $room_type_arr );
                                }
                            }
                        }
                    }
                }
            }

            return $room_type;
        }

        public function get_venue_by_room_type( $type_id, $data_room_type ) {
            $data_venue = array();

            if ( ! empty( $data_room_type ) && is_array( $data_room_type ) ) {
                foreach( $data_room_type as $item_room_type ) {
                    $venue_id = isset( $item_room_type['venue_id'] ) && $item_room_type['venue_id'] ? $item_room_type['venue_id'] : '';

                    if ( $venue_id ) {
                        $venue_arr = array(
                            'city_id'       => $item_room_type['city_id'],
                            'showtime_id'   => $item_room_type['showtime_id'],
                            'movie_id'      => $item_room_type['movie_id'],
                            'room_id'       => $item_room_type['room_id'],
                            'date'          => $item_room_type['date'],
                        );

                        if ( isset( $data_venue[$venue_id] ) && is_array( $data_venue[$venue_id] ) ) {
                            array_push( $data_venue[$venue_id], $venue_arr );
                        } else {
                            $data_venue[$venue_id] = array();
                            array_push( $data_venue[$venue_id], $venue_arr );
                        }
                    }
                }
            }

            return $data_venue;
        }

        public function get_rooms_by_venue( $data_venue ) {
            $data_room = array();

            if ( ! empty( $data_venue ) && is_array( $data_venue ) ) {
                foreach( $data_venue as $item_venue ) {
                    $room_id = isset( $item_venue['room_id'] ) && $item_venue['room_id'] ? $item_venue['room_id'] : '';

                    if ( $room_id ) {
                        $room_arr = array(
                            'showtime_id'   => $item_venue['showtime_id'],
                            'movie_id'      => $item_venue['movie_id'],
                            'date'          => $item_venue['date'],
                        );

                        if ( isset( $data_room[$room_id] ) && is_array( $data_room[$room_id] ) ) {
                            array_push( $data_room[$room_id], $room_arr );
                        } else {
                            $data_room[$room_id] = array();
                            array_push( $data_room[$room_id], $room_arr );
                        }
                    }
                }
            }

            return $data_room;
        }

        public function check_seat_exist( $movie_id = null, $showtime_id = null, $room_id = null, $cart = array(), $discount_code = '' ) {
            if ( ! $movie_id || ! $showtime_id || ! $room_id || ! $cart ) return false;

            $seat_ids   = $area_ids = array();
            $seats      = get_post_meta( $room_id, MB_PLUGIN_PREFIX_ROOM.'seats', true );
            $areas      = get_post_meta( $room_id, MB_PLUGIN_PREFIX_ROOM.'areas', true );
            $date       = get_post_meta( $showtime_id, MB_PLUGIN_PREFIX_SHOWTIME.'date', true );

            // Get Seat IDs
            if ( mb_array_exists( $seats ) ) {
                foreach( $seats as $items ) {
                    if ( strpos( $items['id'], ',' ) ) {
                        foreach ( explode( ',', $items['id'] ) as $seat_id ) {
                            $seat_ids[] = trim($seat_id);
                        }
                    } else {
                        $seat_ids[] = $items['id'];
                    }
                }
            }

            // Get Area IDs
            if ( mb_array_exists( $areas ) ) {
                foreach( $areas as $items ) {
                    if ( strpos( $items['id'], ',' ) ) {
                        foreach ( explode( ',', $items['id'] ) as $area_id ) {
                            $area_ids[] = trim($area_id);
                        }
                    } else {
                        $area_ids[] = $items['id'];
                    }
                }
            }

            // Check Cart
            if ( mb_array_exists( $cart ) ) {
                $data_booked        = MB_Booking()->get_data_booked( $movie_id, $showtime_id, $room_id );
                $seat_booked        = $data_booked['seat_booked'];
                $area_outofstock    = $data_booked['area_outofstock'];

                foreach ( $cart as $value ) {
                    // Check Date
                    if ( absint( $date ) < current_time('timestamp') ) {
                        MB()->msg_session->set( 'mb_message', esc_html__( 'Ticket closed!', 'moviebooking' ) );

                        return false;
                    }

                    // Check exists seat id and area id
                    if ( ! in_array( $value['id'] , $seat_ids ) && ! in_array( $value['id'] , $area_ids ) ) {
                        MB()->msg_session->set( 'mb_message', sprintf( esc_html__( '%s doesn\'t exist!', 'moviebooking' ), $value['id'] ) );

                        return false;
                    }
                }
            }

            // Check Discount
            if ( $discount_code ) {
                $data_discount = MB_Cart()->check_code_discount( $movie_id, $discount_code );

                if ( empty( $data_discount ) ) {
                    MB()->msg_session->set( 'mb_message', sprintf( esc_html__( 'Discount %s doesn\'t exist!', 'moviebooking' ), $discount_code ) );

                    return false;
                }
            }

            return true;
        }

        public function get_data_seat( $room_id = null ) {
            if ( ! $room_id ) return false;

            $prefix     = MB_PLUGIN_PREFIX_ROOM;
            $data_seat  = array();
            $room_seat  = get_post_meta( $room_id, $prefix.'seats', true );

            if ( mb_array_exists( $room_seat ) ) {
                foreach( $room_seat as $items ) {
                    $seat_ids = explode( ',', $items['id'] );

                    if ( mb_array_exists( $seat_ids ) ) {
                        foreach( $seat_ids as $id ) {
                            if ( trim( $id ) ) {
                                $data_id = array(
                                    'id'    => trim( $id ),
                                    'price' => floatval( $items['price'] )
                                );

                                $data_seat[] = $data_id;
                            } 
                        }
                    }
                }
            }

            return $data_seat;
        }
    }
}