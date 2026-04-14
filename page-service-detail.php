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
$is_free = false;
if ( $bookly_data ) {
    $is_free = ( (float)$bookly_data['price'] <= 0 );
    $display_price = $is_free ? 'FREE' : 'From £' . number_format($bookly_data['price'], 2);
    $display_duration = $is_free ? '' : gary_format_duration($bookly_data['duration']);
} elseif ( !empty($manual_price) ) {
    $is_free = ( strtolower($manual_price) === 'free' || $manual_price === '0' );
    $display_price = $is_free ? 'FREE' : 'From £' . number_format((float)$manual_price, 2);
    $display_duration = $is_free ? '' : $manual_dur;
}

// --- LOGIC: SUB-SERVICE SUMMARY ---
$summary = gary_get_sub_service_summary( $post_id );
$grid_items         = $summary['grid_items'];
$final_total_value  = $summary['total_value'];
$final_savings      = $summary['savings'];
$final_parent_price = isset($summary['parent_price']) ? $summary['parent_price'] : 0;
$included_titles_str = $summary['included_str'];
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

                <?php if ( ! empty( $summary['titles'] ) ) : ?>
                    <p style="font-family:'Lato', sans-serif; font-size:1rem; line-height:1.6; color:var(--brand-accent); font-weight:700; margin-bottom: 30px; border-left: 2px solid var(--brand-gold-light); padding-left: 15px;">
                        This collection includes: <?php echo esc_html( implode(', ', $summary['titles']) ); ?>
                    </p>
                <?php endif; ?>

                <?php if ( !empty($highlights) ) : ?>
                    <h3 style="font-family:'Lato', sans-serif; font-size:1.1rem; text-transform:uppercase; letter-spacing:1px;">The finer details of your day:</h3>
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

            <!-- Right: Investment Plaque (Redesigned for Transparency) -->
            <aside class="investment-sidebar" style="flex: 0 0 380px;">
                <div class="investment-plaque" style="position: relative; overflow: hidden; border: 2px solid var(--brand-gold-light); padding: 40px; background: #fff; box-shadow: var(--shadow-deep);">
                    <?php if ( $final_savings > 0 && !$is_free ) : ?>
                        <div class="investment-savings-ribbon" style="top: 30px; right: -65px; width: 250px;">SAVE £<?php echo number_format($final_savings, 0); ?></div>
                    <?php endif; ?>
                    
                    <?php if($subtitle): ?><span class="subtitle" style="display:block; text-transform:uppercase; letter-spacing:2px; font-size:0.75rem; opacity:0.6; margin-bottom:10px; font-weight:700;"><?php echo esc_html($subtitle); ?></span><?php endif; ?>
                    
                    <div class="price-wrap" style="padding-bottom: 20px; margin-bottom: 20px;">
                        <div class="price-label" style="font-size:0.75rem; text-transform:uppercase; letter-spacing:2px; opacity:0.6; margin-bottom:2px; font-weight:700;">Collection Price</div>
                        <div class="price-val" style="font-size:3rem; font-family:var(--font-primary); font-weight:700; color:var(--brand-black);">
                            <?php echo esc_html($display_price); ?>
                        </div>
                        
                        <?php if ( $summary['savings'] > 0 && !$is_free ) : ?>
                            <div class="investment-summary-box">
                                <div style="display:flex; justify-content:space-between; font-size:0.7rem; text-transform:uppercase; letter-spacing:1px; margin-bottom:8px; opacity:0.8;">
                                    <span>Bought Separately:</span>
                                    <span style="font-weight:700;">£<?php echo number_format($summary['total_value'], 2); ?></span>
                                </div>
                                <div style="display:flex; justify-content:space-between; font-size:0.7rem; text-transform:uppercase; letter-spacing:1px; margin-bottom:8px; color:var(--brand-crimson);">
                                    <span>Included Savings:</span>
                                    <span style="font-weight:700;">&mdash; £<?php echo number_format($summary['savings'], 2); ?></span>
                                </div>
                                <div style="display:flex; justify-content:space-between; font-size:0.75rem; text-transform:uppercase; letter-spacing:1px; font-weight:700; border-top:1px solid #ddd; padding-top:8px; color:var(--brand-black);">
                                    <span>Collection Total:</span>
                                    <span><?php echo esc_html($display_price); ?></span>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if($display_duration): ?>
                        <div class="duration-val" style="margin-bottom:20px; font-size:0.7rem; letter-spacing:1px; font-weight:700; opacity:0.7;">
                            <img src="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23C5A059' viewBox='0 0 24 24'><path d='M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5s2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z'/></svg>" style="vertical-align:middle; margin-right:8px;"/>
                            TYPICALLY <?php echo esc_html($display_duration); ?>
                        </div>
                    <?php endif; ?>

                    <div class="investment-buttons" style="display:flex; flex-direction:column; gap:8px;">
                        <a href="#request" class="btn-black" style="background:#000; color:#fff; text-decoration:none; text-align:center; padding:15px; text-transform:uppercase; letter-spacing:2px; font-size:0.8rem; font-weight:700;">Request Details</a>
                        
                        <?php 
                        $booking_sc = get_post_meta( get_the_ID(), '_gary_booking_shortcode', true );
                        if ( ! empty( $booking_sc ) ) : ?>
                            <div class="dynamic-booking-wrapper">
                                <?php echo do_shortcode( $booking_sc ); ?>
                            </div>
                        <?php else : ?>
                            <a href="/booking/" class="btn-black" style="background:var(--brand-accent); color:#fff; text-decoration:none; text-align:center; padding:15px; text-transform:uppercase; letter-spacing:2px; font-size:0.8rem; font-weight:700;">Book Consultation</a>
                        <?php endif; ?>
                    </div>
                </div>
            </aside>
        </div>

        <!-- Section 1: Included Services -->
        <div class="included-services-wrap" style="margin-top: 40px; border-top: 1px solid #eee; padding-top: 30px;">
            <h2 style="text-transform:uppercase; letter-spacing:2px; font-size:1.4rem; color:var(--brand-gold-light); margin-bottom:15px;">Included In This Collection</h2>
            <?php echo do_shortcode('[gary_featured_services show="included"]'); ?>
        </div>

        <!-- Section 2: Paid Add-Ons -->
        <div class="paid-addons-wrap" style="margin-top: 40px; border-top: 1px solid #eee; padding-top: 30px;">
            <h2 style="text-transform:uppercase; letter-spacing:2px; font-size:1.4rem; color:var(--brand-gold-light); margin-bottom:15px;">Available Add-Ons</h2>
            <?php echo do_shortcode('[gary_featured_services show="paid"]'); ?>
        </div>

        <div style="margin-top: 80px; text-align: center;">
            <a href="/services/" style="text-transform:uppercase; letter-spacing:2px; font-size:0.8rem; color:var(--brand-gold-light); text-decoration:none; font-weight:700;">Back to top level packages &rarr;</a>
        </div>

    </div>

</main>

<script>
/**
 * Boutique Visibility Guard (v3.9.3)
 * Ensures Bookly button text is forced to High-Contrast Black on load.
 */
function gary_enforce_booking_visibility() {
    const wrapper = document.querySelector('.dynamic-booking-wrapper');
    if (!wrapper) return;
    
    // Target all buttons and links within the wrapper
    const items = wrapper.querySelectorAll('button, a, .bookly-booking-button, .bookly-appointment-booking-button, .bookly-form-button, span');
    items.forEach(item => {
        // Absolute Background Lock
        item.style.setProperty('background', '#C5A059', 'important');
        item.style.setProperty('background-color', '#C5A059', 'important');
        
        // Absolute Typography Sync (Request Details match)
        item.style.setProperty('color', '#ffffff', 'important');
        item.style.setProperty('-webkit-text-fill-color', '#ffffff', 'important');
        item.style.setProperty('font-size', '0.8rem', 'important');
        item.style.setProperty('font-weight', '700', 'important');
        item.style.setProperty('letter-spacing', '2px', 'important');
        item.style.setProperty('text-transform', 'uppercase', 'important');
        item.style.setProperty('line-height', '1.2', 'important');
        
        // Stability Lock
        item.style.setProperty('opacity', '1', 'important');
        item.style.setProperty('visibility', 'visible', 'important');
        item.style.setProperty('border', 'none', 'important');
        item.style.setProperty('box-shadow', 'none', 'important');
        item.style.setProperty('padding', '15px', 'important');
        item.style.setProperty('min-height', '0', 'important');
        item.style.setProperty('display', 'flex', 'important');
        item.style.setProperty('align-items', 'center', 'important');
        item.style.setProperty('justify-content', 'center', 'important');
    });
}

// Pulse enforcement every 300ms for 3 seconds to catch Bookly's async injection
let gary_pulse_count = 0;
const gary_pulse = setInterval(() => {
    gary_enforce_booking_visibility();
    gary_pulse_count++;
    if (gary_pulse_count > 10) clearInterval(gary_pulse);
}, 300);

// Also run on DOMContentLoaded
document.addEventListener('DOMContentLoaded', gary_enforce_booking_visibility);
</script>

<style>
@media (max-width: 900px) {
    .service-hero-split { flex-direction: column; }
    .investment-sidebar { width: 100%; flex: none; }
}
</style>

<?php get_footer(); ?>
