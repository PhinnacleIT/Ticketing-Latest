<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MB_Woo_Payment' ) ) {

    class MB_Woo_Payment {

        protected static $_instance = null;

        public $booking_id = null;

        public function __construct() {
            $this->booking_id = MB()->cart_session->get( 'booking_id' );

            if ( $this->booking_id ) {
                add_filter( 'woocommerce_add_cart_item_data', array( $this, 'mb_add_extra_data_to_cart_item' ), 10, 4 );
            }

            // Display Extra fields to cart
            add_filter( 'woocommerce_get_item_data', array( $this, 'mb_display_extra_data_cart' ), 10, 2 );

            // Permalink
            add_filter( 'woocommerce_cart_item_permalink' , array( $this, 'mb_display_cart_movie_permalink' ), 10, 3 );
            add_filter( 'woocommerce_order_item_permalink' , array( $this, 'mb_display_cart_movie_permalink' ), 10, 3 );

            // Thumbnail
            add_filter( 'woocommerce_cart_item_thumbnail' , array( $this, 'mb_display_cart_movie_thumbnail' ), 10, 3 );
            add_filter( 'woocommerce_admin_order_item_thumbnail' , array( $this, 'mb_display_admin_order_item_thumbnail' ), 10, 3 );

            // Name
            add_filter( 'woocommerce_cart_item_name' , array( $this, 'mb_display_cart_movie_name' ), 10, 3 );

            // Price
            add_filter( 'woocommerce_cart_item_price' , array( $this, 'mb_display_cart_movie_price' ), 10, 3 );

            // Quantity
            add_filter( 'woocommerce_cart_item_quantity' , array( $this, 'mb_display_cart_movie_quantity' ), 10, 3 );

            // Subtotal
            add_filter( 'woocommerce_cart_item_subtotal' , array( $this, 'mb_display_cart_movie_subtotal' ), 10, 3 );

            // Calculate totals
            add_action( 'woocommerce_before_calculate_totals', array( $this, 'mb_display_cart_calculate_totals' ), 10 );

            // Cart total - Subtotal
            add_filter( 'woocommerce_cart_subtotal' , array( $this, 'mb_display_cart_subtotal' ), 10, 3 );

            // Discount, Tax, Ticket Fee
            add_action( 'woocommerce_cart_totals_before_order_total', array( $this, 'mb_display_cart_totals_before_order_total' ), 10 );
            add_action( 'woocommerce_review_order_before_order_total', array( $this, 'mb_display_cart_totals_before_order_total' ), 10 );

            // Total
            add_filter( 'woocommerce_cart_totals_order_total_html', array( $this, 'mb_display_cart_totals_order_total_html' ), 10 );

            // Save item
            add_action( 'woocommerce_checkout_create_order_line_item', array( $this, 'mb_checkout_create_order_line_item' ), 10, 4 );

            // Validate checkout
            add_action( 'woocommerce_after_checkout_validation', array( $this, 'mb_checkout_validation' ), 10, 2 );

            // Checkout processed
            add_action( 'woocommerce_checkout_order_processed', array( $this, 'mb_checkout_order_processed' ), 10, 3 );

            // Hide fields
            add_filter( 'woocommerce_order_item_get_formatted_meta_data', array( $this, 'mb_order_item_hide_fields' ), 10, 2 );

            // Item Meta - Order Detail
            add_filter( 'woocommerce_display_item_meta', array( $this, 'mb_display_item_meta' ), 10, 3 );
            add_filter( 'woocommerce_order_item_display_meta_key', array( $this, 'mb_order_item_display_meta_key' ), 20, 3 );

            // Checkout & Order Detail Page
            add_filter( 'woocommerce_get_order_item_totals', array( $this, 'mb_add_order_item_totals' ), 20, 3 );
            add_filter( 'woocommerce_order_formatted_line_subtotal', array( $this, 'mb_display_order_detail_subtotal' ), 20, 3 );

            // Order Detail - Admin
            add_action( 'woocommerce_admin_order_totals_after_tax', array( $this, 'mb_display_admin_order_item' ), 10 );

            // Payment success
            $allow_add_ticket = MB()->options->checkout->get( 'allow_add_ticket_by_order', array( 'wc-completed', 'wc-processing' ) );

            // Status: Completed
            if ( in_array( 'wc-completed', $allow_add_ticket ) ) {
                add_action( 'woocommerce_order_status_completed', array( $this, 'mb_order_status_completed' ), 10 );
            }

            // Status: Processing
            if ( in_array( 'wc-processing', $allow_add_ticket ) ) {
                add_action( 'woocommerce_order_status_processing', array( $this, 'mb_order_status_completed' ), 10 );
            }

            // Status: On Hold
            if ( in_array( 'wc-on-hold', $allow_add_ticket ) ) {
                add_action( 'woocommerce_order_status_on-hold', array( $this, 'mb_order_status_completed' ), 10 );    
            }

            // Update status Holding Ticket
            if ( MB()->options->checkout->get('enable_holding_ticket', 'no') === 'yes' ) {
                add_action( 'woocommerce_order_status_completed', array( $this, 'mb_order_update_status_holding_ticket' ), 10 );
                add_action( 'woocommerce_order_status_processing', array( $this, 'mb_order_update_status_holding_ticket' ), 10 );
                add_action( 'woocommerce_order_status_on-hold', array( $this, 'mb_order_update_status_holding_ticket' ), 10 );
            }

            // Attachment file to email
            add_filter( 'woocommerce_email_attachments', array( $this, 'mb_email_attachments' ), 10, 3 );

            // Send mail to recipient
            add_filter( 'woocommerce_email_recipient_customer_on_hold_order', array( $this, 'mb_email_recipient' ), 10, 2 );
            add_filter( 'woocommerce_email_recipient_customer_processing_order', array( $this, 'mb_email_recipient' ), 10, 2 );
            add_filter( 'woocommerce_email_recipient_customer_completed_order', array( $this, 'mb_email_recipient' ), 10, 2 );

            // Countdown checkout
            add_action( 'woocommerce_after_checkout_form', array( $this, 'mb_countdown_holding_ticket_checkout' ) );

            // Thank you page after booking succesfully
            if ( apply_filters( 'mb_ft_booking_movie_thankyou', true ) && MB()->options->checkout->get( 'thanks_page_id' ) != '' ) {
                add_action( 'woocommerce_thankyou', array( $this, 'mb_booking_event_thankyou' ) );
            }
        }

        public function mb_add_extra_data_to_cart_item( $cart_item_data, $product_id, $variation_id, $quantity ) {
            $booking_id = $this->booking_id;
            $prefix     = MB_PLUGIN_PREFIX_BOOKING;

            if ( $booking_id ) {
                $showtime_id    = get_post_meta( $booking_id, $prefix.'showtime_id', true );
                $room_id        = get_post_meta( $booking_id, $prefix.'room_id', true );
                $movie_id       = get_post_meta( $booking_id, $prefix.'movie_id', true );
                $cart           = get_post_meta( $booking_id, $prefix.'cart', true );
                $seat           = get_post_meta( $booking_id, $prefix.'seat', true );
                $area           = get_post_meta( $booking_id, $prefix.'area', true );
                $person_type    = get_post_meta( $booking_id, $prefix.'person_type', true );
                $extra_service  = get_post_meta( $booking_id, $prefix.'extra_service', true );
                $qty            = get_post_meta( $booking_id, $prefix.'qty', true );
                $subtotal       = get_post_meta( $booking_id, $prefix.'subtotal', true );
                $discount       = get_post_meta( $booking_id, $prefix.'discount', true );
                $discount_code  = get_post_meta( $booking_id, $prefix.'discount_code', true );
                $tax            = get_post_meta( $booking_id, $prefix.'tax', true );
                $ticket_fee     = get_post_meta( $booking_id, $prefix.'ticket_fee', true );
                $total          = get_post_meta( $booking_id, $prefix.'total', true );

                $item_data = array(
                    'booking_id'    => $booking_id,
                    'showtime_id'   => $showtime_id,
                    'room_id'       => $room_id,
                    'movie_id'      => $movie_id,
                    'cart'          => $cart,
                    'seat'          => $seat,
                    'area'          => $area,
                    'person_type'   => $person_type,
                    'extra_service' => $extra_service,
                    'qty'           => $qty,
                    'subtotal'      => $subtotal,
                    'discount'      => $discount,
                    'discount_code' => $discount_code,
                    'tax'           => $tax,
                    'ticket_fee'    => $ticket_fee,
                    'total'         => $total,
                );

                $cart_extra_fields = apply_filters( 'mb_ft_cart_extra_fields', $item_data );

                foreach ( $cart_extra_fields as $key => $value ) {
                    $cart_item_data[$key] = $value;
                }
            }

            return $cart_item_data;
        }

        public function mb_display_extra_data_cart( $item_data, $cart_item ) {
            if ( isset( $cart_item['booking_id'] ) && $cart_item['booking_id'] ) {
                $booking_id = $cart_item['booking_id'];
                $prefix     = MB_PLUGIN_PREFIX_BOOKING;

                $showtime_id    = isset( $cart_item['showtime_id'] ) ? $cart_item['showtime_id'] : '';
                $room_id        = isset( $cart_item['room_id'] ) ? $cart_item['room_id'] : '';
                $seat           = isset( $cart_item['seat'] ) ? $cart_item['seat'] : [];
                $area           = isset( $cart_item['area'] ) ? $cart_item['area'] : [];
                $person_type    = isset( $cart_item['person_type'] ) ? $cart_item['person_type'] : [];
                $extra_service  = isset( $cart_item['extra_service'] ) ? $cart_item['extra_service'] : [];
                // Date
                $date = get_post_meta( $showtime_id, MB_PLUGIN_PREFIX_SHOWTIME.'date', true );
                $date_time_format = MBC()->mb_get_date_time_format();

                if ( $date ) {
                    $item_data[] = array(
                        'key'     => esc_html__( 'Date', 'moviebooking' ),
                        'value'   => date( $date_time_format, $date ),
                        'display' => '',
                    );
                }

                // Room
                if ( absint( $room_id ) ) {
                    $item_data[] = array(
                        'key'     => esc_html__( 'Room', 'moviebooking' ),
                        'value'   => get_the_title( $room_id ),
                        'display' => '',
                    );
                }

                // Seat
                if ( ! empty( $seat ) && is_array( $seat ) ) {
                    $item_data[] = array(
                        'key'     => esc_html__( 'Seat', 'moviebooking' ),
                        'value'   => join( ', ', $seat ),
                        'display' => '',
                    );
                }

                // Area
                if ( ! empty( $area ) && is_array( $area ) ) {
                    $area_html = [];

                    foreach ( $area as $area_id => $area_qty ) {

                        if ( ! empty( $person_type ) && array_key_exists( $area_id, $person_type ) ) {
                            foreach ( $person_type[$area_id] as $key => $value ) {
                                array_push( $area_html, $area_id.' - '.$value['id'].'(x'.absint( $value['qty'] ).')' );
                            }
                            
                        } else {
                            array_push( $area_html, $area_id.'(x'.absint( $area_qty ).')' );
                        }
                        
                    }

                    $item_data[] = array(
                        'key'     => esc_html__( 'Area', 'moviebooking' ),
                        'value'   => join( ', ', $area_html ),
                        'display' => '',
                    );
                }

                if ( ! empty( $extra_service ) ) {
                    $html_arr = mb_get_extra_service_html( $extra_service );
                    $item_data[] = array(
                        'key'     => esc_html__( 'Extra Service', 'moviebooking' ),
                        'value'   => join( ', ', $html_arr ),
                        'display' => '',
                    );
                }

                // Address
                $address    = '';
                $city_id    = get_post_meta( $showtime_id, MB_PLUGIN_PREFIX_SHOWTIME.'city_id', true );
                $venue_id   = get_post_meta( $showtime_id, MB_PLUGIN_PREFIX_SHOWTIME.'venue_id', true );

                $city_name          = MBC()->mb_get_taxonomy_name( $city_id, 'movie_location' );
                $venue_name         = MBC()->mb_get_taxonomy_name( $venue_id, 'movie_location' );
                $showtime_address   = get_post_meta( $showtime_id, MB_PLUGIN_PREFIX_SHOWTIME.'address', true );
                $address_arr        = array();

                if ( $showtime_address ) $address_arr[] = $showtime_address;
                if ( $venue_name ) $address_arr[] = $venue_name;
                if ( $city_name ) $address_arr[] = $city_name;

                if ( mb_array_exists( $address_arr ) ) {
                    $address = join( ', ', $address_arr );
                }

                if ( $address ) {
                    $item_data[] = array(
                        'key'     => esc_html__( 'Address', 'moviebooking' ),
                        'value'   => $address,
                        'display' => '',
                    );
                }
            }

            return $item_data;
        }

        public function mb_display_cart_movie_permalink( $link, $cart_item, $cart_item_key ) {
            if ( isset( $cart_item['booking_id'] ) && $cart_item['booking_id'] ) {
                $movie_id   = get_post_meta( $cart_item['booking_id'], MB_PLUGIN_PREFIX_BOOKING.'movie_id', true );
                $permalink  = get_permalink( $movie_id );

                if ( $permalink ) {
                    $link = $permalink;
                }
            }

            return $link;
        }

        public function mb_display_cart_movie_thumbnail( $thumbnail, $cart_item, $cart_item_key ) {
            if ( isset( $cart_item['booking_id'] ) && $cart_item['booking_id'] ) {
                $movie_id       = isset( $cart_item['movie_id'] ) ? $cart_item['movie_id'] : '';
                $thumbnail_id   = get_post_thumbnail_id( $movie_id );

                if ( $thumbnail_id ) {
                    $thumbnail = wp_get_attachment_image( $thumbnail_id, 'woocommerce_thumbnail', false, '' );
                }
            }

            return $thumbnail;
        }

        public function mb_display_admin_order_item_thumbnail( $thumbnail, $item_id, $item ) {
            $booking_id = $item->get_meta('booking_id');

            if ( $booking_id ) {
                $prefix         = MB_PLUGIN_PREFIX_BOOKING;
                $movie_id       = get_post_meta( $booking_id, $prefix.'movie_id', true );
                $thumbnail_id   = get_post_thumbnail_id( $movie_id );

                if ( $thumbnail_id ) {
                    $thumbnail = wp_get_attachment_image( $thumbnail_id, 'woocommerce_thumbnail', false, '' );
                }
            }

            return $thumbnail;
        }

        public function mb_display_cart_movie_name( $name, $cart_item, $cart_item_key ) {
            if ( isset( $cart_item['booking_id'] ) && $cart_item['booking_id'] ) {
                $movie_id       = isset( $cart_item['movie_id'] ) ? $cart_item['movie_id'] : '';
                $movie_title    = get_the_title( $movie_id );
                $permalink      = get_permalink( $movie_id );

                if ( $movie_title ) {
                    if ( $permalink ) {
                        $name = sprintf( '<a href="%s">%s</a>', esc_url( $permalink ), $movie_title );
                    } else {
                        $name = $movie_title;
                    }
                }
            }

            return $name;
        }

        public function mb_display_cart_movie_price( $price, $cart_item, $cart_item_key ) {
            if ( isset( $cart_item['booking_id'] ) && $cart_item['booking_id'] ) {
                $subtotal   = isset( $cart_item['subtotal'] ) ? $cart_item['subtotal'] : 0;
                $price      = wc_price( $subtotal );
            }

            return $price;
        }

        public function mb_display_cart_movie_quantity( $quantity, $cart_item_key, $cart_item ) {
            if ( isset( $cart_item['booking_id'] ) && $cart_item['booking_id'] ) {
                $quantity = '<div class="quantity">';
                    $quantity .= '<input 
                                    type="number" 
                                    class="input-text qty text" 
                                    name="cart['.$cart_item_key.'][qty]" 
                                    value="1" 
                                    title="'.esc_html__( 'Qty', 'moviebooking' ).'" 
                                    size="4" 
                                    step="1" 
                                    disabled />';
                $quantity .= '</div>';
            }

            return $quantity;
        }

        public function mb_display_cart_movie_subtotal( $price, $cart_item, $cart_item_key ) {
            if ( isset( $cart_item['booking_id'] ) && $cart_item['booking_id'] ) {
                $subtotal   = isset( $cart_item['subtotal'] ) ? $cart_item['subtotal'] : 0;
                $price      = wc_price( $subtotal );
                $enable_tax = MB()->options->tax_fee->get( 'enable_tax' );
                $incl_tax   = MB()->options->tax_fee->get( 'prices_include_tax', 'no' );

                if ( 'yes' === $enable_tax && 'yes' === $incl_tax ) {
                    $price .= '<small class="tax_label">'. esc_html__( '(ex. tax)', 'moviebooking' ) .'</small>';
                }
            }

            return $price;
        }

        public function mb_display_cart_calculate_totals( $wc_cart ) {
            if ( is_admin() && ! defined( 'DOING_AJAX' ) ) return;

            foreach ( $wc_cart->get_cart() as $cart_item_key => $cart_item ) {
                if ( isset( $cart_item['booking_id'] ) && $cart_item['booking_id'] ) {
                    $total = isset( $cart_item['total'] ) ? $cart_item['total'] : 0;

                    // Total
                    $number_decimals = MBC()->mb_get_currency_minor_unit();

                    $total = round( floatval( $total ), $number_decimals );

                    $cart_item['data']->set_price( $total );
                }
            }
        }

        public function mb_display_cart_subtotal( $cart_subtotal, $compound, $wc_cart ) {
            if ( is_admin() && ! defined( 'DOING_AJAX' ) ) return $cart_subtotal;

            foreach( $wc_cart->get_cart() as $cart_item_key => $cart_item ) {
                if ( isset( $cart_item['booking_id'] ) && $cart_item['booking_id'] ) {
                    $prefix     = MB_PLUGIN_PREFIX_BOOKING;
                    $booking_id = $cart_item['booking_id'];
                    $subtotal = $cart_item['subtotal'];
                    // $cart       = get_post_meta( $booking_id, $prefix.'cart', true );
                    // $subtotal   = MB_Cart()->get_price_from_cart( $cart );
                    $enable_tax = MB()->options->tax_fee->get( 'enable_tax' );
                    $incl_tax   = MB()->options->tax_fee->get( 'prices_include_tax', 'no' );

                    $cart_subtotal = wc_price( $subtotal );

                    if ( 'yes' === $enable_tax && 'yes' === $incl_tax ) {
                        $cart_subtotal .= '<small class="tax_label">'. esc_html__( '(ex. tax)', 'moviebooking' ) .'</small>';
                    }

                    break;
                }
            }

            return $cart_subtotal;
        }

        public function mb_display_cart_totals_before_order_total() {
            if ( is_admin() && ! defined( 'DOING_AJAX' ) ) return;

            foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                if ( isset( $cart_item['booking_id'] ) && $cart_item['booking_id'] ) {
                    $discount_code  = isset( $cart_item['discount_code'] ) ? $cart_item['discount_code'] : '';
                    $discount       = isset( $cart_item['discount'] ) ? $cart_item['discount'] : '';

                    if ( $discount_code && $discount ) {
                        ?>
                        <tr class="mb-cart-discount">
                            <th><?php esc_html_e( 'Discount', 'moviebooking' ); ?></th>
                            <td data-title="<?php esc_attr_e( 'Discount', 'moviebooking' ); ?>">
                                <?php echo esc_html__( '-', 'moviebooking' ) . wc_price( $discount ) . sprintf( esc_html__( ' (%s)', 'moviebooking' ), $discount_code ); ?>
                            </td>
                        </tr>
                        <?php
                    }
                    // End Discount

                    // Tax
                    $tax = isset( $cart_item['tax'] ) ? $cart_item['tax'] : 0;

                    if ( $tax ) {
                        ?>
                        <tr class="mb-cart-tax">
                            <th><?php esc_html_e( 'Tax', 'moviebooking' ); ?></th>
                            <td data-title="<?php esc_attr_e( 'Tax', 'moviebooking' ); ?>">
                                <?php echo wc_price( $tax ); ?>
                            </td>
                        </tr>
                        <?php
                    }
                    // End Tax

                    // Ticket Fee
                    $ticket_fee = isset( $cart_item['ticket_fee'] ) ? $cart_item['ticket_fee'] : 0;

                    if ( $ticket_fee ) {
                        ?>
                        <tr class="mb-ticket-fee">
                            <th><?php esc_html_e( 'Ticket Fee', 'moviebooking' ); ?></th>
                            <td data-title="<?php esc_attr_e( 'Ticket Fee', 'moviebooking' ); ?>">
                                <?php echo wc_price( $ticket_fee ); ?>
                            </td>
                        </tr>
                        <?php
                    }
                    // End Ticket Fee

                    break;  
                }
            }
        }

        public function mb_display_cart_totals_order_total_html( $total_html ) {
            if ( is_admin() && ! defined( 'DOING_AJAX' ) ) return;

            foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                if ( isset( $cart_item['booking_id'] ) && $cart_item['booking_id'] ) {
                    $subtotal   = isset( $cart_item['subtotal'] ) ? $cart_item['subtotal'] : 0;
                    $discount   = isset( $cart_item['discount'] ) ? $cart_item['discount'] : 0;
                    $tax        = isset( $cart_item['tax'] ) ? $cart_item['tax'] : 0;
                    $ticket_fee = isset( $cart_item['ticket_fee'] ) ? $cart_item['ticket_fee'] : 0;
                    $total      = isset( $cart_item['total'] ) ? $cart_item['total'] : 0;


                    // Total HTML
                    $total_html = '<strong>' . wc_price( $total ) . '</strong>';

                    // Update Cart session
                    $number_decimals = MBC()->mb_get_currency_minor_unit();

                    WC()->cart->cart_contents[$cart_item_key]['subtotal']   = round( $subtotal, $number_decimals );
                    WC()->cart->cart_contents[$cart_item_key]['discount']   = round( $discount, $number_decimals );
                    WC()->cart->cart_contents[$cart_item_key]['tax']        = round( $tax, $number_decimals );
                    WC()->cart->cart_contents[$cart_item_key]['ticket_fee'] = round( $ticket_fee, $number_decimals );
                    WC()->cart->cart_contents[$cart_item_key]['total']      = round( $total, $number_decimals );
                    WC()->cart->set_session();

                    break;  
                }
            }

            return $total_html;
        }

        public function mb_checkout_create_order_line_item( $item, $cart_item_key, $values, $order ) {
            if ( isset( $values['booking_id'] ) && $values['booking_id'] ) {
                $prefix         = MB_PLUGIN_PREFIX_BOOKING;
                $booking_id     = $values['booking_id'];
                $cart           = isset( $values['cart'] ) ? $values['cart'] : [];
                $showtime_id    = isset( $values['showtime_id'] ) ? $values['showtime_id'] : '';
                $room_id        = isset( $values['room_id'] ) ? $values['room_id'] : '';
                $movie_id       = isset( $values['movie_id'] ) ? $values['movie_id'] : '';
                $movie_title    = get_the_title( $movie_id );
                $seat           = isset( $values['seat'] ) ? $values['seat'] : [];
                $area           = isset( $values['area'] ) ? $values['area'] : [];
                $extra_service  = isset( $values['extra_service'] ) ? $values['extra_service'] : [];
                $person_type    = isset( $values['person_type'] ) ? $values['person_type'] : [];
                $enable_tax     = MB()->options->tax_fee->get( 'enable_tax' );
                $incl_tax       = '';

                if ( 'yes' === $enable_tax ) {
                    $incl_tax = MB()->options->tax_fee->get( 'prices_include_tax', 'no' );
                }

                $order->add_meta_data( 'booking_id', $booking_id );

                // Add Booking
                $item->add_meta_data( 'booking_id', $booking_id );

                // Set Item Name
                $item->set_name( $movie_title );

                // Date
                $date = get_post_meta( $showtime_id, MB_PLUGIN_PREFIX_SHOWTIME.'date', true );
                $date_time_format = MBC()->mb_get_date_time_format();

                $item->add_meta_data( 'mb_date', date( $date_time_format, $date ) );
                $item->add_meta_data( 'mb_room', get_the_title( $room_id ) );

                // Seat
                if ( ! empty( $seat ) && is_array( $seat ) ) {
                    $item->add_meta_data( 'mb_seat', join( ', ', $seat ) );
                }

                // Area
                if ( ! empty( $area ) && is_array( $area ) ) {
                    $html_area = [];

                    foreach ( $area as $area_id => $area_qty ) {

                        if ( ! empty( $person_type ) && array_key_exists( $area_id, $person_type ) ) {
                            foreach ( $person_type[$area_id] as $key => $value ) {
                                array_push( $html_area, $area_id.' - '.$value['id'].'(x'.$value['qty'].')' );
                            }
                            
                        } else {
                            array_push( $html_area, $area_id.'(x'.$area_qty.')' );
                        }

                    }

                    $item->add_meta_data( 'mb_area', join( ', ', $html_area ) );
                }

                // Extra Service

                if ( ! empty( $extra_service ) ) {
                    $html_extra_service = mb_get_extra_service_html( $extra_service );
                    $item->add_meta_data( 'mb_extra_service', join( ', ', $html_extra_service ) );
                }

                $data_item = array(
                    'subtotal'      => floatval( $values['subtotal'] ),
                    'discount'      => floatval( $values['discount'] ),
                    'discount_code' => $values['discount_code'],
                    'tax'           => floatval( $values['tax'] ),
                    'ticket_fee'    => floatval( $values['ticket_fee'] ),
                    'qty'           => absint( $values['qty'] ),
                    'total'         => floatval( $values['total'] ),
                    'incl_tax'      => $incl_tax,
                );

                foreach( $data_item as $k => $v ) {
                    // Add Item, Order
                    $item->add_meta_data( 'mb_'.$k, $v );
                }

                // Address
                $address    = '';
                $city_id    = get_post_meta( $showtime_id, MB_PLUGIN_PREFIX_SHOWTIME.'city_id', true );
                $venue_id   = get_post_meta( $showtime_id, MB_PLUGIN_PREFIX_SHOWTIME.'venue_id', true );

                $city_name          = MBC()->mb_get_taxonomy_name( $city_id, 'movie_location' );
                $venue_name         = MBC()->mb_get_taxonomy_name( $venue_id, 'movie_location' );
                $showtime_address   = get_post_meta( $showtime_id, MB_PLUGIN_PREFIX_SHOWTIME.'address', true );
                $address_arr        = array();

                if ( $showtime_address ) $address_arr[] = $showtime_address;
                if ( $venue_name ) $address_arr[] = $venue_name;
                if ( $city_name ) $address_arr[] = $city_name;

                if ( mb_array_exists( $address_arr ) ) {
                    $address = join( ', ', $address_arr );
                }

                $item->add_meta_data( 'mb_address', $address );

                $item->set_subtotal( $values['subtotal'] );
                $item->set_total( $values['subtotal'] );

                $order->set_total( $values['total'] );
            }
        }

        public function mb_checkout_validation( $data, $errors ) {
            foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                if ( isset( $cart_item['booking_id'] ) && $cart_item['booking_id'] ) {
                    $prefix         = MB_PLUGIN_PREFIX_BOOKING;
                    $booking_id     = $cart_item['booking_id'];
                    $showtime_id    = $cart_item['showtime_id'];
                    $room_id        = $cart_item['room_id'];
                    $movie_id       = $cart_item['movie_id'];
                    $cart           = $cart_item['cart'];
                    $discount_code  = $cart_item['discount_code'];

                    // Check seat and discount
                    $validate = MB_Room()->check_seat_exist( $movie_id, $showtime_id, $room_id, $cart, $discount_code );

                    if( ! $validate ) {
                        $errors->add( 'validation', MB()->msg_session->get( 'mb_message' ) );

                        // Remove Session
                        MB()->msg_session->remove();
                    }

                    break;  
                }
            }
        }

        public function mb_checkout_order_processed( $order_id, $posted_data, $order ) {
            $prefix     = MB_PLUGIN_PREFIX_BOOKING;
            $booking_id = $order->get_meta( 'booking_id', true );

            if ( $booking_id ) {
                $user_id    = $order->get_user_id();
                $email      = $order->get_billing_email();
                $phone      = $order->get_billing_phone() ? $order->get_billing_phone() : $order->get_shipping_phone();
                $address    = $order->get_address();
                $first_name = isset( $address['first_name'] ) ? $address['first_name'] : '';
                $last_name  = isset( $address['last_name'] ) ? $address['last_name'] : '';
                $full_name  = sprintf( _x( '%1$s %2$s', 'full name', 'moviebooking' ), $first_name, $last_name );
                
                update_post_meta( $booking_id, $prefix.'customer', $user_id );
                update_post_meta( $booking_id, $prefix.'customer_name', $full_name );
                update_post_meta( $booking_id, $prefix.'customer_email', $email );
                update_post_meta( $booking_id, $prefix.'customer_phone', $phone );
                update_post_meta( $booking_id, $prefix.'customer_address', $address );
            }
        }

        public function mb_order_item_hide_fields( $meta_data, $item ) {
            $field_hide = array(
                'booking_id',
                'mb_subtotal',
                'mb_discount',
                'mb_discount_code',
                'mb_tax',
                'mb_ticket_fee',
                'mb_qty',
                'mb_total',
                'mb_incl_tax',
            );

            $new_meta = array();

            foreach ( $meta_data as $id => $meta_array ) {
                if ( in_array( $meta_array->key, $field_hide ) ) { continue; }
                $new_meta[ $id ] = $meta_array;
            }

            return $new_meta;
        }

        public function mb_display_item_meta( $html, $item, $args ) {
            $html = str_replace( 'mb_date', esc_html__( 'Date', 'moviebooking' ) , $html );
            $html = str_replace( 'mb_room', esc_html__( 'Room', 'moviebooking' ) , $html );
            $html = str_replace( 'mb_seat', esc_html__( 'Seat', 'moviebooking' ) , $html );
            $html = str_replace( 'mb_area', esc_html__( 'Area', 'moviebooking' ) , $html );
            $html = str_replace( 'mb_address', esc_html__( 'Address', 'moviebooking' ) , $html );

            return $html;
        }

        public function mb_order_item_display_meta_key( $key, $meta, $item ) {

            if ( 'mb_date' === $meta->key ) { $key = esc_html__( 'Date', 'moviebooking' ); }
            if ( 'mb_room' === $meta->key ) { $key = esc_html__( 'Room', 'moviebooking' ); }
            if ( 'mb_seat' === $meta->key ) { $key = esc_html__( 'Seat', 'moviebooking' ); }
            if ( 'mb_area' === $meta->key ) { $key = esc_html__( 'Area', 'moviebooking' ); }
            if ( 'mb_extra_service' === $meta->key ) { $key = esc_html__( 'Extra Service', 'moviebooking' ); }
            if ( 'mb_address' === $meta->key ) { $key = esc_html__( 'Address', 'moviebooking' ); }

            return $key;
        }

        public function mb_add_order_item_totals( $total_rows, $order, $tax_display ) {
            $booking_id = $order->get_meta( 'booking_id', true );

            if ( $booking_id ) {
                $prefix         = MB_PLUGIN_PREFIX_BOOKING;
                $discount       = get_post_meta( $booking_id, $prefix.'discount', true );
                $discount_code  = get_post_meta( $booking_id, $prefix.'discount_code', true );
                $tax            = get_post_meta( $booking_id, $prefix.'tax', true );
                $ticket_fee     = get_post_meta( $booking_id, $prefix.'ticket_fee', true );
                $incl_tax       = get_post_meta( $booking_id, $prefix.'incl_tax', true );

                $total_rows_new = array();

                foreach( $total_rows as $k => $item_row ) {
                    $total_rows_new[$k] = $item_row;

                    if ( $k === 'cart_subtotal' ) {

                        if ( $incl_tax === 'yes' ) {
                            $total_rows_new[$k]['value'] .= '<small class="tax_label">'. esc_html__( '(ex. tax)', 'moviebooking' ) .'</small>';
                        }

                        if ( $discount ) {
                            $total_rows_new['mb_discount'] = array(
                                'label' => esc_html__( 'Discount:', 'moviebooking' ),
                                'value' => esc_html__( '-', 'moviebooking' ) . wc_price( $discount , array( 'currency' => $order->get_currency() ) ) . sprintf( esc_html__( ' (%s)', 'moviebooking' ), $discount_code ),
                            );
                        }

                        if ( $tax ) {
                            $total_rows_new['mb_tax'] = array(
                                'label' => esc_html__( 'Tax:', 'moviebooking' ),
                                'value' => wc_price( $tax , array( 'currency' => $order->get_currency() ) ),
                            );
                        }
                        
                        if ( $ticket_fee ) {
                            $total_rows_new['mb_ticket_fee'] = array(
                                'label' => esc_html__( 'Ticket Fee:', 'moviebooking' ),
                                'value' => wc_price( $ticket_fee, array( 'currency' => $order->get_currency() ) ),
                            );
                        }
                    }
                }

                return $total_rows_new;
            }

            return $total_rows;
        }

        public function mb_display_order_detail_subtotal( $subtotal, $item, $order ) {
            $booking_id = $order->get_meta( 'booking_id', true );

            if ( $booking_id ) {
                $prefix     = MB_PLUGIN_PREFIX_BOOKING;
                $incl_tax   = get_post_meta( $booking_id, $prefix.'incl_tax', true );

                if ( $incl_tax == 'yes' ) {
                    $subtotal .= '<small class="tax_label">'. esc_html__( '(ex. tax)', 'moviebooking' ) .'</small>';
                }
            }

            return $subtotal;
        }

        public function mb_display_admin_order_item( $order_id ) {
            $order      = wc_get_order( $order_id );
            $booking_id = $order->get_meta( 'booking_id', true );

            if ( $booking_id ) {
                $prefix         = MB_PLUGIN_PREFIX_BOOKING;
                $discount       = get_post_meta( $booking_id, $prefix.'discount', true );
                $discount_code  = get_post_meta( $booking_id, $prefix.'discount_code', true );
                $tax            = get_post_meta( $booking_id, $prefix.'tax', true );
                $ticket_fee     = get_post_meta( $booking_id, $prefix.'ticket_fee', true );

                if ( $discount ) { ?>
                    <tr>
                        <td class="label"><?php esc_html_e( 'Discount:', 'moviebooking' ); ?></td>
                        <td></td>
                        <td class="mb_discount">
                            <div class="view">
                                <?php echo esc_html__( '-', 'moviebooking' ) . wc_price( $discount , array( 'currency' => $order->get_currency() ) ) . sprintf( esc_html__( ' (%s)', 'moviebooking' ), $discount_code ); ?>
                            </div>
                        </td>
                    </tr>
                    <?php
                }

                if ( $tax ) { ?>
                    <tr>
                        <td class="label"><?php esc_html_e( 'Tax:', 'moviebooking' ); ?></td>
                        <td></td>
                        <td class="mb_tax">
                            <div class="view">
                                <?php echo wc_price( $tax , array( 'currency' => $order->get_currency() ) ); ?>
                            </div>
                        </td>
                    </tr>
                    <?php
                }

                if ( $ticket_fee ) { ?>
                    <tr>
                        <td class="label"><?php esc_html_e( 'Ticket Fee:', 'moviebooking' ); ?></td>
                        <td></td>
                        <td class="mb_ticket_fee">
                            <div class="view">
                                <?php echo wc_price( $ticket_fee, array( 'currency' => $order->get_currency() ) ); ?>
                            </div>
                        </td>
                    </tr>
                    <?php
                }
            }
        }

        public function mb_order_status_completed( $order_id ) {
            $order      = wc_get_order( $order_id );
            $booking_id = $order->get_meta( 'booking_id', true );

            if ( absint( $booking_id ) ) {
                // Remove send mail in WooComemrce when booking move
                if ( apply_filters( 'mb_ft_new_order_use_system_mail', true ) ) {
                    add_action( 'woocommerce_email', array( $this, 'mb_remove_emails_by_woo' ) );
                }

                MB_Booking()->success( $booking_id, $order_id );
            }
        }

        public function mb_order_update_status_holding_ticket( $order_id ) {
            $order      = wc_get_order( $order_id );
            $booking_id = $order->get_meta( 'booking_id', true );

            if ( absint( $booking_id ) ) {
                // Update Status in booking
                if ( apply_filters( 'mb_ft_update_status_holding_ticket', true ) ) {
                    update_post_meta( $booking_id, MB_PLUGIN_PREFIX_BOOKING.'status_holding_ticket', 'Completed', 'Pending' );

                    // Remove holding ticket
                    if ( apply_filters( 'mb_ft_remove_holding_ticket_after_pay', true ) ) {
                        $agrs = [
                            'post_type'         => 'holding_ticket',
                            'post_status'       => 'publish',
                            'posts_per_page'    => -1,
                            'fields'            => 'ids',
                            'meta_query'        => array(
                                array(
                                    'key'       => MB_PLUGIN_PREFIX_BOOKING.'booking_id',
                                    'value'     => $booking_id,
                                    'compare'   => '=' 
                                ),
                            ),
                        ];

                        $holding_ticket_ids = get_posts( $agrs );

                        if ( mb_array_exists( $holding_ticket_ids ) ) {
                            foreach ( $holding_ticket_ids as $ht_id ) {
                                wp_delete_post( $ht_id );
                            }
                        }
                    }
                }
            }
        }

        public function mb_remove_emails_by_woo( $WC_Emails ) {
            // Hooks for sending emails during store events.
            remove_action( 'woocommerce_low_stock_notification', array( $WC_Emails, 'low_stock' ) );
            remove_action( 'woocommerce_no_stock_notification', array( $WC_Emails, 'no_stock' ) );
            remove_action( 'woocommerce_product_on_backorder_notification', array( $WC_Emails, 'backorder' ) );
            
            // New order emails
            remove_action( 'woocommerce_order_status_pending_to_processing_notification', array( $WC_Emails->emails['WC_Email_New_Order'], 'trigger' ) );
            remove_action( 'woocommerce_order_status_pending_to_completed_notification', array( $WC_Emails->emails['WC_Email_New_Order'], 'trigger' ) );
            remove_action( 'woocommerce_order_status_pending_to_on-hold_notification', array( $WC_Emails->emails['WC_Email_New_Order'], 'trigger' ) );
            remove_action( 'woocommerce_order_status_failed_to_processing_notification', array( $WC_Emails->emails['WC_Email_New_Order'], 'trigger' ) );
            remove_action( 'woocommerce_order_status_failed_to_completed_notification', array( $WC_Emails->emails['WC_Email_New_Order'], 'trigger' ) );
            remove_action( 'woocommerce_order_status_failed_to_on-hold_notification', array( $WC_Emails->emails['WC_Email_New_Order'], 'trigger' ) );
            
            // Processing order emails
            remove_action( 'woocommerce_order_status_pending_to_processing_notification', array( $WC_Emails->emails['WC_Email_Customer_Processing_Order'], 'trigger' ) );
            
            remove_action( 'woocommerce_order_status_pending_to_on-hold_notification', array( $WC_Emails->emails['WC_Email_Customer_On_Hold_Order'], 'trigger' ) );
            
            // Completed order emails
            remove_action( 'woocommerce_order_status_completed_notification', array( $WC_Emails->emails['WC_Email_Customer_Completed_Order'], 'trigger' ) );
                
            // Note emails
            remove_action( 'woocommerce_new_customer_note_notification', array( $WC_Emails->emails['WC_Email_Customer_Note'], 'trigger' ) );
        }

        public function mb_email_attachments( $attachments, $email_id, $order ) {
            if ( empty( $order ) ) return $attachments;
            if ( empty( WC()->cart ) ) return $attachments;

            $booking_id = $order->get_meta( 'booking_id', true );

            if ( $booking_id ) {
                $ticket_pdf = apply_filters('mb_ft_booking_mail_attachments', MB_Ticket()->make_pdf_ticket_by_booking_id( $booking_id ));

                if ( is_array( $ticket_pdf ) && count( $ticket_pdf ) ){
                    $attachments = array_merge( $attachments, $ticket_pdf );    
                }
            }

            return $attachments;
        }

        public function mb_email_recipient( $recipient, $object ) {
            if ( empty( WC()->cart ) ) return $recipient;

            // Get Admin email
            $admin_email = get_option( 'admin_email', '' );

            foreach( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                if ( isset( $cart_item['booking_id'] ) && $cart_item['booking_id'] ) {
                    $booking_id = $cart_item['booking_id'];
                    $mail_to    = mb()->options->mail->get('mail_new_booking_sendmail');

                    $customer_email = get_post_meta( $booking_id, MB_PLUGIN_PREFIX_BOOKING.'email', true );

                    if ( ! empty( $mail_to ) && is_array( $mail_to ) ) {
                        foreach( $mail_to as $for ) {
                            if ( $for === 'admin' && ! str_contains( $recipient, $admin_email ) ) {
                                $recipient .= ', '.$admin_email;  
                            }

                            if ( $for === 'customer' && ! str_contains( $recipient, $customer_email ) ) {
                                $recipient .= ', '.$customer_email;
                            }
                        }
                    }

                    break;  
                }
            }

            return $recipient;
        }

        public function mb_countdown_holding_ticket_checkout() {
            // Check Holding Ticket
            $holding_ticket = MB()->options->checkout->get('enable_holding_ticket', 'yes');

            if ( 'yes' === $holding_ticket ) {
                $time_countdown_checkout    = absint( MB()->options->checkout->get('max_time_complete_payment', 600) );
                $booking_id                 = '';
                $redirect                   = home_url();

                if ( WC()->cart && WC()->cart->get_cart() ) {
                    foreach( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                        if ( isset( $cart_item['booking_id'] ) && $cart_item['booking_id'] ) {
                            $booking_id = $cart_item['booking_id'];
                            break;
                        }
                    }
                }

                if ( absint( $booking_id ) ) {
                    $prefix         = MB_PLUGIN_PREFIX_BOOKING;
                    $movie_id       = get_post_meta( $booking_id, $prefix.'movie_id', true );
                    $showtime_id    = get_post_meta( $booking_id, $prefix.'showtime_id', true );
                    $room_id        = get_post_meta( $booking_id, $prefix.'room_id', true );
                    
                    if ( $movie_id ) {
                        $redirect = get_permalink( $movie_id );
                    }

                    if ( $time_countdown_checkout ) {
                        $time_sumbit_checkout   = get_post_meta( $booking_id, $prefix.'time_countdown_checkout', true );
                        $current_time           = current_time( 'timestamp' );
                        $past_time              = absint( $current_time ) - absint( $time_sumbit_checkout );
                        $time_countdown_checkout -= $past_time;

                        if ( $time_countdown_checkout < 0 ) {
                            $time_countdown_checkout = 0;
                        }

                        if ( $time_countdown_checkout == 0 ) {
                            if ( WC()->cart ) {
                                WC()->cart->empty_cart();
                            }

                            wp_redirect( $redirect );
                            exit;
                        }

                        $minutes = absint( $time_countdown_checkout / 60 );
                        $seconds = absint( $time_countdown_checkout % 60 );

                        if ( $minutes < 10 ) {
                            $minutes = '0'.$minutes;
                        }

                        if ( $seconds < 10 ) {
                            $seconds = '0'.$seconds;
                        }
                    ?>
                        <div 
                            class="countdown-checkout" 
                            data-time-countdown-checkout="<?php esc_attr_e( $time_countdown_checkout ); ?>" 
                            data-redirect="<?php echo esc_url( $redirect ); ?>" 
                            data-bookin-id="<?php echo esc_attr( $booking_id ); ?>" 
                            data-movie-id="<?php echo esc_attr( $movie_id ); ?>" 
                            data-showtime-id="<?php echo esc_attr( $showtime_id ); ?>" 
                            data-room-id="<?php echo esc_attr( $room_id ); ?>" 
                            data-countdown-checkout-nonce="<?php echo wp_create_nonce( 'mb_countdown_checkout_nonce' ); ?>">
                            <div class="countdown-time">
                                <span class="text"><?php echo esc_html__( 'Your remaining time is ', 'moviebooking' ); ?></span>
                                <span class="time"><?php echo esc_html( $minutes.':'.$seconds ); ?></span>
                                <span class="unit"><?php echo esc_html__( ' minutes to complete your payment', 'moviebooking' ); ?></span>
                            </div>
                        </div>
                    <?php
                    }
                }
            }
        }

        public function mb_booking_event_thankyou( $order_id ) {
            $order  = wc_get_order( $order_id );
            $url    = MB()->options->checkout->get( 'thanks_page_id' );

            $booking_id = $order->get_meta( 'booking_id', true );

            if ( (int)$booking_id ) {
                // Add order_id for booking
                update_post_meta( $booking_id, MB_PLUGIN_PREFIX_BOOKING.'order_id', $order_id );

                if ( ! $order->has_status( 'failed' ) ) {
                    wp_safe_redirect( apply_filters( 'mb_ft_booking_event_url_thankyou', get_the_permalink( $url ), $order_id, $booking_id ) );
                    exit;
                }
            }
        }

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        public function process() {
            // Get Product for Booking
            $product_id = MB()->options->checkout->get('wc_product_id');

            if ( $product_id ) {
                // Remove cart
                WC()->cart->empty_cart();

                $flag = false;

                if ( sizeof( WC()->cart->get_cart() ) > 0 ) {
                    foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) {
                        $product = $values['data'];
                        if ( $product->get_id() == $product_id ) $flag = true;
                    }

                    if ( ! $flag ) WC()->cart->add_to_cart( $product_id );
                } else {
                    WC()->cart->add_to_cart( $product_id );
                }

                return array(
                    'status'    => 'success',
                    'url'       => mb_get_checkout_woo_page(),
                    'msg'       => ''
                );
            } else {
                return array(
                    'status'    => false,
                    'url'       => home_url('/'),
                    'msg'       => esc_html__( 'Product ID does not exist!', 'moviebooking' ),
                );
            }
        }
    }
}