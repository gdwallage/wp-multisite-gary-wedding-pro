<?php
/**
 * Custom Shortcodes for Gary Wallage Wedding Pro
 */

function gary_featured_services_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'page_ids' => '', // e.g. "12, 15, 23"
        'show'     => 'included', // 'included' or 'paid'
    ), $atts, 'gary_featured_services' );

    $summary = gary_get_sub_service_summary( get_the_ID() );
    $grid_items = ($atts['show'] === 'paid') ? $summary['paid_addons'] : $summary['inclusions'];

    if ( empty( $grid_items ) ) {
        return '';
    }

    ob_start();
    ?>
    <div class="detailed-components-section is-condensed" style="margin-top: 20px;">
        <div class="condensed-service-grid">
            <?php foreach ( $grid_items as $item ) :
                $card_title = !empty($item['title']) ? $item['title'] : '';
                $card_desc  = !empty($item['info']) ? $item['info'] : '';
                $card_thumb = !empty($item['thumb']) ? $item['thumb'] : '';
                $unit_price = !empty($item['price']) ? (float)$item['price'] : 0;
                $is_free    = ($unit_price <= 0);

                // Fallback Image
                $logo_id = get_theme_mod( 'custom_logo' );
                $logo_url = $logo_id ? wp_get_attachment_image_url( $logo_id, 'full' ) : '';
                $final_thumb = $card_thumb ? $card_thumb : $logo_url;
            ?>
                <div class="condensed-service-card">
                    <div class="condensed-card-header" style="display:flex; align-items:center; gap:20px; margin-bottom:15px;">
                        <div class="condensed-coin">
                            <img src="<?php echo esc_url( $final_thumb ); ?>" alt="<?php echo esc_attr( $card_title ); ?>" />
                        </div>
                        <div class="condensed-title-wrap">
                            <h4 style="margin:0; font-family:var(--font-primary); text-transform:uppercase; letter-spacing:1px; font-size:1.1rem;"><?php echo esc_html( $card_title ); ?></h4>
                            <?php if ( $atts['show'] === 'included' ) : ?>
                                <div style="font-size:0.7rem; color:var(--brand-crimson); font-weight:700; letter-spacing:1px; margin-top:4px;">
                                    <?php if($unit_price > 0): ?><span style="text-decoration:line-through; opacity:0.5; margin-right:8px;">£<?php echo number_format($unit_price, 0); ?></span><?php endif; ?>
                                    INCLUDED
                                </div>
                            <?php else : ?>
                                <div style="font-size:0.85rem; color:var(--brand-gold-light); font-weight:700; margin-top:4px;">
                                    From £<?php echo number_format($unit_price, 0); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if ( !empty($card_desc) ) : ?>
                        <div class="condensed-description" style="font-size:0.9rem; line-height:1.6; opacity:0.8; border-top:1px solid #f9f9f9; padding-top:15px;">
                            <?php echo wp_kses_post( $card_desc ); ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'gary_featured_services', 'gary_featured_services_shortcode' );
