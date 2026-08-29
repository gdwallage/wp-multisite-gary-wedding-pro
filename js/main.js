/**
 * File: js/main.js
 * Theme: Gary Wallage Wedding Pro
 * Version: 3001.72 (Vanilla JS Edition)
 */
document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    console.log('Gary Wedding Script: Initializing v3001.78 (Vanilla JS Edition)');

    // ── Dynamic Header Height ────────────────────────────────────────────────
    // Measure the REAL rendered header height (logo + tagline + border can vary)
    // and inject it as --header-height on :root so all sticky/scroll calculations
    // are pixel-perfect regardless of font scaling, admin bar, or content changes.
    function setHeaderHeight() {
        const header = document.querySelector('.site-header');
        if (!header) return;
        // .bottom = exact pixels from viewport top to header's bottom edge.
        // This automatically includes admin bar height, font scaling, border — everything.
        const rect = header.getBoundingClientRect();
        const h = rect.bottom;
        const headerActualHeight = rect.height;
        
        document.documentElement.style.setProperty('--header-height', h + 'px');
        document.documentElement.style.setProperty('--header-actual-height', headerActualHeight + 'px');
        console.log('Gary Wedding: --header-height set to ' + h + 'px, --header-actual-height set to ' + headerActualHeight + 'px');
    }

    // Set immediately, then update on resize/orientation change
    setHeaderHeight();
    window.addEventListener('resize', setHeaderHeight);
    window.addEventListener('orientationchange', function() {
        setTimeout(setHeaderHeight, 100); // small delay for orientation to settle
    });
    // Also re-measure after fonts/images may have loaded and shifted layout
    window.addEventListener('load', setHeaderHeight);


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

    // Mark all scrollytelling wrappers as initialized so CSS enter-transitions activate
    document.querySelectorAll('.scrollytelling-wrapper').forEach(w => {
        w.classList.add('scrolly-initialized');
    });

    // ── Scrollytelling Placement Detection ───────────────────────────
    function detectScrollytellingPlacement() {
        const wrappers = document.querySelectorAll('.scrollytelling-wrapper');
        if (wrappers.length === 0) return;

        function isVisibleContent(el) {
            if (!el) return false;
            const ignoredTags = ['SCRIPT', 'STYLE', 'TEMPLATE', 'LINK', 'NOSCRIPT', 'IFRAME'];
            if (ignoredTags.includes(el.tagName)) return false;
            
            if (el.id === 'wpadminbar' || 
                el.classList.contains('site-header') || 
                el.classList.contains('menu-overlay') || 
                el.classList.contains('site-footer') ||
                el.tagName === 'HEADER' || 
                el.tagName === 'FOOTER') {
                return false;
            }
            
            const style = window.getComputedStyle(el);
            if (style.display === 'none' || style.visibility === 'hidden' || style.opacity === '0') return false;
            
            const rect = el.getBoundingClientRect();
            if (rect.height === 0) return false;
            
            if (el.tagName === 'P' && el.innerHTML.replace(/&nbsp;|\s|<br\s*\/?>/g, '') === '') return false;
            
            return true;
        }

        function hasContentAbove(wrapper) {
            let element = wrapper.closest('.wp-block-gw-scrollytelling-container, .wp-block-gw-scrollytelling-twocol-container') || wrapper;
            let current = element;
            while (current && current.tagName !== 'BODY') {
                let prev = current.previousElementSibling;
                while (prev) {
                    if (isVisibleContent(prev)) return true;
                    prev = prev.previousElementSibling;
                }
                current = current.parentElement;
            }
            return false;
        }

        function hasContentBelow(wrapper) {
            let element = wrapper.closest('.wp-block-gw-scrollytelling-container, .wp-block-gw-scrollytelling-twocol-container') || wrapper;
            let current = element;
            while (current && current.tagName !== 'BODY') {
                let next = current.nextElementSibling;
                while (next) {
                    if (isVisibleContent(next)) return true;
                    next = next.nextElementSibling;
                }
                current = current.parentElement;
            }
            return false;
        }

        let anyAtTop = false;
        let anyAtBottom = false;

        wrappers.forEach(wrapper => {
            const atTop = !hasContentAbove(wrapper);
            const atBottom = !hasContentBelow(wrapper);

            if (atTop) {
                wrapper.classList.add('is-at-top');
                anyAtTop = true;
            } else {
                wrapper.classList.remove('is-at-top');
            }

            if (atBottom) {
                wrapper.classList.add('is-at-bottom');
                anyAtBottom = true;
            } else {
                wrapper.classList.remove('is-at-bottom');
            }
        });

        const body = document.body;
        if (anyAtTop) {
            body.classList.add('has-scrolly-at-top');
        } else {
            body.classList.remove('has-scrolly-at-top');
        }

        if (anyAtBottom) {
            body.classList.add('has-scrolly-at-bottom');
        } else {
            body.classList.remove('has-scrolly-at-bottom');
        }
    }

    // Run placement detection immediately
    detectScrollytellingPlacement();

    // ── Scroll-Based Scrollytelling Active Step Logic ────────────────────────
    function updateScrollytelling() {
        const triggerLine = window.innerHeight * 0.5;
        const isMobile = window.innerWidth <= 1024;

        // 1. Single-Column Scrollytelling
        const singleContainers = document.querySelectorAll('.scrollytelling-wrapper:not(.twocol-scrolly)');
        singleContainers.forEach(wrapper => {
            const steps = wrapper.querySelectorAll('.scroll-step');
            if (steps.length === 0) return;

            // Find active step based on trigger line
            let activeStepNum = 1;
            for (let i = 0; i < steps.length; i++) {
                const step = steps[i];
                const rect = step.getBoundingClientRect();
                if (rect.top <= triggerLine) {
                    activeStepNum = parseInt(step.getAttribute('data-step'), 10);
                }
            }

            // Update step content boxes
            steps.forEach(step => {
                const contentBox = step.querySelector('.step-content-box');
                const stepNum = parseInt(step.getAttribute('data-step'), 10);
                if (contentBox) {
                    if (stepNum === activeStepNum) {
                        contentBox.classList.add('is-active');
                    } else {
                        contentBox.classList.remove('is-active');
                    }
                }
            });

            // Update background images
            const bgWrappers = wrapper.querySelectorAll('.scroll-bg-wrapper');
            bgWrappers.forEach(bg => {
                const stepNum = parseInt(bg.getAttribute('data-step'), 10);
                if (stepNum === activeStepNum) {
                    bg.classList.add('is-active');
                } else {
                    bg.classList.remove('is-active');
                }
            });
        });

        // 2. Two-Column Scrollytelling
        const twocolContainers = document.querySelectorAll('.scrollytelling-wrapper.twocol-scrolly');
        twocolContainers.forEach(wrapper => {
            const columns = wrapper.querySelectorAll('.twocol-step-column');
            if (columns.length === 0) return;

            let activeStepNum = 1;
            let activeIsLeft = true;
            let activeCol = columns[0];

            if (isMobile) {
                // Mobile: Find active column based on trigger line
                for (let i = 0; i < columns.length; i++) {
                    const col = columns[i];
                    const rect = col.getBoundingClientRect();
                    if (rect.top <= triggerLine) {
                        activeCol = col;
                    }
                }
                const activeStep = activeCol.closest('.twocol-step');
                if (activeStep) {
                    activeStepNum = parseInt(activeStep.getAttribute('data-step'), 10);
                }
                activeIsLeft = activeCol.classList.contains('left-step-column');
            } else {
                // Desktop: Find active step based on trigger line checking the step containers
                const steps = wrapper.querySelectorAll('.twocol-step');
                if (steps.length > 0) {
                    for (let i = 0; i < steps.length; i++) {
                        const step = steps[i];
                        const rect = step.getBoundingClientRect();
                        if (rect.top <= triggerLine) {
                            activeStepNum = parseInt(step.getAttribute('data-step'), 10);
                        }
                    }
                }
            }

            // Update columns and content boxes
            columns.forEach(col => {
                const contentBox = col.querySelector('.step-content-box');
                const colStep = col.closest('.twocol-step');
                if (!colStep) return;
                const colStepNum = parseInt(colStep.getAttribute('data-step'), 10);

                if (contentBox) {
                    if (isMobile) {
                        // Mobile: only the single active column's content box is active
                        if (col === activeCol) {
                            contentBox.classList.add('is-active');
                        } else {
                            contentBox.classList.remove('is-active');
                        }
                    } else {
                        // Desktop: both columns of the active step are active
                        if (colStepNum === activeStepNum) {
                            contentBox.classList.add('is-active');
                        } else {
                            contentBox.classList.remove('is-active');
                        }
                    }
                }
            });

            // Update background columns and image wrappers
            const leftBg = wrapper.querySelector('.twocol-bg-grid .left-bg-column');
            const rightBg = wrapper.querySelector('.twocol-bg-grid .right-bg-column');

            if (leftBg && rightBg) {
                if (isMobile) {
                    // Mobile: toggle which column panel is on top
                    if (activeIsLeft) {
                        leftBg.classList.add('is-column-active');
                        rightBg.classList.remove('is-column-active');
                    } else {
                        rightBg.classList.add('is-column-active');
                        leftBg.classList.remove('is-column-active');
                    }

                    // Mobile: activate the current step's image in the active column
                    const activeBgColumn = activeIsLeft ? leftBg : rightBg;
                    const activeBgWrappers = activeBgColumn.querySelectorAll('.scroll-bg-wrapper');
                    activeBgWrappers.forEach(bg => {
                        const stepNum = parseInt(bg.getAttribute('data-step'), 10);
                        if (stepNum === activeStepNum) {
                            bg.classList.add('is-active');
                        } else {
                            bg.classList.remove('is-active');
                        }
                    });
                } else {
                    // Desktop: both background columns are side-by-side. Just make sure the correct step image is active in both columns.
                    const bgWrappers = wrapper.querySelectorAll('.scroll-bg-wrapper');
                    bgWrappers.forEach(bg => {
                        const stepNum = parseInt(bg.getAttribute('data-step'), 10);
                        if (stepNum === activeStepNum) {
                            bg.classList.add('is-active');
                        } else {
                            bg.classList.remove('is-active');
                        }
                    });
                }
            }
        });
    }

    // ── Column Filler Photo Parallax ──────────────────────────────
    function updateColumnFillers() {
        const fillers = document.querySelectorAll('.gw-column-window-photo');
        fillers.forEach(filler => {
            const rect = filler.getBoundingClientRect();
            // Store coordinates as CSS variables for viewport-fixed alignment
            filler.style.setProperty('--col-left', rect.left + 'px');
            filler.style.setProperty('--col-width', rect.width + 'px');
        });
    }

    // Initialize states on load
    updateScrollytelling();
    updateColumnFillers();

    function sendFrontendDebugInfo() {
        const fillers = document.querySelectorAll('.gw-column-window-photo');
        if (fillers.length === 0) return;

        let debugText = 'URL: ' + window.location.href + ' | Screen: ' + window.innerWidth + 'x' + window.innerHeight + '\n';
        fillers.forEach((filler, idx) => {
            const img = filler.querySelector('.gw-column-window-parallax-img');
            const col = filler.closest('.wp-block-column');
            const row = filler.closest('.wp-block-columns');
            const rowStyle = row ? window.getComputedStyle(row) : null;
            const colStyle = col ? window.getComputedStyle(col) : null;
            const fillerStyle = window.getComputedStyle(filler);
            const imgStyle = img ? window.getComputedStyle(img) : null;

            debugText += `Block #${idx + 1}:\n`;
            if (row) {
                debugText += `- Row: class="${row.className}" display="${rowStyle ? rowStyle.display : 'N/A'}" align="${rowStyle ? rowStyle.alignItems : 'N/A'}" height=${row.offsetHeight}px\n`;
                const cols = row.querySelectorAll('.wp-block-column');
                cols.forEach((c, cIdx) => {
                    const cStyle = window.getComputedStyle(c);
                    debugText += `  - Col #${cIdx + 1}: class="${c.className}" basis="${cStyle.flexBasis}" display="${cStyle.display}" height=${c.offsetHeight}px (scrollH=${c.scrollHeight}px)\n`;
                });
            }
            if (col) {
                debugText += `- Col Children Heights:\n`;
                Array.from(col.children).forEach(child => {
                    debugText += `  - <${child.tagName.toLowerCase()}> class="${child.className}" h=${child.offsetHeight}px (top=${child.offsetTop}px)\n`;
                });
            }
            debugText += `- Container: height=${filler.offsetHeight}px display=${fillerStyle.display} position=${fillerStyle.position} bg=${fillerStyle.backgroundColor}\n`;
            if (img) {
                debugText += `- Img: src="${img.src}" natW=${img.naturalWidth} natH=${img.naturalHeight} w=${img.offsetWidth}px h=${img.offsetHeight}px op=${imgStyle ? imgStyle.opacity : 'N/A'} vis=${imgStyle ? imgStyle.visibility : 'N/A'} tf=${imgStyle ? imgStyle.transform : 'N/A'}\n`;
            } else {
                debugText += `- Img: NOT FOUND\n`;
            }
        });

        fetch('/wp-json/gw/v1/frontend-debug', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                debug_data: debugText
            })
        }).catch(err => console.error('Debug send failed', err));
    }

    // Bind scroll, resize, and load events with requestAnimationFrame throttling
    let scrollTimeout;
    window.addEventListener('scroll', function() {
        if (!scrollTimeout) {
            window.requestAnimationFrame(function() {
                updateScrollytelling();
                scrollTimeout = false;
            });
            scrollTimeout = true;
        }
    });
    window.addEventListener('resize', function() {
        updateScrollytelling();
        updateColumnFillers();
        detectScrollytellingPlacement();
    });
    window.addEventListener('load', function() {
        updateScrollytelling();
        updateColumnFillers();
        detectScrollytellingPlacement();
    });

    // Send debug info 1 second after DOMContentLoaded
    setTimeout(sendFrontendDebugInfo, 1000);

});

