<?php
/**
 * File: functions.php
 * Theme: Gary Wallage Wedding Pro
 * BOUTIQUE EDITORIAL MANDATE (NON-NEGOTIABLE):
 * 1. THE 10-80-10 RULE: Strict 10% Margins / 80% Content.
 * 2. THE NEVER-CROP RULE: Preserve artistic image aspect ratios.
 * 3. FOCAL FIDELITY: Maintain centered branding over the Hero Slider.
 */

/**
 * CORE ARCHITECTURE
 */
define( 'GARY_THEME_VERSION', wp_get_theme()->get( 'Version' ) );

require_once get_template_directory() . '/inc/setup.php';
require_once get_template_directory() . '/inc/enqueue.php';
require_once get_template_directory() . '/inc/customizer.php';
require_once get_template_directory() . '/inc/template-tags.php';
require_once get_template_directory() . '/inc/ajax-handlers.php';
require_once get_template_directory() . '/inc/shortcodes.php';
require_once get_template_directory() . '/inc/blocks/service-blocks.php';
require_once get_template_directory() . '/inc/card-renderer.php';
require_once get_template_directory() . '/inc/woocommerce-integration.php';

/**
 * LEGACY / THEME-SPECIFIC OVERRIDES
 * (Moving these to modular files incrementally)
 */

// Placeholder for remaining local functions if any


// Scripts enqueued in inc/enqueue.php

/**
 * UTILITY: Fetch Bookly Forms
 */
function gary_get_bookly_forms()
{
    global $wpdb;
    $table = $wpdb->prefix . 'bookly_forms';
    if ($wpdb->get_var("SHOW TABLES LIKE '$table'") != $table)
        return array();

    $results = $wpdb->get_results("SELECT id, name FROM $table ORDER BY name ASC", ARRAY_A);
    return $results ? $results : array();
}

/**
 * SECURITY: Limit login error messages
 */
add_filter('login_errors', function () {
    return 'Login failed.'; });


// Global Request Modal handled in footer.php

/**
 * HIGH-FIDELITY SHOWCASE BYPASS: Force full-width breakout styles and pristine photography settings inline.
 */
add_action( 'wp_head', function() {
    echo '<style id="gary-showcase-inline-overrides">
        /* Symmetrical Breakout for the Front-Page Gutenberg Trust Bar Group Block */
        .wp-block-group[style*="background-color:#1a1a1a"],
        .wp-block-group[style*="background-color: #1a1a1a"] {
            position: relative !important;
            width: 100vw !important;
            left: 50% !important;
            right: 50% !important;
            margin-left: -50vw !important;
            margin-right: -50vw !important;
            box-sizing: border-box !important;
            max-width: 100vw !important;
        }

        /* 100vw Breakout for the Hero Carousel */
        .hero-peek-carousel {
            position: relative !important;
            width: 100vw !important;
            left: 50% !important;
            right: 50% !important;
            margin-left: -50vw !important;
            margin-right: -50vw !important;
            box-sizing: border-box !important;
        }

        /* Showcase Mode: Completely remove dark radial vignette overlays or filters from background images */
        .image-overlay {
            background: none !important;
            background-image: none !important;
            opacity: 0 !important;
            display: none !important;
        }
    </style>';
}, 999 );
