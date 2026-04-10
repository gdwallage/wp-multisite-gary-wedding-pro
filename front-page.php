<?php
/**
 * File: front-page.php
 * Template Name: Front Page
 * Theme: Gary Wallage Wedding Pro
 * Version: 2.90.0
 * Description: Hero slider auto-built from primary menu pages.
 *              Each slide = a menu page's featured image, title, first H2, and link.
 */

get_header();

// ---------------------------------------------------------------
// BUILD SLIDES FROM PRIMARY MENU PAGES
// ---------------------------------------------------------------
$slides = array();

$menu_locations = get_nav_menu_locations();
if ( ! empty( $menu_locations['primary'] ) ) {
    $menu_items = wp_get_nav_menu_items( $menu_locations['primary'] );

    if ( $menu_items ) {
        foreach ( $menu_items as $item ) {
            // Only top-level items that link to a real page/post
            if ( $item->menu_item_parent != 0 ) continue;

            $page_id  = (int) $item->object_id;
            $page_url = $item->url ?: get_permalink( $page_id );
            $title    = $item->title ?: get_the_title( $page_id );

            // Featured image
            $thumb = get_the_post_thumbnail_url( $page_id, 'full' );
            if ( ! $thumb ) continue; // Skip pages without featured image

            // Extract first H2 from page content
            $subtitle = '';
            $post_obj = get_post( $page_id );
            if ( $post_obj ) {
                $content = apply_filters( 'the_content', $post_obj->post_content );
                if ( preg_match( '/<h2[^>]*>(.*?)<\/h2>/si', $content, $matches ) ) {
                    $subtitle = wp_strip_all_tags( $matches[1] );
                }
            }

            $slides[] = array(
                'img'      => $thumb,
                'title'    => $title,
                'subtitle' => $subtitle,
                'url'      => $page_url,
            );
        }
    }
}

// Fallback: if no menu slides, use the front page featured image itself
if ( empty( $slides ) && has_post_thumbnail() ) {
    $slides[] = array(
        'img'      => get_the_post_thumbnail_url( get_the_ID(), 'full' ),
        'title'    => get_the_title(),
        'subtitle' => get_the_excerpt(),
        'url'      => '',
    );
}
?>

<main id="primary" class="site-main home">

    <?php if ( ! empty( $slides ) ) : ?>
    <div class="hero-carousel-wrapper">
        <div class="hero-carousel">
            <?php foreach ( $slides as $index => $slide ) : ?>
                <?php
                $slide_tag   = ! empty( $slide['url'] ) ? 'a' : 'div';
                $slide_attrs = ! empty( $slide['url'] )
                    ? 'href="' . esc_url( $slide['url'] ) . '" aria-label="' . esc_attr( $slide['title'] ) . '"'
                    : '';
                ?>
                <<?php echo $slide_tag; ?> class="hero-slide hero-slide-link <?php echo $index === 0 ? 'active' : ''; ?>"
                    style="background-image: url('<?php echo esc_url( $slide['img'] ); ?>');"
                    <?php echo $slide_attrs; ?>>

                    <div class="hero-slide-content">
                        <div class="hero-title-box">
                            <?php if ( $index === 0 ) : ?>
                                <h1 class="hero-title"><?php echo esc_html( $slide['title'] ); ?></h1>
                            <?php else : ?>
                                <h2 class="hero-title"><?php echo esc_html( $slide['title'] ); ?></h2>
                            <?php endif; ?>
                            <?php if ( ! empty( $slide['subtitle'] ) ) : ?>
                                <p class="hero-subtitle"><?php echo esc_html( $slide['subtitle'] ); ?></p>
                            <?php endif; ?>
                            <?php if ( ! empty( $slide['url'] ) ) : ?>
                                <span class="hero-cta-hint">Explore &rarr;</span>
                            <?php endif; ?>
                        </div>
                    </div>

                </<?php echo $slide_tag; ?>>
            <?php endforeach; ?>
        </div>

        <?php if ( count( $slides ) > 1 ) : ?>
        <div class="carousel-nav">
            <button id="prevSlide" aria-label="Previous Slide">&larr;</button>
            <div class="carousel-dots">
                <?php foreach ( $slides as $i => $s ) : ?>
                    <button class="carousel-dot <?php echo $i === 0 ? 'active' : ''; ?>" data-index="<?php echo $i; ?>" aria-label="Go to slide <?php echo $i + 1; ?>"></button>
                <?php endforeach; ?>
            </div>
            <button id="nextSlide" aria-label="Next Slide">&rarr;</button>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <!-- Front Page Body Content -->
    <section class="home-intro container" style="margin-top:80px;">
        <?php
        wp_reset_postdata();
        if ( have_posts() ) :
            while ( have_posts() ) : the_post(); ?>
                <div class="entry-content" style="text-align:center;">
                    <?php the_content(); ?>
                </div>
            <?php endwhile;
        endif; ?>
    </section>

</main>

<style>
/* Slide links behave as block elements */
a.hero-slide-link { display: block; text-decoration: none; cursor: pointer; }
a.hero-slide-link:hover .hero-title-box { border-color: var(--brand-gold-light); }
a.hero-slide-link:hover .hero-cta-hint { opacity: 1; transform: translateX(4px); }

/* CTA hint */
.hero-cta-hint {
    display: inline-block; margin-top: 18px;
    font-family: var(--font-primary); font-size: 0.75rem;
    text-transform: uppercase; letter-spacing: 4px;
    color: var(--brand-gold-light); opacity: 0.7;
    transition: opacity 0.3s, transform 0.3s;
}

/* Dot navigation */
.carousel-nav {
    position: absolute; bottom: 20px; left: 0; right: 0;
    display: flex; align-items: center; justify-content: center; gap: 20px;
    z-index: 20;
}
.carousel-nav button#prevSlide,
.carousel-nav button#nextSlide {
    background: rgba(0,0,0,0.4); border: 1px solid rgba(197,160,89,0.6);
    color: var(--brand-gold-light); padding: 8px 18px; cursor: pointer;
    font-size: 1.1rem; transition: background 0.3s;
}
.carousel-nav button:hover { background: rgba(197,160,89,0.3); }
.carousel-dots { display: flex; gap: 8px; align-items: center; }
.carousel-dot {
    width: 8px; height: 8px; border-radius: 50%;
    background: rgba(255,255,255,0.4); border: none; cursor: pointer;
    transition: background 0.3s, transform 0.3s; padding: 0;
}
.carousel-dot.active { background: var(--brand-gold-light); transform: scale(1.4); }

/* Title box styling */
.hero-slide-content {
    position: absolute; inset: 0; display: flex;
    align-items: center; justify-content: center; z-index: 10;
}
.hero-title-box {
    background: rgba(26,26,26,0.65); backdrop-filter: blur(6px);
    border: 1px solid rgba(197,160,89,0.4);
    color: #fff; padding: 40px 60px; text-align: center;
    transition: border-color 0.3s;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const slides  = document.querySelectorAll('.hero-slide');
    const dots    = document.querySelectorAll('.carousel-dot');
    const prevBtn = document.getElementById('prevSlide');
    const nextBtn = document.getElementById('nextSlide');
    let current   = 0;
    let timer;

    function update(idx) {
        slides.forEach((s, i) => s.classList.toggle('active', i === idx));
        dots.forEach((d, i) => d.classList.toggle('active', i === idx));
        current = idx;
    }

    function next() { update((current + 1) % slides.length); }
    function prev() { update((current - 1 + slides.length) % slides.length); }

    function autoplay() {
        clearInterval(timer);
        timer = setInterval(next, 7000);
    }

    if (slides.length > 1) {
        if (nextBtn) nextBtn.addEventListener('click', () => { next(); autoplay(); });
        if (prevBtn) prevBtn.addEventListener('click', () => { prev(); autoplay(); });
        dots.forEach((dot, i) => dot.addEventListener('click', () => { update(i); autoplay(); }));
        autoplay();
    } else if (slides.length === 1) {
        slides[0].classList.add('active');
    }
});
</script>

<?php get_footer(); ?>
