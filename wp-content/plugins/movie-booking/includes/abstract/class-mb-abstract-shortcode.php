<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MB_Shortcode' ) ) {

	abstract class MB_Shortcode {

		protected $shortcode = null;

		function __construct() {
			add_shortcode( $this->shortcode, array( $this, 'add_shortcode' ) );
		}

		function add_shortcode( $atts, $content = null ) {}
	}
}