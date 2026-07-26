<?php

if( !defined( 'ABSPATH' ) ) exit();

global $post;

$lang 				= OVAEV_Settings::archive_format_date_lang();
$date_format 		= OVAEV_Settings::archive_event_format_date();
$time 				= OVAEV_Settings::archive_event_format_time();

$ovaev_start_date 	= get_post_meta( $post->ID, 'ovaev_start_date', true );
$ovaev_end_date   	= get_post_meta( $post->ID, 'ovaev_end_date', true );

$ovaev_start_time 	= get_post_meta( $post->ID, 'ovaev_start_time', true );
$ovaev_end_time   	= get_post_meta( $post->ID, 'ovaev_end_time', true );

$ovaev_start_date_time 	= get_post_meta( $post->ID, 'ovaev_start_date_time', true );
$ovaev_end_date_time   	= get_post_meta( $post->ID, 'ovaev_end_date_time', true );

$ovaev_venue       	= get_post_meta( $post->ID, 'ovaev_venue', true );

$checked           	= get_post_meta( $post->ID, 'ovaev_special', true ) ? get_post_meta( $post->ID, 'ovaev_special', true ) : '' ;

$event_custom_sort 	= get_post_meta( $post->ID, 'event_custom_sort', true ) ? get_post_meta( $post->ID, 'event_custom_sort', true ) : '1' ;

$booking_links 		= get_post_meta( $post->ID, 'ovaev_booking_links', true ) ? get_post_meta( $post->ID, 'ovaev_booking_links', true ) : '' ;

$event_template 	= get_post_meta( $post->ID, 'event_template', true ) ? get_post_meta( $post->ID, 'event_template', true ) : 'global' ;
$selected 			= ( 'global' == $event_template ) ? ' selected ' : '';
$templates 			= get_posts( array('post_type' => 'elementor_library', 'meta_key' => '_elementor_template_type', 'meta_value' => 'page' ) );

?>
<div class="ovaev_metabox">

	<br>
	<div class="ovaev_row">
		<label class="label"><strong><?php esc_html_e( 'Start date:', 'ovaev' ); ?></strong></label>
		<input data-date="<?php echo esc_attr( $date_format ) ?>" type="text" id="ovaev_start_date" class="ovaev_start_date" value="<?php echo esc_attr($ovaev_start_date); ?>" placeholder="<?php echo esc_attr( $date_format ) ?>"  name="ovaev_start_date" autocomplete="off" />
	</div>
	<br>

	<div class="ovaev_row">
		<label class="label"><strong><?php esc_html_e( 'Start Time:', 'ovaev' ); ?></strong></label>
		<input data-time="<?php echo esc_attr( $time ) ?>" type="text" id="ovaev_start_time" value="<?php echo esc_attr($ovaev_start_time); ?>" class="ovaev_time_picker" placeholder="<?php echo esc_attr( $time ) ?>"  name="ovaev_start_time" autocomplete="off" />
	</div>
	<br>

	<div class="ovaev_row">
		<label class="label"><strong><?php esc_html_e( 'End date:', 'ovaev' ); ?></strong></label>
		<input data-date="<?php echo esc_attr( $date_format ) ?>" type="text" id="ovaev_end_date" class="ovaev_end_date" value="<?php echo esc_attr($ovaev_end_date); ?>" placeholder="<?php echo esc_attr( $date_format ) ?>"  name="ovaev_end_date" autocomplete="off" />
	</div>
	<br>

	<div class="ovaev_row">
		<label class="label"><strong><?php esc_html_e( 'End Time:', 'ovaev' ); ?></strong></label>
		<input data-time="<?php echo esc_attr( $time ) ?>" type="text" id="ovaev_end_time" value="<?php echo esc_attr($ovaev_end_time); ?>" class="ovaev_time_picker" placeholder="<?php echo esc_attr( $time ) ?>"  name="ovaev_end_time" autocomplete="off" />
	</div>
	<br>


	<div class="ovaev_row">
		<label class="label"><strong><?php esc_html_e( 'Venue:', 'ovaev' ); ?></strong></label>
		<input type="text" id="ovaev_venue" value="<?php echo esc_attr($ovaev_venue); ?>" placeholder="<?php esc_html_e( 'No. 1, Broadway, New York', 'ovaev' ); ?>"  name="ovaev_venue" autocomplete="off" />
	</div>
	<br>

	<div class="ovaev_row">
		<label class="label"><strong><?php esc_html_e( 'Special Event:', 'ovaev' ); ?></strong></label>
		<input type="checkbox" value="<?php echo esc_attr($checked); ?>" name="ovaev_special" <?php echo esc_attr($checked); ?> />
	</div>
	<br>

	<div class="ovaev_row">
		<label class="label"><strong><?php esc_html_e( 'Custom Sort:', 'ovaev' ); ?></strong></label>
		<input type="number" value="<?php echo esc_attr($event_custom_sort); ?>" name="event_custom_sort" />
	</div>
	<br>
	<div class="ovaev_row">
		<label class="label"><strong><?php esc_html_e( 'Booking Links:', 'ovaev' ); ?></strong></label>
		<input type="text" id="ovaev_booking_links" value="<?php echo esc_attr($booking_links); ?>" placeholder="<?php esc_html_e( '#', 'ovaev' ); ?>"  name="ovaev_booking_links" autocomplete="off" />
	</div>
	<br>
	<div class="ovaev_row">
		<label class="label"><strong><?php esc_html_e( 'Templates:', 'ovaev' ); ?></strong></label>
		<select name="event_template" id="ovaev_event_templates">
				<option <?php echo esc_attr( $selected ); ?> value="global"><?php echo esc_html__('Global', 'ovaev') ?></option>
			<?php if ( ! empty( $templates ) ):
				foreach( $templates as $template ):
					$id 		= $template->ID;
					$title 		= $template->post_title;
					$selected 	= ( $id == $event_template ) ? ' selected ' : '';
			?>
				<option <?php echo esc_attr( $selected ); ?> value="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $title ); ?></option>
			<?php  endforeach; endif; ?>
		</select>
	</div>

</div>

<?php wp_nonce_field( 'ovaev_nonce', 'ovaev_nonce' ); ?>