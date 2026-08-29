<?php
/**
 * Enqueue: Scripts and styles management.
 */

function gary_wedding_scripts() {
    $theme_dir = get_template_directory();
    
    // Core CSS - filemtime for dynamic cache busting
    $css_ver = file_exists( $theme_dir . '/style.css' ) ? filemtime( $theme_dir . '/style.css' ) : wp_get_theme()->get('Version');
    wp_enqueue_style( 'gary-wedding-v3-editorial', get_template_directory_uri() . '/style.css', array(), $css_ver );
    
    // Core JS
    wp_enqueue_script( 'jquery' );
    
    $js_ver = file_exists( $theme_dir . '/js/main.js' ) ? filemtime( $theme_dir . '/js/main.js' ) : $css_ver;
    wp_enqueue_script( 'gary-wedding-main', get_template_directory_uri() . '/js/main.js', array(), $js_ver, true );

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
