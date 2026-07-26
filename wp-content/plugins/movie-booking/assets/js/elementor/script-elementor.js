(function($){
	"use strict";
	

	$(window).on('elementor/frontend/init', function () {

		/* Movie slider */ 
		elementorFrontend.hooks.addAction('frontend/element_ready/movie_slider.default', function(){

			$(".mb-movie-slider").each(function(){
		        var owlsl      = $(this) ;
		        var owlsl_ops  = owlsl.data('options') ? owlsl.data('options') : {};

		        if( owlsl_ops.items >=5 ) {
		        	var responsive_value = {
			            0:{
	                        items:1,
	                        dots: true,
	                        nav: false
	                    },
	                    767: {
	                    	items:2,
	                    },
	                    1024:{
	                        items:owlsl_ops.items - 2,
	                    },
	                    1200:{
	                        items:owlsl_ops.items - 1,
	                    },
	                    1390:{
	                        items:owlsl_ops.items
	                    }
			        };
		        } else {
		        	var responsive_value = {
			            0:{
	                        items:1,
	                        dots: true,
	                        nav: false
	                    },
	                    767: {
	                    	items:2,
	                    },
	                    1024:{
	                        items:owlsl_ops.items - 1,
	                    },
	                    1290:{
	                        items:owlsl_ops.items
	                    }
			        };
		        }
		       
		        
		        owlsl.owlCarousel({
		            margin: owlsl_ops.margin,
		            items: owlsl_ops.items,
		            loop: owlsl_ops.loop,
		            autoplay: owlsl_ops.autoplay,
		            autoplayTimeout: owlsl_ops.autoplayTimeout,
		            nav: owlsl_ops.nav,
		            dots: owlsl_ops.dots,
		            autoplayHoverPause: owlsl_ops.autoplayHoverPause,
		            slideBy: owlsl_ops.slideBy,
		            smartSpeed: owlsl_ops.smartSpeed,
		            rtl: owlsl_ops.rtl,
		            navText:[
			            '<i class="ovaicon ovaicon-back"></i>',
			            '<i class="ovaicon ovaicon-next"></i>'
		            ],
		            responsive: responsive_value,
		        });

		      	/* Fixed WCAG */
				owlsl.find(".owl-nav button.owl-prev").attr("title", "Previous");
				owlsl.find(".owl-nav button.owl-next").attr("title", "Next");
				owlsl.find(".owl-dots button").attr("title", "Dots");

		    });
		});

        
        /* Movie main slider */ 
		elementorFrontend.hooks.addAction('frontend/element_ready/movie_main_slider.default', function(){

		  	$(".mb-movie-main-slider").each(function(){
        		var movies_content = $(this);
        		var data_options   = movies_content.data('options') ? movies_content.data('options') : {};
        		var asNavFor = '';

        		if( $('.mb-movie-trailer-slider').length ){
				   asNavFor = '.mb-movie-trailer-slider';
				}

			    movies_content.slick({
					infinite: data_options.loop,
					slidesToShow: 1,
					slidesToScroll: 1,
					arrows: false,
					fade: false,
					adaptiveHeight: true,
					autoplay: data_options.autoplay,
					autoplaySpeed: data_options.autoplay_speed,
					speed: data_options.smartSpeed,
					rtl: data_options.rtl,
					asNavFor: asNavFor,
					lazyLoad: 'ondemand'
				});

				movies_content.parent().css({'visibility':'visible','opacity':1});
			    movies_content.find('.slideshow-image').css('visibility','visible');
                
                // avoid break layout when window resize
				$(window).resize(function(){
				  	movies_content.slick('setPosition');
				});
        		
        	});


        	$(".mb-movie-trailer-slider").each(function(){
        		var movie_trailer 	= $(this);
        		var data_options 	= movie_trailer.data('options') ? movie_trailer.data('options') : {};
        		var template        = data_options.template;
        		var vertical        = false;

        		var responsive = [
				    {
						breakpoint: 1200,
						settings: {
							slidesToShow: data_options.items
						}
					},
				    {
						breakpoint: 768,
						settings: {
							slidesToShow: data_options.items
						}
				    }
			  	];

			  	if (template == 'template2' || template == 'template3' ) {
			  		var responsive = [
					    {
							breakpoint: 1200,
							settings: {
								slidesToShow: data_options.items - 1,
								vertical : false,
							}
						},
					    {
							breakpoint: 768,
							settings: {
								slidesToShow: 2,
								vertical : false,
							}
					    }
				  	];
			  	}   

			  	if( template == 'template3' ) {
			  		vertical = true;
			  	}


        		movie_trailer.slick({
        			infinite: data_options.loop,
					slidesToShow: data_options.items,
					slidesToScroll: 1,
					arrows: false,
					dots: true,
					focusOnSelect: true,
					vertical : vertical,
					asNavFor: '.mb-movie-main-slider',
					responsive: responsive
				});

				movie_trailer.parent().css('display','block');

                // avoid break layout when window resize
				$(window).resize(function(){ 
					movie_trailer.slick('setPosition');
				});

				
        	});

        });

        /* Movie filter ajax */ 
		elementorFrontend.hooks.addAction('frontend/element_ready/movie_filter_ajax.default', function(){
            
            // click button filter ajax
		  	$(".mb-movie-filter-ajax-container").each(function(){

		  		$('.mb-button-filter-ajax .button-filter-ajax').on( 'click', function(e) {
	                e.preventDefault();

	                var that = $(this);
	                mb_load_movie_filter_ajax(that);
	            });

        	});

			function mb_load_movie_filter_ajax( that ) {
				if ( that != null ) {

		            // div for append response data
		            var movie_filter_ajax_content = that.closest('.mb-movie-filter-ajax-container').find('.mb-movie-filter-ajax');
		            
		            // data for query
		            var date_tabs = that.closest('.mb-date-tabs');
		            var template  = date_tabs.data('template');
		            var venue     = date_tabs.data('venue');
		            var total     = date_tabs.data('total');
		            var orderby   = date_tabs.data('orderby');
		            var order     = date_tabs.data('order');
		            
		            var date_min  = that.data('date_min');
		            var date_max  = that.data('date_max');

		            // Change class current in filter button 
		            that.parent().find('.current').removeClass('current');
		            that.addClass('current');

		            // Show spinner
		            $('.mb-movie-filter-ajax-container .mb-spinner').show();
		            
		            // ajax processing
		            $.post( ajax_object.ajax_url, {
		                action: 'mb_get_movie_filter_ajax',
		                data: {
		                    ajax_nonce: ajax_object.ajax_nonce,
		                    template: template,
		                    venue: venue,
		                    total: total,
		                    orderby: orderby,
		                    order: order,
		                    date_min: date_min,
		                    date_max: date_max,
		                },
		            }, function(response) {
		                // Hide spinner
		                $('.mb-movie-filter-ajax-container .mb-spinner').hide();
		                // append response data
		                movie_filter_ajax_content.html('').append(response);
		                // get ticket & watch trailer popup
		                window.MB_Frontend.mb_popup_showtime();
		                window.MB_Frontend.mb_trailer_video_popup();
		            });

		        }

			}

        });

	});


})(jQuery);
