<?php
/**
 * Template Name: The Experience
 * Description: A premium wide layout to support alternating Z-pattern text and media blocks.
 * File: page-experience.php
 */

get_header(); ?>

<main id="primary" class="site-main page-template-page-experience">
    
    <!-- Hero / Title Section -->
    <header class="experience-header" style="text-align:center; padding: 40px 20px 0;">
        <h1 class="entry-title"><?php the_title(); ?></h1>
    </header>

    <div class="experience-content-wrapper" style="max-width:1200px; margin: 40px auto 80px; padding: 0 40px;">
        <?php
        while ( have_posts() ) :
            the_post();
            // Let Gutenberg Media & Text blocks naturally stretch and layout here.
            the_content();
        endwhile;
        ?>
    </div>

</main>

<?php get_footer(); ?>
