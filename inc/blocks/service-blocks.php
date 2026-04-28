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
            'image_size' => array( 'type' => 'string', 'default' => 'medium_large' )
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
            'image_size' => array( 'type' => 'string', 'default' => 'medium_large' )
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
            'title'         => array( 'type' => 'string', 'default' => 'Ready to Secure Your Date?' ),
            'content'       => array( 'type' => 'string', 'default' => 'I take on a limited number of weddings each year.' ),
            'btn_text'      => array( 'type' => 'string', 'default' => 'Contact Me' ),
            'contact_email' => array( 'type' => 'string', 'default' => '' ),
            'btn_url'       => array( 'type' => 'string', 'default' => '' ) // Legacy — kept for BC
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
            'step_num'    => array('type' => 'string', 'default' => '01'),
            'msg_available'  => array('type' => 'string', 'default' => ""),
            'msg_tentative'  => array('type' => 'string', 'default' => "")
        )
    ));

    // 12. Atomic Check Your Date Block
    register_block_type('gw/check-date-atomic', array(
        'render_callback' => 'gary_render_check_date_atomic',
        'category' => 'gary-editorial-native',
        'attributes' => array(
            'title'          => array('type' => 'string', 'default' => 'Check Your Date!'),
            'description'    => array('type' => 'string', 'default' => 'Select your wedding date to see if I am available for your celebration.'),
            'service_id'     => array('type' => 'string', 'default' => ''),
            'target_page_id' => array('type' => 'number', 'default' => 0),
            'msg_available'  => array('type' => 'string', 'default' => "Excellent... Now let's book your FREE wedding consultation to discuss this in detail."),
            'msg_tentative'  => array('type' => 'string', 'default' => "I may be free! I have restricted hours on this day, but I may be able to rearrange plans for your wedding. Please book a FREE consultation to discuss.")
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

    // 20. Dual Column Container
    register_block_type('gw/editorial-dual-column', array(
        'render_callback' => 'gary_render_dual_column_block',
        'category' => 'gary-editorial-native',
    ));

}

add_action('init', 'gary_register_service_blocks');

// Category Registration
function gary_register_block_categories( $categories, $post ) {
    return array_merge( array( array( 'slug' => 'gary-editorial-native', 'title' => __( 'Gary Wallage Wedding', 'garywedding' ), 'icon' => 'star-filled' ) ), $categories );
}
add_filter( 'block_categories_all', 'gary_register_block_categories', 10, 2 );

function gary_localize_block_data() {
    global $wpdb;
    $options = array( array( 'label' => '-- Select Service --', 'value' => '' ) );
    $table_name = $wpdb->prefix . 'bookly_services';
    if ( $wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name ) {
        $services = $wpdb->get_results( "SELECT id, title FROM $table_name ORDER BY title ASC" );
        if ( is_array($services) ) {
            foreach ( $services as $s ) { $options[] = array('label' => $s->title, 'value' => (string) $s->id); }
        }
    }
    wp_localize_script( 'gary-editorial-blocks-js', 'garyBooklyServiceOptions', $options );

    // Localize Page Options for CTAs (Performance Optimized)
    $page_options = array( array( 'label' => '-- Select Page --', 'value' => 0 ) );
    $query = new WP_Query( array(
        'post_type'      => 'page',
        'post_status'    => 'publish',
        'posts_per_page' => 150, // Safety limit to prevent editor crashes
        'fields'         => 'ids',
        'no_found_rows'  => true,
        'orderby'        => 'title',
        'order'          => 'ASC',
    ) );
    
    if ( $query->have_posts() ) {
        foreach ( $query->posts as $p_id ) {
            $page_options[] = array( 'label' => get_the_title($p_id), 'value' => (int)$p_id );
        }
    }
    wp_reset_postdata();
    
    wp_localize_script( 'gary-editorial-blocks-js', 'garyPageOptions', $page_options );
}
add_action( 'enqueue_block_editor_assets', 'gary_localize_block_data', 20 );


if ( ! function_exists( 'gary_wedding_editor_grid_fix' ) ) :
function gary_wedding_editor_grid_fix() {
    echo '<style id="gary-editor-grid-fix">
        /* Unbox wrappers */
        .wp-block-gw-single-service { display: contents !important; }
        .wp-block-gw-single-service > div { display: contents !important; }
        
        /* -------------------------------------------------------
           FEATURED SERVICES GRID — Editor parity with live site
           The JS editor wraps InnerBlocks in .gw-grid-container > .services-grid
           We must unbox the block-editor intermediate elements so the grid
           columns flow correctly.
        ------------------------------------------------------- */
        @media (min-width: 1024px) {
            /* The outer GW block wrapper must not interfere */
            .wp-block[data-type="gw/service-grid"] { max-width: 100% !important; }

            /* The editor div.gw-grid-container itself becomes the 3-col grid */
            .editor-styles-wrapper .gw-grid-container {
                display: block !important;
            }
            /* The .services-grid inside the editor matches live: 3-col */
            .editor-styles-wrapper .services-grid {
                display: grid !important;
                grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
                gap: 20px !important;
                width: 100% !important;
                row-gap: 40px !important;
            }
            /* Unwrap the block-editor inner layers so cards sit directly in grid */
            .editor-styles-wrapper .services-grid > .block-editor-inner-blocks,
            .editor-styles-wrapper .services-grid > .block-editor-inner-blocks > .block-editor-block-list__layout {
                display: contents !important;
            }
        }

        /* Disable Clickability in Editor */
        .editor-styles-wrapper a.service-card-link { pointer-events: none !important; cursor: default !important; }
        .editor-styles-wrapper .service-card-link * { pointer-events: none !important; }

        .editor-styles-wrapper .service-card { border: var(--gold-frame-border) solid var(--brand-gold-light) !important; background: var(--brand-white) !important; height: 100% !important; }

        /* Force our blocks to use full editor width so internal constraints work */
        .wp-block[data-type^="gw/"] { max-width: 100% !important; }

        /* Z-Pattern Editor Alignment */
        .wp-block[data-type="gw/z-pattern"] > div { 
            display: flex !important; 
            align-items: center !important; 
            width: 80% !important;
            margin: 40px auto !important;
        }
        .wp-block[data-type="gw/z-pattern"] > div.is-right { flex-direction: row-reverse !important; }
        .wp-block[data-type="gw/z-pattern"] .gw-z-image { flex: 0 0 38% !important; max-width: 38% !important; }
        .wp-block[data-type="gw/z-pattern"] .gw-z-content { 
            flex: 1 !important; 
            margin-left: -5% !important; 
            z-index: 10 !important; 
            background: #fff; 
            padding: 38px 48px !important; 
            border: 2px solid #C5A059 !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: center !important;
        }
        .wp-block[data-type="gw/z-pattern"] > div.is-right .gw-z-content { margin-left: 0 !important; margin-right: -5% !important; }

        /* Trio Gallery Alignment */
        .wp-block[data-type="gw/trio-gallery"] > div { width: 80% !important; margin: 40px auto !important; }
        .wp-block[data-type="gw/trio-gallery"] .gw-trio-gallery { display: flex !important; gap: 20px !important; align-items: stretch !important; }
        .wp-block[data-type="gw/trio-gallery"] .gw-trio-main { flex: 0 0 48% !important; }
        .wp-block[data-type="gw/trio-gallery"] .gw-trio-side { flex: 1 !important; display: flex !important; flex-direction: column !important; gap: 20px !important; }

        /* USPs Spacing Fix */
        .wp-block[data-type="gw/usps-3col"] { margin-top: 0 !important; margin-bottom: 0 !important; padding: 0 !important; }
        
        /* Check Your Date (Action Steps) */
        .wp-block[data-type="gw/action-step-container"] > div { width: 80% !important; margin: 40px auto !important; }
    </style>';
}
add_action( 'admin_head', 'gary_wedding_editor_grid_fix' );
endif;

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
    if ( empty($card_data) || !is_array($card_data) ) return '';

    if ($layout === 'horizontal') : 
        ob_start(); ?>
        <a href="<?php echo esc_url($card_data['permalink']); ?>" class="component-card style-bookly-service">
            <div class="service-card-image" style="flex: 0 0 120px; padding: 10px; border: 2px solid var(--brand-gold-light); margin-right: 25px; border-radius: 0 !important;">
                <?php if($card_data['icon']): ?><img src="<?php echo esc_url($card_data['icon']); ?>" style="border-radius: 0 !important;" loading="lazy" decoding="async" /><?php endif; ?>
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
    $img_html = '';
    if ( $img_id ) {
        $img_html = wp_get_attachment_image( $img_id, $size, false, array( 'loading' => 'lazy', 'decoding' => 'async' ) );
    } elseif ( !empty($attributes['image_url']) ) {
        $img_html = '<img src="' . esc_url($attributes['image_url']) . '" alt="" loading="lazy" decoding="async" />';
    }
    ob_start(); ?>
    <div class="gw-z-pattern container is-<?php echo esc_attr($pos); ?>">
        <div class="gw-z-image"><?php echo $img_html; ?></div>
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
            <div class="gw-trio-main">
                <?php if(!empty($attributes['img1_id'])) echo wp_get_attachment_image($attributes['img1_id'], $attributes['img1_size'] ?: 'large'); ?>
            </div>
            <div class="gw-trio-side">
                <div class="gw-trio-top">
                    <?php if(!empty($attributes['img2_id'])) echo wp_get_attachment_image($attributes['img2_id'], $attributes['img2_size'] ?: 'medium'); ?>
                </div>
                <div class="gw-trio-bottom">
                    <?php if(!empty($attributes['img3_id'])) echo wp_get_attachment_image($attributes['img3_id'], $attributes['img3_size'] ?: 'medium'); ?>
                </div>
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
        <div class="gw-split-media">
            <?php if($img_id) echo wp_get_attachment_image($img_id, $size); ?>
        </div>
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
    // Use the block's explicitly set email, fall back to site admin email
    $email = !empty($atts['contact_email']) ? $atts['contact_email'] : get_option('admin_email');
    $service = get_the_title();
    $subject = urlencode( 'Wedding Photography Enquiry — ' . $service );
    $mailto  = 'mailto:' . esc_attr( $email ) . '?subject=' . $subject;

    return '
    <div class="gw-cta-plaque gw-editorial-gold-box container" style="background: var(--brand-white); border: 2px solid var(--brand-gold-light); padding: 50px; text-align: center; box-shadow: var(--shadow-deep); margin: 60px auto; max-width: 800px;">
        <h3 style="font-family: var(--font-primary); font-size: 2rem; text-transform: uppercase; letter-spacing: 3px; color: var(--brand-gold-light); margin-bottom: 20px;">' . esc_html($atts['title']) . '</h3>
        <p style="font-size: 1.1rem; opacity: 0.8; margin-bottom: 40px;">' . esc_html($atts['content']) . '</p>
        <div class="gw-cta-btn-wrap">
            <a href="' . esc_url($mailto) . '" class="btn-black" style="display:inline-flex; align-items:center; gap:10px; padding:16px 36px; text-decoration:none; letter-spacing:2px; font-size:0.85rem;">'
                . esc_html($atts['btn_text']) .
            '</a>
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
        <h3><?php echo esc_html($title); ?></h3>
        <p><?php echo esc_html($desc); ?></p>
        
        <div class="gw-step-action-wrap" style="margin-top:15px;">
            <?php if ( $type === 'availability' ) : 
                $msg_available = !empty($atts['msg_available']) ? $atts['msg_available'] : '';
                $msg_tentative = !empty($atts['msg_tentative']) ? $atts['msg_tentative'] : '';
            ?>
                <div class="gw-availability-check" 
                     data-msg-available="<?php echo esc_attr($msg_available); ?>"
                     data-msg-tentative="<?php echo esc_attr($msg_tentative); ?>">
                    <input type="date" aria-label="Select your preferred date" id="gw-check-date-<?php echo esc_attr($num); ?>" class="gw-date-picker-input" style="padding:10px; border:1px solid #ddd; font-family:inherit; font-size:0.8rem;" />
                    <button type="button" class="btn-black-gold gw-check-availability-btn" data-step-id="<?php echo esc_attr($num); ?>" style="margin-left:10px; cursor:pointer;">Check Date</button>
                    <div id="gw-availability-result-<?php echo esc_attr($num); ?>" class="gw-avail-result" style="margin-top:10px; font-size:0.85rem; font-weight:700;"></div>
                        <input type="date" 
                               id="gw-check-date-atomic" 
                               aria-label="Select your preferred date"
                               value="<?php echo date('Y-m-d'); ?>" 
                               min="<?php echo date('Y-m-d'); ?>"
                               class="gw-date-picker-atomic" 
                               style="width: 100%; padding: 10px; border: 1px solid #ccc; font-family: inherit; font-size: 16px; margin-bottom: 5px;">
                       Book Free Consultation
                    </a>
                </div>
            <?php else : ?>
                <a href="<?php echo esc_url($link); ?>" class="btn-black-gold">Book Free Consultation</a>
            <?php endif; ?>
        </div>
    </div>
    <?php return ob_get_clean();
}

// --- NEW RENDER CALLBACKS ---

function gary_render_hero_bleed_block( $atts, $content ) {
    $img_id = !empty($atts['image_id']) ? $atts['image_id'] : 0;
    $img_url = $img_id ? wp_get_attachment_image_url($img_id, 'gw-hero') : (!empty($atts['image_url']) ? $atts['image_url'] : '');
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
            $url = $img_id ? wp_get_attachment_image_url($img_id, 'medium_large') : 'data:image/svg+xml;utf8,%3Csvg width="100%25" height="100%25" xmlns="http://www.w3.org/2000/svg"%3E%3Crect width="100%25" height="100%25" fill="%23eee"/%3E%3C/svg%3E';
        ?>
            <div class="gw-story-item">
                <img src="<?php echo esc_url($url); ?>" alt="" loading="lazy" decoding="async" />
            </div>
        <?php endfor; ?>
    </div>
    <?php return ob_get_clean();
}

function gary_render_testimonial_quote_block( $atts, $content ) {
    $img_id = !empty($atts['image_id']) ? $atts['image_id'] : 0;
    $img_url = $img_id ? wp_get_attachment_image_url($img_id, 'gw-hero') : (!empty($atts['image_url']) ? $atts['image_url'] : '');
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
    $img_id = !empty($atts['image_id']) ? $atts['image_id'] : 0;
    $img_url = $img_id ? wp_get_attachment_image_url($img_id, 'gw-hero') : (!empty($atts['image_url']) ? $atts['image_url'] : '');
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
    
    // Sanitize: Remove empty <li> tags or tags with only whitespace/nbsp/br
    $content = preg_replace('/<li[^>]*>(?:\s|&nbsp;|<br\s*\/?>)*<\/li>/i', '', $content);

    
    return "<div class='{$class}'><div class='gw-list-box-inner'>{$content}</div></div>";
}


function gary_render_dual_column_block( $atts, $content ) {
    return '
    <div class="gw-dual-column-overview alignwide">
        <div class="gw-dual-column-row">
            ' . $content . '
        </div>
    </div>';
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
    $service_id = !empty($atts['service_id']) ? $atts['service_id'] : '';
    $target_id = !empty($atts['target_page_id']) ? $atts['target_page_id'] : 0;
    $link = $target_id ? get_permalink($target_id) : '#';
    
    // FETCH DYNAMIC SERVICE DETAILS
    $service_label = 'Select a service...';
    if ( $service_id ) {
        $s_data = gary_get_bookly_service_data( $service_id );
        if ( $s_data ) {
            $service_label = $s_data['title'];
            // STRIP PREFIX like "CW04 - "
            $service_label = preg_replace('/^[A-Z0-9]+\s*-\s*/', '', $service_label);
        }
    }

    $msg_available = !empty($atts['msg_available']) ? $atts['msg_available'] : '';
    $msg_tentative = !empty($atts['msg_tentative']) ? $atts['msg_tentative'] : '';

    ob_start(); ?>
    <div class="gw-process-block gw-atomic-check-wrap"
         data-msg-available="<?php echo esc_attr($msg_available); ?>"
         data-msg-tentative="<?php echo esc_attr($msg_tentative); ?>">
        <div class="gw-editorial-gold-box is-atomic-check">
            <h3 class="atomic-title"><?php echo esc_html($title); ?></h3>
            <p class="atomic-desc"><?php echo esc_html($desc); ?></p>
            
            <div class="gw-availability-box-inner">
                <div class="gw-service-looking-for">
                    <?php echo esc_html($service_label); ?>
                </div>

                <div class="gw-input-with-icon">
                    <input type="date" 
                           id="gw-atomic-check-date" 
                           aria-label="Select your preferred date"
                           value="<?php echo date('Y-m-d'); ?>" 
                           min="<?php echo date('Y-m-d'); ?>" 
                           class="gw-date-picker-input" />
                </div>
                
                <div class="gw-atomic-actions">
                    <button type="button" 
                            class="btn-black-gold gw-check-availability-btn-atomic" 
                            data-duration="<?php echo esc_attr($service_id); ?>">Check Availability</button>
                    
                    <a href="<?php echo esc_url($link); ?>" 
                       id="gw-atomic-booking-cta" 
                       class="btn-black-gold" 
                       style="display: none; width: 100%; text-decoration:none; align-items:center; justify-content:center;">
                       Book Free Consultation
                    </a>
                </div>

                <div id="gw-atomic-availability-result" class="gw-avail-result"></div>
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
                <?php 
                // Sanitize: Remove empty <li> tags (including whitespace and nbsp)
                echo preg_replace('/<li[^>]*>(?:\s|&nbsp;|<br\s*\/?>)*<\/li>/i', '', $content); 
                ?>
            </div>

        </div>
    </div>

    <?php return ob_get_clean();
}


