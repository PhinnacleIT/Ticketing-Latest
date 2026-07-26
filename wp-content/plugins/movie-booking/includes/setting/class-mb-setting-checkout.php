<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MB_Setting_Checkout' ) ) {

    class MB_Setting_Checkout extends MB_Abstract_Setting {
        public $_id         = 'checkout';
        public $_title      = null;
        public $_position   = 12;

        public function __construct() {
            $this->_title = esc_html__('Checkout', 'moviebooking');
            parent::__construct();
        }

        public function load_field() {
            return array(
                array(
                    'title'     => esc_html__('Checkout Settings', 'moviebooking'),
                    'desc'      => esc_html__('Checkout options', 'moviebooking'),
                    'fields'    => array(
                        array(
                            'type'  => 'select',
                            'label' => esc_html__( 'Allow to Add ticket when Order status: ', 'moviebooking' ),
                            'desc'  => esc_html__( 'Allow to add ticket, send ticket to customer\'s email', 'moviebooking' ),
                            'name'  => 'allow_add_ticket_by_order',
                            'atts'  => array(
                                'id'        => 'allow_add_ticket_by_order',
                                'class'     => 'allow_add_ticket_by_order',
                                'multiple'  => 'multiple'
                            ),
                            'options' => array(
                                'wc-completed'  => esc_html__( 'Completed', 'moviebooking' ),
                                'wc-processing' => esc_html__( 'Processing', 'moviebooking' ),
                                'wc-on-hold'    => esc_html__( 'Hold-on', 'moviebooking' )
                            ),
                            'default' => array( 'wc-completed', 'wc-processing' )
                        ),
                        array(
                            'type'  => 'select_product',
                            'label' => esc_html__( 'Choose a hidden product in Woocommerce', 'moviebooking' ),
                            'desc'  => esc_html__( 'This allow to booking a movie via WooCommerce', 'moviebooking' ),
                            'atts'  => array(
                                'id'    => 'wc_product_id',
                                'class' => 'wc_product_id mb_select2'
                            ),
                            'name' => 'wc_product_id',
                        ),
                        array(
                            'name'      => 'serect_key_qrcode',
                            'type'      => 'input',
                            'label'     => esc_html__('Secret Key QR Code', 'moviebooking'),
                            'desc'      => esc_html__('This key will attach to string to make QR Code.', 'moviebooking'),
                            'default'   => esc_html__('ovatheme.com', 'moviebooking'),
                            'atts'      => array(
                                'type'          => 'text',
                                'id'            => 'serect_key_qrcode',
                                'class'         => 'serect_key_qrcode',
                                'placeholder'   => esc_html__('ovatheme.com', 'moviebooking'),
                            ),
                        ),
                        array(
                            'type'  => 'select_page',
                            'label' => esc_html__('Thank you page', 'moviebooking'),
                            'desc'  => esc_html__('Redirect after booking successfully.', 'moviebooking'),
                            'atts'  => array(
                                'id'    => 'thanks_page',
                                'class' => 'thanks_page',
                            ),
                            'name' => 'thanks_page_id',
                        ),
                    ),
                ),
                array(
                    'title'     => esc_html__('Holding Ticket', 'moviebooking'),
                    'desc'      => '',
                    'fields'    => array(
                        array(
                            'type'  => 'select',
                            'label' => esc_html__( 'Enable', 'moviebooking' ),
                            'desc'  => esc_html__( 'Allows to hold the ticket until the payment is completed after a period of time', 'moviebooking' ),
                            'atts'  => array(
                                'id'    => 'enable_holding_ticket',
                                'class' => 'enable_holding_ticket'
                            ),
                            'name'  => 'enable_holding_ticket',
                            'options' => array(
                                'no'    => esc_html__( 'No', 'moviebooking' ),
                                'yes'   => esc_html__( 'Yes', 'moviebooking' )
                            ),
                            'default' => 'yes'
                        ),

                        array(
                            'name'      => 'holding_per_seconds',
                            'type'      => 'input',
                            'label'     => esc_html__('Check every x seconds', 'moviebooking'),
                            'desc'      => esc_html__('Run Cron to check ticket hold after x seconds', 'moviebooking'),
                            'default'   => '600',
                            'atts'      => array(
                                'type'  => 'number',
                                'id'    => 'holding_per_seconds',
                                'class' => 'holding_per_seconds'
                            ),
                        ),

                        array(
                            'name'      => 'max_time_complete_payment',
                            'type'      => 'input',
                            'label'     => esc_html__('Maximum time to complete payment', 'moviebooking'),
                            'desc'      => esc_html__('Booking will be deleted if the payment completion time is over x seconds', 'moviebooking'),
                            'default'   => '600',
                            'atts'      => array(
                                'type'  => 'number',
                                'id'    => 'max_time_complete_payment',
                                'class' => 'max_time_complete_payment'
                            ),
                        ),
                    ),
                ),
            );
        }
    }

    $GLOBALS['mb_checkout_settings'] = new MB_Setting_Checkout();
}