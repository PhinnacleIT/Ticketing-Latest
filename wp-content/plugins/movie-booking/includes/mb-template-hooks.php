<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Booking Popup
add_action( 'wp_footer', function() {
    ?>
    <div id="mb_booking_popup" class="mb_booking_popup">
        <div class="mb-bp-container">
            <div class="mb-bp-content"></div>
            <div class="mb-close"><?php echo esc_html__( 'x', 'moviebooking' ); ?></div>
            <div class="mb-spinner">
                <div></div><div></div><div></div><div></div>
                <div></div><div></div><div></div><div></div>
                <div></div><div></div><div></div><div></div>
            </div>
        </div>
    </div>
    <div id="mb_trailer_video_popup" class="mb_trailer_video_popup">
        <div class="modal-container">
            <div class="modal">
                <i class="ovaicon-cancel"></i>
                <div class="modal-content"></div>
            </div>
        </div>
    </div>
    <?php
});

// Cart
add_action( 'mbc_seat_description', 'cart_seat_description' );
add_action( 'mbc_seat_map', 'cart_seat_map' );
add_action( 'mbc_seat_map', 'cart_seat_instruction' );
add_action( 'mbc_seat_info', 'cart_seat_info' );
add_action( 'mbc_seat_discount', 'cart_seat_discount' );
add_action( 'mbc_seat_checkout', 'cart_seat_checkout' );