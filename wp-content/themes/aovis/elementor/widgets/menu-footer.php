<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Aovis_Elementor_Menu_Footer extends Widget_Base {

	public function get_name() {
		return 'aovis_elementor_menu_footer';
	}

	public function get_title() {
		return esc_html__( 'Menu Footer', 'aovis' );
	}

	public function get_icon() {
		return 'eicon-post-list';
	}

	public function get_categories() {
		return [ 'hf' ];
	}

	public function get_script_depends() {
		return [ '' ];
	}
	
	// Add Your Controll In This Function
	protected function register_controls() {

		$this->start_controls_section(
			'section_menu',
			[
				'label' => esc_html__( 'Menu', 'aovis' ),
			]
		);	
			
			$menus 		= \wp_get_nav_menus();

			$list_menu 	= array();

			foreach ($menus as $menu) {
				$list_menu[$menu->slug] = $menu->name;
			}

			$this->add_control(
				'menu_slug',
				[
					'label' 	=> esc_html__( 'Select Menu', 'aovis' ),
					'type' 		=> Controls_Manager::SELECT,
					'options' 	=> $list_menu,
					'default' 	=> '',
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
            'menu_style',
            [
                'label' => esc_html__( 'Menu', 'aovis' ),
                'tab' 	=> Controls_Manager::TAB_STYLE,
            ]
        );

			$this->add_control(
	            'menu_bg',
	            [
	                'label' 	=> esc_html__( 'Background', 'aovis' ),
	                'type' 		=> Controls_Manager::COLOR,
	                'selectors' => [
	                    '{{WRAPPER}} .ova-menu-footer .menu' => 'background-color: {{VALUE}}',
	                ],
	            ]
	        );

			$this->start_controls_tabs( 'tabs_title_style' );

				$this->start_controls_tab(
		            'tab_text_normal',
		            [
		                'label' => esc_html__( 'Normal', 'aovis' ),
		            ]
		        );

			        $this->add_control(
			            'menu_color_normal',
			            [
			                'label' 	=> esc_html__( 'Color', 'aovis' ),
			                'type' 		=> Controls_Manager::COLOR,
			                'selectors' => [
			                    '{{WRAPPER}} .ova-menu-footer .menu li > a' => 'color: {{VALUE}}',
			                ],
			            ]
			        );

			    $this->end_controls_tab();

			    $this->start_controls_tab(
		            'tab_text_hover',
		            [
		                'label' => esc_html__( 'Hover', 'aovis' ),
		            ]
		        );
		        
			        $this->add_control(
			            'menu_color_hover',
			            [
			                'label' 	=> esc_html__( 'Color', 'aovis' ),
			                'type' 		=> Controls_Manager::COLOR,
			                'selectors' => [
			                    '{{WRAPPER}} .ova-menu-footer .menu li:hover > a' => 'color: {{VALUE}}',
			                ],
			            ]
			        );

			    $this->end_controls_tab();
			$this->end_controls_tabs();

	        $this->add_responsive_control(
	            'text_margin',
	            [
	                'label' 		=> esc_html__( 'Margin', 'aovis' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .ova-menu-footer .menu li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

	        $this->add_responsive_control(
	            'text_padding',
	            [
	                'label' 		=> esc_html__( 'Padding', 'aovis' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .ova-menu-footer .menu li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

	        $this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 		=> 'text_typography',
					'selector' 	=> '{{WRAPPER}} .ova-menu-footer .menu li a',
				]
			);

        $this->end_controls_section();
		/* End Menu Style */

		/* Begin Menu Style */
		$this->start_controls_section(
            'sub_menu_style',
            [
                'label' => esc_html__( 'Sub Menu', 'aovis' ),
                'tab' 	=> Controls_Manager::TAB_STYLE,
            ]
        );

			$this->add_control(
	            'sub_menu_bg',
	            [
	                'label' 	=> esc_html__( 'Background', 'aovis' ),
	                'type' 		=> Controls_Manager::COLOR,
	                'selectors' => [
	                    '{{WRAPPER}} .ova-menu-footer .menu li .sub-menu' => 'background-color: {{VALUE}}',
	                ],
	            ]
	        );

			$this->start_controls_tabs( 'tabs_subtitle_style' );

				$this->start_controls_tab(
		            'tab_subtext_normal',
		            [
		                'label' => esc_html__( 'Normal', 'aovis' ),
		            ]
		        );

			        $this->add_control(
			            'sub_menu_color_normal',
			            [
			                'label' 	=> esc_html__( 'Color', 'aovis' ),
			                'type' 		=> Controls_Manager::COLOR,
			                'selectors' => [
			                    '{{WRAPPER}} .ova-menu-footer .menu li .sub-menu li a' => 'color: {{VALUE}}',
			                ],
			            ]
			        );

			    $this->end_controls_tab();

			    $this->start_controls_tab(
		            'tab_subtext_hover',
		            [
		                'label' => esc_html__( 'Hover', 'aovis' ),
		            ]
		        );
		        
			        $this->add_control(
			            'sub_menu_color_hover',
			            [
			                'label' 	=> esc_html__( 'Color', 'aovis' ),
			                'type' 		=> Controls_Manager::COLOR,
			                'selectors' => [
			                    '{{WRAPPER}} .ova-menu-footer .menu li .sub-menu li:hover a' => 'color: {{VALUE}}',
			                ],
			            ]
			        );

			    $this->end_controls_tab();
			$this->end_controls_tabs();

	        $this->add_responsive_control(
	            'subtext_margin',
	            [
	                'label' 		=> esc_html__( 'Margin', 'aovis' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .ova-menu-footer .menu li .sub-menu li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

	        $this->add_responsive_control(
	            'subtext_padding',
	            [
	                'label' 		=> esc_html__( 'Padding', 'aovis' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .ova-menu-footer .menu li .sub-menu li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

	        $this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 		=> 'subtext_typography',
					'selector' 	=> '{{WRAPPER}} .ova-menu-footer .menu li .sub-menu li a',
				]
			);

        $this->end_controls_section();
	}

	// Render Template Here
	protected function render() {
		$settings = $this->get_settings();

		$menu_slug 	= $settings['menu_slug'];

		?>
			<div class="ova-menu-footer">
				<?php
					wp_nav_menu( array(
						'menu'              => $menu_slug,
						'container'         => '',
						'container_class'   => '',
						'container_id'      => '',
					));
				?>
			</div>
		<?php
	}
}
$widgets_manager->register( new Aovis_Elementor_Menu_Footer() );