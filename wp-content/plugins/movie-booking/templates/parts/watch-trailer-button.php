<?php if( ! defined( 'ABSPATH' ) ) exit();

    $id = get_the_ID();

    // video trailer
    $text_trailer = MB()->options->general->get('mb_text_watch_trailer', 'Watch Trailer');
    $embed_url    = get_post_meta( $id, 'ova_mb_movie_trailer', true );

?>

    <!-- Button Watch Trailer video -->
    <?php if ( $embed_url ): ?>

        <div class="has-trailer">

            <div class="btn btn-trailer-video" data-src="<?php echo esc_url( $embed_url ); ?>" data-movie-id="<?php echo esc_attr( $id ); ?>">
                <span class="text-trailer">
                    <?php echo esc_html($text_trailer);?>
                </span>
                <i aria-hidden="true" class="fas fa-play"></i>
            </div>
            
        </div>
        
    <?php endif; ?>