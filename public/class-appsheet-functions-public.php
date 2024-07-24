<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://bachacode.com
 * @since      1.0.0
 *
 * @package    Appsheet_Functions
 * @subpackage Appsheet_Functions/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Appsheet_Functions
 * @subpackage Appsheet_Functions/public
 * @author     Cristhian Flores <bachacode@gmail.com>
 */
class Appsheet_Functions_Public {

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
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Appsheet_Functions_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Appsheet_Functions_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/appsheet-functions-public.css', array(), $this->version, 'all' );

		wp_enqueue_style( $this->plugin_name . '-searchbar', plugin_dir_url( __FILE__ ) . 'css/appsheet-functions-searchbar.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Appsheet_Functions_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Appsheet_Functions_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/appsheet-functions-public.js', array( 'jquery' ), $this->version, false );
		 
		// Register searchbar JS Script
		wp_register_script( $this->plugin_name . '-searchbar', plugin_dir_url( __FILE__ ) . 'js/appsheet-functions-searchbar.js', array( 'jquery' ), $this->version, false );
	}

	public function query_appsheet_functions() {
		/**
		 * Check nonce for security
		 */
		if ( ! check_ajax_referer( 'query_appsheet-functions', '_nonce', false ) ) {
			wp_send_json_error( 'Invalid security token sent.' );
			die();
		}
	
		// The rest of the function that does actual work.

		$ret = array();
		
		$search_query = sanitize_text_field($_POST['search_query']);

		// Eg.: custom Loop for Custom Post Type
		$args = array(
			'post_type' => 'expresiones-appsheet',
			'posts_per_page' => '-1', // for all of them
			'_name__like' => '*'.$search_query.'*'
		);
	
		$loop = new WP_Query( $args );
	
		while( $loop->have_posts() ): $loop->the_post();
			$post_data = array (
				'post_id'		=> get_the_ID(),
				'post_title' 	=> get_the_title(),
			);
			array_push($ret, $post_data);
		endwhile;
	
		wp_reset_query();
	
		die( json_encode( $ret ) );
	
	}

}
