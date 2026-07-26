<?php if ( !defined( 'ABSPATH' ) ) exit(); 

	$id 	= $args['id'];
	$class 	= $args['class'];

?>

<?php if ( $id ): ?>
	<div class="ovaev-shortcode-thumbnail<?php echo ' '.esc_html( $class ); ?>">	
		<a href="<?php echo get_the_permalink( $id ); ?>">
			<?php echo get_the_post_thumbnail( $id, 'ovaev_event_thumbnail' ); ?>
		</a>
	</div>
<?php endif; ?>