<?php
/**
 * Setup: Theme support, images, and initial configuration.
 */

if ( ! function_exists( 'gary_wedding_setup' ) ) :
    function gary_wedding_setup() {
        add_theme_support( 'title-tag' );
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'align-wide' );
        add_theme_support( 'html5', array( 'gallery', 'caption', 'style', 'script' ) );
        add_theme_support( 'custom-logo', array(
            'height'      => 400,
            'width'       => 400,
            'flex-height' => true,
            'flex-width'  => true,
        ) );
        register_nav_menus( array( 'primary' => __( 'Primary Menu', 'garywedding' ) ) );
        add_post_type_support( 'page', 'excerpt' );
        
        // Editor Parity
        add_theme_support( 'editor-styles' );
        add_editor_style( 'style.css' );
        add_editor_style( 'editor-style.css' );

        // High-Precision Editorial Sizes
        add_image_size( 'gw-card-thumb', 500, 500, true );
        add_image_size( 'gw-service-icon', 160, 160, true ); 
        add_image_size( 'gw-hero', 1920, 1080, true );
        add_image_size( 'gw-logo', 250, 250, false ); 
    }
endif;
add_action( 'after_setup_theme', 'gary_wedding_setup' );

/**
 * Image Quality Optimization
 */
add_filter( 'jpeg_quality', function() { return 82; } );
add_filter( 'wp_editor_set_quality', function() { return 82; } );

/**
 * Endpoints
 */
function gary_add_my_bookings_endpoint() {
    add_rewrite_endpoint( 'my-bookings', EP_PAGES );
}
add_action( 'init', 'gary_add_my_bookings_endpoint' );
