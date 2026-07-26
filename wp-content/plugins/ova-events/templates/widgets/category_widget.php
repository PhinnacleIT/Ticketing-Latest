<?php if ( !defined( 'ABSPATH' ) ) exit();

 $categories = $args['categories'];
 $count      = $args['count'];
?>

<?php if ($categories): ?>
    <ul>
        <?php foreach( $categories as $cate ): ?>
            <li>
                <a href="<?php echo esc_url( get_term_link( $cate->term_id ) ) ?>">
                    <?php echo esc_html( $cate->cat_name ) ?>
                </a>
                <?php if( $count == 1){ echo '('.esc_html( $cate->count ).')'; }?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
