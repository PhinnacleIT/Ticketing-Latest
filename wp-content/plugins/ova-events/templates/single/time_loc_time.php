<?php if ( !defined( 'ABSPATH' ) ) exit(); 

$post_ID = get_the_ID();

$time_format = OVAEV_Settings::archive_event_format_time();

$ovaev_start_time = get_post_meta( $post_ID, 'ovaev_start_time', true );
$ovaev_end_time   = get_post_meta( $post_ID, 'ovaev_end_time', true );

$time_start    =  $ovaev_start_time ? date($time_format, strtotime($ovaev_start_time)) : '';
$time_end      = $ovaev_end_time ? date($time_format, strtotime($ovaev_end_time)) : '';

?>

<?php if( ! empty( $time_start ) && ! empty( $time_end ) ) { ?>
	<div class="wrap-time wrap-pro">
		<i class="fas fa-clock"></i>
		<span class="second_font general-content"><?php echo esc_html($time_start); ?> - </span>
		<span class="second_font general-content"><?php echo esc_html($time_end); ?></span>
	</div>
<?php } ?>

