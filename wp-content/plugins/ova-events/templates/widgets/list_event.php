<?php if ( !defined( 'ABSPATH' ) ) exit();

 $time_format = OVAEV_Settings::archive_event_format_time();
 $list_event = $args['list_events'];

        if ($list_event) {
            ?>
            <div class="list-event">
            <?php
            foreach ( $list_event as $event ) {
                $id = $event->ID;
                $title = get_the_title( $id );


                $url_img = get_the_post_thumbnail_url( $id, 'post-thumbnail' );
                $link = get_the_permalink( $id );

                $ovaev_start_date = get_post_meta( $id, 'ovaev_start_date_time', true );
                $ovaev_end_date   = get_post_meta( $id, 'ovaev_end_date_time', true );

                $date_start    = $ovaev_start_date != '' ? date_i18n(get_option('date_format'), $ovaev_start_date) : '';
                $date_end      = $ovaev_end_date != '' ? date_i18n(get_option('date_format'), $ovaev_end_date) : '';

                $time_start = $ovaev_start_date != '' ? date_i18n( $time_format, $ovaev_start_date) : '';
                $time_end = $ovaev_end_date != '' ? date_i18n( $time_format, $ovaev_end_date) : '';

                ?>

                    <div class="item-event">
                       <div class="ova-thumb-nail">
                           <a href="<?php echo $link ?>" style="background-image:url(<?php echo esc_url( $url_img ) ?>)">
                           </a>
                       </div>
                       <div class="ova-content">
                           <h3 class="title">
                               <a class="second_font" href="<?php echo $link ?>">
                                   <?php echo $title ?>
                               </a>
                           </h3>
                            <?php if( $date_start == $date_end && $date_start != '' ){ ?>
                              <span class="time">
                                <span class="date">
                                  <?php echo esc_html( $date_start ).' - '.$time_end; ?>
                                </span>
                              </span>
                            <?php }else{ ?>
                              <span class="time">
                                <span class="date">
                                  <?php echo esc_html( $date_start ) .' '. esc_html__( '@', 'ovaev' ); ?>
                                </span>

                                <span> <?php echo esc_html( $time_start ); ?></span>

                                <?php if( apply_filters( 'ovaev_show_more_date_text', true ) ){ ?>
                                  <a href="<?php the_permalink() ?> " class="more_date_text" data-id="<?php echo get_the_id(); ?>">
                                    <span><?php esc_html_e( ', more', 'ovaev' ); ?></span>  
                                  </a>
                                <?php } ?>
                            
                            </span>
                            <?php } ?>
                       </div>
                    </div>


                <?php                                   
            }
            ?>
            </div>
            <div class="button-all-event">
                <a class="second_font" href="<?php echo esc_url( apply_filters('ovaev_upcomming_event_url', get_post_type_archive_link( 'event' ))); ?>">
                    <?php esc_html_e( 'View All Events', 'ovaev' ) ?>
                    <i data-feather="chevron-right"></i>
                </a>
            </div>
            <?php
        }
