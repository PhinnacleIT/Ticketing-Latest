<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MB_Admin_Importers' ) ) {
    class MB_Admin_Importers {

        public function __construct() {
            add_action( 'admin_menu', array( $this, 'add_to_menus' ) );
            add_action( 'admin_head', array( $this, 'hide_from_menus' ) );
            add_action( 'admin_init', array( $this, 'import_action' ) );
        }

        public function add_to_menus() {
            add_submenu_page(
                'edit.php?post_type=showtime',
                __( 'Showtimes Import', 'moviebooking' ),
                __( 'Showtimes Import', 'moviebooking' ),
                'import',
                'showtimes_importer',
                array( $this, 'showtimes_importer' ),
            );
        }

        public function hide_from_menus() {
            global $submenu;

            if ( isset( $submenu['edit.php?post_type=showtime'] ) && is_array( $submenu['edit.php?post_type=showtime'] ) ) {
                foreach( $submenu['edit.php?post_type=showtime'] as $k => $menu ) {
                    if ( isset( $menu[2] ) && $menu[2] === 'showtimes_importer' ) {
                        unset( $submenu['edit.php?post_type=showtime'][$k] );
                    }
                }
            }
        }

        public function showtimes_importer() {
            include MB_PLUGIN_INC . 'admin/views/importers/html-csv-showtimes.php';
        }

        public function import_action() {
            $showtime_action = isset( $_POST['showtime_action'] ) && $_POST['showtime_action'] ? sanitize_text_field( $_POST['showtime_action'] ) : '';

            if ( $showtime_action === 'import' ) {
                // Check Permission
                if ( ! current_user_can( apply_filters( 'mb_ft_import_showtimes_permission' ,'publish_posts' ) ) ) {
                    echo '<div class="notice notice-error is-dismissible">
                            <h2>'.esc_html__( 'You don\'t have permission to import showtimes', 'moviebooking' ).'</h2>
                        </div>';

                    return;
                }

                $file = isset( $_FILES['showtimes_file'] ) && $_FILES['showtimes_file'] ? $_FILES['showtimes_file'] : '';

                $upload_overrides = array(
                    'test_form' => false,
                    'mimes' => array(
                        'csv' => 'text/csv',
                        'txt' => 'text/plain',
                    ),
                );

                try {
                    $upload = wp_handle_upload( $file, $upload_overrides );
                } catch ( Exception $e ) {
                    $_POST['error'] = $e->getMessage();
                    add_action( 'admin_notices', array( $this, 'mb_show_admin_notice_error' ) );
                    return;
                }

                if ( isset( $upload['error'] ) && $upload['error'] ) {
                    $_POST['error'] = $upload['error'];
                    add_action( 'admin_notices', array( $this, 'mb_show_admin_notice_error' ) );
                    return;
                } else {
                    // Construct the object array.
                    $object = array(
                        'post_title'     => basename( $upload['file'] ),
                        'post_content'   => $upload['url'],
                        'post_mime_type' => $upload['type'],
                        'guid'           => $upload['url'],
                        'context'        => 'import',
                        'post_status'    => 'private',
                    );

                    // Save the data.
                    $id = wp_insert_attachment( $object, $upload['file'] );
                    wp_schedule_single_event( time() + DAY_IN_SECONDS, 'importer_scheduled_cleanup', array( $id ) );

                    $file_url = $upload['file'];
                    $handle = fopen( $file_url, "r" );

                    while ( ! feof( $handle ) ) {
                        $data[] = fgetcsv($handle);
                    }

                    fclose($handle);

                    if ( ! empty( $data ) && is_array( $data ) ) {
                        if ( count( $data ) === 1 ) {
                            $_POST['error'] = esc_html__( 'File empty!', 'moviebooking' );
                            add_action( 'admin_notices', array( $this, 'mb_show_admin_notice_error' ) );
                            return;
                        } else {
                            array_shift($data);

                            $data_import = array();

                            foreach( $data as $items ) {
                                $order = isset( $items[0] ) && $items[0] ? absint( $items[0] ) : '';
                                if ( ! $order ) {
                                    continue;
                                }

                                $data_showtime = array();

                                $title = isset( $items[1] ) && $items[1] ? $items[1] : '';
                                if ( ! $title ) {
                                    continue;
                                }

                                $status = isset( $items[2] ) && $items[2] ? $items[2] : 'draft';

                                $movie_id = isset( $items[3] ) && $items[3] ? absint( $items[3] ) : '';
                                if ( ! $movie_id ) {
                                    continue;
                                }

                                $date = isset( $items[4] ) && strtotime( $items[4] ) ? strtotime( $items[4] ) : '';
                                if ( ! $date ) {
                                    continue;
                                }

                                $room_ids = isset( $items[5] ) && $items[5] ? explode( '|', $items[5] ) : '';
                                if ( ! $room_ids ) {
                                    continue;
                                }

                                $city_id = isset( $items[6] ) && $items[6] ? absint( $items[6] ) : '';
                                if ( ! $city_id ) {
                                    continue;
                                }

                                $venue_id = isset( $items[7] ) && $items[7] ? absint( $items[7] ) : '';
                                if ( ! $venue_id ) {
                                    continue;
                                }

                                $address = isset( $items[8] ) && $items[8] ? $items[8] : '';

                                $data_showtime['title']       = $title;
                                $data_showtime['status']      = $status;
                                $data_showtime['movie_id']    = $movie_id;
                                $data_showtime['date']        = $date;
                                $data_showtime['room_ids']    = $room_ids;
                                $data_showtime['city_id']     = $city_id;
                                $data_showtime['venue_id']    = $venue_id;
                                $data_showtime['address']     = $address;

                                $data_import[$order] = $data_showtime;
                            }

                            if ( ! empty( $data_import ) && is_array( $data_import ) ) {
                                $prefix = MB_PLUGIN_PREFIX_SHOWTIME;

                                foreach ( $data_import as $order => $showtime ) {
                                    $postarr_import = array(
                                        'post_title'    => $showtime['title'],
                                        'post_status'   => $showtime['status'],
                                        'post_type'     => 'showtime',
                                    );

                                    $showtime_id = wp_insert_post( $postarr_import );

                                    if ( absint( $showtime_id ) ) {
                                        update_post_meta( $showtime_id, $prefix.'movie_id', $showtime['movie_id'] );
                                        update_post_meta( $showtime_id, $prefix.'date', $showtime['date'] );
                                        update_post_meta( $showtime_id, $prefix.'room_ids', $showtime['room_ids'] );
                                        update_post_meta( $showtime_id, $prefix.'city_id', $showtime['city_id'] );
                                        update_post_meta( $showtime_id, $prefix.'venue_id', $showtime['venue_id'] );
                                        update_post_meta( $showtime_id, $prefix.'address', $showtime['address'] );
                                    }
                                }

                                $_POST['success'] = esc_html__( 'Imported Success!', 'moviebooking' );
                                add_action( 'admin_notices', array( $this, 'mb_show_admin_notice_error' ) );
                                return;
                            } else {
                                $_POST['error'] = esc_html__( 'Imported Fails!', 'moviebooking' );
                                add_action( 'admin_notices', array( $this, 'mb_show_admin_notice_error' ) );
                                return;
                            }
                        }
                    } else {
                        $_POST['error'] = esc_html__( 'No file was uploaded!', 'moviebooking' );
                        add_action( 'admin_notices', array( $this, 'mb_show_admin_notice_error' ) );
                        return;
                    }
                }
            }
        }

        public function mb_show_admin_notice_error() {
            if ( isset( $_POST['error'] ) && $_POST['error'] ) {
                ?>
                <div class="notice notice-error is-dismissible">
                    <p><?php esc_html_e( $_POST['error'] ); ?></p>
                </div>
                <?php
            }

            if ( isset( $_POST['success'] ) && $_POST['success'] ) {
                ?>
                <div class="notice notice-success is-dismissible">
                    <p><?php esc_html_e( $_POST['success'] ); ?></p>
                </div>
                <?php
            }
        }
    }

    new MB_Admin_Importers();
}