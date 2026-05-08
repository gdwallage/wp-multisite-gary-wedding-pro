<?php
/**
 * File: functions.php
 * Theme: Gary Wallage Wedding Pro
 * BOUTIQUE EDITORIAL MANDATE (NON-NEGOTIABLE):
 * 1. THE 10-80-10 RULE: Strict 10% Margins / 80% Content.
 * 2. THE NEVER-CROP RULE: Preserve artistic image aspect ratios.
 * 3. FOCAL FIDELITY: Maintain centered branding over the Hero Slider.
 */

/**
 * CORE ARCHITECTURE
 */
define( 'GARY_THEME_VERSION', wp_get_theme()->get( 'Version' ) );

require_once get_template_directory() . '/inc/setup.php';
require_once get_template_directory() . '/inc/enqueue.php';
require_once get_template_directory() . '/inc/customizer.php';
require_once get_template_directory() . '/inc/template-tags.php';
require_once get_template_directory() . '/inc/ajax-handlers.php';
require_once get_template_directory() . '/inc/shortcodes.php';
require_once get_template_directory() . '/inc/blocks/service-blocks.php';
require_once get_template_directory() . '/inc/card-renderer.php';
require_once get_template_directory() . '/inc/woocommerce-integration.php';

/**
 * LEGACY / THEME-SPECIFIC OVERRIDES
 * (Moving these to modular files incrementally)
 */

// Placeholder for remaining local functions if any

function gary_wedding_footer_scripts()
{
    if (is_admin())
        return; ?>
    <script>
        (function($) {
            // --- MENU TOGGLE ---
            $(document).on('click', '.menu-toggle', function(e) {
                e.preventDefault();
                var $overlay = $('#primary-menu');
                if (!$overlay.length) return;
                var isOpen = $(this).attr('aria-expanded') === 'true';
                if (isOpen) {
                    $overlay.attr('aria-hidden', 'true').attr('style', 'display: none !important;');
                    $(this).attr('aria-expanded', 'false');
                    $('body').css('overflow', '');
                } else {
                    $overlay.attr('aria-hidden', 'false').attr('style', 'display: flex !important; opacity:1 !important; visibility:visible !important; z-index:99999 !important;');
                    $(this).attr('aria-expanded', 'true');
                    $('body').css('overflow', 'hidden');
                }
            });
            $(document).on('click', '.menu-close, .menu-overlay', function(e) {
                if ($(e.target).closest('.menu-overlay-inner').length && !$(e.target).closest('.menu-close').length) return;
                $('#primary-menu').attr('aria-hidden', 'true').attr('style', 'display: none !important;');
                $('.menu-toggle').attr('aria-expanded', 'false');
                $('body').css('overflow', '');
            });

            // --- AVAILABILITY CHECKER ---
            $(document).on('click', '.gw-check-availability-btn, .gw-check-availability-btn-atomic', function() {
                var isAtomic = $(this).hasClass('gw-check-availability-btn-atomic');
                var stepId = isAtomic ? 'atomic' : $(this).data('stepId');
                var $dateInput = $('#' + (isAtomic ? 'gw-atomic-check-date' : 'gw-check-date-' + stepId));
                var $resultDiv = $('#' + (isAtomic ? 'gw-atomic-availability-result' : 'gw-availability-result-' + stepId));
                var $atomicCta = $('#gw-atomic-booking-cta');

                if (!$dateInput.val()) {
                    $resultDiv.text('Please select a date.');
                    return;
                }

                $(this).prop('disabled', true).text('Checking...');
                $resultDiv.text('Consulting the calendar...').attr('class', 'gw-avail-result');

                var $btn = $(this);
                $.getJSON('/wp-admin/admin-ajax.php', {
                    action: 'gary_check_availability',
                    check_date: $dateInput.val(),
                    duration: $(this).data('duration') || 'Full Day'
                }, function(data) {
                    $btn.prop('disabled', false).text('Check Availability');
                    if (data.success) {
                        $resultDiv.text(data.data.message);
                        if (data.data.status === 'available' || data.data.status === 'tentative') {
                            $resultDiv.addClass('is-available');
                            if (isAtomic) $atomicCta.show();
                        }
                    } else {
                        $resultDiv.text(data.data.message || 'I am busy on this date.').addClass('is-busy');
                    }
                });
            });
        })(jQuery);
    </script>
    <?php
}
add_action('wp_footer', 'gary_wedding_footer_scripts');

/**
 * UTILITY: Fetch Bookly Forms
 */
function gary_get_bookly_forms()
{
    global $wpdb;
    $table = $wpdb->prefix . 'bookly_forms';
    if ($wpdb->get_var("SHOW TABLES LIKE '$table'") != $table)
        return array();

    $results = $wpdb->get_results("SELECT id, name FROM $table ORDER BY name ASC", ARRAY_A);
    return $results ? $results : array();
}

/**
 * SECURITY: Limit login error messages
 */
add_filter('login_errors', function () {
    return 'Login failed.'; });

/**
 * Render the Global Boutique Request Modal (v3000.37.0)
 * Hooked to wp_footer to ensure it is always available for plaque triggers.
 * Logic is handled in js/main.js
 */
function gary_global_request_modal()
{
    ?>
    <div id="gw-request-modal" class="gw-modal"
        style="display:none; position:fixed; inset:0; z-index:100000; align-items:center; justify-content:center;">
        <div class="gw-modal-overlay"
            style="position:absolute; inset:0; background:rgba(0,0,0,0.85); backdrop-filter:blur(5px);"></div>
        <div class="gw-modal-content"
            style="position:relative; z-index:2; max-width:500px; width:90%; background:#fff; padding:40px; border:2px solid #C5A059; box-shadow:0 20px 50px rgba(0,0,0,0.5);">
            <span class="gw-modal-close"
                style="position:absolute; top:20px; right:20px; font-size:30px; cursor:pointer; line-height:1; color:#C5A059;">&times;</span>
            <h3
                style="text-align:center; text-transform:uppercase; letter-spacing:3px; margin-bottom:10px; color:#C5A059; font-family:var(--font-primary); font-weight:700;">
                Request Details</h3>
            <p class="modal-service-name"
                style="text-align:center; font-size:0.9rem; opacity:0.7; margin-bottom:30px; font-family:var(--font-primary);">
            </p>

            <form id="gw-request-form">
                <input type="hidden" name="action" value="gw_submit_request">
                <input type="hidden" name="target_email" id="gw-modal-target-email" value="">
                <input type="hidden" name="service_name" id="modal-service-name-input" value="">

                <div style="margin-bottom:20px;">
                    <label
                        style="display:block; font-size:0.75rem; text-transform:uppercase; letter-spacing:2px; font-weight:700; margin-bottom:8px; opacity:0.6; font-family:var(--font-primary);">Your
                        Name</label>
                    <input type="text" name="user_name" required
                        style="width:100%; padding:12px; border:1px solid #ddd; font-family:var(--font-primary);">
                </div>
                <div style="margin-bottom:20px;">
                    <label
                        style="display:block; font-size:0.75rem; text-transform:uppercase; letter-spacing:2px; font-weight:700; margin-bottom:8px; opacity:0.6; font-family:var(--font-primary);">Email
                        Address</label>
                    <input type="email" name="user_email" required
                        style="width:100%; padding:12px; border:1px solid #ddd; font-family:var(--font-primary);">
                </div>
                <div style="margin-bottom:25px;">
                    <label
                        style="display:block; font-size:0.75rem; text-transform:uppercase; letter-spacing:2px; font-weight:700; margin-bottom:8px; opacity:0.6; font-family:var(--font-primary);">Message
                        / Note</label>
                    <textarea name="user_note" rows="4"
                        style="width:100%; padding:12px; border:1px solid #ddd; font-family:var(--font-primary);"></textarea>
                </div>

                <button type="submit" class="btn-black-gold"
                    style="width:100%; border:none; padding:18px; cursor:pointer; background:#000; color:#fff; font-weight:700; text-transform:uppercase; letter-spacing:2px;">Send
                    Request</button>
                <div class="gw-form-status"
                    style="margin-top:20px; text-align:center; font-weight:700; font-size:0.9rem; font-family:var(--font-primary);">
                </div>
            </form>
        </div>
    </div>
    <?php
}
add_action('wp_footer', 'gary_global_request_modal');
