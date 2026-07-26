<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MB_Room_Register' ) ) {
	class MB_Room_Register {

		public function __construct() {
			// Init
	        add_action( 'init', array( $this, 'MB_Room_register_post_types' ) );
	        add_action( 'init', array( $this, 'MB_Room_register_taxonomies' ) );

	        // Columns in admin
            add_filter( 'manage_room_posts_columns', array( $this, 'MB_Room_add_columns_for_room' ) );
	        add_filter( 'manage_posts_custom_column', array( $this, 'MB_Room_view_columns_for_room' ), 10, 2 );
	    }

	    public function MB_Room_register_post_types() {
	    	$supports   = array( 'author', 'title'  );
			$taxonomies = array( 'room_type' );

			$args_room = array(
				'labels' => array(
					'name'                  => _x( 'Rooms', 'post general name', 'moviebooking' ),
					'singular_name'         => _x( 'Room', 'post singular name', 'moviebooking' ),
					'menu_name'             => _x( 'Rooms', 'Admin menu name', 'moviebooking' ),
					'all_items'             => esc_html__( 'All Rooms', 'moviebooking' ),
					'add_new'               => esc_html__( 'Add New', 'moviebooking' ),
					'add_new_item'          => esc_html__( 'Add New', 'moviebooking' ),
					'edit'                  => esc_html__( 'Edit', 'moviebooking' ),
					'edit_item'             => esc_html__( 'Edit Room', 'moviebooking' ),
					'new_item'              => esc_html__( 'New Room', 'moviebooking' ),
					'view_item'             => esc_html__( 'View Room', 'moviebooking' ),
					'view_items'            => esc_html__( 'View Room', 'moviebooking' ),
					'search_items'          => esc_html__( 'Search Rooms', 'moviebooking' ),
					'not_found'             => esc_html__( 'No Rooms found', 'moviebooking' ),
					'not_found_in_trash'    => esc_html__( 'No Rooms found in trash', 'moviebooking' ),
					'parent'                => esc_html__( 'Parent Rooms', 'moviebooking' ),
					'featured_image'        => esc_html__( 'Room image', 'moviebooking' ),
					'set_featured_image'    => esc_html__( 'Set Room image', 'moviebooking' ),
					'remove_featured_image' => esc_html__( 'Remove Room image', 'moviebooking' ),
					'use_featured_image'    => esc_html__( 'Use as Room image', 'moviebooking' ),
					'insert_into_item'      => esc_html__( 'Insert into Room', 'moviebooking' ),
					'uploaded_to_this_item' => esc_html__( 'Uploaded to this Room', 'moviebooking' ),
					'filter_items_list'     => esc_html__( 'Filter Rooms', 'moviebooking' ),
					'items_list_navigation' => esc_html__( 'Rooms navigation', 'moviebooking' ),
					'items_list'            => esc_html__( 'Rooms list', 'moviebooking' ),
				),
				
				'public'             => false,
				'query_var'          => true,
				'publicly_queryable' => false,
				'show_ui'            => true,
				'has_archive'        => false,
				'capability_type'    => 'post',
				'map_meta_cap'       => true,
				'show_in_menu'       => true,	
				'show_in_nav_menus'  => false,
				'show_in_admin_bar'  => true,
				'taxonomies'         => $taxonomies,
				'supports'           => $supports,
				'hierarchical'       => false,
				'show_in_rest'       => false,
				'rewrite'            => array(
					'slug'       => _x('room','Rooms Slug', 'moviebooking'),
					'with_front' => false,
					'feeds'      => true,
				),
				'menu_position'      => 5,
				'menu_icon'          => 'dashicons-archive'
			);

			$args = apply_filters( 'mb_ft_register_post_type_room', $args_room );
			register_post_type( 'room', $args );
	    }

	    public function MB_Room_register_taxonomies() {
	    	$labels = array(
				'name'              => _x( 'Types', 'taxonomy general name', 'moviebooking' ),
				'singular_name'     => _x( 'Type', 'taxonomy singular name', 'moviebooking' ),
				'menu_name'         => _x( 'Types', 'Admin menu name', 'moviebooking' ),
				'search_items'      => esc_html__( 'Search Type', 'moviebooking' ),
				'all_items'         => esc_html__( 'All Types', 'moviebooking' ),
				'parent_item'       => esc_html__( 'Parent Type', 'moviebooking' ),
				'parent_item_colon' => esc_html__( 'Parent Type:', 'moviebooking' ),
				'edit_item'         => esc_html__( 'Edit Type', 'moviebooking' ),
				'update_item'       => esc_html__( 'Update Type', 'moviebooking' ),
				'add_new_item'      => esc_html__( 'Add New', 'moviebooking' ),
				'new_item_name'     => esc_html__( 'New Type', 'moviebooking' ),
				'not_found'     	=> esc_html__( 'No Types found.', 'moviebooking' ),
			);

			$args = array(
				'hierarchical'       	=> false,
				'label'              	=> esc_html__( 'Types', 'moviebooking' ),
				'labels'             	=> $labels,
				'public'             	=> false,
				'show_ui'            	=> true,
				'show_admin_column'  	=> true,
				'query_var'          	=> false,
				'show_in_rest'       	=> true,
				'meta_box_cb' 		 	=> false,
				'show_admin_column' 	=> false,
				'show_in_quick_edit' 	=> false,
				'rewrite'            	=> array(
					'slug'       => _x( 'room_type','Room Type Slug', 'moviebooking' ),
					'with_front' => false,
					'feeds'      => true,
				),
				
			);

			$args = apply_filters( 'mb_ft_register_taxonomy_room_type', $args );
			register_taxonomy( 'room_type', array( 'room' ), $args );
	    }

	    public function MB_Room_add_columns_for_room( $columns ) {
	    	$prefix = MB_PLUGIN_PREFIX_ROOM;
	    	
	    	unset( $columns['author'] );
	    	unset( $columns['date'] );

            $columns[$prefix.'type_id'] = esc_html__( 'Type', 'moviebooking' );
            $columns['author']    		= esc_html__( 'Author', 'moviebooking' );
            $columns['date'] 			= esc_html__( 'Date', 'moviebooking' );
     
            return $columns;
	    }

	    public function MB_Room_view_columns_for_room( $column, $post_id ) {
	    	$prefix = MB_PLUGIN_PREFIX_ROOM;

	    	switch ( $column ) {
                case $prefix.'type_id':
                    $type_id 	= get_post_meta( $post_id, $prefix.'type_id', true );
                    $type_name 	= MBC()->mb_get_taxonomy_name( $type_id, 'room_type' );

                    if ( $type_name ) {
                    	$type_link = get_edit_term_link( $type_id, 'room_type' );
                    	echo '<a href="'.esc_url( $type_link ).'" target="_blank">'.esc_html( $type_name ).'</a>';
                    }
                    break;
            }
	    }
	}

	return new MB_Room_Register();
}