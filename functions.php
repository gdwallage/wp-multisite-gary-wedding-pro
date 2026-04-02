<?php
/**
 * File: functions.php
 * Theme: Gary Wallage Wedding Pro
 * Version: 1.120.0
 * Fixes: Infinite Tag-Driven Service Grid with Tag Priority logic.
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
    
    // Select price, duration, title, and info for inclusions + tags for linking
    $service = $wpdb->get_row( $wpdb->prepare( "SELECT title, price, duration, info FROM $table_name WHERE id = %d", $service_id ) );
    
    // Check for tags column (may vary by version)
    $tags = "";
    $cols = $wpdb->get_col("DESCRIBE $table_name", 0);
    if (in_array('tags', $cols)) {
        $tags = $wpdb->get_var( $wpdb->prepare( "SELECT tags FROM $table_name WHERE id = %d", $service_id ) );
    }

    if ( $service ) {
        $hours = floor($service->duration / 3600);
        $mins  = ($service->duration % 3600) / 60;
        $duration_label = ($hours > 0 ? $hours . 'h ' : '') . ($mins > 0 ? $mins . 'm' : '');
        
        return array( 
            'title'    => $service->title,
            'price'    => (float) $service->price, 
            'duration' => $duration_label,
            'info'     => (isset($service->info) ? $service->info : ''),
            'tags'     => $tags
        );
    }
    return false;
}

/**
 * HELPER: Find the WP Page linked to a Bookly Service Name
 */
function gary_find_page_by_bookly_title( $title ) {
    if ( empty($title) ) return false;
    global $wpdb;
    
    // 1. Exact Title Match (Highest Priority)
    $page = get_page_by_title( $title, OBJECT, 'page' );
    if ( $page ) return $page->ID;

    // 2. Reverse Metadata lookup (Match by Bookly ID to catch renamed pages)
    // First find the Bookly ID for this name
    $table_name = $wpdb->prefix . 'bookly_services';
    $bookly_id = $wpdb->get_var( $wpdb->prepare( "SELECT id FROM $table_name WHERE title = %s LIMIT 1", $title ) );
    
    if ( $bookly_id ) {
        $found = get_pages(array(
            'meta_key'   => '_gary_bookly_id',
            'meta_value' => $bookly_id,
            'number'     => 1
        ));
        if ( !empty($found) ) return $found[0]->ID;
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
 * Core Native Gutenberg Block Patterns Registration
 */
require_once get_template_directory() . '/inc/editorial-patterns.php';

function gary_send_performance_headers() {
    if ( is_admin() ) return;
    $template_uri = get_template_directory_uri();
    header( "Link: <{$template_uri}/style.css?ver=1.120.0>; rel=preload; as=style", false );
}
add_action( 'send_headers', 'gary_send_performance_headers' );

function gary_wedding_scripts() { wp_enqueue_style( 'gary-wedding-style', get_stylesheet_uri(), array(), '1.120.0' ); }
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

/**
 * EDITOR BOOKLY LINKER UI
 */
function gary_add_bookly_meta_box() {
    add_meta_box(
        'gary_bookly_integration_box',
        __( 'Bookly Service Link', 'garywedding' ),
        'gary_bookly_meta_box_html',
        'page',
        'side',
        'high'
    );
}
add_action( 'add_meta_boxes', 'gary_add_bookly_meta_box' );

function gary_bookly_meta_box_html( $post ) {
    global $wpdb;
    $value = get_post_meta( $post->ID, '_gary_bookly_id', true );
    wp_nonce_field( 'gary_bookly_meta_box_nonce', 'gary_bookly_meta_box_nonce' );

    $table_name = $wpdb->prefix . 'bookly_services';
    $services_exist = ( $wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name );
    
    echo '<label for="gary_bookly_service_dropdown"><strong>' . __( 'Select Bookly Service to Link:', 'garywedding' ) . '</strong></label><br /><br />';
    echo '<select name="gary_bookly_id" id="gary_bookly_service_dropdown" style="width:100%; border-radius: 3px; padding: 5px;">';
    echo '<option value="">' . __( '-- No Service Linked --', 'garywedding' ) . '</option>';
    
    if ( $services_exist ) {
        $services = $wpdb->get_results( "SELECT id, title, price FROM $table_name ORDER BY title ASC" );
        foreach ( $services as $service ) {
            $selected = selected( $value, $service->id, false );
            echo '<option value="' . esc_attr($service->id) . '" ' . $selected . '>' . esc_html($service->title) . ' (&pound;' . esc_html( number_format($service->price, 0) ) . ')</option>';
        }
    }
    
    echo '</select>';
    echo '<p style="font-size: 12px; color: #666; margin-top: 10px;">Select the Bookly service to magically pull Live Pricing and standard durations directly into the Page.</p>';
    
    if ( ! $services_exist ) {
        echo '<p style="color:red;">' . __( 'Bookly plugin data not found. Please install Bookly.', 'garywedding' ) . '</p>';
    }
}

function gary_save_bookly_meta_box_data( $post_id ) {
    if ( ! isset( $_POST['gary_bookly_meta_box_nonce'] ) ) return;
    if ( ! wp_verify_nonce( $_POST['gary_bookly_meta_box_nonce'], 'gary_bookly_meta_box_nonce' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_page', $post_id ) ) return;
    
    if ( ! isset( $_POST['gary_bookly_id'] ) ) return;
    $my_data = sanitize_text_field( $_POST['gary_bookly_id'] );
    update_post_meta( $post_id, '_gary_bookly_id', $my_data );
}
add_action( 'save_post', 'gary_save_bookly_meta_box_data' );

/**
 * ADVANCED EDITORIAL LAYOUT DATA
 */
function gary_add_editorial_meta_box() {
    add_meta_box(
        'gary_editorial_layout_box',
        __( 'Editorial Layout Data (Mockup Style)', 'garywedding' ),
        'gary_editorial_meta_box_html',
        'page',
        'side',
        'high'
    );
}
add_action( 'add_meta_boxes', 'gary_add_editorial_meta_box' );

function gary_editorial_meta_box_html( $post ) {
    wp_nonce_field( 'gary_editorial_meta_box_nonce', 'gary_editorial_meta_box_nonce' );

    $subtitle = get_post_meta( $post->ID, '_gary_service_subtitle', true );
    $highlights = get_post_meta( $post->ID, '_gary_service_highlights', true );
    $bg_img = get_post_meta( $post->ID, '_gary_service_bg_img', true );
    
    // Sub-services 1-4
    $sub_services = array();
    for($i=1; $i<=4; $i++) {
        $sub_services[$i] = get_post_meta( $post->ID, '_gary_sub_service_' . $i, true );
    }

    echo '<p><strong>' . __( 'Investment Subtitle:', 'garywedding' ) . '</strong><br /><input type="text" name="gary_service_subtitle" value="' . esc_attr($subtitle) . '" style="width:100%;" placeholder="e.g. Bespoke Guidance" /></p>';
    
    echo '<p><strong>' . __( 'Personalized Experience Highlights:', 'garywedding' ) . '</strong><br /><textarea name="gary_service_highlights" style="width:100%; height:80px;" placeholder="One item per line (Icons are automatic)">' . esc_textarea($highlights) . '</textarea></p>';

    echo '<hr />';
    echo '<p><strong>' . __( 'Link 4 Sub-Service Pages (The 2x2 Grid):', 'garywedding' ) . '</strong></p>';
    
    // Get all pages using the Service template or as children of a Service page
    $pages = get_pages(array('meta_key' => '_wp_page_template', 'meta_value' => 'page-service-detail.php'));
    if (empty($pages)) { $pages = get_pages(); } // Fallback to all pages

    for($i=1; $i<=4; $i++) {
        echo '<div style="margin-bottom:10px;"><label>Slot ' . $i . ':</label><br />';
        echo '<select name="gary_sub_service_' . $i . '" style="width:100%;">';
        echo '<option value="">' . __( '-- No Page Linked --', 'garywedding' ) . '</option>';
        foreach ( $pages as $p ) {
            if ($p->ID == $post->ID) continue; // Don't link to self
            $selected = selected( $sub_services[$i], $p->ID, false );
            echo '<option value="' . $p->ID . '" ' . $selected . '>' . esc_html($p->post_title) . '</option>';
        }
        echo '</select></div>';
    }

    echo '<hr />';
    echo '<p><strong>' . __( 'Background Illustration URL:', 'garywedding' ) . '</strong><br /><input type="text" name="gary_service_bg_img" value="' . esc_attr($bg_img) . '" style="width:100%;" placeholder="Link to a faint .png illustration" /></p>';
}

function gary_save_editorial_meta_box_data( $post_id ) {
    if ( ! isset( $_POST['gary_editorial_meta_box_nonce'] ) ) return;
    if ( ! wp_verify_nonce( $_POST['gary_editorial_meta_box_nonce'], 'gary_editorial_meta_box_nonce' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_page', $post_id ) ) return;
    
    // Save fields
    $fields = array(
        'gary_service_subtitle'   => '_gary_service_subtitle',
        'gary_service_highlights' => '_gary_service_highlights',
        'gary_service_bg_img'      => '_gary_service_bg_img'
    );
    foreach ($fields as $key => $meta) {
        if ( isset( $_POST[$key] ) ) {
            update_post_meta( $post_id, $meta, sanitize_text_field( $_POST[$key] ) );
        }
    }
    
    // Save sub-services
    for($i=1; $i<=4; $i++) {
        if ( isset( $_POST['gary_sub_service_' . $i] ) ) {
            update_post_meta( $post_id, '_gary_sub_service_' . $i, sanitize_text_field( $_POST['gary_sub_service_' . $i] ) );
        }
    }
}
add_action( 'save_post', 'gary_save_editorial_meta_box_data' );
