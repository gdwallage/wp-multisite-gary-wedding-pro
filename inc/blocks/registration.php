<?php
/**
 * Blocks: Registration and localized data for Gutenberg.
 */

function gary_register_service_blocks() {
    $blocks = array(
        'gw/service-grid'             => 'gary_render_service_grid_block',
        'gw/single-service'           => 'gary_render_single_service_block',
        'gw/z-pattern'                => 'gary_render_z_pattern_block',
        'gw/trio-gallery'             => 'gary_render_trio_gallery_block',
        'gw/editorial-split'          => 'gary_render_split_block',
        'gw/chapter-break'            => 'gary_render_chapter_break_block',
        'gw/cta-plaque'               => 'gary_render_cta_plaque_block',
        'gw/tessellated-menu'         => 'gary_render_tessellated_menu',
        'gw/trust-bar'                => 'gary_render_trust_bar_block',
        'gw/usps-3col'                => 'gary_render_usps_block',
        'gw/action-step-container'    => 'gary_render_action_container_block',
        'gw/action-step'              => 'gary_render_action_step_block',
        'gw/check-date-atomic'        => 'gary_render_check_date_atomic',
        'gw/editorial-triplet-container' => 'gary_render_triplet_container',
        'gw/editorial-triplet-item'   => 'gary_render_triplet_item',
        'gw/hero-bleed'               => 'gary_render_hero_bleed_block',
        'gw/storyteller-grid'         => 'gary_render_storyteller_grid_block',
        'gw/testimonial-quote'        => 'gary_render_testimonial_quote_block',
        'gw/polaroid-frame'           => 'gary_render_polaroid_frame_block',
        'gw/list-included'            => 'gary_render_styled_list_box',
        'gw/list-perfect-for'         => 'gary_render_styled_list_box',
        'gw/editorial-dual-column'    => 'gary_render_dual_column_block',
    );

    foreach ( $blocks as $name => $callback ) {
        register_block_type( $name, array( 'render_callback' => $callback ) );
    }
}
add_action( 'init', 'gary_register_service_blocks' );

function gary_register_block_categories( $categories ) {
    return array_merge( array( array( 'slug' => 'gary-editorial-native', 'title' => __( 'Gary Wallage Wedding', 'garywedding' ), 'icon' => 'star-filled' ) ), $categories );
}
add_filter( 'block_categories_all', 'gary_register_block_categories', 10, 2 );

function gary_localize_block_data() {
    global $wpdb;
    $options = array( array( 'label' => '-- Select Service --', 'value' => '' ) );
    $table_name = $wpdb->prefix . 'bookly_services';
    if ( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) == $table_name ) {
        $services = $wpdb->get_results( "SELECT id, title FROM $table_name ORDER BY title ASC" );
        if ( is_array( $services ) ) {
            foreach ( $services as $s ) { $options[] = array( 'label' => $s->title, 'value' => (string) $s->id ); }
        }
    }
    wp_localize_script( 'gary-editorial-blocks-js', 'garyBooklyServiceOptions', $options );

    $page_options = array( array( 'label' => '-- Select Page --', 'value' => 0 ) );
    $query = new WP_Query( array(
        'post_type'      => 'page',
        'post_status'    => 'publish',
        'posts_per_page' => 150,
        'fields'         => 'ids',
        'no_found_rows'  => true,
        'orderby'        => 'title',
        'order'          => 'ASC',
    ) );
    
    if ( $query->have_posts() ) {
        foreach ( $query->posts as $p_id ) {
            $page_options[] = array( 'label' => get_the_title( $p_id ), 'value' => (int) $p_id );
        }
    }
    wp_reset_postdata();
    wp_localize_script( 'gary-editorial-blocks-js', 'garyPageOptions', $page_options );
}
add_action( 'enqueue_block_editor_assets', 'gary_localize_block_data', 20 );

function gary_register_custom_block_styles() {
    $styles = array(
        'gw-highlights'  => 'Highlights (Gold Ticks)',
        'gw-included'    => 'What\'s Included (Plus)',
        'gw-perfect-for' => 'Perfect For (Diamonds)',
    );
    foreach ( $styles as $name => $label ) {
        register_block_style( 'core/list', array( 'name' => $name, 'label' => __( $label, 'garywedding' ) ) );
    }
}
add_action( 'init', 'gary_register_custom_block_styles' );
