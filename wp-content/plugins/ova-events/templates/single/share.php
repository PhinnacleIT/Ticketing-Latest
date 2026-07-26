<?php if ( !defined( 'ABSPATH' ) ) exit();

if( has_filter( 'ovaev_share_social' ) ){ ?>
    <div class="share_social">
    	<?php echo apply_filters('ovaev_share_social', get_the_permalink(), get_the_title() ); ?>
    </div>
<?php } ?>