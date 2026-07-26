<?php
defined( 'ABSPATH' ) || exit();

if( !class_exists( 'OVAEV_admin_menu' ) ){

	class OVAEV_admin_menu{

		public function __construct(){
			$this->init();
		}

		public function init(){
			add_action( 'admin_menu', array( $this, 'OVAEV_register_menu' ) );
		}

		public function OVAEV_register_menu(){

			// Get Options
			
			add_menu_page( 
				esc_html__( 'Events', 'ovaev' ), 
				esc_html__( 'Events', 'ovaev' ), 
				'edit_posts',
				'ovaev-menu', 
				null,
				'dashicons-calendar', 
				20
			);

			add_submenu_page( 
				'ovaev-menu', 
				esc_html__( 'Add New', 'ovaev' ), 
				esc_html__( 'Add New', 'ovaev' ), 
				'administrator',
				'post-new.php?post_type=event'
			);

			add_submenu_page( 
				'ovaev-menu', 
				esc_html__( 'Categories', 'ovaev' ), 
				esc_html__( 'Categories', 'ovaev' ), 
				'administrator',
				'edit-tags.php?taxonomy=event_category'.'&post_type=event'
			);

			add_submenu_page( 
				'ovaev-menu', 
				esc_html__( 'Tags', 'ovaev' ), 
				esc_html__( 'Tags', 'ovaev' ), 
				'administrator',
				'edit-tags.php?taxonomy=event_tag'.'&post_type=event'
			);

			add_submenu_page( 
				'ovaev-menu', 
				esc_html__( 'Settings', 'ovaev' ),
				esc_html__( 'Settings', 'ovaev' ),
				'administrator',
				'ovaev_general_settings',
				array( 'OVAEV_Admin_Settings', 'create_admin_setting_page' )
			);

		}

	}
	new OVAEV_admin_menu();

}