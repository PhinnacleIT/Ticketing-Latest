<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MB_Abstract_Setting' ) ) {

    abstract class MB_Abstract_Setting extends MB_Setting {
        public $_id             = null;
        protected $_title       = null;
        protected $_fields      = array();
        public $_tab            = false;
        public $_options        = null;
        protected $_position    = 1;

        public function __construct() {
            if ( is_admin() ) {
                add_filter( 'mb_admin_settings', array( $this, 'add_tab' ), $this->_position, 1 );
                add_action( 'mb_admin_setting_' . $this->_id . '_content', array( $this, 'layout' ), $this->_position, 1 );
            }

            $this->options();

            add_filter( 'mb_settings_field', array( $this, 'settings' ) );
        }

        public function settings( $settings ) {
            $settings[$this->_id] = $this;

            return $settings;
        }

        public function add_tab( $tabs ) {
            if ( $this->_id && $this->_title ) {

                $tabs[$this->_id] = $this->_title;

                return $tabs;
            }
        }

        public function layout() { 
            // Before tab content
            do_action( 'mb_admin_setting_before_setting_tab', $this->_id );
            
            $this->_fields = apply_filters( 'mb_admin_setting_fields', $this->load_field(), $this->_id );

            if ( $this->_fields ) {
                $html = array();

                if ( $this->_tab ) {
                    $html[] = '<h3>';

                    $i = 0;

                    foreach( $this->_fields as $id => $groups ) {
                        $active = '';

                        // Get tab
                        $group = isset( $_GET['group'] ) && $_GET['group'] ? $_GET['group'] : '';

                        if ( $group && is_string( $group ) ) {
                            if ( $group === $id ) {
                                $active = ' active';
                            }
                        } else {
                            if ( $i == 0 ) $active = ' active';
                        }

                        $html[] = '<a href="#'.$id.'" id="' . esc_attr( $id ) . '" class="mb_tab_group'.$active.'">' . $groups['title'] . '</a>';

                        $i++;
                    }

                    $html[] = '</h3>';

                    $i = 0;

                    foreach( $this->_fields as $id => $groups ) {
                        $active = '';
                        
                        // Get tab
                        $group = isset( $_GET['group'] ) && $_GET['group'] ? $_GET['group'] : '';

                        if ( $group && is_string( $group ) ) {
                            if ( $group === $id ) {
                                $active = ' active';
                            }
                        } else {
                            if ( $i == 0 ) $active = ' active';
                        }

                        $html[] = '<div data-tab-id="' . $id . '" class="mb_tab_group_content'.$active.'">';
                        $html[] = isset($groups['desc']) ? '<div class="desc_tab">'.$groups['desc'].'</div>' : '';
                        $html[] = $this->generate_fields( $groups );
                        $html[] = '</div>';

                        $i++;
                    }
                } else {
                    $html[] = $this->generate_fields( $this->_fields );
                }

                echo implode( '', $html );
            }

            // After tab content
            do_action( 'mb_admin_setting_after_setting_tab' . $this->_id, $this->_id );
        }

        protected function load_field() {
            return array();
        }

        public function render_atts( $atts = array() ) {
            if ( ! is_array( $atts ) ) return;

            $html = array();

            foreach( $atts as $key => $value ) {

                if ( is_array( $value ) ) {
                    $value = implode( ' ', $value );
                }

                $html[] = $key . '="' . esc_attr( $value ) . '"';
            }

            return implode( ' ', $html );
        }

        protected function options() {

            if ( $this->_options ) return $this->_options;

            $options = parent::options();

            if ( ! $options ) $options = get_option( $this->_prefix, null );

            if ( isset( $options[$this->_id] ) ) return $this->_options = $options[$this->_id];

            return null;
        }

        public function get( $name = null, $default = null ) {
            if ( ! $this->_options ) $this->_options = $this->options();

            if ( $name && isset( $this->_options[$name] ) && !is_array( $this->_options[$name] ) ) return trim( $this->_options[$name] );

            if ( $name && isset( $this->_options[$name] ) && is_array( $this->_options[$name] ) ) return $this->_options[$name];

            return $default;
        }

        public function get_field_id( $name = null, $group = null ) {
            if ( ! $this->_prefix || ! $name ) return;

            if ( !$group ) $group = $this->_id;

            if ( $group ) return $this->_prefix . '_' . $group . '_' . $name;

            return $this->_prefix . '_' . $name;
        }

        public function get_field_name( $name = null, $group = null ) {
            if ( ! $this->_prefix || !$name ) return;
            
            if ( ! $group ) $group = $this->_id;

            if ( $group ) return $this->_prefix . '[' . $group . '][' . $name . ']';

            return $this->_prefix . '[' . $name . ']';
        }

        function generate_fields( $groups = array() ) {
            $html = array();

            foreach( $groups as $key => $group ) {
                if ( isset( $group['title'], $group['desc'] ) ) {
                    $html[] = '<h3>' . sprintf( '%s', $group['title'] ) . '</h3>';
                    $html[] = '<p>' . sprintf( '%s', $group['desc'] ) . '</p>';
                }

                if ( isset( $group['fields'] ) ) {
                    $html[] = '<table>';

                    foreach( $group['fields'] as $type => $field ) {
                        $default = array(
                            'type' => '',
                            'label' => '',
                            'desc' => '',
                            'atts' => array(
                                'id' => '',
                                'class' => ''
                            ),
                            'name' => '',
                            'group' => $this->_id ? $this->_id : null,
                            'options' => array(
                            ),
                            'default' => ''
                        );

                        if ( isset( $field['filter'] ) && $field['filter'] ) {
                            ob_start();
                            call_user_func_array( $field['filter'], array( $field ) );
                            $html[] = ob_get_clean();
                        } elseif ( isset( $field['name'], $field['type'] ) ) {
                            $html[] = '<tr>';

                            // label
                            $html[] = '<th><label for="' . $this->get_field_id( $field['name'] ) . '">' . sprintf( '%s', $field['label'] ) . '</label>';

                            if ( isset( $field['desc'] ) ) {
                                $html[] = '<p><small>' . sprintf( '%s', $field['desc'] ) . '</small></p>';
                            }

                            $html[] = '</th>';
                            // end label
                            // field
                            $html[] = '<td>';

                            $field = wp_parse_args( $field, $default );

                            ob_start();
                            include MB_PLUGIN_INC . 'admin/views/settings/fields/' . $field['type'] . '.php';
                            $html[] = ob_get_clean();

                            $html[] = '</td>';
                            // end field

                            $html[] = '</tr>';
                        }
                    }

                    $html[] = '</table>';
                }
            }

            return implode( '', $html );
        }
    }
}