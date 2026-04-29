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

    <!-- BOUTIQUE EDITORIAL VISUAL GUARD (v3000.9.0 - Ultimate Fidelity Sync) -->
    <style id="gary-final-sync-reset">
        /* 1. Global Fidelity & No-Crop Rule */
        body { padding-top: 15px !important; background-color: var(--brand-bg) !important; }
        
        /* CARDINAL RULE: NEVER CROP ANY PHOTOS */
        img, 
        .hero-peek-img, 
        .service-card-image img, 
        .gw-z-image img, 
        .gw-trio-gallery img { 
            object-fit: contain !important; 
            max-width: 100% !important; 
            height: auto !important; 
            background: transparent !important; 
        } 

        /* 2. Slider Visibility Fix */
        .hero-peek-carousel,
        body .hero-peek-carousel { 
            height: 70vh !important; 
            min-height: 500px !important; 
            display: block !important; 
            visibility: visible !important;
            opacity: 1 !important;
            background: #000 !important;
            position: relative !important;
            z-index: 5 !important;
        }
        .hero-peek-slide.active { opacity: 1 !important; visibility: visible !important; transform: scale(1) !important; }
        .hero-peek-track { height: 100% !important; display: block !important; }

        /* 3. Header & Branding */
        .site-header .custom-logo { width: 320px !important; max-width: 320px !important; height: auto !important; aspect-ratio: auto !important; display: block !important; margin: 0 auto !important; }
        .menu-toggle { gap: 30px !important; border: none !important; background: none !important; display: flex !important; align-items: center !important; cursor: pointer; }
        .menu-text { color: var(--brand-accent) !important; font-weight: 700 !important; letter-spacing: 2px !important; }

        /* 4. Component Fidelity (Gold Box, Ribbons & Z-Pattern) */
        .gw-editorial-gold-box { background: #ffffff !important; border: 2px solid #C5A059 !important; padding: 40px !important; display: block !important; }
        .service-card-ribbon { display: block !important; transform: rotate(45deg) !important; z-index: 100 !important; background: #630000 !important; color: #C5A059 !important; top: 15px !important; right: -45px !important; position: absolute !important; }
        
        /* Enforced Z-Pattern Sizing (45vh Target) */
        body #primary .gw-z-image img, 
        main .gw-z-image img { 
            max-height: 45vh !important; 
            min-height: 350px !important; 
            width: auto !important; 
            border: 15px solid #fff !important;
        }

        /* 5. Menu & Modal UI Force */
        .menu-overlay[aria-hidden="false"] { opacity: 1 !important; visibility: visible !important; display: flex !important; }
        #gw-request-modal { align-items: center !important; justify-content: center !important; z-index: 99999 !important; }

        /* 6. Footer & Legal Alignment */
        body .footer-legal-list, body ul.footer-legal-list { list-style: none !important; padding: 0 !important; }
        body .footer-legal-list li::before { content: none !important; display: none !important; }
        .site-footer .footer-social { text-align: center !important; display: flex !important; flex-direction: column !important; align-items: center !important; width: 100% !important; margin-top: 10px !important; }
    </style>

    <script id="gary-zero-dep-boot">
    (function() {
        const ver = '3000.102.0';
        
        // 1. ZERO-DEPENDENCY MENU & MODAL LOGIC
        const initComponents = () => {
            const toggle = document.querySelector('.menu-toggle');
            const close = document.querySelector('.menu-close');
            const overlay = document.getElementById('primary-menu');
            
            if (toggle && overlay) {
                const openMenu = () => { overlay.setAttribute('aria-hidden', 'false'); document.body.style.overflow = 'hidden'; };
                const closeMenu = () => { overlay.setAttribute('aria-hidden', 'true'); document.body.style.overflow = ''; };
                toggle.onclick = (e) => { e.preventDefault(); openMenu(); };
                if (close) close.onclick = (e) => { e.preventDefault(); closeMenu(); };
            }

            // INQUIRY MODAL LOGIC
            const modal = document.getElementById('gw-request-modal');
            const modalForm = document.getElementById('gw-request-form');
            if (modal) {
                document.querySelectorAll('.gw-request-modal-trigger').forEach(btn => {
                    btn.onclick = (e) => {
                        e.preventDefault();
                        const service = btn.dataset.service || 'General Inquiry';
                        document.querySelector('.modal-service-name').innerText = service;
                        document.getElementById('modal-service-name-input').value = service;
                        modal.style.display = 'flex';
                    };
                });
                const modalClose = modal.querySelector('.gw-modal-close');
                if (modalClose) modalClose.onclick = () => { modal.style.display = 'none'; };
                
                if (modalForm) {
                    modalForm.onsubmit = (e) => {
                        e.preventDefault();
                        const status = modalForm.querySelector('.gw-form-status');
                        status.innerText = 'Sending...';
                        const data = new FormData(modalForm);
                        data.append('action', 'gw_submit_request');
                        fetch('/wp-admin/admin-ajax.php', { method: 'POST', body: data })
                            .then(r => r.json())
                            .then(res => {
                                if (res.success) {
                                    status.innerText = 'Sent successfully!';
                                    setTimeout(() => { modal.style.display = 'none'; modalForm.reset(); status.innerText = ''; }, 2000);
                                } else {
                                    status.innerText = 'Error: ' + res.data;
                                }
                            });
                    };
                }
            }
        };

        // 2. FIDELITY OBSERVER
        const ensureFidelity = () => {
            document.querySelectorAll('.service-card-ribbon').forEach(el => {
                el.style.setProperty('display', 'block', 'important');
            });
            if (document.querySelector('.menu-toggle') && !document.querySelector('.menu-toggle').dataset.init) {
                document.querySelector('.menu-toggle').dataset.init = 'true';
                initComponents();
            }
        };

        document.addEventListener('DOMContentLoaded', () => {
            initComponents();
            ensureFidelity();
        });
        
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
