<?php 

if( !defined( 'ABSPATH' ) ) exit();

if( !class_exists( 'OVAEV_custom_post_type' ) ) {

	class OVAEV_custom_post_type{

		public function __construct(){

			add_action( 'init', array( $this, 'OVAEV_register_post_type_event' ) );


			add_action( 'init', array( $this, 'OVAEV_custom_taxonomy_type' ) );
			add_action( 'init', array( $this, 'OVAEV_custom_taxonomy_tag' ) );

		}

		
		function OVAEV_register_post_type_event() {

			$taxonomies = array( 'event_category', 'event_tag' );

			$labels = array(
				'name'                  => _x( 'Events', 'Post Type General Name', 'ovaev' ),
				'singular_name'         => _x( 'Event', 'Post Type Singular Name', 'ovaev' ),
				'menu_name'             => esc_html__( 'Events', 'ovaev' ),
				'name_admin_bar'        => esc_html__( 'Event', 'ovaev' ),
				'archives'              => esc_html__( 'Item Archives', 'ovaev' ),
				'attributes'            => esc_html__( 'Item Attributes', 'ovaev' ),
				'parent_item_colon'     => esc_html__( 'Parent Item:', 'ovaev' ),
				'all_items'             => esc_html__( 'All Events', 'ovaev' ),
				'add_new_item'          => esc_html__( 'Add New Event', 'ovaev' ),
				'add_new'               => esc_html__( 'Add New Event', 'ovaev' ),
				'new_item'              => esc_html__( 'New Item', 'ovaev' ),
				'edit_item'             => esc_html__( 'Edit Event', 'ovaev' ),
				'view_item'             => esc_html__( 'View Item', 'ovaev' ),
				'view_items'            => esc_html__( 'View Items', 'ovaev' ),
				'search_items'          => esc_html__( 'Search Item', 'ovaev' ),
				'not_found'             => esc_html__( 'Not found', 'ovaev' ),
				'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'ovaev' ),
			);
			$args = array(
				'description'         => esc_html__( 'Post Type Description', 'ovaev' ),
				'labels'              => $labels,
				'supports'            => array( 'author', 'title', 'editor', 'comments', 'excerpt', 'thumbnail' ),
				'taxonomies'         => $taxonomies,
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_rest'        => true, // Show in Rest API
				'show_in_menu'        => 'ovaev-menu',
				'menu_position'       => 20,
				'query_var'           => true,
				'has_archive'         => true,
				'exclude_from_search' => true,
				'publicly_queryable'  => true,
				'rewrite'             => array( 'slug' => _x( 'event', 'URL slug', 'ovaev' ) ),
				'capability_type'     => 'post',
			);
			register_post_type( 'event', $args );
		}
		
		// Register Custom Taxonomy Type
		function OVAEV_custom_taxonomy_type(){

			$labels = array(
				'name'              => _x( 'Event Categories', 'taxonomy general name', 'ovaev' ),
				'singular_name'     => _x( 'Event Category', 'taxonomy singular name', 'ovaev' ),
				'search_items'      => esc_html__( 'Search Event Categorys', 'ovaev' ),
				'all_items'         => esc_html__( 'Categories', 'ovaev' ),
				'parent_item'       => esc_html__( 'Parent Event Category', 'ovaev' ),
				'parent_item_colon' => esc_html__( 'Parent Event Category:', 'ovaev' ),
				'edit_item'         => esc_html__( 'Edit Event Category', 'ovaev' ),
				'update_item'       => esc_html__( 'Update Event Category', 'ovaev' ),
				'add_new_item'      => esc_html__( 'Add New', 'ovaev' ),
				'new_item_name'     => esc_html__( 'New Event Category', 'ovaev' ),
				'menu_name'         => esc_html__( 'Event Category', 'ovaev' )
			);
		
			$args = array(
				'hierarchical'       => true,
				'label'              => esc_html__( 'Event Category', 'ovaev' ),
				'labels'             => $labels,
				'public'             => true,
				'show_ui'            => true,
				'show_admin_column'  => true,
				'show_in_nav_menus'  => true,
				'publicly_queryable' => true,
				'query_var'          => true,
				'show_in_rest'       => true, // Show in Rest API (display in Event Custom Post Type)
				'rewrite'            => array(
					'slug'       => _x('event_category','Event Category Slug', 'ovaev'),
					'with_front' => false,
					'feeds'      => true,
				),	
			);

			$args = apply_filters( 'el_register_tax_event_type', $args );
			register_taxonomy( 'event_category', array( 'event' ), $args );
			
		}	


		// Register Custom Taxonomy Tag
		function OVAEV_custom_taxonomy_tag() {

			$labels = array(
				'name'              => _x( 'Tags', 'taxonomy general name', 'ovaev' ),
				'singular_name'     => _x( 'Tag', 'taxonomy singular name', 'ovaev' ),
				'search_items'      => esc_html__( 'Search Tags', 'ovaev' ),
				'all_items'         => esc_html__( 'All Tags', 'ovaev' ),
				'parent_item'       => esc_html__( 'Parent Tag', 'ovaev' ),
				'parent_item_colon' => esc_html__( 'Parent Tag:', 'ovaev' ),
				'edit_item'         => esc_html__( 'Edit Tag', 'ovaev' ),
				'update_item'       => esc_html__( 'Update Tag', 'ovaev' ),
				'add_new_item'      => esc_html__( 'Add New Tag', 'ovaev' ),
				'new_item_name'     => esc_html__( 'New Tag', 'ovaev' ),
				'menu_name'         => esc_html__( 'Tags', 'ovaev' )
			);

			$args = array(
				'labels'            => $labels,
				'hierarchical'      => true,
				'publicly_queryable' => true,
				'public'            => true,
				'show_ui'           => true,
				'show_in_menu'      => 'ovaev-menu',
				'show_admin_column' => true,
				'show_in_nav_menus' => true,
				'show_tagcloud'     => false,
				'rewrite'            => array(
					'slug'       => _x('event_tag','Event Tag Slug', 'ovaev'),
					'with_front' => false,
					'feeds'      => true,
				),
			);

			$args = apply_filters( 'el_register_tax_event_tag', $args );
			register_taxonomy( 'event_tag', array( 'event' ), $args );
			
		}


	}
	new OVAEV_custom_post_type();
}