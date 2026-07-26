<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

global $post;

$ticket_id  = get_the_ID();
$ticket_url = get_edit_post_link( $ticket_id ) ? get_edit_post_link( $ticket_id ) : '#';

// Booking
$booking_id     = $this->get_mb_value( 'booking_id' );
$booking_url    = get_edit_post_link( $booking_id ) ? get_edit_post_link( $booking_id ) :'#';

// Movie
$movie_id       = $this->get_mb_value( 'movie_id' );
$movie_title    = get_the_title( $movie_id );
$movie_url      = get_edit_post_link( $movie_id ) ? get_edit_post_link( $movie_id ) : '#';

// Showtimes
$date           = $this->get_mb_value( 'date' );
$date_format    = MBC()->mb_get_date_time_format();
$showtime_id    = get_post_meta( $booking_id, MB_PLUGIN_PREFIX_BOOKING.'showtime_id', true );
$showtime_html  = '';

if ( $showtime_id ) {
    $showtime_url   = get_edit_post_link( $showtime_id ) ? get_edit_post_link( $showtime_id ) : '#';
    $showtime_html  = '<a href="'.esc_url( $showtime_url ).'" target="_blank"><strong>'.date( $date_format, $date ).'</strong></a>';
} else {
    $showtime_html = '<strong>'.date( $date_format, $date ).'</strong>';
}

// Room
$room_id    = $this->get_mb_value( 'room_id' );
$room_html  = '';

if ( $room_id ) {
    $room_url   = get_edit_post_link( $room_id ) ? get_edit_post_link( $room_id ) : '#';
    $room_html  = '<a href="'.esc_url( $room_url ).'" target="_blank"><strong>'.get_the_title( $room_id ).'</strong></a>';
}

// Address
$address = $this->get_mb_value( 'address' );

// QR code
$qr_code = $this->get_mb_value( 'qr_code' );

// Status
$status = $this->get_mb_value( 'ticket_status' );

$seat = $this->get_mb_value( 'seat' );

$person_type = $this->get_mb_value( 'person_type', '' );
$extra_service = $this->get_mb_value( 'extra_service', '' );

if ( ! empty( $person_type ) ) {
    $seat .= ' - '.$person_type;
}

?>

<div class="mb_ticket_detail">
    <div class="ova_row">
        <label>
            <strong><?php esc_html_e( 'Ticket Number:', 'moviebooking' ); ?></strong>
            <?php printf( _x( '%s', 'ticket link', 'moviebooking' ), '<a href="'.esc_url( $ticket_url ).'" target="_blank">#'.esc_html( $ticket_id ).'</a>' ); ?>
        </label>
        <br><br>
    </div>
    <div class="ova_row">
        <label>
            <strong><?php esc_html_e( 'Booking ID:', 'moviebooking' ); ?></strong>
            <?php printf( _x( '%s', 'booking link', 'moviebooking' ), '<a href="'.esc_url( $booking_url ).'" target="_blank">#'.esc_html( $booking_id ).'</a>' ); ?>
        </label>
        <br><br>
    </div>
    <div class="ova_row">
        <label>
            <strong><?php esc_html_e( 'Movie:', 'moviebooking' ); ?></strong>
            <?php printf( _x( '%s', 'movie link', 'moviebooking' ), '<a href="'.esc_url( $movie_url ).'" target="_blank">'.esc_html( $movie_title ).'</a>' ); ?>
        </label>
        <br><br>
    </div>
    <div class="ova_row">
        <label>
            <strong><?php esc_html_e( 'Showtimes:', 'moviebooking' ); ?></strong>
            <?php printf( _x( '%s', 'showtime link', 'moviebooking' ), $showtime_html ); ?>
        </label>
        <br><br>
    </div>
    <div class="ova_row">
        <label>
            <strong><?php esc_html_e( 'Room:', 'moviebooking' ); ?></strong>
            <?php printf( _x( '%s', 'room link', 'moviebooking' ), $room_html ); ?>
        </label>
        <br><br>
    </div>
    <div class="ova_row">
        <label>
            <strong><?php esc_html_e( 'Seat:', 'moviebooking' ); ?></strong>
            <?php echo esc_html( $seat ); ?>
        </label>
        <br><br>
    </div>
    <?php if ( ! empty( $extra_service ) ): ?>
        <div class="ova_row">
            <label>
                <strong><?php esc_html_e( 'Extra Service:', 'moviebooking' ); ?></strong>
                <?php echo esc_html( implode(', ', mb_ticket_get_extra_service( $extra_service ) ) ); ?>
            </label>
            <br><br>
        </div>
    <?php endif; ?>
    <div class="ova_row">
        <label>
            <strong><?php esc_html_e( 'QR code:', 'moviebooking' ); ?></strong>
            <?php echo esc_html( $qr_code ); ?>
        </label>
        <br><br>
    </div>
    <div class="ova_row">
        <label>
            <strong><?php esc_html_e( 'Address', 'moviebooking' ); ?></strong>
        </label>
        <?php echo esc_html( $this->get_mb_value( 'address' ) ); ?>
        <br><br>
    </div>
    <div class="ova_row">
        <label>
            <strong><?php esc_html_e( 'Customer Name', 'moviebooking' ); ?></strong>
        </label>
        <input 
            type="text" 
            class="customer_name" 
            name="<?php echo esc_attr( $this->get_mb_name( 'customer_name' ) ); ?>" 
            value="<?php echo $this->get_mb_value( 'customer_name' ) ? esc_attr( $this->get_mb_value( 'customer_name' ) ) : ''; ?>" 
            placeholder="<?php esc_attr_e( 'Customer Name', 'moviebooking' ); ?>" 
            autocomplete="off" 
            autocorrect="off" 
            autocapitalize="none" />
        <br><br>
    </div>
    <div class="ova_row">
        <label>
            <strong><?php esc_html_e( 'Customer Email', 'moviebooking' ); ?></strong>
        </label>
        <input 
            type="text" 
            class="customer_email" 
            name="<?php echo esc_attr( $this->get_mb_name( 'customer_email' ) ); ?>" 
            value="<?php echo $this->get_mb_value( 'customer_email' ) ? esc_attr( $this->get_mb_value( 'customer_email' ) ) : ''; ?>" 
            placeholder="<?php esc_attr_e( 'Customer Email', 'moviebooking' ); ?>" 
            autocomplete="off" 
            autocorrect="off" 
            autocapitalize="none" />
        <br><br>
    </div>
    <div class="ova_row">
        <label>
            <strong><?php esc_html_e( 'Customer Phone', 'moviebooking' ); ?></strong>
        </label>
        <input 
            type="text" 
            class="customer_phone" 
            name="<?php echo esc_attr( $this->get_mb_name( 'customer_phone' ) ); ?>" 
            value="<?php echo $this->get_mb_value( 'customer_phone' ) ? esc_attr( $this->get_mb_value( 'customer_phone' ) ) : ''; ?>" 
            placeholder="<?php esc_attr_e( 'Customer Phone', 'moviebooking' ); ?>" 
            autocomplete="off" 
            autocorrect="off" 
            autocapitalize="none" />
        <br><br>
    </div>
</div>