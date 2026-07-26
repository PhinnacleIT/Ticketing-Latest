<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// var_dump
if ( ! function_exists( 'dd' ) ) {
    function dd( ...$args ) {
        echo '<pre>';
        var_dump( ...$args );
        echo '</pre>';
        die;
    }
}

// class MB_Movie
if ( ! function_exists( 'MB_Movie' ) ) {
    function MB_Movie() {
        return MB_Movie::instance();
    }
}

// class MB_Room
if ( ! function_exists( 'MB_Room' ) ) {
    function MB_Room() {
        return MB_Room::instance();
    }
}

// class MB_Showtime
if ( ! function_exists( 'MB_Showtime' ) ) {
    function MB_Showtime() {
        return MB_Showtime::instance();
    }
}

// class MB_Cart
if ( ! function_exists( 'MB_Cart' ) ) {
    function MB_Cart() {
        return MB_Cart::instance();
    }
}

// class MB_Booking
if ( ! function_exists( 'MB_Booking' ) ) {
    function MB_Booking() {
        return MB_Booking::instance();
    }
}

// class MB_Ticket
if ( ! function_exists( 'MB_Ticket' ) ) {
    function MB_Ticket() {
        return MB_Ticket::instance();
    }
}

// class MB_Email
if ( ! function_exists( 'MB_Email' ) ) {
    function MB_Email() {
        return MB_Email::instance();
    }
}

// Get URL checkout page
if ( ! function_exists( 'mb_get_checkout_woo_page' ) ) {
    function mb_get_checkout_woo_page(){
        $checkout_url = wc_get_checkout_url();

        if ( ! $checkout_url ) {
            $checkout_url = home_url();
        }

        return apply_filters( 'mb_ft_get_checkout_woo_page', $checkout_url );
    }
}

// Convert Price
if ( ! function_exists( 'mb_price' ) ) {
    function mb_price( $price = 0 ) {
        $currency           = MBC()->mb_get_currency();
        $position           = MBC()->mb_get_currency_position();
        $thousand_separator = MBC()->mb_get_currency_thousand_separator();
        $decimal_separator  = MBC()->mb_get_currency_decimal_separator();
        $number_decimals    = MBC()->mb_get_currency_minor_unit();

        $thousand_separator = ( !empty( $thousand_separator ) ) ? $thousand_separator : ',';
        $decimal_separator  = ( !empty( $decimal_separator ) ) ? $decimal_separator : '.';
        $number_decimals    = ( !empty( $number_decimals ) ) ? $number_decimals : 0;
        $price              = ( !empty( $price ) ) ? $price : 0;

        $price = number_format( $price, intval( $number_decimals ), $decimal_separator, $thousand_separator );

        
        switch ( $position ) {
            case "left" : {
                $price = $currency . $price;
                break;
            }
            case "left_space" : {
                $price = $currency . ' ' . $price;
                break;
            }

            case "right" : {
                $price = $price . $currency ;
                break;
            }
            case "right_space" : {
                $price = $price . ' ' . $currency ;
                break;
            }
            default:
                $price = $currency . $price;
                break;
        }

        return $price;
    }
}

// Limit content
if ( ! function_exists( 'sub_string_word' ) ) {
    function sub_string_word( $content = "", $number = 0 ) {
        $content    = sanitize_text_field($content);
        $number     = (int)$number;
        if ( empty( $content ) || empty( $number ) ) return $content;

        $sub_string = substr($content, 0, $number);
        if ( $sub_string == $content ) return $content;

        $content = substr( $sub_string, 0, strrpos( $sub_string, ' ', 0 ) );

        return $content.'...';
    }
}

// Check exists array
if ( ! function_exists( 'mb_array_exists' ) ) {
    function mb_array_exists( $args ) {
        if ( ! empty( $args ) && is_array( $args ) ) {
            return true;
        }

        return false;
    }
}

// Sanitize Cart
if ( ! function_exists( 'mb_sanitize_cart' ) ) {
    function mb_sanitize_cart( $cart = array() ) {
        if ( mb_array_exists( $cart ) ) {
            foreach( $cart as $k => $item ) {
                $cart[$k]['id']     = sanitize_text_field( $item['id'] );
                $cart[$k]['price']  = floatval( $item['price'] );
            }
        }
                
        return $cart;
    }
}

// Check movie has showtimes or not
if ( ! function_exists( 'mb_movie_has_showtimes' ) ) {
    function mb_movie_has_showtimes( $id ) {

        $query_args = array(
            'post_type'      => 'showtime',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'fields'         => 'ids',
            'meta_query'     => array(
                array(
                    'key'       => 'ova_mb_showtime_movie_id',
                    'value'     => $id,
                    'compare'   => '=',
                ),
            )
        );

        if ( !empty ( get_posts($query_args) ) ) {
            $result = true;
        } else {
            $result = false;
        }   
            
        return $result;
    }
}

// check the movie release date has arrived or not
if ( ! function_exists( 'mb_movie_release_date_has_arrived' ) ) {
    function mb_movie_release_date_has_arrived( $id ) {

        $release_date = get_post_meta($id,'ova_mb_movie_release_date',true);

        $now = new DateTime();
        $current_timestamp = $now->getTimestamp();

        if ( $release_date <= $current_timestamp  ) {
            $result = true;
        } else {
            $result = false;
        }   
            
        return $result;
    }
}

// Check movie has related movies or not
if ( ! function_exists( 'mb_movie_has_related_movies' ) ) {
    function mb_movie_has_related_movies( $id, $category ) {
        
        $cat_ids = array();
        if(!empty($category) && !is_wp_error($category)) : foreach ($category as $cat):
            array_push($cat_ids, $cat->term_id);
        endforeach; endif;

        $query_args = array(
            'post_type' => 'movie',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'post__not_in'   => array($id),
            'tax_query' => array(
                array(
                    'taxonomy' => 'movie_cat',
                    'field' => 'term_id',
                    'terms' => $cat_ids
                )
            ),
        );

        if ( !empty ( get_posts($query_args) ) ) {
            $result = true;
        } else {
            $result = false;
        }   
            
        return $result;
    }
}