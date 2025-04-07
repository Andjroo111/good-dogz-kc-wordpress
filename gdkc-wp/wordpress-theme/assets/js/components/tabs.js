/**
 * Good Dogz KC Tabs Component
 * 
 * A lightweight, accessible tab implementation
 */

(function() {
    'use strict';

    // Initialize tabs
    function initTabs() {
        const tabContainers = document.querySelectorAll('.gdkc-tabs');
        
        tabContainers.forEach(container => {
            const tabButtons = container.querySelectorAll('.gdkc-tab');
            const tabPanels = container.querySelectorAll('.gdkc-tab-panel');
            
            // Set up proper accessibility attributes
            setupTabAccessibility(container, tabButtons, tabPanels);
            
            // Add click event listeners to tab buttons
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-tab');
                    activateTab(container, targetId);
                });
                
                // Add keyboard navigation
                button.addEventListener('keydown', function(e) {
                    handleTabKeyboardNavigation(e, container, tabButtons);
                });
            });
            
            // Activate the first tab by default if none are active
            if (!container.querySelector('.gdkc-tab.active')) {
                const firstTabId = tabButtons[0]?.getAttribute('data-tab');
                if (firstTabId) {
                    activateTab(container, firstTabId);
                }
            }
        });
        
        // Check if URL contains a tab hash and activate that tab
        checkUrlHash();
        
        // Listen for hash changes
        window.addEventListener('hashchange', checkUrlHash);
    }
    
    // Set up accessibility attributes
    function setupTabAccessibility(container, tabButtons, tabPanels) {
        // Create a unique ID for the tablist if not present
        const tablistId = container.id || `gdkc-tabs-${Math.floor(Math.random() * 10000)}`;
        container.id = tablistId;
        
        // Set tablist role on nav
        const tabNav = container.querySelector('.gdkc-tabs-nav');
        tabNav.setAttribute('role', 'tablist');
        
        // Set tab roles and attributes
        tabButtons.forEach((button, index) => {
            const tabId = button.getAttribute('data-tab');
            const panelId = tabId;
            const isActive = button.classList.contains('active');
            
            // Set button attributes
            button.setAttribute('role', 'tab');
            button.setAttribute('id', `tab-${tabId}`);
            button.setAttribute('aria-selected', isActive ? 'true' : 'false');
            button.setAttribute('aria-controls', panelId);
            button.setAttribute('tabindex', isActive ? '0' : '-1');
            
            // Find corresponding panel
            const panel = container.querySelector(`#${panelId}`);
            if (panel) {
                panel.setAttribute('role', 'tabpanel');
                panel.setAttribute('aria-labelledby', `tab-${tabId}`);
                panel.setAttribute('tabindex', '0');
                
                if (!isActive) {
                    panel.setAttribute('hidden', '');
                }
            }
        });
    }
    
    // Activate a specific tab
    function activateTab(container, tabId) {
        const tabButtons = container.querySelectorAll('.gdkc-tab');
        const tabPanels = container.querySelectorAll('.gdkc-tab-panel');
        
        // Deactivate all tabs
        tabButtons.forEach(button => {
            button.classList.remove('active');
            button.setAttribute('aria-selected', 'false');
            button.setAttribute('tabindex', '-1');
        });
        
        tabPanels.forEach(panel => {
            panel.classList.remove('active');
            panel.setAttribute('hidden', '');
        });
        
        // Activate selected tab
        const activeButton = container.querySelector(`.gdkc-tab[data-tab="${tabId}"]`);
        const activePanel = container.querySelector(`#${tabId}`);
        
        if (activeButton && activePanel) {
            activeButton.classList.add('active');
            activeButton.setAttribute('aria-selected', 'true');
            activeButton.setAttribute('tabindex', '0');
            activeButton.focus();
            
            activePanel.classList.add('active');
            activePanel.removeAttribute('hidden');
            
            // Trigger custom event
            const event = new CustomEvent('gdkc.tab.changed', {
                detail: { tabId, container }
            });
            document.dispatchEvent(event);
        }
    }
    
    // Handle keyboard navigation
    function handleTabKeyboardNavigation(event, container, tabButtons) {
        const key = event.key;
        const isVertical = container.classList.contains('gdkc-tabs--vertical');
        const currentIndex = Array.from(tabButtons).findIndex(tab => tab === document.activeElement);
        
        // Don't do anything if we couldn't find the current tab
        if (currentIndex === -1) return;
        
        let newIndex;
        
        // Handle arrow navigation based on tab orientation
        if ((isVertical && key === 'ArrowUp') || (!isVertical && key === 'ArrowLeft')) {
            // Previous tab
            newIndex = currentIndex > 0 ? currentIndex - 1 : tabButtons.length - 1;
            event.preventDefault();
        } else if ((isVertical && key === 'ArrowDown') || (!isVertical && key === 'ArrowRight')) {
            // Next tab
            newIndex = currentIndex < tabButtons.length - 1 ? currentIndex + 1 : 0;
            event.preventDefault();
        } else if (key === 'Home') {
            // First tab
            newIndex = 0;
            event.preventDefault();
        } else if (key === 'End') {
            // Last tab
            newIndex = tabButtons.length - 1;
            event.preventDefault();
        } else {
            // Not an arrow key we handle
            return;
        }
        
        // Activate the new tab
        const targetId = tabButtons[newIndex].getAttribute('data-tab');
        activateTab(container, targetId);
    }
    
    // Check URL hash for tab activation
    function checkUrlHash() {
        if (window.location.hash) {
            const hash = window.location.hash.substring(1); // remove the #
            const targetButton = document.querySelector(`.gdkc-tab[data-tab="${hash}"]`);
            
            if (targetButton) {
                const container = targetButton.closest('.gdkc-tabs');
                if (container) {
                    activateTab(container, hash);
                    
                    // Scroll to the tab container
                    setTimeout(() => {
                        container.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }, 100);
                }
            }
        }
    }
    
    // Public API
    window.GDKC = window.GDKC || {};
    window.GDKC.Tabs = {
        init: initTabs,
        activate: function(containerId, tabId) {
            const container = document.getElementById(containerId);
            if (container) {
                activateTab(container, tabId);
            }
        }
    };
    
    // Initialize on DOMContentLoaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initTabs);
    } else {
        initTabs();
    }
})();