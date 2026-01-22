<?php /** File: header.php */ ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- PERFORMANCE: Preload Critical Assets (Fonts/Images) handled in functions.php via Early Hints -->
    
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
        <nav id="site-navigation" class="focal-side focal-right">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'nav-menu-focal',
            ) );
            ?>
        </nav>

    </div>
</header>
