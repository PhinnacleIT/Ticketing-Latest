
<?php 

if( !defined( 'ABSPATH' ) ) exit();

global $post;

?>


<div class="row">

	<div id="tabs">

		<ul>
			<li><a href="#metabox-event-basic"><?php esc_html_e( 'Basic', 'ovaev' ); ?> </a></li>
			<li><a href="#metabox-event-location" class=""><?php esc_html_e( 'Location', 'ovaev' ); ?></a></li>
			<li><a href="#metabox-event-contact" class=""><?php esc_html_e( 'Contact Details', 'ovaev' ); ?></a></li>
			<li><a href="#metabox-event-gallery" class=""><?php esc_html_e( 'Gallery', 'ovaev' ); ?></a></li>
		</ul>


		<!-- Basic Tab Content -->  
		<div id="metabox-event-basic">

			<?php require_once( OVAEV_PLUGIN_PATH.'/admin/views/ovaev-metabox-event-basic.php' ); ?>

		</div>

		<!-- Location -->  
		<div id="metabox-event-location">

			<?php require_once( OVAEV_PLUGIN_PATH.'/admin/views/ovaev-metabox-event-location.php' ); ?>

		</div>

		<!-- Contact Details -->  
		<div id="metabox-event-contact">

			<?php require_once( OVAEV_PLUGIN_PATH.'/admin/views/ovaev-metabox-event-contact.php' ); ?>

		</div>	


		<!-- Gallery -->  
		<div id="metabox-event-gallery">

			<?php require_once( OVAEV_PLUGIN_PATH.'/admin/views/ovaev-metabox-event-gallery.php' ); ?>

		</div>


	</div>

	<br/> 
</div>


<div id="dialogs">
	<!-- Ajax display here -->
</div>	


<?php wp_nonce_field( 'ovaev_nonce', 'ovaev_nonce' ); ?>