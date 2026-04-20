<?php
/**
 * Custom Shortcodes for Gary Wallage Wedding Pro
 */

function gary_featured_services_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'page_ids' => '', 
        'show'     => 'included', 
    ), $atts, 'gary_featured_services' );

    $cards_html = '';

    if ( !empty($atts['page_ids']) ) {
        // Mode 1: Show specific pages as cards
        $ids = explode(',', $atts['page_ids']);
        foreach ($ids as $id) {
            $id = trim($id);
            if (!$id) continue;
            
            $card_data = gary_get_service_data_unified($id, 'page');
            if (!$card_data) continue;

            $cards_html .= gary_render_service_card_html( $card_data );
        }
    } else {
        // Mode 2: Show inclusions/addons of CURRENT page
        $summary = gary_get_sub_service_summary( get_the_ID() );
        $grid_items = ($atts['show'] === 'paid') ? (isset($summary['paid_addons']) ? $summary['paid_addons'] : array()) : (isset($summary['inclusions']) ? $summary['inclusions'] : array());
        
        if ( is_array($grid_items) && !empty($grid_items) ) {
            foreach ($grid_items as $item) {
                 // For sub-items, we already have the title/price, but we use the unified helper 
                 // to ensure consistent formatting.
                 $sub_id = !empty($item['bookly_id']) ? $item['bookly_id'] : 0;
                 $card_data = gary_get_service_data_unified($sub_id, 'bookly');
                 
                 if ($card_data) {
                    if ($atts['show'] === 'included') $card_data['show_inclusions_only'] = true;
                    $cards_html .= gary_render_service_card_html( $card_data );
                 }
            }
        }
    }

    if ( empty( $cards_html ) ) return '';

    return '<div class="services-grid featured-shortcode-grid" style="margin-top: 20px;">' . $cards_html . '</div>';
}
add_shortcode( 'gary_featured_services', 'gary_featured_services_shortcode' );
