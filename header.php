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

<<<<<<< HEAD
    <!-- BOUTIQUE EDITORIAL VISUAL GUARD (v3000.40.0 - High Fidelity Sync) -->
    <style id="gary-final-sync-reset-v3000-40-0">
        /* Absolute specificity override to defeat style.css legacy rules */
        html body:not(.home) .entry-title, 
        html body:not(.home) h1.entry-title, 
        html body:not(.home) .page-header h1,
        html body:not(.home) .service-hero-header h1,
        html body:not(.home) .post-title,
        html body:not(.home) h1:first-of-type { 
            font-size: 3.2rem !important; 
            margin-top: 0 !important; 
            position: relative !important; 
            top: 30px !important; 
            z-index: 100 !important; 
            display: block !important;
            visibility: visible !important;
        }
        
        .service-card-title, .condensed-info h3 { font-family: var(--font-script) !important; font-size: 1.8rem !important; visibility: visible !important; display: block !important; }
        
        /* Layout & Border Fixes */
        .gw-list-box.is-style-included, .gw-editorial-gold-box.detailed-components-section { border: none !important; }
        .footer-meta { margin-top: 15px !important; padding-top: 20px !important; }
        .footer-social { margin-top: 15px !important; }
        .site-footer { margin-top: 60px !important; }

        /* Jetpack Sharing Centering */
        .sharedaddy, .sharedaddy .sd-sharing-enabled { text-align: center !important; margin: 20px auto !important; width: 100% !important; }
        .sharedaddy .sd-content { display: block !important; margin: 0 auto !important; float: none !important; }
        .sharedaddy .sd-content ul { display: flex !important; justify-content: center !important; flex-wrap: wrap !important; list-style: none !important; padding: 0 !important; gap: 10px !important; }

        /* Ensuring Ribbons and Star Bullets are High Fidelity */
        .service-card-ribbon { z-index: 100 !important; }
        .gw-bullet-list.is-inclusions { margin-top: 15px !important; }
        
        /* Grid Dynamicism Overrides */
        .services-grid { grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)) !important; max-width: 1600px !important; }
    </style>
    <script>
    (function() {
        // Observer to ensure dynamic elements (Ribbons, etc.) are stable
        const ensureFidelity = () => {
            document.querySelectorAll('.service-card-ribbon').forEach(el => {
                el.style.setProperty('display', 'block', 'important');
            });
        };
        document.addEventListener('DOMContentLoaded', ensureFidelity);
        const observer = new MutationObserver(ensureFidelity);
        observer.observe(document.documentElement, { childList: true, subtree: true });
    })();
    </script>

=======
    <!-- BOUTIQUE EDITORIAL VISUAL GUARD (v3000.120.0 - Unified Logic) -->
>>>>>>> 95a5d4a20ba5993cbe01c385ca98cc7a9a6bcdd7
    <?php wp_head(); ?>
</head></head>
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
                <span class="menu-text">MENU</span>
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
