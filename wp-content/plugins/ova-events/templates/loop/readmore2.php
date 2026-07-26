<?php if ( !defined( 'ABSPATH' ) ) exit(); 

if( isset( $args['id'] ) ){
	$id = $args['id'];
}else{
	$id = get_the_id();	
}


?>

<div class="button_event">
	<a class="view_detail second_font" href="<?php echo get_the_permalink( $id ); ?>">
		<?php esc_html_e( 'Read More', 'ovaev' );?>
	</a>
</div>