<?php
/**
 * Template Name: Service Detail
 * Description: High-fidelity Advanced Editorial layout with Data-Driven Tag Priority linking.
 * File: page-service-detail.php
 */

get_header(); ?>

<?php
$post_id = get_the_ID();
$bg_img = get_post_meta( $post_id, '_gary_service_bg_img', true );
$subtitle = get_post_meta( $post_id, '_gary_service_subtitle', true );
$highlights = get_post_meta( $post_id, '_gary_service_highlights', true );

// Bookly Data for Main Investment
$bookly_id = get_post_meta( $post_id, '_gary_bookly_id', true );
$bookly_data = gary_get_bookly_service_data( $bookly_id );
$manual_price = get_post_meta( $post_id, '_gary_service_price', true );
$manual_dur   = get_post_meta( $post_id, '_gary_service_duration', true );

$display_price = 'On Request';
$display_duration = '';
if ( $bookly_data ) {
    $display_price = ( (float)$bookly_data['price'] <= 0 ) ? 'FREE' : 'From £' . number_format($bookly_data['price'], 0);
    $display_duration = $bookly_data['duration'];
} elseif ( !empty($manual_price) ) {
    $display_price = 'From £' . $manual_price;
    $display_duration = $manual_dur;
}

/**
 * LOGIC: SUB-SERVICE GRID
 *
 * Each slot stores a Bookly service ID. We resolve it to a renderable item
 * via a three-tier lookup — nothing is silently dropped:
 *
 * Tier 1 → Find WP page where _gary_bookly_id = slot value (explicit link)
 * Tier 2 → Find WP page whose title matches the Bookly service title
 * Tier 3 → Render a card directly from Bookly data (no WP page needed)
 *
 * After manual slots, Bookly tags supplement the list (deduped).
 */
$grid_items  = array(); // array of arrays: [ type=>'page'|'bookly', ... ]
$seen_pages  = array(); // track page IDs already added
$seen_bookly = array(); // track Bookly IDs already added

// 1. Manual slot selections (slots 1–8) — ALWAYS run
for ( $i = 1; $i <= 8; $i++ ) {
    $slot_bookly_id = get_post_meta( $post_id, '_gary_sub_service_' . $i, true );
    if ( empty( $slot_bookly_id ) ) continue;
    if ( in_array( $slot_bookly_id, $seen_bookly ) ) continue; // skip exact duplicate slots
    $seen_bookly[] = $slot_bookly_id;

    // --- Tier 1: page linked via _gary_bookly_id meta ---
    $linked = get_posts( array(
        'post_type'      => 'page',
        'posts_per_page' => 1,
        'meta_key'       => '_gary_bookly_id',
        'meta_value'     => $slot_bookly_id,
        'fields'         => 'ids',
        'post_status'    => 'publish',
    ) );

    if ( ! empty( $linked ) && $linked[0] != $post_id && ! in_array( (int) $linked[0], $seen_pages ) ) {
        $seen_pages[]  = (int) $linked[0];
        $grid_items[]  = array( 'type' => 'page', 'page_id' => (int) $linked[0], 'bookly_id' => $slot_bookly_id );
        continue;
    }

    // --- Tier 2: page matched by Bookly service title ---
    $raw = gary_get_bookly_service_data( $slot_bookly_id );
    if ( $raw && ! empty( $raw['title'] ) ) {
        $title_match = gary_find_page_by_bookly_title( $raw['title'] );
        if ( $title_match && $title_match != $post_id && ! in_array( (int) $title_match, $seen_pages ) ) {
            $seen_pages[] = (int) $title_match;
            $grid_items[] = array( 'type' => 'page', 'page_id' => (int) $title_match, 'bookly_id' => $slot_bookly_id );
            continue;
        }
    }

    // --- Tier 3: no linked page found — render directly from Bookly data ---
    if ( $raw ) {
        $grid_items[] = array( 'type' => 'bookly', 'bookly_id' => $slot_bookly_id, 'data' => $raw );
    }
}

// 2. Bookly tag auto-detection — supplements manual selections
if ( ! empty( $bookly_data['tags'] ) ) {
    $tags = explode( ',', $bookly_data['tags'] );
    foreach ( $tags as $tag_name ) {
        $tag_name = trim( $tag_name );
        if ( empty( $tag_name ) ) continue;
        $matched_id = gary_find_page_by_bookly_title( $tag_name );
        if ( $matched_id && $matched_id != $post_id && ! in_array( (int) $matched_id, $seen_pages ) ) {
            $seen_pages[] = (int) $matched_id;
            $grid_items[] = array( 'type' => 'page', 'page_id' => (int) $matched_id, 'bookly_id' => null );
        }
    }
}

// --- CALCULATE CUMULATIVE VALUE & SAVINGS ---
$package_price_num = 0;
if ( $bookly_data ) {
    $package_price_num = (float) $bookly_data['price'];
} elseif ( ! empty( $manual_price ) ) {
    $package_price_num = (float) str_replace( array(',', '£'), '', $manual_price );
}

$total_included_value = 0;
foreach ( $grid_items as $item ) {
    $sub_p = 0;
    if ( $item['type'] === 'page' ) {
        // Resolve Bookly ID for price
        $sub_b_id = $item['bookly_id'] ?: get_post_meta( $item['page_id'], '_gary_bookly_id', true );
        $sub_b_data = $sub_b_id ? gary_get_bookly_service_data( $sub_b_id ) : false;
        if ( $sub_b_data ) {
            $sub_p = (float) $sub_b_data['price'];
        } else {
            $sub_m = get_post_meta( $item['page_id'], '_gary_service_price', true );
            $sub_p = (float) str_replace( array(',', '£'), '', $sub_m );
        }
    } else {
        // Bookly-only card
        $sub_p = (float) $item['data']['price'];
    }
    $total_included_value += $sub_p;
}

$final_total_value = $package_price_num + $total_included_value;
$final_savings     = $total_included_value;
?>

<main id="primary" class="site-main page-template-service-detail">

    <?php if ( $bg_img ) : ?>
        <div class="service-bg-layer" style="background-image: url('<?php echo esc_url($bg_img); ?>');"></div>
    <?php endif; ?>

    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        
        <header class="service-hero-header" style="text-align:center; margin-bottom: 80px;">
            <h1 class="entry-title"><?php the_title(); ?></h1>
            <p style="opacity:0.6; text-transform:uppercase; letter-spacing:3px; font-size:0.8rem; margin-top:10px;">Comprehensive collections designed to cover every nuance of your celebration</p>
        </header>

        <div class="service-hero-split" style="display:flex; gap:80px; align-items: flex-start; margin-bottom:100px;">
            
            <!-- Left: Intro & Highlights -->
            <div class="experience-intro-wrap" style="flex:1;">
                <div class="main-body-text" style="font-size:1.15rem; line-height:1.8; margin-bottom:40px;">
                    <?php while ( have_posts() ) : the_post(); the_content(); endwhile; ?>
                </div>

                <?php if ( !empty($highlights) ) : ?>
                    <h3 style="font-family:'Lato', sans-serif; font-size:1.1rem; text-transform:uppercase; letter-spacing:1px;">Your personalized experience includes:</h3>
                    <ul class="highlights-list">
                        <?php 
                        $lines = explode("\n", $highlights);
                        foreach($lines as $line) {
                            if (trim($line)) echo '<li>' . esc_html(trim($line)) . '</li>';
                        }
                        ?>
                    </ul>
                <?php endif; ?>
            </div>

            <!-- Right: Investment Plaque -->
            <aside class="investment-sidebar" style="flex: 0 0 380px;">
                <div class="investment-plaque">
                    <h2>Estimated</h2>
                    <?php if($subtitle): ?><span class="subtitle"><?php echo esc_html($subtitle); ?></span><?php endif; ?>
                    
                    <div class="price-wrap">
                        <div class="price-val"><?php echo esc_html($display_price); ?></div>
                        
                        <?php if ( $final_savings > 0 ) : ?>
                            <div style="font-size: 0.75rem; opacity: 0.7; margin-top: 10px; font-weight: normal; font-family: 'Lato', sans-serif;">
                                (Total Value if booked separately: £<?php echo number_format($final_total_value, 0); ?> &mdash; Save £<?php echo number_format($final_savings, 0); ?>)
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if($display_duration): ?>
                        <div class="duration-val" style="margin-bottom:20px;">
                            <img src="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23C5A059' viewBox='0 0 24 24'><path d='M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5s2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z'/></svg>" style="vertical-align:middle; margin-right:5px;"/>
                            TYPICALLY <?php echo esc_html($display_duration); ?>
                        </div>
                    <?php endif; ?>

                    <?php if($bookly_data && !empty($bookly_data['info'])): ?>
                        <div class="service-card-inclusions" style="text-align:left; border-top:1px solid #eee; padding-top:20px;">
                            <?php echo wp_kses_post($bookly_data['info']); ?>
                        </div>
                    <?php endif; ?>

                    <div class="investment-buttons">
                        <a href="#request" class="btn-black">Request Details</a>
                        <a href="/booking/" class="btn-black" style="background:var(--wedding-accent);">Book Consultation</a>
                    </div>
                </div>
            </aside>
        </div>

        <?php if ( ! empty( $grid_items ) ) : ?>
        <!-- Section: Detailed Components Grid -->
        <div class="detailed-components-section">
            <h2 style="font-family:'Lato', sans-serif !important; font-size:2rem; font-weight:700;">Detailed Service Components</h2>
            
            <div class="component-grid">
                <?php foreach ( $grid_items as $item ) :

                    // ── SHARED: resolve price, badge, description ──────────────────
                    if ( $item['type'] === 'page' ) {
                        $sub_page    = get_post( $item['page_id'] );
                        if ( ! $sub_page ) continue;
                        $card_title  = $sub_page->post_title;
                        $card_url    = get_permalink( $item['page_id'] );
                        $card_thumb  = get_the_post_thumbnail_url( $item['page_id'], 'large' );
                        // Get Bookly data: prefer item bookly_id, fall back to page meta
                        $b_id        = $item['bookly_id'] ?: get_post_meta( $item['page_id'], '_gary_bookly_id', true );
                        $b_data      = $b_id ? gary_get_bookly_service_data( $b_id ) : false;
                        $manual_p    = get_post_meta( $item['page_id'], '_gary_service_price', true );
                        // Description fallback chain
                        if ( $b_data && ! empty( $b_data['info'] ) ) {
                            $card_desc = wp_trim_words( wp_strip_all_tags( $b_data['info'] ), 20 );
                        } elseif ( ! empty( $sub_page->post_excerpt ) ) {
                            $card_desc = wp_trim_words( $sub_page->post_excerpt, 20 );
                        } else {
                            $card_desc = wp_trim_words( $sub_page->post_content, 20 );
                        }
                    } else {
                        // Bookly-only card — no linked WP page
                        $b_data      = $item['data'];
                        $card_title  = $b_data['title'];
                        $card_url    = '/booking/';
                        $card_thumb  = ! empty( $b_data['image'] ) ? $b_data['image'] : '';
                        $manual_p    = '';
                        $card_desc   = ! empty( $b_data['info'] ) ? wp_trim_words( wp_strip_all_tags( $b_data['info'] ), 20 ) : '';
                    }

                    // Price badge logic
                    $sub_price = '';
                    $is_free   = false;
                    if ( $b_data ) {
                        if ( (float) $b_data['price'] > 0 ) {
                            $sub_price = '£' . number_format( $b_data['price'], 0 );
                        } else {
                            $is_free = true;
                        }
                    } elseif ( ! empty( $manual_p ) ) {
                        $sub_price = '£' . $manual_p;
                    }

                    $svg_placeholder = 'data:image/svg+xml;utf8,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><rect width="100" height="100" fill="%23f0f0f0"/></svg>';
                ?>
                    <a href="<?php echo esc_url( $card_url ); ?>" class="component-card">
                        <div class="coin-icon-wrap">
                            <img src="<?php echo $card_thumb ? esc_url( $card_thumb ) : $svg_placeholder; ?>"
                                 alt="<?php echo esc_attr( $card_title ); ?> - Editorial Wedding Photography" />
                        </div>
                        <div class="component-info">
                            <h4><?php echo esc_html( $card_title ); ?></h4>
                            <?php if ( $sub_price ) : ?>
                                <div style="font-size:0.8rem; margin-bottom:8px; letter-spacing:1px; color:var(--wedding-gold-light); font-weight:700;">
                                    <span style="text-decoration:line-through; opacity:0.5; margin-right:8px;"><?php echo esc_html( $sub_price ); ?></span>
                                    <span>INCLUDED</span>
                                </div>
                            <?php elseif ( $is_free ) : ?>
                                <div style="font-size:0.75rem; margin-bottom:8px; letter-spacing:2px; font-weight:700; color:#fff; background:var(--wedding-crimson); display:inline-block; padding:3px 10px; border-radius:2px;">
                                    FREE &mdash; INCLUDED
                                </div>
                            <?php endif; ?>
                            <?php if ( $card_desc ) : ?>
                                <p style="margin-top:6px;"><?php echo esc_html( $card_desc ); ?></p>
                            <?php endif; ?>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <div style="margin-top: 80px; text-align: center;">
            <a href="/services/" style="text-transform:uppercase; letter-spacing:2px; font-size:0.8rem; color:var(--wedding-gold-light); text-decoration:none; font-weight:700;">Back to top level packages &rarr;</a>
        </div>

    </div>

</main>

<style>
@media (max-width: 900px) {
    .service-hero-split { flex-direction: column; }
    .investment-sidebar { width: 100%; flex: none; }
}
</style>

<?php get_footer(); ?>
