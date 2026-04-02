<?php
/**
 * SEO Engine for Gary Wallage Wedding Pro
 * Handles dynamic meta tags, Open Graph, and JSON-LD Schema (2026 Ready).
 */

function gary_wedding_seo_engine() {
    $title = get_bloginfo( 'name' );
    $description = get_bloginfo( 'description' );
    $url = get_permalink();
    $image = get_the_post_thumbnail_url( get_the_ID(), 'large' ) ?: get_site_icon_url();
    $business_name = "Gary Wallage Wedding Photography";
    $location = "South West England; Wiltshire; Somerset; Berkshire";
    $address = "63 Twineham Road, Swindon, SN25 2AG";
    $phone = "07970 262 387";
    $social_insta = "https://www.instagram.com/garywallage.wedding/";
    $social_fb = "https://www.facebook.com/garywallage.wedding/";

    if ( is_front_page() || is_home() ) {
        $title = "Editorial Wedding Photographer in $location | Gary Wallage";
        $description = "Award-winning editorial wedding photography covering $location. Preserving legacies with precision gallery frames and documentary storytelling.";
    } elseif ( is_page() || is_single() ) {
        $title = get_the_title() . " | " . get_bloginfo( 'name' ) . " - " . $location;
        $description = get_the_excerpt() ?: wp_trim_words( get_the_content(), 25 );
    }

    // --- Meta Tags ---
    echo "\n<!-- [SEO Engine: Gary Wallage Wedding Pro] -->\n";
    echo '<meta name="description" content="' . esc_attr( $description ) . '">' . "\n";
    echo '<link rel="canonical" href="' . esc_url( $url ) . '">' . "\n";

    // --- Open Graph ---
    echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '">' . "\n";
    echo '<meta property="og:type" content="' . ( is_single() ? 'article' : 'website' ) . '">' . "\n";
    echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr( $description ) . '">' . "\n";
    echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
    echo '<meta property="og:image" content="' . esc_url( $image ) . '">' . "\n";

    // --- Twitter Card ---
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr( $title ) . '">' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr( $description ) . '">' . "\n";
    echo '<meta name="twitter:image" content="' . esc_url( $image ) . '">' . "\n";

    // --- JSON-LD Schema ---
    $schema = [
        "@context" => "https://schema.org",
        "@graph" => [
            // Local Business
            [
                "@type" => "LocalBusiness",
                "@id" => trailingslashit( home_url() ) . "#localbusiness",
                "name" => $business_name,
                "url" => home_url(),
                "telephone" => $phone,
                "address" => [
                    "@type" => "PostalAddress",
                    "streetAddress" => "63 Twineham Road",
                    "addressLocality" => "Swindon",
                    "postalCode" => "SN25 2AG",
                    "addressCountry" => "GB"
                ],
                "areaServed" => [
                    "Wiltshire", "Somerset", "Berkshire", "South West England"
                ],
                "image" => $image,
                "priceRange" => "$$$",
                "sameAs" => [
                    $social_insta,
                    $social_fb
                ]
            ],
            // Professional Service Specific
            [
                "@type" => "WeddingService",
                "name" => $business_name,
                "description" => $description,
                "serviceType" => "Wedding Photography",
                "areaServed" => "South West England"
            ]
        ]
    ];

    // Page-specific Schema additions
    if ( is_page_template( 'page-service-detail.php' ) ) {
        // Individual Service Schema
        $service_data = [
            "@type" => "Service",
            "name" => get_the_title(),
            "provider" => [ "@id" => trailingslashit( home_url() ) . "#localbusiness" ],
            "areaServed" => "South West England"
        ];
        $schema['@graph'][] = $service_data;
    }

    echo '<script type="application/ld+json">' . json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>' . "\n";
    echo "<!-- [/SEO Engine] -->\n";
}

// Hook into wp_head with high priority (but after title-tag)
add_action( 'wp_head', 'gary_wedding_seo_engine', 1 );
