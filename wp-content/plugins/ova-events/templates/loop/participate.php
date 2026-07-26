<?php if ( !defined( 'ABSPATH' ) ) exit(); 

if( isset( $args['id'] ) ){
	$id = $args['id'];
}else{
	$id = get_the_id();	
}

$ovaev_booking_links = get_post_meta( $id, 'ovaev_booking_links', true );

?>

<?php if ( $ovaev_booking_links ): ?>
	<div class="button_event participate">
		<a class="view_detail participate" href="<?php echo esc_url( $ovaev_booking_links ); ?>" target="_blank">
			<?php esc_html_e( 'Register now', 'ovaev' );?>
		</a>
	</div>
<?php endif; ?>