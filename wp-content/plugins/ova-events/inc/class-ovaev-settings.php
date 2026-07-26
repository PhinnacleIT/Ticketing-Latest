<?php

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class OVAEV_Settings {

	public static function single_event_bg(){
		$ops = get_option('ovaev_options');
		return isset( $ops['single_event_bg'] ) ? $ops['single_event_bg'] : '';
	}

	public static function ovaev_show_sidebar_single(){
		$ops = get_option('ovaev_options');
		return isset( $ops['ovaev_show_sidebar_single'] ) ? $ops['ovaev_show_sidebar_single'] : 'yes';
	}

	public static function single_event_header(){
		$ops = get_option('ovaev_options');
		return isset( $ops['single_event_header'] ) ? $ops['single_event_header'] : 'default';
	}

	public static function single_event_footer(){
		$ops = get_option('ovaev_options');
		return isset( $ops['single_event_footer'] ) ? $ops['single_event_footer'] : 'default';
	}

	public static function ovaev_show_title_single(){
		$ops = get_option('ovaev_options');
		return isset( $ops['ovaev_show_title_single'] ) ? $ops['ovaev_show_title_single'] : 'yes';
	}

	public static function ovaev_get_template_single(){
		$ops = get_option('ovaev_options');
		return isset( $ops['ovaev_get_template_single'] ) ? $ops['ovaev_get_template_single'] : 'default';
	}

	public static function google_key_map(){
		$ops = get_option('ovaev_options');
		return isset( $ops['google_key_map'] ) ? $ops['google_key_map'] : '';
	}

	public static function event_map_zoom(){
		$ops = get_option('ovaev_options');
		return isset( $ops['event_map_zoom'] ) ? $ops['event_map_zoom'] : '';
	}

	public static function ovaev_show_past(){
		$ops = get_option('ovaev_options');
		return isset( $ops['ovaev_show_past'] ) ? $ops['ovaev_show_past'] : 'yes';
	}

	public static function archive_event_orderby(){
		$ops = get_option('ovaev_options');
		return isset( $ops['archive_event_orderby'] ) ? $ops['archive_event_orderby'] : 'ID';
	}

	public static function archive_event_order(){
		$ops = get_option('ovaev_options');
		return isset( $ops['archive_event_order'] ) ? $ops['archive_event_order'] : 'DESC';
	}


	public static function archive_event_thumbnail(){
		$ops = get_option('ovaev_options');
		return isset( $ops['archive_event_thumbnail'] ) ? $ops['archive_event_thumbnail'] : '700x450';
	}
	

	public static function archive_event_type(){
		$ops = get_option('ovaev_options');
		return isset( $ops['archive_event_type'] ) ? $ops['archive_event_type'] : 'type2';
	}

	public static function archive_event_header(){
		$ops = get_option('ovaev_options');
		return isset( $ops['archive_event_header'] ) ? $ops['archive_event_header'] : 'default';
	}

	public static function archive_event_footer(){
		$ops = get_option('ovaev_options');
		return isset( $ops['archive_event_footer'] ) ? $ops['archive_event_footer'] : 'default';
	}

	public static function archive_event_col(){
		$ops = get_option('ovaev_options');
		return isset( $ops['archive_event_col'] ) ? $ops['archive_event_col'] : 'col3';
	}

	public static function ovaev_show_sidebar(){
		$ops = get_option('ovaev_options');
		return isset( $ops['ovaev_show_sidebar'] ) ? $ops['ovaev_show_sidebar'] : 'no';
	}

	public static function ovaev_show_search(){
		$ops = get_option('ovaev_options');
		return isset( $ops['ovaev_show_search'] ) ? $ops['ovaev_show_search'] : 'yes';
	}

	public static function archive_event_format_date(){
		$ops = get_option('ovaev_options');
		return isset( $ops['archive_event_format_date'] ) ? $ops['archive_event_format_date'] : 'd-m-Y';
	}

	public static function archive_format_date_lang(){
		$ops = get_option('ovaev_options');
		return isset( $ops['archive_format_date_lang'] ) ? $ops['archive_format_date_lang'] : 'en';
	}

	public static function archive_event_format_time(){
		$ops = get_option('ovaev_options');
		return isset( $ops['archive_event_format_time'] ) ? $ops['archive_event_format_time'] : 'H:i';
	}
	
	public static function archive_format_color(){
		$ops = get_option('ovaev_options');
		return isset( $ops['archive_format_color'] ) ? $ops['archive_format_color'] : '';
	}

}

new OVAEV_Settings();