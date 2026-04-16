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
    <div class="services-grid featured-shortcode-grid" style="margin-top: 20px;">
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
            
            // Link Mapping
            $permalink = !empty($item['page_id']) ? get_permalink($item['page_id']) : '/booking/';
        ?>
            <a href="<?php echo esc_url($permalink); ?>" class="service-card-link">
                <div class="service-card">
                    <?php if ( $atts['show'] === 'included' ) : ?>
                        <div class="service-card-ribbon"><span>INCLUDED</span></div>
                    <?php endif; ?>

                    <div class="service-card-image">
                        <img src="<?php echo esc_url( $final_thumb ); ?>" alt="<?php echo esc_attr( $card_title ); ?>" />
                    </div>

                    <div class="service-card-content">
                        <h2 class="service-card-title"><?php echo esc_html( gary_clean_service_name( $card_title ) ); ?></h2>
                        
                        <div class="service-card-price <?php echo $is_free ? 'is-free' : ''; ?>">
                            <?php if ( $atts['show'] === 'included' ) : ?>
                                <span style="text-decoration:line-through; opacity:0.5; font-size: 0.9rem; margin-right:10px;">£<?php echo number_format($unit_price, 0); ?></span>
                                <span>FREE</span>
                            <?php else : ?>
                                <span>From £<?php echo number_format($unit_price, 0); ?></span>
                            <?php endif; ?>
                        </div>

                        <?php if ( !empty($card_desc) ) : ?>
                            <div class="service-card-inclusions">
                                <?php echo wp_kses_post( $card_desc ); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'gary_featured_services', 'gary_featured_services_shortcode' );
