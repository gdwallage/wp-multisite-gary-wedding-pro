<?php get_header(); ?>

<main id="primary" class="site-main container">
    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="margin-bottom:120px;">
                <header class="entry-header" style="margin-bottom:40px; text-align:center;">
                    <?php if ( is_singular() ) : ?>
                        <h1 class="entry-title" style="font-size:3rem;"><?php the_title(); ?></h1>
                    <?php else : ?>
                        <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <?php endif; ?>
                </header>

                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    <?php else : ?>
        <p>No content found.</p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>

