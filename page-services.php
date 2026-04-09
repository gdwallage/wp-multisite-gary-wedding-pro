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
                $highlights   = get_post_meta( get_the_ID(), '_gary_service_highlights', true );
                
                $display_price = '';
                $display_duration = '';
                $bookly_info = '';
                $is_free = false;

                if ( $bookly_data ) {
                    if ( (float)$bookly_data['price'] <= 0 ) {
                        $display_price = 'FREE';
                        $is_free = true;
                    } else {
                        $display_price = 'From £' . number_format($bookly_data['price'], 2);
                    }
                    $dur_sec = (int)$bookly_data['duration'];
                    $dur_h = round($dur_sec / 3600, 1);
                    $display_duration = 'Typically ' . $dur_h . ' Hours';
                    $bookly_info = isset($bookly_data['info']) ? $bookly_data['info'] : '';
                } else {
                    if ( !empty($manual_price) || $manual_price === '0' ) {
                        if ( $manual_price === '0' || strtolower($manual_price) === 'free' ) {
                            $display_price = 'FREE';
                            $is_free = true;
                        } else {
                            $clean_p = trim($manual_price);
                            $display_price = 'From ' . (strpos($clean_p, '£') === false && is_numeric($clean_p) ? '£' : '');
                            $display_price .= is_numeric($clean_p) ? number_format((float)$clean_p, 2) : $clean_p;
                        }
                    } else {
                        $display_price = 'On Request';
                    }
                    if ( $manual_dur ) { $display_duration = 'Typically ' . $manual_dur; }
                }

                $teaser = wp_trim_words( get_the_content(), 45 );
                $summary = gary_get_sub_service_summary( get_the_ID() );
                $card_savings = $summary['savings'];
                $card_included = $summary['included_str'];
            ?>

                <a href="<?php the_permalink(); ?>" class="service-card-link">
                    <div class="service-card">
                        <?php if ( $card_savings > 0 && ! $is_free ) : ?>
                            <div class="service-card-ribbon">SAVE £<?php echo number_format($card_savings, 2); ?></div>
                        <?php endif; ?>

                        <div class="service-card-image">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail('large', array('alt' => get_the_title() . ' - Gary Wallage Editorial Wedding Photography')); ?>
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
                                <?php if( ! $is_free && $display_duration ): ?>
                                    <small class="duration-label"><?php echo esc_html($display_duration); ?></small>
                                <?php endif; ?>
                            </div>

                            <?php if ( ! empty( $summary['titles'] ) ) : ?>
                                <ul class="card-included-items">
                                    <?php foreach ( $summary['titles'] as $inc_title ) : ?>
                                        <li><?php echo esc_html( $inc_title ); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>

                            <?php if ( !empty($bookly_info) ) : ?>
                                <div class="service-card-inclusions">
                                    <?php echo wp_kses_post( $bookly_info ); ?>
                                </div>
                            <?php endif; ?>

                            <?php if ( !empty($highlights) ) : ?>
                                <div class="service-card-highlights" style="margin-top: 20px; padding: 0 10px;">
                                    <ul style="list-style: none; padding: 0; margin: 0; font-family: 'Lato', sans-serif; font-size: 0.85rem; line-height: 1.7; color: var(--brand-text); opacity: 0.9;">
                                        <?php 
                                        $lines = explode("\n", $highlights);
                                        foreach($lines as $line) {
                                            if (trim($line)) {
                                                echo '<li style="margin-bottom: 5px; padding-left: 20px; position: relative;">';
                                                echo '<span style="position: absolute; left: 0; color: var(--brand-gold-light);">✓</span>';
                                                echo esc_html(trim($line));
                                                echo '</li>';
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </a>

            <?php endwhile;
            wp_reset_postdata();
        endif; ?>
    </div>

</main>

<?php get_footer(); ?>
