<?php 
/** 
 * File: header.php 
 * BOUTIQUE EDITORIAL MANDATE (NON-NEGOTIABLE):
 * - Must maintain 10-80-10 Layout.
 * - Central Logo MUST overlap Hero Slider.
 * - No aggressive cropping of photography.
 */ 
?>
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

    <!-- ALL STYLING DELEGATED TO VERSIONED STYLE.CSS -->
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
            <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false" aria-label="Toggle navigation" 
                onclick="var m=document.getElementById('primary-menu'); if(m){ m.style.display='flex'; m.style.opacity='1'; m.style.visibility='visible'; m.style.zIndex='99999'; var inner=m.querySelector('.menu-overlay-inner'); if(inner){ inner.setAttribute('style', 'display: flex !important; opacity: 1 !important; visibility: visible !important; background: white !important; transform: scale(1) translateY(0) !important;'); } document.body.style.overflow='hidden'; this.setAttribute('aria-expanded','true'); }">
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
        <button class="menu-close" aria-label="Close navigation" 
            onclick="var m=document.getElementById('primary-menu'); if(m){ m.style.display='none'; m.style.opacity='0'; m.style.visibility='hidden'; document.body.style.overflow=''; document.querySelector('.menu-toggle').setAttribute('aria-expanded','false'); }">&times;</button>
        <nav class="overlay-nav">
            <p style="color:red; font-weight:bold; text-align:center;">MENU CONTENT TEST</p>
            <?php
            if ( has_nav_menu( 'primary' ) ) {
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'nav-menu-overlay',
                ) );
            } else {
                echo '<ul class="nav-menu-overlay">';
                wp_list_pages( array( 'title_li' => '', 'depth' => 1 ) );
                echo '</ul>';
            }
            ?>
        </nav>
    </div>
</div>
