<?php
if ( ! defined( 'ABSPATH' ) ) exit();

	if( isset( $args['id'] ) && $args['id'] ) {
		$pid = $args['id'];
	} else {
		$pid = get_the_id();
	}

	$category 		= $args['category'];
	$filter_event 	= $args['filter_event'] ? $args['filter_event'] : 'all';

	$events 		= OVAEV_get_data::get_events_simple_calendar( $category, $filter_event );
	
?>

<div class="ovaev_simple_calendar" events='<?php echo $events; ?>'>
	<div class="ovaev_events_simple_calendar cal1"></div>
</div>
	
 