<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

?>

<?php if ( $field['options'] ): ?>
    <div <?php echo $this->render_atts( $field['atts'] ); ?>>
        <?php foreach ( $field['options'] as $key => $value ):
            $val = $this->get( $field['name'] );

            if ( empty( $val ) && isset( $field['default'] ) ) {
                $val = $field['default'];
            }

            ?>

            <label class="mb-checkbox">
                <?php printf( '%s', $value ); ?>
                <input 
                    type="radio" 
                    value="<?php echo esc_attr( $key ); ?>" 
                    name="<?php echo esc_attr( $this->get_field_name( $field['name'] ) ); ?>"
                    <?php echo ( $key == $val ) ? ' checked="checked"' : ''; ?> />
                <span class="checkmark"></span>
            </label>
        <?php endforeach; ?>
    </div>
<?php endif; ?>