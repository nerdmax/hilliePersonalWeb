<?php

/**
  ReduxFramework Sample Config File
  For full documentation, please visit: https://docs.reduxframework.com
 * */

if (!class_exists('admin_folder_Redux_Framework_config')) {

    class admin_folder_Redux_Framework_config {

        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }

            // This is needed. Bah WordPress bugs.  ;)
            if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }

        }

        public function initSettings() {

            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            // If Redux is running as a plugin, this will remove the demo notice and links
            add_action( 'redux/loaded', array( $this, 'remove_demo' ) );
            
            // Function to test the compiler hook and demo CSS output.
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 2);
            
            // Change the arguments after they've been declared, but before the panel is created
            //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
            
            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
            
            // Dynamically add a section. Can be also used to modify sections/fields
            //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        /**

          This is a test function that will let you see when the compiler hook occurs.
          It only runs if a field	set with compiler=>true is changed.

         * */
        function compiler_action($options, $css) {
            //echo '<h1>The compiler hook has run!';
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )

            /*
              // Demo of how to use the dynamic CSS and write your own static CSS file
              $filename = dirname(__FILE__) . '/style' . '.css';
              global $wp_filesystem;
              if( empty( $wp_filesystem ) ) {
                require_once( ABSPATH .'/wp-admin/includes/file.php' );
              WP_Filesystem();
              }

              if( $wp_filesystem ) {
                $wp_filesystem->put_contents(
                    $filename,
                    $css,
                    FS_CHMOD_FILE // predefined mode settings for WP files
                );
              }
             */
        }

        /**

          Custom function for filtering the sections array. Good for child themes to override or add to the sections.
          Simply include this function in the child themes functions.php file.

          NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
          so you must use get_template_directory_uri() if you want to use any of the built in icons

         * */
        function dynamic_section($sections) {
            //$sections = array();
            $sections[] = array(
                'title' => __('Section via hook', LANGUAGE_ZONE_ADMIN),
                'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', LANGUAGE_ZONE_ADMIN),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }

        /**

          Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.

         * */
        function change_arguments($args) {
            //$args['dev_mode'] = true;

            return $args;
        }

        /**

          Filter hook for filtering the default value of any given field. Very useful in development mode.

         * */
        function change_defaults($defaults) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {

            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
            }
        }

        public function setSections() {

            /**
              Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $sample_patterns_path   = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url    = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns        = array();

            if (is_dir($sample_patterns_path)) :

                if ($sample_patterns_dir = opendir($sample_patterns_path)) :
                    $sample_patterns = array();

                    while (( $sample_patterns_file = readdir($sample_patterns_dir) ) !== false) {

                        if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                            $name = explode('.', $sample_patterns_file);
                            $name = str_replace('.' . end($name), '', $sample_patterns_file);
                            $sample_patterns[]  = array('alt' => $name, 'img' => $sample_patterns_url . $sample_patterns_file);
                        }
                    }
                endif;
            endif;

            ob_start();

            $ct             = wp_get_theme();
            $this->theme    = $ct;
            $item_name      = $this->theme->get('Name');
            $tags           = $this->theme->Tags;
            $screenshot     = $this->theme->get_screenshot();
            $class          = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf(__('Customize &#8220;%s&#8221;', LANGUAGE_ZONE_ADMIN), $this->theme->display('Name'));
            
            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                <?php endif; ?>

                <h4><?php echo $this->theme->display('Name'); ?></h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf(__('By %s', LANGUAGE_ZONE_ADMIN), $this->theme->display('Author')); ?></li>
                        <li><?php printf(__('Version %s', LANGUAGE_ZONE_ADMIN), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . __('Tags', LANGUAGE_ZONE_ADMIN) . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>
            <?php
            if ($this->theme->parent()) {
                printf(' <p class="howto">' . __('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.') . '</p>', __('http://codex.wordpress.org/Child_Themes', LANGUAGE_ZONE_ADMIN), $this->theme->parent()->display('Name'));
            }
            ?>

                </div>
            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();

            $sampleHTML = '';
            if (file_exists(dirname(__FILE__) . '/info-html.html')) {
                /** @global WP_Filesystem_Direct $wp_filesystem  */
                global $wp_filesystem;
                if (empty($wp_filesystem)) {
                    require_once(ABSPATH . '/wp-admin/includes/file.php');
                    WP_Filesystem();
                }
                $sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__) . '/info-html.html');
            }

            // ACTUAL DECLARATION OF SECTIONS
            // Here comes the sections.
            $this->sections[] = array(
                'icon'      => 'el-icon-cogs',
                'title'     => __('General Settings', LANGUAGE_ZONE),
                'fields'    => array(
                    array(
                        'id'        => 'logo-big-dark',
                        'type'      => 'media',
                        'url'       => true,
                        'title'     => __('Logo Big Dark', LANGUAGE_ZONE),
                        'compiler'  => 'true',
                        'subtitle'  => __('Upload here the big logo image (dark version).', LANGUAGE_ZONE),
                        'default'   => array('url' => THEMEROOT . '/assets/img/header/logo-light-bg.png'),
                    ),
                    array(
                        'id'        => 'logo-small-dark',
                        'type'      => 'media',
                        'url'       => true,
                        'title'     => __('Logo Small Dark', LANGUAGE_ZONE),
                        'compiler'  => 'true',
                        'subtitle'  => __('Upload here the small logo image (dark version).', LANGUAGE_ZONE),
                        'default'   => array('url' => THEMEROOT . '/assets/img/header/logo-light-bg-02.png'),
                    ),
                    array(
                        'id'        => 'logo-big-light',
                        'type'      => 'media',
                        'url'       => true,
                        'title'     => __('Logo Big Light', LANGUAGE_ZONE),
                        'compiler'  => 'true',
                        'subtitle'  => __('Upload here the big logo image (light version).', LANGUAGE_ZONE),
                        'default'   => array('url' => THEMEROOT . '/assets/img/header/logo-dark-bg.png'),
                    ),
                    array(
                        'id'        => 'logo-small-light',
                        'type'      => 'media',
                        'url'       => true,
                        'title'     => __('Logo Small Light', LANGUAGE_ZONE),
                        'compiler'  => 'true',
                        'subtitle'  => __('Upload here the small logo image (light version).', LANGUAGE_ZONE),
                        'default'   => array('url' => THEMEROOT . '/assets/img/header/logo-dark-bg-02.png'),
                    ),
                    array(
                        'id'        => 'jscode',
                        'type'      => 'textarea',
                        'title'     => __('Tracking Code', LANGUAGE_ZONE_ADMIN),
                        'subtitle'  => __('Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.', LANGUAGE_ZONE_ADMIN),
                        //'validate'  => 'js',
                        'desc'      => 'Validate that it\'s javascript!',
                    ),
                    array(
                        'id'        => 'csscode',
                        'type'      => 'ace_editor',
                        'title'     => __('CSS Code', LANGUAGE_ZONE_ADMIN),
                        'subtitle'  => __('Paste your CSS code here.', LANGUAGE_ZONE_ADMIN),
                        'mode'      => 'css',
                        'theme'     => 'monokai',
                        'desc'      => 'Possible modes can be found at <a href="http://ace.c9.io" target="_blank">http://ace.c9.io/</a>.',
                        'default'   => ""
                    )
                ));

            $this->sections[] = array(
                'icon'      => 'el-icon-list-alt',
                'title'     => __('Header Options', LANGUAGE_ZONE_ADMIN),
                'fields'    => array(
                    array(
                        'id'        => 'color1',
                        'type'      => 'color',
                        'title'     => __('Theme Color 1', LANGUAGE_ZONE_ADMIN),
                        'default'   => '#1f2021',
                        'validate'  => 'color',
                    ),
                    array(
                        'id'        => 'color2',
                        'type'      => 'color',
                        'title'     => __('Theme Color 2', LANGUAGE_ZONE_ADMIN),
                        'default'   => '#2be6f2',
                        'validate'  => 'color',
                    ),
                    array(
                        'id'        => 'color3',
                        'type'      => 'color',
                        'title'     => __('Theme Color 3 (for shop)', LANGUAGE_ZONE_ADMIN),
                        'default'   => '#f1330e',
                        'validate'  => 'color',
                    ),
                    array(
                        'id'        => 'menu-color-scheme',
                        'type'      => 'select',
                        'title'     => __('Menu Color Scheme', LANGUAGE_ZONE_ADMIN),
                        'options'   => array(
                            'dark' => 'Dark',
                            'light' => 'Light'
                        ),
                        'default'   => 'dark'
                    ),
                    array(
                        'id'        => 'menu-image',
                        'type'      => 'media',
                        'url'       => true,
                        'title'     => __('Menu Background Image', LANGUAGE_ZONE),
                        'compiler'  => 'true',
                        //'subtitle'  => __('Upload here the small logo image (light version).', LANGUAGE_ZONE),
                        'default'   => array('url' => THEMEROOT . '/assets/img/header/menu-bg.jpg'),
                    ),
                ));

            $this->sections[] = array(
                'icon'      => 'el-icon-list-alt',
                'title'     => __('Footer Options', LANGUAGE_ZONE_ADMIN),
                //'desc'      => __('<p class="description">Here you can customize most of the display of Clubix.</p>', LANGUAGE_ZONE_ADMIN),
                'fields'    => array(
                    array(
                        'id'        => 'copyright',
                        'type'      => 'textarea',
                        'title'     => __('Footer Copyright', LANGUAGE_ZONE_ADMIN),
                        //'subtitle'  => __('HTML Allowed (wp_kses)', LANGUAGE_ZONE_ADMIN),
                        //'desc'      => __('This is the description field, again good for additional info.', LANGUAGE_ZONE_ADMIN),
                        'validate'  => 'html', //see http://codex.wordpress.org/Function_Reference/wp_kses_post
                        'default'   => '<p>Copyright 2014 @<a href="#">ROUA</a>. All Rights Reserved</p>'
                    ),
                ));

            $this->sections[] = array(
                'icon'      => 'el-icon-list-alt',
                'title'     => __('Shop Options', LANGUAGE_ZONE_ADMIN),
                //'desc'      => __('<p class="description">Here you can customize most of the display of Clubix.</p>', LANGUAGE_ZONE_ADMIN),
                'fields'    => array(
                    array(
                        'id'        => 'related-products',
                        'type'      => 'switch',
                        'title'     => __('Related Products', LANGUAGE_ZONE),
                        'subtitle'  => __('Turn on or off the related products from the end of the product single page.', LANGUAGE_ZONE),
                        'default'   => true,
                    ),
                ));

            $this->sections[] = array(
                'icon'      => 'el-icon-check',
                'title'     => __('Contact & Social Options', LANGUAGE_ZONE_ADMIN),
                //'desc'      => __('<p class="description">Here you can customize most of the display of Clubix.</p>', LANGUAGE_ZONE_ADMIN),
                'fields'    => array(
                    array(
                        'id'        => 'contact-email',
                        'type'      => 'text',
                        'title'     => __('Contact Email', LANGUAGE_ZONE_ADMIN),
                        'subtitle'  => __('The e-mail address where it will send the messages.', LANGUAGE_ZONE_ADMIN),
                        //'desc'      => __('This is the description field, again good for additional info.', LANGUAGE_ZONE_ADMIN),
                        'validate'  => 'email',
                        'msg'       => 'The email address is not right.',
                        'default'   => 'test@test.com',
                    ),
                    array(
                        'id'        => 'contact-address',
                        'type'      => 'text',
                        'title'     => __('Contact Address', LANGUAGE_ZONE_ADMIN),
                        'subtitle'  => __('This address will be used for the google map on the contact page.', LANGUAGE_ZONE_ADMIN),
                        //'desc'      => __('This is the description field, again good for additional info.', LANGUAGE_ZONE_ADMIN),
                        //'validate'  => 'email',
                        //'msg'       => 'The email address is not right.',
                        'default'   => 'New York, USA',
                    ),
                    array(
                        'id'        => 'contact-title',
                        'type'      => 'text',
                        'title'     => __('Map Title', LANGUAGE_ZONE_ADMIN),
                        'subtitle'  => __('This will appear when you click on the pointer.', LANGUAGE_ZONE_ADMIN),
                        'default'   => 'Contact US',
                    ),
                    array(
                        'id'        => 'contact-description',
                        'type'      => 'textarea',
                        'title'     => __('Map Description', LANGUAGE_ZONE_ADMIN),
                        'subtitle'  => __('This will appear when you click on the pointer.', LANGUAGE_ZONE_ADMIN),
                        'default'   => 'Lorem ipsum dolor sit amet,incididunt ut labore et dolore psum dolor magna aliqua.',
                    ),
                    array(
                        'id'        => 'map-image',
                        'type'      => 'media',
                        'url'       => true,
                        'title'     => __('Pointer Image', LANGUAGE_ZONE),
                        'compiler'  => 'true',
                        'default'   => array('url' => THEMEROOT . '/assets/img/contact/marker.png'),
                    ),
                    array(
                        'id'        => 'social',
                        'type'      => 'multi_text',
                        'title'     => __('Social Icons', LANGUAGE_ZONE_ADMIN),
                        //'validate'  => 'color',
                        'subtitle'  => __('Add a icon shortcode usign a class from Font Awesome.', LANGUAGE_ZONE_ADMIN),
                        //'desc'      => __('This is the description field, again good for additional info.', LANGUAGE_ZONE_ADMIN)
                        'default'   => array('[clx_isocial icon="fa-facebook" href="#" /]','[clx_isocial icon="fa-tumblr" href="#" /]', '[clx_isocial icon="fa-twitter" href="#" /]')
                    ),
                ));

            $this->sections[] = array(
                'type' => 'divide',
            );


            $theme_info  = '<div class="redux-framework-section-desc">';
            $theme_info .= '<p class="redux-framework-theme-data description theme-uri">' . __('<strong>Theme URL:</strong> ', LANGUAGE_ZONE_ADMIN) . '<a href="' . $this->theme->get('ThemeURI') . '" target="_blank">' . $this->theme->get('ThemeURI') . '</a></p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-author">' . __('<strong>Author:</strong> ', LANGUAGE_ZONE_ADMIN) . $this->theme->get('Author') . '</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-version">' . __('<strong>Version:</strong> ', LANGUAGE_ZONE_ADMIN) . $this->theme->get('Version') . '</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-description">' . $this->theme->get('Description') . '</p>';
            $tabs = $this->theme->get('Tags');
            if (!empty($tabs)) {
                $theme_info .= '<p class="redux-framework-theme-data description theme-tags">' . __('<strong>Tags:</strong> ', LANGUAGE_ZONE_ADMIN) . implode(', ', $tabs) . '</p>';
            }
            $theme_info .= '</div>';

            if (file_exists(dirname(__FILE__) . '/../README.md')) {
                $this->sections['theme_docs'] = array(
                    'icon'      => 'el-icon-list-alt',
                    'title'     => __('Documentation', LANGUAGE_ZONE_ADMIN),
                    'fields'    => array(
                        array(
                            'id'        => '17',
                            'type'      => 'raw',
                            'markdown'  => true,
                            'content'   => file_get_contents(dirname(__FILE__) . '/../README.md')
                        ),
                    ),
                );
            }

            $this->sections[] = array(
                'title'     => __('Import / Export', LANGUAGE_ZONE_ADMIN),
                'desc'      => __('Import and Export your Redux Framework settings from file, text or URL.', LANGUAGE_ZONE_ADMIN),
                'icon'      => 'el-icon-refresh',
                'fields'    => array(
                    array(
                        'id'            => 'opt-import-export',
                        'type'          => 'import_export',
                        'title'         => 'Import Export',
                        'subtitle'      => 'Save and restore your Redux options',
                        'full_width'    => false,
                    ),
                ),
            );                     
                    
            $this->sections[] = array(
                'type' => 'divide',
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-info-sign',
                'title'     => __('Theme Information', LANGUAGE_ZONE_ADMIN),
                'desc'      => __('<p class="description">This is the Description. Again HTML is allowed</p>', LANGUAGE_ZONE_ADMIN),
                'fields'    => array(
                    array(
                        'id'        => 'opt-raw-info',
                        'type'      => 'raw',
                        'content'   => $item_info,
                    )
                ),
            );

            if (file_exists(trailingslashit(dirname(__FILE__)) . 'README.html')) {
                $tabs['docs'] = array(
                    'icon'      => 'el-icon-book',
                    'title'     => __('Documentation', LANGUAGE_ZONE_ADMIN),
                    'content'   => nl2br(file_get_contents(trailingslashit(dirname(__FILE__)) . 'README.html'))
                );
            }
        }

        public function setHelpTabs() {

            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-1',
                'title'     => __('Theme Information 1', LANGUAGE_ZONE_ADMIN),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', LANGUAGE_ZONE_ADMIN)
            );

            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-2',
                'title'     => __('Theme Information 2', LANGUAGE_ZONE_ADMIN),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', LANGUAGE_ZONE_ADMIN)
            );

            // Set the help sidebar
            $this->args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', LANGUAGE_ZONE_ADMIN);
        }

        /**

          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                'opt_name' => 'clx_data',
                'page_slug' => 'clx_options',
                'page_title' => 'ROUA Options',
                'update_notice' => '1',
                'admin_bar' => '1',
	            'dev_mode'  => false,
                'menu_type' => 'menu',
                'menu_title' => 'ROUA Options',
                'allow_sub_menu' => '1',
                'page_parent_post_type' => 'your_post_type',
                'customizer' => '1',
                'hints' => 
                array(
                  'icon' => 'el-icon-question-sign',
                  'icon_position' => 'right',
                  'icon_size' => 'normal',
                  'tip_style' => 
                  array(
                    'color' => 'light',
                  ),
                  'tip_position' => 
                  array(
                    'my' => 'top left',
                    'at' => 'bottom right',
                  ),
                  'tip_effect' => 
                  array(
                    'show' => 
                    array(
                      'duration' => '500',
                      'event' => 'mouseover',
                    ),
                    'hide' => 
                    array(
                      'duration' => '500',
                      'event' => 'mouseleave unfocus',
                    ),
                  ),
                ),
                'output' => '1',
                'output_tag' => '1',
                'compiler' => '1',
                'page_icon' => 'icon-themes',
                'page_permissions' => 'manage_options',
                'save_defaults' => '1',
                'show_import_export' => '1',
                'transient_time' => '3600',
                'network_sites' => '1',
              );

            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
            $this->args['share_icons'][] = array(
                'url'   => 'https://github.com/ReduxFramework/ReduxFramework',
                'title' => 'Visit us on GitHub',
                'icon'  => 'el-icon-github'
                //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
            );
            $this->args['share_icons'][] = array(
                'url'   => 'https://www.facebook.com/pages/Redux-Framework/243141545850368',
                'title' => 'Like us on Facebook',
                'icon'  => 'el-icon-facebook'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'http://twitter.com/reduxframework',
                'title' => 'Follow us on Twitter',
                'icon'  => 'el-icon-twitter'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'http://www.linkedin.com/company/redux-framework',
                'title' => 'Find us on LinkedIn',
                'icon'  => 'el-icon-linkedin'
            );

        }

    }
    
    global $reduxConfig;
    $reduxConfig = new admin_folder_Redux_Framework_config();
}

/**
  Custom function for the callback referenced above
 */
if (!function_exists('admin_folder_my_custom_field')):
    function admin_folder_my_custom_field($field, $value) {
        print_r($field);
        echo '<br/>';
        print_r($value);
    }
endif;

/**
  Custom function for the callback validation referenced above
 * */
if (!function_exists('admin_folder_validate_callback_function')):
    function admin_folder_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        $value = 'just testing';

        /*
          do your validation

          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;
            $field['msg'] = 'your custom error message';
          }
         */

        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }
endif;
