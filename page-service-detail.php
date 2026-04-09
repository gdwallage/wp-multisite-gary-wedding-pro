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

// --- LOGIC: SUB-SERVICE SUMMARY ---
$summary = gary_get_sub_service_summary( $post_id );
$grid_items         = $summary['grid_items'];
$final_total_value  = $summary['total_value'];
$final_savings      = $summary['savings'];
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

            <!-- Right: Investment Plaque -->
            <aside class="investment-sidebar" style="flex: 0 0 380px;">
                <div class="investment-plaque">
                    <h2>Estimated</h2>
                    <?php if($subtitle): ?><span class="subtitle"><?php echo esc_html($subtitle); ?></span><?php endif; ?>
                    
                    <div class="price-wrap">
                        <?php if ( $final_savings > 0 ) : ?>
                            <div style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; color: var(--brand-crimson); margin-bottom: 10px;">
                                Bundle Saving: £<?php echo number_format($final_savings, 0); ?>
                            </div>
                        <?php endif; ?>

                        <div class="price-val"><?php echo esc_html($display_price); ?></div>
                        
                        <?php if ( $final_savings > 0 ) : ?>
                            <div style="font-size: 0.75rem; opacity: 0.7; margin-top: 10px; font-weight: normal; font-family: 'Lato', sans-serif; text-transform: uppercase; letter-spacing: 1px;">
                                Combined Individual Value: £<?php echo number_format($final_total_value, 0); ?>
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
                        <a href="/booking/" class="btn-black" style="background:var(--brand-accent);">Book Consultation</a>
                    </div>
                </div>
            </aside>
        </div>

        <?php 
        // Render sub-services via shortcode
        echo do_shortcode('[gary_featured_services]'); 
        ?>

        <div style="margin-top: 80px; text-align: center;">
            <a href="/services/" style="text-transform:uppercase; letter-spacing:2px; font-size:0.8rem; color:var(--brand-gold-light); text-decoration:none; font-weight:700;">Back to top level packages &rarr;</a>
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
