<?php
/**
 * File: front-page.php
 * Template Name: Front Page
 * Theme: Gary Wallage Wedding Pro
 * Version: 1.80.0
 * Description: Corrected loop to ensure Slide 0 and Intro Content work without PHP logic errors.
 */

get_header(); 

$slides = array();

// --- 1. SLIDE 0: Page Featured Image (Pseudo Slide 0) ---
if ( has_post_thumbnail() ) {
    $slides[] = array(
        'img'      => get_the_post_thumbnail_url( get_the_ID(), 'full' ),
        'title'    => get_the_title(),
        'subtitle' => 'Exclusive Feature',
        'box_color'  => get_theme_mod('hero_slide_0_box_color', '#8C6D2D'),
        'box_opacity'=> get_theme_mod('hero_slide_0_box_opacity', '0.9'),
        'text_color' => get_theme_mod('hero_slide_0_text_color', '#ffffff'),
    );
}

// --- 2. CUSTOMIZER SLIDES 1-5 ---
for ($i = 1; $i <= 5; $i++) {
    $img = get_theme_mod("hero_slide_{$i}_img");
    if ($img) {
        $slides[] = array(
            'img'      => $img,
            'title'    => get_theme_mod("hero_slide_{$i}_title"),
            'subtitle' => get_theme_mod("hero_slide_{$i}_subtitle"),
            'box_color'  => get_theme_mod("hero_slide_{$i}_box_color", '#8C6D2D'),
            'box_opacity'=> get_theme_mod("hero_slide_{$i}_box_opacity", '0.9'),
            'text_color' => '#ffffff', 
        );
    }
}
?>

<main id="primary" class="site-main home">

    <?php if ( !empty($slides) ) : ?>
    <div class="hero-carousel-wrapper">
        <div class="hero-carousel">
            <?php foreach ($slides as $index => $slide) : 
                $rgb = gary_hex2rgb($slide['box_color']);
                $bg_style = "rgba($rgb, {$slide['box_opacity']})";
                $txt_color = $slide['text_color'];
            ?>
                <div class="hero-slide <?php echo $index === 0 ? 'active' : ''; ?>" style="background-image: url('<?php echo esc_url($slide['img']); ?>');">
                    <div class="hero-slide-content">
                        <div class="hero-title-box" style="background: <?php echo $bg_style; ?>; color: <?php echo $txt_color; ?>; padding: 40px 60px;">
                            <h1 class="hero-title" style="color: <?php echo $txt_color; ?> !important;"><?php echo esc_html($slide['title']); ?></h1>
                            <?php if ($slide['subtitle']): ?>
                                <p class="hero-subtitle" style="color: <?php echo $txt_color; ?> !important; opacity: 0.8;"><?php echo esc_html($slide['subtitle']); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if (count($slides) > 1): ?>
        <div class="carousel-nav">
            <button id="prevSlide" aria-label="Previous Slide">&larr;</button>
            <button id="nextSlide" aria-label="Next Slide">&rarr;</button>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <!-- RESTORATION: Intro Content from Front Page -->
    <section class="home-intro container" style="margin-top:80px;">
        <?php 
        // Reset post data to ensure we pull from the main page object, not the slider loop
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.hero-slide');
    const prevBtn = document.getElementById('prevSlide');
    const nextBtn = document.getElementById('nextSlide');
    let current = 0;

    if (slides.length > 1) {
        function update() {
            slides.forEach((s, i) => {
                s.classList.remove('active', 'prev', 'next');
                if (i === current) s.classList.add('active');
                else if (i === (current - 1 + slides.length) % slides.length) s.classList.add('prev');
                else if (i === (current + 1) % slides.length) s.classList.add('next');
            });
        }
        if(nextBtn) nextBtn.addEventListener('click', () => { current = (current + 1) % slides.length; update(); });
        if(prevBtn) prevBtn.addEventListener('click', () => { current = (current - 1 + slides.length) % slides.length; update(); });
        setInterval(() => { current = (current + 1) % slides.length; update(); }, 7000);
        update();
    } else if (slides.length === 1) { 
        slides[0].classList.add('active'); 
    }
});
</script>

<?php get_footer(); ?>
