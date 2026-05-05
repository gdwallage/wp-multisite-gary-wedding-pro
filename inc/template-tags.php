<?php
/**
 * Template Tags: Helper functions and filters for theme display.
 */

/**
 * Branding: Optimized Logo Filter
 */
function gary_optimized_custom_logo( $html ) {
    $logo_id = get_theme_mod( 'custom_logo' );
    if ( ! $logo_id ) return $html;
 
    $logo_size = get_theme_mod( 'logo_size_px', '380' ); 
    $image = wp_get_attachment_image( $logo_id, 'gw-logo', false, array(
        'class'         => 'custom-logo',
        'itemprop'      => 'logo',
        'fetchpriority' => 'high',
        'style'         => "max-width: {$logo_size}px; height: auto;",
    ) );

    $html = sprintf( '<a href="%1$s" class="custom-logo-link" rel="home" itemprop="url">%2$s</a>',
        esc_url( home_url( '/' ) ),
        $image
    );
    return $html;
}
add_filter( 'get_custom_logo', 'gary_optimized_custom_logo' );

/**
 * Utility: Hex to RGB
 */
if ( ! function_exists( 'gary_hex2rgb' ) ) {
    function gary_hex2rgb( $hex ) {
        $hex = str_replace( "#", "", $hex );
        if ( strlen( $hex ) == 3 ) {
            $r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
            $g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
            $b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
        } else {
            $r = hexdec( substr( $hex, 0, 2 ) );
            $g = hexdec( substr( $hex, 2, 2 ) );
            $b = hexdec( substr( $hex, 4, 2 ) );
        }
        return "$r, $g, $b";
    }
}

/**
 * Data Helpers: Bookly and Page logic
 */
function gary_get_bookly_service_data( $service_id ) {
    if ( empty( $service_id ) ) return false;

    $cache_key = 'gw_bookly_svc_' . $service_id;
    $cached = wp_cache_get( $cache_key, 'gary_theme' );
    if ( $cached !== false ) return $cached;

    global $wpdb;
    $table = $wpdb->prefix . 'bookly_services';
    if ( $wpdb->get_var( "SHOW TABLES LIKE '$table'" ) != $table ) return false;
    
    $data = $wpdb->get_row( $wpdb->prepare( "SELECT title, price, duration, info FROM $table WHERE id = %d", $service_id ), ARRAY_A );
    wp_cache_set( $cache_key, $data ? $data : 'not_found', 'gary_theme', HOUR_IN_SECONDS );
    return $data;
}

function gary_get_page_id_for_service( $service_id ) {
    global $wpdb;
    if ( empty( $service_id ) ) return false;

    $cache_key = 'gw_page_for_svc_' . $service_id;
    $cached = wp_cache_get( $cache_key, 'gary_theme' );
    if ( $cached !== false ) return $cached === 'not_found' ? false : $cached;

    // 1. Try official link
    $official_table = $wpdb->prefix . 'gw_bookly_service_links';
    $page_id = $wpdb->get_var( $wpdb->prepare( "SELECT wp_page_id FROM $official_table WHERE service_id = %d", $service_id ) );
    
    // 2. Fallback
    if ( ! $page_id ) {
        $page_id = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_gary_bookly_id' AND meta_value = %s LIMIT 1", $service_id ) );
    }

    wp_cache_set( $cache_key, $page_id ? $page_id : 'not_found', 'gary_theme', HOUR_IN_SECONDS );
    return $page_id;
}

function gary_get_service_id_for_page( $page_id ) {
    global $wpdb;
    if ( empty( $page_id ) ) return false;

    $cache_key = 'gw_svc_for_page_' . $page_id;
    $cached = wp_cache_get( $cache_key, 'gary_theme' );
    if ( $cached !== false ) return $cached === 'not_found' ? false : $cached;

    // 1. Try official link
    $official_table = $wpdb->prefix . 'gw_bookly_service_links';
    $service_id = $wpdb->get_var( $wpdb->prepare( "SELECT service_id FROM $official_table WHERE wp_page_id = %d", $page_id ) );
    
    // 2. Fallback
    if ( ! $service_id ) {
        $service_id = get_post_meta( $page_id, '_gary_bookly_id', true );
    }

    wp_cache_set( $cache_key, $service_id ? $service_id : 'not_found', 'gary_theme', HOUR_IN_SECONDS );
    return $service_id;
}

function gary_format_duration( $seconds ) {
    if ( empty( $seconds ) || ! is_numeric( $seconds ) ) return '';
    $hours = round( (int) $seconds / 3600, 1 );
    if ( $hours <= 0 ) return '';
    return $hours . ' Hours';
}

function gary_clean_service_name( $name ) {
    if ( empty( $name ) ) return $name;
    $name = preg_replace( '/^.*? - /', '', $name );
    return ucwords( strtolower( $name ) );
}

function gary_get_manual_savings_fallback( $title ) {
    $title = strtolower( $title );
    $fallbacks = array(
        'story'           => 100,
        'ceremony'        => 50,
        'celebration'     => 100,
        'registry'        => 40,
        'the highlights'  => 150,
        'the journey'     => 150,
        'elopement'       => 100,
        'complete story'  => 500,
        'ultimate legacy' => 1200
    );
    foreach ( $fallbacks as $key => $val ) {
        if ( strpos( $title, $key ) !== false ) return $val;
    }
    return 0;
}
/**
 * Bundle Engine: Calculates savings and inclusions for compound services.
 */
function gary_get_sub_service_summary( $id, $is_post_id = true ) {
    if ( class_exists( 'GW_BooklyAddons\Lib\Utils' ) ) {
        $summary = \GW_BooklyAddons\Lib\Utils::getSubServiceSummary( $id, $is_post_id );
        $summary['included_str'] = implode( ', ', $summary['titles'] );
        return $summary;
    }

    global $wpdb;
    $bookly_id = $is_post_id ? gary_get_service_id_for_page( (int)$id ) : (int)$id;
    $post_id   = $is_post_id ? (int)$id : gary_get_page_id_for_service( $bookly_id );

    $bookly_data = gary_get_bookly_service_data( $bookly_id );
    $parent_price = $bookly_data ? (float)$bookly_data['price'] : 0;
    $parent_title = $bookly_data ? $bookly_data['title'] : '';

    $inc_titles = array();
    $inc_total_val = 0;
    $inc_total_duration = 0;
    $processed_ids = array();
    $inclusions = array();

    // 1. Native Bookly Compound Relations
    $table_sub = $wpdb->prefix . 'bookly_sub_services';
    if ( $bookly_id && $wpdb->get_var( "SHOW TABLES LIKE '$table_sub'" ) == $table_sub ) {
        $native_sub = $wpdb->get_results( $wpdb->prepare( "SELECT sub_service_id FROM $table_sub WHERE service_id = %d ORDER BY position ASC", $bookly_id ) );
        foreach ( $native_sub as $rel ) {
            $sub_data = gary_get_bookly_service_data( $rel->sub_service_id );
            if ( $sub_data && ! in_array( $rel->sub_service_id, $processed_ids ) ) {
                $processed_ids[] = $rel->sub_service_id;
                $inc_titles[] = $sub_data['title'];
                $inc_total_val += (float)$sub_data['price'];
                $inc_total_duration += (int)($sub_data['duration'] ?? 0);
            }
        }
    }

    // 2. Custom Editorial Inclusions (GW Addons)
    $table_inc = $wpdb->prefix . 'gw_bookly_service_inclusions';
    if ( $bookly_id && $wpdb->get_var( "SHOW TABLES LIKE '$table_inc'" ) == $table_inc ) {
        $db_inclusions = $wpdb->get_results( $wpdb->prepare( "SELECT included_id FROM $table_inc WHERE parent_id = %d ORDER BY position ASC", $bookly_id ) );
        foreach ( $db_inclusions as $db_inc ) {
            if ( in_array( $db_inc->included_id, $processed_ids ) ) continue;
            $sub_data = gary_get_bookly_service_data( $db_inc->included_id );
            if ( $sub_data ) {
                $processed_ids[] = $db_inc->included_id;
                $inc_titles[] = $sub_data['title'];
                $inc_total_val += (float)$sub_data['price'];
                $inc_total_duration += (int)($sub_data['duration'] ?? 0);
            }
        }
    }

    $retail_override = $post_id ? get_post_meta( $post_id, '_gary_retail_value_override', true ) : '';
    $retail_value = ! empty( $retail_override ) ? (float)$retail_override : $inc_total_val;
    $savings = $retail_value - $parent_price;

    if ( $savings <= 0 ) {
        $savings = gary_get_manual_savings_fallback( $parent_title );
    }

    return array(
        'titles'         => array_map( 'gary_clean_service_name', $inc_titles ),
        'total_value'    => $retail_value,
        'savings'        => $savings,
        'parent_price'   => $parent_price,
        'total_duration' => $inc_total_duration,
    );
}
