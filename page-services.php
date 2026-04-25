<?php
/**
 * File: page-services.php
 * Template Name: Services
 * Theme: Gary Wallage Wedding Pro
 * Version: 3000.21.0
 * Description: Clean grid with strictly aligned page title and beveled frames.
 */

get_header(); ?>

<main id="primary" class="site-main container page-template-page-services">

    <!-- Strictly using Entry Title - No redundant wrapper -->
    <h1 class="entry-title"><?php the_title(); ?></h1>
    
    <?php if ( get_the_content() ) : ?>
        <div class="services-intro" style="max-width:850px; margin:0 auto 80px; opacity:0.8; text-align:center; font-size:1.15rem; line-height:1.8;">
            <?php the_content(); ?>
        </div>
    <?php endif; ?>

    <?php
    $grouped_services = gary_get_grouped_bookly_services();
    $packages = $grouped_services['packages'];
    $individual = $grouped_services['individual'];
    ?>

    <!-- 1. PACKAGES SECTION -->
    <?php if ( ! empty( $packages ) ) : ?>
        <h2 class="section-divider-title" style="text-align:center; margin: 100px 0 60px; font-size: 2.2rem;">Packages</h2>
        <div class="services-grid">
            <?php foreach ( $packages as $item ) : 
                echo gary_render_service_card_html( array(
                    'title'      => $item['clean_title'],
                    'price'      => $item['price'],
                    'savings'    => $item['savings'],
                    'inclusions' => $item['sub_service_titles'],
                    'permalink'  => $item['permalink'],
                    'thumbnail'  => $item['thumbnail'],
                    'info'       => $item['info'],
                    'is_free'    => ( (float)$item['price'] <= 0 ),
                    'duration'   => $item['duration']
                ));
            endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- 2. INDIVIDUAL SERVICES SECTION -->
    <?php if ( ! empty( $individual ) ) : ?>
        <h2 class="section-divider-title" style="text-align:center; margin: 120px 0 60px; font-size: 2.2rem;">Individual Services</h2>
        <div class="services-grid">
            <?php foreach ( $individual as $item ) : 
                echo gary_render_service_card_html( array(
                    'title'      => $item['clean_title'],
                    'price'      => $item['price'],
                    'savings'    => $item['savings'],
                    'inclusions' => $item['sub_service_titles'],
                    'permalink'  => $item['permalink'],
                    'thumbnail'  => $item['thumbnail'],
                    'info'       => $item['info'],
                    'is_free'    => ( (float)$item['price'] <= 0 ),
                    'duration'   => $item['duration']
                ));
            endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
