<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MB_Movie_Register' ) ) {
	class MB_Movie_Register {

		public function __construct() {
			// Init
	        add_action( 'init', array( $this, 'MB_Movie_register_post_types' ) );
	        add_action( 'init', array( $this, 'MB_Movie_register_taxonomies' ) );
            
            // add image for movie cast taxonomy
	        add_action('movie_cast_add_form_fields', array( $this, 'add_movie_cast_image' ) );
	        add_action('movie_cast_edit_form_fields', array( $this, 'edit_movie_cast_image' ), 10);
	        add_action('created_term', array( $this, 'save_movie_cast_image' ), 10, 3);
	        add_action('edited_term', array( $this, 'save_movie_cast_image' ), 10, 3);

	        // Columns in admin
            add_filter( 'manage_movie_posts_columns', array( $this, 'MB_Movie_add_columns_for_movie' ) );
	    }

	    public function MB_Movie_register_post_types() {
	    	$supports   = array( 'author', 'title', 'editor', 'comments', 'excerpt', 'thumbnail'  );
			$taxonomies = array( 'movie_cat', 'movie_tag' );

			$args_movie = array(
				'labels' => array(
					'name'                  => _x( 'Movies', 'post general name', 'moviebooking' ),
					'singular_name'         => _x( 'Movie', 'post singular name', 'moviebooking' ),
					'menu_name'             => _x( 'Movies', 'Admin menu name', 'moviebooking' ),
					'all_items'             => esc_html__( 'All Movies', 'moviebooking' ),
					'add_new'               => esc_html__( 'Add New', 'moviebooking' ),
					'add_new_item'          => esc_html__( 'Add New', 'moviebooking' ),
					'edit'                  => esc_html__( 'Edit', 'moviebooking' ),
					'edit_item'             => esc_html__( 'Edit movie', 'moviebooking' ),
					'new_item'              => esc_html__( 'New movie', 'moviebooking' ),
					'view_item'             => esc_html__( 'View movie', 'moviebooking' ),
					'view_items'            => esc_html__( 'View movies', 'moviebooking' ),
					'search_items'          => esc_html__( 'Search movies', 'moviebooking' ),
					'not_found'             => esc_html__( 'No movies found', 'moviebooking' ),
					'not_found_in_trash'    => esc_html__( 'No movies found in trash', 'moviebooking' ),
					'parent'                => esc_html__( 'Parent movies', 'moviebooking' ),
					'featured_image'        => esc_html__( 'Movie image', 'moviebooking' ),
					'set_featured_image'    => esc_html__( 'Set movie image', 'moviebooking' ),
					'remove_featured_image' => esc_html__( 'Remove movie image', 'moviebooking' ),
					'use_featured_image'    => esc_html__( 'Use as movie image', 'moviebooking' ),
					'insert_into_item'      => esc_html__( 'Insert into movie', 'moviebooking' ),
					'uploaded_to_this_item' => esc_html__( 'Uploaded to this movie', 'moviebooking' ),
					'filter_items_list'     => esc_html__( 'Filter movies', 'moviebooking' ),
					'items_list_navigation' => esc_html__( 'Movies navigation', 'moviebooking' ),
					'items_list'            => esc_html__( 'Movies list', 'moviebooking' ),
				),
				
				'public'             => true,
				'query_var'          => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'has_archive'        => true,
				'capability_type'    => 'post',
				'map_meta_cap'       => true,
				'show_in_menu'       => true,	
				'show_in_nav_menus'  => true,
				'show_in_admin_bar'  => true,
				'taxonomies'         => $taxonomies,
				'supports'           => $supports,
				'hierarchical'       => false,
				'rewrite'            => array(
					'slug'       => _x('movie','Movie Slug', 'moviebooking'),
					'with_front' => false,
					'feeds'      => true,
				),
				'show_in_rest'       => true,
				'menu_position'      => 5,
				'menu_icon'          => 'dashicons-video-alt'
			);

			$args = apply_filters( 'mb_ft_register_post_type_movie', $args_movie );
			register_post_type( 'movie', $args );
	    }

	    public function MB_Movie_register_taxonomies() {
	    	$labels = array(
				'name'              => _x( 'Movie Categories', 'taxonomy general name', 'moviebooking' ),
				'singular_name'     => _x( 'Category', 'taxonomy singular name', 'moviebooking' ),
				'menu_name'         => _x( 'Categories', 'Admin menu name', 'moviebooking' ),
				'search_items'      => esc_html__( 'Search Category', 'moviebooking' ),
				'all_items'         => esc_html__( 'All Categories', 'moviebooking' ),
				'parent_item'       => esc_html__( 'Parent Category', 'moviebooking' ),
				'parent_item_colon' => esc_html__( 'Parent Category:', 'moviebooking' ),
				'edit_item'         => esc_html__( 'Edit Category', 'moviebooking' ),
				'update_item'       => esc_html__( 'Update Category', 'moviebooking' ),
				'add_new_item'      => esc_html__( 'Add New', 'moviebooking' ),
				'new_item_name'     => esc_html__( 'New Category', 'moviebooking' ),
			);

			$args = array(
				'hierarchical'       => true,
				'label'              => esc_html__( 'Categories', 'moviebooking' ),
				'labels'             => $labels,
				'public'             => true,
				'show_ui'            => true,
				'show_admin_column'  => true,
				'show_in_nav_menus'  => true,
				'publicly_queryable' => true,
				'query_var'          => true,
				'show_in_rest'       => true,
				'rewrite'            => array(
					'slug'       => _x( 'movie_cat','Movies Category Slug', 'moviebooking' ),
					'with_front' => false,
					'feeds'      => true,
				),
				
			);

			$args = apply_filters( 'mb_ft_register_taxonomy_movie_cat', $args );
			register_taxonomy( 'movie_cat', array( 'movie' ), $args );

            // Tags
			$labels = array(
				'name'              => _x( 'Tags', 'taxonomy general name', 'moviebooking' ),
				'singular_name'     => _x( 'Tag', 'taxonomy singular name', 'moviebooking' ),
				'menu_name'         => _x( 'Tags', 'Admin menu name', 'moviebooking' ),
				'search_items'      => esc_html__( 'Search Tag', 'moviebooking' ),
				'all_items'         => esc_html__( 'All Tags', 'moviebooking' ),
				'parent_item'       => esc_html__( 'Parent Tag', 'moviebooking' ),
				'parent_item_colon' => esc_html__( 'Parent Tag:', 'moviebooking' ),
				'edit_item'         => esc_html__( 'Edit Tag', 'moviebooking' ),
				'update_item'       => esc_html__( 'Update Tag', 'moviebooking' ),
				'add_new_item'      => esc_html__( 'Add New', 'moviebooking' ),
				'new_item_name'     => esc_html__( 'New Tag', 'moviebooking' ),
			);

			$args = array(
				'public'            => true,
				'label'             => esc_html__( 'Tags', 'moviebooking' ),
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'capabilities'      => array ( 'post' ),
				'show_in_rest'      => true,
				'rewrite'           => array(
					'slug'       => _x( 'movie_tag','Movie Tag Slug', 'moviebooking' ),
					'with_front' => false,
					'feeds'      => true,
				),
			);

			$args = apply_filters( 'mb_ft_register_taxonomy_movie_tag', $args );
			register_taxonomy( 'movie_tag', array( 'movie' ), $args );
            
            // Cast
			$labels = array(
				'name'              => _x( 'Cast', 'taxonomy general name', 'moviebooking' ),
				'singular_name'     => _x( 'Cast', 'taxonomy singular name', 'moviebooking' ),
				'menu_name'         => _x( 'Cast', 'Admin menu name', 'moviebooking' ),
				'search_items'      => esc_html__( 'Search Cast', 'moviebooking' ),
				'all_items'         => esc_html__( 'All Cast', 'moviebooking' ),
				'parent_item'       => esc_html__( 'Parent Cast', 'moviebooking' ),
				'parent_item_colon' => esc_html__( 'Parent Cast:', 'moviebooking' ),
				'edit_item'         => esc_html__( 'Edit Cast', 'moviebooking' ),
				'update_item'       => esc_html__( 'Update Cast', 'moviebooking' ),
				'add_new_item'      => esc_html__( 'Add New', 'moviebooking' ),
				'new_item_name'     => esc_html__( 'New Cast', 'moviebooking' ),
				'not_found'     	=> esc_html__( 'No Cast found.', 'moviebooking' ),
			);

			$args = array(
				'hierarchical'       	=> false,
				'label'              	=> esc_html__( 'Cast', 'moviebooking' ),
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
					'slug'       => _x( 'movie_cast','Movie Cast Slug', 'moviebooking' ),
					'with_front' => false,
					'feeds'      => true,
				),
				
			);

			$args = apply_filters( 'mb_ft_register_taxonomy_movie_cast', $args );
			register_taxonomy( 'movie_cast', array( 'movie' ), $args );
	    }

		public function add_movie_cast_image(){
		    ?>
		    <div class="form-field term-thumbnail-wrap">
				<label><?php esc_html_e( 'Thumbnail', 'moviebooking' ); ?></label>
				<div id="movie_cast_thumbnail" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( \Elementor\Utils::get_placeholder_image_src() ); ?>" width="60px" height="60px" /></div>
				<div style="line-height: 60px;">
					<input type="hidden" id="movie_cast_thumbnail_id" name="movie_cast_thumbnail_id" />
					<button type="button" class="upload_image_button button"><?php esc_html_e( 'Upload/Add image', 'moviebooking' ); ?></button>
					<button type="button" class="remove_image_button button"><?php esc_html_e( 'Remove image', 'moviebooking' ); ?></button>
				</div>
				<script type="text/javascript">
					// Only show the "remove image" button when needed
					if ( ! jQuery( '#movie_cast_thumbnail_id' ).val() ) {
						jQuery( '.remove_image_button' ).hide();
					}

					// Uploading files
					var file_frame;

					jQuery( document ).on( 'click', '.upload_image_button', function( event ) {

						event.preventDefault();

						// If the media frame already exists, reopen it.
						if ( file_frame ) {
							file_frame.open();
							return;
						}

						// Create the media frame.
						file_frame = wp.media.frames.downloadable_file = wp.media({
							title: '<?php esc_html_e( 'Choose an image', 'moviebooking' ); ?>',
							button: {
								text: '<?php esc_html_e( 'Use image', 'moviebooking' ); ?>'
							},
							multiple: false
						});

						// When an image is selected, run a callback.
						file_frame.on( 'select', function() {
							var attachment           = file_frame.state().get( 'selection' ).first().toJSON();
							var attachment_thumbnail = attachment.sizes.thumbnail || attachment.sizes.full;

							jQuery( '#movie_cast_thumbnail_id' ).val( attachment.id );
							jQuery( '#movie_cast_thumbnail' ).find( 'img' ).attr( 'src', attachment_thumbnail.url );
							jQuery( '.remove_image_button' ).show();
						});

						// Finally, open the modal.
						file_frame.open();
					});

					jQuery( document ).on( 'click', '.remove_image_button', function() {
						jQuery( '#movie_cast_thumbnail' ).find( 'img' ).attr( 'src', '<?php echo esc_js( \Elementor\Utils::get_placeholder_image_src() ); ?>' );
						jQuery( '#movie_cast_thumbnail_id' ).val( '' );
						jQuery( '.remove_image_button' ).hide();
						return false;
					});

					jQuery( document ).ajaxComplete( function( event, request, options ) {
						if ( request && 4 === request.readyState && 200 === request.status
							&& options.data && 0 <= options.data.indexOf( 'action=add-tag' ) ) {

							var res = wpAjax.parseAjaxResponse( request.responseXML, 'ajax-response' );
							if ( ! res || res.errors ) {
								return;
							}
							// Clear Thumbnail fields on submit
							jQuery( '#movie_cast_thumbnail' ).find( 'img' ).attr( 'src', '<?php echo esc_js( \Elementor\Utils::get_placeholder_image_src() ); ?>' );
							jQuery( '#movie_cast_thumbnail_id' ).val( '' );
							jQuery( '.remove_image_button' ).hide();
							// Clear Display type field on submit
							jQuery( '#display_type' ).val( '' );
							return;
						}
					} );
				</script>
				<div class="clear"></div>
			</div>
		    <?php
		}

		public function edit_movie_cast_image($term) {
		    $thumbnail_id = absint( get_term_meta( $term->term_id, 'thumbnail_id', true ) );

			if ( $thumbnail_id ) {
				$image = wp_get_attachment_thumb_url( $thumbnail_id );
			} else {
				$image = \Elementor\Utils::get_placeholder_image_src();
			}
		?>
		    <tr class="form-field term-thumbnail-wrap">
				<th scope="row" valign="top"><label><?php esc_html_e( 'Thumbnail', 'moviebooking' ); ?></label></th>
				<td>
					<div id="movie_cast_thumbnail" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( $image ); ?>" width="60px" height="60px" /></div>
					<div style="line-height: 60px;">
						<input type="hidden" id="movie_cast_thumbnail_id" name="movie_cast_thumbnail_id" value="<?php echo esc_attr( $thumbnail_id ); ?>" />
						<button type="button" class="upload_image_button button"><?php esc_html_e( 'Upload/Add image', 'moviebooking' ); ?></button>
						<button type="button" class="remove_image_button button"><?php esc_html_e( 'Remove image', 'moviebooking' ); ?></button>
					</div>
					<script type="text/javascript">
						// Only show the "remove image" button when needed
						if ( '0' === jQuery( '#movie_cast_thumbnail_id' ).val() ) {
							jQuery( '.remove_image_button' ).hide();
						}

						// Uploading files
						var file_frame;

						jQuery( document ).on( 'click', '.upload_image_button', function( event ) {

							event.preventDefault();

							// If the media frame already exists, reopen it.
							if ( file_frame ) {
								file_frame.open();
								return;
							}

							// Create the media frame.
							file_frame = wp.media.frames.downloadable_file = wp.media({
								title: '<?php esc_html_e( 'Choose an image', 'moviebooking' ); ?>',
								button: {
									text: '<?php esc_html_e( 'Use image', 'moviebooking' ); ?>'
								},
								multiple: false
							});

							// When an image is selected, run a callback.
							file_frame.on( 'select', function() {
								var attachment           = file_frame.state().get( 'selection' ).first().toJSON();
								var attachment_thumbnail = attachment.sizes.thumbnail || attachment.sizes.full;

								jQuery( '#movie_cast_thumbnail_id' ).val( attachment.id );
								jQuery( '#movie_cast_thumbnail' ).find( 'img' ).attr( 'src', attachment_thumbnail.url );
								jQuery( '.remove_image_button' ).show();
							});

							// Finally, open the modal.
							file_frame.open();
						});

						jQuery( document ).on( 'click', '.remove_image_button', function() {
							jQuery( '#movie_cast_thumbnail' ).find( 'img' ).attr( 'src', '<?php echo esc_js( \Elementor\Utils::get_placeholder_image_src() ); ?>' );
							jQuery( '#movie_cast_thumbnail_id' ).val( '' );
							jQuery( '.remove_image_button' ).hide();
							return false;
						});
					</script>
					<div class="clear"></div>
				</td>
			</tr>
		<?php }

		public function save_movie_cast_image($term_id, $tt_id = '', $taxonomy = '') {
		    if ( isset( $_POST['movie_cast_thumbnail_id'] ) && 'movie_cast' === $taxonomy ) { // WPCS: CSRF ok, input var ok.
				update_term_meta( $term_id, 'thumbnail_id', absint( $_POST['movie_cast_thumbnail_id'] ) ); // WPCS: CSRF ok, input var ok.
			}
		}

	    public function MB_Movie_add_columns_for_movie( $columns ) {
	    	$prefix = MB_PLUGIN_PREFIX_MOVIE;

	    	unset( $columns['author'] );
	    	unset( $columns['comments'] );
	    	unset( $columns['date'] );

            $columns['author'] 		= esc_html__( 'Author', 'moviebooking' );
            $columns['comments'] 	= '<span class="vers comment-grey-bubble" title="'.esc_html__( 'Comments', 'moviebooking' ).'"><span class="screen-reader-text">'.esc_html__( 'Comments', 'moviebooking' ).'</span></span>';
            $columns['date'] 		= esc_html__( 'Date', 'moviebooking' );

            return $columns;
	    }
	}

	return new MB_Movie_Register();
}