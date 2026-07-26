<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

$bytes      = wp_max_upload_size();
$size       = size_format( $bytes );
$upload_dir = wp_upload_dir();

?>
<div class="mb-import-showtimes wrap">
    <div class="mb-heading">
        <h2 class="header"><?php esc_html_e( 'Import Showtimes', 'moviebooking' ); ?></h2>
    </div>
    <div class="import-form">
        <form class="import-showtimes" enctype="multipart/form-data" method="post">
            <h2 class="title"><?php esc_html_e( 'Import showtimes from a CSV file', 'moviebooking' ); ?></h2>
            <div class="import-showtimes-upload">
                <h4 for="upload">
                    <?php esc_html_e( 'Choose a CSV file from your computer:', 'moviebooking' ); ?>
                </h4>
                <input type="file" id="upload" name="showtimes_file" size="25">
                <input type="hidden" name="showtime_action" value="import">
                <input type="hidden" name="max_file_size" value="<?php echo esc_attr( $bytes ); ?>" />
                <br/>
                <span class="max-size">
                    <?php
                    printf(
                        esc_html__( 'Maximum size: %s', 'moviebooking' ),
                        esc_html( $size )
                    );
                    ?>
                </span>
                <a href="<?php echo esc_url( MB_PLUGIN_URI.'assets/libs/importers/demo.csv' ); ?>" class="demo" download>
                    <?php esc_html_e( 'demo.csv', 'moviebooking' ); ?>
                </a>
            </div>
            <div class="import-showtimes-submit">
                <button type="submit" class="button">
                    <?php esc_html_e( 'Import', 'moviebooking' ); ?>
                </button>
            </div>
            <div class="note">
                <hr>
                <label><?php esc_html_e( 'Note:', 'moviebooking' ); ?></label>
                <ul>
                    <li>
                        <span class="note-column"><?php esc_html_e( 'Title:', 'moviebooking' ); ?></span>
                        <span class="note-content"><?php esc_html_e( 'Showtime title', 'moviebooking' ); ?></span>
                    </li>
                    <li>
                        <span class="note-column"><?php esc_html_e( 'Status:', 'moviebooking' ); ?></span>
                        <span class="note-content"><?php esc_html_e( 'Showtime status', 'moviebooking' ); ?></span>
                    </li>
                    <li>
                        <span class="note-column"><?php esc_html_e( 'Movie ID:', 'moviebooking' ); ?></span>
                        <span class="note-content"><?php esc_html_e( 'Dashboard >> Movies', 'moviebooking' ); ?></span>
                    </li>
                    <li>
                        <span class="note-column"><?php esc_html_e( 'Date:', 'moviebooking' ); ?></span>
                        <span class="note-content"><?php esc_html_e( 'Showtime date', 'moviebooking' ); ?></span>
                    </li>
                    <li>
                        <span class="note-column"><?php esc_html_e( 'Room ID:', 'moviebooking' ); ?></span>
                        <span class="note-content"><?php esc_html_e( 'Dashboard >> Rooms', 'moviebooking' ); ?></span>
                    </li>
                    <li>
                        <span class="note-column"><?php esc_html_e( 'City ID:', 'moviebooking' ); ?></span>
                        <span class="note-content"><?php esc_html_e( 'Dashboard >> Showtimes >> Locations (parent of Venue IDs)', 'moviebooking' ); ?></span>
                    </li>
                    <li>
                        <span class="note-column"><?php esc_html_e( 'Venue ID:', 'moviebooking' ); ?></span>
                        <span class="note-content"><?php esc_html_e( 'Dashboard >> Showtimes >> Locations (child of City ID)', 'moviebooking' ); ?></span>
                    </li>
                    <li>
                        <span class="note-column"><?php esc_html_e( 'Address:', 'moviebooking' ); ?></span>
                        <span class="note-content"><?php esc_html_e( 'Showtimes address', 'moviebooking' ); ?></span>
                    </li>
                </ul>
            </div>
        </form>
    </div>
</div>