<?php
/**
 * File: functions.php
 * Theme: Gary Wallage Wedding Pro
 * Version: 1.28.0
 * Fixes: Bumps version number to force browser to reload CSS cache.
 */

if ( ! function_exists( 'gary_wedding_setup' ) ) :
    function gary_wedding_setup() {
        add_theme_support( 'title-tag' );
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'align-wide' );
        add_theme_support( 'html5', array( 'gallery', 'caption', 'style', 'script' ) );
        add_theme_support( 'custom-logo', array(
            'height'      => 320,
            'width'       => 320,
            'flex-height' => true,
            'flex-width'  => true,
        ) );
        register_nav_menus( array( 'primary' => __( 'Primary Menu', 'garywedding' ) ) );
    }
endif;
add_action( 'after_setup_theme', 'gary_wedding_setup' );

// HELPER: Hex to RGB (Safety Wrapped)
if ( ! function_exists( 'gary_hex2rgb' ) ) {
    function gary_hex2rgb( $hex ) {
        $hex = str_replace("#", "", $hex);
        if(strlen($hex) == 3) {
            $r = hexdec(substr($hex,0,1).substr($hex,0,1));
            $g = hexdec(substr($hex,1,1).substr($hex,1,1));
            $b = hexdec(substr($hex,2,1).substr($hex,2,1));
        } else {
            $r = hexdec(substr($hex,0,2));
            $g = hexdec(substr($hex,2,2));
            $b = hexdec(substr($hex,4,2));
        }
        return "$r, $g, $b";
    }
}

function gary_force_webp_output( $formats ) {
    $formats['image/jpeg'] = 'image/webp';
    $formats['image/png']  = 'image/webp';
    return $formats;
}
add_filter( 'image_editor_output_format', 'gary_force_webp_output' );

function gary_send_performance_headers() {
    if ( is_admin() ) return;
    $template_uri = get_template_directory_uri();
    header( "Link: <{$template_uri}/style.css?ver=1.28.0>; rel=preload; as=style", false );
    header( "Link: <{$template_uri}/fonts/Blacksword.woff2>; rel=preload; as=font; crossorigin", false );
}
add_action( 'send_headers', 'gary_send_performance_headers' );

add_filter( 'get_custom_logo', function( $html ) {
    return str_replace( '<img ', '<img fetchpriority="high" ', $html );
});

function gary_remove_emoji_bloat() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
}
add_action( 'init', 'gary_remove_emoji_bloat' );

// SEO
function gary_add_seo_meta_tags() {
    if ( is_admin() ) return;
    global $post;
    $image_url = get_site_icon_url( 512 ); 
    if ( is_singular() || is_front_page() ) {
        if ( has_post_thumbnail( $post->ID ) ) {
            $image_url = get_the_post_thumbnail_url( $post->ID, 'full' );
        } elseif ( is_front_page() ) {
            $slide1 = get_theme_mod('hero_slide_1_img');
            if ( $slide1 ) $image_url = $slide1;
        }
        echo '<meta property="og:title" content="' . get_the_title() . '" />' . "\n";
        echo '<meta property="og:url" content="' . get_permalink() . '" />' . "\n";
        echo '<meta property="og:type" content="website" />' . "\n";
    }
    if ( $image_url ) {
        echo '<meta property="og:image" content="' . esc_url( $image_url ) . '" />' . "\n";
    }
}
add_action( 'wp_head', 'gary_add_seo_meta_tags' );

// SANITIZATION
function gary_sanitize_opacity( $input ) {
    return filter_var( $input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
}
function gary_sanitize_layout( $input ) {
    $valid = array( 'masonry', 'grid-square', 'grid-portrait', 'grid-landscape' );
    return in_array( $input, $valid ) ? $input : 'masonry';
}
function gary_sanitize_font_family( $input ) {
    $valid = array( 'Blacksword', 'Lato', 'Playfair Display', 'sans-serif', 'serif' );
    return in_array( $input, $valid ) ? $input : 'Blacksword';
}
function gary_sanitize_checkbox( $input ) {
    return ( ( isset( $input ) && true == $input ) ? true : false );
}

/**
 * CUSTOMIZER CONTROLS
 */
function gary_customize_register( $wp_customize ) {
    // 1. Header Options
    $wp_customize->add_section( 'gary_header_options', array( 'title' => 'Header Background & Spacing', 'priority' => 35 ) );
    $wp_customize->add_setting( 'header_bg_image', array( 'sanitize_callback' => 'esc_url_raw' ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'header_bg_image', array( 'label' => 'Upload Header Image', 'section' => 'gary_header_options' ) ) );
    $wp_customize->add_setting( 'header_overlay_opacity', array( 'default' => '0.85', 'sanitize_callback' => 'gary_sanitize_opacity', 'transport' => 'refresh' ) );
    $wp_customize->add_control( 'header_overlay_opacity', array( 'label' => 'Overlay Opacity', 'section' => 'gary_header_options', 'type' => 'range', 'input_attrs' => array( 'min' => 0, 'max' => 1, 'step' => 0.05 ) ) );
    $wp_customize->add_setting( 'header_padding_val', array( 'default' => '80', 'sanitize_callback' => 'absint', 'transport' => 'refresh' ) );
    $wp_customize->add_control( 'header_padding_val', array( 'label' => 'Header Spacing (px)', 'section' => 'gary_header_options', 'type' => 'range', 'input_attrs' => array( 'min' => 20, 'max' => 300, 'step' => 5 ) ) );

    // 2. Front Page Hero Slider
    $wp_customize->add_section( 'gary_hero_slider_options', array( 'title' => 'Front Page Hero Slider', 'priority' => 38, 'description' => 'Slide 1 uses Featured Image. Each slide has independent box styling.' ) );

    // Global Typography
    $wp_customize->add_setting( 'hero_title_font', array( 'default' => 'Blacksword', 'sanitize_callback' => 'gary_sanitize_font_family', 'transport' => 'refresh' ) );
    $wp_customize->add_control( 'hero_title_font', array( 'label' => 'Title Font Family', 'section' => 'gary_hero_slider_options', 'type' => 'select', 'choices' => array( 'Blacksword' => 'Blacksword', 'Lato' => 'Lato', 'Playfair Display' => 'Playfair Display' ) ) );
    
    $wp_customize->add_setting( 'hero_title_bold', array( 'default' => false, 'sanitize_callback' => 'gary_sanitize_checkbox', 'transport' => 'refresh' ) );
    $wp_customize->add_control( 'hero_title_bold', array( 'label' => 'Bold Title?', 'section' => 'gary_hero_slider_options', 'type' => 'checkbox' ) );

    $wp_customize->add_setting( 'hero_subtitle_font', array( 'default' => 'Lato', 'sanitize_callback' => 'gary_sanitize_font_family', 'transport' => 'refresh' ) );
    $wp_customize->add_control( 'hero_subtitle_font', array( 'label' => 'Subtitle Font Family', 'section' => 'gary_hero_slider_options', 'type' => 'select', 'choices' => array( 'Blacksword' => 'Blacksword', 'Lato' => 'Lato', 'Playfair Display' => 'Playfair Display' ) ) );

    $wp_customize->add_setting( 'hero_subtitle_bold', array( 'default' => false, 'sanitize_callback' => 'gary_sanitize_checkbox', 'transport' => 'refresh' ) );
    $wp_customize->add_control( 'hero_subtitle_bold', array( 'label' => 'Bold Subtitle?', 'section' => 'gary_hero_slider_options', 'type' => 'checkbox' ) );

    // Loop for 5 Slides
    for ($i = 1; $i <= 5; $i++) {
        $label_prefix = ($i === 1) ? "Slide 1 (Featured) " : "Slide $i ";
        
        if ($i > 1) {
            $wp_customize->add_setting( "hero_slide_{$i}_img", array( 'sanitize_callback' => 'esc_url_raw' ) );
            $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, "hero_slide_{$i}_img", array( 'label' => "Slide $i Image", 'section' => 'gary_hero_slider_options' ) ) );
        }
        
        $wp_customize->add_setting( "hero_slide_{$i}_title", array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_control( "hero_slide_{$i}_title", array( 'label' => $label_prefix . "Title", 'section' => 'gary_hero_slider_options', 'type' => 'text' ) );
        
        $wp_customize->add_setting( "hero_slide_{$i}_subtitle", array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_control( "hero_slide_{$i}_subtitle", array( 'label' => $label_prefix . "Subtitle", 'section' => 'gary_hero_slider_options', 'type' => 'text' ) );
        
        $wp_customize->add_setting( "hero_slide_{$i}_btn", array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_control( "hero_slide_{$i}_btn", array( 'label' => $label_prefix . "Button Text", 'section' => 'gary_hero_slider_options', 'type' => 'text' ) );
        
        $wp_customize->add_setting( "hero_slide_{$i}_link", array( 'default' => '', 'sanitize_callback' => 'esc_url_raw' ) );
        $wp_customize->add_control( "hero_slide_{$i}_link", array( 'label' => $label_prefix . "Link", 'section' => 'gary_hero_slider_options', 'type' => 'text' ) );

        // TITLE BOX COLORS
        $wp_customize->add_setting( "hero_slide_{$i}_text_color", array( 'default' => '#ffffff', 'sanitize_callback' => 'sanitize_hex_color' ) );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, "hero_slide_{$i}_text_color", array( 'label' => $label_prefix . "Title Text Color", 'section' => 'gary_hero_slider_options' ) ) );

        $wp_customize->add_setting( "hero_slide_{$i}_box_color", array( 'default' => '#8C6D2D', 'sanitize_callback' => 'sanitize_hex_color' ) );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, "hero_slide_{$i}_box_color", array( 'label' => $label_prefix . "Title Box Background", 'section' => 'gary_hero_slider_options' ) ) );

        $wp_customize->add_setting( "hero_slide_{$i}_box_opacity", array( 'default' => '0.9', 'sanitize_callback' => 'gary_sanitize_opacity', 'transport' => 'refresh' ) );
        $wp_customize->add_control( "hero_slide_{$i}_box_opacity", array( 'label' => $label_prefix . "Title Box Opacity", 'section' => 'gary_hero_slider_options', 'type' => 'range', 'input_attrs' => array( 'min' => 0, 'max' => 1, 'step' => 0.05 ) ) );

        // BUTTON COLORS
        $wp_customize->add_setting( "hero_slide_{$i}_btn_text_color", array( 'default' => '#ffffff', 'sanitize_callback' => 'sanitize_hex_color' ) );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, "hero_slide_{$i}_btn_text_color", array( 'label' => $label_prefix . "Button Text Color", 'section' => 'gary_hero_slider_options' ) ) );

        $wp_customize->add_setting( "hero_slide_{$i}_btn_bg_color", array( 'default' => '#8C6D2D', 'sanitize_callback' => 'sanitize_hex_color' ) );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, "hero_slide_{$i}_btn_bg_color", array( 'label' => $label_prefix . "Button Background", 'section' => 'gary_hero_slider_options' ) ) );
        
        $wp_customize->add_setting( "hero_slide_{$i}_btn_bg_opacity", array( 'default' => '0.9', 'sanitize_callback' => 'gary_sanitize_opacity', 'transport' => 'refresh' ) );
        $wp_customize->add_control( "hero_slide_{$i}_btn_bg_opacity", array( 'label' => $label_prefix . "Button Opacity", 'section' => 'gary_hero_slider_options', 'type' => 'range', 'input_attrs' => array( 'min' => 0, 'max' => 1, 'step' => 0.05 ) ) );
    }

    // 3. Gallery Layouts
    $wp_customize->add_section( 'gary_gallery_options', array( 'title' => 'Gallery Layouts', 'priority' => 40 ) );
    $wp_customize->add_setting( 'category_layout_type', array( 'default' => 'masonry', 'transport' => 'refresh', 'sanitize_callback' => 'gary_sanitize_layout' ) );
    $wp_customize->add_control( 'category_layout_type', array( 'label' => 'Category Page Layout', 'section' => 'gary_gallery_options', 'type' => 'select', 'choices' => array( 'masonry' => 'Masonry', 'grid-square' => 'Square Grid', 'grid-portrait' => 'Portrait Grid', 'grid-landscape'=> 'Landscape Grid' ) ) );
    $wp_customize->add_setting( 'tag_layout_type', array( 'default' => 'masonry', 'transport' => 'refresh', 'sanitize_callback' => 'gary_sanitize_layout' ) );
    $wp_customize->add_control( 'tag_layout_type', array( 'label' => 'Tag Page Layout', 'section' => 'gary_gallery_options', 'type' => 'select', 'choices' => array( 'masonry' => 'Masonry', 'grid-square' => 'Square Grid', 'grid-portrait' => 'Portrait Grid', 'grid-landscape'=> 'Landscape Grid' ) ) );

    // 4. Footer Content
    $wp_customize->add_section( 'gary_footer_options', array( 'title' => 'Footer Content & Sizing', 'priority' => 120 ) );
    $wp_customize->add_setting( 'footer_heading', array( 'default' => 'Preserving Legacies', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ) );
    $wp_customize->add_control( 'footer_heading', array( 'label' => 'Footer Heading', 'section' => 'gary_footer_options', 'type' => 'text' ) );
    $wp_customize->add_setting( 'footer_text', array( 'default' => 'A visual historian...', 'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'refresh' ) );
    $wp_customize->add_control( 'footer_text', array( 'label' => 'Footer Description', 'section' => 'gary_footer_options', 'type' => 'textarea' ) );
    
    // CONTACT
    $wp_customize->add_setting( 'footer_contact', array( 'default' => '', 'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'refresh' ) );
    $wp_customize->add_control( 'footer_contact', array( 'label' => 'Address / Location', 'section' => 'gary_footer_options', 'type' => 'textarea' ) );
    $wp_customize->add_setting( 'footer_email', array( 'default' => '', 'sanitize_callback' => 'sanitize_email', 'transport' => 'refresh' ) );
    $wp_customize->add_control( 'footer_email', array( 'label' => 'Email Address', 'section' => 'gary_footer_options', 'type' => 'email' ) );
    $wp_customize->add_setting( 'footer_phone', array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ) );
    $wp_customize->add_control( 'footer_phone', array( 'label' => 'Phone Number', 'section' => 'gary_footer_options', 'type' => 'text' ) );
    
    $wp_customize->add_setting( 'footer_copyright', array( 'default' => 'Gary Wallage Digital Ecosystem', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ) );
    $wp_customize->add_control( 'footer_copyright', array( 'label' => 'Copyright Text', 'section' => 'gary_footer_options', 'type' => 'text' ) );
    
    // LEGAL
    $wp_customize->add_setting( 'legal_page_privacy', array( 'default' => 0, 'sanitize_callback' => 'absint' ) );
    $wp_customize->add_control( 'legal_page_privacy', array( 'label' => 'Privacy Policy Page', 'section' => 'gary_footer_options', 'type' => 'dropdown-pages' ) );
    $wp_customize->add_setting( 'legal_page_terms', array( 'default' => 0, 'sanitize_callback' => 'absint' ) );
    $wp_customize->add_control( 'legal_page_terms', array( 'label' => 'Terms & Conditions Page', 'section' => 'gary_footer_options', 'type' => 'dropdown-pages' ) );
    $wp_customize->add_setting( 'legal_page_cookies', array( 'default' => 0, 'sanitize_callback' => 'absint' ) );
    $wp_customize->add_control( 'legal_page_cookies', array( 'label' => 'Cookie Policy Page', 'section' => 'gary_footer_options', 'type' => 'dropdown-pages' ) );
    
    // SIZING
    $wp_customize->add_setting( 'footer_padding', array( 'default' => '100', 'sanitize_callback' => 'absint', 'transport' => 'refresh' ) );
    $wp_customize->add_control( 'footer_padding', array( 'label' => 'Footer Vertical Padding (px)', 'section' => 'gary_footer_options', 'type' => 'number', 'input_attrs' => array( 'min' => 20, 'max' => 200, 'step' => 10 ) ) );
    $wp_customize->add_setting( 'footer_heading_size', array( 'default' => '1.8', 'sanitize_callback' => 'gary_sanitize_opacity', 'transport' => 'refresh' ) );
    $wp_customize->add_control( 'footer_heading_size', array( 'label' => 'Heading Font Size (rem)', 'section' => 'gary_footer_options', 'type' => 'number', 'input_attrs' => array( 'min' => 1, 'max' => 4, 'step' => 0.1 ) ) );
    $wp_customize->add_setting( 'footer_text_size', array( 'default' => '0.95', 'sanitize_callback' => 'gary_sanitize_opacity', 'transport' => 'refresh' ) );
    $wp_customize->add_control( 'footer_text_size', array( 'label' => 'Text Font Size (rem)', 'section' => 'gary_footer_options', 'type' => 'number', 'input_attrs' => array( 'min' => 0.5, 'max' => 2, 'step' => 0.05 ) ) );
}
add_action( 'customize_register', 'gary_customize_register' );

// DYNAMIC CSS
add_action( 'wp_head', function() {
    $bg_img = get_theme_mod( 'header_bg_image' );
    $opacity = get_theme_mod( 'header_overlay_opacity', '0.85' );
    $padding = get_theme_mod( 'header_padding_val', '80' );
    
    $title_font = get_theme_mod('hero_title_font', 'Blacksword');
    $title_bold = get_theme_mod('hero_title_bold') ? 'bold' : 'normal';
    $sub_font   = get_theme_mod('hero_subtitle_font', 'Lato');
    $sub_bold   = get_theme_mod('hero_subtitle_bold') ? 'bold' : 'normal';

    $f_padding = get_theme_mod( 'footer_padding', '100' );
    $f_h_size  = get_theme_mod( 'footer_heading_size', '1.8' );
    $f_t_size  = get_theme_mod( 'footer_text_size', '0.95' );
    ?>
    <style type="text/css">
        .site-header {
            <?php if($bg_img): ?>
                background-image: linear-gradient(rgba(255,255,255, <?php echo $opacity; ?>), rgba(255,255,255, <?php echo $opacity; ?>)), url('<?php echo esc_url($bg_img); ?>');
            <?php else: ?>
                background-color: transparent;
            <?php endif; ?>
            padding: <?php echo $padding; ?>px 0 !important;
        }
        
        .hero-title {
            font-family: '<?php echo esc_attr($title_font); ?>', sans-serif !important;
            font-weight: <?php echo esc_attr($title_bold); ?> !important;
        }
        .hero-subtitle {
            font-family: '<?php echo esc_attr($sub_font); ?>', sans-serif !important;
            font-weight: <?php echo esc_attr($sub_bold); ?> !important;
        }

        .site-footer { padding: <?php echo $f_padding; ?>px 20px !important; }
        .footer-grid { display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; max-width: 1400px; margin: 0 auto; gap: 40px; }
        .footer-col-left { flex: 1; text-align: left; min-width: 250px; align-self: flex-end; }
        .footer-col-center { flex: 2; text-align: center; min-width: 300px; align-self: flex-start; }
        .footer-col-right { flex: 1; text-align: right; min-width: 250px; align-self: flex-end; }
        .footer-branding h3 { font-size: <?php echo $f_h_size; ?>rem !important; color: var(--wedding-accent); margin-top: 0; }
        .footer-branding p { font-size: <?php echo $f_t_size; ?>rem !important; opacity: 0.8; max-width: 600px; margin: 15px auto 0; }
        .footer-legal-list { list-style: none; padding: 0; margin: 0; }
        .footer-legal-list li { margin-bottom: 10px; }
        .footer-legal-list li a { color: #fff; text-decoration: none; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; opacity: 0.6; transition: opacity 0.3s ease; }
        .footer-legal-list li a:hover { opacity: 1; }
        .footer-contact { font-size: 0.9rem; line-height: 1.6; opacity: 0.8; }
        .footer-contact a { color: #fff; text-decoration: none; transition: color 0.3s; }
        .footer-contact a:hover { color: var(--wedding-accent); }
        .contact-row { margin-bottom: 5px; display: block; }
        .whatsapp-link { color: #25D366 !important; font-weight: 700; margin-left: 5px; }
        @media (max-width: 900px) {
            .footer-grid { flex-direction: column; align-items: center; text-align: center; }
            .footer-col-left, .footer-col-center, .footer-col-right { text-align: center; width: 100%; flex: auto; align-self: center; }
            .footer-legal-list { margin-bottom: 30px; }
            .footer-col-center { order: -1; margin-bottom: 30px; }
        }
    </style>
    <?php
});

function gary_register_visual_legacies() {
    register_post_type( 'visual_legacies', array(
        'labels' => array( 'name' => 'Visual Legacies', 'singular_name' => 'Legacy Story' ),
        'public' => true, 'has_archive' => true, 'show_in_rest' => true,
        'menu_icon' => 'dashicons-camera-alt', 'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'rewrite' => array( 'slug' => 'stories' ),
    ) );
}
add_action( 'init', 'gary_register_visual_legacies' );

// Enqueue with version 1.28.0
function gary_wedding_scripts() {
    wp_enqueue_style( 'gary-wedding-style', get_stylesheet_uri(), array(), '1.28.0' );
    wp_enqueue_style( 'gary-google-fonts', 'https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&family=Playfair+Display:ital@0;1&display=swap', array(), null );
}
add_action( 'wp_enqueue_scripts', 'gary_wedding_scripts' );
