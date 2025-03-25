<?php

namespace TailorSheet_Manager;

use TailorSheet_Manager\Libraries\Custom_Template_Loader;

class Helpers 
{
    static public function load_template($template_name, $data = array ())
    {
        $templates = new Custom_Template_Loader;
        // Turn on output buffering, because it is a shortcode, content file should not echo anything out.
        // In other cases, output buffering may not required.
        ob_start();
        // Load template from PLUGIN_NAME_BASE_DIR/templates/content-header.php
        $templates->set_template_data($data)->get_template_part( $template_name );
        // Return content ftom the file
        return ob_get_clean();
    }

    static public function render_template($template_name, $data = array())
    {
        echo Helpers::load_template($template_name, $data);
    }

    static public function init_twig() {
        $template_dir = TAILORSHEET_MANAGER_BASE_DIR . 'templates'; // Path to your Twig templates
    
        $loader = new \Twig\Loader\FilesystemLoader($template_dir);
        $twig = new \Twig\Environment($loader, [
            'debug' => true, // Enable debugging (set to false in production)
            'cache' => TAILORSHEET_MANAGER_BASE_DIR . 'cache', // Optional: set a cache directory
        ]);
    
        return $twig;
    }

    static public function render_twig_template($template_name, $data = array()) {
        $twig = Helpers::init_twig();
    
        echo $twig->render($template_name, $data);
    }

    static public function admin_assets($dir) 
    {
        return TAILORSHEET_MANAGER_BASE_URL . 'assets/admin/' . $dir;
    }

    static public function public_assets($dir) 
    {
        return TAILORSHEET_MANAGER_BASE_URL . 'assets/public/' . $dir;
    }
}