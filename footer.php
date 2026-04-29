<footer id="colophon" class="site-footer">
    
    <div class="footer-grid">
        
        <!-- LEFT COLUMN: Legal Pages -->
        <div class="footer-col-left">
            <?php 
            $privacy_id = get_theme_mod('legal_page_privacy');
            $terms_id   = get_theme_mod('legal_page_terms');
            $cookies_id = get_theme_mod('legal_page_cookies');
            
            if ( $privacy_id || $terms_id || $cookies_id ) : 
            ?>
                <ul class="footer-legal-list">
                    <?php if ( $terms_id ) : ?>
                        <li><a href="<?php echo esc_url( get_permalink( $terms_id ) ); ?>">Terms & Conditions</a></li>
                    <?php endif; ?>

                    <?php if ( $privacy_id ) : ?>
                        <li><a href="<?php echo esc_url( get_permalink( $privacy_id ) ); ?>">Privacy Policy</a></li>
                    <?php endif; ?>
                    
                    <?php if ( $cookies_id ) : ?>
                        <li><a href="<?php echo esc_url( get_permalink( $cookies_id ) ); ?>">Cookie Policy</a></li>
                    <?php endif; ?>
                </ul>
            <?php endif; ?>
        </div>

        <!-- CENTER COLUMN: Branding -->
        <div class="footer-col-center">
            <div class="footer-branding">
                <h3>
                    <?php echo esc_html( get_theme_mod( 'footer_heading', 'Preserving Legacies' ) ); ?>
                </h3>
                <p>
                    <?php echo nl2br( esc_html( get_theme_mod( 'footer_text', 'A visual historian grounded in the technical discipline of the darkroom.' ) ) ); ?>
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
                $phone_clean   = '447970262387';
                ?>
                <span class="contact-row">
                    <a href="tel:<?php echo esc_attr( $phone_clean ); ?>">
                        <?php echo esc_html( $display_phone ); ?>
                    </a>
                    <!-- WhatsApp Dual Link -->
                    <a href="https://wa.me/<?php echo esc_attr( $phone_clean ); ?>" class="whatsapp-link" target="_blank" aria-label="Chat on WhatsApp">
                        <span style="font-size:1.1em; vertical-align:middle;">&rarr;</span> WhatsApp
                    </a>
                </span>
            </div>
        </div>

    </div>

    <!-- Social Media Links -->
    <?php
    $social_links = array(
        'facebook'  => array( 'url' => get_theme_mod( 'social_facebook',  'https://www.facebook.com/garywallage.wedding' ), 'label' => 'Facebook',  'icon' => 'f' ),
        'instagram' => array( 'url' => get_theme_mod( 'social_instagram', 'https://www.instagram.com/garywallage.wedding' ), 'label' => 'Instagram', 'icon' => '&#9673;' ),
        'youtube'   => array( 'url' => get_theme_mod( 'social_youtube',   '' ), 'label' => 'YouTube',   'icon' => '&#9654;' ),
        'twitter'   => array( 'url' => get_theme_mod( 'social_twitter',   '' ), 'label' => 'X',         'icon' => 'X' ),
        'linkedin'  => array( 'url' => get_theme_mod( 'social_linkedin',  '' ), 'label' => 'LinkedIn',  'icon' => 'in' ),
    );
    $has_social = false;
    foreach ( $social_links as $s ) { if ( ! empty( $s['url'] ) ) { $has_social = true; break; } }
    if ( $has_social ) :
    ?>
    <div class="footer-social">
        <p class="footer-social-label">Follow the Story</p>
        <div class="footer-social-icons">
            <?php foreach ( $social_links as $platform => $s ) :
                if ( empty( $s['url'] ) ) continue; ?>
                <a href="<?php echo esc_url( $s['url'] ); ?>"
                   target="_blank"
                   rel="noopener noreferrer"
                   aria-label="<?php echo esc_attr( $s['label'] ); ?> — Gary Wallage Wedding Photography"
                   class="footer-social-link">
                    <?php echo $s['icon']; ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Bottom Copyright -->
    <div class="footer-meta">
        <p>
            &copy; <?php echo date('Y'); ?> Gary Wallage Photography | Wiltshire Historian & Visual Poet
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
