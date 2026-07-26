<?php

if (!class_exists('ImageMapPro_Shortcode')) {
  class ImageMapPro_v6_Shortcode {
    function __construct($storage, $version) {
			$this->version = $version;
			// Get a reference to the storage
      $this->storage = $storage;

      // Create an array to store the shortcodes, which have been printed
      $this->start_session();

      // Generate the shortcodes
      foreach ($this->storage->load_projects_as_objects() as $project) {
				if (isset($project->shortcode) && strlen($project->shortcode) > 0) {
					add_shortcode($project->shortcode, array($this, 'print_shortcode'));
				}
			}

      // // Register the client script
      add_action('wp_enqueue_scripts', array($this, 'register_client_script'));
    }
    function start_session() {
      // Check if session has already started
			$started = false;
			if (version_compare(phpversion(), '5.4.0') != -1) {
				if (session_status() == PHP_SESSION_NONE) {
					$started = true;
				}
			} else {
				if(session_id() == '') {
					$started = true;
				}
			}
			if (!$started) {
				session_start();
			}

      // Create the array if it doesn't exist
      $_SESSION['image-map-pro-shortcodes'] = array();
    }
    function register_client_script() {
			wp_register_script('image-map-pro', plugins_url('../js/client/main.js', __FILE__), false, $this->version, true);
		}
    function print_shortcode($a, $b, $shortcode) {			
      $project = $this->storage->get_project_by_shortcode($shortcode);
			$result = '';

      if ($project) {
        $result = '<div><div id="image-map-pro-'. $project->id .'"></div></div>';

        if (isset($_SESSION['image-map-pro-shortcodes'])) {
          array_push($_SESSION['image-map-pro-shortcodes'], $shortcode);
        }

        add_action('wp_footer', array($this, 'footer_script'));
      }

			return $result;
		}
    function footer_script() {
      wp_enqueue_script('image-map-pro');

      $projects = $this->storage->load_projects_as_objects();

			foreach ($projects as $project) {
				if (isset($_SESSION['image-map-pro-shortcodes'])) {
					if (array_search($project->shortcode, $_SESSION['image-map-pro-shortcodes']) === false) {
						continue;
					}
				}
				
				?>
				<script>
					;(function () {
						setTimeout(() => {
							if (canLaunchImageMapPro()) {
								launchImageMapPro()
								return
							} else {
								const interval = setInterval(() => {
									if (!canLaunchImageMapPro()) {
										return
									} else {
										clearInterval(interval)
										launchImageMapPro()
									}
								}, 250)
							}
						}, 1)

						function canLaunchImageMapPro() {
							try {
								return ImageMapPro && document.querySelector("#image-map-pro-<?php echo $project->id ?>")
							} catch(err) {
								return false
							}
						}
						function launchImageMapPro() {
							<?php
								echo 'const settings = '. $this->expand_shortcodes($project->json) .';' . "\n";
								echo 'ImageMapPro.init("#image-map-pro-'. $project->id .'", settings)';
							?>
						}
					})();
				</script>
				<?php

				$parsed = json_decode($project->json);

				if (isset($parsed->custom_code->custom_css) && strlen($parsed->custom_code->custom_css) > 0) {
					echo '<style type="text/css">' . $this->format_custom_code($parsed->custom_code->custom_css) . '</style>';
				}
				if (isset($parsed->custom_code->custom_js) && strlen($parsed->custom_code->custom_js) > 0) {
					echo '<script>' . $this->format_custom_code($parsed->custom_code->custom_js) .'</script>' . "\n";
				}
			}
    }
    function format_custom_code($code) {
      $formatted = str_replace('\n', " ", $code);
      $formatted = preg_replace("/\s+/", " ", $formatted);
      $formatted = preg_replace("/<br>/", '', $formatted);
      $formatted = preg_replace("/\\\\t/", ' ', $formatted);

      return $formatted;
    }
		function expand_shortcodes($json) {
			// register a test shortcode
			add_shortcode('test', function($atts, $content) {
				return '<strong>this is a test shortcode</strong>';
			});

			// decode json
			$json = json_decode($json);

			// iterate over each item in prop "children" of json->artboards
			foreach ($json->artboards as $artboard) {
				foreach ($artboard->children as $child) {
					// if the item has a prop "text" and it contains a shortcode
					if (isset($child->tooltip_content)) {
						foreach ($child->tooltip_content as $content) {
							if ($content->text) {
								$content->text = do_shortcode($content->text);
							}
						}
					}
				}
			}

			// encode back to json and return
			return json_encode($json);
		}
  }
}

?>