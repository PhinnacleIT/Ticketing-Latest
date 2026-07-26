<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MB_Admin_Assets' ) ) {
    class MB_Admin_Assets {

        public function __construct() {
            add_action( 'admin_enqueue_scripts', array( $this, 'MB_Assets_admin_enqueue_scripts' ) );
        }

        public function MB_Assets_admin_enqueue_scripts() {

            /* Select2 */
            wp_enqueue_script( 'select2', MB_PLUGIN_URI.'assets/libs/select2/select2.min.js' , array( 'jquery' ), null, true );
            wp_enqueue_style( 'select2', MB_PLUGIN_URI. 'assets/libs/select2/select2.min.css', array(), null );

            /* Datetimepicker */
            wp_enqueue_script('moment', MB_PLUGIN_URI.'assets/libs/datetimepicker/moment.min.js', array('jquery'), null, true);
            wp_enqueue_script( 'datetimepicker', MB_PLUGIN_URI.'assets/libs/datetimepicker/jquery.datetimepicker.js' , array( 'jquery' ), null, true );
            wp_enqueue_style( 'datetimepicker', MB_PLUGIN_URI. 'assets/libs/datetimepicker/jquery.datetimepicker.css', array(), null );

            /* Color Picker */
            wp_enqueue_style( 'wp-color-picker' );
            wp_enqueue_script( 'wp-color-picker' );

            /* Admin JS */
            wp_enqueue_script( 'mb_admin', MB_PLUGIN_URI.'assets/js/admin/admin.min.js', array('jquery'), false, true );
            wp_localize_script( 'mb_admin', 'ajax_object', array(
                'ajax_url'      => admin_url('admin-ajax.php'),
                'ajax_nonce'    => wp_create_nonce( apply_filters( 'mb_admin_ajax_security', 'ajax_nonce_mb' ) ),
            ));
            wp_localize_script( 'mb_admin', 'mb_admin', array(
                'urls' => array(
                    'import_showtimes'      => get_admin_url().'edit.php?post_type=showtime&page=showtimes_importer',
                    'export_showtimes'      => get_admin_url().'edit.php?post_type=showtime&page=showtimes_exporter',
                    'export_tickets'        => get_admin_url().'edit.php?post_type=mb_ticket&page=tickets_exporter',
                    'booking_statistics'    => get_admin_url().'edit.php?post_type=mb_booking&page=booking_statistics',
                ),
                'strings' => array(
                    'import_showtimes'      => esc_html__( 'Import', 'moviebooking' ),
                    'export_showtimes'      => esc_html__( 'Export', 'moviebooking' ),
                    'export_tickets'        => esc_html__( 'Export', 'moviebooking' ),
                    'booking_statistics'    => esc_html__( 'Statistical', 'moviebooking' ),
                ), 
            ));
            
            /* Media */
            if ( in_array( get_current_screen()->id, array( 'edit-movie_cast' ) ) ) {
                wp_enqueue_media();
            }

            /* Admin CSS */
            wp_enqueue_style('mb_admin', MB_PLUGIN_URI.'assets/css/admin/admin.css' );
        }
    }

    return new MB_Admin_Assets();
}