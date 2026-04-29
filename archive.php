<?php
/**
 * The template for displaying archive pages
 */

get_header();
?>

<main id="primary" class="site-main container-editorial" style="padding: 60px 20px;">

    <?php if ( have_posts() ) : ?>

        <header class="page-header" style="text-align: center; margin-bottom: 80px;">
            <?php
            the_archive_title( '<h1 class="blacksword-title" style="font-size: 3.5rem; color: var(--brand-accent);">', '</h1>' );
            the_archive_description( '<div class="archive-description lato-subtitle" style="max-width: 800px; margin: 20px auto; opacity: 0.8; letter-spacing: 1px; line-height: 1.6;">', '</div>' );
            ?>
        </header>

        <div class="archive-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 40px;">
            <?php
            while ( have_posts() ) :
                the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'archive-item' ); ?> style="background: #fff; border: 1px solid #eee; padding: 30px; transition: transform 0.3s ease;">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="post-thumbnail" style="margin-bottom: 20px; overflow: hidden;">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail( 'large', array( 'style' => 'width: 100%; height: auto; display: block; transform: scale(1.05); transition: transform 0.5s ease;' ) ); ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <header class="entry-header">
                        <h2 class="entry-title" style="font-size: 1.5rem; margin-bottom: 10px;">
                            <a href="<?php the_permalink(); ?>" rel="bookmark" style="text-decoration: none; color: #1a1a1a;"><?php the_title(); ?></a>
                        </h2>
                    </header>

                    <div class="entry-summary" style="opacity: 0.8; font-size: 0.95rem; line-height: 1.6; margin-bottom: 20px;">
                        <?php the_excerpt(); ?>
                    </div>

                    <footer class="entry-footer">
                        <a href="<?php the_permalink(); ?>" class="read-more-link" style="text-transform: uppercase; font-weight: 700; letter-spacing: 2px; font-size: 0.75rem; color: var(--brand-accent); text-decoration: none;">Explore Legacy &rarr;</a>
                    </footer>
                </article>
                <?php
            endwhile;

            the_posts_navigation( array(
                'prev_text' => '&larr; Prev',
                'next_text' => 'Next &rarr;',
            ) );

        else :
            get_template_part( 'template-parts/content', 'none' );
        endif;
        ?>
    </div>

</main>

<?php
get_footer();
