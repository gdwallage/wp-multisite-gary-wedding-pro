/**
 * File: js/main.js
 * Theme: Gary Wallage Wedding Pro
 * Version: 3001.72 (Vanilla JS Edition)
 */
document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    console.log('Gary Wedding Script: Initializing v3001.78 (Vanilla JS Edition)');

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
        
        // Find elements relatively first to support duplicate blocks (e.g. desktop and mobile headers/sections)
        const wrapper = btn.closest('.gw-process-block, .gw-editorial-gold-box, .gw-availability-check');
        let dateInput = wrapper ? wrapper.querySelector('.gw-date-picker-input') : null;
        let resultDiv = wrapper ? wrapper.querySelector('.gw-avail-result') : null;

        // Fallback to global IDs if relative lookup fails
        if (!dateInput) {
            dateInput = document.getElementById(isAtomic ? 'gw-atomic-check-date' : 'gw-check-date-' + stepId);
        }
        if (!resultDiv) {
            resultDiv = document.getElementById(isAtomic ? 'gw-atomic-availability-result' : 'gw-availability-result-' + stepId);
        }

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
                    let bookingCta = wrapper ? wrapper.querySelector('#gw-atomic-booking-cta') : null;
                    if (!bookingCta) {
                        bookingCta = document.getElementById('gw-atomic-booking-cta');
                    }
                    if (bookingCta) {
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

        const wrapper = dateInput.closest('.gw-process-block, .gw-editorial-gold-box, .gw-availability-check');
        const isAtomic = dateInput.id === 'gw-atomic-check-date' || (wrapper && wrapper.classList.contains('is-atomic-check'));
        
        // Find corresponding elements relatively first
        let btn = wrapper ? wrapper.querySelector('.gw-check-availability-btn, .gw-check-availability-btn-atomic') : null;
        let resultDiv = wrapper ? wrapper.querySelector('.gw-avail-result') : null;
        
        // Fallbacks if relative lookup fails
        if (!btn) {
            const stepId = isAtomic ? 'atomic' : dateInput.id.replace('gw-check-date-', '');
            btn = document.querySelector(isAtomic ? '.gw-check-availability-btn-atomic' : '.gw-check-availability-btn[data-step-id="' + stepId + '"]');
        }
        if (!resultDiv) {
            const stepId = isAtomic ? 'atomic' : dateInput.id.replace('gw-check-date-', '');
            resultDiv = document.getElementById(isAtomic ? 'gw-atomic-availability-result' : 'gw-availability-result-' + stepId);
        }
        
        if (resultDiv) {
            resultDiv.textContent = '';
            resultDiv.className = 'gw-avail-result';
        }

        if (isAtomic) {
            if (btn) btn.style.display = '';
            let bookingCta = wrapper ? wrapper.querySelector('#gw-atomic-booking-cta') : null;
            if (!bookingCta) {
                bookingCta = document.getElementById('gw-atomic-booking-cta');
            }
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
            threshold: window.innerWidth <= 1024 ? 0.15 : 0.5
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const stepNum = entry.target.getAttribute('data-step');
                    console.log('Gary Wedding Scrollytelling: Slide ' + stepNum + ' In View');

                    const wrapper = entry.target.closest('.scrollytelling-wrapper');
                    if (wrapper) {
                        // Skip if this is a two-column scrolly on mobile (handled by the column observer)
                        if (wrapper.classList.contains('twocol-scrolly') && window.innerWidth <= 1024) {
                            return;
                        }

                        const stepWrappers = wrapper.querySelectorAll('.scroll-bg-wrapper');
                        stepWrappers.forEach(w => w.classList.remove('is-active'));
                        const targetWrappers = wrapper.querySelectorAll('.scroll-bg-wrapper[data-step="' + stepNum + '"]');
                        targetWrappers.forEach(targetWrapper => {
                            targetWrapper.classList.add('is-active');
                        });
                    }
                }
            });
        }, observerOptions);

        steps.forEach(step => {
            observer.observe(step);
        });
    }

    // Two-Column Scrollytelling Sequential Stacking Observer
    const columns = document.querySelectorAll('.twocol-step-column');
    if (columns.length > 0) {
        console.log('Gary Wedding Scrollytelling: Initializing Two-Column IntersectionObserver...');

        const colObserverOptions = {
            root: null,
            rootMargin: window.innerWidth <= 1024 ? '-40% 0px -40% 0px' : '0px', // Create a trigger zone in the center of the screen on mobile
            threshold: 0 // trigger immediately when entering the center zone
        };

        const colObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const col = entry.target;
                    const isLeft = col.classList.contains('left-step-column');
                    const step = col.closest('.twocol-step');
                    if (step) {
                        const stepNum = step.getAttribute('data-step');
                        const wrapper = col.closest('.twocol-scrolly');
                        if (wrapper) {
                            const bgGrid = wrapper.querySelector('.twocol-bg-grid');
                            if (bgGrid) {
                                const leftBg = bgGrid.querySelector('.left-bg-column');
                                const rightBg = bgGrid.querySelector('.right-bg-column');
                                if (leftBg && rightBg) {
                                    // 1. Sync step active state
                                    const stepWrappers = wrapper.querySelectorAll('.scroll-bg-wrapper');
                                    stepWrappers.forEach(w => w.classList.remove('is-active'));
                                    
                                    if (window.innerWidth <= 1024) {
                                        // On mobile, only activate the specific column's wrapper to prevent ghosting
                                        const targetBg = isLeft ? leftBg : rightBg;
                                        const targetWrapper = targetBg.querySelector('.scroll-bg-wrapper[data-step="' + stepNum + '"]');
                                        if (targetWrapper) targetWrapper.classList.add('is-active');
                                    } else {
                                        // On desktop, activate both sides simultaneously
                                        const targetWrappers = wrapper.querySelectorAll('.scroll-bg-wrapper[data-step="' + stepNum + '"]');
                                        targetWrappers.forEach(targetWrapper => {
                                            targetWrapper.classList.add('is-active');
                                        });
                                    }

                                    // 2. Set active column visibility
                                    if (isLeft) {
                                        console.log('Gary Wedding Scrollytelling: Left Column In View for Step ' + stepNum);
                                        leftBg.classList.add('is-column-active');
                                        rightBg.classList.remove('is-column-active');
                                    } else {
                                        console.log('Gary Wedding Scrollytelling: Right Column In View for Step ' + stepNum);
                                        rightBg.classList.add('is-column-active');
                                        leftBg.classList.remove('is-column-active');
                                    }
                                }
                            }
                        }
                    }
                }
            });
        }, colObserverOptions);

        columns.forEach(col => {
            colObserver.observe(col);
        });
    }
});
