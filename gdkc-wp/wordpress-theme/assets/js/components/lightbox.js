/**
 * Good Dogz KC Lightbox Component
 * 
 * A lightweight, accessible image lightbox/gallery implementation
 */

(function() {
    'use strict';
    
    // Lightbox state
    let currentGallery = [];
    let currentIndex = 0;
    let isLoading = false;
    
    // Lightbox elements
    let lightbox;
    let lightboxContent;
    let lightboxImage;
    let lightboxCaption;
    let lightboxCounter;
    let lightboxClose;
    let lightboxPrev;
    let lightboxNext;
    let lightboxLoader;
    
    // Create lightbox element if it doesn't exist
    function createLightbox() {
        if (document.getElementById('gdkc-lightbox')) {
            return;
        }
        
        lightbox = document.createElement('div');
        lightbox.id = 'gdkc-lightbox';
        lightbox.className = 'gdkc-lightbox';
        lightbox.setAttribute('role', 'dialog');
        lightbox.setAttribute('aria-modal', 'true');
        lightbox.setAttribute('aria-label', 'Image lightbox');
        
        // Create structure
        lightbox.innerHTML = `
            <div class="gdkc-lightbox-content">
                <button type="button" class="gdkc-lightbox-close" aria-label="Close lightbox">&times;</button>
                <img class="gdkc-lightbox-image" src="" alt="" />
                <div class="gdkc-lightbox-caption"></div>
                <div class="gdkc-lightbox-counter"></div>
                <button type="button" class="gdkc-lightbox-prev" aria-label="Previous image">&larr;</button>
                <button type="button" class="gdkc-lightbox-next" aria-label="Next image">&rarr;</button>
                <div class="gdkc-lightbox-loader"></div>
            </div>
        `;
        
        // Cache elements
        lightboxContent = lightbox.querySelector('.gdkc-lightbox-content');
        lightboxImage = lightbox.querySelector('.gdkc-lightbox-image');
        lightboxCaption = lightbox.querySelector('.gdkc-lightbox-caption');
        lightboxCounter = lightbox.querySelector('.gdkc-lightbox-counter');
        lightboxClose = lightbox.querySelector('.gdkc-lightbox-close');
        lightboxPrev = lightbox.querySelector('.gdkc-lightbox-prev');
        lightboxNext = lightbox.querySelector('.gdkc-lightbox-next');
        lightboxLoader = lightbox.querySelector('.gdkc-lightbox-loader');
        
        // Add event listeners
        lightboxClose.addEventListener('click', closeLightbox);
        lightboxPrev.addEventListener('click', showPrevImage);
        lightboxNext.addEventListener('click', showNextImage);
        lightbox.addEventListener('click', function(event) {
            if (event.target === lightbox) {
                closeLightbox();
            }
        });
        
        // Add keyboard navigation
        document.addEventListener('keydown', handleKeyboardNavigation);
        
        // Add touch navigation
        let touchStartX = 0;
        let touchEndX = 0;
        
        lightbox.addEventListener('touchstart', function(event) {
            touchStartX = event.changedTouches[0].screenX;
        }, false);
        
        lightbox.addEventListener('touchend', function(event) {
            touchEndX = event.changedTouches[0].screenX;
            handleSwipe();
        }, false);
        
        function handleSwipe() {
            const swipeThreshold = 50;
            if (touchEndX < touchStartX - swipeThreshold) {
                // Swipe left (next)
                showNextImage();
            } else if (touchEndX > touchStartX + swipeThreshold) {
                // Swipe right (prev)
                showPrevImage();
            }
        }
        
        // Add to document
        document.body.appendChild(lightbox);
    }
    
    // Initialize lightbox and gallery
    function initLightbox() {
        // Create lightbox if it doesn't exist
        createLightbox();
        
        // Find all galleries
        const galleries = document.querySelectorAll('.gdkc-gallery');
        
        galleries.forEach(gallery => {
            const galleryItems = gallery.querySelectorAll('.gdkc-gallery-item');
            
            galleryItems.forEach((item, index) => {
                item.addEventListener('click', function(event) {
                    event.preventDefault();
                    
                    // Build gallery array from this gallery
                    currentGallery = [];
                    galleryItems.forEach(galleryItem => {
                        currentGallery.push({
                            src: galleryItem.getAttribute('href') || galleryItem.getAttribute('data-src'),
                            caption: galleryItem.getAttribute('data-caption') || '',
                            alt: galleryItem.querySelector('img')?.getAttribute('alt') || ''
                        });
                    });
                    
                    // Open lightbox with clicked image
                    currentIndex = index;
                    openLightbox(currentGallery[currentIndex]);
                });
            });
        });
        
        // Find single lightbox items not in galleries
        const singleItems = document.querySelectorAll('.gdkc-lightbox-item:not(.gdkc-gallery .gdkc-lightbox-item)');
        
        singleItems.forEach(item => {
            item.addEventListener('click', function(event) {
                event.preventDefault();
                
                // Create a single-item gallery
                currentGallery = [{
                    src: item.getAttribute('href') || item.getAttribute('data-src'),
                    caption: item.getAttribute('data-caption') || '',
                    alt: item.querySelector('img')?.getAttribute('alt') || ''
                }];
                
                // Open lightbox
                currentIndex = 0;
                openLightbox(currentGallery[0]);
            });
        });
    }
    
    // Open lightbox with a specific image
    function openLightbox(item) {
        if (!lightbox) {
            createLightbox();
        }
        
        // Show loading indicator
        showLoading(true);
        
        // Reset image
        lightboxImage.src = '';
        lightboxImage.alt = '';
        
        // Load the new image
        const img = new Image();
        
        img.onload = function() {
            // Hide loading indicator
            showLoading(false);
            
            // Update image
            lightboxImage.src = item.src;
            lightboxImage.alt = item.alt;
            
            // Update caption
            lightboxCaption.textContent = item.caption;
            
            // Show/hide navigation based on gallery length
            if (currentGallery.length <= 1) {
                lightboxPrev.style.display = 'none';
                lightboxNext.style.display = 'none';
                lightboxCounter.style.display = 'none';
            } else {
                lightboxPrev.style.display = '';
                lightboxNext.style.display = '';
                lightboxCounter.style.display = '';
                lightboxCounter.textContent = `${currentIndex + 1} / ${currentGallery.length}`;
            }
            
            // Show lightbox
            lightbox.classList.add('is-active');
            
            // Prevent page scrolling
            document.body.style.overflow = 'hidden';
            
            // Set focus on the lightbox for accessibility
            lightboxContent.focus();
            
            // Trigger custom event
            const event = new CustomEvent('gdkc.lightbox.opened', {
                detail: { index: currentIndex, gallery: currentGallery }
            });
            document.dispatchEvent(event);
        };
        
        img.onerror = function() {
            // Hide loading indicator
            showLoading(false);
            
            // Show error message
            lightboxImage.src = '';
            lightboxImage.alt = 'Image failed to load';
            lightboxCaption.textContent = 'Error: Image failed to load';
            
            // Show lightbox
            lightbox.classList.add('is-active');
        };
        
        // Start loading the image
        img.src = item.src;
    }
    
    // Close the lightbox
    function closeLightbox() {
        lightbox.classList.remove('is-active');
        
        // Re-enable page scrolling
        document.body.style.overflow = '';
        
        // Clear image to prevent continued loading
        setTimeout(() => {
            lightboxImage.src = '';
        }, 300);
        
        // Trigger custom event
        const event = new CustomEvent('gdkc.lightbox.closed');
        document.dispatchEvent(event);
    }
    
    // Show next image
    function showNextImage() {
        if (isLoading || currentGallery.length <= 1) return;
        
        currentIndex = (currentIndex + 1) % currentGallery.length;
        openLightbox(currentGallery[currentIndex]);
    }
    
    // Show previous image
    function showPrevImage() {
        if (isLoading || currentGallery.length <= 1) return;
        
        currentIndex = (currentIndex - 1 + currentGallery.length) % currentGallery.length;
        openLightbox(currentGallery[currentIndex]);
    }
    
    // Handle keyboard navigation
    function handleKeyboardNavigation(event) {
        if (!lightbox.classList.contains('is-active')) return;
        
        if (event.key === 'Escape') {
            // Close on ESC
            closeLightbox();
        } else if (event.key === 'ArrowRight') {
            // Next on right arrow
            showNextImage();
        } else if (event.key === 'ArrowLeft') {
            // Previous on left arrow
            showPrevImage();
        }
    }
    
    // Show/hide loading indicator
    function showLoading(show) {
        isLoading = show;
        lightboxLoader.style.display = show ? 'block' : 'none';
    }
    
    // Public API
    window.GDKC = window.GDKC || {};
    window.GDKC.Lightbox = {
        init: initLightbox,
        open: function(src, caption, alt) {
            currentGallery = [{
                src: src,
                caption: caption || '',
                alt: alt || ''
            }];
            currentIndex = 0;
            openLightbox(currentGallery[0]);
        },
        close: closeLightbox
    };
    
    // Initialize on DOMContentLoaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initLightbox);
    } else {
        initLightbox();
    }
})();