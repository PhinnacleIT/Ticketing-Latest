<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}


if ( ! class_exists( 'MB_Admin_Menus' ) ) {

    class MB_Admin_Menus {

        protected static $_instance = null;
        public $_menus = array();

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        public function __construct(){
            // Add menus.
            add_action( 'admin_menu', array( $this, 'admin_menu' ) );
        }

        public function admin_menu() {
            $menus = apply_filters( 'mb_admin_menus', $this->_menus );

            foreach( $menus as $menu ) {
                call_user_func_array( 'add_submenu_page', $menu );
            }
        }

        public function add_menu( $params ) {
            $this->_menus[] = $params;
        }
    }

    return new MB_Admin_Menus();
}