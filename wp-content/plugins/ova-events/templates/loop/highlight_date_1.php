<?php if ( !defined( 'ABSPATH' ) ) exit();

if( isset( $args['id'] ) ){
	$id = $args['id'];
}else{
	$id = get_the_id();	
}

$ovaev_start_date = get_post_meta( $id, 'ovaev_start_date_time', true );
$date_event    = $ovaev_start_date != '' ? date_i18n('d', $ovaev_start_date ) : '';
$month_event_M = $ovaev_start_date != '' ? date_i18n('M', $ovaev_start_date ) : '';

if( $ovaev_start_date != '' ){ ?>

<div class="date-event">
	<span class="date"><?php echo esc_html($date_event);?></span>
	<span class="month"><?php echo esc_html($month_event_M);?></span>
</div>

<?php } ?>