<?php

	$id = get_the_ID();
		
	$ovaev_start_date = get_post_meta( $id, 'ovaev_start_date_time', true );
	$ovaev_end_date   = get_post_meta( $id, 'ovaev_end_date_time', true );

	$date_start  = $ovaev_start_date != '' ? date_i18n( get_option( 'date_format' ), $ovaev_start_date ) : '';
	$time_start  = $ovaev_start_date != '' ? date_i18n( get_option( 'time_format' ), $ovaev_start_date ) : '';
	$date_end    = $ovaev_end_date != '' ? date_i18n( get_option( 'date_format' ), $ovaev_end_date ) : '';
	$time_end    = $ovaev_end_date != '' ? date_i18n( get_option( 'time_format' ), $ovaev_end_date ) : '';

	$day_start 	 = $ovaev_start_date != '' ? date_i18n( 'd', $ovaev_start_date ) : '';
	$month_start = $ovaev_start_date != '' ? date_i18n( 'M', $ovaev_start_date ) : '';


?>

<div class="item">

	<div class="date-time_title">

		<?php if( $date_start != '' ){ ?>
			<div class="date-start">
				<span><?php echo esc_html($day_start);?></span>
				<span><?php echo esc_html($month_start);?></span>
			</div>
		<?php } ?>
	    
	    <div class="time_title">

	    	<div class="time-venue">

				<?php if( $date_start === $date_end && $date_end != '' && $date_start != '' ){ ?>
					<div class="time">
						<span class="icon-time"><i class="fas fa-clock icon_event"></i></span>
						<span><?php echo esc_html($time_start); ?> - <?php echo esc_html($time_end); ?></span>
					</div>
				<?php } elseif( $date_start != $date_end && $date_end != '' && $date_start != '' ){ ?>
					<div class="time">
						<span class="icon-time"><i class="fas fa-clock icon_event"></i></span>
						<span><?php echo esc_html($time_start); ?> - <?php echo esc_html($time_end); ?> @ <?php echo esc_html($date_end);?></span>
					</div>
				<?php } ?>

				<?php esc_html_e('/','ovaev'); do_action( 'ovaev_loop_venue', $id ); ?>

			</div>

			<h3 class="title">
				<a class="second_font" href="<?php echo get_the_permalink( $id ) ?>">
					<?php echo get_the_title( $id ) ?>
				</a>
			</h3>

	    </div>

	</div>

    <?php do_action( 'ovaev_event_button', $id ); ?>
	
	
</div>