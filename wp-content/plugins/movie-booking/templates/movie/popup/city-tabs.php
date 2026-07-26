<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

$flag = 0;
$date_id    = isset( $args['date_id'] ) ? $args['date_id'] : '';
$showtimes  = isset( $args['data_showtime'] ) ? $args['data_showtime'] : array();
$data_city  = MB_Showtime()->get_city_by_showtime( $date_id, $showtimes );

?>
<?php if ( ! empty( $data_city ) && is_array( $data_city ) ): ?>
    <div class="mb-tabs-cities">
        <ul class="toggle-tabs">
            <?php foreach( $data_city as $city_id => $items_city ):
                $current = $city_name = '';

                if ( $flag == 0 ) {
                    $current = ' current';
                }

                if ( $city_id ) {
                    $city_name = MBC()->mb_get_taxonomy_name( $city_id, 'movie_location' );
                }
            ?>
                <li class="mb-city-name<?php esc_attr_e( $current ); ?>">
                    <span><?php esc_html_e( $city_name ); ?></span>
                </li>
            <?php $flag++; endforeach; ?>
        </ul>
    </div>
    <?php # Get Room Type ?>
    <?php mb_get_template( 'movie/popup/type-tabs.php', $data_city ); ?>
<?php else: ?>
    <?php echo esc_html__( 'Sorry, there is no showtime on this date, please choose another date.', 'moviebooking' ); ?>
<?php endif; ?>