<?php
/**
 * File: front-page.php
 * Template Name: Front Page
 * Theme: Gary Wallage Wedding Pro
 * Description: Custom Homepage with Circular Center-Mode Carousel.
 * Fixes: Removes duplicate hex2rgb function.
 */

get_header(); 

// 1. Initialize Slides Array
$slides = array();

// 2. SETUP SLIDE 1 (The Master/Featured Slide)
$feat_img = get_the_post_thumbnail_url( get_the_ID(), 'full' );

if ( $feat_img ) {
    $slides[] = array(
        'img'      => $feat_img,
        'title'    => get_theme_mod('hero_slide_1_title', 'Capturing Moments'),
        'subtitle' => get_theme_mod('hero_slide_1_subtitle', 'Preserving Memories'),
        'btn'      => get_theme_mod('hero_slide_1_btn', 'Start Your Journey'),
        'link'     => get_theme_mod('hero_slide_1_link', '/contact'),
        // Title Colors
        'text_color' => get_theme_mod('hero_slide_1_text_color', '#ffffff'),
        'box_color'  => get_theme_mod('hero_slide_1_box_color', '#8C6D2D'),
        'box_opacity'=> get_theme_mod('hero_slide_1_box_opacity', '0.9'),
        // Button Colors
        'btn_text_color' => get_theme_mod('hero_slide_1_btn_text_color', '#ffffff'),
        'btn_bg_color'   => get_theme_mod('hero_slide_1_btn_bg_color', '#8C6D2D'),
        'btn_bg_opacity' => get_theme_mod('hero_slide_1_btn_bg_opacity', '0.9'),
    );
}

// 3. SETUP SLIDES 2-5
for ($i = 2; $i <= 5; $i++) {
    $img = get_theme_mod("hero_slide_{$i}_img");
    if ($img) {
        $slides[] = array(
            'img'      => $img,
            'title'    => get_theme_mod("hero_slide_{$i}_title"),
            'subtitle' => get_theme_mod("hero_slide_{$i}_subtitle"),
            'btn'      => get_theme_mod("hero_slide_{$i}_btn"),
            'link'     => get_theme_mod("hero_slide_{$i}_link"),
            // Title Colors
            'text_color' => get_theme_mod("hero_slide_{$i}_text_color", '#ffffff'),
            'box_color'  => get_theme_mod("hero_slide_{$i}_box_color", '#8C6D2D'),
            'box_opacity'=> get_theme_mod("hero_slide_{$i}_box_opacity", '0.9'),
            // Button Colors
            'btn_text_color' => get_theme_mod("hero_slide_{$i}_btn_text_color", '#ffffff'),
            'btn_bg_color'   => get_theme_mod("hero_slide_{$i}_btn_bg_color", '#8C6D2D'),
            'btn_bg_opacity' => get_theme_mod("hero_slide_{$i}_btn_bg_opacity", '0.9'),
        );
    }
}

// 4. EDGE CASE: Duplicate if only 2
if (count($slides) === 2) {
    $slides = array_merge($slides, $slides);
}
?>

<main id="primary" class="site-main">

    <!-- HERO CAROUSEL -->
    <?php if ( !empty($slides) ) : ?>
    <div class="hero-carousel-wrapper">
        <div class="hero-carousel">
            <?php foreach ($slides as $index => $slide) : 
                // Calc RGBA for Title Box
                $rgb = gary_hex2rgb($slide['box_color']);
                $opacity = $slide['box_opacity'];
                $bg_style = "rgba($rgb, $opacity)";
                $txt_color = $slide['text_color'];

                // Calc RGBA for Button Box
                $btn_rgb = gary_hex2rgb($slide['btn_bg_color']);
                $btn_opacity = $slide['btn_bg_opacity'];
                $btn_bg_style = "rgba($btn_rgb, $btn_opacity)";
                $btn_txt_color = $slide['btn_text_color'];
            ?>
                <div class="hero-slide <?php echo $index === 0 ? 'active' : ''; ?>" data-index="<?php echo $index; ?>" style="background-image: url('<?php echo esc_url($slide['img']); ?>');">
                    <div class="hero-slide-content">

                        <!-- TITLE WRAPPER -->
                        <div class="hero-title-box" style="background: <?php echo $bg_style; ?>; color: <?php echo $txt_color; ?>; display: inline-block; padding: 30px 50px; margin-bottom: 20px;">
                            <?php if ($slide['title']): ?>
                                <h1 class="hero-title" style="color: <?php echo $txt_color; ?>; margin:0;"><?php echo str_replace(',', ',<br>', esc_html($slide['title'])); ?></h1>
                            <?php endif; ?>
                            
                            <?php if ($slide['subtitle']): ?>
                                <p class="hero-subtitle" style="color: <?php echo $txt_color; ?>; margin-top:10px;"><?php echo esc_html($slide['subtitle']); ?></p>
                            <?php endif; ?>
                        </div>

                        <br>

                        <!-- BUTTON -->
                        <?php if ($slide['btn']): ?>
                            <a href="<?php echo esc_url($slide['link']); ?>" class="button hero-btn" style="background: <?php echo $btn_bg_style; ?>; color: <?php echo $btn_txt_color; ?>; border-color: <?php echo $slide['btn_bg_color']; ?>;">
                                <?php echo esc_html($slide['btn']); ?>
                            </a>
                        <?php endif; ?>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <?php if (count($slides) > 1): ?>
            <div class="carousel-nav">
                <button id="prevSlide" aria-label="Previous">&larr;</button>
                <button id="nextSlide" aria-label="Next">&rarr;</button>
            </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <!-- INTRO -->
    <section class="home-intro container">
        <?php while ( have_posts() ) : the_post(); ?>
            <div class="entry-content" style="text-align:center; max-width:800px; margin:0 auto;">
                <?php the_content(); ?>
            </div>
        <?php endwhile; ?>
    </section>

    <!-- LATEST STORIES -->
    <section class="home-latest container">
        <header class="section-header" style="text-align:center; margin-bottom:50px;">
            <span class="sub-heading">Recent Works</span>
            <h2 class="section-title">Latest Visual Legacies</h2>
        </header>

        <div class="visual-legacy-grid layout-masonry">
            <?php
            $stories = new WP_Query( array(
                'post_type' => 'visual_legacies',
                'posts_per_page' => 3,
                'post_status' => 'publish'
            ));

            if ( $stories->have_posts() ) :
                while ( $stories->have_posts() ) : $stories->the_post(); ?>
                    <div class="gallery-item">
                        <a href="<?php the_permalink(); ?>">
                            <?php if ( has_post_thumbnail() ) {
                                the_post_thumbnail('large');
                            } ?>
                            <div class="gallery-overlay">
                                <span><?php the_title(); ?></span>
                            </div>
                        </a>
                    </div>
                <?php endwhile;
                wp_reset_postdata();
            else: ?>
                <p style="text-align:center;">No stories published yet.</p>
            <?php endif; ?>
        </div>
        
        <div style="text-align:center; margin-top:40px;">
            <a href="/stories" class="button-outline">View All Stories</a>
        </div>
    </section>

</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.hero-slide');
    const wrapper = document.querySelector('.hero-carousel');
    const nextBtn = document.getElementById('nextSlide');
    const prevBtn = document.getElementById('prevSlide');
    let current = 0;
    const total = slides.length;

    setTimeout(() => {
        if(wrapper) wrapper.classList.add('loaded');
    }, 100);

    if (total > 1) {
        function updateSlides() {
            slides.forEach((slide, index) => {
                slide.classList.remove('active', 'prev', 'next');
                
                let prevIndex = (current - 1 + total) % total;
                let nextIndex = (current + 1) % total;

                if (index === current) {
                    slide.classList.add('active');
                } else if (index === prevIndex) {
                    slide.classList.add('prev');
                } else if (index === nextIndex) {
                    slide.classList.add('next');
                }
            });
        }

        if(nextBtn) {
            nextBtn.addEventListener('click', () => {
                current = (current + 1) % total;
                updateSlides();
            });
        }

        if(prevBtn) {
            prevBtn.addEventListener('click', () => {
                current = (current - 1 + total) % total;
                updateSlides();
            });
        }

        let autoRotate = setInterval(() => {
            current = (current + 1) % total;
            updateSlides();
        }, 6000);

        if(wrapper) {
            wrapper.addEventListener('mouseover', () => clearInterval(autoRotate));
        }

        updateSlides();
    } else if (total === 1) {
        slides[0].classList.add('active');
    }
});
</script>

<?php get_footer(); ?>
