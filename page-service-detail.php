<?php
/**
 * Template Name: Service Detail
 * Description: High-fidelity Advanced Editorial layout with Data-Driven Tag Priority linking.
 * File: page-service-detail.php
 */

get_header(); ?>

<?php
$post_id = get_the_ID();
$bg_img    = get_post_meta( $post_id, '_gary_service_bg_img', true );
$subtitle  = get_post_meta( $post_id, '_gary_service_subtitle', true );
$highlights = get_post_meta( $post_id, '_gary_service_highlights', true );

// --- HARDENED BOOKLY RESOLUTION (v3000.10.0) ---
// Use the same resolver as service cards: GW Addons table first, legacy meta fallback.
$bookly_id   = gary_get_service_id_for_page( $post_id );
$bookly_data = gary_get_bookly_service_data( $bookly_id );
$manual_price = get_post_meta( $post_id, '_gary_service_price', true );
$manual_dur   = get_post_meta( $post_id, '_gary_service_duration', true );

$display_price    = 'On Request';
$display_duration = '';
$is_free          = false;

if ( $bookly_data ) {
    $is_free          = ( (float)$bookly_data['price'] <= 0 );
    $display_price    = $is_free ? 'FREE' : '£' . number_format( (float)$bookly_data['price'], 2 );
    $display_duration = ( $is_free || empty($bookly_data['duration']) ) ? '' : gary_format_duration( $bookly_data['duration'] );
} elseif ( !empty( $manual_price ) ) {
    $is_free          = ( strtolower($manual_price) === 'free' || $manual_price === '0' );
    $display_price    = $is_free ? 'FREE' : '£' . number_format( (float)$manual_price, 2 );
    $display_duration = $is_free ? '' : $manual_dur;
}

// --- UNIFIED SAVINGS ENGINE (same as service cards) ---
// Merges native Bookly compound sub-services + custom GW Addons inclusions.
$summary            = gary_get_sub_service_summary( $post_id );
$grid_items         = $summary['grid_items'];
$final_total_value  = $summary['total_value'];
$final_savings      = $summary['savings'];
$final_parent_price = isset($summary['parent_price']) ? $summary['parent_price'] : 0;
$included_titles_str = $summary['included_str'];

// If we still don't have a price from Bookly but summary found a parent_price, use that
if ( $display_price === 'On Request' && $final_parent_price > 0 ) {
    $display_price = '£' . number_format( $final_parent_price, 2 );
    $is_free = false;
}

// --- COMPOUND DURATION OVERRIDE ---
// If the service has sub-services, sum their durations instead of using parent's single duration.
if ( !empty($summary['grid_items']) && $summary['total_duration'] > 0 ) {
    $display_duration = gary_format_duration( $summary['total_duration'] );
}

// --- SERVICE TYPE FLAG ---
// Atomic = single stand-alone session.  Package = compound (has sub-services).
$is_package = !empty( $summary['grid_items'] );
?>

<main id="primary" class="site-main page-template-service-detail">

    <?php if ( $bg_img ) : ?>
        <div class="service-bg-layer" style="background-image: url('<?php echo esc_url($bg_img); ?>');"></div>
    <?php endif; ?>

    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        
        <header class="service-hero-header" style="text-align:center; margin-bottom: 30px; margin-top: 0;">
            <h1 class="entry-title"><?php echo esc_html( gary_clean_service_name( get_the_title() ) ); ?></h1>
        </header>

        <div class="service-hero-single-column">
            
            <!-- Left: Intro area (Editorial Blocks) -->
            <div class="experience-intro-wrap" style="flex:1;">
                <div class="main-body-text" style="font-size:1.15rem; line-height:1.8; margin-bottom:40px;">
                    <?php while ( have_posts() ) : the_post(); the_content(); endwhile; ?>
                </div>


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

            </div>
        </div>


        <!-- Bottom Section Placeholder (Sub-services now immediately follow main split) -->

        <div style="margin-top: 80px; text-align: center;">
            <a href="/services/" style="text-transform:uppercase; letter-spacing:2px; font-size:0.8rem; color:var(--brand-gold-light); text-decoration:none; font-weight:700;">Back to top level packages and Individual Services &rarr;</a>
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
    .service-hero-split { flex-direction: column-reverse; gap: 40px !important; }
    .investment-sidebar { width: 100%; flex: none; margin-bottom: 40px; }
    .service-hero-header { margin-bottom: 40px !important; }
    .entry-title { font-size: 2.2rem !important; }
}
</style>

<?php get_footer(); ?>
