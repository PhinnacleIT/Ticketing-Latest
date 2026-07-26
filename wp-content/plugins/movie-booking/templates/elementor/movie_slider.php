<?php

    $template = isset($args['template']) ? $args['template'] : 'template1';

    if ( is_singular('movie') && MB()->options->movie->get('single_filter_by_related', 'yes') == 'yes' ) {
        $args['current_movie_id'] = get_the_id();
    } else {
        $args['current_movie_id'] = '';
    }

	$movies  = MB_Movie()->get_data_movie_el( $args );
    
    // data options for slider
    if( isset($args['data_options']) ) {
        $data_options = $args['data_options'];
    } else {
        $data_options['items']              = isset($args['item_number']) ? $args['item_number'] : 3 ;
        $data_options['slideBy']            = isset($args['slides_to_scroll']) ? $args['slides_to_scroll'] : 1 ;
        $data_options['margin']             = isset($args['margin_items']) ? $args['margin_items'] : 20 ;
        $data_options['autoplayHoverPause'] = $args['pause_on_hover'] === 'yes' ? true : false;
        $data_options['loop']               = $args['infinite'] === 'yes' ? true : false;
        $data_options['autoplay']           = $args['autoplay'] === 'yes' ? true : false;
        $data_options['autoplayTimeout']    = isset($args['autoplay_speed']) ? $args['autoplay_speed'] : 3000 ;
        $data_options['smartSpeed']         = isset($args['smartSpeed']) ? $args['smartSpeed'] : 500 ;
        $data_options['dots']               = $args['dot_control'] === 'yes' ? true : false;
        $data_options['nav']                = $args['nav_control'] === 'yes' ? true : false;
    }


?>

<div class="mb-movie-slider mb-movie-slider-<?php echo esc_attr($template);?> owl-carousel owl-theme" data-options="<?php echo esc_attr(json_encode($data_options)) ?>">

	<?php if( $movies->have_posts() ) : while ( $movies->have_posts() ) : $movies->the_post(); ?>

		<?php if( $template === 'template1' ) {
            mb_get_template( 'parts/item-template1.php', $args );

        } elseif( $template === 'template2' ) {
            mb_get_template( 'parts/item-template2.php', $args );

        } elseif( $template === 'template3' ) {
            mb_get_template( 'parts/item-template3.php', $args );

        } elseif( $template === 'template4' ) {
            mb_get_template( 'parts/item-template4.php', $args );

        } else {
            mb_get_template( 'parts/item-template1.php', $args );
    	}

	endwhile; endif; wp_reset_postdata(); ?>

</div>