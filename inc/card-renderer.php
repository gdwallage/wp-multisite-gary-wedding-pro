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

    $thumbnail = $page_id ? get_the_post_thumbnail_url($page_id, 'large') : '';

    // Fallback: If no WP Page thumbnail, try to use the Bookly native attachment_id
    if ( !$thumbnail && !empty($b_data['attachment_id']) ) {
        $thumbnail = wp_get_attachment_image_url( $b_data['attachment_id'], 'large' );
    }

    return array(
        'title'      => gary_clean_service_name($b_data['title']),
        'price'      => $b_data['price'],
        'savings'    => !empty($summary['savings']) ? (float)$summary['savings'] : 0,
        'inclusions' => !empty($summary['titles']) ? $summary['titles'] : array(),
        'permalink'  => $page_id ? get_permalink($page_id) : '/booking/',
        'thumbnail'  => $thumbnail,
        'info'       => $b_data['info'],
        'is_free'    => (float)$b_data['price'] <= 0,
        'duration'   => (!empty($summary['total_duration'])) ? $summary['total_duration'] : ($b_data['duration'] ?: (($page_id ?: get_the_ID()) ? get_post_meta(($page_id ?: get_the_ID()), '_gary_service_duration', true) : ''))
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
        $thumb_url = $logo_id ? wp_get_attachment_image_url( $logo_id, 'full' ) : '';
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
                    <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr($item['title']); ?>" />
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
function gary_render_service_plaque_html( $data ) {
    $item = wp_parse_args( $data, array(
        'title' => '', 'price' => 0, 'savings' => 0, 'inclusions' => array(),
        'permalink' => '#', 'thumbnail' => '', 'is_free' => false, 'duration' => 0,
    ));

    // FINAL SAFETY: If duration is empty in the data payload, try to grab it from the current page
    if ( empty($item['duration']) && is_singular() ) {
        $manual_dur = get_post_meta( get_the_ID(), '_gary_service_duration', true );
        if ( $manual_dur ) {
            $item['duration'] = $manual_dur;
        }
    }

    $display_price = $item['is_free'] ? 'FREE' : '£' . number_format((float)$item['price'], 2);
    $formatted_dur = gary_format_duration($item['duration']);
    $duration_str  = '';
    
    if ( !$item['is_free'] && !empty($formatted_dur) ) {
        // If the user already typed 'Typically' in their override, don't double it
        if ( stripos($formatted_dur, 'Typically') !== false ) {
            $duration_str = $formatted_dur;
        } else {
            $duration_str = 'Typically ' . $formatted_dur;
        }
    }
    
    // Determine if it's a package or session based on savings/inclusions
    $is_pkg = !empty($item['inclusions']);
    $label = $is_pkg ? 'PACKAGE PRICE' : 'SERVICE PRICE';

    // Refine Title: Remove the word 'Package' (case insensitive) and trim
    $refined_title = preg_replace('/\bpackage\b/i', '', $item['title']);
    $refined_title = trim($refined_title);

    ob_start(); ?>
    <div class="investment-sidebar plaque-rendering-context" style="max-width: 420px; margin: 40px auto;">
        <div class="investment-plaque" style="position: relative; overflow: hidden; border: 2px solid var(--brand-gold-light); padding: 40px; background: #fff; box-shadow: var(--shadow-deep); text-align:center;">
            <?php if ( (float)$item['savings'] > 0 && !$item['is_free'] ) : ?>
                <div class="investment-savings-ribbon" style="top: 30px; right: -65px; width: 250px;">SAVE £<?php echo number_format($item['savings'], 0); ?></div>
            <?php endif; ?>
            
            <div class="price-wrap" style="padding-bottom: 20px; margin-bottom: 10px;">
                <div class="price-label" style="font-size:0.75rem; text-transform:uppercase; letter-spacing:2px; opacity:0.6; margin-bottom:15px; font-weight:700;">
                    <?php echo esc_html($label); ?>
                </div>
                
                <div class="price-val" style="font-size:4.2rem; font-family:var(--font-primary); font-weight:700; color:var(--brand-black); line-height:1; margin-bottom: 15px;">
                    <?php echo esc_html($display_price); ?>
                </div>

                <div class="package-name-sub" style="font-family:'Lato', sans-serif; font-size:0.9rem; text-transform:uppercase; letter-spacing:2px; opacity:0.9; font-weight:700; margin-bottom: 25px;">
                    <?php echo esc_html( $refined_title ); ?>
                </div>
                
                <?php if ( (float)$item['savings'] > 0 && !$item['is_free'] ) : ?>
                    <div class="investment-summary-box" style="background:#fbfbfb; border:1px solid #f0f0f0; padding:20px; margin:20px 0; text-align:left;">
                        <div style="display:flex; justify-content:space-between; font-size:0.7rem; text-transform:uppercase; letter-spacing:1px; margin-bottom:8px; opacity:0.8;">
                            <span>Bought Separately:</span>
                            <?php 
                            $total_val = (float)$item['price'] + (float)$item['savings'];
                            ?>
                            <span style="font-weight:700;">£<?php echo number_format($total_val, 2); ?></span>
                        </div>
                        <div style="display:flex; justify-content:space-between; font-size:0.7rem; text-transform:uppercase; letter-spacing:1px; color:var(--brand-crimson);">
                            <span>You Save:</span>
                            <span style="font-weight:700;">&mdash; £<?php echo number_format($item['savings'], 2); ?></span>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if($duration_str): ?>
                    <div class="duration-val" style="margin: 20px 0 20px 0; font-size:0.75rem; letter-spacing:1px; font-weight:700; opacity:0.7; text-transform:uppercase; display:flex; align-items:center; justify-content:center; color:var(--brand-black) !important;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#C5A059" viewBox="0 0 16 16" style="margin-right:10px; display:inline-block;">
                            <path d="M8 3.5a.5.5 0 0 0-1 0V8a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 7.71V3.5z"/>
                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                        </svg>
                        <?php echo esc_html($duration_str); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="investment-buttons" style="display:flex; flex-direction:column; gap:12px; margin-top: 0;">
                <a href="#request" class="btn-black" style="background:#000; color:#fff; text-decoration:none; text-align:center; padding:18px; text-transform:uppercase; letter-spacing:2px; font-size:0.85rem; font-weight:700;">Request Details</a>
                <a href="/booking/" class="btn-gold" style="background:var(--brand-gold-light); color:#fff; text-decoration:none; text-align:center; padding:18px; text-transform:uppercase; letter-spacing:2px; font-size:0.85rem; font-weight:700;">Book Consultation</a>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
