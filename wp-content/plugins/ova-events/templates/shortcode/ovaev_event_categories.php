<?php if ( !defined( 'ABSPATH' ) ) exit(); 

	$id 	= $args['id'];
	$class 	= $args['class'];
	$icon 	= $args['icon'];

	$categories = get_the_terms( $id, 'event_category' );
	$separator 	= esc_html( ', ', 'ovaev' ); 
?>

<?php if ( ! empty( $categories ) && is_array( $categories ) ):
	$count 	= count( $categories );
	$i 		= 1;
?>
	<div class="ovaev-shortcode-categories<?php echo ' '.esc_html( $class ); ?>">
		<i class="<?php echo esc_attr( $icon ); ?>"></i>
		<?php foreach ( $categories as $category ):
			if ( $i == $count ) {
				$separator = '';
			}
			$link 		= get_term_link( $category->term_id );
			$name 		= $category->name;
		?>
		<span class="event-category">
	    	<a class="second_font" href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $name ); ?></a>
		</span>
	    <span class="separator">
	        <?php echo esc_html( $separator ); ?>
	    </span>
		<?php $i++; endforeach; ?>
	</div>
<?php endif; ?>