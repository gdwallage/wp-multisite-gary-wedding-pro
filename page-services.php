<?php
/**
 * File: page-services.php
 * Template Name: Services
 * Theme: Gary Wallage Wedding Pro
 * Version: 4.2.0
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
                $is_free = ( (float)$item['price'] <= 0 );
                $display_price = $is_free ? 'FREE' : 'From £' . number_format($item['price'], 2);
                $display_duration = $is_free ? '' : 'Typically ' . gary_format_duration($item['duration']);
                
                $final_thumb = $item['thumbnail'];
                if ( !$final_thumb ) {
                    $logo_id = get_theme_mod( 'custom_logo' );
                    $thumb_url = $logo_id ? wp_get_attachment_image_url( $logo_id, 'full' ) : '';
                } else {
                    $thumb_url = $final_thumb;
                }
            ?>
                <a href="<?php echo esc_url($item['permalink']); ?>" class="service-card-link">
                    <div class="service-card">
                        <?php if ( $item['savings'] > 0 && !$is_free ) : ?>
                            <div class="service-card-ribbon">SAVING £<?php echo number_format($item['savings'], 0); ?></div>
                        <?php endif; ?>

                        <div class="service-card-image">
                            <?php if ( $thumb_url ) : ?>
                                <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr($item['clean_title']); ?> - Gary Wallage Editorial Wedding Photography" />
                            <?php else : ?>
                                <div class="fallback-placeholder">GW</div>
                            <?php endif; ?>
                        </div>

                        <div class="service-card-content">
                            <h2 class="service-card-title"><?php echo esc_html($item['clean_title']); ?></h2>
                            
                            <div class="service-card-price <?php echo $is_free ? 'is-free' : ''; ?>">
                                <span><?php echo esc_html($display_price); ?></span>
                                <?php if( !$is_free && $display_duration ): ?>
                                    <small class="duration-label"><?php echo esc_html($display_duration); ?></small>
                                <?php endif; ?>
                            </div>

                            <?php if ( ! empty( $item['sub_service_titles'] ) ) : ?>
                                <ul class="gw-bullet-list is-inclusions">
                                    <?php foreach ( $item['sub_service_titles'] as $inc_title ) : ?>
                                        <li><?php echo esc_html( $inc_title ); ?></li>
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
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- 2. INDIVIDUAL SERVICES SECTION -->
    <?php if ( ! empty( $individual ) ) : ?>
        <h2 class="section-divider-title" style="text-align:center; margin: 120px 0 60px; font-size: 2.2rem;">Individual Services</h2>
        <div class="services-grid">
            <?php foreach ( $individual as $item ) : 
                $is_free = ( (float)$item['price'] <= 0 );
                $display_price = $is_free ? 'FREE' : 'From £' . number_format($item['price'], 2);
                $display_duration = $is_free ? '' : 'Typically ' . gary_format_duration($item['duration']);
                
                $final_thumb = $item['thumbnail'];
                if ( !$final_thumb ) {
                    $logo_id = get_theme_mod( 'custom_logo' );
                    $thumb_url = $logo_id ? wp_get_attachment_image_url( $logo_id, 'full' ) : '';
                } else {
                    $thumb_url = $final_thumb;
                }
            ?>
                <a href="<?php echo esc_url($item['permalink']); ?>" class="service-card-link">
                    <div class="service-card">
                        <div class="service-card-image">
                            <?php if ( $thumb_url ) : ?>
                                <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr($item['clean_title']); ?> - Gary Wallage Editorial Wedding Photography" />
                            <?php else : ?>
                                <div class="fallback-placeholder">GW</div>
                            <?php endif; ?>
                        </div>

                        <div class="service-card-content">
                            <h2 class="service-card-title"><?php echo esc_html($item['clean_title']); ?></h2>
                            
                            <div class="service-card-price <?php echo $is_free ? 'is-free' : ''; ?>">
                                <span><?php echo esc_html($display_price); ?></span>
                                <?php if( !$is_free && $display_duration ): ?>
                                    <small class="duration-label"><?php echo esc_html($display_duration); ?></small>
                                <?php endif; ?>
                            </div>

                            <?php if ( !empty($item['info']) ) : ?>
                                <div class="service-card-inclusions">
                                    <?php echo wp_kses_post( $item['info'] ); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
