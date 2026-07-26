<?php
	if(defined('AOVIS_URL') 	== false) 	define('AOVIS_URL', get_template_directory());
	if(defined('AOVIS_URI') 	== false) 	define('AOVIS_URI', get_template_directory_uri());

	load_theme_textdomain( 'aovis', AOVIS_URL . '/languages' );

	// Main Feature
	require_once( AOVIS_URL.'/inc/class-main.php' );

	// Functions
	require_once( AOVIS_URL.'/inc/functions.php' );

	// Hooks
	require_once( AOVIS_URL.'/inc/class-hook.php' );

	// Widget
	require_once (AOVIS_URL.'/inc/class-widgets.php');
	

	// Elementor
	if (defined('ELEMENTOR_VERSION')) {
		require_once (AOVIS_URL.'/inc/class-elementor.php');
	}
	
	// WooCommerce
	if (class_exists('WooCommerce')) {
		require_once (AOVIS_URL.'/inc/class-woo.php');	
	}
	
	
	/* Customize */
	if( current_user_can('customize') ){
	    require_once AOVIS_URL.'/customize/custom-control/google-font.php';
	    require_once AOVIS_URL.'/customize/custom-control/heading.php';
	    require_once AOVIS_URL.'/inc/class-customize.php';
	}
    
   
	require_once ( AOVIS_URL.'/install-resource/active-plugins.php' );
	

	
	