<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MB_Frondend_Ajax' ) ) {
    class MB_Frondend_Ajax {

        public function __construct() {
            $this->init();
        }

        public function init() {
            // Define All Ajax function
            $args_ajax =  array(
                'mb_popup_showtime',
                'mb_get_showtimes',
                'mb_check_discount',
                'mb_process_checkout',
                'mb_countdown_checkout',
                'mb_get_trailer',
                'mb_get_movie_filter_ajax',
            );

            foreach( $args_ajax as $name ) {
                add_action( 'wp_ajax_'.$name, array( $this, $name ) );
                add_action( 'wp_ajax_nopriv_'.$name, array( $this, $name ) );
            }
        }

        public function mb_popup_showtime() {
            if ( ! isset( $_POST['data'] ) ) wp_die();
            $data = $_POST['data'];

            $ajax_nonce = isset( $data['ajax_nonce'] ) ? sanitize_text_field( $data['ajax_nonce'] ) : '';

            if ( ! wp_verify_nonce( $ajax_nonce , apply_filters( 'mb_frontend_ajax_security', 'ajax_nonce_mb' ) ) ) wp_die();

            $movie_id   = isset( $data['movie_id'] ) ? absint( sanitize_text_field( $data['movie_id'] ) ) : 0;
            $txt_error  = esc_html__( 'Sorry, there is no showtime for this movie, please choose another movie.', 'moviebooking' );

            if ( $movie_id ) {
                $showtimes      = MB_Showtime()->get_all_showtime( $movie_id );
                $data_showtime  = MB_Showtime()->get_date_by_showtime( $showtimes );

                if ( ! empty( $data_showtime ) && is_array( $data_showtime ) ) {
                    $maximum_showtime = MB()->options->general->get( 'mb_maximum_showtime', 14 );

                    if ( absint( $maximum_showtime ) ) {
                        $data_showtime = array_slice( $data_showtime, 0, $maximum_showtime, true );
                    }

                    mb_get_template( 'movie/popup/date-tabs.php', $data_showtime );
                    echo '<input type="hidden" name="movie_id" value="'.$movie_id.'">';
                } else {
                    echo $txt_error;
                }
            } else {
                echo $txt_error;
            }
            wp_die();
        }

        public function mb_get_showtimes() {
            if ( ! isset( $_POST['data'] ) ) wp_die();
            $data = $_POST['data'];

            $ajax_nonce = isset( $data['ajax_nonce'] ) ? sanitize_text_field( $data['ajax_nonce'] ) : '';

            if ( ! wp_verify_nonce( $ajax_nonce , apply_filters( 'mb_frontend_ajax_security', 'ajax_nonce_mb' ) ) ) wp_die();

            $movie_id       = isset( $data['movie_id'] ) ? absint( sanitize_text_field( $data['movie_id'] ) ) : 0;
            $date           = isset( $data['date'] ) ? absint( sanitize_text_field( $data['date'] ) ) : '';
            $txt_error      = esc_html__( 'Sorry, there is no showtime for this movie, please choose another movie.', 'moviebooking' );

            if ( $movie_id ) {
                $showtimes      = MB_Showtime()->get_all_showtime( $movie_id );
                $data_showtime  = MB_Showtime()->get_date_by_showtime( $showtimes );

                if ( ! empty( $data_showtime ) && is_array( $data_showtime ) ) { ?>
                    <div class="tab-content mb-showtimes">
                        <?php 
                            mb_get_template( 'movie/popup/city-tabs.php', array( 
                                'date_id'       => $date, 
                                'data_showtime' => $data_showtime,
                            ));
                        ?>
                    </div>
                    <?php
                } else {
                    echo $txt_error;
                }
            } else {
                echo $txt_error;
            }
            wp_die();
        }

        public function mb_check_discount() {
            if ( ! isset( $_POST['data'] ) ) wp_die();
            $data = $_POST['data'];

            $ajax_nonce = isset( $data['ajax_nonce'] ) ? sanitize_text_field( $data['ajax_nonce'] ) : '';

            if ( ! wp_verify_nonce( $ajax_nonce , apply_filters( 'mb_frontend_ajax_security', 'ajax_nonce_mb' ) ) ) wp_die();

            $movie_id       = isset( $data['movieID'] ) ? absint( sanitize_text_field( $data['movieID'] ) ) : 0;
            $discount_code  = isset( $data['discountCode'] ) ? sanitize_text_field( $data['discountCode'] ) : '';

            $data = MB_Cart()->check_code_discount( $movie_id, $discount_code );

            echo $data;

            wp_die();
        }

        public function mb_process_checkout() {
            if ( ! isset( $_POST['data'] ) ) wp_die();
            $data = $_POST['data'];

            $checkout_nonce = isset( $data['checkout_nonce'] ) ? sanitize_text_field( $data['checkout_nonce'] ) : '';

            if ( ! wp_verify_nonce( $checkout_nonce , apply_filters( 'mb_checkout_nonce', 'mb_checkout_nonce' ) ) ) wp_die();

            $result = MB()->checkout->process_checkout( $data );

            if ( $result ) {
                echo json_encode( $result );
            }

            wp_die();
        }

        public function mb_countdown_checkout() {
            if ( ! isset( $_POST['data'] ) ) wp_die();
            $data = $_POST['data'];

            $checkout_nonce = isset( $data['checkout_nonce'] ) ? sanitize_text_field( $data['checkout_nonce'] ) : '';
            $booking_id     = isset( $data['booking_id'] ) ? sanitize_text_field( $data['booking_id'] ) : '';
            $movie_id       = isset( $data['movie_id'] ) ? sanitize_text_field( $data['movie_id'] ) : '';
            $showtime_id    = isset( $data['showtime_id'] ) ? sanitize_text_field( $data['showtime_id'] ) : '';
            $room_id        = isset( $data['room_id'] ) ? sanitize_text_field( $data['room_id'] ) : '';

            if ( ! wp_verify_nonce( $checkout_nonce , apply_filters( 'mb_countdown_checkout_nonce', 'mb_countdown_checkout_nonce' ) ) ) wp_die();

            if ( WC()->cart ) {
                WC()->cart->empty_cart();
            }

            echo 'success';
            wp_die();
        }

        public function mb_get_trailer() {
            if ( ! isset( $_POST['data'] ) ) wp_die();
            $data = $_POST['data'];

            $ajax_nonce = isset( $data['ajax_nonce'] ) ? sanitize_text_field( $data['ajax_nonce'] ) : '';

            if ( ! wp_verify_nonce( $ajax_nonce , apply_filters( 'mb_frontend_ajax_security', 'ajax_nonce_mb' ) ) ) wp_die();

            $movie_id       = isset( $data['movie_id'] ) ? absint( sanitize_text_field( $data['movie_id'] ) ) : 0;
            $txt_error      = esc_html__( 'Sorry, there is no trailer video for this movie', 'moviebooking' );

            if ( $movie_id ) {
                $embed_url  = get_post_meta( $movie_id, 'ova_mb_movie_trailer', true );

                if ( ! empty( $embed_url ) ) {
                   echo wp_oembed_get( $embed_url );
                } else {
                    echo $txt_error;
                }
            } else {
                echo $txt_error;
            }
            wp_die();
        }

        public function mb_get_movie_filter_ajax() {
            if ( ! isset( $_POST['data'] ) ) wp_die();
            $data = $_POST['data'];

            $ajax_nonce = isset( $data['ajax_nonce'] ) ? sanitize_text_field( $data['ajax_nonce'] ) : '';

            if ( ! wp_verify_nonce( $ajax_nonce , apply_filters( 'mb_frontend_ajax_security', 'ajax_nonce_mb' ) ) ) wp_die();
            
            $template   = isset( $data['template'] ) ? sanitize_text_field( $data['template'] )  : 'template1'; 
            $venue      = isset( $data['venue'] )    ? sanitize_text_field( $data['venue'] )     : '';
            $total      = isset( $data['total'] )    ? sanitize_text_field( $data['total'] )     :  6;
            $orderby    = isset( $data['orderby'] )  ? sanitize_text_field( $data['orderby'] )   : 'ID';
            $order      = isset( $data['order'] )    ? sanitize_text_field( $data['order'] )     : 'DESC'; 
            $date_min   = isset( $data['date_min'] ) ? sanitize_text_field( $data['date_min'] )  : '';
            $date_max   = isset( $data['date_max'] ) ? sanitize_text_field( $data['date_max'] )  : '';

            $args = array(
                'venue' => $venue,
                'total' => $total,
                'orderby' => $orderby,
                'order' => $order,
                'date_min' => $date_min,
                'date_max' => $date_max,
            );
            
            $movies     = MB_Movie()->get_data_movie_filter_ajax( $args );
            $txt_error  = esc_html__( 'No movie found', 'moviebooking' );

            if( $movies->have_posts() ) : while ( $movies->have_posts() ) : $movies->the_post();

                if( $template === 'template1' ) {
                    mb_get_template( 'parts/item-template1.php' );

                } elseif( $template === 'template2' ) {
                    mb_get_template( 'parts/item-template2.php' );

                } elseif( $template === 'template3' ) {
                    mb_get_template( 'parts/item-template3.php' );

                } elseif( $template === 'template4' ) {
                    mb_get_template( 'parts/item-template4.php' );

                } else {
                    mb_get_template( 'parts/item-template1.php' );
                }

            endwhile; wp_reset_postdata();

            else : echo $txt_error; endif;

            wp_die();
        }

    }

    return new MB_Frondend_Ajax();
}