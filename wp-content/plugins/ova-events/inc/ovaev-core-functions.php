<?php

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'aovis_header_customize', 'aovis_header_customize_event', 10, 1 );
function aovis_header_customize_event( $header ){

    if( is_tax( 'event_category' ) ||  get_query_var( 'event_category' ) != '' || is_tax( 'event_tag' ) ||  get_query_var( 'event_tag' ) != '' || is_post_type_archive( 'event' ) ){

        $header = OVAEV_Settings::archive_event_header();

    }else if( is_singular( 'event' ) ){

        $header = OVAEV_Settings::single_event_header();
    }

    return $header;

}

add_filter( 'aovis_footer_customize', 'aovis_footer_customize_event', 10, 1 );
function aovis_footer_customize_event( $footer ){
    
    if( is_tax( 'event_category' ) ||  get_query_var( 'event_category' ) != '' || is_tax( 'event_tag' ) ||  get_query_var( 'event_tag' ) != '' || is_post_type_archive( 'event' ) ){

        $footer = OVAEV_Settings::archive_event_footer();

    }else if( is_singular( 'event' ) ){

        $footer = OVAEV_Settings::single_event_footer();
    }

    return $footer;

}

if( !function_exists( 'ovaev_locate_template' ) ){
	function ovaev_locate_template( $template_name, $template_path = '', $default_path = '' ) {
		
		// Set variable to search in ovaev-templates folder of theme.
		if ( ! $template_path ) :
			$template_path = 'ovaev-templates/';
		endif;

		// Set default plugin templates path.
		if ( ! $default_path ) :
			$default_path = OVAEV_PLUGIN_PATH . 'templates/'; // Path to the template folder
		endif;

		// Search template file in theme folder.
		$template = locate_template( array(
			$template_path . $template_name
			// $template_name
		) );

		// Get plugins template file.
		if ( ! $template ) :
			$template = $default_path . $template_name;
		endif;

		return apply_filters( 'ovaev_locate_template', $template, $template_name, $template_path, $default_path );
	}

}


function ovaev_get_template( $template_name, $args = array(), $tempate_path = '', $default_path = '' ) {
	if ( is_array( $args ) && isset( $args ) ) :
		extract( $args );
    endif;
    $template_file = ovaev_locate_template( $template_name, $tempate_path, $default_path );
    if ( ! file_exists( $template_file ) ) :
      _doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $template_file ), '1.0.0' );
      return;
    endif;

    include $template_file;
}



/** in_array() and multidimensional array **/

function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
    	foreach ($item as $value) {
    		if (  $value['date'] === $needle ) {
             return true;
             break;
         }
     }

 }

 return false;
}

add_action( 'widgets_init', 'ovaev_event_sidebar' );
function ovaev_event_sidebar() {
  $args = array(
    'name'          => esc_html__( 'Event Sidebar', 'ovaev' ),
    'id'            => 'event-sidebar',
    'description'   => esc_html__( 'Display in event sidebar', 'ovaev' ),
    'class'         => '',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h4 class="widget-title">',
    'after_title'   => '</h4>' 
);

  register_sidebar( $args );

}

function ovaev_get_category_event_by_id( $id = '' ){

    if( $id === '' ) return;

    $cat_event = get_the_terms( $id, 'event_category' );
    $i = 0;

    if( ! empty( $cat_event ) ){
        $count_cat = count( $cat_event );
        ?>
        <i class="fa fa-list-alt"></i>
        <?php
        foreach ($cat_event as $cat) {
            $i++;
            $separator = ( $count_cat !== $i ) ? "," : "";

            $link = get_term_link($cat->term_id);
            $name = $cat->name;
            ?>
            <span class="cat-ovaev">
                <a class="second_font" href="<?php echo esc_url( $link ) ?>"><?php echo esc_html( $name ) ?></a>
            </span>
            <span class="separator">
                <?php echo esc_html( $separator ) ?>
            </span>

            <?php
        }
    }
}

function ovaev_get_tag_event_by_id( $id = '' ){

    if( $id === '' ) return;
    $tag_event = get_the_terms( $id, 'event_tag' );

    if( ! empty( $tag_event ) ){
        ?>
        <div class="event-tags">
            <?php
            foreach ($tag_event as $tag) {

                $link = get_term_link($tag->term_id);
                $name = $tag->name;
                ?>

                    <a class="ovaev-tag second_font" href="<?php echo esc_url( $link ) ?>"><?php echo esc_html( $name ) ?></a>

                <?php
            }
            ?>
        </div>
        <?php
    }
}

function ovaev_get_event_related_by_id( $id = '' ){

    if( empty( $id ) ) return;
    $time = OVAEV_Settings::archive_event_format_time();

    $terms_type = get_the_terms( $id, 'event_category' );
    $terms_tag = get_the_terms( $id, 'event_tag' );

    $arr_type = [];
    if( $terms_type ){
        foreach( $terms_type as $type ){
            $arr_type[] = $type->term_id;
        }
    }

    $arr_tag = [];
    if( $terms_tag ){
        foreach( $terms_tag as $tag ){
            $arr_tag[] = $tag->term_id;
        }
    }

    $args_related = array(
        'post_type' => 'event',
        'posts_per_page' => apply_filters( 'ovaev_single_related_count', 3 ),
        'post__not_in' => array( $id ),
        'tax_query' => array(
            'relation' => 'OR',
            array(
                'taxonomy' => 'event_category',
                'field'    => 'term_id',
                'terms'    => $arr_type,
            ),
            array(
                'taxonomy' => 'event_tag',
                'field'    => 'term_id',
                'terms'    => $arr_tag,
            ),
        ),
    );
    $event_related = new WP_Query( $args_related );

   return $event_related;
}

function ovaev_get_events_elements( $args ){

    if( $args['category'] === 'all'){
        if( $args['time_event'] === 'current'){
            $args_event= array(
                'post_type'      => 'event',
                'post_status'    => 'publish',
                'posts_per_page' => $args['total_count'],
                'meta_query'     => array(
                    array(
                        array(
                            'relation' => 'AND',
                            array(
                                'key'     => 'ovaev_start_date_time',
                                'value'   => current_time('timestamp' ),
                                'compare' => '<'
                            ),
                            array(
                                'key'     => 'ovaev_end_date_time',
                                'value'   => current_time('timestamp' ),
                                'compare' => '>='
                            )
                        )
                    )
                )
            );
        } elseif( $args['time_event'] === 'upcoming' ){
            $args_event= array(
                'post_type'      => 'event',
                'post_status'    => 'publish',
                'posts_per_page' => $args['total_count'],
                'meta_query'     => array(
                    array(
                        array(
                            'key'     => 'ovaev_start_date_time',
                            'value'   => current_time( 'timestamp' ),
                            'compare' => '>'
                        ),
                    )
                )
            );
        } elseif( $args['time_event'] === 'past' ){
            $args_event= array(
                'post_type'      => 'event',
                'post_status'    => 'publish',
                'posts_per_page' => $args['total_count'],
                'meta_query'     => array(
                    array(
                        'key'     => 'ovaev_end_date_time',
                        'value'   => current_time('timestamp' ),
                        'compare' => '<',                   
                    ),
                ),
            );
        } else{ 
            $args_event= array(
                'post_type'      => 'event',
                'post_status'    => 'publish',
                'posts_per_page' => $args['total_count'],
            );
        }

    } elseif( $args['category'] != 'all' ) {
        if( $args['time_event'] === 'current'){
            $args_event= array(
                'post_type'      => 'event',
                'post_status'    => 'publish',
                'posts_per_page' => $args['total_count'],
                'tax_query'      => array(
                    array(
                        'taxonomy' => 'event_category',
                        'field'    => 'slug',
                        'terms'    => $args['category'],
                    )
                ),
                'meta_query'     => array(
                    array(
                        'relation' => 'OR',
                        array(
                            'key'     => 'ovaev_start_date_time',
                            'value'   => array( current_time('timestamp' )-1, current_time('timestamp' )+(24*60*60)+1 ),
                            'type'    => 'numeric',
                            'compare' => 'BETWEEN'  
                        ),
                        array(
                            'relation' => 'AND',
                            array(
                                'key'     => 'ovaev_start_date_time',
                                'value'   => current_time('timestamp' ),
                                'compare' => '<'
                            ),
                            array(
                                'key'     => 'ovaev_end_date_time',
                                'value'   => current_time('timestamp' ),
                                'compare' => '>='
                            )
                        )
                    )
                )
            );
        } elseif( $args['time_event'] === 'upcoming' ){
            $args_event= array(
                'post_type'      => 'event',
                'post_status'    => 'publish',
                'posts_per_page' => $args['total_count'],
                'tax_query'      => array(
                    array(
                        'taxonomy' => 'event_category',
                        'field'    => 'slug',
                        'terms'    => $args['category'],
                    )
                ),
                'meta_query'     => array(
                    array(
                        array(
                            'key'     => 'ovaev_start_date_time',
                            'value'   => current_time( 'timestamp' ),
                            'compare' => '>'
                        ),  
                    )
                )
            );
        } elseif( $args['time_event'] === 'past' ){
            $args_event= array(
                'post_type'      => 'event',
                'post_status'    => 'publish',
                'posts_per_page' => $args['total_count'],
                'tax_query'      => array(
                    array(
                        'taxonomy' => 'event_category',
                        'field'    => 'slug',
                        'terms'    => $args['category'],
                    )
                ),
                'meta_query'     => array(
                    array(
                        'key'     => 'ovaev_end_date_time',
                        'value'   => current_time('timestamp' ),
                        'compare' => '<',                   
                    ),
                ),
            );
        } else{
            $args_event= array(
                'post_type'   => 'event',
                'post_status' => 'publish',
                'tax_query'   => array(
                    array(
                        'taxonomy' => 'event_category',
                        'field'    => 'slug',
                        'terms'    => explode(',', $args['category'] ),
                    )
                ),
                'posts_per_page' => $args['total_count']
            );
        } 

    }


    $args_event_order = [];
    if( $args['order_by'] === 'ovaev_start_date_time' || $args['order_by'] === 'event_custom_sort' ) {
        $args_event_order = [
            'meta_key'   => $args['order_by'],
            'orderby'    => 'meta_value_num',
            'order'      => $args['order'],
        ];
    } else {
        $args_event_order = [
            'orderby'        => $args['order_by'],
            'order'          => $args['order'],
        ];
    }

    $args_event = array_merge( $args_event, $args_event_order );

    $events = new \WP_Query($args_event);

    return $events;
}
