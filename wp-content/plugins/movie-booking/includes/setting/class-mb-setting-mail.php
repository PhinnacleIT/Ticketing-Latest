<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MB_Setting_Mail' ) ) {

    class MB_Setting_Mail extends MB_Abstract_Setting {
        public $_id         = 'mail';
        public $_title      = null;
        public $_position   = 13;
        public $_tab        = true;

        public function __construct() {
            $this->_title = esc_html__('Mail', 'moviebooking');

            add_filter( 'mb_admin_setting_fields', array( $this, 'mb_generate_fields_mail' ), 10, 2 );

            parent::__construct();
        }

        public function mb_generate_fields_mail( $groups, $id = 'mail' ) {
            if ( $id == 'mail' ) {
                $groups[$id . '_booking_mail'] = apply_filters( 'mb_admin_setting_fields_booking_mail', $this->mb_admin_setting_fields_booking_mail(), $this->id );
                $groups[$id . '_remind_mail'] = apply_filters( 'mb_admin_setting_fields_remind_mail', $this->mb_admin_setting_fields_remind_mail(), $this->id );
                $groups[$id . '_cancel'] = apply_filters( 'mb_admin_setting_fields_cancel', $this->mb_admin_setting_fields_cancel_mail(), $this->id );
            }

            return $groups;
        }

        public function mb_admin_setting_fields_booking_mail() {
            return array(
                'title'     => esc_html__('New Order', 'moviebooking'),
                'desc'      => '',
                array(
                    'fields'    => array(
                        array(
                            'type'  => 'select',
                            'label' => esc_html__( 'Enable', 'moviebooking' ),
                            'desc'  => esc_html__( 'Allow to send an email after a customer books an event successfully.', 'moviebooking' ),
                            'atts'  => array(
                                'id'    => 'enable_send_booking_email',
                                'class' => 'enable_send_booking_email',
                            ),
                            'name' => 'enable_send_booking_email',
                            'options' => array(
                                'yes'   => esc_html__( 'Yes', 'moviebooking' ),
                                'no'    => esc_html__( 'No', 'moviebooking' ),
                            ),
                            'default' => 'yes'
                        ),
                        array(
                            'type'  => 'select',
                            'label' => esc_html__( 'Send email to', 'moviebooking' ),
                            'desc'  => esc_html__( 'Send email to Admin, Customer', 'moviebooking' ),
                            'name'  => 'mail_new_booking_sendmail',
                            'atts'  => array(
                                'id'        => 'mail_new_booking_sendmail',
                                'class'     => 'mail_new_booking_sendmail',
                                'multiple'  => 'multiple'
                            ),
                            'options' => array(
                                'admin'     => esc_html__( 'Admin', 'moviebooking' ),
                                'customer'  => esc_html__( 'Customer', 'moviebooking' ),
                            ),
                            'default' => array( 'admin', 'customer' )
                        ),
                        array(
                            'name'      => 'mail_new_recipient',
                            'type'      => 'input',
                            'label'     => esc_html__('Recipient(s)', 'moviebooking'),
                            'desc'      => esc_html__('Add recipient\'s email addresses (use comma seperated to add more email addresses).', 'moviebooking'),
                            'default'   => '',
                            'atts'      => array(
                                'type'          => 'text',
                                'id'            => 'mail_new_recipient',
                                'class'         => 'mail_new_recipient',
                                'placeholder'   => esc_html__('new_email@gmail.com', 'moviebooking'),
                            ),
                        ),
                        array(
                            'name'      => 'mail_new_subject',
                            'type'      => 'input',
                            'label'     => esc_html__('Subject', 'moviebooking'),
                            'desc'      => esc_html__('The subject displays in mail list', 'moviebooking'),
                            'default'   => esc_html__('Booking Ticket Success', 'moviebooking'),
                            'atts'      => array(
                                'type'          => 'text',
                                'id'            => 'mail_new_subject',
                                'class'         => 'mail_new_subject',
                                'placeholder'   => esc_html__('Booking Ticket Success', 'moviebooking'),
                            ),
                        ),
                        array(
                            'name'      => 'mail_new_from_name',
                            'type'      => 'input',
                            'label'     => esc_html__('From name', 'moviebooking'),
                            'desc'      => esc_html__('The subject displays in mail detail', 'moviebooking'),
                            'default'   => esc_html__('Booking Ticket Success', 'moviebooking'),
                            'atts'      => array(
                                'type'          => 'text',
                                'id'            => 'mail_new_from_name',
                                'class'         => 'mail_new_from_name',
                                'placeholder'   => esc_html__('Booking Ticket Success', 'moviebooking'),
                            ),
                        ),
                        array(
                            'name'      => 'mail_new_admin_email',
                            'type'      => 'input',
                            'label'     => esc_html__('Send from email', 'moviebooking'),
                            'desc'      => esc_html__('Customers will know them to receive mail from which email address is.', 'moviebooking'),
                            'default'   => get_option( 'admin_email' ),
                            'atts'      => array(
                                'type'          => 'text',
                                'id'            => 'mail_new_admin_email',
                                'class'         => 'mail_new_admin_email',
                                'placeholder'   => get_option('admin_email'),
                            ),
                        ),
                        array(
                            'name'      => 'mail_new_template',
                            'type'      => 'editor',
                            'label'     => esc_html__('Email Content', 'moviebooking'),
                            'desc'      => __('Use tags to generate email template.<br/>
                                Movie: [mb_movie]<br/>
                                Booking: #[mb_booking]<br/>
                                Date: [mb_date]<br/>
                                Room: [mb_room]<br/>
                                Seat: [mb_seat]<br/>
                                Area: [mb_area]<br/>
                                Extra Service: [mb_extra_service]<br/>
                                Address: [mb_address]<br/>
                                [mb_total]<br/>
                                Customer: [mb_customer]<br/>
                                Phone: [mb_phone]<br/>
                                Email: [mb_email]<br/>', 'moviebooking'),
                            'default'   => '',
                            'atts'      => array(
                                'type'          => 'text',
                                'id'            => 'mail_new_template',
                                'class'         => 'mail_new_template',
                                'placeholder'   => esc_html__('Email Content', 'moviebooking'),
                                'cols'          => 50,
                                'rows'          => 20,
                            ),
                        ),
                        array(
                            'name'      => 'ticket_logo',
                            'type'      => 'upload_image',
                            'label'     => esc_html__('Ticket Logo', 'moviebooking'),
                            'desc'      => __('Add ticket logo (.jpg, .png)<br>Recommended size: 130x50(px)', 'moviebooking'),
                            'default'   => '',
                            'atts'      => array(
                                'type'          => 'hidden',
                                'id'            => 'ticket_logo',
                                'class'         => 'ticket_logo',
                            ),
                        ),
                        array(
                            'name'      => 'ticket_border_color',
                            'type'      => 'input',
                            'label'     => esc_html__('Ticket Border Color', 'moviebooking'),
                            'default'   => '',
                            'atts'      => array(
                                'type'          => 'text',
                                'id'            => 'ticket_border_color',
                                'class'         => 'ticket_border_color mb-colorpicker',
                            ),
                        ),
                        array(
                            'name'      => 'ticket_label_color',
                            'type'      => 'input',
                            'label'     => esc_html__('Ticket Label Color', 'moviebooking'),
                            'default'   => '',
                            'atts'      => array(
                                'type'          => 'text',
                                'id'            => 'ticket_label_color',
                                'class'         => 'ticket_label_color mb-colorpicker',
                            ),
                        ),
                        array(
                            'name'      => 'ticket_content_color',
                            'type'      => 'input',
                            'label'     => esc_html__('Ticket Content Color', 'moviebooking'),
                            'default'   => '',
                            'atts'      => array(
                                'type'          => 'text',
                                'id'            => 'ticket_content_color',
                                'class'         => 'ticket_content_color mb-colorpicker',
                            ),
                        ),
                    ),
                ),
            );
        }

        public function mb_admin_setting_fields_remind_mail() {
            return array(
                'title'     => esc_html__('Remind', 'moviebooking'),
                'desc'      => '',
                array(
                    'fields'    => array(
                        array(
                            'type'  => 'select',
                            'label' => esc_html__( 'Enable', 'moviebooking' ),
                            'desc'  => esc_html__( 'Remind customer about event start time that they registered.', 'moviebooking' ),
                            'atts'  => array(
                                'id'    => 'enable_remind_mail',
                                'class' => 'enable_remind_mail',
                            ),
                            'name' => 'enable_remind_mail',
                            'options' => array(
                                'yes'   => esc_html__( 'Yes', 'moviebooking' ),
                                'no'    => esc_html__( 'No', 'moviebooking' ),
                            ),
                            'default' => 'no'
                        ),
                        array(
                            'name'      => 'remind_mail_before_xday',
                            'type'      => 'input',
                            'label'     => esc_html__('Before x day', 'moviebooking'),
                            'desc'      => esc_html__('Send mail x days before the event starts', 'moviebooking'),
                            'default'   => 3,
                            'atts'      => array(
                                'type'          => 'number',
                                'id'            => 'remind_mail_before_xday',
                                'class'         => 'remind_mail_before_xday',
                                'placeholder'   => esc_html__('Number', 'moviebooking'),
                            ),
                        ),
                        array(
                            'name'      => 'remind_mail_send_per_seconds',
                            'type'      => 'input',
                            'label'     => esc_html__('Send a mail every x seconds', 'moviebooking'),
                            'desc'      => esc_html__('You can setup 86400 to send 1 time per day', 'moviebooking'),
                            'default'   => 86400,
                            'atts'      => array(
                                'type'          => 'number',
                                'id'            => 'remind_mail_send_per_seconds',
                                'class'         => 'remind_mail_send_per_seconds',
                                'placeholder'   => esc_html__('Number', 'moviebooking'),
                            ),
                        ),
                        array(
                            'name'      => 'remind_mail_subject',
                            'type'      => 'input',
                            'label'     => esc_html__('Subject', 'moviebooking'),
                            'desc'      => esc_html__('The subject displays in mail list', 'moviebooking'),
                            'default'   => esc_html__('Remind the movie start time', 'moviebooking'),
                            'atts'      => array(
                                'type'          => 'text',
                                'id'            => 'remind_mail_subject',
                                'class'         => 'remind_mail_subject',
                                'placeholder'   => esc_html__('Text', 'moviebooking'),
                            ),
                        ),
                        array(
                            'name'      => 'remind_mail_from_name',
                            'type'      => 'input',
                            'label'     => esc_html__('From name', 'moviebooking'),
                            'desc'      => esc_html__('The subject displays in mail detail', 'moviebooking'),
                            'default'   => esc_html__('Remind the movie start time', 'moviebooking'),
                            'atts'      => array(
                                'type'          => 'text',
                                'id'            => 'remind_mail_from_name',
                                'class'         => 'remind_mail_from_name',
                                'placeholder'   => esc_html__('Text', 'moviebooking'),
                            ),
                        ),
                        array(
                            'name'      => 'remind_mail_admin_email',
                            'type'      => 'input',
                            'label'     => esc_html__('Send from email', 'moviebooking'),
                            'desc'      => esc_html__('Customers will know them to receive mail from which email address is.', 'moviebooking'),
                            'default'   => get_option( 'admin_email' ),
                            'atts'      => array(
                                'type'          => 'text',
                                'id'            => 'remind_mail_admin_email',
                                'class'         => 'remind_mail_admin_email',
                                'placeholder'   => get_option('admin_email'),
                            ),
                        ),
                        array(
                            'name'      => 'remind_mail_template',
                            'type'      => 'editor',
                            'label'     => esc_html__('Email Content', 'moviebooking'),
                            'desc'      => __('Use tags to generate email template.<br/>
                                You booked the [mb_movie] movie at [mb_date].<br>
                                Booking: #[mb_booking]<br/>
                                Room: [mb_room]<br/>
                                Seat: [mb_seat]<br/>
                                Address: [mb_address]<br/>', 'moviebooking'),
                            'default'   => '',
                            'atts'      => array(
                                'type'          => 'text',
                                'id'            => 'remind_mail_template',
                                'class'         => 'remind_mail_template',
                                'placeholder'   => esc_html__('Email Content', 'moviebooking'),
                                'cols'          => 50,
                                'rows'          => 20,
                            ),
                        ),
                    ),
                ),
            );
        }

        public function mb_admin_setting_fields_cancel_mail() {
            return array(
                'title'     => esc_html__('Cancel', 'moviebooking'),
                'desc'      => '',
                array(
                    'fields'    => array(
                        array(
                            'type'  => 'select',
                            'label' => esc_html__( 'Enable', 'moviebooking' ),
                            'desc'  => esc_html__( 'Notify customers when Booking is canceled.', 'moviebooking' ),
                            'atts'  => array(
                                'id'    => 'enable_cancel_email',
                                'class' => 'enable_cancel_email',
                            ),
                            'name' => 'enable_cancel_email',
                            'options' => array(
                                'yes'   => esc_html__( 'Yes', 'moviebooking' ),
                                'no'    => esc_html__( 'No', 'moviebooking' ),
                            ),
                            'default' => 'no'
                        ),
                        array(
                            'name'      => 'cancel_email_subject',
                            'type'      => 'input',
                            'label'     => esc_html__('Subject', 'moviebooking'),
                            'desc'      => esc_html__('The subject displays in mail list', 'moviebooking'),
                            'default'   => esc_html__('Cancellation Booking', 'moviebooking'),
                            'atts'      => array(
                                'type'          => 'text',
                                'id'            => 'cancel_email_subject',
                                'class'         => 'cancel_email_subject',
                                'placeholder'   => esc_html__('Text', 'moviebooking'),
                            ),
                        ),
                        array(
                            'name'      => 'cancel_mail_from_name',
                            'type'      => 'input',
                            'label'     => esc_html__('From name', 'moviebooking'),
                            'desc'      => esc_html__('The subject displays in mail detail', 'moviebooking'),
                            'default'   => esc_html__('Cancellation Booking', 'moviebooking'),
                            'atts'      => array(
                                'type'          => 'text',
                                'id'            => 'cancel_mail_from_name',
                                'class'         => 'cancel_mail_from_name',
                                'placeholder'   => esc_html__('Text', 'moviebooking'),
                            ),
                        ),
                        array(
                            'name'      => 'cancel_mail_admin_email',
                            'type'      => 'input',
                            'label'     => esc_html__('Send from email', 'moviebooking'),
                            'desc'      => esc_html__('Customers will know them to receive mail from which email address is.', 'moviebooking'),
                            'default'   => get_option( 'admin_email' ),
                            'atts'      => array(
                                'type'          => 'text',
                                'id'            => 'cancel_mail_admin_email',
                                'class'         => 'cancel_mail_admin_email',
                                'placeholder'   => get_option('admin_email'),
                            ),
                        ),
                        array(
                            'name'      => 'cancel_mail_template',
                            'type'      => 'editor',
                            'label'     => esc_html__('Email Content', 'moviebooking'),
                            'desc'      => __('Use tags to generate email template.<br/>
                                Booking #[mb_booking] has been canceled.<br>
                                Movie #[mb_movie].<br>', 'moviebooking'),
                            'default'   => '',
                            'atts'      => array(
                                'type'          => 'text',
                                'id'            => 'cancel_mail_template',
                                'class'         => 'cancel_mail_template',
                                'placeholder'   => esc_html__('Email Content', 'moviebooking'),
                                'cols'          => 50,
                                'rows'          => 20,
                            ),
                        ),
                    ),
                ),
            );
        }
    }

    $GLOBALS['mb_mail_settings'] = new MB_Setting_Mail();
}