<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MB_Showtime_Metabox' ) ) {
    class MB_Showtime_Metabox extends MB_Abstract_Metabox {

        public function __construct() {
            $this->_id = 'metabox_showtime';
            $this->_title = esc_html__( 'Showtime Settings','moviebooking' );
            $this->_screen = array( 'showtime' );
            $this->_output = MB_PLUGIN_INC . 'admin/views/metaboxes/metabox-showtime.php';
            $this->_prefix = MB_PLUGIN_PREFIX_SHOWTIME;

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

            if ( isset( $post_data['post_type'] ) && $post_data['post_type'] === 'showtime' ) {
                foreach( $post_data as $name => $value ) {
                    if ( strpos( $name, $this->_prefix ) !== 0 ) continue;
                    
                    if ( $name === $this->_prefix.'date' ) {
                        $value = strtotime( $value );
                    }

                    update_post_meta( $post_id, $name, $value );
                }

                if ( ! get_the_title( $post_id ) ) {
                    $title = array();

                    if ( isset( $post_data[$this->_prefix.'date'] ) && strtotime( $post_data[$this->_prefix.'date'] ) ) {
                        $date_format = MBC()->mb_get_date_time_format();
                        array_push( $title, date_i18n( $date_format, strtotime( $post_data[$this->_prefix.'date'] ) ) );
                    }

                    if ( isset( $post_data[$this->_prefix.'room_ids'] ) && $post_data[$this->_prefix.'room_ids'] && is_array( $post_data[$this->_prefix.'room_ids'] ) ) {
                        $rooms = array();

                        foreach( $post_data[$this->_prefix.'room_ids'] as $room_id ) {
                            array_push( $rooms, get_the_title( $room_id ) );
                        }

                        array_push( $title, join( ',', $rooms ) );
                    }

                    if ( isset( $post_data[$this->_prefix.'city_id'] ) && $post_data[$this->_prefix.'city_id'] ) {
                        $city_name  = MBC()->mb_get_taxonomy_name( $post_data[$this->_prefix.'city_id'], 'movie_location' );
                        array_push( $title, $city_name );
                    }

                    if ( isset( $post_data[$this->_prefix.'venue_id'] ) && $post_data[$this->_prefix.'venue_id'] ) {
                        $venue_name = MBC()->mb_get_taxonomy_name( $post_data[$this->_prefix.'venue_id'], 'movie_location' );
                        array_push( $title, $venue_name );
                    }

                    if ( ! empty( $title ) && is_array( $title ) ) {
                        $title = join( ' - ', $title );
                    } else {
                        $title = '#'.$post_id;
                    }

                    wp_update_post(array(
                        'ID'            => $post_id,
                        'post_title'    => $title,
                    ));
                }
            }
        }
    }
}