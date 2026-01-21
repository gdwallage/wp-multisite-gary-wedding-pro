<?php
/**
 * File: page-services.php
 * Template Name: Services
 * Theme: Gary Wallage Wedding Pro
 * Description: Centered layout optimized for pricing tables and package lists.
 */

get_header(); ?>

<main id="primary" class="site-main container">

    <header class="archive-header" style="text-align:center; margin-bottom:60px;">
        <span style="font-family:'Blacksword', serif; color:var(--wedding-accent); font-size:2rem;">Investment</span>
        <h1 class="entry-title" style="font-size:3.5rem; margin-top:10px;"><?php the_title(); ?></h1>
    </header>

    <?php while ( have_posts() ) : the_post(); ?>
        
        <div class="services-content entry-content">
            <?php the_content(); ?>
        </div>

        <div class="services-cta" style="text-align:center; margin-top:80px; padding:60px; background:#fff; border:1px solid #eee;">
            <h3>Ready to secure your date?</h3>
            <p>Let's start the conversation about your visual legacy.</p>
            <a href="/contact" class="button" style="margin-top:20px;">Enquire Now</a>
        </div>

    <?php endwhile; ?>

</main>

<?php get_footer(); ?>
