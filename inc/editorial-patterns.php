<?php
/**
 * Register Native Control Editorial Block Patterns
 */

function gary_register_native_editorial_patterns() {
    if ( ! function_exists( 'register_block_pattern_category' ) ) return;

    register_block_pattern_category( 'gary-editorial-native', array( 'label' => __( 'Gary Wallage Editorial', 'garywedding' ) ) );

    // Common SVG Placeholder for editor aesthetics
    $svg = esc_url('data:image/svg+xml;utf8,%3Csvg opacity="0.05" width="100%25" height="100%25" xmlns="http://www.w3.org/2000/svg"%3E%3Crect width="100%25" height="100%25" fill="%23C5A059"/%3E%3C/svg%3E');

    // 1. Z-Pattern Left
    register_block_pattern( 'gw/z-pattern-left', array(
        'title'         => __( 'Z-Pattern (Image Left)', 'garywedding' ),
        'categories'    => array( 'gary-editorial-native' ),
        'viewportWidth' => 1000,
        'content'       => '<!-- wp:columns {"verticalAlignment":"center","align":"wide"} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center","width":"55%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:55%"><!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"is-style-default"} -->
<figure class="wp-block-image size-large is-style-default"><img src="' . $svg . '" alt="Select and click Replace Toolbar" style="border:10px solid #ffffff;box-shadow:0 15px 40px rgba(0,0,0,0.08);background:#f0f0f0;min-height:500px;"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->
<!-- wp:column {"verticalAlignment":"center","width":"55%","style":{"spacing":{"padding":{"top":"8%","right":"8%","bottom":"8%","left":"8%"},"margin":{"left":"-10%"}},"color":{"background":"#ffffff"}}} -->
<div class="wp-block-column is-vertically-aligned-center has-background" style="background-color:#ffffff;padding-top:8%;padding-right:8%;padding-bottom:8%;padding-left:8%;margin-left:-10%;flex-basis:55%;z-index:10;box-shadow:0 10px 40px rgba(0,0,0,0.05);"><!-- wp:heading {"textAlign":"center","level":3,"style":{"color":{"text":"#c5a059"}}} -->
<h3 class="wp-block-heading has-text-align-center has-text-color" style="color:#c5a059">A Moment in Time</h3>
<!-- /wp:heading -->
<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Click here to write your story. Because this is a native block, you can select the outer box and change its padding, background color, or margins using the right sidebar!</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->',
    ) );

    // 2. Z-Pattern Right
    register_block_pattern( 'gw/z-pattern-right', array(
        'title'         => __( 'Z-Pattern (Image Right)', 'garywedding' ),
        'categories'    => array( 'gary-editorial-native' ),
        'viewportWidth' => 1000,
        'content'       => '<!-- wp:columns {"verticalAlignment":"center","align":"wide"} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center","width":"55%","style":{"spacing":{"padding":{"top":"8%","right":"8%","bottom":"8%","left":"8%"},"margin":{"right":"-10%"}},"color":{"background":"#ffffff"}}} -->
<div class="wp-block-column is-vertically-aligned-center has-background" style="background-color:#ffffff;padding-top:8%;padding-right:8%;padding-bottom:8%;padding-left:8%;margin-right:-10%;flex-basis:55%;z-index:10;box-shadow:0 10px 40px rgba(0,0,0,0.05);"><!-- wp:heading {"textAlign":"center","level":3,"style":{"color":{"text":"#c5a059"}}} -->
<h3 class="wp-block-heading has-text-align-center has-text-color" style="color:#c5a059">Unscripted Joy</h3>
<!-- /wp:heading -->
<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Use this alternating pattern to break up wide text segments. Edit colors, typography, and overlaps visually.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->
<!-- wp:column {"verticalAlignment":"center","width":"55%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:55%"><!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="' . $svg . '" alt="Select and Replace" style="border:10px solid #ffffff;box-shadow:0 15px 40px rgba(0,0,0,0.08);background:#f0f0f0;min-height:500px;"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->',
    ) );

    // 3. Gallery Wall Trio
    register_block_pattern( 'gw/trio-gallery', array(
        'title'         => __( 'The Gallery Wall Trio', 'garywedding' ),
        'categories'    => array( 'gary-editorial-native' ),
        'viewportWidth' => 1000,
        'content'       => '<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"30px","left":"30px"}}}} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"width":"66.66%"} -->
<div class="wp-block-column" style="flex-basis:66.66%"><!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="' . $svg . '" alt="Replace this main piece" style="border:8px solid #ffffff;box-shadow:0 10px 20px rgba(0,0,0,0.05);background:#f0f0f0;height:630px;object-fit:cover;"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->
<!-- wp:column {"width":"33.33%","style":{"spacing":{"blockGap":"30px"}}} -->
<div class="wp-block-column" style="flex-basis:33.33%"><!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="' . $svg . '" alt="Top right image" style="border:8px solid #ffffff;box-shadow:0 10px 20px rgba(0,0,0,0.05);background:#f0f0f0;height:300px;object-fit:cover;"/></figure>
<!-- /wp:image -->
<!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="' . $svg . '" alt="Bottom right image" style="border:8px solid #ffffff;box-shadow:0 10px 20px rgba(0,0,0,0.05);background:#f0f0f0;height:300px;object-fit:cover;"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->',
    ) );

    // 4. Cinematic Hero Bleed
    register_block_pattern( 'gw/cinematic-bleed', array(
        'title'         => __( 'Cinematic Hero Bleed', 'garywedding' ),
        'categories'    => array( 'gary-editorial-native' ),
        'viewportWidth' => 1000,
        'content'       => '<!-- wp:cover {"url":"' . $svg . '","dimRatio":10,"overlayColor":"base","align":"full","style":{"spacing":{"padding":{"top":"150px","right":"20px","bottom":"150px","left":"20px"}}}} -->
<div class="wp-block-cover alignfull has-base-background-color has-background-dim-10 has-background-dim" style="padding-top:150px;padding-right:20px;padding-bottom:150px;padding-left:20px"><img class="wp-block-cover__image-background" alt="Hero Bleed" src="' . $svg . '" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:heading {"textAlign":"center","level":2,"style":{"color":{"text":"#ffffff"}}} -->
<h2 class="wp-block-heading has-text-align-center has-text-color" style="color:#ffffff">Replace Cover Background</h2>
<!-- /wp:heading --></div></div>
<!-- /wp:cover -->',
    ) );

    // 5. Editorial Split
    register_block_pattern( 'gw/editorial-split', array(
        'title'         => __( 'Editorial Split (50/50)', 'garywedding' ),
        'categories'    => array( 'gary-editorial-native' ),
        'viewportWidth' => 1000,
        'content'       => '<!-- wp:media-text {"mediaPosition":"right","mediaType":"image","imageFill":false,"style":{"color":{"background":"#fefefe"}}} -->
<div class="wp-block-media-text alignwide has-media-on-the-right is-stacked-on-mobile has-background" style="background-color:#fefefe"><figure class="wp-block-media-text__media"><img src="' . $svg . '" alt="" style="background:#eeeeee;padding:15px;min-height:400px;"/></figure><div class="wp-block-media-text__content"><!-- wp:heading {"level":3,"style":{"color":{"text":"#c5a059"}}} -->
<h3 class="wp-block-heading has-text-color" style="color:#c5a059">Magazine Layout</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Clean, crisp, and split flawlessly down the middle. Best used for "About" introductions or explaining a specific package offering.</p>
<!-- /wp:paragraph --></div></div>
<!-- /wp:media-text -->',
    ) );

    // 6. Storyteller Grid (4 Pcs)
    register_block_pattern( 'gw/storyteller-grid', array(
        'title'         => __( 'The Storyteller Grid (4 Pcs)', 'garywedding' ),
        'categories'    => array( 'gary-editorial-native' ),
        'viewportWidth' => 1000,
        'content'       => '<!-- wp:gallery {"columns":2,"linkTo":"none","style":{"spacing":{"blockGap":{"top":"5px","left":"5px"}}}} -->
<figure class="wp-block-gallery has-nested-images columns-2 is-cropped"><!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="' . $svg . '" alt=""/></figure>
<!-- /wp:image -->
<!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="' . $svg . '" alt=""/></figure>
<!-- /wp:image -->
<!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="' . $svg . '" alt=""/></figure>
<!-- /wp:image -->
<!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="' . $svg . '" alt=""/></figure>
<!-- /wp:image --></figure>
<!-- /wp:gallery -->',
    ) );

    // 7. Call-to-Action Plaque
    register_block_pattern( 'gw/cta-plaque', array(
        'title'         => __( 'Call-to-Action Plaque', 'garywedding' ),
        'categories'    => array( 'gary-editorial-native' ),
        'viewportWidth' => 1000,
        'content'       => '<!-- wp:group {"style":{"border":{"width":"2px","color":"#c5a059"},"spacing":{"padding":{"top":"60px","right":"40px","bottom":"60px","left":"40px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="border-color:#c5a059;border-width:2px;padding-top:60px;padding-right:40px;padding-bottom:60px;padding-left:40px"><!-- wp:heading {"textAlign":"center","style":{"typography":{"textTransform":"uppercase","letterSpacing":"2px"}}} -->
<h2 class="wp-block-heading has-text-align-center" style="letter-spacing:2px;text-transform:uppercase">Ready to Secure Your Date?</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">I take on a limited number of weddings each year.</p>
<!-- /wp:paragraph -->
<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"style":{"border":{"radius":"2px"},"color":{"background":"#b08d55"}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-background wp-element-button" style="border-radius:2px;background-color:#b08d55">Inquire Now</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->',
    ) );

    // 8. Testimonial Transparency
    register_block_pattern( 'gw/testimonial-bg', array(
        'title'         => __( 'Testimonial Transparency', 'garywedding' ),
        'categories'    => array( 'gary-editorial-native' ),
        'viewportWidth' => 1000,
        'content'       => '<!-- wp:cover {"url":"' . $svg . '","dimRatio":80,"overlayColor":"base","isUserOverlayColor":true,"align":"wide","style":{"spacing":{"padding":{"top":"100px","bottom":"100px"}}}} -->
<div class="wp-block-cover alignwide has-base-background-color has-background-dim-80 has-background-dim" style="padding-top:100px;padding-bottom:100px"><img class="wp-block-cover__image-background" alt="" src="' . $svg . '" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:quote {"textAlign":"center","style":{"color":{"text":"#ffffff"},"typography":{"fontSize":"1.5rem"}}} -->
<blockquote class="wp-block-quote has-text-align-center has-text-color" style="color:#ffffff;font-size:1.5rem"><p>"The purest moments captured flawlessly. We forgot he was there, yet he caught every single tear."</p><cite>— EMMA &amp; JAMES</cite></blockquote>
<!-- /wp:quote --></div></div>
<!-- /wp:cover -->',
    ) );

    // 9. Fine-Art Polaroid
    register_block_pattern( 'gw/polaroid', array(
        'title'         => __( 'Fine-Art Polaroid', 'garywedding' ),
        'categories'    => array( 'gary-editorial-native' ),
        'viewportWidth' => 400,
        'content'       => '<!-- wp:group {"style":{"color":{"background":"#ffffff"},"spacing":{"padding":{"top":"5%","right":"5%","bottom":"15%","left":"5%"}}},"layout":{"type":"constrained","justifyContent":"center"}} -->
<div class="wp-block-group has-background" style="background-color:#ffffff;padding-top:5%;padding-right:5%;padding-bottom:15%;padding-left:5%"><!-- wp:image {"align":"center","sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image aligncenter size-large"><img src="' . $svg . '" alt="" style="min-height:300px;background:#eee;"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group -->',
    ) );

    // 10. Chapter Break
    register_block_pattern( 'gw/chapter-break', array(
        'title'         => __( 'The Chapter Break', 'garywedding' ),
        'categories'    => array( 'gary-editorial-native' ),
        'viewportWidth' => 1000,
        'content'       => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"80px","bottom":"80px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:80px;padding-bottom:80px"><!-- wp:separator {"backgroundColor":"gold-light","className":"is-style-wide"} -->
<hr class="wp-block-separator has-text-color has-gold-light-color has-alpha-channel-opacity has-gold-light-background-color has-background is-style-wide"/>
<!-- /wp:separator -->
<!-- wp:heading {"textAlign":"center","style":{"typography":{"textTransform":"uppercase","letterSpacing":"8px","fontSize":"0.9rem"}}} -->
<h2 class="wp-block-heading has-text-align-center" style="font-size:0.9rem;letter-spacing:8px;text-transform:uppercase">Photographing Life</h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->',
    ) );

    // 11. Trust Bar
    register_block_pattern( 'gw/trust-bar', array(
        'title'         => __( 'Trust Bar (5 Signals)', 'garywedding' ),
        'categories'    => array( 'gary-editorial-native' ),
        'viewportWidth' => 1000,
        'content'       => '<!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"20px","bottom":"20px"}},"color":{"background":"#1a1a1a"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"center"}} -->
<div class="wp-block-group alignwide has-background" style="background-color:#1a1a1a;padding-top:20px;padding-bottom:20px"><!-- wp:paragraph {"style":{"color":{"text":"#c5a059"},"typography":{"fontSize":"0.85rem","textTransform":"uppercase","letterSpacing":"1px"}}} -->
<p class="has-text-color" style="color:#c5a059;font-size:0.85rem;letter-spacing:1px;text-transform:uppercase"><strong>✓</strong> 10+ Years Experience</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"style":{"color":{"text":"#c5a059"},"typography":{"fontSize":"0.85rem","textTransform":"uppercase","letterSpacing":"1px"}}} -->
<p class="has-text-color" style="color:#c5a059;font-size:0.85rem;letter-spacing:1px;text-transform:uppercase"><strong>✓</strong> Documentary Style</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"style":{"color":{"text":"#c5a059"},"typography":{"fontSize":"0.85rem","textTransform":"uppercase","letterSpacing":"1px"}}} -->
<p class="has-text-color" style="color:#c5a059;font-size:0.85rem;letter-spacing:1px;text-transform:uppercase"><strong>✓</strong> Swindon &amp; Wiltshire</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"style":{"color":{"text":"#c5a059"},"typography":{"fontSize":"0.85rem","textTransform":"uppercase","letterSpacing":"1px"}}} -->
<p class="has-text-color" style="color:#c5a059;font-size:0.85rem;letter-spacing:1px;text-transform:uppercase"><strong>✓</strong> Limited Bookings</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"style":{"color":{"text":"#c5a059"},"typography":{"fontSize":"0.85rem","textTransform":"uppercase","letterSpacing":"1px"}}} -->
<p class="has-text-color" style="color:#c5a059;font-size:0.85rem;letter-spacing:1px;text-transform:uppercase"><strong>✓</strong> Free Consultation</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->',
    ) );

    // 12. USPs (3 Columns)
    register_block_pattern( 'gw/usps-3col', array(
        'title'         => __( 'USPs (3 Columns)', 'garywedding' ),
        'categories'    => array( 'gary-editorial-native' ),
        'viewportWidth' => 1000,
        'content'       => '<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"40px","left":"40px"},"padding":{"top":"60px","bottom":"60px"}}}} -->
<div class="wp-block-columns alignwide" style="padding-top:60px;padding-bottom:60px"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"textAlign":"center","level":4,"style":{"color":{"text":"#c5a059"},"typography":{"textTransform":"uppercase","letterSpacing":"2px"}}} -->
<h4 class="wp-block-heading has-text-align-center has-text-color" style="color:#c5a059;letter-spacing:2px;text-transform:uppercase">Documentary Storytelling</h4>
<!-- /wp:heading -->
<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">I blend into the background and document your day exactly as it unfolds — unposed, unrepeated, and completely authentic.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"textAlign":"center","level":4,"style":{"color":{"text":"#c5a059"},"typography":{"textTransform":"uppercase","letterSpacing":"2px"}}} -->
<h4 class="wp-block-heading has-text-align-center has-text-color" style="color:#c5a059;letter-spacing:2px;text-transform:uppercase">Technical Precision</h4>
<!-- /wp:heading -->
<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Ten years of experience means no weather, no venue, and no timeline pressure will ever compromise your final images.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"textAlign":"center","level":4,"style":{"color":{"text":"#c5a059"},"typography":{"textTransform":"uppercase","letterSpacing":"2px"}}} -->
<h4 class="wp-block-heading has-text-align-center has-text-color" style="color:#c5a059;letter-spacing:2px;text-transform:uppercase">A Calming Presence</h4>
<!-- /wp:heading -->
<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Many couples describe me as the most relaxed person in the room. That calm is entirely intentional and it shows.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->',
    ) );

    // 13. Featured Services Wrapper
    register_block_pattern( 'gw/featured-services', array(
        'title'         => __( 'Featured Services Grid', 'garywedding' ),
        'categories'    => array( 'gary-editorial-native' ),
        'viewportWidth' => 1000,
        'content'       => '<!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"80px","bottom":"80px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide" style="padding-top:80px;padding-bottom:80px"><!-- wp:heading {"textAlign":"center","style":{"typography":{"textTransform":"uppercase","letterSpacing":"3px","fontSize":"2rem"}}} -->
<h2 class="wp-block-heading has-text-align-center" style="font-size:2rem;letter-spacing:3px;text-transform:uppercase">Featured Collections</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Select your services from the block settings.</p>
<!-- /wp:paragraph -->
<!-- wp:gw/service-grid -->
<div class="wp-block-gw-service-grid detailed-components-section"><!-- wp:gw/single-service /-->
<!-- wp:gw/single-service /-->
<!-- wp:gw/single-service /--></div>
<!-- /wp:gw/service-grid --></div>
<!-- /wp:group -->',
    ) );

    // 14. Full-Width CTA
    register_block_pattern( 'gw/cta-fullwidth', array(
        'title'         => __( 'Full-Width Action Plate', 'garywedding' ),
        'categories'    => array( 'gary-editorial-native' ),
        'viewportWidth' => 1000,
        'content'       => '<!-- wp:cover {"url":"' . $svg . '","dimRatio":90,"overlayColor":"base","isUserOverlayColor":true,"align":"full","style":{"spacing":{"padding":{"top":"120px","right":"20px","bottom":"120px","left":"20px"}}}} -->
<div class="wp-block-cover alignfull has-base-background-color has-background-dim-90 has-background-dim" style="padding-top:120px;padding-right:20px;padding-bottom:120px;padding-left:20px"><img class="wp-block-cover__image-background" alt="" src="' . $svg . '" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:heading {"textAlign":"center","style":{"color":{"text":"#ffffff"},"typography":{"textTransform":"uppercase","letterSpacing":"3px"}}} -->
<h2 class="wp-block-heading has-text-align-center has-text-color" style="color:#ffffff;letter-spacing:3px;text-transform:uppercase">Ready to Tell Your Story?</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"align":"center","style":{"color":{"text":"#cccccc"}}} -->
<p class="has-text-align-center has-text-color" style="color:#cccccc">I take on a limited number of bookings each year to ensure full creative focus.</p>
<!-- /wp:paragraph -->
<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"style":{"border":{"radius":"0px","width":"2px"},"color":{"background":"#c5a059","text":"#1a1a1a"}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-text-color has-background wp-element-button" style="border-width:2px;border-radius:0px;color:#1a1a1a;background-color:#c5a059">View Pricing</a></div>
<!-- /wp:button -->
<!-- wp:button {"style":{"border":{"radius":"0px","color":"#ffffff","width":"2px"},"color":{"text":"#ffffff"}},"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-text-color wp-element-button" style="border-color:#ffffff;border-width:2px;border-radius:0px;color:#ffffff">Book Consultation</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div></div>
<!-- /wp:cover -->',
    ) );

}
add_action( 'init', 'gary_register_native_editorial_patterns' );
