<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

    $number_column = isset($args['number_column']) ? $args['number_column'] : 'four_column';

    if ( is_singular('movie') ) {
        $current_movie_id = get_the_id();
        $terms = wp_get_post_terms( $current_movie_id, 'movie_cast', array( 'orderby' => 'ID', 'order' => 'ASC' ) );
    } else {
        $args_taxonomy = array('orderby' => $orderby, 'order' => $order, 'number' => $total_number, 'hide_empty' => true); 
        $terms = get_terms( 'movie_cast', $args_taxonomy );
    }

?>

<div class="mb-movie-cast-list <?php echo esc_attr($number_column);?>">

	<?php if (is_array($terms)) : foreach ($terms as $term) : ?>
        <?php
            $thumbnail_id   = get_term_meta($term->term_id, 'thumbnail_id', true);
            $thumbnail_url  = wp_get_attachment_url($thumbnail_id) ? wp_get_attachment_url($thumbnail_id) : wc_placeholder_img_src('thumbnail');
            $name           = $term->name;
            $description    = $term->description;
        ?>
        <div class="movie-cast-item">
            <div class="cast-thumbnail">
                <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo esc_html($name); ?>">
            </div>
            <div class="cast-info">
                <h4 class="cast-name"><?php echo esc_html($name); ?></h4>
                <p class="cast-description">
                    <?php echo esc_html($description); ?>
                </p>
            </div>
        </div>
    <?php endforeach; endif; ?>

</div>