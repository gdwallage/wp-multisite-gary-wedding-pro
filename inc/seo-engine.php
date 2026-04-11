<?php
/**
 * SEO Engine for Gary Wallage Wedding Pro
 * Version: 2.0.0
 * Fixes: Canonical URL, meta description length, schema errors (WeddingService→ProfessionalService),
 *        priceRange currency, hreflang, title length filter, social sameAs.
 */

// ---------------------------------------------------------------------------
// SUPPRESS DUPLICATE HEAD TAGS
// WordPress core outputs its own canonical via rel_canonical (priority 10).
// We output our own at priority 2, so we must remove core's version.
// ---------------------------------------------------------------------------
remove_action( 'wp_head', 'rel_canonical' );              // WP core canonical
remove_action( 'wp_head', 'rsd_link' );                   // Not needed
remove_action( 'wp_head', 'wlwmanifest_link' );           // Not needed

// ---------------------------------------------------------------------------
// TITLE LENGTH FILTER — keeps <title> under 58 chars for on-page SEO
// ---------------------------------------------------------------------------
add_filter( 'pre_get_document_title', 'gary_optimised_title', 10 );
function gary_optimised_title( $title ) {
    if ( is_front_page() || is_home() ) {
        return 'Gary Wallage | Wedding Photographer Swindon & Wiltshire';
    }
    return $title; // Let other pages use their default title
}

// ---------------------------------------------------------------------------
// MAIN SEO HEAD OUTPUT
// ---------------------------------------------------------------------------
function gary_wedding_seo_engine() {

    // --- Core data ---
    $business_name = 'Gary Wallage Wedding Photography';
    $location      = 'Wiltshire & the South West';
    $phone         = '07970 262 387';
    $address_street = '63 Twineham Road';
    $address_city   = 'Swindon';
    $address_post   = 'SN25 2AG';

    // Social links — Customizer-driven, with known defaults
    $social_fb     = get_theme_mod( 'social_facebook',  'https://www.facebook.com/garywallage.wedding' );
    $social_insta  = get_theme_mod( 'social_instagram', 'https://www.instagram.com/garywallage.wedding' );
    $social_yt     = get_theme_mod( 'social_youtube',   '' );
    $social_x      = get_theme_mod( 'social_twitter',   '' );
    $social_li     = get_theme_mod( 'social_linkedin',  '' );

    // Build sameAs array — only include non-empty URLs
    $same_as = array_values( array_filter( [
        $social_fb, $social_insta, $social_yt, $social_x, $social_li
    ] ) );

    // --- Page-specific title / description / url ---
    $post_id     = get_the_ID();
    $manual_title = get_post_meta( $post_id, '_gary_seo_title', true );
    $manual_desc  = get_post_meta( $post_id, '_gary_seo_desc', true );

    if ( is_front_page() || is_home() ) {
        $title       = !empty($manual_title) ? $manual_title : 'Gary Wallage | Wedding Photographer Swindon & Wiltshire';
        $description = !empty($manual_desc) ? $manual_desc : 'Wedding photographer in Swindon, Wiltshire & the South West. Editorial storytelling, precise framing & unforgettable memories.';
        $url         = trailingslashit( home_url() );
        $og_type     = 'website';
    } elseif ( is_page() || is_single() ) {
        $title       = !empty($manual_title) ? $manual_title : get_the_title() . ' | Gary Wallage Weddings';
        $description = !empty($manual_desc) ? $manual_desc : (get_the_excerpt() ?: wp_trim_words( get_the_content(), 25 ));
        $url         = get_permalink();
        $og_type     = is_single() ? 'article' : 'website';
    } else {
        $title       = !empty($manual_title) ? $manual_title : get_bloginfo( 'name' );
        $description = !empty($manual_desc) ? $manual_desc : get_bloginfo( 'description' );
        $url         = get_permalink();
        $og_type     = 'website';
    }

    // OG image
    $image = get_the_post_thumbnail_url( get_the_ID(), 'large' )
          ?: get_site_icon_url( 512 )
          ?: '';

    // Logo for schema
    $logo_url = get_site_icon_url( 512 ) ?: $image;

    // ---------------------------------------------------------------------------
    // OUTPUT
    // ---------------------------------------------------------------------------
    echo "\n<!-- [SEO Engine v2.0 · Gary Wallage Wedding Pro] -->\n";

    // --- Meta description ---
    echo '<meta name="description" content="' . esc_attr( $description ) . '">' . "\n";

    // --- Canonical (single, explicit) ---
    echo '<link rel="canonical" href="' . esc_url( $url ) . '">' . "\n";

    // --- Hreflang (en-GB self-reference) ---
    if ( is_front_page() ) {
        echo '<link rel="alternate" hreflang="en-GB" href="' . esc_url( trailingslashit( home_url() ) ) . '">' . "\n";
        echo '<link rel="alternate" hreflang="x-default" href="' . esc_url( trailingslashit( home_url() ) ) . '">' . "\n";
    }

    // --- Open Graph ---
    echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '">' . "\n";
    echo '<meta property="og:type"      content="' . esc_attr( $og_type ) . '">' . "\n";
    echo '<meta property="og:title"     content="' . esc_attr( $title ) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr( $description ) . '">' . "\n";
    echo '<meta property="og:url"       content="' . esc_url( $url ) . '">' . "\n";
    if ( $image ) {
        echo '<meta property="og:image" content="' . esc_url( $image ) . '">' . "\n";
    }
    echo '<meta property="og:locale"    content="en_GB">' . "\n";

    // --- Twitter / X Card ---
    echo '<meta name="twitter:card"        content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title"       content="' . esc_attr( $title ) . '">' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr( $description ) . '">' . "\n";
    if ( $image ) {
        echo '<meta name="twitter:image"   content="' . esc_url( $image ) . '">' . "\n";
    }
    if ( $social_x ) {
        // Extract handle from URL if present
        $x_handle = '@' . rtrim( basename( rtrim( $social_x, '/' ) ), '/' );
        echo '<meta name="twitter:site"    content="' . esc_attr( $x_handle ) . '">' . "\n";
    }

    // ---------------------------------------------------------------------------
    // JSON-LD SCHEMA — fixed types & properties
    // ---------------------------------------------------------------------------
    $local_biz = [
        '@type'       => 'ProfessionalService',
        '@id'         => trailingslashit( home_url() ) . '#localbusiness',
        'name'        => $business_name,
        'url'         => trailingslashit( home_url() ),
        'telephone'   => $phone,
        'priceRange'  => '£££',       // Corrected: £ not $
        'address'     => [
            '@type'           => 'PostalAddress',
            'streetAddress'   => $address_street,
            'addressLocality' => $address_city,
            'postalCode'      => $address_post,
            'addressCountry'  => 'GB',
        ],
        'areaServed'  => [
            [ '@type' => 'State', 'name' => 'Wiltshire' ],
            [ '@type' => 'State', 'name' => 'Somerset' ],
            [ '@type' => 'State', 'name' => 'Berkshire' ],
            [ '@type' => 'Country', 'name' => 'England' ],
        ],
        'knowsAbout'   => [ 'Wedding Photography', 'Editorial Photography', 'Documentary Photography' ],
    ];

    // Add image if available
    if ( $logo_url ) {
        $local_biz['logo']  = $logo_url;
        $local_biz['image'] = $logo_url;
    }

    // Add sameAs only if we have social links
    if ( ! empty( $same_as ) ) {
        $local_biz['sameAs'] = $same_as;
    }

    // Service node
    $service_node = [
        '@type'       => 'Service',
        '@id'         => trailingslashit( home_url() ) . '#wedding-photography-service',
        'name'        => 'Wedding Photography',
        'serviceType' => 'Wedding Photography',
        'description' => $description,
        'provider'    => [ '@id' => trailingslashit( home_url() ) . '#localbusiness' ],
        'areaServed'  => 'South West England',
    ];

    $graph = [ $local_biz, $service_node ];

    // Page-specific Service schema
    if ( is_page_template( 'page-service-detail.php' ) ) {
        $graph[] = [
            '@type'    => 'Service',
            '@id'      => get_permalink() . '#service',
            'name'     => get_the_title(),
            'provider' => [ '@id' => trailingslashit( home_url() ) . '#localbusiness' ],
            'areaServed' => 'South West England',
        ];
    }

    $schema = [
        '@context' => 'https://schema.org',
        '@graph'   => $graph,
    ];

    echo '<script type="application/ld+json">' . "\n"
        . json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE )
        . "\n" . '</script>' . "\n";

    echo "<!-- [/SEO Engine] -->\n";
}

// Hook with priority 2 — after title-tag (priority 1) but before other plugins
add_action( 'wp_head', 'gary_wedding_seo_engine', 2 );
