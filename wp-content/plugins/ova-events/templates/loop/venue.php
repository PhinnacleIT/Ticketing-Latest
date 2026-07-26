<?php if ( !defined( 'ABSPATH' ) ) exit(); 

if( isset( $args['id'] ) ){
	$id = $args['id'];
}else{
	$id = get_the_id();	
}


$ovaev_venue = get_post_meta( $id, 'ovaev_venue', true ); 

?>

<?php if( ! empty( $ovaev_venue ) ) { ?>
	<div class="venue">
		<i class="fas fa-map-marker-alt icon_event"></i>
		<span class="number"><?php echo esc_html( $ovaev_venue ); ?></span>
	</div>
<?php } ?>