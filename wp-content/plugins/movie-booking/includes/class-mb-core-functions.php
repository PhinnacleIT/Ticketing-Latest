<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class MovieBooking_Core {
    /**
     * instance
     * @var null
     */
    protected static $_instance = null;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function mb_get_currency() {
        return apply_filters( 'mb_ft_get_currency', get_woocommerce_currency_symbol() );
    }

    public function mb_get_currency_position() {
        return apply_filters( 'mb_ft_get_currency_position', get_option( 'woocommerce_currency_pos' ) );
    }

    public function mb_get_currency_thousand_separator() {
        return apply_filters( 'mb_ft_get_currency_thousand_separator', wc_get_price_thousand_separator() );
    }

    public function mb_get_currency_decimal_separator() {
        return apply_filters( 'mb_ft_get_currency_decimal_separator', wc_get_price_decimal_separator() );
    }

    public function mb_get_currency_minor_unit() {
        return apply_filters( 'mb_ft_get_currency_minor_unit', wc_get_price_decimals() );
    }

    public function mb_get_taxonomies( $taxonomy = '', $include = [], $exclude = [], $fields = 'all', $hide_empty = 0, $parent = 0 ) {
        if ( ! $taxonomy ) return false;

        $args = array(
            'taxonomy'      => $taxonomy,
            'orderby'       => 'name',
            'order'         => 'ASC',
            'hide_empty'    => $hide_empty,
            'include'       => $include,
            'exclude'       => $exclude,
            'fields'        => $fields,
            'parent'        => $parent,
        );

        $taxonomy_query = apply_filters( 'mb_ft_get_taxonomies', $args );
        $taxonomies     = get_categories( $taxonomy_query );

        return $taxonomies;
    }

    public function mb_get_taxonomy_name( $term_id, $taxonomy = '' ) {
        if ( ! $term_id ) return;

        $term = get_term( $term_id, $taxonomy );

        if ( $term && is_object( $term ) ) {
            return $term->name;
        }
    }

    public function mb_get_language() {
        $language = MB()->options->general->get( 'mb_calenadar_language', 'en' );

        if ( function_exists( 'pll_current_language' ) ) {
            $language = pll_current_language();
        }

        if ( has_filter( 'wpml_current_language' ) ) {
            if ( apply_filters( 'wpml_current_language', $language ) ) {
                $language = apply_filters( 'wpml_current_language', $language );
            }
        }

        return apply_filters( 'mb_ft_get_language', $language );
    }

    public function mb_get_first_day() {
        $first_day = MB()->options->general->get( 'mb_day_of_week_start', '1' );

        return apply_filters( 'mb_ft_get_first_day', $first_day );
    }

    public function mb_get_date_format() {
        $date_format = MB()->options->general->get( 'mb_date_format', 'd-m-Y' );

        return apply_filters( 'mb_ft_get_date_format', $date_format );
    }

    public function mb_get_time_format() {
        $time_format = MB()->options->general->get( 'mb_time_format', 'H:i' );

        return apply_filters( 'mb_time_format', $time_format );
    }

    public function mb_get_date_time_format() {
        $date_time_format = $this->mb_get_date_format() . ' ' . $this->mb_get_time_format();

        return apply_filters( 'mb_ft_get_date_time_format', $date_time_format );
    }

    public function mb_get_time_step() {
        $time_step = MB()->options->general->get( 'mb_step_time', '15' );

        return apply_filters( 'mb_ft_get_time_step', $time_step );
    }

    public function mb_get_time_default() {
        $time_default = MB()->options->general->get( 'mb_default_time', '00:00' );

        return apply_filters( 'mb_ft_get_time_default', $time_default );
    }

    public function mb_get_language_support() {
        $language = array(
            'ar'    => esc_html__( 'Arabic', 'moviebooking' ),
            'az'    => esc_html__( 'Azerbaijanian', 'moviebooking' ),
            'bg'    => esc_html__( 'Bulgarian', 'moviebooking' ),
            'bs'    => esc_html__( 'Bosanski', 'moviebooking' ),
            'ca'    => esc_html__( 'Català', 'moviebooking' ),
            'ch'    => esc_html__( 'Simplified Chinese', 'moviebooking' ),
            'cs'    => esc_html__( 'Čeština', 'moviebooking' ),
            'da'    => esc_html__( 'Dansk', 'moviebooking' ),
            'de'    => esc_html__( 'German', 'moviebooking' ),
            'el'    => esc_html__( 'Ελληνικά', 'moviebooking' ),
            'en'    => esc_html__( 'English', 'moviebooking' ),
            'en-GB' => esc_html__( 'English (British)', 'moviebooking' ),
            'es'    => esc_html__( 'Spanish', 'moviebooking' ),
            'et'    => esc_html__( 'Eesti', 'moviebooking' ),
            'eu'    => esc_html__( 'Euskara', 'moviebooking' ),
            'fa'    => esc_html__( 'Persian', 'moviebooking' ),
            'fi'    => esc_html__( 'Finnish (Suomi)', 'moviebooking' ),
            'fr'    => esc_html__( 'French', 'moviebooking' ),
            'gl'    => esc_html__( 'Galego', 'moviebooking' ),
            'he'    => esc_html__( 'Hebrew', 'moviebooking' ),
            'hr'    => esc_html__( 'Hrvatski', 'moviebooking' ),
            'hu'    => esc_html__( 'Hungarian', 'moviebooking' ),
            'id'    => esc_html__( 'Indonesian', 'moviebooking' ),
            'it'    => esc_html__( 'Italian', 'moviebooking' ),
            'ja'    => esc_html__( 'Japanese', 'moviebooking' ),
            'ko'    => esc_html__( 'Korean', 'moviebooking' ),
            'kr'    => esc_html__( 'Korean', 'moviebooking' ),
            'lt'    => esc_html__( 'Lithuanian', 'moviebooking' ),
            'lv'    => esc_html__( 'Latvian', 'moviebooking' ),
            'mk'    => esc_html__( 'Macedonian', 'moviebooking' ),
            'mn'    => esc_html__( 'Mongolian', 'moviebooking' ),
            'nl'    => esc_html__( 'Dutch', 'moviebooking' ),
            'no'    => esc_html__( 'Norwegian', 'moviebooking' ),
            'pl'    => esc_html__( 'Polish', 'moviebooking' ),
            'pt'    => esc_html__( 'Portuguese', 'moviebooking' ),
            'pt-BR' => esc_html__( 'Português(Brasil)', 'moviebooking' ),
            'ro'    => esc_html__( 'Romanian', 'moviebooking' ),
            'ru'    => esc_html__( 'Russian', 'moviebooking' ),
            'se'    => esc_html__( 'Swedish', 'moviebooking' ),
            'sk'    => esc_html__( 'Slovenčina', 'moviebooking' ),
            'sl'    => esc_html__( 'Slovenščina', 'moviebooking' ),
            'sq'    => esc_html__( 'Albanian', 'moviebooking' ),
            'sr'    => esc_html__( 'Serbian Cyrillic', 'moviebooking' ),
            'sr-YU' => esc_html__( 'Serbian', 'moviebooking' ),
            'sv'    => esc_html__( 'Svenska', 'moviebooking' ),
            'th'    => esc_html__( 'Thai', 'moviebooking' ),
            'tr'    => esc_html__( 'Turkish', 'moviebooking' ),
            'uk'    => esc_html__( 'Ukrainian', 'moviebooking' ),
            'vi'    => esc_html__( 'Vietnamese', 'moviebooking' ),
            'zh'    => esc_html__( 'Simplified Chinese', 'moviebooking' ),
            'zh-TW' => esc_html__( 'Traditional Chinese', 'moviebooking' ),
        );

        return apply_filters( 'mb_ft_get_language_support', $language );
    }

    public function recursive_sanitize_text_field( $array ) {
        foreach ( $array as $key => &$value ) {
            if ( is_array( $value ) ) {
                $value = recursive_sanitize_text_field($value);
            }
            else {
                $value = sanitize_text_field( $value );
            }
        }

        return $array;
    }
}