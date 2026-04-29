<?php
/**
 * File: front-page.php
 * Theme: Gary Wallage Wedding Pro
 * Version: 3000.87.0
 * Description: Minimalist Hero Slider + Gutenberg Content.
 */

get_header();

$slides = array();
$count = (int) get_theme_mod( 'hero_slider_count', 3 );
for ( $i = 1; $i <= $count; $i++ ) {
    $pid = (int) get_theme_mod( "hero_slide_page_{$i}", 0 );
    if ( $pid > 0 ) {
        $slides[] = array(
            'img_id'   => get_post_thumbnail_id( $pid ),
            'title'    => get_the_title( $pid ),
            'subtitle' => get_the_excerpt( $pid ),
            'url'      => get_permalink( $pid )
        );
    }
}
$slide_count = count( $slides );
?>

<main id="primary" class="site-main home">

    <?php if ( ! empty( $slides ) ) : ?>
    <div class="hero-peek-carousel" id="heroPeekCarousel">
        <div class="hero-peek-track" id="heroPeekTrack">
            <?php foreach ( $slides as $idx => $s ) : 
                $class = ($idx === 0) ? 'active' : (($idx === 1) ? 'next' : (($idx === $slide_count - 1) ? 'prev' : 'hidden'));
            ?>
            <div class="hero-peek-slide <?php echo $class; ?>" data-index="<?php echo $idx; ?>" data-url="<?php echo esc_url( $s['url'] ); ?>">
                <?php echo wp_get_attachment_image( $s['img_id'], 'gw-hero', false, array( 'class' => 'hero-peek-img' ) ); ?>
                <div class="hero-peek-caption">
                    <h1 class="hero-peek-title"><?php echo esc_html( $s['title'] ); ?></h1>
                    <?php if ( $s['subtitle'] ) : ?>
                        <p class="hero-peek-subtitle"><?php echo esc_html( wp_trim_words( $s['subtitle'], 12 ) ); ?></p>
                    <?php endif; ?>
                    <span class="hero-peek-cta">Explore <span aria-hidden="true">→</span></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <?php if ( $slide_count > 1 ) : ?>
        <div class="hero-peek-nav">
            <button id="heroPeekPrev" class="hero-peek-arrow">&#8592;</button>
            <div class="hero-peek-dots">
                <?php for($i=0; $i<$slide_count; $i++): ?>
                    <button class="hero-peek-dot <?php echo $i===0?'active':''; ?>" data-index="<?php echo $i; ?>"><?php echo $i+1; ?></button>
                <?php endfor; ?>
            </div>
            <button id="heroPeekNext" class="hero-peek-arrow">&#8594;</button>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <section class="home-intro container">
        <?php while ( have_posts() ) : the_post(); the_content(); endwhile; ?>
    </section>

</main>

<?php get_footer(); ?>
