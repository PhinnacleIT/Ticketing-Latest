<div class="row_site">
	<div class="container_site">
		<div id="main-content" class="main">
			<?php					
			if ( have_posts() ) : while ( have_posts() ) : the_post();

					if( apply_filters( 'aovis_show_singular_title', true ) ){ ?>
						<header class="page-header">
							<h1 class="page-title">
								<?php the_title();?>
							</h1>
						</header>
					<?php } ?>
						<article id="post-<?php the_ID(); ?>" <?php post_class('post-wrap '); ?>  >
					<?php
						the_content();
					
						wp_link_pages( array(
							'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'aovis' ) . '</span>',
							'after'       => '</div>',
							'link_before' => '<span>',
							'link_after'  => '</span>',
							'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'aovis' ) . ' </span>%',
							'separator'   => '',
						) );
					?>
						</article>
					<?php

			    		if ( comments_open() ) comments_template( '', true );

				endwhile; else : ?>
			        <p>
			        	<?php esc_html_e('Sorry, no pages matched your criteria.', 'aovis'); ?>
			        </p>
			<?php endif; ?>	

		</div>
		<?php get_sidebar(); ?>
	</div>
</div>
