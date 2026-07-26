<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MB_Setting' ) ) {
    class MB_Setting {

        protected static $_instance = null;
        public $_options            = null;
        public $_id                 = null;
        public $_prefix             = 'ova_mb_setting';

        public function __construct( $prefix = null, $id = null ) {

            if ( $prefix ) {
                $this->_prefix = $prefix;
            }

            $this->_id = $id;

            // Load options
            $this->options();

            // Save, Update setting
            add_filter( 'mb_admin_menus', array( $this, 'setting_page' ), 10, 1 );
            add_action( 'admin_init', array( $this, 'register_setting' ) );
        }

        public function __get( $id = null ) {
            $settings = apply_filters( 'mb_settings_field', array() );

            if ( array_key_exists( $id, $settings ) ) {
                return $settings[ $id ];
            }

            return null;
        }
        
        public function register_setting() {
            register_setting( $this->_prefix, $this->_prefix );
        }

        public function setting_page( $menus ){
            $menus[] = array(
                'edit.php?post_type=movie',
                __( 'Movie Settings', 'moviebooking' ),
                __( 'Settings', 'moviebooking' ),
                'manage_options',
                'ova_mb_setting',
                array( $this, 'register_options_page' )
            );
            
            return $menus;
        }


        /**
         * register option page
         * @return
         */
        public function register_options_page() {
            MB()->_include( MB_PLUGIN_INC . 'admin/views/settings/settings.php' );
        }

        protected function options() {
            if ( $this->_options ) {
                return $this->_options;
            }

            return $this->_options = get_option( $this->_prefix, null );
        }

        public function get( $name = null, $default = null ) {
            if ( ! $this->_options ) {
                $this->_options = $this->options();
            }

            if ( $name && isset( $this->_options[ $name ] ) ) {
                return $this->_options[ $name ];
            }

            return $default;
        }
        
        static function instance( $prefix = null, $id = null ) {
            if ( ! empty( self::$_instance[ $prefix ] ) ) {
                return self::$_instance[ $prefix ];
            }

            return self::$_instance[ $prefix ] = new self( $prefix, $id );
        }
    }
}