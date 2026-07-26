<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MB_Admin_Exporters' ) ) {
    class MB_Admin_Exporters {

        public function __construct() {
            add_action( 'admin_menu', array( $this, 'add_to_menus' ) );
            add_action( 'admin_head', array( $this, 'hide_from_menus' ) );
            add_action( 'admin_init', array( $this, 'mb_export_action' ) );
        }

        public function add_to_menus() {
            add_submenu_page(
                'edit.php?post_type=showtime',
                __( 'Showtimes Export', 'moviebooking' ),
                __( 'Showtimes Export', 'moviebooking' ),
                'export',
                'showtimes_exporter',
                array( $this, 'showtimes_exporter' ),
            );

            add_submenu_page(
                'edit.php?post_type=mb_ticket',
                __( 'Tickets Export', 'moviebooking' ),
                __( 'Tickets Export', 'moviebooking' ),
                'export',
                'tickets_exporter',
                array( $this, 'tickets_exporter' ),
            );
        }

        public function hide_from_menus() {
            global $submenu;

            if ( isset( $submenu['edit.php?post_type=showtime'] ) && is_array( $submenu['edit.php?post_type=showtime'] ) ) {
                foreach( $submenu['edit.php?post_type=showtime'] as $k => $menu ) {
                    if ( isset( $menu[2] ) && $menu[2] === 'showtimes_exporter' ) {
                        unset( $submenu['edit.php?post_type=showtime'][$k] );
                    }
                }
            }

            if ( isset( $submenu['edit.php?post_type=mb_ticket'] ) && is_array( $submenu['edit.php?post_type=mb_ticket'] ) ) {
                foreach( $submenu['edit.php?post_type=mb_ticket'] as $k => $menu ) {
                    if ( isset( $menu[2] ) && $menu[2] === 'tickets_exporter' ) {
                        unset( $submenu['edit.php?post_type=mb_ticket'][$k] );
                    }
                }
            }
        }

        public function showtimes_exporter() {
            include MB_PLUGIN_INC . 'admin/views/exporters/html-csv-showtimes.php';
        }

        public function tickets_exporter() {
            include MB_PLUGIN_INC . 'admin/views/exporters/html-csv-tickets.php';
        }

        public function mb_export_action() {
            $showtime_action = isset( $_POST['showtime_action'] ) && $_POST['showtime_action'] ? sanitize_text_field( $_POST['showtime_action'] ) : '';

            if ( $showtime_action === 'export' ) {
                $status     = isset( $_POST['showtime_status'] ) && $_POST['showtime_status'] ? $_POST['showtime_status'] : 'any';
                $from       = isset( $_POST['from'] ) && strtotime( $_POST['from'] ) ? strtotime( $_POST['from'] ) : '';
                $to         = isset( $_POST['to'] ) && strtotime( $_POST['to'] ) ? strtotime( $_POST['to'] ) : '';
                $movie_id   = isset( $_POST['movie_id'] ) ? absint( $_POST['movie_id'] ) : 0;
                $city_id    = isset( $_POST['city_id'] ) ? absint( $_POST['city_id'] ) : 0;
                $venue_id   = isset( $_POST['venue_id'] ) ? absint( $_POST['venue_id'] ) : 0;
                $room_id    = isset( $_POST['room_id'] ) ? absint( $_POST['room_id'] ) : 0;
                $order      = isset( $_POST['showtime_order'] ) && $_POST['showtime_order'] ? $_POST['showtime_order'] : 'ASC';
                $orderby    = isset( $_POST['showtime_orderby'] ) && $_POST['showtime_orderby'] ? $_POST['showtime_orderby'] : 'date';

                $prefix = MB_PLUGIN_PREFIX_SHOWTIME;

                $args = array(
                    'post_type'      => 'showtime',
                    'posts_per_page' => -1,
                    'post_status'    => $status,
                    'fields'         => 'ids',
                    'order'          => $order,
                    'meta_query'     => array(
                        'relation'   => 'AND',
                    ),
                );

                if ( $orderby === 'showtime_date' ) {
                    $args['orderby']    = 'meta_value_num';
                    $args['meta_type']  = 'NUMERIC';
                    $args['meta_key']   = $prefix.'date';
                } else {
                    $args['orderby'] = $orderby;
                }

                $showtime_query = apply_filters( 'mb_ft_export_showtimes_query', $args );

                // Movie
                if ( $movie_id ) {
                    array_push( $showtime_query['meta_query'] , array(
                        'key'     => $prefix.'movie_id',
                        'value'   => $movie_id,
                        'compare' => '=',
                    ));
                }

                if ( $from && $to ) {
                    if ( $to < $from ) {
                        $_POST['error'] = esc_html__( 'The "End" time must be greater than or equal to the "Start" time', 'moviebooking' );
                        add_action( 'admin_notices', array( $this, 'mb_show_admin_notice_error' ) );
                        return;
                    }

                    array_push( $showtime_query['meta_query'], array(
                        'key'     => $prefix.'date',
                        'value'   => array( $from, $to ),
                        'type'    => 'numeric',
                        'compare' => 'BETWEEN',
                    ));
                } elseif ( $from && ! $to ) {
                    array_push( $showtime_query['meta_query'], array(
                        'key'     => $prefix.'date',
                        'value'   => $from,
                        'type'    => 'numeric',
                        'compare' => '>=',
                    ));
                } elseif ( ! $from && $to ) {
                    array_push( $showtime_query['meta_query'], array(
                        'key'     => $prefix.'date',
                        'value'   => $to,
                        'type'    => 'numeric',
                        'compare' => '<=',
                    ));
                } else {
                    // nothing
                }

                // City & Venue
                if ( $city_id ) {
                    array_push( $showtime_query['meta_query'] , array(
                        'key'     => $prefix.'city_id',
                        'value'   => $city_id,
                        'compare' => '=',
                    ));
                }

                if ( $venue_id ) {
                    array_push( $showtime_query['meta_query'] , array(
                        'key'     => $prefix.'venue_id',
                        'value'   => $venue_id,
                        'compare' => '=',
                    ));
                }
                // End
                
                // Room
                if ( $room_id ) {
                    array_push( $showtime_query['meta_query'] , array(
                        'key'     => $prefix.'room_ids',
                        'value'   => $room_id,
                        'compare' => 'REGEXP',
                    ));
                }

                $showtimes = get_posts( $showtime_query );

                // Check fields
                $fields = isset( $_POST['check_fields'] ) ? $_POST['check_fields'] : array();

                $custom_fields = apply_filters( 'mb_ft_export_showtimes_fields', array() );

                $field_id           = in_array( 'id', $fields ) ? esc_html__( 'ID', 'moviebooking' ) : '';
                $field_title        = in_array( 'title', $fields ) ? esc_html__( 'Title', 'moviebooking' ) : '';
                $field_status       = in_array( 'status', $fields ) ? esc_html__( 'Status', 'moviebooking' ) : '';
                $field_movie_id     = in_array( 'movie_id', $fields ) ? esc_html__( 'Movie ID', 'moviebooking' ) : '';
                $field_movie_name   = in_array( 'movie_name', $fields ) ? esc_html__( 'Movie', 'moviebooking' ) : '';
                $field_date         = in_array( 'date', $fields ) ? esc_html__( 'Date', 'moviebooking' ) : '';
                $field_room_id      = in_array( 'room_id', $fields ) ? esc_html__( 'Room ID', 'moviebooking' ) : '';
                $field_room_name    = in_array( 'room_name', $fields ) ? esc_html__( 'Room', 'moviebooking' ) : '';
                $field_city_id      = in_array( 'city_id', $fields ) ? esc_html__( 'City ID', 'moviebooking' ) : '';
                $field_city_name    = in_array( 'city_name', $fields ) ? esc_html__( 'City', 'moviebooking' ) : '';
                $field_venue_id     = in_array( 'venue_id', $fields ) ? esc_html__( 'Venue ID', 'moviebooking' ) : '';
                $field_venue_name   = in_array( 'venue_name', $fields ) ? esc_html__( 'Venue', 'moviebooking' ) : '';
                $field_address      = in_array( 'address', $fields ) ? esc_html__( 'Address', 'moviebooking' ) : '';

                $csv_row = '';

                $csv_row .= $field_id ? $field_id."\t" : '';
                $csv_row .= $field_title ? $field_title."\t" : '';
                $csv_row .= $field_status ? $field_status."\t" : '';
                $csv_row .= $field_movie_id ? $field_movie_id."\t" : '';
                $csv_row .= $field_movie_name ? $field_movie_name."\t" : '';
                $csv_row .= $field_date ? $field_date."\t" : '';
                $csv_row .= $field_room_id ? $field_room_id."\t" : '';
                $csv_row .= $field_room_name ? $field_room_name."\t" : '';
                $csv_row .= $field_city_id ? $field_city_id."\t" : '';
                $csv_row .= $field_city_name ? $field_city_name."\t" : '';
                $csv_row .= $field_venue_id ? $field_venue_id."\t" : '';
                $csv_row .= $field_venue_name ? $field_venue_name."\t" : '';
                $csv_row .= $field_address ? $field_address."\t" : '';

                if ( ! empty( $custom_fields ) && is_array( $custom_fields ) ) {
                    foreach ( $custom_fields as $items ) {
                        if ( isset( $items['string'] ) && $items['string'] ) {
                            $csv_row .= $items['string']."\t";
                        }
                    }
                }

                $csv_row .= "\r\n";

                /* Write Data */
                if ( $showtimes ) {
                    foreach ( $showtimes as $showtime_id ) {
                        // ID
                        if ( $field_id ) {
                            $csv_row .= $showtime_id."\t";
                        }

                        // Title
                        if ( $field_title ) {
                            $csv_row .= html_entity_decode( get_the_title( $showtime_id ) )."\t";
                        }

                        // Status
                        if ( $field_status ) {
                            $csv_row .= get_post_status( $showtime_id )."\t";
                        }

                        // Movie ID
                        if ( $field_movie_id ) {
                            $csv_row .= get_post_meta( $showtime_id, $prefix.'movie_id', true )."\t";
                        }

                        // Movie Name
                        if ( $field_movie_name ) {
                            $movie_id = get_post_meta( $showtime_id, $prefix.'movie_id', true );
                            $csv_row .= html_entity_decode( get_the_title( $movie_id ) )."\t";
                        }

                        // Date
                        if ( $field_date ) {
                            $date_format    = MBC()->mb_get_date_time_format();
                            $date           = get_post_meta( $showtime_id, $prefix.'date', true );

                            if ( absint( $date ) ) {
                                $csv_row .= date_i18n( $date_format, $date )."\t";
                            } else {
                                $csv_row .= "\t";
                            }
                        }

                        // Room ID
                        if ( $field_room_id ) {
                            $room_ids = get_post_meta( $showtime_id, $prefix.'room_ids', true );

                            if ( ! empty( $room_ids ) && is_array( $room_ids ) ) {
                                $csv_row .= implode( '|', $room_ids )."\t";
                            } else {
                                $csv_row .= "\t";
                            }
                        }

                        // Room Name
                        if ( $field_room_name ) {
                            $room_ids = get_post_meta( $showtime_id, $prefix.'room_ids', true );

                            if ( ! empty( $room_ids ) && is_array( $room_ids ) ) {
                                $room_name = array();

                                foreach ( $room_ids as $room_id ) {
                                    array_push( $room_name , html_entity_decode( get_the_title( $room_id ) ) );
                                }

                                $csv_row .= implode( '|', $room_name )."\t";
                            } else {
                                $csv_row .= "\t";
                            }
                        }

                        // City ID
                        if ( $field_city_id ) {
                            $csv_row .= get_post_meta( $showtime_id, $prefix.'city_id', true )."\t";
                        }

                        // City Name
                        if ( $field_city_name ) {
                            $city_id    = get_post_meta( $showtime_id, $prefix.'city_id', true );
                            $city_name  = MBC()->mb_get_taxonomy_name( $city_id, 'movie_location' );
                            $csv_row    .= html_entity_decode( $city_name )."\t";
                        }

                        // Venue ID
                        if ( $field_venue_id ) {
                            $csv_row .= get_post_meta( $showtime_id, $prefix.'venue_id', true )."\t";
                        }

                        // Venue Name
                        if ( $field_venue_name ) {
                            $venue_id   = get_post_meta( $showtime_id, $prefix.'venue_id', true );
                            $venue_name = MBC()->mb_get_taxonomy_name( $venue_id, 'movie_location' );
                            $csv_row    .= html_entity_decode( $venue_name )."\t";
                        }

                        // Address
                        if ( $field_address ) {
                            $csv_row .= html_entity_decode( get_post_meta( $showtime_id, $prefix.'address', true ) )."\t";
                        }

                        if ( ! empty( $custom_fields ) && is_array( $custom_fields ) ) {
                            foreach ( $custom_fields as $items ) {
                                if ( isset( $items['key'] ) && $items['key'] ) {
                                    $csv_row .= html_entity_decode( get_post_meta( $showtime_id, $items['key'], true ) )."\t";
                                }
                            }
                        }

                        $csv_row .= "\r\n";
                    }
                }

                $csv = chr(255).chr(254).mb_convert_encoding( $csv_row, "UTF-16LE", "UTF-8" );

                header( "Content-type: application/x-msdownload" );
                header( "Content-disposition: csv; filename=Showtime_List_" . date("Y-m-d") .".csv; size=".strlen( $csv ) );

                echo $csv;
               
                exit();
            }

            $ticket_action = isset( $_POST['ticket_action'] ) && $_POST['ticket_action'] ? sanitize_text_field( $_POST['ticket_action'] ) : '';

            if ( $ticket_action === 'export' ) {
                $status     = isset( $_POST['ticket_status'] ) && $_POST['ticket_status'] ? $_POST['ticket_status'] : 'any';
                $from       = isset( $_POST['from'] ) && strtotime( $_POST['from'] ) ? strtotime( $_POST['from'] ) : '';
                $to         = isset( $_POST['to'] ) && strtotime( $_POST['to'] ) ? strtotime( $_POST['to'] ) : '';
                $movie_id   = isset( $_POST['movie_id'] ) ? absint( $_POST['movie_id'] ) : 0;
                $city_id    = isset( $_POST['city_id'] ) ? absint( $_POST['city_id'] ) : 0;
                $venue_id   = isset( $_POST['venue_id'] ) ? absint( $_POST['venue_id'] ) : 0;
                $room_id    = isset( $_POST['room_id'] ) ? absint( $_POST['room_id'] ) : 0;
                $order      = isset( $_POST['ticket_order'] ) && $_POST['ticket_order'] ? $_POST['ticket_order'] : 'ASC';
                $orderby    = isset( $_POST['ticket_orderby'] ) && $_POST['ticket_orderby'] ? $_POST['ticket_orderby'] : 'date';

                $prefix = MB_PLUGIN_PREFIX_TICKET;

                $args = array(
                    'post_type'      => 'mb_ticket',
                    'posts_per_page' => -1,
                    'post_status'    => $status,
                    'fields'         => 'ids',
                    'order'          => $order,
                    'meta_query'     => array(
                        'relation'   => 'AND',
                    ),
                );

                if ( $orderby === 'showtime_date' ) {
                    $args['orderby']    = 'meta_value_num';
                    $args['meta_type']  = 'NUMERIC';
                    $args['meta_key']   = $prefix.'date';
                } else {
                    $args['orderby'] = $orderby;
                }

                $tickets_query = apply_filters( 'mb_ft_export_tickets_query', $args );

                // Movie
                if ( $movie_id ) {
                    array_push( $tickets_query['meta_query'] , array(
                        'key'     => $prefix.'movie_id',
                        'value'   => $movie_id,
                        'compare' => '=',
                    ));
                }

                if ( $from && $to ) {
                    if ( $to < $from ) {
                        $_POST['error'] = esc_html__( 'The "End" time must be greater than or equal to the "Start" time', 'moviebooking' );
                        add_action( 'admin_notices', array( $this, 'mb_show_admin_notice_error' ) );
                        return;
                    }

                    array_push( $tickets_query['meta_query'], array(
                        'key'     => $prefix.'date',
                        'value'   => array( $from, $to ),
                        'type'    => 'numeric',
                        'compare' => 'BETWEEN',
                    ));
                } elseif ( $from && ! $to ) {
                    array_push( $tickets_query['meta_query'], array(
                        'key'     => $prefix.'date',
                        'value'   => $from,
                        'type'    => 'numeric',
                        'compare' => '>=',
                    ));
                } elseif ( ! $from && $to ) {
                    array_push( $tickets_query['meta_query'], array(
                        'key'     => $prefix.'date',
                        'value'   => $to,
                        'type'    => 'numeric',
                        'compare' => '<=',
                    ));
                } else {
                    // nothing
                }

                // City & Venue
                if ( $city_id ) {
                    array_push( $tickets_query['meta_query'] , array(
                        'key'     => $prefix.'city_id',
                        'value'   => $city_id,
                        'compare' => '=',
                    ));
                }

                if ( $venue_id ) {
                    array_push( $tickets_query['meta_query'] , array(
                        'key'     => $prefix.'venue_id',
                        'value'   => $venue_id,
                        'compare' => '=',
                    ));
                }
                // End
                
                // Room
                if ( $room_id ) {
                    array_push( $tickets_query['meta_query'] , array(
                        'key'     => $prefix.'room_id',
                        'value'   => $room_id,
                        'compare' => '=',
                    ));
                }

                $tickets = get_posts( $tickets_query );

                // Check fields
                $fields = isset( $_POST['check_fields'] ) ? $_POST['check_fields'] : array();

                $custom_fields = apply_filters( 'mb_ft_export_tickets_fields', array() );

                $field_id           = in_array( 'id', $fields ) ? esc_html__( 'Ticket Number', 'moviebooking' ) : '';
                $field_booking_id   = in_array( 'booking_id', $fields ) ? esc_html__( 'Booking ID', 'moviebooking' ) : '';
                $field_movie_id     = in_array( 'movie_id', $fields ) ? esc_html__( 'Movie ID', 'moviebooking' ) : '';
                $field_movie_name   = in_array( 'movie_name', $fields ) ? esc_html__( 'Movie', 'moviebooking' ) : '';
                $field_date         = in_array( 'date', $fields ) ? esc_html__( 'Date', 'moviebooking' ) : '';
                $field_seat         = in_array( 'seat', $fields ) ? esc_html__( 'Seat', 'moviebooking' ) : '';
                $field_code         = in_array( 'code', $fields ) ? esc_html__( 'QR code', 'moviebooking' ) : '';
                $field_room_id      = in_array( 'room_id', $fields ) ? esc_html__( 'Room ID', 'moviebooking' ) : '';
                $field_room_name    = in_array( 'room_name', $fields ) ? esc_html__( 'Room', 'moviebooking' ) : '';
                $field_city_id      = in_array( 'city_id', $fields ) ? esc_html__( 'City ID', 'moviebooking' ) : '';
                $field_city_name    = in_array( 'city_name', $fields ) ? esc_html__( 'City', 'moviebooking' ) : '';
                $field_venue_id     = in_array( 'venue_id', $fields ) ? esc_html__( 'Venue ID', 'moviebooking' ) : '';
                $field_venue_name   = in_array( 'venue_name', $fields ) ? esc_html__( 'Venue', 'moviebooking' ) : '';
                $field_address      = in_array( 'address', $fields ) ? esc_html__( 'Address', 'moviebooking' ) : '';
                $field_customer_name    = in_array( 'customer_name', $fields ) ? esc_html__( 'Customer Name', 'moviebooking' ) : '';
                $field_customer_email   =  in_array( 'customer_email', $fields ) ? esc_html__( 'Customer Email', 'moviebooking' ) : '';
                $field_customer_phone   =  in_array( 'customer_phone', $fields ) ? esc_html__( 'Customer Phone', 'moviebooking' ) : '';
                $field_customer_address =  in_array( 'customer_address', $fields ) ? esc_html__( 'Customer Address', 'moviebooking' ) : '';
                //JPM
                $field_ticket_status =  in_array( 'ticket_status', $fields ) ? esc_html__( 'Ticket Status', 'moviebooking' ) : '';

                $csv_row = '';

                $csv_row .= $field_id ? $field_id."\t" : '';
                $csv_row .= $field_booking_id ? $field_booking_id."\t" : '';
                $csv_row .= $field_movie_id ? $field_movie_id."\t" : '';
                $csv_row .= $field_movie_name ? $field_movie_name."\t" : '';
                $csv_row .= $field_date ? $field_date."\t" : '';
                $csv_row .= $field_seat ? $field_seat."\t" : '';
                $csv_row .= $field_code ? $field_code."\t" : '';
                $csv_row .= $field_room_id ? $field_room_id."\t" : '';
                $csv_row .= $field_room_name ? $field_room_name."\t" : '';
                $csv_row .= $field_city_id ? $field_city_id."\t" : '';
                $csv_row .= $field_city_name ? $field_city_name."\t" : '';
                $csv_row .= $field_venue_id ? $field_venue_id."\t" : '';
                $csv_row .= $field_venue_name ? $field_venue_name."\t" : '';
                $csv_row .= $field_address ? $field_address."\t" : '';
                $csv_row .= $field_customer_name ? $field_customer_name."\t" : '';
                $csv_row .= $field_customer_email ? $field_customer_email."\t" : '';
                $csv_row .= $field_customer_phone ? $field_customer_phone."\t" : '';
                $csv_row .= $field_customer_address ? $field_customer_address."\t" : '';
                //JPM
                $csv_row .= $field_ticket_status ? $field_ticket_status."\t" : '';

                if ( ! empty( $custom_fields ) && is_array( $custom_fields ) ) {
                    foreach ( $custom_fields as $items ) {
                        if ( isset( $items['string'] ) && $items['string'] ) {
                            $csv_row .= $items['string']."\t";
                        }
                    }
                }

                $csv_row .= "\r\n";

                /* Write Data */
                if ( $tickets ) {
                    foreach ( $tickets as $ticket_id ) {
                        // ID
                        if ( $field_id ) {
                            $csv_row .= $ticket_id."\t";
                        }

                        // Booking ID
                        if ( $field_booking_id ) {
                            $csv_row .= get_post_meta( $ticket_id, $prefix.'booking_id', true )."\t";
                        }

                        // Movie ID
                        if ( $field_movie_id ) {
                            $csv_row .= get_post_meta( $ticket_id, $prefix.'movie_id', true )."\t";
                        }

                        // Movie Name
                        if ( $field_movie_name ) {
                            $movie_id = get_post_meta( $ticket_id, $prefix.'movie_id', true );
                            $csv_row .= html_entity_decode( get_the_title( $movie_id ) )."\t";
                        }

                        // Date
                        if ( $field_date ) {
                            $date_format    = MBC()->mb_get_date_time_format();
                            $date           = get_post_meta( $ticket_id, $prefix.'date', true );

                            if ( absint( $date ) ) {
                                $csv_row .= date_i18n( $date_format, $date )."\t";
                            } else {
                                $csv_row .= "\t";
                            }
                        }

                        // Seat
                        if ( $field_seat ) {
                            $csv_row .= html_entity_decode( get_post_meta( $ticket_id, $prefix.'seat', true ) )."\t";
                        }

                        // QR code
                        if ( $field_code ) {
                            $csv_row .= get_post_meta( $ticket_id, $prefix.'qr_code', true )."\t";
                        }

                        // Room ID
                        if ( $field_room_id ) {
                            $csv_row .= get_post_meta( $ticket_id, $prefix.'room_id', true )."\t";
                        }

                        // Room Name
                        if ( $field_room_name ) {
                            $room_id = get_post_meta( $ticket_id, $prefix.'room_id', true );

                            if ( absint( $room_id ) ) {
                                $csv_row .= html_entity_decode( get_the_title( $room_id ) )."\t";
                            } else {
                                $csv_row .= "\t";
                            }
                        }

                        // City ID
                        if ( $field_city_id ) {
                            $csv_row .= get_post_meta( $ticket_id, $prefix.'city_id', true )."\t";
                        }

                        // City Name
                        if ( $field_city_name ) {
                            $city_id    = get_post_meta( $ticket_id, $prefix.'city_id', true );
                            $city_name  = MBC()->mb_get_taxonomy_name( $city_id, 'movie_location' );
                            $csv_row    .= html_entity_decode( $city_name )."\t";
                        }

                        // Venue ID
                        if ( $field_venue_id ) {
                            $csv_row .= get_post_meta( $ticket_id, $prefix.'venue_id', true )."\t";
                        }

                        // Venue Name
                        if ( $field_venue_name ) {
                            $venue_id   = get_post_meta( $ticket_id, $prefix.'venue_id', true );
                            $venue_name = MBC()->mb_get_taxonomy_name( $venue_id, 'movie_location' );
                            $csv_row    .= html_entity_decode( $venue_name )."\t";
                        }

                        // Address
                        if ( $field_address ) {
                            $csv_row .= html_entity_decode( get_post_meta( $ticket_id, $prefix.'address', true ) )."\t";
                        }

                        // Customer Name
                        if ( $field_customer_name ) {
                            $csv_row .= html_entity_decode( get_post_meta( $ticket_id, $prefix.'customer_name', true ) )."\t";
                        }

                        // Customer Email
                        if ( $field_customer_email ) {
                            $csv_row .= get_post_meta( $ticket_id, $prefix.'customer_email', true )."\t";
                        }

                        // Customer Phone
                        if ( $field_customer_phone ) {
                            $csv_row .= get_post_meta( $ticket_id, $prefix.'customer_phone', true )."\t";
                        }

                        // Customer Phone
                        if ( $field_customer_address ) {
                            $customer_address = get_post_meta( $ticket_id, $prefix.'customer_address', true );

                            if ( isset( $customer_address['address_1'] ) && $customer_address['address_1'] ) {
                                $csv_row .= html_entity_decode( $customer_address['address_1'] )."\t";
                            } else {
                                $csv_row .= "\t";
                            }
                        }

                        //JPM Ticket Status
                        if ( $field_ticket_status ) {
                            $csv_row .= get_post_meta( $ticket_id, $prefix.'ticket_status', true )."\t";
                        }

                        if ( ! empty( $custom_fields ) && is_array( $custom_fields ) ) {
                            foreach ( $custom_fields as $items ) {
                                if ( isset( $items['key'] ) && $items['key'] ) {
                                    $csv_row .= html_entity_decode( get_post_meta( $ticket_id, $items['key'], true ) )."\t";
                                }
                            }
                        }

                        $csv_row .= "\r\n";
                    }
                }

                $csv = chr(255).chr(254).mb_convert_encoding( $csv_row, "UTF-16LE", "UTF-8" );

                header( "Content-type: application/x-msdownload" );
                header( "Content-disposition: csv; filename=Ticket_List_" . date("Y-m-d") .".csv; size=".strlen( $csv ) );

                echo $csv;
               
                exit();
            }
        }

        public function mb_show_admin_notice_error() {
            if ( isset( $_POST['error'] ) && $_POST['error'] ) {
                ?>
                <div class="notice notice-error is-dismissible">
                    <p><?php esc_html_e( $_POST['error'] ); ?></p>
                </div>
                <?php
            }

            if ( isset( $_POST['success'] ) && $_POST['success'] ) {
                ?>
                <div class="notice notice-success is-dismissible">
                    <p><?php esc_html_e( $_POST['success'] ); ?></p>
                </div>
                <?php
            }
        }
    }

    new MB_Admin_Exporters();
}