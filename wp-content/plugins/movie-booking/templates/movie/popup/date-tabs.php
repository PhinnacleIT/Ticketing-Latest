<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

$flag       = 0;
$dates      = array();
$date_id    = '';
$date_time_format = MBC()->mb_get_date_time_format();

if ( ! empty( $args ) && is_array( $args ) ): ?>
    <ul class="toggle-tabs mb-date-tabs">
    <?php foreach( $args as $date => $item ):
        array_push( $dates , $date );
        $current = '';

        if ( $flag == 0 ) {
            $current = 'current';
            $date_id = $date;
        }
    ?>
        <li class="<?php esc_attr_e( $current ); ?>">
            <div class="day" data-date="<?php esc_attr_e( $date ); ?>">
                <span class="D_m_day">
                    <span class="m_day"><?php esc_attr_e( date( 'm', $date ) ); ?></span>
                    <span class="D_day"><?php esc_attr_e( date( 'D', $date ) ); ?></span>
                </span>
                <span class="d_day">
                    <strong><?php esc_attr_e( date( 'd', $date ) ); ?></strong>
                </span>
            </div>
        </li>
    <?php $flag++; endforeach; ?>
    </ul>

    <?php # Get Showtime ?>
    <?php if ( ! empty( $dates ) && is_array( $dates ) ): ?>
    <dl class="collateral-tabs">
        <?php foreach( $dates as $k => $date ):
            $current = '';

            if ( $date_id == $date ) {
                $current = ' current';
            }
        ?>
            <dt class="tab<?php esc_attr_e( $current ); ?>" data-date="<?php esc_attr_e( $date ); ?>">
                <?php esc_html_e( date( $date_time_format, $date ) ); ?>
            </dt>
            <dd class="tab-container<?php esc_attr_e( $current ); ?>">
                <?php if ( $k == 0 ): ?>
                    <div class="tab-content mb-showtimes">
                        <?php mb_get_template( 'movie/popup/city-tabs.php', array( 
                            'date_id'           => $date_id, 
                            'data_showtime'     => $args,
                        )); ?>
                    </div>
                <?php else: ?>
                    <div class="tab-content mb-showtimes"></div>
                <?php endif; ?>
            </dd>
        <?php endforeach; ?>
    </dl>
<?php endif; ?>
<?php endif; ?>