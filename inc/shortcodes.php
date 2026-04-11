<?php
/**
 * Custom Shortcodes for Gary Wallage Wedding Pro
 */

function gary_featured_services_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'page_ids' => '', // e.g. "12, 15, 23"
    ), $atts, 'gary_featured_services' );

    // If no specific page IDs provided, try and get them from the current page's sub-service slots
    $grid_items = array();

    if ( ! empty( $atts['page_ids'] ) ) {
        $ids = array_map( 'trim', explode( ',', $atts['page_ids'] ) );
        foreach ( $ids as $id ) {
            $id = (int) $id;
            if ( $id <= 0 ) continue;
            
            $b_id = get_post_meta( $id, '_gary_bookly_id', true );
            $grid_items[] = array( 
                'type' => 'page', 
                'page_id' => $id, 
                'bookly_id' => $b_id 
            );
        }
    } else {
        // Fallback to the current page's advanced editorial sub-service logic
        $summary = gary_get_sub_service_summary( get_the_ID() );
        $grid_items = $summary['grid_items'];
    }

    if ( empty( $grid_items ) ) {
        return '';
    }

    ob_start();
    ?>
    <div class="detailed-components-section" style="margin-top: 20px;">
        <div class="component-grid">
            <?php foreach ( $grid_items as $item ) :

                $card_title = !empty($item['title']) ? $item['title'] : '';
                $card_url   = !empty($item['page_url']) ? $item['page_url'] : '#';
                $card_thumb = !empty($item['thumb']) ? $item['thumb'] : '';
                $card_desc  = '';
                $b_data     = false;
                $manual_p   = '';

                // If we have a page_id, try to get more rich data
                if ( !empty($item['page_id']) && $item['page_id'] > 0 ) {
                    $sub_page = get_post($item['page_id']);
                    if ($sub_page) {
                        $card_title = $sub_page->post_title;
                        $card_url   = get_permalink($sub_page->ID);
                        if (!$card_thumb) $card_thumb = get_the_post_thumbnail_url($sub_page->ID, 'medium');
                        $manual_p   = get_post_meta($sub_page->ID, '_gary_service_price', true);
                        $card_desc  = !empty($sub_page->post_excerpt) ? $sub_page->post_excerpt : wp_trim_words(strip_shortcodes($sub_page->post_content), 20);
                    }
                }

                // Get Bookly data for price/info override
                $b_id = !empty($item['bookly_id']) ? $item['bookly_id'] : ( !empty($item['page_id']) ? get_post_meta($item['page_id'], '_gary_bookly_id', true) : false );
                if ($b_id) {
                    $b_data = gary_get_bookly_service_data($b_id);
                    if ($b_data) {
                        if (empty($card_title)) $card_title = $b_data['title'];
                        if (!empty($b_data['info'])) $card_desc = wp_trim_words(wp_strip_all_tags($b_data['info']), 20);
                    }
                }

                // Price badge logic
                $sub_price = '';
                $is_free   = false;
                if ( $b_data ) {
                    if ( (float) $b_data['price'] > 0 ) {
                        $sub_price = 'From £' . number_format( $b_data['price'], 0 );
                    } else {
                        $is_free = true;
                    }
                } elseif ( ! empty( $manual_p ) ) {
                    if ( strtolower(trim($manual_p)) === 'free' || trim($manual_p) === '0' ) {
                        $is_free = true;
                    } else {
                        $sub_price = 'From £' . $manual_p;
                    }
                }

                // Fallback Image Logic: Site Logo -> SVG
                $logo_id = get_theme_mod( 'custom_logo' );
                $logo_url = $logo_id ? wp_get_attachment_image_url( $logo_id, 'full' ) : '';
                
                $svg_raw = '<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><rect width="100" height="100" fill="#f0f0f0"/><path d="M50 30 L70 70 L30 70 Z" fill="#C5A059" opacity="0.3"/></svg>';
                $svg_fallback = 'data:image/svg+xml;base64,' . base64_encode($svg_raw);

                $final_thumb = $card_thumb ? $card_thumb : ( $logo_url ? $logo_url : $svg_fallback );
            ?>
                <a href="<?php echo esc_url( $card_url ); ?>" class="component-card">
                    <div class="coin-icon-wrap">
                        <img src="<?php echo esc_url( $final_thumb ); ?>"
                             alt="<?php echo esc_attr( $card_title ); ?>" />
                    </div>
                    <div class="component-info">
                        <h4><?php echo esc_html( $card_title ); ?></h4>
                        <?php if ( $sub_price ) : ?>
                            <div style="font-size:0.8rem; margin-bottom:8px; letter-spacing:1px; color:var(--brand-gold-light); font-weight:700;">
                                <span style="text-decoration:line-through; opacity:0.5; margin-right:8px;"><?php echo esc_html( $sub_price ); ?></span>
                                <span>INCLUDED</span>
                            </div>
                        <?php elseif ( $is_free ) : ?>
                            <div style="font-size:0.75rem; margin-bottom:8px; letter-spacing:2px; font-weight:700; color:#fff; background:var(--brand-crimson); display:inline-block; padding:3px 10px; border-radius:2px;">
                                FREE &mdash; INCLUDED
                            </div>
                        <?php endif; ?>
                        <?php if ( !empty($card_desc) ) : ?>
                            <p style="margin-top:6px;"><?php echo esc_html( $card_desc ); ?></p>
                        <?php endif; ?>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'gary_featured_services', 'gary_featured_services_shortcode' );
