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
            'trio_title' => array( 'type' => 'string', 'default' => '' ),
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

    // 6. Chapter Break
    register_block_type('gw/chapter-break', array(
        'render_callback' => 'gary_render_chapter_break_block',
        'category' => 'gary-editorial-native',
        'attributes' => array(
            'title' => array( 'type' => 'string', 'default' => 'Photographing Life' )
        )
    ));

    // 7. CTA Plaque (The Black & Gold Action Plate)
    register_block_type('gw/cta-plaque', array(
        'render_callback' => 'gary_render_cta_plaque_block',
        'category' => 'gary-editorial-native',
        'attributes' => array(
            'title'    => array( 'type' => 'string', 'default' => 'Ready to Secure Your Date?' ),
            'content'  => array( 'type' => 'string', 'default' => 'I take on a limited number of weddings each year.' ),
            'btn_text' => array( 'type' => 'string', 'default' => 'Inquire Now' ),
            'btn_url'  => array( 'type' => 'string', 'default' => '/contact/' )
        )
    ));

    // 8. Trust Bar (Confidence Signals)
    register_block_type('gw/trust-bar', array(
        'render_callback' => 'gary_render_trust_bar_block',
        'category' => 'gary-editorial-native',
        'attributes' => array(
            'signals' => array( 'type' => 'string', 'default' => '✓ 10+ Years Experience | ✓ Documentary Style | ✓ Limited Bookings' )
        )
    ));

    // 9. USPs (3-Column Editorial Value)
    register_block_type('gw/usps-3col', array(
        'render_callback' => 'gary_render_usps_block',
        'category' => 'gary-editorial-native',
        'attributes' => array(
            'main_title' => array('type' => 'string', 'default' => 'Our Core Values'),
            't1' => array('type'=>'string', 'default'=>'Documentary Storytelling'), 'd1' => array('type'=>'string', 'default'=>'I blend into the background...'),
            't2' => array('type'=>'string', 'default'=>'Technical Precision'),      'd2' => array('type'=>'string', 'default'=>'Ten years of experience...'),
            't3' => array('type'=>'string', 'default'=>'A Calming Presence'),      'd3' => array('type'=>'string', 'default'=>'Relaxed, intentional calm.')
        )
    ));

    // 10. Action Step Container (Parent)
    register_block_type('gw/action-step-container', array(
        'render_callback' => 'gary_render_action_container_block',
        'category' => 'gary-editorial-native',
        'attributes' => array(
            'main_title' => array('type' => 'string', 'default' => 'The Journey')
        )
    ));

    // 11. Individual Action Step (Child)
    register_block_type('gw/action-step', array(
        'render_callback' => 'gary_render_action_step_block',
        'category' => 'gary-editorial-native',
        'attributes' => array(
            'step_type'   => array('type' => 'string', 'default' => 'link'), // 'link' or 'availability'
            'title'       => array('type' => 'string', 'default' => 'Consultation'),
            'description' => array('type' => 'string', 'default' => ''),
            'target_page' => array('type' => 'number', 'default' => 0),
            'step_num'    => array('type' => 'string', 'default' => '01')
        )
    ));

    // 12. Atomic Check Your Date Block
    register_block_type('gw/check-date-atomic', array(
        'render_callback' => 'gary_render_check_date_atomic',
        'category' => 'gary-editorial-native',
        'attributes' => array(
            'title'          => array('type' => 'string', 'default' => 'Check Your Date!'),
            'description'    => array('type' => 'string', 'default' => 'Select your wedding date to see if I am available for your celebration.'),
            'duration'       => array('type' => 'string', 'default' => 'Full Day'),
            'target_page_id' => array('type' => 'number', 'default' => 0)
        )
    ));

    // 13. Editorial Triplet Container (Parent)
    register_block_type('gw/editorial-triplet-container', array(
        'render_callback' => 'gary_render_triplet_container',
        'category' => 'gary-editorial-native',
    ));

    // 14. Editorial Triplet Item (Child)
    register_block_type('gw/editorial-triplet-item', array(
        'render_callback' => 'gary_render_triplet_item',
        'category' => 'gary-editorial-native',
        'attributes' => array(
            'heading' => array('type' => 'string', 'default' => ''),
            'text'    => array('type' => 'string', 'default' => ''),
        )
    ));

    // 11. Hero Bleed (Was Cinematic Bleed Pattern)
    register_block_type('gw/hero-bleed', array(
        'render_callback' => 'gary_render_hero_bleed_block',
        'category' => 'gary-editorial-native',
        'attributes' => array(
            'image_id' => array('type' => 'number', 'default' => 0),
            'image_url' => array('type' => 'string', 'default' => ''),
            'overlay_opacity' => array('type' => 'number', 'default' => 10),
        )
    ));

    // 12. Storyteller Grid (Was Pattern)
    register_block_type('gw/storyteller-grid', array(
        'render_callback' => 'gary_render_storyteller_grid_block',
        'category' => 'gary-editorial-native',
        'attributes' => array(
            'img1_id' => array('type' => 'number', 'default' => 0),
            'img2_id' => array('type' => 'number', 'default' => 0),
            'img3_id' => array('type' => 'number', 'default' => 0),
            'img4_id' => array('type' => 'number', 'default' => 0),
        )
    ));

    // 13. Testimonial Quote (Was Pattern)
    register_block_type('gw/testimonial-quote', array(
        'render_callback' => 'gary_render_testimonial_quote_block',
        'category' => 'gary-editorial-native',
        'attributes' => array(
            'image_id' => array('type' => 'number', 'default' => 0),
            'image_url' => array('type' => 'string', 'default' => ''),
        )
    ));

    // 14. Polaroid Frame (Was Pattern)
    register_block_type('gw/polaroid-frame', array(
        'render_callback' => 'gary_render_polaroid_frame_block',
        'category' => 'gary-editorial-native',
    ));

    // 15. Full-Width CTA (Was Pattern)
    register_block_type('gw/cta-fullwidth', array(
        'render_callback' => 'gary_render_cta_fullwidth_block',
        'category' => 'gary-editorial-native',
        'attributes' => array(
            'image_id' => array('type' => 'number', 'default' => 0),
            'image_url' => array('type' => 'string', 'default' => ''),
        )
    ));

    // 16. Highlights Box
    register_block_type('gw/list-highlights', array(
        'render_callback' => 'gary_render_styled_list_box',
        'category' => 'gary-editorial-native',
        'attributes' => array( 'type' => array('type' => 'string', 'default' => 'highlights') )
    ));

    // 17. Included Box
    register_block_type('gw/list-included', array(
        'render_callback' => 'gary_render_styled_list_box',
        'category' => 'gary-editorial-native',
        'attributes' => array( 'type' => array('type' => 'string', 'default' => 'included') )
    ));

    // 18. Perfect For Box
    register_block_type('gw/list-perfect-for', array(
        'render_callback' => 'gary_render_styled_list_box',
        'category' => 'gary-editorial-native',
        'attributes' => array( 'type' => array('type' => 'string', 'default' => 'perfect-for') )
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
    wp_enqueue_script( 'gw-service-blocks', get_template_directory_uri() . '/inc/blocks/service-blocks.js', array('wp-blocks', 'wp-element', 'wp-components', 'wp-block-editor', 'wp-server-side-render'), '1.6.1', true );
    wp_enqueue_style( 'gw-service-blocks-editor', get_stylesheet_uri(), array(), '1.6.1' );

    global $wpdb;
    $options = array( array( 'label' => '-- Select Service --', 'value' => '' ) );
    $table_name = $wpdb->prefix . 'bookly_services';
    if ( $wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name ) {
        $services = $wpdb->get_results( "SELECT id, title FROM $table_name ORDER BY title ASC" );
        foreach ( $services as $s ) { $options[] = array('label' => $s->title, 'value' => (string) $s->id); }
    }
    wp_localize_script( 'gw-service-blocks', 'garyBooklyServiceOptions', $options );

    // Localize Page Options for CTAs (Optimized for large sites)
    $page_options = array( array( 'label' => '-- Select Page --', 'value' => 0 ) );
    $query = new WP_Query( array(
        'post_type'      => 'page',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'fields'         => 'ids',
        'no_found_rows'  => true,
    ) );
    
    if ( $query->have_posts() ) {
        foreach ( $query->posts as $p_id ) {
            $page_options[] = array( 'label' => get_the_title($p_id), 'value' => (int)$p_id );
        }
    }
    wp_reset_postdata();
    
    wp_localize_script( 'gw-service-blocks', 'garyPageOptions', $page_options );
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

    $card_data = gary_get_service_data_unified($b_id, 'bookly');
    if (!$card_data) return '';

    if ($layout === 'horizontal') : 
        ob_start(); ?>
        <a href="<?php echo esc_url($card_data['permalink']); ?>" class="component-card style-bookly-service">
            <div class="service-card-image" style="flex: 0 0 120px; padding: 10px; border: 2px solid var(--brand-gold-light); margin-right: 25px; border-radius: 0 !important;">
                <?php if($card_data['thumbnail']): ?><img src="<?php echo esc_url($card_data['thumbnail']); ?>" style="border-radius: 0 !important;" /><?php endif; ?>
            </div>
            <div class="component-info">
                <h2 class="service-card-title" style="font-size: 1.2rem; height: auto; text-align: left; justify-content: flex-start; margin-bottom: 5px !important;">
                    <?php echo esc_html( $card_data['title'] ); ?>
                </h2>
                <?php if( $card_data['savings'] > 0 && !$card_data['is_free']): ?>
                    <div class="service-card-ribbon" style="top: 15px; right: -45px; font-size: 0.6rem; width: 180px;">SAVING £<?php echo number_format($card_data['savings'], 0); ?></div>
                <?php endif; ?>
            </div>
        </a>
        <?php return ob_get_clean();
    else :
        return gary_render_service_card_html( $card_data );
    endif;
}

function gary_render_z_pattern_block( $attributes, $content ) {
    $img_id = !empty($attributes['image_id']) ? $attributes['image_id'] : 0;
    $pos = !empty($attributes['image_pos']) ? $attributes['image_pos'] : 'left';
    $size = !empty($attributes['image_size']) ? $attributes['image_size'] : 'large';
    $img_url = $img_id ? wp_get_attachment_image_url($img_id, $size) : (!empty($attributes['image_url']) ? $attributes['image_url'] : '');
    ob_start(); ?>
    <div class="gw-z-pattern container is-<?php echo esc_attr($pos); ?>">
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
    <div class="gw-trio-gallery-wrapper container">
        <?php if ( !empty($attributes['trio_title']) ) : ?>
            <h2 class="trio-gallery-heading" style="text-align:center; font-family:var(--font-script); font-size:3rem; color:var(--brand-accent); margin-bottom:40px; font-weight:normal;">
                <?php echo esc_html( $attributes['trio_title'] ); ?>
            </h2>
        <?php endif; ?>
        <div class="gw-trio-gallery">
            <div class="gw-trio-main"><?php if($imgs[1]): ?><img src="<?php echo esc_url($imgs[1]); ?>" /><?php endif; ?></div>
            <div class="gw-trio-side">
                <div class="gw-trio-top"><?php if($imgs[2]): ?><img src="<?php echo esc_url($imgs[2]); ?>" /><?php endif; ?></div>
                <div class="gw-trio-bottom"><?php if($imgs[3]): ?><img src="<?php echo esc_url($imgs[3]); ?>" /><?php endif; ?></div>
            </div>
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
    <div class="gw-editorial-split container is-<?php echo esc_attr($pos); ?>">
        <div class="gw-split-media"><?php if($img_url): ?><img src="<?php echo esc_url($img_url); ?>" /><?php endif; ?></div>
        <div class="gw-split-content"><?php echo $content; ?></div>
    </div>
    <?php return ob_get_clean();
}

function gary_render_chapter_break_block( $atts ) {
    return '
    <div class="gw-chapter-break container">
        <hr class="gw-gold-sep" />
        <h2 class="gw-chapter-title">' . esc_html($atts['title']) . '</h2>
    </div>';
}

function gary_render_cta_plaque_block( $atts ) {
    return '
    <div class="gw-cta-plaque container">
        <h3>' . esc_html($atts['title']) . '</h3>
        <p>' . esc_html($atts['content']) . '</p>
        <div class="gw-cta-btn-wrap">
            <a href="' . esc_url($atts['btn_url']) . '" class="btn-black-gold">' . esc_html($atts['btn_text']) . '</a>
        </div>
    </div>';
}

function gary_render_trust_bar_block( $atts ) {
    return '
    <div class="gw-trust-bar">
        <div class="container">
            <p>' . esc_html($atts['signals']) . '</p>
        </div>
    </div>';
}

function gary_render_usps_block( $atts ) {
    ob_start(); ?>
    <div class="gw-usps-block container">
        <?php if (!empty($atts['main_title'])) : ?>
            <h2 class="gw-block-main-title"><?php echo esc_html($atts['main_title']); ?></h2>
        <?php endif; ?>
        <div class="gw-usps-row">
            <?php for($i=1; $i<=3; $i++) : ?>
                <div class="gw-usp-col">
                    <h4><?php echo esc_html($atts["t$i"]); ?></h4>
                    <p><?php echo esc_html($atts["d$i"]); ?></p>
                </div>
            <?php endfor; ?>
        </div>
    </div>
    <?php return ob_get_clean();
}

function gary_render_action_container_block( $atts, $content ) {
    ob_start(); ?>
    <div class="gw-process-block container">
        <?php if (!empty($atts['main_title'])) : ?>
            <h2 class="gw-block-main-title"><?php echo esc_html($atts['main_title']); ?></h2>
        <?php endif; ?>
        <div class="gw-process-row">
            <?php echo $content; ?>
        </div>
    </div>
    <?php return ob_get_clean();
}

function gary_render_action_step_block( $atts ) {
    $type = !empty($atts['step_type']) ? $atts['step_type'] : 'link';
    $num = !empty($atts['step_num']) ? $atts['step_num'] : '01';
    $title = !empty($atts['title']) ? $atts['title'] : '';
    $desc = !empty($atts['description']) ? $atts['description'] : '';
    $target_id = !empty($atts['target_page']) ? $atts['target_page'] : 0;
    $link = $target_id ? get_permalink($target_id) : '#';

    ob_start(); ?>
    <div class="gw-process-col">
        <span class="step-num"><?php echo esc_html($num); ?></span>
        <h4><?php echo esc_html($title); ?></h4>
        <p><?php echo esc_html($desc); ?></p>
        
        <div class="gw-step-action-wrap" style="margin-top:20px;">
            <?php if ( $type === 'availability' ) : ?>
                <div class="gw-availability-check">
                    <input type="date" id="gw-check-date-<?php echo esc_attr($num); ?>" class="gw-date-picker-input" style="padding:10px; border:1px solid #ddd; font-family:inherit; font-size:0.8rem;" />
                    <button type="button" class="btn-black-gold gw-check-availability-btn" data-step-id="<?php echo esc_attr($num); ?>" style="margin-left:10px; cursor:pointer;">Check Date</button>
                    <div id="gw-availability-result-<?php echo esc_attr($num); ?>" class="gw-avail-result" style="margin-top:10px; font-size:0.85rem; font-weight:700;"></div>
                </div>
            <?php else : ?>
                <a href="<?php echo esc_url($link); ?>" class="btn-black-gold">Begin Booking</a>
            <?php endif; ?>
        </div>
    </div>
    <?php return ob_get_clean();
}

// --- NEW RENDER CALLBACKS ---

function gary_render_hero_bleed_block( $atts, $content ) {
    $img_url = $atts['image_id'] ? wp_get_attachment_image_url($atts['image_id'], 'full') : $atts['image_url'];
    $opacity = isset($atts['overlay_opacity']) ? (int)$atts['overlay_opacity'] : 10;
    ob_start(); ?>
    <div class="gw-hero-bleed alignfull" style="background-image: url('<?php echo esc_url($img_url); ?>');">
        <div class="gw-hero-bleed-overlay" style="background: rgba(0,0,0,<?php echo $opacity/100; ?>);"></div>
        <div class="gw-hero-bleed-content container">
            <?php echo $content; ?>
        </div>
    </div>
    <?php return ob_get_clean();
}

function gary_render_storyteller_grid_block( $atts ) {
    ob_start(); ?>
    <div class="gw-storyteller-grid container">
        <?php for($i=1; $i<=4; $i++) : 
            $img_id = !empty($atts["img{$i}_id"]) ? $atts["img{$i}_id"] : 0;
            $url = $img_id ? wp_get_attachment_image_url($img_id, 'large') : 'data:image/svg+xml;utf8,%3Csvg width="100%25" height="100%25" xmlns="http://www.w3.org/2000/svg"%3E%3Crect width="100%25" height="100%25" fill="%23eee"/%3E%3C/svg%3E';
        ?>
            <div class="gw-story-item">
                <img src="<?php echo esc_url($url); ?>" alt="" />
            </div>
        <?php endfor; ?>
    </div>
    <?php return ob_get_clean();
}

function gary_render_testimonial_quote_block( $atts, $content ) {
    $img_url = $atts['image_id'] ? wp_get_attachment_image_url($atts['image_id'], 'full') : $atts['image_url'];
    ob_start(); ?>
    <div class="gw-testimonial-quote-block alignfull" style="background-image: url('<?php echo esc_url($img_url); ?>');">
        <div class="gw-testimonial-overlay"></div>
        <div class="container">
            <div class="gw-testimonial-inner">
                <?php echo $content; ?>
            </div>
        </div>
    </div>
    <?php return ob_get_clean();
}

function gary_render_polaroid_frame_block( $atts, $content ) {
    return '<div class="gw-polaroid-frame container">' . $content . '</div>';
}

function gary_render_cta_fullwidth_block( $atts, $content ) {
    $img_url = $atts['image_id'] ? wp_get_attachment_image_url($atts['image_id'], 'full') : $atts['image_url'];
    ob_start(); ?>
    <div class="gw-cta-fullwidth alignfull" style="background-image: url('<?php echo esc_url($img_url); ?>');">
        <div class="gw-cta-fullwidth-overlay"></div>
        <div class="container">
            <div class="gw-cta-fullwidth-content">
                <?php echo $content; ?>
            </div>
        </div>
    </div>
    <?php return ob_get_clean();
}

function gary_render_styled_list_box( $atts, $content ) {
    $type = !empty($atts['type']) ? $atts['type'] : 'highlights';
    $class = "gw-list-box is-style-{$type}";
    return "<div class='{$class}'><div class='gw-list-box-inner'>{$content}</div></div>";
}

function gary_register_custom_block_styles() {
    register_block_style( 'core/list', array( 'name' => 'gw-highlights', 'label' => __( 'Highlights (Gold Ticks)', 'garywedding' ) ));
    register_block_style( 'core/list', array( 'name' => 'gw-included', 'label' => __( 'What\'s Included (Plus)', 'garywedding' ) ));
    register_block_style( 'core/list', array( 'name' => 'gw-perfect-for', 'label' => __( 'Perfect For (Diamonds)', 'garywedding' ) ));
}
add_action( 'init', 'gary_register_custom_block_styles' );
function gary_render_check_date_atomic( $atts ) {
    $title = !empty($atts['title']) ? $atts['title'] : 'Check Your Date!';
    $desc = !empty($atts['description']) ? $atts['description'] : 'Select your wedding date...';
    $duration = !empty($atts['duration']) ? $atts['duration'] : 'Full Day';
    $target_id = !empty($atts['target_page_id']) ? $atts['target_page_id'] : 0;
    $link = $target_id ? get_permalink($target_id) : '#';

    ob_start(); ?>
    <div class="gw-process-block container gw-atomic-check-wrap">
        <div class="gw-process-col is-atomic-check condensed-check" style="max-width: 500px; margin: 0 auto; border: 2px solid var(--brand-gold-light); padding: 50px 30px; text-align:center;">
            <h4 style="margin-top: 0;"><?php echo esc_html($title); ?></h4>
            <p style="margin-bottom: 25px; opacity:0.8; font-size: 0.9rem;"><?php echo esc_html($desc); ?></p>
            
            <div class="gw-availability-box-inner" style="display: inline-block; width: 100%; max-width: 320px; border-top: 1px solid rgba(0,0,0,0.05); padding-top: 25px;">
                <div class="gw-duration-badge" style="text-transform:uppercase; letter-spacing:2px; font-size:0.7rem; font-weight:700; color:var(--brand-accent); margin-bottom:15px;">
                    Duration: <?php echo esc_html($duration); ?>
                </div>

                <div class="gw-input-with-icon" style="position: relative; margin-bottom: 20px;">
                    <input type="date" id="gw-atomic-check-date" class="gw-date-picker-input" style="padding:12px 12px 12px 40px; border:1px solid #ddd; font-family:inherit; font-size:1.1rem; width:100%; text-align:center; box-sizing:border-box;" />
                    <span class="gw-calendar-icon" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); opacity: 0.5;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/></svg>
                    </span>
                </div>
                
                <div style="display: flex; flex-direction: column; gap: 10px; align-items: center;">
                    <button type="button" 
                            class="btn-black-gold gw-check-availability-btn-atomic" 
                            data-duration="<?php echo esc_attr($duration); ?>"
                            style="cursor:pointer; width: 100%;">Check Availability</button>
                    
                    <a href="<?php echo esc_url($link); ?>" 
                       id="gw-atomic-booking-cta" 
                       class="btn-black-gold" 
                       style="display: none; background: #000; color: #fff; width: 100%; text-decoration:none; align-items:center; justify-content:center;">
                       Book Now
                    </a>
                </div>

                <div id="gw-atomic-availability-result" class="gw-avail-result" style="margin-top:20px; font-size:1rem; font-weight:700;"></div>
            </div>
        </div>
    </div>
    <?php return ob_get_clean();
}
function gary_render_triplet_container( $atts, $content ) {
    ob_start(); ?>
    <div class="gw-editorial-triplet-wrap container">
        <div class="gw-triplet-row">
            <?php echo $content; ?>
        </div>
    </div>
    <?php return ob_get_clean();
}

function gary_render_triplet_item( $atts, $content ) {
    $heading = !empty($atts['heading']) ? $atts['heading'] : '';
    $text    = !empty($atts['text']) ? $atts['text'] : '';
    ob_start(); ?>
    <div class="gw-triplet-item">
        <div class="gw-triplet-inner">
            <?php if ( $heading ) : ?>
                <h3 class="triplet-heading"><?php echo esc_html($heading); ?></h3>
                <div class="triplet-h-rule"></div>
            <?php endif; ?>
            
            <?php if ( $text ) : ?>
                <div class="triplet-body-text"><?php echo wp_kses_post($text); ?></div>
                <div class="triplet-h-rule"></div>
            <?php endif; ?>
            
            <div class="triplet-list-content">
                <?php echo $content; ?>
            </div>
        </div>
    </div>
    <?php return ob_get_clean();
}
