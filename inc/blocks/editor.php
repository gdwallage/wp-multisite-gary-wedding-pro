<?php
/**
 * Blocks Editor: Admin-specific styles and fixes for Gutenberg parity.
 */

if ( ! function_exists( 'gary_wedding_editor_grid_fix' ) ) :
function gary_wedding_editor_grid_fix() {
    echo '<style id="gary-editor-grid-fix">
        html, body, .editor-styles-wrapper { background: var(--brand-bg) !important; }
        .editor-styles-wrapper { padding: 0 !important; }
        .is-root-container { max-width: 100% !important; padding: 0 !important; }
        .wp-block-post-content { max-width: 100% !important; margin: 0 !important; }
        
        /* Layout Constraints */
        .wp-block-post-content > *:not(.alignfull):not(.gw-trust-bar):not([data-type^="gw/"]) {
            max-width: var(--editorial-width) !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }

        /* Hero Placeholder */
        .editor-post-title__block::before {
            content: "FRONT PAGE HERO SLIDER (ACTIVE)";
            display: flex; background: #11110e; color: var(--brand-gold-light); height: 120px;
            align-items: center; justify-content: center; font-family: var(--font-primary);
            letter-spacing: 5px; text-transform: uppercase; font-weight: 700; margin-bottom: 40px;
            border: 2px solid var(--brand-gold-light); opacity: 0.8;
        }
        
        .wp-block[data-type^="gw/"] { max-width: 100% !important; width: 100% !important; margin: 0 !important; }

        /* Component Parity */
        .wp-block[data-type="gw/z-pattern"] .gw-z-pattern { display: flex !important; align-items: center !important; width: var(--editorial-width) !important; margin: 80px auto !important; }
        .wp-block[data-type="gw/service-grid"] .services-grid { display: grid !important; grid-template-columns: repeat(3, 1fr) !important; gap: 40px !important; width: var(--editorial-width) !important; margin: 80px auto !important; }

        .editor-styles-wrapper a { pointer-events: none !important; }
    </style>';
}
add_action( 'admin_head', 'gary_wedding_editor_grid_fix' );
endif;

add_action( 'enqueue_block_editor_assets', function() {
    wp_add_inline_style( 'gary-editorial-blocks-js', '
        .wp-block[data-type^="gw/"] { max-width: 100% !important; width: 100% !important; }
        .is-root-container { max-width: 100% !important; }
    ');
});
