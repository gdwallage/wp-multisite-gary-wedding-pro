<?php
/**
 * File: front-page.php
 * Template Name: Front Page
 * Theme: Gary Wallage Wedding Pro
 * Version: 3.1.0
 * Description: Peek carousel — active slide centred & fully visible, adjacent pages
 *              peek in from left/right. Data source: Customiser page-picker (falls
 *              back to Primary Menu pages if nothing is selected).
 */

get_header();

// ---------------------------------------------------------------
// HELPER: build one slide array from a page ID
// ---------------------------------------------------------------
function gw_slide_from_page_id( $page_id ) {
    $page_id = (int) $page_id;
    if ( $page_id < 1 ) return null;
    $post_obj = get_post( $page_id );
    if ( ! $post_obj || $post_obj->post_status !== 'publish' ) return null;

    $thumb    = get_the_post_thumbnail_url( $page_id, 'large' );
    $subtitle = '';
    if ( $post_obj ) {
        $content = apply_filters( 'the_content', $post_obj->post_content );
        if ( preg_match( '/<h2[^>]*>(.*?)<\/h2>/si', $content, $matches ) ) {
            $subtitle = wp_strip_all_tags( $matches[1] );
        }
        // Fallback to excerpt
        if ( ! $subtitle ) {
            $subtitle = get_the_excerpt( $page_id );
        }
    }

    return array(
        'img'      => $thumb,           // may be false — placeholder shown instead
        'title'    => get_the_title( $page_id ),
        'subtitle' => $subtitle,
        'url'      => get_permalink( $page_id ),
        'page_id'  => $page_id,
    );
}

// ---------------------------------------------------------------
// BUILD SLIDE LIST — Customiser page picker first, then menu fallback
// ---------------------------------------------------------------
$slides = array();

$customiser_count = (int) get_theme_mod( 'hero_slider_count', 3 );
// Clamp to valid values
if ( ! in_array( $customiser_count, array( 3, 5, 7, 9 ) ) ) $customiser_count = 3;

for ( $i = 1; $i <= $customiser_count; $i++ ) {
    $page_id = (int) get_theme_mod( "hero_slide_page_{$i}", 0 );
    if ( $page_id > 0 ) {
        $slide = gw_slide_from_page_id( $page_id );
        if ( $slide ) $slides[] = $slide;
    }
}

// Fallback: Primary Menu top-level pages (any, with or without featured image)
if ( empty( $slides ) ) {
    $menu_locations = get_nav_menu_locations();
    if ( ! empty( $menu_locations['primary'] ) ) {
        $menu_items = wp_get_nav_menu_items( $menu_locations['primary'] );
        if ( $menu_items ) {
            foreach ( $menu_items as $item ) {
                if ( $item->menu_item_parent != 0 ) continue;
                $slide = gw_slide_from_page_id( (int) $item->object_id );
                if ( $slide ) $slides[] = $slide;
            }
        }
    }
}

// Last-resort fallback: front page featured image or placeholder
if ( empty( $slides ) ) {
    $slides[] = array(
        'img'      => get_the_post_thumbnail_url( get_the_ID(), 'large' ) ?: false,
        'title'    => get_bloginfo( 'name' ),
        'subtitle' => get_bloginfo( 'description' ),
        'url'      => '',
    );
}

$slide_count = count( $slides );
?>

<main id="primary" class="site-main home">

<?php if ( ! empty( $slides ) ) : ?>

<div class="hero-peek-carousel" id="heroPeekCarousel" data-count="<?php echo $slide_count; ?>">

    <!-- Track -->
    <div class="hero-peek-track" id="heroPeekTrack">
        <?php foreach ( $slides as $index => $slide ) :
            $pos_class = 'hidden';
            if ( $index === 0 )                     $pos_class = 'active';
            elseif ( $index === 1 )                 $pos_class = 'next';
            elseif ( $index === $slide_count - 1 )  $pos_class = 'prev';
        ?>
        <div class="hero-peek-slide <?php echo $pos_class; ?>"
             data-index="<?php echo $index; ?>"
             data-url="<?php echo esc_url( $slide['url'] ); ?>">

            <?php if ( $slide['img'] ) : ?>
                <img class="hero-peek-img" src="<?php echo esc_url( $slide['img'] ); ?>"
                     alt="<?php echo esc_attr( $slide['title'] ); ?>" loading="<?php echo $index === 0 ? 'eager' : 'lazy'; ?>" />
            <?php else : ?>
                <div class="hero-peek-placeholder">
                    <span class="hero-peek-placeholder-icon">◆</span>
                </div>
            <?php endif; ?>

            <div class="hero-peek-caption">
                <?php if ( $index === 0 ) : ?>
                    <h1 class="hero-peek-title"><?php echo esc_html( $slide['title'] ); ?></h1>
                <?php else : ?>
                    <h1 class="hero-peek-title"><?php echo esc_html( $slide['title'] ); ?></h1>
                <?php endif; ?>
                <?php if ( ! empty( $slide['subtitle'] ) ) : ?>
                    <p class="hero-peek-subtitle"><?php echo esc_html( wp_trim_words( $slide['subtitle'], 12 ) ); ?></p>
                <?php endif; ?>
                <?php if ( ! empty( $slide['url'] ) && $slide['page_id'] != get_option('page_on_front') ) : ?>
                    <span class="hero-peek-cta">Explore <span aria-hidden="true">→</span></span>
                <?php endif; ?>
            </div>

        </div>
        <?php endforeach; ?>
    </div><!-- /.hero-peek-track -->

    <!-- Navigation -->
    <?php if ( $slide_count > 1 ) : ?>
    <div class="hero-peek-nav" role="navigation" aria-label="Slide navigation">
        <button class="hero-peek-arrow hero-peek-prev" id="heroPeekPrev" aria-label="Previous slide">&#8592;</button>
        <div class="hero-peek-dots" role="list">
            <?php foreach ( $slides as $i => $s ) : ?>
                <button class="hero-peek-dot <?php echo $i === 0 ? 'active' : ''; ?>"
                        data-index="<?php echo $i; ?>"
                        role="listitem"
                        aria-label="Go to slide <?php echo $i + 1; ?>"><?php echo $i + 1; ?></button>
            <?php endforeach; ?>
        </div>
        <button class="hero-peek-arrow hero-peek-next" id="heroPeekNext" aria-label="Next slide">&#8594;</button>
    </div>
    <?php endif; ?>

</div><!-- /.hero-peek-carousel -->

<?php endif; ?>

    <!-- Front Page Body Content -->
    <section class="home-intro" style="margin-top:0;">
        <?php
        wp_reset_postdata();
        if ( have_posts() ) :
            while ( have_posts() ) : the_post(); ?>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            <?php endwhile;
        endif; ?>
    </section>

</main>

<style>
/* ================================================================
   PEEK CAROUSEL — Layout & Styles
   ================================================================ */

/* Home intro section — full width by default, inner blocks constrain themselves */
.home-intro { width: 100%; margin-top: 0; }
.home-intro .entry-content > *:not(.gw-trust-bar):not(.wp-block-gw-trust-bar) { 
    max-width: var(--site-max-width); 
    width: var(--editorial-width); 
    margin-left: auto; 
    margin-right: auto; 
}

.hero-peek-carousel {
    position: relative;
    width: 100%;
    background: #11110e;
    padding: 0;
    overflow: hidden;
    user-select: none;
    margin-top: 0;
    z-index: 5;
}

/* Track — the horizontal container all slides sit inside */
.hero-peek-track {
    position: relative;
    width: 100%;
    height: 80vh;
    min-height: 550px;
    display: flex;
    align-items: stretch;
    justify-content: center;
    background: #11110e;
}

/* Every slide is absolute so they layer on top of each other */
.hero-peek-slide {
    position: absolute;
    top: 0; bottom: 0;
    overflow: hidden;
    border-radius: 3px;
    cursor: pointer;
    transition: width 0.55s cubic-bezier(0.4,0,0.2,1),
                left 0.55s cubic-bezier(0.4,0,0.2,1),
                right 0.55s cubic-bezier(0.4,0,0.2,1),
                opacity 0.55s ease,
                transform 0.55s cubic-bezier(0.4,0,0.2,1),
                box-shadow 0.55s ease;
}

/* ---- Position States ---- */

.hero-peek-slide.active {
    width: 30%;
    left: 35%;
    transform: none;
    opacity: 1;
    z-index: 10;
    box-shadow: 0 40px 100px rgba(0,0,0,0.9);
    cursor: default;
}

/* Inner Peeks — absolutely flush with 35%-65% center */
.hero-peek-slide.prev {
    width: 25%;
    left: 10%;
    right: auto;
    transform: none;
    opacity: 0.5;
    z-index: 5;
    cursor: pointer;
}

.hero-peek-slide.next {
    width: 25%;
    left: 65%;
    transform: none;
    opacity: 0.5;
    z-index: 5;
    cursor: pointer;
}

/* Outer Peeks — absolutely flush with inner peeks */
.hero-peek-slide.far-prev {
    width: 20%;
    left: -10%;
    opacity: 0.2;
    z-index: 2;
    pointer-events: none;
}
.hero-peek-slide.far-next {
    width: 20%;
    left: 90%;
    opacity: 0.2;
    z-index: 2;
    pointer-events: none;
}

/* Fully hidden (all others) */
.hero-peek-slide.hidden {
    opacity: 0;
    pointer-events: none;
    z-index: 1;
    width: 10%;
    left: 50%;
    transform: translateX(-50%) scale(0.8);
}

/* Hover effects on side peeks */
.hero-peek-slide.prev:hover,
.hero-peek-slide.next:hover {
    opacity: 0.85;
}

/* ---- Image — fully contained, never cropped ---- */
.hero-peek-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    display: block;
    background: transparent !important;
}

/* ---- Placeholder (no featured image) ---- */
.hero-peek-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, var(--brand-black) 0%, #2d2410 50%, var(--brand-black) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
}
.hero-peek-placeholder-icon {
    font-size: 4rem;
    color: var(--brand-gold-light);
    opacity: 0.4;
}

/* ---- Caption overlay (active slide only) ---- */
.hero-peek-caption {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    background: linear-gradient(to top, rgba(17,17,14,0.95) 0%, rgba(17,17,14,0.6) 60%, transparent 100%);
    padding: 50px 40px 65px;
    text-align: center;
    opacity: 0;
    transition: opacity 0.4s ease 0.2s;
    pointer-events: none;
}
.hero-peek-slide.active .hero-peek-caption {
    opacity: 1;
    pointer-events: auto;
    cursor: pointer;
}

.hero-peek-title {
    font-family: var(--font-script) !important;
    font-size: 2.8rem !important;
    font-weight: normal !important;
    color: #fff !important;
    margin: 0 0 8px !important;
    text-shadow: 0 2px 15px rgba(0,0,0,0.6);
    line-height: 1.1 !important;
}
.hero-peek-subtitle {
    font-family: var(--font-primary);
    font-size: 0.78rem;
    text-transform: uppercase;
    letter-spacing: 3px;
    color: rgba(255,255,255,0.75);
    margin: 0 0 14px;
}
.hero-peek-cta {
    display: inline-block;
    font-family: var(--font-primary);
    font-size: 0.72rem;
    text-transform: uppercase;
    letter-spacing: 4px;
    color: var(--brand-gold-light);
    border: 1px solid rgba(197,160,89,0.5);
    padding: 8px 20px;
    transition: background 0.3s, border-color 0.3s;
}
.hero-peek-slide.active .hero-peek-caption:hover .hero-peek-cta {
    background: rgba(197,160,89,0.15);
    border-color: var(--brand-gold-light);
}

/* ---- Navigation bar ---- */
.hero-peek-nav {
    position: absolute;
    bottom: 18px;
    left: 0; right: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 18px;
    z-index: 20;
}



.hero-peek-arrow {
    background: rgba(0,0,0,0.45);
    border: 1px solid rgba(197,160,89,0.5);
    color: var(--brand-gold-light);
    width: 40px; height: 40px;
    border-radius: 50%;
    font-size: 1rem;
    cursor: pointer;
    transition: background 0.3s, border-color 0.3s;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.hero-peek-arrow:hover {
    background: rgba(197,160,89,0.25);
    border-color: var(--brand-gold-light);
}

.hero-peek-dots {
    display: flex;
    gap: 8px;
    align-items: center;
}
.hero-peek-dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    background: rgba(255,255,255,0.35);
    border: none;
    cursor: pointer;
    font-size: 0;           /* hide the number text visually */
    padding: 0;
    transition: background 0.3s, transform 0.3s;
}
.hero-peek-dot.active {
    background: var(--brand-gold-light);
    transform: scale(1.5);
}

/* ---- Responsive ---- */
@media (max-width: 900px) {
    .hero-peek-track { height: 35vh; min-height: 260px; }
    .hero-peek-slide.active { width: 100%; left: 0; box-shadow: none; border-radius: 0; }
    .hero-peek-slide.prev, .hero-peek-slide.next, .hero-peek-slide.far-prev, .hero-peek-slide.far-next, .hero-peek-slide.hidden { display: none; }
    .hero-peek-caption { padding: 25px; background: rgba(17,17,14,0.8); backdrop-filter: blur(5px); }
    .hero-peek-title { font-size: 1.8rem; }
    .hero-peek-subtitle { display: none; }
}
@media (max-width: 768px) {
    .hero-peek-track { height: 300px; }
}
@media (max-width: 480px) {
    .hero-peek-track { height: 240px; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const carousel  = document.getElementById('heroPeekCarousel');
    if ( ! carousel ) return;

    const slides    = Array.from( carousel.querySelectorAll('.hero-peek-slide') );
    const dots      = Array.from( carousel.querySelectorAll('.hero-peek-dot') );
    const prevBtn   = document.getElementById('heroPeekPrev');
    const nextBtn   = document.getElementById('heroPeekNext');
    const total     = slides.length;
    let current     = 0;
    let timer       = null;

    // Position classes in order rel to active
    const CLASSES = ['active', 'next', 'far-next', 'hidden', 'far-prev', 'prev'];

    function getClass( relativeIndex ) {
        // relativeIndex: 0 = active, 1 = next, -1 = prev, 2 = far-next, -2 = far-prev
        if ( relativeIndex === 0 )       return 'active';
        if ( relativeIndex === 1 )       return 'next';
        if ( relativeIndex === -1 )      return 'prev';
        if ( relativeIndex === 2 )       return 'far-next';
        if ( relativeIndex === -2 )      return 'far-prev';
        return 'hidden';
    }

    function update( idx ) {
        current = ( idx + total ) % total;

        slides.forEach( function( slide, i ) {
            // Calculate shortest circular relative position
            let rel = i - current;
            if ( rel > total / 2 )  rel -= total;
            if ( rel < -total / 2 ) rel += total;

            slide.className = 'hero-peek-slide ' + getClass( rel );
        });

        dots.forEach( function( dot, i ) {
            dot.classList.toggle( 'active', i === current );
        });
    }

    function next() { update( current + 1 ); }
    function prev() { update( current - 1 ); }

    function startAutoplay() {
        clearInterval( timer );
        timer = setInterval( next, 7000 );
    }
    function stopAutoplay() {
        clearInterval( timer );
    }

    // Arrow buttons
    if ( prevBtn ) prevBtn.addEventListener( 'click', function() { prev(); startAutoplay(); } );
    if ( nextBtn ) nextBtn.addEventListener( 'click', function() { next(); startAutoplay(); } );

    // Dot buttons
    dots.forEach( function( dot, i ) {
        dot.addEventListener( 'click', function() { update( i ); startAutoplay(); } );
    });

    // Clicking a side-peek slide advances to it
    slides.forEach( function( slide, i ) {
        slide.addEventListener( 'click', function( e ) {
            if ( slide.classList.contains('prev') || slide.classList.contains('next') ||
                 slide.classList.contains('far-prev') || slide.classList.contains('far-next') ) {
                e.preventDefault();
                update( i );
                startAutoplay();
            } else if ( slide.classList.contains('active') ) {
                // Navigate to the page
                const url = slide.dataset.url;
                if ( url ) window.location.href = url;
            }
        });
    });

    // Keyboard navigation
    document.addEventListener( 'keydown', function( e ) {
        if ( e.key === 'ArrowLeft' )  { prev(); startAutoplay(); }
        if ( e.key === 'ArrowRight' ) { next(); startAutoplay(); }
    });

    // Pause on hover
    carousel.addEventListener( 'mouseenter', stopAutoplay );
    carousel.addEventListener( 'mouseleave', startAutoplay );

    // Touch swipe
    let touchStartX = 0;
    carousel.addEventListener( 'touchstart', function( e ) { touchStartX = e.touches[0].clientX; }, { passive: true });
    carousel.addEventListener( 'touchend', function( e ) {
        const diff = touchStartX - e.changedTouches[0].clientX;
        if ( Math.abs( diff ) > 50 ) {
            if ( diff > 0 ) next(); else prev();
            startAutoplay();
        }
    });

    // Init
    update( 0 );
    if ( total > 1 ) startAutoplay();
});
</script>

<?php get_footer(); ?>
