<?php $blog_template = apply_filters( 'aovis_blog_template', '' ); ?>
<div class="row_site">
	<div class="container_site">
		<div id="main-content" class="main">
			
			<div class="blog_<?php echo esc_attr($blog_template); ?>">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			        <?php  get_template_part( 'template-parts/blog/'.$blog_template ); ?>
			        
				<?php endwhile; ?>
			</div>

		    <div class="pagination-wrapper">
		    	<?php 
		    		 $args = array(
		                'type'      => 'list',
		                'next_text' => '<i class="ovaicon-next"></i>',
		                'prev_text' => '<i class="ovaicon-back"></i>',
		            );

		            the_posts_pagination($args);
		    	 ?>
			</div>

			<?php else : ?>
			        <?php get_template_part( 'template-parts/content/content-none' ); ?>
			<?php endif; ?>
			
		</div>
		<?php get_sidebar(); ?>
	</div>
</div>