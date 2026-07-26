<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

?>

<input 
    name="<?php echo esc_attr( $this->get_field_name( $field['name'] ) ); ?>" 
    value="<?php echo $this->get( $field['name'], $field['default'] ); ?>"
    <?php echo $this->render_atts( $field['atts'] ); ?> 
    autocomplete="off" />