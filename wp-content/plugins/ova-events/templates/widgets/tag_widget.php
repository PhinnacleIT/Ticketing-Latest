<?php if ( !defined( 'ABSPATH' ) ) exit();

 $categories = $args['categories'];

 if ($categories) {
            ?>
            <div class="tagcloud">
            <?php
            foreach ( $categories as $cate ) {
                ?>

                    <a class="tag-cloud-link" href="<?php echo esc_url( get_term_link( $cate->term_id ) ) ?>">
                        <?php echo esc_html( $cate->cat_name ) ?>
                    </a>

                <?php                                   
            }
            ?>
            </div>
            <?php
        }