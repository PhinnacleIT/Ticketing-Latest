<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

final class MovieBooking {
    /**
     * instance
     * @var null
     */
    protected static $_instance = null;
    public $options             = null;
    public $cart                = null;
    public $checkout            = null;
    public $msg_session         = null;
    public $cart_session        = null;

    /**
     * MovieBooking Constructor.
     */
    public function __construct() {
        $this->includes();

        $this->options      = MB_Setting::instance();
        $this->cart         = MB_Cart::instance();
        $this->checkout     = MB_Checkout::instance();
        $this->msg_session  = MB_Sessions::instance('msg_session');
        $this->cart_session = MB_Sessions::instance('cart_session');
    }

    public function includes() {
        // Settings
        require_once MB_PLUGIN_INC . 'class-mb-setting.php';

        $folders = array( 'abstract', 'movie', 'showtime', 'room', 'booking', 'ticket', 'setting', 'shortcode' );
        $this->autoload( $folders );

        // General functions
        require_once MB_PLUGIN_INC . 'class-mb-general-functions.php';

        // Core functions
        require_once MB_PLUGIN_INC . 'class-mb-core-functions.php';

        // Assets
        require_once MB_PLUGIN_INC . 'class-mb-assets.php';

        // Template Loader
        require_once MB_PLUGIN_INC . 'class-mb-template-loader.php';
        require_once MB_PLUGIN_INC . 'mb-template-functions.php';
        require_once MB_PLUGIN_INC . 'mb-template-hooks.php';

        // Ajax
        require_once MB_PLUGIN_INC . 'class-mb-ajax.php';

        // Admin
        if ( $this->is_request( 'admin' ) ) {
            require_once MB_PLUGIN_INC . 'admin/class-mb-admin.php';
        }

        // Session
        require_once MB_PLUGIN_INC . 'class-mb-sessions.php';

        // Cart
        require_once MB_PLUGIN_INC . 'cart/class-mb-cart.php';

        // Checkout
        require_once MB_PLUGIN_INC . 'class-mb-checkout.php';

        // Email
        require_once MB_PLUGIN_INC . 'email/class-mb-email-functions.php';

        // Cron
        require_once MB_PLUGIN_INC . 'cron/class-mb-cron.php';

        // API
        require_once MB_PLUGIN_INC . 'api/vendor/autoload.php';
        require_once MB_PLUGIN_INC . 'api/class-mb-api.php';
    }

    /**
     * Main MovieBooking Instance 
     * Ensures only one instance of MovieBooking is loaded or can be loaded.
     * @return MovieBooking - Main instance.
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function options() {
        return MB_Setting::instance();
    }

    public function _include( $file ) {
        if ( ! $file ) {
            return;
        }

        if ( is_array( $file ) ) {
            foreach ( $file as $key => $f ) {
                if ( file_exists( MB_PLUGIN_PATH . $f ) ) {
                    require_once MB_PLUGIN_PATH . $f;
                }
            }
        } else {
            if ( file_exists( MB_PLUGIN_PATH . $file ) ) {
                require_once MB_PLUGIN_PATH . $file;
            } elseif ( file_exists( $file ) ) {
                require_once $file;
            }
        }
    }

    public function autoload( $folders ) {
        foreach ( $folders as $key => $folder ) {
            $real_folder = MB_PLUGIN_INC . $folder;
            foreach ( (array) glob( $real_folder . '/class-mb-' . $folder . '*.php' ) as $key => $file ) {
                $this->_include( $file );
            }
        }
    }

    private function is_request( $type ) {
        switch ( trim( $type ) ) {
            case 'admin':
                return is_admin();
            case 'ajax':
                return defined( 'DOING_AJAX' );
            case 'cron':
                return defined( 'DOING_CRON' );
            case 'frontend':
                return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' ) && ! $this->is_rest_api_request();
        }
    }
}