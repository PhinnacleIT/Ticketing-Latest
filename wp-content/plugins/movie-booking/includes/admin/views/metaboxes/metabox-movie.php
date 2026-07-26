<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

global $post;

$movie_id = get_the_ID();

$coupons        = $this->get_mb_value( 'coupons' );
$date_format    = MBC()->mb_get_date_time_format();

?>

<div class="mb_movie_metabox">
    <div class="mb_movie_coupons">
        <h2 class="title"><?php esc_html_e( 'Coupons', 'moviebooking' ); ?></h2>
        <div class="coupons">
            <?php if ( ! empty( $coupons ) && is_array( $coupons ) ):
                foreach ( $coupons as $k => $coupon ):
            ?>
                    <div class="coupons_item">
                        <div class="ova_row">
                            <label>
                                <strong><?php esc_html_e( 'Coupon Code', 'moviebooking' ); ?></strong>
                            </label>
                            <input 
                                type="text" 
                                class="coupon_code" 
                                name="<?php echo esc_attr( $this->get_mb_name( 'coupons' ) ).'['.$k.']'.'[code]'; ?>" 
                                value="<?php echo esc_attr( $coupon['code'] ); ?>" 
                                placeholder="<?php esc_attr_e( 'No Coupon Code' ); ?>" 
                                autocomplete="off" 
                                autocorrect="off" 
                                autocapitalize="none" />
                        </div>
                        <div class="ova_row">
                            <label>
                                <strong><?php esc_html_e( 'Start', 'moviebooking' ); ?></strong>
                            </label>
                            <input 
                                type="text" 
                                class="coupon_start mb_datepicker" 
                                name="<?php echo esc_attr( $this->get_mb_name( 'coupons' ) ).'['.$k.']'.'[start]'; ?>" 
                                value="<?php echo $coupon['start'] ? esc_attr( date( $date_format, $coupon['start'] ) ) : ''; ?>" 
                                placeholder="<?php echo esc_attr( $date_format ); ?>" 
                                autocomplete="off" 
                                autocorrect="off" 
                                autocapitalize="none" 
                                onfocus="blur();" />
                        </div>
                        <div class="ova_row">
                            <label>
                                <strong><?php esc_html_e( 'End', 'moviebooking' ); ?></strong>
                            </label>
                            <input 
                                type="text" 
                                class="coupon_end mb_datepicker" 
                                name="<?php echo esc_attr( $this->get_mb_name( 'coupons' ) ).'['.$k.']'.'[end]'; ?>" 
                                value="<?php echo $coupon['end'] ? esc_attr( date( $date_format, $coupon['end'] ) ) : ''; ?>" 
                                placeholder="<?php echo esc_attr( $date_format ); ?>" 
                                autocomplete="off" 
                                autocorrect="off" 
                                autocapitalize="none" 
                                onfocus="blur();" />
                        </div>
                        <div class="ova_row">
                            <label>
                                <strong><?php esc_html_e( 'Type', 'moviebooking' ); ?></strong>
                            </label>
                            <select name="<?php echo esc_attr( $this->get_mb_name( 'coupons' ) ).'['.$k.']'.'[type]'; ?>" class="coupon_type">
                                <?php $type = $coupon['type']; ?>
                                <?php if ( $type === 'amount' ): ?>
                                    <option value="percent"><?php esc_html_e( 'Percentage(%)', 'moviebooking' ); ?></option>
                                    <option value="amount" selected><?php esc_html_e( 'Fixed amount(n)', 'moviebooking' ); ?></option>
                                <?php else: ?>
                                    <option value="percent" selected><?php esc_html_e( 'Percentage(%)', 'moviebooking' ); ?></option>
                                    <option value="amount"><?php esc_html_e( 'Fixed amount(n)', 'moviebooking' ); ?></option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="ova_row">
                            <label>
                                <strong><?php esc_html_e( 'Percentage(%)', 'moviebooking' ); ?></strong>
                            </label>
                            <input 
                                type="text" 
                                class="coupon_percent" 
                                name="<?php echo esc_attr( $this->get_mb_name( 'coupons' ) ).'['.$k.']'.'[percent]'; ?>" 
                                value="<?php echo esc_attr( $coupon['percent'] ); ?>" 
                                placeholder="<?php esc_html_e( '10', 'moviebooking' ); ?>" 
                                autocomplete="off" 
                                autocorrect="off" 
                                autocapitalize="none" />
                        </div>
                        <div class="ova_row">
                            <label>
                                <strong><?php esc_html_e( 'Fixed amount(n)', 'moviebooking' ); ?></strong>
                            </label>
                            <input 
                                type="text" 
                                class="coupon_amount" 
                                name="<?php echo esc_attr( $this->get_mb_name( 'coupons' ) ).'['.$k.']'.'[amount]'; ?>" 
                                value="<?php echo esc_attr( $coupon['amount'] ); ?>" 
                                placeholder="<?php esc_html_e( '10', 'moviebooking' ); ?>" 
                                autocomplete="off" 
                                autocorrect="off" 
                                autocapitalize="none" />
                        </div>
                        <div class="ova_row">
                            <label>
                                <strong><?php esc_html_e( 'Quantity', 'moviebooking' ); ?></strong>
                            </label>
                            <input 
                                type="number" 
                                class="coupon_quantity" 
                                name="<?php echo esc_attr( $this->get_mb_name( 'coupons' ) ).'['.$k.']'.'[quantity]'; ?>" 
                                value="<?php echo esc_attr( $coupon['quantity'] ); ?>" 
                                placeholder="<?php esc_html_e( '10', 'moviebooking' ); ?>" 
                                autocomplete="off" 
                                autocorrect="off" 
                                autocapitalize="none" />
                        </div>
                        <a href="javascript:void(0)" class="btn remove_coupon">
                            <i class="dashicons-before dashicons-no-alt"></i>
                        </a>
                    </div>
            <?php endforeach; endif; ?>
        </div>
        <input 
            type="hidden" 
            id="mb_datetimepicker_config"
            class="mb_datetimepicker_config"
            data-language="<?php echo esc_attr( MBC()->mb_get_language() ); ?>" 
            data-first-day="<?php echo esc_attr( MBC()->mb_get_first_day() ); ?>" 
            data-date-format="<?php echo esc_attr( MBC()->mb_get_date_format() ); ?>" 
            data-time-format="<?php echo esc_attr( MBC()->mb_get_time_format() ); ?>" 
            data-time-step="<?php echo esc_attr( MBC()->mb_get_time_step() ); ?>" 
            data-time-default="<?php echo esc_attr( MBC()->mb_get_time_default() ); ?>" />
        <div class="btn_add_coupon">
            <button class="button add_coupon"><?php esc_html_e( 'Add Coupon', 'moviebooking' ); ?></button>
            <div class="mb-loading" style="display: none;">
                <i class="dashicons-before dashicons-update-alt"></i>
            </div>
        </div>
    </div>
</div>