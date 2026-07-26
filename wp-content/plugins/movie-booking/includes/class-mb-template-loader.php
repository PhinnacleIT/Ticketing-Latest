<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MB_Template_Loader' ) ) {
    class MB_Template_Loader {

        public function __construct() {
            // Template loader
            add_filter( 'template_include', array( $this, 'mb_template_loader' ) );
            // Loader Header Movie
            add_filter( 'aovis_header_customize', array( $this, 'aovis_header_customize_movie' ) );
            // Loader Footer Movie
            add_filter( 'aovis_footer_customize', array( $this, 'aovis_footer_customize_movie' ) );
        }

        public function mb_template_loader( $template ) {
            $post_type = isset( $_REQUEST['post_type'] ) ? $_REQUEST['post_type'] : get_post_type();

            // Archive movie
            if ( is_tax( 'movie_cat' ) || get_query_var( 'movie_cat' ) != '' || get_query_var( 'movie_tag' ) != '' ) {
                $paged = get_query_var('paged') ? get_query_var('paged') : '1';

                if ( get_query_var( 'movie_tag' ) != '' ) {
                    query_posts( '&movie_tag='.get_query_var( 'movie_tag' ).'&paged=' . $paged );
                } else {
                    query_posts( '&movie_cat='.get_query_var( 'movie_cat' ).'&paged=' . $paged );
                }
                
                mb_get_template( 'movie/archive-movie.php' );

                return false;
            }

            // Is Movie Post Type
            if ( $post_type == 'movie' ) {
                if ( is_post_type_archive( 'movie' ) ) { 
                    mb_get_template( 'movie/archive-movie.php' );
                    return false;
                } elseif ( is_single() ) {
                    mb_get_template( 'movie/single-movie.php' );
                    return false;
                }
            }

            if ( $post_type !== 'movie' ) {
                return $template;
            }
        }

        public function aovis_header_customize_movie( $header ){


            if( is_tax( 'movie_cat' ) ||  get_query_var( 'movie_cat' ) != '' || is_post_type_archive( 'movie' ) ){

                $header = MB()->options->movie->get('archive_header', 'default');

            }else if( is_singular( 'movie' ) ){

                $header = MB()->options->movie->get('single_header', 'default');
            }

            return $header;

        }


        public function aovis_footer_customize_movie( $footer ){
            
           if( is_tax( 'movie_cat' ) ||  get_query_var( 'movie_cat' ) != '' || is_post_type_archive( 'movie' ) ){

                $footer = MB()->options->movie->get('archive_footer', 'default');

            }else if( is_singular( 'movie' ) ){

                $footer = MB()->options->movie->get('single_footer', 'default');
            }

            return $footer;

        }
    }

    return new MB_Template_Loader();
}