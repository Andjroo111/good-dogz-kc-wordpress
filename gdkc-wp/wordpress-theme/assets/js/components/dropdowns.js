/**
 * Good Dogz KC Dropdown Component
 * 
 * A lightweight, accessible dropdown implementation
 */

(function() {
    'use strict';

    // Keep track of active dropdowns
    let activeDropdown = null;
    
    // Initialize dropdowns
    function initDropdowns() {
        const dropdownToggleButtons = document.querySelectorAll('.gdkc-dropdown-toggle');
        
        // Set up toggle buttons
        dropdownToggleButtons.forEach(button => {
            const dropdown = button.closest('.gdkc-dropdown');
            const menu = dropdown.querySelector('.gdkc-dropdown-menu');
            
            // Generate IDs if not present
            if (!menu.id) {
                menu.id = `dropdown-${Math.floor(Math.random() * 10000)}`;
            }
            
            // Set up proper accessibility attributes
            button.setAttribute('aria-expanded', 'false');
            button.setAttribute('aria-haspopup', 'true');
            button.setAttribute('aria-controls', menu.id);
            
            // Add click listener to toggle button
            button.addEventListener('click', function(event) {
                event.preventDefault();
                event.stopPropagation();
                
                const isExpanded = this.getAttribute('aria-expanded') === 'true';
                
                // If already open, close it
                if (isExpanded) {
                    closeDropdown(dropdown);
                    return;
                }
                
                // If another dropdown is open, close it first
                if (activeDropdown && activeDropdown !== dropdown) {
                    const activeButton = activeDropdown.querySelector('.gdkc-dropdown-toggle');
                    closeDropdown(activeDropdown);
                }
                
                // Open this dropdown
                openDropdown(dropdown);
            });
            
            // Add listeners to all dropdown items for keyboard navigation
            const dropdownItems = menu.querySelectorAll('.gdkc-dropdown-item');
            dropdownItems.forEach((item, index) => {
                // Add keyboard navigation
                item.addEventListener('keydown', function(event) {
                    handleDropdownKeyboardNavigation(event, dropdown, dropdownItems, index);
                });
            });
        });
        
        // Close active dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (activeDropdown && !activeDropdown.contains(event.target)) {
                closeDropdown(activeDropdown);
            }
        });
        
        // Close active dropdown on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && activeDropdown) {
                const activeButton = activeDropdown.querySelector('.gdkc-dropdown-toggle');
                closeDropdown(activeDropdown);
                activeButton.focus();
            }
        });
    }
    
    // Open dropdown
    function openDropdown(dropdown) {
        const button = dropdown.querySelector('.gdkc-dropdown-toggle');
        const menu = dropdown.querySelector('.gdkc-dropdown-menu');
        
        // Update active dropdown reference
        activeDropdown = dropdown;
        
        // Update attributes and classes
        button.setAttribute('aria-expanded', 'true');
        menu.classList.add('is-active');
        
        // Focus first menu item for keyboard accessibility
        setTimeout(() => {
            const firstItem = menu.querySelector('.gdkc-dropdown-item:not(.disabled)');
            if (firstItem) {
                firstItem.focus();
            }
        }, 10);
        
        // Trigger custom event
        const event = new CustomEvent('gdkc.dropdown.opened', {
            detail: { dropdown }
        });
        document.dispatchEvent(event);
    }
    
    // Close dropdown
    function closeDropdown(dropdown) {
        const button = dropdown.querySelector('.gdkc-dropdown-toggle');
        const menu = dropdown.querySelector('.gdkc-dropdown-menu');
        
        // Clear active dropdown reference
        if (activeDropdown === dropdown) {
            activeDropdown = null;
        }
        
        // Update attributes and classes
        button.setAttribute('aria-expanded', 'false');
        menu.classList.remove('is-active');
        
        // Trigger custom event
        const event = new CustomEvent('gdkc.dropdown.closed', {
            detail: { dropdown }
        });
        document.dispatchEvent(event);
    }
    
    // Handle keyboard navigation
    function handleDropdownKeyboardNavigation(event, dropdown, items, currentIndex) {
        const key = event.key;
        
        let newIndex;
        
        if (key === 'ArrowDown') {
            // Next item
            newIndex = currentIndex < items.length - 1 ? currentIndex + 1 : 0;
            event.preventDefault();
        } else if (key === 'ArrowUp') {
            // Previous item
            newIndex = currentIndex > 0 ? currentIndex - 1 : items.length - 1;
            event.preventDefault();
        } else if (key === 'Home') {
            // First item
            newIndex = 0;
            event.preventDefault();
        } else if (key === 'End') {
            // Last item
            newIndex = items.length - 1;
            event.preventDefault();
        } else if (key === 'Tab' && !event.shiftKey && currentIndex === items.length - 1) {
            // Tabbing from last item should close dropdown
            closeDropdown(dropdown);
            return;
        } else if (key === 'Tab' && event.shiftKey && currentIndex === 0) {
            // Shift+Tab from first item should close dropdown
            closeDropdown(dropdown);
            return;
        } else {
            // Not a navigation key
            return;
        }
        
        // Skip disabled items
        while (items[newIndex].classList.contains('disabled') && newIndex !== currentIndex) {
            newIndex = key === 'ArrowDown' || key === 'Home' ? 
                (newIndex + 1) % items.length : 
                (newIndex - 1 + items.length) % items.length;
        }
        
        // Focus the new item
        items[newIndex].focus();
    }
    
    // Position dropdown based on available space
    function positionDropdown(dropdown) {
        const menu = dropdown.querySelector('.gdkc-dropdown-menu');
        const rect = dropdown.getBoundingClientRect();
        const menuRect = menu.getBoundingClientRect();
        const viewportHeight = window.innerHeight;
        const viewportWidth = window.innerWidth;
        
        // Check if dropdown should open upward
        const spaceBelow = viewportHeight - rect.bottom;
        const spaceAbove = rect.top;
        const needsUpward = spaceBelow < menuRect.height && spaceAbove > menuRect.height;
        
        // Check if dropdown should align right
        const spaceRight = viewportWidth - rect.left;
        const needsRightAlign = spaceRight < menuRect.width;
        
        // Apply positioning classes
        if (needsUpward) {
            dropdown.classList.add('gdkc-dropdown--up');
        } else {
            dropdown.classList.remove('gdkc-dropdown--up');
        }
        
        if (needsRightAlign) {
            dropdown.classList.add('gdkc-dropdown--right');
        } else {
            dropdown.classList.remove('gdkc-dropdown--right');
        }
    }
    
    // Public API
    window.GDKC = window.GDKC || {};
    window.GDKC.Dropdown = {
        init: initDropdowns,
        open: function(dropdownId) {
            const dropdown = document.getElementById(dropdownId);
            if (dropdown) {
                openDropdown(dropdown);
            }
        },
        close: function(dropdownId) {
            const dropdown = document.getElementById(dropdownId);
            if (dropdown) {
                closeDropdown(dropdown);
            }
        },
        toggle: function(dropdownId) {
            const dropdown = document.getElementById(dropdownId);
            if (!dropdown) return;
            
            const button = dropdown.querySelector('.gdkc-dropdown-toggle');
            const isExpanded = button.getAttribute('aria-expanded') === 'true';
            
            if (isExpanded) {
                closeDropdown(dropdown);
            } else {
                openDropdown(dropdown);
            }
        }
    };
    
    // Initialize on DOMContentLoaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initDropdowns);
    } else {
        initDropdowns();
    }
})();