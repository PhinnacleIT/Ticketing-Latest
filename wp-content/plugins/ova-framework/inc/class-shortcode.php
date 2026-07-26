<?php if (!defined( 'ABSPATH' )) exit;

if( !class_exists('Aovis_Shortcode') ){
    
    class Aovis_Shortcode {

        public function __construct() {

            add_shortcode( 'aovis-elementor-template', array( $this, 'aovis_elementor_template' ) );
            
        }

        public function aovis_elementor_template( $atts ){

            $atts = extract( shortcode_atts(
            array(
                'id'  => '',
            ), $atts) );

            $args = array(
                'id' => $id
                
            );

            if( did_action( 'elementor/loaded' ) ){
                return Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $id );    
            }
            return;

            
        }

        

    }
}



return new Aovis_Shortcode();

