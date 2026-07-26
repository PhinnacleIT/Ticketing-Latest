<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MB_Admin' ) ) {
    class MB_Admin {

        public function __construct(){
            add_action( 'init', array( $this, 'includes' ) );
        }

        public function includes() {
            // Functions
            require_once MB_PLUGIN_INC . 'admin/class-mb-admin-functions.php';

            // Hook
            require_once MB_PLUGIN_INC . 'admin/class-mb-admin-hooks.php';

            // Menus class
            require_once MB_PLUGIN_INC . 'admin/class-mb-admin-menus.php';

            // Assets
            require_once MB_PLUGIN_INC . 'admin/class-mb-admin-assets.php';

            // Metabox class
            require_once MB_PLUGIN_INC . 'room/class-mb-room-metabox.php';
            require_once MB_PLUGIN_INC . 'showtime/class-mb-showtime-metabox.php';
            require_once MB_PLUGIN_INC . 'admin/class-mb-admin-metaboxes.php';

            // Ajax
            require_once MB_PLUGIN_INC . 'admin/class-mb-admin-ajax.php';

            // Importers
            require_once MB_PLUGIN_INC . 'admin/class-mb-admin-importers.php';

            // Exporters
            require_once MB_PLUGIN_INC . 'admin/class-mb-admin-exporters.php';

            // Statistical
            require_once MB_PLUGIN_INC . 'admin/class-mb-admin-statistical.php';
        }
    }

    return new MB_Admin();
}