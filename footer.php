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

    <!-- Bottom Copyright -->
    <div class="footer-meta" style="border-top:1px solid #333; padding-top:30px; margin-top:30px; text-align:center;">
        <p style="font-size:0.7rem; letter-spacing:3px; text-transform:uppercase; opacity:0.6;">
            &copy; <?php echo date('Y'); ?> <?php echo esc_html( get_theme_mod( 'footer_copyright', 'Gary Wallage Digital Ecosystem | Wiltshire Historian' ) ); ?>
        </p>
    </div>
</footer>

<!-- LIGHTBOX MARKUP -->
<div id="gw-lightbox">
    <div id="gw-lightbox-close">&times;</div>
    <img id="gw-lightbox-img" src="" alt="Full View">
</div>

<!-- LIGHTBOX SCRIPT -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const lightbox = document.getElementById('gw-lightbox');
    const lightboxImg = document.getElementById('gw-lightbox-img');
    const closeBtn = document.getElementById('gw-lightbox-close');
    const triggers = document.querySelectorAll('.lightbox-trigger');

    triggers.forEach(trigger => {
        trigger.addEventListener('click', function(e) {
            e.preventDefault();
            const fullResUrl = this.getAttribute('href');
            lightboxImg.src = fullResUrl;
            lightbox.classList.add('active');
        });
    });

    closeBtn.addEventListener('click', () => lightbox.classList.remove('active'));
    lightbox.addEventListener('click', (e) => {
        if (e.target === lightbox) lightbox.classList.remove('active');
    });
    document.addEventListener('keydown', (e) => {
        if (e.key === "Escape" && lightbox.classList.contains('active')) lightbox.classList.remove('active');
    });
});
</script>

<?php wp_footer(); ?>
</body>
</html>
