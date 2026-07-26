<?php if ( !defined( 'ABSPATH' ) ) exit(); 

if( isset( $args['id'] ) ){
	$id = $args['id'];
}else{
	$id = get_the_id();	
}


?>

<h2 class="second_font event_title">
	<a href="<?php echo get_the_permalink( $id );?>">
		<?php echo get_the_title( $id ); ?>
	</a>
</h2>