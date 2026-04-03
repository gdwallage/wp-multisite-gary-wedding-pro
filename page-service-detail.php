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
 * LOGIC: SUB-SERVICE GRID (DATA-DRIVEN TAG PRIORITY)
 */
$grid_pages = array();

// 1. Check for Bookly Tags on current service
if ( !empty($bookly_data['tags']) ) {
    $tags = explode(',', $bookly_data['tags']);
    foreach ($tags as $tag_name) {
        $tag_name = trim($tag_name);
        if ( empty($tag_name) ) continue;
        
        // Find WP Page by this tag (Name Match)
        $matched_id = gary_find_page_by_bookly_title( $tag_name );
        if ( $matched_id && $matched_id != $post_id ) {
            $grid_pages[] = $matched_id;
        }
    }
}

// 2. Fallback to Manual Selections if no tags matched
// Stored values are now Bookly service IDs — resolve each to its linked WP page
if ( empty($grid_pages) ) {
    for ( $i = 1; $i <= 4; $i++ ) {
        $manual_bookly_id = get_post_meta( $post_id, '_gary_sub_service_' . $i, true );
        if ( empty($manual_bookly_id) ) continue;

        // Find the WP page that has this Bookly service ID set via the Bookly Link meta box
        $linked_pages = get_posts( array(
            'post_type'      => 'page',
            'posts_per_page' => 1,
            'meta_key'       => '_gary_bookly_id',
            'meta_value'     => $manual_bookly_id,
            'fields'         => 'ids',
            'post_status'    => 'publish',
        ) );

        if ( ! empty($linked_pages) && $linked_pages[0] != $post_id ) {
            $grid_pages[] = $linked_pages[0];
        }
    }
}

// Unique and filter
$grid_pages = array_unique($grid_pages);
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

        <?php if ( !empty($grid_pages) ) : ?>
        <!-- Section: Detailed Components Grid -->
        <div class="detailed-components-section">
            <h2 style="font-family:'Lato', sans-serif !important; font-size:2rem; font-weight:700;">Detailed Service Components</h2>
            
            <div class="component-grid">
                <?php 
                foreach($grid_pages as $sub_id) : 
                    $sub_post = get_post($sub_id);
                    if($sub_post) :
                        $thumb = get_the_post_thumbnail_url($sub_id, 'large');
                ?>
                    <a href="<?php echo get_permalink($sub_id); ?>" class="component-card">
                        <div class="coin-icon-wrap">
                            <img src="<?php echo $thumb ? esc_url($thumb) : 'data:image/svg+xml;utf8,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><rect width="100" height="100" fill="%23f0f0f0"/></svg>'; ?>" alt="<?php echo esc_attr($sub_post->post_title); ?> - Editorial Wedding Photography" />
                        </div>
                        <div class="component-info">
                            <h4><?php echo esc_html($sub_post->post_title); ?></h4>
                            <?php 
                            // Fetch Price for Slashed effect
                            $sub_bookly_id = get_post_meta($sub_id, '_gary_bookly_id', true);
                            $sub_data = gary_get_bookly_service_data($sub_bookly_id);
                            $sub_manual = get_post_meta($sub_id, '_gary_service_price', true);
                            $sub_price = '';
                            if($sub_data && $sub_data['price'] > 0) {
                                $sub_price = '£' . number_format($sub_data['price'], 0);
                            } elseif(!empty($sub_manual)) {
                                $sub_price = '£' . $sub_manual;
                            }
                            
                            if($sub_price) : ?>
                                <div style="font-size:0.8rem; margin-bottom:5px; letter-spacing:1px; color:var(--wedding-gold-light); font-weight:700;">
                                    <span style="text-decoration:line-through; opacity:0.5; margin-right:8px;"><?php echo esc_html($sub_price); ?></span>
                                    <span>INCLUDED</span>
                                </div>
                            <?php endif; ?>
                            <p><?php echo wp_trim_words($sub_post->post_content, 18); ?></p>
                        </div>
                    </a>
                <?php 
                    endif;
                endforeach; 
                ?>
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
