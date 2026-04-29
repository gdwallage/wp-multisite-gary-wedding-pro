<?php
/**
 * Blocks Rendering: Front-end display logic for custom editorial blocks.
 */

function gary_render_service_grid_block( $attributes, $content ) {
    $layout = !empty($attributes['grid_layout']) ? $attributes['grid_layout'] : '3-cols';
    $class = ($layout === '2-cols') ? 'components-grid' : 'services-grid';
    $wrapper = ($layout === '2-cols') ? 'detailed-components-section' : 'gw-global-grid-wrapper';
    return "<div class='{$wrapper}'><div class='{$class}'>{$content}</div></div>";
}

function gary_render_single_service_block( $attributes ) {
    $b_id = !empty($attributes['bookly_id']) ? $attributes['bookly_id'] : '';
    if ( empty($b_id) ) return is_admin() ? '<div style="padding:20px; border:1px dashed #ccc;">Select Bookly Service</div>' : '';
    
    // We use the unified card renderer from card-renderer.php
    $card_data = gary_get_service_data_unified($b_id, 'bookly');
    if ( empty($card_data) ) return '';

    return gary_render_service_card_html( $card_data );
}

function gary_render_z_pattern_block( $attributes, $content ) {
    $img_id = !empty($attributes['image_id']) ? $attributes['image_id'] : 0;
    $pos = !empty($attributes['image_pos']) ? $attributes['image_pos'] : 'left';
    $size = !empty($attributes['image_size']) ? $attributes['image_size'] : 'large';
    $img_html = $img_id ? wp_get_attachment_image( $img_id, $size ) : '';
    
    ob_start(); ?>
    <div class="gw-z-pattern container is-<?php echo esc_attr($pos); ?>">
        <div class="gw-z-image"><?php echo $img_html; ?></div>
        <div class="gw-z-content"><?php echo $content; ?></div>
    </div>
    <?php return ob_get_clean();
}

function gary_render_trio_gallery_block( $attributes ) {
    ob_start(); ?>
    <div class="gw-trio-gallery-wrapper container">
        <?php if ( !empty($attributes['trio_title']) ) : ?>
            <h2 class="trio-gallery-heading"><?php echo esc_html( $attributes['trio_title'] ); ?></h2>
        <?php endif; ?>
        <div class="gw-trio-gallery">
            <div class="gw-trio-main"><?php if(!empty($attributes['img1_id'])) echo wp_get_attachment_image($attributes['img1_id'], 'large'); ?></div>
            <div class="gw-trio-side">
                <div class="gw-trio-top"><?php if(!empty($attributes['img2_id'])) echo wp_get_attachment_image($attributes['img2_id'], 'medium'); ?></div>
                <div class="gw-trio-bottom"><?php if(!empty($attributes['img3_id'])) echo wp_get_attachment_image($attributes['img3_id'], 'medium'); ?></div>
            </div>
        </div>
    </div>
    <?php return ob_get_clean();
}

function gary_render_split_block( $attributes, $content ) {
    $img_id = !empty($attributes['image_id']) ? $attributes['image_id'] : 0;
    $pos = !empty($attributes['image_pos']) ? $attributes['image_pos'] : 'right';
    ob_start(); ?>
    <div class="gw-editorial-split container is-<?php echo esc_attr($pos); ?>">
        <div class="gw-split-media"><?php if($img_id) echo wp_get_attachment_image($img_id, 'large'); ?></div>
        <div class="gw-split-content"><?php echo $content; ?></div>
    </div>
    <?php return ob_get_clean();
}

function gary_render_chapter_break_block( $atts ) {
    return '<div class="gw-chapter-break container"><hr class="gw-gold-sep" /><h2 class="gw-chapter-title">' . esc_html($atts['title']) . '</h2></div>';
}

function gary_render_cta_plaque_block( $atts ) {
    $title    = !empty($atts['title']) ? $atts['title'] : 'Ready to tell your story?';
    $content  = !empty($atts['content']) ? $atts['content'] : 'I take on a limited number of weddings each year...';
    $btn1     = !empty($atts['btn_text']) ? $atts['btn_text'] : 'Inquire Now';

    ob_start(); ?>
    <div class="gw-cta-plaque-rebuilt container">
        <div class="investment-plaque">
            <h3 class="plaque-title"><?php echo esc_html($title); ?></h3>
            <div class="cta-plaque-body"><?php echo esc_html($content); ?></div>
            <div class="investment-buttons">
                <a href="javascript:void(0)" class="btn-black-gold gw-request-modal-trigger" data-service="<?php echo esc_attr($title); ?>">
                    <?php echo esc_html($btn1); ?> &rarr;
                </a>
            </div>
        </div>
    </div>
    <?php return ob_get_clean();
}

function gary_render_tessellated_menu( $atts ) {
    $slug = !empty($atts['menu_slug']) ? $atts['menu_slug'] : 'primary';
    $items = wp_get_nav_menu_items( $slug );
    if ( ! $items ) return '';

    ob_start(); ?>
    <div class="gw-tessellated-wall alignfull">
        <div class="gw-tessellation-grid">
            <?php foreach ( $items as $idx => $item ) : 
                $img_url = get_the_post_thumbnail_url( $item->object_id, 'large' ) ?: 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&q=80&w=1000';
            ?>
                <a href="<?php echo esc_url($item->url); ?>" class="gw-wall-tile">
                    <div class="tile-image" style="background-image: url('<?php echo esc_url($img_url); ?>');"></div>
                    <div class="tile-overlay"><div class="tile-content"><h3 class="tile-title"><?php echo esc_html($item->title); ?></h3></div></div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php return ob_get_clean();
}

function gary_render_trust_bar_block( $atts ) {
    return '<div class="gw-trust-bar"><div class="container"><p>' . esc_html($atts['signals']) . '</p></div></div>';
}

function gary_render_usps_block( $atts ) {
    ob_start(); ?>
    <div class="gw-usps-block container">
        <h2 class="gw-block-main-title"><?php echo esc_html($atts['main_title']); ?></h2>
        <div class="gw-usps-row">
            <?php for($i=1; $i<=3; $i++) : ?>
                <div class="gw-usp-col"><h4><?php echo esc_html($atts["t$i"]); ?></h4><p><?php echo esc_html($atts["d$i"]); ?></p></div>
            <?php endfor; ?>
        </div>
    </div>
    <?php return ob_get_clean();
}

function gary_render_action_container_block( $atts, $content ) {
    ob_start(); ?>
    <div class="gw-process-block container">
        <h2 class="gw-block-main-title"><?php echo esc_html($atts['main_title']); ?></h2>
        <div class="gw-process-row"><?php echo $content; ?></div>
    </div>
    <?php return ob_get_clean();
}

function gary_render_action_step_block( $atts ) {
    $num = !empty($atts['step_num']) ? $atts['step_num'] : '01';
    ob_start(); ?>
    <div class="gw-process-col">
        <span class="step-num"><?php echo esc_html($num); ?></span>
        <h3><?php echo esc_html($atts['title']); ?></h3>
        <p><?php echo esc_html($atts['description']); ?></p>
        <div class="gw-step-action-wrap"><a href="<?php echo get_permalink($atts['target_page']); ?>" class="btn-black-gold">Book Consultation</a></div>
    </div>
    <?php return ob_get_clean();
}

function gary_render_check_date_atomic( $atts ) {
    $title = !empty($atts['title']) ? $atts['title'] : 'Check Your Date!';
    ob_start(); ?>
    <div class="gw-process-block gw-atomic-check-wrap">
        <div class="gw-editorial-gold-box is-atomic-check">
            <h3 class="atomic-title"><?php echo esc_html($title); ?></h3>
            <div class="gw-atomic-actions">
                <input type="date" id="gw-atomic-check-date" class="gw-date-picker-input" />
                <button type="button" class="btn-black-gold gw-check-availability-btn-atomic">Check Availability</button>
            </div>
            <div id="gw-atomic-availability-result" class="gw-avail-result"></div>
        </div>
    </div>
    <?php return ob_get_clean();
}

function gary_render_triplet_container( $atts, $content ) {
    return "<div class='gw-editorial-triplet-wrap container'><div class='gw-triplet-row'>{$content}</div></div>";
}

function gary_render_triplet_item( $atts, $content ) {
    ob_start(); ?>
    <div class="gw-triplet-item">
        <div class="gw-triplet-inner">
            <?php if ( !empty($atts['heading']) ) : ?><h3><?php echo esc_html($atts['heading']); ?></h3><?php endif; ?>
            <div class="triplet-body-text"><?php echo wp_kses_post($atts['text']); ?></div>
            <div class="triplet-list-content"><?php echo preg_replace('/<li[^>]*>(?:\s|&nbsp;|<br\s*\/?>)*<\/li>/i', '', $content); ?></div>
        </div>
    </div>
    <?php return ob_get_clean();
}

function gary_render_hero_bleed_block( $atts, $content ) {
    $img_url = !empty($atts['image_url']) ? $atts['image_url'] : '';
    return "<div class='gw-hero-bleed alignfull' style='background-image: url(" . esc_url($img_url) . ");'><div class='gw-hero-bleed-content container'>{$content}</div></div>";
}

function gary_render_storyteller_grid_block( $atts ) {
    ob_start(); ?>
    <div class="gw-storyteller-grid container">
        <?php for($i=1; $i<=4; $i++) : ?>
            <div class="gw-story-item"><img src="<?php echo esc_url($atts["img{$i}_url"]); ?>" alt="" /></div>
        <?php endfor; ?>
    </div>
    <?php return ob_get_clean();
}

function gary_render_testimonial_quote_block( $atts, $content ) {
    $img_url = !empty($atts['image_url']) ? $atts['image_url'] : '';
    return "<div class='gw-testimonial-quote-block alignfull' style='background-image: url(" . esc_url($img_url) . ");'><div class='container'><div class='gw-testimonial-inner'>{$content}</div></div></div>";
}

function gary_render_polaroid_frame_block( $atts, $content ) {
    return '<div class="gw-polaroid-frame container">' . $content . '</div>';
}

function gary_render_styled_list_box( $atts, $content ) {
    $type = !empty($atts['type']) ? $atts['type'] : 'highlights';
    $content = preg_replace('/<li[^>]*>(?:\s|&nbsp;|<br\s*\/?>)*<\/li>/i', '', $content);
    return "<div class='gw-list-box is-style-{$type}'><div class='gw-list-box-inner'>{$content}</div></div>";
}

function gary_render_dual_column_block( $atts, $content ) {
    return "<div class='gw-editorial-dual-column alignwide'><div class='gw-dual-column-row'>{$content}</div></div>";
}
