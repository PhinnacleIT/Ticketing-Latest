<?php if ( !defined( 'ABSPATH' ) ) exit(); 

$get_search_cat = isset( $_GET["ovaev_type"] ) ? $_GET["ovaev_type"] : '';
$ovaev_start_date_search = isset( $_GET["ovaev_start_date_search"] ) ? $_GET["ovaev_start_date_search"] : '';
$ovaev_end_date_search = isset( $_GET["ovaev_end_date_search"] ) ? $_GET["ovaev_end_date_search"] : '';

if( is_tax( 'event_category' ) ||  get_query_var( 'event_category' ) != '' ){
	$get_search_cat = get_query_var( 'event_category' );
}

$lang = OVAEV_Settings::archive_format_date_lang();
$date_format = OVAEV_Settings::archive_event_format_date();
$time_format = OVAEV_Settings::archive_event_format_time();

?>

<div class="search_archive_event">

	<form action="<?php echo esc_url(get_post_type_archive_link( 'event' )); ?>" method="GET" name="search_event" autocomplete="off">
		
		<div class="start_date">

			<label class="second_font ova-label-search">
				<?php esc_html_e('Start Date', 'ovaev') ?>
			</label>

			<input type="text" 
				id="ovaev_start_date_search" 
				class="ovaev_start_date_search" 
				data-lang="<?php echo esc_attr($lang); ?>" 
				data-date="<?php echo esc_attr($date_format); ?>" 
				data-time="<?php echo esc_attr($time_format); ?>" 
				placeholder="<?php echo esc_attr__( 'Choose Date', 'ovaev' ); ?>" 
				name="ovaev_start_date_search" 
				value="<?php echo esc_attr( $ovaev_start_date_search ); ?>" 
			/>

			<i class="far fa-calendar-alt"></i>

		</div>

		<div class="end_date">

			<label class="second_font ova-label-search">
				<?php esc_html_e('End Date', 'ovaev') ?>
			</label>
			
			<input 
				type="text" 
				id="ovaev_end_date_search" 
				class="ovaev_end_date_search" 
				data-lang="<?php echo esc_attr($lang); ?>" 
				data-date="<?php echo esc_attr($date_format); ?>" 
				placeholder="<?php echo esc_attr__( 'Choose Date', 'ovaev' ); ?>" 
				name="ovaev_end_date_search" 
				value="<?php echo esc_attr( $ovaev_end_date_search ); ?>" 
			/>

			<i class="far fa-calendar-alt"></i>
			
		</div>

		<div class="ovaev_cat_search">

			<label class="second_font ova-label-search" for="ovaev_type">
				<?php esc_html_e('Category', 'ovaev'); ?>
			</label>

			<?php $dropdown_args1 = apply_filters( 'OVAEV_event_type', $get_search_cat ); ?>
			<i class="arrow_carrot-down "></i>

		</div>

		<div class="wrap-ovaev_submit">
			<input class="second_font ovaev_submit" type="submit" value="<?php esc_html_e('Find Event', 'ovaev'); ?>" />
		</div>

		<input type="hidden" name="post_type" value="event">
		<input type="hidden" name="search_event" value="search-event">
		
	</form>
</div>