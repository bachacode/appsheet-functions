<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://bachacode.com
 * @since      1.0.0
 *
 * @package    Tailorsheet_Manager
 * @subpackage Tailorsheet_Manager/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Tailorsheet_Manager
 * @subpackage Tailorsheet_Manager/includes
 * @author     Cristhian Flores <bachacode@gmail.com>
 */
class Tailorsheet_Manager_i18n
{
    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    public function load_plugin_textdomain()
    {

        load_plugin_textdomain(
            'tailorsheet-manager',
            false,
            dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
        );

    }



}
