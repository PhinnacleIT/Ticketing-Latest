<?php if (!defined( 'ABSPATH' )) exit;

if( !class_exists('Aovis_Metaboxes') ){
    
    class Aovis_Metaboxes {

        public $prefix = 'ova_met_';

        public function __construct() {
            add_action( 'add_meta_boxes', array( $this, 'add' ) );
            add_action( 'save_post', array($this, 'save') );
        }

        function add(){

            // General Setting
            add_meta_box(
                $this->prefix.'general_setting',          // Unique ID
                esc_html__('General Setting', 'ova-framework'), // Box title
                array( $this, 'general_setting' ),   // Content callback, must be of type callable
                apply_filters( 'aovis_set_header_version' ,array( 'post', 'page' ) )                  // Post type
            );

            // Post Format Setting
            add_meta_box(
                $this->prefix.'embed_setting',          // Unique ID
                esc_html__('Embed setting', 'ova-framework'), // Box title
                array( $this, 'embed_setting' ),   // Content callback, must be of type callable
                array( 'post' ),
                'side', // priority
                'high' // position
            );

            add_meta_box(
                $this->prefix.'gallery_setting',
                esc_html__('Gallery', 'ova-framework'),
                array( $this, 'galery_setting' ),
                array( 'post', 'movie' ),
                'side',
                'high'
            );
        }

        function save( int $post_id  ){

            // Header Version
            if ( array_key_exists(  $this->prefix.'header_version', $_POST ) ) {
                update_post_meta(
                    $post_id,
                    $this->prefix.'header_version',
                    $_POST[$this->prefix.'header_version']
                );
            }

            // Footer Version
            if ( array_key_exists(  $this->prefix.'footer_version', $_POST ) ) {
                update_post_meta(
                    $post_id,
                    $this->prefix.'footer_version',
                    $_POST[$this->prefix.'footer_version']
                );
            }

            // Main layout
            if ( array_key_exists(  $this->prefix.'main_layout', $_POST ) ) {
                update_post_meta(
                    $post_id,
                    $this->prefix.'main_layout',
                    $_POST[$this->prefix.'main_layout']
                );
            }

            // Wide layout
            if ( array_key_exists(  $this->prefix.'wide_site', $_POST ) ) {
                update_post_meta(
                    $post_id,
                    $this->prefix.'wide_site',
                    $_POST[$this->prefix.'wide_site']
                );
            }

            // Primary Color
            if ( array_key_exists(  $this->prefix.'primary_font', $_POST ) ) {
                update_post_meta(
                    $post_id,
                    $this->prefix.'primary_font',
                    $_POST[$this->prefix.'primary_font']
                );
            }

            // Primary Color
            if ( array_key_exists(  $this->prefix.'primary_color', $_POST ) ) {
                update_post_meta(
                    $post_id,
                    $this->prefix.'primary_color',
                    $_POST[$this->prefix.'primary_color']
                );
            }

            // Embed Media
            if ( array_key_exists(  $this->prefix.'embed_media', $_POST ) ) {
                update_post_meta(
                    $post_id,
                    $this->prefix.'embed_media',
                    $_POST[$this->prefix.'embed_media']
                );
            }

            // Save
            if (!isset($_POST['gallery_meta_nonce']) || !wp_verify_nonce($_POST['gallery_meta_nonce'], basename(__FILE__))) return;
            if (!current_user_can('edit_post', $post_id)) return;
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

            if(isset($_POST[$this->prefix.'gallery_id'])) {
                update_post_meta($post_id, $this->prefix.'gallery_id', $_POST[$this->prefix.'gallery_id']);
            } else {
                delete_post_meta($post_id, $this->prefix.'gallery_id');
            }
            
        }

        function general_setting( $post ) {

            // Header Version
            $header_selected = get_post_meta( $post->ID, $this->prefix.'header_version', true );

            $list_header = apply_filters('aovis_list_header', '') != '' ? array_merge( array( 'global' => 'Global' ),  apply_filters('aovis_list_header', '') ) : array( 'global' => 'Global' );
            ?>
            <label for="<?php echo $this->prefix.'header_version' ?>">
                <?php esc_html_e('Header Version', 'ova-framework'); ?>
            </label>

            <select name="<?php echo $this->prefix.'header_version' ?>" id="<?php echo $this->prefix.'header_version' ?>" class="postbox">
                <?php foreach ($list_header as $key => $value) { ?>
                    <option value="<?php echo $key ?>" <?php selected( $header_selected, $key ); ?>>
                        <?php echo $value; ?>
                    </option>
                <?php } ?>
            </select>

            <br><br>
            <?php

            // Footer Version
            $footer_selected = get_post_meta( $post->ID, $this->prefix.'footer_version', true );

            $list_footer = apply_filters('aovis_list_footer', '') != '' ? array_merge( array( 'global' => 'Global' ),  apply_filters('aovis_list_footer', '') ) : array( 'global' => 'Global' );
            ?>
            <label for="<?php echo $this->prefix.'footer_version' ?>">
                <?php esc_html_e('Footer Version', 'ova-framework'); ?>
            </label>

            <select name="<?php echo $this->prefix.'footer_version' ?>" id="<?php echo $this->prefix.'footer_version' ?>" class="postbox">
                <?php foreach ($list_footer as $key => $value) { ?>
                    <option value="<?php echo $key ?>" <?php selected( $footer_selected, $key ); ?>>
                        <?php echo $value; ?>
                    </option>
                <?php } ?>
            </select>

            <br><br>
            <?php

            // Main layout
            $layout_selected = get_post_meta( $post->ID, $this->prefix.'main_layout', true );

            $layouts = apply_filters('aovis_define_layout', '') != '' ? array_merge( array( 'global' => 'Global' ),  apply_filters('aovis_define_layout', '') ) : array( 'global' => 'Global' );
            ?>
            <label for="<?php echo $this->prefix.'main_layout' ?>">
                <?php esc_html_e('Main layout', 'ova-framework'); ?>
            </label>

            <select name="<?php echo $this->prefix.'main_layout' ?>" id="<?php echo $this->prefix.'main_layout' ?>" class="postbox">
                <?php foreach ($layouts as $key => $value) { ?>
                    <option value="<?php echo $key ?>" <?php selected( $layout_selected, $key ); ?>>
                        <?php echo $value; ?>
                    </option>
                <?php } ?>
            </select>

            <br><br>
            <?php

            // Wide site
            $wide_site_selected = get_post_meta( $post->ID, $this->prefix.'wide_site', true );

            $wide_site = apply_filters('aovis_define_wide_boxed', '') != '' ? array_merge( array( 'global' => 'Global' ),  apply_filters('aovis_define_wide_boxed', '') ) : array( 'global' => 'Global' );
            ?>
            <label for="<?php echo $this->prefix.'wide_site' ?>">
                <?php esc_html_e('Wide Site', 'ova-framework'); ?>
            </label>

            <select name="<?php echo $this->prefix.'wide_site' ?>" id="<?php echo $this->prefix.'wide_site' ?>" class="postbox">
                <?php foreach ($wide_site as $key => $value) { ?>
                    <option value="<?php echo $key ?>" <?php selected( $wide_site_selected, $key ); ?>>
                        <?php echo $value; ?>
                    </option>
                <?php } ?>
            </select>
            <br><br>
            <?php
                if ( function_exists( 'aovis_default_primary_font' ) ) {
                    $default_primary_font   = json_decode( aovis_default_primary_font() );
                    $primary_font_global    = json_decode( get_theme_mod( 'primary_font' ) ) ? json_decode( get_theme_mod( 'primary_font' ) ) : $default_primary_font;
                    $primary_font_family    = $primary_font_global->font;
                    $custom_primary_font    = get_post_meta( $post->ID, $this->prefix.'primary_font', true );
                    $primary_font           = '';

                    if ( $custom_primary_font ) {
                        $custom_primary_font_args = explode( ':', $custom_primary_font );

                        if ( isset( $custom_primary_font_args[0] ) && $custom_primary_font_args[0] ) {
                            $primary_font = $custom_primary_font_args[0];
                        }
                    }

                    $all_fonts = $this->get_all_font();

                    if ( ! empty( $all_fonts ) && is_array( $all_fonts ) ) {
                        ?>
                        <label for="<?php echo esc_attr( $this->prefix.'primary_font' ); ?>">
                            <?php esc_html_e('Primary Font', 'ova-framework'); ?>
                        </label>
                        <select name="<?php echo esc_attr( $this->prefix.'primary_font' ); ?>">
                            <option value=""><?php esc_html_e('Global', 'ova-framework'); ?></option>
                        <?php
                        foreach( $all_fonts as $fonts ) {
                            $font = $fonts->family . ':' . implode( ',', $fonts->variants );
                            if ( $fonts->family === $primary_font ) {
                                ?>
                                <option value="<?php esc_attr_e( $font ); ?>" selected>
                                    <?php echo esc_html( $fonts->family ); ?>
                                </option>
                                <?php
                            } else {
                                ?>
                                <option value="<?php esc_attr_e( $font ); ?>">
                                    <?php echo esc_html( $fonts->family ); ?>
                                </option>
                                <?php
                            }
                        }
                        ?>
                        </select>
                        <br><br>
                        <?php
                    }
                }
            ?>
            <label for="<?php echo esc_attr( $this->prefix.'primary_color' ); ?>">
                <?php esc_html_e('Primary Color', 'ova-framework'); ?>
            </label>
            <input 
                type="text" 
                name="<?php echo esc_attr( $this->prefix.'primary_color' ); ?>" 
                value="" />
            <?php
        }

        function embed_setting( $post ){

            // Embed Media
            $header_selected = get_post_meta( $post->ID, $this->prefix.'embed_media', true );
            ?>
            <label for="<?php echo $this->prefix.'embed_media' ?>">
                <?php esc_html_e('Embed Video Link', 'ova-framework'); ?>
            </label>

            <input type="text" name="<?php echo $this->prefix.'embed_media' ?>" value="<?php echo $header_selected; ?>" id="<?php echo $this->prefix.'embed_media' ?>" class="postbox" />
            <?php

        }

        
        
        function galery_setting( $post ) {

           wp_nonce_field( basename(__FILE__), 'gallery_meta_nonce' );
           $ids = get_post_meta($post->ID, $this->prefix.'gallery_id', true);
            ?>
             <table class="form-table ova_metabox_gallery">
                <tr>
                    <td>
                        <a class="gallery-add button" href="#" data-uploader-title="<?php esc_html_e( 'Add Images', 'ova-framework' ) ?>" data-uploader-button-text="<?php esc_html_e( 'Add Images', 'ova-framework' ) ?>">
                            <?php esc_html_e( 'Add Images', 'ova-framework' ) ?>
                        </a>

                        <ul id="gallery-metabox-list">
                            <?php if ($ids) : foreach ($ids as $key => $value) : $image = wp_get_attachment_image_src($value); ?>
                            <li>
                               <input type="hidden" name="<?php echo $this->prefix.'gallery_id';?>[<?php echo $key; ?>]" value="<?php echo $value; ?>">

                               <img class="image-preview" src="<?php echo $image[0]; ?>">

                               <a class="change-image button button-small" href="#" data-uploader-title="<?php esc_html_e( 'Change Image', 'ova-framework' ) ?>" data-uploader-button-text="<?php esc_html_e( 'Change Image', 'ova-framework' ) ?>" title="<?php esc_html_e( 'Delete image', 'ova-framework' ); ?>">
                                    <?php esc_html_e( 'Change', 'ova-framework' ) ?>
                                </a>
                                <br>
                               <small>
                                <a class="remove-image" href="#" title="<?php esc_html_e( 'Delete image', 'ova-framework' ); ?>">
                                    <?php esc_html_e( 'Delete', 'ova-framework' ); ?>
                                </a>
                                </small>
                            </li>
                            <?php endforeach; endif; ?>
                        </ul>

                    </td>
                </tr>
            </table>
         <?php
        }
       
        function get_all_font() {
            $fontFile = AOVIS_URI . '/customize/custom-control/api/google-fonts-alphabetical.json';

            $request = wp_remote_get( $fontFile );

            if ( is_wp_error( $request ) ) {
                return "";
            }

            $body       = wp_remote_retrieve_body( $request );
            $content    = json_decode( $body );

            $all_fonts = $content->items;

            if ( get_theme_mod('ova_custom_font','') != '' ) {

                $list_custom_font = explode( '|', get_theme_mod('ova_custom_font' ) );

                foreach( $list_custom_font as $key => $font ) {

                    $cus_font = json_decode( $font );
                    $cus_font_family = $cus_font['0'];
                    $cus_font_weight = explode( ':', $cus_font['1'] );

                    $all_fonts[] = json_decode(json_encode( array(
                        "kind"      => "webfonts#webfont",
                        "family"    => $cus_font_family,
                        "category"  => "sans-serif",
                        "variants"  => $cus_font_weight,
                    ) ) );
                }
            }
            
            return $all_fonts;
        }
    }
}



return new Aovis_Metaboxes();