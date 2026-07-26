<?php if ( !defined( 'ABSPATH' ) ) exit();

get_header( );

$post_ID = get_the_ID();

$event_map_address 	 = get_post_meta( $post_ID, 'ovaev_map_address', true );
$event_map_lat     	 = get_post_meta( $post_ID, 'ovaev_map_lat', true );
$event_map_lng     	 = get_post_meta( $post_ID, 'ovaev_map_lng', true );
$event_map_zoom    	 = OVAEV_Settings::event_map_zoom();

$date_format 	   	 = OVAEV_Settings::archive_event_format_date();
$time 			   	 = OVAEV_Settings::archive_event_format_time();

$event_name        	 = get_post_meta( $post_ID, 'ovaev_organizer', true);
$event_phone       	 = get_post_meta( $post_ID, 'ovaev_phone', true);
$event_email       	 = get_post_meta( $post_ID, 'ovaev_email', true);
$event_website     	 = get_post_meta( $post_ID, 'ovaev_website', true);
$event_gallery     	 = get_post_meta( $post_ID, 'ovaev_gallery_id', true);
$event_template 	 = get_post_meta( $post_ID, 'event_template', true ) ? get_post_meta( $post_ID, 'event_template', true ) : 'global' ;

$event_booking_links = get_post_meta( $post_ID, 'ovaev_booking_links', true);

$sidebar_single 	 = isset( $_GET['show_sidebar_single'] ) ? $_GET['show_sidebar_single'] : OVAEV_Settings::ovaev_show_sidebar_single();

$active_sidebar = 'main-event';
if ( 'yes' === $sidebar_single && is_active_sidebar('event-sidebar') ) {
	$active_sidebar = 'sidebar-active';
}

$template = OVAEV_Settings::ovaev_get_template_single();

?>

<?php if ( 'default' != $template ): ?>
	<?php if ( 'global' != $event_template ): ?>
		<?php echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $event_template ); ?>
	<?php else: ?>
		<?php echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $template ); ?>
	<?php endif; ?>
<?php else: ?>
	<?php if ( 'global' != $event_template ): ?>
		<?php echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $event_template ); ?>
	<?php else: ?>
		<div class="single_event">
			<div class="container-event">
				<div id="<?php echo $active_sidebar; ?>" class="content-event">	
					<div class="event_intro">

						<!-- Feature image -->
						<?php do_action( 'oavev_single_thumbnail' ); ?>
                        
                         <div class="meta-event">
		                	<!-- Date -->
		                	<?php do_action( 'ovaev_loop_author_event', $post_ID ); ?>
						    <?php do_action( 'ovaev_loop_date_event', $post_ID ); ?>
		                </div>	

						<?php do_action( 'ovaev_single_title' ); ?>
						
						<div class="wrap-event-info">
							<div class="wrap-info">
								<?php 
									/**
									 * action oavev_single_time_loc
									 * Hooked oavev_single_time_loc_date
									 * Hooked oavev_single_time_loc_time
									 * Hooked oavev_single_time_loc_location
									 */
									do_action( 'oavev_single_time_loc' );
								?>
							</div>
							<div class="wrap-booking-links">
								<?php do_action( 'oavev_single_booking_links' );  ?>
							</div>

						</div>

						<div class="ovaev-event-content">
							<?php if( have_posts() ) : while( have_posts() ) : the_post();
								the_content();
					 		?>
					 		<?php endwhile; endif; wp_reset_postdata(); ?>
						</div>


						<?php if( ! empty( $event_map_address ) || ! empty( $event_name ) || ! empty( $event_phone ) || ! empty( $event_email ) || ! empty( $event_website ) || ! empty( $event_gallery ) ) { ?>
						
							<div class="tab-Location">

								<ul class="event_nav event_nav-tabs" role="tablist">

									<?php if( ! empty( $event_map_address ) ) { ?>
									 	<li class="event_nav-item">
									    	<a class="event_nav-link second_font " data-href="#location" role="tab">
									    		<?php esc_html_e('Location','ovaev')?>
									    	</a>
									  	</li>
									 <?php } ?>

								  	<?php if( ! empty( $event_name ) || ! empty( $event_phone ) || ! empty( $event_email ) || ! empty( $event_website ) ) { ?>
									  	<li class="event_nav-item">
									    	<a class="event_nav-link second_font" data-href="#contact" role="tab">
									    		<?php esc_html_e('Contact Details','ovaev')?>
									    	</a>
									 	</li>
								 	<?php } ?>

								 	<?php if( $event_gallery != '' ){  ?>
									  	<li class="event_nav-item">
									    	<a class="event_nav-link second_font" data-href="#gallery" role="tab">
									    		<?php esc_html_e('Gallery','ovaev')?>
									    	</a>
									  	</li>
								  	<?php } ?>

								</ul>

								<!-- Tab panes -->
								<div class="tab-content">

									<?php if( ! empty( $event_map_address ) ) { ?>

							  			<div role="tabpanel" 
							  				class="event_tab-pane in active" 
							  				id="location" 
							  				style="height: 500px;" 
							  				data-address="<?php echo esc_attr($event_map_address);?>" 
							  				data-lat="<?php echo esc_attr($event_map_lat);?>" 
							  				data-lng="<?php echo esc_attr($event_map_lng);?>" 
							  				data-zoom="<?php echo esc_attr($event_map_zoom); ?>"
							  			></div>

								  	<?php } ?>

								  	
									<?php if( ! empty( $event_name ) || ! empty( $event_phone ) || ! empty( $event_email ) || ! empty( $event_website ) ) { ?>
								  		<div role="tabpanel" class="event_tab-pane " id="contact">
								  			<div class="event_row">
												<div class="col_contact">
													<div class="contact">
														<ul class="info-contact">
															<?php if( $event_name != '' ) : ?>
			 												<li>
																<span><?php esc_html_e('Organizer Name:','ovaev'); ?></span>
																<span class="info"><?php echo esc_html($event_name); ?></span>
															</li>
															<?php endif; ?>
															<?php if( $event_phone != '') : ?>
															<li>
																<span><?php esc_html_e('Phone:','ovaev'); ?></span>
																<a href="tel:<?php echo esc_attr( $event_phone ) ?>" class="info"><?php echo esc_html($event_phone); ?></a>
															</li>
															<?php endif; ?>
														</ul>
													</div>
												</div>
												<div class="col_contact">
													<div class="contact">
														<ul class="info-contact">
															<?php if( $event_email != '') : ?>
															<li>
																<span><?php esc_html_e('Email:','ovaev'); ?></span>
																<a href="mailto:<?php echo esc_attr( $event_email ) ?>" class="info"><?php echo esc_html($event_email); ?></a>
															</li>
															<?php endif; ?>
															<?php if( $event_website != '') : ?>
															<li>
																<span><?php esc_html_e('Website:','ovaev'); ?></span>
																<a href="<?php echo esc_url( $event_website ) ?>" class="info"><?php echo esc_html($event_website); ?></a>
															</li>
															<?php endif; ?>
														</ul>
													</div>
												</div>
								  			</div>
								  		</div>
							  		<?php } ?>


							  		<?php if( $event_gallery != '' ) :  ?>
							 		 	<div role="tabpanel" class="event_tab-pane " id="gallery">
							 		 		<div class="event_row">
							 		 			<?php
							 		 			foreach ( $event_gallery as $items ) { ?>
							 		 				<div class="event_col-6">
														<div class="gallery-items">
															<?php
																$img_url = wp_get_attachment_image_url( $items, 'large' );
															?>
															<a href="<?php echo esc_url($img_url);?>" data-gal="prettyPhoto[gal]"><img src="<?php echo esc_url($img_url);?>"  alt="<?php echo get_the_title() ?>" /></a> 
														</div>
													</div>
							 		 			<?php }  ?>
							 		 		</div>
							 		 	</div>
					 		 		<?php endif; ?>
						 		 	
								</div>
							</div>

						<?php } ?>
						<!-- end tab-location -->

						<div class="event_tags_share">
							<!-- Share -->
							<?php do_action( 'oavev_single_share' ); ?>
						</div>

						<!-- Navigation -->
						<?php do_action( 'oavev_single_nav' ); ?>

						<!-- Related -->
						<?php do_action( 'oavev_single_related' ); ?>
						

				        <?php

				        	if( comments_open( get_the_ID() ) ) {
					        	comments_template(); 
					        }
				        ?>

					</div>
					<!-- end event_intro -->
				</div>
				<?php 
					if ( 'yes' === $sidebar_single ) {
						ovaev_get_template( 'sidebar-event.php' );
					}
				?>
			</div>
		</div>
	<?php endif; ?>
<?php endif; ?>
<?php get_footer();