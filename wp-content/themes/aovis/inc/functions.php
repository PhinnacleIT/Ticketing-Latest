<?php if (!defined( 'ABSPATH' )) exit;

// Get current ID of post/page, etc
if( !function_exists( 'aovis_get_current_id' )):
	function aovis_get_current_id(){
	    
	    $current_page_id = '';
	    // Get The Page ID You Need
	    
	    if(class_exists("woocommerce")) {
	        if( is_shop() ){ ///|| is_product_category() || is_product_tag()) {
	            $current_page_id  =  get_option ( 'woocommerce_shop_page_id' );
	        }elseif(is_cart()) {
	            $current_page_id  =  get_option ( 'woocommerce_cart_page_id' );
	        }elseif(is_checkout()){
	            $current_page_id  =  get_option ( 'woocommerce_checkout_page_id' );
	        }elseif(is_account_page()){
	            $current_page_id  =  get_option ( 'woocommerce_myaccount_page_id' );
	        }elseif(is_view_order_page()){
	            $current_page_id  = get_option ( 'woocommerce_view_order_page_id' );
	        }
	    }
	    if($current_page_id=='') {
	        if ( is_home () && is_front_page () ) {
	            $current_page_id = '';
	        } elseif ( is_home () ) {
	            $current_page_id = get_option ( 'page_for_posts' );
	        } elseif ( is_search () || is_category () || is_tag () || is_tax () || is_archive() ) {
	            $current_page_id = '';
	        } elseif ( !is_404 () ) {
	           $current_page_id = get_the_id();
	        } 
	    }

	    return $current_page_id;
	}
endif;



if (!function_exists('aovis_is_elementor_active')) {
    function aovis_is_elementor_active(){
        return did_action( 'elementor/loaded' );
    }
}

if (!function_exists('aovis_is_woo_active')) {
    function aovis_is_woo_active(){
        return class_exists('woocommerce');    
    }
}

if (!function_exists('aovis_is_blog_archive')) {
    function aovis_is_blog_archive() {
        return (is_home() && is_front_page()) || is_archive() || is_category() || is_tag() || is_home();
    }
}



/* Get ID from Slug of Header Footer Builder - Post Type */
function aovis_get_id_by_slug( $page_slug ) {
    $page = get_page_by_path( $page_slug, OBJECT, 'ova_framework_hf_el' ) ;
    if ($page) {
        return $page->ID;
    } else {
        return null;
    }
}


function aovis_custom_text ($content = "",$limit = 15) {

    $content = explode(' ', $content, $limit);

    if (count($content)>=$limit) {
        array_pop($content);
        $content = implode(" ",$content).'...';
    } else {
        $content = implode(" ",$content);
    }

    $content = preg_replace('`[[^]]*]`','',$content);
    
    return strip_tags( $content );
}



/**
 * Google Font sanitization
 *
 * @param  string   JSON string to be sanitized
 * @return string   Sanitized input
 */
if ( ! function_exists( 'aovis_google_font_sanitization' ) ) {
    function aovis_google_font_sanitization( $input ) {
        $val =  json_decode( $input, true );
        if( is_array( $val ) ) {
            foreach ( $val as $key => $value ) {
                $val[$key] = sanitize_text_field( $value );
            }
            $input = json_encode( $val );
        }
        else {
            $input = json_encode( sanitize_text_field( $val ) );
        }
        return $input;
    }
}

/* Default Primary Color in Customize */
if ( ! function_exists( 'aovis_default_primary_color' ) ) {
    function aovis_default_primary_color() {
        $primary_color = get_theme_mod( 'primary_color', '#D96C2C' );

        return $primary_color;
    }
}

/* Default Primary Font in Customize */
if ( ! function_exists( 'aovis_default_primary_font' ) ) {
    function aovis_default_primary_font() {
        $customizer_defaults = json_encode(
            array(
                'font' => 'Space Grotesk',
                'regularweight' => '300,regular,500,600,700',
                'category' => 'serif'
            )
        );

        return $customizer_defaults;
    }
}

/* Default Second Font in Customize */
if ( ! function_exists( 'aovis_default_second_font' ) ) {
    function aovis_default_second_font() {
        $customizer_defaults = json_encode(
            array(
                'font' => 'Space Grotesk',
                'regularweight' => '300,regular,500,600,700',
                'category' => 'serif'
            )
        );

        return $customizer_defaults;
    }
}

if ( ! function_exists( 'aovis_woo_sidebar' ) ) {
    function aovis_woo_sidebar(){
        if( class_exists('woocommerce') && is_product() ){
            return get_theme_mod( 'woo_product_layout', 'woo_layout_1c' );
        }else{
            return get_theme_mod( 'woo_archive_layout', 'woo_layout_1c' );
        }
    }
}

if( !function_exists( 'aovis_blog_show_media' ) ){
    function aovis_blog_show_media(){
        $show_media = get_theme_mod( 'blog_archive_show_media', 'yes' );
        return isset( $_GET['show_media'] ) ? $_GET['show_media'] : $show_media;
    }
}

if( !function_exists( 'aovis_blog_show_title' ) ){
    function aovis_blog_show_title(){
        $show_title = get_theme_mod( 'blog_archive_show_title', 'yes' );
        return isset( $_GET['show_title'] ) ? $_GET['show_title'] : $show_title;
    }
}

if( !function_exists( 'aovis_blog_show_date' ) ){
    function aovis_blog_show_date(){
        $show_date = get_theme_mod( 'blog_archive_show_date', 'yes' );
        return isset( $_GET['show_date'] ) ? $_GET['show_date'] : $show_date;
    }
}

if( !function_exists( 'aovis_blog_show_cat' ) ){
    function aovis_blog_show_cat(){
        $show_cat = get_theme_mod( 'blog_archive_show_cat', 'yes' );
        return isset( $_GET['show_cat'] ) ? $_GET['show_cat'] : $show_cat;
    }
}

if( !function_exists( 'aovis_blog_show_author' ) ){
    function aovis_blog_show_author(){
        $show_author = get_theme_mod( 'blog_archive_show_author', 'yes' );
        return isset( $_GET['show_author'] ) ? $_GET['show_author'] : $show_author;
    }
}

if( !function_exists( 'aovis_blog_show_comment' ) ){
    function aovis_blog_show_comment(){
        $show_comment = get_theme_mod( 'blog_archive_show_comment', 'yes' );
        return isset( $_GET['show_comment'] ) ? $_GET['show_comment'] : $show_comment;
    }
}

if( !function_exists( 'aovis_blog_show_excerpt' ) ){
    function aovis_blog_show_excerpt(){
        $show_excerpt = get_theme_mod( 'blog_archive_show_excerpt', 'yes' );
        return isset( $_GET['show_excerpt'] ) ? $_GET['show_excerpt'] : $show_excerpt;
    }
}


if( !function_exists( 'aovis_blog_show_readmore' ) ){
    function aovis_blog_show_readmore(){
        $show_readmore = get_theme_mod( 'blog_archive_show_readmore', 'yes' );
        return isset( $_GET['show_readmore'] ) ? $_GET['show_readmore'] : $show_readmore;
    }
}



if( !function_exists( 'aovis_post_show_media' ) ){
    function aovis_post_show_media(){
        $show_media = get_theme_mod( 'blog_single_show_media', 'yes' );
        return isset( $_GET['show_media'] ) ? $_GET['show_media'] : $show_media;
    }
}

if( !function_exists( 'aovis_post_show_title' ) ){
    function aovis_post_show_title(){
        $show_title = get_theme_mod( 'blog_single_show_title', 'yes' );
        return isset( $_GET['show_title'] ) ? $_GET['show_title'] : $show_title;
    }
}

if( !function_exists( 'aovis_post_show_date' ) ){
    function aovis_post_show_date(){
        $show_date = get_theme_mod( 'blog_single_show_date', 'yes' );
        return isset( $_GET['show_date'] ) ? $_GET['show_date'] : $show_date;
    }
}

if( !function_exists( 'aovis_post_show_cat' ) ){
    function aovis_post_show_cat(){
        $show_cat = get_theme_mod( 'blog_single_show_cat', 'yes' );
        return isset( $_GET['show_cat'] ) ? $_GET['show_cat'] : $show_cat;
    }
}

if( !function_exists( 'aovis_post_show_author' ) ){
    function aovis_post_show_author(){
        $show_author = get_theme_mod( 'blog_single_show_author', 'yes' );
        return isset( $_GET['show_author'] ) ? $_GET['show_author'] : $show_author;
    }
}

if( !function_exists( 'aovis_post_show_comment' ) ){
    function aovis_post_show_comment(){
        $show_comment = get_theme_mod( 'blog_single_show_comment', 'yes' );
        return isset( $_GET['show_comment'] ) ? $_GET['show_comment'] : $show_comment;
    }
}

if( !function_exists( 'aovis_post_show_tag' ) ){
    function aovis_post_show_tag(){
        $show_tag = get_theme_mod( 'blog_single_show_tag', 'yes' );
        return isset( $_GET['show_tag'] ) ? $_GET['show_tag'] : $show_tag;
    }
}


