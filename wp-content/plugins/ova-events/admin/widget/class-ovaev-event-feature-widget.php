<?php

// Creating the widget 
class ova_event_feature_widget extends WP_Widget {

    function __construct() {

        $widget_ops = array(
            'classname'                   => 'widget_feature_event',
            'description'                 => esc_html__( 'Get feature event', 'ovaev' ),
            'customize_selective_refresh' => true,
        );
        parent::__construct( 'event_feature', esc_html__( 'Feature Event', 'ovaev' ), $widget_ops );
    }

    public function widget( $args, $instance ) {

        $title = apply_filters( 'widget_title', $instance['title'] );

        $title = ! empty( $title ) ? $title : esc_html__( 'Featured Event', 'ovaev' );

        $count = isset( $instance['count'] ) ? $instance['count'] : 5;

        echo $args['before_widget'];

        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        // Basic
        $args_event_basic = array(

            'post_type' => 'event',
            'posts_per_page' => $count,
            'meta_query' => array(
                array(
                    'key'     => 'ovaev_special',
                    'value'   => 'checked',
                    'compare' => '=',
                ),
            )
            
        );


        // Query with Category (Type)
        $args_event_tax = array();

        $selected_categories = $instance['wcw_selected_categories'] ? $instance['wcw_selected_categories'] : '';
        $wcw_action_on_cat = $instance['wcw_action_on_cat'] ? $instance['wcw_action_on_cat'] : '';

        if( $wcw_action_on_cat == 'include' ){

            $args_event_tax = array(

                'tax_query' => array(
                    array(
                        'taxonomy' => 'event_category',
                        'field'    => 'term_id',
                        'terms'    => $selected_categories,
                        'operator' => 'IN',
                    ),
                )

            );

        }else if( $wcw_action_on_cat == 'exclude' ){

            $args_event_tax = array(

                'tax_query' => array(
                    array(
                        'taxonomy' => 'event_category',
                        'field'    => 'term_id',
                        'terms'    => $selected_categories,
                        'operator' => 'NOT IN',
                    ),
                )
                
            );

        }

        $args_event = array_merge( $args_event_basic, $args_event_tax );
    

        $events = get_posts( $args_event );

        echo ovaev_get_template( 'widgets/feature_event.php', array( 'events' => $events ) );

        echo $args['after_widget'];

    }

    public function form( $instance ) {
       
        // Defaults.
        $instance     = wp_parse_args( (array) $instance, array( 'title' => 'Feature Event','count'=>'5' ) );
        $wcw_selected_categories    = (! empty( $instance['wcw_selected_categories'] ) && ! empty( $instance['wcw_action_on_cat'] ) ) ? $instance['wcw_selected_categories'] : esc_html__( '', 'ovaev' );
        $wcw_action_on_cat          = ! empty( $instance['wcw_action_on_cat'] ) ? $instance['wcw_action_on_cat'] : esc_html__( '', 'ovaev' );

        ?>
        <p>
            <label>
                <?php esc_html_e( 'Title:', 'ovaev' ); ?>
            </label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
        </p>

        <p>
            <label>
                <?php esc_html_e( 'Count:', 'ovaev' ); ?>
            </label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $instance['count'] ); ?>" />
        </p>

        <div class="wcwmultiselect">

            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'wcw_action_on_cat' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'wcw_action_on_cat' ) ); ?>">
               <option value="" <?php selected($wcw_action_on_cat,'' )?> >Show All Category:</option>       
               <option value="include" <?php selected($wcw_action_on_cat,'include' )?> >Include Selected Category:</option>       
               <option value="exclude" <?php selected($wcw_action_on_cat,'exclude' )?> >Exclude Selected Category:</option>
            </select>

            <div class="wcwcheckboxes" id="wcwcb-<?php echo esc_attr( $this->get_field_id( 'wcw_action_on_cat' ) ); ?>">
            <?php           
                $i=0;
                   
                    $terms = get_terms( array(
                                'taxonomy' => 'event_category',
                            ) );

                    if ( $terms ) {
                        foreach ( $terms as $term ) {
                            echo '<label for="'.esc_attr( $this->get_field_id( 'wcw_action_on_cat' ) ).'-'.$i.'"><input type="checkbox" id="'.esc_attr( $this->get_field_id( 'wcw_action_on_cat' ) ).'-'.$i.'"  '.checked(true, ($wcw_selected_categories!='' ? in_array($term->term_id,$wcw_selected_categories) : ($wcw_selected_categories=='' ? true : '')), false).' name="'.esc_attr( $this->get_field_name( 'wcw_selected_categories' ) ).'[]" value="'.$term->term_id.'"/>'.$term->name.'</label></br>';
                            $i++;
                        }
                    }

                ?>   
              
             
            </div>

          </div>
    

        <?php 
    }

    public function update( $new_instance, $old_instance ) {
        $instance                 = $old_instance;
        $instance['title']        = sanitize_text_field( $new_instance['title'] );
        $instance['count']        = sanitize_text_field( $new_instance['count'] );
        $instance['wcw_selected_categories']    = ( ! empty( $new_instance['wcw_selected_categories'] ) ) ? $new_instance['wcw_selected_categories'] : '';
        $instance['wcw_action_on_cat']          = ( ! empty( $new_instance['wcw_action_on_cat'] ) ) ? $new_instance['wcw_action_on_cat'] : '';

        return $instance;
    }

    static function check_widget() {
        if (is_active_widget(false,false,'event_feature',true)) {
          wp_enqueue_style( 'owl-carousel', OVAEV_PLUGIN_URI.'assets/libs/owl-carousel/assets/owl.carousel.min.css' );
          wp_enqueue_script( 'owl-carousel', OVAEV_PLUGIN_URI.'assets/libs/owl-carousel/owl.carousel.min.js', array('jquery'), false, true );
        }
    }

} 

function ovaev_event_feature_load_widget() {
    register_widget( 'ova_event_feature_widget' );
}

add_action( 'widgets_init', 'ovaev_event_feature_load_widget' );
add_action ('init','ova_event_feature_widget::check_widget');