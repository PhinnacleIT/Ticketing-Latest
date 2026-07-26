<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}


$multiple = false;
if ( isset( $field['atts'], $field['atts']['multiple'] ) && $field['atts']['multiple'] ) {
    $multiple = true;
}

?>

<select name="<?php echo esc_attr( $this->get_field_name( $field['name'] ) ) . ( $multiple ? '[]' : '' ); ?>"<?php echo $this->render_atts( $field['atts'] ); ?> >
    
    <?php if ( mb_dropdown_wc_products() ): ?>
        <?php foreach ( mb_dropdown_wc_products() as $key => $value ):
            $name = $this->get( $field['name'] );
            if ( empty( $name ) && isset( $field['default'] ) ) {
                $name = $field['default'];
            }
            ?>

            <?php if ( $multiple ): ?>
                <!--Multi select-->
                <option value="<?php echo esc_attr( $key ); ?>"<?php echo in_array( $key, $name ) ? ' selected="selected"' : ''; ?>>
                    <?php printf( '%s', $value ); ?>
                </option>
                <?php else: ?>
                    <option value="<?php echo esc_attr( $key ); ?>"<?php echo $name == $key ? ' selected="selected"' : ''; ?>>
                        <?php printf( '%s', $value ); ?>
                    </option>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
</select>