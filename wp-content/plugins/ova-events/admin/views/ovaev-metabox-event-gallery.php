<?php

if( !defined( 'ABSPATH' ) ) exit();

global $post;

$post_id = isset( $_REQUEST['post'] ) ? $_REQUEST['post'] : '';
$ovaev_gallery_id = get_post_meta( $post_id, 'ovaev_gallery_id', true); 


?>
<div class="ovaev_metabox">

	<a class="gallery-add button button button-primary button-large text-right" href="javascript:void(0)" data-uploader-title=<?php esc_html_e( "Add image(s) to gallery", "ovaev" ); ?>" data-uploader-button-text="Add image(s)"><?php esc_html_e( "Add image(s)", "ovaev" ); ?></a>


	<ul id="gallery-metabox-list">
		<?php if ($ovaev_gallery_id) : foreach ($ovaev_gallery_id as $key => $value) : $image = wp_get_attachment_image_src($value); ?>
			<li>
				<input type="hidden" name="ovaev_gallery_id[<?php echo $key; ?>]" value="<?php echo esc_attr($value); ?>">
				<img class="image-preview" src="<?php echo $image[0]; ?>">
				<a class="change-image button button-small" href="#" data-uploader-title="Change image" data-uploader-button-text="Change image"><?php esc_html_e( "Change image", "ovaev" ); ?></a>
				<small><a class="remove-image" href="#"><?php esc_html_e( "Remove image", "ovaev" ); ?></a></small>
			</li>

		<?php endforeach; endif; ?>
		
	</ul>
</div>

<?php wp_nonce_field( 'ovaev_nonce', 'ovaev_nonce' ); ?>