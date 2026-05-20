<?php 
/** 
 * File: header.php 
 * Theme: Gary Wallage Wedding Pro
 * Version: 3002.16 (Prevent step 1 background fade-in and resolve mobile column race condition)
 */ 
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-version" content="3002.16">

    <?php wp_head(); ?>

    <style id="emergency-menu-fix">
        /* EMERGENCY OVERRIDE FOR CACHED CSS */
        @media (min-width: 1025px) {
            body { padding-top: 95px !important; }
            .site-header {
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                width: 100% !important;
                z-index: 5000 !important;
                background: #ffffff !important;
                box-shadow: none !important;
            }
            /* Admin Bar Correction */
            body.admin-bar .site-header {
                top: 32px !important;
            }
        }
        @media (max-width: 1024px) {
            body { padding-top: 70px !important; }
            .site-header {
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                width: 100% !important;
                z-index: 5000 !important;
                background: var(--brand-bg, #F9F9F7) !important;
                box-shadow: 0 2px 10px rgba(0,0,0,0.05) !important;
                height: 70px !important;
            }
            body.admin-bar .site-header {
                top: 46px !important;
            }
            @media (min-width: 783px) {
                body.admin-bar .site-header {
                    top: 32px !important;
                }
            }
        }
        .menu-overlay.active {
            display: flex !important;
            visibility: visible !important;
            opacity: 1 !important;
            z-index: 1000000 !important;
        }
        .menu-overlay-inner {
            opacity: 1 !important;
            display: flex !important;
        }
        /* Fix the white-text-on-white-box styling collision */
        .menu-overlay-inner .nav-menu-overlay li a {
            color: #111111 !important;
            font-size: clamp(0.9rem, 2.5vh, 1.5rem) !important;
            text-transform: uppercase !important;
            letter-spacing: 3px !important;
        }
        .menu-overlay-inner .nav-menu-overlay li a:hover {
            color: var(--brand-gold-light) !important;
            letter-spacing: 5px !important;
        }
    </style>
</head>
<body <?php body_class(); ?>>
    <!-- VERSION 3002.16 -->
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="header-focal-container">

        <!-- Zone 1: Branding -->
        <div class="focal-side focal-left">
            <div class="branding-group">
                <div class="site-title-blacksword"><?php bloginfo( 'name' ); ?></div>
                <div class="site-tagline-lato"><?php bloginfo( 'description' ); ?></div>
            </div>
        </div>

        <!-- Zone 2: Logo -->
        <div class="focal-center">
            <?php
            if ( has_custom_logo() ) :
                the_custom_logo();
            else :
                echo '<div class="logo-placeholder">G.W</div>';
            endif;
            ?>
        </div>

        <!-- Zone 3: Navigation -->
        <div class="focal-side focal-right nav-toggle-container">
            <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
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
        <button class="menu-close">&times;</button>
        <nav class="overlay-nav">
            <!-- MENU CONTENT TEST: Version 3001.58 -->
            <ul class="nav-menu-overlay">
                <li class="menu-item"><a href="/" style="color: #fff !important; font-size: 2.5rem;">HOME (Safety Link)</a></li>
            </ul>
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
