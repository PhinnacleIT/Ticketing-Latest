<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MB_Admin_Ajax' ) ) {

    class MB_Admin_Ajax {
        
        public function __construct() {
            $this->init();
        }

        public function init() {
            // Define All Ajax function
            $args_ajax =  array(
                'mb_add_seat_map',
                'mb_add_area_map',
                'mb_change_city',
                'mb_add_coupon',
                'mb_date_showtimes_filter',
                'mb_city_showtimes_filter',
                'mb_add_booking_select_movie',
                'mb_add_booking_change_date',
                'mb_add_booking_change_room',
                'mb_add_booking_check_coupon',
                'mb_create_send_tickets',
                'mb_booking_statistics',
                'mb_add_person_type',
                'mb_add_person_price',
                'mb_add_services',
            );

            foreach( $args_ajax as $name ) {
                add_action( 'wp_ajax_'.$name, array( $this, $name ) );
                add_action( 'wp_ajax_nopriv_'.$name, array( $this, $name ) );
            }
        }

        // Add Seat Map
        public function mb_add_seat_map() {
            if ( ! isset( $_POST['data'] ) ) wp_die();
            $data = $_POST['data'];

            $ajax_nonce = isset( $data['ajax_nonce'] ) ? sanitize_text_field( $data['ajax_nonce'] ) : '';

            if ( ! wp_verify_nonce( $ajax_nonce , apply_filters( 'mb_admin_ajax_security', 'ajax_nonce_mb' ) ) ) wp_die();

            $k          = isset( $data['count_seat'] ) ? absint( sanitize_text_field( $data['count_seat'] ) ) : 0;
            $prefix     = MB_PLUGIN_PREFIX_ROOM;
            $currency   = MBC()->mb_get_currency();

            ?>
                <div class="item-seat">
                    <div class="seat-id-field item-seat-field">
                        <label><?php esc_html_e( 'Seat*', 'moviebooking' ); ?></label>
                        <input 
                            type="text" 
                            class="seat-map-id" 
                            value="" 
                            placeholder="<?php echo esc_attr( 'A1, A2, A3, ...', 'moviebooking' ); ?>" 
                            name="<?php echo esc_attr( $prefix ).'seats['.$k.']'.'[id]'; ?>" 
                            autocomplete="off" 
                            autocorrect="off" 
                            autocapitalize="none" 
                            required />
                    </div>
                    <div class="seat-price-field item-seat-field">
                        <label><?php printf( esc_html__( 'Price(%s)*', 'moviebooking' ), $currency ); ?></label>
                        <input 
                            type="text" 
                            class="seat-map-price" 
                            value="" 
                            placeholder="<?php esc_attr_e( '10', 'moviebooking' ); ?>" 
                            name="<?php echo esc_attr( $prefix ).'seats['.$k.']'.'[price]'; ?>" 
                            autocomplete="off" 
                            autocorrect="off" 
                            autocapitalize="none" 
                            required />
                    </div>
                    <div class="seat-type-field item-seat-field">
                        <label><?php esc_html_e( 'Type', 'moviebooking' ); ?></label></label>
                        <input 
                            type="text" 
                            class="seat-map-type" 
                            value="" 
                            placeholder="<?php esc_attr_e( 'Standard', 'moviebooking' ); ?>" 
                            name="<?php echo esc_attr( $prefix ).'seats['.$k.']'.'[type]'; ?>" 
                            autocomplete="off" 
                            autocorrect="off" 
                            autocapitalize="none" />
                    </div>
                    <div class="item-seat-field seat-description-field">
                        <label><?php esc_html_e( 'Description', 'moviebooking' ); ?></label></label>
                        <input 
                            type="text" 
                            class="seat-map-description" 
                            value="" 
                            placeholder="<?php esc_attr_e( 'Description of type seat', 'moviebooking' ); ?>" 
                            name="<?php echo esc_attr( $prefix ).'seats['.$k.']'.'[description]'; ?>" 
                            autocomplete="off" 
                            autocorrect="off" 
                            autocapitalize="none" />
                    </div>
                    <div class="seat-color-field item-seat-field">
                        <label><?php esc_html_e( 'Color', 'moviebooking' ); ?></label></label>
                        <input 
                            type="text" 
                            class="seat-map-color mb-colorpicker" 
                            value="" 
                            name="<?php echo esc_attr( $prefix ).'seats['.$k.']'.'[color]'; ?>" 
                            autocomplete="off" 
                            autocorrect="off" 
                            autocapitalize="none" />
                    </div>
                    <a href="javascript:void(0)" class="btn remove_seat_map">
                        <i class="dashicons-before dashicons-no-alt"></i>
                    </a>
                </div>
            <?php
            wp_die();
        }

        // Add Seat Map
        public function mb_add_area_map() {
            if ( ! isset( $_POST['data'] ) ) wp_die();
            $data = $_POST['data'];

            $ajax_nonce = isset( $data['ajax_nonce'] ) ? sanitize_text_field( $data['ajax_nonce'] ) : '';
            $person_names = isset( $data['person_names'] ) ? MovieBooking_Core::instance()->recursive_sanitize_text_field( $data['person_names'] ) : array();
            if ( ! wp_verify_nonce( $ajax_nonce , apply_filters( 'mb_admin_ajax_security', 'ajax_nonce_mb' ) ) ) wp_die();

            $k          = isset( $data['count_area'] ) ? absint( sanitize_text_field( $data['count_area'] ) ) : 0;
            $prefix     = MB_PLUGIN_PREFIX_ROOM;
            $currency   = MBC()->mb_get_currency();
            $price_default = empty( $person_names ) ? '' : '0';
            ?>
                <div class="item-area">
                    <div class="area-id-field item-area-field">
                        <label><?php esc_html_e( 'Area*', 'moviebooking' ); ?></label>
                        <input 
                            type="text" 
                            class="area-map-id" 
                            value="" 
                            placeholder="<?php esc_attr_e( 'Insert only an area', 'moviebooking' ); ?>" 
                            name="<?php echo esc_attr( $prefix ).'areas['.$k.']'.'[id]'; ?>" 
                            autocomplete="off" 
                            autocorrect="off" 
                            autocapitalize="none" 
                            required />
                    </div>
                    <?php if ( ! empty( $person_names ) ): ?>
                        <?php foreach ( $person_names as $key => $name ): ?>
                            <div class="area-person-price-field item-area-field">
                                <label><?php printf( esc_html__( '%1$s(%2$s)*', 'moviebooking' ), $name ,MBC()->mb_get_currency() ); ?></label>
                                <input 
                                    type="text" 
                                    class="area-map-person-price" 
                                    value="" 
                                    placeholder="<?php esc_attr_e( '10', 'moviebooking' ); ?>" 
                                    name="<?php echo esc_attr( $prefix.'areas['.$k.']'.'[person_price]'.'['.$key.']'); ?>" 
                                    autocomplete="off" 
                                    autocorrect="off" 
                                    autocapitalize="none" 
                                    required />
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <div class="area-price-field item-area-field">
                        <label><?php printf( esc_html__( 'Price(%s)*', 'moviebooking' ), $currency ); ?></label>
                        <input 
                            type="text" 
                            class="area-map-price" 
                            value="<?php echo esc_attr( $price_default ); ?>" 
                            placeholder="<?php esc_attr_e( '10', 'moviebooking' ); ?>" 
                            name="<?php echo esc_attr( $prefix ).'areas['.$k.']'.'[price]'; ?>" 
                            autocomplete="off" 
                            autocorrect="off" 
                            autocapitalize="none" 
                            required />
                    </div>
                    <div class="area-qty-field item-area-field">
                        <label><?php esc_html_e( 'Quantity*', 'moviebooking' ); ?></label>
                        <input 
                            type="number" 
                            class="area-map-qty" 
                            value="" 
                            placeholder="<?php esc_attr_e( '100', 'moviebooking' ); ?>" 
                            name="<?php echo esc_attr( $prefix ).'areas['.$k.']'.'[qty]'; ?>"
                            min="0"
                            autocomplete="off" 
                            autocorrect="off" 
                            autocapitalize="none" 
                            required />
                    </div>
                    <div class="area-type-field item-area-field">
                        <label><?php esc_html_e( 'Type', 'moviebooking' ); ?></label></label>
                        <input 
                            type="text" 
                            class="area-map-type" 
                            value="" 
                            placeholder="<?php esc_attr_e( 'Standard', 'moviebooking' ); ?>" 
                            name="<?php echo esc_attr( $prefix ).'areas['.$k.']'.'[type]'; ?>" 
                            autocomplete="off" 
                            autocorrect="off" 
                            autocapitalize="none" />
                    </div>
                    <div class="item-area-field area-description-field">
                        <label><?php esc_html_e( 'Description', 'moviebooking' ); ?></label></label>
                        <input 
                            type="text" 
                            class="area-map-description" 
                            value="" 
                            placeholder="<?php esc_attr_e( 'Description of type area', 'moviebooking' ); ?>" 
                            name="<?php echo esc_attr( $prefix ).'areas['.$k.']'.'[description]'; ?>" 
                            autocomplete="off" 
                            autocorrect="off" 
                            autocapitalize="none" />
                    </div>
                    <div class="area-color-field item-area-field">
                        <label><?php esc_html_e( 'Color', 'moviebooking' ); ?></label></label>
                        <input 
                            type="text" 
                            class="area-map-color mb-colorpicker" 
                            value="" 
                            name="<?php echo esc_attr( $prefix ).'areas['.$k.']'.'[color]'; ?>" 
                            autocomplete="off" 
                            autocorrect="off" 
                            autocapitalize="none" />
                    </div>
                    <a href="javascript:void(0)" class="btn remove_area_map">
                        <i class="dashicons-before dashicons-no-alt"></i>
                    </a>
                </div>
            <?php
            wp_die();
        }

        // Change City
        public function mb_change_city() {
            if ( ! isset( $_POST['data'] ) ) wp_die();
            $data = $_POST['data'];

            $ajax_nonce = isset( $data['ajax_nonce'] ) ? sanitize_text_field( $data['ajax_nonce'] ) : '';

            if ( ! wp_verify_nonce( $ajax_nonce , apply_filters( 'mb_admin_ajax_security', 'ajax_nonce_mb' ) ) ) wp_die();

            $city_id    = isset( $data['city_id'] ) ? absint( sanitize_text_field( $data['city_id'] ) ) : 0;
            $prefix     = MB_PLUGIN_PREFIX_SHOWTIME;

            if ( $city_id ) {
                $venue = MBC()->mb_get_taxonomies( 'movie_location', array(), array(), 'all', 0, $city_id );

                if ( ! empty( $venue ) && is_array( $venue ) ) {
                    ?>
                    <select name="<?php echo esc_attr( $prefix ).'venue_id'; ?>" class="showtime_city_id mb_select2" data-placeholder="<?php echo esc_html__( 'Choose venue', 'moviebooking' ); ?>" required>
                        <?php foreach( $venue as $venue_item ): ?>
                            <option value="<?php echo esc_attr( $venue_item->term_id ); ?>">
                                <?php echo esc_html( $venue_item->name ); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php
                } else {
                    ?>
                    <select name="<?php echo esc_attr( $prefix ).'venue_id'; ?>" class="showtime_city_id mb_select2" data-placeholder="<?php esc_html_e( 'Not found Venue', 'moviebooking' ); ?>" required>
                    </select>
                    <?php
                }
            } else {
                ?>
                <select name="<?php echo esc_attr( $prefix ).'venue_id'; ?>" class="showtime_city_id mb_select2" data-placeholder="<?php esc_html_e( 'Not found Venue', 'moviebooking' ); ?>" required>
                </select>
                <?php
            }

            wp_die();
        }

        // Add Coupon
        public function mb_add_coupon() {
            if ( ! isset( $_POST['data'] ) ) wp_die();
            $data = $_POST['data'];

            $ajax_nonce = isset( $data['ajax_nonce'] ) ? sanitize_text_field( $data['ajax_nonce'] ) : '';

            if ( ! wp_verify_nonce( $ajax_nonce , apply_filters( 'mb_admin_ajax_security', 'ajax_nonce_mb' ) ) ) wp_die();

            $k      = isset( $data['count_seat'] ) ? absint( sanitize_text_field( $data['count_seat'] ) ) : 0;
            $prefix = MB_PLUGIN_PREFIX_MOVIE;
            $date_format = MBC()->mb_get_date_time_format();
            ?>
                <div class="coupons_item">
                    <div class="ova_row">
                        <label>
                            <strong><?php esc_html_e( 'Coupon Code', 'moviebooking' ); ?></strong>
                        </label>
                        <input 
                            type="text" 
                            class="coupon_code" 
                            name="<?php echo esc_attr( $prefix ).'coupons['.$k.']'.'[code]'; ?>" 
                            value="" 
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
                            name="<?php echo esc_attr( $prefix ).'coupons['.$k.']'.'[start]'; ?>" 
                            value="" 
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
                            name="<?php echo esc_attr( $prefix ).'coupons['.$k.']'.'[end]'; ?>" 
                            value="" 
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
                        <select name="<?php echo esc_attr( $prefix ).'coupons['.$k.']'.'[type]'; ?>" class="coupon_type">
                            <option value="percent" selected><?php esc_html_e( 'Percentage(%)', 'moviebooking' ); ?></option>
                            <option value="amount"><?php esc_html_e( 'Fixed amount(n)', 'moviebooking' ); ?></option>
                        </select>
                    </div>
                    <div class="ova_row">
                        <label>
                            <strong><?php esc_html_e( 'Percentage(%)', 'moviebooking' ); ?></strong>
                        </label>
                        <input 
                            type="text" 
                            class="coupon_percent" 
                            name="<?php echo esc_attr( $prefix ).'coupons['.$k.']'.'[percent]'; ?>" 
                            value="" 
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
                            name="<?php echo esc_attr( $prefix ).'coupons['.$k.']'.'[amount]'; ?>" 
                            value="" 
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
                            name="<?php echo esc_attr( $prefix ).'coupons['.$k.']'.'[quantity]'; ?>" 
                            value="" 
                            placeholder="<?php esc_html_e( '10', 'moviebooking' ); ?>" 
                            autocomplete="off" 
                            autocorrect="off" 
                            autocapitalize="none" />
                    </div>
                    <a href="javascript:void(0)" class="btn remove_coupon">
                        <i class="dashicons-before dashicons-no-alt"></i>
                    </a>
                </div>
            <?php
            wp_die();
        }

        // Showtimes Filter
        public function mb_date_showtimes_filter() {
            if ( ! isset( $_POST['data'] ) ) wp_die();
            $data = $_POST['data'];

            $ajax_nonce = isset( $data['ajax_nonce'] ) ? sanitize_text_field( $data['ajax_nonce'] ) : '';

            if ( ! wp_verify_nonce( $ajax_nonce , apply_filters( 'mb_admin_ajax_security', 'ajax_nonce_mb' ) ) ) wp_die();

            $date_format    = MBC()->mb_get_date_time_format();
            $from           = isset( $data['from'] ) ? strtotime( $data['from'] ) : 0;

            if ( $from ) {
                $to = date_i18n( $date_format, $from + 24*60*60 );

                echo $to;
            }

            wp_die();
        }

        public function mb_city_showtimes_filter() {
            if ( ! isset( $_POST['data'] ) ) wp_die();
            $data = $_POST['data'];

            $ajax_nonce = isset( $data['ajax_nonce'] ) ? sanitize_text_field( $data['ajax_nonce'] ) : '';

            if ( ! wp_verify_nonce( $ajax_nonce , apply_filters( 'mb_admin_ajax_security', 'ajax_nonce_mb' ) ) ) wp_die();

            $city_id    = isset( $data['city_id'] ) ? absint( sanitize_text_field( $data['city_id'] ) ) : 0;
            $venue_id   = isset( $_GET['venue_id'] ) ? $_GET['venue_id'] : 0;

            ob_start();

            if ( $city_id ) {
                $venues = MBC()->mb_get_taxonomies( 'movie_location', array(), array(), 'all', 0, $city_id );

                if ( ! empty( $venues ) && is_array( $venues ) ) {
                    ?>
                    <option value="0" selected><?php esc_html_e( 'All venues', 'moviebooking' ); ?></option>
                    <?php foreach ( $venues as $venue_item ): ?>
                        <option value="<?php echo esc_attr( $venue_item->term_id ); ?>" <?php selected( $venue_item->term_id, $venue_id ); ?>>
                            <?php echo esc_html( $venue_item->name ); ?>
                        </option>
                    <?php endforeach; ?>
                    <?php
                } else {
                    ?>
                    <option value="0" selected><?php esc_html_e( 'All venues', 'moviebooking' ); ?></option>
                    <?php
                }
            } else {
                ?>
                <option value="0" selected><?php esc_html_e( 'All venues', 'moviebooking' ); ?></option>
                <?php
            }

            $options = ob_get_contents();
            ob_end_clean();

            echo $options;

            wp_die();
        }

        // Select Movie
        public function mb_add_booking_select_movie() {
            if ( ! isset( $_POST['data'] ) ) wp_die();
            $data = $_POST['data'];

            $ajax_nonce = isset( $data['ajax_nonce'] ) ? sanitize_text_field( $data['ajax_nonce'] ) : '';

            if ( ! wp_verify_nonce( $ajax_nonce , apply_filters( 'mb_admin_ajax_security', 'ajax_nonce_mb' ) ) ) wp_die();

            $movie_id       = isset( $data['movie_id'] ) ? absint( sanitize_text_field( $data['movie_id'] ) ) : 0;
            $date_format    = MBC()->mb_get_date_time_format();

            $person_type    = array();

            $extra_service = array();

            if ( $movie_id ) {
                // Config
                $seats = array();
                $default_showtime_id = $default_room_id = '';

                // Get Showtimes
                $showtimes = MB_Showtime()->get_any_showtime( $movie_id );

                ob_start();
                if ( mb_array_exists( $showtimes ) ) {
                    foreach ( $showtimes as $k => $showtime_id ) {
                        if ( $k === 0 ) $default_showtime_id = $showtime_id;

                        $showtime_date = get_post_meta( $showtime_id, MB_PLUGIN_PREFIX_SHOWTIME.'date', true );
                    ?>
                        <option value="<?php echo esc_attr( $showtime_date ); ?>" data-showtime-id="<?php echo esc_attr( $showtime_id ); ?>">
                            <?php echo esc_html( date( $date_format, $showtime_date ) ); ?>
                        </option>
                    <?php }
                } else {
                    ?>
                    <option value="" data-showtime-id="">
                        <?php esc_html_e( 'No Showtime', 'moviebooking' ); ?>
                    </option>
                    <?php
                }

                $html_showtime = ob_get_contents();
                ob_end_clean();

                // Room
                ob_start();
                if ( absint( $default_showtime_id ) ) {
                    $room_ids = get_post_meta( $default_showtime_id, MB_PLUGIN_PREFIX_SHOWTIME.'room_ids', true );

                    if ( mb_array_exists( $room_ids ) ) {
                        foreach ( $room_ids as $k_r => $room_id ) {
                            if ( $k_r === 0 ) $default_room_id = $room_id;

                            $room_title = get_the_title( $room_id );
                        ?>
                            <option value="<?php echo esc_attr( $room_id ); ?>">
                                <?php echo esc_html( $room_title ); ?>
                            </option>
                        <?php }
                    }
                } else {
                    ?>
                    <option value="">
                        <?php esc_html_e( 'No Room', 'moviebooking' ); ?>
                    </option>
                    <?php
                }

                $html_room = ob_get_contents();
                ob_end_clean();

                // Seat
                ob_start();
                if ( absint( $default_room_id ) ) {
                    $seats = MB_Room()->get_data_seat( $default_room_id );

                    if ( mb_array_exists( $seats ) ) {
                        foreach ( $seats as $k => $seat_item ) {
                        ?>
                            <label class="mb-checkbox">
                                <input 
                                    type="checkbox" 
                                    class="seat" 
                                    name="<?php echo esc_attr( 'ova_mb_booking_seats'.'['.$k.'][id]' ); ?>" 
                                    value="<?php echo esc_attr( $seat_item['id'] ); ?>"  
                                    data-price="<?php echo esc_attr( $seat_item['price'] ); ?>" />
                                <input
                                    type="hidden"
                                    name="<?php echo esc_attr( 'mb_booking_seats_price['.$seat_item['id'].']' ); ?>"
                                    value="<?php echo esc_attr( $seat_item['price'] ); ?>"
                                />
                                <span class="checkmark"></span>
                                <?php echo esc_html( $seat_item['id'] ); ?>
                            </label>
                        <?php }
                    }
                } else {
                    ?>
                    <span class="no-seat"><?php esc_html_e( 'No Seat', 'moviebooking' ); ?></span>
                    <?php
                }

                $html_seat = ob_get_contents();
                ob_end_clean();

                // Area
                ob_start();
                if ( absint( $default_room_id ) ) {
                    $areas          = get_post_meta( $default_room_id, MB_PLUGIN_PREFIX_ROOM.'areas', true );
                    $person_type    = get_post_meta( $default_room_id, MB_PLUGIN_PREFIX_ROOM.'person_type', true );
                    $extra_service  = mb_booking_get_extra_service_remaining( $default_room_id );

                    if ( mb_array_exists( $areas ) ) {
                        foreach ( $areas as $k => $area_item ) {
                            $person_price = isset( $area_item['person_price'] ) ? $area_item['person_price'] : array();
                        ?>
                            <label class="mb-checkbox">
                                <input
                                    type="checkbox"
                                    class="area"
                                    name="<?php echo esc_attr( 'ova_mb_booking_areas'.'['.$k.'][id]' ); ?>"
                                    value="<?php echo esc_attr( $area_item['id'] ); ?>"
                                    data-id="<?php echo esc_attr( $area_item['id'] ); ?>"
                                    data-price="<?php echo esc_attr( $area_item['price'] ); ?>"
                                    data-qty="<?php echo esc_attr( $area_item['qty'] ); ?>"
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
                        <?php }
                    }
                } else {
                    ?>
                    <span class="no-area"><?php esc_html_e( 'No Area', 'moviebooking' ); ?></span>
                    <?php
                }

                $html_area = ob_get_contents();
                ob_end_clean();

                echo json_encode( array( 
                    'html_showtime' => $html_showtime,
                    'html_room'     => $html_room,
                    'html_seat'     => $html_seat,
                    'html_area'     => $html_area,
                    'person_type'   => $person_type,
                    'extra_service' => $extra_service,
                ));
            }

            wp_die();
        }

        // Change Date
        public function mb_add_booking_change_date() {
            if ( ! isset( $_POST['data'] ) ) wp_die();
            $data = $_POST['data'];

            $ajax_nonce = isset( $data['ajax_nonce'] ) ? sanitize_text_field( $data['ajax_nonce'] ) : '';

            if ( ! wp_verify_nonce( $ajax_nonce , apply_filters( 'mb_admin_ajax_security', 'ajax_nonce_mb' ) ) ) wp_die();

            $showtime_id = isset( $data['showtime_id'] ) ? absint( sanitize_text_field( $data['showtime_id'] ) ) : 0;

            $person_type = array();
            $extra_service = array();

            if ( absint( $showtime_id ) ) {
                // Config
                $seats = array();
                $default_room_id = '';

                // Room
                ob_start();
                $room_ids = get_post_meta( $showtime_id, MB_PLUGIN_PREFIX_SHOWTIME.'room_ids', true );

                if ( mb_array_exists( $room_ids ) ) {
                    foreach ( $room_ids as $k_r => $room_id ) {
                        if ( $k_r === 0 ) $default_room_id = $room_id;

                        $room_title = get_the_title( $room_id );
                    ?>
                        <option value="<?php echo esc_attr( $room_id ); ?>">
                            <?php echo esc_html( $room_title ); ?>
                        </option>
                    <?php }
                } else {
                    ?>
                    <option value="">
                        <?php esc_html_e( 'No Room', 'moviebooking' ); ?>
                    </option>
                    <?php
                }

                $html_room = ob_get_contents();
                ob_end_clean();

                // Seat
                ob_start();
                $seats = MB_Room()->get_data_seat( $default_room_id );

                if ( mb_array_exists( $seats ) ) {
                    foreach( $seats as $k => $seat_item ) {
                    ?>
                        <label class="mb-checkbox">
                            <input 
                                type="checkbox" 
                                class="seat" 
                                name="<?php echo esc_attr( 'ova_mb_booking_seats'.'['.$k.'][id]' ); ?>" 
                                value="<?php echo esc_attr( $seat_item['id'] ); ?>"  
                                data-price="<?php echo esc_attr( $seat_item['price'] ); ?>" />
                            <input
                                type="hidden"
                                name="<?php echo esc_attr( 'mb_booking_seats_price['.$seat_item['id'].']' ); ?>"
                                value="<?php echo esc_attr( $seat_item['price'] ); ?>"
                            />
                            <span class="checkmark"></span>
                            <?php echo esc_html( $seat_item['id'] ); ?>
                        </label>
                    <?php }
                } else {
                    ?>
                    <span class="no-seat"><?php esc_html_e( 'No Seat', 'moviebooking' ); ?></span>
                    <?php
                }

                $html_seat = ob_get_contents();
                ob_end_clean();

                // Area
                ob_start();
                if ( absint( $default_room_id ) ) {
                    $areas = get_post_meta( $default_room_id, MB_PLUGIN_PREFIX_ROOM.'areas', true );

                    $person_type = get_post_meta( $default_room_id, MB_PLUGIN_PREFIX_ROOM.'person_type', true );
                    $extra_service = mb_booking_get_extra_service_remaining( $default_room_id );

                    if ( mb_array_exists( $areas ) ) {
                        foreach ( $areas as $k => $area_item ) {
                            $person_price = isset( $area_item['person_price'] ) ? $area_item['person_price'] : array();
                        ?>
                            <label class="mb-checkbox">
                                <input
                                    type="checkbox"
                                    class="area"
                                    name="<?php echo esc_attr( 'ova_mb_booking_areas'.'['.$k.'][id]' ); ?>"
                                    value="<?php echo esc_attr( $area_item['id'] ); ?>"
                                    data-id="<?php echo esc_attr( $area_item['id'] ); ?>"
                                    data-price="<?php echo esc_attr( $area_item['price'] ); ?>"
                                    data-qty="<?php echo esc_attr( $area_item['qty'] ); ?>"
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
                        <?php }
                    }
                } else {
                    ?>
                    <span class="no-area"><?php esc_html_e( 'No Area', 'moviebooking' ); ?></span>
                    <?php
                }

                $html_area = ob_get_contents();
                ob_end_clean();

                echo json_encode( array( 
                    'html_room'     => $html_room,
                    'html_seat'     => $html_seat,
                    'html_area'     => $html_area,
                    'person_type'   => $person_type,
                    'extra_service' => $extra_service,
                ));
            }

            wp_die();
        }

        // Change Room
        public function mb_add_booking_change_room() {
            if ( ! isset( $_POST['data'] ) ) wp_die();
            $data = $_POST['data'];

            $ajax_nonce = isset( $data['ajax_nonce'] ) ? sanitize_text_field( $data['ajax_nonce'] ) : '';

            if ( ! wp_verify_nonce( $ajax_nonce , apply_filters( 'mb_admin_ajax_security', 'ajax_nonce_mb' ) ) ) wp_die();

            $room_id = isset( $data['room_id'] ) ? absint( sanitize_text_field( $data['room_id'] ) ) : 0;
            $person_type = get_post_meta( $room_id, MB_PLUGIN_PREFIX_ROOM.'person_type', true );
            $person_type = ! empty( $person_type ) ? $person_type : array();
            $extra_service = mb_booking_get_extra_service_remaining( $room_id );

            if ( absint( $room_id ) ) {
                // Seat
                ob_start();
                $seats = MB_Room()->get_data_seat( $room_id );

                if ( mb_array_exists( $seats ) ) {
                    foreach ( $seats as $k => $seat_item ) {
                    ?>
                        <label class="mb-checkbox">
                            <input 
                                type="checkbox" 
                                class="seat" 
                                name="<?php echo esc_attr( 'ova_mb_booking_seats'.'['.$k.'][id]' ); ?>" 
                                value="<?php echo esc_attr( $seat_item['id'] ); ?>"  
                                data-price="<?php echo esc_attr( $seat_item['price'] ); ?>" />
                            <input
                                type="hidden"
                                name="<?php echo esc_attr( 'mb_booking_seats_price['.$seat_item['id'].']' ); ?>"
                                value="<?php echo esc_attr( $seat_item['price'] ); ?>"
                            />
                            <span class="checkmark"></span>
                            <?php echo esc_html( $seat_item['id'] ); ?>
                        </label>
                    <?php }
                } else {
                    ?>
                    <span class="no-seat"><?php esc_html_e( 'No Seat', 'moviebooking' ); ?></span>
                    <?php
                }

                $html_seat = ob_get_contents();
                ob_end_clean();

                // Area
                ob_start();
                if ( absint( $room_id ) ) {
                    $areas = get_post_meta( $room_id, MB_PLUGIN_PREFIX_ROOM.'areas', true );

                    if ( mb_array_exists( $areas ) ) {
                        foreach ( $areas as $k => $area_item ) {
                            $person_price = isset( $area_item['person_price'] ) ? $area_item['person_price'] : array();
                        ?>
                            <label class="mb-checkbox">
                                <input
                                    type="checkbox"
                                    class="area"
                                    name="<?php echo esc_attr( 'ova_mb_booking_areas'.'['.$k.'][id]' ); ?>"
                                    value="<?php echo esc_attr( $area_item['id'] ); ?>"
                                    data-id="<?php echo esc_attr( $area_item['id'] ); ?>"
                                    data-price="<?php echo esc_attr( $area_item['price'] ); ?>"
                                    data-qty="<?php echo esc_attr( $area_item['qty'] ); ?>"
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
                        <?php }
                    }
                } else {
                    ?>
                    <span class="no-area"><?php esc_html_e( 'No Area', 'moviebooking' ); ?></span>
                    <?php
                }

                $html_area = ob_get_contents();
                ob_end_clean();

                echo json_encode( array( 
                    'html_seat' => $html_seat,
                    'html_area' => $html_area,
                    'person_type' => $person_type,
                    'extra_service' => $extra_service,
                ));
            }

            wp_die();
        }

        // Check Coupon
        public function mb_add_booking_check_coupon() {
            if ( ! isset( $_POST['data'] ) ) wp_die();
            $data = $_POST['data'];

            $ajax_nonce = isset( $data['ajax_nonce'] ) ? sanitize_text_field( $data['ajax_nonce'] ) : '';

            if ( ! wp_verify_nonce( $ajax_nonce , apply_filters( 'mb_admin_ajax_security', 'ajax_nonce_mb' ) ) ) wp_die();

            $movie_id       = isset( $data['movieID'] ) ? absint( sanitize_text_field( $data['movieID'] ) ) : 0;
            $discount_code  = isset( $data['discountCode'] ) ? sanitize_text_field( $data['discountCode'] ) : '';

            if ( ! $movie_id || ! $discount_code ) wp_die();

            $result = MB_Cart()->check_code_discount( $movie_id, $discount_code );

            echo $result;

            wp_die();
        }

        // Create and Send Tickets
        public function mb_create_send_tickets() {
            if ( ! isset( $_POST['data'] ) ) wp_die();
            $data = $_POST['data'];

            $ajax_nonce = isset( $data['ajax_nonce'] ) ? sanitize_text_field( $data['ajax_nonce'] ) : '';

            if ( ! wp_verify_nonce( $ajax_nonce , apply_filters( 'mb_admin_ajax_security', 'ajax_nonce_mb' ) ) ) wp_die();

            $result         = array();
            $booking_id     = isset( $data['bookingID'] ) ? absint( sanitize_text_field( $data['bookingID'] ) ) : 0;
            $booking_status = get_post_meta( $booking_id, MB_PLUGIN_PREFIX_BOOKING.'status', true );

            if ( $booking_status !== 'Completed' ) {
                $result['status']   = 'error';
                $result['message']  = esc_html__( 'Please update booking status to Complete to send mail', 'moviebooking' );

                echo json_encode($result);

                wp_die();
            }

            $tickets_data   = get_post_meta( $booking_id, MB_PLUGIN_PREFIX_BOOKING.'ticket_ids', true );
            if ( ! is_array( $tickets_data ) ) $tickets_data = array();

            $tickets_record = MB_Ticket()->get_tickets_by_booking( $booking_id );
            $send_mail      = false;

            if ( count( $tickets_record ) == 0 && count( $tickets_data ) >= 0 ) {
                $result['message'] = esc_html__( 'Create Ticket and Send mail success!', 'moviebooking' );
                $ticket_ids = MB_Ticket()->add_ticket( $booking_id );

                // Update Record ticket ids to Booking 
                update_post_meta( $booking_id, MB_PLUGIN_PREFIX_BOOKING.'ticket_ids', $ticket_ids );

                $send_mail = MB_Email()->mb_sendmail_by_booking_id( $booking_id, 'customer' );
            } else {
                $result['message'] = esc_html__( 'Send mail success!', 'moviebooking' );
                $send_mail = MB_Email()->mb_sendmail_by_booking_id( $booking_id, 'customer' );
            }

            if ( $send_mail ) {
                $result['status'] = 'success';
            } else {
                $result['status']   = 'error';
                $result['message']  = esc_html__( 'Send mail failed!', 'moviebooking' );
            }

            if ( empty( $result ) ) {
                $result['status']   = 'error';
                $result['message']  = esc_html__( 'Failed!', 'moviebooking' );
            }

            echo json_encode($result);

            wp_die();
        }

        // Booking Statistics
        public function mb_booking_statistics() {
            if ( ! isset( $_POST['data'] ) ) wp_die();
            $data = $_POST['data'];

            $ajax_nonce = isset( $data['ajax_nonce'] ) ? sanitize_text_field( $data['ajax_nonce'] ) : '';

            if ( ! wp_verify_nonce( $ajax_nonce , apply_filters( 'mb_admin_ajax_security', 'ajax_nonce_mb' ) ) ) wp_die();

            $movie_id   = isset( $data['movieID'] ) ? absint( sanitize_text_field( $data['movieID'] ) ) : 0;
            $status     = isset( $data['status'] ) ? sanitize_text_field( $data['status'] ) : '';
            $from       = isset( $data['from'] ) ? strtotime( sanitize_text_field( $data['from'] ) ) : '';
            $to         = isset( $data['to'] ) ? strtotime( sanitize_text_field( $data['to'] ) ) : '';
            $city_id    = isset( $data['cityID'] ) ? absint( sanitize_text_field( $data['cityID'] ) ) : 0;
            $venue_id   = isset( $data['venueID'] ) ? absint( sanitize_text_field( $data['venueID'] ) ) : 0;
            $room_id    = isset( $data['roomID'] ) ? absint( sanitize_text_field( $data['roomID'] ) ) : 0;

            $data_booking = MB_Booking()->mb_get_total_booking( $movie_id, $status, $from, $to, $city_id, $venue_id, $room_id );
            $result = array();

            foreach ( $data_booking as $k => $value ) {
                if ( $k === 'discount' ) {
                    $result[$k] = '-'.wc_price( $value );
                } else {
                    $result[$k] = wc_price( $value );
                }
            }

            echo json_encode( $result );

            wp_die();
        }

        public function mb_add_person_type(){
            $response = '';
            if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'mb_add_person_type' ) ) {
                echo $response;
                wp_die();
            }
            $items = isset( $_POST['items'] ) ? $_POST['items'] : 0;

            ob_start();
            ?>
            <li class="person_type_item">
                <input class="mb_person_type" name="<?php echo esc_attr( MB_PLUGIN_PREFIX_ROOM.'person_type'.'['.$items.']' ); ?>" type="text" value="" class="regular-text">
                <button type="button" class="mb_remove_person_type button button-secondary"><span class="dashicons dashicons-no-alt"></span></button>
            </li>
            <?php
            $response = ob_get_clean();
            echo $response;
            wp_die();
        }

        public function mb_add_person_price(){

            $person_names = isset( $_POST['person_names'] ) ? MovieBooking_Core::instance()->recursive_sanitize_text_field( $_POST['person_names'] ): array();
            $area_items = isset( $_POST['area_items'] ) ? sanitize_text_field( $_POST['area_items'] ) : '';

            $response = array();

            if ( empty( $area_items ) || empty( $person_names ) ) {
                echo json_encode( $response );
                wp_die();
            }
            
            for ( $i=0; $i < (int)$area_items; $i++ ) { 
                ob_start();
                foreach ( $person_names as $key => $name ) {
                    
                    ?>
                    <div class="area-person-price-field item-area-field">
                        <label><?php printf( esc_html__( '%1$s(%2$s)*', 'moviebooking' ), $name ,MBC()->mb_get_currency() ); ?></label>
                        <input 
                            type="text" 
                            class="area-map-person-price" 
                            value="" 
                            placeholder="<?php esc_attr_e( '10', 'moviebooking' ); ?>" 
                            name="<?php echo esc_attr( 'ova_mb_room_areas'.'['.$i.']'.'[person_price]'.'['.$key.']'); ?>" 
                            autocomplete="off" 
                            autocorrect="off" 
                            autocapitalize="none" 
                            required />
                    </div>
                    <?php

                }
                $response[] = ob_get_clean();
            }
            
            echo json_encode( $response );
            wp_die();
        }

        public function mb_add_services(){
            if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'mb_add_services' ) ) {
                echo '';
                wp_die();
            }
            $k = isset( $_POST['count_item'] ) ? sanitize_text_field( $_POST['count_item'] ) : 0;
            ob_start();
            ?>
            <li class="el_service_item">
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row"><label for=""><?php esc_html_e( 'Service Name', 'moviebooking' ); ?></label></th>
                            <td>
                                <input name="<?php echo MB_PLUGIN_PREFIX_ROOM.'extra_service['.$k.'][name]'; ?>" type="text" value="" placeholder="<?php esc_attr_e( 'Enter Name', 'moviebooking' ); ?>" required class="extra_service_name regular-text">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for=""><?php esc_html_e( 'Price', 'moviebooking' ); ?></label></th>
                            <td><input name="<?php echo MB_PLUGIN_PREFIX_ROOM.'extra_service['.$k.'][price]'; ?>" type="number" min="0" step="0.1" value="" placeholder="<?php echo esc_attr_e( '10', 'moviebooking' ); ?>" class="extra_service_price regular-number"></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for=""><?php esc_html_e( 'Max Quantity/Calendar', 'moviebooking' ); ?></label></th>
                            <td><input name="<?php echo MB_PLUGIN_PREFIX_ROOM.'extra_service['.$k.'][qty]'; ?>" type="number" min="0" step="1" value="" placeholder="<?php esc_attr_e( '100', 'moviebooking' ); ?>" required class="extra_service_qty regular-number"></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for=""><?php esc_html_e( 'Max Quantity/Ticket', 'moviebooking' ); ?></label></th>
                            <td><input name="<?php echo MB_PLUGIN_PREFIX_ROOM.'extra_service['.$k.'][max_qty]'; ?>" type="number" min="0" step="1" value="" placeholder="<?php esc_attr_e( '10', 'moviebooking' ); ?>" class="extra_service_max_qty regular-number"></td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" class="el_remove_service button button-small button-secondary">&#x2715;</button>
            </li>
            <?php
            echo ob_get_clean();
            wp_die();
        }

    }

    new MB_Admin_Ajax();
}

?>