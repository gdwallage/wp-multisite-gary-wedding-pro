<?php
/**
 * File: front-page.php
 * Theme: Gary Wallage Wedding Pro
 * Version: 3001.5.0
 * Description: Orchestrator for the modular Hero Slider and Home Content.
 */

get_header();

$gw_slides = function_exists( 'gary_get_hero_slides' ) ? gary_get_hero_slides() : array();
?>

<?php if ( ! empty( $gw_slides ) ) : ?>
<section class="hero-peek-carousel" id="heroPeekCarousel">
    <div class="hero-peek-track">
        <?php foreach ( $gw_slides as $i => $slide ) : ?>
        <a href="<?php echo esc_url( $slide['url'] ); ?>"
           class="hero-peek-slide<?php echo $i === 0 ? ' active' : ''; ?>"
           data-title="<?php echo esc_attr( $slide['title'] ); ?>"
           data-subtitle="<?php echo esc_attr( $slide['subtitle'] ); ?>"
           data-cta="View"
           data-url="<?php echo esc_url( $slide['url'] ); ?>">
            <?php
            if ( ! empty( $slide['thumb_id'] ) ) {
                echo wp_get_attachment_image( $slide['thumb_id'], 'gw-hero-mobile', false, array(
                    'class'         => 'hero-peek-img',
                    'sizes'         => '(max-width: 600px) 384px, (max-width: 1024px) 680px, 860px',
                    'loading'       => $i === 0 ? 'eager' : 'lazy',
                    'fetchpriority' => $i === 0 ? 'high' : 'auto',
                    'decoding'      => 'async',
                ) );
            } else {
                ?>
                <img class="hero-peek-img" src="<?php echo esc_url( $slide['image'] ); ?>" alt="<?php echo esc_attr( $slide['title'] ); ?>" width="683" height="1024" <?php echo $i === 0 ? 'fetchpriority="high" loading="eager"' : 'loading="lazy"'; ?> decoding="async" />
                <?php
            }
            ?>
        </a>
        <?php endforeach; ?>
    </div>

    <div class="hero-peek-caption-stable" id="heroCaptionStage">
        <h1 class="hero-peek-title"><?php echo esc_html( $gw_slides[0]['title'] ); ?></h1>
        <p class="hero-peek-subtitle"><?php echo esc_html( $gw_slides[0]['subtitle'] ); ?></p>
        <a class="hero-peek-cta" href="<?php echo esc_url( $gw_slides[0]['url'] ); ?>">View</a>
    </div>

    <button class="carousel-nav prev" id="heroPeekPrev" aria-label="Previous slide">&#8249;</button>
    <button class="carousel-nav next" id="heroPeekNext" aria-label="Next slide">&#8250;</button>

    <div class="carousel-dots">
        <?php foreach ( $gw_slides as $i => $slide ) : ?>
        <span class="carousel-dot hero-peek-dot<?php echo $i === 0 ? ' active' : ''; ?>"></span>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<main id="primary" class="site-main home">
    <section class="home-intro container">
        <?php while ( have_posts() ) : the_post(); the_content(); endwhile; ?>
    </section>
</main>

<?php get_footer(); ?>

