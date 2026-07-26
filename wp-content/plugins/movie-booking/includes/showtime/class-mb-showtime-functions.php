<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MB_Showtime' ) ) {
    class MB_Showtime {
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

        public function get_all_city() {

            $args = array( 
                'parent' => 0, 
                'orderby' => 'title', 
                'order' => 'DESC',
                'hide_empty' => false 
            );

            $cities = get_terms( 'movie_location', $args );

            return $cities;
        }

        public function get_all_showtime( $movie_id ) {
            if ( ! $movie_id ) return false;

            $prefix = MB_PLUGIN_PREFIX_SHOWTIME;

            $args = array(
                'post_type'      => 'showtime',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'fields'         => 'ids',
                'order'          => 'ASC',
                'orderby'        => 'meta_value_num',
                'meta_type'      => 'NUMERIC',
                'meta_key'       => $prefix.'date',
                'meta_query' => array(
                    'relation'      => 'AND',
                    array(
                        'key'     => $prefix.'movie_id',
                        'value'   => $movie_id,
                        'compare' => '=',
                    ),
                    array(
                        'key'     => $prefix.'date',
                        'value'   => current_time( 'timestamp' ),
                        'compare' => '>=',
                    ),
                ),
            );

            $showtime_query = apply_filters( 'mb_ft_get_all_showtime', $args );
            $showtimes      = get_posts( $showtime_query );

            return $showtimes;
        }

        public function get_any_showtime( $movie_id ) {
            if ( ! $movie_id ) return false;

            $prefix = MB_PLUGIN_PREFIX_SHOWTIME;

            $args = array(
                'post_type'      => 'showtime',
                'posts_per_page' => -1,
                'post_status'    => 'any',
                'fields'         => 'ids',
                'order'          => 'DESC',
                'orderby'        => 'date',
                'meta_query' => array(
                    'relation'      => 'AND',
                    array(
                        'key'     => $prefix.'movie_id',
                        'value'   => $movie_id,
                        'compare' => '=',
                    ),
                    array(
                        'key'     => $prefix.'date',
                        'value'   => current_time( 'timestamp' ),
                        'compare' => '>=',
                    ),
                ),
            );

            $showtime_query = apply_filters( 'mb_ft_get_all_showtime', $args );
            $showtimes      = get_posts( $showtime_query );

            return $showtimes;
        }

        public function get_showtime_by_venue_and_date( $venue_id, $date_min, $date_max ) {
            if ( ! $venue_id && ! $date_min && ! $date_max  ) return false;

            $prefix = MB_PLUGIN_PREFIX_SHOWTIME;

            $args = array(
                'post_type'      => 'showtime',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'fields'         => 'ids',
                'order'          => 'DESC',
                'orderby'        => 'date',
            );

            if ( $venue_id != '') {
                $args['meta_query']  = array(
                    'relation'  => 'AND',
                    array(
                        'key'     => $prefix.'date',
                        'value'   => array($date_min, $date_max),
                        'type'    => 'numeric',
                        'compare' => 'BETWEEN',
                    ),
                    array(
                        'key'     => $prefix.'venue_id',
                        'value'   => $venue_id,
                        'type'    => 'numeric',
                        'compare' => '=',
                    ),
                );
            } else {
                $args['meta_query']  = array(
                    array(
                        'key'     => $prefix.'date',
                        'value'   => array($date_min, $date_max),
                        'type'    => 'numeric',
                        'compare' => 'BETWEEN',
                    )
                );
            }  

            $showtime_query = apply_filters( 'mb_ft_get_showtime_by_venue_and_date', $args );
            $showtimes      = get_posts( $showtime_query );

            return $showtimes;
        }

        public function get_date_by_showtime( $showtimes = array() ) {
            $data_showtime = array();

            if ( ! empty( $showtimes ) && is_array( $showtimes ) ) {
                foreach( $showtimes as $showtime_id ) {
                    $date = get_post_meta( $showtime_id, 'ova_mb_showtime_date', true );
                    $date_strtt = '';

                    if ( $date ) {
                        $date_strtt = strtotime( date( MBC()->mb_get_date_format(), $date ) );
                    }

                    $args = array(
                        'date'          => $date,
                        'showtime_id'   => $showtime_id,
                        'movie_id'      => get_post_meta( $showtime_id, 'ova_mb_showtime_movie_id', true ),
                        'room_ids'      => get_post_meta( $showtime_id, 'ova_mb_showtime_room_ids', true ),
                        'city_id'       => get_post_meta( $showtime_id, 'ova_mb_showtime_city_id', true ),
                        'venue_id'      => get_post_meta( $showtime_id, 'ova_mb_showtime_venue_id', true ),
                    );

                    if ( $date_strtt ) {
                        if ( isset( $data_showtime[$date_strtt] ) && is_array( $data_showtime[$date_strtt] ) ) {
                            array_push( $data_showtime[$date_strtt] , $args );
                        } else {
                            $data_showtime[$date_strtt] = array();
                            array_push( $data_showtime[$date_strtt] , $args );
                        }
                    }
                }
            }

            ksort( $data_showtime );

            return $data_showtime;
        }

        public function get_city_by_showtime( $date_id, $showtimes = array() ) {
            $data_city = array();

            $data_showtime = isset( $showtimes[$date_id] ) && $showtimes[$date_id] ? $showtimes[$date_id] : array();

            if ( ! empty( $data_showtime ) && is_array( $data_showtime ) ) {
                foreach( $data_showtime as $k => $items ) {
                    $city_id = isset( $items['city_id'] ) && $items['city_id'] ? $items['city_id'] : '';

                    if ( $city_id ) {
                        if ( isset( $data_city[$city_id] ) && is_array( $data_city[$city_id] ) ) {
                            array_push( $data_city[$city_id] , array(
                                'showtime_id'  => $items['showtime_id'],
                                'movie_id'      => $items['movie_id'],
                                'date'          => $items['date'],
                                'room_ids'      => $items['room_ids'],
                                'venue_id'      => $items['venue_id'],
                            ));
                        } else {
                            $data_city[$city_id] = array();
                            array_push( $data_city[$city_id] , array(
                                'showtime_id'   => $items['showtime_id'],
                                'movie_id'      => $items['movie_id'],
                                'date'          => $items['date'],
                                'room_ids'      => $items['room_ids'],
                                'venue_id'      => $items['venue_id'],
                            ));
                        }
                    }
                }
            }

            ksort( $data_city );

            return $data_city;
        }

        public function get_room_by_city( $city_id, $data_city ) {
            $data_room = array();

            if ( ! empty( $data_city ) && is_array( $data_city ) ) {
                foreach( $data_city as $item_city ) {
                    $room_ids = isset( $item_city['room_ids'] ) && $item_city['room_ids'] ? $item_city['room_ids'] : array();

                    if ( ! empty( $room_ids ) && is_array( $room_ids ) ) {
                        foreach( $room_ids as $room_id ) {
                            $room_arr = array(
                                'city_id'       => $city_id,
                                'showtime_id'   => $item_city['showtime_id'],
                                'movie_id'      => $item_city['movie_id'],
                                'date'          => $item_city['date'],
                                'venue_id'      => $item_city['venue_id'],
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
            }

            return $data_room;
        }

        public function get_venue_by_room( $room_id, $data_room ) {
            $data_venue = array();

            if ( ! empty( $data_room ) && is_array( $data_room ) ) {
                foreach( $data_room as $item_room ) {
                    $venue_id = isset( $item_room['venue_id'] ) && $item_room['venue_id'] ? $item_room['venue_id'] : '';

                    if ( $venue_id ) {
                        $venue_arr = array(
                            'city_id'       => $item_room['city_id'],
                            'showtime_id'   => $item_room['showtime_id'],
                            'movie_id'      => $item_room['movie_id'],
                            'room_id'       => $room_id,
                            'venue_id'      => $item_room['venue_id'],
                            'date'          => $item_room['date'],
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

    }
}