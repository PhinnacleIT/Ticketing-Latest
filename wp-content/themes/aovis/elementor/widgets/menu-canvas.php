<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Aovis_Elementor_Canvas_Menu extends Widget_Base {

	public function get_name() {
		return 'aovis_elementor_menu_canvas';
	}

	public function get_title() {
		return esc_html__( 'Menu Canvas', 'aovis' );
	}

	public function get_icon() {
		return 'eicon-menu-bar';
	}

	public function get_categories() {
		return [ 'hf' ];
	}

	public function get_script_depends() {
		return [ 'aovis-elementor-menu-canvas' ];
	}
	

	protected function register_controls() {


		/* Global Section *******************************/
		/***********************************************/
		$this->start_controls_section(
			'section_menu_type',
			[
				'label' => esc_html__( 'Global', 'aovis' ),
			]
		);


			$menus = \wp_get_nav_menus();
			$list_menu = array();
			foreach ($menus as $menu) {
				$list_menu[$menu->slug] = $menu->name;
			}

			$this->add_control(
				'menu_slug',
				[
					'label' => esc_html__( 'Select Menu', 'aovis' ),
					'type' => Controls_Manager::SELECT,
					'options' => $list_menu,
					'default' => '',
					'prefix_class' => 'elementor-view-',
				]
			);

			$this->add_control(
				'menu_dir',
				[
					'label' => esc_html__( 'Menu Direction', 'aovis' ),
					'type' => \Elementor\Controls_Manager::CHOOSE,
					'options' => [
						'dir_left' => [
							'title' => esc_html__( 'Left', 'aovis' ),
							'icon' => 'eicon-h-align-left',
						],
						'dir_right' => [
							'title' => esc_html__( 'Right', 'aovis' ),
							'icon' => 'eicon-h-align-right',
						],
					],
					'default' => 'dir_left'
				]
			);
			
		$this->end_controls_section();	


		/* Style Section *******************************/
		/***********************************************/
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Style', 'aovis' ),
			]
		);
			
			$this->add_control(
				'text_align',
				[
					'label' 	=> esc_html__( 'Alignment', 'aovis' ),
					'type' 		=> \Elementor\Controls_Manager::CHOOSE,
					'options' 	=> [
						'left' 	=> [
							'title' => esc_html__( 'Left', 'aovis' ),
							'icon' 	=> 'eicon-text-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'aovis' ),
							'icon' 	=> 'eicon-text-align-center',
						],
						'right' => [
							'title' => esc_html__( 'Right', 'aovis' ),
							'icon' 	=> 'eicon-text-align-right',
						],
					],
					'default' 	=> 'right',
					'toggle' 	=> true,
					'selectors' => [
						'{{WRAPPER}} .menu-canvas' => 'text-align: {{VALUE}};',
					],
				]
			);
			
			// Background Button
			$this->add_control(
				'btn_color',
				[
					'label' => esc_html__( 'Button', 'aovis' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .menu-toggle:before' => 'background-color: {{VALUE}};',
						'{{WRAPPER}} .menu-toggle span:before' => 'background-color: {{VALUE}};',
						'{{WRAPPER}} .menu-toggle:after' => 'background-color: {{VALUE}};',
					]
				]
			);

			// Background Menu
			$this->add_control(
				'bg_color',
				[
					'label' => esc_html__( 'Menu Background', 'aovis' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .container-menu' => 'background-color: {{VALUE}};',
					],
					'separator' => 'before'
				]
			);

			// Typography Menu Item
			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'typography',
					'selector'	=> '{{WRAPPER}} ul li a'
				]
			);

			// Control Tabs
			$this->start_controls_tabs(
				'style_tabs_text'
			);

				// Normal Tab
				$this->start_controls_tab(
					'style_normal_tab_text',
					[
						'label' => esc_html__( 'Normal', 'aovis' ),
					]
				);
			
					$this->add_control(
						'text_color',
						[
							'label' => esc_html__( 'Menu Color', 'aovis' ),
							'type' => Controls_Manager::COLOR,
							'default' => '',
							'selectors' => [
								'{{WRAPPER}} ul li a' => 'color: {{VALUE}};',
							]
						]
					);

				$this->end_controls_tab();


				// Hover Tab
				$this->start_controls_tab(
					'style_hover_tab_text',
					[
						'label' => esc_html__( 'Hover', 'aovis' ),
					]
				);

					$this->add_control(
						'text_color_hover',
						[
							'label' => esc_html__( 'Menu Color', 'aovis' ),
							'type' => Controls_Manager::COLOR,
							'default' => '',
							'selectors' => [
								'{{WRAPPER}} ul li a:hover' => 'color: {{VALUE}};',
							]
							
						]
					);

				$this->end_controls_tab();
				

				// Active Tab
				$this->start_controls_tab(
					'style_active_tab_text',
					[
						'label' => esc_html__( 'Active', 'aovis' ),
					]
				);

					$this->add_control(
						'text_color_active',
						[
							'label' => esc_html__( 'Menu Color', 'aovis' ),
							'type' => Controls_Manager::COLOR,
							'default' => '',
							'selectors' => [
								'{{WRAPPER}} ul li.current-menu-item > a' => 'color: {{VALUE}};',
								'{{WRAPPER}} ul li.current-menu-ancestor > a' => 'color: {{VALUE}};',
								'{{WRAPPER}} ul li.current-menu-parent > a' => 'color: {{VALUE}};',
							]
							
						]
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();	
			
			$this->add_responsive_control(
				'padding_item',
				[
					'label' 		=> esc_html__( 'Padding', 'aovis' ),
					'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px', '%', 'em', 'custom' ],
					'selectors' 	=> [
						'{{WRAPPER}} .menu-canvas ul li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator' 	=> 'before',
				]
			);

			$this->add_responsive_control(
				'margin_item',
				[
					'label' 		=> esc_html__( 'Margin', 'aovis' ),
					'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px', '%', 'em', 'custom' ],
					'selectors' 	=> [
						'{{WRAPPER}} .menu-canvas ul li a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' 		=> 'item_border',
					'selector' 	=> '{{WRAPPER}} .menu-canvas ul li a',
				]
			);

			$this->add_control(
				'arrow_color',
				[
					'label' 	=> esc_html__( 'Arrow Color', 'aovis' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .menu-canvas .dropdown-toggle' => 'color: {{VALUE}};',
					],
					'separator' => 'before',
				]
			);

			$this->add_responsive_control(
				'margin_submenu',
				[
					'label' 		=> esc_html__( 'Margin Sub', 'aovis' ),
					'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px', '%', 'em', 'custom' ],
					'selectors' 	=> [
						'{{WRAPPER}} .menu-canvas ul.menu ul' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

		$this->end_controls_section();
	}
	
	protected function render() {
		$settings = $this->get_settings();
		
		?>

		<nav class="menu-canvas">
            <button class="menu-toggle">
            	<span></span>
            </button>
            <nav class="container-menu <?php echo  esc_attr( $settings['menu_dir'] ); ?>" >
	            <div class="close-menu">
	            	<i class="ovaicon-cancel"></i>
	            </div>
				<?php
					wp_nav_menu( [
						'theme_location'  => $settings['menu_slug'],
						'container_class' => 'primary-navigation',
						'menu'              => $settings['menu_slug'],

					] );
				?>
			</nav>
			<div class="site-overlay"></div>
        </nav>
	<?php }
}

$widgets_manager->register( new Aovis_Elementor_Canvas_Menu() );