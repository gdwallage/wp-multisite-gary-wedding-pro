<?php
/**
 * File: page-about.php
 * Template Name: About Me
 * Theme: Gary Wallage Wedding Pro
 * Version: 3000.21.0
 * Description: Precision alignment and synced 3D Gold Frame for the portrait.
 */

get_header(); ?>

<main id="primary" class="site-main container page-template-page-about">

    <?php while ( have_posts() ) : the_post(); ?>
        
        <!-- Page Title Unified with Global Styles -->
        <h1 class="entry-title about-title"><?php the_title(); ?></h1>

        <div class="about-grid">
            <!-- Left: Portrait (Locked at 30% Width) -->
            <div class="about-image">
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="portrait-frame-wrapper">
                        <div class="portrait-frame">
                            <?php the_post_thumbnail('medium_large'); ?>
                            
                            <!-- Gold Plaque Integrated into Frame -->
                            <div class="frame-plaque">
                                <span>Your Photographer</span>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Right: Bio Content (Strict Top-Align via align-items: flex-start) -->
            <div class="about-content">
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>

                <!-- Personal Sign-off -->
                <div class="about-sig" style="margin-top:60px;">
                    <span style="font-family:'Blacksword'; font-size:2.8rem; color:var(--brand-accent);">Gary Wallage</span>
                </div>
            </div>
        </div>

    <?php endwhile; ?>

</main>

<?php get_footer(); ?>
