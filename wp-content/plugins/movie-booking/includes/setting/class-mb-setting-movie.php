<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}


if ( ! class_exists( 'MB_Setting_Movie' ) ) {

    class MB_Setting_Movie extends MB_Abstract_Setting {
        public $_id         = 'movie';
        public $_title      = null;
        public $_position   = 11;
        public $_tab        = true;

        public function __construct() {
            $this->_title = esc_html__('Movie', 'moviebooking');

            add_filter( 'mb_admin_setting_fields', array( $this, 'mb_generate_fields_movie' ), 10, 2 );

            parent::__construct();
        }

        public function mb_generate_fields_movie( $groups, $id = 'movie' ) {
            if ( $id == 'movie' ) {
                $groups[$id . '_archive'] = apply_filters( 'mb_admin_setting_fields_archive_movie', $this->mb_admin_setting_fields_archive_movie(), $this->id );

                $groups[$id . '_single'] = apply_filters( 'mb_admin_setting_fields_single_movie', $this->mb_admin_setting_fields_single_movie(), $this->id );
            }

            return $groups;
        }

        public function mb_admin_setting_fields_archive_movie() {
            return array(
                'title'     => esc_html__('Archive', 'moviebooking'),
                'desc'      => '',
                array(
                    'fields'    => array(
                        array(
                            'type'  => 'input',
                            'label' => esc_html__( 'Movies Per Page', 'moviebooking' ),
                            'desc'  => esc_html__( 'Number of Movies Per Page', 'moviebooking' ),
                            'atts'  => array(
                                'id'    => 'archive_movies_per_page',
                                'class' => 'archive_movies_per_page',
                                'type'  => 'number'
                            ),
                            'name' => 'archive_movies_per_page',
                            'default' => 6
                        ),
                        array(
                            'type'  => 'select',
                            'label' => esc_html__( 'Template', 'moviebooking' ),
                            'desc'  => esc_html__( 'Choose template', 'moviebooking' ),
                            'atts'  => array(
                                'id'    => 'archive_template',
                                'class' => 'archive_template mb_select2',
                            ),
                            'name' => 'archive_template',
                            'options' => array(
                                'template1' => esc_html__( 'Template 1', 'moviebooking' ),
                                'template2' => esc_html__( 'Template 2', 'moviebooking' ),
                                'template3' => esc_html__( 'Template 3', 'moviebooking' ),
                                'template4' => esc_html__( 'Template 4', 'moviebooking' ),
                            ),
                            'default' => 'template1'
                        ),
                        array(
                            'type'  => 'select',
                            'label' => esc_html__( 'Number Column', 'moviebooking' ),
                            'desc'  => esc_html__( 'Choose Number Column', 'moviebooking' ),
                            'atts'  => array(
                                'id'    => 'archive_number_column',
                                'class' => 'archive_number_column',
                            ),
                            'name' => 'archive_number_column',
                            'options' => array(
                                'two_column' => esc_html__( '2 Column', 'moviebooking' ),
                                'three_column' => esc_html__( '3 Column', 'moviebooking' ),
                                'four_column' => esc_html__( '4 Column', 'moviebooking' ),
                            ),
                            'default' => 'three_column'
                        ),
                        array(
                            'type'  => 'select',
                            'label' => esc_html__( 'Header', 'moviebooking' ),
                            'desc'  => esc_html__( 'Choose Header', 'moviebooking' ),
                            'atts'  => array(
                                'id'    => 'archive_header',
                                'class' => 'archive_header',
                            ),
                            'name' => 'archive_header',
                            'options' => apply_filters('aovis_list_header', ''),
                            'default' => 'default'
                        ),
                        array(
                            'type'  => 'select',
                            'label' => esc_html__( 'Footer', 'moviebooking' ),
                            'desc'  => esc_html__( 'Choose Footer', 'moviebooking' ),
                            'atts'  => array(
                                'id'    => 'archive_footer',
                                'class' => 'archive_footer',
                            ),
                            'name' => 'archive_footer',
                            'options' => apply_filters('aovis_list_footer', ''),
                            'default' => 'default'
                        ),
                    ),
                ),
            );
        }

        public function mb_admin_setting_fields_single_movie() {

            // Get templates from elementor
            $templates = get_posts( array('post_type' => 'elementor_library', 'posts_per_page' => -1, 'meta_key' => '_elementor_template_type', 'meta_value' => 'page' ) );
            
            $list_templates = array( 'default' => esc_html__('Default','moviebooking') );

            if( ! empty( $templates ) ) {
                foreach( $templates as $template ) {
                    $id_template    = $template->ID;
                    $title_template = $template->post_title;
                    $list_templates[$id_template] = $title_template;
                }
            }

            return array(
                'title'     => esc_html__('Single', 'moviebooking'),
                'desc'      => '',
                array(
                    'fields'    => array(
                        array(
                            'type'  => 'select',
                            'label' => esc_html__( 'Template', 'moviebooking' ),
                            'desc'  => esc_html__( 'Default or Other (made in Templates of Elementor)', 'moviebooking' ),
                            'atts'  => array(
                                'id'    => 'single_template',
                                'class' => 'single_template mb_select2',
                            ),
                            'name' => 'single_template',
                            'options' => $list_templates,
                            'default' => 'default'
                        ),
                        array(
                            'type'  => 'select',
                            'label' => esc_html__( 'Header', 'moviebooking' ),
                            'desc'  => esc_html__( 'Choose Header', 'moviebooking' ),
                            'atts'  => array(
                                'id'    => 'single_header',
                                'class' => 'single_header',
                            ),
                            'name' => 'single_header',
                            'options' => apply_filters('aovis_list_header', ''),
                            'default' => 'default'
                        ),
                        array(
                            'type'  => 'select',
                            'label' => esc_html__( 'Footer', 'moviebooking' ),
                            'desc'  => esc_html__( 'Choose Footer', 'moviebooking' ),
                            'atts'  => array(
                                'id'    => 'single_footer',
                                'class' => 'single_footer',
                            ),
                            'name' => 'single_footer',
                            'options' => apply_filters('aovis_list_footer', ''),
                            'default' => 'default'
                        ),
                        array(
                            'type'  => 'input',
                            'label' => esc_html__( 'Text Watch Trailer', 'moviebooking' ),
                            'desc'  => esc_html__( 'Text with pointing up arrow below the trailer button', 'moviebooking' ),
                            'atts'  => array(
                                'id'    => 'single_text_watch_trailer',
                                'class' => 'single_text_watch_trailer',
                                'type'  => 'text'
                            ),
                            'name' => 'single_text_watch_trailer',
                            'default' => esc_html__( 'Watch the Trailer', 'moviebooking' )
                        ),
                        array(
                            'type'  => 'input',
                            'label' => esc_html__( 'Cast Heading', 'moviebooking' ),
                            'desc'  => esc_html__( 'Heading Movie Cast (Note*: Default template)', 'moviebooking' ),
                            'atts'  => array(
                                'id'    => 'single_cast_heading',
                                'class' => 'single_cast_heading',
                                'type'  => 'text'
                            ),
                            'name' => 'single_cast_heading',
                            'default' => esc_html__( 'Top Cast', 'moviebooking' )
                        ),
                        array(
                            'type'  => 'input',
                            'label' => esc_html__( 'Story Heading', 'moviebooking' ),
                            'desc'  => esc_html__( 'Heading Movie Content (Note*: Default template)', 'moviebooking' ),
                            'atts'  => array(
                                'id'    => 'single_story_heading',
                                'class' => 'single_story_heading',
                                'type'  => 'text'
                            ),
                            'name' => 'single_story_heading',
                            'default' => esc_html__( 'Story Line', 'moviebooking' )
                        ),
                        array(
                            'type'  => 'input',
                            'label' => esc_html__( 'Related Movies Heading', 'moviebooking' ),
                            'desc'  => esc_html__( 'Related Movies Heading (Note*: Default template)', 'moviebooking' ),
                            'atts'  => array(
                                'id'    => 'single_related_movies_heading',
                                'class' => 'single_related_movies_heading',
                                'type'  => 'text'
                            ),
                            'name' => 'single_related_movies_heading',
                            'default' => esc_html__( 'More Movies Like This', 'moviebooking' )
                        ),
                        array(
                            'type'  => 'select',
                            'label' => esc_html__( 'Enable Filter by related movies', 'moviebooking' ),
                            'desc'  => esc_html__( 'Movies and Movie Slider widget used in single movie page use filter by related movies', 'moviebooking' ),
                            'atts'  => array(
                                'id'    => 'single_filter_by_related',
                                'class' => 'single_filter_by_related'
                            ),
                            'name'  => 'single_filter_by_related',
                            'options' => array(
                                'no'    => esc_html__( 'No', 'moviebooking' ),
                                'yes'   => esc_html__( 'Yes', 'moviebooking' )
                            ),
                            'default' => 'yes'
                        ),
                    ),
                ),
            );
        }
    }

    $GLOBALS['mb_movie_settings'] = new MB_Setting_Movie();
}