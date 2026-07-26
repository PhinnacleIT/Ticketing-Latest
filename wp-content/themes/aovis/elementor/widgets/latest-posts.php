<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class Aovis_Elementor_Latest_Posts extends Widget_Base {

	
	public function get_name() {
		return 'aovis_elementor_latest_posts';
	}

	
	public function get_title() {
		return esc_html__( 'Latest Posts', 'aovis' );
	}

	
	public function get_icon() {
		return 'eicon-post-list';
	}

	
	public function get_categories() {
		return [ 'aovis' ];
	}

	public function get_script_depends() {
		return [ '' ];
	}
	
	// Add Your Controll In This Function
	protected function register_controls() {

		$args = array(
			'orderby' 	=> 'name',
			'order' 	=> 'ASC'
		);

		$categories 	= get_categories($args);
		$cate_array 	= array();
		$arrayCateAll 	= array( 'all' => esc_html__( 'All categories', 'aovis' ) );

		if ($categories) {
		 	foreach ( $categories as $cate ) {
				$cate_array[$cate->slug] = $cate->cat_name;
		  }
		} else {
		  	$cate_array[ esc_html__( 'No content Category found', 'aovis' ) ] = 0;
		}

		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'aovis' ),
			]
		);	
			
			
			$this->add_control(
				'total_count',
				[
					'label' 	=> esc_html__( 'Post Total', 'aovis' ),
					'type' 		=> \Elementor\Controls_Manager::NUMBER,
					'default' 	=> 3,
				]
			);

			$this->add_control(
			  	'category',
			  	[
				  	'label' 	=> esc_html__( 'Category', 'aovis' ),
				  	'type' 		=> Controls_Manager::SELECT,
				  	'default' 	=> 'all',
				  	'options' 	=> array_merge($arrayCateAll,$cate_array),
			  	]
			);

			$this->add_control(
				'order_by',
				[
					'label' 	=> esc_html__('Order By', 'aovis'),
					'type' 		=> \Elementor\Controls_Manager::SELECT,
					'default' 	=> 'ID',
					'options' 	=> [
						'none' 		=> esc_html__('None', 'aovis'),
						'ID' 		=> esc_html__('ID', 'aovis'),
						'title' 	=> esc_html__('Title', 'aovis'),
						'date' 		=> esc_html__('Date', 'aovis'),
						'modified' 	=> esc_html__('Modified', 'aovis'),
						'rand' 		=> esc_html__('Rand', 'aovis'),
					]
				]
			);

			$this->add_control(
				'order',
				[
					'label' 	=> esc_html__('Order', 'aovis'),
					'type' 		=> \Elementor\Controls_Manager::SELECT,
					'default' 	=> 'desc',
					'options' 	=> [
						'asc' => esc_html__('Ascending', 'aovis'),
						'desc' => esc_html__('Descending', 'aovis'),
					]
				]
			);

		$this->end_controls_section();

		//SECTION TAB STYLE GENERAL
		$this->start_controls_section(
			'section_general_style',
			[
				'label' => esc_html__( 'General', 'aovis' ),
				'tab' 	=> \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
			$this->add_responsive_control(
				'item_gap',
				[
					'label' 	=> esc_html__( 'Column Gap', 'aovis' ),
					'type' 		=> \Elementor\Controls_Manager::SLIDER,
					'range' 	=> [
						'px' 	=> [
							'min' => 0,
							'max' => 50,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .ova-latest-posts .item' => 'gap: {{SIZE}}{{UNIT}}',
					],
				]
			);

			$this->add_responsive_control(
				'margin_item',
				[
					'label' 		=> esc_html__( 'Margin', 'aovis' ),
					'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px', 'em', '%' ],
					'selectors' 	=> [
						'{{WRAPPER}} .ova-latest-posts .item ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->start_controls_tabs(
				'general_tabs'
			);

			$this->start_controls_tab(
				'general_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'aovis' ),
				]
			);

				$this->add_group_control(
					\Elementor\Group_Control_Background::get_type(),
					[
						'name' => 'general_background',
						'types' => [ 'classic', 'gradient'],
						'selector' => '{{WRAPPER}} .ova-latest-posts .item',
					]
				);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'general_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'aovis' ),
				]
			);

				$this->add_group_control(
					\Elementor\Group_Control_Background::get_type(),
					[
						'name' => 'general_background_hover',
						'types' => [ 'classic', 'gradient'],
						'selector' => '{{WRAPPER}} .ova-latest-posts .item:hover',
					]
				);

			$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'general_box_shadow',
					'selector' => '{{WRAPPER}} .ova-latest-posts .item',
				]
			);

		$this->end_controls_section();
		// END SECTION TAB STYLE General

		//  Image
		$this->start_controls_section(
			'section_image',
			[
				'label' => esc_html__( 'Image', 'aovis' ),
				'tab' 	=> \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
 			$this->add_responsive_control(
				'img_width',
				[
					'label' 		=> esc_html__( 'Width', 'aovis' ),
					'type' 			=> \Elementor\Controls_Manager::SLIDER,
					'size_units' 	=> [ 'px' ],
					'range' => [
						'px' => [
							'min' 	=> 0,
							'max' 	=> 80,
							'step' 	=> 1,
						]
					],
					'selectors' 	=> [
						'{{WRAPPER}} .ova-latest-posts .item .media a img' => 'width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'img_height',
				[
					'label' 		=> esc_html__( 'Height', 'aovis' ),
					'type' 			=> \Elementor\Controls_Manager::SLIDER,
					'size_units' 	=> [ 'px' ],
					'range' => [
						'px' => [
							'min' 	=> 0,
							'max' 	=> 80,
							'step' 	=> 1,
						]
					],
					'selectors' 	=> [
						'{{WRAPPER}} .ova-latest-posts .item .media a img' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);

 		$this->end_controls_section();
		// END SECTION TAB STYLE Image
		 
		// META
		$this->start_controls_section(
			'section_meta',
			[
				'label' => esc_html__( 'Meta', 'aovis' ),
				'tab' 	=> \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' 		=> 'meta_typography',
					'selector' 	=> '{{WRAPPER}} .ova-latest-posts .item .info .item-meta',
				]
			);

			$this->add_control(
				'meta_color',
				[
					'label' 	=> esc_html__( 'Color', 'aovis' ),
					'type' 		=> \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-latest-posts .item .info .item-meta .right a' => 'color : {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'icon__color',
				[
					'label' 	=> esc_html__( 'Icon Color', 'aovis' ),
					'type' 		=> \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-latest-posts .item .info .item-meta .left i' => 'color : {{VALUE}};',
					],
				]
			);

			$this->add_responsive_control(
				'margin_meta',
				[
					'label' 	=> esc_html__( 'Margin', 'aovis' ),
					'type' 		=> \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .ova-latest-posts .item .info .item-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

		$this->end_controls_section();
		// END SECTION TAB STYLE META
		 
		//SECTION TAB STYLE TITLE
		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Title', 'aovis' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' 		=> 'title_typography',
					'selector' 	=> '{{WRAPPER}} .ova-latest-posts .item .info .post-title',
				]
			);

			$this->add_control(
				'color_title',
				[
					'label' 	=> esc_html__( 'Color', 'aovis' ),
					'type' 		=> \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-latest-posts .item .info .post-title a' => 'color : {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'color_title_hover',
				[
					'label' 	=> esc_html__( 'Color Hover', 'aovis' ),
					'type' 		=> \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ova-latest-posts .item:hover .info .post-title a' => 'color : {{VALUE}};',
					],
				]
			);

			$this->add_responsive_control(
				'margin_title',
				[
					'label' 	=> esc_html__( 'Margin', 'aovis' ),
					'type' 		=> \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .ova-latest-posts .item .info .post-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);


		$this->end_controls_section();
		// END SECTION TAB STYLE TITLE
		
		
	}

	// Render Template Here
	protected function render() {

		$settings 		= 	$this->get_settings();

		$category 		= 	$settings['category'];
		$total_count 	= 	$settings['total_count'];
		$order 			= 	$settings['order'];
		$order_by 		= 	$settings['order_by'];

		$args 	= [];
		$postid = get_the_ID(); 

		if ($category == 'all') {
		  	$args = [
			  	'post_type' 		=> 'post',
			  	'post_status' 		=> 'publish',
			  	'posts_per_page' 	=> $total_count,
			  	'order' 			=> $order,
	  		    'orderby' 			=> $order_by,
	  		    'post__not_in' 		=> array( $postid ),
	  		    'fields'			=> 'ids'
		  	];
		} else {
		  	$args = [
			  	'post_type' 		=> 'post', 
			  	'post_status' 		=> 'publish',
			  	'category_name'		=>	$category,
			  	'posts_per_page' 	=> 	$total_count,
			  	'order' 			=> 	$order,
	  		    'orderby' 			=>  $order_by,
	  		    'post__not_in' 		=>  array( $postid ),
			  	'fields'			=> 	'ids'
		  	];
		}

		$query = new WP_Query( $args );

		?>

		<div class="ova-latest-posts">

			<?php if($query->have_posts()) : while($query->have_posts()) : $query->the_post(); ?>

				<div class="item">
					<div class="media">
			        	<?php 
			        		$thumbnail = wp_get_attachment_image_url(get_post_thumbnail_id() , 'thumbnail' );
			        		$url_thumb = $thumbnail ? $thumbnail : \Elementor\Utils::get_placeholder_image_src();

			        	?>
			        	<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
			        		<img src="<?php echo esc_url( $url_thumb ) ?>" alt="<?php the_title(); ?>">
			        	</a>
			        </div>

			        <div class="info">
						<div class="item-meta">
							  	<span class="left">
								  	<i class="fas fa-comments"></i>
							  	</span>
							  	<span class="right">
								  	<?php
								  		comments_popup_link(
									  	esc_html__('0', 'aovis'), 
									  	esc_html__('1', 'aovis'), 
									  	'%',
									  	'',
									  	esc_html__( 'Comment off', 'aovis' ) )
								  	; ?> 
							  	</span> 
							  	<span class="text-comment">
							  		<?php echo esc_html__( 'Comments', 'aovis' ); ?>	
							  	</span>           
						  </div>

			            <h4 class="post-title">
					        <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
					          <?php the_title(); ?>
					        </a>
					    </h4>

			        </div>
				</div>

			<?php endwhile; endif; wp_reset_postdata(); ?>
		</div>
		 	
		<?php
	}

	
}
$widgets_manager->register( new Aovis_Elementor_Latest_Posts() );