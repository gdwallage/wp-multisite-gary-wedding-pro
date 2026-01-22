<?php
/**
 * File: page-faq.php
 * Template Name: FAQ
 * Theme: Gary Wallage Wedding Pro
 * Version: 1.42.0
 * Description: Clean accordion layout. Turns H3 into triggers.
 */

get_header(); ?>

<main id="primary" class="site-main container" style="max-width:800px;">

    <header class="archive-header" style="text-align:center; margin-bottom:60px;">
        <!-- Clean Title (Blacksword font handled by global CSS) -->
        <h1 class="entry-title"><?php the_title(); ?></h1>
    </header>

    <?php while ( have_posts() ) : the_post(); ?>
        <div class="faq-content entry-content">
            <?php the_content(); ?>
        </div>
    <?php endwhile; ?>

</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const content = document.querySelector('.faq-content');
    if(!content) return;

    const headings = content.querySelectorAll('h3');
    
    headings.forEach(h3 => {
        h3.classList.add('faq-trigger');
        let answer = h3.nextElementSibling;
        const wrapper = document.createElement('div');
        wrapper.classList.add('faq-answer');
        
        if(answer) {
            h3.parentNode.insertBefore(wrapper, answer);
            wrapper.appendChild(answer);
        }

        h3.addEventListener('click', () => {
            h3.classList.toggle('active');
            wrapper.classList.toggle('open');
        });
    });
});
</script>

<?php get_footer(); ?>
