<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MB_Movie' ) ) {
    class MB_Movie {
        /**
         * instance
         * @var null
         */
        protected static $_instance = null;
        protected $_prefix          = MB_PLUGIN_PREFIX_MOVIE;

        public function __construct() {
            add_action( 'pre_get_posts', array( $this, 'post_per_page_archive' ) );
        }

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        public function post_per_page_archive( $query ) {

            if ( ( is_post_type_archive( 'movie' )  && !is_admin() )  || ( is_tax('movie_cat') && !is_admin() ) ) {

                if( $query->is_post_type_archive( 'movie' ) || $query->is_tax('movie_cat') ) {
                    $query->set('post_type', array( 'movie' ) );
                    $query->set('posts_per_page', MB()->options->movie->get('archive_movies_per_page', 6) );
                    $query->set('orderby', 'meta_value_num' );
                    $query->set('order', 'DESC' );
                    $query->set('meta_type', 'NUMERIC' );
                    $query->set('meta_key', 'ova_mb_movie_order' );
                }
            }
        }

        public function get_data_movie_el( $args ){
            
            $show_only_featured = isset($args['show_only_featured']) ? $args['show_only_featured'] : 'no';

            $category       = isset($args['category']) ? $args['category'] : 'all' ;
            $movie_status   = isset($args['movie_status']) ? $args['movie_status'] : 'all' ;

            $total_count    = isset($args['total_count']) ? $args['total_count'] : 4 ;
            $orderby        = isset($args['orderby']) ? $args['orderby'] : 'ID' ;
            $order          = isset($args['order']) ? $args['order'] : 'DESC' ;
            $offset         = isset($args['offset']) ? $args['offset'] : 0 ;

            // variable used to get related movies in movie single page
            $current_movie_id = isset($args['current_movie_id']) ? $args['current_movie_id'] : '';
            $cm_cat_ids = array();

            if( $current_movie_id != '' ) {
                $current_movie_category = get_the_terms($current_movie_id, 'movie_cat');
                if(!empty($current_movie_category) && !is_wp_error($current_movie_category)):
                    foreach ($current_movie_category as $cm_cat_id):
                        array_push($cm_cat_ids, $cm_cat_id->term_id);
                    endforeach;
                endif;
            }
            

            // Start Query
            if( $category == 'all' ){
                $args_base = array(
                    'post_type' => 'movie',
                    'post_status' => 'publish',
                    'posts_per_page' => $total_count,
                    'offset' => $offset,
                );
            } else {
                $args_base = array(
                    'post_type' => 'movie',
                    'post_status' => 'publish',
                    'posts_per_page' => $total_count,
                    'offset' => $offset,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'movie_cat',
                            'field'    => 'slug',
                            'terms'    => $category,
                        )
                    ),
                );
            }
            
            // In Movie single page - query get realted movies
            if( $current_movie_id != '' ) { 
                if( $category == 'all' ){
                    $args_base = array(
                        'post_type' => 'movie',
                        'post_status' => 'publish',
                        'posts_per_page' => $total_count,
                        'post__not_in'   => array($current_movie_id),
                        'offset' => $offset,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'movie_cat',
                                'field' => 'term_id',
                                'terms' => $cm_cat_ids
                            )
                        ),
                    );
                } else {
                    $args_base = array(
                        'post_type' => 'movie',
                        'post_status' => 'publish',
                        'posts_per_page' => $total_count,
                        'offset' => $offset,
                        'tax_query' => array(
                            'relation' => 'AND',
                            array(
                                'taxonomy' => 'movie_cat',
                                'field'    => 'slug',
                                'terms'    => $category,
                            ),
                            array(
                                'taxonomy' => 'movie_cat',
                                'field' => 'term_id',
                                'terms' => $cm_cat_ids
                            )
                        ),
                    );
                }
            }

            // Movie Status Query - Meta Query
            if ( $movie_status == 'coming_soon' ) {
                $args_base['meta_query'] =  array(
                    'relation' => 'AND',
                    array(
                        'key' => 'ova_mb_movie_release_date',
                        'value' => current_time( 'timestamp' ),
                        'compare' => '>'
                    ),
                    array(
                        'key' => 'ova_mb_movie_closed',
                        'compare' => 'NOT EXISTS',
                    )
                );
            }
            
            if ( $movie_status == 'now_playing' ) {
                $args_base['meta_query'] =  array(
                    'relation' => 'AND',
                    array(
                        'key' => 'ova_mb_movie_release_date',
                        'value' => current_time( 'timestamp' ),
                        'compare' => '<='
                    ),
                    array(
                        'key' => 'ova_mb_movie_closed',
                        'compare' => 'NOT EXISTS',
                    )
                );
            }
            
            // Show only featured
            if( $show_only_featured == 'yes') {

                if ( $movie_status == 'all' ) {
                    $args_base['meta_query'] =  array(
                        array(
                            'key' => 'ova_mb_movie_featured',
                            'compare' => 'EXISTS',
                        )
                    );
                }

                if ( $movie_status == 'coming_soon' ) {
                    $args_base['meta_query'] =  array(
                        'relation' => 'AND',
                        array(
                            'key' => 'ova_mb_movie_release_date',
                            'value' => current_time( 'timestamp' ),
                            'compare' => '>'
                        ),
                        array(
                            'key' => 'ova_mb_movie_closed',
                            'compare' => 'NOT EXISTS',
                        ),
                        array(
                            'key' => 'ova_mb_movie_featured',
                            'compare' => 'EXISTS',
                        )
                    );
                }
                
                if ( $movie_status == 'now_playing' ) {
                    $args_base['meta_query'] =  array(
                        'relation' => 'AND',
                        array(
                            'key' => 'ova_mb_movie_release_date',
                            'value' => current_time( 'timestamp' ),
                            'compare' => '<='
                        ),
                        array(
                            'key' => 'ova_mb_movie_closed',
                            'compare' => 'NOT EXISTS',
                        ),
                        array(
                            'key' => 'ova_mb_movie_featured',
                            'compare' => 'EXISTS',
                        )
                    );
                }

            }          

            // Order Query
            $args_movie_order = [];
            if( $orderby === MB_PLUGIN_PREFIX_MOVIE.'release_date' || $orderby === MB_PLUGIN_PREFIX_MOVIE.'order'  ) {
                $args_movie_order = [
                    'meta_key'   => $orderby,
                    'orderby'    => 'meta_value_num',
                    'meta_type'  => 'NUMERIC',
                    'order'      => $order,
                ];
            } else { 
                $args_movie_order = [
                    'orderby' => $orderby,
                    'order'   => $order,
                ];
            }

            $args_movie     = array_merge( $args_base, $args_movie_order );

            $movies         = new \WP_Query($args_movie);

            return $movies;

        }

        public function get_categories(){

            $args = array(
                'taxonomy' => 'movie_cat',
                'orderby' => 'name',
                'order'   => 'ASC'
            );
            
            $categories = get_categories($args);

            return $categories;

        }

        public function get_sort_order() {
            $count_movie    = $this->get_count_movie();
            $order          = $count_movie ? $count_movie : 1;

            return $order;
        }

        public function get_count_movie() {
            $count_movie = '';

            $args = array(
               'post_type'      => 'movie',
               'posts_per_page' => -1,
               'post_status'    => 'publish',
               'fields'         => 'ids'
            );

            $movie_query    = apply_filters( 'mb_ft_get_count_movie', $args );
            $movies         = get_posts( $movie_query );

            if ( $movies && is_array( $movies ) ) {
                $count_movie = count( $movies );
            }

            return $count_movie;
        }

        public function get_all_movie() {
            $args = array(
               'post_type'      => 'movie',
               'posts_per_page' => -1,
               'post_status'    => 'publish',
               'fields'         => 'ids',
               'order'          => 'DESC',
               'orderby'        => 'date',
            );

            $movie_query    = apply_filters( 'mb_ft_get_all_movie', $args );
            $movies         = get_posts( $movie_query );

            return $movies;
        }

        public function get_id_by_showtime( $showtime_id ) {
            $movie_id = get_post_meta( $showtime_id, MB_PLUGIN_PREFIX_SHOWTIME.'movie_id', true );

            return $movie_id;
        }

        public function get_ids_multi_lang( $id ) {
            $translated_ids = array();

            // get plugin active
            $active_plugins = get_option('active_plugins');

            if ( in_array ( 'polylang/polylang.php', $active_plugins ) || in_array ( 'polylang-pro/polylang.php', $active_plugins ) ) {
                $languages = pll_languages_list();

                if ( ! isset( $languages ) ) {
                    $translated_ids[] = $id;
                } else {
                    foreach( $languages as $lang ) {
                        $translated_ids[] = pll_get_post( $id, $lang );
                    }
                }
            } elseif ( in_array ( 'sitepress-multilingual-cms/sitepress.php', $active_plugins ) ) {
                global $sitepress;
            
                if ( ! isset( $sitepress ) ) {
                    $translated_ids[] = $id;
                } else {
                    $trid           = $sitepress->get_element_trid( $id, 'post_movie' );
                    $translations   = $sitepress->get_element_translations( $trid, 'movie' );

                    foreach( $translations as $lang=>$translation){
                        $translated_ids[] = $translation->element_id;
                    }
                }
            } else {
                $translated_ids[] = $id;
            }

            return apply_filters( 'mb_ft_multiple_languages', $translated_ids );
        }

        public function update_coupon( $booking_id = null ) {
            if ( ! $booking_id ) return false;

            $movie_id       = get_post_meta( $booking_id, MB_PLUGIN_PREFIX_BOOKING . 'movie_id', true );
            $discount_code  = get_post_meta( $booking_id, MB_PLUGIN_PREFIX_BOOKING . 'discount_code', true );

            if ( $movie_id && $discount_code ) {
                $coupons = get_post_meta( $movie_id, $this->_prefix . 'coupons', true );

                if ( mb_array_exists( $coupons ) ) {
                    foreach( $coupons as $k => $coupon_item ) {
                        if ( isset( $coupon_item['code'] ) && $coupon_item['code'] === $discount_code ) {
                            $qty = isset( $coupon_item['quantity'] ) && $coupon_item['quantity'] ? absint( $coupon_item['quantity'] ) : 0;
                            $qty -= 1;

                            if ( $qty > 0 ) {
                                $coupons[$k]['quantity'] = $qty;
                            } else {
                                $coupons[$k]['quantity'] = 0;
                            }
                        }
                    }

                    update_post_meta( $movie_id, $this->_prefix . 'coupons', $coupons );

                    return true;
                }
            }

            return false;
        }

        public function get_data_movie_filter_ajax( $args ){

            $prefix = MB_PLUGIN_PREFIX_MOVIE;

            $movie__in_ids = array();

            $venue    = isset($args['venue'])    ? $args['venue']    : '' ;
            $total    = isset($args['total'])    ? $args['total']    : 6 ;
            $orderby  = isset($args['orderby'])  ? $args['orderby']  : 'ID' ;
            $order    = isset($args['order'])    ? $args['order']    : 'DESC' ; 
            $date_min = isset($args['date_min']) ? $args['date_min'] : 0 ; 
            $date_max = isset($args['date_max']) ? $args['date_max'] : 0 ;         

            // Start Query
            $args_base = array(
                'post_type' => 'movie',
                'post_status' => 'publish',
                'posts_per_page' => $total,
                'meta_query' => array(
                    'relation'  => 'AND',
                    array(
                        'key' => 'ova_mb_movie_closed',
                        'compare' => 'NOT EXISTS',
                    ),
                )
            );

            // Order Query
            $args_movie_order = [];
            if( $orderby === $prefix.'release_date' || $orderby === $prefix.'order'  ) {
                $args_movie_order = [
                    'meta_key'   => $orderby,
                    'orderby'    => 'meta_value_num',
                    'meta_type'  => 'NUMERIC',
                    'order'      => $order,
                ];
            } else { 
                $args_movie_order = [
                    'orderby' => $orderby,
                    'order'   => $order,
                ];
            }

            // Query by venue and date
            if ( $venue != '' || $date_min != '' ) {
                $movie__in_id  = '';

                $showtime_ids  = MB_Showtime()->get_showtime_by_venue_and_date($venue, $date_min, $date_max);

                if ( is_array($showtime_ids) ) {
                    foreach($showtime_ids as $showtime_id) {
                        $movie__in_id = $this->get_id_by_showtime($showtime_id);
                        array_push($movie__in_ids, $movie__in_id );
                    }
                } 

                if ( !empty($movie__in_ids) ) {
                    $args_base['post__in'] = $movie__in_ids;
                } else {
                    $args_base['post__in'] = array('0');
                }

            } 

            $args_movie   = array_merge( $args_base, $args_movie_order );

            $movies       = new \WP_Query($args_movie);

            return $movies;

        }
    }
    
    new MB_Movie();
}