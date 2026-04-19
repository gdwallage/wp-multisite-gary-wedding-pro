<footer id="colophon" class="site-footer" style="background:#1a1a1a; color:#fff; text-align:center; margin-top:100px;">
    
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
                <?php if ( get_theme_mod( 'footer_contact' ) ) : ?>
                    <span class="contact-row">
                        <?php echo nl2br( esc_html( get_theme_mod( 'footer_contact' ) ) ); ?>
                    </span>
                <?php endif; ?>

                <?php if ( get_theme_mod( 'footer_email' ) ) : ?>
                    <span class="contact-row" style="margin-top:10px;">
                        <a href="mailto:<?php echo esc_attr( get_theme_mod( 'footer_email' ) ); ?>">
                            <?php echo esc_html( get_theme_mod( 'footer_email' ) ); ?>
                        </a>
                    </span>
                <?php endif; ?>

                <?php 
                $phone_raw = get_theme_mod( 'footer_phone' );
                if ( $phone_raw ) :
                    $phone_clean = preg_replace('/[^0-9+]/', '', $phone_raw);
                ?>
                    <span class="contact-row">
                        <a href="tel:<?php echo esc_attr( $phone_clean ); ?>">
                            <?php echo esc_html( $phone_raw ); ?>
                        </a>
                        <!-- WhatsApp Dual Link -->
                        <a href="https://wa.me/<?php echo esc_attr( $phone_clean ); ?>" class="whatsapp-link" target="_blank" aria-label="Chat on WhatsApp">
                            <span style="font-size:1.1em; vertical-align:middle;">&rarr;</span> WhatsApp
                        </a>
                    </span>
                <?php endif; ?>
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
    <div class="footer-social" style="margin-top:30px; padding-bottom:20px; text-align:center;">
        <p style="font-size:0.65rem; letter-spacing:3px; text-transform:uppercase; opacity:0.5; margin-bottom:14px;">Follow the Story</p>
        <div style="display:flex; gap:16px; justify-content:center; flex-wrap:wrap;">
            <?php foreach ( $social_links as $platform => $s ) :
                if ( empty( $s['url'] ) ) continue; ?>
                <a href="<?php echo esc_url( $s['url'] ); ?>"
                   target="_blank"
                   rel="noopener noreferrer"
                   aria-label="<?php echo esc_attr( $s['label'] ); ?> — Gary Wallage Wedding Photography"
                   class="footer-social-link"
                   style="display:inline-flex; align-items:center; justify-content:center; width:44px; height:44px; border:1px solid rgba(201,168,76,0.4); border-radius:50%; color:#C9A84C; text-decoration:none; font-size:0.85rem; font-weight:700; letter-spacing:0; transition:background 0.3s, border-color 0.3s;"
                   onmouseover="this.style.background='rgba(201,168,76,0.15)'; this.style.borderColor='#C9A84C';"
                   onmouseout="this.style.background='transparent'; this.style.borderColor='rgba(201,168,76,0.4)';">
                    <?php echo $s['icon']; ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Bottom Copyright -->
    <div class="footer-meta" style="border-top:1px solid #333; padding-top:30px; margin-top:30px; text-align:center;">
        <p style="font-size:0.7rem; letter-spacing:3px; text-transform:uppercase; opacity:0.6;">
            &copy; <?php echo date('Y'); ?> <?php echo esc_html( get_theme_mod( 'footer_copyright', 'Gary Wallage Digital Ecosystem | Wiltshire Historian' ) ); ?>
        </p>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
