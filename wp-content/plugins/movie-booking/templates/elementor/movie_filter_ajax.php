<?php

    $template       = isset($args['template'])      ? $args['template']         : 'template1';
    $number_column  = isset($args['number_column']) ? $args['number_column']    : 'four_column';
    $venue          = isset($args['venue'])         ? $args['venue']            : '';
    $total          = isset($args['total_count'])   ? $args['total_count']      : 6;
    $orderby        = isset($args['orderby'])       ? $args['orderby']          : 'ID';
    $order          = isset($args['order'])         ? $args['order']            : 'DESC';
    
    // tabs button filter ajax
    $date_filter_type = $args['date_filter_type'];
    $number_of_days   = isset($args['number_of_days'])  ? $args['number_of_days']   : 5;
    $text_today       = isset($args['text_today'])      ? $args['text_today']       : '';
    $text_this_week   = isset($args['text_this_week'])  ? $args['text_this_week']   : '';
    $text_this_month  = isset($args['text_this_month']) ? $args['text_this_month']  : '';
    if( $text_today == '' || $text_this_week == '' ) {
        $text_today     = esc_html__('Today','moviebooking');
        $text_this_week = esc_html__('This week','moviebooking');
    }

    // demo data mode
    $demo_data_mode    = $args['demo_data_mode'];
    $currentDate_demo  = isset($args['currentDate_demo']) ? $args['currentDate_demo'] : '';
    if($demo_data_mode == 'yes') {
        $currentDate  = strtotime($currentDate_demo); 
    } else {
        $currentDate = time(); 
    }
   
    $gmt_offset   = get_option('gmt_offset');
    $startDate    = strtotime("midnight", $currentDate);
    $endDate      = $startDate + 86400-1; 
    
    $dates = array();
    for ($x = 1; $x < $number_of_days; $x++) {
        $str_day = '+'.$x.' day';
        array_push( $dates, strtotime($str_day, $startDate) );
    }

    // fixed period calculate date
    $day   = date('j', $startDate);
    $month = date('n', $startDate);
    $year  = date('Y', $startDate);
    $day_of_the_week = date('w', $currentDate);

    $number_of_days_to_end_week  = 7 - $day_of_the_week;
    $number_of_days_to_end_month = cal_days_in_month(CAL_GREGORIAN,$month,$year) - $day;
    $end_week  = $startDate + $number_of_days_to_end_week*86400-1;
    $end_month = $startDate + $number_of_days_to_end_month*86400-1;
    

    // data movies first init
    $args['date_min'] = $currentDate + $gmt_offset*3600;
    $args['date_max'] = $endDate;
    $args['total']    = $args['total_count'];
    $movies = MB_Movie()->get_data_movie_filter_ajax( $args );

?>

<div class="mb-movie-filter-ajax-container">

    <?php if ( $date_filter_type == 'weekdays' ): ?>
        <ul class="mb-button-filter-ajax mb-date-tabs"
            data-template="<?php echo esc_attr( $template ); ?>"
            data-venue="<?php echo esc_attr( $venue ); ?>"
            data-total="<?php echo esc_attr($total); ?>" 
            data-orderby="<?php echo esc_attr($orderby); ?>" 
            data-order="<?php echo esc_attr($order); ?>"
        >
            <li class="button-filter-ajax current" data-date_min="<?php echo esc_attr( $currentDate + $gmt_offset*3600 ); ?>"
                data-date_max="<?php echo esc_attr( $endDate ); ?>"
            >
                <div class="day">
                    <span class="D_m_day">
                        <span class="m_day"><?php esc_attr_e( date( 'm', $currentDate + $gmt_offset*3600 ) ); ?></span>
                        <span class="D_day"><?php esc_attr_e( date( 'D', $currentDate + $gmt_offset*3600 ) ); ?></span>
                    </span>
                    <span class="d_day">
                        <strong><?php esc_attr_e( date( 'd', $currentDate ) ); ?></strong>
                    </span>
                </div>
            </li>

            <?php foreach( $dates as $date ) : ?>
                <li class="button-filter-ajax" data-date_min="<?php echo esc_attr( $date ); ?>"
                    data-date_max="<?php echo esc_attr( $date + 86400-1 ); ?>"
                >
                    <div class="day">
                        <span class="D_m_day">
                            <span class="m_day"><?php esc_attr_e( date( 'm', $date ) ); ?></span>
                            <span class="D_day"><?php esc_attr_e( date( 'D', $date ) ); ?></span>
                        </span>
                        <span class="d_day">
                            <strong><?php esc_attr_e( date( 'd', $date ) ); ?></strong>
                        </span>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <ul class="mb-button-filter-ajax mb-date-tabs fixed-period"
            data-template="<?php echo esc_attr( $template ); ?>"
            data-venue="<?php echo esc_attr( $venue ); ?>"
            data-total="<?php echo esc_attr($total); ?>" 
            data-orderby="<?php echo esc_attr($orderby); ?>" 
            data-order="<?php echo esc_attr($order); ?>"
        >
            <li class="button-filter-ajax current" data-date_min="<?php esc_attr_e( $currentDate + $gmt_offset*3600 ); ?>"
                data-date_max="<?php echo esc_attr( $endDate ); ?>"
            >
                <?php echo esc_html($text_today); ?>
            </li>
            <li class="button-filter-ajax" data-date_min="<?php esc_attr_e( $currentDate + $gmt_offset*3600 ); ?>"
                data-date_max="<?php echo esc_attr( $end_week ); ?>"
            >
                <?php echo esc_html($text_this_week); ?>
            </li>
            <?php if( !empty($text_this_month) ) { ?>
                <li class="button-filter-ajax" data-date_min="<?php esc_attr_e( $currentDate + $gmt_offset*3600 ); ?>"
                    data-date_max="<?php echo esc_attr( $end_month ); ?>"
                >
                    <?php echo esc_html($text_this_month); ?>
                </li>
            <?php } ?>
        </ul>
    <?php endif;?>

    <div class="mb-spinner">
        <div></div><div></div><div></div><div></div>
        <div></div><div></div><div></div><div></div>
        <div></div><div></div><div></div><div></div>
    </div>

    <div class="mb-movie-filter-ajax mb-movie-filter-ajax-<?php echo esc_attr($template);?> <?php echo esc_attr($number_column);?>">
        
        <!-- fill data movies first load without ajax -->
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

        endwhile; wp_reset_postdata();

        else : esc_html_e( 'No movie found', 'moviebooking' ); endif; ?>

    </div>

</div>