<?php if ( !defined( 'ABSPATH' ) ) exit(); 

	$id 		= $args['id'];
	$class 		= $args['class'];
	$content 	= apply_filters('the_content', get_post_field('post_content', $id));
?>

<?php if ( $content ): ?>
	<div class="ovaev-shortcode-content<?php echo ' '.esc_html( $class ); ?>">
		<?php echo $content; ?>
	</div>
<?php endif; ?>