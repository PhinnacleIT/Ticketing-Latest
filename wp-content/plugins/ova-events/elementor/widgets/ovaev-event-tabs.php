<?php
namespace ova_ovaev_elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class ova_event_tabs extends Widget_Base {

	public function get_name() {		
		return 'ova_event_tabs';
	}

	public function get_title() {
		return esc_html__( 'Event Tabs', 'ovaev' );
	}

	public function get_icon() {
		return 'eicon-tabs';
	}

	public function get_categories() {
		return [ 'ovaev_template' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_tabs',
			[
				'label' => esc_html__( 'Tabs', 'ovaev' ),
			]
		);

			$this->add_control(
				'map_zoom',
				[
					'label' 	=> esc_html__( 'Map Zoom', 'ovaev' ),
					'type' 		=> Controls_Manager::NUMBER,
					'default' 	=> 17,
				]
			);

			$this->end_controls_section();

		$this->start_controls_section(
			'section_tabs_style',
			[
				'label' => esc_html__( 'Tabs', 'ovaev' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_responsive_control(
				'align',
				[
					'label' => esc_html__( 'Alignment', 'ovaev' ),
					'type' 	=> Controls_Manager::CHOOSE,
					'options' => [
						'flex-start' => [
							'title' => esc_html__( 'Left', 'ovaev' ),
							'icon' 	=> 'eicon-text-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'ovaev' ),
							'icon' 	=> 'eicon-text-align-center',
						],
						'flex-end' => [
							'title' => esc_html__( 'Right', 'ovaev' ),
							'icon' 	=> 'eicon-text-align-right',
						],
					],
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .ovaev-event-tabs .content-event .tab-Location ul.event_nav' => 'justify-content: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
	            Group_Control_Border::get_type(), [
	                'name' 		=> 'tabs_border',
	                'selector' 	=> '{{WRAPPER}} .ovaev-event-tabs .content-event .tab-Location ul.event_nav',
	                'separator' => 'before',
	            ]
	        );

	        $this->add_control(
				'title_options',
				[
					'label' 	=> esc_html__( 'Title Options', 'ovaev' ),
					'type' 		=> Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

				$this->start_controls_tabs( 'tabs_title_style' );

					$this->start_controls_tab(
			            'tab_title_normal',
			            [
			                'label' => esc_html__( 'Normal', 'ovaev' ),
			            ]
			        );

						$this->add_control(
							'title_color_normal',
							[
								'label' => esc_html__( 'Color', 'ovaev' ),
								'type' 	=> Controls_Manager::COLOR,
								'selectors' => [
									'{{WRAPPER}} .ovaev-event-tabs .content-event .tab-Location ul.event_nav li.event_nav-item a' => 'color: {{VALUE}};',
								],
							]
						);

						$this->add_control(
							'title_background_normal',
							[
								'label' => esc_html__( 'Background', 'ovaev' ),
								'type' 	=> Controls_Manager::COLOR,
								'selectors' => [
									'{{WRAPPER}} .ovaev-event-tabs .content-event .tab-Location ul.event_nav li.event_nav-item' => 'background-color: {{VALUE}};',
								],
							]
						);

					$this->end_controls_tab();

					$this->start_controls_tab(
			            'tab_title_hover',
			            [
			                'label' => esc_html__( 'Hover', 'ovaev' ),
			            ]
			        );

						$this->add_control(
							'title_color_hover',
							[
								'label' => esc_html__( 'Color', 'ovaev' ),
								'type' 	=> Controls_Manager::COLOR,
								'selectors' => [
									'{{WRAPPER}} .ovaev-event-tabs .content-event .tab-Location ul.event_nav li.event_nav-item:hover a' => 'color: {{VALUE}};',
								],
							]
						);

						$this->add_control(
							'title_background_hover',
							[
								'label' => esc_html__( 'Background', 'ovaev' ),
								'type' 	=> Controls_Manager::COLOR,
								'selectors' => [
									'{{WRAPPER}} .ovaev-event-tabs .content-event .tab-Location ul.event_nav li.event_nav-item:hover' => 'background-color: {{VALUE}};',
								],
							]
						);

					$this->end_controls_tab();
				$this->end_controls_tabs();

			$this->add_control(
				'title_options_active',
				[
					'label' 	=> esc_html__( 'Active Title Options', 'ovaev' ),
					'type' 		=> Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

				$this->add_control(
					'title_color_active',
					[
						'label' => esc_html__( 'Color', 'ovaev' ),
						'type' 	=> Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .ovaev-event-tabs .content-event .tab-Location ul.event_nav li.event_nav-item.active a' => 'color: {{VALUE}};',
						],
					]
				);

				$this->add_control(
					'title_background_active',
					[
						'label' => esc_html__( 'Background', 'ovaev' ),
						'type' 	=> Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .ovaev-event-tabs .content-event .tab-Location ul.event_nav li.event_nav-item.active' => 'background-color: {{VALUE}};',
						],
					]
				);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 		=> 'title_typography',
					'selector' 	=> '{{WRAPPER}} .ovaev-event-tabs .content-event .tab-Location ul.event_nav li.event_nav-item a',
				]
			);

			$this->add_responsive_control(
	            'title_padding',
	            [
	                'label' 		=> esc_html__( 'Padding', 'ovaev' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .ovaev-event-tabs .content-event .tab-Location ul.event_nav li.event_nav-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

	        $this->add_responsive_control(
	            'title_margin',
	            [
	                'label' 		=> esc_html__( 'Margin', 'ovaev' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .ovaev-event-tabs .content-event .tab-Location ul.event_nav li.event_nav-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

	        $this->add_control(
				'line_options',
				[
					'label' 	=> esc_html__( 'Line Options', 'ovaev' ),
					'type' 		=> Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

				$this->start_controls_tabs( 'tabs_line_style' );

					$this->start_controls_tab(
			            'tab_line_normal',
			            [
			                'label' => esc_html__( 'Normal', 'ovaev' ),
			            ]
			        );

			        	$this->add_control(
							'line_background_normal',
							[
								'label' => esc_html__( 'Background', 'ovaev' ),
								'type' 	=> Controls_Manager::COLOR,
								'selectors' => [
									'{{WRAPPER}} .ovaev-event-tabs .content-event .tab-Location ul.event_nav li.event_nav-item.active:after' => 'background-color: {{VALUE}};',
								],
							]
						);

			        	$this->add_responsive_control(
							'line_height_active',
							[
								'label' 	=> esc_html__( 'Height', 'ovaev' ),
								'type' 		=> Controls_Manager::SLIDER,
								'default' 	=> [
									'unit' 	=> 'px',
								],
								'tablet_default' => [
									'unit' => 'px',
								],
								'mobile_default' => [
									'unit' => 'px',
								],
								'range' => [
									'px' => [
										'min' => -100,
										'max' => 100,
									],
									'%' => [
										'min' => -100,
										'max' => 100,
									],
								],
								'size_units' 	=> [ '%', 'px' ],
								'selectors' 	=> [
									'{{WRAPPER}} .ovaev-event-tabs .content-event .tab-Location ul.event_nav li.event_nav-item.active:after' => 'height: {{SIZE}}{{UNIT}};',
								],
							]
						);

						$this->add_responsive_control(
							'line_bottom_active',
							[
								'label' 	=> esc_html__( 'Bottom', 'ovaev' ),
								'type' 		=> Controls_Manager::SLIDER,
								'default' 	=> [
									'unit' 	=> 'px',
								],
								'tablet_default' => [
									'unit' => 'px',
								],
								'mobile_default' => [
									'unit' => 'px',
								],
								'range' => [
									'px' => [
										'min' => -100,
										'max' => 100,
									],
									'%' => [
										'min' => -100,
										'max' => 100,
									],
								],
								'size_units' 	=> [ '%', 'px' ],
								'selectors' 	=> [
									'{{WRAPPER}} .ovaev-event-tabs .content-event .tab-Location ul.event_nav li.event_nav-item.active:after' => 'bottom: {{SIZE}}{{UNIT}};',
								],
							]
						);

					$this->end_controls_tab();

					$this->start_controls_tab(
			            'tab_line_hover',
			            [
			                'label' => esc_html__( 'Hover', 'ovaev' ),
			            ]
			        );

						$this->add_control(
							'line_background_hover',
							[
								'label' => esc_html__( 'Background', 'ovaev' ),
								'type' 	=> Controls_Manager::COLOR,
								'selectors' => [
									'{{WRAPPER}} .ovaev-event-tabs .content-event .tab-Location ul.event_nav li.event_nav-item a:after' => 'background-color: {{VALUE}};',
								],
							]
						);

						$this->add_responsive_control(
							'line_height_hover',
							[
								'label' 	=> esc_html__( 'Height', 'ovaev' ),
								'type' 		=> Controls_Manager::SLIDER,
								'default' 	=> [
									'unit' 	=> 'px',
								],
								'tablet_default' => [
									'unit' => 'px',
								],
								'mobile_default' => [
									'unit' => 'px',
								],
								'range' => [
									'px' => [
										'min' => -100,
										'max' => 100,
									],
									'%' => [
										'min' => -100,
										'max' => 100,
									],
								],
								'size_units' 	=> [ '%', 'px' ],
								'selectors' 	=> [
									'{{WRAPPER}} .ovaev-event-tabs .content-event .tab-Location ul.event_nav li.event_nav-item a:after' => 'height: {{SIZE}}{{UNIT}};',
								],
							]
						);

						$this->add_responsive_control(
							'line_bottom_hover',
							[
								'label' 	=> esc_html__( 'Bottom', 'ovaev' ),
								'type' 		=> Controls_Manager::SLIDER,
								'default' 	=> [
									'unit' 	=> 'px',
								],
								'tablet_default' => [
									'unit' => 'px',
								],
								'mobile_default' => [
									'unit' => 'px',
								],
								'range' => [
									'px' => [
										'min' => -100,
										'max' => 100,
									],
									'%' => [
										'min' => -100,
										'max' => 100,
									],
								],
								'size_units' 	=> [ '%', 'px' ],
								'selectors' 	=> [
									'{{WRAPPER}} .ovaev-event-tabs .content-event .tab-Location ul.event_nav li.event_nav-item a:after' => 'bottom: {{SIZE}}{{UNIT}};',
								],
							]
						);

					$this->end_controls_tab();
				$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
            'location_style',
            [
                'label' => esc_html__( 'Location', 'ovaev' ),
                'tab' 	=> Controls_Manager::TAB_STYLE,
            ]
        );

        	$this->add_responsive_control(
	            'content_margin',
	            [
	                'label' 		=> esc_html__( 'Margin', 'ovaev' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .ovaev-event-tabs .content-event .tab-Location .tab-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

        	$this->add_responsive_control(
				'map_height',
				[
					'label' 	=> esc_html__( 'Map Height', 'ovaev' ),
					'type' 		=> Controls_Manager::SLIDER,
					'default' 	=> [
						'unit' 	=> 'px',
					],
					'tablet_default' => [
						'unit' => 'px',
					],
					'mobile_default' => [
						'unit' => 'px',
					],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1000,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'size_units' 	=> [ '%', 'px' ],
					'selectors' 	=> [
						'{{WRAPPER}} .ovaev-event-tabs .content-event .tab-Location .tab-content #location' => 'height: {{SIZE}}{{UNIT}} !important;',
					],
				]
			);

        $this->end_controls_section();

        $this->start_controls_section(
            'contact_details_style',
            [
                'label' => esc_html__( 'Contact Details', 'ovaev' ),
                'tab' 	=> Controls_Manager::TAB_STYLE,
            ]
        );

        	$this->add_control(
				'contact_details_title_options',
				[
					'label' 	=> esc_html__( 'Title Options', 'ovaev' ),
					'type' 		=> Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

				$this->add_control(
					'contact_details_title_color',
					[
						'label' => esc_html__( 'Color', 'ovaev' ),
						'type' 	=> Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .ovaev-event-tabs .content-event .tab-Location .tab-content .col_contact .contact .info-contact li span:nth-child(1)' => 'color: {{VALUE}};',
						],
					]
				);

			$this->add_control(
				'contact_details_description_options',
				[
					'label' 	=> esc_html__( 'Description Options', 'ovaev' ),
					'type' 		=> Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

				$this->add_control(
					'contact_details_description_color',
					[
						'label' => esc_html__( 'Color', 'ovaev' ),
						'type' 	=> Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .ovaev-event-tabs .content-event .tab-Location .tab-content .col_contact .contact .info-contact li span.info' => 'color: {{VALUE}};',
							'{{WRAPPER}} .ovaev-event-tabs .content-event .tab-Location .tab-content .col_contact .contact .info-contact li a.info' => 'color: {{VALUE}};',
						],
					]
				);

			$this->add_responsive_control(
	            'contact_details_padding',
	            [
	                'label' 		=> esc_html__( 'Padding', 'ovaev' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .ovaev-event-tabs .content-event .tab-Location .tab-content .col_contact .contact .info-contact li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

	        $this->add_responsive_control(
	            'contact_details_margin',
	            [
	                'label' 		=> esc_html__( 'Margin', 'ovaev' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .ovaev-event-tabs .content-event .tab-Location .tab-content .col_contact .contact .info-contact li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

        $this->end_controls_section();

        $this->start_controls_section(
            'gallery_style',
            [
                'label' => esc_html__( 'Gallery', 'ovaev' ),
                'tab' 	=> Controls_Manager::TAB_STYLE,
            ]
        );

        	$this->add_responsive_control(
				'thumbnail_spacing',
				[
					'label' 	=> esc_html__( 'Space Between', 'ovaev' ),
					'type' 		=> Controls_Manager::SLIDER,
					'range' 	=> [
						'px' 	=> [
							'min' => 0,
							'max' => 500,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .ovaev-event-tabs .content-event .tab-Location .tab-content .event_row' => 'grid-gap: {{SIZE}}{{UNIT}};',
					],
				]
			);

        $this->end_controls_section();

	}

	protected function render() {

		$settings 	= $this->get_settings();

		$id 		= get_the_ID();
		$post_type 	= get_post_type( $id );
		
		if ( empty( $post_type ) || 'event' != $post_type ) {
			echo '<div class="ovaev_elementor_none"><span>' . esc_html( $this->get_title() ) . '</span></div>';
			return;
		}

		$map_address 	= get_post_meta( $id, 'ovaev_map_address', true );
		$map_lat 		= get_post_meta( $id, 'ovaev_map_lat', true );
		$map_lng     	= get_post_meta( $id, 'ovaev_map_lng', true );
		$map_zoom    	= $settings['map_zoom'] ? $settings['map_zoom'] : 17;
		$name        	= get_post_meta( $id, 'ovaev_organizer', true);
		$phone       	= get_post_meta( $id, 'ovaev_phone', true);
		$email       	= get_post_meta( $id, 'ovaev_email', true);
		$website     	= get_post_meta( $id, 'ovaev_website', true);
		$gallery     	= get_post_meta( $id, 'ovaev_gallery_id', true);

		?>

		<?php if( ! empty( $map_address ) || ! empty( $name ) || ! empty( $phone ) || ! empty( $email ) || ! empty( $website ) || ! empty( $gallery ) ): ?>
			<div class="ovaev-event-tabs single_event">		
				<div class="content-event">
					<div class="tab-Location">
						<ul class="event_nav event_nav-tabs" role="tablist">
							<?php if ( ! empty( $map_address ) ): ?>
							 	<li class="event_nav-item">
							    	<a class="event_nav-link second_font " data-href="#location" role="tab">
							    		<?php esc_html_e('Location','ovaev'); ?>
							    	</a>
							  	</li>
							 <?php endif; ?>

						  	<?php if ( ! empty( $name ) || ! empty( $phone ) || ! empty( $email ) || ! empty( $website ) ): ?>
							  	<li class="event_nav-item">
							    	<a class="event_nav-link second_font" data-href="#contact" role="tab">
							    		<?php esc_html_e('Contact Details','ovaev'); ?>
							    	</a>
							 	</li>
						 	<?php endif; ?>

						 	<?php if ( $gallery != '' ): ?>
							  	<li class="event_nav-item">
							    	<a class="event_nav-link second_font" data-href="#gallery" role="tab">
							    		<?php esc_html_e('Gallery','ovaev')?>
							    	</a>
							  	</li>
						  	<?php endif; ?>

						</ul>

						<!-- Tab panes -->
						<div class="tab-content">
							<?php if ( ! empty( $map_address ) ): ?>
					  			<div role="tabpanel" 
					  				class="event_tab-pane in active" 
					  				id="location" 
					  				style="height: 500px;" 
					  				data-address="<?php echo esc_attr( $map_address ); ?>" 
					  				data-lat="<?php echo esc_attr( $map_lat ); ?>" 
					  				data-lng="<?php echo esc_attr( $map_lng ); ?>" 
					  				data-zoom="<?php echo esc_attr( $map_zoom ); ?>">
					  			</div>
						  	<?php endif; ?>

							<?php if ( ! empty( $name ) || ! empty( $phone ) || ! empty( $email ) || ! empty( $website ) ): ?>
						  		<div role="tabpanel" class="event_tab-pane " id="contact">
						  			<div class="event_row">
										<div class="col_contact">
											<div class="contact">
												<ul class="info-contact">
													<?php if ( $name != '' ): ?>
														<li>
															<span><?php esc_html_e('Organizer Name:','ovaev'); ?></span>
															<span class="info"><?php echo esc_html( $name ); ?></span>
														</li>
													<?php endif; ?>
													<?php if ( $phone != ''): ?>
														<li>
															<span><?php esc_html_e('Phone:','ovaev'); ?></span>
															<a href="tel:<?php echo esc_attr( $phone ); ?>" class="info"><?php echo esc_html( $phone ); ?></a>
														</li>
													<?php endif; ?>
												</ul>
											</div>
										</div>
										<div class="col_contact">
											<div class="contact">
												<ul class="info-contact">
													<?php if ( $email != ''): ?>
														<li>
															<span><?php esc_html_e('Email:','ovaev'); ?></span>
															<a href="mailto:<?php echo esc_attr( $email ); ?>" class="info"><?php echo esc_html( $email ); ?></a>
														</li>
													<?php endif; ?>

													<?php if ( $website != ''): ?>
														<li>
															<span><?php esc_html_e('Website:','ovaev'); ?></span>
															<a href="<?php echo esc_url( $website ); ?>" class="info"><?php echo esc_html( $website ); ?></a>
														</li>
													<?php endif; ?>
												</ul>
											</div>
										</div>
						  			</div>
						  		</div>
					  		<?php endif; ?>

					  		<?php if ( $gallery != '' ):  ?>
					 		 	<div role="tabpanel" class="event_tab-pane " id="gallery">
					 		 		<div class="event_row">
					 		 			<?php
					 		 			foreach ( $gallery as $items ): ?>
					 		 				<div class="event_col-6">
												<div class="gallery-items">
													<?php
														$img_url = wp_get_attachment_image_url( $items, 'large' );
													?>
													<a 
														href="<?php echo esc_url( $img_url ); ?>" 
														data-gal="prettyPhoto[gal]">
														<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo get_the_title(); ?>" />
													</a> 
												</div>
											</div>
					 		 			<?php endforeach; ?>
					 		 		</div>
					 		 	</div>
			 		 		<?php endif; ?>
				 		 	
						</div>
					</div>
				</div>
			</div>
		<?php
		endif;
	}
}
