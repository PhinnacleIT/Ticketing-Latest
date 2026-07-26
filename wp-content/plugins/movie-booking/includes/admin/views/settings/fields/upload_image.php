<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

$thumbnail_id   = $this->get( $field['name'], $field['default'] );
$src            = $alt = '';

if ( $thumbnail_id ) {
    $src = wp_get_attachment_image_url( $thumbnail_id, apply_filters( 'mb_ft_upload_image_size', 'thumbnail' ) );
    $alt = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
}

?>

<div class="mb-upload">
    <img src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( $alt ); ?>">
    <input 
        name="<?php echo esc_attr( $this->get_field_name( $field['name'] ) ); ?>" 
        value="<?php echo $this->get( $field['name'], $field['default'] ); ?>"
        <?php echo $this->render_atts( $field['atts'] ); ?> 
        autocomplete="off" />
    <button type="submit" class="upload_image_btn"><?php esc_html_e( 'Upload', 'moviebooking' ); ?></button>
    <button type="submit" class="remove_image_btn"><i class="dashicons-before dashicons-no-alt"></i></button>
</div>
