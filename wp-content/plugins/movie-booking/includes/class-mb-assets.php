<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MB_Assets' ) ) {
    class MB_Assets {

        public function __construct() {
            add_action( 'wp_enqueue_scripts', array( $this, 'MB_Assets_enqueue_scripts' ) );
             /* Add JS for Elementor */
            add_action( 'elementor/frontend/after_register_scripts', array( $this, 'MB_Assets_elementor_scripts' ) );
        }

        public function MB_Assets_enqueue_scripts() {
            /* Fancybox */
            if ( is_single() ) {
                wp_enqueue_script( 'fancybox', MB_PLUGIN_URI.'assets/libs/fancybox/fancybox.umd.js', array('jquery'), false, true );
                wp_enqueue_style( 'fancybox', MB_PLUGIN_URI.'assets/libs/fancybox/fancybox.css' );
            }
            
            /* Frontend JS */
            wp_enqueue_script( 'mb_frontend', MB_PLUGIN_URI.'assets/js/frontend/script.min.js', array('jquery'), false, true );
            wp_localize_script( 'mb_frontend', 'ajax_object', array(
                'ajax_url'      => admin_url('admin-ajax.php'),
                'ajax_nonce'    => wp_create_nonce( apply_filters( 'mb_frontend_ajax_security', 'ajax_nonce_mb' ) ),
            ));

            /* Frontend CSS */
            wp_enqueue_style('mb_frontend', MB_PLUGIN_URI.'assets/css/frontend/style.css' );
        }

        // Add JS for elementor
        public function MB_Assets_elementor_scripts(){
            wp_enqueue_script( 'script-elementor', MB_PLUGIN_URI.'assets/js/elementor/script-elementor.js', [ 'jquery' ], false, true );
        }
    }

    return new MB_Assets();
}