<?php
$general_css 	= '';

$primary_color 	= OVAEV_Settings::archive_format_color();
$primary_color 	= !empty( $primary_color ) ? $primary_color : '#d96c2c';

$general_css .= <<<CSS


#sidebar-event .widget_feature_event .event-feature .item .date-event .date,
.single_event .content-event .tab-Location ul.event_nav li.event_nav-item.active:after,
.single_event .content-event .tab-Location ul.event_nav li.event_nav-item a:after,
.single_event .content-event .event-related .archive_event .ovaev-content.content-grid .date-event .date,
#sidebar-event .widget ul li a:hover:before,
.type1 .desc .event_post .button_event .view_detail:hover,
.type2 .desc .event_post .button_event .view_detail:hover,
#sidebar-event .widget_feature_event .event-feature .item .desc .event_post .button_event .view_detail:hover,
#sidebar-event .widget_list_event .button-all-event a:hover,
.single_event .content-event .event_intro .wrap-event-info .wrap-booking-links a:hover
.single_event .content-event .ova-next-pre-post .pre:hover .num-1 .icon,
.single_event .content-event .ova-next-pre-post .next:hover .num-1 .icon,
.single_event .content-event .ova-next-pre-post .pre:hover .num-1 .icon,
.single_event .content-event .ova-next-pre-post .next:hover .num-1 .icon,
.single_event .content-event .event-related .archive_event .ovaev-content.content-grid .desc .event_post .button_event .view_detail:hover,
.single_event .content-event .event_intro .wrap-event-info .wrap-booking-links a:hover,
.ovaev-event-element.ovaev-event-slide .owl-nav button:hover,
.ovapo_project_slide .grid .owl-nav button:hover,
.search_archive_event form .wrap-ovaev_submit .ovaev_submit,
.ovaev-event-element.version_2 .wp-content .ovaev-content.content-grid .date-event .date,
.ovaev-event-element.version_2 .wp-content .ovaev-content.content-grid .desc .event_post .button_event .view_detail:hover,
.blog_pagination .pagination li.active a,
.blog_pagination .pagination li a:hover,
.blog_pagination .pagination li a:focus,
.ovaev-event-element.ovaev-event-slide .owl-dots .owl-dot.active span,
.ovapo_project_grid .btn_grid .btn_grid_event:hover,
.events_pagination .page-numbers li span,
.events_pagination .page-numbers li a:hover,
.ovaev-wrapper-search-ajax .search-ajax-pagination ul li .page-numbers.current,
.ovaev-wrapper-search-ajax .search-ajax-pagination ul li .page-numbers:hover
{
	background-color: {$primary_color};
}

.type1 .desc .event_post .button_event .view_detail:hover,
.type2 .desc .event_post .button_event .view_detail:hover,
#sidebar-event .widget_feature_event .event-feature .item .desc .event_post .button_event .view_detail:hover,
#sidebar-event .widget_list_event .button-all-event a:hover,
.single_event .content-event .event_intro .wrap-event-info .wrap-booking-links a:hover,
.single_event .content-event .ova-next-pre-post .pre:hover .num-1 .icon,
.single_event .content-event .ova-next-pre-post .next:hover .num-1 .icon,
.single_event .content-event .event-related .archive_event .ovaev-content.content-grid .desc .event_post .button_event .view_detail:hover,
.search_archive_event form .wrap-ovaev_submit .ovaev_submit,
.ovaev-event-element.version_2 .wp-content .ovaev-content.content-grid .desc .event_post .button_event .view_detail:hover,
.blog_pagination .pagination li.active a,
.blog_pagination .pagination li a:hover,
.blog_pagination .pagination li a:focus,
.ovapo_project_grid .btn_grid .btn_grid_event:hover,
.events_pagination .page-numbers li a:hover,
.events_pagination .page-numbers li span,
.ovaev-wrapper-search-ajax .search-ajax-pagination ul li .page-numbers.current,
.ovaev-wrapper-search-ajax .search-ajax-pagination ul li .page-numbers:hover,
.ovaev-booking-btn a:hover
{
	border-color: {$primary_color};
}

.type1 .date-event .month-year,
.type1 .desc .event_post .post_cat .event_type,
.type1 .desc .event_post .event_title a:hover,
.icon_event,
.type2 .date-event .month-year,
.type2 .desc .event_post .post_cat .event_type,
.type2 .desc .event_post .event_title a:hover,
#sidebar-event .widget_feature_event .event-feature .item .date-event .month-year,
#sidebar-event .widget_feature_event .event-feature .item .desc .event_post .post_cat .event_type,
#sidebar-event .widget_feature_event .event-feature .item .desc .event_post .event_title a:hover,
#sidebar-event .widget_list_event .list-event .item-event .ova-content .title a:hover,
#sidebar-event .widget ul li:hover a,
#sidebar-event .widget ul li:hover,
.single_event .content-event .event_intro .wrap-event-info .wrap-info .wrap-pro i,
.single_event .content-event .event_intro .wrap-event-info .wrap-info .ovaev-category i,
.single_event .content-event .ova-next-pre-post .pre .num-2 .title:hover,
.single_event .content-event .ova-next-pre-post .next .num-2 .title:hover,
.single_event .content-event .event-related .archive_event .ovaev-content.content-grid .date-event .month-year,
.single_event .content-event .event-related .archive_event .ovaev-content.content-grid .desc .event_post .post_cat .event_type,
.single_event .content-event .event-related .archive_event .ovaev-content.content-grid .desc .event_post .event_title a:hover,
.single_event .content-event .event_tags_share .event-tags a:hover,
#sidebar-event .widget .tagcloud a:hover,
.ovapo_project_grid .button-filter button.active,
.ovapo_project_grid .button-filter button:hover,
.more_date_text,
.ovaev-event-element.version_2 .wp-content .ovaev-content.content-grid .date-event .month-year,
.ovaev-event-element.version_2 .wp-content .ovaev-content.content-grid .desc .event_post .event_title a:hover,
.ovaev-event-element.version_2 .wp-content .ovaev-content.content-grid .desc .event_post .time-event .time .more_date_text span,
.ovaev-event-element.version_2 .title-readmore .read-more,
.ovaev-event-element .item .title a:hover,
.single_event .content-event .event_intro .wrap-event-info .ovaev-category a:hover,
#sidebar-event .widget_list_event .list-event .item-event .ova-content .time .more_date_text span,
.ovaev-shortcode-title a:hover,
.ovaev-shortcode-date i,
.ovaev-shortcode-time i,
.ovaev-shortcode-location i,
.ovaev-shortcode-categories i,
.ovaev-shortcode-categories span.event-category a:hover,
.ovaev-shortcode-tags .ovaev-tag:hover
{
	color: {$primary_color};
}

#sidebar-event .widget .widget-title
{
	border-bottom-color: {$primary_color};
}

.ovapo_project_grid .wrap_loader .loader circle, .ovaev-wrapper-search-ajax .ovaev-search-ajax-container .wrap_loader .loader circle
{
	stroke: {$primary_color};
}


CSS;

return $general_css;