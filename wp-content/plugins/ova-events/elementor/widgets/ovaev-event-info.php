<?php
namespace ova_ovaev_elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class ova_event_info extends Widget_Base {

	public function get_name() {		
		return 'ova_event_info';
	}

	public function get_title() {
		return esc_html__( 'Event Info', 'ovaev' );
	}

	public function get_icon() {
		return 'eicon-info';
	}

	public function get_categories() {
		return [ 'ovaev_template' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_info',
			[
				'label' => esc_html__( 'Content', 'ovaev' ),
			]
		);

		    $this->add_control(
				'time_format',
				[
					'label' 	=> esc_html__( 'Time Format', 'ovaev' ),
					'type' 		=> Controls_Manager::SELECT,
					'options' 	=> [
						'H:i' 		=> esc_html__( 'H:i 24 Hour	', 'ovaev' ),
						'g:i A' 	=> esc_html__( 'g:i A 12 Hour', 'ovaev' ),
						'g:i a' 	=> esc_html__( 'g:i a 12 hour', 'ovaev' ),
					],
					'default' 	=> 'g:i a',
				]
			);
			
			$this->add_control(
				'separator',
				[
					'label' 	=> esc_html__( 'Time Separator', 'ovaev' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> esc_html__( ' to ', 'ovaev' ),
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

		    $this->add_responsive_control(
	            'contact_details_padding',
	            [
	                'label' 		=> esc_html__( 'Padding', 'ovaev' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .ovaev-event-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

	        $this->add_control(
				'contact_details_bgcolor',
				[
					'label' => esc_html__( 'Background Color', 'ovaev' ),
					'type' 	=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ovaev-event-info' => 'background-color: {{VALUE}};',
					],
				]
			);

        	$this->add_control(
				'contact_details_label_options',
				[
					'label' 	=> esc_html__( 'Label Options', 'ovaev' ),
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
							'{{WRAPPER}} .ovaev-event-info .info-contact li .label' => 'color: {{VALUE}};',
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
							'{{WRAPPER}} .ovaev-event-info .info-contact li .info' => 'color: {{VALUE}};',
							'{{WRAPPER}} .ovaev-event-info .info-contact li a' => 'color: {{VALUE}};',
						],
					]
				);

				$this->add_control(
					'contact_details_description_underline_hover_color',
					[
						'label' => esc_html__( 'Link Underline Color', 'ovaev' ),
						'type' 	=> Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .ovaev-event-info .info-contact li a:hover:before' => 'background-color: {{VALUE}};',
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

		$name        	= get_post_meta( $id, 'ovaev_organizer', true);
		$phone       	= get_post_meta( $id, 'ovaev_phone', true);
		$email       	= get_post_meta( $id, 'ovaev_email', true);
		$website     	= get_post_meta( $id, 'ovaev_website', true);
		$location       = get_post_meta( $id, 'ovaev_venue', true);

		// Date format
		$date_format 		= apply_filters( 'ovaev_date_event_format', get_option('date_format') );

		// Time format
		$time_format 	    = $settings['time_format'];

		// Time separator
		$separator 		    = $settings['separator'];	

		// Start date
		$ovaev_start_date 	= get_post_meta( $id, 'ovaev_start_date_time', true );
		$start_date    		= $ovaev_start_date != '' ? date_i18n( $date_format, $ovaev_start_date ) : '';

		// Start time
		$ovaev_start_time 	= get_post_meta( $id, 'ovaev_start_time', true );
		$start_time 		= $ovaev_start_time ? date( $time_format, strtotime($ovaev_start_time) ) : '';

		// End date
		$ovaev_end_date   	= get_post_meta( $id, 'ovaev_end_date_time', true );
		$end_date      		= $ovaev_end_date != '' ? date_i18n( $date_format, $ovaev_end_date) : '';

		// End time
		$ovaev_end_time   	= get_post_meta( $id, 'ovaev_end_time', true );
		$end_time      		= $ovaev_end_time ? date( $time_format, strtotime($ovaev_end_time) ) : ''; 
        
        // Category
		$category    = get_the_terms($id, 'event_category');

		?>
		    <div class="ovaev-event-info">
				<ul class="info-contact">
					<li>
						<?php if( $start_date == $end_date && $start_date != '' ){ ?>
							<span class="info">
								<?php echo esc_html( $start_time ). $separator .$end_time; ?>
							</span>
						<?php }else{ ?>
							<span class="info">
								<span><?php echo esc_html( $start_time ); ?></span>
							</span>
						<?php } ?>
						<span class="label"><?php esc_html_e('Timing','ovaev'); ?></span>
					</li>

					<?php if ( $start_date != '' ): ?>
						<li>
							<span class="info"><?php echo esc_html( $start_date ); ?></span>
							<span class="label"><?php esc_html_e('Date','ovaev'); ?></span>
						</li>
					<?php endif; ?>

					<?php if ( !empty($category) ) : ?>
						<li>
							<span class="info">
								<?php 
									$arr_link = array();
									foreach( $category as $cat ) { 
								        $category_link = get_term_link($cat->term_id);
								        if ( $category_link ) {
								        	$link = '<a href="'.esc_url( $category_link ).'" title="'.esc_attr($cat->name).'">'.$cat->name.'</a>';
	                                    	array_push( $arr_link, $link );
								        }
									}
									if ( !empty( $arr_link ) && is_array( $arr_link ) ) {
										echo join(', ', $arr_link);
									}
								?>
							</span>
							<span class="label"><?php esc_html_e('Category','ovaev'); ?></span>
						</li>
					<?php endif; ?>

					<?php if ( $name != ''): ?>
						<li>
							<span class="info"><?php echo esc_html( $name ); ?></span>
							<span class="label"><?php esc_html_e('Organizer Name','ovaev'); ?></span>
						</li>
					<?php endif; ?>

					<?php if ( $phone != ''): ?>
						<li>
							<a href="tel:<?php echo esc_attr( $phone ); ?>" class="info"><?php echo esc_html( $phone ); ?></a>
							<span class="label"><?php esc_html_e('Phone','ovaev'); ?></span>
						</li>
					<?php endif; ?>

					<?php if ( $email != ''): ?>
						<li>
							<a href="mailto:<?php echo esc_attr( $email ); ?>" class="info"><?php echo esc_html( $email ); ?></a>
							<span class="label"><?php esc_html_e('Email','ovaev'); ?></span>
						</li>
					<?php endif; ?>

					<?php if ( $website != ''): ?>
						<li>
							<a href="<?php echo esc_url( $website ); ?>" class="info" target="_blank"><?php echo esc_html( $website ); ?></a>
							<span class="label"><?php esc_html_e('Website','ovaev'); ?></span>
						</li>
					<?php endif; ?>

					<?php if ( $location != ''): ?>
						<li>
							<span class="info"><?php echo esc_html( $location ); ?></span>
							<span class="label"><?php esc_html_e('Location','ovaev'); ?></span>
						</li>
					<?php endif; ?>
				</ul>
				<div class="ovaev-event-share">
					<?php echo apply_filters('ovaev_share_social', get_the_permalink(), get_the_title() ); ?>
				</div>
  			</div>
		<?php
	}
}
