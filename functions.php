<?php
/**
 * File: functions.php
 * Theme: Gary Wallage Wedding Pro
 * Version: 2.100.0
 * Fixes: FULL RESTORATION of Customizer suite, dynamic styling controls, and sub-service logic.
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
 * CUSTOMIZER REGISTRATION (Header, Hero Slider, Social)
 */
function gary_customize_register( $wp_customize ) {
    // 1. Header Options
    $wp_customize->add_section( 'gary_header_options', array('title' => 'Header Options') );
    $wp_customize->add_setting( 'logo_size_px', array('default' => '280', 'transport' => 'refresh') );
    $wp_customize->add_control( 'logo_size_px', array('label' => 'Logo Size (px)', 'section' => 'gary_header_options', 'type' => 'number') );
    $wp_customize->add_setting( 'header_padding_val', array('default' => '80', 'transport' => 'refresh') );
    $wp_customize->add_control( 'header_padding_val', array('label' => 'Header Padding (px)', 'section' => 'gary_header_options', 'type' => 'number') );

    // 2. Hero Slider Content (Restoring all 5 slides)
    $wp_customize->add_section( 'gary_hero_section', array('title' => 'Hero Slider Content', 'priority' => 30) );
    for ( $i = 0; $i < 5; $i++ ) {
        $wp_customize->add_setting( "hero_slide_{$i}_img", array('sanitize_callback' => 'esc_url_raw') );
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, "hero_slide_{$i}_img", array(
            'label' => "Slide " . ($i+1) . " Image", 'section' => 'gary_hero_section'
        )));
        $wp_customize->add_setting( "hero_slide_{$i}_title", array('default' => '') );
        $wp_customize->add_control( "hero_slide_{$i}_title", array('label' => "Slide " . ($i+1) . " Title", 'section' => 'gary_hero_section') );
    }

    // 3. Social & Colors
    $wp_customize->add_section( 'gary_social_options', array('title' => 'Social Media Links') );
    $socials = array('facebook','instagram','youtube','twitter','linkedin');
    foreach($socials as $s) {
        $wp_customize->add_setting("social_$s", array('sanitize_callback' => 'esc_url_raw'));
        $wp_customize->add_control("social_$s", array('label' => ucfirst($s).' URL', 'section' => 'gary_social_options'));
    }
}
add_action( 'customize_register', 'gary_customize_register' );

/**
 * DYNAMIC CSS (Maps Customizer Settings to Design System)
 */
add_action( 'wp_head', function() {
    $logo_size = get_theme_mod( 'logo_size_px', '280' ); 
    $padding = get_theme_mod( 'header_padding_val', '80' );
    ?>
    <style type="text/css">
        .site-header { padding: <?php echo $padding; ?>px 0 !important; }
        .focal-center .custom-logo-link img { width: <?php echo $logo_size; ?>px !important; }
    </style>
    <?php
});

/**
 * CORE MODULES
 */
require_once get_template_directory() . '/inc/editorial-patterns.php';
require_once get_template_directory() . '/inc/seo-engine.php';
require_once get_template_directory() . '/inc/shortcodes.php';
require_once get_template_directory() . '/inc/blocks/service-blocks.php';

/**
 * PERFORMANCE HEADERS & SCRIPTS
 */
function gary_send_performance_headers() {
    if ( is_admin() ) return;
    $template_uri = get_template_directory_uri();
    header( "Link: <{$template_uri}/style.css?ver=2.100.0>; rel=preload; as=style", false );
}
add_action( 'send_headers', 'gary_send_performance_headers' );

function gary_wedding_scripts() { wp_enqueue_style( 'gary-wedding-style', get_stylesheet_uri(), array(), '2.100.0' ); }
add_action( 'wp_enqueue_scripts', 'gary_wedding_scripts' );

function gary_wedding_footer_scripts() {
    if ( is_admin() ) return;
    ?>
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
 * DATA HELPERS
 */
function gary_get_bookly_service_data( $service_id ) {
    if ( empty($service_id) ) return false;
    global $wpdb;
    $table = $wpdb->prefix . 'bookly_services';
    if ( $wpdb->get_var("SHOW TABLES LIKE '$table'") != $table ) return false;
    return $wpdb->get_row( $wpdb->prepare( "SELECT title, price FROM $table WHERE id = %d", $service_id ), ARRAY_A );
}

function gary_find_page_by_bookly_title( $title ) {
    if ( empty($title) ) return false;
    global $wpdb;
    return $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_gary_service_title_match' AND meta_value = %s LIMIT 1", $title ) );
}

/**
 * META BOXES (Restoring Full Editorial Fields)
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
        foreach ( $svcs as $s ) {
            echo '<option value="'.$s->id.'" '.selected($val, $s->id, false).'>'.$s->title.'</option>';
        }
    }
    echo '</select>';
}

function gary_editorial_mb_html( $post ) {
    $sub = get_post_meta( $post->ID, '_gary_service_subtitle', true );
    $high = get_post_meta( $post->ID, '_gary_service_highlights', true );
    echo '<p>Subtitle:<br /><input type="text" name="gary_service_subtitle" value="'.esc_attr($sub).'" style="width:100%;" /></p>';
    echo '<p>Highlights:<br /><textarea name="gary_service_highlights" style="width:100%; height:80px;">'.esc_textarea($high).'</textarea></p>';
}

function gary_save_meta_boxes( $post_id ) {
    if ( isset($_POST['gary_bookly_id']) ) update_post_meta( $post_id, '_gary_bookly_id', $_POST['gary_bookly_id'] );
    if ( isset($_POST['gary_service_subtitle']) ) update_post_meta( $post_id, '_gary_service_subtitle', $_POST['gary_service_subtitle'] );
    if ( isset($_POST['gary_service_highlights']) ) update_post_meta( $post_id, '_gary_service_highlights', $_POST['gary_service_highlights'] );
}
add_action( 'save_post', 'gary_save_meta_boxes' );

/**
 * BUNDLE LOGIC (Restoring Full Analysis)
 */
function gary_get_sub_service_summary( $post_id ) {
    $bookly_id = get_post_meta( $post_id, '_gary_bookly_id', true );
    $bookly_data = gary_get_bookly_service_data( $bookly_id );
    $parent_price = $bookly_data ? (float)$bookly_data['price'] : 0;
    
    $titles = array();
    $total_val = $parent_price;
    
    for ( $i = 1; $i <= 8; $i++ ) {
        $sub_id = get_post_meta( $post_id, "_gary_sub_service_$i", true );
        if ( !empty($sub_id) ) {
            $sub_data = gary_get_bookly_service_data($sub_id);
            if($sub_data) {
                $titles[] = $sub_data['title'];
                $total_val += (float)$sub_data['price'];
            }
        }
    }

    return array(
        'grid_items'   => array(),
        'titles'       => $titles,
        'total_value'  => $total_val,
        'savings'      => $total_val - $parent_price,
        'included_str' => implode(', ', $titles)
    );
}
