<?php

if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly.
}

get_header();

$id = get_the_ID();

$template = MB()->options->movie->get('single_template', 'default');

// category
$category = get_the_terms($id, 'movie_cat');

// Running time
$running_time = get_post_meta($id, 'ova_mb_movie_running_time', true); 

// listing
$group_listing  = get_post_meta( $id, 'ova_mb_movie_listing', true );

// heading options
$cast_heading    = MB()->options->movie->get('single_cast_heading', 'Top Cast');
$content_heading = MB()->options->movie->get('single_story_heading', 'Story Line');
$related_heading = MB()->options->movie->get('single_related_movies_heading', 'More Movies Like This');

// for related movie slider
$data_options = apply_filters( 'mb_related_movies_options', array( 'items' => 5, 
    'slideBy' => 1,
    'margin' => 20,
    'loop' => false,
    'autoplayHoverPause' => true,
    'autoplay' => true,
    'autoplayTimeout' => 3000,
    'smartSpeed' => 500,
    'dots' => false,
    'nav' => false
));

?>

<?php if( $template == 'default' ){ ?>

    <div class="row_site">
        <div class="container_site">
            <div class="ova_movie_single">
                
                <div class="top-content">

                    <div class="movie-heading">
                        <h1 class="movie-title">
                            <?php the_title(); ?>    
                        </h1>

                        <div class="categories-and-time">
                            <?php if( ! empty( $category ) ) { ?>
                                <div class="movie-category">
                                    <?php 
                                        $arr_link = array();
                                        foreach( $category as $cat ) { 
                                            $category_link = get_term_link($cat->term_id);
                                            if ( $category_link ) {
                                                $link = '<a href="'.esc_url( $category_link ).'" title="'.esc_attr($cat->name).'">'.$cat->name.'</a>';
                                                array_push( $arr_link, $link );
                                            }
                                        }
                                        if ( !empty( $arr_link ) && is_array( $arr_link ) ) {
                                            echo join(', ', $arr_link);
                                        }
                                    ?>
                                </div>
                            <?php } ?>

                            <?php if( ! empty( $category ) && ! empty( $running_time ) ) { ?>
                                <div class="separator"><?php esc_html_e('/','moviebooking');?></div>
                            <?php } ?>

                            <?php if( ! empty( $running_time ) ) { ?>
                                <span class="running-time">
                                    <?php echo esc_html( $running_time ); ?> 
                                </span>
                            <?php } ?>
                        </div>
                    </div>

                   <?php if ( mb_movie_release_date_has_arrived($id) ) {
                        mb_get_template( 'parts/single-get-ticket-button.php' ); 
                    } ?>

                </div>

                <div class="movie-media has-trailer">
                    <?php mb_get_template( 'parts/single-media.php' ); ?>
                </div>  

                <?php if($group_listing) { ?>
                    <ul class="info-list">
                        <?php
                            foreach( $group_listing as $k => $listing ){
                                $listing_title  = isset( $listing['ova_mb_movie_listing_title'] ) ? $listing['ova_mb_movie_listing_title'] : ''; 
                                $listing_value  = isset( $listing['ova_mb_movie_listing_value'] ) ? $listing['ova_mb_movie_listing_value'] : ''; 
                            ?>
                              
                            <li class="item item-<?php echo esc_attr($k);?>">
                                
                                <?php if($listing_title) { ?>
                                    <h4 class="title">
                                        <?php echo esc_html( $listing_title ); ?>   
                                    </h4>
                                <?php } ?> 

                                <?php if($listing_value) { ?>
                                    <span class="value">
                                        <?php echo esc_html( $listing_value ); ?>
                                    </span>
                                <?php }?> 

                            </li>

                        <?php } ?>
                    </ul>
                <?php } ?>

                <?php if( get_the_terms( $id, 'movie_cast' ) ) : ?>
                    <div class="movie-cast">
                        <?php if( !empty($cast_heading) ) { ?>
                            <h2 class="movie-title-h2 cast-title">
                                <?php echo esc_html($cast_heading); ?>    
                            </h2>
                        <?php } ?>
                        <?php mb_get_template( 'elementor/movie_cast_list.php' ); ?>
                    </div> 
                <?php endif; ?>

                <div class="main-content">
                    <?php if( !empty($content_heading) ) { ?>
                        <h2 class="movie-title-h2 story-title">
                            <?php echo esc_html($content_heading); ?>    
                        </h2>
                    <?php } ?>
                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
                        the_content();
                    endwhile; endif; wp_reset_postdata(); ?>
                </div>  
                
                <?php if( mb_movie_has_related_movies($id,$category) ) : ?>
                    <div class="movie-related">
                        <?php if( !empty($related_heading) ) { ?>
                            <h2 class="movie-title-h2 related-title">
                                <?php echo esc_html($related_heading); ?>    
                            </h2>
                        <?php } ?>
                        <?php mb_get_template( 'elementor/movie_list.php' ); ?>
                    </div> 
                <?php endif; ?>
                
                <?php if ( comments_open() || get_comments_number() ) {
                    comments_template();
                } ?>

            </div>
        </div>
    </div>

<?php } else {
    echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $template );
} ?>


<?php get_footer(); ?>