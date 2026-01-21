<?php
/**
 * File: page-faq.php
 * Template Name: FAQ
 * Theme: Gary Wallage Wedding Pro
 * Description: Automatically converts H3 + P tags in the content into an interactive accordion.
 */

get_header(); ?>

<main id="primary" class="site-main container" style="max-width:800px;">

    <header class="archive-header" style="text-align:center; margin-bottom:60px;">
        <span style="font-family:'Blacksword', serif; color:var(--wedding-accent); font-size:2rem;">Common Questions</span>
        <h1 class="entry-title" style="font-size:3.5rem; margin-top:10px;"><?php the_title(); ?></h1>
    </header>

    <?php while ( have_posts() ) : the_post(); ?>
        <div class="faq-content entry-content">
            <?php the_content(); ?>
        </div>
    <?php endwhile; ?>

</main>

<script>
// Simple script to turn H3s into Accordion Triggers
document.addEventListener('DOMContentLoaded', function() {
    const content = document.querySelector('.faq-content');
    if(!content) return;

    const headings = content.querySelectorAll('h3');
    
    headings.forEach(h3 => {
        h3.classList.add('faq-trigger');
        // Find the next element (the answer)
        let answer = h3.nextElementSibling;
        
        // Create wrapper
        const wrapper = document.createElement('div');
        wrapper.classList.add('faq-answer');
        
        // Move answer inside wrapper
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
