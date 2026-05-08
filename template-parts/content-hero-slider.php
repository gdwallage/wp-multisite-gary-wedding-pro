<?php
/**
 * Template Part: Hero Slider
 * Implementation: Automated 3D Hero Slider synced with Primary Menu.
 */

// Fetch items from the 'primary' menu location to automatically sync slider with navigation
$locations = get_nav_menu_locations();
$menu_obj = isset($locations['primary']) ? wp_get_nav_menu_object($locations['primary']) : null;
$menu_items = $menu_obj ? wp_get_nav_menu_items($menu_obj->term_id) : array();

$slides = array();

if ($menu_items) {
    foreach ($menu_items as $item) {
        if ($item->menu_item_parent == 0 && $item->object === 'page') {
            $pid = $item->object_id;
            $img_id = get_post_thumbnail_id($pid);
            
            if ($img_id) {
                $post_obj = get_post($pid);
                $content = $post_obj ? $post_obj->post_content : '';
                
                // Rule: Fetch FIRST HEADER (H1, H2, or H3) as Subtitle
                $subtitle = '';
                if (preg_match('/<h[1-3][^>]*>(.*?)<\/h[1-3]>/si', $content, $matches)) {
                    $subtitle = wp_strip_all_tags($matches[1]);
                }
                
                // Fallback to Excerpt
                if (!$subtitle) {
                    $subtitle = get_the_excerpt($pid);
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

// FALLBACK
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

<?php if ( ! empty( $slides ) ) : ?>
<div class="hero-peek-carousel" id="heroPeekCarousel">
    <div class="hero-peek-track" id="heroPeekTrack">
        <?php foreach ( $slides as $idx => $s ) : 
            $class = ($idx === 0) ? 'active' : (($idx === 1) ? 'next' : (($idx === $slide_count - 1) ? 'prev' : 'hidden'));
            $is_home_slide = ( untrailingslashit($s['url']) === untrailingslashit(home_url('/')) );
        ?>
        <div class="hero-peek-slide <?php echo $class; ?>" 
             data-index="<?php echo $idx; ?>" 
             data-title="<?php echo esc_attr($s['title']); ?>"
             data-subtitle="<?php echo esc_attr($s['subtitle']); ?>"
             data-cta="<?php echo $is_home_slide ? '' : 'Explore'; ?>"
             <?php if (!$is_home_slide) echo 'data-url="' . esc_url( $s['url'] ) . '"'; ?>>
            <?php echo wp_get_attachment_image( $s['img_id'], 'full', false, array( 'class' => 'hero-peek-img' ) ); ?>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- STABLE CAPTION LAYER: Anchored at bottom as requested -->
    <div class="hero-peek-caption-stable" id="heroCaptionStage">
        <h1 class="hero-peek-title"><?php echo esc_html($slides[0]['title']); ?></h1>
        <?php if ($slides[0]['subtitle']): ?>
            <p class="hero-peek-subtitle"><?php echo esc_html($slides[0]['subtitle']); ?></p>
        <?php endif; ?>
        <a href="<?php echo esc_url($slides[0]['url']); ?>" class="hero-peek-cta">Explore <span aria-hidden="true">→</span></a>
    </div>

    <?php if ( $slide_count > 1 ) : ?>
    <div class="hero-peek-nav">
        <button id="heroPeekPrev" class="hero-peek-arrow">&#8592;</button>
        <div class="hero-peek-dots">
            <?php for($i=0; $i<$slide_count; $i++): ?>
                <button class="hero-peek-dot <?php echo $i===0?'active':''; ?>" aria-label="Slide <?php echo $i+1; ?>" data-index="<?php echo $i; ?>"></button>
            <?php endfor; ?>
        </div>
        <button id="heroPeekNext" class="hero-peek-arrow">&#8594;</button>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>
