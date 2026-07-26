<?php

 if ( is_home () && is_front_page () ) {
        
    esc_html_e('Home','aovis');

} elseif ( is_front_page() ) {
    
    esc_html_e('Home','aovis');

}elseif ( is_home () ) {

    esc_html_e('Blog','aovis');

} elseif ( is_search () ) {

    esc_html_e('Search','aovis');

} else if(is_category () ){

    echo single_cat_title('');

}else if (is_tag ()){

    esc_html_e('Tags','aovis');

}else if( is_tax () || is_archive() ){

    echo get_the_archive_title();

}else if( is_singular() ){

    echo get_the_title();

}else if(  is_404() ) {
    esc_html_e('page not found','aovis');
}
