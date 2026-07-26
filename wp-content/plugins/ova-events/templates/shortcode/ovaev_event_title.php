<?php if ( !defined( 'ABSPATH' ) ) exit(); 

	$id 	= $args['id'];
	$class 	= $args['class'];
	$title 	= get_the_title( $id );
?>

<?php if ( $title ): ?>
	<h2 class="second_font ovaev-shortcode-title<?php echo ' '.esc_html( $class ); ?>">
		<a href="<?php echo get_the_permalink( $id );?>">
			<?php echo esc_html( $title ); ?>
		</a>
	</h2>
<?php endif; ?>