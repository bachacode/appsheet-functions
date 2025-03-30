<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://bachacode.com
 * @since             1.0.0
 * @package           Tailorsheet_Manager
 *
 * @wordpress-plugin
 * Plugin Name:       TailorSheet Manager
 * Plugin URI:        https://bachacode.com
 * Description:       Custom plugin tailored for TailorSheet Website to manage AppSheet related features
 * Version:           2.7.1
 * Author:            Cristhian Flores
 * Author URI:        https://bachacode.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       tailorsheet-manager
 * Domain Path:       /languages
 * Requires Plugins: elementor
 */

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}

/**
 * Currently plugin version.
 */
define('TAILORSHEET_MANAGER_VERSION', '2.7.1');

/**
 * Store plugin base dir, for easier access later from other classes.
 * (eg. Include, public or admin)
 */
define('TAILORSHEET_MANAGER_BASE_DIR', plugin_dir_path(__FILE__));

/**
 * This is useful if you need to display a message or update options, etc...
 */
define('TAILORSHEET_MANAGER_BASE_NAME', plugin_basename(__FILE__));

/**
 * Store plugin base dir, for easier access later from other classes.
 * (eg. Include, public or admin)
 */
define('TAILORSHEET_MANAGER_BASE_URL', plugin_dir_url(__FILE__));

define('TAILORSHEET_MANAGER_NAME_SLUG', 'tailorsheet-manager');

/**
 * Including composer autoloader globally.
 *
 * @since 2.5.4
 */
require_once TAILORSHEET_MANAGER_BASE_DIR . 'autoload.php';

if (! class_exists('\YahnisElsts\PluginUpdateChecker\v5\Puc_v4_Factory')) {
    require_once plugin_dir_path(__FILE__) . 'vendor/plugin-update-checker/plugin-update-checker.php';
}

if (is_admin()) {
    $myUpdateChecker = \YahnisElsts\PluginUpdateChecker\v5\PucFactory::buildUpdateChecker(
        'https://github.com/bachacode/tailorsheet-manager',
        __FILE__,
        TAILORSHEET_MANAGER_NAME_SLUG
    );

    //Set the branch that contains the stable release.
    $myUpdateChecker->setBranch('main');

    add_action('in_plugin_update_message-tailorsheet-manager/tailorsheet-manager.php', 'show_upgrade_notification', 10, 2);
    function show_upgrade_notification($current_plugin_metadata, $new_plugin_metadata)
    {
        // check "upgrade_notice"
        if (isset($new_plugin_metadata->upgrade_notice) && strlen(trim($new_plugin_metadata->upgrade_notice))  > 0) {

            echo '<span style="background-color:#d54e21;padding:6px;color:#f9f9f9;margin-top:10px;display:block;"><strong>' . esc_html('Upgrade Notice', 'tailorsheet-manager') . ':</strong><br>';
            echo esc_html($new_plugin_metadata->upgrade_notice);
            echo '</span>';

        }
    }
}
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-tailorsheet-manager-activator.php
 */
function activate_tailorsheet_manager()
{
    \TailorSheet_Manager\Core\Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-tailorsheet-manager-deactivator.php
 */
function deactivate_tailorsheet_manager()
{
    \TailorSheet_Manager\Core\Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_tailorsheet_manager');
register_deactivation_hook(__FILE__, 'deactivate_tailorsheet_manager');

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_tailorsheet_manager()
{
    $plugin = new \TailorSheet_Manager\Core\Bootstrap();
    $plugin->run();
}
run_tailorsheet_manager();
