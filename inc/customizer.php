<?php
/**
 * Customizer: Registration of boutique editorial settings.
 */

function gary_customize_register( $wp_customize ) {
    // Header & Logo Options
    $wp_customize->add_section( 'gary_header_options', array( 'title' => 'Header Options' ) );
    $wp_customize->add_setting( 'logo_size_px', array( 'default' => '225', 'transport' => 'refresh' ) );
    $wp_customize->add_control( 'logo_size_px', array(
        'label'   => 'Logo Size (px)',
        'section' => 'gary_header_options',
        'type'    => 'number',
    ) );

    // Social Media Options
    $wp_customize->add_section( 'gary_social_options', array( 'title' => 'Social Media links' ) );
    $socials = array( 'facebook', 'instagram', 'youtube', 'twitter', 'linkedin' );
    foreach ( $socials as $s ) {
        $wp_customize->add_setting( "social_$s", array( 'sanitize_callback' => 'esc_url_raw' ) );
        $wp_customize->add_control( "social_$s", array(
            'label'   => ucfirst( $s ) . ' URL',
            'section' => 'gary_social_options',
        ) );
    }

    // NOTE: Hero Slider Page Selection removed as it is now automated via the Primary Menu.
}
add_action( 'customize_register', 'gary_customize_register' );
