<?php if ( !defined( 'ABSPATH' ) ) exit(); 

	$id 	= $args['id'];
	$class 	= $args['class'];
	$icon 	= $args['icon'];

	$time_format 		= OVAEV_Settings::archive_event_format_time();
	$post_start_time 	= get_post_meta( $id, 'ovaev_start_time', true );
	$post_end_time   	= get_post_meta( $id, 'ovaev_end_time', true );
	$start_time    		= $post_start_time 	? date( $time_format, strtotime( $post_start_time ) ) 	: '';
	$end_time      		= $post_end_time 	? date( $time_format, strtotime( $post_end_time ) ) 	: '';
?>

<?php if ( ! empty( $start_time ) && ! empty( $end_time ) ): ?>
	<div class="ovaev-shortcode-time<?php echo ' '.esc_html( $class ); ?>">
		<i class="<?php echo esc_attr( $icon ); ?>"></i>
		<span class="second_font"><?php echo esc_html( $start_time ); ?></span>
		<span class="second_font"><?php echo esc_html_e( ' - ', 'ovaev' ); ?></span>
		<span class="second_font"><?php echo esc_html( $end_time ); ?></span>
	</div>
<?php endif; ?>