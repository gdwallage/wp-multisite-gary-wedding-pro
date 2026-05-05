<?php
/**
 * File: front-page.php
 * Theme: Gary Wallage Wedding Pro
 * Version: 3000.110.0
 * Description: Automated 3D Hero Slider synced with Primary Menu.
 */

get_header();

// Fetch items from the 'primary' menu location to automatically sync slider with navigation
$locations = get_nav_menu_locations();
$menu_obj = isset($locations['primary']) ? wp_get_nav_menu_object($locations['primary']) : null;
$menu_items = $menu_obj ? wp_get_nav_menu_items($menu_obj->term_id) : array();

$slides = array();

if ($menu_items) {
    foreach ($menu_items as $item) {
        // Only include top-level pages that have a featured image
        if ($item->menu_item_parent == 0 && $item->object === 'page') {
            $pid = $item->object_id;
            $img_id = get_post_thumbnail_id($pid);
            
            if ($img_id) {
                // Fetch subtitle: Prefer manual meta _gary_service_subtitle, then first H2, then excerpt
                $subtitle = get_post_meta($pid, '_gary_service_subtitle', true);
                if (!$subtitle) {
                    $post_obj = get_post($pid);
                    if ($post_obj && preg_match('/<h2[^>]*>(.*?)<\/h2>/si', $post_obj->post_content, $matches)) {
                        $subtitle = wp_strip_all_tags($matches[1]);
                    }
                    if (!$subtitle) {
                        $subtitle = get_the_excerpt($pid);
                    }
                }

                $slides[] = array(
                    'img_id'   => $img_id,
                    'title'    => get_the_title($pid),
                    'subtitle' => $subtitle,
                    'url'      => get_permalink($pid)
                );
            }
        }
    }
}

// FALLBACK: If no menu slides found, fetch latest 3 pages with thumbnails
if ( empty( $slides ) ) {
    $fallback_query = new WP_Query( array(
        'post_type'      => 'page',
        'posts_per_page' => 3,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
        'meta_query'     => array(
            array(
                'key' => '_thumbnail_id',
                'compare' => 'EXISTS'
            )
        )
    ) );
    if ( $fallback_query->have_posts() ) {
        while ( $fallback_query->have_posts() ) {
            $fallback_query->the_post();
            $slides[] = array(
                'img_id'   => get_post_thumbnail_id(),
                'title'    => get_the_title(),
                'subtitle' => get_the_excerpt(),
                'url'      => get_permalink()
            );
        }
    }
    wp_reset_postdata();
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
                        <p class="hero-peek-subtitle"><?php echo esc_html( $s['subtitle'] ); ?></p>
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
