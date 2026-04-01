<?php
/**
 * Template Name: Service Detail
 * Description: For individual services, with a right-hand Bookly details dynamically sourced.
 * File: page-service-detail.php
 */

get_header(); ?>

<main id="primary" class="site-main container page-template-service-detail">
    
    <header class="entry-header" style="text-align:center; margin-bottom: 60px;">
        <h1 class="entry-title"><?php the_title(); ?></h1>
    </header>

    <div class="service-detail-layout" style="display:flex; flex-wrap:wrap; gap:60px; max-width:1200px; margin:0 auto 80px;">
        
        <!-- Left: Raw WP Content -->
        <div class="service-main-content" style="flex: 1; min-width:300px; font-size:1.1rem; line-height:1.8; color:var(--wedding-text);">
            <?php
            while ( have_posts() ) :
                the_post();
                the_content();
            endwhile;
            ?>
        </div>

        <!-- Right: Bookly Injection -->
        <aside class="service-sidebar" style="flex: 0 0 320px; min-width:300px;">
            <div class="bookly-sticky-box" style="position:sticky; top:40px; background:#fff; border:4px solid var(--wedding-gold-light); padding:40px 30px; box-shadow:0 10px 30px rgba(0,0,0,0.05); text-align:center;">
                
                <h3 style="font-family:'Blacksword', serif; font-size:2.5rem; color:var(--wedding-text); margin-bottom:10px; font-weight:normal;">Investment</h3>
                
                <?php
                // Get dynamic data
                $bookly_id = get_post_meta( get_the_ID(), '_gary_bookly_id', true );
                $bookly_data = gary_get_bookly_service_data( $bookly_id );
                
                $manual_price = get_post_meta( get_the_ID(), '_gary_service_price', true );
                $manual_dur   = get_post_meta( get_the_ID(), '_gary_service_duration', true );

                $display_price = '';
                $display_duration = '';
                $bookly_info = '';

                if ( $bookly_data ) {
                    if ( (float)$bookly_data['price'] <= 0 ) {
                        $display_price = 'FREE';
                    } else {
                        $display_price = 'From £' . number_format($bookly_data['price'], 0);
                    }
                    $display_duration = 'Typically ' . $bookly_data['duration'];
                    $bookly_info = isset($bookly_data['info']) ? $bookly_data['info'] : '';
                } else {
                    if ( !empty($manual_price) || $manual_price === '0' ) {
                        if ( $manual_price === '0' || strtolower($manual_price) === 'free' ) {
                            $display_price = 'FREE';
                        } else {
                            $clean_p = trim($manual_price);
                            $display_price = 'From ' . (strpos($clean_p, '£') === false && is_numeric($clean_p) ? '£' : '') . $clean_p;
                        }
                    } else {
                        $display_price = 'On Request';
                    }
                    if ( $manual_dur ) { $display_duration = 'Typically ' . $manual_dur; }
                }
                ?>
                
                <!-- Display Data -->
                <div style="font-size:2rem; font-weight:700; color:var(--wedding-text); margin: 20px 0;">
                    <?php echo esc_html($display_price); ?>
                </div>
                
                <?php if ( !empty($display_duration) ) : ?>
                <div style="margin-bottom:30px; opacity:0.8; font-family:'Lato', sans-serif; text-transform:uppercase; letter-spacing:2px; font-size:0.8rem;">
                    <?php echo esc_html($display_duration); ?>
                </div>
                <?php endif; ?>

                <?php if ( !empty($bookly_info) ) : ?>
                <div class="service-card-inclusions" style="padding:0; margin-bottom:30px;">
                    <?php echo wp_kses_post($bookly_info); ?>
                </div>
                <?php endif; ?>

                <?php if ( empty($bookly_data) && empty($manual_price) ) : ?>
                    <p style="opacity:0.7; font-size:0.9rem;">Please contact us for custom bespoke pricing details.</p>
                <?php endif; ?>

                <a href="/booking/" class="wedding-button" style="display:inline-block; margin-top:20px; padding:15px 30px; background:var(--wedding-text); color:#fff; text-decoration:none; text-transform:uppercase; font-family:'Lato', sans-serif; letter-spacing:2px; font-size:0.8rem; transition:0.3s; width:100%; box-sizing:border-box;">Book Consultation</a>
                
            </div>
        </aside>

    </div>

</main>

<style>
/* Local CSS overlay for sticky right rail */
@media (max-width: 900px) {
    .service-detail-layout { flex-direction: column; }
    .service-sidebar { width: 100%; min-width: unset !important; }
}
.wedding-button:hover { background: var(--wedding-gold-light) !important; color:#000 !important; }
</style>

<?php get_footer(); ?>
