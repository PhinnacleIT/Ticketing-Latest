<?php

    $template = isset($args['template']) ? $args['template'] : 'template1';
    $number_column = isset($args['number_column']) ? $args['number_column'] : 'four_column';

    if ( is_singular('movie') && MB()->options->movie->get('single_filter_by_related', 'yes') == 'yes' ) {
        $args['current_movie_id'] = get_the_id();
    } else {
        $args['current_movie_id'] = '';
    }

	$movies  = MB_Movie()->get_data_movie_el( $args );

?>

<div class="mb-movie-list mb-movie-list-<?php echo esc_attr($template);?> <?php echo esc_attr($number_column);?>">

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