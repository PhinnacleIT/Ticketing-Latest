<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MB_Cron' ) ) {
    class MB_Cron {

        // Holding Ticket
        public $hook_update_holding_ticket          = 'mb_cron_hook_update_holding_ticket';
        public $time_repeat_update_holding_ticket   = 'time_repeat_update_holding_ticket';

        // Remind Email
        public $hook_remind_movie_time          = 'mb_cron_hook_remind_movie_time';
        public $time_repeat_remind_movie_time   = 'time_repeat_remind_movie_time';

        public function __construct() {
            add_filter( 'cron_schedules', array( $this, 'mb_add_cron_interval' ) );
            add_action( 'init', array( $this, 'mb_check_scheduled' ) );
            register_deactivation_hook( __FILE__, array( $this, 'mb_deactivate_cron' ) ); 

            add_action( $this->hook_update_holding_ticket, array( $this, 'mb_update_holding_ticket' ) );
            add_action( $this->hook_remind_movie_time, array( $this, 'mb_remind_email_movie' ) );
        }

        public function mb_add_cron_interval( $schedules ) {
            // Holding Ticket
            $update_holding_ticket_per_seconds = intval( MB()->options->checkout->get('holding_per_seconds', 600) );

            $schedules[$this->time_repeat_update_holding_ticket] = array(
                'interval'  => $update_holding_ticket_per_seconds,
                'display'   => sprintf( esc_html__( 'Every % seconds', 'moviebooking' ), $update_holding_ticket_per_seconds )
            );

            // Remind Email
            $remind_mail_send_per_seconds = intval( MB()->options->mail->get( 'remind_mail_send_per_seconds', 86400 ) );

            $schedules[$this->time_repeat_remind_movie_time] = array(
                'interval'  => $remind_mail_send_per_seconds,
                'display'   => sprintf( esc_html__( 'Every % seconds', 'moviebooking' ), $remind_mail_send_per_seconds )
            );

            return $schedules;
        }

        public function mb_check_scheduled(){
            // Holding Ticket
            if ( ! wp_next_scheduled( $this->hook_update_holding_ticket ) ) {
                wp_schedule_event( time(), $this->time_repeat_update_holding_ticket, $this->hook_update_holding_ticket );
            }

            // Remind Email
            if ( ! wp_next_scheduled( $this->hook_remind_movie_time ) ) {
                wp_schedule_event( time(), $this->time_repeat_remind_movie_time, $this->hook_remind_movie_time );
            }
        }

        public function mb_deactivate_cron() {
            // Holding Ticket
            $timestamp_update_holding_ticket = wp_next_scheduled( $this->hook_update_holding_ticket );
            wp_unschedule_event( $timestamp_update_holding_ticket, $this->hook_update_holding_ticket );

            // Remind Email
            $timestamp_send_remind_email = wp_next_scheduled( $this->hook_remind_movie_time );
            wp_unschedule_event( $timestamp_send_remind_email, $this->hook_remind_movie_time );
        }

        public function mb_update_holding_ticket() {
            if ( MB()->options->checkout->get('enable_holding_ticket', 'yes') !== 'yes' ) return;

            $max_time_complete_checkout = absint( MB()->options->checkout->get('max_time_complete_payment', 600) );

            $args = array(
                'post_type'         => 'holding_ticket',
                'post_status'       => 'publish',
                'posts_per_page'    => -1,
                'fields'            => 'ids',
            );

            $holding_ticket = get_posts( $args );

            if ( mb_array_exists( $holding_ticket ) ) {
                $prefix         = MB_PLUGIN_PREFIX_BOOKING;
                $curren_time    = current_time('timestamp');

                foreach( $holding_ticket as $ht_id ) {
                    $ht_current_time    = absint( get_post_meta( $ht_id, $prefix . 'current_time', true ) );
                    $past_time          = $curren_time - $ht_current_time;
                    $booking_id         = get_post_meta( $ht_id, $prefix . 'booking_id', true );

                    if ( $past_time > $max_time_complete_checkout ) {
                        wp_delete_post( $ht_id );

                        if ( (int)$booking_id ) {
                            $status_holding_ticket = get_post_meta( $booking_id, $prefix . 'status_holding_ticket', true );

                            if ( $status_holding_ticket === 'Pending' ) {
                                update_post_meta( $booking_id, $prefix . 'status', 'Expired' );
                            }
                        }
                    }
                }
            }
        }

        public function mb_remind_email_movie() {
            if ( MB()->options->mail->get( 'enable_remind_mail', 'yes' ) === 'yes' ) {
                $send_x_day     = intval( MB()->options->mail->get( 'remind_mail_before_xday', 3 ) );
                $current_time   = current_time('timestamp');

                $args = array(
                    'post_type'     => 'mb_ticket',
                    'post_status'   => 'publish',
                    'numberposts'   => -1,
                    'fields'        => 'ids',
                    'meta_query'    => array(
                        array(
                            'relation' => 'AND',
                            array(
                                'key'       => MB_PLUGIN_PREFIX_TICKET.'date',
                                'value'     => array( $current_time, $current_time + $send_x_day*24*60*60 ),
                                'compare'   => 'BETWEEN'
                            ),
                            array(
                                'key'       => MB_PLUGIN_PREFIX_TICKET.'ticket_status',
                                'value'     => '',
                                'compare'   => '='
                            )
                        )
                    )
                );

                $tickets = get_posts( $args );

                if ( mb_array_exists( $tickets ) ) {
                    foreach( $tickets as $ticket_id ) {
                        $send_mail = MB_Email()->mb_sendmail_remind_movie( $ticket_id );
                    }
                }
            }
        }
    }

    new MB_Cron();
}