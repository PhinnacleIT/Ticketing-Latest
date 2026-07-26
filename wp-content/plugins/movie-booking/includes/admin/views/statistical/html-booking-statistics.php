<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

$data_booking = MB_Booking()->mb_get_total_booking();

?>

<div class="mb-booking-statistics wrap">
    <div class="mb-heading">
        <h2 class="header"><?php esc_html_e( 'Booking Statistics', 'moviebooking' ); ?></h2>
    </div>
    <div class="booking-statistics">
        <div class="filter-booking-statistics mb-showtimes-filter">
            <?php echo mb_dropdown_movies(); ?>
            <select name="booking_status" id="booking_status">
                <option value=""><?php esc_html_e( 'Choose status', 'moviebooking' ); ?></option>
                <option value="completed"><?php esc_html_e( 'Completed', 'moviebooking' ); ?></option>
                <option value="pending"><?php esc_html_e( 'Pending', 'moviebooking' ); ?></option>
            </select>
            <span class="datepicker-showtimes-filter">
                <input 
                    type="text" 
                    class="from_date mb_datepicker_filter" 
                    name="from" 
                    value="" 
                    placeholder="<?php esc_attr_e( 'From Date', 'moviebooking' ); ?>" 
                    autocomplete="off" 
                    autocorrect="off" 
                    autocapitalize="none" 
                    onfocus="blur();" />
                <a href="javascript:void(0)" class="btn remove_date" title="<?php esc_html_e( 'Clear', 'moviebooking' ); ?>">
                    <i class="dashicons-before dashicons-no-alt"></i>
                </a>
            </span>
            <span class="datepicker-showtimes-filter">
                <input 
                    type="text" 
                    class="to_date mb_datepicker_filter" 
                    name="to" 
                    value="" 
                    placeholder="<?php esc_attr_e( 'To Date', 'moviebooking' ); ?>" 
                    autocomplete="off" 
                    autocorrect="off" 
                    autocapitalize="none" 
                    onfocus="blur();" />
                <a href="javascript:void(0)" class="btn remove_date" title="<?php esc_html_e( 'Clear', 'moviebooking' ); ?>">
                    <i class="dashicons-before dashicons-no-alt"></i>
                </a>
            </span>
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
            <?php
                echo mb_dropdown_cities();
                echo mb_dropdown_venues();
                echo mb_dropdown_rooms();
            ?>
        </div>
        <div class="booking-statistics-submit">
            <button type="submit" class="button">
                <?php esc_html_e( 'Check', 'moviebooking' ); ?>
            </button>
            <div class="mb-loading">
                <i class="dashicons-before dashicons-update-alt"></i>
            </div>
        </div>
        <div class="booking-total">
            <div class="subtotal total-box">
                <label><?php esc_html_e( 'Subtotal', 'moviebooking' ); ?></label>
                <div class="price">
                    <?php echo wc_price( $data_booking['subtotal'] ); ?>
                </div>
            </div>
            <div class="discount total-box">
                <label><?php esc_html_e( 'Discount', 'moviebooking' ); ?></label>
                <div class="price">
                    <?php echo '-'.wc_price( $data_booking['discount'] ); ?>
                </div>
            </div>
            <div class="tax total-box">
                <label><?php esc_html_e( 'Tax', 'moviebooking' ); ?></label>
                <div class="price">
                    <?php echo wc_price( $data_booking['tax'] ); ?>
                </div>
            </div>
            <div class="ticket-fee total-box">
                <label><?php esc_html_e( 'Ticket Fee', 'moviebooking' ); ?></label>
                <div class="price">
                    <?php echo wc_price( $data_booking['ticket_fee'] ); ?>
                </div>
            </div>
            <div class="total total-box">
                <label><?php esc_html_e( 'Total', 'moviebooking' ); ?></label>
                <div class="price">
                    <?php echo wc_price( $data_booking['total'] ); ?>
                </div>
            </div>
        </div>
    </div>
</div>