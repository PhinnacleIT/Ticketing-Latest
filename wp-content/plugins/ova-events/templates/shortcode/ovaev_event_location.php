<?php if ( !defined( 'ABSPATH' ) ) exit(); 

	$id 	= $args['id'];
	$class 	= $args['class'];
	$icon 	= $args['icon'];

	$venue 	= get_post_meta( $id, 'ovaev_venue', true);
?>

<?php if ( ! empty( $venue ) ): ?>
	<div class="ovaev-shortcode-location<?php echo ' '.esc_html( $class ); ?>">
		<i class="<?php echo esc_attr( $icon ); ?>"></i>
		<span class="second_font"><?php echo esc_html( $venue ); ?></span>
	</div>
<?php endif; ?>