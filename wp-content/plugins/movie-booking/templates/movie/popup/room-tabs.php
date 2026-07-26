<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

$flag = 0;

?>

<?php if ( ! empty( $args ) && is_array( $args ) ): ?>
    <dl class="collateral-tabs">
        <?php foreach( $args as $city_id => $data_city ):
            $current = $city_name = '';

            if ( $flag == 0 ) {
                $current = ' current';
            }

            if ( $city_id ) {
                $city_name = MBC()->mb_get_taxonomy_name( $city_id, 'movie_location' );
            }

            $rooms = MB_Showtime()->get_room_by_city( $city_id, $data_city );
        ?>
            <dt class="tab<?php esc_attr_e( $current ); ?>">
                <?php esc_html_e( $city_name ); ?>
            </dt>
            <dd class="tab-container<?php esc_attr_e( $current ); ?>">
                <div class="tab-content mb-rooms">
                    <ul class="toggle-tabs">
                        <?php if ( ! empty( $rooms ) && is_array( $rooms ) ): $flag_room = 0; ?>
                            <?php foreach( array_keys( $rooms ) as $room_id ): 
                                $room_current = '';

                                if ( $flag_room == 0 ) {
                                    $room_current = ' current';
                                }

                                $room_name = get_the_title( $room_id );
                            ?>
                                <li class="mb-room-name<?php esc_attr_e( $room_current ); ?>">
                                    <?php esc_html_e( $room_name ); ?>
                                </li>
                            <?php $flag_room++; endforeach; ?>
                        <?php endif; ?>
                    </ul>
                    <dl class="collateral-tabs">
                        <?php if ( ! empty( $rooms ) && is_array( $rooms ) ): $flag_showtime = 0; ?>
                            <?php foreach( $rooms as $room_id => $item_room ): 
                                $showtime_current = '';

                                if ( $flag_showtime == 0 ) {
                                    $showtime_current = ' current';
                                }

                                $room_name  = get_the_title( $room_id );
                                $venues     = MB_Showtime()->get_venue_by_room( $room_id, $item_room );
                            ?>
                                <dt class="tab<?php esc_attr_e( $showtime_current ); ?>">
                                    <?php esc_html_e( $room_name ); ?>
                                </dt>
                                <dd class="tab-container<?php esc_attr_e( $showtime_current ); ?>">
                                    <div class="tab-content showtimes">
                                        <?php if ( ! empty( $venues ) && is_array( $venues ) ): ?>
                                            <?php foreach( $venues as $venue_id => $item_venue ): 
                                                $prefix     = MB_PLUGIN_PREFIX_ROOM;
                                                $venue_name = MBC()->mb_get_taxonomy_name( $venue_id, 'movie_location' );
                                                $type_id    = get_post_meta( $room_id, $prefix.'type_id', true );
                                                $type_name  = MBC()->mb_get_taxonomy_name( $type_id, 'room_type' );
                                            ?>
                                                <div class="mb-venue">
                                                    <div class="venue-name">
                                                        <h3><?php esc_html_e( $venue_name ); ?></h3>
                                                    </div>
                                                    <?php if ( $type_name ): ?>
                                                        <div class="mb-room-type">
                                                            <h4><?php esc_html_e( $type_name ); ?></h4>
                                                        </div>
                                                    <?php endif; ?>
                                                    <ul class="mb-tab-showtime">
                                                        <?php foreach( $item_venue as $item_data ): 
                                                            $time = date( MBC()->mb_get_time_format(), $item_data['date'] );
                                                            $url = add_query_arg( array(
                                                                'sid' => $item_data['showtime_id'],
                                                                'rid' => $item_data['room_id'],
                                                            ), MB()->cart->get_cart_page() );
                                                        ?>
                                                            <li class="item">
                                                                <a href="<?php echo esc_url( $url ); ?>">
                                                                    <span><?php esc_html_e( $time ); ?></span>
                                                                </a>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </dd>
                            <?php $flag_showtime++; endforeach; ?>
                        <?php endif; ?>
                    </dl>
                </div>
            </dd>
        <?php $flag++; endforeach; ?>
    </dl>
<?php endif; ?>