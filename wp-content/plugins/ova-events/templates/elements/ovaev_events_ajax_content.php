<?php
//data event
$data_event 	= $args['data_posts'];
$data_carousel 	= $args['data_carousel'];
$settings 		= $args['settings'];
$layout 		= $settings['layout'] ? $settings['layout'] : 1;

?>

<?php if( !empty($data_event) ): ?>
	<div class="ovapo_project_grid full_width">
		<?php if ($settings['show_filter'] == 'yes') { ?>
			<div class="button-filter container">
				<?php if ($settings['show_all'] == 'yes') { ?>
					<button 
						data-filter="<?php echo esc_attr( 'all' ); ?>" 
						data-order="<?php echo esc_attr($settings['order_post']); ?>" 
						data-orderby="<?php echo esc_attr($settings['orderby_post']); ?>" 
						data-first_term="<?php echo esc_attr($settings['first_term']); ?>" 
						data-term_id_filter_string="<?php echo esc_attr($settings['term_id_filter_string']); ?>" 
						data-number_post="<?php echo esc_attr($settings['number_post']); ?>" 
						data-layout='<?php echo esc_attr($layout); ?>' 
						data-show_featured="<?php echo esc_attr($settings['show_featured']); ?>" class="second_font" >
						<?php esc_html_e( 'All', 'ovaev' ); ?>
					</button>
				<?php } ?>

				<?php if ( count( $settings['terms'] ) > 0 ){
					foreach ( $settings['terms'] as $term ) { ?>
						<button 
							data-filter="<?php echo esc_attr($term->term_id); ?>" 
							data-order="<?php echo esc_attr($settings['order_post']); ?>" 
							data-orderby="<?php echo esc_attr($settings['orderby_post']); ?>" 
							data-first_term="<?php echo esc_attr($settings['first_term']); ?>" 
							data-term_id_filter_string="<?php echo esc_attr($settings['term_id_filter_string']); ?>" 
							data-number_post="<?php echo esc_attr($settings['number_post']); ?>" 
							data-layout='<?php echo esc_attr($layout); ?>' 
							data-show_featured="<?php echo esc_attr($settings['show_featured']); ?>" class="second_font">
							<?php esc_html_e( $term->name, 'ovaev' ); ?>
						</button>
					<?php }
				} ?>
			</div>
		<?php } ?>
		
		<div class="content ovapo_project_slide">
			<div  class="items grid owl-carousel" data-owl="<?php echo esc_attr(json_encode( $data_carousel )); ?>">
				<?php if( $data_event->have_posts() ) : while( $data_event->have_posts() ) : $data_event->the_post();

					$id = get_the_ID();
					$ovapo_cat = get_the_terms( $id, 'event_category' );

					$cat_name = array();
					if ($ovapo_cat != '') {
						foreach ($ovapo_cat as $key => $value) {
							$cat_name[] = $value->name;
						}
					}
					$category_name = join(', ', $cat_name);

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

					?>

				<?php endwhile; endif; wp_reset_postdata(); ?>
			</div>

	    	<div class="title-readmore">
				<?php if( $settings['show_read_more'] == 'yes' ){ ?>
				<div class="btn_grid" >
					<a href="<?php echo get_post_type_archive_link('event') ?>" class="read-more second_font btn_grid_event">
						<?php echo esc_html( $settings['text_read_more'] ) ?>
					</a>
				</div>
				<?php } ?>
	    	</div>
			<div class="wrap_loader">
				<svg class="loader" width="50" height="50">
					<circle cx="25" cy="25" r="10" stroke="#a1a1a1"/>
					<circle cx="25" cy="25" r="20" stroke="#a1a1a1"/>
				</svg>
			</div>
		</div>

	</div>

<?php else : ?>
	<div class="search_not_found">
		<?php esc_html_e( 'Not Found Event', 'ovaev' ); ?>
	</div>
<?php endif;