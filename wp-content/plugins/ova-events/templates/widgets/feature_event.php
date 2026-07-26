<?php if ( !defined( 'ABSPATH' ) ) exit();

// Get List Event *
$list_event = $args['events'];

if ($list_event) { ?>
    
    <div class="event-feature slide-event-feature owl-carousel owl-theme">

        <?php
        foreach ( $list_event as $event ) {

            $id = $event->ID;
        ?>

            <div class="ovaev-content" >

                <div class="item">
                    
                    <!-- Display Highlight Date 2 -->
                    <?php do_action( 'ovaev_loop_highlight_date_2', $id ); ?>

                    <div class="desc">

                        
                        <!-- Thumbnail -->
                        <?php do_action( 'ovaev_loop_thumbnail_grid', $id ); ?>

                        <div class="event_post">
                            
                            <!-- Taxonomy Type -->
                            <?php  do_action( 'ovaev_loop_type', $id ); ?>

                            <!-- Tille -->
                            <?php do_action( 'ovaev_loop_title', $id ); ?>

                            

                            <div class="time-event">
                                

                                <!-- Date -->
                                <?php do_action( 'ovaev_loop_date_event', $id ); ?>

                                
                                <!-- Tille -->
                                <?php do_action( 'ovaev_loop_venue', $id ); ?>

                            </div>
                            

                            <!-- Read More Button -->
                            <?php do_action( 'ovaev_loop_readmore_2', $id ); ?>

                        </div>

                    </div>

                </div>

            </div>


        <?php } ?>

    </div>

    <?php
}