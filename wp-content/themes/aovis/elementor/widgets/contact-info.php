<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Aovis_Elementor_Contact_Info extends Widget_Base {

	public function get_name() {
		return 'aovis_elementor_contact_info';
	}

	public function get_title() {
		return esc_html__( 'Contact Info', 'aovis' );
	}

	public function get_icon() {
		return 'eicon-email-field';
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
			// Add Class control
			$this->add_control(
				'icon',
				[
					'label' => esc_html__( 'Icon', 'aovis' ),
					'type' => \Elementor\Controls_Manager::ICONS,
					'default' => [
						'value' => 'flaticon flaticon-location',
						'library' => 'flaticon',
					],
				]
			);

			$this->add_control(
				'title',
				[
					'label' => esc_html__( 'Title', 'aovis' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'Contact', 'aovis' ),
				]
			);

			$this->add_control(
				'html_tag',
				[
					'label' => esc_html__( 'HTML Tag', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'h3',
					'options' => [
						'h1' => esc_html__( 'H1', 'aovis' ),
						'h2' => esc_html__( 'H2', 'aovis' ),
						'h3' => esc_html__( 'H3', 'aovis' ),
						'h4' => esc_html__( 'H4', 'aovis' ),
						'h5' => esc_html__( 'H5', 'aovis' ),
						'h6' => esc_html__( 'H6', 'aovis' ),
						'div' => esc_html__( 'div', 'aovis' ),
						'span' => esc_html__( 'span', 'aovis' ),
						'p' => esc_html__( 'p', 'aovis' ),
					],
				]
			);

			$repeater = new \Elementor\Repeater();

			$repeater->add_control(
				'type',
				[
					'label' => esc_html__( 'Type', 'aovis' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'email',
					'options' => [
						'email'  => esc_html__( 'Email', 'aovis' ),
						'phone' => esc_html__( 'Phone', 'aovis' ),
						'link' => esc_html__( 'Link', 'aovis' ),
						'text' => esc_html__( 'Text', 'aovis' ),
					],
				]
			);

			$repeater->add_control(
				'email_label',
				[
					'label' => esc_html__( 'Email Label', 'aovis' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'email@company.com', 'aovis' ),
					'placeholder' => esc_html__( 'Type your email label here', 'aovis' ),
					'description' => esc_html__( 'email@company.com', 'aovis' ),
					'condition' => [
						'type' => 'email',
					]
				]
			);

			$repeater->add_control(
				'email_address',
				[
					'label' => esc_html__( 'Email Address', 'aovis' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'email@company.com', 'aovis' ),
					'placeholder' => esc_html__( 'Type your email address here', 'aovis' ),
					'description' => esc_html__( 'email@company.com', 'aovis' ),
					'condition' => [
						'type' => 'email',
					]
				]
			);

			$repeater->add_control(
				'phone_label',
				[
					'label' => esc_html__( 'Phone Label', 'aovis' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'description' => esc_html__( '+ 012 (345) 678', 'aovis' ),
					'condition' => [
						'type' => 'phone',
					]
				]
			);

			$repeater->add_control(
				'phone_address',
				[
					'label' => esc_html__( 'Phone Address', 'aovis' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'description' => esc_html__( '12345678', 'aovis' ),
					'condition' => [
						'type' => 'phone',
					]
				]
			);

			$repeater->add_control(
				'link_label',
				[
					'label' => esc_html__( 'Link Label', 'aovis' ),
					'type' => \Elementor\Controls_Manager::TEXTAREA,
					'description' => esc_html__( 'https://your-domain.com', 'aovis' ),
					'condition' => [
						'type' => 'link',
					]
				]
			);

			$repeater->add_control(
				'link_address',
				[
					'label' => esc_html__( 'Link', 'aovis' ),
					'type' => \Elementor\Controls_Manager::URL,
					'description' => esc_html__( 'https://your-domain.com', 'aovis' ),
					'options' => [ 'url', 'is_external', 'nofollow' ],
					'default' => [
						'url' => '#',
						'is_external' => false,
						'nofollow' => false,
					],
					'condition' => [
						'type' => 'link',
					]
				]
			);

			$repeater->add_control(
				'text',
				[
					'label' => esc_html__( 'Text', 'aovis' ),
					'type' => \Elementor\Controls_Manager::TEXTAREA,
					'description' => esc_html__( 'Your Text', 'aovis' ),
					'default' => esc_html__( 'Morbi ut tellus ac leo mol stie luctus nec vehicula sed', 'aovis' ),
					'condition' => [
						'type' => 'text',
					]
				]
			);

			$this->add_control(
				'item_info',
				[
					'label' => esc_html__( 'Item Info', 'aovis' ),
					'type' => \Elementor\Controls_Manager::REPEATER,
					'fields' => $repeater->get_controls(),
					'default' => [
						[
							'type' => 'email',
							'email_label' => esc_html__('email@company.com', 'aovis'),
							'email_address' => esc_html__('email@company.com', 'aovis'),
						],
					],
					'title_field' => '{{{ type }}}',
				]
			);

			$this->add_control(
				'background_image',
				[
					'label' => esc_html__( 'Background Image', 'aovis' ),
					'type' => \Elementor\Controls_Manager::MEDIA,
					'default' => [
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					],
					'separator' => 'before',
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_general_style',
			[
				'label' => esc_html__( 'General', 'aovis' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_responsive_control(
				'general_padding',
				[
					'label' => esc_html__( 'Padding', 'aovis' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .ova-contact-info'=> 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->start_controls_tabs(
				'style_tabs'
			);

				$this->start_controls_tab(
					'style_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'aovis' ),
					]
				);

					$this->add_group_control(
						\Elementor\Group_Control_Border::get_type(),
						[
							'name' => 'general_border',
							'selector' => '{{WRAPPER}} .ova-contact-info .border-wrapper',
						]
					);

					$this->add_group_control(
						\Elementor\Group_Control_Box_Shadow::get_type(),
						[
							'name' => 'general_box_shadow',
							'selector' => '{{WRAPPER}} .ova-contact-info',
						]
					);

				$this->end_controls_tab();

			$this->start_controls_tab(
				'style_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'aovis' ),
				]
			);

					$this->add_group_control(
						\Elementor\Group_Control_Border::get_type(),
						[
							'name' => 'general_border_hover',
							'selector' => '{{WRAPPER}} .ova-contact-info:hover .border-wrapper',
						]
					);

					$this->add_group_control(
						\Elementor\Group_Control_Box_Shadow::get_type(),
						[
							'name' => 'general_box_shadow_hover',
							'selector' => '{{WRAPPER}} .ova-contact-info:hover',
						]
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_icon_style',
			[
				'label' => esc_html__( 'Icon', 'aovis' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'icon_size',
				[
					'label' => esc_html__( 'Size', 'aovis' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 1,
							'max' => 100,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .ova-contact-info .icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'icon_color',
				[
					'label' => esc_html__( 'Color', 'aovis' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-contact-info .icon i' => 'color : {{VALUE}};',
					],
				]
			);

			$this->add_responsive_control(
				'icon_margin',
				[
					'label' => esc_html__( 'Margin', 'aovis' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .ova-contact-info .icon'=> 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

		$this->end_controls_section(); // End Icon Style Tab

		/**
		 * Title Style Tab
		 */
		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Title', 'aovis' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'title_typography',
					'selector' => '{{WRAPPER}} .ova-contact-info .content .title',
				]
			);

			$this->add_control(
				'title_color',
				[
					'label' => esc_html__( 'Color', 'aovis' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-contact-info .content .title' => 'color : {{VALUE}};',
					],
				]
			);

			$this->add_responsive_control(
				'title_margin',
				[
					'label' => esc_html__( 'Margin', 'aovis' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .ova-contact-info .content .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

		$this->end_controls_section(); // End Label Style Tab


		/**
		 * Info Style Tab
		 */
		$this->start_controls_section(
			'section_info_style',
			[
				'label' => esc_html__( 'Info', 'aovis' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'info_typography',
					'selector' => '{{WRAPPER}} .ova-contact-info .content .info .item, {{WRAPPER}} .ova-contact-info .content .info .item a, {{WRAPPER}} .ova-contact-info .content .info .item p',
				]
			);

			$this->add_control(
				'info_color',
				[
					'label' => esc_html__( 'Color', 'aovis' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-contact-info .content .info .item' => 'color : {{VALUE}};',
						'{{WRAPPER}} .ova-contact-info .content .info .item a' => 'color : {{VALUE}};',
						'{{WRAPPER}} .ova-contact-info .content .info .item p' => 'color : {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'info_color_hover',
				[
					'label' => esc_html__( 'Link Color hover', 'aovis' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-contact-info .content .info .item a:hover' => 'color : {{VALUE}};',
					],
				]
			);

			$this->add_responsive_control(
				'info_margin',
				[
					'label' => esc_html__( 'Margin', 'aovis' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .ova-contact-info .content .info .item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

		$this->end_controls_section(); 

		$this->start_controls_section(
			'section_background',
			[
				'label' => esc_html__( 'Background', 'aovis' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'background_color_overlay',
				[
					'label' => esc_html__( 'Color', 'aovis' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-contact-info .overlay' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_responsive_control(
				'background_opacity',
				[
					'label' => esc_html__( 'Opacity', 'aovis' ),
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
						'{{WRAPPER}} .ova-contact-info .background' => 'opacity: {{SIZE}};',
					],
				]
			);

		$this->end_controls_section(); 
	}

	// Render Template Here
	protected function render() {
		$settings = $this->get_settings();
		$icon 				= 	$settings['icon'];
		$title 				= 	$settings['title'];
		$html_tag 			= 	$settings['html_tag'];
		$nofollow      		= 	( isset( $link['nofollow'] ) && $link['nofollow'] ) ? 'rel=nofollow' : '';
		$target           	=   ( isset( $link['is_external'] ) && $link['is_external'] == 'on' ) ? '_blank' : '';

		$background_image  	=	$settings['background_image'];

		?>
			<div class="ova-contact-info">
				<div class="content">

					<?php if( !empty($title) ) { ?>

	                	<<?php echo esc_html( $html_tag ); ?> class="title"><?php echo esc_html( $title ); ?></<?php echo esc_html( $html_tag ); ?>>

	                <?php } ?>

	                <ul class="info">
	                	
	                	<?php foreach ( $settings['item_info']  as $item ) : 
	                		$type = $item['type'];
	                	?> 
	                		
	                		<li class="item ">
	                			<?php

	                			switch ($type) {

									case "email":
									    $email_address = $item['email_address'];
										$email_label = $item['email_label'];

										if( $email_address && $email_label ){ ?>
										
											<a href="mailto:<?php echo esc_attr( $email_address ) ?> " title="<?php esc_attr_e( 'address', 'aovis' ); ?>"><?php echo esc_html( $email_label ); ?></a>

										<?php }
									    break;

									case "phone":

									    $phone_label = $item['phone_label'];
									    $phone_address = $item['phone_address'];

									    if( $phone_address && $phone_label ) { ?>
									    
											<a href="tel:<?php echo esc_attr( $phone_address ); ?>" title=" <?php echo esc_attr_e( 'address' , 'aovis' ); ?> "><?php echo esc_html( $phone_label ); ?></a>

									    <?php }
									    break;

									case "link":

									    $this->add_render_attribute( 'title' );

											$link_address = $item['link_address']['url'];
											$link_label = $item['link_label'];

											$title = $item['link_label'] ? $item['link_label'] : '';

											if ( ! empty( $item['link_address']['url'] ) ) {

												$this->add_link_attributes( 'url', $item['link_address'] );

												echo sprintf( '<a %1$s title="%2$s">%3$s</a>', $this->get_render_attribute_string( 'url' ), esc_attr( $title ), esc_html( $title ) );

											}else{

												echo esc_html( $title );

											}
									    break;

									case "text":
									    $text = $item['text'];

									    if( $text ) { ?>
									    
											<p><?php echo esc_html( $text ); ?></p>

									    <?php }
									    break;

									default: ''  ;
								}

								?> 
	                		</li>

	                	<?php endforeach; ?>

	                </ul>

				</div>
                

				<?php if( !empty($icon) ) { ?>
					<span class="icon"><?php \Elementor\Icons_Manager::render_icon( $icon , [ 'aria-hidden' => 'true' ] ); ?></span> 
				<?php } ?>

				<div class="background"
		 	    	style="background-image: url(<?php echo esc_attr( $background_image['url'] ) ; ?>)"
                >	
                </div>

                <div class="overlay"></div>

                <div class="border-wrapper"></div>

			</div>
					
		<?php
	}

	
}
$widgets_manager->register( new Aovis_Elementor_Contact_Info() );