<?php
/**
 * File: front-page.php
 * Theme: Gary Wallage Wedding Pro
 * Version: 3001.4.0
 * Description: Orchestrator for the modular Hero Slider and Home Content.
 */

get_header(); ?>

<main id="primary" class="site-main home">

    <?php get_template_part( 'template-parts/content', 'hero-slider' ); ?>

    <section class="home-intro container">
        <?php while ( have_posts() ) : the_post(); the_content(); endwhile; ?>
    </section>

</main>

<?php get_footer(); ?>
