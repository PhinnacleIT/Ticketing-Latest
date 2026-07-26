<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

global $post;

$showtime_id    = get_the_ID();
$showtime_url   = get_edit_post_link( $showtime_id ) ? get_edit_post_link( $showtime_id ) : '#';

$movies     = MB_Movie()->get_all_movie();
$rooms      = MB_Room()->get_room_with_taxonomy();
$city       = MBC()->mb_get_taxonomies( 'movie_location' );
$city_id    = $this->get_mb_value( 'city_id' );
$venues     = array();

if ( $city_id ) {
    $venues = MBC()->mb_get_taxonomies( 'movie_location', array(), array(), 'all', 0, $city_id );
}

$date_format = MBC()->mb_get_date_time_format();

?>

<div class="mb_showtime_detail">
    <div class="ova_row">
        <label>
            <strong><?php esc_html_e( 'Showtimes:', 'moviebooking' ); ?></strong>
            <?php printf( _x( '%s', 'showtime link', 'moviebooking' ), '<a href="'.esc_url( $showtime_url ).'" target="_blank">#'.esc_html( $showtime_id ).'</a>' ); ?>
        </label>
        <br><br>
    </div>
    <div class="ova_row">
        <label>
            <strong><?php echo esc_html__( 'Movie*', 'moviebooking' ) ?></strong>
        </label>
        <select name="<?php echo esc_attr( $this->get_mb_name( 'movie_id' ) ); ?>" class="showtime_movie_id mb_select2" data-placeholder="<?php esc_html_e( 'Choose movie', 'moviebooking' ); ?>" required>
            <?php if ( ! empty( $movies ) ): 
                $m_id       = $this->get_mb_value( 'movie_id' );
                $selected   = '';

                foreach( $movies as $movie_id ):
                    if ( $movie_id == $m_id ) {
                        $selected = ' selected';
                    } else {
                        $selected = '';
                    }
            ?>
                    <option value="<?php echo esc_attr( $movie_id ); ?>"<?php echo esc_html( $selected ); ?>>
                        <?php echo esc_html( get_the_title( $movie_id ) ); ?>
                    </option>
            <?php endforeach; endif; ?>
        </select>
        <br><br>
    </div>
    <div class="ova_row">
        <label>
            <strong><?php esc_html_e( 'Date*', 'moviebooking' ); ?></strong>
        </label>
        <input 
            type="text" 
            class="showtime_date mb_datepicker" 
            name="<?php echo esc_attr( $this->get_mb_name( 'date' ) ); ?>" 
            value="<?php echo $this->get_mb_value( 'date' ) ? esc_attr( date( $date_format, $this->get_mb_value( 'date' ) ) ) : ''; ?>" 
            placeholder="<?php echo esc_attr( date( $date_format, current_time( 'timestamp' ) ) ); ?>" 
            autocomplete="off" 
            autocorrect="off" 
            autocapitalize="none" 
            onfocus="blur();" 
            required />
        <input 
            type="hidden" 
            id="mb_datetimepicker_config"
            class="mb_datetimepicker_config"
            data-language="<?php echo esc_attr( MBC()->mb_get_language() ); ?>" 
            data-first-day="<?php echo esc_attr( MBC()->mb_get_first_day() ); ?>" 
            data-date-format="<?php echo esc_attr( MBC()->mb_get_date_format() ); ?>" 
            data-time-format="<?php echo esc_attr( MBC()->mb_get_time_format() ); ?>" 
            data-time-step="<?php echo esc_attr( MBC()->mb_get_time_step() ); ?>" 
            data-time-default="<?php echo esc_attr( MBC()->mb_get_time_default() ); ?>" />
        <br><br>
    </div>
    <div class="ova_row">
        <label>
            <strong><?php esc_html_e( 'Rooms*', 'moviebooking' ) ?></strong>
        </label>
        <select name="<?php echo esc_attr( $this->get_mb_name( 'room_ids' ).'[]' ); ?>" class="showtime_room_ids mb_select2" data-placeholder="<?php esc_html_e( 'Choose rooms', 'moviebooking' ); ?>" multiple required>
            <?php if ( ! empty( $rooms ) ): 
                $room_ids   = $this->get_mb_value( 'room_ids' );

                if ( empty( $room_ids ) ) {
                    $room_ids = array();
                }

                $selected   = '';

                foreach( $rooms as $type_id => $items ):
            ?>      <optgroup label="<?php echo esc_attr( $items['name'] ); ?>">
                        <?php foreach( $items['rooms'] as $room_id ):
                            if ( in_array( $room_id, $room_ids ) ) {
                                $selected = ' selected';
                            } else {
                                $selected = '';
                            }
                        ?>
                            <option value="<?php echo esc_attr( $room_id ); ?>"<?php echo esc_html( $selected ); ?>>
                                <?php echo esc_html( get_the_title( $room_id ) ); ?>
                            </option>
                        <?php endforeach; ?>
                    </optgroup>
            <?php endforeach; endif; ?>
        </select>
        <br><br>
    </div>
    <div class="ova_row">
        <label>
            <strong><?php esc_html_e( 'City*', 'moviebooking' ); ?></strong>
        </label>
        <select name="<?php echo esc_attr( $this->get_mb_name( 'city_id' ) ); ?>" class="showtime_city_id mb_select2" data-placeholder="<?php esc_html_e( 'Choose city', 'moviebooking' ); ?>" required>
            <option value=""><?php esc_html_e( 'Choose city', 'moviebooking' ); ?></option>
            <?php if ( $city ): 
                $city_id    = $this->get_mb_value( 'city_id' );
                $selected   = '';

                foreach( $city as $city_item ):
                    if ( $city_id == $city_item->term_id ) {
                        $selected = ' selected';
                    } else {
                        $selected = '';
                    }
            ?>
                    <option value="<?php echo esc_attr( $city_item->term_id ); ?>"<?php echo esc_html( $selected ); ?>>
                        <?php echo esc_html( $city_item->name ); ?>
                    </option>
            <?php endforeach; endif; ?>
        </select>
        <br><br>
    </div>
    <div class="ova_row">
        <label>
            <strong><?php esc_html_e( 'Venue*', 'moviebooking' ); ?></strong>
        </label>
        <div class="mb_generate_venue">
            <?php if ( ! empty( $venues ) && is_array( $venues ) ): 
                $venue_id   = $this->get_mb_value( 'venue_id' );
                $selected   = '';
            ?>
                <select name="<?php echo esc_attr( $this->get_mb_name( 'venue_id' ) ); ?>" class="showtime_city_id mb_select2" data-placeholder="<?php esc_html_e( 'Choose venue', 'moviebooking' ); ?>" required>
            <?php

                foreach( $venues as $venue ):
                    if ( $venue_id == $venue->term_id ) {
                        $selected = ' selected';
                    } else {
                        $selected = '';
                    }
            ?>  
                    <option value="<?php echo esc_attr( $venue->term_id ); ?>"<?php echo esc_html( $selected ); ?>>
                        <?php echo esc_html( $venue->name ); ?>
                    </option>
                <?php endforeach; ?>
                </select>
            <?php else: ?>
                <select name="<?php echo esc_attr( $this->get_mb_name( 'venue_id' ) ); ?>" class="showtime_city_id mb_select2" data-placeholder="<?php esc_html_e( 'Choose venue', 'moviebooking' ); ?>" required>
                </select>
            <?php endif; ?>
        </div>
        <div class="mb-loading">
            <i class="dashicons-before dashicons-update-alt"></i>
        </div>
        <br><br>
    </div>
    <div class="ova_row">
        <label>
            <strong><?php esc_html_e( 'Address', 'moviebooking' ); ?></strong>
        </label>
        <input 
            type="text" 
            class="showtime_address" 
            name="<?php echo esc_attr( $this->get_mb_name( 'address' ) ); ?>" 
            value="<?php echo $this->get_mb_value( 'address' ) ? esc_attr( $this->get_mb_value( 'address' ) ) : ''; ?>" 
            placeholder="<?php esc_html_e( 'Address', 'moviebooking' ); ?>" 
            autocomplete="off" 
            autocorrect="off" 
            autocapitalize="none" />
        <br><br>
    </div>
</div>