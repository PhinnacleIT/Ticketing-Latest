<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

?>

<div class="mb-export-tickets wrap">
    <div class="mb-heading">
        <h2 class="header"><?php esc_html_e( 'Export Tickets', 'moviebooking' ); ?></h2>
    </div>
    <div class="export-form">
        <form class="export-tickets" enctype="multipart/form-data" method="post">
            <input type="hidden" name="ticket_action" value="export">
            <h2 class="title"><?php esc_html_e( 'Export tickets to CSV file', 'moviebooking' ); ?></h2>
            <div class="export-fields">
                <label><strong><?php esc_html_e('Choose fields to export', 'moviebooking'); ?></strong></label>
                <div class="fields">
                    <label class="container"><?php esc_html_e( 'Ticket Number', 'moviebooking' ); ?>
                        <input type="checkbox" name="check_fields[]" value="id" checked />
                        <span class="checkmark"></span>
                    </label>
                    <label class="container"><?php esc_html_e( 'Booking ID', 'moviebooking' ); ?>
                        <input type="checkbox" name="check_fields[]" value="booking_id" checked />
                        <span class="checkmark"></span>
                    </label>
                    <label class="container"><?php esc_html_e( 'Movie ID', 'moviebooking' ); ?>
                        <input type="checkbox" name="check_fields[]" value="movie_id" />
                        <span class="checkmark"></span>
                    </label>
                    <label class="container"><?php esc_html_e( 'Movie', 'moviebooking' ); ?>
                        <input type="checkbox" name="check_fields[]" value="movie_name" checked />
                        <span class="checkmark"></span>
                    </label>
                    <label class="container"><?php esc_html_e( 'Date', 'moviebooking' ); ?>
                        <input type="checkbox" name="check_fields[]" value="date" checked />
                        <span class="checkmark"></span>
                    </label>
                    <label class="container"><?php esc_html_e( 'Seat', 'moviebooking' ); ?>
                        <input type="checkbox" name="check_fields[]" value="seat" checked />
                        <span class="checkmark"></span>
                    </label>
                    <label class="container"><?php esc_html_e( 'QR code', 'moviebooking' ); ?>
                        <input type="checkbox" name="check_fields[]" value="code" checked />
                        <span class="checkmark"></span>
                    </label>
                    <label class="container"><?php esc_html_e( 'Room ID', 'moviebooking' ); ?>
                        <input type="checkbox" name="check_fields[]" value="room_id" />
                        <span class="checkmark"></span>
                    </label>
                    <label class="container"><?php esc_html_e( 'Room', 'moviebooking' ); ?>
                        <input type="checkbox" name="check_fields[]" value="room_name" checked />
                        <span class="checkmark"></span>
                    </label>
                    <label class="container"><?php esc_html_e( 'City ID', 'moviebooking' ); ?>
                        <input type="checkbox" name="check_fields[]" value="city_id" />
                        <span class="checkmark"></span>
                    </label>
                    <label class="container"><?php esc_html_e( 'City', 'moviebooking' ); ?>
                        <input type="checkbox" name="check_fields[]" value="city_name" checked />
                        <span class="checkmark"></span>
                    </label>
                    <label class="container"><?php esc_html_e( 'Venue ID', 'moviebooking' ); ?>
                        <input type="checkbox" name="check_fields[]" value="venue_id" />
                        <span class="checkmark"></span>
                    </label>
                    <label class="container"><?php esc_html_e( 'Venue', 'moviebooking' ); ?>
                        <input type="checkbox" name="check_fields[]" value="venue_name" checked />
                        <span class="checkmark"></span>
                    </label>
                    <label class="container"><?php esc_html_e( 'Address', 'moviebooking' ); ?>
                        <input type="checkbox" name="check_fields[]" value="address" checked />
                        <span class="checkmark"></span>
                    </label>
                    <label class="container"><?php esc_html_e( 'Customer Name', 'moviebooking' ); ?>
                        <input type="checkbox" name="check_fields[]" value="customer_name" checked />
                        <span class="checkmark"></span>
                    </label>
                    <label class="container"><?php esc_html_e( 'Customer Email', 'moviebooking' ); ?>
                        <input type="checkbox" name="check_fields[]" value="customer_email" checked />
                        <span class="checkmark"></span>
                    </label>
                    <label class="container"><?php esc_html_e( 'Customer Phone', 'moviebooking' ); ?>
                        <input type="checkbox" name="check_fields[]" value="customer_phone" checked />
                        <span class="checkmark"></span>
                    </label>
                    <label class="container"><?php esc_html_e( 'Customer Address', 'moviebooking' ); ?>
                        <input type="checkbox" name="check_fields[]" value="customer_address" checked />
                        <span class="checkmark"></span>
                    </label>
                    <label class="container"><?php esc_html_e( 'Ticket Status', 'moviebooking' ); ?>
                        <input type="checkbox" name="check_fields[]" value="ticket_status" checked />
                        <span class="checkmark"></span>
                    </label>
                </div>
            </div>
            <div class="filter-export mb-showtimes-filter">
                <select name="ticket_status" id="ticket_status">
                    <option value=""><?php esc_html_e( 'Choose status', 'moviebooking' ); ?></option>
                    <option value="publish"><?php esc_html_e( 'Publish', 'moviebooking' ); ?></option>
                    <option value="pending"><?php esc_html_e( 'Pending', 'moviebooking' ); ?></option>
                    <option value="draft"><?php esc_html_e( 'Draft', 'moviebooking' ); ?></option>
                </select>
                <?php echo mb_dropdown_movies(); ?>
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
                <select name="ticket_order" id="ticket_order">
                    <option value=""><?php esc_html_e( 'Choose order', 'moviebooking' ); ?></option>
                    <option value="ASC"><?php esc_html_e( 'Ascending', 'moviebooking' ); ?></option>
                    <option value="DESC"><?php esc_html_e( 'Descending', 'moviebooking' ); ?></option>
                </select>
                <select name="ticket_orderby" id="ticket_orderby">
                    <option value=""><?php esc_html_e( 'Choose orderby', 'moviebooking' ); ?></option>
                    <option value="showtime_date"><?php esc_html_e( 'Showtime Date', 'moviebooking' ); ?></option>
                    <option value="ID"><?php esc_html_e( 'ID', 'moviebooking' ); ?></option>
                    <option value="date"><?php esc_html_e( 'Date', 'moviebooking' ); ?></option>
                    <option value="rand"><?php esc_html_e( 'Random', 'moviebooking' ); ?></option>
                </select>
            </div>
            <div class="export-tickets-submit">
                <button type="submit" class="button">
                    <?php esc_html_e( 'Export', 'moviebooking' ); ?>
                </button>
            </div>
        </form>
    </div>
</div>