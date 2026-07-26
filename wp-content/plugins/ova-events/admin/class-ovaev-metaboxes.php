<?php 

if( !defined( 'ABSPATH' ) ) exit();

if( !class_exists( 'OVAEV_metaboxes' ) ){

	class OVAEV_metaboxes{

		public function __construct(){

			$this->require_metabox();


			add_action( 'add_meta_boxes', array( $this , 'OVAEV_add_metabox' ) );

			add_action( 'save_post', array( $this , 'OVAEV_save_metabox' ) );


			// Save
			add_action( 'ovaev_update_meta_event', array( 'OVAEV_metaboxes_render_event' ,'save' ), 10, 2 );

		}


		public function require_metabox(){

			require_once( OVAEV_PLUGIN_PATH.'admin/meta-boxes/ovaev-metaboxes-event.php' );

		}

		function OVAEV_add_metabox() {

			add_meta_box( 'ovaev-metabox-settings-event',
				'Events',
				array('OVAEV_metaboxes_render_event', 'render'),
				'event',
				'normal',
				'high'
			);

		}	

		function OVAEV_save_metabox($post_id) {

			// Bail if we're doing an auto save
			if ( empty( $_POST ) && defined( 'DOING_AJAX' ) && DOING_AJAX ) return;

			// if our nonce isn't there, or we can't verify it, bail
			if( !isset( $_POST['ovaev_nonce'] ) || !wp_verify_nonce( $_POST['ovaev_nonce'], 'ovaev_nonce' ) ) return;

			do_action( 'ovaev_update_meta_event', $post_id, $_POST );
			
		}

	}

	new OVAEV_metaboxes();

}
?>