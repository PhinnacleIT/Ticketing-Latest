<?php if( ! defined( 'ABSPATH' ) ) exit();

	$id = get_the_ID();

	// gallery
	$movie_gallery_ids = get_post_meta($id, 'ova_met_gallery_id', true) ? get_post_meta($id, 'ova_met_gallery_id', true) : '';
    
    // featured movie image
	$url_movie_image   = wp_get_attachment_image_url(get_post_thumbnail_id() , 'large' );
	if ( $url_movie_image == '') {
	    $url_movie_image  =  \Elementor\Utils::get_placeholder_image_src();
	}

	// video trailer
	$text_trailer 	= MB()->options->movie->get('single_text_watch_trailer', 'Watch the Trailer');
	$embed_url  	= get_post_meta( $id, 'ova_mb_movie_trailer', true );

?>

	<?php if ( !empty($movie_gallery_ids) ) : $k = 1; ?>
		<?php foreach( $movie_gallery_ids as $gallery_id ):
			$gallery_alt   = get_post_meta($gallery_id, '_wp_attachment_image_alt', true);
    	    $gallery_title = get_the_title( $gallery_id );
    	    $gallery_url   = wp_get_attachment_image_url( $gallery_id, 'aovis_thumbnail' );
    	  
			if ( ! $gallery_alt ) {
				$gallery_alt = get_the_title( $gallery_id );
			}

			$hidden = ( $k > 1 ) ? ' gallery_hidden' : '';
			$blur 	= ( $k == 1 && count( $movie_gallery_ids ) > 1 ) ? ' gallery_blur' : '';

		?>
			<div class="movie-gallery<?php echo esc_attr( $hidden ); ?><?php echo esc_attr( $blur ); ?>">
				<a class="gallery-fancybox" 
					data-src="<?php echo esc_url( $gallery_url ); ?>" 
					data-fancybox="movie-gallery-fancybox" 
					data-caption="<?php echo esc_attr( $gallery_alt ); ?>">
  					<img src="<?php echo esc_url($gallery_url); ?>" alt="<?php echo esc_attr($gallery_alt); ?>" title="<?php echo esc_attr($gallery_title); ?>">
  					<?php if ( $blur ): ?>
  						<div class="blur-bg">
  							<span class="gallery-count">
  								<?php echo esc_html( '+', 'moviebooking' ) . esc_html( count( $movie_gallery_ids ) - 1 ); ?>
  							</span>
  						</div>
  					<?php endif; ?>
  				</a>
			</div>
		<?php $k = $k + 1 ; endforeach; ?>
	<?php endif; ?>

	<!-- Featured image -->
	<div class="movie-featured-image">
		<a class="gallery-fancybox" 
			data-src="<?php echo esc_url( $url_movie_image ); ?>" 
			data-fancybox="movie-gallery-fancybox" 
			data-caption="<?php the_title(); ?>">
			<img src="<?php echo esc_url( $url_movie_image ); ?>" alt="<?php the_title(); ?>">
		</a>

	    <!-- Button Watch trailer video in single -->
		<?php if ( $embed_url ): ?>
			<div class="btn-trailer-video-wrapper">
				<div class="btn-video btn-trailer-video" data-src="<?php echo esc_url( $embed_url ); ?>" data-movie-id="<?php echo esc_attr( $id ); ?>">
		            <i aria-hidden="true" class="fas fa-play"></i>
		        </div>
			</div>
            
            <?php if ( !empty($text_trailer) ): ?>
				<span class="text-trailer">
		        	<?php echo esc_html($text_trailer);?>
		        	<i aria-hidden="true" class="ovaicon ovaicon-diagonal-arrow"></i>
		        </span>
		    <?php endif; ?>
	    <?php endif; ?>

	</div>