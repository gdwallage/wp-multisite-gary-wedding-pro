<?php 
/** 
 * File: footer.php 
 * BOUTIQUE FOOTER MANDATE (NON-NEGOTIABLE):
 * - Must maintain 3-column symmetry.
 * - Social section must use the locked SVG icon system.
 * - Vertical spacing must remain compact.
 */ 
?>
<footer id="colophon" class="site-footer" style="background:#1a1a1a; color:#fff; text-align:center; margin-top:40px;">

    <div class="footer-grid">

        <!-- LEFT COLUMN: Legal Pages -->
        <div class="footer-col-left">
            <?php
            $privacy_id = get_theme_mod('legal_page_privacy');
            $terms_id = get_theme_mod('legal_page_terms');
            $cookies_id = get_theme_mod('legal_page_cookies');

            if ($privacy_id || $terms_id || $cookies_id):
                ?>
                <ul class="footer-legal-list">
                    <?php if ($terms_id): ?>
                        <li><a href="<?php echo esc_url(get_permalink($terms_id)); ?>">Terms & Conditions</a></li>
                    <?php endif; ?>

                    <?php if ($privacy_id): ?>
                        <li><a href="<?php echo esc_url(get_permalink($privacy_id)); ?>">Privacy Policy</a></li>
                    <?php endif; ?>

                    <?php if ($cookies_id): ?>
                        <li><a href="<?php echo esc_url(get_permalink($cookies_id)); ?>">Cookie Policy</a></li>
                    <?php endif; ?>
                </ul>
            <?php endif; ?>
        </div>

        <!-- CENTER COLUMN: Branding -->
        <div class="footer-col-center">
            <div class="footer-branding">
                <h3>
                    <?php echo esc_html(get_theme_mod('footer_heading', 'Preserving Legacies')); ?>
                </h3>
                <p>
                    <?php echo nl2br(esc_html(get_theme_mod('footer_text', 'A visual historian grounded in the technical discipline of the darkroom.'))); ?>
                </p>
            </div>
        </div>

        <!-- RIGHT COLUMN: Contact Info -->
        <div class="footer-col-right">
            <div class="footer-contact">
                <span class="contact-row">
                    63 Twineham Road, Swindon, SN25 2AG
                </span>

                <span class="contact-row" style="margin-top:10px;">
                    <a href="mailto:gary@garywallage.uk">
                        gary@garywallage.uk
                    </a>
                </span>

                <?php
                // NAP Consistency: Rigidly formatted phone number
                $display_phone = '+44 7970 262 387';
                $phone_clean = '447970262387';
                ?>
                <span class="contact-row">
                    <a href="tel:<?php echo esc_attr($phone_clean); ?>">
                        <?php echo esc_html($display_phone); ?>
                    </a>
                    <!-- WhatsApp Dual Link -->
                    <a href="https://wa.me/<?php echo esc_attr($phone_clean); ?>" class="whatsapp-link"
                        target="_blank" aria-label="Chat on WhatsApp">
                        <span style="font-size:1.1em; vertical-align:middle;">&rarr;</span> WhatsApp
                    </a>
                </span>
            </div>
        </div>

    </div>

    <!-- Social Media Links -->
    <?php
    $social_links = array(
        'facebook'  => array('url' => get_theme_mod('social_facebook', 'https://www.facebook.com/garywallage.wedding'), 'label' => 'Facebook', 'svg' => '<svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>'),
        'instagram' => array('url' => get_theme_mod('social_instagram', 'https://www.instagram.com/garywallage.wedding'), 'label' => 'Instagram', 'svg' => '<svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>'),
        'threads'   => array('url' => get_theme_mod('social_threads', ''), 'label' => 'Threads', 'svg' => '<svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M15.42 12.87c-.45-.44-1.07-.69-1.7-.69h-1.44v2.76h1.44c.63 0 1.25-.25 1.7-.69l.48.48c-.58.58-1.37.91-2.18.91h-1.44v1.38h-1.38v-8.28h2.82c.63 0 1.25.25 1.7.69l.48-.48c-.58-.58-1.37-.91-2.18-.91h-2.82c-.63 0-1.25.25-1.7.69l-.48-.48c.58-.58 1.37-.91 2.18-.91h2.82v-1.38h1.38v1.38h1.44c.63 0 1.25.25 1.7.69l-.48.48c-.45-.44-1.07-.69-1.7-.69h-1.44v2.76h1.44c.63 0 1.25-.25 1.7-.69l.48.48z"/></svg>'),
        'pinterest' => array('url' => get_theme_mod('social_pinterest', ''), 'label' => 'Pinterest', 'svg' => '<svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.162-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.965 1.406-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738.098.119.112.224.083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.261 7.929-7.261 4.162 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.631-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146 1.124.347 2.317.535 3.554.535 6.607 0 11.985-5.365 11.985-11.987C23.97 5.39 18.592 0 12.017 0z"/></svg>'),
        'youtube'   => array('url' => get_theme_mod('social_youtube', ''), 'label' => 'YouTube', 'svg' => '<svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>'),
        'twitter'   => array('url' => get_theme_mod('social_twitter', ''), 'label' => 'X', 'svg' => '<svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>'),
    );
    $has_social = false;
    foreach ($social_links as $s) {
        if (!empty($s['url'])) {
            $has_social = true;
            break;
        }
    }
    if ($has_social):
        ?>
        <div class="footer-social" style="margin-top:0; padding-bottom:20px; text-align:center;">
            <p style="font-size:0.65rem; letter-spacing:3px; text-transform:uppercase; opacity:0.5; margin-bottom:14px;">
                Follow the Story</p>
            <div style="display:flex; gap:16px; justify-content:center; flex-wrap:wrap;">
                <?php foreach ($social_links as $platform => $s):
                    if (empty($s['url']))
                        continue; ?>
                    <a href="<?php echo esc_url($s['url']); ?>" target="_blank" rel="noopener noreferrer"
                        aria-label="<?php echo esc_attr($s['label']); ?> — Gary Wallage Wedding Photography"
                        class="footer-social-link">
                        <?php echo $s['svg']; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Bottom Copyright -->
    <div class="footer-meta" style="border-top:1px solid #333; padding-top:30px; margin-top:30px; text-align:center;">
        <p style="font-size:0.7rem; letter-spacing:3px; text-transform:uppercase; opacity:0.6;">
            &copy; <?php echo date('Y'); ?>
            <?php echo esc_html(get_theme_mod('footer_copyright', 'Gary Wallage Digital Ecosystem | Wiltshire Historian')); ?>
        </p>
    </div>
    <!-- Inquiry Modal (High Fidelity Boutique Style) -->
    <div id="gw-request-modal" class="gw-modal-overlay" style="display:none;">
        <div class="gw-modal-content">
            <button class="gw-modal-close" aria-label="Close Modal">&times;</button>
            <div class="gw-modal-header">
                <h3 class="modal-service-name">Request Details</h3>
                <p>Let's discuss how I can preserve your legacy.</p>
            </div>
            <form id="gw-request-form">
                <input type="hidden" name="target_email" id="modal-target-email">
                <input type="hidden" name="service_name" id="modal-service-name-input">
                <div class="gw-form-row">
                    <input type="text" name="user_name" placeholder="Your Name" required>
                </div>
                <div class="gw-form-row">
                    <input type="email" name="user_email" placeholder="Email Address" required>
                </div>
                <div class="gw-form-row">
                    <textarea name="user_note" placeholder="Tell me about your day..." rows="4" required></textarea>
                </div>
                <div class="gw-form-status" style="margin-bottom:15px; font-size:0.85rem; min-height:1.2em;"></div>
                <button type="submit" class="btn-black-gold">Send Inquiry</button>
            </form>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>

</html>