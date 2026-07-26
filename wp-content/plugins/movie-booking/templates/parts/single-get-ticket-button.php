<?php if( ! defined( 'ABSPATH' ) ) exit();

    $id = get_the_ID();
    
    $custom_link = get_post_meta( $id, 'ova_mb_movie_custom_link_get_ticket', true );
    
    $text_get_ticket = MB()->options->general->get('mb_text_get_ticket', 'Get Ticket');
    if ( empty($text_get_ticket) ) {
        $text_get_ticket = esc_html__('Get Ticket','moviebooking');
    }

?>

<?php if( !empty($custom_link) ) { ?>
    <a href="<?php echo esc_url($custom_link); ?>" target="_blank">
        <button class="btn btn-custom-link">
            <?php echo esc_html($text_get_ticket); ?>
        </button> 
    </a>
<?php } else { ?>
    <button class="btn btn-booking" data-movie-id="<?php esc_attr_e( $id ); ?>">
        <?php echo esc_html($text_get_ticket); ?>
    </button>
<?php } ?>