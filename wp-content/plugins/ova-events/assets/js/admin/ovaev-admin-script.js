jQuery(function( $ ){

	'use strict';

	/***** Menu Tab *****/
	$( function() {
		$( "#tabs" ).tabs();
	} );
	/***** End Menu Tab *****/

	$( function() {
		jQuery(document).ready( function( $ ) {

		    $('#archive_event_bg_button').on( 'click', function() {

		        formfield = $('#archive_event_bg_upload').attr('name');
		        tb_show( '', 'media-upload.php?type=image&amp;TB_iframe=true' );
		        window.send_to_editor = function(html) {
		           imgurl = $(html).attr('src');
		           $('#archive_event_bg_upload').val(imgurl);
		           tb_remove();
		        }

		        return false;
		    });

		});
	})

	/***** Color Picker *****/
	$( function() {
		jQuery(document).ready(function($){
			$('.colorpick').wpColorPicker();
		});
	});
	/***** End Color Picker *****/

	$( function() {
		jQuery(document).ready( function( $ ) {

		    $('#single_event_bg_button').on( 'click', function() {

		        formfield = $('#single_event_bg_upload').attr('name');
		        tb_show( '', 'media-upload.php?type=image&amp;TB_iframe=true' );
		        window.send_to_editor = function(html) {
		           imgurl = $(html).attr('src');
		           $('#single_event_bg_upload').val(imgurl);
		           tb_remove();
		        }

		        return false;
		    });

		});
	})


	/***** Map *****/
	$( function($) {
		$.fn.ovaev_map = function( paramObject ){

			paramObject = $.extend( { lat: -33.8688, lng: 151.2195, zoom: 17 }, paramObject );

			var map_canvas = paramObject.id;
			var map = new google.maps.Map(document.getElementById('show_map'), {
				center: {
					lat: paramObject.lat,
					lng: paramObject.lng
				},
				zoom: paramObject.zoom,
				scrollwheel: true,
				draggable: true,
			});


			// alert('x');

			var input = document.getElementById('pac-input');

			var autocomplete = new google.maps.places.Autocomplete(input);
			autocomplete.bindTo('bounds', map);

			map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

			var mapIWcontent = $('#pac-input').val();
			var infowindow = new google.maps.InfoWindow({
				content: mapIWcontent,
			});

			var infowindowContent = document.getElementById('infowindow-content');

			var marker = new google.maps.Marker({
				map: map,
				position: map.getCenter()
			});
			marker.addListener('click', function() {
				infowindow.open(map, marker);
			});


			autocomplete.addListener('place_changed', function() {
				infowindow.close();
				var place = autocomplete.getPlace();
				if (!place.geometry) {
					return;
				}

				if (place.geometry.viewport) {
					map.fitBounds(place.geometry.viewport);
				} else {
					map.setCenter(place.geometry.location);
					map.setZoom(17);
				}

            	// Set the position of the marker using the place ID and location.
            	marker.setPlace({
            		placeId: place.place_id,
            		location: place.geometry.location
            	});
            	marker.setVisible(true);
            	infowindowContent.children['place-name'].textContent = place.name;
            	infowindowContent.children['place-address'].textContent = place.formatted_address;

            	$(".ovaev_map #ovaev_map_name").val(place.name);
            	$(".ovaev_map #ovaev_map_address").val(place.formatted_address);

            	var location_map = String(place.geometry.location);
            	var lacation_input = location_map.replace("(","").replace(")","").replace(" ", "").split(",");
            	$(".ovaev_map #ovaev_map_lat").val(lacation_input[0]);
            	$(".ovaev_map #ovaev_map_lng").val(lacation_input[1]);

            	infowindow.setContent(place.formatted_address);
            	infowindow.open(map, marker);

            });
		}
	} );

	$( function($) {
		if( typeof google !== 'undefined' && $("#show_map").length > 0 ){
			var ovaev_map_lat = parseFloat( $('input#ovaev_map_lat').val() );
			var ovaev_map_lng = parseFloat( $('input#ovaev_map_lng').val() );

			$("#show_map").ovaev_map({ lat: ovaev_map_lat, lng: ovaev_map_lng, zoom: 17, id:'#show_map'  });	
		}
	} );
	/***** End Map *****/


	/***** Date Time Picker *****/
	$( function($) {
      if($().datetimepicker) {
         $('.ovaev_start_date, .ovaev_end_date').each(function(){
            var lang = $(this).data('lang');
            var format_date = $(this).data('date');

            $(this).datetimepicker({
            	timepicker:false,
               	format: format_date,
            });
            $.datetimepicker.setLocale(lang);
         });
      } 
   });
	/***** End Date Time Picker *****/

	/***** Date Time Picker *****/
	$( function($) {
      if($().datetimepicker) {
         $('.ovaev_time_picker').each(function(){
            var lang = $(this).data('lang');
            var format_time = $(this).data('time');

            $(this).datetimepicker({
	            datepicker:false,
				format:format_time
            });
            $.datetimepicker.setLocale(lang);
         });
      } 
   });
	/***** End Date Time Picker *****/


	/***** Show Hiden Link *****/
	$( function($) {
		$('#ovaev_book').each(function(){
			var valueSelected = this.value;
			(valueSelected == 'extra_link' ) ? $('#ovaev_book_link').css('display', 'inline-block') : $('#ovaev_book_link').css('display', 'none');
			(valueSelected == 'extra_link' ) ? $('#ovaev_target_book').css('display', 'inline-block') : $('#ovaev_target_book').css('display', 'none');
		});
		$('#ovaev_book').on('change', function (e) {
			var valueSelected = this.value;
			(valueSelected == 'extra_link' ) ? $('#ovaev_book_link').css('display', 'inline-block') : $('#ovaev_book_link').css('display', 'none');
			(valueSelected == 'extra_link' ) ? $('#ovaev_target_book').css('display', 'inline-block') : $('#ovaev_target_book').css('display', 'none');
		});
	} );
	/***** End Show Hiden Link *****/

	/***** Upload Image *****/
	$( function() {
		var file_frame;
		$(document).on('click', '#metabox-event-gallery a.gallery-add', function(e) {

			e.preventDefault();

			if (file_frame) file_frame.close();

			file_frame = wp.media.frames.file_frame = wp.media({
				title: $(this).data('uploader-title'),
				button: {
					text: $(this).data('uploader-button-text'),
				},
				multiple: true
			});

			file_frame.on('select', function() {
				var listIndex = $('#gallery-metabox-list li').index($('#gallery-metabox-list li:last')),
				selection = file_frame.state().get('selection');

				selection.map(function(attachment, i) {
					attachment = attachment.toJSON();
					var index      = listIndex + (i + 1);
					var url 	   = attachment.sizes.full.url;
					if ( $(attachment.sizes.thumbnail).length > 0 ) {
						url = attachment.sizes.thumbnail.url;
					}

					$('#gallery-metabox-list').append('<li><input type="hidden" name="ovaev_gallery_id[' + index + ']" value="' + attachment.id + '"><img class="image-preview" src="' + url + '"><a class="change-image button button-small" href="#" data-uploader-title="Change image" data-uploader-button-text="Change image">Change image</a><small><a class="remove-image" href="#">Remove image</a></small></li>');
				});
			});

			makeSortable();

			file_frame.open();
		});

		$(document).on('click', '#metabox-event-gallery a.change-image', function(e) {

			e.preventDefault();

			var that = $(this);

			if (file_frame) file_frame.close();

         file_frame = wp.media.frames.file_frame = wp.media({
            title: $(this).data('uploader-title'),
            button: {
               text: $(this).data('uploader-button-text'),
            },
            multiple: false
         });

         file_frame.on( 'select', function() {
            attachment = file_frame.state().get('selection').first().toJSON();

            that.parent().find('input:hidden').attr('value', attachment.id);
            that.parent().find('img.image-preview').attr('src', attachment.sizes.thumbnail.url);
         });

         file_frame.open();
      });

		function resetIndex() {
			$('#metabox-event-gallery #gallery-metabox-list li').each(function(i) {
				$(this).find('input:hidden').attr('name', 'ovaev_gallery_id[' + i + ']');
			});
		}

		function makeSortable() {
			$('#metabox-event-gallery #gallery-metabox-list').sortable({
				opacity: 0.6,
				stop: function() {
					resetIndex();
				}
			});
		}

		$(document).on('click', '#metabox-event-gallery a.remove-image', function(e) {
			e.preventDefault();

			$(this).parents('li').animate({ opacity: 0 }, 200, function() {
				$(this).remove();
				resetIndex();
			});
		});

		makeSortable();
	} );
	/***** End Upload Image *****/

	/***** Templates Single Event *****/
	$( function() {
		if ( $("#ovaev_get_template_single").length > 0 ) {
			$("#ovaev_get_template_single").select2();
		}
	});

	$( function() {
		if ( $("#ovaev_event_templates").length > 0 ) {
			$("#ovaev_event_templates").select2();
		}
	});
	/***** End Templates Single Event *****/

}); 	
