<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MB_Movie_Metabox' ) ) {
    class MB_Movie_Metabox extends MB_Abstract_Metabox {

        public function __construct() {
            add_action( 'cmb2_init', array( $this, 'MB_Movie_metaboxes' ) );
            add_action( 'save_post', array( $this, 'MB_Movie_save_metaboxes' ), 20, 3 );

            $this->_id          = 'metabox_movie';
            $this->_title       = esc_html__( 'Metaboxs','moviebooking' );
            $this->_screen      = array( 'movie' );
            $this->_output      = MB_PLUGIN_INC . 'admin/views/metaboxes/metabox-movie.php';
            $this->_prefix      = MB_PLUGIN_PREFIX_MOVIE;
            $this->_priority    = 'default';

            parent::__construct();
        }

        public function MB_Movie_metaboxes() {
            $movie_settings = new_cmb2_box( array(
                'id'            => MB_PLUGIN_PREFIX_MOVIE.'settings',
                'title'         => esc_html__( 'Settings', 'moviebooking' ),
                'object_types'  => array( 'movie'),
                'context'       => 'normal',
                'priority'      => 'high',
                'show_names'    => true,    
            ));

            // Listings
            $group_listing = $movie_settings->add_field( array(
                'id'          => MB_PLUGIN_PREFIX_MOVIE. 'listing',
                'type'        => 'group',
                'options'     => array(
                    'group_title'       => esc_html__( 'Listing', 'moviebooking' ), 
                    'add_button'        => esc_html__( 'Add Listing', 'moviebooking' ),
                    'remove_button'     => esc_html__( 'Remove', 'moviebooking' ),
                    'sortable'          => true, 
                ),
            ) );

            $movie_settings->add_group_field( $group_listing, array(
                'name' => esc_html__( 'Title', 'moviebooking' ),
                'id'   => MB_PLUGIN_PREFIX_MOVIE . 'listing_title',
                'type' => 'text',
            ) );       
            
            $movie_settings->add_group_field( $group_listing, array(
                'name' => esc_html__( 'Value', 'moviebooking' ),
                'id'   => MB_PLUGIN_PREFIX_MOVIE. 'listing_value',
                'type' => 'text',
            ) );
            
            // Release date
            $movie_settings->add_field( array(
                'name' => esc_html__( 'Release date', 'moviebooking' ), 
                'id'   => MB_PLUGIN_PREFIX_MOVIE.'release_date',
                'type' => 'text_date_timestamp',
                'date_format' => MBC()->mb_get_date_format(),
            ) );
            
            // Running time
            $movie_settings->add_field( array(
                'name'  => esc_html__( 'Running time', 'moviebooking' ),
                'id'    => MB_PLUGIN_PREFIX_MOVIE.'running_time',
                'type'  => 'text',
            ));

            // Slideshow image
            $movie_settings->add_field( array(
                'name'       => esc_html__( 'Slideshow image', 'moviebooking' ),
                'id'         => MB_PLUGIN_PREFIX_MOVIE. 'slideshow_image',
                'type'    => 'file',
                'query_args' => array(
                    'type' => array(
                        'image/jpeg',
                        'image/png',
                    ),
                ),
                'desc'  => esc_html__( "Used in the Movie Main Slider widget as background image ( recommended size: 1600x720px )", 'moviebooking' ),
            ) );

            $movie_settings->add_field( array(
                'name'  => esc_html__( 'Video Trailer', 'moviebooking' ), 
                'id'    => MB_PLUGIN_PREFIX_MOVIE.'trailer',
                'type'  => 'oembed',
                'desc'  => esc_html__( 'You can paste the video URL from the third-party site such as YouTube, Vimeo... ( Find out more: https://wordpress.org/documentation/article/embeds/ )', 'moviebooking' ),
            ));

            $movie_settings->add_field( array(
                'name' => esc_html__( 'Custom Link Get ticket', 'ova-team' ),
                'id'   => MB_PLUGIN_PREFIX_MOVIE.'custom_link_get_ticket',
                'type' => 'text_url',
                'desc' => esc_html__( 'Redirect to custom link instead of booking popup', 'moviebooking' ),
            ) );

            // Sort order
            $movie_settings->add_field( array(
                'name'      => esc_html__( 'Sort Order', 'moviebooking' ),
                'id'        => MB_PLUGIN_PREFIX_MOVIE.'order',
                'desc'      => esc_html__( 'Insert Number', 'moviebooking' ),
                'type'      => 'text',
                'default'   => '',
                'desc'      => esc_html__( 'Automatically insert Sort Order if empty', 'moviebooking' ),
            ));

            // Featured Movie
            $movie_settings->add_field( array(
                'name' => esc_html__( 'Featured Movie', 'moviebooking' ),
                'id'   => MB_PLUGIN_PREFIX_MOVIE.'featured',
                'type' => 'checkbox',
                'desc' => esc_html__( 'Featured Movie', 'moviebooking' ),
            ) );
            
            // Closed
            $movie_settings->add_field( array(
                'name' => esc_html__( 'Closed Statement', 'moviebooking' ),
                'id'   => MB_PLUGIN_PREFIX_MOVIE.'closed',
                'type' => 'checkbox',
                'desc' => esc_html__( 'Stop showing this movie in archive page and all movie widgets', 'moviebooking' ),
            ) );

            // Staff check Tickets
            $movie_settings->add_field( array(
                'name' => esc_html__( 'Username of staff', 'moviebooking' ),
                'id'   => MB_PLUGIN_PREFIX_MOVIE.'staff_check_tickets',
                'type' => 'text',
                'desc' => esc_html__( 'Enter username of Staff check Tickets. Ex: demo', 'moviebooking' ),
            ) );

        }

        public function MB_Movie_save_metaboxes( $id, $post, $update ) {
            $data = isset( $_POST ) && ! empty( $_POST ) ? $_POST : array();

            if ( ! empty( $data ) && $post->post_type == 'movie' ) {
                $meta_key_order = MB_PLUGIN_PREFIX_MOVIE.'order';
                $sort_order     = isset( $data[$meta_key_order] ) && $data[$meta_key_order] ? $data[$meta_key_order] : MB_Movie()->get_sort_order();

                if ( get_post_meta( $id, $meta_key_order, FALSE ) ) { 
                    update_post_meta( $id, $meta_key_order, $sort_order );
                } else {
                    add_post_meta( $id, $meta_key_order, $sort_order );
                }

                // Save Coupons
                $meta_key_coupon    = MB_PLUGIN_PREFIX_MOVIE.'coupons';
                $coupons            = isset( $data[$meta_key_coupon] ) && $data[$meta_key_coupon] ? $data[$meta_key_coupon] : array();

                if ( ! empty( $coupons ) && is_array( $coupons ) ) {
                    foreach( $coupons as $key => $coupon ) {
                        if ( $coupon['start'] ) {
                            $coupons[$key]['start'] = strtotime( $coupon['start'] );
                        }

                        if ( $coupon['end'] ) {
                            $coupons[$key]['end'] = strtotime( $coupon['end'] );
                        }
                    }

                    if ( get_post_meta( $id, $meta_key_coupon, FALSE ) ) { 
                        update_post_meta( $id, $meta_key_coupon, $coupons );
                    } else {
                        add_post_meta( $id, $meta_key_coupon, $coupons );
                    }
                }
            }
        }
    }

    return new MB_Movie_Metabox();
}