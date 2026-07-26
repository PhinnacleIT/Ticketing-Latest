<?php if( ! defined( 'ABSPATH' ) ) exit();
	
	if ( isset( $args['id'] ) && $args['id'] ) {
		$id = $args['id'];
	} else {
		$id = get_the_id();
	}

	// featured image
    $thumbnail   = wp_get_attachment_image_url( get_post_thumbnail_id( $id ),'aovis_thumbnail' );
    if( $thumbnail == '') {
    	$thumbnail  =  \Elementor\Utils::get_placeholder_image_src();
	}

?>

	<div class="mb-movie-item item-template4">
        
        <a href="<?php the_permalink();?>" title="<?php the_title(); ?>">
			<div class="movie-image">
				<img src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php the_title(); ?>">
			</div>
		</a>

		<div class="movie-info">
            
			<?php if ( mb_movie_release_date_has_arrived($id) ) {
				mb_get_template( 'parts/single-get-ticket-button.php' ); 
			} else {
				mb_get_template( 'parts/watch-trailer-button.php' );
			} ?>
	        
	        <a href="<?php the_permalink();?>" title="<?php the_title(); ?>">
		        <h3 class="movie-title">
					<?php the_title(); ?>
				</h3>
			</a>
			
		</div>			

	</div>