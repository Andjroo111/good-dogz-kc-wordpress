/**
 * Mobile Menu Solution for Good Dogz KC
 * 
 * This is a clean implementation of the mobile menu with no hamburger animation.
 * It includes:
 * 1. A simple hamburger button with three lines
 * 2. A sliding menu panel that comes in from the right
 * 3. A darkened overlay background
 * 4. A close button inside the menu
 * 
 * The implementation prevents the page from scrolling when the menu is open,
 * and allows users to close the menu by:
 * - Clicking the X button
 * - Clicking outside the menu on the overlay
 * - Pressing the Escape key
 */

document.addEventListener('DOMContentLoaded', function() {
    // Get menu elements
    const menuToggle = document.querySelector('.menu-toggle');
    const mobileMenu = document.querySelector('.mobile-menu');
    const menuOverlay = document.querySelector('.menu-overlay');
    const closeButton = document.querySelector('.mobile-menu-close');
    
    // Function to open the menu - no hamburger animation
    function openMenu() {
        mobileMenu.classList.add('active');
        menuOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    
    // Function to close the menu
    function closeMenu() {
        mobileMenu.classList.remove('active');
        menuOverlay.classList.remove('active');
        document.body.style.overflow = '';
    }
    
    // Add event listeners
    if (menuToggle) {
        menuToggle.addEventListener('click', openMenu);
    }
    
    if (closeButton) {
        closeButton.addEventListener('click', closeMenu);
    }
    
    if (menuOverlay) {
        menuOverlay.addEventListener('click', closeMenu);
    }
    
    // Close menu with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && mobileMenu.classList.contains('active')) {
            closeMenu();
        }
    });
});