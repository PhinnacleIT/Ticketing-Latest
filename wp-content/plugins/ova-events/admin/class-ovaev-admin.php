<?php 

if( !defined( 'ABSPATH' ) ) exit();


if( !class_exists( 'OVAEV_admin' ) ){

	/**
	 * Make Admin Class
	 */
	class OVAEV_admin{
		public static $custom_meta_fields = array();

		/**
		 * Construct Admin
		 */
		public function __construct(){
			$this->init();

		}

		public function init(){
			require_once( OVAEV_PLUGIN_PATH. '/admin/class-ovaev-admin-menu.php' );
			require_once( OVAEV_PLUGIN_PATH. '/admin/class-ovaev-admin-assets.php' );
			require_once( OVAEV_PLUGIN_PATH. '/admin/class-ovaev-admin-settings.php' );
		}


	}
	new OVAEV_admin();
}