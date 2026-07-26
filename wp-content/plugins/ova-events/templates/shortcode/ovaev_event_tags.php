<?php if ( !defined( 'ABSPATH' ) ) exit(); 

	$id 	= $args['id'];
	$class 	= $args['class'];
	$tags 	= get_the_terms( $id, 'event_tag' );
?>

<?php if ( $tags ): ?>
	<div class="ovaev-shortcode-tags<?php echo ' '.esc_html( $class ); ?>">
		<?php ovaev_get_tag_event_by_id( $id ); ?>
	</div>
<?php endif; ?>