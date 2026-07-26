<?php if ( !defined( 'ABSPATH' ) ) exit();

get_header();

$event_type_temp 	= isset( $_GET['event_type_temp'] ) ? $_GET['event_type_temp'] : OVAEV_Settings::archive_event_type();
$event_col 			= isset( $_GET['col'] ) ? $_GET['col'] : OVAEV_Settings::archive_event_col();
$show_sidebar 		= isset( $_GET['show_sidebar'] ) ? $_GET['show_sidebar'] : OVAEV_Settings::ovaev_show_sidebar();
$show_search 		= isset( $_GET['show_search'] ) ? $_GET['show_search'] : OVAEV_Settings::ovaev_show_search();

$active_sidebar 	= 'main-event';
if ( 'yes' === $show_sidebar && is_active_sidebar('event-sidebar') ) {
	$active_sidebar = 'sidebar-active';
}

?>

<div class="container-event">
	<div id="<?php echo $active_sidebar; ?>" class="content-event">
        
        <!-- search form -->
        <?php if ( 'yes' === $show_search ) {
			    do_action( 'ovaev_search_form' );
		   }
		?>	

		<div class="archive_event <?php echo $event_col; ?>">

			<?php if( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<?php ovaev_get_template( 'event-templates/event-'.$event_type_temp.'.php' ); ?>
			<?php endwhile; else: ?>
				<div class="search_not_found">
					<?php esc_html_e( 'No Events found', 'ovaev' ); ?>
				</div>
			<?php endif; wp_reset_postdata(); ?>

		</div>
		
		<?php  
			global $wp_query;
			if ( $wp_query->max_num_pages > 1 ) {
		?>
			<div class="events_pagination">
				<?php
					echo paginate_links( apply_filters( 'el_pagination_args', array(
						'base'         => esc_url_raw( str_replace( 999999999, '%#%', get_pagenum_link( 999999999, false ) ) ),
						'format'       => '',
						'add_args'     => '',
						'current'      => max( 1, get_query_var( 'paged' ) ),
						'total'        => $wp_query->max_num_pages,
						'prev_text'    => __( 'Previous', 'ovaev' ),
						'next_text'    => __( 'Next', 'ovaev' ),
						'type'         => 'list',
						'end_size'     => 3,
						'mid_size'     => 3
					) ) ); 
				?>
			</div>
		<?php } ?>


	</div>

	<?php 
		if ( 'yes' === $show_sidebar ) {
			ovaev_get_template( 'sidebar-event.php' );
		}
	?>
</div>

<?php get_footer();