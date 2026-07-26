<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MB_PDF' ) ) {
	class MB_PDF {

		function make_pdf_ticket( $ticket_id ) {
			$prefix = MB_PLUGIN_PREFIX_TICKET;

			$ticket = array();

			$movie_name 			= get_post_meta( $ticket_id, $prefix . 'movie_name', true );
			$room_id 				= get_post_meta( $ticket_id, $prefix . 'room_id', true );
			$qr_code 				= get_post_meta( $ticket_id, $prefix . 'qr_code', true );
			$date 					= get_post_meta( $ticket_id, $prefix . 'date', true );
			$address 				= get_post_meta( $ticket_id, $prefix . 'address', true );
			$seat 					= get_post_meta( $ticket_id, $prefix . 'seat', true );
			$extra_service 			= get_post_meta( $ticket_id, $prefix . 'extra_service', true );
			$person_type 			= get_post_meta( $ticket_id, $prefix . 'person_type', true );
			$customer_name 			= get_post_meta( $ticket_id, $prefix . 'customer_name', true );
			$description_ticket 	= get_post_meta( $ticket_id, $prefix . 'description_ticket', true );
			$private_description 	= get_post_meta( $ticket_id, $prefix . 'private_desc_ticket', true );
			$logo_id 				= get_post_meta( $ticket_id, $prefix . 'logo', true );

			// Get info ticket
			$ticket['ticket_id'] 	= $ticket_id;
			$ticket['room'] 		= get_the_title( $room_id );
			$ticket['seat'] 		= $seat;
			$ticket['movie_name'] 	= $movie_name;

			if ( ! empty( $person_type ) ) {
				$ticket['seat'] .= ' - '.$person_type;
			}

			
			if ( ! empty( $extra_service ) ) {
				$extra_service = mb_ticket_get_extra_service( $extra_service );
				$extra_service = implode( ', ', $extra_service );
			}
			$ticket['extra_service'] = $extra_service;

			$ticket['color_border_ticket'] = get_post_meta( $ticket_id, $prefix . 'color_border_ticket', true );
			if ( empty( $ticket['color_border_ticket'] ) ) {
				$ticket['color_border_ticket'] = '#cccccc';
			}

			$ticket['color_label_ticket'] = get_post_meta( $ticket_id, $prefix . 'color_label_ticket', true );
			if ( empty( $ticket['color_label_ticket'] ) ) {
				$ticket['color_label_ticket'] = '#666666';	
			}

			$ticket['color_content_ticket'] = get_post_meta( $ticket_id, $prefix . 'color_content_ticket', true );
			if ( empty( $ticket['color_content_ticket'] ) ) {
				$ticket['color_content_ticket'] = '#333333';	
			}

			$ticket['description_ticket'] 	= sub_string_word( $description_ticket, apply_filters( 'mb_ft_description_ticket_characters', 230 ) );
			$ticket['private_desc_ticket'] 	= sub_string_word( $private_description, apply_filters( 'mb_ft_private_description_ticket_characters', 230 ) );
			
			$ticket['date'] 		= date_i18n( MBC()->mb_get_date_time_format(), $date );
			$ticket['address'] 		= $address;
			$ticket['qrcode_str'] 	= $qr_code;
			$ticket['order_info'] 	= esc_html__( 'Ordered by', 'moviebooking' ).' '.$customer_name;
			$ticket['logo_url'] 	= $logo_id ? wp_get_attachment_image_url( $logo_id, 'full' ) : '';

			$upload_dir = wp_upload_dir();

			// Add Font
			$defaultConfig = ( new Mpdf\Config\ConfigVariables() )->getDefaults();
			$fontDirs = $defaultConfig['fontDir'];

			$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
			$fontData = $defaultFontConfig['fontdata'];

			$config_mpdf = array(
				'tempDir' 			=> $upload_dir['basedir'],
				'default_font_size' => apply_filters( 'mb_ft_pdf_font_size_'.apply_filters( 'wpml_current_language', NULL ), 12 ),
				'default_font' 		=> apply_filters( 'mb_ft_pdf_font_'.apply_filters( 'wpml_current_language', NULL ), 'DejaVuSans' ),
				'fontDir' 			=> array_merge( $fontDirs, array( get_stylesheet_directory() . '/font' ) ),
			);

			$attach_file = '';

			ob_start();
				mb_get_template( 'pdf/template.php', array( 'ticket' => $ticket ) );
				$html = ob_get_contents();
			ob_get_clean();

			try {
			    $mpdf = new \Mpdf\Mpdf( apply_filters( 'mb_ft_config_mpdf', $config_mpdf ) );
				$mpdf->WriteHTML( $html );
				$ticket_name = apply_filters( 'mb_ft_ticket_name', 'movie_ticket_'.$ticket_id, $ticket_id );
				$attach_file = WP_CONTENT_DIR.'/uploads/'.sanitize_title( $ticket_name ).'.pdf';
				$mpdf->Output( $attach_file, 'F' );
			} catch (\Mpdf\MpdfException $e) { // Note: safer fully qualified exception name used for catch
			    // Process the exception, log, print etc.
			    echo $e->getMessage();
			}
			
			return $attach_file;
		}
	}
}