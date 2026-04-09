<?php

function gary_register_service_blocks() {
    
    // Register the container block
    register_block_type('gw/service-grid', array(
        'render_callback' => 'gary_render_service_grid_block',
        'attributes' => array(
            'grid_layout' => array(
                'type' => 'string',
                'default' => '3-cols'
            )
        )
    ));

    // Register the single dynamic block
    register_block_type('gw/single-service', array(
        'render_callback' => 'gary_render_single_service_block',
        'attributes' => array(
            'bookly_id' => array(
                'type' => 'string',
                'default' => ''
            ),
            'card_layout' => array(
                'type' => 'string',
                'default' => 'vertical'
            )
        )
    ));
}
add_action('init', 'gary_register_service_blocks');

// Register custom block category for the editor
function gary_register_block_categories( $categories, $post ) {
    return array_merge(
        array(
            array(
                'slug'  => 'gary-editorial-native',
                'title' => __( 'Gary Wallage Wedding', 'garywedding' ),
                'icon'  => 'star-filled',
            ),
        ),
        $categories
    );
}
add_filter( 'block_categories_all', 'gary_register_block_categories', 10, 2 );

function gary_register_custom_block_styles() {
    register_block_style( 'core/list', array(
        'name'         => 'gw-highlights',
        'label'        => __( 'Highlights (Gold Ticks)', 'garywedding' ),
        'inline_style' => '
            ul.is-style-gw-highlights { list-style: none; padding-left: 0; font-family: "Lato", sans-serif; font-size: 0.85rem; line-height: 1.7; color: var(--wedding-text); }
            ul.is-style-gw-highlights li { position: relative; padding-left: 20px; margin-bottom: 5px; }
            ul.is-style-gw-highlights li::before { content: "✓"; position: absolute; left: 0; color: var(--wedding-gold-light); }
        '
    ));
    register_block_style( 'core/list', array(
        'name'         => 'gw-included',
        'label'        => __( 'What\'s Included (Plus)', 'garywedding' ),
        'inline_style' => '
            ul.is-style-gw-included { list-style: none; padding-left: 0; font-family: "Lato", sans-serif; font-size: 0.85rem; line-height: 1.7; color: var(--wedding-text); border-top: 1px solid #eee; padding-top: 10px; }
            ul.is-style-gw-included li { position: relative; padding-left: 24px; margin-bottom: 10px; font-weight: 700; color: var(--wedding-gold-light); text-transform: uppercase; letter-spacing: 1px; }
            ul.is-style-gw-included li::before { content: "+"; position: absolute; left: 0; background: var(--wedding-gold-light); color: #fff; width: 14px; height: 14px; border-radius: 50%; font-size: 10px; line-height: 14px; text-align: center; }
            ul.is-style-gw-included li strong { color: #1a1a1a; margin-left: 5px; }
        '
    ));
    register_block_style( 'core/list', array(
        'name'         => 'gw-perfect-for',
        'label'        => __( 'Perfect For (Diamonds)', 'garywedding' ),
        'inline_style' => '
            ul.is-style-gw-perfect-for { list-style: none; padding-left: 0; font-family: "Lato", sans-serif; font-size: 0.95rem; font-style: italic; color: #555; }
            ul.is-style-gw-perfect-for li { position: relative; padding-left: 18px; margin-bottom: 8px; }
            ul.is-style-gw-perfect-for li::before { content: "⬦"; position: absolute; left: 0; color: var(--wedding-gold-light); font-size: 1.1rem; line-height: 1; top: 2px; }
        '
    ));
}
add_action( 'init', 'gary_register_custom_block_styles' );

function gary_enqueue_block_editor_assets() {
    wp_enqueue_script(
        'gw-service-blocks',
        get_template_directory_uri() . '/inc/blocks/service-blocks.js',
        array('wp-blocks', 'wp-element', 'wp-components', 'wp-block-editor', 'wp-server-side-render'),
        '1.0',
        true
    );

    // Get Bookly options
    global $wpdb;
    $options = array( array( 'label' => '-- Select Service --', 'value' => '' ) );
    
    $table_name = $wpdb->prefix . 'bookly_services';
    if ( $wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name ) {
        $services = $wpdb->get_results( "SELECT id, title FROM $table_name ORDER BY title ASC" );
        foreach ( $services as $s ) {
            $options[] = array(
                'label' => $s->title,
                'value' => (string) $s->id // Ensure it's a string, matching the attribute type
            );
        }
    }

    wp_localize_script( 'gw-service-blocks', 'garyBooklyServiceOptions', $options );
}
add_action( 'enqueue_block_editor_assets', 'gary_enqueue_block_editor_assets' );

function gary_wedding_editor_grid_fix() {
    echo '<style>
        .wp-block-gw-single-service { display: contents !important; }
        .editor-styles-wrapper .services-grid, .editor-styles-wrapper .components-grid { flex-wrap: wrap; }
    </style>';
}
add_action( 'admin_head', 'gary_wedding_editor_grid_fix' );

function gary_render_service_grid_block( $attributes, $content ) {
    $grid_layout = !empty($attributes['grid_layout']) ? $attributes['grid_layout'] : '3-cols';
    
    if ( $grid_layout === '2-cols' ) {
        // Output the 2-wide detailed components grid
        return '<div class="detailed-components-section"><div class="components-grid">' . $content . '</div></div>';
    } else {
        if ( is_admin() ) {
            return '<div class="detailed-components-section" style="margin-top:20px;"><div class="component-grid">' . $content . '</div></div>';
        }
        // On the frontend, vertical cards require the services-grid wrapper
        return '<div class="services-grid">' . $content . '</div>';
    }
}

function gary_render_single_service_block( $attributes ) {
    $b_id = !empty($attributes['bookly_id']) ? $attributes['bookly_id'] : '';
    $card_layout = !empty($attributes['card_layout']) ? $attributes['card_layout'] : 'vertical';
    
    if ( empty($b_id) ) {
        // Fallback for editor if rendering empty
        if ( is_admin() ) {
            return '<div style="padding: 20px; text-align: center; border: 1px dashed #ccc;">[gw/single-service] Please select a Bookly Service from the right sidebar.</div>';
        }
        return '';
    }

    // Attempt to fetch Bookly data
    $b_data = gary_get_bookly_service_data( $b_id );
    if ( !$b_data ) {
        return '<div style="padding: 20px; text-align: center; border: 1px dashed red;">Bookly Service not found or Bookly inactive.</div>';
    }

    // Try to find the mapped WP Page
    global $wpdb;
    $page_id = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_gary_bookly_id' AND meta_value = %s LIMIT 1", $b_id ) );

    $card_title  = $b_data['title'];
    $sub_price   = '';
    $is_free     = false;
    $display_duration = '';
    
    if ( (float) $b_data['price'] <= 0 ) {
        $sub_price = 'FREE';
        $is_free = true;
    } else {
        $sub_price = 'From £' . number_format( $b_data['price'], 0 );
    }
    if ( !empty($b_data['duration']) ) {
        $display_duration = 'Typically ' . $b_data['duration'];
    }

    $summary = array( 'savings' => 0, 'titles' => array(), 'included_str' => '' );
    $highlights = '';

    // If paired to a Page, use its details
    if ( $page_id ) {
        $sub_page    = get_post( $page_id );
        if ( ! $sub_page ) {
            $card_url    = '/booking/';
            $card_thumb  = ! empty( $b_data['image'] ) ? $b_data['image'] : '';
            $card_desc   = ! empty( $b_data['info'] ) ? $b_data['info'] : '';
        } else {
            $card_url    = get_permalink( $page_id );
            $card_thumb  = get_the_post_thumbnail_url( $page_id, 'large' );
            $summary     = gary_get_sub_service_summary( $page_id );
            $highlights  = get_post_meta( $page_id, '_gary_service_highlights', true );

            $manual_p    = get_post_meta( $page_id, '_gary_service_price', true );
            $manual_d    = get_post_meta( $page_id, '_gary_service_duration', true );
            
            if ( !$b_data && ! empty( $manual_p ) ) {
                if ( strtolower(trim($manual_p)) === 'free' || trim($manual_p) === '0' ) {
                    $is_free = true;
                    $sub_price = 'FREE';
                } else {
                    $sub_price = 'From £' . $manual_p;
                    $is_free = false;
                }
            }
            if ( !empty($manual_d) ) {
                $display_duration = 'Typically ' . $manual_d;
            }

            if ( ! empty( $b_data['info'] ) ) {
                $card_desc = $b_data['info'];
            } elseif ( ! empty( $sub_page->post_excerpt ) ) {
                $card_desc = '<p>' . $sub_page->post_excerpt . '</p>';
            } else {
                $card_desc = '<p>' . wp_trim_words( strip_shortcodes( $sub_page->post_content ), 30 ) . '</p>';
            }
        }
    } else {
        // Only Bookly details
        $card_url    = '/booking/';
        $card_thumb  = ! empty( $b_data['image'] ) ? $b_data['image'] : '';
        $card_desc   = ! empty( $b_data['info'] ) ? $b_data['info'] : '';
    }

    $logo_id = get_theme_mod( 'custom_logo' );
    $logo_url = $logo_id ? wp_get_attachment_image_url( $logo_id, 'full' ) : '';
    $final_thumb = $card_thumb ? $card_thumb : $logo_url;

    if ( $card_layout === 'horizontal' ) {
        // HORIZONTAL COMPONENT CARD (Used in page-service-detail grids)
        ob_start();
        ?>
        <a href="<?php echo esc_url( $card_url ); ?>" class="component-card style-bookly-service">
            <div class="coin-icon-wrap">
                <?php if ( $final_thumb ) : ?>
                    <img src="<?php echo esc_url( $final_thumb ); ?>" alt="" style="width:100%; height:100%; object-fit:cover; border-radius:50%;" />
                <?php else : ?>
                    <div class="faux-initial"><?php echo esc_html( substr( $card_title, 0, 1 ) ); ?></div>
                <?php endif; ?>
            </div>
            <div class="component-info">
                <h3><?php echo esc_html( $card_title ); ?></h3>
                <?php
                $subtitle = '';
                if ( !empty($summary['savings']) && $summary['savings'] > 0 && ! empty( $summary['titles'] ) ) {
                    $subtitle = 'Includes ' . count( $summary['titles'] ) . ' sub-services';
                } elseif ( $display_duration ) {
                    $subtitle = $display_duration;
                }
                if ( $subtitle ) {
                    echo '<div class="meta-row" style="font-size:0.8rem; color:#888; font-style:italic;">' . esc_html( $subtitle ) . '</div>';
                }

                if ( !empty($summary['savings']) && $summary['savings'] > 0 ) {
                    echo '<div class="component-includes" style="font-size:0.75rem; border-top:1px dashed #eee; margin-top:5px; padding-top:5px;">';
                    echo '<strong style="color:var(--wedding-crimson);">Save £' . number_format( $summary['savings'], 0 ) . '</strong> &nbsp;—&nbsp; ';
                    echo esc_html( implode( ', ', $summary['titles'] ) );
                    echo '</div>';
                } elseif ( ! empty( $card_desc ) ) {
                    echo '<div class="component-includes" style="font-size:0.8rem; color:#666; margin-top:5px;">' . wp_kses_post( wp_trim_words( $card_desc, 15 ) ) . '</div>';
                }
                ?>
            </div>
        </a>
        <?php
        return ob_get_clean();
    }

    // DEFAULT VERTICAL CARD (Used in page-services featured blocks)
    ob_start();
    ?>
    <a href="<?php echo esc_url( $card_url ); ?>" class="service-card-link">
        <div class="service-card">
            <?php if ( !empty($summary['savings']) && $summary['savings'] > 0 ) : ?>
                <div class="service-card-ribbon">SAVE £<?php echo number_format($summary['savings'],0); ?></div>
            <?php endif; ?>

            <div class="service-card-image">
                <?php if ( $final_thumb ) : ?>
                    <img src="<?php echo esc_url( $final_thumb ); ?>" alt="<?php echo esc_attr( $card_title ); ?>" />
                <?php else : ?>
                    <div class="fallback-placeholder">GW</div>
                <?php endif; ?>
            </div>

            <div class="service-card-content">
                <h2 class="service-card-title"><?php echo esc_html( $card_title ); ?></h2>
                
                <div class="service-card-price <?php echo $is_free ? 'is-free' : ''; ?>">
                    <span><?php echo esc_html($sub_price); ?></span>
                    <?php if($display_duration): ?>
                        <small class="duration-label"><?php echo esc_html($display_duration); ?></small>
                    <?php endif; ?>
                </div>

                <?php if ( ! empty( $summary['titles'] ) ) : ?>
                    <ul class="card-included-items">
                        <?php foreach ( $summary['titles'] as $inc_title ) : ?>
                            <li><?php echo esc_html( $inc_title ); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <?php if ( !empty($card_desc) ) : ?>
                    <div class="service-card-inclusions">
                        <?php echo wp_kses_post( $card_desc ); ?>
                    </div>
                <?php endif; ?>

                <?php if ( !empty($highlights) ) : ?>
                    <div class="service-card-highlights" style="margin-top: 20px; padding: 0 10px;">
                        <ul style="list-style: none; padding: 0; margin: 0; font-family: 'Lato', sans-serif; font-size: 0.85rem; line-height: 1.7; color: var(--wedding-text); opacity: 0.9;">
                            <?php 
                            $lines = explode("\n", $highlights);
                            foreach($lines as $line) {
                                if (trim($line)) {
                                    echo '<li style="margin-bottom: 5px; padding-left: 20px; position: relative;">';
                                    echo '<span style="position: absolute; left: 0; color: var(--wedding-gold-light);">✓</span>';
                                    echo esc_html(trim($line));
                                    echo '</li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </a>
    <?php
    return ob_get_clean();
}
