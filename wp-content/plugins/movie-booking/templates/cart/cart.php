<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

$cookie_sid     = isset( $_COOKIE['sid'] )      ? $_COOKIE['sid']       : '';
$cookie_rid     = isset( $_COOKIE['rid'] )      ? $_COOKIE['rid']       : '';
$showtime_id    = isset( $_GET['sid'] )         ? $_GET['sid']          : $cookie_sid;
$room_id        = isset( $_GET['rid'] )         ? $_GET['rid']          : $cookie_rid;

// Tax
$enable_tax = MB()->options->tax_fee->get( 'enable_tax' );
$tax_type   = MB()->options->tax_fee->get( 'type_tax' );
$tax_fee    = '';
$incl_tax   = MB()->options->tax_fee->get( 'prices_include_tax', 'no' );

if ( $enable_tax === 'yes' ) {
    if ( $tax_type === 'percent' ) {
        $tax_fee = MB()->options->tax_fee->get( 'pecent_tax' );
    }

    if ( $tax_type === 'amount' ) {
        $tax_fee = MB()->options->tax_fee->get( 'amount_tax' );
    }
}
// End Tax

// Ticket Fee
$enable_ticket_fee  = MB()->options->tax_fee->get( 'enable_ticket_fee' );
$type_ticket_fee    = MB()->options->tax_fee->get( 'type_ticket_fee' );
$ticket_fee         = '';

if ( $enable_ticket_fee === 'yes' ) {
    if ( $type_ticket_fee === 'percent' ) {
        $ticket_fee = MB()->options->tax_fee->get( 'pecent_ticket_fee' );
    }

    if ( $type_ticket_fee === 'amount' ) {
        $ticket_fee = MB()->options->tax_fee->get( 'amount_ticket_fee' );
    }
}
// End Ticket Fee

$person_type    = get_post_meta( $room_id, MB_PLUGIN_PREFIX_ROOM.'person_type' , true );
$extra_service  = mb_booking_get_extra_service_remaining( $room_id );

if ( empty( $person_type ) ) {
    $person_type = array();
}

// Currency
$currency_settings = MB_Cart()->get_cart_currency_settings();
// End Currency

if ( ! $showtime_id || ! $room_id ): ?>
    <article id="mb_cart" class="cart_detail">
        <div class="cart_empty">
            <?php 
                esc_html_e( 'The Cart is empty!', 'moviebooking' );
            ?>  
        </div>
    </article>
<?php else: ?>
    <div class="mb-cart-header">
        <?php do_action( 'mbc_header' ); ?>
    </div>
    <article id="mb_cart" class="cart_detail">
        <input 
            type="hidden" 
            id="cart-data" 
            name="cart-data"
            data-extra-item-prefix="<?php esc_attr_e( 'Ticket #', 'moviebooking' ); ?>"
            data-extra-service="<?php echo esc_attr( json_encode( $extra_service ) ); ?>"
            data-person-type="<?php echo esc_attr( json_encode( $person_type ) ); ?>"
            data-sid="<?php echo esc_attr( $showtime_id ); ?>" 
            data-rid="<?php echo esc_attr( $room_id ); ?>" 
            data-tax-fee="<?php echo esc_attr( $tax_fee ); ?>" 
            data-tax-type="<?php echo esc_attr( $tax_type ); ?>" 
            data-tax-incl="<?php echo esc_attr( $incl_tax  ); ?>" 
            data-ticket-fee="<?php echo esc_attr( $ticket_fee ); ?>" 
            data-ticket-fee-type="<?php echo esc_attr( $type_ticket_fee ); ?>" 
            data-currency-settings="<?php echo esc_attr( $currency_settings ); ?>"
        />
        <div class="cart-content">
            <?php do_action( 'mbc_seat_description' ); ?>
            <?php do_action( 'mbc_seat_map' ); ?>
        </div>
        <div class="cart-sidebar">
            <?php do_action( 'mbc_seat_info' ); ?>
            <?php do_action( 'mbc_seat_discount' ); ?>
            <?php do_action( 'mbc_seat_checkout' ); ?>
        </div>
    </article>
<?php endif; ?>