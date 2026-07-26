<div class="page_404">
	<div class="row_site">
		<div class="container_site">

			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/404/image-404.png">

			<div class="message">

				<h3 class="title"><?php esc_html_e( "Sorry we can't find that page!" , 'aovis' ); ?></h3> 

				<p class="content"><?php esc_html_e( "The page you are looking for was never existed." , 'aovis' ); ?></p> 

			</div>

			<?php get_search_form(); ?>	

			<div class="btn-back-home">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php esc_html_e( 'Back to Home', 'aovis' ); ?>
				</a>
			</div>

		</div>
	</div>
</div>

