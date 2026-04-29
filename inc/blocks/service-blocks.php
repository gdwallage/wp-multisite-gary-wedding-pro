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
            'subtitle'      => array( 'type' => 'string', 'default' => '' ),
            'title'         => array( 'type' => 'string', 'default' => 'Ready to tell your story?' ),
            'content'       => array( 'type' => 'string', 'default' => 'I take on a limited number of weddings each year to ensure every couple receives my full creative energy. Let’s chat about your plans.' ),
            'btn_text'      => array( 'type' => 'string', 'default' => 'Inquire Now' ),
            'btn_text_2'    => array( 'type' => 'string', 'default' => 'Book Consultation' ),
            'contact_email' => array( 'type' => 'string', 'default' => '' ),
            'btn_url'       => array( 'type' => 'string', 'default' => '/booking/' )
        )
    ));

    // 19. Visual Navigation Wall (Tessellated Menu)
    register_block_type('gw/tessellated-menu', array(
        'render_callback' => 'gary_render_tessellated_menu',
        'category' => 'gary-editorial-native',
        'attributes' => array(
            'menu_slug' => array( 'type' => 'string', 'default' => 'primary' ),
            'height'    => array( 'type' => 'string', 'default' => '600px' )
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
            'service_id'  => array('type' => 'string', 'default' => ''),
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
        /* 1. FORCE THE EDITOR IFRAME TO BEHAVE */
        html, body, .editor-styles-wrapper { background: var(--brand-bg) !important; }
        .editor-styles-wrapper { padding: 0 !important; }
        .is-root-container { max-width: 100% !important; padding: 0 !important; }
        .wp-block-post-content { max-width: 100% !important; margin: 0 !important; }
        
        /* 2. CORE BLOCK CONSTRAINTS (80% Parity) */
        .wp-block-post-content > *:not(.alignfull):not(.gw-trust-bar):not([data-type^="gw/"]) {
            max-width: var(--editorial-width) !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }

        /* 3. HERO SLIDER PLACEHOLDER (FRONT PAGE ONLY) */
        .editor-post-title__block::before {
            content: "FRONT PAGE HERO SLIDER (ACTIVE)";
            display: flex; background: #11110e; color: var(--brand-gold-light); height: 200px;
            align-items: center; justify-content: center; font-family: var(--font-primary);
            letter-spacing: 5px; text-transform: uppercase; font-weight: 700; margin-bottom: 40px;
            border: 2px solid var(--brand-gold-light); opacity: 0.8;
        }
        
        /* 4. CUSTOM BLOCK PARITY (Aggressive Unboxing) */
        .wp-block[data-type^="gw/"] { 
            max-width: 100% !important; 
            width: 100% !important;
            margin: 0 !important; 
        }

        /* 5. Z-PATTERN PARITY (Forced Row) */
        .wp-block[data-type="gw/z-pattern"] .gw-z-pattern { 
            display: flex !important; 
            flex-direction: row !important;
            align-items: center !important; 
            width: var(--editorial-width) !important;
            margin: 80px auto !important;
            max-width: var(--site-max-width) !important;
        }
        .wp-block[data-type="gw/z-pattern"] .gw-z-pattern.is-right { flex-direction: row-reverse !important; }
        .wp-block[data-type="gw/z-pattern"] .gw-z-image { flex: 0 0 35% !important; max-width: 35% !important; }
        .wp-block[data-type="gw/z-pattern"] .gw-z-content { 
            flex: 1 !important; margin-left: -5% !important; background: #fff !important; 
            padding: 40px !important; border: 2px solid var(--brand-gold-light) !important; 
            z-index: 10 !important; box-shadow: var(--shadow-soft) !important;
        }
        .wp-block[data-type="gw/z-pattern"] .gw-z-pattern.is-right .gw-z-content { margin-left: 0 !important; margin-right: -5% !important; }
        
        /* Image Height Constraint (70vh Rule) */
        .wp-block[data-type^="gw/"] img { max-height: 70vh !important; object-fit: cover !important; }

        /* 6. FEATURED SERVICES GRID PARITY */
        .wp-block[data-type="gw/service-grid"] .services-grid { 
            display: grid !important; 
            grid-template-columns: repeat(3, 1fr) !important; 
            gap: 40px !important; 
            width: var(--editorial-width) !important; 
            margin: 80px auto !important;
            max-width: var(--site-max-width) !important;
        }

        /* 7. TRIO GALLERY PARITY */
        .wp-block[data-type="gw/trio-gallery"] .gw-trio-gallery { 
            display: flex !important; 
            gap: 20px !important; 
            width: var(--editorial-width) !important;
            margin: 80px auto !important;
        }
        .wp-block[data-type="gw/trio-gallery"] .gw-trio-main { flex: 1.5 !important; }
        .wp-block[data-type="gw/trio-gallery"] .gw-trio-side { flex: 1 !important; display: flex !important; flex-direction: column !important; gap: 20px !important; }

        /* 8. CTA PLAQUE PARITY */
        .wp-block[data-type="gw/cta-plaque"] .investment-plaque {
            width: 500px !important; margin: 80px auto !important;
            background: #fff !important; border: 2px solid var(--brand-gold-light) !important;
            padding: 40px !important; text-align: center !important;
        }

        .editor-styles-wrapper a { pointer-events: none !important; }
    </style>';
}
add_action( 'admin_head', 'gary_wedding_editor_grid_fix' );
add_action( 'enqueue_block_editor_assets', function() {
    wp_add_inline_style( 'gary-editorial-blocks-js', '
        .wp-block[data-type^="gw/"] { max-width: 100% !important; width: 100% !important; }
        .is-root-container { max-width: 100% !important; }
    ');
});

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
                    <div class="service-card-ribbon">SAVING £<?php echo number_format($card_data['savings'], 0); ?></div>
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
    static $modal_injected = false;
    $email    = !empty($atts['contact_email']) ? $atts['contact_email'] : get_option('admin_email');
    $title    = !empty($atts['title']) ? $atts['title'] : 'Ready to tell your story?';
    $content  = !empty($atts['content']) ? $atts['content'] : 'I take on a limited number of weddings each year to ensure every couple receives my full creative energy. Let’s chat about your plans.';
    $btn1     = !empty($atts['btn_text']) ? $atts['btn_text'] : 'Inquire Now';

    ob_start(); ?>
    <div class="gw-cta-plaque-rebuilt container" style="margin: 80px auto; max-width: 500px;">
        <div class="investment-plaque" style="text-align: center; position: relative; overflow: hidden;">
            <div class="plaque-decorative-label" style="font-family: var(--font-script); font-size: 2.2rem; color: var(--brand-gold-light); margin-bottom: -15px; opacity: 0.6;">Enquire</div>
            <h3 class="plaque-title" style="margin-bottom:20px; font-size:1.1rem; text-transform:uppercase; letter-spacing:2px; color:var(--brand-text);"><?php echo esc_html($title); ?></h3>
            
            <div class="cta-plaque-body" style="font-size: 0.95rem; opacity: 0.8; margin-bottom: 30px; line-height: 1.8; padding: 0 10%;">
                <?php echo esc_html($content); ?>
            </div>

            <div class="investment-buttons">
                <a href="javascript:void(0)" class="btn-black-gold gw-request-modal-trigger" 
                   data-email="<?php echo esc_attr($email); ?>"
                   data-service="<?php echo esc_attr($title); ?>"
                   style="display: inline-flex; align-items: center; gap: 10px; justify-content: center; width: auto; min-width: 200px;">
                    <?php echo esc_html($btn1); ?>
                    <span style="font-size: 1.2rem; line-height: 1;">&rarr;</span>
                </a>
            </div>
        </div>
    </div>

    <?php 
    // Modal HTML (Only once per page)
    if ( ! $modal_injected ) : $modal_injected = true; ?>
        <div id="gw-request-modal" class="gw-modal" style="display:none; position:fixed; inset:0; z-index:10000; align-items:center; justify-content:center;">
            <div class="gw-modal-overlay" style="position:absolute; inset:0; background:rgba(0,0,0,0.85); backdrop-filter:blur(5px);"></div>
            <div class="gw-modal-content gw-editorial-gold-box" style="position:relative; z-index:2; max-width:500px; width:90%; background:#fff; padding:40px; border:2px solid var(--brand-gold-light); box-shadow:var(--shadow-deep);">
                <span class="gw-modal-close" style="position:absolute; top:20px; right:20px; font-size:30px; cursor:pointer; line-height:1; color:var(--brand-gold-light);">&times;</span>
                <h3 style="text-align:center; text-transform:uppercase; letter-spacing:3px; margin-bottom:10px; color:var(--brand-accent);">Enquiry</h3>
                <p class="modal-service-name" style="text-align:center; font-size:0.9rem; opacity:0.7; margin-bottom:30px;"></p>
                
                <form id="gw-request-form">
                    <input type="hidden" name="action" value="gw_submit_request">
                    <input type="hidden" name="target_email" id="modal-target-email">
                    <input type="hidden" name="service_name" id="modal-service-name-input">
                    
                    <div style="margin-bottom:20px;">
                        <label style="display:block; font-size:0.75rem; text-transform:uppercase; letter-spacing:2px; font-weight:700; margin-bottom:8px; opacity:0.6;">Your Name</label>
                        <input type="text" name="user_name" required style="width:100%; padding:12px; border:1px solid #ddd; font-family:var(--font-primary);">
                    </div>
                    <div style="margin-bottom:20px;">
                        <label style="display:block; font-size:0.75rem; text-transform:uppercase; letter-spacing:2px; font-weight:700; margin-bottom:8px; opacity:0.6;">Email Address</label>
                        <input type="email" name="user_email" required style="width:100%; padding:12px; border:1px solid #ddd; font-family:var(--font-primary);">
                    </div>
                    <div style="margin-bottom:25px;">
                        <label style="display:block; font-size:0.75rem; text-transform:uppercase; letter-spacing:2px; font-weight:700; margin-bottom:8px; opacity:0.6;">Message / Note</label>
                        <textarea name="user_note" rows="4" style="width:100%; padding:12px; border:1px solid #ddd; font-family:var(--font-primary);"></textarea>
                    </div>
                    
                    <button type="submit" class="btn-black-gold" style="width:100%; border:none; padding:18px; cursor:pointer;">Send Request</button>
                    <div class="gw-form-status" style="margin-top:20px; text-align:center; font-weight:700; font-size:0.9rem;"></div>
                </form>
            </div>
        </div>

    <?php endif; ?>

    <?php return ob_get_clean();
}

function gary_render_tessellated_menu( $atts ) {
    $slug = !empty($atts['menu_slug']) ? $atts['menu_slug'] : 'primary';
    $height = !empty($atts['height']) ? $atts['height'] : '600px';
    
    // Get menu items by location or slug
    $locations = get_nav_menu_locations();
    $menu_id = isset($locations[$slug]) ? $locations[$slug] : 0;
    
    if ( ! $menu_id ) {
        $menu = get_term_by('slug', $slug, 'nav_menu');
        $menu_id = $menu ? $menu->term_id : 0;
    }

    $items = wp_get_nav_menu_items( $menu_id );
    if ( ! $items ) return is_admin() ? '<div style="padding:40px; background:#eee; text-align:center;">No menu items found for slug: ' . esc_html($slug) . '</div>' : '';

    ob_start(); ?>
    <div class="gw-tessellated-wall alignfull" style="--wall-height: <?php echo esc_attr($height); ?>;">
        <div class="gw-tessellation-grid">
            <?php 
            $count = 0;
            foreach ( $items as $item ) : 
                if ( $item->menu_item_parent ) continue; // Only top level
                $count++;
                $post_id = $item->object_id;
                $img_url = get_the_post_thumbnail_url( $post_id, 'large' );
                if ( ! $img_url ) {
                    // Fallback to a placeholder or a default wedding image
                    $img_url = 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&q=80&w=1000';
                }
                
                // Complex Tessellation Pattern
                $span_class = '';
                if ( $count % 8 == 1 ) $span_class = 'span-2-2'; // Large Feature
                elseif ( $count % 8 == 3 ) $span_class = 'span-1-2'; // Tall
                elseif ( $count % 8 == 6 ) $span_class = 'span-2-1'; // Wide
                ?>
                <a href="<?php echo esc_url($item->url); ?>" class="gw-wall-tile <?php echo $span_class; ?>">
                    <div class="tile-image" style="background-image: url('<?php echo esc_url($img_url); ?>');"></div>
                    <div class="tile-overlay">
                        <div class="tile-content">
                            <span class="tile-subtitle"><?php echo esc_html($count < 10 ? '0'.$count : $count); ?></span>
                            <h3 class="tile-title"><?php echo esc_html($item->title); ?></h3>
                            <span class="tile-btn">View Details</span>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php return ob_get_clean();
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
    $service_id = !empty($atts['service_id']) ? $atts['service_id'] : 0;
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
                    <button type="button" class="btn-black-gold gw-check-availability-btn" data-step-id="<?php echo esc_attr($num); ?>" data-duration="<?php echo esc_attr($service_id); ?>" style="margin-left:10px; cursor:pointer;">Check Date</button>
                    <div id="gw-availability-result-<?php echo esc_attr($num); ?>" class="gw-avail-result" style="margin-top:10px; font-size:0.85rem; font-weight:700;"></div>
                    <a href="<?php echo esc_url($link); ?>" id="gw-step-booking-cta-<?php echo esc_attr($num); ?>" class="btn-black-gold" style="display: none; margin-top:10px;">
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


