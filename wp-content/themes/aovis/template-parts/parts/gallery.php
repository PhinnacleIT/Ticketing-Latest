<?php

	$post_id = get_the_ID();

	$gallery = get_post_meta($post_id, 'ova_met_gallery_id', true) ? get_post_meta($post_id, 'ova_met_gallery_id', true) : '';

	$carousel_id = 'carousel'.$post_id.'gallery';

	$k = 0;
	if($gallery){ $i=0; ?>

	    <div id="<?php echo esc_attr($carousel_id); ?>" 
	    	class="owl-carousel slide_gallery" 
	    	data-autoplay="true"
	    	data-autoplaytimeout="5000" 
	    	data-autoplayspeed="500"
	    	data-stoponhover="true"
	    	data-loop="true"
	    	data-dots="true"
	    	data-nav="false"
	    	data-items="1"
	    >

		  	<?php foreach ($gallery as $key => $value) { $active_dot = ( $k == 0 ) ? 'active' : ''; ?>
			    <div class="carousel-item <?php echo esc_attr($active_dot); $k++; ?>">
			    	<?php echo wp_get_attachment_image($value, 'large'); ?>
			    </div>
		   	<?php } ?>
		</div>
	   
	    <?php
	}
