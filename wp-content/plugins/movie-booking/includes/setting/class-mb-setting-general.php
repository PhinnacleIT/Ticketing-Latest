<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MB_Setting_General' ) ) {

    class MB_Setting_General extends MB_Abstract_Setting {
        public $_id         = 'general';
        public $_title      = null;
        public $_position   = 10;

        public function __construct() {
            $this->_title = esc_html__('General', 'moviebooking');
            parent::__construct();
        }

        public function load_field() {
            return array(
                array(
                    'title'     => esc_html__('General Settings', 'moviebooking'),
                    'desc'      => esc_html__('General options', 'moviebooking'),
                    'fields'    => array(
                        array(
                            'type'  => 'select_page',
                            'label' => esc_html__('Cart page', 'moviebooking'),
                            'desc'  => esc_html__('Page contents: [mb_cart/]', 'moviebooking'),
                            'name'  => 'cart_page_id',
                            'atts'  => array(
                                'id'    => 'cart_page',
                                'class' => 'cart_page mb_select2',
                            ),
                        ),
                        array(
                            'type'  => 'select',
                            'label' => esc_html__('Date Format', 'moviebooking'),
                            'desc'  => '',
                            'name'  => 'mb_date_format',
                            'atts'  => array(
                                'id'    => 'mb_date_format',
                                'class' => 'mb_date_format',
                            ),
                            'options' => array(
                                'd-m-Y'     => sprintf( esc_html__( 'd-m-Y (%s)', 'moviebooking' ), date( 'd-m-Y', current_time( 'timestamp' ) )),
                                'Y-m-d'     => sprintf( esc_html__( 'Y-m-d (%s)', 'moviebooking' ), date( 'Y-m-d', current_time( 'timestamp' ) )),
                                'm/d/Y'     => sprintf( esc_html__( 'm/d/Y (%s)', 'moviebooking' ), date( 'm/d/Y', current_time( 'timestamp' ) )),
                                'd/m/Y'     => sprintf( esc_html__( 'd/m/Y (%s)', 'moviebooking' ), date( 'd/m/Y', current_time( 'timestamp' ) )),
                                'F j, Y'    => sprintf( esc_html__( 'F j, Y (%s)', 'moviebooking' ), date( 'F j, Y', current_time( 'timestamp' ) )),
                            ),
                            'default' => 'd-m-Y'
                        ),
                        array(
                            'type'  => 'select',
                            'label' => esc_html__('Time Format', 'moviebooking'),
                            'desc'  => '',
                            'name'  => 'mb_time_format',
                            'atts'  => array(
                                'id'    => 'mb_time_format',
                                'class' => 'mb_time_format',
                            ),
                            'options' => array(
                                'H:i'   => sprintf( esc_html__( 'H:i (%s)', 'moviebooking' ), date( 'H:i', current_time( 'timestamp' ) )),
                                'g:i a' => sprintf( esc_html__( 'g:i a (%s)', 'moviebooking' ), date( 'g:i a', current_time( 'timestamp' ) )),
                                'g:i A' => sprintf( esc_html__( 'g:i A (%s)', 'moviebooking' ), date( 'g:i A', current_time( 'timestamp' ) )),
                            ),
                            'default' => 'H:i'
                        ),
                        array(
                            'type'  => 'input',
                            'label' => esc_html__('Step Time', 'moviebooking'),
                            'desc'  => esc_html__('Minutes', 'moviebooking'),
                            'name'  => 'mb_step_time',
                            'atts'  => array(
                                'id'    => 'mb_step_time',
                                'class' => 'mb_step_time',
                                'type'  => 'number',
                                'min'   => 1,
                                'max'   => 60,
                            ),
                            'default' => '15'
                        ),
                        array(
                            'type'  => 'input',
                            'label' => esc_html__('Default Time', 'moviebooking'),
                            'desc'  => '',
                            'name'  => 'mb_default_time',
                            'atts'  => array(
                                'id'    => 'mb_default_time',
                                'class' => 'mb_default_time',
                            ),
                            'default' => '00:00'
                        ),
                        array(
                            'type'  => 'select',
                            'label' => esc_html__('Calenadar Language', 'moviebooking'),
                            'desc'  => '',
                            'name'  => 'mb_calenadar_language',
                            'atts'  => array(
                                'id'    => 'mb_calenadar_language',
                                'class' => 'mb_calenadar_language mb_select2',
                            ),
                            'options' => MBC()->mb_get_language_support(),
                            'default' => 'en'
                        ),
                        array(
                            'type'  => 'select',
                            'label' => esc_html__('The first day of week', 'moviebooking'),
                            'desc'  => '',
                            'name'  => 'mb_day_of_week_start',
                            'atts'  => array(
                                'id'    => 'mb_day_of_week_start',
                                'class' => 'mb_day_of_week_start',
                            ),
                            'options' => array(
                                '1' => esc_html__('Monday', 'moviebooking'),
                                '2' => esc_html__('Tuesday', 'moviebooking'),
                                '3' => esc_html__('Wednesday', 'moviebooking'),
                                '4' => esc_html__('Thursday', 'moviebooking'),
                                '5' => esc_html__('Friday', 'moviebooking'),
                                '6' => esc_html__('Saturday', 'moviebooking'),
                                '7' => esc_html__('Sunday', 'moviebooking'),
                            ),
                            'default' => '1'
                        ),
                        array(
                            'type'  => 'input',
                            'label' => esc_html__('Maximum showtime', 'moviebooking'),
                            'desc'  => esc_html__('Maximum date to show in pop-up showtime', 'moviebooking'),
                            'name'  => 'mb_maximum_showtime',
                            'atts'  => array(
                                'id'    => 'mb_maximum_showtime',
                                'class' => 'mb_maximum_showtime',
                                'type'  => 'number',
                                'min'   => 1,
                            ),
                            'default' => 14,
                        ),
                        array(
                            'type'  => 'input',
                            'label' => esc_html__( 'Text Get Ticket', 'moviebooking' ),
                            'desc'  => esc_html__( 'Text get ticket button in all template/parts of movie', 'moviebooking' ),
                            'atts'  => array(
                                'id'    => 'mb_text_get_ticket',
                                'class' => 'mb_text_get_ticket',
                                'type'  => 'text'
                            ),
                            'name' => 'mb_text_get_ticket',
                            'default' => esc_html__('Get Ticket', 'moviebooking'),
                        ),
                         array(
                            'type'  => 'input',
                            'label' => esc_html__( 'Text Watch Trailer', 'moviebooking' ),
                            'desc'  => esc_html__( 'Text watch trailer button in all template/parts of movie', 'moviebooking' ),
                            'atts'  => array(
                                'id'    => 'mb_text_watch_trailer',
                                'class' => 'mb_text_watch_trailer',
                                'type'  => 'text'
                            ),
                            'name' => 'mb_text_watch_trailer',
                            'default' => esc_html__('Watch Trailer', 'moviebooking'),
                        ),
                    ),
                ),
            );
        }
    }

    $GLOBALS['mb_general_settings'] = new MB_Setting_General();
}