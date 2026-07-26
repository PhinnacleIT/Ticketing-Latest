<?php if ( !defined( 'ABSPATH' ) ) exit(); 

	$id 	= $args['id'];
	$class 	= $args['class'];
?>

<div class="ovaev-shortcode-share<?php echo ' '.esc_html( $class ); ?>">
	<?php echo apply_filters('ovaev_share_social', get_the_permalink(), get_the_title() ); ?>
</div>