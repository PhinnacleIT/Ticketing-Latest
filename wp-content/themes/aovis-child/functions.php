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

    wp_enqueue_style( $parenthandle, get_template_directory_uri() . '/style.css', 

        array(),  // if the parent theme code has a dependency, copy it to here

        $theme->parent()->get('Version')

    );

    wp_enqueue_style( 'child-style', get_stylesheet_uri(),

        array( $parenthandle ),

        $theme->get('Version') // this only works if you have Version in the style header

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
