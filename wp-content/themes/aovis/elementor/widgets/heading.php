<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class Aovis_Elementor_Heading extends Widget_Base {

	
	public function get_name() {
		return 'aovis_elementor_heading';
	}

	
	public function get_title() {
		return esc_html__( 'Ova Heading', 'aovis' );
	}

	
	public function get_icon() {
		return 'eicon-heading';
	}

	
	public function get_categories() {
		return [ 'aovis' ];
	}

	public function get_script_depends() {
		return [ '' ];
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
				'template',
				[
					'label' => esc_html__( 'Template', 'aovis' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'template1',
					'options' => [
						'template1' => esc_html__('Template 1 (Normal)', 'aovis'),
						'template2' => esc_html__('Template 2 (White)', 'aovis'),
					]
				]
			);

	        $this->add_control(
				'icon',
				[
					'label' => esc_html__( 'Icon', 'aovis' ),
					'type' => \Elementor\Controls_Manager::ICONS,
					'default' => [
						'value' => 'flaticon flaticon-film-roll',
						'library' => 'all',
					],
					
				]
			);
			
			$this->add_control(
				'sub_title',
				[
					'label' 	=> esc_html__( 'Sub Title', 'aovis' ),
					'type' 		=> Controls_Manager::TEXT,
					'default' 	=> esc_html__( 'Sub Title', 'aovis' ),
				]
			);

			$this->add_control(
				'title',
				[
					'label' 	=> esc_html__( 'Title', 'aovis' ),
					'type' 		=> Controls_Manager::TEXTAREA,
					'default' 	=> esc_html__( 'Aovis Movie Booking', 'aovis' ),
				]
			);

			$this->add_control(
				'description',
				[
					'label' 	=> esc_html__( 'Description', 'aovis' ),
					'type' 		=> Controls_Manager::TEXTAREA,
				]
			);

			$this->add_control(
				'link_address',
				[
					'label'   		=> esc_html__( 'Link', 'aovis' ),
					'type'    		=> \Elementor\Controls_Manager::URL,
					'show_external' => false,
					'default' 		=> [
						'url' 			=> '',
						'is_external' 	=> false,
						'nofollow' 		=> false,
					],
				]
			);
			
			$this->add_control(
				'html_tag',
				[
					'label' 	=> esc_html__( 'HTML Tag', 'aovis' ),
					'type' 		=> \Elementor\Controls_Manager::SELECT,
					'default' 	=> 'h2',
					'options' 	=> [
						'h1' 		=> esc_html__( 'H1', 'aovis' ),
						'h2'  		=> esc_html__( 'H2', 'aovis' ),
						'h3'  		=> esc_html__( 'H3', 'aovis' ),
						'h4' 		=> esc_html__( 'H4', 'aovis' ),
						'h5' 		=> esc_html__( 'H5', 'aovis' ),
						'h6' 		=> esc_html__( 'H6', 'aovis' ),
						'div' 		=> esc_html__( 'Div', 'aovis' ),
						'span' 		=> esc_html__( 'span', 'aovis' ),
						'p' 		=> esc_html__( 'p', 'aovis' ),
					],
				]
			);

			$this->add_responsive_control(
				'alignment',
				[
					'label' 	=> esc_html__( 'Alignment', 'aovis' ),
					'type' 		=> \Elementor\Controls_Manager::CHOOSE,
					'options' 	=> [
						'left' => [
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
					'toggle' 	=> true,
					'selectors' => [
						'{{WRAPPER}} .ova-heading' => 'text-align: {{VALUE}}',
					],
				]
			);

		$this->end_controls_section();
        
        //SECTION TAB STYLE ICON
		$this->start_controls_section(
			'icon_section_style',
			[
				'label' => esc_html__( 'Icon', 'aovis' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_responsive_control(
				'icon_size',
				[
					'label' => esc_html__( 'Size', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 60,
							'step' => 5,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .ova-heading i' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'icon_color',
				[
					'label' => esc_html__( 'Icon Color', 'aovis' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-heading i' => 'color: {{VALUE}}',
					],
				]
			);

		$this->end_controls_section();
		
		//SECTION TAB STYLE TITLE
		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Title', 'aovis' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' 		=> 'content_typography_title',
					'label' 	=> esc_html__( 'Typography', 'aovis' ),
					'selector' 	=> '{{WRAPPER}} .ova-heading .title',
				]
			);

			$this->add_control(
				'color_title',
				[
					'label' 	=> esc_html__( 'Color', 'aovis' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-heading .title, {{WRAPPER}} .ova-heading .title a, {{WRAPPER}} .ova-heading .top-heading .title' => 'color : {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'color_title_hover',
				[
					'label' 	=> esc_html__( 'Color Hover', 'aovis' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-heading .title:hover, {{WRAPPER}} .ova-heading .title:hover a, {{WRAPPER}} .ova-heading .top-heading .title:hover' => 'color : {{VALUE}};'
					],
					
				]
			);

			$this->add_responsive_control(
				'padding_title',
				[
					'label' 	 => esc_html__( 'Padding', 'aovis' ),
					'type' 		 => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .ova-heading .title ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control( 
				'margin_title',
				[
					'label' 	 => esc_html__( 'Margin', 'aovis' ),
					'type' 		 => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .ova-heading .title ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'show_square_corner',
				[
					'label' 		=> esc_html__( 'Show Square Corner', 'aovis' ),
					'type' 			=> \Elementor\Controls_Manager::SWITCHER,
					'label_on' 		=> esc_html__( 'Show', 'aovis' ),
					'label_off' 	=> esc_html__( 'Hide', 'aovis' ),
					'return_value' 	=> 'yes',
					'default' 		=> 'no',
				]
			);

			$this->add_control(
				'color_square_corner',
				[
					'label' 	=> esc_html__( 'Color Square Corner', 'aovis' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-heading .top-heading:before' => 'border-color : {{VALUE}};',
					],
					'condition' => [
						'show_square_corner' => 'yes'
					]
				]
			);

			$this->add_control(
				'show_shape_underline',
				[
					'label' 		=> esc_html__( 'Show Shape Underline', 'aovis' ),
					'type' 			=> \Elementor\Controls_Manager::SWITCHER,
					'label_on' 		=> esc_html__( 'Show', 'aovis' ),
					'label_off' 	=> esc_html__( 'Hide', 'aovis' ),
					'return_value' 	=> 'yes',
					'default' 		=> 'no',
				]
			);

			$this->add_control(
				'type_underline',
				[
					'label' => esc_html__( 'Type', 'aovis' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'word',
					'options' => [
						'word' => esc_html__('Word', 'aovis'),
						'entire' => esc_html__('Entire', 'aovis'),
					],
					'condition' => [
						'show_shape_underline' => 'yes'
					]
				]
			);

			$this->add_control(
				'word_position',
				[
					'label' => esc_html__( 'Word Position', 'aovis' ),
					'type'	=> \Elementor\Controls_Manager::NUMBER,
					'min' 	=> 0,
					'max' 	=> 20,
					'step' 	=> 1,
					'default' => 0,
					'description' => esc_html__( '( 0 is first word )', 'aovis' ),
					'condition' => [
						'show_shape_underline' => 'yes',
						'type_underline' => 'word'
					]
				]
			);

		$this->end_controls_section();
		//END SECTION TAB STYLE TITLE

		//SECTION TAB STYLE SUB TITLE
		$this->start_controls_section(
			'section_sub_title',
			[
				'label' => esc_html__( 'Sub Title', 'aovis' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' 		=> 'content_typography_sub_title',
					'label' 	=> esc_html__( 'Typography', 'aovis' ),
					'selector' 	=> '{{WRAPPER}} .ova-heading .sub-title',
				]
			);

			$this->add_control(
				'color_sub_title',
				[
					'label'	 	=> esc_html__( 'Color', 'aovis' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-heading .sub-title' => 'color : {{VALUE}};'
						
						
					],
				]
			);

			$this->add_responsive_control(
				'padding_sub_title',
				[
					'label' 	 => esc_html__( 'Padding', 'aovis' ),
					'type' 		 => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .ova-heading .sub-title ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'margin_sub_title',
				[
					'label' 	 => esc_html__( 'Margin', 'aovis' ),
					'type' 		 => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .ova-heading .sub-title ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'show_special_style',
				[
					'label' 		=> esc_html__( 'Show Special Style', 'aovis' ),
					'type' 			=> \Elementor\Controls_Manager::SWITCHER,
					'label_on' 		=> esc_html__( 'Show', 'aovis' ),
					'label_off' 	=> esc_html__( 'Hide', 'aovis' ),
					'return_value' 	=> 'yes',
					'default' 		=> 'no',
				]
			);

			$this->add_responsive_control(
				'sub_title_bottom',
				[
					'label' => esc_html__( 'Bottom', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%' ],
					'range' => [
						'px' => [
							'min' => -200,
							'max' => 200,
							'step' => 5,
						],
						'%' => [
							'min' => -100,
							'max' => 100,
							'step' => 2,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .ova-heading .sub-title.special-style' => 'bottom: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'show_special_style' => 'yes'
					]
				]
			);

			$this->add_responsive_control(
				'sub_title_right',
				[
					'label' => esc_html__( 'Right', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%' ],
					'range' => [
						'px' => [
							'min' => -200,
							'max' => 200,
							'step' => 5,
						],
						'%' => [
							'min' => -100,
							'max' => 100,
							'step' => 2,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .ova-heading .sub-title.special-style' => 'right: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'show_special_style' => 'yes'
					]
				]
			);
			
		$this->end_controls_section();
		//END SECTION TAB STYLE SUB TITLE

		//SECTION TAB STYLE DESCRIPTION
		$this->start_controls_section(
			'section_description',
			[
				'label' => esc_html__( 'Description', 'aovis' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' 		=> 'content_typography_description',
					'label' 	=> esc_html__( 'Typography', 'aovis' ),
					'selector' 	=> '{{WRAPPER}} .ova-heading .description',
				]
			);

			$this->add_control(
				'color_description',
				[
					'label'	 	=> esc_html__( 'Color', 'aovis' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-heading .description' => 'color : {{VALUE}};'		
					],
				]
			);

			$this->add_responsive_control(
				'padding_description',
				[
					'label' 	 => esc_html__( 'Padding', 'aovis' ),
					'type' 		 => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .ova-heading .description ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'margin_description',
				[
					'label' 	 => esc_html__( 'Margin', 'aovis' ),
					'type' 		 => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .ova-heading .description ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			
		$this->end_controls_section();
		//END SECTION TAB STYLE DESCRIPTION
		
	}

	// Render Template Here
	protected function render() {

		$settings 		= 	$this->get_settings();
        
        $template 		= 	$settings['template'];
		
		
		$description	= 	$settings['description']; 
		$link      		= 	$settings['link_address']['url'];
		$target    		= 	$settings['link_address']['is_external'] ? ' target="_blank"' : '';
		$html_tag  		= 	$settings['html_tag'];
         
        // title
        $title     				= 	$settings['title'];
        $show_square_corner     =   $settings['show_square_corner'];
		$show_shape_underline 	= 	$settings['show_shape_underline'];
		$type_underline 		= 	$settings['type_underline'] ? $settings['type_underline'] : '' ;
		$word_position 			= 	$settings['word_position'] ? $settings['word_position'] : 0 ;
		$square_corner 			= 	'';
        
        // replace % to %% avoid printf error
		if(strpos($title, '%') !== false){
		    $title = str_replace('%', '%%', $title);
		}

		if($show_square_corner == 'yes') {
			$square_corner 		= 'has-square-corner';
		}

		if($show_shape_underline == 'yes') {

			if($type_underline == 'word') {
				$explode_fullname 	= explode(' ', $title);
				$replace 			= '<span class="word">' . $explode_fullname[$word_position] . '</span>';
				$title     			= str_replace( $explode_fullname[$word_position], $replace, $title );
			} else {
				$title = '<span>' . $title . '</span>';
			}
			
		}
        
        // sub title
        $sub_title 				= 	$settings['sub_title'];
	 	$show_special_style 	= 	$settings['show_special_style'];
	 	$special_style			= '';

	 	if($show_special_style == 'yes') {
			$special_style 		= 'special-style';
		}		

		?>

		<div class="ova-heading ova-heading-<?php echo esc_attr( $template ); ?>">
            
            <div class="icon">
            	<?php if( $settings['icon']['value'] != '' ): ?>
					<?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
				<?php endif; ?>
            </div>

			<div class="top-heading <?php echo esc_attr( $square_corner ); ?>">
				<?php if( $sub_title ): ?>
					<h3 class="sub-title <?php echo esc_attr( $special_style ); ?>"><?php echo esc_html( $sub_title ); ?></h3>
				<?php endif; ?>

				<?php if( $title) : ?>

					<?php if( $link ) { ?>
					
						<<?php echo esc_attr($html_tag); ?> class="title"><a href="<?php echo esc_url( $link ); ?>"<?php printf( $target ); ?>><?php printf($title);?></a></<?php echo esc_attr( $html_tag ); ?>>

					<?php } else { ?>

						<<?php echo esc_attr($html_tag); ?> class="title"><?php printf($title); ?></<?php echo esc_attr( $html_tag ); ?>>

					<?php } ?>

				<?php endif; ?>
			</div>

			<?php if( $description ): ?>
				<p class="description"><?php echo esc_html( $description ); ?></p>
			<?php endif; ?>

		</div>
		 	
		<?php
	}
	
}
$widgets_manager->register( new Aovis_Elementor_Heading() );