<?php
  if (!class_exists('ImageMapPro_Storage')) {
    class ImageMapPro_v6_Storage {
      function __construct() {
        $this->admin_options_name = 'image-map-pro-wordpress-admin-options-v6';
        $this->admin_options_name_before_v6 = 'image-map-pro-wordpress-admin-options';
        
        add_action('wp_ajax_image_map_pro_get_last_project_id', array($this, 'get_last_project_id'));
        add_action('wp_ajax_image_map_pro_load_projects', array($this, 'load_projects'));
        add_action('wp_ajax_image_map_pro_load_projects_only_name_and_shortcode', array($this, 'load_projects_only_name_and_shortcode'));
        add_action('wp_ajax_image_map_pro_save_project', array($this, 'save_project'));
        add_action('wp_ajax_image_map_pro_load_project', array($this, 'load_project'));
        add_action('wp_ajax_image_map_pro_delete_project', array($this, 'delete_project'));
        
        // $old_options = get_option($this->admin_options_name_before_v6);
        // $old_options['migrated'] = false;
        // update_option($this->admin_options_name_before_v6, $old_options);
        // error_log($old_options['migrated']);

        $this->init_storage();
        $this->migrate_old_options();
      }
      function get_admin_options() {
        $options = get_option($this->admin_options_name);
        if (!is_array($options)) {
          $options = array(
            'lastProjectID' => ''
          );
          update_option($this->admin_options_name, $options);
        }
        return $options;
      }
      function init_storage() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'image_map_pro_projects';
        $charset_collate = $wpdb->get_charset_collate();

        if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
          $sql = "CREATE TABLE $table_name (
            id varchar(36) NOT NULL,
            name tinytext NOT NULL,
            shortcode tinytext NOT NULL,
            json longtext NOT NULL,
            PRIMARY KEY  (id)
          ) $charset_collate;";

          require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
          dbDelta($sql);
        }
      }
      function migrate_old_options() {
        // Check if old options exist and have not been migrated
        $old_options = get_option($this->admin_options_name_before_v6);
        if ($old_options['migrated'] == true) {
          return;
        }

        // Migrate old options
        $first_id = '';
        foreach ($old_options['saves'] as $key => $value) {
          $id = json_decode(stripslashes($value['json']))->id;
          if ($first_id == '') {
            $first_id = $id;
          }

          // write to db
          global $wpdb;
          $table_name = $wpdb->prefix . 'image_map_pro_projects';
          $wpdb->insert(
            $table_name,
            array(
              'id' => $id,
              'name' => $value['meta']['name'],
              'shortcode' => $value['meta']['shortcode'],
              'json' => $value['json']
            )
          );
        }

        // Set last project id to the last project in the old options
        $options = $this->get_admin_options();
        $options['lastProjectID'] = $first_id;
        update_option($this->admin_options_name, $options);
        
        // Mark old options as migrated
        $old_options['migrated'] = true;
        update_option($this->admin_options_name_before_v6, $old_options);
      }
      function verify_nonce() {
        if (function_exists('wp_verify_nonce')) {
          if (!wp_verify_nonce($_POST['nonce'], 'image_map_pro')) {
            die('Invalid nonce');
          }
        }
      }
      function get_last_project_id() {
        $this->verify_nonce();

        $options = $this->get_admin_options();
        echo $options['lastProjectID'];

        die();
      }
      function load_projects() {        
        $this->verify_nonce();
        
        global $wpdb;
        $table_name = $wpdb->prefix . 'image_map_pro_projects';
        $projects = $wpdb->get_results("SELECT * FROM $table_name ORDER BY name ASC");

        // strip slashes from each project's json
        foreach ($projects as $key => $value) {
          $projects[$key]->json = stripslashes($value->json);
        }

        $result = json_encode($projects);
        echo $result;

			  die();
      }
      function load_projects_only_name_and_shortcode() {        
        $this->verify_nonce();
        
        global $wpdb;
        $table_name = $wpdb->prefix . 'image_map_pro_projects';
        $projects = $wpdb->get_results("SELECT * FROM $table_name ORDER BY name ASC");

        // strip slashes from each project's json
        foreach ($projects as $key => $value) {
          $projects[$key]->json = stripslashes($value->json);
        }

        $projects_trimmed = array();
        foreach ($projects as $key => $value) {
          $projects_trimmed[$key] = array(
            'name' => $value->name,
            'shortcode' => $value->shortcode
          );
        }

        $result = json_encode($projects_trimmed);
        echo $result;

			  die();
      }
      function load_projects_as_objects() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'image_map_pro_projects';
        $projects = $wpdb->get_results("SELECT * FROM $table_name ORDER BY name ASC");

        // strip slashes from each project's json
        foreach ($projects as $key => $value) {
          $projects[$key]->json = stripslashes($value->json);
        }

        return $projects;
      }
      function get_project_by_shortcode($shortcode) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'image_map_pro_projects';
        $project = $wpdb->get_row("SELECT * FROM $table_name WHERE shortcode = '" . $shortcode . "'");

        if ($project) {
          $project->json = stripslashes($project->json);
        }

        return $project;
      }
      function save_project() {
        $this->verify_nonce();

        if (!isset($_POST['shortcode'])) {
          $_POST['shortcode'] = '';
        }
        if (!isset($_POST['name'])) {
          $_POST['name'] = 'Untitled';
        }
        if (!isset($_POST['json'])) {
          $_POST['json'] = '{}';
        }

        // update project by id, or create if it doesnt exist
        global $wpdb;
        $table_name = $wpdb->prefix . 'image_map_pro_projects';
        $project = $wpdb->get_row("SELECT * FROM $table_name WHERE id = '" . $_POST['saveID'] . "'");
        
        if ($project) {
          $wpdb->update(
            $table_name,
            array(
              'name' => $_POST['name'],
              'shortcode' => $_POST['shortcode'],
              'json' => $_POST['json']
            ),
            array('id' => $_POST['saveID'])
          );
        } else {
          $wpdb->insert(
            $table_name,
            array(
              'id' => $_POST['saveID'],
              'name' => $_POST['name'],
              'shortcode' => $_POST['shortcode'],
              'json' => $_POST['json']
            )
          );
        }

        // set last project id
        $options = $this->get_admin_options();
        $options['lastProjectID'] = $_POST['saveID'];
        update_option($this->admin_options_name, $options);
        echo 1;

        die();
      }
      function load_project() {
        $this->verify_nonce();

        // load project from db by id
        global $wpdb;
        $table_name = $wpdb->prefix . 'image_map_pro_projects';
        $project = $wpdb->get_row("SELECT * FROM $table_name WHERE id = '" . $_POST['saveID'] . "'");

        $json = stripslashes($project->json);

        // return
        echo $json;
        die();
      }
      function delete_project() {
        $this->verify_nonce();

        // delete project from db by id
        global $wpdb;
        $table_name = $wpdb->prefix . 'image_map_pro_projects';
        $wpdb->delete($table_name, array('id' => $_POST['saveID']));
        die();
      }
    }
  }
?>