<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Aovis_Elementor_Gallery_Slide extends Widget_Base {

	public function get_name() {
		return 'aovis_elementor_gallery_slide';
	}

	public function get_title() {
		return esc_html__( 'Gallery Slide', 'aovis' );
	}

	public function get_icon() {
		return ' eicon-slider-3d';
	}

	public function get_categories() {
		return [ 'aovis' ];
	}

	public function get_script_depends() {

		wp_enqueue_style( 'fancybox', get_template_directory_uri().'/assets/libs/fancybox/fancybox.css' );
		wp_enqueue_script( 'fancybox', get_template_directory_uri().'/assets/libs/fancybox/fancybox.umd.js', array('jquery'), false, true );

		return [ 'aovis-elementor-gallery-slide' ];
	}
	
	// Add Your Controll In This Function
	protected function register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'aovis' ),
			]
		);	
			
			$this->add_control(
				'icon',
				[
					'label' => esc_html__( 'Icon', 'aovis' ),
					'type' => \Elementor\Controls_Manager::ICONS,
					'default' => [
						'value' => 'fab fa-instagram',
						'library' => 'all',
					],		
				]
			);

			$this->add_control(
				'image_gallery',
				[
					'label' => esc_html__( 'Add Images', 'aovis' ),
					'type' => Controls_Manager::GALLERY,
					'show_label' => false,
					'dynamic' => [
						'active' => true,
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Image_Size::get_type(),
				[
					'name' => 'medium', // Usage: `{name}_size` and `{name}_custom_dimension`
					'exclude' => [ 'custom' ],
					'default' => 'medium',
					'separator' => 'none',
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_additional_options',
			[
				'label' => esc_html__( 'Additional Options', 'aovis' ),
			]
		);

			$this->add_control(
				'margin_items',
				[
					'label'   => esc_html__( 'Margin Right Items', 'aovis' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 10,
				]
			);

			$this->add_control(
				'item_number',
				[
					'label'       => esc_html__( 'Item Number', 'aovis' ),
					'type'        => Controls_Manager::NUMBER,
					'description' => esc_html__( 'Number Item', 'aovis' ),
					'default'     => 5,
				]
			);

			$this->add_control(
				'slides_to_scroll',
				[
					'label'       => esc_html__( 'Slides to Scroll', 'aovis' ),
					'type'        => Controls_Manager::NUMBER,
					'description' => esc_html__( 'Set how many slides are scrolled per swipe.', 'aovis' ),
					'default'     => 1,
				]
			);

			$this->add_control(
				'pause_on_hover',
				[
					'label'   => esc_html__( 'Pause on Hover', 'aovis' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'yes',
					'options' => [
						'yes' => esc_html__( 'Yes', 'aovis' ),
						'no'  => esc_html__( 'No', 'aovis' ),
					],
					'frontend_available' => true,
				]
			);


			$this->add_control(
				'infinite',
				[
					'label'   => esc_html__( 'Infinite Loop', 'aovis' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'yes',
					'options' => [
						'yes' => esc_html__( 'Yes', 'aovis' ),
						'no'  => esc_html__( 'No', 'aovis' ),
					],
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'autoplay',
				[
					'label'   => esc_html__( 'Autoplay', 'aovis' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'yes',
					'options' => [
						'yes' => esc_html__( 'Yes', 'aovis' ),
						'no'  => esc_html__( 'No', 'aovis' ),
					],
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'autoplay_speed',
				[
					'label'     => esc_html__( 'Autoplay Speed', 'aovis' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 3000,
					'step'      => 500,
					'condition' => [
						'autoplay' => 'yes',
					],
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'smartspeed',
				[
					'label'   => esc_html__( 'Smart Speed', 'aovis' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 3000,
				]
			);

			$this->add_control(
				'dot_control',
				[
					'label'   => esc_html__( 'Show Dots', 'aovis' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'no',
					'options' => [
						'yes' => esc_html__( 'Yes', 'aovis' ),
						'no'  => esc_html__( 'No', 'aovis' ),
					],
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'nav_control',
				[
					'label'   => esc_html__( 'Show Nav', 'aovis' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'no',
					'options' => [
						'yes' => esc_html__( 'Yes', 'aovis' ),
						'no'  => esc_html__( 'No', 'aovis' ),
					],
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'rtl',
				[
					'label'   => esc_html__( 'Right to Left', 'aovis' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'no',
					'options' => [
						'yes' => esc_html__( 'Yes', 'aovis' ),
						'no'  => esc_html__( 'No', 'aovis' ),
					],
					'frontend_available' => true,
				]
			);

		$this->end_controls_section();

		//SECTION TAB STYLE General
		$this->start_controls_section(
			'section_general_style',
			[
				'label' => esc_html__( 'General', 'aovis' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'icon_box_size',
				[
					'label' => esc_html__( 'Icon Size', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%' ],
					'range' => [
						'px' => [
							'min' => 10,
							'max' => 100,
							'step' => 1,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .ova-gallery-slide .gallery-slide .owl-stage-outer .owl-stage .owl-item .gallery-box .list-gallery .icon-box i' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'icon_box_color',
				[
					'label' => esc_html__( 'Icon Color', 'aovis' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-gallery-slide .gallery-slide .owl-stage-outer .owl-stage .owl-item .gallery-box .list-gallery .icon-box i' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'image_overlay_hover',
				[
					'label' => esc_html__( 'Overlay Hover', 'aovis' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-gallery-slide .gallery-slide .owl-stage-outer .gallery-box .gallery-fancybox:before' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'decoration_line_options',
				[
					'label' => esc_html__( 'Decoration Line', 'aovis' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_control(
				'decoration_line_width',
				[
					'label' => esc_html__( 'Width', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%', 'em', 'rem' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
							'step' => 1,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .ova-gallery-slide .gallery-slide .owl-stage-outer .gallery-box .gallery-fancybox .list-gallery .decor-line-1:before' => 'width: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .ova-gallery-slide .gallery-slide .owl-stage-outer .gallery-box .gallery-fancybox .list-gallery .decor-line-2:before' => 'width: {{SIZE}}{{UNIT}};',

					],
				]
			);

			$this->add_control(
				'decoration_line_height',
				[
					'label' => esc_html__( 'Height', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%', 'em', 'rem' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
							'step' => 1,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .ova-gallery-slide .gallery-slide .owl-stage-outer .gallery-box .gallery-fancybox .list-gallery .decor-line-1:after' => 'height: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .ova-gallery-slide .gallery-slide .owl-stage-outer .gallery-box .gallery-fancybox .list-gallery .decor-line-2:after' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'decoration_line_weight',
				[
					'label' => esc_html__( 'Weight', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%', 'em', 'rem' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 10,
							'step' => 1,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .ova-gallery-slide .gallery-slide .owl-stage-outer .gallery-box .gallery-fancybox .list-gallery .decor-line-1:after' => 'width: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .ova-gallery-slide .gallery-slide .owl-stage-outer .gallery-box .gallery-fancybox .list-gallery .decor-line-2:after' => 'width: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .ova-gallery-slide .gallery-slide .owl-stage-outer .gallery-box .gallery-fancybox .list-gallery .decor-line-1:before' => 'height: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .ova-gallery-slide .gallery-slide .owl-stage-outer .gallery-box .gallery-fancybox .list-gallery .decor-line-2:before' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);

		$this->end_controls_section();
		
		//SECTION TAB STYLE DOTS
		$this->start_controls_section(
			'section_dots',
			[
				'label' 	=> esc_html__( 'Dots', 'aovis' ),
				'tab' 		=> Controls_Manager::TAB_STYLE,
				'condition' => [
					'dot_control' => 'yes',
				],
			]
		);

			$this->add_responsive_control(
			 	'position_dots',
			  	[
				  	'label' 	=> esc_html__( 'Position', 'aovis' ),
				  	'type' 		=> \Elementor\Controls_Manager::CHOOSE,
				  	'options' 	=> [
					  	'absolute' => [
						  	'title' => esc_html__( 'Absolute', 'aovis' ),
						  	'icon' 	=> 'eicon-text-align-left',
					  	],
					  	'relative' => [
						  	'title' => esc_html__( 'Relative', 'aovis' ),
						  	'icon' 	=> 'eicon-text-align-center',
					  	],
					  	 
				  	],
				  	'toggle' 	=> true,
				  	'selectors' => [
					  	'{{WRAPPER}} .ova-gallery-slide .gallery-slide .owl-dots' => 'position: {{VALUE}};',
				  	],
			  	]
			);

			$this->add_control(
				'position_bottom',
				[
					'label' 		=> esc_html__( 'Position Bottom', 'aovis' ),
					'type' 			=> Controls_Manager::SLIDER,
					'size_units' 	=> [ 'px' ],
					'range' => [
						'px' => [
							'min' 	=> 0,
							'max' 	=> 70,
							'step' 	=> 1,
						]
					],
					'selectors' 	=> [
						'{{WRAPPER}} .ova-gallery-slide .gallery-slide .owl-dots' => 'bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'dots_margin',
				[
					'label' => esc_html__( 'Margin', 'aovis' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .ova-gallery-slide .gallery-slide .owl-dots' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition' => [
						'position_dots' => 'relative',
					],
				]
			);


			$this->add_control(
				'style_dots',
				[
					'label' 	=> esc_html__( 'Dots', 'aovis' ),
					'type' 		=> \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'dot_control' => 'yes',
					],
				]
			);

			$this->add_control(
				'dot_color',
				[
					'label'     => esc_html__( 'Dot Color', 'aovis' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-gallery-slide .owl-carousel .owl-dots button' => 'background-color : {{VALUE}};',
						
					],
					'condition' => [
						'dot_control' => 'yes',
					],
				]
			);

			$this->add_control(
				'dot_width',
				[
					'label' 		=> esc_html__( 'Dots width', 'aovis' ),
					'type' 			=> Controls_Manager::SLIDER,
					'size_units' 	=> [ 'px' ],
					'range' => [
						'px' => [
							'min' 	=> 0,
							'max' 	=> 70,
							'step' 	=> 1,
						]
					],
					'selectors' 	=> [
						'{{WRAPPER}} .ova-gallery-slide .gallery-slide .owl-dots button' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'dot_height',
				[
					'label' 		=> esc_html__( 'Dots Height', 'aovis' ),
					'type' 			=> Controls_Manager::SLIDER,
					'size_units' 	=> [ 'px' ],
					'range' => [
						'px' => [
							'min' 	=> 0,
							'max' 	=> 70,
							'step' 	=> 1,
						]
					],
					'selectors' 	=> [
						'{{WRAPPER}} .ova-gallery-slide .gallery-slide .owl-dots button' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'border_radius_dot',
				array(
					'label'      => esc_html__( 'Border Radius', 'aovis' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} .ova-gallery-slide .gallery-slide .owl-dots button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'style_dot_active',
				[
					'label' 	=> esc_html__( 'Dots Active', 'aovis' ),
					'type' 		=> \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'dot_control' => 'yes',
					],
				]
			);

			$this->add_control(
				'dot_color_active',
				[
					'label'     => esc_html__( 'Dot Color Active', 'aovis' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-gallery-slide .gallery-slide .owl-dots button.active' => 'background-color : {{VALUE}};',
						
					],
					'condition' => [
						'dot_control' => 'yes',
					],
				]
			);

			$this->add_control(
				'dot_width_active',
				[
					'label' 		=> esc_html__( 'Dots Width Active', 'aovis' ),
					'type' 			=> Controls_Manager::SLIDER,
					'size_units' 	=> [ 'px' ],
					'range' => [
						'px' => [
							'min' 	=> 0,
							'max' 	=> 70,
							'step' 	=> 1,
						]
					],
					'selectors' 	=> [
						'{{WRAPPER}} .ova-gallery-slide .gallery-slide .owl-dots button.active' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'dot_height_active',
				[
					'label' 		=> esc_html__( 'Dots Height Active', 'aovis' ),
					'type' 			=> Controls_Manager::SLIDER,
					'size_units' 	=> [ 'px' ],
					'range' => [
						'px' => [
							'min' 	=> 0,
							'max' 	=> 70,
							'step' 	=> 1,
						]
					],
					'selectors' 	=> [
						'{{WRAPPER}} .ova-gallery-slide .gallery-slide .owl-dots button.active' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);


		$this->end_controls_section();
		//END SECTION TAB STYLE DOTS
		
		//SECTION TAB STYLE NAV
		$this->start_controls_section(
			'section_nav',
			[
				'label' 	=> esc_html__( 'Nav', 'aovis' ),
				'tab' 		=> Controls_Manager::TAB_STYLE,
				'condition' => [
					'nav_control' => 'yes',
				],
			]
		);

			$this->add_control(
				'nav_size',
				[
					'label' 		=> esc_html__( 'Nav Size', 'aovis' ),
					'type' 			=> Controls_Manager::SLIDER,
					'size_units' 	=> [ 'px' ],
					'range' => [
						'px' => [
							'min' 	=> 0,
							'max' 	=> 70,
							'step' 	=> 1,
						]
					],
					'selectors' 	=> [
						'{{WRAPPER}} .ova-gallery-slide .gallery-slide .owl-nav button' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'icon_size',
				[
					'label' 		=> esc_html__( 'Icon Size', 'aovis' ),
					'type' 			=> Controls_Manager::SLIDER,
					'size_units' 	=> [ 'px' ],
					'range' => [
						'px' => [
							'min' 	=> 0,
							'max' 	=> 30,
							'step' 	=> 1,
						]
					],
					'selectors' 	=> [
						'{{WRAPPER}} .ova-gallery-slide .gallery-slide .owl-nav button i' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);


			$this->add_responsive_control(
				'border_radius_nav',
				array(
					'label'      => esc_html__( 'Border Radius', 'aovis' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} .ova-gallery-slide .gallery-slide .owl-nav button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->start_controls_tabs( 'tabs_nav_style' );

				$this->start_controls_tab(
		            'tab_nav',
		            [
		                'label' => esc_html__( 'Normal', 'aovis' ),
		            ]
		        );

					$this->add_control(
						'nav_color',
						[
							'label'     => esc_html__( 'Color', 'aovis' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ova-gallery-slide .gallery-slide .owl-nav button' => 'color : {{VALUE}};',		
							],
							'condition' => [
								'nav_control' => 'yes',
							],
						]
					);

					$this->add_control(
						'nav_bg',
						[
							'label'     => esc_html__( 'Background', 'aovis' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ova-gallery-slide .gallery-slide .owl-nav button' => 'background-color : {{VALUE}};',
							],
							'condition' => [
								'nav_control' => 'yes',
							],
						]
					);

				$this->end_controls_tab();

			    $this->start_controls_tab(
		            'tab_hover',
		            [
		                'label' => esc_html__( 'Hover', 'aovis' ),
		            ]
		        );
		        	$this->add_control(
						'nav_next_color_hover',
						[
							'label'     => esc_html__( 'Color', 'aovis' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ova-gallery-slide .gallery-slide .owl-nav button:hover ' => 'color : {{VALUE}};',		
							],
							'condition' => [
								'nav_control' => 'yes',
							],
						]
					);

					$this->add_control(
						'nav_bg_hover',
						[
							'label'     => esc_html__( 'Background', 'aovis' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .ova-gallery-slide .gallery-slide .owl-nav button:hover' => 'background-color : {{VALUE}};',
								
							],
							'condition' => [
								'nav_control' => 'yes',
							],
						]
					);

				$this->end_controls_tab();
			$this->end_controls_tabs();

		$this->end_controls_section();
		// END SECTION TAB STYLE NAV
		
		//SECTION STYLE Image
		$this->start_controls_section(
			'section_images_style',
			[
				'label' => esc_html__( 'Image', 'aovis' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'border_image_galery',
					'selector' => '{{WRAPPER}} .ova-gallery-slide .gallery-slide .owl-stage-outer .owl-stage .owl-item .gallery-box .list-gallery',
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'box_shadow_image_galery',
					'selector' => '{{WRAPPER}} .ova-gallery-slide .gallery-slide .owl-stage-outer .owl-stage .owl-item .gallery-box .list-gallery',
				]
			);

			$this->add_control(
				'padding_image',
				[
					'label' => esc_html__( 'Padding', 'aovis' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .ova-gallery-slide .gallery-slide .owl-stage-outer .owl-stage .owl-item .gallery-box .list-gallery' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

		$this->end_controls_section();
	}

	// Render Template Here
	protected function render() {
		$settings = $this->get_settings();

		// image gallery
		$image_gallery = $settings['image_gallery'];
		$data_gallery  = array();

        // data option for slide
		$data_options['items']         		= $settings['item_number'];
		$data_options['margin']         	= $settings['margin_items'];
		$data_options['slideBy']            = $settings['slides_to_scroll'];
		$data_options['autoplayHoverPause'] = $settings['pause_on_hover'] === 'yes' ? true : false;
		$data_options['loop']               = $settings['infinite'] === 'yes' ? true : false;
		$data_options['autoplay']           = $settings['autoplay'] === 'yes' ? true : false;
		$data_options['autoplayTimeout']    = $settings['autoplay_speed'];
		$data_options['smartSpeed']         = $settings['smartspeed'];
		$data_options['dots']               = $settings['dot_control'] === 'yes' ? true : false;
		$data_options['nav']                = $settings['nav_control'] === 'yes' ? true : false;
		$data_options['rtl']				= $settings['rtl'] === 'yes' ? true: false;	

		?>

			<?php if ( !empty($image_gallery) ) : ?>

				<div class="ova-gallery-slide">

					<div class="gallery-slide owl-carousel" data-options="<?php echo esc_attr(json_encode($data_options)); ?>" >

						<?php foreach ( $image_gallery as $k => $image ) {

							$image_id 		= $image['id']; 

	                        $url 	  		= $image['url'] ;
	                        $thumbnail_url_array  = wp_get_attachment_image_src( $image_id, $settings['medium_size'] );
	                        $thumbnail_url  =  is_array( $thumbnail_url_array ) ? $thumbnail_url_array[0] : '';

	                        $alt 			= get_post_meta($image_id, '_wp_attachment_image_alt', true) ? get_post_meta($image_id, '_wp_attachment_image_alt', true) : esc_html__('Gallery Slide','aovis');  

	                        $caption        = wp_get_attachment_caption( $image_id );
	                        
	                        if ( $caption == '') {
	                        	$caption = $alt;
	                        }

	                        array_push( $data_gallery , array(
			                    'src'       => $url,
			                    'caption'   => $caption,
			                    'thumb'     => $thumbnail_url,
			                ));
	                        
						?>

							<div class="gallery-box ">
	                            
	                            <a class="gallery-fancybox" data-index="<?php echo esc_attr( $k ); ?>" href="javascript:;">
									<div class="list-gallery">

										<div class="decor-line-1"></div>
		                                
										<img src="<?php echo esc_url( $thumbnail_url ); ?>" alt="<?php echo esc_attr( $alt ); ?>">

										<div class="icon-box">
											<?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>		
										</div>

										<div class="decor-line-2"></div>

									</div>
								</a>

							</div>

						<?php } ?>
						
					</div>

					<input type="hidden" class="data-gallery-slide" data-gallery="<?php echo esc_attr( json_encode( $data_gallery ) ); ?>">

				</div>

			<?php endif; ?>

		<?php
	}

	
}
$widgets_manager->register( new Aovis_Elementor_Gallery_Slide() );