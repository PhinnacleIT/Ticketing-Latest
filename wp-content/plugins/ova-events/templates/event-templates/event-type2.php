<?php if ( !defined( 'ABSPATH' ) ) exit(); 
	$id = get_the_id();
?>

<div class="ovaev-content">

	<div class="type2">

		<div class="desc">

			<!-- Thumbnail -->
			<?php do_action( 'ovaev_loop_thumbnail_list', $id ); ?>

			<div class="event_post">

				<!-- Display Highlight Date 2 -->
				<?php do_action( 'ovaev_loop_highlight_date_2', $id ); ?>

				<!-- Title -->
				<?php do_action( 'ovaev_loop_title', $id ); ?>
                
                <!-- Time and Venue -->
				<div class="time-event">

					<!-- Date -->
					<div class="wrapper">
						<?php do_action( 'ovaev_loop_date_event', $id ); ?>
						<label><?php echo esc_html__( 'Timing', 'ovaev' ); ?></label>
					</div>

					<!-- Venue -->
					<div class="wrapper">
						<?php do_action( 'ovaev_loop_venue', $id ); ?>
						<label><?php echo esc_html__( 'Location', 'ovaev' ); ?></label>
					</div>

				</div>
					
                <!-- Go to detail -->
				<a href="<?php the_permalink();?>">
					<div class="icon">
				    	<i aria-hidden="true" class="ovaicon-next-4"></i>	
					</div>
				</a>

			</div>



		</div>

	</div>

</div>
