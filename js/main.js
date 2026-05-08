/**
 * File: js/main.js
 * Theme: Gary Wallage Wedding Pro
 * BOUTIQUE MENU MANDATE (ULTRA-AGGRESIVE FIX)
 */
(function ($) {
    'use strict';

    $(document).ready(function() {
        console.log('Gary Wedding: Script Loaded (v3001.51)');

        // Global delegation to bypass any propagation issues
        $(document).on('click', '.menu-toggle', function (e) {
            e.preventDefault();
            console.log('Gary Wedding: Menu Toggle Clicked');
            
            const overlay = $('#primary-menu');
            const toggle = $(this);
            
            if (!overlay.length) {
                console.error('Gary Wedding: #primary-menu NOT FOUND in DOM');
                return;
            }

            const isExpanded = toggle.attr('aria-expanded') === 'true';

            if (isExpanded) {
                console.log('Gary Wedding: Closing Menu');
                overlay.attr('aria-hidden', 'true').attr('style', 'display: none !important; opacity: 0; visibility: hidden;');
                toggle.attr('aria-expanded', 'false');
                $('body').removeClass('menu-open').css('overflow', '');
            } else {
                console.log('Gary Wedding: Opening Menu');
                // FORCE DISPLAY
                overlay.attr('aria-hidden', 'false').attr('style', 'display: flex !important; opacity: 1 !important; visibility: visible !important; z-index: 100000 !important;');
                toggle.attr('aria-expanded', 'true');
                $('body').addClass('menu-open').css('overflow', 'hidden');
                
                // Force child animation
                overlay.find('.menu-overlay-inner').css({
                    'opacity': '1',
                    'transform': 'scale(1) translateY(0)',
                    'display': 'flex'
                });
            }
        });

        $(document).on('click', '.menu-close, .menu-overlay', function (e) {
            // Only close if clicking the background or the X
            if ($(e.target).closest('.menu-overlay-inner').length && !$(e.target).closest('.menu-close').length) {
                return;
            }
            
            console.log('Gary Wedding: Closing via Overlay/Close Button');
            const overlay = $('#primary-menu');
            const toggle = $('.menu-toggle');

            overlay.attr('aria-hidden', 'true').attr('style', 'display: none !important;');
            toggle.attr('aria-expanded', 'false');
            $('body').removeClass('menu-open').css('overflow', '');
        });

        // INQUIRY MODAL
        $(document).on('click', '.gw-request-modal-trigger', function (e) {
            e.preventDefault();
            const modal = $('#gw-request-modal');
            const service = $(this).data('service') || 'Inquiry';
            
            $('#gw-modal-target-email').val($(this).data('email') || '');
            $('#modal-service-name-input').val(service);
            $('.modal-service-name').text(service);

            modal.fadeIn(300).css('display', 'flex');
            $('body').css('overflow', 'hidden');
        });
    });

})(jQuery);
