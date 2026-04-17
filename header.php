<?php /** File: header.php */ ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon: WP site icon if set, else SVG fallback -->
    <?php if ( get_site_icon_url() ) : ?>
        <link rel="icon" href="<?php echo esc_url( get_site_icon_url( 32 ) ); ?>" sizes="32x32">
        <link rel="icon" href="<?php echo esc_url( get_site_icon_url( 192 ) ); ?>" sizes="192x192">
        <link rel="apple-touch-icon" href="<?php echo esc_url( get_site_icon_url( 180 ) ); ?>">
    <?php else : ?>
        <!-- SVG camera aperture favicon fallback (gold on dark) -->
        <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ccircle cx='50' cy='50' r='48' fill='%231a1a1a'/%3E%3Ccircle cx='50' cy='50' r='32' fill='none' stroke='%23C5A059' stroke-width='6'/%3E%3Ccircle cx='50' cy='50' r='14' fill='%23C5A059'/%3E%3Cline x1='50' y1='18' x2='50' y2='2' stroke='%23C5A059' stroke-width='5' stroke-linecap='round'/%3E%3Cline x1='50' y1='98' x2='50' y2='82' stroke='%23C5A059' stroke-width='5' stroke-linecap='round'/%3E%3Cline x1='18' y1='50' x2='2' y2='50' stroke='%23C5A059' stroke-width='5' stroke-linecap='round'/%3E%3Cline x1='98' y1='50' x2='82' y2='50' stroke='%23C5A059' stroke-width='5' stroke-linecap='round'/%3E%3C/svg%3E">
        <link rel="apple-touch-icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ccircle cx='50' cy='50' r='48' fill='%231a1a1a'/%3E%3Ccircle cx='50' cy='50' r='32' fill='none' stroke='%23C5A059' stroke-width='6'/%3E%3Ccircle cx='50' cy='50' r='14' fill='%23C5A059'/%3E%3C/svg%3E">
    <?php endif; ?>

    <!-- BOUTIQUE EDITORIAL VISUAL GUARD (v1000.0.0 - Endgame Sync) -->
    <style id="gary-endgame-reset">
        /* THE CIRCLE NUKE & RECTANGULAR RESET */
        .service-card-image, 
        .service-card-image img, 
        .gold-frame, 
        .gold-frame img,
        [class*="service-card"] .service-card-image img {
            border-radius: 0 !important;
            aspect-ratio: 1/1 !important;
            object-fit: cover !important;
            clip-path: none !important;
            mask-image: none !important;
        }
        .service-card-image {
            overflow: hidden !important;
            border: 1px solid #C5A059 !important;
        }
    </style>
    <script>
    (function() {
        const resetStyles = () => {
            document.querySelectorAll('.service-card-image, .service-card-image img, .gold-frame, .gold-frame img').forEach(el => {
                el.style.setProperty('border-radius', '0', 'important');
                el.style.setProperty('aspect-ratio', '1/1', 'important');
            });
            if (window.innerWidth > 1024) {
               document.querySelectorAll('.gw-trio-gallery').forEach(el => {
                   el.style.setProperty('display', 'flex', 'important');
                   el.style.setProperty('flex-direction', 'row', 'important');
               });
            }
        };
        document.addEventListener('DOMContentLoaded', resetStyles);
        window.addEventListener('load', resetStyles);
        const observer = new MutationObserver(resetStyles);
        observer.observe(document.documentElement, { attributes: true, childList: true, subtree: true });
    })();
    </script>

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="header-focal-container">

        <!-- Zone 1: Branding (25% Focal Line) -->
        <div class="focal-side focal-left">
            <div class="branding-group">
                <div class="site-title-blacksword"><?php bloginfo( 'name' ); ?></div>
                <div class="site-tagline-lato"><?php bloginfo( 'description' ); ?></div>
            </div>
        </div>

        <!-- Zone 2: Logo (50% Focal Line) -->
        <div class="focal-center">
            <?php
            if ( has_custom_logo() ) :
                // Filtered in functions.php to include fetchpriority="high"
                the_custom_logo();
            else :
                echo '<div class="logo-placeholder">G.W</div>';
            endif;
            ?>
        </div>

        <!-- Zone 3: Navigation (75% Focal Line) -->
        <div class="focal-side focal-right nav-toggle-container">
            <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
                <span class="menu-text" style="font-family:'Lato', sans-serif; font-size:0.9rem; letter-spacing:2px; text-transform:uppercase; margin-left:12px; font-weight:700;">MENU</span>
            </button>
        </div>

    </div>
</header>

<div class="menu-overlay" id="primary-menu" aria-hidden="true">
    <div class="menu-overlay-inner">
        <button class="menu-close" aria-label="Close navigation">&times;</button>
        <nav class="overlay-nav">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'nav-menu-overlay',
            ) );
            ?>
        </nav>
    </div>
</div>
