<?php
/**
 * File: functions.php
 * Theme: Gary Wallage Wedding Pro
 * Version: 3.9.7
 * Fixes: CACHE BUSTER + TOTAL RESTORATION.
 */

if ( ! function_exists( 'gary_wedding_setup' ) ) :
    function gary_wedding_setup() {
        add_theme_support( 'title-tag' );
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'align-wide' );
        add_theme_support( 'html5', array( 'gallery', 'caption', 'style', 'script' ) );
        add_theme_support( 'custom-logo', array( 'height' => 400, 'width' => 400, 'flex-height' => true, 'flex-width' => true ) );
        register_nav_menus( array( 'primary' => __( 'Primary Menu', 'garywedding' ) ) );
        add_post_type_support( 'page', 'excerpt' );
        add_theme_support( 'editor-styles' );
        add_editor_style( 'style.css' );
    }
endif;
add_action( 'after_setup_theme', 'gary_wedding_setup' );

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
    // Header & Logo
    $wp_customize->add_section( 'gary_header_options', array('title' => 'Header Options') );
    $wp_customize->add_setting( 'logo_size_px', array('default' => '125', 'transport' => 'refresh') );
    $wp_customize->add_control( 'logo_size_px', array('label' => 'Logo Size (px)', 'section' => 'gary_header_options', 'type' => 'number') );
    
    // Hero Slider — Page Picker
    $wp_customize->add_section( 'gw_hero_slider', array(
        'title'       => 'Hero Slider — Page Selection',
        'priority'    => 28,
        'description' => 'Choose which pages appear in the front-page hero carousel. Select 3, 5, 7, or 9 slides.',
    ) );

    // Slide count
    $wp_customize->add_setting( 'hero_slider_count', array( 'default' => '3', 'transport' => 'refresh', 'sanitize_callback' => 'absint' ) );
    $wp_customize->add_control( 'hero_slider_count', array(
        'label'   => 'Number of slides',
        'section' => 'gw_hero_slider',
        'type'    => 'select',
        'choices' => array( '3' => '3 slides', '5' => '5 slides', '7' => '7 slides', '9' => '9 slides' ),
    ) );

    // Build a flat list of all published pages for the dropdowns
    $all_pages = get_posts( array( 'post_type' => 'page', 'post_status' => 'publish', 'numberposts' => -1, 'orderby' => 'title', 'order' => 'ASC' ) );
    $page_choices = array( '' => '— Select a page —' );
    foreach ( $all_pages as $p ) {
        $page_choices[ $p->ID ] = $p->post_title;
    }

    // One dropdown per possible slot (up to 9)
    for ( $i = 1; $i <= 9; $i++ ) {
        $wp_customize->add_setting( "hero_slide_page_{$i}", array( 'default' => '', 'transport' => 'refresh', 'sanitize_callback' => 'absint' ) );
        $wp_customize->add_control( "hero_slide_page_{$i}", array(
            'label'   => "Slide {$i} — Page",
            'section' => 'gw_hero_slider',
            'type'    => 'select',
            'choices' => $page_choices,
        ) );
    }

    // Social
    $wp_customize->add_section( 'gary_social_options', array('title' => 'Social Media links') );
    $socials = array('facebook','instagram','youtube','twitter','linkedin');
    foreach($socials as $s) {
        $wp_customize->add_setting("social_$s", array('sanitize_callback' => 'esc_url_raw'));
        $wp_customize->add_control("social_$s", array('label' => ucfirst($s).' URL', 'section' => 'gary_social_options'));
    }
}
add_action( 'customize_register', 'gary_customize_register' );

/**
 * DYNAMIC STYLING
 */
add_action( 'wp_head', function() {
    $logo_size = get_theme_mod( 'logo_size_px', '125' );
    ?>
    <style type="text/css" id="gw-emergency-branding">
        @font-face {
            font-family: 'Blacksword';
            src: url('<?php echo get_template_directory_uri(); ?>/fonts/Blacksword.woff2') format('woff2');
            font-weight: normal; font-style: normal; font-display: swap;
        }
        
        /* 1. FORCE BRAND FONT & GOLD */
        /* 1. H1 - Gold Blacksword */
        h1, 
        .site-title-blacksword, 
        .entry-title, 
        .hero-title, 
        .footer-branding h3, 
        .about-sig span {
            font-family: 'Blacksword', cursive !important;
            color: var(--brand-gold-light) !important;
            font-weight: normal !important;
            text-transform: none !important;
            letter-spacing: normal !important;
        }

        /* 2. H2 - Gold Lato AllCaps */
        h2 {
            font-family: 'Lato', sans-serif !important;
            color: var(--brand-gold-light) !important;
            text-transform: uppercase !important;
            letter-spacing: 3px !important;
            font-weight: 700 !important;
        }

        /* 3. H3+ - Boutique Black */
        h3, h4, h5, h6 {
            color: var(--brand-black) !important;
            font-family: 'Lato', sans-serif !important;
            text-transform: uppercase !important;
            letter-spacing: 2px !important;
        }

        /* 2. FORCE LAYOUT BOXES (Overrides) */
        .gw-z-pattern, .about-grid { display: flex !important; width: 80% !important; margin: 60px auto !important; max-width: 1500px !important; }
        .gw-z-image img { border: 15px solid #fff !important; box-shadow: 0 20px 50px rgba(0,0,0,0.15) !important; }
        .gw-z-content { border: 2px solid #C5A059 !important; padding: 60px !important; background: #fff !important; }

        .focal-center .custom-logo-link img { width: <?php echo $logo_size; ?>px !important; }
    </style>
    <?php
});

/**
 * CORE MODULES
 */
require_once get_template_directory() . '/inc/shortcodes.php';
require_once get_template_directory() . '/inc/blocks/service-blocks.php';

/**
 * PERFORMANCE & SCRIPTS
 */
function gary_send_performance_headers() {
    if ( is_admin() ) return;
    $template_uri = get_template_directory_uri();
    header( "Link: <{$template_uri}/style.css?ver=3.9.7>; rel=preload; as=style", false );
}
add_action( 'send_headers', 'gary_send_performance_headers' );

function gary_wedding_scripts() { wp_enqueue_style( 'gary-wedding-style', get_stylesheet_uri(), array(), '3.9.7' ); }
add_action( 'wp_enqueue_scripts', 'gary_wedding_scripts' );

function gary_wedding_footer_scripts() {
    if ( is_admin() ) return; ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.querySelector('.menu-toggle');
        const overlay = document.getElementById('primary-menu');
        if(!toggleBtn || !overlay) return;
        toggleBtn.addEventListener('click', () => {
            const isOpened = overlay.getAttribute('aria-hidden') === 'false';
            overlay.setAttribute('aria-hidden', isOpened ? 'true' : 'false');
            document.body.style.overflow = isOpened ? '' : 'hidden';
        });
        document.querySelector('.menu-close')?.addEventListener('click', () => {
            overlay.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        });
    });
    </script>
    <?php
}
add_action( 'wp_footer', 'gary_wedding_footer_scripts' );

/**
 * DATA HELPERS (High-Fidelity)
 */
function gary_get_bookly_service_data( $service_id ) {
    if ( empty($service_id) ) return false;
    global $wpdb;
    $table = $wpdb->prefix . 'bookly_services';
    if ( $wpdb->get_var("SHOW TABLES LIKE '$table'") != $table ) return false;
    return $wpdb->get_row( $wpdb->prepare( "SELECT title, price, duration, info FROM $table WHERE id = %d", $service_id ), ARRAY_A );
}

function gary_find_page_by_bookly_title( $title ) {
    if ( empty($title) ) return false;
    global $wpdb;
    return $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_gary_service_title_match' AND meta_value = %s LIMIT 1", $title ) );
}

/**
 * HELPER: Format seconds into human readable duration
 */
function gary_format_duration( $seconds ) {
    if ( empty($seconds) || !is_numeric($seconds) ) return '';
    $hours = round( (int)$seconds / 3600, 1 );
    if ($hours <= 0) return '';
    return $hours . ' Hours';
}

/**
 * META BOXES
 */
function gary_add_meta_boxes() {
    add_meta_box( 'gary_bookly_id_box', 'Bookly Link', 'gary_bookly_mb_html', 'page', 'side' );
    add_meta_box( 'gary_editorial_mb', 'Editorial Options', 'gary_editorial_mb_html', 'page', 'side' );
}
add_action( 'add_meta_boxes', 'gary_add_meta_boxes' );

function gary_bookly_mb_html( $post ) {
    global $wpdb;
    $val = get_post_meta( $post->ID, '_gary_bookly_id', true );
    $table = $wpdb->prefix . 'bookly_services';
    echo '<select name="gary_bookly_id" style="width:100%;">';
    echo '<option value="">-- No Link --</option>';
    if ( $wpdb->get_var("SHOW TABLES LIKE '$table'") == $table ) {
        $svcs = $wpdb->get_results( "SELECT id, title FROM $table ORDER BY title ASC" );
        foreach ( $svcs as $s ) { echo '<option value="'.$s->id.'" '.selected($val, $s->id, false).'>'.$s->title.'</option>'; }
    }
    echo '</select>';
}

function gary_editorial_mb_html( $post ) {
    $sub = get_post_meta( $post->ID, '_gary_service_subtitle', true );
    $high = get_post_meta( $post->ID, '_gary_service_highlights', true );
    
    echo '<div style="margin-bottom:20px; border-bottom:1px solid #eee; padding-bottom:15px;">';
    echo '<p><strong>Subtitle:</strong><br /><input type="text" name="gary_service_subtitle" value="'.esc_attr($sub).'" style="width:100%;" /></p>';
    echo '<p><strong>Highlights (One per line):</strong><br /><textarea name="gary_service_highlights" style="width:100%; height:80px;">'.esc_textarea($high).'</textarea></p>';
    echo '</div>';

    $retail_override = get_post_meta( $post->ID, '_gary_retail_value_override', true );

    echo '<p><strong>Bundle Marketing Overrides:</strong></p>';
    echo '<div style="margin-bottom:15px;">';
    echo '<label style="font-size:11px; color:#666;">Manual Retail Value (£): (e.g. 1950.00)</label><br />';
    echo '<input type="text" name="gary_retail_value_override" value="'.esc_attr($retail_override).'" style="width:100%;" placeholder="Overrides calculated total if set" />';
    echo '</div>';

    $booking_sc = get_post_meta( $post->ID, '_gary_booking_shortcode', true );
    $bookly_forms = gary_get_bookly_forms();
    
    echo '<div style="margin-bottom:15px; border-top:1px solid #eee; padding:15px; background:#f9f9f9; border-radius:4px;">';
    echo '<p style="margin-top:0;"><strong>Custom Booking Code / Shortcode:</strong></p>';
    
    if ( ! empty( $bookly_forms ) ) {
        echo '<div style="font-size:11px; margin-bottom:10px; background:#fff; padding:10px; border:1px solid #ddd;">';
        echo '<p style="margin-top:0; font-weight:700;">Reference: Your Bookly Appearances</p>';
        echo '<ul style="margin:0; padding-left:15px;">';
        foreach ( $bookly_forms as $form ) {
            echo '<li>ID: <strong>' . $form['id'] . '</strong> &mdash; ' . esc_html( $form['name'] ) . '</li>';
        }
        echo '</ul>';
        echo '<p style="margin-bottom:0; opacity:0.6;">Example: <code>[bookly-form appearance_id="' . $bookly_forms[0]['id'] . '"]</code></p>';
        echo '</div>';
    }
    
    echo '<textarea name="gary_booking_shortcode" style="width:100%; height:60px; font-family:monospace; font-size:12px;" placeholder="[bookly-form appearance_id=\"X\"]">'.esc_textarea($booking_sc).'</textarea>';
    echo '<p style="font-size:11px; color:#666; margin-bottom:0;">Leave empty to use the standard /booking/ page link.</p>';
    echo '</div>';

    // Sub-service Slots
    global $wpdb;
    $table = $wpdb->prefix . 'bookly_services';
    $services = array();
    if ( $wpdb->get_var("SHOW TABLES LIKE '$table'") == $table ) {
        $services = $wpdb->get_results( "SELECT id, title FROM $table ORDER BY title ASC" );
    }

    echo '<p><strong>Sub-Service Bundle Slots (INCLUDED):</strong></p>';
    for ( $i = 1; $i <= 8; $i++ ) {
        $val = get_post_meta( $post->ID, "_gary_sub_service_$i", true );
        echo '<div style="margin-bottom:8px;">';
        echo '<label style="font-size:11px; color:#666;">Included '.$i.':</label><br />';
        echo '<select name="gary_sub_service_'.$i.'" style="width:100%;">';
        echo '<option value="">-- No Sub-service --</option>';
        foreach ( $services as $s ) { echo '<option value="'.$s->id.'" '.selected($val, $s->id, false).'>'.$s->title.'</option>'; }
        echo '</select></div>';
    }

    echo '<p style="margin-top:20px;"><strong>Paid Add-On Slots (OPTIONAL):</strong></p>';
    for ( $i = 1; $i <= 8; $i++ ) {
        $val = get_post_meta( $post->ID, "_gary_paid_service_$i", true );
        echo '<div style="margin-bottom:8px;">';
        echo '<label style="font-size:11px; color:#666;">Add-On '.$i.':</label><br />';
        echo '<select name="gary_paid_service_'.$i.'" style="width:100%;">';
        echo '<option value="">-- No Add-on --</option>';
        foreach ( $services as $s ) { echo '<option value="'.$s->id.'" '.selected($val, $s->id, false).'>'.$s->title.'</option>'; }
        echo '</select></div>';
    }
}



function gary_save_meta_boxes( $post_id ) {
    if ( isset($_POST['gary_bookly_id']) ) update_post_meta( $post_id, '_gary_bookly_id', $_POST['gary_bookly_id'] );
    if ( isset($_POST['gary_service_subtitle']) ) update_post_meta( $post_id, '_gary_service_subtitle', $_POST['gary_service_subtitle'] );
    if ( isset($_POST['gary_service_highlights']) ) update_post_meta( $post_id, '_gary_service_highlights', $_POST['gary_service_highlights'] );
    
    if ( isset($_POST['gary_retail_value_override']) ) update_post_meta( $post_id, '_gary_retail_value_override', $_POST['gary_retail_value_override'] );
    if ( isset($_POST['gary_booking_shortcode']) ) update_post_meta( $post_id, '_gary_booking_shortcode', $_POST['gary_booking_shortcode'] );
    
    for ( $i = 1; $i <= 8; $i++ ) {
        if ( isset($_POST["gary_sub_service_$i"]) ) update_post_meta( $post_id, "_gary_sub_service_$i", $_POST["gary_sub_service_$i"] );
        if ( isset($_POST["gary_paid_service_$i"]) ) update_post_meta( $post_id, "_gary_paid_service_$i", $_POST["gary_paid_service_$i"] );
    }
}
add_action( 'save_post', 'gary_save_meta_boxes' );

/**
 * BUNDLE LOGIC (TOTAL RESTORATION)
 */
function gary_get_sub_service_summary( $post_id ) {
    $bookly_id = get_post_meta( $post_id, '_gary_bookly_id', true );
    $bookly_data = gary_get_bookly_service_data( $bookly_id );
    $parent_price = $bookly_data ? (float)$bookly_data['price'] : 0;
    
    $inclusions = array();
    $paid_addons = array();
    $inc_titles = array();
    $inc_total_val = 0;
    
    // 1. INCLUDED ITEMS
    for ( $i = 1; $i <= 8; $i++ ) {
        $sub_id = get_post_meta( $post_id, "_gary_sub_service_$i", true );
        if ( !empty($sub_id) ) {
            $sub_data = gary_get_bookly_service_data($sub_id);
            if($sub_data) {
                $inc_titles[] = $sub_data['title'];
                $unit_p = (float)$sub_data['price'];
                $inc_total_val += $unit_p;
                $page_id = gary_find_page_by_bookly_title($sub_data['title']);
                $inclusions[] = array(
                    'page_id' => $page_id, 'bookly_id' => $sub_id, 'title' => $sub_data['title'],
                    'price' => $unit_p, 'info' => $sub_data['info'], 'thumb' => $page_id ? get_the_post_thumbnail_url($page_id, 'medium') : ''
                );
            }
        }
    }

    // 2. PAID ADDONS
    for ( $i = 1; $i <= 8; $i++ ) {
        $sub_id = get_post_meta( $post_id, "_gary_paid_service_$i", true );
        if ( !empty($sub_id) ) {
            $sub_data = gary_get_bookly_service_data($sub_id);
            if($sub_data) {
                $unit_p = (float)$sub_data['price'];
                $page_id = gary_find_page_by_bookly_title($sub_data['title']);
                $paid_addons[] = array(
                    'page_id' => $page_id, 'bookly_id' => $sub_id, 'title' => $sub_data['title'],
                    'price' => $unit_p, 'info' => $sub_data['info'], 'thumb' => $page_id ? get_the_post_thumbnail_url($page_id, 'medium') : ''
                );
            }
        }
    }

    $retail_override = get_post_meta( $post_id, '_gary_retail_value_override', true );
    $savings = !empty($retail_override) ? (float)$retail_override - $parent_price : $inc_total_val;
    $retail_value = abs($parent_price) + abs($savings);

    return array(
        'grid_items'   => $inclusions, // Backward compatibility
        'inclusions'   => $inclusions,
        'paid_addons'  => $paid_addons,
        'titles'       => $inc_titles,
        'total_value'  => $retail_value,
        'bought_separately' => $inc_total_val,
        'savings'      => $savings,
        'parent_price' => $parent_price,
        'included_str' => implode(', ', $inc_titles)
    );
}

/**
 * Fetch Custom Bookly Forms (Appearances)
 */
function gary_get_bookly_forms() {
    global $wpdb;
    $table = $wpdb->prefix . 'bookly_forms';
    if ( $wpdb->get_var("SHOW TABLES LIKE '$table'") != $table ) return array();
    
    $results = $wpdb->get_results( "SELECT id, name FROM $table ORDER BY name ASC", ARRAY_A );
    return $results ? $results : array();
}

/**
 * SECURITY: Limit login error messages
 */
add_filter( 'login_errors', function() { return 'Login failed.'; });
