<?php

function gary_register_service_blocks() {
    
    // Register the container block
    register_block_type('gw/service-grid', array());

    // Register the single dynamic block
    register_block_type('gw/single-service', array(
        'render_callback' => 'gary_render_single_service_block',
        'attributes' => array(
            'bookly_id' => array(
                'type' => 'string',
                'default' => ''
            )
        )
    ));
}
add_action('init', 'gary_register_service_blocks');

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

function gary_render_single_service_block( $attributes ) {
    $b_id = !empty($attributes['bookly_id']) ? $attributes['bookly_id'] : '';
    
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
    
    if ( (float) $b_data['price'] <= 0 ) {
        $is_free = true;
    } else {
        $sub_price = 'From £' . number_format( $b_data['price'], 0 );
    }

    // If paired to a Page, use its details
    if ( $page_id ) {
        $sub_page    = get_post( $page_id );
        if ( ! $sub_page ) {
            // Mapped but page is deleted, fallback to Bookly details
            $card_url    = '/booking/';
            $card_thumb  = ! empty( $b_data['image'] ) ? $b_data['image'] : '';
            $card_desc   = ! empty( $b_data['info'] ) ? wp_trim_words( wp_strip_all_tags( $b_data['info'] ), 20 ) : '';
        } else {
            $card_url    = get_permalink( $page_id );
            $card_thumb  = get_the_post_thumbnail_url( $page_id, 'large' );

            $manual_p    = get_post_meta( $page_id, '_gary_service_price', true );
            if ( !$b_data && ! empty( $manual_p ) ) {
                if ( strtolower(trim($manual_p)) === 'free' || trim($manual_p) === '0' ) {
                    $is_free = true;
                    $sub_price = '';
                } else {
                    $sub_price = 'From £' . $manual_p;
                    $is_free = false;
                }
            }

            if ( ! empty( $b_data['info'] ) ) {
                $card_desc = wp_trim_words( wp_strip_all_tags( $b_data['info'] ), 20 );
            } elseif ( ! empty( $sub_page->post_excerpt ) ) {
                $card_desc = wp_trim_words( $sub_page->post_excerpt, 20 );
            } else {
                $card_desc = wp_trim_words( strip_shortcodes( $sub_page->post_content ), 20 );
            }
        }
    } else {
        // Only Bookly details
        $card_url    = '/booking/';
        $card_thumb  = ! empty( $b_data['image'] ) ? $b_data['image'] : '';
        $card_desc   = ! empty( $b_data['info'] ) ? wp_trim_words( wp_strip_all_tags( $b_data['info'] ), 20 ) : '';
    }

    // Fallback Image Logic
    $logo_id = get_theme_mod( 'custom_logo' );
    $logo_url = $logo_id ? wp_get_attachment_image_url( $logo_id, 'full' ) : '';
    
    $svg_raw = '<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><rect width="100" height="100" fill="#f0f0f0"/><path d="M50 30 L70 70 L30 70 Z" fill="#C5A059" opacity="0.3"/></svg>';
    $svg_fallback = 'data:image/svg+xml;base64,' . base64_encode($svg_raw);

    $final_thumb = $card_thumb ? $card_thumb : ( $logo_url ? $logo_url : $svg_fallback );

    ob_start();
    ?>
    <a href="<?php echo esc_url( $card_url ); ?>" class="component-card">
        <div class="coin-icon-wrap">
            <img src="<?php echo esc_url( $final_thumb ); ?>"
                 alt="<?php echo esc_attr( $card_title ); ?>" />
        </div>
        <div class="component-info">
            <h4><?php echo esc_html( $card_title ); ?></h4>
            <?php if ( $sub_price ) : ?>
                <div style="font-size:0.8rem; margin-bottom:8px; letter-spacing:1px; color:var(--wedding-gold-light); font-weight:700;">
                    <span style="text-decoration:line-through; opacity:0.5; margin-right:8px;"><?php echo esc_html( $sub_price ); ?></span>
                    <span>INCLUDED</span>
                </div>
            <?php elseif ( $is_free ) : ?>
                <div style="font-size:0.75rem; margin-bottom:8px; letter-spacing:2px; font-weight:700; color:#fff; background:var(--wedding-crimson); display:inline-block; padding:3px 10px; border-radius:2px;">
                    FREE &mdash; INCLUDED
                </div>
            <?php endif; ?>
            <?php if ( !empty($card_desc) ) : ?>
                <p style="margin-top:6px;"><?php echo esc_html( $card_desc ); ?></p>
            <?php endif; ?>
        </div>
    </a>
    <?php
    return ob_get_clean();
}
