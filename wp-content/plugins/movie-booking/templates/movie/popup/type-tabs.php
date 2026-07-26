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

            $room_type = MB_Room()->get_room_type_by_city( $city_id, $data_city );
        ?>
            <dt class="tab<?php esc_attr_e( $current ); ?>">
                <?php esc_html_e( $city_name ); ?>
            </dt>
            <dd class="tab-container<?php esc_attr_e( $current ); ?>">
                <div class="tab-content mb-room-types">
                    <ul class="toggle-tabs">
                        <?php if ( ! empty( $room_type ) && is_array( $room_type ) ): $flag_room = 0; ?>
                            <?php foreach( array_keys( $room_type ) as $type_id ): 
                                $room_current = '';

                                if ( $flag_room == 0 ) {
                                    $room_current = ' current';
                                }

                                $type_name = MBC()->mb_get_taxonomy_name( $type_id, 'room_type' );
                            ?>
                                <li class="mb-room-type-name<?php esc_attr_e( $room_current ); ?>">
                                    <?php esc_html_e( $type_name ); ?>
                                </li>
                            <?php $flag_room++; endforeach; ?>
                        <?php endif; ?>
                    </ul>
                    <dl class="collateral-tabs">
                        <?php if ( ! empty( $room_type ) && is_array( $room_type ) ): $flag_showtime = 0; ?>
                            <?php foreach( $room_type as $type_id => $item_room_type ): 
                                $showtime_current = '';

                                if ( $flag_showtime == 0 ) {
                                    $showtime_current = ' current';
                                }

                                $type_name  = MBC()->mb_get_taxonomy_name( $type_id, 'room_type' );
                                $venues     = MB_Room()->get_venue_by_room_type( $type_id, $item_room_type );
                            ?>
                                <dt class="tab<?php esc_attr_e( $showtime_current ); ?>">
                                    <?php esc_html_e( $type_name ); ?>
                                </dt>
                                <dd class="tab-container<?php esc_attr_e( $showtime_current ); ?>">
                                    <div class="tab-content showtimes">
                                        <?php if ( ! empty( $venues ) && is_array( $venues ) ): ?>
                                            <?php foreach( $venues as $venue_id => $item_venue ): 
                                                $prefix     = MB_PLUGIN_PREFIX_ROOM;
                                                $venue_name = MBC()->mb_get_taxonomy_name( $venue_id, 'movie_location' );
                                                $rooms      = MB_Room()->get_rooms_by_venue( $item_venue );
                                            ?>
                                                <div class="mb-venue">
                                                    <div class="venue-name">
                                                        <h3><?php esc_html_e( $venue_name ); ?></h3>
                                                    </div>
                                                    <?php if ( ! empty( $rooms ) && is_array( $rooms ) ): ?>
                                                        <?php foreach( $rooms as $room_id => $item_room ):
                                                            $room_title = get_the_title( $room_id );
                                                        ?>
                                                            <div class="mb-room-name">
                                                                <h4><?php esc_html_e( $room_title ); ?></h4>
                                                            </div>
                                                            <ul class="mb-tab-showtime">
                                                                <?php foreach( $item_room as $item_data ): 
                                                                    $time   = date( MBC()->mb_get_time_format(), $item_data['date'] );
                                                                    $url    = add_query_arg( array(
                                                                        'sid' => $item_data['showtime_id'],
                                                                        'rid' => $room_id,
                                                                    ), MB()->cart->get_cart_page() );
                                                                ?>
                                                                    <li class="item">
                                                                        <a href="<?php echo esc_url( $url ); ?>">
                                                                            <span><?php esc_html_e( $time ); ?></span>
                                                                        </a>
                                                                    </li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
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