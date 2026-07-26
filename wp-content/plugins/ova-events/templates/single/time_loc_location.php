<?php if ( !defined( 'ABSPATH' ) ) exit(); 

$post_ID = get_the_ID();

$event_venue       = get_post_meta( $post_ID, 'ovaev_venue', true);

?>

<?php if( ! empty( $event_venue ) ) { ?>
	<div class="wrap-location wrap-pro">
		<i class="fas fa-map-marker-alt"></i>
		<span class="second_font general-content"><?php echo esc_html( $event_venue ) ?></span>
	</div>
<?php } ?>