<?php
/**
 * File: page-reviews.php
 * Template Name: Client Reviews
 * Theme: Gary Wallage Wedding Pro
 * Description: Editorial Client Reviews & Testimonials Showcase.
 */

get_header(); ?>

<main id="primary" class="site-main container page-template-page-reviews" style="padding: 40px 0 80px;">

    <?php while ( have_posts() ) : the_post(); ?>
        
        <header class="archive-header" style="text-align:center; margin-bottom:50px;">
            <h1 class="entry-title" style="font-family:'Blacksword'; font-size:3.2rem; color:var(--brand-accent); margin-bottom:10px;"><?php the_title(); ?></h1>
            <p style="font-family:'Lato', sans-serif; font-size:1.1rem; letter-spacing:1px; text-transform:uppercase; opacity:0.8;">Kind Words from Cherished Clients</p>
        </header>

        <div class="entry-content reviews-content">
            <?php the_content(); ?>
        </div>

    <?php endwhile; ?>

</main>

<?php get_footer(); ?>
