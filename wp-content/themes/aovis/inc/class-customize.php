<?php if (!defined( 'ABSPATH' )) exit;

if (!class_exists( 'Aovis_Customize' )){

	class Aovis_Customize {
		
		public function __construct() {
	        add_action( 'customize_register', array( $this, 'aovis_customize_register' ) );
	    }

	    public function aovis_customize_register($wp_customize) {
	        
	        $this->aovis_init_remove_setting( $wp_customize );
	        $this->aovis_init_ova_typography( $wp_customize );
	        $this->aovis_init_ova_color( $wp_customize );
	        $this->aovis_init_ova_layout( $wp_customize );
	        $this->aovis_init_ova_header( $wp_customize );
	        $this->aovis_init_ova_footer( $wp_customize );
	        $this->aovis_init_ova_blog( $wp_customize );
	        
	        if( aovis_is_woo_active() ){
	        	$this->aovis_init_ova_woo( $wp_customize );	
	        }
	   
	        do_action( 'aovis_customize_register', $wp_customize );
	    }

	    public function aovis_init_remove_setting( $wp_customize ){
	    	/* Remove Colors &  Header Image Customize */
			$wp_customize->remove_section('colors');
			$wp_customize->remove_section('header_image');

			$wp_customize->add_setting( 'logo', array(
				'type' 				=> 'theme_mod', // or 'option'
				'capability' 		=> 'edit_theme_options',
				'theme_supports' 	=> '', // Rarely needed.
				'default' 			=> '',
				'transport' 		=> 'refresh', // or postMessage
				'sanitize_callback' => 'sanitize_text_field' // Get function name 
		    ) );

		    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo', array(
		        'label'    => esc_html__( 'Logo Default', 'aovis' ),
		        'section'  => 'title_tagline',
		        'settings' => 'logo'
		    )));
	    }
	    
	    /* Typo */
	    public function aovis_init_ova_typography($wp_customize){

	    		/* Body Pane ******************************/
				$wp_customize->add_section( 'typo_general' , array(
				    'title'      => esc_html__( 'Typography', 'aovis' ),
				    'priority'   => 1,
				    // 'panel' => 'typo_panel',
				) );

					/* General Typo */
					$wp_customize->add_setting( 'general_heading', array(
					  	'default' 			=> '',
					  	'sanitize_callback' 	=> 'sanitize_text_field' // Get function name 
					  
					) );


					/* Message */
					$wp_customize->add_setting( 'text_typo_message', array(
						'type' 				=> 'theme_mod', // or 'option'
						'capability' 		=> 'edit_theme_options',
						'theme_supports' 	=> '', // Rarely needed.
						'default' 			=> '',
						'transport' 		=> 'refresh', // or postMessage
						'sanitize_callback' => 'sanitize_text_field' // Get function name 
					) );

					$wp_customize->add_control(
						new Aovis_Customize_Control_Heading( 
						$wp_customize, 
						'text_typo_message', 
						array(
							'label'		=> esc_html__('Text Font','aovis'),
				            'section' 	=> 'typo_general',
				            'settings' 	=> 'text_typo_message',
						) )
					);

						/* Font Size */
						$wp_customize->add_setting( 'general_font_size', array(
						  'type' 				=> 'theme_mod', // or 'option'
						  'capability' 			=> 'edit_theme_options',
						  'theme_supports' 		=> '', // Rarely needed.
						  'default' 			=> '16px',
						  'transport' 			=> 'refresh', // or postMessage
						  'sanitize_callback' 	=> 'sanitize_text_field' // Get function name 
						  
						) );
						
						$wp_customize->add_control('general_font_size', array(
							'label' 		=> esc_html__('Font Size','aovis'),
							'description' 	=> esc_html__('Example: 16px, 1.2em','aovis'),
							'section' 		=> 'typo_general',
							'settings' 		=> 'general_font_size',
							'type' 			=>'text'
						));

						/* Line Height */
						$wp_customize->add_setting( 'general_line_height', array(
						  'type' 				=> 'theme_mod', // or 'option'
						  'capability' 			=> 'edit_theme_options',
						  'theme_supports' 		=> '', // Rarely needed.
						  'default' 			=> '1.87em',
						  'transport' 			=> 'refresh', // or postMessage
						  'sanitize_callback' 	=> 'sanitize_text_field' // Get function name 
						) );
						
						$wp_customize->add_control('general_line_height', array(
							'label' 		=> esc_html__('Line height','aovis'),
							'description' 	=> esc_html__('Recommend use em. Example: 1.6em, 23px','aovis'),
							'section' 		=> 'typo_general',
							'settings' 		=> 'general_line_height',
							'type' 			=>'text'
						));

						/* Letter Space */
						$wp_customize->add_setting( 'general_letter_space', array(
						  'type' 				=> 'theme_mod', // or 'option'
						  'capability' 			=> 'edit_theme_options',
						  'theme_supports' 		=> '', // Rarely needed.
						  'default' 			=> '0px',
						  'transport' 			=> 'refresh', // or postMessage
						  'sanitize_callback' 	=> 'sanitize_text_field' // Get function name 
						) );
						
						$wp_customize->add_control('general_letter_space', array(
							'label' 		=> esc_html__('Letter Spacing','aovis'),
							'description' 	=> esc_html__('Example: 0px, 0.5em','aovis'),
							'section' 		=> 'typo_general',
							'settings' 		=> 'general_letter_space',
							'type' 			=>'text'
						));

				$wp_customize->add_control(
					new Aovis_Customize_Control_Heading( 
					$wp_customize, 
					'general_heading', 
					array(
						'label' 	=> esc_html__('Primary Font','aovis'),
			            'section' 	=> 'typo_general',
			            'settings' 	=> 'general_heading',
					) )
				);

				/* General Font */
				$wp_customize->add_setting( 'primary_font',
					array(
						'default' 			=> aovis_default_primary_font(),
						'sanitize_callback' => 'aovis_google_font_sanitization'
					)
				);
					$wp_customize->add_control( new Aovis_Google_Font_Select_Custom_Control( $wp_customize, 'primary_font',
						array(
							'label' 			=> esc_html__( 'Primary Font', 'aovis' ),
							'section' 			=> 'typo_general',
							'input_attrs' 		=> array(
								'font_count' 	=> 'all',
								'orderby' 		=> 'popular',
							),
						)
					) );

				/* Message */
				$wp_customize->add_setting( 'second_font_message', array(
					'type' 					=> 'theme_mod', // or 'option'
					'capability' 			=> 'edit_theme_options',
					'theme_supports' 		=> '', // Rarely needed.
					'default' 				=> '',
					'transport' 			=> 'refresh', // or postMessage
					'sanitize_callback' 	=> 'sanitize_text_field' // Get function name 
				  
				) );
				$wp_customize->add_control(
					new Aovis_Customize_Control_Heading( 
					$wp_customize, 
					'second_font_message', 
					array(
						'label' 	=> esc_html__('Second Font','aovis'),
			            'section' 	=> 'typo_general',
			            'settings' 	=> 'second_font_message',
					) )
				);

					/* Heading Font */
					$wp_customize->add_setting( 'second_font',
						array(
							'default' 			=> aovis_default_second_font(),
							'sanitize_callback' => 'aovis_google_font_sanitization'
						)
					);
					$wp_customize->add_control( new Aovis_Google_Font_Select_Custom_Control( $wp_customize, 'second_font',
						array(
							'label' 			=> esc_html__( 'Font', 'aovis' ),
							'section' 			=> 'typo_general',
							'input_attrs' 		=> array(
								'font_count' 	=> 'all',
								'orderby' 		=> 'popular',
							),
						)
					) );


				/* Custom Font */
				/* Message */
				$wp_customize->add_setting( 'custom_font_message', array(
					'type' 				=> 'theme_mod', // or 'option'
					'capability' 		=> 'edit_theme_options',
					'theme_supports' 	=> '', // Rarely needed.
					'default' 			=> '',
					'transport' 		=> 'refresh', // or postMessage
					'sanitize_callback' => 'sanitize_text_field' // Get function name 
				) );
				$wp_customize->add_control(
					new Aovis_Customize_Control_Heading( 
					$wp_customize, 
					'custom_font_message', 
					array(
						'label' 	=> esc_html__('Custom Font','aovis'),
			            'section' 	=> 'typo_general',
			            'settings' 	=> 'custom_font_message',
					) )
				);

					$wp_customize->add_control(
						new Aovis_Customize_Control_Heading( 
						$wp_customize, 
						'custom_font_message', 
						array(
							'label' 	=> esc_html__('Custom Font','aovis'),
				            'section' 	=> 'typo_general',
				            'settings' 	=> 'custom_font_message',
						) )
					);

					$wp_customize->add_setting( 'ova_custom_font', array(
						'type' 				=> 'theme_mod', // or 'option'
						'capability' 		=> 'edit_theme_options',
						'theme_supports' 	=> '', // Rarely needed.
						'default' 			=> '',
						'transport' 		=> 'refresh', // or postMessage
						'sanitize_callback' => 'sanitize_text_field' // Get function name 
					) );

					$wp_customize->add_control('ova_custom_font', array(
						'label' 		=> esc_html__('Custom Font','aovis'),
						'description' 	=> esc_html__('Step 1: Insert font-face in style.css file: Refer https://www.w3schools.com/cssref/css3_pr_font-face_rule.asp. Step 2: Insert font-family and font-weight like format: 
							["Perpetua", "Regular:Bold:Italic:Light"] | ["Name-Font", "Regular:Bold:Italic:Light"]. Step 3: Refresh customize page to display new font in dropdown font field.','aovis'),
						'section' 		=> 'typo_general',
						'settings' 		=> 'ova_custom_font',
						'type' 			=>'textarea'
					));
	    }


	     /* Color */
	    public function aovis_init_ova_color( $wp_customize ){

	    	/* Body Pane ******************************/
			$wp_customize->add_section( 'color_section' , array(
			    'title'      => esc_html__( 'Color', 'aovis' ),
			    'priority'   => 2,
			    // 'panel' => 'typo_panel',
			) );

				$wp_customize->add_setting( 'primary_color', array(
					'type' 				=> 'theme_mod', // or 'option'
					'capability' 		=> 'edit_theme_options',
					'theme_supports' 	=> '', // Rarely needed.
					'transport' 		=> 'refresh', // or postMessage
					'default'			=> aovis_default_primary_color(),
					'sanitize_callback' => 'sanitize_text_field' // Get function name 
				) );
				$wp_customize->add_control(
					new WP_Customize_Color_Control(
					$wp_customize, 
					'primary_color', 
					array(
						'label' 	=> esc_html__("Primary",'aovis'),
			            'section' 	=> 'color_section',
			            'settings' 	=> 'primary_color',
					) ) 
				);

				$wp_customize->add_setting( 'text_color', array(
				  'type' 				=> 'theme_mod', // or 'option'
				  'capability' 			=> 'edit_theme_options',
				  'theme_supports' 		=> '', // Rarely needed.
				  'default'				=> '#737373',
				  'transport' 			=> 'refresh', // or postMessage
				  'sanitize_callback' 	=> 'sanitize_text_field' // Get function name 
				) );

				$wp_customize->add_control(
					new WP_Customize_Color_Control(
					$wp_customize, 
					'text_color', 
					array(
						'label' 	=> esc_html__("Text",'aovis'),
			            'section' 	=> 'color_section',
			            'settings' 	=> 'text_color',
					) ) 
				);

				$wp_customize->add_setting( 'heading_color', array(
					'type' 				=> 'theme_mod', // or 'option'
					'capability' 		=> 'edit_theme_options',
					'theme_supports' 	=> '', // Rarely needed.
					'default'			=> '#000000',		
					'transport' 		=> 'refresh', // or postMessage
					'sanitize_callback' => 'sanitize_text_field' // Get function name 
				) );

				$wp_customize->add_control(
					new WP_Customize_Color_Control(
					$wp_customize, 
					'heading_color', 
					array(
						'label' 	=> esc_html__("Heading",'aovis'),
			            'section' 	=> 'color_section',
			            'settings' 	=> 'heading_color',
					) ) 
				);

				$wp_customize->add_setting( 'light_color', array(
				  'type' 				=> 'theme_mod', // or 'option'
				  'capability' 			=> 'edit_theme_options',
				  'theme_supports' 		=> '', // Rarely needed.
				  'default'				=> '#E0E0E0',	
				  'transport' 			=> 'refresh', // or postMessage
				  'sanitize_callback' 	=> 'sanitize_text_field' // Get function name 
				) );

				$wp_customize->add_control(
					new WP_Customize_Color_Control(
					$wp_customize, 
					'light_color', 
					array(
						'label' 	=> esc_html__("Light",'aovis'),
			            'section' 	=> 'color_section',
			            'settings' 	=> 'light_color',
					) ) 
				);
	    }


	    /* Layout */
	    public function aovis_init_ova_layout( $wp_customize ){

	    	$wp_customize->add_section( 'layout_section' , array(
			    'title'      => esc_html__( 'Layout', 'aovis' ),
			    'priority'   => 2,
			) );

				$wp_customize->add_setting( 'global_boxed_container_width', array(
					'type' 				=> 'theme_mod', // or 'option'
					'capability' 		=> 'edit_theme_options',
					'theme_supports' 	=> '', // Rarely needed.
					'default' 			=> '1290',
					'transport' 		=> 'refresh', // or postMessage
					'sanitize_callback' => 'sanitize_text_field' // Get function name 
				) );
				$wp_customize->add_control('global_boxed_container_width', array(
					'label' 	=> esc_html__('Container (px)','aovis'),
					'section' 	=> 'layout_section',
					'settings' 	=> 'global_boxed_container_width',
					'type' 		=>'number',
					'default' 	=> '1290'
				));

				$wp_customize->add_setting( 'global_layout', array(
					'type' 				=> 'theme_mod', // or 'option'
					'capability' 		=> 'edit_theme_options',
					'theme_supports' 	=> '', // Rarely needed.
					'default' 			=> 'layout_2r',
					'transport' 		=> 'refresh', // or postMessage
					'sanitize_callback' => 'sanitize_text_field' // Get function name 
				) );
				$wp_customize->add_control('global_layout', array(
					'label' 	=> esc_html__('Layout','aovis'),
					'section' 	=> 'layout_section',
					'settings' 	=> 'global_layout',
					'type' 		=>'select',
					'choices' 	=> apply_filters( 'aovis_define_layout', '' )
				));

				$wp_customize->add_setting( 'global_sidebar_width', array(
					'type' 				=> 'theme_mod', // or 'option'
					'capability' 		=> 'edit_theme_options',
					'theme_supports' 	=> '', // Rarely needed.
					'default' 			=> '320',
					'transport' 		=> 'refresh', // or postMessage
					'sanitize_callback' => 'sanitize_text_field' // Get function name
				) );

				$wp_customize->add_control('global_sidebar_width', array(
					'label' 	=> esc_html__('Sidebar Width (px)','aovis'),
					'section' 	=> 'layout_section',
					'settings' 	=> 'global_sidebar_width',
					'type' 		=>'number'
				));
				
				$wp_customize->add_setting( 'global_wide_site', array(
					'type' 					=> 'theme_mod', // or 'option'
					'capability' 			=> 'edit_theme_options',
					'theme_supports' 		=> '', // Rarely needed.
					'default' 				=> 'wide',
					'transport' 			=> 'refresh', // or postMessage
					'sanitize_callback' 	=> 'sanitize_text_field' // Get function name 
				) );

				$wp_customize->add_control('global_wide_site', array(
					'label' 	=> esc_html__('Wide Site','aovis'),
					'section' 	=> 'layout_section',
					'settings' 	=> 'global_wide_site',
					'type' 		=>'select',
					'choices' 	=> apply_filters('aovis_define_wide_boxed', '')
				));

				$wp_customize->add_setting( 'global_boxed_offset', array(
				  'type' 				=> 'theme_mod', // or 'option'
				  'capability' 			=> 'edit_theme_options',
				  'theme_supports' 		=> '', // Rarely needed.
				  'default' 			=> '20',
				  'transport' 			=> 'refresh', // or postMessage
				  'sanitize_callback' 	=> 'sanitize_text_field' // Get function name 
				) );

				$wp_customize->add_control('global_boxed_offset', array(
					'label' 	=> esc_html__('Boxed Offset (px)','aovis'),
					'section' 	=> 'layout_section',
					'settings' 	=> 'global_boxed_offset',
					'type' 		=>'number',
					'default' 	=> '20'
				));
	    }

	    /* Header */
	    public function aovis_init_ova_header( $wp_customize ){

	    	$wp_customize->add_section( 'header_section' , array(
			    'title'      => esc_html__( 'Header', 'aovis' ),
			    'priority'   => 3,
			) );

				$wp_customize->add_setting( 'global_header', array(
					'type' 				=> 'theme_mod', // or 'option'
					'capability' 		=> 'edit_theme_options',
					'theme_supports' 	=> '', // Rarely needed.
					'default' 			=> 'default',
					'transport' 		=> 'refresh', // or postMessage
					'sanitize_callback' => 'sanitize_text_field' // Get function name
				) );

				$wp_customize->add_control('global_header', array(
					'label' 		=> esc_html__('Header Default','aovis'),
					'description' 	=> esc_html__('This isn\'t effect in Blog' ,'aovis'),
					'section' 		=> 'header_section',
					'settings' 		=> 'global_header',
					'type' 			=>'select',
					'choices' 		=> apply_filters('aovis_list_header', '')
				));
	    }

	    /* Footer */
	    public function aovis_init_ova_footer( $wp_customize ){

	    	$wp_customize->add_section( 'footer_section' , array(
			    'title'      => esc_html__( 'Footer', 'aovis' ),
			    'priority'   => 4,
			) );

				$wp_customize->add_setting( 'global_footer', array(
					'type' 				=> 'theme_mod', // or 'option'
					'capability' 		=> 'edit_theme_options',
					'theme_supports' 	=> '', // Rarely needed.
					'default' 			=> 'default',
					'transport' 		=> 'refresh', // or postMessage
					'sanitize_callback' => 'sanitize_text_field' // Get function name
				) );

				$wp_customize->add_control('global_footer', array(
					'label' 		=> esc_html__('Footer Default','aovis'),
					'description' 	=> esc_html__('This isn\'t effect in Blog' ,'aovis'),
					'section' 		=> 'footer_section',
					'settings' 		=> 'global_footer',
					'type' 			=>'select',
					'choices' 		=> apply_filters('aovis_list_footer', '')
				));
	    }


	    /* Blog */
	    public function aovis_init_ova_blog( $wp_customize ){

	    	$wp_customize->add_panel( 'blog_panel', array(
			    'title'		=> esc_html__( 'Blog', 'aovis' ),
			    'priority' 	=> 5,
			) );

				$wp_customize->add_section( 'blog_section' , array(
				    'title' 	=> esc_html__( 'Archive', 'aovis' ),
				    'priority' 	=> 30,
				    'panel' 	=> 'blog_panel',
				) );

					$wp_customize->add_setting( 'blog_template', array(
						'type' 				=> 'theme_mod', // or 'option'
						'capability'		=> 'edit_theme_options',
						'theme_supports' 	=> '', // Rarely needed.
						'default' 			=> 'default',
						'transport' 		=> 'refresh', // or postMessage
						'sanitize_callback' => 'sanitize_text_field' // Get function name
					) );

					$wp_customize->add_control('blog_template', array(
						'label' 	=> esc_html__('Type','aovis'),
						'section' 	=> 'blog_section',
						'settings' 	=> 'blog_template',
						'type' 		=>'select',
						'choices' 	=> array(
							'default' 	=> esc_html__('Default', 'aovis'),
							'grid'		=> esc_html__('Grid', 'aovis'),
							'masonry' 	=> esc_html__('Masonry', 'aovis'),
						)
					));

					$wp_customize->add_setting( 'blog_archive_show_media', array(
						'type' 				=> 'theme_mod', // or 'option'
						'capability' 		=> 'edit_theme_options',
						'theme_supports' 	=> '', // Rarely needed.
						'default' 			=> 'yes',
						'transport' 		=> 'refresh', // or postMessage
						'sanitize_callback' => 'sanitize_text_field' // Get function name
					) );
					
					$wp_customize->add_control('blog_archive_show_media', array(
						'label' 	=> esc_html__('Show Media','aovis'),
						'section' 	=> 'blog_section',
						'settings' 	=> 'blog_archive_show_media',
						'type' 		=>'select',
						'choices' 	=> array(
							'yes' 	=> esc_html__('Yes', 'aovis'),
							'no' 	=> esc_html__('No', 'aovis'),
						)
					));

					$wp_customize->add_setting( 'blog_archive_show_title', array(
						'type' 				=> 'theme_mod', // or 'option'
						'capability' 		=> 'edit_theme_options',
						'theme_supports' 	=> '', // Rarely needed.
						'default' 			=> 'yes',
						'transport' 		=> 'refresh', // or postMessage
						'sanitize_callback' => 'sanitize_text_field' // Get function name
					) );
					
					$wp_customize->add_control('blog_archive_show_title', array(
						'label' 	=> esc_html__('Show Title','aovis'),
						'section' 	=> 'blog_section',
						'settings' 	=> 'blog_archive_show_title',
						'type' 		=>'select',
						'choices' 	=> array(
							'yes' 	=> esc_html__('Yes', 'aovis'),
							'no' 	=> esc_html__('No', 'aovis'),
						)
					));

					$wp_customize->add_setting( 'blog_archive_show_date', array(
						'type' 				=> 'theme_mod', // or 'option'
						'capability' 		=> 'edit_theme_options',
						'theme_supports' 	=> '', // Rarely needed.
						'default' 			=> 'yes',
						'transport' 		=> 'refresh', // or postMessage
						'sanitize_callback' => 'sanitize_text_field' // Get function name
					) );
					
					$wp_customize->add_control('blog_archive_show_date', array(
						'label' 	=> esc_html__('Show Date','aovis'),
						'section' 	=> 'blog_section',
						'settings' 	=> 'blog_archive_show_date',
						'type' 		=>'select',
						'choices' 	=> array(
							'yes' 	=> esc_html__('Yes', 'aovis'),
							'no' 	=> esc_html__('No', 'aovis'),
						)
					));

					$wp_customize->add_setting( 'blog_archive_show_cat', array(
						'type' 				=> 'theme_mod', // or 'option'
						'capability' 		=> 'edit_theme_options',
						'theme_supports' 	=> '', // Rarely needed.
						'default' 			=> 'yes',
						'transport' 		=> 'refresh', // or postMessage
						'sanitize_callback' => 'sanitize_text_field' // Get function name
					) );
					
					$wp_customize->add_control('blog_archive_show_cat', array(
						'label' 	=> esc_html__('Show Category','aovis'),
						'section' 	=> 'blog_section',
						'settings' 	=> 'blog_archive_show_cat',
						'type' 		=>'select',
						'choices' 	=> array(
							'yes' 	=> esc_html__('Yes', 'aovis'),
							'no' 	=> esc_html__('No', 'aovis'),
						)
					));

					$wp_customize->add_setting( 'blog_archive_show_author', array(
						'type' 				=> 'theme_mod', // or 'option'
						'capability' 		=> 'edit_theme_options',
						'theme_supports' 	=> '', // Rarely needed.
						'default' 			=> 'no',
						'transport' 		=> 'refresh', // or postMessage
						'sanitize_callback' => 'sanitize_text_field' // Get function name
					) );
					
					$wp_customize->add_control('blog_archive_show_author', array(
						'label' 	=> esc_html__('Show Author','aovis'),
						'section' 	=> 'blog_section',
						'settings' 	=> 'blog_archive_show_author',
						'type' 		=>'select',
						'choices' 	=> array(
							'yes' 	=> esc_html__('Yes', 'aovis'),
							'no' 	=> esc_html__('No', 'aovis'),
						)
					));

					$wp_customize->add_setting( 'blog_archive_show_comment', array(
						'type' 				=> 'theme_mod', // or 'option'
						'capability' 		=> 'edit_theme_options',
						'theme_supports' 	=> '', // Rarely needed.
						'default' 			=> 'yes',
						'transport' 		=> 'refresh', // or postMessage
						'sanitize_callback' => 'sanitize_text_field' // Get function name
					) );
					
					$wp_customize->add_control('blog_archive_show_comment', array(
						'label' 	=> esc_html__('Show Comment','aovis'),
						'section' 	=> 'blog_section',
						'settings' 	=> 'blog_archive_show_comment',
						'type' 		=>'select',
						'choices' 	=> array(
							'yes' 	=> esc_html__('Yes', 'aovis'),
							'no' 	=> esc_html__('No', 'aovis'),
						)
					));

					$wp_customize->add_setting( 'blog_archive_show_excerpt', array(
						'type' 				=> 'theme_mod', // or 'option'
						'capability' 		=> 'edit_theme_options',
						'theme_supports' 	=> '', // Rarely needed.
						'default' 			=> 'yes',
						'transport' 		=> 'refresh', // or postMessage
						'sanitize_callback' => 'sanitize_text_field' // Get function name
					) );
					
					$wp_customize->add_control('blog_archive_show_excerpt', array(
						'label' 	=> esc_html__('Show Excerpt','aovis'),
						'section' 	=> 'blog_section',
						'settings' 	=> 'blog_archive_show_excerpt',
						'type' 		=>'select',
						'choices' 	=> array(
							'yes' 	=> esc_html__('Yes', 'aovis'),
							'no' 	=> esc_html__('No', 'aovis'),
						)
					));

					$wp_customize->add_setting( 'blog_archive_show_readmore', array(
						'type' 				=> 'theme_mod', // or 'option'
						'capability' 		=> 'edit_theme_options',
						'theme_supports' 	=> '', // Rarely needed.
						'default' 			=> 'yes',
						'transport' 		=> 'refresh', // or postMessage
						'sanitize_callback' => 'sanitize_text_field' // Get function name
					) );
					
					$wp_customize->add_control('blog_archive_show_readmore', array(
						'label' 	=> esc_html__('Show Read More','aovis'),
						'section' 	=> 'blog_section',
						'settings' 	=> 'blog_archive_show_readmore',
						'type' 		=>'select',
						'choices' 	=> array(
							'yes' 	=> esc_html__('Yes', 'aovis'),
							'no' 	=> esc_html__('No', 'aovis'),
						)
					));

					$wp_customize->add_setting( 'blog_layout', array(
					  'type' 				=> 'theme_mod', // or 'option'
					  'capability' 			=> 'edit_theme_options',
					  'theme_supports' 		=> '', // Rarely needed.
					  'default' 			=> 'layout_2r',
					  'transport' 			=> 'refresh', // or postMessage
					  'sanitize_callback' 	=> 'sanitize_text_field' // Get function name 
					  
					) );
					$wp_customize->add_control('blog_layout', array(
						'label' 	=> esc_html__('Layout','aovis'),
						'section' 	=> 'blog_section',
						'settings' 	=> 'blog_layout',
						'type' 		=>'select',
						'choices' 	=> apply_filters( 'aovis_define_layout', '' )
					));
					
					$wp_customize->add_setting( 'blog_header', array(
					  'type' 				=> 'theme_mod', // or 'option'
					  'capability' 			=> 'edit_theme_options',
					  'theme_supports' 		=> '', // Rarely needed.
					  'default' 			=> 'default',
					  'transport' 			=> 'refresh', // or postMessage
					  'sanitize_callback' 	=> 'sanitize_text_field' // Get function name 
					  
					) );
					$wp_customize->add_control('blog_header', array(
						'label' 	=> esc_html__('Header','aovis'),
						'section' 	=> 'blog_section',
						'settings' 	=> 'blog_header',
						'type' 		=>'select',
						'choices' 	=> apply_filters('aovis_list_header', '')
					));

					$wp_customize->add_setting( 'blog_footer', array(
						'type' 				=> 'theme_mod', // or 'option'
						'capability' 		=> 'edit_theme_options',
						'theme_supports' 	=> '', // Rarely needed.
						'default' 			=> 'default',
						'transport' 		=> 'refresh', // or postMessage
						'sanitize_callback' => 'sanitize_text_field' // Get function name 
					) );
					$wp_customize->add_control('blog_footer', array(
						'label' 	=> esc_html__('Footer','aovis'),
						'section' 	=> 'blog_section',
						'settings' 	=> 'blog_footer',
						'type' 		=>'select',
						'choices' 	=> apply_filters('aovis_list_footer', '')
					));

				$wp_customize->add_section( 'single_section' , array(
				    'title' 	=> esc_html__( 'Single', 'aovis' ),
				    'priority' 	=> 30,
				    'panel' 	=> 'blog_panel',
				) );	

					$wp_customize->add_setting( 'single_layout', array(
						'type' 				=> 'theme_mod', // or 'option'
						'capability' 		=> 'edit_theme_options',
						'theme_supports' 	=> '', // Rarely needed.
						'default' 			=> 'layout_2r',
						'transport' 		=> 'refresh', // or postMessage
						'sanitize_callback' => 'sanitize_text_field' // Get function name 
					) );
					$wp_customize->add_control('single_layout', array(
						'label' 	=> esc_html__('Layout','aovis'),
						'section' 	=> 'single_section',
						'settings' 	=> 'single_layout',
						'type' 		=>'select',
						'choices' 	=> apply_filters( 'aovis_define_layout', '' )
					));

					$wp_customize->add_setting( 'blog_single_show_media', array(
					  'type' 				=> 'theme_mod', // or 'option'
					  'capability' 			=> 'edit_theme_options',
					  'theme_supports' 		=> '', // Rarely needed.
					  'default' 			=> 'yes',
					  'transport' 			=> 'refresh', // or postMessage
					  'sanitize_callback' 	=> 'sanitize_text_field' // Get function name
					) );
					
					$wp_customize->add_control('blog_single_show_media', array(
						'label' 	=> esc_html__('Show Media','aovis'),
						'section' 	=> 'single_section',
						'settings' 	=> 'blog_single_show_media',
						'type' 		=>'select',
						'choices' 	=> array(
							'yes' 	=> esc_html__('Yes', 'aovis'),
							'no' 	=> esc_html__('No', 'aovis'),
						)
					));

					$wp_customize->add_setting( 'blog_single_show_title', array(
						'type' 				=> 'theme_mod', // or 'option'
						'capability' 		=> 'edit_theme_options',
						'theme_supports' 	=> '', // Rarely needed.
						'default' 			=> 'yes',
						'transport' 		=> 'refresh', // or postMessage
						'sanitize_callback' => 'sanitize_text_field' // Get function name
					) );
					
					$wp_customize->add_control('blog_single_show_title', array(
						'label' 	=> esc_html__('Show Title','aovis'),
						'section' 	=> 'single_section',
						'settings' 	=> 'blog_single_show_title',
						'type' 		=>'select',
						'choices' 	=> array(
							'yes' 	=> esc_html__('Yes', 'aovis'),
							'no' 	=> esc_html__('No', 'aovis'),
						)
					));

					$wp_customize->add_setting( 'blog_single_show_date', array(
						'type' 				=> 'theme_mod', // or 'option'
						'capability' 		=> 'edit_theme_options',
						'theme_supports' 	=> '', // Rarely needed.
						'default' 			=> 'yes',
						'transport' 		=> 'refresh', // or postMessage
						'sanitize_callback' => 'sanitize_text_field' // Get function name
					) );
					
					$wp_customize->add_control('blog_single_show_date', array(
						'label' 	=> esc_html__('Show Date','aovis'),
						'section' 	=> 'single_section',
						'settings' 	=> 'blog_single_show_date',
						'type' 		=>'select',
						'choices' 	=> array(
							'yes' 	=> esc_html__('Yes', 'aovis'),
							'no' 	=> esc_html__('No', 'aovis'),
						)
					));

					$wp_customize->add_setting( 'blog_single_show_cat', array(
						'type' 				=> 'theme_mod', // or 'option'
						'capability' 		=> 'edit_theme_options',
						'theme_supports' 	=> '', // Rarely needed.
						'default' 			=> 'yes',
						'transport' 		=> 'refresh', // or postMessage
						'sanitize_callback' => 'sanitize_text_field' // Get function name 
					) );
					
					$wp_customize->add_control('blog_single_show_cat', array(
						'label' 	=> esc_html__('Show Category','aovis'),
						'section' 	=> 'single_section',
						'settings' 	=> 'blog_single_show_cat',
						'type' 		=>'select',
						'choices' 	=> array(
							'yes' 	=> esc_html__('Yes', 'aovis'),
							'no' 	=> esc_html__('No', 'aovis'),
						)
					));

					$wp_customize->add_setting( 'blog_single_show_author', array(
						'type' 				=> 'theme_mod', // or 'option'
						'capability' 		=> 'edit_theme_options',
						'theme_supports' 	=> '', // Rarely needed.
						'default' 			=> 'no',
						'transport' 		=> 'refresh', // or postMessage
						'sanitize_callback' => 'sanitize_text_field' // Get function name 
					) );
					
					$wp_customize->add_control('blog_single_show_author', array(
						'label' 	=> esc_html__('Show Author','aovis'),
						'section' 	=> 'single_section',
						'settings' 	=> 'blog_single_show_author',
						'type' 		=>'select',
						'choices' 	=> array(
							'yes' 	=> esc_html__('Yes', 'aovis'),
							'no' 	=> esc_html__('No', 'aovis'),
						)
					));

					$wp_customize->add_setting( 'blog_single_show_comment', array(
						'type' 				=> 'theme_mod', // or 'option'
						'capability' 		=> 'edit_theme_options',
						'theme_supports' 	=> '', // Rarely needed.
						'default' 			=> 'yes',
						'transport' 		=> 'refresh', // or postMessage
						'sanitize_callback' => 'sanitize_text_field' // Get function name 
					) );
					
					$wp_customize->add_control('blog_single_show_comment', array(
						'label' 	=> esc_html__('Show Comment','aovis'),
						'section' 	=> 'single_section',
						'settings' 	=> 'blog_single_show_comment',
						'type' 		=>'select',
						'choices' 	=> array(
							'yes' 	=> esc_html__('Yes', 'aovis'),
							'no' 	=> esc_html__('No', 'aovis'),
						)
					));

					$wp_customize->add_setting( 'blog_single_show_tag', array(
						'type' 				=> 'theme_mod', // or 'option'
						'capability' 		=> 'edit_theme_options',
						'theme_supports' 	=> '', // Rarely needed.
						'default' 			=> 'yes',
						'transport' 		=> 'refresh', // or postMessage
						'sanitize_callback' => 'sanitize_text_field' // Get function name
					) );
					
					$wp_customize->add_control('blog_single_show_tag', array(
						'label' 	=> esc_html__('Show Tag','aovis'),
						'section' 	=> 'single_section',
						'settings' 	=> 'blog_single_show_tag',
						'type' 		=>'select',
						'choices' 	=> array(
							'yes' 	=> esc_html__('Yes', 'aovis'),
							'no' 	=> esc_html__('No', 'aovis'),
						)
					));
					
					$wp_customize->add_setting( 'single_header', array(
					  'type' 				=> 'theme_mod', // or 'option'
					  'capability' 			=> 'edit_theme_options',
					  'theme_supports' 		=> '', // Rarely needed.
					  'default' 			=> 'default',
					  'transport' 			=> 'refresh', // or postMessage
					  'sanitize_callback' 	=> 'sanitize_text_field' // Get function name 
					  
					) );
					$wp_customize->add_control('single_header', array(
						'label' 	=> esc_html__('Header','aovis'),
						'section' 	=> 'single_section',
						'settings' 	=> 'single_header',
						'type' 		=>'select',
						'choices' 	=> apply_filters('aovis_list_header', '')
					));

					$wp_customize->add_setting( 'single_footer', array(
						'type' 				=> 'theme_mod', // or 'option'
						'capability' 		=> 'edit_theme_options',
						'theme_supports' 	=> '', // Rarely needed.
						'default' 			=> 'default',
						'transport' 		=> 'refresh', // or postMessage
						'sanitize_callback' => 'sanitize_text_field' // Get function name
					) );
					$wp_customize->add_control('single_footer', array(
						'label' 	=> esc_html__('Footer','aovis'),
						'section' 	=> 'single_section',
						'settings' 	=> 'single_footer',
						'type' 		=>'select',
						'choices' 	=> apply_filters('aovis_list_footer', '')
					));
	    }

	    public function aovis_init_ova_woo( $wp_customize ){

			$wp_customize->add_setting( 'woo_archive_layout', array(
				'type'              => 'theme_mod', // or 'option'
				'capability'        => 'edit_theme_options',
				'theme_supports'    => '', // Rarely needed.
				'default'           => 'woo_layout_1c',
				'transport'         => 'refresh', // or postMessage
				'sanitize_callback' => 'sanitize_text_field' // Get function name 
					  
			) );
			$wp_customize->add_control('woo_archive_layout', array(
				'label'    => esc_html__('Archive Layout','aovis'),
				'section'  => 'woocommerce_product_catalog',
				'settings' => 'woo_archive_layout',
				'type'     =>'select',
				'choices'  => array(
					'woo_layout_1c' => esc_html__('No Sidebar', 'aovis'),
					'woo_layout_2r' => esc_html__('Right Sidebar', 'aovis'),
					'woo_layout_2l' => esc_html__('Left Sidebar', 'aovis'),
				)
			));



			$wp_customize->add_setting( 'woo_sidebar_width', array(
				'type'              => 'theme_mod', // or 'option'
				'capability'        => 'edit_theme_options',
				'theme_supports'    => '', // Rarely needed.
				'default'           => '320',
				'transport'         => 'refresh', // or postMessage
				'sanitize_callback' => 'sanitize_text_field' // Get function name 
			  
			) );
			$wp_customize->add_control('woo_sidebar_width', array(
				'label'    => esc_html__('Sidebar Width (px)','aovis'),
				'section'  => 'woocommerce_product_catalog',
				'settings' => 'woo_sidebar_width',
				'type'     =>'number'
			));

			/* Show/hide title in category,tag */
			$wp_customize->add_setting( 'woo_archive_show_title', array(
				'type' 				=> 'theme_mod', // or 'option'
				'capability' 		=> 'edit_theme_options',
				'theme_supports' 	=> '', // Rarely needed.
				'transport' 		=> 'refresh', // or postMessage
				'sanitize_callback' => 'sanitize_text_field', // Get function name 
				'default'  			=> 'yes',
			) );

	    	$wp_customize->add_control('woo_archive_show_title', array(
	    		'label'    	=> esc_html__('Show/Hide Title','aovis'),
	    		'section'  	=> 'woocommerce_product_catalog',
	    		'settings' 	=> 'woo_archive_show_title',
	    		'type'     	=> 'select',
	    		'choices'  	=> array(
	    			'yes' 	=> esc_html__('Yes', 'aovis'),
	    			'no' 	=> esc_html__('No', 'aovis'),
	    		)
	    	));

			$wp_customize->add_section( 'product_detail' , array(
			    'title' 	=> esc_html__( 'Product detail', 'aovis' ),
			    'priority' 	=> 30,
			    'panel' 	=> 'woocommerce',
			) );

			$wp_customize->add_setting( 'woo_product_layout', array(
				'type'              => 'theme_mod', // or 'option'
				'capability'        => 'edit_theme_options',
				'theme_supports'    => '', // Rarely needed.
				'default'           => 'woo_layout_1c',
				'transport'         => 'refresh', // or postMessage
				'sanitize_callback' => 'sanitize_text_field' // Get function name 
			) );
			$wp_customize->add_control('woo_product_layout', array(
				'label'    => esc_html__('Single Layout','aovis'),
				'section'  => 'product_detail',
				'settings' => 'woo_product_layout',
				'type'     =>'select',
				'choices'  => array(
					'woo_layout_1c' => esc_html__('No Sidebar', 'aovis'),
					'woo_layout_2r' => esc_html__('Right Sidebar', 'aovis'),
					'woo_layout_2l' => esc_html__('Left Sidebar', 'aovis'),
				)
			));

	    	$wp_customize->add_setting( 'woo_product_detail_show_title', array(
				'type' 				=> 'theme_mod', // or 'option'
				'capability' 		=> 'edit_theme_options',
				'theme_supports' 	=> '', // Rarely needed.
				'transport' 		=> 'refresh', // or postMessage
				'sanitize_callback' => 'sanitize_text_field', // Get function name 
				'default'  			=> 'yes',
			) );

	    	$wp_customize->add_control('woo_product_detail_show_title', array(
	    		'label'    	=> esc_html__('Show/Hide Title','aovis'),
	    		'section'  	=> 'product_detail',
	    		'settings' 	=> 'woo_product_detail_show_title',
	    		'type'     	=> 'select',
	    		'choices'  	=> array(
	    			'yes' 	=> esc_html__('Yes', 'aovis'),
	    			'no' 	=> esc_html__('No', 'aovis'),
	    		)
	    	));
	    }
	}

}

new Aovis_Customize();