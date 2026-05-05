<?php
/**
 * The template for displaying 404 pages (not found)
 */

get_header();
?>

<main id="primary" class="site-main container-editorial" style="min-height: 60vh; display: flex; align-items: center; justify-content: center; text-align: center;">

    <section class="error-404 not-found">
        <header class="page-header">
            <h1 class="blacksword-title" style="font-size: 4rem; color: var(--brand-accent);">Lost in the Moment?</h1>
            <h2 class="lato-subtitle" style="letter-spacing: 4px; margin-bottom: 30px;">PAGE NOT FOUND</h2>
        </header>

        <div class="page-content" style="max-width: 600px; margin: 0 auto;">
            <p style="font-size: 1.1rem; opacity: 0.8; margin-bottom: 40px;">
                It seems the page you are looking for has slipped away. Perhaps it's been moved to a new gallery or archived in our visual legacy.
            </p>

            <div class="cta-group" style="display: flex; gap: 20px; justify-content: center;">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-gold" style="padding: 15px 30px; text-decoration: none; font-weight: 700; letter-spacing: 2px;">RETURN HOME</a>
                <a href="/services/" class="btn-black" style="padding: 15px 30px; background: #000; color: #fff; text-decoration: none; font-weight: 700; letter-spacing: 2px;">VIEW COLLECTIONS</a>
            </div>
        </div>
    </section>

</main>

<?php
get_footer();
