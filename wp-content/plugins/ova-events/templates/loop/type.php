<?php if ( !defined( 'ABSPATH' ) ) exit(); 

if( isset( $args['id'] ) ){
	$id = $args['id'];
}else{
	$id = get_the_id();	
}

$event_type  = get_the_terms( $id, 'event_category') ? get_the_terms( $id, 'event_category') : '' ;

$value_event_type = array();
if ( $event_type != '' ) {
	foreach ( $event_type as $value ) {
		$value_event_type[] = '<a class="event_type" href="'.get_term_link($value->term_id).'">' .$value->name. '</a>' ;
		
	}
}

if( $value_event_type ){
?>

<div class="post_cat">
	<?php echo implode(', ', $value_event_type); ?>
</div>

<?php } ?>