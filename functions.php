<?php
/**
 * File: functions.php
 * Theme: Gary Wallage Wedding Pro
 * Version: 3000.150.0
 * 
 * CORE ARCHITECTURE: Modularized for Uber Developer Standards.
 */

// 1. Core Constants
define('GARY_THEME_VERSION', '3000.150.0');

// 2. Load Modules
$gary_modules = array(
    'inc/setup.php',                 // Theme setup and support
    'inc/enqueue.php',               // Scripts and styles
    'inc/customizer.php',            // Customizer settings
    'inc/template-tags.php',         // Helper functions
    'inc/ajax-handlers.php',         // AJAX logic
    'inc/meta-boxes.php',            // Page meta boxes
    'inc/woocommerce-integration.php', // Portal and credits
    'inc/shortcodes.php',            // Theme shortcodes
    'inc/card-renderer.php',         // Dynamic card rendering
    'inc/blocks/service-blocks.php', // Gutenberg blocks
);

foreach ($gary_modules as $module) {
    $file = get_template_directory() . '/' . $module;
    if (file_exists($file)) {
        require_once $file;
    }
}

// 3. Security: Limit login error messages
add_filter('login_errors', function () {
    return 'Login failed.';
});
