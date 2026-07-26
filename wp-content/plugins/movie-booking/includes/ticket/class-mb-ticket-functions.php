<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MB_Ticket' ) ) {
    class MB_Ticket {
        /**
         * instance
         * @var null
         */
        protected static $_instance = null;
        protected $_prefix          = MB_PLUGIN_PREFIX_TICKET;

        public function __construct(){
            require_once MB_PLUGIN_INC . 'ticket/mpdf/vendor/autoload.php';

            if( apply_filters( 'mb_ft_attach_qrcode_mail', true ) ){
                require_once  MB_PLUGIN_INC.'ticket/qrcode/qrcode.class.php';
            }
            
            require_once MB_PLUGIN_INC.'ticket/class-mb-pdf.php';
        }

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        public function add_ticket( $booking_id = null ) {
            if ( $booking_id == null ) return false;

            $status_booking = get_post_meta( $booking_id, MB_PLUGIN_PREFIX_BOOKING . 'status', true );

            if ( $status_booking != 'Completed' ) return false;

            $movie_id           = get_post_meta( $booking_id, MB_PLUGIN_PREFIX_BOOKING . 'movie_id', true );
            $showtime_id        = get_post_meta( $booking_id, MB_PLUGIN_PREFIX_BOOKING . 'showtime_id', true );
            $room_id            = get_post_meta( $booking_id, MB_PLUGIN_PREFIX_BOOKING . 'room_id', true );
            $customer_id        = get_post_meta( $booking_id, MB_PLUGIN_PREFIX_BOOKING . 'customer', true );
            $customer_email     = get_post_meta( $booking_id, MB_PLUGIN_PREFIX_BOOKING . 'customer_email', true );
            $customer_phone     = get_post_meta( $booking_id, MB_PLUGIN_PREFIX_BOOKING . 'customer_phone', true );
            $customer_address   = get_post_meta( $booking_id, MB_PLUGIN_PREFIX_BOOKING . 'customer_address', true );
            $first_name         = isset( $customer_address['first_name'] ) ? $customer_address['first_name'] : '';
            $last_name          = isset( $customer_address['last_name'] ) ? $customer_address['last_name'] : '';
            $customer_name      = sprintf( _x( '%1$s %2$s', 'full name', 'moviebooking' ), $first_name, $last_name );
            $seat_booked        = get_post_meta( $booking_id, MB_PLUGIN_PREFIX_BOOKING . 'seat', true );
            $area_booked        = get_post_meta( $booking_id, MB_PLUGIN_PREFIX_BOOKING . 'area', true );
            $person_type_booked = get_post_meta( $booking_id, MB_PLUGIN_PREFIX_BOOKING . 'person_type', true );
            $extra_service_booked = get_post_meta( $booking_id, MB_PLUGIN_PREFIX_BOOKING . 'extra_service', true );
            $area_person_type   = array();
            if ( empty( $seat_booked ) || ! is_array( $seat_booked ) ) $seat_booked = []; 

            if ( ! empty( $area_booked ) && is_array( $area_booked ) ) {
                foreach ( $area_booked as $area_id => $qty ) {
                    if ( absint( $qty ) && absint( $qty ) > 0 ) {
                        for ( $i = 0; $i < $qty; $i ++ ) {
                            array_push( $seat_booked , $area_id );
                        }
                    }
                }
            }

            if ( ! empty( $person_type_booked ) ) {
                foreach ( $person_type_booked as $area_id => $person ) {
                    foreach ( $person as $key => $value ) {
                        $qty = absint( $value['qty'] );
                        $person_id = $value['id'];
                        for ($i=0; $i < $qty; $i++) { 
                            $area_person_type[$area_id][] = $person_id;
                        }
                    }
                }
            }

            $description_ticket     = get_post_meta( $room_id, MB_PLUGIN_PREFIX_ROOM . 'description', true );
            $private_desc_ticket    = get_post_meta( $room_id, MB_PLUGIN_PREFIX_ROOM . 'private_description', true );


            // Ticket Data
            $post_data['post_type']     = 'mb_ticket';
            $post_data['post_status']   = 'publish';

            // Add Author of event for Ticket
            $booking_data       = get_post( $booking_id );
            $booking_author_id  = $booking_data->post_author;
            $post_data['post_author'] = $booking_author_id;

            // Date
            $date = get_post_meta( $showtime_id, MB_PLUGIN_PREFIX_SHOWTIME.'date', true );

            // Address
            $address    = '';
            $city_id    = get_post_meta( $showtime_id, MB_PLUGIN_PREFIX_SHOWTIME.'city_id', true );
            $venue_id   = get_post_meta( $showtime_id, MB_PLUGIN_PREFIX_SHOWTIME.'venue_id', true );

            $city_name          = MBC()->mb_get_taxonomy_name( $city_id, 'movie_location' );
            $venue_name         = MBC()->mb_get_taxonomy_name( $venue_id, 'movie_location' );
            $showtime_address   = get_post_meta( $showtime_id, MB_PLUGIN_PREFIX_SHOWTIME.'address', true );
            $address_arr        = array();

            if ( $showtime_address ) $address_arr[] = $showtime_address;
            if ( $venue_name ) $address_arr[] = $venue_name;
            if ( $city_name ) $address_arr[] = $city_name;

            if ( mb_array_exists( $address_arr ) ) {
                $address = join( ', ', $address_arr );
            }

            // Tickets
            $ticket_ids = array();

            if ( ! empty( $seat_booked ) && is_array( $seat_booked ) ) {
                foreach( $seat_booked as $k => $seat ) {

                    $post_data['post_title'] = $seat;

                    $person_type = '';
                    $extra_service = [];

                    if ( ! empty( $extra_service_booked ) ) {
                        
                        if ( ! array_key_exists( $seat, $area_booked ) ) {
                            $extra_service = isset( $extra_service_booked[$seat] ) ? $extra_service_booked[$seat] : array();
                        } else {
                            $extra_service = isset( $extra_service_booked[$seat][0] ) ? $extra_service_booked[$seat][0] : array();
                            array_splice($extra_service_booked[$seat], 0, 1);
                        }

                    }

                    if ( ! empty( $area_person_type ) && array_key_exists( $seat, $area_person_type ) ) {
                        if ( count( $area_person_type[$seat] ) > 0 ) {
                            $person_type = $area_person_type[$seat][0];
                            array_shift( $area_person_type[$seat] );
                        }
                    }

                    if ( ! empty( $person_type ) ) {
                        $post_data['post_title'] .= ' - '.$person_type;
                    }

                    // QRcode
                    $mix_id     = 'ovatheme_'.$movie_id.'_'.$booking_id.'_'.$seat.'_'.$k.'_'.MB()->options->checkout->get('serect_key_qrcode');
                    $code       = apply_filters( 'mb_ft_encode_qrcode', $mix_id );
                    $qr_code    = md5( $mix_id );

                    $meta_input = array(
                        $this->_prefix.'booking_id'                 => $booking_id,
                        $this->_prefix.'movie_id'                   => $movie_id,
                        $this->_prefix.'showtime_id'                => $showtime_id,
                        $this->_prefix.'city_id'                    => $city_id,
                        $this->_prefix.'venue_id'                   => $venue_id,
                        $this->_prefix.'room_id'                    => $room_id,
                        $this->_prefix.'movie_name'                 => get_the_title( $movie_id ),
                        $this->_prefix.'qr_code'                    => $qr_code,
                        $this->_prefix.'customer_id'                => $customer_id,
                        $this->_prefix.'customer_email'             => $customer_email,
                        $this->_prefix.'customer_name'              => $customer_name,
                        $this->_prefix.'customer_phone'             => $customer_phone,
                        $this->_prefix.'customer_address'           => $customer_address,
                        $this->_prefix.'seat'                       => $seat,
                        $this->_prefix.'person_type'                => $person_type,
                        $this->_prefix.'extra_service'              => $extra_service,
                        $this->_prefix.'date'                       => $date,
                        $this->_prefix.'address'                    => $address,
                        $this->_prefix.'logo'                       => MB()->options->mail->get('ticket_logo', ''),
                        $this->_prefix.'color_border_ticket'        => MB()->options->mail->get('ticket_border_color', '#cccccc'),
                        $this->_prefix.'color_label_ticket'         => MB()->options->mail->get('ticket_label_color', '#666666'),
                        $this->_prefix.'color_content_ticket'       => MB()->options->mail->get('ticket_content_color', '#333333'),
                        $this->_prefix.'description_ticket'         => $description_ticket,
                        $this->_prefix.'private_desc_ticket'        => $private_desc_ticket,
                        $this->_prefix.'color_desc_ticket'          => $private_desc_ticket,
                        $this->_prefix.'color_private_desc_ticket'  => $private_desc_ticket,
                        $this->_prefix.'ticket_status'              => '',
                        $this->_prefix.'checkin_time'               => '',
                    );

                    $post_data['meta_input'] = apply_filters( 'mb_ft_ticket_metabox_input', $meta_input );

                    $ticket_id = wp_insert_post( $post_data, true );

                    // Add Meta Ticket ID
                    $metabox_ticket_id = array(
                        'ID'            => $ticket_id,
                        'meta_input'    => array(
                            $this->_prefix.'ticket_id' => $ticket_id
                        )
                    );
                     
                    // Update the post into the database
                    wp_update_post( $metabox_ticket_id );

                    $ticket_ids[] = $ticket_id;
                }
            }

            return $ticket_ids;
        }

        public function update_ticket( $ticket_id = null, $data_update = array() ) {
            if ( ! $ticket_id || empty( $data_update ) || ! is_array( $data_update ) ) return false;

            foreach( $data_update as $key => $value ) {
                update_post_meta( $ticket_id, $this->_prefix.$key, $value );
            }

            return true;
        }

        public function make_pdf_ticket_by_booking_id( $booking_id = null ) {
            if ( ! $booking_id ) return array();

            $args = array(
                'post_type'         => 'mb_ticket',
                'post_status'       => 'publish',
                'posts_per_page'    => '-1',
                'meta_query'        => array(
                    array(
                        'key'       => $this->_prefix . 'booking_id',
                        'value'     => $booking_id,
                        'compare'   => '='
                    )
                )
            );

            $tickets    = new WP_Query( $args );
            $ticket_pdf = array();

            $k = 0;

            if ( $tickets->have_posts() ): while( $tickets->have_posts() ): $tickets->the_post();
                $ticket_id = get_the_id();

                if ( apply_filters( 'mb_ft_attach_pdf_mail', true ) ) {
                    $pdf = new MB_PDF();

                    $ticket_pdf[$k] = $pdf->make_pdf_ticket( $ticket_id );  
                    $k++;
                }

                if ( apply_filters( 'mb_ft_attach_qrcode_mail', true ) ) {
                    $qrcode_str = get_post_meta( $ticket_id, $this->_prefix . 'qr_code', true );
                    $qrcode     = new QRcode( $qrcode_str, 'H' );
                    $qr_name    = apply_filters( 'mb_ft_qr_name', 'ticket_qr_'.$qrcode_str, $qrcode_str );
                    $qr_image   = WP_CONTENT_DIR.'/uploads/'.sanitize_title( $qr_name ).'.png';

                    $qrcode->displayPNG('100',array(255,255,255), array(0,0,0), $qr_image , 0);
                    $ticket_pdf[$k] = $qr_image;
                    $k++;
                }

            endwhile; endif; wp_reset_postdata();

            return $ticket_pdf;
        }

        public function get_tickets_by_booking( $booking_id = null ) {
            if ( ! $booking_id ) return array();

            $args = array(
                'post_type'         => 'mb_ticket',
                'post_status'       => 'publish',
                'posts_per_page'    => '-1',
                'fields'            => 'ids',
                'meta_query'        => array(
                    array(
                        'key'       => $this->_prefix . 'booking_id',
                        'value'     => $booking_id,
                        'compare'   => '=',
                    )
                )
            );

            $tickets = get_posts( $args );

            return $tickets;
        }
    }
}