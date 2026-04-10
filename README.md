# Gary Wallage Wedding Pro — Theme Design Guide & Technical Reference

> **Version 2.90.1** | WordPress Multisite | Boutique Editorial Aesthetic

---

## Vision & Intent

This theme is a **premium boutique editorial** for a professional wedding photographer. It is not a generic theme — every design decision is intentional, reflecting the brand values of:

- **Documentary authenticity** — natural, unposed, honest imagery
- **Editorial precision** — magazine-quality layouts, not template layouts
- **Boutique luxury** — gold, crimson, script typography, white space
- **Data-driven trust** — transparent pricing, bundle savings clearly shown

The site must feel like a luxury editorial magazine on first glance. Generic, wide, flat layouts are a **failure state**.

---

## Design System

### Brand Colour Palette

| Token | Value | Usage |
|---|---|---|
| `--brand-bg` | `#F9F9F7` | Page background (warm white) |
| `--brand-text` | `#1a1a1a` | Body text |
| `--brand-accent` | `#B08D55` | Headings, site title, hover |
| `--brand-gold-light` | `#C5A059` | Bullets, borders, prices, ribbons |
| `--brand-crimson` | `#630000` | FREE label, SAVE ribbon, alerts |
| `--brand-white` | `#ffffff` | Card backgrounds, frame fills |

> **Rule**: Never use `--wedding-*` variable names. All variables must use the `--brand-*` prefix.

### Typography

| Role | Font | Notes |
|---|---|---|
| Body / UI | `Lato` (Google Fonts) | Sans-serif, 400 & 700 weights |
| Headings / Branding / Hero | `Blacksword` | Custom cursive script, loaded from `/fonts/` |

- The site title (`.site-title-blacksword`) is **1.6rem** — small enough not to overflow the tagline
- H1 entry titles are gold (`var(--brand-accent)`), uppercase, 3.5rem
- All prices use `£nnn.00` format (2 decimal places, never omit `.00`)

### Layout Rules

- **Editorial width**: `80%` / max `1500px` centred — enforced via `.container` and `.site-main.container`
- **Never** let content blocks stretch full-width unless it is the hero carousel or footer background
- **Row gap** on service grids: `60px` minimum
- Service cards: 3 columns on desktop, 1 on mobile

---

## Architecture: File Map

```
wp-multisite-gary-wedding-pro/
├── style.css                  — Master Design System (single source of truth)
├── functions.php              — Theme setup, customizer, data helpers, enqueue
├── header.php                 — Site header + hamburger nav overlay
├── footer.php                 — 3-column editorial footer
├── front-page.php             — Homepage: auto-slider from menu pages
├── page-about.php             — About Me: tilted portrait frame + bio
├── page-faq.php               — FAQ: JS accordion (h3 triggers)
├── page-services.php          — Service directory grid
├── page-service-detail.php    — Individual service detail + investment plaque
├── page-experience.php        — Experience/portfolio page
├── inc/
│   ├── editorial-patterns.php — Gutenberg block patterns (Z-pattern, USPs, etc.)
│   ├── shortcodes.php         — [gary_featured_services] shortcode
│   ├── seo-engine.php         — SEO meta tags
│   └── blocks/
│       └── service-blocks.php — Custom Gutenberg block renderers
```

---

## Component Specifications

### 1. Hero Slider (Front Page Only)

**Behaviour:**
- Lives exclusively in `front-page.php`
- Auto-builds one slide per **top-level menu item**
- Each slide uses: **Featured image** (background) + **Page title** (H1/H2) + **First H2** from page content (subtitle) + **Page URL** (clickable)
- Pages with no featured image are **skipped**
- Autoplay: 7 seconds, with dot navigation and prev/next arrows
- Height: `42vh` / min `260px` — intentionally narrow so images don't crop

**CSS Classes:** `.hero-carousel-wrapper`, `.hero-carousel`, `.hero-slide`, `.hero-slide-link`, `.hero-title-box`, `.hero-title`, `.hero-subtitle`, `.hero-cta-hint`, `.carousel-nav`, `.carousel-dots`, `.carousel-dot`

**Rule:** Never make this full-screen. The narrower format draws the eye down to content below.

---

### 2. Service Cards

**Structure:** `.service-card-link > .service-card`
- **Gold price box**: `.service-card-price` — gold background, white text, `£nnn.00` format
- **FREE services**: `.service-card-price.is-free` — crimson background, gold text, NO duration shown
- **SAVE ribbon**: `.service-card-ribbon` — diagonal crimson ribbon, appears when bundle savings > 0, NOT shown on FREE services
- **Bullet list**: `.gw-bullet-list` — gold `✵` diamond bullets, left-aligned

**Pricing Rules:**
- All prices: `£` + `number_format($price, 2)` — always 2 decimal places
- Duration: converted from Bookly seconds → `X Hours` (e.g., 36000s = `10.0 Hours`)
- FREE services: hide duration label, hide savings, hide "combined value" row

---

### 3. Investment Plaque (Service Detail)

Right-hand sidebar on `page-service-detail.php`. Shows:
1. Bundle saving (if `savings > 0` AND not FREE)
2. Main price `£nnn.00`
3. Combined individual value (if bundle, not FREE)
4. Duration (if not FREE)
5. Bookly service info text
6. CTA buttons

---

### 4. Z-Pattern Editorial Blocks

**CSS:** `.gw-z-pattern` — alternates image left/right with overlapping text box
- Width constrained: `80%` / max `1500px` — **never edge-to-edge**
- Image: 55% width, white border frame, deep shadow
- Content box: 50% width, overlaps image by 8%, 4-sided gold border `2px solid var(--brand-gold-light)`
- Alternating direction: `.is-right` reverses flex order

---

### 5. About Me Portrait Frame

Only active on pages using the `page-about.php` template (body class: `page-template-page-about`).

- **Tilt**: `rotate(-3deg)` — relaxed, natural feel
- **Frame**: `8px solid var(--brand-gold-light)` with inner padding and white fill
- **Hover**: straightens to `rotate(0deg)`
- **Plaque**: `.frame-plaque` — gold bar reading "Your Photographer", positioned below the frame
- Implemented with `!important` overrides to ensure no Gutenberg styles override the tilt

---

### 6. FAQ Accordion

- Template: `page-faq.php`
- **Content format**: Page content written as H3 headings (questions) followed by paragraphs (answers)
- JS wraps each paragraph after an H3 in `.faq-answer` div
- CSS: answers hidden (`max-height: 0`), expand on `.open` class
- Trigger shows `+` / `−` indicator via `::after` pseudo-element
- **No plugin required** — pure CSS + vanilla JS

---

### 7. Footer

3-column grid, dark (`#1a1a1a`) background:

| Left | Centre | Right |
|---|---|---|
| Legal links (Terms, Privacy, Cookies) | Branding heading + strapline | Contact address, email, phone, WhatsApp |

- Column dividers: `1px solid rgba(255,255,255,0.1)`
- Gold diamond bullets `✧` on all list items
- WhatsApp: green pill button `#25D366` (not a generic link)
- Social icons: gold-bordered circles, below the grid
- Footer width: same editorial `80%` constraint as main content
- Legal/nav links page IDs set via Customizer (`legal_page_privacy`, `legal_page_terms`, `legal_page_cookies`)

---

## Customizer Settings

All settings accessible at **Appearance → Customize**:

| Setting Key | Description |
|---|---|
| `custom_logo` | Site logo (displayed in header centre) |
| `logo_size_px` | Logo width in px (default: 125) |
| `footer_heading` | Footer centre heading (e.g. "Preserving Legacies") |
| `footer_text` | Footer centre strapline text |
| `footer_contact` | Footer address (multi-line, use line breaks) |
| `footer_email` | Footer email address |
| `footer_phone` | Footer phone number (used for tel: and wa.me: links) |
| `footer_copyright` | Copyright string |
| `legal_page_privacy` | Page ID for Privacy Policy |
| `legal_page_terms` | Page ID for Terms & Conditions |
| `legal_page_cookies` | Page ID for Cookie Policy |
| `social_facebook` | Facebook profile URL |
| `social_instagram` | Instagram profile URL |
| `social_youtube` | YouTube channel URL (optional) |
| `social_twitter` | X/Twitter URL (optional) |
| `social_linkedin` | LinkedIn URL (optional) |

---

## Data Architecture: Services & Bookly

Services are WordPress pages using custom post meta. Meta keys:

| Meta Key | Description |
|---|---|
| `_gary_bookly_id` | Bookly service ID (integer) |
| `_gary_service_price` | Manual price override (if no Bookly) |
| `_gary_service_duration` | Manual duration string (if no Bookly) |
| `_gary_service_subtitle` | Short subtitle for investment plaque |
| `_gary_service_highlights` | Newline-separated bullet points |
| `_gary_service_bg_img` | Background image URL |
| `_gary_sub_service_1` … `_gary_sub_service_8` | Bookly IDs of included sub-services (for bundles) |

**Bundle Logic** (`gary_get_sub_service_summary` in `functions.php`):
- Loops sub-services 1–8, fetches Bookly price for each
- Sums individual prices → `total_value`
- `savings = total_value − parent_price` (0 if no saving)
- Savings are shown on the card ribbon and investment plaque **only if > 0 and not FREE**

---

## CSS Variable Rules

> All custom properties **must** use `--brand-` prefix. The old `--wedding-` prefix is deprecated and must never be reintroduced.

```css
/* ✅ Correct */
color: var(--brand-accent);
border-color: var(--brand-gold-light);

/* ❌ Never */
color: var(--wedding-accent);
```

---

## Version & Cache Busting

The theme version string appears in three places. **Always update all three together**:

1. `style.css` — comment header (`* Version: X.X.X`)
2. `functions.php` — `gary_send_performance_headers()` preload header
3. `functions.php` — `gary_wedding_scripts()` enqueue call

Current version: **2.90.1**

---

## Content Guidelines for Menu Pages

For the front-page slider to work correctly, each top-level menu page must have:

1. **A Featured Image set** in the WordPress editor (right sidebar → Featured Image)
2. **A clear H2 heading** early in the content — this becomes the slide subtitle
3. The page must be linked directly in the **Primary Menu** (not as a child/sub-menu item)

Pages without a featured image are silently skipped in the slider.

---

## Anti-Patterns (Never Do These)

| Anti-Pattern | Correct Approach |
|---|---|
| Full-width content blocks | Use `80%` container constraint |
| `width: 100%` on Z-patterns | Use `.gw-z-pattern` with `var(--editorial-width)` |
| Price shown as `£595` | Always `£595.00` (`number_format($price, 2)`) |
| Duration shown in seconds (`36000`) | Convert: `round($seconds / 3600, 1) . ' Hours'` |
| FREE service showing savings/duration | Enforce `$is_free` check to hide those fields |
| `--wedding-` variables | Migrate to `--brand-` |
| Making the hero slider taller | Keep at `42vh` — narrower prevents photo cropping |
| Inline styles for repeated patterns | Define in `style.css` with proper class selectors |
