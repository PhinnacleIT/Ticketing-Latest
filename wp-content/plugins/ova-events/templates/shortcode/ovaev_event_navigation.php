<?php if ( !defined( 'ABSPATH' ) ) exit(); 

	$id 		= $args['id'];
	$class 		= $args['class'];
	global $post;
	$post 		= get_post( $id );
	$prev_post 	= get_previous_post();
	$next_post 	= get_next_post();
?>

<?php if ( $next_post || $prev_post ): ?>
<div class="single_event ovaev-shortcode-navigation<?php echo ' '.esc_html( $class ); ?>">
	<div class="content-event">
		<div class="ova-next-pre-post">	
		<?php if ( $prev_post ): ?>
			<a class="pre" href="<?php echo esc_attr( get_permalink( $prev_post->ID ) ); ?>">
				<span class="num-1">
					<span class="icon"><i class="arrow_carrot-left"></i></span>
				</span>
				<span  class="num-2">
					<span  class="second_font title" ><?php echo esc_html( get_the_title( $prev_post->ID ) ); ?></span>
				</span>
			</a>
		<?php endif; ?>

		<a class="ova-slash" href="<?php echo get_post_type_archive_link('event') ?>">
			<?php if ( $prev_post && $next_post ): ?>
				<span></span>
				<span></span>
				<span></span>
			<?php endif; ?>
		</a>
		
		<?php if ( $next_post ): ?>
			<a class="next" href="<?php echo esc_attr( get_permalink( $next_post->ID ) ); ?> ">
				<span class="num-1">
					<span class="icon" ><i class="arrow_carrot-right"></i></span>
				</span>
				<span  class="num-2">
					<span class="second_font title" ><?php echo esc_html( get_the_title( $next_post->ID ) ); ?></span>
				</span>
			</a>
		<?php endif; ?>
	</div>
	</div>
</div>
<?php endif; ?>