<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

?>

<ul class="mb-seat-instruction">
    <li class="available">
        <span class="box"></span>
        <span class="text"><?php esc_html_e( 'Available' ); ?></span>
    </li>
    <li class="booked">
        <span class="box"></span>
        <span class="text"><?php esc_html_e( 'Booked' ); ?></span>
    </li>
</ul>