<?php

namespace ova_ovaev_elementor;

use ova_ovaev_elementor\widgets\ova_events;
use ova_ovaev_elementor\widgets\ova_events_simple_calendar;
use ova_ovaev_elementor\widgets\ova_events_calendar;
use ova_ovaev_elementor\widgets\ova_events_slide;
use ova_ovaev_elementor\widgets\ova_events_ajax;
use ova_ovaev_elementor\widgets\ova_events_search_ajax;
use ova_ovaev_elementor\widgets\ova_event_thumbnail;
use ova_ovaev_elementor\widgets\ova_event_title;
use ova_ovaev_elementor\widgets\ova_event_date;
use ova_ovaev_elementor\widgets\ova_event_time;
use ova_ovaev_elementor\widgets\ova_event_location;
use ova_ovaev_elementor\widgets\ova_event_categories;
use ova_ovaev_elementor\widgets\ova_event_content;
use ova_ovaev_elementor\widgets\ova_event_tabs;
use ova_ovaev_elementor\widgets\ova_event_tags;
use ova_ovaev_elementor\widgets\ova_event_share;
use ova_ovaev_elementor\widgets\ova_event_navigation;
use ova_ovaev_elementor\widgets\ova_event_related;
use ova_ovaev_elementor\widgets\ova_event_sidebar;
use ova_ovaev_elementor\widgets\ova_event_button;
use ova_ovaev_elementor\widgets\ova_event_info;
use ova_ovaev_elementor\widgets\ova_event_meta;
use ova_ovaev_elementor\widgets\ova_event_gallery;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Main Plugin Class
 *
 * Register new elementor widget.
 *
 * @since 1.0.0
 */
class Ova_Event_Register_Elementor {

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
	        'ovatheme',
	        [
	            'title' => esc_html__( 'Ovatheme Event', 'ovaev' ),
	            'icon' => 'fa fa-plug',
	        ]
	    );

	    \Elementor\Plugin::instance()->elements_manager->add_category(
	        'ovaev_template',
	        [
	            'title' => esc_html__( 'Event Template', 'ovaev' ),
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
		
		require OVAEV_PLUGIN_PATH . 'elementor/widgets/ovaev-events.php';
		require OVAEV_PLUGIN_PATH . 'elementor/widgets/ovaev-events-simple-calendar.php';
		require OVAEV_PLUGIN_PATH . 'elementor/widgets/ovaev-events-calendar.php';
		require OVAEV_PLUGIN_PATH . 'elementor/widgets/ovaev-events-slide.php';
		require OVAEV_PLUGIN_PATH . 'elementor/widgets/ovaev-events-ajax.php';
		require OVAEV_PLUGIN_PATH . 'elementor/widgets/ovaev-events-search-ajax.php';
		require OVAEV_PLUGIN_PATH . 'elementor/widgets/ovaev-event-thumbnail.php';
		require OVAEV_PLUGIN_PATH . 'elementor/widgets/ovaev-event-title.php';
		require OVAEV_PLUGIN_PATH . 'elementor/widgets/ovaev-event-date.php';
		require OVAEV_PLUGIN_PATH . 'elementor/widgets/ovaev-event-time.php';
		require OVAEV_PLUGIN_PATH . 'elementor/widgets/ovaev-event-location.php';
		require OVAEV_PLUGIN_PATH . 'elementor/widgets/ovaev-event-categories.php';
		require OVAEV_PLUGIN_PATH . 'elementor/widgets/ovaev-event-content.php';
		require OVAEV_PLUGIN_PATH . 'elementor/widgets/ovaev-event-tabs.php';
		require OVAEV_PLUGIN_PATH . 'elementor/widgets/ovaev-event-tags.php';
		require OVAEV_PLUGIN_PATH . 'elementor/widgets/ovaev-event-share.php';
		require OVAEV_PLUGIN_PATH . 'elementor/widgets/ovaev-event-navigation.php';
		require OVAEV_PLUGIN_PATH . 'elementor/widgets/ovaev-event-related.php';
		require OVAEV_PLUGIN_PATH . 'elementor/widgets/ovaev-event-sidebar.php';
		require OVAEV_PLUGIN_PATH . 'elementor/widgets/ovaev-event-button.php';
		require OVAEV_PLUGIN_PATH . 'elementor/widgets/ovaev-event-info.php';
		require OVAEV_PLUGIN_PATH . 'elementor/widgets/ovaev-event-meta.php';
		require OVAEV_PLUGIN_PATH . 'elementor/widgets/ovaev-event-gallery.php';
		
	}

	/**
	 * Register Widget
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function register_widget() {

		\Elementor\Plugin::instance()->widgets_manager->register( new ova_events() );
		\Elementor\Plugin::instance()->widgets_manager->register( new ova_events_simple_calendar() );
		\Elementor\Plugin::instance()->widgets_manager->register( new ova_events_calendar() );
		\Elementor\Plugin::instance()->widgets_manager->register( new ova_events_slide() );
		\Elementor\Plugin::instance()->widgets_manager->register( new ova_events_ajax() );
		\Elementor\Plugin::instance()->widgets_manager->register( new ova_events_search_ajax() );
		\Elementor\Plugin::instance()->widgets_manager->register( new ova_event_thumbnail() );
		\Elementor\Plugin::instance()->widgets_manager->register( new ova_event_title() );
		\Elementor\Plugin::instance()->widgets_manager->register( new ova_event_date() );
		\Elementor\Plugin::instance()->widgets_manager->register( new ova_event_time() );
		\Elementor\Plugin::instance()->widgets_manager->register( new ova_event_location() );
		\Elementor\Plugin::instance()->widgets_manager->register( new ova_event_categories() );
		\Elementor\Plugin::instance()->widgets_manager->register( new ova_event_content() );
		\Elementor\Plugin::instance()->widgets_manager->register( new ova_event_tabs() );
		\Elementor\Plugin::instance()->widgets_manager->register( new ova_event_tags() );
		\Elementor\Plugin::instance()->widgets_manager->register( new ova_event_share() );
		\Elementor\Plugin::instance()->widgets_manager->register( new ova_event_navigation() );
		\Elementor\Plugin::instance()->widgets_manager->register( new ova_event_related() );
		\Elementor\Plugin::instance()->widgets_manager->register( new ova_event_sidebar() );
		\Elementor\Plugin::instance()->widgets_manager->register( new ova_event_button() );
		\Elementor\Plugin::instance()->widgets_manager->register( new ova_event_info() );
		\Elementor\Plugin::instance()->widgets_manager->register( new ova_event_meta() );
		\Elementor\Plugin::instance()->widgets_manager->register( new ova_event_gallery() );

	}
	    
	

}

new Ova_Event_Register_Elementor();