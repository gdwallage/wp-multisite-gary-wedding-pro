<?php

function gary_register_service_blocks() {
    
    // 1. Featured Services Grid
    register_block_type('gw/service-grid', array(
        'render_callback' => 'gary_render_service_grid_block',
        'category' => 'gary-editorial-native',
        'attributes' => array(
            'grid_layout' => array( 'type' => 'string', 'default' => '3-cols' )
        )
    ));

    // 2. Singular Service Box
    register_block_type('gw/single-service', array(
        'render_callback' => 'gary_render_single_service_block',
        'category' => 'gary-editorial-native',
        'attributes' => array(
            'bookly_id'   => array( 'type' => 'string', 'default' => '' ),
            'card_layout' => array( 'type' => 'string', 'default' => 'vertical' )
        )
    ));

    // 3. Z-Pattern Layout
    register_block_type('gw/z-pattern', array(
        'render_callback' => 'gary_render_z_pattern_block',
        'category' => 'gary-editorial-native',
        'attributes' => array(
            'image_url'  => array( 'type' => 'string', 'default' => '' ),
            'image_id'   => array( 'type' => 'number', 'default' => 0 ),
            'image_pos'  => array( 'type' => 'string', 'default' => 'left' ),
            'image_size' => array( 'type' => 'string', 'default' => 'large' )
        )
    ));

    // 4. Trio Gallery
    register_block_type('gw/trio-gallery', array(
        'render_callback' => 'gary_render_trio_gallery_block',
        'category' => 'gary-editorial-native',
        'attributes' => array(
            'img1_id' => array( 'type' => 'number', 'default' => 0 ), 'img1_size' => array( 'type' => 'string', 'default' => 'large' ),
            'img2_id' => array( 'type' => 'number', 'default' => 0 ), 'img2_size' => array( 'type' => 'string', 'default' => 'medium' ),
            'img3_id' => array( 'type' => 'number', 'default' => 0 ), 'img3_size' => array( 'type' => 'string', 'default' => 'medium' ),
        )
    ));

    // 5. Editorial Split
    register_block_type('gw/editorial-split', array(
        'render_callback' => 'gary_render_split_block',
        'category' => 'gary-editorial-native',
        'attributes' => array(
            'image_id'   => array( 'type' => 'number', 'default' => 0 ),
            'image_pos'  => array( 'type' => 'string', 'default' => 'right' ),
            'image_size' => array( 'type' => 'string', 'default' => 'large' )
        )
    ));
}
add_action('init', 'gary_register_service_blocks');

// Category Registration
function gary_register_block_categories( $categories, $post ) {
    return array_merge( array( array( 'slug' => 'gary-editorial-native', 'title' => __( 'Gary Wallage Wedding', 'garywedding' ), 'icon' => 'star-filled' ) ), $categories );
}
add_filter( 'block_categories_all', 'gary_register_block_categories', 10, 2 );

// Editor Enqueuing
function gary_enqueue_block_editor_assets() {
    wp_enqueue_script( 'gw-service-blocks', get_template_directory_uri() . '/inc/blocks/service-blocks.js', array('wp-blocks', 'wp-element', 'wp-components', 'wp-block-editor', 'wp-server-side-render'), '1.6.0', true );
    wp_enqueue_style( 'gw-service-blocks-editor', get_stylesheet_uri(), array(), '1.6.0' );

    global $wpdb;
    $options = array( array( 'label' => '-- Select Service --', 'value' => '' ) );
    $table_name = $wpdb->prefix . 'bookly_services';
    if ( $wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name ) {
        $services = $wpdb->get_results( "SELECT id, title FROM $table_name ORDER BY title ASC" );
        foreach ( $services as $s ) { $options[] = array('label' => $s->title, 'value' => (string) $s->id); }
    }
    wp_localize_script( 'gw-service-blocks', 'garyBooklyServiceOptions', $options );
}
add_action( 'enqueue_block_editor_assets', 'gary_enqueue_block_editor_assets' );

function gary_wedding_editor_grid_fix() {
    echo '<style id="gary-editor-grid-fix">
        /* Unbox wrappers */
        .wp-block-gw-single-service { display: contents !important; }
        .wp-block-gw-single-service > div { display: contents !important; }
        
        /* Force 3 Columns on Desktop in Editor */
        @media (min-width: 1024px) {
            .editor-styles-wrapper .services-grid {
                display: grid !important;
                grid-template-columns: repeat(3, 1fr) !important;
                gap: 20px !important;
                width: 100% !important;
            }
        }

        /* Disable Clickability in Editor */
        .editor-styles-wrapper a.service-card-link { pointer-events: none !important; cursor: default !important; }
        .editor-styles-wrapper .service-card-link * { pointer-events: none !important; }

        .editor-styles-wrapper .services-grid > .block-editor-inner-blocks > .block-editor-block-list__layout {
            display: contents !important;
        }

        .editor-styles-wrapper .service-card { border: var(--gold-frame-border) solid var(--brand-gold-light) !important; background: var(--brand-white) !important; height: 100% !important; }
    </style>';
}
add_action( 'admin_head', 'gary_wedding_editor_grid_fix' );

// -----------------------------------------------------------------------------------
// RENDER CALLBACKS
// -----------------------------------------------------------------------------------

function gary_render_service_grid_block( $attributes, $content ) {
    $layout = !empty($attributes['grid_layout']) ? $attributes['grid_layout'] : '3-cols';
    $class = ($layout === '2-cols') ? 'components-grid' : 'services-grid';
    $wrapper = ($layout === '2-cols') ? 'detailed-components-section' : 'gw-global-grid-wrapper';
    return "<div class='{$wrapper}'><div class='{$class}'>{$content}</div></div>";
}

function gary_render_single_service_block( $attributes ) {
    $b_id = !empty($attributes['bookly_id']) ? $attributes['bookly_id'] : '';
    $layout = !empty($attributes['card_layout']) ? $attributes['card_layout'] : 'vertical';
    if ( empty($b_id) ) return is_admin() ? '<div style="padding:20px; border:1px dashed #ccc;">Select Bookly Service</div>' : '';

    $b_data = gary_get_bookly_service_data( $b_id );
    if ( !$b_data ) return '';

    global $wpdb;
    $page_id = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_gary_bookly_id' AND meta_value = %s LIMIT 1", $b_id ) );

    $card_title = $b_data['title'];
    $is_free = (float)$b_data['price'] <= 0;
    $display_price = $is_free ? 'FREE' : 'From £' . number_format($b_data['price'], 0);
    $display_duration = '';
    
    $card_url = $page_id ? get_permalink($page_id) : '/booking/';
    $card_thumb = '';
    $highlights = '';
    $summary = array('savings' => 0, 'titles' => array());

    if ($page_id) {
        $card_thumb = get_the_post_thumbnail_url($page_id, 'large');
        $highlights = get_post_meta($page_id, '_gary_service_highlights', true);
        $summary = gary_get_sub_service_summary($page_id);
    }

    if (!$card_thumb) {
        $logo_id = get_theme_mod('custom_logo');
        $card_thumb = $logo_id ? wp_get_attachment_image_url($logo_id, 'full') : '';
    }

    $card_desc = !empty($b_data['info']) ? $b_data['info'] : '';

    ob_start();
    if ($layout === 'horizontal') : ?>
        <a href="<?php echo esc_url($card_url); ?>" class="component-card style-bookly-service">
            <div class="coin-icon-wrap"><?php if($card_thumb): ?><img src="<?php echo esc_url($card_thumb); ?>" /><?php endif; ?></div>
            <div class="component-info">
                <h3><?php echo esc_html($card_title); ?></h3>
                <div class="component-includes"><?php echo wp_kses_post(wp_trim_words($card_desc, 15)); ?></div>
            </div>
        </a>
    <?php else : ?>
        <a href="<?php echo esc_url($card_url); ?>" class="service-card-link">
            <div class="service-card">
                <?php if($summary['savings'] > 0): ?><div class="service-card-ribbon">SAVE £<?php echo number_format($summary['savings'], 0); ?></div><?php endif; ?>
                <div class="service-card-image"><?php if($card_thumb): ?><img src="<?php echo esc_url($card_thumb); ?>" /><?php endif; ?></div>
                <div class="service-card-content">
                    <h3 class="service-card-title"><?php echo esc_html($card_title); ?></h3>
                    <div class="service-card-price <?php echo $is_free ? 'is-free' : ''; ?>">
                        <span><?php echo esc_html($display_price); ?></span>
                    </div>
                    
                    <?php if ( ! empty( $summary['titles'] ) ) : ?>
                        <ul class="gw-bullet-list is-inclusions">
                            <?php foreach ( $summary['titles'] as $inc_title ) : ?>
                                <li><?php echo esc_html( $inc_title ); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <div class="service-card-description" style="text-align: center; margin-bottom: 20px; font-size: 0.9rem; opacity: 0.8;">
                        <?php echo wp_kses_post(wp_trim_words($card_desc, 25)); ?>
                    </div>

                    <?php if (!empty($highlights)) : ?>
                        <ul class="gw-bullet-list is-highlights">
                            <?php 
                            $lines = explode("\n", $highlights);
                            foreach($lines as $line) {
                                if (trim($line)) {
                                    echo '<li>' . esc_html(trim($line)) . '</li>';
                                }
                            }
                            ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </a>
    <?php endif;
    return ob_get_clean();
}

function gary_render_z_pattern_block( $attributes, $content ) {
    $img_id = !empty($attributes['image_id']) ? $attributes['image_id'] : 0;
    $pos = !empty($attributes['image_pos']) ? $attributes['image_pos'] : 'left';
    $size = !empty($attributes['image_size']) ? $attributes['image_size'] : 'large';
    $img_url = $img_id ? wp_get_attachment_image_url($img_id, $size) : (!empty($attributes['image_url']) ? $attributes['image_url'] : '');
    ob_start(); ?>
    <div class="gw-z-pattern is-<?php echo esc_attr($pos); ?>">
        <div class="gw-z-image"><?php if($img_url): ?><img src="<?php echo esc_url($img_url); ?>" /><?php endif; ?></div>
        <div class="gw-z-content"><?php echo $content; ?></div>
    </div>
    <?php return ob_get_clean();
}

function gary_render_trio_gallery_block( $attributes ) {
    $imgs = array();
    for($i=1; $i<=3; $i++) {
        $id = !empty($attributes["img{$i}_id"]) ? $attributes["img{$i}_id"] : 0;
        $size = !empty($attributes["img{$i}_size"]) ? $attributes["img{$i}_size"] : 'large';
        $imgs[$i] = $id ? wp_get_attachment_image_url($id, $size) : '';
    }
    ob_start(); ?>
    <div class="gw-trio-gallery">
        <div class="gw-trio-main"><?php if($imgs[1]): ?><img src="<?php echo esc_url($imgs[1]); ?>" /><?php endif; ?></div>
        <div class="gw-trio-side">
            <div class="gw-trio-top"><?php if($imgs[2]): ?><img src="<?php echo esc_url($imgs[2]); ?>" /><?php endif; ?></div>
            <div class="gw-trio-bottom"><?php if($imgs[3]): ?><img src="<?php echo esc_url($imgs[3]); ?>" /><?php endif; ?></div>
        </div>
    </div>
    <?php return ob_get_clean();
}

function gary_render_split_block( $attributes, $content ) {
    $img_id = !empty($attributes['image_id']) ? $attributes['image_id'] : 0;
    $pos = !empty($attributes['image_pos']) ? $attributes['image_pos'] : 'right';
    $size = !empty($attributes['image_size']) ? $attributes['image_size'] : 'large';
    $img_url = $img_id ? wp_get_attachment_image_url($img_id, $size) : '';
    ob_start(); ?>
    <div class="gw-editorial-split is-<?php echo esc_attr($pos); ?>">
        <div class="gw-split-media"><?php if($img_url): ?><img src="<?php echo esc_url($img_url); ?>" /><?php endif; ?></div>
        <div class="gw-split-content"><?php echo $content; ?></div>
    </div>
    <?php return ob_get_clean();
}

function gary_register_custom_block_styles() {
    register_block_style( 'core/list', array( 'name' => 'gw-highlights', 'label' => __( 'Highlights (Gold Ticks)', 'garywedding' ) ));
    register_block_style( 'core/list', array( 'name' => 'gw-included', 'label' => __( 'What\'s Included (Plus)', 'garywedding' ) ));
    register_block_style( 'core/list', array( 'name' => 'gw-perfect-for', 'label' => __( 'Perfect For (Diamonds)', 'garywedding' ) ));
}
add_action( 'init', 'gary_register_custom_block_styles' );
