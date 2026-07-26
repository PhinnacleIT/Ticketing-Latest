<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

global $post;

$booking_id     = get_the_ID();
$status         = get_post_status( $booking_id );
$showtime_id    = $this->get_mb_value( 'showtime_id' );
$movie_id       = $this->get_mb_value( 'movie_id' );
$date           = $this->get_mb_value( 'date' );
$date_format    = MBC()->mb_get_date_time_format();

// Get Movies
$movies = MB_Movie()->get_all_movie();

// Get Showtimes
$showtimes = MB_Showtime()->get_any_showtime( $movie_id );

// Get Room
$rooms = get_post_meta( $showtime_id, MB_PLUGIN_PREFIX_SHOWTIME.'room_ids', true );

// Status
$status_booking = $this->get_mb_value( 'status' );

// Seat
$seat_booked    = $this->get_mb_value( 'seat' );
$area_booked    = $this->get_mb_value( 'area' );
$room_id        = $this->get_mb_value( 'room_id' );
$seats          = MB_Room()->get_data_seat( $room_id  );
$areas          = get_post_meta( $room_id, MB_PLUGIN_PREFIX_ROOM.'areas', true );

$data_person_type = get_post_meta( $room_id, MB_PLUGIN_PREFIX_ROOM.'person_type', true );
$data_person_type = ! empty( $data_person_type ) ? $data_person_type : array();
$data_extra_service = mb_booking_get_extra_service_remaining( $room_id );
// Address
$customer_address = $this->get_mb_value( 'customer_address' );

if ( ! $customer_address ) {
    $order_id = $this->get_mb_value( 'order_id' );

    if ( $order_id ) {
        $order              = wc_get_order( $order_id );
        $customer_address   = $order->get_address();
    }
}

$address    = isset( $customer_address['address_1'] ) ? $customer_address['address_1'] : '';
$first_name = isset( $customer_address['first_name'] ) ? $customer_address['first_name'] : '';
$last_name  = isset( $customer_address['last_name'] ) ? $customer_address['last_name'] : '';
$email      = isset( $customer_address['email'] ) ? $customer_address['email'] : '';
$phone      = isset( $customer_address['phone'] ) ? $customer_address['phone'] : '';

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

// Currency
$currency_settings = MB_Cart()->get_cart_currency_settings();
// End Currency

// Current
$booking_seat           = $this->get_mb_value( 'seat' );
$booking_area           = $this->get_mb_value( 'area' );
$booking_person_type    = $this->get_mb_value( 'person_type', '' );
$booking_subtotal       = $this->get_mb_value( 'subtotal' );
$booking_discount       = $this->get_mb_value( 'discount' );
$booking_discount_code  = $this->get_mb_value( 'discount_code' );
$booking_discount_value = $this->get_mb_value( 'discount_value' );
$booking_discount_type  = $this->get_mb_value( 'discount_type' );
$booking_tax            = $this->get_mb_value( 'tax' );
$booking_ticket_fee     = $this->get_mb_value( 'ticket_fee' );
$booking_total          = $this->get_mb_value( 'total' );
$booking_incl_tax       = $this->get_mb_value( 'incl_tax' );
$booking_cart           = $this->get_mb_value( 'cart' );
$booking_tax_type       = $this->get_mb_value( 'tax_type', '' );
$booking_tax_fee        = $this->get_mb_value( 'tax_fee', '' );
$booking_extra_service  = $this->get_mb_value( 'extra_service', array() );

// Get subtotal
$total_seat = 0;
$total_area = [];
$total_person_type = [];

if ( mb_array_exists( $booking_cart ) ) {
    foreach ( $booking_cart as $cart_item ) {
        if ( isset( $cart_item['qty'] ) && absint( $cart_item['qty'] ) ) {
            if ( isset( $cart_item['data_person'] ) ) {
                foreach ( $cart_item['data_person'] as $val ) {
                    $price = (float)$val['price'] * absint( $val['qty'] );
                    $total_person_type[$cart_item['id']][] = array( 'id' => $val['id'], 'price' => $price );
                }
            }
            $total_area[$cart_item['id']] = (float)( $cart_item['price'] ) * absint( $cart_item['qty'] );

        } else {
            $total_seat += (float)$cart_item['price'];
        }
    }
}


?>
<div class="mb_booking_detail">
    <input type="hidden" name="post-status" value="<?php echo esc_attr( $status ); ?>" />
    <div class="ova_row">
        <label>
            <strong><?php esc_html_e( 'Booking ID:', 'moviebooking' ); ?></strong>
            <?php echo '#'.$booking_id; ?>
        </label>
        <br><br>
    </div>
    <div class="ova_row mb-error">
        <span class="mesg"></span>
        <br><br>
    </div>
    <div class="ova_row mb_movies">
        <label>
            <strong><?php esc_html_e( 'Movie*:', 'moviebooking' ); ?></strong>
            <select name="<?php echo $this->get_mb_name('movie_id'); ?>" class="movide_id mb_select2" data-placeholder="<?php esc_attr_e( 'Choose movie', 'moviebooking' ); ?>" required>
                <option value=""></option>
                <?php foreach( $movies as $value ): ?>
                    <option value="<?php echo esc_attr( $value ); ?>" <?php echo selected( $value, $movie_id ); ?>>
                        <?php echo get_the_title( $value ); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>
        <br><br>
    </div>
    <div class="ova_row mb_showtimes">
        <label>
            <strong><?php esc_html_e( 'Showtime*:', 'moviebooking' ); ?></strong>
            <select name="<?php echo $this->get_mb_name('date'); ?>" class="showtimes mb_select2" data-placeholder="<?php esc_attr_e( 'Choose time', 'moviebooking' ); ?>" required>
                <?php if ( mb_array_exists( $showtimes ) ): ?>
                    <?php foreach( $showtimes as $st_id ):
                        $showtime_date = get_post_meta( $st_id, MB_PLUGIN_PREFIX_SHOWTIME.'date', true );
                    ?>
                        <option value="<?php echo esc_attr( $showtime_date ); ?>" data-showtime-id="<?php echo esc_attr( $st_id ); ?>" <?php echo selected( $showtime_date, $date ); ?>>
                            <?php echo esc_html( date( $date_format, $showtime_date ) ); ?>
                        </option>
                <?php endforeach; endif; ?>
            </select>
            <input 
                type="hidden" 
                name="<?php echo esc_attr( $this->get_mb_name( 'showtime_id' ) ); ?>" 
                value="<?php echo $this->get_mb_value( 'showtime_id' ) ? esc_attr( $this->get_mb_value( 'showtime_id' ) ) : ''; ?>" />
            <div class="mb-loading">
                <i class="dashicons-before dashicons-update-alt"></i>
            </div>
        </label>
        <br><br>
    </div>
    <div class="ova_row mb_rooms">
        <label>
            <strong><?php esc_html_e( 'Room*:', 'moviebooking' ); ?></strong>
            <select name="<?php echo $this->get_mb_name('room_id'); ?>" class="rooms mb_select2" data-placeholder="<?php esc_html_e( 'Choose room', 'moviebooking' ); ?>" required>
                <?php if ( mb_array_exists( $rooms ) ): ?>
                    <?php foreach( $rooms as $r_id ):
                        $r_title = get_the_title( $r_id );
                    ?>
                        <option value="<?php echo esc_attr( $r_id ); ?>" <?php echo selected( $r_id, $room_id ); ?>>
                            <?php echo esc_html( $r_title ); ?>
                        </option>
                <?php endforeach; endif; ?>
            </select>
            <div class="mb-loading">
                <i class="dashicons-before dashicons-update-alt"></i>
            </div>
        </label>
        <br><br>
    </div>
    <div class="ova_row mb_status">
        <label>
            <strong><?php esc_html_e( 'Status:', 'moviebooking' ); ?></strong>
            <select name="<?php echo $this->get_mb_name('status'); ?>" class="status mb_select2" data-placeholder="<?php esc_html_e( 'Choose status', 'moviebooking' ); ?>" required>
                <option value="Completed" <?php selected( 'Completed', $status_booking ); ?>>
                    <?php esc_html_e( 'Completed', 'moviebooking' ); ?>
                </option>
                <option value="Pending" <?php selected( 'Pending', $status_booking ); ?>>
                    <?php esc_html_e( 'Pending', 'moviebooking' ); ?>
                </option>
                <option value="Canceled" <?php selected( 'Canceled', $status_booking ); ?>>
                    <?php esc_html_e( 'Canceled', 'moviebooking' ); ?>
                </option>
                <option value="Expired" <?php selected( 'Expired', $status_booking ); ?>>
                    <?php esc_html_e( 'Expired', 'moviebooking' ); ?>
                </option>
            </select>
        </label>
        <br><br>
    </div>
    <div class="ova_row mb_seats">
        <label>
            <strong><?php esc_html_e( 'Seats*:', 'moviebooking' ); ?></strong>
        </label>
        <div class="seats" data-error="<?php echo esc_attr( 'Seat or Area is required.', 'moviebooking' ); ?>">
            <?php if ( mb_array_exists( $seats ) ): ?>
                <?php foreach ( $seats as $k => $seat_item ):
                    $checked = '';

                    if ( mb_array_exists( $seat_booked ) && in_array( $seat_item['id'] , $seat_booked ) ) {
                        $checked = ' checked="checked"';
                    }
                ?>
                    <label class="mb-checkbox">
                        <input 
                            type="checkbox" 
                            class="seat" 
                            name="<?php echo $this->get_mb_name('seats').'['.$k.'][id]'; ?>" 
                            value="<?php echo esc_attr( $seat_item['id'] ); ?>"<?php echo esc_html( $checked ); ?> 
                            data-price="<?php echo esc_attr( $seat_item['price'] ); ?>" />
                        <input
                            type="hidden"
                            name="<?php echo esc_attr( 'mb_booking_seats_price['.$seat_item['id'].']' ); ?>"
                            value="<?php echo esc_attr( $seat_item['price'] ); ?>"
                        />
                        <span class="checkmark"></span>
                        <?php echo esc_html( $seat_item['id'] ); ?>
                    </label>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="mb-loading">
            <i class="dashicons-before dashicons-update-alt"></i>
        </div>
        <br><br>
    </div>
    <div class="ova_row mb_areas">
        <label>
            <strong><?php esc_html_e( 'Areas*:', 'moviebooking' ); ?></strong>
        </label>
        <div class="areas">
            <?php if ( mb_array_exists( $areas ) ): ?>
                <?php foreach ( $areas as $k => $area_item ):
                    $checked = '';
                    $person_price = isset( $area_item['person_price'] ) ? $area_item['person_price'] : array();
                    if ( mb_array_exists( $area_booked ) && array_key_exists( $area_item['id'] , $area_booked ) ) {
                        $checked = ' checked="checked"';
                    }
                ?>
                    <label class="mb-checkbox">
                        <input
                            type="checkbox"
                            class="area"
                            name="<?php echo $this->get_mb_name('areas').'['.$k.'][id]'; ?>"
                            value="<?php echo esc_attr( $area_item['id'] ); ?>"
                            data-id="<?php echo esc_attr( $area_item['id'] ); ?>"
                            data-price="<?php echo esc_attr( $area_item['price'] ); ?>"
                            data-qty="<?php echo esc_attr( $area_item['qty'] ); ?>"
                            <?php echo esc_html( $checked ); ?>
                        />
                        <input
                            type="hidden"
                            name="<?php echo esc_attr( 'mb_booking_areas_price['.$area_item['id'].']' ); ?>"
                            value="<?php echo esc_attr( $area_item['price'] ); ?>"
                        />
                        <?php if ( ! empty( $person_price ) ): ?>

                            <input type="hidden"
                                data-area="<?php echo esc_attr( $area_item['id'] ); ?>"
                                class="person_price"
                                value="<?php echo esc_attr( json_encode( $person_price ) ); ?>"
                            />

                        <?php endif; ?>
                        <span class="checkmark"></span>
                        <?php echo esc_html( $area_item['id'] ); ?>
                    </label>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="mb-loading">
            <i class="dashicons-before dashicons-update-alt"></i>
        </div>
        <br><br>
    </div>
    <div class="ova_row mb_customer_first_name">
        <label>
            <strong><?php esc_html_e( 'First name*:', 'moviebooking' ); ?></strong>
        </label>
        <input 
            type="text" 
            class="customer_first_name" 
            name="customer_first_name" 
            value="<?php echo esc_attr( $first_name ); ?>" 
            placeholder="<?php esc_attr_e( 'First name', 'moviebooking' ); ?>" 
            autocomplete="off" 
            autocorrect="off" 
            autocapitalize="none" 
            required />
        <br><br>
    </div>
    <div class="ova_row mb_customer_last_name">
        <label>
            <strong><?php esc_html_e( 'Last name*:', 'moviebooking' ); ?></strong>
        </label>
        <input 
            type="text" 
            class="customer_last_name" 
            name="customer_last_name" 
            value="<?php echo esc_attr( $last_name ); ?>" 
            placeholder="<?php esc_attr_e( 'Last name', 'moviebooking' ); ?>" 
            autocomplete="off" 
            autocorrect="off" 
            autocapitalize="none" 
            required />
        <br><br>
    </div>
    <div class="ova_row mb_customer_email">
        <label>
            <strong><?php esc_html_e( 'Email*:', 'moviebooking' ); ?></strong>
        </label>
        <input 
            type="email" 
            class="customer_email" 
            name="<?php echo esc_attr( $this->get_mb_name( 'customer_email' ) ); ?>" 
            value="<?php echo esc_attr( $email ); ?>" 
            placeholder="<?php esc_attr_e( 'Customer email', 'moviebooking' ); ?>" 
            autocomplete="off" 
            autocorrect="off" 
            autocapitalize="none" 
            required />
        <br><br>
    </div>
    <div class="ova_row mb_customer_phone">
        <label>
            <strong><?php esc_html_e( 'Phone*:', 'moviebooking' ); ?></strong>
        </label>
        <input 
            type="text" 
            class="customer_phone" 
            name="<?php echo esc_attr( $this->get_mb_name( 'customer_phone' ) ); ?>" 
            value="<?php echo esc_attr( $phone ); ?>" 
            placeholder="<?php esc_attr_e( 'Customer phone', 'moviebooking' ); ?>" 
            autocomplete="off" 
            autocorrect="off" 
            autocapitalize="none" 
            required />
        <br><br>
    </div>
    <div class="ova_row mb_customer_address">
        <label>
            <strong><?php esc_html_e( 'Address*:', 'moviebooking' ); ?></strong>
        </label>
        <input 
            type="text" 
            class="customer_address" 
            name="<?php echo esc_attr( $this->get_mb_name( 'address' ) ); ?>" 
            value="<?php echo esc_attr( $address ); ?>" 
            placeholder="<?php esc_attr_e( 'Customer address', 'moviebooking' ); ?>" 
            autocomplete="off" 
            autocorrect="off" 
            autocapitalize="none" 
            required />
        <br><br>
    </div>
    <div class="ova_row mb_cart">
        <label>
            <strong><?php esc_html_e( 'Cart:', 'moviebooking' ); ?></strong>
        </label>
        <div class="cart-detail">
            <div class="cart-info">
                <div class="cart-header">
                    <span><?php esc_html_e( 'Seat', 'moviebooking' ); ?></span>
                    <span><?php esc_html_e( 'Price', 'moviebooking' ); ?></span>
                </div>
                <div class="cart-error">
                    <?php esc_html_e( 'Please Select Your Seat or Area', 'moviebooking' ); ?>
                </div>
                <div class="cart-item">
                    <div class="seat">
                        <?php if ( mb_array_exists( $booking_seat ) ): ?>
                            <?php foreach ( $booking_seat as $seat ): ?>
                                <span><?php echo esc_html( $seat ); ?></span>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <div class="subtotal mb-price"><?php echo wc_price( mb_get_price_incl_tax( $total_seat, $booking_tax_type, $booking_tax_fee )  ); ?></div>
                    <input 
                        type="hidden" 
                        name="<?php echo esc_attr( $this->get_mb_name( 'qty' ) ); ?>" 
                        value="<?php echo $this->get_mb_value( 'qty' ) ? esc_attr( $this->get_mb_value( 'qty' ) ) : ''; ?>" />
                    <input 
                        type="hidden" 
                        name="<?php echo esc_attr( $this->get_mb_name( 'subtotal' ) ); ?>" 
                        value="<?php echo $this->get_mb_value( 'subtotal' ) ? esc_attr( $this->get_mb_value( 'subtotal' ) ) : ''; ?>" />
                </div>
                <div class="cart-area-item">
                    <?php if ( mb_array_exists( $booking_area ) ): ?>

                        <?php if ( ! empty( $booking_person_type ) ) {
                            foreach ( $booking_person_type as $area_id => $data_person ) {
                                $area_price = 0;
                                foreach ( $total_person_type[$area_id] as $key => $value ) {
                                    $area_price += (float)$value['price'];
                                }
                                
                                $area_qty = isset( $booking_area[$area_id] ) ? absint( $booking_area[$area_id] ) : 0;
                                ?>
                                <div class="area-item" data-area-id="<?php echo esc_attr( $area_id ); ?>" data-area-price="<?php echo esc_attr( $area_price ); ?>" data-area-qty="<?php echo esc_attr( $area_qty ); ?>">
                                    <div class="area-item-wrap">
                                        <div class="area-id">
                                            <span><?php echo esc_html( $area_id ); ?></span>
                                        </div>
                                    </div>
                                    <ul class="person_type_wrap">
                                        <?php if ( ! empty( $data_person ) ): ?>
                                            <?php foreach ( $data_person as $key => $value ):
                                                $person_id = isset( $value['id'] ) ? $value['id'] : '';
                                                $qty = isset( $value['qty'] ) ? absint( $value['qty'] ) : 0;
                                                $price = isset( $value['price'] ) ? (float)$value['price'] : 0;
                                                $subtotal = $price * $qty;
                                                ?>
                                                <li class="person_type_item">
                                                    <div class="person_type"
                                                        data-key="<?php echo esc_attr( $key ); ?>"
                                                        data-id="<?php echo esc_attr( $person_id ); ?>"
                                                        data-qty="<?php echo esc_attr( $qty ); ?>"
                                                    data-price="<?php echo esc_attr( $subtotal ); ?>">
                                                    <?php echo esc_html( $person_id ); ?>
                                                    </div>
                                                    <div class="person_qty_wrap">
                                                        <span class="person_minus"><span class="dashicons dashicons-minus"></span></span>
                                                        <span class="person_qty"><?php echo esc_html( $qty ); ?></span>
                                                        <span class="person_plus"><span class="dashicons dashicons-plus-alt2"></span></span>
                                                    </div>
                                                    <input
                                                        type="hidden"
                                                        class="person_id_booking"
                                                        data-key="<?php echo esc_attr( $key ); ?>"
                                                        name="<?php echo esc_attr( $this->get_mb_name( 'person_type' ).'['.$area_id.']'.'['.$key.'][id]' ); ?>"
                                                        value="<?php echo esc_attr( $person_id ); ?>"
                                                    />
                                                    <input
                                                        type="hidden"
                                                        class="person_price_booking"
                                                        data-key="<?php echo esc_attr( $key ); ?>"
                                                        name="<?php echo esc_attr( $this->get_mb_name( 'person_type' ).'['.$area_id.']'.'['.$key.'][price]' ); ?>"
                                                        value="<?php echo esc_attr( $price ); ?>"
                                                    />
                                                    <input
                                                        type="hidden"
                                                        class="person_qty_booking"
                                                        data-key="<?php echo esc_attr( $key ); ?>"
                                                        name="<?php echo esc_attr( $this->get_mb_name( 'person_type' ).'['.$area_id.']'.'['.$key.'][qty]' ); ?>"
                                                        value="<?php echo esc_attr( $qty ); ?>"
                                                    />
                                                    <div class="person_price"><?php echo wc_price( mb_get_price_incl_tax( $subtotal, $booking_tax_type, $booking_tax_fee ) ); ?></div>
                                                </li>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                        
                                    </ul>
                                    <input 
                                        type="hidden"
                                        class="area_qty_booking"
                                        name="<?php echo esc_attr( $this->get_mb_name( 'area_qty' ).'['.$area_id.']' ); ?>"
                                        value="<?php echo esc_attr( $area_qty ); ?>"
                                    />
                                </div>
                                <?php
                            }
                            
                        } else {
                            foreach ( $booking_area as $area_id => $area_qty ):
                            $area_price = isset( $total_area[$area_id] ) ? (float)( $total_area[$area_id] ) : 0;
                        ?>
                            <div class="area-item" data-area-id="<?php echo esc_attr( $area_id ); ?>" data-area-price="<?php echo esc_attr( $area_price ); ?>" data-area-qty="<?php echo esc_attr( $area_qty ); ?>">
                                <div class="area-item-wrap">
                                    <div class="area-id">
                                        <span><?php echo esc_html( $area_id ); ?></span>
                                    </div>
                                    <div class="area-qty">
                                        <span class="area-minus">
                                            <span class="dashicons dashicons-minus"></span>
                                        </span>
                                        <span class="qty"><?php echo esc_html( $area_qty ); ?></span>
                                        <input 
                                            type="hidden"
                                            class="area_qty_booking"
                                            name="<?php echo esc_attr( $this->get_mb_name( 'area_qty' ).'['.$area_id.']' ); ?>" 
                                            value="<?php echo esc_attr( $area_qty ); ?>"
                                        />
                                        <span class="area-plus">
                                            <span class="dashicons dashicons-plus-alt2"></span>
                                        </span>
                                    </div>
                                    <div class="subtotal mb-price"><?php echo wc_price( mb_get_price_incl_tax( $area_price, $booking_tax_type, $booking_tax_fee ) ); ?></div>
                                </div>
                            </div>
                        <?php
                            endforeach;
                            }
                        ?>

                    <?php endif; ?>
                </div>
                <ul class="extra-services" data-total="0">
                    <?php foreach ( $booking_extra_service as $seat_id => $extra_item ):
                        $name_item = isset( $extra_item['name'] ) ? $extra_item['name'] : '';
                        $person_names = mb_booking_get_person_type_name( $booking_person_type, $seat_id );

                        if ( empty( $name_item ) ) {
                            if ( is_array( $extra_item ) && count( $extra_item ) > 0 ) {
                                foreach ($extra_item as $key => $items ) {
                                    $name_item = isset( $items['name'] ) ? $items['name'] : '';
                                    if ( empty( $name_item ) ) {
                                        foreach ( $items as $k => $item ) {
                                            $class_border = $k == 0 ? 'border_color' : '';
                                            $person_name = isset( $person_names[0] ) ? $person_names[0] : '';
                                            
                                            ?>
                                            <li class="extra-item <?php echo esc_attr( $class_border ); ?>"
                                            data-seat="<?php echo esc_attr( $seat_id ); ?>"
                                            data-map="area"
                                            data-index="<?php echo esc_attr( $key ); ?>"
                                            data-subtotal="<?php echo esc_attr( (float)$item['price'] * absint( $item['qty'] ) ); ?>"
                                            data-rest="<?php echo esc_attr( $item['rest_qty'] ); ?>"
                                            data-price="<?php echo esc_attr( $item['price'] ); ?>"
                                            data-qty="<?php echo esc_attr( $item['qty'] ); ?>"
                                            data-max="<?php echo esc_attr( $item['max_qty'] ); ?>"
                                            data-name="<?php echo esc_attr( $item['name'] ); ?>"
                                            data-key="<?php echo esc_attr( $k ); ?>">
                                                <?php if ( $k == 0 ): ?>
                                                    <span class="count_item"><?php echo sprintf( esc_html__( '%1$s - %2$s Ticket #%3$s', 'moviebooking' ), $seat_id , $person_name ,$key + 1 ); ?></span>
                                                <?php array_splice($person_names, 0, 1); endif;
                                                
                                                ?>
                                                <span class="name"><?php echo esc_html( $item['name'] ); ?></span>
                                                <span class="qty">
                                                    <span class="service-minus"><span class="dashicons dashicons-minus"></span></span>
                                                    <span class="service-qty"><?php echo esc_html( $item['qty'] ); ?></span>
                                                    <span class="service-plus"><span class="dashicons dashicons-plus-alt2"></span></span>
                                                </span>
                                                <span class="price"><?php echo wc_price( mb_get_price_incl_tax( (float)$item['price'] * absint( $item['qty'] ) , $booking_tax_type, $booking_tax_fee ) ); ?></span>

                                                <input type="hidden"
                                                class="extra_service_name_booking"
                                                name="<?php echo esc_attr( $this->get_mb_name('extra_service').'['.$seat_id.']['.$key.']['.$k.'][name]' ); ?>"
                                                value="<?php echo esc_attr( $item['name'] ); ?>">

                                                <input type="hidden"
                                                class="extra_service_price_booking"
                                                name="<?php echo esc_attr( $this->get_mb_name('extra_service').'['.$seat_id.']['.$key.']['.$k.'][price]' ); ?>"
                                                value="<?php echo esc_attr( $item['price'] ); ?>">

                                                <input type="hidden"
                                                class="extra_service_qty_booking"
                                                name="<?php echo esc_attr( $this->get_mb_name('extra_service').'['.$seat_id.']['.$key.']['.$k.'][qty]' ); ?>"
                                                value="<?php echo esc_attr( $item['qty'] ); ?>">

                                                <input type="hidden"
                                                class="extra_service_rest_qty_booking"
                                                name="<?php echo esc_attr( $this->get_mb_name('extra_service').'['.$seat_id.']['.$key.']['.$k.'][rest_qty]' ); ?>"
                                                value="<?php echo esc_attr( $item['rest_qty'] ); ?>">

                                                <input type="hidden"
                                                class="extra_service_max_qty_booking"
                                                name="<?php echo esc_attr( $this->get_mb_name('extra_service').'['.$seat_id.']['.$key.']['.$k.'][max_qty]' ); ?>"
                                                value="<?php echo esc_attr( $item['max_qty'] ); ?>">
                                            </li>
                                            <?php
                               
                                        }
                                    } else {
                                        $class_border = $key == 0 ? 'border_color' : '';
                                        ?>
                                        <li class="extra-item <?php echo esc_attr( $class_border ); ?>"
                                        data-seat="<?php echo esc_attr( $seat_id ); ?>"
                                        data-map="area"
                                        data-index="<?php echo esc_attr( $key ); ?>"
                                        data-subtotal="<?php echo esc_attr( (float)$items['price'] * absint( $items['qty'] ) ); ?>"
                                        data-rest="<?php echo esc_attr( $items['rest_qty'] ); ?>"
                                        data-price="<?php echo esc_attr( $items['price'] ); ?>"
                                        data-qty="<?php echo esc_attr( $items['qty'] ); ?>"
                                        data-max="<?php echo esc_attr( $items['max_qty'] ); ?>"
                                        data-name="<?php echo esc_attr( $items['name'] ); ?>">
                                            <?php if ( $key == 0 ): ?>
                                                <span class="count_item"><?php echo sprintf( esc_html__( 'Ticket #%s', 'moviebooking' ), $seat_id ); ?></span>
                                            <?php endif; ?>
                                            <span class="name"><?php echo esc_html( $items['name'] ); ?></span>
                                            <span class="qty">
                                                <span class="service-minus"><span class="dashicons dashicons-minus"></span></span>
                                                <span class="service-qty"><?php echo esc_html( $items['qty'] ); ?></span>
                                                <span class="service-plus"><span class="dashicons dashicons-plus-alt2"></span></span>
                                            </span>
                                            <span class="price"><?php echo wc_price( mb_get_price_incl_tax( (float)$items['price'] * absint( $items['qty'] ) , $booking_tax_type, $booking_tax_fee ) ); ?></span>

                                            <input type="hidden"
                                            class="extra_service_name_booking"
                                            name="<?php echo esc_attr( $this->get_mb_name('extra_service').'['.$seat_id.']['.$key.'][name]' ); ?>"
                                            value="<?php echo esc_attr( $items['name'] ); ?>">

                                            <input type="hidden"
                                            class="extra_service_price_booking"
                                            name="<?php echo esc_attr( $this->get_mb_name('extra_service').'['.$seat_id.']['.$key.'][price]' ); ?>"
                                            value="<?php echo esc_attr( $items['price'] ); ?>">

                                            <input type="hidden"
                                            class="extra_service_qty_booking"
                                            name="<?php echo esc_attr( $this->get_mb_name('extra_service').'['.$seat_id.']['.$key.'][qty]' ); ?>"
                                            value="<?php echo esc_attr( $items['qty'] ); ?>">

                                            <input type="hidden"
                                            class="extra_service_rest_qty_booking"
                                            name="<?php echo esc_attr( $this->get_mb_name('extra_service').'['.$seat_id.']['.$key.'][rest_qty]' ); ?>"
                                            value="<?php echo esc_attr( $items['rest_qty'] ); ?>">

                                            <input type="hidden"
                                            class="extra_service_max_qty_booking"
                                            name="<?php echo esc_attr( $this->get_mb_name('extra_service').'['.$seat_id.']['.$key.'][max_qty]' ); ?>"
                                            value="<?php echo esc_attr( $items['max_qty'] ); ?>">
                                        </li>
                                        <?php
                                    }
                                }
                            }
                        } else {

                            ?>
                            <li class="extra-item border_color"
                            data-seat="<?php echo esc_attr( $seat_id ); ?>"
                            data-map="seat"
                            data-index="0"
                            data-subtotal="0"
                            data-rest="0"
                            data-price="5"
                            data-qty="0"
                            data-max="10"
                            data-name="CoCa"
                            data-key="0">
                                <span class="count_item"><?php echo sprintf( esc_html__( 'Ticket #%s', 'moviebooking' ), $seat_id ); ?></span>
                                <span class="name"><?php echo esc_html( $name_item ); ?></span>
                                <span class="qty">
                                    <span class="service-minus"><i aria-hidden="true" class="flaticon-minus"></i></span>
                                    <span class="service-qty"><?php echo esc_html( $extra_item['qty'] ); ?></span>
                                    <span class="service-plus"><i aria-hidden="true" class="flaticon-plus"></i></span>
                                </span>
                                <span class="price">$0.00</span>
                            </li>
                            <?php
                        }
                        endforeach;?>
                </ul>
                <div class="cart-fee total-discount">
                    <p class="text"><?php esc_html_e( 'Discount', 'moviebooking' ); ?></p>
                    <p class="dicount-number mb-price"><?php echo '-'.wc_price( $booking_discount ); ?></p>
                    <input
                        type="hidden"
                        name="<?php echo esc_attr( $this->get_mb_name( 'discount' ) ); ?>"
                        value="<?php echo esc_attr( $booking_discount ); ?>"
                    />
                    <input
                        type="hidden"
                        name="<?php echo esc_attr( $this->get_mb_name( 'discount_value' ) ); ?>"
                        value="<?php echo esc_attr( $booking_discount_value ); ?>"
                    />
                    <input
                        type="hidden"
                        name="<?php echo esc_attr( $this->get_mb_name( 'discount_code' ) ); ?>"
                        value="<?php echo esc_attr( $booking_discount_code ); ?>"
                    />
                    <input
                        type="hidden"
                        name="<?php echo esc_attr( $this->get_mb_name( 'discount_type' ) ); ?>"
                        value="<?php echo esc_attr( $booking_discount_type ); ?>"
                    />
                </div>
                <div class="cart-fee total-tax">
                    <p class="text"><?php esc_html_e( 'Tax', 'moviebooking' ); ?></p>
                    <p class="tax-number mb-price"><?php echo wc_price( $booking_tax ); ?></p>
                    <input 
                        type="hidden" 
                        name="<?php echo esc_attr( $this->get_mb_name( 'tax' ) ); ?>" 
                        value="<?php echo $this->get_mb_value( 'tax' ) ? esc_attr( $this->get_mb_value( 'tax' ) ) : ''; ?>" />
                    <input 
                        type="hidden" 
                        name="<?php echo esc_attr( $this->get_mb_name( 'incl_tax' ) ); ?>" 
                        value="<?php echo $booking_incl_tax; ?>" />

                    <input type="hidden" name="<?php echo esc_attr( $this->get_mb_name( 'tax_type' ) ); ?>" value="<?php echo esc_attr( $booking_tax_type ); ?>">

                    <input type="hidden" name="<?php echo esc_attr( $this->get_mb_name( 'tax_fee' ) ); ?>" value="<?php echo esc_attr( $booking_tax_fee ); ?>">

                </div>
                <div class="cart-fee total-ticket-fee">
                    <p class="text"><?php esc_html_e( 'Ticket Fee', 'moviebooking' ); ?></p>
                    <p class="ticket-fee-number mb-price"><?php echo wc_price( $booking_ticket_fee ); ?></p>
                    <input 
                        type="hidden" 
                        name="<?php echo esc_attr( $this->get_mb_name( 'ticket_fee' ) ); ?>" 
                        value="<?php echo $this->get_mb_value( 'ticket_fee' ) ? esc_attr( $this->get_mb_value( 'ticket_fee' ) ) : ''; ?>" />
                </div>
                <div class="cart-fee cart-total">
                    <p class="text"><?php esc_html_e( 'Total', 'moviebooking' ); ?></p>
                    <p class="total-number mb-price"><?php echo wc_price( $booking_total ); ?></p>
                    <input 
                        type="hidden" 
                        name="<?php echo esc_attr( $this->get_mb_name( 'total' ) ); ?>" 
                        value="<?php echo $this->get_mb_value( 'total' ) ? esc_attr( $this->get_mb_value( 'total' ) ) : ''; ?>" />
                </div>
            </div>
            <div class="cart-discount">
                <div class="cart-input-discount">
                    <input 
                        type="text" 
                        class="discount_code" 
                        name="add_discount_code" 
                        value="<?php echo esc_attr( $booking_discount_code ); ?>" 
                        placeholder="<?php esc_attr_e( 'Discount code', 'moviebooking' ); ?>" 
                        autocomplete="off" 
                        autocorrect="off" 
                        autocapitalize="none" />
                    <div class="mb-loading">
                        <i class="dashicons-before dashicons-update-alt"></i>
                    </div>
                </div>
                <button class="submit-discount"><?php esc_html_e( 'Apply', 'moviebooking' ); ?></button>
            </div>
            <div class="mb-error mb-error-discount">
                <span class="mesg"><?php esc_html_e( 'Invalid Discount Code', 'moviebooking' ); ?></span>
            </div>
            <input 
                type="hidden" 
                id="cart-data" 
                name="cart-data" 
                data-sid="<?php echo esc_attr( $showtime_id ); ?>" 
                data-rid="<?php echo esc_attr( $room_id ); ?>"
                data-tax-fee="<?php echo esc_attr( $tax_fee ); ?>" 
                data-person-type="<?php echo esc_attr( json_encode( $data_person_type ) ); ?>"
                data-extra-service="<?php echo esc_attr( json_encode( $data_extra_service ) ); ?>"
                data-extra-item-prefix="<?php esc_attr_e( 'Ticket #', 'moviebooking' ); ?>"
                data-tax-type="<?php echo esc_attr( $tax_type ); ?>" 
                data-tax-incl="<?php echo esc_attr( $incl_tax  ); ?>" 
                data-ticket-fee="<?php echo esc_attr( $ticket_fee ); ?>" 
                data-ticket-fee-type="<?php echo esc_attr( $type_ticket_fee ); ?>" 
                data-currency-settings="<?php echo esc_attr( $currency_settings ); ?>" />
        </div>
        <br><br>
    </div>
    <div class="ova_row mb_create_ticket">
        <label>
            <strong></strong>
        </label>
        <a href="javascript:void(0)" class="create-ticket" data-booking-id="<?php echo esc_attr( $booking_id ); ?>">
            <?php esc_html_e( 'Create and send tickets', 'moviebooking' ); ?>
        </a>
        <div class="mb-loading">
            <i class="dashicons-before dashicons-update-alt"></i>
        </div>
        <span class="msg"></span>
    </div>
</div>