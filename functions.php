<?php
/**
 * File: functions.php
 * Theme: Gary Wallage Wedding Pro
 * Version: 1.200.0
 * Fixes: CRITICAL RESTORATION. Restoring all missing functions to fix site crash.
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
        
        // Block Editor Design Support
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
    $wp_customize->add_section( 'gary_social_options', array(
        'title'    => 'Social Media Links',
        'priority' => 30,
    ));

    $social_fields = array(
        'social_facebook'  => array( 'label' => 'Facebook URL',  'default' => '' ),
        'social_instagram' => array( 'label' => 'Instagram URL', 'default' => '' ),
        'social_youtube'   => array( 'label' => 'YouTube URL',   'default' => '' ),
        'social_twitter'   => array( 'label' => 'X / Twitter URL', 'default' => '' ),
        'social_linkedin'  => array( 'label' => 'LinkedIn URL',  'default' => '' ),
    );

    foreach ( $social_fields as $key => $field ) {
        $wp_customize->add_setting( $key, array(
            'default'           => $field['default'],
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'refresh',
        ) );
        $wp_customize->add_control( $key, array(
            'label'   => $field['label'],
            'section' => 'gary_social_options',
            'type'    => 'url',
        ) );
    }
}
add_action( 'customize_register', 'gary_customize_register' );

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
    header( "Link: <{$template_uri}/style.css?ver=1.200.0>; rel=preload; as=style", false );
}
add_action( 'send_headers', 'gary_send_performance_headers' );

function gary_wedding_scripts() { wp_enqueue_style( 'gary-wedding-style', get_stylesheet_uri(), array(), '1.200.0' ); }
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
            overlay.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
            if(closeBtn) closeBtn.focus();
        }

        function closeMenu() {
            overlay.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
            toggleBtn.focus();
        }

        toggleBtn.addEventListener('click', openMenu);
        if(closeBtn) closeBtn.addEventListener('click', closeMenu);

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && overlay.getAttribute('aria-hidden') === 'false') {
                closeMenu();
            }
        });
    });
    </script>
    <?php
}
add_action( 'wp_footer', 'gary_wedding_footer_scripts' );

/**
 * BOOKLY DATA HELPER
 */
function gary_get_bookly_service_data( $service_id ) {
    if ( empty($service_id) ) return false;
    global $wpdb;
    $table = $wpdb->prefix . 'bookly_services';
    if ( $wpdb->get_var("SHOW TABLES LIKE '$table'") != $table ) return false;
    
    $row = $wpdb->get_row( $wpdb->prepare( "SELECT title, price, duration, info FROM $table WHERE id = %d", $service_id ), ARRAY_A );
    return $row;
}

function gary_find_page_by_bookly_title( $title ) {
    if ( empty($title) ) return false;
    global $wpdb;
    $page_id = $wpdb->get_var( $wpdb->prepare( 
        "SELECT post_id FROM {$wpdb->postmeta} pm 
         JOIN {$wpdb->posts} p ON p.ID = pm.post_id 
         WHERE pm.meta_key = '_gary_service_title_match' AND pm.meta_value = %s 
         AND p.post_status = 'publish' LIMIT 1", $title 
    ) );
    return $page_id;
}

/**
 * EDITOR BOOKLY LINKER UI
 */
function gary_add_bookly_meta_box() {
    add_meta_box( 'gary_bookly_integration_box', __( 'Bookly Service Link', 'garywedding' ), 'gary_bookly_meta_box_html', 'page', 'side', 'high' );
}
add_action( 'add_meta_boxes', 'gary_add_bookly_meta_box' );

function gary_bookly_meta_box_html( $post ) {
    global $wpdb;
    $value = get_post_meta( $post->ID, '_gary_bookly_id', true );
    wp_nonce_field( 'gary_bookly_meta_box_nonce', 'gary_bookly_meta_box_nonce' );
    $table_name = $wpdb->prefix . 'bookly_services';
    $services_exist = ( $wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name );
    echo '<select name="gary_bookly_id" style="width:100%;">';
    echo '<option value="">-- No Service --</option>';
    if ( $services_exist ) {
        $services = $wpdb->get_results( "SELECT id, title FROM $table_name ORDER BY title ASC" );
        foreach ( $services as $service ) {
            $selected = selected( $value, $service->id, false );
            echo '<option value="' . esc_attr($service->id) . '" ' . $selected . '>' . esc_html($service->title) . '</option>';
        }
    }
    echo '</select>';
}

function gary_save_bookly_meta_box_data( $post_id ) {
    if ( isset( $_POST['gary_bookly_id'] ) && current_user_can( 'edit_page', $post_id ) ) {
        update_post_meta( $post_id, '_gary_bookly_id', sanitize_text_field( $_POST['gary_bookly_id'] ) );
    }
}
add_action( 'save_post', 'gary_save_bookly_meta_box_data' );

/**
 * EDITORIAL META BOXES
 */
function gary_add_editorial_meta_box() {
    add_meta_box( 'gary_editorial_layout_box', __( 'Editorial Layout Data', 'garywedding' ), 'gary_editorial_meta_box_html', 'page', 'side', 'high' );
}
add_action( 'add_meta_boxes', 'gary_add_editorial_meta_box' );

function gary_editorial_meta_box_html( $post ) {
    wp_nonce_field( 'gary_editorial_meta_box_nonce', 'gary_editorial_meta_box_nonce' );
    $subtitle = get_post_meta( $post->ID, '_gary_service_subtitle', true );
    $highlights = get_post_meta( $post->ID, '_gary_service_highlights', true );
    echo '<p><strong>Subtitle:</strong><br /><input type="text" name="gary_service_subtitle" value="' . esc_attr($subtitle) . '" style="width:100%;" /></p>';
    echo '<p><strong>Highlights:</strong><br /><textarea name="gary_service_highlights" style="width:100%;">' . esc_textarea($highlights) . '</textarea></p>';
}

function gary_save_editorial_meta_box_data( $post_id ) {
    if ( isset( $_POST['gary_service_subtitle'] ) ) update_post_meta( $post_id, '_gary_service_subtitle', sanitize_text_field( $_POST['gary_service_subtitle'] ) );
    if ( isset( $_POST['gary_service_highlights'] ) ) update_post_meta( $post_id, '_gary_service_highlights', sanitize_textarea_field( $_POST['gary_service_highlights'] ) );
}
add_action( 'save_post', 'gary_save_editorial_meta_box_data' );

/**
 * Helper: Aggregate sub-services and calculate value.
 */
function gary_get_sub_service_summary( $post_id ) {
    $bookly_id = get_post_meta( $post_id, '_gary_bookly_id', true );
    $bookly_data = gary_get_bookly_service_data( $bookly_id );
    
    $parent_price = $bookly_data ? (float)$bookly_data['price'] : 0;
    
    // Quick summary for now to restore site
    return array(
        'grid_items'   => array(),
        'titles'       => array(),
        'total_value'  => $parent_price,
        'savings'      => 0,
        'included_str' => ''
    );
}
