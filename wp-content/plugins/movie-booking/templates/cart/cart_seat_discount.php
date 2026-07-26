<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

$cookie_sid         = isset( $_COOKIE['sid'] ) ? $_COOKIE['sid'] : '';
$showtime_id        = isset( $_GET['sid'] ) ? $_GET['sid'] : $cookie_sid;
$movie_id           = MB_Movie()->get_id_by_showtime( $showtime_id );
$enable_discount    = MB()->options->tax_fee->get( 'enable_discount', 'yes' );

?>

<?php if ( $enable_discount === 'yes' ): ?>
    <div class="cart-discount">
        <a class="cart-discount-btn" href="javascript:void(0)"><?php esc_html_e( 'Enter Discount Code', 'moviebooking' ); ?></a>
        <div class="form-discount">
            <div class="input-discount-code">
                <input 
                    type="text" 
                    class="discount-code" 
                    placeholder="<?php esc_html_e( 'DISCOUNT CODE', 'moviebooking' ); ?>" />
                <i class="dashicons-before dashicons-update-alt"></i>
            </div>
            <button data-movie-id="<?php echo esc_attr( $movie_id ); ?>" class="cart-discount-submit-code">
                <?php esc_html_e( 'Apply', 'moviebooking' ); ?>
            </button>
            <i class="fas fa-times" id="cart-discount-close"></i>
            <p class="error"><?php esc_html_e( 'Invalid Discount Code', 'moviebooking' ); ?></p>
        </div>
    </div>
<?php endif; ?>