<?php
/**
 * Builds hero slide data from top-level Primary Menu pages with a featured image.
 * Resiliently handles both core page menu items and custom link items pointing to local pages.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function gary_get_hero_slides() {
    $locations = get_nav_menu_locations();
    if ( empty( $locations['primary'] ) ) return array();

    $menu_items = wp_get_nav_menu_items( $locations['primary'] );
    if ( ! $menu_items ) return array();

    $slides = array();
    $seen_page_ids = array();

    foreach ( $menu_items as $item ) {
        if ( (int) $item->menu_item_parent !== 0 ) continue; // top-level only

        $page_id = 0;
        if ( $item->object === 'page' ) {
            $page_id = (int) $item->object_id;
        } elseif ( ! empty( $item->url ) ) {
            // For custom links pointing to local pages (e.g. /experience or https://domain.com/experience)
            $url_path = parse_url( $item->url, PHP_URL_PATH );
            if ( is_string( $url_path ) ) {
                $parsed_path = trim( $url_path, '/' );
                if ( $parsed_path ) {
                    $matched_page = get_page_by_path( $parsed_path );
                    if ( $matched_page && $matched_page->post_status === 'publish' ) {
                        $page_id = $matched_page->ID;
                    }
                }
            }
        }

        if ( ! $page_id || isset( $seen_page_ids[ $page_id ] ) ) continue;
        if ( ! has_post_thumbnail( $page_id ) ) continue; // silently skip pages without featured image

        $seen_page_ids[ $page_id ] = true;

        $content = get_post_field( 'post_content', $page_id );
        $subtitle = '';
        if ( preg_match( '/<h2[^>]*>(.*?)<\/h2>/is', $content, $m ) ) {
            $subtitle = wp_strip_all_tags( $m[1] );
        }

        $slides[] = array(
            'title'    => get_the_title( $page_id ),
            'subtitle' => $subtitle,
            'image'    => get_the_post_thumbnail_url( $page_id, 'full' ),
            'url'      => get_permalink( $page_id ),
        );
    }
    return $slides;
}
