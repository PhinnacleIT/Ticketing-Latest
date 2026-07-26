<?php

if( !defined( 'ABSPATH' ) ) exit();

global $post;


$ovaev_map_name    = get_post_meta( $post->ID , 'ovaev_map_name', true ) ? get_post_meta( $post->ID ,'ovaev_map_name', true ) : esc_html__('New York', 'ovaev');
$ovaev_map_address = get_post_meta( $post->ID , 'ovaev_map_address', true ) ? get_post_meta( $post->ID ,'ovaev_map_address', true ) : '' ;
$ovaev_map_lat     = get_post_meta( $post->ID , 'ovaev_map_lat', true ) ? get_post_meta( $post->ID ,'ovaev_map_lat', true ) : '';
$ovaev_map_lng     = get_post_meta( $post->ID , 'ovaev_map_lng', true ) ? get_post_meta( $post->ID ,'ovaev_map_lng', true ) : '';

?>
<div class="ovaev_metabox">

	<br>
	<div class="ovaev_row">

		<div class="ovaev_map">
			<label class="label"><strong><?php esc_html_e( 'Map', 'ovaev' ); ?>: </strong></label>
			
			<input id="pac-input" value="<?php echo esc_attr($ovaev_map_address); ?>" class="controls" type="text" placeholder="<?php esc_html_e( 'Enter a venue', 'ovaev' ); ?>" autocomplete="off">

			<div id="show_map"></div>

			<div id="infowindow-content">
				<span id="place-name"  class="title"><?php echo esc_attr($ovaev_map_name); ?></span><br>
				<span id="place-address"><?php echo esc_attr($ovaev_map_address); ?></span>
			</div>

			<input type="hidden" value="<?php echo esc_attr($ovaev_map_name); ?>" name="ovaev_map_name" id="ovaev_map_name"  autocomplete="off"/>	

			<label>
				<?php esc_html_e( 'Address: ', 'ovaev' ); ?>
				<input type="text" value="<?php echo esc_attr($ovaev_map_address); ?>" name="ovaev_map_address" id="ovaev_map_address" autocomplete="off"/>
			</label>

			&nbsp;&nbsp;&nbsp;

			<label>
				<?php esc_html_e( 'Latitude: ', 'ovaev' ); ?>
				<input type="text" value="<?php echo  trim(esc_attr($ovaev_map_lat)); ?>" name="ovaev_map_lat" id="ovaev_map_lat"  autocomplete="off"/>	
			</label>

			&nbsp;&nbsp;&nbsp;

			<label>

				<?php esc_html_e( 'Longitude: ', 'ovaev' ); ?>
				<input type="text" value="<?php echo trim(esc_attr($ovaev_map_lng)); ?>" name="ovaev_map_lng" id="ovaev_map_lng" autocomplete="off"/>	
			</label>

		</div>

	</div>
	<br>


</div>

<?php wp_nonce_field( 'ovaev_nonce', 'ovaev_nonce' ); ?>