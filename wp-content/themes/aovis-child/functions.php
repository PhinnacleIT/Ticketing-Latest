<?php

/**

 * Setup aovis Child Theme's textdomain.

 *

 * Declare textdomain for this child theme.

 * Translations can be filed in the /languages/ directory.

 */

function aovis_child_theme_setup() {

	load_child_theme_textdomain( 'aovis-child', get_stylesheet_directory() . '/languages' );

}

add_action( 'after_setup_theme', 'aovis_child_theme_setup' );





add_action( 'wp_enqueue_scripts', 'aovis_enqueue_styles' );

function aovis_enqueue_styles() {

    $parenthandle = 'aovis-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.

    $theme = wp_get_theme();
    $child_style_path = get_stylesheet_directory() . '/style.css';
    $child_style_ver  = file_exists( $child_style_path ) ? filemtime( $child_style_path ) : $theme->get('Version');

    wp_enqueue_style( $parenthandle, get_template_directory_uri() . '/style.css', 

        array(),  // if the parent theme code has a dependency, copy it to here

        $theme->parent()->get('Version')

    );

    wp_enqueue_style( 'child-style', get_stylesheet_uri(),

        array( $parenthandle ),

        $child_style_ver

    );

}

add_action( 'wp_enqueue_scripts', 'aovis_enqueue_mb_checkout_loader_fix', 99 );

function aovis_enqueue_mb_checkout_loader_fix() {
    if ( is_admin() ) {
        return;
    }

    $script_path = get_stylesheet_directory() . '/js/mb-checkout-loader-fix.js';
    $script_ver  = file_exists( $script_path ) ? filemtime( $script_path ) : wp_get_theme()->get( 'Version' );

    wp_enqueue_script(
        'aovis-mb-checkout-loader-fix',
        get_stylesheet_directory_uri() . '/js/mb-checkout-loader-fix.js',
        array( 'jquery' ),
        $script_ver,
        true
    );
}

function wk_save_custom_user_profile_fields( $user_id ) {
    if ( current_user_can( 'edit_user', $user_id ) ) {
        update_user_meta( $user_id, 'movie_access', sanitize_text_field( $_POST['movie_access'] ) );
        update_user_meta( $user_id, 'room_access', sanitize_text_field( $_POST['room_access'] ) );
    }
}

add_action( 'personal_options_update', 'wk_save_custom_user_profile_fields' );
add_action( 'edit_user_profile_update', 'wk_save_custom_user_profile_fields' );

function wk_custom_user_profile_fields( $user ) {
    echo '<h3 class="heading">Custom Fields</h3>';
    ?>
    <table class="form-table">
        <tr>
            <th><label for="movie_access">Movie Access</label></th>
            <td>
                <input type="text" name="movie_access" id="movie_access" value="<?php echo esc_attr( get_the_author_meta( 'movie_access', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="room_access">Room Access</label></th>
            <td>
                <input type="text" name="room_access" id="room_access" value="<?php echo esc_attr( get_the_author_meta( 'room_access', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
    </table>
    <?php
}
add_action( 'show_user_profile', 'wk_custom_user_profile_fields' );
add_action( 'edit_user_profile', 'wk_custom_user_profile_fields' );

function wdm_disable_cod( $available_gateways ) {
    if ( is_user_logged_in() and isset($_COOKIE['showtime_id']) and isset($_COOKIE['room_id'])) {
        $current_user = wp_get_current_user();
        $user_movie_access = explode(',',get_user_meta( $current_user->ID, 'movie_access', true ));
        $user_room_access = explode(',',get_user_meta( $current_user->ID, 'room_access', true ));
        $user_roles = $current_user->roles;
        $movie_id = get_post_meta( $_COOKIE['showtime_id'], 'ova_mb_showtime_movie_id', true );
        $room_id = $_COOKIE['room_id'];
        if ( isset($available_gateways['cod']) && (! (in_array($movie_id, $user_movie_access)) || ! (in_array($room_id, $user_room_access))) ) {

            //remove the cash on delivery payment gateway from the available gateways.
    
             unset($available_gateways['cod']);
         } 
    }

    //check whether the avaiable payment gateways have Cash on delivery and user is not logged in or he is a user with role customer
    //if ( isset($available_gateways['cod']) && (current_user_can('customer') || ! is_user_logged_in()) ) {

        //remove the cash on delivery payment gateway from the available gateways.

    //     unset($available_gateways['cod']);
    // }
     return $available_gateways;
}

add_filter('woocommerce_available_payment_gateways', 'wdm_disable_cod', 10, 1);

function aovis_mb_get_fee_exempt_roles() {
    return apply_filters( 'aovis_mb_fee_exempt_roles', array( 'administrator', 'promoter' ) );
}

function aovis_mb_is_fee_exempt_user() {
    if ( ! is_user_logged_in() ) {
        return false;
    }

    $user = wp_get_current_user();

    if ( ! $user || empty( $user->roles ) || ! is_array( $user->roles ) ) {
        return false;
    }

    $exempt_roles = aovis_mb_get_fee_exempt_roles();

    return (bool) array_intersect( $user->roles, $exempt_roles );
}

function aovis_mb_zero_fees_for_exempt_users( $meta_input ) {
    if ( ! aovis_mb_is_fee_exempt_user() || ! is_array( $meta_input ) ) {
        return $meta_input;
    }

    $prefix = defined( 'MB_PLUGIN_PREFIX_BOOKING' ) ? MB_PLUGIN_PREFIX_BOOKING : 'ova_mb_booking_';

    $subtotal = isset( $meta_input[ $prefix . 'subtotal' ] ) ? (float) $meta_input[ $prefix . 'subtotal' ] : 0;
    $discount = isset( $meta_input[ $prefix . 'discount' ] ) ? (float) $meta_input[ $prefix . 'discount' ] : 0;
    $total    = $subtotal - $discount;

    if ( $total < 0 ) {
        $total = 0;
    }

    $meta_input[ $prefix . 'tax' ]        = 0;
    $meta_input[ $prefix . 'ticket_fee' ] = 0;
    $meta_input[ $prefix . 'total' ]      = $total;
    $meta_input[ $prefix . 'incl_tax' ]   = 'no';

    unset( $meta_input[ $prefix . 'tax_type' ] );
    unset( $meta_input[ $prefix . 'tax_fee' ] );

    return $meta_input;
}

add_filter( 'mb_ft_booking_metabox_input', 'aovis_mb_zero_fees_for_exempt_users', 20 );
