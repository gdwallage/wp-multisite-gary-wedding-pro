<?php
/**
 * Builds hero slide data from top-level Primary Menu pages with a featured image.
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
    foreach ( $menu_items as $item ) {
        if ( (int) $item->menu_item_parent !== 0 ) continue; // top-level only
        if ( $item->object !== 'page' ) continue;
        $page_id = (int) $item->object_id;
        if ( ! has_post_thumbnail( $page_id ) ) continue; // silently skip

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
