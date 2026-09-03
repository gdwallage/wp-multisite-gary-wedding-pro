<?php 
/** 
 * File: header.php 
 * Theme: Gary Wallage Wedding Pro
 * Version: 3003.54 (Bypass Authentik AJAX blocks & resolve column height matching collapse & parallax true lock native CSS & column constrain & height constrain & Bookly calendar mobile fix & reverted scrollytelling containment & fixed scrollytelling background height and header offsets with step min-height sizing & restored contain fit)
 */ 
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-version" content="3003.54">

    <?php wp_head(); ?>

    <style id="emergency-menu-fix">
        /* EMERGENCY OVERRIDE FOR CACHED CSS & GENRE BAR STACKING */
        @media (min-width: 1025px) {
            body { padding-top: calc(var(--header-actual-height, 82px) + 37px) !important; }
            .site-header {
                position: fixed !important;
                top: 37px !important;
                left: 0 !important;
                width: 100% !important;
                z-index: 5000 !important;
                background: #ffffff !important;
                box-shadow: none !important;
                border-bottom: 2px solid var(--brand-gold-light) !important;
            }
            /* Admin Bar Correction */
            body.admin-bar .site-header {
                top: calc(37px + 32px) !important;
            }
        }
        @media (max-width: 1024px) {
            body { padding-top: calc(70px + 37px) !important; }
            .site-header {
                position: fixed !important;
                top: 37px !important;
                left: 0 !important;
                width: 100% !important;
                max-width: 100vw !important;
                z-index: 5000 !important;
                background: #FFFFFF !important;
                box-shadow: none !important;
                height: 70px !important;
                border-bottom: 2px solid var(--brand-accent, #C5A059) !important;
                box-sizing: border-box !important;
            }
            body.admin-bar .site-header {
                top: calc(37px + 46px) !important;
            }
            @media (min-width: 783px) {
                body.admin-bar .site-header {
                    top: calc(37px + 32px) !important;
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
<?php wp_body_open(); ?>

<?php
$gw_current_host = parse_url( home_url(), PHP_URL_HOST );
$gw_genres = array(
    'boudoir' => array(
        'label' => 'Boudoir',
        'url'   => 'https://boudoir.garywallage.uk',
        'host'  => 'boudoir.garywallage.uk',
    ),
    'portrait' => array(
        'label' => 'Portrait',
        'url'   => 'https://garywallage.uk',
        'host'  => 'garywallage.uk',
        'alt_hosts' => array('portrait.garywallage.uk'),
    ),
    'family' => array(
        'label' => 'Family',
        'url'   => 'https://family.garywallage.uk',
        'host'  => 'family.garywallage.uk',
    ),
    'wedding' => array(
        'label' => 'Wedding',
        'url'   => 'https://wedding.garywallage.uk',
        'host'  => 'wedding.garywallage.uk',
    ),
    'fashion' => array(
        'label' => 'Fashion',
        'url'   => 'https://fashion.garywallage.uk',
        'host'  => 'fashion.garywallage.uk',
    ),
    'cosplay' => array(
        'label' => 'Cosplay',
        'url'   => 'https://cosplay.garywallage.uk',
        'host'  => 'cosplay.garywallage.uk',
    ),
    'glamour' => array(
        'label' => 'Glamour',
        'url'   => 'https://glamour.garywallage.uk',
        'host'  => 'glamour.garywallage.uk',
    ),
);
?>
<nav class="gw-genre-bar" aria-label="Photography genres">
    <ul class="gw-genre-list">
        <?php foreach ( $gw_genres as $gw_key => $gw_genre ) :
            $is_current = ( $gw_current_host === $gw_genre['host'] ) || ( ! empty( $gw_genre['alt_hosts'] ) && in_array( $gw_current_host, $gw_genre['alt_hosts'], true ) );
            $current_class = $is_current ? ' is-current' : '';
        ?>
            <li><a href="<?php echo esc_url( $gw_genre['url'] ); ?>" class="gw-genre-link gw-genre-<?php echo esc_attr( $gw_key ); ?><?php echo esc_attr( $current_class ); ?>"><?php echo esc_html( $gw_genre['label'] ); ?></a></li>
        <?php endforeach; ?>
    </ul>
</nav>

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
