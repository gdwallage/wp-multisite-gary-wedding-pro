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

    <!-- BOUTIQUE EDITORIAL VISUAL GUARD (v3000.420.0 - Clean Consolidation) -->
    <style id="gary-final-sync-reset-v3000-420-0">
        /* 1. Global Page Title Consistency */
        html body:not(.home) .entry-title, 
        html body:not(.home) h1.entry-title, 
        html body:not(.home) .page-header h1,
        html body:not(.home) .service-hero-header h1,
        html body:not(.home) .post-title,
        html body:not(.home) h1:first-of-type { 
            font-size: 3.2rem !important; 
            margin-top: 130px !important; 
            position: relative !important; 
            top: 0 !important; 
            z-index: 100 !important; 
            display: block !important;
            visibility: visible !important;
        }
        h1, .entry-title, .hero-peek-title { font-size: clamp(1.8rem, 4vw, 2.6rem) !important; line-height: 1.2 !important; word-wrap: break-word !important; color: #C5A059 !important; }

        /* 2. Hero Peek Slider Architecture (49.8% Squeezed) */
        .hero-peek-carousel { height: 75vh !important; min-height: 520px !important; margin-top: 0 !important; background: #ffffff !important; overflow: hidden !important; position: relative !important; }
        .hero-peek-track { position: relative !important; width: 100% !important; height: 100% !important; overflow: visible !important; background: #ffffff !important; }
        
        .hero-peek-slide { position: absolute !important; width: 49.8% !important; height: 100% !important; top: 0 !important; transition: left 0.8s cubic-bezier(0.25, 1, 0.5, 1), opacity 0.8s !important; opacity: 1 !important; z-index: 1 !important; background: #ffffff !important; border-right: 2px solid #ffffff !important; box-shadow: none !important; }
        .hero-peek-slide.active { left: 25.1% !important; z-index: 10 !important; opacity: 1 !important; }
        .hero-peek-slide.next   { left: 74.9% !important; z-index: 5 !important; opacity: 0.5 !important; }
        .hero-peek-slide.prev   { left: -24.7% !important; z-index: 5 !important; opacity: 0.5 !important; }
        .hero-peek-slide.far-next { left: 124.7% !important; opacity: 0 !important; }
        .hero-peek-slide.far-prev { left: -74.5% !important; opacity: 0 !important; }
        .hero-peek-slide.hidden   { left: 180% !important; opacity: 0 !important; }

        .hero-peek-img { object-fit: contain !important; width: 100% !important; height: 100% !important; display: block !important; background: #ffffff !important; }

        /* 3. Refined Auto-Height Caption Box */
        .hero-peek-caption { 
            position: absolute !important; 
            bottom: 30px !important; 
            left: 50% !important; 
            transform: translateX(-50%) !important; 
            width: fit-content !important; 
            height: auto !important;
            min-height: 0 !important;
            max-width: 90% !important; 
            padding: 30px 40px 80px !important; 
            background: rgba(0, 0, 0, 0.6) !important; 
            backdrop-filter: blur(12px) !important; 
            border: 1px solid rgba(197, 160, 89, 0.2) !important;
            border-radius: 12px !important;
            opacity: 0 !important; 
            transition: opacity 0.4s !important; 
            display: flex !important; 
            flex-direction: column !important; 
            align-items: center !important; 
            text-align: center !important; 
            z-index: 20 !important; 
        }
        .hero-peek-slide.active .hero-peek-caption { opacity: 1 !important; }
        .hero-peek-title { color: #C5A059 !important; text-shadow: none !important; font-family: 'Blacksword', cursive !important; max-width: 90% !important; margin: 0 auto 5px !important; }
        .hero-peek-subtitle { color: #ffffff !important; font-size: 0.65rem !important; letter-spacing: 3px !important; text-transform: uppercase !important; max-width: 95% !important; margin: 0 auto !important; opacity: 0.8 !important; }
        
        .hero-peek-nav { bottom: 55px !important; left: 50% !important; transform: translateX(-50%) !important; width: auto !important; z-index: 100 !important; position: absolute !important; display: flex !important; gap: 20px !important; align-items: center !important; }
        .hero-peek-arrow { width: 40px !important; height: 40px !important; border: 1px solid rgba(197, 160, 89, 0.5) !important; border-radius: 50% !important; color: #C5A059 !important; background: transparent !important; display: flex !important; align-items: center !important; justify-content: center !important; cursor: pointer !important; font-size: 1rem !important; transition: all 0.3s !important; }
        .hero-peek-arrow:hover { background: #C5A059 !important; color: #fff !important; }
        .hero-peek-dot { width: 7px !important; height: 7px !important; border-radius: 50% !important; background: rgba(197, 160, 89, 0.3) !important; border: none !important; transition: all 0.3s !important; }
        .hero-peek-dot.active { background: #C5A059 !important; }
        
        .hero-peek-cta { display: inline-block !important; background: transparent !important; color: #C5A059 !important; border: 1px solid #C5A059 !important; padding: 10px 28px !important; text-transform: uppercase !important; letter-spacing: 2px !important; border-radius: 4px !important; margin-top: 15px !important; cursor: pointer !important; font-size: 0.75rem !important; transition: all 0.3s !important; }
        .hero-peek-cta:hover { background: rgba(197, 160, 89, 0.2) !important; }

        /* 4. Branding & Tagline Centering */
        .focal-left { display: flex !important; align-items: center !important; justify-content: flex-start !important; }
        .branding-group { display: flex !important; flex-direction: column !important; align-items: center !important; text-align: center !important; width: 100% !important; }
        .site-tagline-lato { text-align: center !important; width: 100% !important; margin: -5px auto 0 !important; display: block !important; }
        
        /* 5. Premium Menu Burger & Overlay (80% Modal) */
        .hamburger-inner, .hamburger-inner::before, .hamburger-inner::after { width: 28px !important; height: 3px !important; background-color: #C5A059 !important; border-radius: 2px !important; }
        .hamburger-inner::before { top: -8px !important; }
        .hamburger-inner::after { top: 8px !important; }
        .hamburger-box { width: 28px !important; height: 19px !important; }

        .menu-overlay { position: fixed !important; inset: 0 !important; background: rgba(0, 0, 0, 0.75) !important; backdrop-filter: blur(8px) !important; display: flex !important; align-items: center !important; justify-content: center !important; z-index: 99999 !important; }
        .menu-overlay-inner { width: 80% !important; height: 80% !important; max-width: 1000px !important; max-height: 85vh !important; background: #ffffff !important; border-radius: 20px !important; box-shadow: 0 40px 100px rgba(0,0,0,0.6) !important; padding: 80px 40px !important; display: flex !important; flex-direction: column !important; align-items: center !important; justify-content: center !important; overflow-y: auto !important; }
        .menu-close { top: 30px !important; right: 30px !important; font-size: 40px !important; color: #C5A059 !important; }
        .nav-menu-overlay { width: 100% !important; text-align: center !important; list-style: none !important; padding: 0 !important; }
        .nav-menu-overlay li a { font-size: 1.8rem !important; color: #1a1a1a !important; padding: 15px !important; display: block !important; }
        .nav-menu-overlay li a:hover { color: #C5A059 !important; }

        /* 6. Layout & Fidelity Fixes */
        @media (max-width: 768px) {
            .hero-peek-carousel { height: 55vh !important; margin-top: 0 !important; }
            .hero-peek-slide { width: 86% !important; }
            .hero-peek-slide.active { left: 7% !important; }
            .hero-peek-slide.next { left: 95% !important; }
            .hero-peek-slide.prev { left: -81% !important; }
            .menu-overlay-inner { width: 90% !important; height: 90% !important; padding: 40px 20px !important; }
        }
        .gw-list-box.is-style-included, .gw-editorial-gold-box.detailed-components-section { border: none !important; }
        .footer-meta, .footer-social { margin-top: 15px !important; }
        .site-footer { margin-top: 60px !important; }
        .services-grid { grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)) !important; max-width: 1600px !important; }

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
