<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MB_Room_Metabox' ) ) {
    class MB_Room_Metabox extends MB_Abstract_Metabox {

        public function __construct() {
            $this->_id = 'metabox_room';
            $this->_title = esc_html__( 'Room Settings','moviebooking' );
            $this->_screen = array( 'room' );
            $this->_output = MB_PLUGIN_INC . 'admin/views/metaboxes/metabox-room.php';
            $this->_prefix = MB_PLUGIN_PREFIX_ROOM;

            parent::__construct();

            add_action( 'mb_ac_proccess_update_meta', array( $this, 'update' ), 10, 2 );
        }

        public function update( $post_id, $post_data ) {
            if ( empty( $post_data ) ) exit();

            if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
                return;
            }

            if ( !isset( $post_data ) )
                return;

            if ( !isset( $post_data['ova_metaboxes'] ) || !wp_verify_nonce( $post_data['ova_metaboxes'], 'ova_metaboxes' ) )
                return;

            if ( isset( $post_data['post_type'] ) && $post_data['post_type'] === 'room' ) {
                if ( ! isset( $post_data['ova_mb_room_seats'] ) ) {
                    update_post_meta( $post_id, 'ova_mb_room_seats', '' );
                }

                $person_type = isset( $post_data[$this->_prefix.'person_type'] ) ? MovieBooking_Core::instance()->recursive_sanitize_text_field( $post_data[$this->_prefix.'person_type'] ) : '';
                update_post_meta( $post_id, $this->_prefix.'person_type', $person_type );

                foreach ( $post_data as $name => $value ) {
                    if ( strpos( $name, $this->_prefix ) !== 0 ) continue;
                    
                    if ( $name === 'ova_mb_room_code' ) $value = sanitize_title( $value );
                    
                    update_post_meta( $post_id, $name, $value );
                }



                if ( ! get_the_title( $post_id ) ) {
                    wp_update_post(array(
                        'ID'            => $post_id,
                        'post_title'    => sprintf( esc_html__( 'Room #%s', 'moviebooking' ), $post_id ),
                    ));
                }
            }
        }
    }
}