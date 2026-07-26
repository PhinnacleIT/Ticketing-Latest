<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MB_Admin_Statistical' ) ) {
    class MB_Admin_Statistical {
        public function __construct() {
            add_action( 'admin_menu', array( $this, 'add_to_menus' ) );
            add_action( 'admin_head', array( $this, 'hide_from_menus' ) );
        }

        public function add_to_menus() {
            add_submenu_page(
                'edit.php?post_type=mb_booking',
                __( 'Booking Statistics', 'moviebooking' ),
                __( 'Booking Statistics', 'moviebooking' ),
                'edit_posts',
                'booking_statistics',
                array( $this, 'booking_statistics' ),
            );
        }

        public function hide_from_menus() {
            global $submenu;

            if ( isset( $submenu['edit.php?post_type=mb_booking'] ) && is_array( $submenu['edit.php?post_type=mb_booking'] ) ) {
                foreach( $submenu['edit.php?post_type=mb_booking'] as $k => $menu ) {
                    if ( isset( $menu[2] ) && $menu[2] === 'booking_statistics' ) {
                        unset( $submenu['edit.php?post_type=mb_booking'][$k] );
                    }
                }
            }
        }

        public function booking_statistics() {
            include MB_PLUGIN_INC . 'admin/views/statistical/html-booking-statistics.php';
        }
    }

    new MB_Admin_Statistical();
}