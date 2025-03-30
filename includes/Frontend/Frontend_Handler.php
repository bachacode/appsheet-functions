<?php

namespace TailorSheet_Manager\Frontend;

use TailorSheet_Manager\Helpers;

class Frontend_Handler
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
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
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

        wp_enqueue_style($this->plugin_name, Helpers::public_assets('css/tailorsheet-manager-public.css') , array(), $this->version, 'all');

        wp_enqueue_style($this->plugin_name . '-main', Helpers::public_assets('css/tailorsheet-manager-main.css') , array(), $this->version, 'all');

        wp_enqueue_style($this->plugin_name . '-faq', Helpers::public_assets('css/tailorsheet-manager-faq.css'), array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
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

        wp_enqueue_script( $this->plugin_name, Helpers::public_assets('js/tailorsheet-manager-public.js'), array( 'jquery' ), $this->version, false);
        
        // AlpineJS
        wp_register_script( $this->plugin_name . "-alpinejs", Helpers::public_assets('js/alpinejs.min.js'), array(), $this->version, array ( 'strategy' => 'defer' ));
        
        // Register searchbar JS Script
        wp_register_script( $this->plugin_name . '-main', Helpers::public_assets('js/tailorsheet-manager-main.js'), array( 'jquery' ), $this->version, false);

        wp_enqueue_script( $this->plugin_name . '-faq', Helpers::public_assets('js/tailorsheet-manager-faq.js'), array('jquery'), $this->version, false );
    }

    public function query_tailorsheet_manager()
    {

        /**
         * Check nonce for security
         */
        if (! check_ajax_referer('query_tailorsheet-manager', '_nonce', false)) {
            wp_send_json_error('Invalid security token sent.');
            die();
        }

        // The rest of the function that does actual work.

        $ret = array();

        $search_query = rtrim(sanitize_text_field($_POST['search_query']), "()\n\r\t\v\0 ");

        // Eg.: custom Loop for Custom Post Type
        $args = array(
            'post_type' => 'expresiones-appsheet',
            'posts_per_page' => '-1', // for all of them
            'post_status' => 'publish',
            '_name__like' => '*'.$search_query.'*'
        );

        $loop = new \WP_Query($args);

        while($loop->have_posts()): $loop->the_post();
            $post_data = array(
                'post_id'		=> get_the_ID(),
                'post_title' 	=> get_the_title(),
                'post_url' 		=> get_the_permalink(),
                'post_categories' => get_the_terms(get_the_ID(), 'categoria-de-expresion')
            );
            array_push($ret, $post_data);
        endwhile;
        
        $template = Helpers::load_template('af-appsheet-functions-list', array( 'posts' => $ret ));

        wp_reset_query();

        die($template);

    }

    public function query_tailorsheet_manager_by_category()
    {

        /**
         * Check nonce for security
         */
        if (! check_ajax_referer('query_tailorsheet-manager', '_nonce', false)) {
            wp_send_json_error('Invalid security token sent.');
            die();
        }

        // The rest of the function that does actual work.

        $ret = array();

        $categories = isset($_POST['categories']) ? (array) $_POST['categories'] : array();
        $categories = array_map('esc_attr', $categories);
        $categories = array_map('intval', $categories);

        // Eg.: custom Loop for Custom Post Type
        $args = array(
            'post_type' => 'expresiones-appsheet',
            'posts_per_page' => '-1', // for all of them
            'post_status' => 'publish',

        );

        if(!($categories === [])) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'categoria-de-expresion',
                    'field'		=> 'term_id',
                    'terms'		=> $categories
                    )
                );
        }

        $loop = new \WP_Query($args);

        while($loop->have_posts()): $loop->the_post();
            $post_data = array(
                'post_id'		=> get_the_ID(),
                'post_title' 	=> get_the_title(),
                'post_url' 		=> get_the_permalink(),
                'post_categories' => get_the_terms(get_the_ID(), 'categoria-de-expresion')
            );
            array_push($ret, $post_data);
        endwhile;

        $template = Helpers::load_template('af-appsheet-functions-list', array( 'posts' => $ret ));

        wp_reset_query();

        die($template);

    }

}
