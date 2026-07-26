<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Get simple products
if ( ! function_exists( 'mb_get_wc_products' ) ) {
    function mb_get_wc_products() {
        $products = array();

        $args_query = array(
            'status'    => 'publish',
            'type'      => 'simple',
            'orderby'   => 'date',
            'order'     => 'DESC',
            'return'    => 'ids',
        );

        $args = apply_filters( 'mb_ft_get_wc_products', $args_query );

        if ( function_exists( 'wc_get_products' ) ) {
            $products = wc_get_products( $args );
        }

        return $products;
    }
}

// Dropdown wc Products
if ( ! function_exists( 'mb_dropdown_wc_products' ) ) {
    function mb_dropdown_wc_products() {
        $products = mb_get_wc_products();

        $products_dropdown[''] = esc_html__( '--- Select Product ---', 'moviebooking' );
        
        foreach ( $products as $id ) {
            $products_dropdown[$id] = get_the_title( $id );
        }

        return apply_filters( 'mb_ft_dropdown_wc_products', $products_dropdown );
    }
}

// Get HTML movies select
if ( ! function_exists( 'mb_dropdown_movies' ) ) {
    function mb_dropdown_movies( $selected = '' ) {
        $movies = MB_Movie()->get_all_movie();

        ob_start();
        ?>
        <select name="movie_id" id="movie_id">
            <option value="0" selected><?php esc_html_e( 'All movies', 'moviebooking' ); ?></option>
            <?php if ( ! empty( $movies ) && is_array( $movies ) ): ?>
                <?php foreach ( $movies as $movie_id ): ?>
                    <option value="<?php echo esc_attr( $movie_id ); ?>" <?php selected( $movie_id, $selected ); ?>>
                        <?php echo esc_html( get_the_title( $movie_id ) ); ?>
                    </option>
            <?php endforeach; endif; ?>
        </select>
        <?php

        $html = ob_get_clean();

        return $html;
    }
}

// Get HTML cities
if ( ! function_exists( 'mb_dropdown_cities') ) {
    function mb_dropdown_cities( $selected = '' ) {
        $cities = MBC()->mb_get_taxonomies( 'movie_location' );

        ob_start();
        ?>
        <select name="city_id" id="city_id">
            <option value="0" selected><?php esc_html_e( 'All cities', 'moviebooking' ); ?></option>
            <?php if ( ! empty( $cities ) && is_array( $cities ) ): ?>
                <?php foreach ( $cities as $city_item ): ?>
                    <option value="<?php echo esc_attr( $city_item->term_id ); ?>" <?php selected( $city_item->term_id, $selected ); ?>>
                        <?php echo esc_html( $city_item->name ); ?>
                    </option>
            <?php endforeach; endif; ?>
        </select>
        <?php

        $html = ob_get_clean();

        return $html;
    }
}

// Get HTML venues
if ( ! function_exists( 'mb_dropdown_venues') ) {
    function mb_dropdown_venues( $city_id = '' , $selected = '' ) {
        $venues = array();

        if ( $city_id ) {
            $venues = MBC()->mb_get_taxonomies( 'movie_location', array(), array(), 'all', 0, $city_id );
        }

        ob_start();

        if ( ! empty( $venues ) && is_array( $venues ) ):
        ?>
            <select name="venue_id" id="venue_id">
                <option value="0" selected><?php esc_html_e( 'All venues', 'moviebooking' ); ?></option>
                <?php foreach ( $venues as $venue_item ): ?>
                    <option value="<?php echo esc_attr( $venue_item->term_id ); ?>" <?php selected( $venue_item->term_id, $selected ); ?>>
                        <?php echo esc_html( $venue_item->name ); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        <?php
        else:
        ?>
            <select name="venue_id" id="venue_id">
                <option value="0" selected><?php esc_html_e( 'All venues', 'moviebooking' ); ?></option>
            </select>
        <?php
        endif;

        $html = ob_get_clean();

        return $html;
    }
}

// Get HTML rooms select
if ( ! function_exists( 'mb_dropdown_rooms' ) ) {
    function mb_dropdown_rooms( $selected = '' ) {
        $rooms = MB_Room()->get_all_room();

        ob_start();
        ?>
        <select name="room_id" id="room_id">
            <option value="0" selected><?php esc_html_e( 'All rooms', 'moviebooking' ); ?></option>
            <?php if ( ! empty( $rooms ) && is_array( $rooms ) ): ?>
                <?php foreach ( $rooms as $room_id ): ?>
                    <option value="<?php echo esc_attr( $room_id ); ?>" <?php selected( $room_id, $selected ); ?>>
                        <?php echo esc_html( get_the_title( $room_id ) ); ?>
                    </option>
            <?php endforeach; endif; ?>
        </select>
        <?php

        $html = ob_get_clean();

        return $html;
    }
}