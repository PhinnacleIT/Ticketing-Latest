<?php
// Creating the widget 
class ova_tag_event_widget extends WP_Widget {

    function __construct() {

        $widget_ops = array(
            'classname'                   => 'widget_tag_cloud',
            'description'                 => esc_html__( 'Get list tag event', 'ovaev' ),
            'customize_selective_refresh' => true,
        );
        parent::__construct( 'event_tag', esc_html__( 'Tag Event' ), $widget_ops );
    }

    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );
        $title = ! empty( $title ) ? $title : esc_html__( 'Tags', 'ovaev' );
        
        echo $args['before_widget'];

        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }


        $args_tag = array(
           'taxonomy' => 'event_tag',
           'orderby' => 'name',
        );


        $categories = get_categories($args_tag);
        
        echo ovaev_get_template( 'widgets/tag_widget.php', array( 'categories' => $categories ) );

        echo $args['after_widget'];

    }

    public function form( $instance ) {
       
        // Defaults.
        $instance     = wp_parse_args( (array) $instance, array( 'title' => '' ) );
        $hierarchical = isset( $instance['hierarchical'] ) ? (bool) $instance['hierarchical'] : false;
        ?>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" /></p>

        <?php 
    }

    public function update( $new_instance, $old_instance ) {
        $instance                 = $old_instance;
        $instance['title']        = sanitize_text_field( $new_instance['title'] );

        return $instance;
    }

} 

function ovaev_tag_load_widget() {
    register_widget( 'ova_tag_event_widget' );
}

add_action( 'widgets_init', 'ovaev_tag_load_widget' );