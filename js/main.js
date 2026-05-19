/**
 * File: js/main.js
 * Theme: Gary Wallage Wedding Pro
 * Version: 3001.72 (Vanilla JS Edition)
 */
document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    console.log('Gary Wedding Script: Initializing v3001.77 (Vanilla JS Edition)');

    // Bookly Pre-fill Date from URL Query Parameter
    const urlParams = new URLSearchParams(window.location.search);
    const checkDate = urlParams.get('check_date');

    if (checkDate && document.body.classList.contains('page-template-page-service-detail')) {
        console.log('Gary Wedding Pre-fill: Found check_date in URL: ' + checkDate);
        
        const targetSelectors = [
            'input.bookly-js-date-from',
            'input.bookly-date-from',
            'input[name="date_from"]',
            '.bookly-date-from',
            '.bookly-js-date',
            'input[id^="bookly-date"]'
        ];

        const prefillBookly = () => {
            for (let selector of targetSelectors) {
                const els = document.querySelectorAll(selector);
                for (let el of els) {
                    if (el && el.value !== checkDate) {
                        console.log('Gary Wedding Pre-fill: Pre-filling Bookly field', el, 'with', checkDate);
                        el.value = checkDate;
                        // Trigger standard events so datepicker libraries and Bookly core synchronize
                        el.dispatchEvent(new Event('change', { bubbles: true }));
                        el.dispatchEvent(new Event('input', { bubbles: true }));
                        
                        // If jQuery is active, attempt to update the datepicker widget
                        if (window.jQuery && jQuery(el).datepicker) {
                            try {
                                jQuery(el).datepicker('setDate', checkDate);
                                jQuery(el).change();
                            } catch (e) {
                                console.error('Failed jQuery datepicker init:', e);
                            }
                        }
                    }
                }
            }
        };

        // Run immediately
        prefillBookly();

        // Use MutationObserver to watch for dynamic AJAX loading of Bookly forms
        const observer = new MutationObserver(() => {
            prefillBookly();
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true
        });

        // Disconnect observer after 10 seconds to optimize page performance
        setTimeout(() => {
            observer.disconnect();
        }, 10000);
    }

    const menuToggle = document.querySelector('.menu-toggle');
    const menuOverlay = document.getElementById('primary-menu');
    const body = document.body;

    if (menuToggle && menuOverlay) {
        const toggleMenu = (forceClose = false) => {
            const isOpen = menuOverlay.style.display === 'flex';
            const shouldClose = forceClose || isOpen;

            if (shouldClose) {
                console.log('Gary Wedding: Menu Closing Action');
                menuToggle.setAttribute('aria-expanded', 'false');
                menuToggle.classList.remove('active');
                menuOverlay.classList.remove('active');
                menuOverlay.setAttribute('aria-hidden', 'true');
                menuOverlay.setAttribute('style', 'display: none !important;');
                body.classList.remove('menu-open');
                body.style.overflow = '';
            } else {
                console.log('Gary Wedding: Menu Opening Action');
                menuToggle.setAttribute('aria-expanded', 'true');
                menuToggle.classList.add('active');
                menuOverlay.classList.add('active');
                menuOverlay.setAttribute('aria-hidden', 'false');
                menuOverlay.setAttribute('style', 'display: flex !important; opacity: 1 !important; visibility: visible !important; z-index: 1000000 !important;');
                body.classList.add('menu-open');
                body.style.overflow = 'hidden';
            }
        };

        // Click menu toggle
        menuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            toggleMenu();
        });

        // Click close button or overlay background
        menuOverlay.addEventListener('click', function(e) {
            const inner = menuOverlay.querySelector('.menu-overlay-inner');
            if (inner && inner.contains(e.target) && !e.target.classList.contains('menu-close')) {
                return;
            }
            toggleMenu(true);
        });

        // Escape key to close
        document.addEventListener('keyup', function(e) {
            if (e.key === 'Escape') {
                toggleMenu(true);
            }
        });
    }

    // Availability Checker Event Delegation
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.gw-check-availability-btn, .gw-check-availability-btn-atomic');
        if (!btn) return;

        const isAtomic = btn.classList.contains('gw-check-availability-btn-atomic');
        const stepId = isAtomic ? 'atomic' : btn.getAttribute('data-step-id');
        const dateInput = document.getElementById(isAtomic ? 'gw-atomic-check-date' : 'gw-check-date-' + stepId);
        const resultDiv = document.getElementById(isAtomic ? 'gw-atomic-availability-result' : 'gw-availability-result-' + stepId);

        if (!dateInput || !resultDiv) return;

        if (!dateInput.value) {
            resultDiv.textContent = 'Please select a date.';
            return;
        }

        btn.disabled = true;
        const originalText = btn.textContent;
        btn.textContent = 'Checking...';
        
        resultDiv.textContent = 'Consulting the calendar...';
        resultDiv.className = 'gw-avail-result';

        const duration = btn.getAttribute('data-duration') || 'Full Day';
        const ajaxUrl = '/wp-json/gw/v1/check-availability?check_date=' + encodeURIComponent(dateInput.value) + '&duration=' + encodeURIComponent(duration);

        fetch(ajaxUrl, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok: ' + response.statusText);
            }
            return response.text();
        })
        .then(text => {
            let data;
            try {
                data = JSON.parse(text);
            } catch (e) {
                console.error('Failed to parse JSON response:', text);
                throw new Error('Invalid server response format.');
            }
            
            btn.disabled = false;
            btn.textContent = originalText;
            
            if (data.success) {
                resultDiv.textContent = data.data.message;
                resultDiv.classList.add('is-available');
                if (isAtomic) {
                    const bookingCta = document.getElementById('gw-atomic-booking-cta');
                    if (bookingCta) {
                        const originalUrl = bookingCta.getAttribute('href') || '#';
                        let cleanUrl = originalUrl.split('?')[0];
                        let params = new URLSearchParams(originalUrl.indexOf('?') !== -1 ? originalUrl.split('?')[1] : '');
                        params.set('check_date', dateInput.value);
                        bookingCta.setAttribute('href', cleanUrl + '?' + params.toString());
                        bookingCta.style.display = 'flex';
                    }
                    btn.style.display = 'none';
                }
            } else {
                resultDiv.textContent = (data.data && data.data.message) ? data.data.message : 'Busy on this date.';
                resultDiv.classList.add('is-busy');
            }
        })
        .catch(err => {
            btn.disabled = false;
            btn.textContent = originalText;
            resultDiv.textContent = 'Error verifying availability. Please try again.';
            resultDiv.classList.add('is-busy');
            console.error('AJAX Error:', err);
        });
    });

    // Automatically reset checker state when date input changes
    document.addEventListener('change', function(e) {
        const dateInput = e.target.closest('.gw-date-picker-input');
        if (!dateInput) return;

        const isAtomic = dateInput.id === 'gw-atomic-check-date';
        const stepId = isAtomic ? 'atomic' : dateInput.id.replace('gw-check-date-', '');
        
        // Find corresponding elements
        const btn = document.querySelector(isAtomic ? '.gw-check-availability-btn-atomic' : '.gw-check-availability-btn[data-step-id="' + stepId + '"]');
        const resultDiv = document.getElementById(isAtomic ? 'gw-atomic-availability-result' : 'gw-availability-result-' + stepId);
        
        if (resultDiv) {
            resultDiv.textContent = '';
            resultDiv.className = 'gw-avail-result';
        }

        if (isAtomic) {
            if (btn) btn.style.display = '';
            const bookingCta = document.getElementById('gw-atomic-booking-cta');
            if (bookingCta) bookingCta.style.display = 'none';
        }
    });

    // Inquiry Form / Modal Handling
    document.addEventListener('click', function(e) {
        const trigger = e.target.closest('.gw-request-modal-trigger');
        if (!trigger) return;

        e.preventDefault();
        const modal = document.getElementById('gw-request-modal');
        if (!modal) return;

        const service = trigger.getAttribute('data-service') || 'Inquiry';
        const email = trigger.getAttribute('data-email') || '';

        const targetEmailInput = document.getElementById('modal-target-email');
        if (targetEmailInput) targetEmailInput.value = email;

        const serviceNameEls = modal.querySelectorAll('.modal-service-name');
        serviceNameEls.forEach(el => el.textContent = service);

        modal.style.display = 'flex';
        // Fade in
        modal.style.opacity = '0';
        modal.style.transition = 'opacity 0.3s ease';
        // force reflow
        modal.offsetHeight;
        modal.style.opacity = '1';

        body.classList.add('menu-open');
        body.style.overflow = 'hidden';
    });

    // Close Modal Delegation
    document.addEventListener('click', function(e) {
        const modal = document.getElementById('gw-request-modal');
        if (!modal) return;

        const isCloseBtn = e.target.classList.contains('gw-modal-close');
        const isOverlay = e.target.classList.contains('gw-modal-overlay');

        if (isCloseBtn || isOverlay) {
            modal.style.transition = 'opacity 0.3s ease';
            modal.style.opacity = '0';
            setTimeout(() => {
                modal.style.display = 'none';
            }, 300);
            body.classList.remove('menu-open');
            body.style.overflow = '';
        }
    });

    const steps = document.querySelectorAll('.scroll-step');
    const wrappers = document.querySelectorAll('.scroll-bg-wrapper');

    if (steps.length > 0 && wrappers.length > 0) {
        console.log('Gary Wedding Scrollytelling: Initializing IntersectionObserver...');

        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.5
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const stepNum = entry.target.getAttribute('data-step');
                    console.log('Gary Wedding Scrollytelling: Slide ' + stepNum + ' In View');

                    wrappers.forEach(w => w.classList.remove('is-active'));
                    const targetWrappers = document.querySelectorAll('.scroll-bg-wrapper[data-step="' + stepNum + '"]');
                    targetWrappers.forEach(targetWrapper => {
                        targetWrapper.classList.add('is-active');
                    });
                }
            });
        }, observerOptions);

        steps.forEach(step => {
            observer.observe(step);
        });
    }
});
