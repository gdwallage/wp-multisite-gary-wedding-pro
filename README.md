# Gary Wallage Wedding Pro — Theme Documentation

> **WordPress Theme** · Multisite Compatible · Bookly Integration · Custom SEO Engine  
> Version 1.150+ · Author: Gary Wallage · Site: `wedding.garywallage.uk`

---

## Table of Contents

1. [Overview](#overview)
2. [Design System — Colours & Typography](#design-system)
3. [File Structure](#file-structure)
4. [Page Templates — How to Use Each One](#page-templates)
5. [The Hero Carousel — Front Page](#hero-carousel)
6. [The Services System — Bookly Integration](#services-system)
7. [Editorial Block Patterns](#editorial-block-patterns)
8. [WordPress Customizer Settings](#wordpress-customizer)
9. [SEO Engine](#seo-engine)
10. [The Footer & Social Links](#footer--social-links)
11. [Admin Meta Boxes — Quick Reference](#admin-meta-boxes)
12. [Fonts](#fonts)
13. [Known Requirements & Dependencies](#requirements)

---

## Overview

**Gary Wallage Wedding Pro** is a bespoke, precision-built WordPress theme for a wedding photography business. It is designed around an *editorial magazine* aesthetic — high contrast, typographically rich, and visually cinematic — while being fully data-driven through the **Bookly** appointment plugin.

The theme is opinionated by design: it has no page builder dependency (Elementor, Divi, etc.) and instead uses native WordPress block patterns, PHP page templates, and a custom SEO engine. All of its visual language derives from the Brand DNA colour tokens defined in `style.css`.

---

## Design System

### Colour Palette

All colours are defined as CSS custom properties in `:root` in `style.css`.

| Token | Hex | Usage |
|---|---|---|
| `--wedding-bg` | `#F9F9F7` | Global page background (warm off-white) |
| `--wedding-text` | `#1a1a1a` | Primary body text (near-black) |
| `--wedding-accent` | `#B08D55` | Primary gold — headings, borders, buttons |
| `--wedding-gold-light` | `#C5A059` | Lighter gold — hover states, price labels, separators |
| `--wedding-crimson` | `#630000` | Deep crimson — FREE badge, "is-free" service price chips |

The site footer uses a **hard dark background** (`#1a1a1a`) with white text and gold accents, creating a cinematic contrast to the warm off-white body.

### Typography

Two typefaces are used across the entire site:

| Typeface | Source | Usage |
|---|---|---|
| **Blacksword** | Local (`/fonts/Blacksword.woff2`) | Script display font — site title, page headings (H1/H2), service names, footer branding |
| **Lato** | Google Fonts (loaded in `header.php`) | All body text, navigation, labels, meta, buttons |

**Heading Scale (desktop):**

| Element | Size | Font |
|---|---|---|
| Site title | `3.2rem` | Blacksword |
| H1 / H2 in content | `2.5rem` / `2.2rem` | Blacksword |
| H3 / H4 | `1.4rem` / `1.2rem` | Lato (400 weight) |
| Body copy | `1.15rem` | Lato |
| Navigation | `0.85rem` uppercase, 2px spacing | Lato Bold |
| Footer labels | `0.7rem` uppercase, 3px spacing | Lato |

All mobile font sizes are capped to readable minimums in the `@media (max-width: 768px)` block — body is explicitly set to `16px` for Google mobile friendliness checks.

### Border & Frame System

The theme uses a consistent **8px solid gold border** as its primary decorative frame motif — visible on service cards, the portrait frame on the About page, and the investment plaque on service detail pages. This is the visual "gallery frame" concept that runs throughout the design.

---

## File Structure

```
wp-multisite-gary-wedding-pro/
│
├── style.css                    # All CSS — design tokens, layout, responsive
├── functions.php                # Theme setup, enqueues, Customizer, meta boxes, Bookly helpers
│
├── header.php                   # Global header — navigation, site title, favicon
├── footer.php                   # Global footer — branding columns, social links, copyright
├── index.php                    # Fallback template (blog / generic)
│
├── front-page.php               # Home page — hero carousel + intro content
├── page-about.php               # Template: "About Me" — portrait frame + bio
├── page-faq.php                 # Template: "FAQ" — accordion-style questions
├── page-experience.php          # Template: "Experience" — general content page
├── page-services.php            # Template: "Services" — Bookly-driven card grid
├── page-service-detail.php      # Template: "Service Detail" — editorial investment layout
│
├── category.php                 # Category archive template
├── tag.php                      # Tag archive template
├── single-visual_legacies.php   # Single post template for "Visual Legacies" CPT
│
├── inc/
│   ├── seo-engine.php           # Custom SEO — meta tags, Open Graph, structured data, hreflang
│   └── editorial-patterns.php   # 10 registered native WordPress block patterns
│
└── fonts/
    └── Blacksword.woff2 / .ttf  # Local script font (no external dependency)
```

---

## Page Templates

Each template is assigned in the WordPress page editor via **Page Attributes → Template**. Here is what each one does and how to configure it.

---

### `Front Page` — `front-page.php`

WordPress automatically uses this for your static front page (set in **Settings → Reading → Your homepage displays → A static page**).

**What it does:**
- Renders a **hero carousel** with up to 6 slides (1 from the featured image + 5 from Customizer)
- Below the carousel, outputs the **page's WordPress content** (editor body) as the intro section
- The intro content is where you add your About blurb, area coverage, style description, etc.

**How to configure:**
- Set this page as the static front page in Settings → Reading
- Upload a **featured image** — this becomes Slide 0 (the primary H1 slide)
- Add content in the WordPress editor below the title — this appears as the intro section
- Configure Slides 1–5 in **Appearance → Customise → Hero Carousel Slides**
- Write approximately 800 words of body content for best SEO performance

---

### `About Me` — `page-about.php`

**What it does:**
- Two-column layout: **portrait on left** (30% width), **bio text on right**
- Portrait is displayed in a gold-bordered frame (`8px solid --wedding-gold-light`) with a slight `rotate(-3deg)` tilt
- Frame includes a gold "Your Photographer" plaque at the bottom
- Bio content comes from the WordPress editor — uses all standard heading/paragraph typesetting
- Finishes with a Blacksword script sign-off: *Gary Wallage*

**How to configure:**
1. Create a new page, set Template → **About Me**
2. Upload a **featured image** (portrait photo) — this appears in the left frame
3. Write your bio in the editor — use H3 for section breaks, paragraphs for copy
4. The frame tilt and gold border are automatic

---

### `FAQ` — `page-faq.php`

**What it does:**
- Accordion-style FAQ — each question collapses/expands on click
- Gold `+` / `—` toggle icons, animated open/close
- Content comes entirely from the WordPress editor

**How to format content in the editor:**
- Use `<h3>` blocks for **questions** — these become the clickable triggers
- Use `<p>` blocks **immediately after** each H3 for the **answer** — these collapse/expand

The FAQ JS script auto-converts any H3 followed by a P block into a trigger/answer pair.

---

### `Services` — `page-services.php`

**What it does:**
- Reads all services from the **Bookly database** (`wp_bookly_services` table)
- Renders a responsive grid of service cards — each card shows: title, image, price, duration, info text
- Each card links to its corresponding **Service Detail** page (matched by Bookly service ID)

**The card–page link:**
Each WP page using the `Service Detail` template stores a **Bookly service ID** in its meta (`_gary_bookly_id`). The services page finds the matching WP page to link to by querying `_gary_bookly_id`.

**How to configure a new service:**
1. Create the service in **Bookly → Services** — set title, price, duration, info text, category image
2. Create a new WordPress page
3. Set its template to **Service Detail**
4. In the right sidebar meta box "**Bookly Service Link**", select the matching Bookly service
5. Write the editorial content for the page in the WordPress editor
6. The card grid on the Services page will automatically include it

**Price display rules:**
- Price > 0 → shows `From £XXX`
- Price = 0 → shows `FREE` (crimson badge)
- No Bookly data → shows `On Request`

---

### `Service Detail` — `page-service-detail.php`

This is the most complex template. It creates a full **editorial investment layout** for a single photography service.

**Layout structure:**
```
[Page Title / H1]
[Subtitle caption]

[Left column: Editor body content + Experience Highlights list]
[Right column: Investment Plaque — price, duration, Bookly info, CTA buttons]

[Sub-Service Components Grid — 2×N card grid]

[Back to Services link]
```

**Meta box fields (Editorial Layout Data sidebar):**

| Field | What it does |
|---|---|
| **Investment Subtitle** | Small caption under the "Estimated" heading in the plaque (e.g. "Bespoke Guidance") |
| **Personalized Experience Highlights** | One bullet point per line — rendered with animated gold SVG tick icons |
| **Link Bookly Sub-Services (Slots 1–8)** | Select up to 8 Bookly services to show in the component grid below the main content |
| **Background Illustration URL** | Optional very faint PNG/SVG that sits as a fixed background layer (opacity 0.04) |

**The Sub-Service Component Grid:**

Each slot holds a **Bookly service ID**. The template resolves this to the WP page that has `_gary_bookly_id` matching it, then renders:
- The page's featured image (circular "coin" frame)
- The page title
- Price badge: struck-through price + "INCLUDED" (paid), or "FREE — INCLUDED" (free services)
- Description: Bookly service `info` field → WP excerpt → trimmed content (in priority order)
- Click links to the sub-service's own detail page

**Sub-service auto-population via Bookly tags:**
If the parent Bookly service has **tags** set in Bookly, the template *additionally* auto-includes any WP pages whose titles match those tag names. These are added *after* your manual slot selections, not instead of them.

**Investment Plaque CTA buttons:**
- "Request Details" → `#request` anchor (you can add a contact form below with this ID)
- "Book Consultation" → `/booking/` (your Bookly booking page)

---

### `Experience` — `page-experience.php`

A general full-width content page with no special behaviour. Use this for any editorial long-form pages (e.g. a "What to expect" narrative page). Content comes entirely from the editor.

---

## Hero Carousel

The front page carousel supports **6 slides total**:

| Slide | Source | Title tag |
|---|---|---|
| Slide 0 (first) | Page **Featured Image** | `<h1>` (SEO primary heading) |
| Slides 1–5 | **Customiser → Hero Carousel Slides** | `<h2>` |

**Customiser fields per slide (1–5):**
- Image URL (paste from Media Library)
- Title text
- Subtitle text
- Title box background colour (hex picker)
- Title box opacity (0.0–1.0)

**Timing:** Auto-advances every 7 seconds. Prev/Next arrow buttons show when there are 2+ slides.

**Mobile behaviour:** On screens ≤768px, all slides become full-width, "ghost" prev/next slides are hidden, and carousel arrow buttons shrink to 44×44px tap targets.

---

## Services System — Bookly Integration

The theme has two helper functions in `functions.php`:

### `gary_get_bookly_service_data( $bookly_id )`

Queries the `wp_bookly_services` table and returns an array:

```php
array(
    'title'    => 'Wedding Day Photography',
    'price'    => 1200.00,
    'duration' => '480 min',
    'info'     => '<p>Full day coverage...</p>',
    'tags'     => 'ceremony,portraits,reception',
    'image'    => 'https://example.com/image.jpg',
)
```

Returns `false` if Bookly is not installed or the service ID doesn't exist.

### `gary_find_page_by_bookly_title( $title )`

Finds a WP page whose title exactly matches `$title`. Used for Bookly tag auto-resolution.

### Bookly Service Link Meta Box

Every page can have a Bookly service ID attached via the **"Bookly Service Link"** sidebar meta box (appears on all pages). This is how the services grid and sub-service resolver know which Bookly service a WP page represents.

---

## Editorial Block Patterns

The theme registers **10 native WordPress block patterns** under the "Gary Wallage Editorial" category. Access them in the WordPress editor via the **Block Inserter (+ button) → Patterns → Gary Wallage Editorial**.

| Pattern | Name | Use |
|---|---|---|
| `gw/z-pattern-left` | Z-Pattern (Image Left) | Image left, overlapping text box right |
| `gw/z-pattern-right` | Z-Pattern (Image Right) | Text box left, image right |
| `gw/trio-gallery` | The Gallery Wall Trio | Hero landscape image left + 2 portrait images stacked right |
| `gw/cinematic-bleed` | Cinematic Hero Bleed | Full-width cover block with centred heading |
| `gw/editorial-split` | Editorial Split (50/50) | Media-text block — image one side, copy the other |
| `gw/storyteller-grid` | The Storyteller Grid | 2×2 gallery grid with tight 5px gaps |
| `gw/cta-plaque` | Call-to-Action Plaque | Gold-bordered CTA box with heading, copy, and button |
| `gw/testimonial-bg` | Testimonial Transparency | Cover block with 80% dim, blockquote overlay |
| `gw/polaroid` | Fine-Art Polaroid | White-bordered polaroid frame for a single image |
| `gw/chapter-break` | The Chapter Break | Gold separator + small uppercase heading as a section divider |

**How to use:** In the WordPress post/page editor, click **+** → **Patterns** tab → scroll to "Gary Wallage Editorial" → click any pattern to insert it. Then click images to replace them from your Media Library.

---

## WordPress Customizer

Access via **Appearance → Customise**. The theme registers the following sections:

### Hero Carousel Slides (Section: `gary_hero_slides`)

For each of **Slides 1–5**:
- `hero_slide_N_img` — Image URL
- `hero_slide_N_title` — Slide title
- `hero_slide_N_subtitle` — Slide subtitle
- `hero_slide_N_box_color` — Title box background colour
- `hero_slide_N_box_opacity` — Title box opacity

Slide 0 also has: `hero_slide_0_box_color`, `hero_slide_0_box_opacity`, `hero_slide_0_text_color`.

### Colours (Section: `gary_colours`)

- `primary_accent_color` — Overrides `--wedding-accent` globally

### Footer Content (Section: `gary_footer_options`)

- `footer_heading` — Branding script heading in the footer
- `footer_text` — Description paragraph under the heading
- `footer_copyright` — Copyright line text

### Social Media Links (Section: `gary_social_options`)

| Setting | Platform |
|---|---|
| `social_facebook` | Facebook profile URL |
| `social_instagram` | Instagram profile URL |
| `social_youtube` | YouTube channel URL |
| `social_twitter` | X / Twitter profile URL |
| `social_linkedin` | LinkedIn profile URL |

These URLs appear as **gold circle icon buttons** in the footer and are also embedded in the structured data `sameAs` array for SEO.

---

## SEO Engine

The theme includes a custom SEO engine (`inc/seo-engine.php`) that replaces the need for a generic SEO plugin. It outputs into `wp_head` at priority 2.

**What it outputs:**

| Tag | Details |
|---|---|
| `<title>` | Custom title via `pre_get_document_title` filter — front page: "Gary Wallage \| Wedding Photographer Swindon & Wiltshire" (55 chars) |
| `<meta name="description">` | Front page: 126-char description. Inner pages: auto-generated from excerpt or content |
| `<link rel="canonical">` | Single canonical — WP core `rel_canonical` hook is suppressed to prevent duplicates |
| `<link rel="alternate" hreflang>` | `en-GB` and `x-default` self-referencing tags |
| `<meta property="og:*">` | Open Graph — title, description, URL, image, type, site name |
| `<meta name="twitter:*">` | Twitter/X card — `summary_large_image` type |
| `<script type="application/ld+json">` | Structured data: `LocalBusiness → ProfessionalService` with `Service` child node, `sameAs` social links, `logo`, `image`, `priceRange: £££` |

**Favicon:**
- If a **Site Icon** is set in WordPress (Appearance → Customise → Site Identity → Site Icon), that icon is used automatically
- If no site icon is set, a **gold SVG camera aperture** fallback is output as an inline data URI

**Suppressed WP head noise:**
- `rsd_link` (Really Simple Discovery)
- `wlwmanifest_link` (Windows Live Writer)
- `rel_canonical` (duplicate prevention)

---

## Footer & Social Links

The footer renders in three columns on desktop (stacking to one column on tablet/mobile):

| Column | Content |
|---|---|
| Left | Blacksword brand heading + description text (from Customiser) |
| Centre | Legal navigation menu (register "Footer Legal" menu in Appearance → Menus) |
| Right | Phone number, email address, location (from Customiser fields) |

Below the columns, a "**Follow the Story**" social links bar renders gold circle icon buttons for any configured social platforms. Only platforms with a URL set are shown.

The copyright line reads: `© [year] [footer_copyright setting]`.

---

## Admin Meta Boxes

### "Bookly Service Link" (all pages)

| Field | Meta key | Notes |
|---|---|---|
| Bookly Service | `_gary_bookly_id` | Select from Bookly services dropdown; stores Bookly service ID |
| Manual Price | `_gary_service_price` | Fallback if Bookly not available |
| Manual Duration | `_gary_service_duration` | Fallback duration string |

### "Editorial Layout Data" (all pages — used mainly on Service Detail pages)

| Field | Meta key | Notes |
|---|---|---|
| Investment Subtitle | `_gary_service_subtitle` | Caption in the investment plaque |
| Highlights | `_gary_service_highlights` | One item per line; auto-receives gold tick icons |
| Sub-Service Slots 1–8 | `_gary_sub_service_1` … `_gary_sub_service_8` | Each stores a Bookly service ID; resolves to the linked WP page |
| Background Illustration | `_gary_service_bg_img` | URL of a faint fixed-position background image |

---

## Fonts

| File | Format | Usage |
|---|---|---|
| `fonts/Blacksword.woff2` | WOFF2 | Primary (preferred, smaller) |
| `fonts/Blacksword.ttf` | TrueType | Fallback |

The font uses `font-display: swap` to prevent invisible text during load. It is loaded via `@font-face` in `style.css` — **no external request** is made for this font.

Lato is loaded from Google Fonts via a `<link>` in `header.php` (weights 300, 400, 700).

---

## Requirements

| Requirement | Notes |
|---|---|
| WordPress | 6.0+ recommended |
| PHP | 7.4+ (8.0+ preferred) |
| **Bookly** plugin | Required for service grid and service detail data. Free tier works; `wp_bookly_services` table must exist. |
| Google Fonts (Lato) | Loaded from CDN — internet connection required during page load |
| WP Multisite | Compatible — theme is tested on a multisite subsite |

### Optional but Recommended

| Plugin | Purpose |
|---|---|
| WP Super Cache / LiteSpeed Cache | Improves INP performance (Interaction to Next Paint) |
| Wordfence | Security hardening |
| WP Mail SMTP | Reliable form/booking email delivery |

---

## Quick Start Checklist

When setting up this theme on a fresh site:

- [ ] Activate theme in **Appearance → Themes**
- [ ] Install and activate **Bookly** plugin
- [ ] Create a **static page** for the front page and set it in **Settings → Reading**
- [ ] Set template to **Front Page** on that page
- [ ] Upload a portrait + featured image for the About page
- [ ] Create pages and assign templates: About Me, FAQ, Services, Experience
- [ ] Create Bookly services in **Bookly → Services** (set title, price, duration, info, image)
- [ ] Create WP pages for each service using template **Service Detail**; link each to its Bookly service via the sidebar meta box
- [ ] Configure **Appearance → Customise → Hero Carousel Slides** with your images
- [ ] Configure **Appearance → Customise → Social Media Links** with your profile URLs
- [ ] Upload a **Site Icon** (512×512 PNG) in **Appearance → Customise → Site Identity**
- [ ] Register the **"Footer Legal"** nav menu in **Appearance → Menus** and link it
- [ ] Submit your sitemap to Google Search Console

---

*Theme built and maintained by Gary Wallage · `wedding.garywallage.uk`*
