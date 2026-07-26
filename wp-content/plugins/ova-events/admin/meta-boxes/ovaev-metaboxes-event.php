<?php 

if( !defined( 'ABSPATH' ) ) exit();

if( !class_exists( 'OVAEV_metaboxes_render_event' ) ){

	class OVAEV_metaboxes_render_event{

		public static function render(){

			require_once( OVAEV_PLUGIN_PATH. '/admin/views/ovaev-metabox-event.php' );

		}

		public static function save($post_id, $post_data){
			
			if( empty($post_data) ) exit();

			// Checked Special
			if( array_key_exists('ovaev_special', $post_data) == false ){
				$post_data['ovaev_special'] = '';
			}else{
				$post_data['ovaev_special'] = 'checked';
			}

			// Check gallery exits
			if( ! isset( $post_data['ovaev_gallery_id'] ) ){
				$post_data['ovaev_gallery_id'] = '';
			}

			if( ! empty( $post_data['ovaev_start_date'] ) ){
				$post_data['ovaev_start_date_time'] = strtotime( $post_data['ovaev_start_date'] . ' ' . $post_data['ovaev_start_time'] );
			} else {
				$post_data['ovaev_start_date_time'] = '';
			}

			if( ! empty( $post_data['ovaev_end_date'] ) ){
				$post_data['ovaev_end_date_time'] = strtotime( $post_data['ovaev_end_date'] . ' ' . $post_data['ovaev_end_time'] );
			} else {
				$post_data['ovaev_end_date_time'] = '';
			}

			foreach ($post_data as $key => $value) {

				update_post_meta( $post_id, $key, $value );
			}
		}
	}
}
?>