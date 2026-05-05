/**
 * File: js/main.js
 * Theme: Gary Wallage Wedding Pro
 * Description: Core theme logic for menus, modals, and fidelity.
 * Version: 3000.150.0
 */
(function($) {
    'use strict';

    const initComponents = () => {
        const toggle = document.querySelector('.menu-toggle');
        const close = document.querySelector('.menu-close');
        const overlay = document.getElementById('primary-menu');
        
        if (toggle && overlay) {
            const openMenu = () => { 
                overlay.setAttribute('aria-hidden', 'false'); 
                document.body.style.overflow = 'hidden'; 
            };
            const closeMenu = () => { 
                overlay.setAttribute('aria-hidden', 'true'); 
                document.body.style.overflow = ''; 
            };
            toggle.onclick = (e) => { e.preventDefault(); openMenu(); };
            if (close) close.onclick = (e) => { e.preventDefault(); closeMenu(); };
        }

        // INQUIRY MODAL LOGIC
        const modal = document.getElementById('gw-request-modal');
        const modalForm = document.getElementById('gw-request-form');
        if (modal) {
            document.querySelectorAll('.gw-request-modal-trigger').forEach(btn => {
                btn.onclick = (e) => {
                    e.preventDefault();
                    const service = btn.dataset.service || 'General Inquiry';
                    const modalServiceName = modal.querySelector('.modal-service-name');
                    const modalServiceInput = document.getElementById('modal-service-name-input');
                    
                    if (modalServiceName) modalServiceName.innerText = service;
                    if (modalServiceInput) modalServiceInput.value = service;
                    
                    modal.style.display = 'flex';
                };
            });
            
            const modalClose = modal.querySelector('.gw-modal-close');
            if (modalClose) modalClose.onclick = () => { modal.style.display = 'none'; };
            
            if (modalForm) {
                modalForm.onsubmit = (e) => {
                    e.preventDefault();
                    const status = modalForm.querySelector('.gw-form-status');
                    if (status) status.innerText = 'Sending...';
                    
                    const data = new FormData(modalForm);
                    data.append('action', 'gw_submit_request');
                    
                    fetch('/wp-admin/admin-ajax.php', { method: 'POST', body: data })
                        .then(r => r.json())
                        .then(res => {
                            if (res.success) {
                                if (status) status.innerText = 'Sent successfully!';
                                setTimeout(() => { 
                                    modal.style.display = 'none'; 
                                    modalForm.reset(); 
                                    if (status) status.innerText = ''; 
                                }, 2000);
                            } else {
                                if (status) status.innerText = 'Error: ' + res.data;
                            }
                        });
                };
            }
        }
    };

    const ensureFidelity = () => {
        // Force display of important boutique elements
        document.querySelectorAll('.service-card-ribbon').forEach(el => {
            el.style.setProperty('display', 'block', 'important');
        });
    };

    document.addEventListener('DOMContentLoaded', () => {
        initComponents();
        ensureFidelity();
    });

    // Observer for dynamic content
    const observer = new MutationObserver(ensureFidelity);
    observer.observe(document.documentElement, { childList: true, subtree: true });

})(jQuery);
