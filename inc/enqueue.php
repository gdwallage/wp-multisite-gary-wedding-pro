<?php
/**
 * Enqueue: Scripts and styles management.
 */

function gary_wedding_scripts() {
    $theme_dir = get_template_directory();
    
    // Core CSS - filemtime for dynamic cache busting (prefer minified in production)
    $css_file = file_exists( $theme_dir . '/style.min.css' ) ? '/style.min.css' : '/style.css';
    $css_ver  = filemtime( $theme_dir . $css_file );
    wp_enqueue_style( 'gary-wedding-v3-editorial', get_template_directory_uri() . $css_file, array(), $css_ver );
    
    // Core JS - front page uses Vanilla JS, avoid loading jQuery
    if ( ! is_front_page() ) {
        wp_enqueue_script( 'jquery' );
    }
    
    $js_file = file_exists( $theme_dir . '/js/main.min.js' ) ? '/js/main.min.js' : '/js/main.js';
    $js_ver  = filemtime( $theme_dir . $js_file );
    wp_enqueue_script( 'gary-wedding-main', get_template_directory_uri() . $js_file, array(), $js_ver, true );

    // Page-Specific
    if ( is_front_page() ) {
        $slider_ver = file_exists( $theme_dir . '/js/hero-slider.js' ) ? filemtime( $theme_dir . '/js/hero-slider.js' ) : $css_ver;
        wp_enqueue_script( 'gw-hero-slider', get_template_directory_uri() . '/js/hero-slider.js', array(), $slider_ver, true );
    }
}
add_action( 'wp_enqueue_scripts', 'gary_wedding_scripts' );

function gary_wedding_editor_assets() {
    $ver = GARY_THEME_VERSION;
    wp_enqueue_script( 'gary-editorial-blocks-js', get_template_directory_uri() . '/inc/blocks/service-blocks.js', array(
        'jquery', 'wp-blocks', 'wp-element', 'wp-components', 'wp-block-editor', 'wp-server-side-render'
    ), $ver, true );
}
add_action( 'enqueue_block_editor_assets', 'gary_wedding_editor_assets' );

/**
 * Dynamic styles and preloading in head.
 */
add_action( 'wp_head', function () {
    $logo_size = get_theme_mod( 'logo_size_px', '225' );
    $theme_uri = get_template_directory_uri();
    
    if ( $logo_size ) {
        echo "<style>.custom-logo { max-width: " . (int)$logo_size . "px !important; }</style>\n";
    }

    // Font Preloading
    echo '<link rel="preload" as="font" href="' . esc_url( $theme_uri . '/fonts/Blacksword.woff2' ) . '" type="font/woff2" crossorigin>' . "\n";
    echo '<link rel="preload" as="font" href="' . esc_url( $theme_uri . '/fonts/lato-bold.woff2' ) . '" type="font/woff2" crossorigin>' . "\n";
    echo '<link rel="preload" as="font" href="' . esc_url( $theme_uri . '/fonts/lato-regular.woff2' ) . '" type="font/woff2" crossorigin>' . "\n";
} );
