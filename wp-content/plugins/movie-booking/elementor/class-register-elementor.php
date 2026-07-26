<?php

namespace mb_elementor;

use mb_elementor\widgets\movie_list;
use mb_elementor\widgets\movie_slider;
use mb_elementor\widgets\movie_main_slider;
use mb_elementor\widgets\movie_filter_ajax;
use mb_elementor\widgets\movie_cast_list;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/**
 * Main Plugin Class
 *
 * Register new elementor widget.
 *
 * @since 1.0.0
 */
class MB_Register_Elementor {

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() {
		$this->add_actions();
	}

	/**
	 * Add Actions
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function add_actions() {

	     // Register Ovatheme Category in Pane
	    add_action( 'elementor/elements/categories_registered', array( $this, 'add_ovatheme_category' ) );
		
		add_action( 'elementor/widgets/register', [ $this, 'on_widgets_registered' ] );

	}

	
	public function add_ovatheme_category(  ) {

	    \Elementor\Plugin::instance()->elements_manager->add_category(
	        'moviebooking',
	        [
	            'title' => esc_html__( 'Ovatheme Movie Booking', 'moviebooking' ),
	            'icon' => 'fa fa-plug',
	        ]
	    );

	}


	/**
	 * On Widgets Registered
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function on_widgets_registered() {
		$this->includes();
		$this->register_widget();
	}

	/**
	 * Includes
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function includes() {

		require MB_PLUGIN_PATH . 'elementor/widgets/movie_list.php';
		require MB_PLUGIN_PATH . 'elementor/widgets/movie_slider.php';
		require MB_PLUGIN_PATH . 'elementor/widgets/movie_main_slider.php';
		require MB_PLUGIN_PATH . 'elementor/widgets/movie_filter_ajax.php';
		require MB_PLUGIN_PATH . 'elementor/widgets/movie_cast_list.php';

	}

	/**
	 * Register Widget
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function register_widget() {

		\Elementor\Plugin::instance()->widgets_manager->register( new movie_list() );
		\Elementor\Plugin::instance()->widgets_manager->register( new movie_slider() );
		\Elementor\Plugin::instance()->widgets_manager->register( new movie_main_slider() );
		\Elementor\Plugin::instance()->widgets_manager->register( new movie_filter_ajax() );
		\Elementor\Plugin::instance()->widgets_manager->register( new movie_cast_list() );

	}
	    
	

}

new MB_Register_Elementor();