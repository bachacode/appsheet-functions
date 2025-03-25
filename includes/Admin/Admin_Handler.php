<?php

namespace TailorSheet_Manager\Admin;

use TailorSheet_Manager\Helpers;

class Admin_Handler
{
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Tailorsheet_Manager_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Tailorsheet_Manager_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        
        wp_enqueue_style($this->plugin_name, Helpers::admin_assets('css/tailorsheet-manager-admin.css'), array(), $this->version, 'all');
        wp_enqueue_style('select2-css', Helpers::admin_assets('css/select2.min.css'), array(), '4.1.0', 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Tailorsheet_Manager_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Tailorsheet_Manager_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->plugin_name, Helpers::admin_assets('js/tailorsheet-manager-admin.js'), array( 'jquery' ), $this->version, false);
        wp_enqueue_script('select2-js', Helpers::admin_assets('js/select2.min.js'), array('jquery'), '4.1.0', true);
    }

    public function create_menu()
    {
        // If we are not in admin area exit.
			if ( ! is_admin() ) {
				return;
			}

        $config = array(

            'type'              => 'menu',
            'id'                => "{$this->plugin_name}-admin",
            'title'             => esc_html__('TailorSheet Manager', 'tailorsheet-manager'),
            'menu_title'        => esc_html__('TailorSheet Manager', 'tailorsheet-manager'),
            'submenu'           => false,
            'position'          => 6,
            'capability'        => 'manage_options',
            'icon'              => 'dashicons-clipboard',
        );

        $fields_menu[] = array(
            'name'   => 'expresiones-appsheet-options',
            'title'  => 'Opciones de Expresiones AppSheet',
            'icon'   => 'dashicons-admin-generic',
            'fields' => array(
                array(
                    'id'          => 'expresiones-appsheet-archive',
                    'type'        => 'text',
                    'title'       => 'Slug de archivo',
                    'description' => 'Slug de la página de archivado de "Expresiones AppSheet", si se deja vacio se desactivara el archivado',
                    'attributes'    => array(
                    'placeholder' => 'e.g: lista-de-expresiones'
                    )
                ),
            ),
        );

        $fields_menu[] = array(
            'name'   => 'ejemplos-appsheet-options',
            'title'  => 'Opciones de Ejemplos AppSheet',
            'icon'   => 'dashicons-admin-generic',
            'fields' => array(
                array(
                    'id'          => 'ejemplos-appsheet-archive',
                    'type'        => 'text',
                    'title'       => 'Slug de archivo',
                    'description' => 'Slug de la página de archivado de "Ejemplos AppSheet", si se deja vacio se desactivara el archivado',
                    'attributes'    => array(
                    'placeholder' => 'e.g: lista-de-ejemplos'
                    )
                ),
            ),
        );

        /**
         * instantiate your admin page
         */
        (new \Exopite_Simple_Options_Framework($config, $fields_menu));

        $submenu_options = array(
            array(
                'page_title'        => 'Expresiones AppSheet',
                'menu_title'        => 'Expresiones AppSheet',
                'menu_slug'         => 'edit.php?post_type=expresiones-appsheet',
            ),
            array(
                'page_title'        => 'Categorías de Expresión',
                'menu_title'        => 'Categorías de Expresión',
                'menu_slug'         => 'edit-tags.php?taxonomy=categoria-de-expresion',
            ),
            array(
                'page_title'        => 'Ejemplos de Expresión',
                'menu_title'        => 'Ejemplos de Expresión',
                'menu_slug'         => 'edit-tags.php?taxonomy=ejemplo-de-expresion',
            ),
            // array(
            //     'page_title'        => 'Expresiones relacionadas',
            //     'menu_title'        => 'Expresiones relacionadas',
            //     'menu_slug'         => 'edit-tags.php?taxonomy=relacion-de-expresion',
            // ),
            array(
                'page_title'        => 'Ejemplos AppSheet',
                'menu_title'        => '<span class="ts-manager-settings-menu-title">Ejemplos AppSheet</span>',
                'menu_slug'         => 'edit.php?post_type=ejemplos-appsheet',
            ),
            // array(
            //     'page_title'        => 'Categorías de Ejemplo',
            //     'menu_title'        => 'Categorías de Ejemplo',
            //     'menu_slug'         => 'edit-tags.php?taxonomy=categoria-de-ejemplo',
            // ),
            array(
                'page_title'        => 'Sectores de Ejemplo',
                'menu_title'        => 'Sectores de Ejemplo',
                'menu_slug'         => 'edit-tags.php?taxonomy=sector-de-ejemplo',
            ),
            array(
                'page_title'        => 'Funcionalidades de Ejemplo',
                'menu_title'        => 'Funcionalidades de Ejemplo',
                'menu_slug'         => 'edit-tags.php?taxonomy=func-de-ejemplo',
            ),
            array(
                'page_title'        => 'Integraciones de Ejemplo',
                'menu_title'        => 'Integraciones de Ejemplo',
                'menu_slug'         => 'edit-tags.php?taxonomy=integracion-de-ejemplo',
            ),
            // array(
            //     'page_title'        => 'Etiquetas de Ejemplo',
            //     'menu_title'        => 'Etiquetas de Ejemplo',
            //     'menu_slug'         => 'edit-tags.php?taxonomy=etiqueta-de-ejemplo',
            // ),
        );

        foreach ($submenu_options as $option) {
            add_submenu_page(
                'tailorsheet-manager-admin', // The slug of your top-level menu
                $option['page_title'], // Page title
                $option['menu_title'], // Menu title
                'manage_options', // Capability
                $option['menu_slug'] // Link to CPT
            );
        }

        add_submenu_page(
            'tailorsheet-manager-admin',
            'TailorSheet Manager',
            '<span class="ts-manager-settings-menu-title">Ajustes</span>',
            'manage_options',
            'tailorsheet-manager-admin'
        );
    }

    public function create_metaboxes()
    {
        /*
        * To add a metabox.
        * This normally go to your functions.php or another hook
        */
        $config_metabox = array(

            /*
            * METABOX
            */
            'type'              => 'metabox',                       // Required, menu or metabox
            'id'                => 'functions-meta',    // Required, meta box id, unique, for saving meta: id[field-id]
            // 'post_types'        => array( 'page' ),                 // Post types to display meta box
            'post_types'        => array( 'expresiones-appsheet' ),         // Post types to display meta box
            'context'           => 'advanced',
            'options'			=> 'simple',
            'priority'          => 'default',
            'title'             => __('Extra fields', 'tailorsheet-manager'),                  // The name of this page
            'capability'        => 'edit_posts',                    // The capability needed to view the page
            'tabbed'            => false,

        );

        $fields[] = array(
            'name'   => 'first',
            'title'  => __('Appsheet Function fields', 'tailorsheet-manager'),
            'icon'   => 'dashicons-admin-generic',
            'fields' => array(

                /**
                 * Available fields:
                 * - ACE field
                 * - attached
                 * - backup
                 * - button
                 * - botton_bar
                 * - card
                 * - checkbox
                 * - color
                 * - content
                 * - date
                 * - editor
                 * - group
                 * - hidden
                 * - image
                 * - image_select
                 * - meta
                 * - notice
                 * - number
                 * - password
                 * - radio
                 * - range
                 * - select
                 * - switcher
                 * - tap_list
                 * - text
                 * - textarea
                 * - upload
                 * - video mp4/oembed
                 *
                 * Add your fields, eg.:
                 */

                array(
                    'id'          => 'function_syntax',
                    'type'        => 'text',
                    'title'       => __('Example Syntax', 'tailorsheet-manager'),
                    'attributes'    => array(
                        'rows'        => 10,
                        'cols'        => 5,
                        'placeholder' => 'e.g: Function ( number1, number2 )',
                    ),
                    'help'        => __('The syntax shown on the function description page', 'tailorsheet-manager'),

                ),

                array(
                    'id'          => 'expected_result',
                    'type'        => 'text',
                    'title'       => __('Expected Result', 'tailorsheet-manager'),
                    'attributes'    => array(
                        'rows'        => 10,
                        'cols'        => 5,
                        'placeholder' => 'e.g: Number or Decimal',
                    ),
                    'help' 		=> __('The type of data that is returned by the function', 'tailorsheet-manager'),
                ),

                array(
                    'id'          => 'explanation',
                    'type'        => 'editor',
                    'title'       => __('Explanation', 'tailorsheet-manager'),
                    'attributes'    => array(
                        'rows'        => 10,
                        'cols'        => 5,
                    ),
                ),

                array(
                    'id'          => 'related_functions',
                    'type'        => 'select',
                    'title'       => __('Related Functions', 'tailorsheet-manager'),
                    'query'          => array(
                        'type'          => 'posts', // Built-in type 'posts' to query custom post types.
                        'args'          => array(
                            'post_type'      => 'expresiones-appsheet', // Your custom post type.
                            'posts_per_page' => -1, // Retrieve all posts.
                            'orderby'        => 'title', // Order by title for better readability.
                            'order'          => 'ASC', // Ascending order.
                        ),
                    ),
                    'attributes'     => array(
                        'multiple'       => true, // Makes the select a multiselect field.
                        'rows'        => 10,
                        'cols'        => 5,
                    ),
                    'default_option' => 'Select one or more...', // Optional default placeholder option.
                
                ),
            ),
        );

        /**
         * instantiate your admin page
         */
        (new \Exopite_Simple_Options_Framework($config_metabox, $fields));
    }

    public function create_metaboxes_examples_appsheet()
    {
        $config_metabox = array(
            'type'              => 'metabox',
            'id'                => 'examples-appsheet-meta',
            'post_types'        => array( 'ejemplos-appsheet' ),
            'context'           => 'advanced',
            'options'			=> 'simple',
            'priority'          => 'default',
            'title'             => __('Extra fields', 'tailorsheet-manager'),
            'capability'        => 'edit_posts',
            'tabbed'            => false,
        );

        $fields[] = array(
            'name'   => 'first',
            'title'  => __('External Fields', 'tailorsheet-manager'),
            'icon'   => 'dashicons-external',
            'fields' => array(
                array(
                    'id'          => 'presentation_video',
                    'type'        => 'text',
                    'title'       => __('Presentation video', 'tailorsheet-manager'),
                    'attributes'    => array(
                        'rows'        => 10,
                        'cols'        => 5,
                        'placeholder' => 'https://youtube.com...',
                    ),
                ),
                array(
                    'id'          => 'iframe_code',
                    'type'        => 'text',
                    'title'       => __('Iframe code', 'tailorsheet-manager'),
                    'attributes'    => array(
                        'rows'        => 10,
                        'cols'        => 5,
                        'placeholder' => 'Codigo del iframe de la app',
                    ),
                ),
            ),
        );

        $fields[] = array(
            'name'   => 'second',
            'title'  => __('App Tabs', 'tailorsheet-manager'),
            'icon'   => 'dashicons-editor-ul',
            'fields' => array(
                array(
                    'id'          => 'app_information',
                    'type'        => 'editor',
                    'title'       => __('App Information', 'tailorsheet-manager'),
                    'attributes'    => array(
                        'rows'        => 10,
                        'cols'        => 5,
                    ),
                ),
                array(
                    'id'          => 'sections',
                    'type'        => 'editor',
                    'title'       => __('Sections', 'tailorsheet-manager'),
                    'attributes'    => array(
                        'rows'        => 10,
                        'cols'        => 5,
                    ),
                ),
                array(
                    'id'          => 'functionality',
                    'type'        => 'editor',
                    'title'       => __('Functionality', 'tailorsheet-manager'),
                    'attributes'    => array(
                        'rows'        => 10,
                        'cols'        => 5,
                    ),
                ),

                array(
                    'id'          => 'app_gallery',
                    'type'        => 'gallery',
                    'title'       => __('Gallery', 'tailorsheet-manager'),
                    'options' => array(
                        'add_button'  => esc_attr__( 'Add to gallery', 'tailorsheet-manager' ),
                    )
                    
                ),
            ),
        );

        $fields[] = array(
            'name'   => 'third',
            'title'  => __('SEO Fields', 'tailorsheet-manager'),
            'icon'   => 'dashicons-chart-bar',
            'fields' => array(
                array(
                    'id'          => 'app_faq',
                    'type'        => 'group',
                    'title'       => __('FAQs', 'tailorsheet-manager'),
                    'options'     => array(
                        'repeater'      => true,
                        'accordion'     => true,
                        'sortable'      => true,
                        'button_title'  => __('Add New Question', 'tailorsheet-manager'),
                        'group_title'   => __('Frequently Asked Question', 'tailorsheet-manager'),
                        'limit'         => 30,
                    ),
                    'fields' => array(
                        array(
                            'id'    => 'app_faq_question',
                            'type'  => 'text',
                            'title' => __('Question', 'tailorsheet-manager'),
                        ),
                        array(
                            'id'          => 'app_faq_answer',
                            'type'        => 'editor',
                            'title'       => __('Answer', 'tailorsheet-manager'),
                        )
                    )
                ),
                array(
                    'id'          => 'app_structured_data_script',
                    'type'        => 'ace_editor',
                    'title'       => __('Structured Data', 'tailorsheet-manager'),
                    'options' => array(
                        'theme'                     => 'ace/theme/chrome', // Choose a theme
                        'mode'                      => 'ace/mode/javascript', // Set mode to JavaScript for JSON-LD
                        'showGutter'                => true, // Show line numbers
                        'showPrintMargin'           => false, // Hide print margin
                        'enableBasicAutocompletion' => false, // Enable autocompletion
                        'enableSnippets'            => false,
				        'enableLiveAutocompletion'  => false,
                    ),
                    'attributes' => array(
                        'style' => 'height: 300px; max-width: 700px;', // Adjust size
                    ),
                ),
            ),
        );

        /**
         * instantiate your admin page
         */
        (new \Exopite_Simple_Options_Framework($config_metabox, $fields));
    }

    public function fe_add_fields()
    {
        Helpers::render_template('af-admin-function-example-fields');
    }

    public function fe_edit_fields($term, $taxonomy)
    {
        $syntax = get_term_meta($term->term_id, 'fe_syntax', true);
        $expected = get_term_meta($term->term_id, 'fe_expected', true);

        Helpers::render_template('af-admin-function-example-fields', array(
            'syntax' => $syntax,
            'expected' => $expected
        ));
    }

    public function fe_save_term_fields($term_id)
    {
        update_term_meta(
            $term_id,
            'fe_syntax',
            sanitize_text_field($_POST[ 'fe_syntax' ])
        );
        update_term_meta(
            $term_id,
            'fe_expected',
            htmlspecialchars($_POST[ 'fe_expected' ], ENT_QUOTES, 'UTF-8')
        );

    }

    public function search_posts_by_name_like($where, $q)
    {
        if ($name__like = $q->get('_name__like')) {
            global $wpdb;
            $where .= $wpdb->prepare(
                " AND {$wpdb->posts}.post_name LIKE %s ",
                str_replace(
                    array( '**', '*' ),
                    array( '*',  '%' ),
                    mb_strtolower($wpdb->esc_like($name__like))
                )
            );
        }
        return $where;
    }

    public function register_elementor_widgets($widgets_manager)
    {
        $registered_widgets = require_once TAILORSHEET_MANAGER_BASE_DIR . 'config/widgets.php';
        
        foreach($registered_widgets as $widget) {
            if($widget['published']) {
                $widgets_manager->register(new $widget['class']);
            }
        }  
    }

    public function register_elementor_tailorsheet_manager_category($elements_manager)
    {
        $elements_manager->add_category(
            'tailorsheet-manager',
            [
                'title' => esc_html__('TailorSheet Manager', 'tailorsheet-manager'),
            ]
        );
    }

    public function upgrader_process_complete($upgrader_object, $options)
    {

        // If an update has taken place and the updated type is plugins and the plugins element exists
        if ($options['action'] == 'update' && $options['type'] == 'plugin' && isset($options['plugins'])) {

            // Iterate through the plugins being updated and check if ours is there
            foreach ($options['plugins'] as $plugin) {
                if ($plugin == TAILORSHEET_MANAGER_BASE_NAME) {

                    // Your code here, eg display a message:

                    // Set a transient to record that our plugin has just been updated
                    set_transient($this->plugin_name . '_updated', 1);
                    set_transient($this->plugin_name . '_updated_message', esc_html__('Thanks for updating', 'exopite_sof'));

                }
            }
        }
    }

    public function display_update_notice()
    {

        // Check the transient to see if we've just activated the plugin
        if (get_transient($this->plugin_name . '_updated')) {

            /**
             * Display a message.
             */
            // @link https://digwp.com/2016/05/wordpress-admin-notices/
            echo '<div class="notice notice-success is-dismissible"><p><strong>' . get_transient('exopite_sof_updated_message') . '</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';

            // Delete the transient so we don't keep displaying the activation message
            delete_transient($this->plugin_name . '_updated');
            delete_transient($this->plugin_name . '_updated_message');
        }

    }
}
