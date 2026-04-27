<?php
/**
 * Shared Service Card Renderer for Gary Wallage Wedding Pro
 * Ensures 100% visual identity across Templates, Shortcodes, and Blocks.
 */

/**
 * Robust Data Lookup: Finds all necessary data for a service card.
 * @param mixed $id - Either a WordPress Page ID OR a Bookly Service ID.
 * @param string $source - 'page' or 'bookly'
 */
function gary_get_service_data_unified( $id, $source = 'page' ) {
    global $wpdb;
    $page_id = 0;
    $bookly_id = 0;

    if ( $source === 'page' ) {
        $page_id = (int) $id;
        $bookly_id = gary_get_service_id_for_page( $page_id );
    } else {
        $bookly_id = (int) $id;
        $page_id = gary_get_page_id_for_service( $bookly_id );
    }

    $b_data = gary_get_bookly_service_data( $bookly_id );
    if ( !$b_data ) return false;

    // Fetch Savings & Inclusions summary (v3000.1.0 Unified Engine)
    $summary = $page_id ? gary_get_sub_service_summary( $page_id, true ) : gary_get_sub_service_summary( $bookly_id, false );

    $thumbnail = $page_id ? get_the_post_thumbnail_url($page_id, 'gw-card-thumb') : '';

    return array(
        'title'      => gary_clean_service_name($b_data['title']),
        'price'      => $b_data['price'],
        'savings'    => !empty($summary['savings']) ? (float)$summary['savings'] : 0,
        'inclusions' => !empty($summary['titles']) ? $summary['titles'] : array(),
        'permalink'  => $page_id ? get_permalink($page_id) : '/booking/',
        'thumbnail'  => $thumbnail,
        'info'       => $b_data['info'],
        'is_free'    => (float)$b_data['price'] <= 0,
        'duration'   => $b_data['duration'],
        'icon'       => $page_id ? get_the_post_thumbnail_url($page_id, 'gw-service-icon') : ''
    );
}

function gary_render_service_card_html( $data ) {
    $item = wp_parse_args( $data, array(
        'title'      => '', 'price' => 0, 'savings' => 0, 'inclusions' => array(),
        'permalink' => '#', 'thumbnail' => '', 'info' => '', 'is_free' => false, 'duration' => 0,
        'show_inclusions_only' => false,
    ));

    $display_price = $item['is_free'] ? 'FREE' : '£' . number_format((float)$item['price'], 2);
    $display_duration = ($item['is_free'] || empty($item['duration'])) ? '' : 'Typically ' . gary_format_duration($item['duration']);
    
    $thumb_url = $item['thumbnail'];
    if ( !$thumb_url ) {
        $logo_id = get_theme_mod( 'custom_logo' );
        $thumb_url = $logo_id ? wp_get_attachment_image_url( $logo_id, 'gw-logo' ) : '';
    }

    ob_start(); ?>
    <a href="<?php echo esc_url($item['permalink']); ?>" class="service-card-link">
        <div class="service-card">
            <?php if ( (float)$item['savings'] > 0 && !$item['is_free'] ) : ?>
                <div class="service-card-ribbon">SAVING £<?php echo number_format((float)$item['savings'], 0); ?></div>
            <?php elseif ( $item['show_inclusions_only'] ) : ?>
                <div class="service-card-ribbon"><span>INCLUDED</span></div>
            <?php endif; ?>

            <div class="service-card-image">
                <?php if ( $thumb_url ) : ?>
                    <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr($item['title']); ?>" width="500" height="500" loading="lazy" />
                <?php else : ?>
                    <div class="fallback-placeholder">GW</div>
                <?php endif; ?>
            </div>

            <div class="service-card-content">
                <h2 class="service-card-title"><?php echo esc_html($item['title']); ?></h2>
                
                <div class="service-card-price <?php echo $item['is_free'] ? 'is-free' : ''; ?>">
                    <span><?php echo esc_html($display_price); ?></span>
                    <?php if( !$item['is_free'] && $display_duration ): ?>
                        <small class="duration-label"><?php echo esc_html($display_duration); ?></small>
                    <?php endif; ?>
                </div>

                <?php if ( ! empty( $item['inclusions'] ) ) : ?>
                    <ul class="gw-bullet-list is-inclusions">
                        <?php foreach ( $item['inclusions'] as $inc_title ) : ?>
                            <li><?php echo esc_html($inc_title); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <?php if ( !empty($item['info']) ) : ?>
                    <div class="service-card-inclusions">
                        <?php echo wp_kses_post( $item['info'] ); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </a>
    <?php
    return ob_get_clean();
}
