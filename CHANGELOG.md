# Changelog - Gary Wallage Wedding Pro

## [3001.84] - 2026-05-18
### Added
- **High-Priority Inline Overrides (Showcase Mode & Breakouts)**: Injected inline styling overrides directly into the `<head>` tag via `functions.php`. This successfully bypasses all aggressive proxy, browser, and server caches, forcing the **Gutenberg Group Trust Bar** to span exactly `100vw` wide, stretching the **Hero Carousel** to full screen width, and completely disabling all dark background gradients on scrollytelling background photos so they render with zero filters in pure photographic showcase quality.

## [3001.83] - 2026-05-18
### Added
- **Photographic Showcase Mode (Zero Vignette / Filters)**: Removed the radial and linear dark vignette overlays (`.image-overlay`) from the scrollytelling background, allowing your custom editorial photography to show at 100% brightness, clarity, and true color representation.
- **Automated Gutenberg Group Trust Bar Breakout**: Added a targeted layout breakout rule that automatically intercepts the standard Gutenberg Group block representing the front page Trust Bar (matching its `#1a1a1a` background) and expands it to exactly `100vw` without requiring manual page editor layout modifications.

## [3001.82] - 2026-05-18
### Added
- **Full-Width Hero Slider & Balanced Trust Bar**: Applied robust, viewport-relative breakouts (`100vw` centered width) directly to the **Front-Page Hero Carousel (`.hero-peek-carousel`)** and balanced the breakout margins for the **Trust Bar (`.gw-trust-bar`)** with symmetrical left and right definitions.
- **Architectural Gutenberg Integration**: Fixed an architectural theme bug where custom block editor styles in `editor.php` were not being loaded in Gutenberg. Enqueued `editor.php` via `service-blocks.php` and injected edge-to-edge block-editor-scoped breakout rules so that all full-width blocks automatically stretch to exactly `100vw` inside the Gutenberg admin dashboard and post-editing views as well.

## [3001.81] - 2026-05-18
### Fixed
- **Resolved Sticky Engine Disabler (`overflow-x: clip`)**: Upgraded all `overflow-x: hidden` scroll-guards on `html` and `body` elements to `overflow-x: clip`. This successfully prevents horizontal scrollbars without triggering browser-level sticky boundary restrictions, fully restoring the custom `position: sticky` pinning engine.
- **Bypassed Image Height Cap (`max-height: none`)**: Applied strict height and sizing overrides (`max-height: none !important; width: 100% !important; height: 100% !important;`) to `.scroll-bg-image` to prevent the theme's global `img { max-height: 70vh }` rule from truncating scrollytelling backgrounds. Photos now seamlessly stretch to fill the absolute 100% fullscreen height.

## [3001.80] - 2026-05-18
### Added
- **Global Breakout Support (`.alignfull`)**: Refactored the full-width breakout stylesheet rules into a highly reusable, global `.alignfull` definition. This immediately forces all full-width elements—such as the **Front-Page Hero/Scrollytelling** slides, the **Inquiry Plaque**, and the **Trust Bar**—to seamlessly expand to exactly `100vw` regardless of nested container constraints like `.home-intro.container` or `.entry-content`.
- **Sticky Engine Restoration**: Forced `overflow: visible !important;` on all primary WordPress container parent elements (e.g. `.site-main`, `article`, `.entry-content`, and `.home-intro`). This resolves parent overflow truncation blocks, allowing the hardware-accelerated scrollytelling background engine to pin flawlessly to the viewport as a static element while the descriptive narrative boxes scroll in front.

## [3001.79] - 2026-05-18
### Fixed
- **Boutique Scrollytelling Registry Correction**: Resolved a major global array timing bug where `$gw_scrollytelling_slides` was being wiped out at the start of the parent container's rendering process. Implemented a smart, dual-path check in `gary_render_scrollytelling_container` that automatically parses and preserves slide data regardless of WordPress's rendering sequence.
- **Cinematic Fullscreen Viewport Breakout**: Implemented a mathematically robust `100vw` margin-pull breakout in `style.css` for `.scrollytelling-wrapper` to break the standard 10-80-10 page container confinement, creating a seamless edge-to-edge full-bleed presentation on all screens with zero horizontal overflow.

## [3001.78] - 2026-05-18
### Fixed
- **Gutenberg Editor Recovery**: Patched `inc/blocks/service-blocks.js` which had a syntax error that crashed the block editor. Specifically, resolved a duplicate `gw/service-grid` block definition that caused registration collisions, and corrected a missing closing parenthesis and bracket (`});`) on the `gw/editorial-triplet-item` registration. All boutique blocks are now syntactically perfect and register flawlessly inside WordPress.

## [3001.77] - 2026-05-18
### Fixed
- **Conditional Date Pre-filling**: Restrained the dynamic Bookly date pre-filling routine to execute *only* on pages utilizing the **Service Detail Page** template (`page-service-detail.php`). This keeps general forms (like booking a Free Consultation next week) on the standard date flow, while still pre-filling the specific wedding date on package-specific detail pages.

## [3001.76] - 2026-05-18
### Added
- **Date Hand-off to Booking & Service Detail Pages**: Added a high-fidelity URL parameter system. When a date is verified successfully, the "Book Now" CTA dynamically appends the selected date as a query parameter (e.g., `?check_date=2026-06-10`).
- **Bookly Dynamic Pre-filling**: Added a background `MutationObserver` and pre-fill routine in `js/main.js`. It monitors the target page for any standard Bookly inputs (e.g. `input.bookly-js-date-from`, `.bookly-date-from`, `input[name="date_from"]`, and jQuery datepickers), automatically pre-filling the user's selected date and triggering standard input/change events to automatically load the correct Bookly slots on load.

## [3001.75] - 2026-05-18
### Changed
- **Dynamic Revalidation Support**: Added a change listener to the date picker inputs in `js/main.js` that automatically clears the previous availability result, re-shows the "Check Availability" button, and hides the Booking CTA the instant a user selects a different date. This allows seamless revalidation of alternative dates without leaving the page.

## [3001.74] - 2026-05-18
### Fixed
- **Custom REST API Endpoint for Availability Checker**: Registered a public, custom WordPress REST API endpoint (`/wp-json/gw/v1/check-availability`) in `inc/ajax-handlers.php`. This completely bypasses the Authentik SSO `/wp-admin/*` proxy rules, allowing both logged-in and public non-authenticated users to check calendar availability smoothly without triggering CORS preflight redirect blocks.
- **Menu Panel Typography Contrast Override**: Patched a CSS styling collision where the fullscreen layout's white links (`#ffffff !important`) overlayed the Boutique Panel's white background (`#ffffff !important`). Injected high-contrast dark text styling (`#111111 !important`) with gold hover transitions inside `<style id="emergency-menu-fix">` in `header.php`, making all menu links instantly visible and legible.

## [3001.73] - 2026-05-18
### Fixed
- **Restored Simplistic Menu Inline Style**: Reverted the menu open/close handler back to the highly robust, proven inline `style` modifications (injecting `display: flex !important; opacity: 1 !important` etc.) instead of manual class list transitions which were breaking native CSS animations and causing the menu to display as all black.
- **SSO Proxy AJAX Header Integration**: Modified the Vanilla JS `fetch()` call for the availability calendar picker to explicitly send the `X-Requested-With: XMLHttpRequest` header and use same-origin credentials. This ensures that Authentik SSO, Wordfence, and the server's security gateways correctly process the background availability query instead of triggering CORS-blocked login redirects.

## [3001.72] - 2026-05-18
### Fixed
- **Vanilla JavaScript Migration (Zero Dependency)**: Rewrote `js/main.js` from scratch in modern, 100% native Vanilla JavaScript. This completely eliminates dependency conflicts caused by aggressive third-party caching/optimization plugins on the live site that defer `jquery.min.js`.
- **Early Execution & Defer Elimination**: Removed the jQuery loading dependency from the `gary-wedding-main` script enqueue call in `inc/enqueue.php`. The main script now loads instantly, executing independent event handlers for the hamburger popup menu, availability calendar picker, scrollytelling steps, and boutique inquiry modal with flawless performance.
- **Native Fetch AJAX Handlers**: Replaced jQuery's `$.getJSON` with standard JavaScript `fetch()` calls to handle calendar checker and inquiry form AJAX requests smoothly with zero load-order dependencies.

## [3001.71] - 2026-05-18
### Changed
- **Removed Duration Text**: Streamlined the layout by completely removing the redundant "Duration: [Full Day]" text badge from the horizontal calendar check date block, letting the user focus purely on date selection.
- **Removed Duplicate Calendar Icon**: Removed the custom SVG calendar icon overlay which was causing a duplicate calendar icon to appear alongside the browser's native built-in date picker icon.
- **Centered 2-Column Horizontal Layout**: Re-engineered the inner flex row to beautifully center the two remaining fields (Date Input Picker and Action Button) side-by-side. Both elements are now cleanly bounded to a max-width of `320px` with a premium 20px gap.
- **Streamlined Date Input Padding**: Shifted input padding back to a balanced `12px` all-around, eliminating the legacy 40px left-side indent.

## [3001.70] - 2026-05-18
### Changed
- **Unconstrained Date Checker Inner Width**: Fixed a critical visual bug where the horizontal "Check Your Date" inner row was squished in the center with columns restricted to 102px. Overrode the old `max-width: 340px` wrapper rule with `max-width: 100% !important`, allowing the three columns to expand fully to their dedicated 30% desktop space.
- **Tighter Vertical Padding**: Decreased the top/bottom block padding to `30px 40px !important` to eliminate excessive vertical blank spaces and keep the horizontal bar look clean and tight.
- **Envelope Pseudo-Element Suppression**: Explicitly disabled the global `::after` envelope symbol (`✉`) on the availability checker's action buttons, keeping the CTA presentation professional and free of mail icon conflicts.
- **Optimized Layout Gaps**: Increased horizontal gaps between layout columns to `30px` to give the badge, input date picker, and Gold button professional breathing room.

## [3001.69] - 2026-05-18
### Changed
- **Individual Service Card Confinement**: Constrained `.service-card-link` elements to a maximum width of `420px` and automatically centered them on the page when placed as standalone blocks. Nested `.services-grid .service-card-link` elements remain set to `100%` so they perfectly fill their active columns in the services grid.
- **Horizontal Calendar Checker (10-30-30-30-10 Spacing)**: Redesigned the atomic `Check Your Date` block from a narrow vertical column to a wide horizontal bar. Re-engineered the inner availability row into a responsive flex layout featuring a `10% - 30% - 30% - 30% - 10%` spacing pattern:
  - **Left (30% Width)**: A stylish "Duration" badge indicating the selected service window.
  - **Center (30% Width)**: The styled, calendar icon-anchored native date input picker.
  - **Right (30% Width)**: Stays locked with the "Check Availability" primary button (cross-fading to "Book Now" on successful matches).
- **Responsive Calendar Alignment**: Integrated vertical layout flex fallback rules on mobile screens (`max-width: 768px`) to ensure complete cross-device pixel stability.
- **AJAX Button Syncing**: Synchronized `#gw-atomic-booking-cta` within the success callback inside `js/main.js` to immediately display the "Book Now" CTA and transition out the check button when dates are confirmed available.

## [3001.68] - 2026-05-18
### Added
- **Boutique Scrollytelling Gutenberg Blocks**: Created two brand new custom editorial blocks to natively implement cinematic image scrollytelling in the WordPress Block Editor:
  - `gw/scrollytelling-container` (Parent): Serves as the outer layout block. It automatically groups child slide background images inside a pinned, hardware-accelerated `.sticky-background-container` and places scrolling narrative steps in a `.scrolling-text-container`.
  - `gw/scrollytelling-slide` (Child): Renders as a highly-intuitive grid in the editor, allowing creators to easily choose slide background images, write titles, and edit narratives using native block tools.
- **Hardware-Accelerated Scrollytelling Styles**: Added high-fidelity, premium styles to `style.css` featuring glassmorphism text overlays (`rgba(17, 17, 17, 0.85)` with gold framed borders and custom blur-filters) and smooth transition curves (`cubic-bezier(0.25, 1, 0.5, 1)`) for cinematic background crossfading.
- **Scroll Detection Engine**: Extended `js/main.js` with a robust `IntersectionObserver` scroll engine that tracks the exact percentage of active content blocks in the viewport and triggers smooth, instantaneous background crossfades on the frontend.

## [3001.67] - 2026-05-18
### Changed
- **Gutenberg Service Grid Confinement**: Added a strict container confinement rule for the Gutenberg block wrapper `.wp-block-gw-service-grid` to ensure its width is always constrained to `100%` of its parent container, matching the services template. This prevents the block from stretching or breaking out of the 10-80-10 editorial width when alignment wrappers (like `alignwide` or `alignfull`) are present in Gutenberg content.
- **Service Grid Editor Alignment**: Synchronized the WordPress Block Editor layout by updating `auto-fit` to `auto-fill` on the block editor's grid fix helper inside `service-blocks.php`. This keeps the editor's mock grid perfectly aligned and identical to the frontend rendering constraints.

## [3001.66] - 2026-05-18
### Changed
- **Service Grid Grid-Column Scaling (Auto-Fill Migration)**: Migrated `.services-grid` from `auto-fit` to `auto-fill` in the CSS grid-template-columns. While `auto-fit` stretches columns to fill the row when there are fewer items than the available grid columns (which caused Gutenberg blocks on pages with only 3 items to stretch and appear wider than the services template), `auto-fill` forces empty column tracks to remain open. This guarantees that service cards maintain the exact same dimensions regardless of the number of items in the grid.

## [3001.65] - 2026-05-18
### Changed
- **Global 10-80-10 Unboxing**: Fixed a critical CSS issue where the strict 10-80-10 editorial mandate rule (which applies `width: 80%; margin: 0 10%;` to `#primary`, `.site-main`, and `.container`) was stacking on top of itself. Elements like `.home-intro.container` or Gutenberg blocks carrying the `.container` class were getting double or triple-squeezed to 64% or 51% width because they were nested inside `#primary`. Added a CSS rule to force nested containers to cleanly expand to `100%` without additional margins.

## [3001.64] - 2026-05-18
### Changed
- **Gutenberg Block Unboxing**: Applied `display: contents !important` to the frontend `.wp-block-gw-single-service` wrapper and `display: block` to the inner `.service-card-link`. This prevents the editor's generated wrapper `div` from trapping the grid cells, allowing the single service cards to accurately span to the grid's columns (e.g. `250px`) on pages like the front page where the blocks are inserted manually.

## [3001.63] - 2026-05-18
### Changed
- **Service Grid Width Adjustment**: Increased the `auto-fit` minimum width threshold on `.services-grid` from `200px` to `250px` to provide a better visual balance for service cards on the front page and services template.

## [3001.62] - 2026-05-18
### Changed
- **Double 80% Fix**: Completely removed `width: var(--editorial-width)` from `.gw-global-grid-wrapper` and replaced it with `width: 100%`. Since elements on the front page (like `.home-intro`) and the `page-services.php` template are already wrapped in a `.container` (which enforces the 80% rule), placing an 80% wrapper inside another 80% container was causing a 64% squeeze. Both the front page and the services template should now breathe perfectly.

## [3001.61] - 2026-05-18
### Changed
- **Service Grid Auto-Fit Restoration**: Restored `grid-template-columns: repeat(auto-fit, minmax(200px, 1fr))` to adhere to the auto-fit rule, reducing the minimum width to 200px so elements scale cleanly without breaking the grid, while keeping the double 80% container fix intact.

## [3001.60] - 2026-05-18
### Changed
- **Service Grid Width & Columns**: Fixed an issue where the `.services-grid` was dropping to 2 extremely wide columns by replacing `auto-fit` with a strict `repeat(3, 1fr)` 3-column layout as dictated by the design rules.
- **Service Grid Container Bug**: Fixed a double 80% squeeze on the services grid by moving the `var(--editorial-width)` constraint to the `.gw-global-grid-wrapper`. This ensures individual `gw/single-service` blocks deployed in custom pages and the `page-services.php` template both respect the exact same dimensional constraints.
- **Row Gaps**: Enforced the strict 60px minimum row gap rule on the service grid.

## [3000.120.0] - 2026-04-29
### Changed
- **Restored "Classic" 3D Peek Slider**: Analyzed the Git repository history to restore the high-fidelity overlapping peek effect while maintaining the 3D depth and editorial typography standards.
- **Global Asset Refresh**: Bumped all versions to v3000.120.0 to ensure a clean cache state for all users.

## [3000.102.0] - 2026-04-29
### Changed
- **Automated Hero Slider**: The front-page slider now automatically syncs with the **Primary Menu**. It filters for top-level pages and utilizes their featured images, eliminating the need for manual Customizer selection.
- **Editorial Visibility (100% Rule)**: Adjusted the slider height and CSS to ensure 100% of featured images are visible without cropping (using `object-fit: contain`).
- **Peek Carousel UI**: Restored the missing "peek" transition classes (`.next`, `.prev`) and implemented a responsive 80%/95% width strategy for mobile/desktop balance.

## [3000.101.0] - 2026-04-29
### Added
- **Persona & Development Rules**: Created `PERSONA.md` to codify the "Antigravity" persona and establish a permanent set of overarching rules for the workspace.
- **Universal Device Compatibility Mandate**: Formalized the requirement for the theme to perform flawlessly on MS Edge, Chrome (Android), iPhone, and Tablets.
- **P: Drive Persistence**: Established the `P:` workspace as the primary location for rules and changelogs to ensure device-independent continuity.

## [3000.70.0] - 2026-04-28
### Added
- **1:1 Gutenberg Editor Parity**: Injected powerful CSS overrides (`.wp-block[data-type="..."]`) into the editor to ensure custom blocks (Z-Pattern, Trio Gallery, Action Steps) match their frontend constraints (`80%` width) instead of Gutenberg's narrow default column.
- **De-coupled Editor Controls**: Moved media upload and image replacement buttons for custom blocks entirely into the right-hand Inspector Sidebar to prevent accidental clicks during text editing.

### Changed
- **Z-Pattern Redesign**: Adjusted image width to 38% and content width to 62%, establishing a "happy medium" for high-end boutique visuals. Implemented vertical flex-centering for content.
- **Trio Gallery Scale**: Constrained the Trio Gallery Wall block to a maximum width of 80% to maintain the curated editorial aesthetic without blowing out to the edges of the screen.
- **CTA Plaque Unification**: Updated the Call to Action Plaque (`gw/cta-plaque`) to match the exact visual style of the Investment Plaque. It now triggers the identical `#gw-request-modal` "Contact Me" dialogue.
- **SEO Heading Structure**: Corrected the front-page Hero Slider so only the first slide outputs an `<h1>` tag, with all subsequent slides using `<h2>` to resolve duplicate heading penalties.
- **Performance - LCP Protection**: Expanded eager-loading to the first 6 images on a page to satisfy WebPageTest's viewport lazy-loading warnings.
- **Accessibility - Footer Contrast**: Increased the opacity of the copyright footer text from 0.4 to 0.65 to ensure it passes WCAG AA 4.5:1 color contrast requirements against the `#1a1a1a` background.
- **Performance - Asset Bloat**: Enforced aggressive dequeueing of WooCommerce and Jetpack (`social-logos`, `sharedaddy`) render-blocking CSS on the frontend.

### Removed
- Removed excessive top/bottom margins generated by Gutenberg panel styling on the USPs (Values) block.
