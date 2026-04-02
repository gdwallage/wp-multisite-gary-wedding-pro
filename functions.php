<?php
/**
 * File: functions.php
 * Theme: Gary Wallage Wedding Pro
 * Version: 1.98.0
 * Fixes: Fixed strict header and template-wide mobile overflow limits.
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
    }
endif;
add_action( 'after_setup_theme', 'gary_wedding_setup' );

/**
 * BOOKLY DATA HELPER
 */
function gary_get_bookly_service_data( $service_id ) {
    global $wpdb;
    if ( empty( $service_id ) ) return false;
    $table_name = $wpdb->prefix . 'bookly_services';
    if ( $wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name ) return false;
    
    // Select price, duration, and info for inclusions
    $service = $wpdb->get_row( $wpdb->prepare( "SELECT price, duration, info FROM $table_name WHERE id = %d", $service_id ) );
    
    if ( $service ) {
        $hours = floor($service->duration / 3600);
        $mins  = ($service->duration % 3600) / 60;
        $duration_label = ($hours > 0 ? $hours . 'h ' : '') . ($mins > 0 ? $mins . 'm' : '');
        
        return array( 
            'price' => (float) $service->price, 
            'duration' => $duration_label,
            'info' => (isset($service->info) ? $service->info : '')
        );
    }
    return false;
}

/**
 * COLOR HELPER
 */
if ( ! function_exists( 'gary_hex2rgb' ) ) {
    function gary_hex2rgb( $hex ) {
        $hex = str_replace("#", "", $hex);
        if(strlen($hex) == 3) {
            $r = hexdec(substr($hex,0,1).substr($hex,0,1));
            $g = hexdec(substr($hex,1,1).substr($hex,1,1));
            $b = hexdec(substr($hex,2,1).substr($hex,2,1));
        } else {
            $r = hexdec(substr($hex,0,2)); $g = hexdec(substr($hex,2,2)); $b = hexdec(substr($hex,4,2));
        }
        return "$r, $g, $b";
    }
}

/**
 * CUSTOMIZER REGISTRATION
 */
function gary_customize_register( $wp_customize ) {
    // Header
    $wp_customize->add_section( 'gary_header_options', array( 'title' => 'Header Background & Logo', 'priority' => 35 ) );
    $wp_customize->add_setting( 'logo_size_px', array( 'default' => '280', 'sanitize_callback' => 'absint', 'transport' => 'refresh' ) );
    $wp_customize->add_control( 'logo_size_px', array( 'label' => 'Logo Width (px)', 'section' => 'gary_header_options', 'type' => 'range', 'input_attrs' => array( 'min' => 50, 'max' => 600, 'step' => 5 ) ) );
    $wp_customize->add_setting( 'header_padding_val', array( 'default' => '80', 'sanitize_callback' => 'absint', 'transport' => 'refresh' ) );
    $wp_customize->add_control( 'header_padding_val', array( 'label' => 'Header Spacing (px)', 'section' => 'gary_header_options', 'type' => 'range', 'input_attrs' => array( 'min' => 10, 'max' => 200, 'step' => 5 ) ) );

    // Slider controls
    $wp_customize->add_section( 'gary_hero_slider_options', array( 'title' => 'Front Page Hero Slider', 'priority' => 39 ) );
    $wp_customize->add_setting( "hero_slide_0_box_color", array( 'default' => '#8C6D2D', 'sanitize_callback' => 'sanitize_hex_color' ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, "hero_slide_0_box_color", array( 'label' => 'Slide 0 Box Color', 'section' => 'gary_hero_slider_options' ) ) );
    $wp_customize->add_setting( "hero_slide_0_box_opacity", array( 'default' => '0.9', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ) );
    $wp_customize->add_control( "hero_slide_0_box_opacity", array( 'label' => 'Slide 0 Box Opacity', 'section' => 'gary_hero_slider_options', 'type' => 'range', 'input_attrs' => array( 'min' => 0, 'max' => 1, 'step' => 0.05 ) ) );

    $wp_customize->add_section( 'gary_footer_options', array( 'title' => 'Footer Content', 'priority' => 120 ) );
    $wp_customize->add_setting( 'footer_heading', array( 'default' => 'Preserving Legacies', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'footer_heading', array( 'label' => 'Footer Heading', 'section' => 'gary_footer_options', 'type' => 'text' ) );
    $wp_customize->add_setting( 'footer_text', array( 'default' => 'A visual historian...', 'sanitize_callback' => 'sanitize_textarea_field' ) );
    $wp_customize->add_control( 'footer_text', array( 'label' => 'Footer Description', 'section' => 'gary_footer_options', 'type' => 'textarea' ) );
}
add_action( 'customize_register', 'gary_customize_register' );

/**
 * DYNAMIC CSS
 */
add_action( 'wp_head', function() {
    $logo_size = get_theme_mod( 'logo_size_px', '280' ); 
    $padding = get_theme_mod( 'header_padding_val', '80' );
    $brand_font = get_theme_mod('brand_font_family', 'Blacksword');
    ?>
    <style type="text/css">
        .site-header { padding: <?php echo $padding; ?>px 0 !important; }
        .focal-center .custom-logo-link img { width: <?php echo $logo_size; ?>px !important; height: auto !important; margin: 0 auto; }
        
        /* UNIFIED BRAND TITLES */
        .entry-title, .archive-header h1, .about-title, .site-header .site-title-blacksword, .footer-branding h3 { 
            font-family: '<?php echo esc_attr($brand_font); ?>', 'Blacksword', serif !important; 
            color: var(--wedding-accent) !important;
            font-weight: normal !important;
            text-align: center !important;
        }
        .entry-title, .about-title, .archive-header h1 { margin-top: 30px !important; margin-bottom: 0px !important; }
        .site-header .site-title-blacksword { line-height: 1.8 !important; }
        .footer-branding h3 { color: var(--wedding-gold-light) !important; }
    </style>
    <?php
});

/**
 * REGISTER EDITORIAL BLOCK PATTERNS
 */
function gary_register_block_patterns() {
    if ( ! function_exists( 'register_block_pattern_category' ) ) return;

    register_block_pattern_category(
        'gary-editorial',
        array( 'label' => __( 'Gary Wallage Editorial', 'garywedding' ) )
    );

    // 1. Z-Pattern
    register_block_pattern(
        'garywedding/z-pattern',
        array(
            'title'       => __( 'The Z-Pattern Story', 'garywedding' ),
            'categories'  => array( 'gary-editorial' ),
            'content'     => '<!-- wp:group {"className":"gw-z-pattern","layout":{"type":"constrained"}} --><div class="wp-block-group gw-z-pattern"><!-- wp:image {"className":"gw-z-image gw-img-placeholder"} --><figure class="wp-block-image size-large gw-z-image gw-img-placeholder"><img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="/></figure><!-- /wp:image --><!-- wp:group {"className":"gw-z-text","layout":{"type":"constrained"}} --><div class="wp-block-group gw-z-text"><!-- wp:heading {"level":3,"textAlign":"center"} --><h3 class="wp-block-heading has-text-align-center">A Moment in Time</h3><!-- /wp:heading --><!-- wp:paragraph {"align":"center"} --><p class="has-text-align-center">Replace this text with your story. This layout naturally draws the eye back and forth across the beautiful fine-art imagery.</p><!-- /wp:paragraph --></div><!-- /wp:group --></div><!-- /wp:group -->',
        )
    );

    // 2. Cinematic Bleed
    register_block_pattern(
        'garywedding/cinematic-bleed',
        array(
            'title'       => __( 'The Cinematic Break', 'garywedding' ),
            'categories'  => array( 'gary-editorial' ),
            'content'     => '<!-- wp:group {"className":"gw-cinematic-bleed","layout":{"type":"constrained"}} --><div class="wp-block-group gw-cinematic-bleed"><!-- wp:image {"className":"gw-img-placeholder"} --><figure class="wp-block-image size-full gw-img-placeholder"><img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="/></figure><!-- /wp:image --></div><!-- /wp:group -->',
        )
    );

    // 3. Masonry Trio
    register_block_pattern(
        'garywedding/masonry-trio',
        array(
            'title'       => __( 'Asymmetric Masonry Trio', 'garywedding' ),
            'categories'  => array( 'gary-editorial' ),
            'content'     => '<!-- wp:group {"className":"gw-masonry-trio","layout":{"type":"constrained"}} --><div class="wp-block-group gw-masonry-trio"><!-- wp:image {"className":"gw-trio-main gw-img-placeholder"} --><figure class="wp-block-image size-large gw-trio-main gw-img-placeholder"><img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="/></figure><!-- /wp:image --><!-- wp:group {"className":"gw-trio-side","layout":{"type":"constrained"}} --><div class="wp-block-group gw-trio-side"><!-- wp:image {"className":"gw-img-placeholder"} --><figure class="wp-block-image size-large gw-img-placeholder"><img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="/></figure><!-- /wp:image --><!-- wp:image {"className":"gw-img-placeholder"} --><figure class="wp-block-image size-large gw-img-placeholder"><img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="/></figure><!-- /wp:image --></div><!-- /wp:group --></div><!-- /wp:group -->',
        )
    );

    // 4. Quote Capture
    register_block_pattern(
        'garywedding/quote-capture',
        array(
            'title'       => __( 'Quote & Capture', 'garywedding' ),
            'categories'  => array( 'gary-editorial' ),
            'content'     => '<!-- wp:group {"className":"gw-quote-capture","layout":{"type":"constrained"}} --><div class="wp-block-group gw-quote-capture"><!-- wp:quote {"textAlign":"center"} --><blockquote class="wp-block-quote has-text-align-center"><p>“Gary captured the atmosphere perfectly... it’s the emotions he caught that we love the most.”</p><cite>— Sarah &amp; Tom</cite></blockquote><!-- /wp:quote --></div><!-- /wp:group -->',
        )
    );
}
add_action( 'init', 'gary_register_block_patterns' );

function gary_send_performance_headers() {
    if ( is_admin() ) return;
    $template_uri = get_template_directory_uri();
    header( "Link: <{$template_uri}/style.css?ver=1.98.0>; rel=preload; as=style", false );
}
add_action( 'send_headers', 'gary_send_performance_headers' );

function gary_wedding_scripts() { wp_enqueue_style( 'gary-wedding-style', get_stylesheet_uri(), array(), '1.98.0' ); }
add_action( 'wp_enqueue_scripts', 'gary_wedding_scripts' );

function gary_wedding_footer_scripts() {
    if ( is_admin() ) return;
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.querySelector('.menu-toggle');
        const closeBtn = document.querySelector('.menu-close');
        const overlay = document.getElementById('primary-menu');
        if(!toggleBtn || !overlay) return;

        function openMenu() {
            overlay.classList.add('is-active');
            toggleBtn.setAttribute('aria-expanded', 'true');
            overlay.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
            if(closeBtn) closeBtn.focus();
        }

        function closeMenu() {
            overlay.classList.remove('is-active');
            toggleBtn.setAttribute('aria-expanded', 'false');
            overlay.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
            toggleBtn.focus();
        }

        toggleBtn.addEventListener('click', openMenu);
        if(closeBtn) closeBtn.addEventListener('click', closeMenu);

        // Escape key to close
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && overlay.classList.contains('is-active')) {
                closeMenu();
            }
        });
    });
    </script>
    <?php
}
add_action( 'wp_footer', 'gary_wedding_footer_scripts' );
