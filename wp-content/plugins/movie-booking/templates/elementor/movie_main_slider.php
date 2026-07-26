<?php

    $template = isset($args['template']) ? $args['template'] : 'template1';

	$movies  = MB_Movie()->get_data_movie_el( $args );
    
    // data options
    $data_options['items']              = isset($args['item_number']) ? $args['item_number'] : 2;
    $data_options['autoplayHoverPause'] = $args['pause_on_hover'] === 'yes' ? true : false;
    $data_options['loop']               = $args['infinite'] === 'yes' ? true : false;
    $data_options['autoplay']           = $args['autoplay'] === 'yes' ? true : false;
    $data_options['autoplayTimeout']    = isset($args['autoplay_speed']) ? $args['autoplay_speed'] : 6900 ;
    $data_options['smartSpeed']         = isset($args['smartSpeed']) ? $args['smartSpeed'] : 500 ;
    $data_options['rtl']                = is_rtl() ? true: false;
    $data_options['template']           = $template;

    if($template == 'template2' || $template == 'template3') {
        $data_options['items'] = 4;
    }

    // text options
    $show_share_social  = isset($args['show_share_social']) ? $args['show_share_social'] : 'yes';
    $text_share         = isset($args['text_share'])        ? $args['text_share']        : esc_html__('Share','moviebooking');
    $show_category      = isset($args['show_category'])     ? $args['show_category']     : 'yes';
    $category_suffix    = isset($args['category_suffix'])   ? $args['category_suffix']   : esc_html__('Movie','moviebooking');
    $show_release_date  = isset($args['show_release_date']) ? $args['show_release_date'] : 'yes';
    $text_release       = isset($args['text_release'])      ? $args['text_release']      : esc_html__('In theater','moviebooking');
    $show_trailer       = isset($args['show_trailer'])      ? $args['show_trailer']      : 'yes';
    $text_trailer       = isset($args['text_trailer'])      ? $args['text_trailer']      : esc_html__('Trailers','moviebooking');
    $text_more_info     = isset($args['text_more_info'])    ? $args['text_more_info']    : esc_html__('More Info','moviebooking');

?>

<div class="mb-movie-main-slider-wrapper main-wrapper-<?php echo esc_attr($template);?>">
    
    <!-- main slider -->
    <div class="mb-movie-main-slider main-<?php echo esc_attr($template);?>" data-options="<?php echo esc_attr(json_encode($data_options)) ?>">

    	<?php if( $movies->have_posts() ) : while ( $movies->have_posts() ) : $movies->the_post();

            $id = get_the_ID();

            // slideshow image 
            $url_slideshow_image = get_post_meta( $id, 'ova_mb_movie_slideshow_image', true );

            // category ( get first category)
            $category = get_the_terms($id, 'movie_cat');
            if($category) {
                $cat_name = $category[0]->name;
            } else {
                $cat_name = '';
            }
           
            // get release date
            $release_date_timestamp = get_post_meta( $id, 'ova_mb_movie_release_date', true );
            $date_format  = 'F Y';

            if($release_date_timestamp) {
                $release_date = date($date_format,$release_date_timestamp);
            } else {
                $release_date = '';
            }   

        ?>  

            <div class="movie-main-item-wrapper">

                <?php if( !empty( $url_slideshow_image) ) { ?>
                    <img class="slideshow-image" data-lazy="<?php echo esc_attr($url_slideshow_image);?>" alt="<?php the_title(); ?>">
                <?php } ?>
                
                <?php if( $show_share_social  == "yes" ) { ?>
                    <div class="movie-social-sharing">
                        <span class="text-share"><?php echo esc_html($text_share);?></span>
                        <span class="line"></span>
                        <?php apply_filters( 'ova_share_social', get_the_permalink(), get_the_title()  ); ?>
                    </div>  
                <?php } ?>

                <div class="movie-main-item-container row_site">
                    
                    <?php if(!empty($release_date) && $show_release_date == "yes" ) { ?>
                        <div class="movie-release">
                            <span class="text"><?php echo esc_html($text_release);?></span>
                            <h3 class="time"><?php echo esc_html($release_date);?></h3>
                        </div>
                    <?php } ?>

                    <div class="movie-main-item">

                        <div class="movie-heading">
                            <?php if(!empty($cat_name) && $show_category == "yes") { ?>
                                <h3 class="movie-category">
                                    <?php echo esc_html($cat_name) . ' ' . esc_html($category_suffix); ?>
                                </h3>
                            <?php } ?>
                            
                            <a href="<?php the_permalink();?>" title="<?php the_title(); ?>">
                                <h1 class="movie-title">
                                    <?php the_title(); ?>
                                </h1>
                            </a>
                        </div>

                        <p class="movie-excerpt">
                            <?php echo wp_trim_words(get_the_excerpt(),20,'...'); ?>
                        </p>  

                        <div class="button-wrapper">
                            <?php if(!empty($text_more_info) && $template == 'template1') { ?>
                                <a href="<?php the_permalink();?>" title="<?php the_title(); ?>">
                                    <button class="btn btn-more-info">
                                        <?php echo esc_html($text_more_info); ?>
                                    </button> 
                                </a>
                            <?php } ?>
                            <?php mb_get_template( 'parts/single-get-ticket-button.php' ); ?>
                        </div>

                    </div>

                </div>  

            </div>
           
    	<?php endwhile; endif; wp_reset_postdata(); ?>

    </div>

    
    <!-- trailer slider wrapper -->
    <?php if( $show_trailer  == "yes" ) { ?>
        <div class="mb-movie-trailer-slider-wrapper trailer-<?php echo esc_attr($template);?>">
            
            <?php if( $template != 'template3') { ?>
                <img class="arrow-trailers-img" src="<?php echo MB_PLUGIN_URI.'assets/img/arrow-watch-trailer.png';?>" alt="<?php echo esc_html__('Arrow watch trailer','moviebooking'); ?>">
            <?php } ?>
            <span class="text-trailer"><?php echo esc_html($text_trailer)?></span>
            
             <!-- trailer slider -->
            <div class="mb-movie-trailer-slider" data-options="<?php echo esc_attr(json_encode($data_options)) ?>">
                <?php if( $movies->have_posts() ) : while ( $movies->have_posts() ) : $movies->the_post(); 
                    $thumbnail   = wp_get_attachment_image_url( get_post_thumbnail_id(),'medium' );
                    if( $thumbnail == '') {
                        $thumbnail  =  \Elementor\Utils::get_placeholder_image_src();
                    }
                ?>  
                    <div class="movie-trailer-item">
                        <div class="movie-trailer-media">
                            <img src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php the_title(); ?>">
                            <?php mb_get_template( 'parts/watch-trailer-button.php' ); ?> 
                        </div>
                    </div>    
                <?php endwhile; endif; wp_reset_postdata(); ?>
            </div>

        </div>
    <?php } ?>

</div>