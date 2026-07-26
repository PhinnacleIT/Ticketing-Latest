<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MB_Admin_Metaboxes' ) ) {
	class MB_Admin_Metaboxes {

		public function __construct() {
			add_action( 'admin_init', array( $this, 'add_meta_boxes' ) );
			add_action( 'save_post', array( $this, 'save_post' ), 10, 3 );
		}

		/* add metaboxes */
		public function add_meta_boxes() {
			new MB_Room_Metabox();
			new MB_Showtime_Metabox();
			new MB_Booking_Metabox();
			new MB_Ticket_Metabox();
		}

		public static function save_post( $post_id, $post, $update ) {
			if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
				return;
			}

			if ( ! isset( $_POST ) )
				return;

			if ( ! isset( $_POST['ova_metaboxes'] ) || ! wp_verify_nonce( $_POST['ova_metaboxes'], 'ova_metaboxes' ) )
				return;

			do_action( 'mb_ac_proccess_update_meta', $post_id, $_POST );
		}

	}

	new MB_Admin_Metaboxes();
}