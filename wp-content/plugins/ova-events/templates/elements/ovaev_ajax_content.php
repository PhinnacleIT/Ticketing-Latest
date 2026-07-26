<?php if ( !defined( 'ABSPATH' ) ) exit(); 

$id = get_the_id();
?>

<div class="ovaev-content">
	<div class="item">
		<!-- Display Highlight Date 2 -->
		<?php do_action( 'ovaev_loop_highlight_date_1', $id ); ?>

		<div class="desc">

			<!-- Thumbnail -->
			<?php do_action( 'ovaev_loop_thumbnail_list', $id ); ?>

			<div class="event_post">
				<!-- Tille -->
				<?php do_action( 'ovaev_loop_title', $id ); ?>

				<div class="time-event">
					<!-- Date -->
					<?php do_action( 'ovaev_loop_date_event', $id ); ?>

					<!-- Tille -->
					<?php do_action( 'ovaev_loop_venue', $id ); ?>

				</div>
			</div>
		</div>
	</div>
</div>