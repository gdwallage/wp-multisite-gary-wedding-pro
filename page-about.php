<?php
/**
 * File: page-about.php
 * Template Name: About Me
 * Theme: Gary Wallage Wedding Pro
 * Description: Split layout for bio and portrait.
 */

get_header(); ?>

<main id="primary" class="site-main container">

    <?php while ( have_posts() ) : the_post(); ?>
        
        <div class="about-grid">
            <!-- Left: Portrait -->
            <div class="about-image">
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="portrait-frame">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Right: Bio Content -->
            <div class="about-content">
                <span class="sub-heading" style="color:var(--wedding-accent);">The Photographer</span>
                <h1 class="entry-title" style="margin-top:10px; font-size:3rem;"><?php the_title(); ?></h1>
                
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>

                <div class="about-sig">
                    <!-- Placeholder for signature image if you have one -->
                    <span style="font-family:'Blacksword'; font-size:2rem; margin-top:20px; display:block;">Gary Wallage</span>
                </div>
            </div>
        </div>

    <?php endwhile; ?>

</main>

<?php get_footer(); ?>
