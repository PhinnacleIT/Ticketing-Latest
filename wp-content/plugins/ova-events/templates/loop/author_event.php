<?php if ( !defined( 'ABSPATH' ) ) exit();

	if ( isset( $args['id'] ) ) {
		$id = $args['id'];
	} else {
		$id = get_the_id();	
	}
	
	global $post;
	$author_id = $post->post_author;

?>

<div class="author">
	<i class="fas fa-user-circle icon_event"></i>
	<a href="<?php echo get_author_posts_url( $author_id ); ?>">
		<?php the_author_meta( 'display_name', $author_id ); ?>
	</a>
</div>

