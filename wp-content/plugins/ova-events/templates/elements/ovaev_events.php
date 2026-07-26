<?php
$version 		= $args['version'];
$column_temp 	= $args['column_template'];
$type_event 	= $args['type_event'];
$text_read_more = $args['text_read_more'];
$title 			= $args['title'] != '' ? esc_html( $args['title'] ) : '';

$show_title 	= $args['show_title'] != '' ? esc_html( $args['show_title'] ) : '';
$show_read_more = $args['show_read_more'] != '' ? esc_html( $args['show_read_more'] ) : '';

$term 		= get_term_by('name', $args['category'], 'event_category');
$term_link 	= get_term_link( $term );

$events 	= ovaev_get_events_elements( $args );

?>

<div class="ovaev-event-element <?php echo esc_attr( $version ) ?>" >

	<?php if( $show_title == 'yes' && $version == 'version_1' ) { ?>
		<h2 class="title-event">
			<?php echo esc_html($title); ?>
		</h2>
	<?php } ?>

	<?php if( ( $show_title == 'yes' || $show_read_more == 'yes' ) && ( $title != '' || $text_read_more != '' ) && ( $version == 'version_2') ) { ?>
			
		<div class="title-readmore">

			<?php if( $show_title == 'yes' ) { ?>
				<h2 class="title-event">
					<?php echo esc_html($title); ?>
				</h2>
			<?php } ?>

			<?php if( $show_read_more == 'yes' ){ ?>
				<a href="<?php echo get_post_type_archive_link('event'); ?>" class="read-more second_font">
					<?php echo esc_html( $text_read_more ); ?>
					<i data-feather="chevron-right"></i>
				</a>
			<?php } ?>

		</div>

	<?php } ?>


	<?php if ( $version == 'version_1' ) { 

			if( $events->have_posts() ) : while( $events->have_posts() ) : $events->the_post();

				echo ovaev_get_template( 'elements/__content_list.php' );
			
			endwhile; endif; wp_reset_postdata();
		
		} else { ?>

			<div class="container-event">
				<div id="main-event" class="content-event">
					<div class="archive_event <?php echo esc_attr( $column_temp ); ?>">

						<?php if( $events->have_posts() ) : while( $events->have_posts() ) : $events->the_post(); ?>
							<?php ovaev_get_template( 'event-templates/event-'.$type_event.'.php' ); ?>
						<?php endwhile; else: ?>
							<div class="search_not_found">
								<?php esc_html_e( 'No Events found', 'ovaev' ); ?>
							</div>
						<?php endif; wp_reset_postdata(); ?>

					</div>
				</div>
			</div>

	<?php } ?>

</div>