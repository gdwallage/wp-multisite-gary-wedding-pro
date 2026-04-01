<?php
/**
 * File: page-services.php
 * Template Name: Services
 * Theme: Gary Wallage Wedding Pro
 * Version: 1.78.0
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

    <div class="services-grid">
        <?php
        $args = array(
            'post_type'      => 'page',
            'posts_per_page' => -1,
            'post_parent'    => get_the_ID(),
            'order'          => 'ASC',
            'orderby'        => 'menu_order'
        );
        $parent = new WP_Query( $args );

        if ( $parent->have_posts() ) :
            while ( $parent->have_posts() ) : $parent->the_post(); 
                
                // Data Logic
                $bookly_id = get_post_meta( get_the_ID(), '_gary_bookly_id', true );
                $bookly_data = gary_get_bookly_service_data( $bookly_id );
                $manual_price = get_post_meta( get_the_ID(), '_gary_service_price', true );
                $manual_dur   = get_post_meta( get_the_ID(), '_gary_service_duration', true );
                
                $display_price = '';
                $display_duration = '';
                $bookly_info = '';
                $is_free = false;

                if ( $bookly_data ) {
                    if ( (float)$bookly_data['price'] <= 0 ) {
                        $display_price = 'FREE';
                        $is_free = true;
                    } else {
                        $display_price = 'From £' . number_format($bookly_data['price'], 0);
                    }
                    $display_duration = 'Typically ' . $bookly_data['duration'];
                    $bookly_info = isset($bookly_data['info']) ? $bookly_data['info'] : '';
                } else {
                    if ( !empty($manual_price) || $manual_price === '0' ) {
                        if ( $manual_price === '0' || strtolower($manual_price) === 'free' ) {
                            $display_price = 'FREE';
                            $is_free = true;
                        } else {
                            $clean_p = trim($manual_price);
                            $display_price = 'From ' . (strpos($clean_p, '£') === false && is_numeric($clean_p) ? '£' : '') . $clean_p;
                        }
                    } else {
                        $display_price = 'On Request';
                    }
                    if ( $manual_dur ) { $display_duration = 'Typically ' . $manual_dur; }
                }

                $teaser = wp_trim_words( get_the_content(), 30 );
            ?>

                <a href="<?php the_permalink(); ?>" class="service-card-link">
                    <div class="service-card">
                        <div class="service-card-image">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail('large'); ?>
                            <?php else : 
                                $logo_id = get_theme_mod( 'custom_logo' );
                                if ( $logo_id ) :
                                    echo wp_get_attachment_image( $logo_id, 'full', false, array( 'class' => 'fallback-logo' ) );
                                else :
                                    echo '<div class="fallback-placeholder">GW</div>';
                                endif;
                            endif; ?>
                        </div>

                        <div class="service-card-content">
                            <h2 class="service-card-title"><?php the_title(); ?></h2>
                            
                            <div class="service-card-price <?php echo $is_free ? 'is-free' : ''; ?>">
                                <span><?php echo esc_html($display_price); ?></span>
                                <?php if($display_duration): ?>
                                    <small class="duration-label"><?php echo esc_html($display_duration); ?></small>
                                <?php endif; ?>
                            </div>

                            <?php if ( !empty($bookly_info) ) : ?>
                                <div class="service-card-inclusions">
                                    <?php 
                                    // Bookly info may contain HTML lists. Output cleanly.
                                    echo wp_kses_post( $bookly_info ); 
                                    ?>
                                </div>
                            <?php endif; ?>

                            <div class="service-card-teaser">
                                <p><?php echo $teaser; ?></p>
                            </div>
                        </div>
                    </div>
                </a>

            <?php endwhile;
            wp_reset_postdata();
        endif; ?>
    </div>

</main>

<?php get_footer(); ?>
