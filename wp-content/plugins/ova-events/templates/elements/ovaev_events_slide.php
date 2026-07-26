<?php
$data_options['items']              = (int)$args['item_number'];
$data_options['slideBy']            = (int)$args['slides_to_scroll'];
$data_options['margin']             = (int)$args['margin_items'];
$data_options['autoplayHoverPause'] = $args['pause_on_hover'] === 'yes' ? true : false;
$data_options['loop']               = $args['infinite'] === 'yes' ? true : false;
$data_options['autoplay']           = $args['autoplay'] === 'yes' ? true : false;
$data_options['autoplayTimeout']    = (int)$args['autoplay_speed'];
$data_options['smartSpeed']         = (int)$args['smartspeed'];
$data_options['dots']               = $args['dot_control'] === 'yes' ? true : false;
$data_options['nav']                = $args['nav_control'] === 'yes' ? true : false;

$term 		= get_term_by('name', $args['category'], 'event_category');
$term_link 	= get_term_link( $term );

$layout 	= $args['layout'];

$events 	= ovaev_get_events_elements( $args );

?>

<div class="ovaev-event-element ovaev-event-slide" >
		
	<div class="wp-content ovaev-slide owl-carousel" data-options="<?php echo esc_attr(json_encode($data_options)) ?>">
		<?php
			if( $events->have_posts() ) : while( $events->have_posts() ) : $events->the_post();
				
				switch ($layout) {
					case '1':
						ovaev_get_template( 'event-templates/event-type1.php' );
						break;
					case '2':
						ovaev_get_template( 'event-templates/event-type2.php' );
						break;
					default:
						ovaev_get_template( 'event-templates/event-type1.php' );
				}
				
			endwhile; endif; wp_reset_postdata();
		?>
	</div>

</div>