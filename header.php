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

    <?php wp_head(); ?>

    <!-- BOUTIQUE EDITORIAL VISUAL GUARD (v3000.452.0 - Version Sync) -->
    <style id="gary-final-sync-reset-v3000-452-0">
        /* 0. Global Precision Normalization */
        *, *::before, *::after { box-sizing: border-box !important; }
        html, body { background-color: #ffffff !important; background: #ffffff !important; padding: 0 !important; overflow-x: hidden !important; }
        /* Respect WordPress Admin Bar offset */
        .admin-bar html { margin-top: 32px !important; }
        @media screen and (max-width: 782px) { .admin-bar html { margin-top: 46px !important; } }
        :root { --brand-bg: #ffffff !important; --site-max-width: none !important; }
        
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

        /* 4. Branding & Tagline (Flush-Left Alignment) */
        .focal-left { display: flex !important; align-items: center !important; justify-content: flex-start !important; }
        .branding-group { display: flex !important; flex-direction: column !important; align-items: flex-start !important; text-align: left !important; width: auto !important; }
        .site-title-blacksword { text-align: left !important; margin-left: 0 !important; width: 100% !important; }
        .site-tagline-lato { text-align: left !important; width: 100% !important; margin: 5px 0 0 !important; display: block !important; font-size: 0.65rem !important; letter-spacing: 2px !important; text-transform: uppercase !important; opacity: 0.8 !important; }
        
        .menu-toggle { display: flex !important; align-items: center !important; gap: 20px !important; background: transparent !important; border: none !important; cursor: pointer !important; padding: 0 !important; }
        .menu-text { font-family: var(--font-primary) !important; font-size: 0.75rem !important; letter-spacing: 2px !important; color: #C5A059 !important; font-weight: 700 !important; line-height: 1 !important; }
        .hamburger-box { width: 28px !important; height: 19px !important; display: inline-block !important; position: relative !important; margin-right: 8px !important; }
        
        /* 5. Premium Menu Burger & Overlay (80% Modal) */
        .hamburger-inner, .hamburger-inner::before, .hamburger-inner::after { width: 28px !important; height: 3px !important; background-color: #C5A059 !important; border-radius: 2px !important; display: block !important; position: absolute !important; }
        .hamburger-inner { top: 50% !important; margin-top: -1.5px !important; }
        .hamburger-inner::before { top: -8px !important; content: "" !important; left: 0 !important; }
        .hamburger-inner::after { top: 8px !important; content: "" !important; left: 0 !important; }

        .menu-overlay { position: fixed !important; inset: 0 !important; background: rgba(0, 0, 0, 0.75) !important; backdrop-filter: blur(8px) !important; display: flex !important; align-items: center !important; justify-content: center !important; z-index: 99999 !important; }
        .menu-overlay-inner { width: 80% !important; height: auto !important; max-width: 800px !important; max-height: 90vh !important; background: #ffffff !important; border-radius: 20px !important; box-shadow: 0 40px 100px rgba(0,0,0,0.6) !important; padding: 60px 40px !important; display: flex !important; flex-direction: column !important; align-items: center !important; justify-content: center !important; overflow-y: auto !important; }
        .menu-close { top: 30px !important; right: 30px !important; font-size: 32px !important; color: #C5A059 !important; }
        .nav-menu-overlay { width: 100% !important; text-align: center !important; list-style: none !important; padding: 0 !important; }
        .nav-menu-overlay li a { font-size: 1.4rem !important; color: #1a1a1a !important; padding: 10px !important; display: block !important; font-family: var(--font-primary) !important; text-transform: uppercase !important; letter-spacing: 2px !important; text-decoration: none !important; }
        
        /* 5.5 Universal 10-80-10 Editorial Mandate (Non-Recursive) */
        /* Only apply 80% to the absolute outermost layout container */
        #primary, 
        .site-main, 
        .header-focal-container,
        .page-header { 
            width: 80% !important; 
            max-width: none !important; 
            margin-left: auto !important; 
            margin-right: auto !important; 
            padding-left: 0 !important; 
            padding-right: 0 !important; 
            display: block !important;
            clear: both !important;
        }

        /* Exception: Footer Grid (Needs 80% Width + Grid Display) */
        .site-footer .footer-grid {
            width: 80% !important;
            max-width: none !important;
            margin: 0 auto !important;
            display: grid !important;
        }

        /* 5.6 Recursive Reset (Ensures internal containers fill the 80% column) */
        #primary .container,
        #primary .site-main,
        #primary .entry-content,
        #primary .wp-block-group:not(.trust-bar-fix),
        #primary .services-intro,
        #primary .service-hero-single-column,
        #primary article,
        #primary .page-content,
        .site-main .container,
        .container .container,
        .entry-content .container {
            width: 100% !important;
            max-width: none !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
            display: block !important;
        }

        /* 5.6.1 Boutique Centered Services Gallery (Flex-Centering Engine) */
        .services-grid {
            display: flex !important;
            flex-wrap: wrap !important;
            justify-content: center !important;
            gap: 20px !important;
            row-gap: 50px !important;
            width: 100% !important;
            margin: 40px auto !important;
            overflow: visible !important;
        }
        .service-card-link {
            flex: 0 1 285px !important; /* Forces 5-wide on 1536px, centers remainder */
            min-width: 250px !important;
            max-width: 100% !important;
            display: flex !important;
            flex-direction: column !important;
            text-decoration: none !important;
            transition: transform 0.3s ease !important;
        }
        .service-card-link:hover { transform: translateY(-10px) !important; }
        
        @media (max-width: 1400px) { .service-card-link { flex: 0 1 300px !important; } }
        @media (max-width: 850px) { .service-card-link { flex: 0 1 45% !important; } }
        @media (max-width: 550px) { .service-card-link { flex: 0 1 100% !important; } }

        /* 5.7 Boutique About Me Grid (Locked 40/5/55 Split) */
        .about-grid { 
            display: flex !important; 
            flex-direction: row !important;
            justify-content: space-between !important;
            gap: 5% !important; 
            align-items: flex-start !important;
            width: 100% !important;
            margin-top: 60px !important;
        }
        .about-image { flex: 0 0 40% !important; width: 40% !important; }
        .about-content { flex: 0 0 55% !important; width: 55% !important; }
        @media (max-width: 900px) {
            .about-grid { flex-direction: column !important; gap: 40px !important; }
            .about-image, .about-content { flex: 1 1 100% !important; width: 100% !important; }
        }
        
        /* Exception: Full-Width Elements */
        .hero-peek-carousel, 
        .hero-peek-track,
        .site-footer,
        .site-header { 
            width: 100% !important; 
            max-width: none !important; 
        }

        .header-focal-container {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
        }
        
        .focal-center { padding: 0 40px !important; }
        .focal-side { flex: 1 !important; }
        .site-header { background: #fff !important; }

        /* 5.8 Content Impediment Removal */
        .services-intro { 
            max-width: 1200px !important; 
            margin: 0 auto 50px !important; 
            width: 90% !important;
        }

        /* 7. Trust Bar (Nuclear Specifier: Horizontal Row) */
        html body #primary .wp-block-group.trust-bar-fix,
        html body #primary .wp-block-group:has(.is-layout-flex),
        html body #primary .is-layout-flex.wp-block-group { 
            display: flex !important; 
            flex-direction: row !important;
            flex-wrap: wrap !important;
            justify-content: center !important;
            align-items: center !important;
            width: 100% !important; 
            min-width: 100% !important;
            background: #000000 !important; 
            color: #ffffff !important; 
            padding: 25px 40px !important; 
            margin-top: 40px !important;
            margin-bottom: 40px !important;
            border-top: 1px solid rgba(197, 160, 89, 0.2) !important;
            border-bottom: 1px solid rgba(197, 160, 89, 0.2) !important;
            clear: both !important;
            gap: 40px !important;
        }
        
        html body #primary .trust-bar-fix p, 
        html body #primary .trust-bar-fix li,
        html body #primary .wp-block-group:has(.is-layout-flex) p { 
            margin: 0 !important; 
            font-size: 0.85rem !important; 
            letter-spacing: 2px !important; 
            text-transform: uppercase !important; 
            font-weight: 700 !important;
            width: auto !important;
            line-height: 1 !important;
            white-space: nowrap !important;
            display: inline-block !important;
            color: #C5A059 !important;
        }

        @media (max-width: 900px) {
            html body #primary .trust-bar-fix,
            html body #primary .wp-block-group:has(.is-layout-flex) { 
                flex-direction: column !important; 
                gap: 15px !important; 
                align-items: center !important; 
                text-align: center !important;
            }
        }

        /* 8. Check Your Date Block (Atomic Compression) */
        .gw-process-block.gw-atomic-check-wrap { 
            padding: 30px 0 !important; 
            margin: 20px auto !important; 
            background: transparent !important;
        }
        .gw-process-col.is-atomic-check { 
            padding: 20px 30px !important; 
            margin: 0 auto !important; 
            max-width: 800px !important;
            background: #ffffff !important;
            border: 1px solid #f0f0f0 !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05) !important;
        }
        .gw-process-col h4 { margin-top: 0 !important; margin-bottom: 10px !important; font-size: 1.6rem !important; }
        .gw-process-col p { margin-top: 0 !important; margin-bottom: 15px !important; font-size: 0.9rem !important; }
        .gw-availability-box-inner { margin-top: 10px !important; }
        
        .gw-calendar-icon, .is-atomic-check i.fas.fa-calendar-alt { display: none !important; visibility: hidden !important; }
        
        /* 9. Elegant Button Block */
        .gw-elegant-btn-wrap { display: flex !important; width: 100% !important; margin: 30px 0 !important; }
        .gw-elegant-btn-wrap.is-align-center { justify-content: center !important; }
        .gw-elegant-btn-wrap.is-align-left { justify-content: flex-start !important; }
        .gw-elegant-btn-wrap.is-align-right { justify-content: flex-end !important; }
        
        .btn-elegant { 
            display: inline-block !important; 
            background: #000000 !important; 
            color: #C5A059 !important; 
            border: 1px solid #C5A059 !important; 
            padding: 16px 45px !important; 
            font-family: var(--font-primary) !important;
            font-size: 0.75rem !important;
            font-weight: 700 !important;
            letter-spacing: 3px !important;
            text-transform: uppercase !important;
            text-decoration: none !important;
            transition: all 0.4s cubic-bezier(0.25, 1, 0.5, 1) !important;
            border-radius: 2px !important;
            cursor: pointer !important;
            position: relative !important;
            overflow: hidden !important;
        }
        .btn-elegant:hover { 
            background: #C5A059 !important; 
            color: #000000 !important; 
            transform: translateY(-2px) !important;
            box-shadow: 0 10px 20px rgba(197, 160, 89, 0.2) !important;
        }
        .is-size-large .btn-elegant { padding: 22px 65px !important; font-size: 0.85rem !important; }
        
        .gw-list-box.is-style-included, .gw-editorial-gold-box.detailed-components-section { border: none !important; }
        .footer-meta, .footer-social { margin-top: 15px !important; }
        .site-footer { margin-top: 60px !important; }

        /* Jetpack Sharing Centering */
        .sharedaddy, .sharedaddy .sd-sharing-enabled { text-align: center !important; margin: 20px auto !important; width: 100% !important; }
        .sharedaddy .sd-content { display: block !important; margin: 0 auto !important; float: none !important; }
        .sharedaddy .sd-content ul { display: flex !important; justify-content: center !important; flex-wrap: wrap !important; list-style: none !important; padding: 0 !important; gap: 10px !important; }
        /* Ensuring Ribbons and Star Bullets are High Fidelity */
        .service-card-ribbon { z-index: 100 !important; }
        .gw-bullet-list.is-inclusions { margin-top: 15px !important; }
    </style>
    <script>
    (function() {
        const fix = () => {
            document.querySelectorAll('.wp-block-group').forEach(el => {
                if (el.textContent.includes('EXPERIENCE')) {
                    el.classList.add('trust-bar-fix');
                    el.style.setProperty('display', 'flex', 'important');
                    el.style.setProperty('flex-direction', 'row', 'important');
                }
                if (el.textContent.includes('Check Your Date!')) {
                    el.classList.add('check-date-box-fix');
                    el.style.setProperty('padding', '30px', 'important');
                }
            });
            document.querySelectorAll('.service-card-ribbon').forEach(el => {
                el.style.setProperty('display', 'block', 'important');
            });
        };
        fix();
        document.addEventListener('DOMContentLoaded', fix);
        window.addEventListener('load', fix);
        const observer = new MutationObserver(fix);
        observer.observe(document.documentElement, { childList: true, subtree: true });
    })();
    </script>
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
