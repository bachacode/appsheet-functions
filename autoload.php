<?php

spl_autoload_register(function ($class) {
    // Define namespace mappings
    $prefixes = [
        'TailorSheet_Manager\\' => TAILORSHEET_MANAGER_BASE_DIR . 'includes/',
        'Twig\\' => TAILORSHEET_MANAGER_BASE_DIR . 'vendor/twig/src/', // Adjusted path for Twig source files
    ];

    foreach ($prefixes as $prefix => $base_dir) {
        // Check if the class uses the prefix
        if (strncmp($prefix, $class, strlen($prefix)) === 0) {
            // Remove the namespace prefix
            $relative_class = substr($class, strlen($prefix));

            // Convert namespace separators to directory separators and append ".php"
            $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

            // Check if file exists before including
            if (file_exists($file)) {
                require $file;
            }
        }
    }
});
