<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}


if ( ! class_exists( 'MB_Email' ) ) {
    class MB_Email {
        protected static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        public function mb_sendmail_by_booking_id( $booking_id = null, $receiver = '' ) {
            if ( ! $booking_id ) return false;

            // Mail Settings
            $sendmail_to    = MB()->options->mail->get('mail_new_booking_sendmail');
            $recipients     = MB()->options->mail->get('mail_new_recipient');
            $subject        = MB()->options->mail->get('mail_new_subject');
            $from_name      = MB()->options->mail->get('mail_new_from_name');
            $send_from      = MB()->options->mail->get('mail_new_admin_email');
            $mail_content   = MB()->options->mail->get('mail_new_template');

            // Booking
            $movie_id           = get_post_meta( $booking_id, MB_PLUGIN_PREFIX_BOOKING . 'movie_id', true );
            $showtime_id        = get_post_meta( $booking_id, MB_PLUGIN_PREFIX_BOOKING . 'showtime_id', true );
            $room_id            = get_post_meta( $booking_id, MB_PLUGIN_PREFIX_BOOKING . 'room_id', true );
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
            // Area html
            $area_html = [];
            $extra_service_html = [];

            if ( mb_array_exists( $area_booked ) ) {
                foreach ( $area_booked as $area_id => $area_qty ) {

                    if ( ! empty( $person_type_booked ) && array_key_exists($area_id, $person_type_booked) ) {
                        foreach  ($person_type_booked[$area_id] as $key => $value ) {
                            $qty = isset( $value['qty'] ) ? absint( $value['qty'] ) : 0;
                            if ( $qty > 0 ) {
                                $area_name = $area_id.' - '.$value['id'];
                                $area_html[] = sprintf( esc_html__( '%s(x%s)', 'moviebooking' ), $area_name , $value['qty'] );
                            }
                            
                        }
                        

                    } else {
                        $area_html[] = sprintf( esc_html__( '%s(x%s)', 'moviebooking' ), $area_id, $area_qty );
                    }

                }
            }

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

            // Movie
            $movie_name = get_the_title( $movie_id );
            $movie_link = get_permalink( $movie_id );
            $movie_view = '<a href="'.esc_url( $movie_link ).'" title="'.esc_attr( $movie_name ).'" target="_blank">'.esc_attr( $movie_name ).'</a>';

            // Extra Service
            if ( ! empty( $extra_service_booked ) ) {
                $extra_service_html = mb_get_extra_service_html( $extra_service_booked );
            }

            // Date
            $date               = get_post_meta( $showtime_id, MB_PLUGIN_PREFIX_SHOWTIME.'date', true );
            $date_time_format   = MBC()->mb_get_date_time_format();
            $date_time          = date( $date_time_format, $date );

            // Discount, Tax, Ticket Fee, Total
            $total_html = '';

            $discount       = get_post_meta( $booking_id, MB_PLUGIN_PREFIX_BOOKING . 'discount', true );
            $discount_code  = get_post_meta( $booking_id, MB_PLUGIN_PREFIX_BOOKING . 'discount_code', true );
            if ( $discount && $discount_code ) {
                $total_html .= sprintf( _x( 'Discount: %1$s (%2$s)', 'discount mail', 'moviebooking' ), mb_price( $discount ), $discount_code ) . '<br>';
            }

            $tax = get_post_meta( $booking_id, MB_PLUGIN_PREFIX_BOOKING . 'tax', true );
            if ( $tax ) {
                $total_html .= sprintf( _x( 'Tax: %s', 'tax mail', 'moviebooking' ), mb_price( $tax ) ) . '<br>';
            }

            $ticket_fee = get_post_meta( $booking_id, MB_PLUGIN_PREFIX_BOOKING . 'ticket_fee', true );
            if ( $ticket_fee ) {
                $total_html .= sprintf( _x( 'Ticket fee: %s', 'ticket fee mail', 'moviebooking' ), mb_price( $ticket_fee ) ) . '<br>';
            }

            $total = get_post_meta( $booking_id, MB_PLUGIN_PREFIX_BOOKING . 'total', true );
            if ( $total ) {
                $total_html .= '<strong>'.sprintf( _x( 'Total: %s', 'total mail', 'moviebooking' ), mb_price( $total ) ). '</strong>';
            }

            // Mail to
            $mail_to        = [];
            $admin_email    = get_option( 'admin_email' );

            if ( ! empty( $sendmail_to ) && is_array( $sendmail_to ) ) {
                foreach( $sendmail_to as $for ) {
                    if ( $for === 'admin' && ! in_array( $admin_email, $mail_to ) ) {
                        $mail_to[] = $admin_email;
                    }

                    if ( $for === 'customer' && ! in_array( $customer_email, $mail_to ) ) {
                        $mail_to[] = $customer_email;
                    }
                }
            }

            if ( $recipients ) {
                $recipients_arr = explode( ',', $recipients );

                foreach( $recipients_arr as $recipient_email ) {
                    if ( trim( $recipient_email ) && ! in_array( trim( $recipient_email ), $mail_to ) ) {
                        $mail_to[] = trim( $recipient_email );
                    }
                }
            }

            $mail_to = apply_filters( 'mb_ft_mail_new_booking', implode( ',', $mail_to ) );

            if ( $receiver === 'admin' ) $mail_to = array( $admin_email );
            if ( $receiver === 'customer' ) $mail_to = array( $customer_email );

            // Email Content
            $mail_content = str_replace( '&lt;br&gt;', '<br>', $mail_content );
            $mail_content = str_replace( '[mb_movie]', $movie_view.'<br>', $mail_content );
            $mail_content = str_replace( '[mb_booking]', sprintf( esc_html__( '%s' ), $booking_id ).'<br>', $mail_content );
            $mail_content = str_replace( '[mb_date]', $date_time.'<br>', $mail_content );
            $mail_content = str_replace( '[mb_room]', get_the_title( $room_id ).'<br>', $mail_content );
            $mail_content = str_replace( '[mb_seat]', join( ', ', $seat_booked ).'<br>', $mail_content );
            $mail_content = str_replace( '[mb_area]', join( ', ', $area_html ).'<br>', $mail_content );
            $mail_content = str_replace( '[mb_extra_service]', join( ', ', $extra_service_html ).'<br>', $mail_content );
            $mail_content = str_replace( '[mb_address]', $address.'<br>', $mail_content );
            $mail_content = str_replace( '[mb_total]', $total_html.'<br>', $mail_content );
            $mail_content = str_replace( '[mb_customer]', $customer_name.'<br>', $mail_content );
            $mail_content = str_replace( '[mb_phone]', $customer_phone.'<br>', $mail_content );
            $mail_content = str_replace( '[mb_email]', $customer_email.'<br>', $mail_content );

            // If Email Content is Empty
            if ( ! $mail_content ) {
                $mail_content .= esc_html__( 'Movie: ', 'moviebooking') . $movie_view . '<br>';
                $mail_content .= esc_html__( 'Booking: ', 'moviebooking') . sprintf( esc_html__( '#%s' ), $booking_id ).'<br>';
                $mail_content .= esc_html__( 'Date: ', 'moviebooking') . $date_time.'<br>';
                $mail_content .= esc_html__( 'Room: ', 'moviebooking') . get_the_title( $room_id ).'<br>';
                $mail_content .= esc_html__( 'Seat: ', 'moviebooking') . join( ', ', $seat_booked ).'<br>';
                $mail_content .= esc_html__( 'Area: ', 'moviebooking') . join( ', ', $area_html ).'<br>';
                $mail_content .= esc_html__( 'Extra Service: ', 'moviebooking') . join( ', ', $extra_service_html ).'<br>';
                $mail_content .= esc_html__( 'Address: ', 'moviebooking') . $address.'<br>';
                $mail_content .= $total_html.'<br>';
                $mail_content .= esc_html__( 'Customer: ', 'moviebooking') . $customer_name.'<br>';
                $mail_content .= esc_html__( 'Phone: ', 'moviebooking') . $customer_phone.'<br>';
                $mail_content .= esc_html__( 'Email: ', 'moviebooking') . $customer_email.'<br>';
            }

            // Hook mail content new Booking
            $mail_content = apply_filters( 'mb_ft_mail_content_new_booking', $mail_content, $booking_id );

            // Ticket PDF
            $ticket_pdf = apply_filters( 'mb_ft_booking_mail_attachments', MB_Ticket()->make_pdf_ticket_by_booking_id( $booking_id ) );
            $result     = $this->mb_sendmail_new_order( $mail_to, $subject, $mail_content, $ticket_pdf );

            // Remove ticket
            $total_ticket_pdf = count( $ticket_pdf );

            if ( ! empty( $ticket_pdf ) && is_array( $ticket_pdf ) ) {
                foreach( $ticket_pdf as $key => $file ) {
                    if ( $key < $total_ticket_pdf ) {
                        if ( file_exists( $file ) ) unlink( $file );
                    } 
                }
            }

            return $result;
        }

        public function mb_sendmail_new_order( $mail_to, $subject, $body, $attachments = array() ) {
            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=".get_bloginfo( 'charset' )."\r\n";

            add_filter( 'wp_mail_from', array( $this, 'mb_wp_mail_from_new_order' ) );
            add_filter( 'wp_mail_from_name', array( $this, 'mb_wp_mail_from_name_new_order' ) );

            if ( wp_mail( $mail_to, $subject, $body, $headers, $attachments ) ) {
                $result = true;
            } else {
                $result = false;
            }

            remove_filter( 'wp_mail_from', array( $this, 'mb_wp_mail_from_new_order' ) );
            remove_filter( 'wp_mail_from_name', array( $this, 'mb_wp_mail_from_name_new_order' ) );

            return $result;
        }

        public function mb_wp_mail_from_new_order() {
            if ( MB()->options->mail->get('mail_new_admin_email') ) {
                return MB()->options->mail->get('mail_new_admin_email');
            } else {
                return get_option('admin_email');   
            }
        }

        public function mb_wp_mail_from_name_new_order() {
            return MB()->options->mail->get( 'mail_new_from_name', esc_html__( 'Booking Ticket Success!', 'moviebooking') );
        }

        public function mb_sendmail_remind_movie( $ticket_id = null ) {
            if ( ! $ticket_id ) return false;

            $booking_id = get_post_meta( $ticket_id, MB_PLUGIN_PREFIX_TICKET . 'booking_id', true );
            $room_id    = get_post_meta( $ticket_id, MB_PLUGIN_PREFIX_TICKET . 'room_id', true );
            $movie_id   = get_post_meta( $ticket_id, MB_PLUGIN_PREFIX_TICKET . 'movie_id', true );
            $mail_to    = get_post_meta( $ticket_id, MB_PLUGIN_PREFIX_TICKET . 'customer_email', true );
            $date       = get_post_meta( $ticket_id, MB_PLUGIN_PREFIX_TICKET . 'date', true );
            $seat       = get_post_meta( $ticket_id, MB_PLUGIN_PREFIX_TICKET . 'seat', true );
            $address    = get_post_meta( $ticket_id, MB_PLUGIN_PREFIX_TICKET . 'address', true );

            // Mail to
            $mail_to = apply_filters( 'mb_ft_mail_to_remind', $mail_to );

            // Movie
            $movie_name = get_the_title( $movie_id );
            $movie_link = get_permalink( $movie_id );
            $movie_view = '<a href="'.esc_url( $movie_link ).'" title="'.esc_attr( $movie_name ).'" target="_blank">'.esc_attr( $movie_name ).'</a>';

            // Date
            $date_time_format   = MBC()->mb_get_date_time_format();
            $date_time          = date( $date_time_format, $date );

            $subject = MB()->options->mail->get( 'remind_mail_subject', esc_html__( 'Remind the movie start time', 'moviebooking' ) );

            $mail_content = MB()->options->mail->get( 'remind_mail_template' );

            if ( ! $mail_content ) {
                $mail_content = esc_html__( 'You booked the [mb_movie] movie at [mb_date].<br>Booking: #[mb_booking]<br/>Room: [mb_room]<br/>Seat: [mb_seat]<br/>Address: [mb_address]<br/>'. 'moviebooking' );
            }

            $mail_content = str_replace( '&lt;br&gt;', '<br>', $mail_content );
            $mail_content = str_replace( '[mb_movie]', $movie_view.'<br>', $mail_content );
            $mail_content = str_replace( '[mb_date]', $date_time.'<br>', $mail_content );
            $mail_content = str_replace( '[mb_booking]', $booking_id.'<br>', $mail_content );
            $mail_content = str_replace( '[mb_room]', get_the_title( $room_id ).'<br>', $mail_content );
            $mail_content = str_replace( '[mb_seat]', $seat.'<br>', $mail_content );
            $mail_content = str_replace( '[mb_address]', $address.'<br>', $mail_content );

            // Hook mail content remind
            $mail_content = apply_filters( 'mb_ft_mail_content_remind', $mail_content, $ticket_id );

            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=".get_bloginfo( 'charset' )."\r\n";

            add_filter( 'wp_mail_from', array( $this, 'mb_wp_mail_from_remind_email' ) );
            add_filter( 'wp_mail_from_name', array( $this, 'mb_wp_mail_from_name_remind_email' ) );

            $result = false;

            if ( wp_mail( $mail_to, $subject, $mail_content, $headers ) ) {
                $result = true;
            }

            remove_filter( 'wp_mail_from', array( $this, 'mb_wp_mail_from_remind_email' ) );
            remove_filter( 'wp_mail_from_name', array( $this, 'mb_wp_mail_from_name_remind_email' ) );

            return $result;
        }

        public function mb_wp_mail_from_remind_email(){
            if ( MB()->options->mail->get('remind_mail_admin_email') ) {
                return MB()->options->mail->get('remind_mail_admin_email');
            } else {
                return get_option('admin_email');   
            }
        }

        public function mb_wp_mail_from_name_remind_email() {
            return MB()->options->mail->get( 'remind_mail_from_name', esc_html__( 'Remind the movie start time', 'moviebooking' ) );
        }

        public function mb_sendmail_cancel_booking( $booking_id = null ) {
            if ( ! $booking_id ) return false;

            $movie_id = get_post_meta( $booking_id, MB_PLUGIN_PREFIX_BOOKING . 'movie_id', true );

            // Movie
            $movie_name = get_the_title( $movie_id );
            $movie_link = get_permalink( $movie_id );
            $movie_view = '<a href="'.esc_url( $movie_link ).'" title="'.esc_attr( $movie_name ).'" target="_blank">'.esc_attr( $movie_name ).'</a>';

            $mail_to = get_post_meta( $booking_id, MB_PLUGIN_PREFIX_BOOKING . 'customer_email', true );

            // Mail to
            $mail_to = apply_filters( 'mb_ft_mail_to_cancel', $mail_to );

            $mail_content = MB()->options->mail->get( 'cancel_mail_template' );

            if ( ! $mail_content ) {
                $mail_content = esc_html__( 'Booking #[mb_booking] has been canceled.<br>Movie [mb_movie].<br>', 'moviebooking' );
            }

            $subject = MB()->options->mail->get( 'cancel_email_subject', esc_html__( 'Cancellation Booking', 'moviebooking' ) );

            $mail_content = str_replace( '&lt;br&gt;', '<br>', $mail_content );
            $mail_content = str_replace( '[mb_booking]', $booking_id, $mail_content );
            $mail_content = str_replace( '[mb_movie]', $movie_view, $mail_content );

            // Hook mail content cancel
            $mail_content = apply_filters( 'mb_ft_mail_content_cancel', $mail_content, $booking_id );

            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=".get_bloginfo( 'charset' )."\r\n";

            add_filter( 'wp_mail_from', array( $this, 'mb_wp_mail_from_cancel_booking' ) );
            add_filter( 'wp_mail_from_name', array( $this, 'mb_wp_mail_from_name_cancel_booking' ) );

            $result = false;

            if ( wp_mail( $mail_to, $subject, $mail_content, $headers ) ) {
                $result = true;
            }

            remove_filter( 'wp_mail_from', array( $this, 'mb_wp_mail_from_cancel_booking' ) );
            remove_filter( 'wp_mail_from_name', array( $this, 'mb_wp_mail_from_name_cancel_booking' ) );

            return $result;
        }

        public function mb_wp_mail_from_cancel_booking() {
            if ( MB()->options->mail->get('cancel_mail_admin_email') ){
                return MB()->options->mail->get('cancel_mail_admin_email');
            } else {
                return get_option('admin_email');   
            }
        }

        public function mb_wp_mail_from_name_cancel_booking() {
            return MB()->options->mail->get( 'cancel_mail_from_name', esc_html__( 'Cancellation Booking', 'moviebooking' ) );
        }
    }
}