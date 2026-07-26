<?php defined( 'ABSPATH' ) || exit;

if( !class_exists( 'ovaev_shortcode_slide_ajax' ) ) {

	class ovaev_shortcode_slide_ajax {

		public $shortcode = 'ovaev_slide_ajax';

		public function __construct() {
			//add shortcode
			add_shortcode( $this->shortcode, array( $this, 'init_shortcode' ) );
		}

		public function get_data_shortcode( $settings ) {
			
			//data post
			$number_post 	= $settings['number_post'];
			$order_post 	= $settings['order_post'];
			$orderby_post 	= $settings['orderby_post'];
			$show_all 		= $settings['show_all'];
			$show_featured 	= $settings['show_featured'];
			$show_filter 	= $settings['show_filter'];
			$exclude_cat 	= $settings['exclude_cat'];
			$text_read_more = $settings['text_read_more'];
	        $show_read_more = $settings['show_read_more'] != '' ? esc_html( $settings['show_read_more'] ) : '';

	        $cat_exclude = array(
				'exclude' => explode(", ",$exclude_cat), 
			);


			$terms 				= get_terms('event_category', $cat_exclude);
			$settings['terms'] 	= $terms;
			$count 				= count($terms);

			$term_id_filter 	= array();
			foreach ( $terms as $term ) {
				$term_id_filter[] = $term->term_id;
			}

			$term_id_filter_string = implode(", ", $term_id_filter);
			$first_term = '';
			if( $terms ){
				$first_term = $terms[0]->term_id;	
			}
			$settings['first_term'] 			= $first_term;
			$settings['term_id_filter_string'] 	= $term_id_filter_string;
			$settings['column'] 				= 1;
			
			$args_base = array(
				'post_type' 		=> 'event',
				'post_status' 		=> 'publish',
				'posts_per_page' 	=> $number_post,
				'order' 			=> $order_post,
				'orderby' 			=> $orderby_post,
			);


			/* Show Featured */
			if ($show_featured == 'yes') {
				$args_featured = array(
					'meta_key' => 'ovaev_special',
					'meta_query'=> array(
						array(
							'key' 		=> 'ovaev_special',
							'compare' 	=> '=',
							'value' 	=> 'checked',
						)
					)
				);
			} else {
				$args_featured = array();
			}

			if ($show_all !== 'yes' && $first_term != '' ) {
				$args_cat = array(
					'tax_query' => array(
						array(
							'taxonomy' => 'event_category',
							'field'    => 'id',
							'terms'    => $first_term,
						)
					)
				);

				$args = array_merge_recursive($args_cat, $args_base, $args_featured);
				$event_posts = new \WP_Query( $args );

			} else {
				$args_cat = array(
					'tax_query' => array(
						array(
							'taxonomy' => 'event_category',
							'field'    => 'id',
							'terms'    => $term_id_filter,
						)
					)
				);

				$args = array_merge_recursive($args_cat, $args_base, $args_featured);
				$event_posts = new \WP_Query( $args );
			}

			//data carousel
			$data_carousel = [
				'items'           => isset( $settings['item_number'] ) ? (int)$settings['item_number'] : 3,
				'margin'          => isset( $settings['margin_items'] ) ? (int)$settings['margin_items'] : 30,
				'dots'            => false,
				'nav'             => isset( $settings['nav_control'] ) === 'yes' ? true : false,
				'autoplay'        => isset( $settings['autoplay'] ) === 'yes' ? true : false,
				'autoplay_speed'  => isset( $settings['speed'] ) ? (int)$settings['speed'] : 3000,
				'smartspeed' 	  => isset( $settings['smart_speed'] ) ? (int)$settings['smart_speed'] : 500,
				'autoplayTimeout' => isset( $settings['autoplay_speed'] ) ? $settings['autoplay_speed'] : 'no',
				'loop'            => isset( $settings['infinite'] ) === 'yes' ? true : false,
				'lazyLoad'        => isset( $settings['owl_lazyload'] ) === 'yes' ? true : false,
				'mouseDrag'       => isset( $my_posts->found_posts ) == 1 ? false : true,
				'dot_control' 	  => isset( $settings['dot'] ) ? $settings['dot'] : 'no',
				'nav_control' 	  => isset( $settings['nav'] ) ? $settings['nav'] : 'yes',
				'navText' => [
					'<i class="' . isset( $settings['owl_nav_prev'] ) ? $settings['owl_nav_prev'] : 'arrow_carrot-left' . '"></i>',
					'<i class="' . isset( $settings['owl_nav_next'] ) ? $settings['owl_nav_next'] : 'arrow_carrot-right' . '"></i>'
				],
				'responsive' => [
					'0'  => [
						'items'  => 1,
					],
					'768'  => [
						'items'  => 2,
					],
					'1024'  => [
						'items'  => 3,
					]
				]
			];

			$data = [
				'data_posts' 	=> $event_posts,
				'data_carousel' => $data_carousel,
				'settings' 		=> $settings,
			];

			return $data;
		}

		function init_shortcode( $args, $content = null ) {
			
			$content = get_the_content( get_the_ID() );

			//check shortcode
			if ( is_page() && has_shortcode( $content, 'ovaev_slide_ajax') ) {
				// wp_enqueue_script( 'slick-script', OVAEV_PLUGIN_URI.'assets/libs/slick/slick/slick.min.js', 
				// 	array('jquery'), false, true );
				wp_enqueue_style( 'owl-carousel', OVAEV_PLUGIN_URI.'assets/libs/owl-carousel/assets/owl.carousel.min.css' );
				wp_enqueue_script( 'owl-carousel', OVAEV_PLUGIN_URI.'assets/libs/owl-carousel/owl.carousel.min.js', 
					array('jquery'), false, true );
			}

			//check variable shortcode
			if ( !empty($args) ) {
				$attr = [
					//query events
					'number_post' 		=> isset($args['number_post']) ? (int)$args['number_post'] : 8,
					'order_post' 		=> isset($args['order_post']) ? $args['order_post'] : 'desc',
					'orderby_post' 		=> isset($args['orderby_post']) ? $args['orderby_post'] : 'date',
					'show_all' 			=> isset($args['show_all']) ? $args['show_all'] : 'yes',
					'show_featured' 	=> isset($args['show_featured']) ? $args['show_featured'] : 'no',
					'show_filter' 		=> isset($args['show_filter']) ? $args['show_filter'] : 'yes',
					'exclude_cat' 		=> isset($args['exclude_cat']) ? $args['exclude_cat'] : '',
					'text_read_more' 	=> isset($args['text_read_more']) ? $args['text_read_more'] : 'See All Events',
					'show_read_more' 	=> isset($args['show_read_more']) ? $args['show_read_more'] : 'yes',
					'layout' 			=> isset($args['layout']) ? (int)$args['layout'] : 1,

					//carousel
					'item_number' 		=> isset($args['items']) ? (int)$args['items'] : 3,
					'slides_to_scroll' 	=> isset($args['slide_by']) ? (int)$args['slide_by'] : 1,
					'margin_items' 		=> isset($args['margin']) ? (int)$args['margin'] : 20,
					'pause_on_hover' 	=> isset($args['pause_on_hover']) ? $args['pause_on_hover'] : 'yes',
					'infinite' 			=> isset($args['loop']) ? $args['loop'] : 'no',
					'autoplay' 			=> isset($args['autoplay']) ? $args['autoplay'] : 'no',
					'autoplay_speed' 	=> isset($args['speed']) ? (int)$args['speed'] : 3000,
					'smartspeed' 		=> isset($args['smart_speed']) ? (int)$args['smart_speed'] : 500,
					'dot_control' 		=> isset($args['dot']) ? $args['dot'] : 'no',
					'nav_control' 		=> isset($args['nav']) ? $args['nav'] : 'yes',
					'owl_lazyload'		=> isset($args['owl_lazyload']) ? $args['owl_lazyload'] : 'yes',
					'mouse_drag' 		=> isset($args['mouseDrag']) ? $args['mouseDrag'] : 'yes',
					'owl_nav_prev' 		=> isset($args['owl_nav_prev']) ? $args['owl_nav_prev'] : 'arrow_carrot-left',
					'owl_nav_next' 		=> isset($args['owl_nav_next']) ? $args['owl_nav_next'] : 'arrow_carrot-right',

					'category' 			=> isset($args['category']) ? $args['category'] : 'all',
				];
			} else {
				$attr = [
					//query events
					'number_post' 		=> 8,
					'order_post' 		=> 'desc',
					'orderby_post' 		=> 'date',
					'show_all' 			=> 'yes',
					'show_featured' 	=> 'no',
					'show_filter' 		=> 'yes',
					'exclude_cat' 		=> '',
					'text_read_more' 	=> 'See All Events',
					'show_read_more' 	=> 'yes',
					'layout' 			=> 1,

					//carousel
					'item_number' 		=> 3,
					'slides_to_scroll' 	=> 1,
					'margin_items' 		=> 20,
					'pause_on_hover' 	=> 'yes',
					'infinite' 			=> 'no',
					'autoplay' 			=> 'yes',
					'autoplay_speed' 	=> 3000,
					'smartspeed' 		=> 500,
					'dot_control' 		=> 'no',
					'nav_control' 		=> 'yes',
					'mouse_drag' 		=> 'yes',
					'owl_nav_prev' 		=> 'arrow_carrot-left',
					'owl_nav_next' 		=> 'arrow_carrot-right',

					'category' 			=> 'all',
				];
			}
			
			$data = $this->get_data_shortcode($attr);
			
			//get template
			$template = apply_filters( 'shortcode_ovaev_ajax', 'elements/ovaev_events_ajax_content.php' );

			ob_start();
			ovaev_get_template( $template, $data );
			return ob_get_clean();
		}
	}

	new ovaev_shortcode_slide_ajax();
}
