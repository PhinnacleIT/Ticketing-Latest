<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

?>

<div class="cart-info">
    <div class="wp-cart-info">
        <h3 class="cart_title">
            <span class="title"><?php esc_html_e( 'Booking Information', 'moviebooking' ); ?></span>
        </h3>
        <div class="content-cart-info">
            <span class="placeholder"><?php esc_html_e( 'Please Select Your Seat', 'moviebooking' ); ?></span>
            <div class="item-info item-header">
                <span><?php esc_html_e( 'Seat', 'moviebooking' ); ?></span>
                <span><?php esc_html_e( 'Price', 'moviebooking' ); ?></span>
            </div>
            <div class="wp-content-item"></div>
            <ul class="extra-services" data-total="0"></ul>
            <div class="cart-fee total-discount">
                <p class="text"><?php esc_html_e( 'Discount', 'moviebooking' ); ?></p>
                <p class="discount-number"></p>
            </div>
            <div class="cart-fee total-tax">
                <p class="text"><?php esc_html_e( 'Tax', 'moviebooking' ); ?></p>
                <p class="tax-number"></p>
            </div>
            <div class="cart-fee ticket-fee">
                <p class="text"><?php esc_html_e( 'Ticket Fee', 'moviebooking' ); ?></p>
                <p class="ticket-fee-number"></p>
            </div>
        </div>
    </div>
    <div class="total-cart-info">
        <span class="text"><?php esc_html_e( 'Total', 'moviebooking' ); ?></span>
        <span class="total-price"><?php echo esc_html__( '0', 'moviebooking' ); ?></span>
    </div>
</div>