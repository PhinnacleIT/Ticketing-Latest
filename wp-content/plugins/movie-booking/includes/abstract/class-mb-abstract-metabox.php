<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MB_Abstract_Metabox' ) ) {
	abstract class MB_Abstract_Metabox {
		/**
		 * Meta box ID
		 * @var null
		 */
		public $_id = null;

		/**
		 * Prefix for metabox field
		 * @var string
		 */
		protected $_prefix = 'ova_mb_';

		/**
		 * Titlte Meta box
		 */
		protected $_title = null;

		/**
		 * Display in Post Type
		 * @var array, string
		 */
		protected $_screen = array();

		/**
		 * Context
		 * @var string normal, advanced or side
		 */
		protected $_context = 'normal';

		/**
		 * show position High, Low
		 * @var string
		 */
		protected $_priority = 'high';

		/**
		 * Display Layout Meta Box
		 * @var null
		 */
		protected $_output = null;

		public function __construct() {
			if ( ! $this->_id ) return;
			
			add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		}

		public function add_meta_box() {
			foreach ($this->_screen as $post_type) {
				add_meta_box(
					$this->_id,
					$this->_title,
					array( $this, 'output' ),
					$post_type,
					$this->_context,
					$this->_priority
				);
			}
		}

		public function output() {
			// make hide field and security
			wp_nonce_field( 'ova_metaboxes', 'ova_metaboxes' );

			do_action( 'mb_ac_metabox_before_output', $this->_id );

			$this->_output = apply_filters( 'el_metabox_output', $this->_output, $this->_id );
			if ( file_exists( $this->_output ) ) {
				require_once $this->_output;
			}

			do_action( 'mb_ac_metabox_after_output', $this->_id );
		}

		/**
		 * return metabox name
		 * @return prefix_name
		 */
		public function get_mb_name( $name = '' ) {
			return $this->_prefix . $name;
		}

		/**
	     * return metabox value
	     * @return string
	     */
		public function get_mb_value( $name = '', $default = false ) {
			global $post;
			$post_id 	= $post->ID;
			$value 		= get_post_meta( $post_id, $this->_prefix . $name, true );

			if ( ! $value && $default != '' ) {
				$value = $default;
			}

			return $value;
		}
	}
}