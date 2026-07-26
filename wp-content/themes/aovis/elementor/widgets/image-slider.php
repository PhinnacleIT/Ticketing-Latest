<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Aovis_Elementor_Image_Slider extends Widget_Base {

	public function get_name() {
		return 'aovis_elementor_image_slider';
	}

	public function get_title() {
		return esc_html__( 'Ova Image Slider', 'aovis' );
	}

	public function get_icon() {
		return 'eicon-slider-push';
	}

	public function get_categories() {
		return [ 'aovis' ];
	}

	public function get_script_depends() {
		return [ 'aovis-elementor-image-slider' ];
	}
	
	// Add Your Controll In This Function
	protected function register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'aovis' ),
			]
		);	
			
			// Add Class control
			$this->add_control(
				'list_image',
				[
					'label' => esc_html__( 'Add Images', 'aovis' ),
					'type' => \Elementor\Controls_Manager::GALLERY,
					'default' => [],
				]
			);

		$this->end_controls_section();

		/*****************************************************************
						START SECTION ADDITIONAL
		******************************************************************/

		$this->start_controls_section(
			'section_additional_options',
			[
				'label' => esc_html__( 'Additional Options', 'aovis' ),
			]
		);

		/***************************  VERSION  ***********************/
			$this->add_control(
				'margin_items',
				[
					'label'   => esc_html__( 'Margin Right Items', 'aovis' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 30,	
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
					'default' => 500,
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
					'default' => 'yes',
					'options' => [
						'yes' => esc_html__( 'Yes', 'aovis' ),
						'no'  => esc_html__( 'No', 'aovis' ),
					],
					'frontend_available' => true,
				]
			);

		$this->end_controls_section();

		/****************************  END SECTION ADDITIONAL *********************/


		/****************************  SECTION GENERAL *********************/
		$this->start_controls_section(
			'general_section',
			[
				'label' => esc_html__( 'General', 'aovis' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'image_opacity',
				[
					'label' => esc_html__( 'Image Opacity', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1,
							'step' => 0.01,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .ova-images-slider .item-images-slider img' => 'opacity: {{SIZE}};',
					],
				]
			);

			$this->add_control(
				'image_hover_opacity',
				[
					'label' => esc_html__( 'Image Hover Opacity', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1,
							'step' => 0.01,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .ova-images-slider .item-images-slider:hover img' => 'opacity: {{SIZE}};',
					],
				]
			);

			$this->add_control(
				'background_color_normal',
				[
					'label' => esc_html__( 'Background Color', 'aovis' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-images-slider .item-images-slider' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'background_color_hover',
				[
					'label' => esc_html__( 'Background Color Hover', 'aovis' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-images-slider .item-images-slider:hover' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'items_padding',
				[
					'label' => esc_html__( 'Padding', 'aovis' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em', 'rem' ],
					'selectors' => [
						'{{WRAPPER}} .ova-images-slider .item-images-slider' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'items_margin',
				[
					'label' => esc_html__( 'Margin', 'aovis' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em', 'rem' ],
					'selectors' => [
						'{{WRAPPER}} .ova-images-slider .item-images-slider' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

		$this->end_controls_section();
		/**************************** END SECTION GENERAL *********************/

		/*************  SECTION DOTs. *******************/
		$this->start_controls_section(
			'section_dot',
			[
				'label' => esc_html__( 'Dots', 'aovis' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'dot_control' => 'yes',
				]
			]
		);

			$this->add_control(
				'dot_color',
				[
					'label'     => esc_html__( 'Dot Color', 'aovis' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-images-slider.owl-carousel .owl-dots button' => 'background-color : {{VALUE}};',
						
					],
				]
			);

			$this->add_control(
				'dot_active_color',
				[
					'label'     => esc_html__( 'Dot Active Color', 'aovis' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-images-slider.owl-carousel .owl-dots button.active' => 'background-color : {{VALUE}};',
						
					],
				]
			);

			$this->add_control(
				'dot_width',
				[
					'label' 		=> esc_html__( 'Size', 'aovis' ),
					'type' 			=> Controls_Manager::SLIDER,
					'size_units' 	=> [ 'px' ],
					'range' => [
						'px' => [
							'min' 	=> 1,
							'max' 	=> 300,
							'step' 	=> 1,
						]
					],
					'selectors' 	=> [
						'{{WRAPPER}} .ova-images-slider.owl-carousel .owl-dots button' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'dots_margin',
				[
					'label'      => esc_html__( 'Margin', 'aovis' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .ova-images-slider.owl-carousel .owl-dots button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

		$this->end_controls_section();
		###############  end section dot  ###############
		
		
		/*************  SECTION NAV.  *******************/
		$this->start_controls_section(
			'section_nav',
			[
				'label' => esc_html__( 'Nav', 'aovis' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'nav_control' => 'yes',
				]
			]
		);

			$this->add_control(
				'nav_width',
				[
					'label' 		=> esc_html__( 'Size', 'aovis' ),
					'type' 			=> Controls_Manager::SLIDER,
					'size_units' 	=> [ 'px' ],
					'range' => [
						'px' => [
							'min' 	=> 1,
							'max' 	=> 300,
							'step' 	=> 1,
						]
					],
					'selectors' 	=> [
						'{{WRAPPER}} .ova-images-slider .customNavigation a' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			
			$this->add_control(
				'icon_size_nav',
				[
					'label' 		=> esc_html__( 'Icon Size', 'aovis' ),
					'type' 			=> Controls_Manager::SLIDER,
					'size_units' 	=> [ 'px' ],
					'range' => [
						'px' => [
							'min' 	=> 1,
							'max' 	=> 300,
							'step' 	=> 1,
						]
					],
					'selectors' 	=> [
						'{{WRAPPER}} .ova-images-slider .customNavigation a i' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);	
			
			$this->add_control(
				'nav__bg_color_',
				[
					'label'     => esc_html__( 'Background', 'aovis' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-images-slider .customNavigation a' => 'background-color : {{VALUE}};',
					],
				]
			);	

			$this->add_control(
				'nav__bg_color_hover',
				[
					'label'     => esc_html__( 'Background Hover', 'aovis' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-images-slider .customNavigation a:hover' => 'background-color : {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'bg_icon_color',
				[
					'label'     => esc_html__( 'Icon', 'aovis' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-images-slider .customNavigation a i' => 'color : {{VALUE}};',
					],
				]
			);			

			$this->add_control(
				'nav__bg_icon_color_hover',
				[
					'label'     => esc_html__( 'Icon Hover', 'aovis' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-images-slider .customNavigation a:hover i' => 'color : {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'nav_margin',
				[
					'label' => esc_html__( 'Margin', 'aovis' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em', 'rem' ],
					'selectors' => [
						'{{WRAPPER}} .ova-images-slider .customNavigation' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'line_decoration',
				[
					'label' => esc_html__( 'Line Decoration', 'aovis' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_control(
				'line_decoration_color',
				[
					'label'     => esc_html__( 'Color', 'aovis' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-images-slider .customNavigation:before' => 'background-color : {{VALUE}};',
						'{{WRAPPER}} .ova-images-slider .customNavigation:after' => 'background-color : {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'line_decoration_space',
				[
					'label' => esc_html__( 'Space', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%', 'em', 'rem' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1000,
							'step' => 1,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .ova-images-slider .customNavigation:before' => 'width: calc( 50% - {{SIZE}}{{UNIT}} ) ;',
						'{{WRAPPER}} .ova-images-slider .customNavigation:after' => 'width: calc( 50% - {{SIZE}}{{UNIT}} ) ;',
					],
				]
			);

			$this->add_control(
				'line_decoration_weight',
				[
					'label' => esc_html__( 'Weight', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%', 'em', 'rem' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 30,
							'step' => 1,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .ova-images-slider .customNavigation:before' => 'height:  {{SIZE}}{{UNIT}} ;',
						'{{WRAPPER}} .ova-images-slider .customNavigation:after' => 'height:  {{SIZE}}{{UNIT}} ;',
					],
				]
			);

		$this->end_controls_section();
		
	}

	// Render Template Here
	protected function render() {
		$settings = $this->get_settings();

		$list_image 						= 	$settings['list_image'];

		$data_options['items']              = 	$settings['item_number'] ? $settings['item_number'] : 6;
		$data_options['slideBy']            = 	$settings['slides_to_scroll'];
		$data_options['margin']             = 	$settings['margin_items'] ? $settings['margin_items'] : 0;
		$data_options['autoplayHoverPause'] = 	$settings['pause_on_hover'] === 'yes' ? true : false;
		$data_options['loop']               = 	$settings['infinite'] === 'yes' ? true : false;
		$data_options['autoplay']           = 	$settings['autoplay'] === 'yes' ? true : false;
		$data_options['autoplayTimeout']    = 	$settings['autoplay_speed'] ? $settings['autoplay_speed'] : '3000';
		$data_options['smartSpeed']         = 	$settings['smartspeed'] ? $settings['smartspeed'] : '500';
		$data_options['dots']               = 	$settings['dot_control'] === 'yes' ? true : false;
		$data_options['nav']               	= 	$settings['nav_control'] === 'yes' ? true : false;
		$data_options['rtl']				= 	is_rtl() ? true: false;

		$nav_control = $settings['nav_control'];

		?>
			<div class="ova-images-slider "  >

				<?php if( $nav_control == 'yes' ) : ?>
					<div class="customNavigation prev_next">
	    				<a class="prev">
	    					<i class="fas fa-angle-left"></i>
	    				</a>
	    				<a class="next">
	    					<i class="fas fa-angle-right"></i>
	    				</a>
	  				</div>
  				<?php endif; ?>

				<div class="slider-images owl-carousel owl-theme " data-options="<?php echo esc_attr(json_encode($data_options)); ?>">
					<?php foreach( $list_image as $item): ?>
						<?php 
							$caption = wp_get_attachment_caption($item['id']);
							$alt     = get_post_meta( $item['id'], '_wp_attachment_image_alt', true);
						?>
						
						    <div class="item-images-slider">
						    	<img src="<?php echo esc_url( $item['url'] ); ?>" alt="<?php echo esc_attr( $alt ); ?>">
						    </div>

					<?php endforeach; ?>
				</div>

			</div> 	
		<?php
	}
}
$widgets_manager->register( new Aovis_Elementor_Image_Slider() );