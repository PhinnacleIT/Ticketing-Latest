<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Aovis_Elementor_Ova_Counter extends Widget_Base {

	public function get_name() {
		return 'aovis_elementor_ova_counter';
	}

	public function get_title() {
		return esc_html__( 'Ova Counter', 'aovis' );
	}

	public function get_icon() {
		return 'eicon-counter';
	}

	public function get_categories() {
		return [ 'aovis' ];
	}

	public function get_script_depends() {
		// appear js
		wp_enqueue_script( 'aovis-counter-appear', get_theme_file_uri('/assets/libs/appear/appear.js'), array('jquery'), false, true);
		// Odometer for counter
		wp_enqueue_style( 'odometer', get_template_directory_uri().'/assets/libs/odometer/odometer.min.css' );
		wp_enqueue_script( 'odometer', get_template_directory_uri().'/assets/libs/odometer/odometer.min.js', array('jquery'), false, true );

		return [ 'aovis-elementor-ova-counter' ];
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
					'label' => esc_html__( 'Border Style', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'template1',
					'options' => [
						'template1' => esc_html__( 'Template 1', 'aovis' ),
						'template2' => esc_html__( 'Template 2', 'aovis' ),
						'template3' => esc_html__( 'Template 3', 'aovis' ),
					],
				]
			);
			
			// Add Class control
			$this->add_control(
				'icon',
				[
					'label' => esc_html__( 'Icon', 'aovis' ),
					'type' => \Elementor\Controls_Manager::ICONS,
					'default' => [
						'value' => 'flaticon flaticon-badge',
						'library' => 'flaticon',
					],
					'condition' => [
						'template' => 'template1',
					],
				]
			);

			$this->add_control(
				'number',
				[
					'label' 	=> esc_html__( 'Number', 'aovis' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => esc_html__( '23', 'aovis' ),
				]
			);

			$this->add_control(
				'suffix',
				[
					'label'  => esc_html__( 'Suffix', 'aovis' ),
					'type'   => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'Plus', 'aovis' ),
				]
			);

			$this->add_control(
				'content',
				[
					'label' 	=> esc_html__( 'Text', 'aovis' ),
					'type' 	=> Controls_Manager::TEXTAREA,
					'default' => esc_html__( 'Awards Won', 'aovis' ),
				]
			);

			$this->add_responsive_control(
				'align',
				[
					'label' 	=> esc_html__( 'Alignment', 'aovis' ),
					'type' 		=> Controls_Manager::CHOOSE,
					'default'   => esc_html__( 'center', 'aovis' ),
					'options' 	=> [
						'flex-start' 	=> [
							'title' => esc_html__( 'Left', 'aovis' ),
							'icon' 	=> 'eicon-text-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'aovis' ),
							'icon' 	=> 'eicon-text-align-center',
						],
						'flex-end' => [
							'title' => esc_html__( 'Right', 'aovis' ),
							'icon' 	=> 'eicon-text-align-right',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .ova-counter' => 'justify-content: {{VALUE}};',
					],
					'condition' => [
						'template' => 'template1',
					],
				]
			);

		$this->end_controls_section();

		/* Begin Counter Style */
		$this->start_controls_section(
            'counter_style',
            [
               'label' => esc_html__( 'Ova Counter', 'aovis' ),
               'tab' 	=> Controls_Manager::TAB_STYLE,
            ]
        );

			$this->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
				[
					'name' => 'counter_background',
					'types' => [ 'classic', 'gradient'],
					'selector' => '{{WRAPPER}} .ova-counter',
				]
			);

		    $this->add_responsive_control(
	            'counter_padding',
	            [
	                'label' 		=> esc_html__( 'Padding', 'aovis' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .ova-counter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

	        $this->add_responsive_control(
	            'counter_margin',
	            [
	                'label' 		=> esc_html__( 'Margin', 'aovis' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .ova-counter' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'counter_border',
					'label' => esc_html__( 'Border', 'aovis' ),
					'selector' => '{{WRAPPER}} .ova-counter',
				]
			);

        $this->end_controls_section();
		/* End counter style */

		/* Begin icon Style */
		$this->start_controls_section(
            'icon_style',
            [
                'label' => esc_html__( 'Icon', 'aovis' ),
                'tab' 	=> Controls_Manager::TAB_STYLE,
                'condition' => [
					'template' => 'template1',
				],
            ]
        );
            
			$this->add_responsive_control(
				'size_icon',
				[
					'label' 		=> esc_html__( 'Size', 'aovis' ),
					'type' 			=> Controls_Manager::SLIDER,
					'size_units' 	=> [ 'px'],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
							'step' => 1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .ova-counter .icon i' => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .ova-counter .icon svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
					],
				]
			);

            $this->add_control(
				'icon_color',
				[
					'label' 	=> esc_html__( 'Color', 'aovis' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-counter .icon i' => 'color: {{VALUE}};',
						'{{WRAPPER}} .ova-counter .icon svg path' => 'fill : {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'icon_background_color',
				[
					'label' 	=> esc_html__( 'Background Color', 'aovis' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-counter .icon' => 'background-color: {{VALUE}};',
					],
				]
			);

			$this->add_responsive_control(
	            'icon_padding',
	            [
	                'label' 		=> esc_html__( 'Padding', 'aovis' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .ova-counter .icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

	        $this->add_responsive_control(
				'icon_align',
				[
					'label' 	=> esc_html__( 'Alignment', 'aovis' ),
					'type' 		=> Controls_Manager::CHOOSE,
					'default'   => esc_html__( 'center', 'aovis' ),
					'options' 	=> [
						'flex-start' 	=> [
							'title' => esc_html__( 'Left', 'aovis' ),
							'icon' 	=> 'eicon-text-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'aovis' ),
							'icon' 	=> 'eicon-text-align-center',
						],
						'flex-end' => [
							'title' => esc_html__( 'Right', 'aovis' ),
							'icon' 	=> 'eicon-text-align-right',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .ova-counter .icon' => 'justify-content: {{VALUE}};',
					],
				]
			);
		
        $this->end_controls_section();
		/* End icon style */

		/* Begin content Style */
		$this->start_controls_section(
            'content_style',
            [
                'label' => esc_html__( 'Content', 'aovis' ),
                'tab' 	=> Controls_Manager::TAB_STYLE,
            ]
        );

			$this->add_control(
				'content_background_color',
				[
					'label' 	=> esc_html__( 'Background', 'aovis' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-counter .counter-content' => 'background-color: {{VALUE}};',
						'{{WRAPPER}} .ova-counter.template3 .counter-content .triangle-2' => 'border-top-color: {{VALUE}};',
					],
				]
			);

			$this->add_responsive_control(
	            'content_padding',
	            [
	                'label' 		=> esc_html__( 'Padding', 'aovis' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .ova-counter .counter-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

	        $this->add_responsive_control(
	            'content_margin',
	            [
	                'label' 		=> esc_html__( 'Margin', 'aovis' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .ova-counter .counter-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

	        $this->add_control(
				'content_border_color',
				[
					'label' 	=> esc_html__( 'Border Color', 'aovis' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-counter .counter-content' => 'border-color: {{VALUE}};',
						'{{WRAPPER}} .ova-counter.template3 .counter-content .triangle-1' => 'border-top-color: {{VALUE}};',
					],
					'condition' => [
						'template' => 'template3',
					]
				]
			);

        $this->end_controls_section();
		/* End content style */

		/* Begin number (odometer) Style */
		$this->start_controls_section(
            'number_style',
            [
                'label' => esc_html__( 'Number', 'aovis' ),
                'tab' 	=> Controls_Manager::TAB_STYLE,
            ]
        );

        	$this->add_control(
				'number_position',
				[
					'label' => esc_html__( ' Position', 'aovis' ),
					'type' => Controls_Manager::CHOOSE,
					'default' => 'row',
					'options' => [
						'row' => [
							'title' => esc_html__( 'Left', 'aovis' ),
							'icon' => 'eicon-h-align-left',
						],
						'column' => [
							'title' => esc_html__( 'Top', 'aovis' ),
							'icon' => 'eicon-v-align-top',
						],
						'row-reverse' => [
							'title' => esc_html__( 'Right', 'aovis' ),
							'icon' => 'eicon-h-align-right',
						],
					],
					'selectors' => [
					'{{WRAPPER}} .ova-counter .counter-content' => 'display: flex ; flex-direction: {{VALUE}}; align-items: center;',
					],
					'condition' => [
						'template' => 'template3' ,
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 		=> 'number_typography',
					'selector' 	=> '{{WRAPPER}} .ova-counter .odometer',
				]
			);

			$this->add_control(
				'number_color',
				[
					'label' 	=> esc_html__( 'Color', 'aovis' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-counter .odometer' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_responsive_control(
	            'number_margin',
	            [
	                'label' 		=> esc_html__( 'Margin', 'aovis' ),
	                'type' 			=> Controls_Manager::DIMENSIONS,
	                'size_units' 	=> [ 'px', '%', 'em' ],
	                'selectors' 	=> [
	                    '{{WRAPPER}} .ova-counter .odometer' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

        $this->end_controls_section();
		/* End number style */

		/* Begin suffix Style */
		$this->start_controls_section(
            'suffix_style',
            [
                'label' => esc_html__( 'Suffix', 'aovis' ),
                'tab' 	=> Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 		=> 'suffix_typography',
					'selector' 	=> '{{WRAPPER}} .ova-counter .suffix',
				]
			);

			$this->add_control(
				'suffix_color',
				[
					'label' 	=> esc_html__( 'Color', 'aovis' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-counter .suffix' => 'color: {{VALUE}};',
					],
				]
			);

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
					'selector' 	=> '{{WRAPPER}} .ova-counter .content',
				]
			);

			$this->add_control(
				'text_color',
				[
					'label' 	=> esc_html__( 'Color', 'aovis' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-counter .content' => 'color: {{VALUE}};',
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
	                    '{{WRAPPER}} .ova-counter .content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

        $this->end_controls_section();
		/* End text style */
	}

	// Render Template Here
	protected function render() {
		$settings = $this->get_settings();

		$template 	 = $settings['template'];
		$icon  		 = $settings['icon'];
		$number      = isset( $settings['number'] ) ? $settings['number'] : '100';
		$suffix      = $settings['suffix'];
		$content     = $settings['content'];

		?>
       	    <div class="ova-counter <?php echo esc_attr( $template ); ?> " data-count="<?php echo esc_attr( $number ); ?>">

                <?php if ( !empty( $icon['value'] ) && $template == 'template1' ): ?>
                	<div class="icon">
	            	    <?php 
						    \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] );
						?>	
	            	</div>
	            <?php endif;?>
            
	            <div class="counter-content">
		 
					<span class="odometer">0</span><span class="suffix"><?php echo esc_html( $suffix ); ?></span>
	
		      	    <?php if (!empty( $content )): ?><p class="content"><?php echo esc_html( $content ); ?></p><?php endif;?>

		      	    <?php if( $template == 'template3') : ?>
			      	    <div class="triangle-1"></div>
			      	    <div class="triangle-2"></div>
			      	<?php endif; ?>

	            </div>

           	</div>

		<?php
	}
}
$widgets_manager->register( new Aovis_Elementor_Ova_Counter() );