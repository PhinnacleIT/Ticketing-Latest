<?php if ( !defined( 'ABSPATH' ) ) exit();

$post_ID = get_the_ID();

$event_related = ovaev_get_event_related_by_id( $post_ID );

if( $event_related->have_posts() ){ ?>

    <div class="event-related">

        <h3 class="related-event">
        	<?php esc_html_e( 'Related Events', 'ovaev' ) ?>
        </h3>

    	<div class="archive_event">

    		<?php if($event_related->have_posts() ) : while ( $event_related->have_posts() ) : $event_related->the_post();
	        
	        	ovaev_get_template( 'elements/ovaev-related-content.php' );

	        	endwhile; endif; wp_reset_postdata();
	        ?>

    	</div>
    	
    </div>

<?php }
