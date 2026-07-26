<?php 
/**
 * Plugin Name: Movie Booking
 * Description: Movie Booking plugin Allow to manage multiple movies with ticket booking.
 * Plugin URI: https://ovatheme.com
 * Author: ovatheme.com
 * Version: 1.0.6
 * Author URI: ovatheme.com
 * Text Domain: moviebooking
 * Domain Path: /languages/
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! defined( 'MB_PLUGIN_FILE' ) ) {
    define( 'MB_PLUGIN_FILE', __FILE__ );
}

if ( ! defined( 'MB_PLUGIN_PATH' ) ) {
    define( 'MB_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'MB_PLUGIN_URI' ) ) {
    define( 'MB_PLUGIN_URI', plugins_url( '/', __FILE__ ) );
}

if ( ! defined( 'MB_PLUGIN_PREFIX' ) ) {
    define( 'MB_PLUGIN_PREFIX', 'ova_mb_' );
}

if ( ! defined( 'MB_PLUGIN_PREFIX_MOVIE' ) ) {
    define( 'MB_PLUGIN_PREFIX_MOVIE', 'ova_mb_movie_' );
}

if ( ! defined( 'MB_PLUGIN_PREFIX_ROOM' ) ) {
    define( 'MB_PLUGIN_PREFIX_ROOM', 'ova_mb_room_' );
}

if ( ! defined( 'MB_PLUGIN_PREFIX_SHOWTIME' ) ) {
    define( 'MB_PLUGIN_PREFIX_SHOWTIME', 'ova_mb_showtime_' );
}

if ( ! defined( 'MB_PLUGIN_PREFIX_BOOKING' ) ) {
    define( 'MB_PLUGIN_PREFIX_BOOKING', 'ova_mb_booking_' );
}

if ( ! defined( 'MB_PLUGIN_PREFIX_TICKET' ) ) {
    define( 'MB_PLUGIN_PREFIX_TICKET', 'ova_mb_ticket_' );
}

if ( ! defined( 'MB_PLUGIN_INC' ) ) {
    define( 'MB_PLUGIN_INC', MB_PLUGIN_PATH . 'includes/' );
}

add_action( 'plugins_loaded', 'ova_mb_load_plugin_textdomain' );
function ova_mb_load_plugin_textdomain() {
    load_plugin_textdomain( 'moviebooking', false, basename( dirname( __FILE__ ) ) .'/languages' );
}

include_once dirname( __FILE__ ) . '/includes/mb-core-functions.php';

// Include the MovieBooking class.
if ( ! class_exists( 'MovieBooking' ) ) {
    include_once dirname( __FILE__ ) . '/includes/class-movie-booking.php';
}

// Include the MovieBookingCore class.
if ( ! class_exists( 'MovieBooking_Core' ) ) {
    include_once dirname( __FILE__ ) . '/includes/class-mb-core-functions.php';
}

/* Make Elementors */
if ( did_action( 'elementor/loaded' ) ) {
    include MB_PLUGIN_PATH.'elementor/class-register-elementor.php';
}


/**
 * Returns the main instance of MB.
 * @since  1.0
 * @return MovieBooking
 */
function MB() {
    return MovieBooking::instance();
}

/**
 * Returns the main instance of MB Core.
 * @since  1.0
 * @return MovieBooking
 */
function MBC() {
    return MovieBooking_Core::instance();
}

# Set Global
$GLOBALS['moviebooking'] = MB();
$GLOBALS['moviebookingcore'] = MBC();
