<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MB_Setting_Tax' ) ) {

    class MB_Setting_Tax extends MB_Abstract_Setting {
        public $_id         = 'tax_fee';
        public $_title      = null;
        public $_position   = 14;

        public function __construct() {
            $this->_title = esc_html__('Tax', 'moviebooking');
            parent::__construct();
        }

        public function load_field() {
            return array(
                array(
                    'title'     => esc_html__('Tax Settings', 'moviebooking'),
                    'desc'      => '',
                    'fields'    => array(
                        array(
                            'type'  => 'select',
                            'label' => esc_html__( 'Enable', 'moviebooking' ),
                            'desc'  => esc_html__( 'Allow to calculate tax in order', 'moviebooking' ),
                            'atts'  => array(
                                'id'    => 'enable_tax',
                                'class' => 'enable_tax',
                            ),
                            'name' => 'enable_tax',
                            'options' => array(
                                'yes'   => esc_html__( 'Yes', 'moviebooking' ),
                                'no'    => esc_html__( 'No', 'moviebooking' ),
                            ),
                            'default' => 'no'
                        ),
                        array(
                            'type'  => 'select',
                            'label' => esc_html__( 'Type', 'moviebooking' ),
                            'desc'  => esc_html__( 'Percentage(%) OR Fixed amount(n)', 'moviebooking' ),
                            'atts'  => array(
                                'id'    => 'type_tax',
                                'class' => 'type_tax',
                            ),
                            'name'  => 'type_tax',
                            'options' => array(
                                'percent'   => esc_html__( 'Percentage(%)', 'moviebooking' ),
                                'amount'    => esc_html__( 'Fixed amount(n)', 'moviebooking' ),
                            ),
                            'default' => 'percent'
                        ),
                        array(
                            'type'  => 'input',
                            'label' => esc_html__( 'Percentage(%)', 'moviebooking' ),
                            'atts'  => array(
                                'id'          => 'pecent_tax',
                                'class'       => 'pecent_tax',
                                'type'        => 'text',
                                'placeholder' => '10',
                            ),
                            'name'  => 'pecent_tax',
                        ),
                        array(
                            'type'  => 'input',
                            'label' => esc_html__( 'Fixed amount(n)', 'moviebooking' ),
                            'atts'  => array(
                                'id'          => 'amount_tax',
                                'class'       => 'amount_tax',
                                'type'        => 'text',
                                'placeholder' => '10',
                            ),
                            'name'  => 'amount_tax',
                        ),
                        array(
                            'type'  => 'checkbox',
                            'label' => esc_html__( 'Prices entered with tax', 'moviebooking' ),
                            'desc'  => esc_html__( 'Seat price', 'moviebooking' ),
                            'atts'  => array(
                                'id'    => 'prices_include_tax',
                                'class' => 'prices_include_tax',
                            ),
                            'name'  => 'prices_include_tax',
                            'options' => array(
                                'yes'   => esc_html__( 'Yes, I will enter prices inclusive of tax', 'moviebooking' ),
                                'no'    => esc_html__( 'No, I will enter prices exclusive of tax', 'moviebooking' ),
                            ),
                            'default' => 'no'
                        ),
                    ),
                ),
                array(
                    'title'     => esc_html__('Ticket Fee', 'moviebooking'),
                    'desc'      => '',
                    'fields'    => array(
                        array(
                            'type'  => 'select',
                            'label' => esc_html__( 'Enable', 'moviebooking' ),
                            'desc'  => esc_html__( 'Customers have to pay extra for each ticket', 'moviebooking' ),
                            'atts'  => array(
                                'id'    => 'enable_ticket_fee',
                                'class' => 'enable_ticket_fee',
                            ),
                            'name' => 'enable_ticket_fee',
                            'options' => array(
                                'yes'   => esc_html__( 'Yes', 'moviebooking' ),
                                'no'    => esc_html__( 'No', 'moviebooking' ),
                            ),
                            'default' => 'no'
                        ),
                        array(
                            'type'  => 'select',
                            'label' => esc_html__( 'Type', 'moviebooking' ),
                            'desc'  => esc_html__( 'Percentage(%) OR Fixed amount(n)', 'moviebooking' ),
                            'atts'  => array(
                                'id'    => 'type_ticket_fee',
                                'class' => 'type_ticket_fee',
                            ),
                            'name'  => 'type_ticket_fee',
                            'options' => array(
                                'percent'   => esc_html__( 'Percentage(%)', 'moviebooking' ),
                                'amount'    => esc_html__( 'Fixed amount(n)', 'moviebooking' ),
                            ),
                            'default' => 'percent'
                        ),
                        array(
                            'type'  => 'input',
                            'label' => esc_html__( 'Percentage(%)', 'moviebooking' ),
                            'atts'  => array(
                                'id'          => 'pecent_ticket_fee',
                                'class'       => 'pecent_ticket_fee',
                                'type'        => 'text',
                                'placeholder' => '10',
                            ),
                            'name'  => 'pecent_ticket_fee',
                        ),
                        array(
                            'type'  => 'input',
                            'label' => esc_html__( 'Fixed amount(n)', 'moviebooking' ),
                            'atts'  => array(
                                'id'          => 'amount_ticket_fee',
                                'class'       => 'amount_ticket_fee',
                                'type'        => 'text',
                                'placeholder' => '10',
                            ),
                            'name'  => 'amount_ticket_fee',
                        ),
                    ),
                ),
                array(
                    'title'     => esc_html__('Discount', 'moviebooking'),
                    'desc'      => '',
                    'fields'    => array(
                        array(
                            'type'  => 'select',
                            'label' => esc_html__( 'Enable', 'moviebooking' ),
                            'desc'  => esc_html__( 'Allow customers to enter discount on Cart page', 'moviebooking' ),
                            'atts'  => array(
                                'id'    => 'enable_discount',
                                'class' => 'enable_discount',
                            ),
                            'name' => 'enable_discount',
                            'options' => array(
                                'yes'   => esc_html__( 'Yes', 'moviebooking' ),
                                'no'    => esc_html__( 'No', 'moviebooking' ),
                            ),
                            'default' => 'yes'
                        ),
                    ),
                ),
            );
        }
    }

    $GLOBALS['mb_tax_settings'] = new MB_Setting_Tax();
}