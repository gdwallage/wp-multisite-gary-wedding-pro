<?php
/**
 * File: functions.php
 * Theme: Gary Wallage Wedding Pro
 * Version: 4.2.0
 * Fixes: GLOBAL DE-CAPPING + SIZE NORMALIZATION.
 * Integration: GW Bookly Addons Official Table Support.
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

    // Build a flat list of all published pages for the dropdowns (Optimized)
    $page_choices = array( '' => '— Select a page —' );
    $query = new WP_Query( array(
        'post_type'      => 'page',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'fields'         => 'ids',
        'no_found_rows'  => true,
        'orderby'        => 'title',
        'order'          => 'ASC'
    ) );
    
    if ( $query->have_posts() ) {
        foreach ( $query->posts as $p_id ) {
            $page_choices[ $p_id ] = get_the_title( $p_id );
        }
    }
    wp_reset_postdata();

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
});

/**
 * CORE MODULES
 */
require_once get_template_directory() . '/inc/shortcodes.php';
require_once get_template_directory() . '/inc/blocks/service-blocks.php';
require_once get_template_directory() . '/inc/card-renderer.php';

/**
 * PERFORMANCE & SCRIPTS
 */
function gary_send_performance_headers() {
    if ( is_admin() ) return;
    $template_uri = get_template_directory_uri();
    header( "Link: <{$template_uri}/style.css?ver=3000.10.0>; rel=preload; as=style", false );
}
add_action( 'send_headers', 'gary_send_performance_headers' );

function gary_wedding_scripts() { 
    wp_enqueue_style( 'gary-wedding-v3-editorial', get_stylesheet_uri(), array(), '3000.10.0' ); 
    
    // Add My Account support for logged in users
    if ( is_user_logged_in() ) {
        $custom_css = "
            .gw-credits-grid { margin-top: 20px; }
            .gw-credit-card:hover { border-color: var(--brand-gold) !important; box-shadow: var(--shadow-deep); }
        ";
        wp_add_inline_style( 'gary-wedding-style', $custom_css );
    }
}
add_action( 'wp_enqueue_scripts', 'gary_wedding_scripts' );
function gary_wedding_footer_scripts() {
    if ( is_admin() ) return; ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.querySelector('.menu-toggle');
        const overlay = document.getElementById('primary-menu');
        if(toggleBtn && overlay) {
            toggleBtn.addEventListener('click', () => {
                const isOpened = overlay.getAttribute('aria-hidden') === 'false';
                overlay.setAttribute('aria-hidden', isOpened ? 'true' : 'false');
                document.body.style.overflow = isOpened ? '' : 'hidden';
            });
            document.querySelector('.menu-close')?.addEventListener('click', () => {
                overlay.setAttribute('aria-hidden', 'true');
                document.body.style.overflow = '';
            });
        }

        // --- AVAILABILITY CHECKER LOGIC (ATOMIC & JOURNEY) ---
        const checkBtns = document.querySelectorAll('.gw-check-availability-btn, .gw-check-availability-btn-atomic');
        checkBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const isAtomic = this.classList.contains('gw-check-availability-btn-atomic');
                const stepId = isAtomic ? 'atomic' : this.dataset.stepId;
                const dateInput = document.getElementById(isAtomic ? 'gw-atomic-check-date' : 'gw-check-date-' + stepId);
                const resultDiv = document.getElementById(isAtomic ? 'gw-atomic-availability-result' : 'gw-availability-result-' + stepId);
                const atomicCta = document.getElementById('gw-atomic-booking-cta');
                
                if ( !dateInput || !dateInput.value ) {
                    if(resultDiv) resultDiv.innerText = 'Please select a date.';
                    return;
                }

                this.disabled = true;
                const originalText = this.innerText;
                this.innerText = 'Checking...';
                
                if(atomicCta) atomicCta.style.display = 'none';

                if(resultDiv) {
                    resultDiv.innerText = 'Consulting the calendar...';
                    resultDiv.className = 'gw-avail-result';
                }

                const duration = this.dataset.duration || 'Full Day';
                
                fetch('/wp-admin/admin-ajax.php?action=gary_check_availability&check_date=' + dateInput.value + '&duration=' + encodeURIComponent(duration))
                    .then(response => response.json())
                    .then(data => {
                        this.disabled = false;
                        this.innerText = originalText;
                        if ( data.success ) {
                            resultDiv.innerText = data.data.message;
                            resultDiv.classList.add('is-available');
                            // REVEAL CTA FOR ATOMIC
                            if ( isAtomic && atomicCta ) {
                                atomicCta.style.display = 'flex';
                            }
                        } else {
                            resultDiv.innerText = data.data.message;
                            resultDiv.classList.add('is-busy');
                        }
                    })
                    .catch(err => {
                        this.disabled = false;
                        this.innerText = originalText;
                        if(resultDiv) resultDiv.innerText = 'Could not connect. Please try again.';
                    });
            });
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
 * HELPER: Get the WordPress Page ID for a given Bookly Service ID
 * Prioritizes the official "GW Bookly Addon" link.
 */
function gary_get_page_id_for_service( $service_id ) {
    global $wpdb;
    if ( empty($service_id) ) return false;
    
    // 1. Try official link
    $official_table = $wpdb->prefix . 'gw_bookly_service_links';
    $page_id = $wpdb->get_var( $wpdb->prepare( "SELECT wp_page_id FROM $official_table WHERE service_id = %d", $service_id ) );
    if ( $page_id ) return $page_id;
    
    // 2. Fallback to legacy meta
    return $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_gary_bookly_id' AND meta_value = %s LIMIT 1", $service_id ) );
}

/**
 * HELPER: Get the Bookly Service ID for a given WordPress Page ID
 */
function gary_get_service_id_for_page( $page_id ) {
    global $wpdb;
    if ( empty($page_id) ) return false;
    
    // 1. Try official link
    $official_table = $wpdb->prefix . 'gw_bookly_service_links';
    $service_id = $wpdb->get_var( $wpdb->prepare( "SELECT service_id FROM $official_table WHERE wp_page_id = %d", $page_id ) );
    if ( $service_id ) return $service_id;
    
    // 2. Fallback to legacy meta
    return get_post_meta( $page_id, '_gary_bookly_id', true );
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
 * HELPER: Simple duration parser for availability checks
 */
function gary_parse_duration_to_seconds( $text ) {
    if ( stripos($text, 'Full Day') !== false || stripos($text, 'Wedding') !== false ) {
        return -1; // Flag for Full Day
    }
    preg_match('/(\d+)/', $text, $matches);
    $hours = isset($matches[1]) ? intval($matches[1]) : 2; // Default 2 hours
    return $hours * 3600;
}

/**
 * HELPER: Strip identifier codes (e.g. "WE01 - ") from service names
 */
function gary_clean_service_name( $name ) {
    if ( empty($name) ) return $name;
    // 1. Strip identifier (WE01 - )
    $name = preg_replace('/^.*? - /', '', $name);
    // 2. Convert to Title Case for legibility in script font
    return ucwords( strtolower( $name ) );
}

/**
 * DATA: Fetch all Bookly services grouped by type with savings calculation
 */
function gary_get_grouped_bookly_services() {
    global $wpdb;
    $table_services = $wpdb->prefix . 'bookly_services';
    $table_sub_services = $wpdb->prefix . 'bookly_sub_services';
    
    if ( $wpdb->get_var("SHOW TABLES LIKE '$table_services'") != $table_services ) return array('packages' => array(), 'individual' => array());
    
    // 1. Fetch all services
    $all_services = $wpdb->get_results( "SELECT id, title, type, price, duration, info FROM $table_services ORDER BY title ASC", ARRAY_A );
    
    $packages = array();
    $individual = array();
    
    // Map of all services for easy price lookup
    $service_map = array();
    foreach ( $all_services as $s ) {
        $service_map[ $s['id'] ] = $s;
    }
    
    foreach ( $all_services as $s ) {
        $item = $s;
        $item['clean_title'] = gary_clean_service_name( $s['title'] );
        $item['savings'] = 0;
        $item['sub_service_titles'] = array();
        
        // Find matching WP page for thumbnail/link
        $official_links_table = $wpdb->prefix . 'gw_bookly_service_links';
        $inclusions_table = $wpdb->prefix . 'gw_bookly_service_inclusions';
        $page_id = false;
        
        // A. Try the official link table
        if ( $wpdb->get_var("SHOW TABLES LIKE '$official_links_table'") == $official_links_table ) {
            $page_id = $wpdb->get_var( $wpdb->prepare( "SELECT wp_page_id FROM $official_links_table WHERE service_id = %d", $s['id'] ) );
        }
        
        // B. Fallback to legacy meta search
        if ( ! $page_id ) {
            $page_id = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_gary_bookly_id' AND meta_value = %s LIMIT 1", $s['id'] ) );
        }
        
        $item['page_id'] = $page_id;
        $item['permalink'] = $page_id ? get_permalink( $page_id ) : '/booking/';
        $item['thumbnail'] = $page_id ? get_the_post_thumbnail_url( $page_id, 'large' ) : '';
        
        // --- INCLUSIONS LOGIC ---
        $total_sub_price = 0;

        // 1. Check Custom GW Inclusions (The New Standard)
        if ( $wpdb->get_var("SHOW TABLES LIKE '$inclusions_table'") == $inclusions_table ) {
            $custom_inclusions = $wpdb->get_results( $wpdb->prepare( "SELECT included_id FROM $inclusions_table WHERE parent_id = %d ORDER BY position ASC", $s['id'] ) );
            foreach ( $custom_inclusions as $inc ) {
                if ( isset( $service_map[ $inc->included_id ] ) ) {
                    $sub_svc = $service_map[ $inc->included_id ];
                    $item['sub_service_titles'][] = gary_clean_service_name( $sub_svc['title'] );
                    $total_sub_price += (float)$sub_svc['price'];
                }
            }
        }

        // 2. Fallback/Merge with Native Bookly Compound/Package relations
        if ( in_array( $s['type'], array( 'compound', 'package' ) ) ) {
            $sub_relations = $wpdb->get_results( $wpdb->prepare( "SELECT sub_service_id FROM $table_sub_services WHERE service_id = %d ORDER BY position ASC", $s['id'] ) );
            foreach ( $sub_relations as $rel ) {
                if ( isset( $service_map[ $rel->sub_service_id ] ) ) {
                    $sub_svc = $service_map[ $rel->sub_service_id ];
                    $clean_sub_title = gary_clean_service_name( $sub_svc['title'] );
                    if ( !in_array( $clean_sub_title, $item['sub_service_titles'] ) ) {
                        $item['sub_service_titles'][] = $clean_sub_title;
                        $total_sub_price += (float)$sub_svc['price'];
                    }
                }
            }
        }

        // Calculate Savings
        if ( $total_sub_price > (float)$s['price'] ) {
            $item['savings'] = $total_sub_price - (float)$s['price'];
            $item['retail_value'] = $total_sub_price;
        }

        // Categorize
        if ( !empty($item['sub_service_titles']) || in_array( $s['type'], array( 'compound', 'package' ) ) ) {
            $packages[] = $item;
        } else {
            $individual[] = $item;
        }
    }
    
    return array(
        'packages'   => $packages,
        'individual' => $individual
    );
}

/**
 * META BOXES
 */
function gary_add_meta_boxes() {
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

    // Legacy slots removed - now handled via Bookly "GW Addons" tab
}



function gary_save_meta_boxes( $post_id ) {
    if ( isset($_POST['gary_bookly_id']) ) update_post_meta( $post_id, '_gary_bookly_id', $_POST['gary_bookly_id'] );
    if ( isset($_POST['gary_service_subtitle']) ) update_post_meta( $post_id, '_gary_service_subtitle', $_POST['gary_service_subtitle'] );
    if ( isset($_POST['gary_service_highlights']) ) update_post_meta( $post_id, '_gary_service_highlights', $_POST['gary_service_highlights'] );
    
    if ( isset($_POST['gary_retail_value_override']) ) update_post_meta( $post_id, '_gary_retail_value_override', $_POST['gary_retail_value_override'] );
    if ( isset($_POST['gary_booking_shortcode']) ) update_post_meta( $post_id, '_gary_booking_shortcode', $_POST['gary_booking_shortcode'] );
    
    for ( $i = 1; $i <= 8; $i++ ) {
        if ( isset($_POST["gary_sub_service_$i"]) ) delete_post_meta( $post_id, "_gary_sub_service_$i" );
        if ( isset($_POST["gary_paid_service_$i"]) ) delete_post_meta( $post_id, "_gary_paid_service_$i" );
    }
}
add_action( 'save_post', 'gary_save_meta_boxes' );

/**
 * MANUAL SAVINGS FALLBACK (For core featured units)
 * Ensures ribbons appear on the Home Page even if the database mapping is slow.
 */
function gary_get_manual_savings_fallback( $title ) {
    $title = strtolower($title);
    if (strpos($title, 'story') !== false) return 100;
    if (strpos($title, 'ceremony') !== false) return 50;
    if (strpos($title, 'celebration') !== false) return 100;
    if (strpos($title, 'registry') !== false) return 40;
    return 0;
}

/**
 * BUNDLE LOGIC (UNIFIED SAVINGS ENGINE)
 * Merges native Bookly compound services with custom editorial inclusions.
 */
function gary_get_sub_service_summary( $id, $is_post_id = true ) {
    global $wpdb;
    
    if ( $is_post_id ) {
        $post_id = (int)$id;
        $bookly_id = gary_get_service_id_for_page( $post_id );
    } else {
        $bookly_id = (int)$id;
        $post_id = gary_get_page_id_for_service( $bookly_id );
    }

    $bookly_data = gary_get_bookly_service_data( $bookly_id );
    $parent_price = $bookly_data ? (float)$bookly_data['price'] : 0;
    $parent_title = $bookly_data ? $bookly_data['title'] : '';
    
    $inclusions = array();
    $inc_titles = array();
    $inc_total_val = 0;
    $inc_total_duration = 0;
    $processed_ids = array();
    
    // 1. NATIVE BOOKLY COMPOUND RELATIONS
    $table_sub = $wpdb->prefix . 'bookly_sub_services';
    if ( $bookly_id && $wpdb->get_var("SHOW TABLES LIKE '$table_sub'") == $table_sub ) {
        $native_sub = $wpdb->get_results( $wpdb->prepare( "SELECT sub_service_id FROM $table_sub WHERE service_id = %d ORDER BY position ASC", $bookly_id ) );
        foreach ( $native_sub as $rel ) {
            $sub_data = gary_get_bookly_service_data( $rel->sub_service_id );
            if ( $sub_data && !in_array($rel->sub_service_id, $processed_ids) ) {
                $processed_ids[] = $rel->sub_service_id;
                $inc_titles[] = $sub_data['title'];
                $unit_p = (float)$sub_data['price'];
                $unit_d = (int)( isset($sub_data['duration']) ? $sub_data['duration'] : 0 );
                $inc_total_val += $unit_p;
                $inc_total_duration += $unit_d;
                $p_id = gary_get_page_id_for_service($rel->sub_service_id);
                $inclusions[] = array(
                    'page_id' => $p_id, 'bookly_id' => $rel->sub_service_id, 'title' => $sub_data['title'],
                    'price' => $unit_p, 'duration' => $unit_d, 'info' => $sub_data['info'],
                    'thumb' => $p_id ? get_the_post_thumbnail_url($p_id, 'medium') : ''
                );
            }
        }
    }

    // 2. CUSTOM EDITORIAL INCLUSIONS (GW Addons)
    $table_inc = $wpdb->prefix . 'gw_bookly_service_inclusions';
    if ( $bookly_id && $wpdb->get_var("SHOW TABLES LIKE '$table_inc'") == $table_inc ) {
        $db_inclusions = $wpdb->get_results( $wpdb->prepare( "SELECT included_id FROM $table_inc WHERE parent_id = %d ORDER BY position ASC", $bookly_id ) );
        foreach ( $db_inclusions as $db_inc ) {
            if ( in_array($db_inc->included_id, $processed_ids) ) continue; // Deduplicate
            
            $sub_data = gary_get_bookly_service_data( $db_inc->included_id );
            if ( $sub_data ) {
                $processed_ids[] = $db_inc->included_id;
                $inc_titles[] = $sub_data['title'];
                $unit_p = (float)$sub_data['price'];
                $unit_d = (int)( isset($sub_data['duration']) ? $sub_data['duration'] : 0 );
                $inc_total_val += $unit_p;
                $inc_total_duration += $unit_d;
                $p_id = gary_get_page_id_for_service($db_inc->included_id);
                $inclusions[] = array(
                    'page_id' => $p_id, 'bookly_id' => $db_inc->included_id, 'title' => $sub_data['title'],
                    'price' => $unit_p, 'duration' => $unit_d, 'info' => $sub_data['info'],
                    'thumb' => $p_id ? get_the_post_thumbnail_url($p_id, 'medium') : ''
                );
            }
        }
    }

    // 3. Fallback to manual highlights if no items found in database
    if ( empty($inc_titles) && $post_id ) {
        $highlights = get_post_meta($post_id, '_gary_service_highlights', true);
        if ($highlights) {
            $lines = explode("\n", $highlights);
            foreach($lines as $line) {
                if(trim($line)) $inc_titles[] = trim($line);
            }
        }
    }

    $retail_override = $post_id ? get_post_meta( $post_id, '_gary_retail_value_override', true ) : '';
    
    // Total Retail Value is either the override or the sum of inclusions
    $retail_value = !empty($retail_override) ? (float)$retail_override : $inc_total_val;
    $savings = $retail_value - $parent_price;
    
    // FINAL SAFETY: If no savings detected via DB, use the manual fallback table
    if ( $savings <= 0 ) {
        $savings = gary_get_manual_savings_fallback($parent_title);
    }

    return array(
        'grid_items'      => $inclusions, 
        'inclusions'      => $inclusions,
        'titles'          => array_map('gary_clean_service_name', $inc_titles),
        'total_value'     => $retail_value,
        'savings'         => $savings,
        'parent_price'    => $parent_price,
        'total_duration'  => $inc_total_duration,
        'included_str'    => implode(', ', array_map('gary_clean_service_name', $inc_titles))
    );
}


/**
 * PORTAL: WOOCOMMERCE "MY ACCOUNT" INTEGRATION
 */

// 1. Register Endpoint
function gary_add_my_bookings_endpoint() {
    add_rewrite_endpoint( 'my-bookings', EP_PAGES );
}
add_action( 'init', 'gary_add_my_bookings_endpoint' );

// 2. Add to Menu
function gary_add_my_bookings_link_my_account( $items ) {
    $new_items = array();
    foreach ( $items as $key => $value ) {
        $new_items[ $key ] = $value;
        if ( 'dashboard' === $key ) {
            $new_items['my-bookings'] = 'My Bookings';
        }
    }
    return $new_items;
}
add_filter( 'woocommerce_account_menu_items', 'gary_add_my_bookings_link_my_account' );

// 3. Render Content
function gary_my_bookings_content() {
    global $wpdb;
    $user_id = get_current_user_id();
    
    echo '<h3>Your Entitlements & Credits</h3>';
    $table_credits = $wpdb->prefix . 'gw_bookly_customer_credits';
    $credits = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $table_credits WHERE customer_id = %d AND balance > 0", $user_id ) );

    if ( $credits ) {
        echo '<div class="gw-credits-grid" style="display:grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap:20px; margin-bottom:40px;">';
        foreach ( $credits as $c ) {
            $s_data = gary_get_bookly_service_data($c->service_id);
            if ( !$s_data ) continue;
            ?>
            <div class="gw-credit-card" style="border: 2px solid var(--brand-gold-light); padding: 20px; background: #fff; position:relative;">
                <span style="font-size:0.7rem; text-transform:uppercase; letter-spacing:1px; opacity:0.6;">Included Session</span>
                <h4 style="margin: 5px 0 15px;"><?php echo esc_html(gary_clean_service_name($s_data['title'])); ?></h4>
                <div style="font-size:1.2rem; font-weight:700; margin-bottom:15px;"><?php echo (int)$c->balance; ?> Remaining</div>
                <a href="/booking/?redeem=<?php echo $c->id; ?>" class="btn-black" style="display:block; background:#000; color:#fff; text-decoration:none; text-align:center; padding:10px; font-size:0.7rem; text-transform:uppercase; letter-spacing:1px; font-weight:700;">Book Using Credit</a>
            </div>
            <?php
        }
        echo '</div>';
    } else {
        echo '<p style="opacity:0.6; margin-bottom:40px;">You currently have no outstanding session credits to redeem.</p>';
    }

    echo '<h3>Upcoming Appointments</h3>';
    echo do_shortcode('[bookly-appointments-list columns="date,time,service,staff,price,status,cancel"]');
}
add_action( 'woocommerce_account_my-bookings_endpoint', 'gary_my_bookings_content' );

/**
 * ENGINE: ENTITLEMENT GRANTING (WooCommerce Order Completed)
 */
function gary_grant_credits_on_order_complete( $order_id ) {
    global $wpdb;
    $order = wc_get_order( $order_id );
    $user_id = $order->get_user_id();
    if ( !$user_id ) return;

    $table_inc = $wpdb->prefix . 'gw_bookly_service_inclusions';
    $table_credits = $wpdb->prefix . 'gw_bookly_customer_credits';

    foreach ( $order->get_items() as $item ) {
        // Find if this product is linked to a Bookly service
        $bookly_id = $item->get_meta( 'Service ID' ); // Bookly stores this in WC meta
        if ( !$bookly_id ) continue;

        // Check for inclusions in our DB
        $inclusions = $wpdb->get_results( $wpdb->prepare( "SELECT included_id FROM $table_inc WHERE parent_id = %d", $bookly_id ) );
        foreach ( $inclusions as $inc ) {
            // Grant 1 credit per inclusion
            $wpdb->insert( $table_credits, array(
                'customer_id' => $user_id,
                'service_id'  => $inc->included_id,
                'balance'     => 1
            ) );
        }
    }
}
add_action( 'woocommerce_order_status_completed', 'gary_grant_credits_on_order_complete' );

/**
 * ENGINE: PRICE INTERCEPTOR (Zero the price if user has credit)
 */
function gary_intercept_bookly_price( $cart_info, $item ) {
    global $wpdb;
    $user_id = get_current_user_id();
    if ( !$user_id ) return $cart_info;

    $service_id = $item->getServiceId();
    $table_credits = $wpdb->prefix . 'gw_bookly_customer_credits';

    // Check if user has an active credit for this specific service
    $credit_id = $wpdb->get_var( $wpdb->prepare( "SELECT id FROM $table_credits WHERE customer_id = %d AND service_id = %d AND balance > 0 LIMIT 1", $user_id, $service_id ) );

    if ( $credit_id ) {
        // Redraw price to Zero for WooCommerce cart
        // Note: We'll consume the credit when the order is marked completed
        $cart_info->setPayNow( 0 );
        $cart_info->setTotal( 0 );
    }

    return $cart_info;
}
// We use the Proxy Shared filter to catch the cart info preparation
add_filter( 'bookly_cart_info_prepare', 'gary_intercept_bookly_price', 10, 2 );

// Consume credit only when the zero-price order is completed
function gary_consume_credits_on_order_complete( $order_id ) {
    global $wpdb;
    $order = wc_get_order( $order_id );
    if ( (float)$order->get_total() > 0 ) return; // Only process zero-price redemptions

    $user_id = $order->get_user_id();
    $table_credits = $wpdb->prefix . 'gw_bookly_customer_credits';

    foreach ( $order->get_items() as $item ) {
        $bookly_id = $item->get_meta( 'Service ID' );
        if ( !$bookly_id ) continue;

        // Decrease balance by 1
        $credit_id = $wpdb->get_var( $wpdb->prepare( "SELECT id FROM $table_credits WHERE customer_id = %d AND service_id = %d AND balance > 0 LIMIT 1", $user_id, $bookly_id ) );
        if ( $credit_id ) {
            $wpdb->query( $wpdb->prepare( "UPDATE $table_credits SET balance = balance - 1 WHERE id = %d", $credit_id ) );
        }
    }
}
add_action( 'woocommerce_order_status_completed', 'gary_consume_credits_on_order_complete', 20 ); // Run after granting logic

function gary_get_bookly_forms() {
    global $wpdb;
    $table = $wpdb->prefix . 'bookly_forms';
    if ( $wpdb->get_var("SHOW TABLES LIKE '$table'") != $table ) return array();
    
    $results = $wpdb->get_results( "SELECT id, name FROM $table ORDER BY name ASC", ARRAY_A );
    return $results ? $results : array();
}

/**
 * AJAX: Check Bookly Availability for a specific date (Photography Category)
 */
function gary_ajax_check_availability() {
    global $wpdb;
    
    $date = isset($_GET['check_date']) ? sanitize_text_field($_GET['check_date']) : '';
    $duration_str = isset($_GET['duration']) ? sanitize_text_field($_GET['duration']) : 'Full Day';

    if ( empty($date) ) {
        wp_send_json_error( array( 'message' => 'Please select a date.' ) );
    }

    $duration_seconds = gary_parse_duration_to_seconds($duration_str);

    // 1. Find the "Photography" Category ID
    $cat_table = $wpdb->prefix . 'bookly_categories';
    $cat_id = $wpdb->get_var( $wpdb->prepare( "SELECT id FROM $cat_table WHERE name LIKE %s LIMIT 1", '%Photography%' ) );
    
    // Looser staff selection to ensure we catch Gary regardless of exact category name
    if ( !$cat_id ) {
        $staff_query = "SELECT id FROM {$wpdb->prefix}bookly_staff LIMIT 20";
    } else {
        $staff_query = $wpdb->prepare( "SELECT id FROM {$wpdb->prefix}bookly_staff WHERE category_id = %d OR id > 0", $cat_id );
    }

    $staff_members = $wpdb->get_col( $staff_query );
    
    if ( empty($staff_members) ) {
        wp_send_json_error( array( 'message' => 'No photographers found in the system.' ) );
    }

    $is_available = false;
    $day_of_week = date('N', strtotime($date)); // 1 (Mon) to 7 (Sun)
    
    foreach ( $staff_members as $staff_id ) {
        // A. Is the staff member working on this day?
        $schedule_table = $wpdb->prefix . 'bookly_staff_schedule';
        $working_hours = $wpdb->get_row( $wpdb->prepare( "SELECT start_time, end_time FROM $schedule_table WHERE staff_id = %d AND day_index = %d LIMIT 1", $staff_id, $day_of_week ) );
        
        if ( !$working_hours || ( $working_hours->start_time === null && $working_hours->end_time === null ) ) {
            continue; 
        }

        // B. Check appointments
        $app_table = $wpdb->prefix . 'bookly_appointments';
        $customer_app_table = $wpdb->prefix . 'bookly_customer_appointments';
        
        // We need start/end times precisely to find gaps
        $appointments = $wpdb->get_results( $wpdb->prepare( 
            "SELECT start_date, end_date FROM $app_table 
             WHERE staff_id = %d AND DATE(start_date) = %s 
             ORDER BY start_date ASC", 
            $staff_id, $date 
        ) );

        // LOGIC 1: FULL DAY
        if ( $duration_seconds === -1 ) {
            if ( count($appointments) === 0 ) {
                $is_available = true;
                break;
            }
            continue;
        }

        // LOGIC 2: HOURLY GAP ANALYSIS
        // Required gap = Requested duration + 30 mins before + 30 mins after (Total + 1 hour)
        $required_gap = $duration_seconds + 3600; 
        $work_start = strtotime($date . ' ' . $working_hours->start_time);
        $work_end   = strtotime($date . ' ' . $working_hours->end_time);
        
        $current_cursor = $work_start;
        $found_gap = false;

        foreach ( $appointments as $app ) {
            $app_start = strtotime($app->start_date);
            $app_end   = strtotime($app->end_date);
            
            // Is there a big enough gap before this appointment?
            if ( ($app_start - $current_cursor) >= $required_gap ) {
                $found_gap = true;
                break;
            }
            // Move cursor to end of appointment
            $current_cursor = max($current_cursor, $app_end);
        }

        // Final check: gap between last appointment and end of work day
        if ( !$found_gap && ($work_end - $current_cursor) >= $required_gap ) {
            $found_gap = true;
        }

        if ( $found_gap ) {
            $is_available = true;
            break;
        }
    }

    if ( $is_available ) {
        wp_send_json_success( array( 'message' => 'Your date is available! Let\'s begin.' ) );
    } else {
        $msg = ($duration_seconds === -1) 
            ? 'I am already booked on this date, but please check another.'
            : 'I am tied up for parts of this day and cannot fit this session, please try another date.';
        wp_send_json_error( array( 'message' => $msg ) );
    }
}
add_action( 'wp_ajax_gary_check_availability', 'gary_ajax_check_availability' );
add_action( 'wp_ajax_nopriv_gary_check_availability', 'gary_ajax_check_availability' );

/**
 * SECURITY: Limit login error messages
 */
add_filter( 'login_errors', function() { return 'Login failed.'; });
