<?php if ( !defined( 'ABSPATH' ) ) exit();
	$post_ID = get_the_ID();
	$ovaev_booking_links = get_post_meta( $post_ID, 'ovaev_booking_links', true );
?>

<?php if ( !empty($ovaev_booking_links) ): ?>
	<a href="<?php echo esc_html( $ovaev_booking_links ); ?>" target="_blank"><?php esc_html_e('Register Yourself','ovaev'); ?></a>
<?php endif; ?>