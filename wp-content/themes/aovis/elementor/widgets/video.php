<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Aovis_Elementor_Video extends Widget_Base {

	public function get_name() {
		return 'aovis_elementor_video';
	}

	public function get_title() {
		return esc_html__( 'Ova Video', 'aovis' );
	}

	public function get_icon() {
		return 'eicon-video-playlist';
	}

	public function get_categories() {
		return [ 'aovis' ];
	}

	public function get_script_depends() {
		return [ 'aovis-elementor-video' ];
	}
	
	// Add Your Controll In This Function
	protected function register_controls() {

		$this->start_controls_section(
			'section_video',
			[
				'label' => esc_html__( 'Video', 'aovis' ),
			]
		);	

			$this->add_control(
				'image_v1',
				[
					'label'   => esc_html__( 'Image', 'aovis' ),
					'type'    => \Elementor\Controls_Manager::MEDIA,
					'default' => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'condition' => [
						'version' => 'version_1',
					]
				]
			);

			$this->add_control(
				'icon',
				[
					'label' => esc_html__( 'Icon', 'aovis' ),
					'type' => \Elementor\Controls_Manager::ICONS,
					'default' => [
						'value' => 'fas fa-play',
						'library' => 'all',
					],
				]
			);

			$this->add_control(
				'icon_url_video',
				[
					'label' 	=> esc_html__( 'URL Video', 'aovis' ),
					'type' 		=> Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'Enter your URL', 'aovis' ) . ' (YouTube)',
					'default' 	=> 'https://www.youtube.com/watch?v=XHOmBV4js_E',
				]
			);

			$this->add_control(
				'icon_text',
				[
					'label' 	=> esc_html__( 'Text', 'aovis' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> esc_html__( 'Watch the Trailer', 'aovis' ),
				]
			);

			$this->add_control(
	            'link',
	            [
	                'label' 	=> esc_html__( 'Link', 'aovis' ),
	                'type' 		=> Controls_Manager::URL,
	                'dynamic' 	=> [
	                    'active' => true,
	                ],
	                'condition' => [
	                	'icon_url_video' => '',
	                ],
	            ]
	        );

	        $this->add_control(
				'icon_animation',
				[
					'label' => esc_html__( 'Animation', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'On', 'aovis' ),
					'label_off' => esc_html__( 'Off', 'aovis' ),
					'return_value' => 'yes',
					'default' => 'yes',
				]
			);

	        $this->add_control(
				'video_options',
				[
					'label' 	=> esc_html__( 'Video Options', 'aovis' ),
					'type' 		=> Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'icon_url_video!' => '',
					],
				]
			);

			$this->add_control(
				'autoplay_video',
				[
					'label' 	=> esc_html__( 'Autoplay', 'aovis' ),
					'type' 		=> Controls_Manager::SWITCHER,
					'label_on' 	=> esc_html__( 'Yes', 'aovis' ),
					'label_off' => esc_html__( 'No', 'aovis' ),
					'default' 	=> 'yes',
					'condition' => [
						'icon_url_video!' => '',
					],
				]
			);

			$this->add_control(
				'mute_video',
				[
					'label' 	=> esc_html__( 'Mute', 'aovis' ),
					'type' 		=> Controls_Manager::SWITCHER,
					'label_on' 	=> esc_html__( 'Yes', 'aovis' ),
					'label_off' => esc_html__( 'No', 'aovis' ),
					'default' 	=> 'no',
					'condition' => [
						'icon_url_video!' => '',
					],
				]
			);

			$this->add_control(
				'loop_video',
				[
					'label' 	=> esc_html__( 'Loop', 'aovis' ),
					'type' 		=> Controls_Manager::SWITCHER,
					'label_on' 	=> esc_html__( 'Yes', 'aovis' ),
					'label_off' => esc_html__( 'No', 'aovis' ),
					'default' 	=> 'yes',
					'condition' => [
						'icon_url_video!' => '',
					],
				]
			);

			$this->add_control(
				'player_controls_video',
				[
					'label' 	=> esc_html__( 'Player Controls', 'aovis' ),
					'type' 		=> Controls_Manager::SWITCHER,
					'label_on' 	=> esc_html__( 'Yes', 'aovis' ),
					'label_off' => esc_html__( 'No', 'aovis' ),
					'default' 	=> 'yes',
					'condition' => [
						'icon_url_video!' => '',
					],
				]
			);

			$this->add_control(
				'modest_branding_video',
				[
					'label' 	=> esc_html__( 'Modest Branding', 'aovis' ),
					'type' 		=> Controls_Manager::SWITCHER,
					'label_on' 	=> esc_html__( 'Yes', 'aovis' ),
					'label_off' => esc_html__( 'No', 'aovis' ),
					'default' 	=> 'yes',
					'condition' => [
						'icon_url_video!' => '',
					],
				]
			);

			$this->add_control(
				'show_info_video',
				[
					'label' 	=> esc_html__( 'Show Info', 'aovis' ),
					'type' 		=> Controls_Manager::SWITCHER,
					'label_on' 	=> esc_html__( 'Yes', 'aovis' ),
					'label_off' => esc_html__( 'No', 'aovis' ),
					'default' 	=> 'no',
					'condition' => [
						'icon_url_video!' => '',
					],
				]
			);

		$this->end_controls_section();

		/* Begin section icon style */
		$this->start_controls_section(
			'section_icon_style',
			[
				'label' => esc_html__( 'Icon', 'aovis' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);	

		    $this->add_responsive_control(
				'icon_font_size',
				[
					'label' 	=> esc_html__( 'Size', 'aovis' ),
					'type' 		=> Controls_Manager::SLIDER,
					'size_units' => ['px'],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 200,
						],
					],
					'selectors' 	=> [
						'{{WRAPPER}} .ova-video .icon-content-view .content i' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'icon_bgsize',
				[
					'label' 	=> esc_html__( 'Background Size', 'aovis' ),
					'type' 		=> Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 400,
						],
					],	
					'selectors' => [
						'{{WRAPPER}} .ova-video .icon-content-view .content' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
	            'icon_border_radius',
	            [
	                'label' 		=> esc_html__( 'Border Radius', 'aovis' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .ova-video .icon-content-view .content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                    '{{WRAPPER}} .ova-video .icon-content-view .content:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                    '{{WRAPPER}} .ova-video .icon-content-view .content:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

			$this->add_group_control(
	            Group_Control_Border::get_type(), [
	                'name' 		=> 'icon_before_border',
	                'selector' 	=> '{{WRAPPER}} .ova-video .icon-content-view .content:before', 
	            ]
	        );

	        $this->add_responsive_control(
				'margin',
				[
					'label' => esc_html__( 'Margin', 'aovis' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em', 'rem'],
					'selectors' => [
						'{{WRAPPER}} .ova-video .icon-content-view .content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->start_controls_tabs( 'tabs_icon_style' );

				$this->start_controls_tab(
		            'tab_icon_normal',
		            [
		                'label' => esc_html__( 'Normal', 'aovis' ),
		            ]
		        );

		        	$this->add_control(
			            'icon_color_normal',
			            [
			                'label' 	=> esc_html__( 'Color', 'aovis' ),
			                'type' 		=> Controls_Manager::COLOR,
			                'selectors' => [
			                    '{{WRAPPER}} .ova-video .icon-content-view .content i' => 'color: {{VALUE}};',
			                ],
			            ]
			        );

			        $this->add_control(
			            'icon_primary_background_normal',
			            [
			                'label' 	=> esc_html__( 'Primary Background Color', 'aovis' ),
			                'type' 		=> Controls_Manager::COLOR,
			                'selectors' => [
			                    '{{WRAPPER}} .ova-video .icon-content-view .content:before' => 'background-color: {{VALUE}};',
			                ],
			            ]
			        );

			        $this->add_control(
			            'icon_secondary_background_normal',
			            [
			                'label' 	=> esc_html__( 'Secondary Background Color', 'aovis' ),
			                'type' 		=> Controls_Manager::COLOR,
			                'selectors' => [
			                    '{{WRAPPER}} .ova-video .icon-content-view .content:after' => 'background-color: {{VALUE}};',
			                ],
			            ]
			        );

		        $this->end_controls_tab();

		        $this->start_controls_tab(
		            'tab_icon_hover',
		            [
		                'label' => esc_html__( 'Hover', 'aovis' ),
		            ]
		        );

		        	$this->add_control(
			            'icon_color_hover',
			            [
			                'label' 	=> esc_html__( 'Color', 'aovis' ),
			                'type' 		=> Controls_Manager::COLOR,
			                'selectors' => [
			                    '{{WRAPPER}} .ova-video .icon-content-view .content:hover i' => 'color: {{VALUE}};',
			                ],
			            ]
			        );

			        $this->add_control(
			            'icon_primary_background_hover',
			            [
			                'label' 	=> esc_html__( 'Primary Background Color', 'aovis' ),
			                'type' 		=> Controls_Manager::COLOR,
			                'selectors' => [
			                    '{{WRAPPER}} .ova-video .icon-content-view .content:hover:before' => 'background-color: {{VALUE}};',
			                ],
			            ]
			        );

			        $this->add_control(
			            'icon_secondary_background_hover',
			            [
			                'label' 	=> esc_html__( 'Secondary Background Color', 'aovis' ),
			                'type' 		=> Controls_Manager::COLOR,
			                'selectors' => [
			                    '{{WRAPPER}} .ova-video .icon-content-view .content:hover:after' => 'background-color: {{VALUE}};',
			                ],
			            ]
			        );

		        $this->end_controls_tab();

			$this->end_controls_tabs();

	    $this->end_controls_section();

	    /* Begin text Style */
		$this->start_controls_section(
            'text_style',
            [
                'label' => esc_html__( 'Text', 'aovis' ),
                'tab' 	=> Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 		=> 'text_typography',
					'selector' 	=> '{{WRAPPER}} .ova-video .text',
				]
			);

			$this->add_control(
				'text_color',
				[
					'label' 	=> esc_html__( 'Color', 'aovis' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-video .text, {{WRAPPER}} .ova-video .text a' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'text_color_hover',
				[
					'label' 	=> esc_html__( 'Color Hover', 'aovis' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-video .text:hover a, {{WRAPPER}} .ova-video .text:hover' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_responsive_control(
	            'text_margin',
	            [
	                'label' 		=> esc_html__( 'Margin', 'aovis' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .ova-video .text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

        $this->end_controls_section();
		/* End text style */

	}

	// Render Template Here
	protected function render() {
		$settings = $this->get_settings();

		$icon 		= $settings['icon'];
		$url_video 	= $settings['icon_url_video'];
		$icon_text 	= $settings['icon_text'];
		$link 		= $settings['link']['url'];
		$tg_blank 	= '';
		if ( $settings['link']['is_external'] == 'on' ) {
			$tg_blank = 'target="_blank"';
		}

		$icon_animation = $settings['icon_animation'];

        // video options
		$autoplay 	= $settings['autoplay_video'];
		$mute 		= $settings['mute_video'];
		$loop 		= $settings['loop_video'];
		$controls 	= $settings['player_controls_video'];
		$modest 	= $settings['modest_branding_video'];
		$show_info 	= $settings['show_info_video'];

		?>

			 <div class="ova-video">
		 			
     			<?php if ( $icon_text ): ?>
					<div class="text">
						<?php if ( $link ): ?>
							<a href="<?php echo esc_url( $link ); ?>" <?php echo esc_html( $tg_blank ); ?>>
								<?php echo esc_html( $icon_text ); ?>
							</a>
						<?php else: ?>
							<?php echo esc_html( $icon_text ); ?>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<div class="icon-content-view video_active <?php if( $icon_animation != 'yes') { echo esc_attr('no-animation'); }  ?>">
					
					<?php if ( ! empty( $url_video ) ) : ?>
						<div class="content video-btn" 
								data-src="<?php echo esc_url( $url_video ); ?>" 
								data-autoplay="<?php echo esc_attr( $autoplay ); ?>" 
								data-mute="<?php echo esc_attr( $mute ); ?>" 
								data-loop="<?php echo esc_attr( $loop ); ?>" 
								data-controls="<?php echo esc_attr( $controls ); ?>" 
								data-modest="<?php echo esc_attr( $modest ); ?>" 
								data-show_info="<?php echo esc_attr( $show_info ); ?> 
								">
							<?php \Elementor\Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] ); ?>
						</div>
					
					<?php endif; ?>

				</div>

				<div class="ova-modal-container">
					<div class="modal">
						<i class="modal-close ovaicon-cancel"></i>
						<iframe class="modal-video" allow="autoplay"></iframe>
					</div>
				</div>

			</div>

		<?php
	}
}
$widgets_manager->register( new Aovis_Elementor_Video() );