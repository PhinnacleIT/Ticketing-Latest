<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MB_Cart' ) ) {

    class MB_Cart {

        protected static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        public function get_cart_page() {
            $cart_id = apply_filters( 'mb_ft_cart_page', MB()->options->general->get('cart_page_id') );

            return $cart_id ? esc_url( get_permalink( $cart_id ) ) : home_url();
        }

        public function get_template_cart( $data ) {
            $template = apply_filters( 'mb_shortcode_cart_template', 'cart/cart.php' );

            return $template;
        }

        public function get_cart_currency_settings() {
            $settings = array(
                'currency'              => MBC()->mb_get_currency(),
                'currency_position'     => MBC()->mb_get_currency_position(),
                'thousand_separator'    => MBC()->mb_get_currency_thousand_separator(),
                'decimal_separator'     => MBC()->mb_get_currency_decimal_separator(),
                'number_decimals'       => MBC()->mb_get_currency_minor_unit(),
            );

            return json_encode( $settings );
        }

        public function check_code_discount( $movie_id, $discount_code ) {
            $coupons = get_post_meta( $movie_id, MB_PLUGIN_PREFIX_MOVIE.'coupons', true );

            if ( ! empty( $coupons ) && is_array( $coupons ) ) {
                foreach ( $coupons as $coupon ) {
                    $code   = $coupon['code'];
                    $start  = absint( $coupon['start'] );
                    $end    = absint( $coupon['end'] );
                    $type   = $coupon['type'];
                    $value  = floatval( $coupon['percent'] );

                    if ( $type === 'amount' ) {
                        $value = floatval( $coupon['amount'] );
                    }

                    $qty            = absint( $coupon['quantity'] );
                    $current_time   = current_time('timestamp');

                    if ( $code === $discount_code && $start <= $current_time && $current_time <= $end && $qty > 0 ) {
                        $data_coupon = array(
                            'movie_id'  => $movie_id,
                            'code'      => $code,
                            'type'      => $type,
                            'value'     => $value,
                        );

                        return json_encode( $data_coupon );
                    }
                }
            }

            return false;
        }

        public function sanitize_cart_map( $cart = [] ) {
            if ( ! empty($cart)  && ! is_array($cart) ) return [];
                foreach ( $cart as $key => $item ) {
                    $cart[$key]['id']       = sanitize_text_field( $item['id'] );
                    $cart[$key]['price']    = floatval( $item['price'] );
                }

            return $cart;
        }

        public function get_seats_include_tax( $room_seats ) {
            if ( empty( $room_seats ) || ! is_array( $room_seats ) ) return array();

            foreach( $room_seats as $k => $item ) {
                if ( $item['price'] ) {
                    $price = $this->get_price_include_tax( $item['price'] );

                    $room_seats[$k]['price'] = $price;
                }
            }

            return $room_seats;
        }

        public function get_price_from_cart( $cart_data ) {
            $incl_tax   = MB()->options->tax_fee->get( 'prices_include_tax', 'no' );
            $enable_tax = MB()->options->tax_fee->get( 'enable_tax' );
            $price      = 0;

            if ( ! empty( $cart_data ) && is_array( $cart_data ) ) {
                foreach( $cart_data as $item ) {
                    if ( isset( $item['qty'] ) && absint( $item['qty'] ) ) {
                        $price += isset( $item['price'] ) ? floatval( $item['price'] ) * absint( $item['qty'] ) : 0;
                    } else {
                        $price += isset( $item['price'] ) ? floatval( $item['price'] ) : 0;
                    }
                }
            }

            if ( 'yes' === $enable_tax && 'yes' === $incl_tax ) {
                return $this->get_price_include_tax( floatval( $price ) );
            }

            return floatval( $price );
        }

        public function get_price_include_tax( $price ) {
            $tax_type           = MB()->options->tax_fee->get( 'type_tax' );
            $number_decimals    = MBC()->mb_get_currency_minor_unit();

            if ( $tax_type === 'percent' ) {
                $tax_fee            = (float)MB()->options->tax_fee->get( 'pecent_tax' );
                $regular_tax_rate   = ( 1 + $tax_fee ) / 100;
                $the_rate           = ( $regular_tax_rate / 100 ) / $regular_tax_rate * $tax_fee;
                $net_price          = $price - ( $the_rate * $price );

                return round( $net_price, $number_decimals );
            }

            if ( $tax_type === 'amount' ) {
                $tax_fee    = MB()->options->tax_fee->get( 'amount_tax' );
                $net_price  = $price - $tax_fee;

                return round( $net_price, $number_decimals );
            }

            return $price;
        }

        public function get_price_discount( $discount_code, $movie_id, $subtotal ) {
            if ( ! $discount_code || ! $movie_id || ! $subtotal ) return 0;

            $total_discount = 0;
            $data_discount  = $this->check_code_discount( $movie_id, $discount_code );

            if ( $data_discount ) {
                $discount = json_decode( $data_discount, true );

                if ( ! empty( $discount ) && is_array( $discount ) ) {

                    if ( $discount['type'] === 'percent' ) {
                        $total_discount = ( floatval( $discount['value'] ) * $subtotal ) / 100;
                    }

                    if ( $discount['type'] === 'amount' ) {
                        $total_discount = floatval( $discount['value'] );
                    }
                }
            }

            return floatval( $total_discount );
        }

        public function get_price_tax( $subtotal ) {
            if ( ! $subtotal ) return 0;

            $total_tax  = 0;
            $enable_tax = MB()->options->tax_fee->get( 'enable_tax' );
            $tax_type   = MB()->options->tax_fee->get( 'type_tax' );

            if ( $enable_tax === 'yes' ) {
                if ( $tax_type === 'percent' ) {
                    $tax_fee    = MB()->options->tax_fee->get( 'pecent_tax' );
                    $total_tax  = ( floatval( $tax_fee ) * $subtotal ) / 100;
                }

                if ( $tax_type === 'amount' ) {
                    $tax_fee    = MB()->options->tax_fee->get( 'amount_tax' );
                    $total_tax  = floatval( $tax_fee );
                }
            }

            return floatval( $total_tax );
        }

        public function get_price_ticket_fee( $subtotal = 0, $count_ticket = 0 ) {
            if ( ! $subtotal || ! $count_ticket ) return 0;

            $total_ticket_fee   = 0;
            $enable_ticket_fee  = MB()->options->tax_fee->get( 'enable_ticket_fee' );
            $type_ticket_fee    = MB()->options->tax_fee->get( 'type_ticket_fee' );

            if ( $enable_ticket_fee === 'yes' ) {
                if ( $type_ticket_fee === 'percent' ) {
                    $ticket_fee         = MB()->options->tax_fee->get( 'pecent_ticket_fee' );
                    $total_ticket_fee   = ( floatval( $ticket_fee ) * $subtotal ) / 100;
                }

                if ( $type_ticket_fee === 'amount' ) {
                    $ticket_fee         = MB()->options->tax_fee->get( 'amount_ticket_fee' );
                    $total_ticket_fee   = floatval( $ticket_fee ) * absint( $count_ticket );
                }
            }

            return floatval( $total_ticket_fee );
        }
    }

    return new MB_Cart();
}