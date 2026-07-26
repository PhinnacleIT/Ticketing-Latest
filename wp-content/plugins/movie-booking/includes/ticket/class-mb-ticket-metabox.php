<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MB_Ticket_Metabox' ) ) {
    class MB_Ticket_Metabox extends MB_Abstract_Metabox {

        public function __construct() {
            $this->_id = 'metabox_ticket';
            $this->_title = esc_html__( 'Ticket Detail','moviebooking' );
            $this->_screen = array( 'mb_ticket' );
            $this->_output = MB_PLUGIN_INC . 'admin/views/metaboxes/metabox-ticket.php';
            $this->_prefix = MB_PLUGIN_PREFIX_TICKET;

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

            if ( isset( $post_data['post_type'] ) && $post_data['post_type'] === 'mb_ticket' ) {
                
                foreach( $post_data as $name => $value ) {
                    if ( strpos( $name, $this->_prefix ) !== 0 ) continue;
                    
                    update_post_meta( $post_id, $name, $value );
                }
            }
        }
    }
}