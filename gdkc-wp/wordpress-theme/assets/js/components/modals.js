/**
 * Good Dogz KC Modal Component
 * 
 * A lightweight, accessible modal implementation
 */

(function() {
    'use strict';

    // Store active modal for handling keyboard and focus management
    let activeModal = null;
    let lastFocusedElement = null;
    
    // Modal focus trap elements
    const createFocusTrap = () => {
        const startTrap = document.createElement('div');
        startTrap.tabIndex = 0;
        startTrap.className = 'gdkc-focus-trap';
        startTrap.setAttribute('aria-hidden', 'true');
        
        const endTrap = document.createElement('div');
        endTrap.tabIndex = 0;
        endTrap.className = 'gdkc-focus-trap';
        endTrap.setAttribute('aria-hidden', 'true');
        
        return { startTrap, endTrap };
    };
    
    // Initialize modals
    function initModals() {
        // Set up open triggers
        const openTriggers = document.querySelectorAll('[data-modal-open]');
        openTriggers.forEach(trigger => {
            trigger.addEventListener('click', function(event) {
                event.preventDefault();
                const modalId = this.getAttribute('data-modal-open');
                openModal(modalId);
            });
        });
        
        // Set up close triggers
        const closeTriggers = document.querySelectorAll('[data-modal-close]');
        closeTriggers.forEach(trigger => {
            trigger.addEventListener('click', function(event) {
                event.preventDefault();
                const modal = this.closest('.gdkc-modal');
                if (modal) {
                    closeModal(modal.id);
                }
            });
        });
        
        // Configure modals with proper attributes and focus traps
        const modals = document.querySelectorAll('.gdkc-modal');
        modals.forEach(modal => {
            // Set modal attributes for accessibility
            modal.setAttribute('role', 'dialog');
            modal.setAttribute('aria-modal', 'true');
            modal.setAttribute('aria-hidden', 'true');
            
            const title = modal.querySelector('.gdkc-modal-title');
            if (title) {
                const titleId = title.id || `modal-title-${modal.id}`;
                title.id = titleId;
                modal.setAttribute('aria-labelledby', titleId);
            }
            
            // Add focus traps
            const { startTrap, endTrap } = createFocusTrap();
            modal.prepend(startTrap);
            modal.append(endTrap);
            
            // Set up focus trapping
            startTrap.addEventListener('focus', () => {
                const focusableElements = getFocusableElements(modal);
                if (focusableElements.length > 0) {
                    focusableElements[focusableElements.length - 1].focus();
                }
            });
            
            endTrap.addEventListener('focus', () => {
                const focusableElements = getFocusableElements(modal);
                if (focusableElements.length > 0) {
                    focusableElements[0].focus();
                }
            });
            
            // Close when clicking backdrop (outside modal content)
            modal.addEventListener('click', function(event) {
                if (event.target === modal) {
                    closeModal(modal.id);
                }
            });
        });
        
        // Global keyboard listener
        document.addEventListener('keydown', function(event) {
            // Close on ESC key
            if (event.key === 'Escape' && activeModal) {
                closeModal(activeModal.id);
            }
            
            // Trap focus with Tab key
            if (event.key === 'Tab' && activeModal) {
                // Let the focus traps handle this
            }
        });
    }
    
    // Open a modal by ID
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (!modal) return;
        
        // Store last focused element to restore focus when closing
        lastFocusedElement = document.activeElement;
        
        // Set as active modal
        activeModal = modal;
        
        // Show modal
        modal.classList.add('is-active');
        modal.setAttribute('aria-hidden', 'false');
        
        // Prevent body scrolling while modal is open
        document.body.style.overflow = 'hidden';
        
        // Set focus to first focusable element
        setTimeout(() => {
            const focusableElements = getFocusableElements(modal);
            if (focusableElements.length > 0) {
                focusableElements[0].focus();
            }
        }, 50);
        
        // Trigger open event
        const event = new CustomEvent('gdkc.modal.opened', {
            detail: { modalId }
        });
        document.dispatchEvent(event);
    }
    
    // Close a modal by ID
    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (!modal) return;
        
        // Hide modal
        modal.classList.remove('is-active');
        modal.setAttribute('aria-hidden', 'true');
        
        // Re-enable body scrolling
        document.body.style.overflow = '';
        
        // Restore focus
        if (lastFocusedElement) {
            lastFocusedElement.focus();
        }
        
        // Clear active modal
        activeModal = null;
        
        // Trigger close event
        const event = new CustomEvent('gdkc.modal.closed', {
            detail: { modalId }
        });
        document.dispatchEvent(event);
    }
    
    // Helper to get focusable elements
    function getFocusableElements(element) {
        return Array.from(element.querySelectorAll(
            'a[href], button:not([disabled]), input:not([disabled]), ' +
            'select:not([disabled]), textarea:not([disabled]), ' +
            '[tabindex]:not([tabindex="-1"])'
        )).filter(el => !el.classList.contains('gdkc-focus-trap'));
    }
    
    // Public API
    window.GDKC = window.GDKC || {};
    window.GDKC.Modal = {
        init: initModals,
        open: openModal,
        close: closeModal
    };
    
    // Initialize on DOMContentLoaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initModals);
    } else {
        initModals();
    }
})();