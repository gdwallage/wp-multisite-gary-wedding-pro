<?php
/**
 * Register Native Control Editorial Block Patterns
 */

function gary_register_native_editorial_patterns() {
    if ( ! function_exists( 'register_block_pattern_category' ) ) return;

    register_block_pattern_category( 'gary-editorial-native', array( 'label' => __( 'Gary Wallage Editorial', 'garywedding' ) ) );

    // Common SVG Placeholder for editor aesthetics
    $svg = esc_url('data:image/svg+xml;utf8,%3Csvg opacity="0.05" width="100%25" height="100%25" xmlns="http://www.w3.org/2000/svg"%3E%3Crect width="100%25" height="100%25" fill="%23C5A059"/%3E%3C/svg%3E');

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


    // 8. Testimonial Transparency
    register_block_pattern( 'gw/testimonial-bg', array(
        'title'         => __( 'Testimonial Transparency', 'garywedding' ),
        'categories'    => array( 'gary-editorial-native' ),
        'viewportWidth' => 1000,
        'content'       => '<!-- wp:cover {"url":"' . $svg . '","dimRatio":80,"overlayColor":"base","isUserOverlayColor":true,"style":{"spacing":{"padding":{"top":"100px","bottom":"100px"}}}} -->
<div class="wp-block-cover has-base-background-color has-background-dim-80 has-background-dim" style="padding-top:100px;padding-bottom:100px"><img class="wp-block-cover__image-background" alt="" src="' . $svg . '" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:quote {"textAlign":"center","style":{"color":{"text":"#ffffff"},"typography":{"fontSize":"1.5rem"}}} -->
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





    // 14. Full-Width CTA
    register_block_pattern( 'gw/cta-fullwidth', array(
        'title'         => __( 'Full-Width Action Plate', 'garywedding' ),
        'categories'    => array( 'gary-editorial-native' ),
        'viewportWidth' => 1000,
        'content'       => '<!-- wp:cover {"url":"' . $svg . '","dimRatio":90,"overlayColor":"base","isUserOverlayColor":true,"align":"full"} -->
<div class="wp-block-cover alignfull has-base-background-color has-background-dim-90 has-background-dim"><img class="wp-block-cover__image-background" alt="" src="' . $svg . '" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:heading {"textAlign":"center","style":{"color":{"text":"#ffffff"},"typography":{"textTransform":"uppercase","letterSpacing":"3px"}}} -->
<h2 class="wp-block-heading has-text-align-center has-text-color" style="color:#ffffff;letter-spacing:3px;text-transform:uppercase">Ready to Tell Your Story?</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"align":"center","style":{"color":{"text":"#cccccc"}}} -->
<p class="has-text-align-center has-text-color" style="color:#cccccc">I take on a limited number of bookings each year to ensure full creative focus.</p>
<!-- /wp:paragraph -->
<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"style":{"color":{"background":"#c5a059","text":"#1a1a1a"}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-text-color has-background wp-element-button" style="color:#1a1a1a;background-color:#c5a059">View Pricing</a></div>
<!-- /wp:button -->
<!-- wp:button {"style":{"border":{"color":"#ffffff"}},"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-text-color wp-element-button" style="border-color:#ffffff;color:#ffffff">Book Consultation</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div></div>
<!-- /wp:cover -->',
    ) );

    // 16. Highlights List
    register_block_pattern( 'gw/list-highlights', array(
        'title'         => __( 'Personalized Experience Highlights', 'garywedding' ),
        'categories'    => array( 'gary-editorial-native' ),
        'content'       => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"30px","right":"30px","bottom":"30px","left":"30px"}},"color":{"background":"#fdfdfd"}}} -->
<div class="wp-block-group has-background" style="background-color:#fdfdfd;padding-top:30px;padding-right:30px;padding-bottom:30px;padding-left:30px"><!-- wp:heading {"level":4,"style":{"typography":{"textTransform":"uppercase","letterSpacing":"1px"}}} -->
<h4 class="wp-block-heading" style="letter-spacing:1px;text-transform:uppercase">Personalized Experience Highlights</h4>
<!-- /wp:heading -->
<!-- wp:list {"className":"is-style-gw-highlights"} -->
<ul class="is-style-gw-highlights"><li>Initial concept and style consultation</li><li>Bespoke location scouting</li><li>Full creative direction on the day</li></ul>
<!-- /wp:list --></div>
<!-- /wp:group -->',
    ) );

    // 17. Included List
    register_block_pattern( 'gw/list-included', array(
        'title'         => __( 'What\'s Included Box', 'garywedding' ),
        'categories'    => array( 'gary-editorial-native' ),
        'content'       => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"30px","right":"30px","bottom":"30px","left":"30px"}},"border":{"width":"1px","color":"#e0e0e0"}}} -->
<div class="wp-block-group has-border-color" style="border-color:#e0e0e0;border-width:1px;padding-top:30px;padding-right:30px;padding-bottom:30px;padding-left:30px"><!-- wp:heading {"level":4,"style":{"typography":{"textTransform":"uppercase","letterSpacing":"1px"}}} -->
<h4 class="wp-block-heading" style="letter-spacing:1px;text-transform:uppercase">What\'s Included</h4>
<!-- /wp:heading -->
<!-- wp:list {"className":"is-style-gw-included"} -->
<ul class="is-style-gw-included"><li><strong>8 Hours Coverage:</strong> From morning preparations to the first dance.</li><li><strong>Online Gallery:</strong> Beautifully presented digital delivery of your images.</li><li><strong>Printing Rights:</strong> Full permission to print and share your photographs.</li></ul>
<!-- /wp:list --></div>
<!-- /wp:group -->',
    ) );

    // 18. Perfect For List
    register_block_pattern( 'gw/list-perfect-for', array(
        'title'         => __( 'Perfect For...', 'garywedding' ),
        'categories'    => array( 'gary-editorial-native' ),
        'content'       => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"20px","right":"20px","bottom":"20px","left":"20px"}}}} -->
<div class="wp-block-group" style="padding-top:20px;padding-right:20px;padding-bottom:20px;padding-left:20px"><!-- wp:heading {"level":4,"style":{"typography":{"textTransform":"uppercase","letterSpacing":"1px"}}} -->
<h4 class="wp-block-heading" style="letter-spacing:1px;text-transform:uppercase">Perfect For</h4>
<!-- /wp:heading -->
<!-- wp:list {"className":"is-style-gw-perfect-for"} -->
<ul class="is-style-gw-perfect-for"><li>Couples who value authentic documentation</li><li>Intimate boutique weddings</li><li>Those seeking a relaxed, unscripted approach</li></ul>
<!-- /wp:list --></div>
<!-- /wp:group -->',
    ) );

}
add_action( 'init', 'gary_register_native_editorial_patterns' );
