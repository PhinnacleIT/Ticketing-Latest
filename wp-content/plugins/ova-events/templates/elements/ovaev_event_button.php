<?php if ( !defined( 'ABSPATH' ) ) exit(); 

if( isset( $args['id'] ) ){
	$id = $args['id'];
}else{
	$id = get_the_id();	
}

$target 	 = $args['target'] ? ' target="_blank"' : '';
$booking_url = get_post_meta( $id, 'ovaev_booking_links', true );

?>

<?php if ( $booking_url ): ?>
	<div class="ovaev-booking-btn">
		<a href="<?php echo esc_url( $booking_url ); ?>"<?php echo esc_attr( $target ); ?>>
			<?php esc_html_e( 'Register Now', 'ovaev' ); ?>
		</a>
	</div>
<?php endif; ?>