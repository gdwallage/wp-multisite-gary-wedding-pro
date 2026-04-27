<?php
/**
 * The template for displaying single Legacy Stories (Weddings/Cosplay)
 */
get_header(); ?>

<main class="site-main">
    <?php while ( have_posts() ) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            
            <!-- Full Width Hero Image if exists -->
            <?php if ( has_post_thumbnail() ) : ?>
                <div class="legacy-hero" style="height:70vh; width:100%; overflow:hidden;">
                    <?php the_post_thumbnail('gw-hero', array('style' => 'width:100%; height:100%; object-fit:cover;')); ?>
                </div>
            <?php endif; ?>

            <div class="container" style="max-width:800px; margin-top: -60px; background:#fff; padding:60px; position:relative; box-shadow:0 20px 40px rgba(0,0,0,0.05);">
                <header class="entry-header" style="text-align:center; margin-bottom:50px;">
                    <span style="text-transform:uppercase; letter-spacing:4px; font-size:0.7rem; color:var(--wedding-accent);">Visual Legacy Chapter</span>
                    <h1 class="entry-title" style="margin:15px 0; font-size:3.5rem;"><?php the_title(); ?></h1>
                    <div class="technical-meta" style="font-style:italic; font-size:0.85rem; color:#999;">
                        Technical Notes: Crafted with <?php echo get_post_meta(get_the_ID(), 'camera_gear', true) ?: 'Canon 5D Mark IV & EF Glass'; ?>
                    </div>
                </header>

                <div class="entry-content">
                    <?php the_content(); ?>
                </div>

                <footer class="entry-footer" style="margin-top:80px; padding-top:40px; border-top:1px solid #eee; text-align:center;">
                    <p style="font-style:italic;">Are you ready to document your next chapter in Wiltshire?</p>
                    <a href="<?php echo esc_url(home_url('/book-your-wedding-day/')); ?>" class="button" style="display:inline-block; background:var(--wedding-accent); color:#fff; padding:15px 35px; border-radius:30px; margin-top:20px;">Request a Consult</a>
                </footer>
            </div>

        </article>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>

