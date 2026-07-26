<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

$cookie_sid     = isset( $_COOKIE['sid'] )      ? $_COOKIE['sid']       : '';
$cookie_rid     = isset( $_COOKIE['rid'] )      ? $_COOKIE['rid']       : '';
$showtime_id    = isset( $_GET['sid'] )         ? $_GET['sid']          : $cookie_sid;
$room_id        = isset( $_GET['rid'] )         ? $_GET['rid']          : $cookie_rid;
$movie_id       = MB_Movie()->get_id_by_showtime( $showtime_id );
$shortcode_map  = get_post_meta( $room_id, MB_PLUGIN_PREFIX_ROOM.'shortcode_img_map', true );

// Data Seat
$room_seats     = get_post_meta( $room_id, MB_PLUGIN_PREFIX_ROOM.'seats', true );
$data_booked    = MB_Booking()->get_data_booked( $movie_id, $showtime_id, $room_id );
$seat_booked    = $data_booked['seat_booked'];

// Data Area
$room_areas         = get_post_meta( $room_id, MB_PLUGIN_PREFIX_ROOM.'areas', true );
$area_outofstock    = $data_booked['area_outofstock'];

?>
<div class="mb-seat-map">
    <div class="mb-cart-error">
        <span class="mb-error seat-error"><?php esc_html_e( 'This seat booked!', 'moviebooking' ); ?></span>
        <span class="mb-error area-error"><?php esc_html_e( 'This area out of stock!', 'moviebooking' ); ?></span>
    </div>
    <?php echo do_shortcode( $shortcode_map ); ?>
    <input
        type="hidden"
        name="data-seat"
        id="mb-seat"
        data-seat="<?php echo esc_attr( wp_json_encode( $room_seats ) ); ?>"
        data-seat-booked="<?php echo esc_attr( wp_json_encode( $seat_booked ) ); ?>"
    />
    <input
        type="hidden"
        name="data-area"
        id="mb-area"
        data-area="<?php echo esc_attr( wp_json_encode( $room_areas ) ); ?>"
        data-area-outofstock="<?php echo esc_attr( wp_json_encode( $area_outofstock ) ); ?>"
    />
</div>