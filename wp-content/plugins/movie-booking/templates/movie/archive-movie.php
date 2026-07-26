<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

get_header();

$template       =  isset( $_GET['template'] ) ? sanitize_text_field( $_GET['template'] ) : MB()->options->movie->get('archive_template', 'template1');
$number_column  =  isset( $_GET['number_column'] ) ? sanitize_text_field( $_GET['number_column'] ) : MB()->options->movie->get('archive_number_column', 'three_column');

?>

    <div class="row_site">
        <div class="container_site">

            <div class="ova_movie_archive">

                <div class="movie_archive_content <?php echo esc_attr( $number_column ) ?>">
                         
                    <?php if( have_posts() ) : while ( have_posts() ) : the_post();

                        if( $template === 'template1' ) {
                            mb_get_template( 'parts/item-template1.php' );

                        } elseif( $template === 'template2' ) {
                            mb_get_template( 'parts/item-template2.php' );

                        } elseif( $template === 'template3' ) {
                            mb_get_template( 'parts/item-template3.php', $args );

                        } elseif( $template === 'template4' ) {
                            mb_get_template( 'parts/item-template4.php', $args );

                        } else {
                            mb_get_template( 'parts/item-template1.php' );
                        }

                    endwhile; endif; wp_reset_postdata(); ?>
                    
                </div>

                <?php 
                    $args = array(
                        'type'      => 'list',
                        'next_text' => '<i class="ovaicon-next"></i>',
                        'prev_text' => '<i class="ovaicon-back"></i>',
                    );

                    the_posts_pagination($args);
                 ?>
               
            </div>

        </div>
    </div>

<?php get_footer(); ?>