<?php
/**
 * File: inc/blocks/service-blocks.php
 * Description: Main entry point for custom editorial blocks.
 */

$block_modules = array(
    'registration.php',
    'rendering.php',
    'editor.php',
);

foreach ($block_modules as $module) {
    require_once plugin_dir_path(__FILE__) . $module;
}
