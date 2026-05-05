<?php
/**
 * Enqueue: Scripts and styles management.
 */

function gary_wedding_scripts() {
    $ver = GARY_THEME_VERSION;
    
    // Core CSS
    wp_enqueue_style( 'gary-wedding-v3-editorial', get_template_directory_uri() . '/style.css', array(), $ver );
    
    // Core JS
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'gary-wedding-main', get_template_directory_uri() . '/js/main.js', array('jquery'), $ver, true );

    // Page-Specific
    if ( is_front_page() ) {
        wp_enqueue_script( 'gw-hero-slider', get_template_directory_uri() . '/js/hero-slider.js', array('jquery'), $ver, true );
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
