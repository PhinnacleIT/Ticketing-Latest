<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MB_Shortcode_Cart' ) ) {

    class MB_Shortcode_Cart extends MB_Shortcode {

        public $shortcode = 'mb_cart';

        public function __construct() {
            parent::__construct();
        }

        function add_shortcode( $args, $content = null ) {
            ob_start();

            $template = MB_Cart()->get_template_cart( $_GET );

            if ( $template ) {
                mb_get_template( $template, $_GET );
            }
            
            return ob_get_clean();
        }
    }

    new MB_Shortcode_Cart();
}