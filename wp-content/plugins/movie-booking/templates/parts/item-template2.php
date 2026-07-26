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

	// category
	$category = get_the_terms($id, 'movie_cat');

	// Running time
	$running_time = get_post_meta($id, 'ova_mb_movie_running_time', true); 

?>

	<div class="mb-movie-item item-template2">
        
        <a href="<?php the_permalink();?>" title="<?php the_title(); ?>">
			<div class="movie-image">
				<img src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php the_title(); ?>">
			</div>
		</a>

		<div class="movie-info">
	        
	        <a href="<?php the_permalink();?>" title="<?php the_title(); ?>">
		        <h3 class="movie-title">
					<?php the_title(); ?>
				</h3>
			</a>

			<div class="categories-and-time">
	            <?php if( ! empty( $category ) ) { ?>
	                <div class="movie-category">
	                    <?php 
	                        $arr_link = array();
	                        foreach( $category as $cat ) { 
	                            $category_link = get_term_link($cat->term_id);
	                            if ( $category_link ) {
	                                $link = '<a href="'.esc_url( $category_link ).'" title="'.esc_attr($cat->name).'">'.$cat->name.'</a>';
	                                array_push( $arr_link, $link );
	                            }
	                        }
	                        if ( !empty( $arr_link ) && is_array( $arr_link ) ) {
	                            echo join(', ', $arr_link);
	                        }
	                    ?>
	                </div>
	            <?php } ?>

	            <?php if( ! empty( $running_time ) ) { ?>
	                <span class="running-time">
	                    <?php echo esc_html( $running_time ); ?> 
	                </span>
	            <?php } ?>
	        </div>
            
            <div class="button-wrapper">
            	<?php mb_get_template( 'parts/watch-trailer-button.php' ); ?>
            	<?php if ( mb_movie_release_date_has_arrived($id) ) {
                    mb_get_template( 'parts/single-get-ticket-button.php' ); 
                } ?>
            </div>
			
		</div>			

	</div>