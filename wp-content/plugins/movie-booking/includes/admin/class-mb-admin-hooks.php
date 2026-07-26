<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Add Showtimes filter
add_action( 'restrict_manage_posts', 'mb_filter_showtimes' );
if ( ! function_exists( 'mb_filter_showtimes' ) ) {
    function mb_filter_showtimes() {
        global $typenow;
        
        if ( $typenow === 'showtime' ) {
            $date_format    = MBC()->mb_get_date_time_format();
            $movie_id       = isset( $_GET['movie_id'] ) ? $_GET['movie_id'] : 0;
            $from           = isset( $_GET['from'] ) ? $_GET['from'] : '';
            $to             = isset( $_GET['to'] ) ? $_GET['to'] : '';
            $city_id        = isset( $_GET['city_id'] ) ? $_GET['city_id'] : 0;
            $venue_id       = isset( $_GET['venue_id'] ) ? $_GET['venue_id'] : 0;
            $room_id        = isset( $_GET['room_id'] ) ? $_GET['room_id'] : 0;

            ?>
            <div class="alignleft actions mb-showtimes-filter">
            <?php
                echo mb_dropdown_movies( $movie_id );
            ?>
                <span class="datepicker-showtimes-filter">
                    <input 
                        type="text" 
                        class="from_date mb_datepicker_filter" 
                        name="from" 
                        value="<?php echo strtotime( $from ) ? esc_attr( date_i18n( $date_format, strtotime( $from ) ) ) : ''; ?>" 
                        placeholder="<?php esc_attr_e( 'From Date', 'moviebooking' ); ?>" 
                        autocomplete="off" 
                        autocorrect="off" 
                        autocapitalize="none" 
                        onfocus="blur();" />
                    <a href="javascript:void(0)" class="btn remove_date" title="<?php esc_html_e( 'Clear', 'moviebooking' ); ?>">
                        <i class="dashicons-before dashicons-no-alt"></i>
                    </a>
                </span>
                <span class="datepicker-showtimes-filter">
                    <input 
                        type="text" 
                        class="to_date mb_datepicker_filter" 
                        name="to" 
                        value="<?php echo strtotime( $to ) ? esc_attr( date_i18n( $date_format, strtotime( $to ) ) ) : ''; ?>" 
                        placeholder="<?php esc_attr_e( 'To Date', 'moviebooking' ); ?>" 
                        autocomplete="off" 
                        autocorrect="off" 
                        autocapitalize="none" 
                        onfocus="blur();" />
                    <a href="javascript:void(0)" class="btn remove_date" title="<?php esc_html_e( 'Clear', 'moviebooking' ); ?>">
                        <i class="dashicons-before dashicons-no-alt"></i>
                    </a>
                </span>
                <input 
                    type="hidden" 
                    id="mb_datetimepicker_config"
                    class="mb_datetimepicker_config"
                    data-language="<?php echo esc_attr( MBC()->mb_get_language() ); ?>" 
                    data-first-day="<?php echo esc_attr( MBC()->mb_get_first_day() ); ?>" 
                    data-date-format="<?php echo esc_attr( MBC()->mb_get_date_format() ); ?>" 
                    data-time-format="<?php echo esc_attr( MBC()->mb_get_time_format() ); ?>" 
                    data-time-step="<?php echo esc_attr( MBC()->mb_get_time_step() ); ?>" 
                    data-time-default="<?php echo esc_attr( MBC()->mb_get_time_default() ); ?>" />
                <?php
                    echo mb_dropdown_cities( $city_id );
                    echo mb_dropdown_venues( $city_id, $venue_id );
                    echo mb_dropdown_rooms( $room_id );
                ?>
            </div>
            <?php
        }
    }
}

// Query Showtimes filter
add_filter( 'parse_query', 'mb_query_filter_showtimes' );
if ( ! function_exists( 'mb_query_filter_showtimes' ) ) {
    function mb_query_filter_showtimes( $query ) {
        global $pagenow;
        
        $meta_query = array();
        $post_type  = 'showtime';
        $q_vars     = &$query->query_vars;

        $movie_id   = isset( $_GET['movie_id'] ) ? $_GET['movie_id'] : 0;
        $from       = isset( $_GET['from'] ) ? $_GET['from'] : '';
        $to         = isset( $_GET['to'] ) ? $_GET['to'] : '';
        $city_id    = isset( $_GET['city_id'] ) ? $_GET['city_id'] : 0;
        $venue_id   = isset( $_GET['venue_id'] ) ? $_GET['venue_id'] : 0;
        $room_id    = isset( $_GET['room_id'] ) ? $_GET['room_id'] : 0;

        if ( $pagenow == 'edit.php' && isset( $q_vars['post_type'] ) && $q_vars['post_type'] == $post_type ) {
            // Movie
            if ( $movie_id ) {
                array_push( $meta_query , array(
                    'key'     => 'ova_mb_showtime_movie_id',
                    'value'   => $movie_id,
                    'compare' => '=',
                ));
            }

            // From - To
            if ( strtotime( $from ) && strtotime( $to ) ) {
                array_push( $meta_query , array(
                    'key'     => 'ova_mb_showtime_date',
                    'value'   => array( strtotime( $from ), strtotime( $to ) ),
                    'type'    => 'numeric',
                    'compare' => 'BETWEEN',
                ));
            } elseif ( strtotime( $from ) && ! strtotime( $to ) ) {
                array_push( $meta_query , array(
                    'key'     => 'ova_mb_showtime_date',
                    'value'   => strtotime( $from ),
                    'type'    => 'numeric',
                    'compare' => '>=',
                ));
            } elseif ( ! strtotime( $from ) && strtotime( $to ) ) {
                array_push( $meta_query , array(
                    'key'     => 'ova_mb_showtime_date',
                    'value'   => strtotime( $to ),
                    'type'    => 'numeric',
                    'compare' => '<=',
                ));
            } else {
                $from   = isset( $_GET['from'] ) ? $_GET['from'] : '';
                $to     = isset( $_GET['from'] ) ? $_GET['to'] : '';
            }

            // City & Venue
            if ( $city_id ) {
                array_push( $meta_query , array(
                    'key'     => 'ova_mb_showtime_city_id',
                    'value'   => $city_id,
                    'compare' => '=',
                ));
            }

            if ( $venue_id ) {
                array_push( $meta_query , array(
                    'key'     => 'ova_mb_showtime_venue_id',
                    'value'   => $venue_id,
                    'compare' => '=',
                ));
            }
            // End
            
            // Room
            if ( $room_id ) {
                array_push( $meta_query , array(
                    'key'     => 'ova_mb_showtime_room_ids',
                    'value'   => $room_id,
                    'compare' => 'REGEXP',
                ));
            }

            // orderby, order
            $orderby    = isset( $_GET['orderby'] ) ? $_GET['orderby'] : '';
            $order      = isset( $_GET['order'] ) ? $_GET['order'] : '';

            if ( $orderby && $order ) {
                if ( $orderby === 'ova_mb_showtime_movie_id' || $orderby === 'ova_mb_showtime_date' ) {
                    $q_vars['orderby']      = 'meta_value_num';
                    $q_vars['order']        = $order;
                    $q_vars['meta_type']    = 'NUMERIC';
                    $q_vars['meta_key']     = $orderby;
                }
            }
            
            if ( isset( $q_vars['meta_query'] ) && is_array( $q_vars['meta_query'] ) ) {
                $q_vars['meta_query'] = array_merge( $q_vars['meta_query'], $meta_query );
            } else {
                $q_vars['meta_query'] = $meta_query;
            }
        }
    }
}