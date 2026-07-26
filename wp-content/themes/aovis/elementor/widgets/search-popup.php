<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Aovis_Elementor_Search_Popup extends Widget_Base {

	public function get_name() {
		return 'aovis_elementor_search_popup';
	}

	public function get_title() {
		return esc_html__( 'Search Popup', 'aovis' );
	}

	public function get_icon() {
		return 'eicon-search';
	}

	public function get_categories() {
		return [ 'aovis' ];
	}

	public function get_script_depends() {
		return [ 'aovis-elementor-search-popup' ];
	}
	
	// Add Your Controll In This Function
	protected function register_controls() {

		$this->start_controls_section(
			'section_icon_search',
			[
				'label' => esc_html__( 'Icon Search', 'aovis' ),
			]
		);

		    $this->add_control(
				'size_icon',
				[
					'label' => esc_html__( 'Size Icon', 'aovis' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 50,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default' => [
						'unit' => 'px',
					],
					'selectors' => [
						'{{WRAPPER}} .ova_wrap_search_popup i' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			
			$this->add_control(
				'color_icon_search',
				[
					'label' => esc_html__( 'Icon Color', 'aovis' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova_wrap_search_popup i' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'color_hover_icon_search',
				[
					'label' => esc_html__( 'Icon Color Hover', 'aovis' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova_wrap_search_popup i:hover' => 'color: {{VALUE}}',
					],
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_search_popup_button',
			[
				'label' => esc_html__( 'Search Popup Button', 'aovis' ),
			]
		);
			
			$this->add_control(
				'bgcolor_search_popup_button',
				[
					'label' => esc_html__( 'Background Color', 'aovis' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova_wrap_search_popup .ova_search_popup .container .search-form .search-submit' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'bgcolor_hover_icon_search_popup',
				[
					'label' => esc_html__( 'Background Color Hover', 'aovis' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova_wrap_search_popup .ova_search_popup .container .search-form .search-submit:hover' => 'background-color: {{VALUE}}',
					],
				]
			);

		$this->end_controls_section();
	}

	// Render Template Here
	protected function render() {
		$settings = $this->get_settings();

		?>

			<div class="ova_wrap_search_popup">
				<i class="ovaicon ovaicon-search"></i>
				<div class="ova_search_popup">
					<div class="search-popup__overlay"></div>
					<div class="container">
						<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
						        <input type="search" class="search-field" placeholder="<?php esc_attr_e( 'Search …', 'aovis' ) ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php esc_attr_e( 'Search for:', 'aovis' ) ?>" />
				   			 	<button type="submit" class="search-submit">
				   			 		<i class="ovaicon ovaicon-search"></i>
				   			 	</button>
						</form>									
					</div>
				</div>
			</div>

		<?php
	}

	
}
$widgets_manager->register( new Aovis_Elementor_Search_Popup() );