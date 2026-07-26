<?php if ( !defined( 'ABSPATH' ) ) exit(); 
	$id 		= get_the_id();
?>

<div class="ovaev-content">
	<div class="type1">

		<div class="desc">

			<!-- Thumbnail -->
			<?php do_action( 'ovaev_loop_thumbnail_grid', $id ); ?>

			<div class="event_post">
                
                <div class="meta-event">
				    <?php do_action( 'ovaev_loop_date_event', $id ); ?>
				    <?php do_action( 'ovaev_loop_venue', $id ); ?>
                </div>	

				<!-- Title -->
				<?php do_action( 'ovaev_loop_title', $id ); ?>
				
				<!-- Read More Button -->
				<?php do_action( 'ovaev_loop_readmore_2', $id ); ?>
			</div>
		</div>
	</div>
</div>
