<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

?>

<div class="cart-checkout" id="mb-btn-checkout">
    <div class="submit-load-more">
        <div class="load-more">
            <div class="lds-spinner">
                <div></div><div></div><div></div><div></div><div></div><div></div>
                <div></div><div></div><div></div><div></div><div></div><div></div>
            </div>
        </div>
    </div>
    <input 
        type="hidden" 
        name="mb_checkout_nonce" 
        id="mb_checkout_nonce" 
        value="<?php echo wp_create_nonce( apply_filters( 'mb_checkout_nonce', 'mb_checkout_nonce' ) ); ?>"
    />
    <input 
        type="hidden" 
        name="login-required" 
        value="<?php echo esc_url( home_url('/') ); ?> "
    />
    <a id="btn-checkout" href="javascript:void(0)">
        <?php esc_html_e( 'Proceed to checkout', 'moviebooking' ); ?>
    </a>
</div>
<span class="cart-error"><?php esc_html_e( 'Please select seat', 'moviebooking' ); ?></span>
<div class="message-error">
    <a class="mb-auto-reload" onclick='window.location.reload(true);' href="javascript:void(0)"></a>
</div>