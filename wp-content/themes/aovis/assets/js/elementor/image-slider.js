(function($){
	"use strict";
	
	$(window).on('elementor/frontend/init', function () {
		
        elementorFrontend.hooks.addAction('frontend/element_ready/aovis_elementor_image_slider.default', function(){
	       
	        /* Add your code here */
	        $(".slider-images").each(function(){     	
	     
		        var owlsl 		= $(this);
		        var owlsl_ops 	= owlsl.data('options') ? owlsl.data('options') : {};
                
                if ( owlsl_ops.items >= 5 ) {
                	var responsive_value = {
			            0:{
			                items:1,
			                nav:false,
			            },
			            430:{
			              	items:2,
			            },
			            768:{
			              	items:owlsl_ops.items - 2,
			            },
			            1024:{
			              	items:owlsl_ops.items - 1,
			            },
			            1200:{
			              	items:owlsl_ops.items,
			            }
			        };
                } else {
                	var responsive_value = {
			            0:{
			                items:1,
			                nav:false,
			            },
			            430:{
			              	items:2,
			            },
			            1024:{
			              	items:owlsl_ops.items - 1,
			            },
			            1200:{
			              	items:owlsl_ops.items,
			            }
			        };
                }      
		        
		        owlsl.owlCarousel({
		         	autoWidth: owlsl_ops.autoWidth,
		          	margin: owlsl_ops.margin,
		          	items: owlsl_ops.items,
		          	loop: owlsl_ops.loop,
		          	autoplay: owlsl_ops.autoplay,
		          	autoplayTimeout: owlsl_ops.autoplayTimeout,
		          	center: owlsl_ops.center,
		          	nav: false,
		          	dots: owlsl_ops.dots,
		          	thumbs: owlsl_ops.thumbs,
		          	autoplayHoverPause: owlsl_ops.autoplayHoverPause,
		          	slideBy: owlsl_ops.slideBy,
		          	smartSpeed: owlsl_ops.smartSpeed,
		          	rtl: owlsl_ops.rtl,
		          	responsive: responsive_value,
		        });

		      	/* Fixed WCAG */
				
				owlsl.find(".owl-dots button").attr("title", "Dots");

				owlsl.parent().find(".customNavigation.prev_next .next").click(function () {
				    owlsl.trigger('next.owl.carousel');
				});

				owlsl.parent().find(".customNavigation.prev_next .prev").click(function () {
				    owlsl.trigger('prev.owl.carousel');
				});
				 
				owlsl.trigger('owl.play', false);

		    });
	    	
        });
        
   });

})(jQuery);
