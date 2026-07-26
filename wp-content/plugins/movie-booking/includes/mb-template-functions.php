<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Locate template
if ( ! function_exists( 'mb_locate_template' ) ) {
    function mb_locate_template( $template_name, $template_path = '', $default_path = '' ) {
        // Set variable to search in ovamb-templates folder of theme.
        if ( ! $template_path ) {
            $template_path = 'ovamb-templates/';
        }

        // Set default plugin templates path.
        if ( ! $default_path ) {
            $default_path = MB_PLUGIN_PATH . 'templates/'; // Path to the template folder
        }

        // Search template file in theme folder.
        $template = locate_template( array( $template_path . $template_name ) );

        // Get plugins template file.
        if ( ! $template ) {
            $template = $default_path . $template_name;
        }

        return apply_filters( 'mb_ft_locate_template', $template, $template_name, $template_path, $default_path );
    }
}

// Get template
if ( ! function_exists( 'mb_get_template' ) ) {
    function mb_get_template( $template_name, $args = array(), $tempate_path = '', $default_path = '' ) {
        if ( is_array( $args ) && isset( $args ) ) {
            extract( $args );
        }

        $template_file = mb_locate_template( $template_name, $tempate_path, $default_path );

        if ( ! file_exists( $template_file ) ) {
            _doing_it_wrong( __FUNCTION__, sprintf( "<code>%s</code> doesn't exist.", $template_file ), '1.0.0' );
            return;
        }

        include $template_file;
    }
}

// Cart
if ( ! function_exists( 'cart_seat_description' ) ) {
    function cart_seat_description() {
        mb_get_template( 'cart/cart_seat_description.php' );
    }
}

if ( ! function_exists( 'cart_seat_map' ) ) {
    function cart_seat_map() {
        mb_get_template( 'cart/cart_seat_map.php' );
    }
}

if ( ! function_exists( 'cart_seat_instruction' ) ) {
    function cart_seat_instruction() {
        mb_get_template( 'cart/cart_seat_instruction.php' );
    }
}

if ( ! function_exists( 'cart_seat_info' ) ) {
    function cart_seat_info() {
        mb_get_template( 'cart/cart_seat_info.php' );
    }
}

if ( ! function_exists( 'cart_seat_discount' ) ) {
    function cart_seat_discount() {
        mb_get_template( 'cart/cart_seat_discount.php' );
    }
}

if ( ! function_exists( 'cart_seat_checkout' ) ) {
    function cart_seat_checkout() {
        mb_get_template( 'cart/cart_seat_checkout.php' );
    }
}
// End Cart