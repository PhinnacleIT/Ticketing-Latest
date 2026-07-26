<?php if ( !defined( 'ABSPATH' ) ) exit();

if( isset( $args['id'] ) ){
	$id = $args['id'];
}else{
	$id = get_the_id();	
}

$ovaev_start_date = get_post_meta( $id, 'ovaev_start_date_time', true );
$date_event    = $ovaev_start_date != '' ? date_i18n('d', $ovaev_start_date ) : '';
$month_event_M = $ovaev_start_date != '' ? date_i18n('M', $ovaev_start_date ) : '';
$year_event    = $ovaev_start_date != '' ? date_i18n('Y', $ovaev_start_date ) : '';

$full_date_event    = $date_event . ' ' . $month_event_M . ', ' . $year_event;

if( $ovaev_start_date != '' ){ ?>

<div class="date-event">

	<span class="date">
		<?php echo esc_html($full_date_event);?>
	</span>

</div>

<?php } ?>