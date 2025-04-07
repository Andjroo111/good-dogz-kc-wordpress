/**
 * Good Dogz KC - WordPress Theme JavaScript
 * This file handles animations, interactions, and dynamic content for the website
 */

document.addEventListener('DOMContentLoaded', function() {
    console.log("DOM fully loaded");
    
    // Debug mobile menu elements
    const menuToggleDebug = document.querySelector('.menu-toggle');
    const mobileMenuDebug = document.querySelector('.mobile-menu');
    console.log('Initial check - Menu toggle found:', menuToggleDebug !== null);
    console.log('Initial check - Mobile menu found:', mobileMenuDebug !== null);
    
    // Add a small delay to ensure all elements are properly loaded and parsed
    setTimeout(function() {
        console.log("Starting component initialization");
        // Initialize all components
        initAnimations();
        initMobileMenu();
        initCounters();
        initBeforeAfterSlider();
        initProgramCards();
        initTestimonialCarousel();
        initFaqAccordion();
        initToastMessages();
        initProgramMatcher();
        initIssueButtons();
        initExpandableStories();
        
        // Initialize new UI components
        initTooltips();
        initModals();
        initTabs();
        initDropdowns();
        initLightbox();
    }, 200);
});

/**
 * Initialize tooltip functionality
 */
function initTooltips() {
    // This component is CSS-only and doesn't require JavaScript initialization
    console.log("Tooltips initialized");
}

/**
 * Initialize modal dialogs
 */
function initModals() {
    // Load external component script
    if (typeof GDKC !== 'undefined' && GDKC.Modal) {
        GDKC.Modal.init();
    } else {
        console.log("Initializing modals without external script");
        
        // Modal triggers
        const modalTriggers = document.querySelectorAll('[data-modal-open]');
        modalTriggers.forEach(trigger => {
            trigger.addEventListener('click', e => {
                e.preventDefault();
                const modalId = trigger.getAttribute('data-modal-open');
                const modal = document.getElementById(modalId);
                
                if (modal) {
                    openModal(modal);
                }
            });
        });
        
        // Modal close buttons
        const closeButtons = document.querySelectorAll('[data-modal-close]');
        closeButtons.forEach(button => {
            button.addEventListener('click', e => {
                e.preventDefault();
                const modal = button.closest('.gdkc-modal');
                
                if (modal) {
                    closeModal(modal);
                }
            });
        });
        
        // Close when clicking outside modal content
        document.addEventListener('click', e => {
            if (e.target.classList.contains('gdkc-modal')) {
                closeModal(e.target);
            }
        });
        
        // Close on ESC key
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') {
                const activeModal = document.querySelector('.gdkc-modal.is-active');
                if (activeModal) {
                    closeModal(activeModal);
                }
            }
        });
        
        function openModal(modal) {
            modal.classList.add('is-active');
            document.body.style.overflow = 'hidden';
        }
        
        function closeModal(modal) {
            modal.classList.remove('is-active');
            document.body.style.overflow = '';
        }
    }
}

/**
 * Initialize tab component
 */
function initTabs() {
    // Load external component script
    if (typeof GDKC !== 'undefined' && GDKC.Tabs) {
        GDKC.Tabs.init();
    } else {
        console.log("Initializing tabs without external script");
        
        const tabContainers = document.querySelectorAll('.gdkc-tabs');
        
        tabContainers.forEach(container => {
            const tabs = container.querySelectorAll('.gdkc-tab');
            const panels = container.querySelectorAll('.gdkc-tab-panel');
            
            // Set initial state if none is active
            if (!container.querySelector('.gdkc-tab.active')) {
                tabs[0]?.classList.add('active');
                panels[0]?.classList.add('active');
            }
            
            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    const target = tab.getAttribute('data-tab');
                    
                    // Deactivate all tabs and panels
                    tabs.forEach(t => t.classList.remove('active'));
                    panels.forEach(p => p.classList.remove('active'));
                    
                    // Activate clicked tab and corresponding panel
                    tab.classList.add('active');
                    container.querySelector(`#${target}`)?.classList.add('active');
                });
            });
        });
    }
}

/**
 * Initialize dropdown component
 */
function initDropdowns() {
    // Load external component script
    if (typeof GDKC !== 'undefined' && GDKC.Dropdown) {
        GDKC.Dropdown.init();
    } else {
        console.log("Initializing dropdowns without external script");
        
        const dropdownToggles = document.querySelectorAll('.gdkc-dropdown-toggle');
        
        dropdownToggles.forEach(toggle => {
            const dropdown = toggle.closest('.gdkc-dropdown');
            const menu = dropdown.querySelector('.gdkc-dropdown-menu');
            
            // Toggle dropdown on click
            toggle.addEventListener('click', e => {
                e.preventDefault();
                e.stopPropagation();
                
                // Close all other open dropdowns
                document.querySelectorAll('.gdkc-dropdown-menu.is-active').forEach(openMenu => {
                    if (openMenu !== menu) {
                        openMenu.classList.remove('is-active');
                        openMenu.closest('.gdkc-dropdown').querySelector('.gdkc-dropdown-toggle').setAttribute('aria-expanded', 'false');
                    }
                });
                
                // Toggle this dropdown
                menu.classList.toggle('is-active');
                toggle.setAttribute('aria-expanded', menu.classList.contains('is-active') ? 'true' : 'false');
            });
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', () => {
            const activeDropdowns = document.querySelectorAll('.gdkc-dropdown-menu.is-active');
            
            activeDropdowns.forEach(menu => {
                menu.classList.remove('is-active');
                menu.closest('.gdkc-dropdown').querySelector('.gdkc-dropdown-toggle').setAttribute('aria-expanded', 'false');
            });
        });
    }
}

/**
 * Initialize lightbox for image galleries
 */
function initLightbox() {
    // Load external component script
    if (typeof GDKC !== 'undefined' && GDKC.Lightbox) {
        GDKC.Lightbox.init();
    } else {
        console.log("Initializing lightbox without external script");
        
        // Find all gallery items
        const galleryItems = document.querySelectorAll('.gdkc-gallery-item');
        
        if (galleryItems.length === 0) return;
        
        // Create lightbox if it doesn't exist
        let lightbox = document.getElementById('gdkc-lightbox');
        
        if (!lightbox) {
            lightbox = document.createElement('div');
            lightbox.id = 'gdkc-lightbox';
            lightbox.className = 'gdkc-lightbox';
            lightbox.innerHTML = `
                <div class="gdkc-lightbox-content">
                    <button class="gdkc-lightbox-close" aria-label="Close">&times;</button>
                    <img class="gdkc-lightbox-image" src="" alt="" />
                    <div class="gdkc-lightbox-caption"></div>
                    <button class="gdkc-lightbox-prev" aria-label="Previous">&larr;</button>
                    <button class="gdkc-lightbox-next" aria-label="Next">&rarr;</button>
                    <div class="gdkc-lightbox-counter"></div>
                </div>
            `;
            document.body.appendChild(lightbox);
        }
        
        // Get lightbox elements
        const lightboxImage = lightbox.querySelector('.gdkc-lightbox-image');
        const lightboxCaption = lightbox.querySelector('.gdkc-lightbox-caption');
        const lightboxClose = lightbox.querySelector('.gdkc-lightbox-close');
        const lightboxPrev = lightbox.querySelector('.gdkc-lightbox-prev');
        const lightboxNext = lightbox.querySelector('.gdkc-lightbox-next');
        const lightboxCounter = lightbox.querySelector('.gdkc-lightbox-counter');
        
        // Lightbox state
        let currentIndex = 0;
        let galleryImages = [];
        
        // Add click handlers to gallery items
        galleryItems.forEach((item, index) => {
            item.addEventListener('click', e => {
                e.preventDefault();
                
                // Build gallery array
                galleryImages = [];
                const gallery = item.closest('.gdkc-gallery');
                const items = gallery.querySelectorAll('.gdkc-gallery-item');
                
                items.forEach(galleryItem => {
                    galleryImages.push({
                        src: galleryItem.getAttribute('href'),
                        caption: galleryItem.getAttribute('data-caption') || '',
                        alt: galleryItem.querySelector('img')?.getAttribute('alt') || ''
                    });
                });
                
                // Open lightbox
                currentIndex = index;
                openLightbox();
            });
        });
        
        // Lightbox close handler
        lightboxClose.addEventListener('click', () => {
            closeLightbox();
        });
        
        // Close when clicking outside the content
        lightbox.addEventListener('click', e => {
            if (e.target === lightbox) {
                closeLightbox();
            }
        });
        
        // Navigation buttons
        lightboxPrev.addEventListener('click', () => {
            navigateGallery(-1);
        });
        
        lightboxNext.addEventListener('click', () => {
            navigateGallery(1);
        });
        
        // Keyboard navigation
        document.addEventListener('keydown', e => {
            if (!lightbox.classList.contains('is-active')) return;
            
            if (e.key === 'Escape') {
                closeLightbox();
            } else if (e.key === 'ArrowLeft') {
                navigateGallery(-1);
            } else if (e.key === 'ArrowRight') {
                navigateGallery(1);
            }
        });
        
        // Open lightbox and show current image
        function openLightbox() {
            updateLightboxContent();
            lightbox.classList.add('is-active');
            document.body.style.overflow = 'hidden';
        }
        
        // Close lightbox
        function closeLightbox() {
            lightbox.classList.remove('is-active');
            document.body.style.overflow = '';
        }
        
        // Navigate through gallery
        function navigateGallery(direction) {
            currentIndex = (currentIndex + direction + galleryImages.length) % galleryImages.length;
            updateLightboxContent();
        }
        
        // Update lightbox content
        function updateLightboxContent() {
            const current = galleryImages[currentIndex];
            
            lightboxImage.src = current.src;
            lightboxImage.alt = current.alt;
            lightboxCaption.textContent = current.caption;
            lightboxCounter.textContent = `${currentIndex + 1} / ${galleryImages.length}`;
            
            // Show/hide navigation based on gallery length
            if (galleryImages.length <= 1) {
                lightboxPrev.style.display = 'none';
                lightboxNext.style.display = 'none';
                lightboxCounter.style.display = 'none';
            } else {
                lightboxPrev.style.display = '';
                lightboxNext.style.display = '';
                lightboxCounter.style.display = '';
            }
        }
    }
}

/**
 * Initialize scroll-triggered animations
 */
function initAnimations() {
    // Set up Intersection Observer for animated sections
    const animatedSections = document.querySelectorAll('.animated-section');
    
    const sectionObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                
                // Animate children with staggered delay if they exist
                const animatedItems = entry.target.querySelectorAll('.animated-item');
                if (animatedItems.length > 0) {
                    animatedItems.forEach((item, index) => {
                        setTimeout(() => {
                            item.classList.add('visible');
                        }, 100 * index);
                    });
                }
                
                // Unobserve after animation to improve performance
                sectionObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15 }); // Trigger when 15% visible
    
    // Observe all animated sections
    animatedSections.forEach(section => {
        sectionObserver.observe(section);
    });
}

/**
 * Initialize mobile menu and desktop navigation functionality
 */
function initMobileMenu() {
    // Enhanced Mobile Menu
    const menuToggle = document.querySelector('.menu-toggle');
    const mobileMenu = document.querySelector('.mobile-menu');
    
    if (menuToggle && mobileMenu) {
        // Create/get menu overlay
        const menuOverlay = document.querySelector('.menu-overlay') || document.createElement('div');
        if (!document.querySelector('.menu-overlay')) {
            menuOverlay.className = 'menu-overlay';
            document.body.appendChild(menuOverlay);
        }
        
        // Find close button
        const closeButton = document.querySelector('.mobile-menu-close');
        
        // Toggle menu function
        const toggleMobileMenu = () => {
            mobileMenu.classList.toggle('active');
            menuOverlay.classList.toggle('active');
            
            if (mobileMenu.classList.contains('active')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        };
        
        // Hamburger click handler
        menuToggle.onclick = function(e) {
            toggleMobileMenu();
            e.preventDefault();
            return false;
        };
        
        // Close button click handler
        if (closeButton) {
            closeButton.onclick = function() {
                toggleMobileMenu();
                return false;
            };
        }
        
        // Overlay click handler
        menuOverlay.onclick = function() {
            toggleMobileMenu();
        };
        
        // Fix for mobile menu dropdowns
        const dropdownToggles = document.querySelectorAll('.mobile-menu .dropdown-toggle');
        
        // Make sure menu items have proper style from the beginning
        document.querySelectorAll('.mobile-menu-item').forEach(item => {
            // Set parent container styles
            item.style.position = 'relative';
            
            // Get the dropdown menu inside this item if it exists
            const dropdownMenu = item.querySelector('.dropdown-menu');
            if (dropdownMenu) {
                // Style dropdown for proper alignment
                dropdownMenu.style.display = 'none';
                dropdownMenu.style.overflow = 'hidden';
                dropdownMenu.style.transition = 'all 0.3s ease';
                dropdownMenu.style.paddingLeft = '15px';
                dropdownMenu.style.marginTop = '5px';
                
                // For non-dropdown subpages, make sure they align correctly
                dropdownMenu.style.position = 'relative';
                dropdownMenu.style.width = '100%';
            }
        });
        
        // Add click handlers for dropdowns
        dropdownToggles.forEach(toggle => {
            const icon = toggle.querySelector('i');
            if (icon) {
                icon.style.transition = 'transform 0.3s ease';
            }
            
            toggle.onclick = function(e) {
                e.preventDefault();
                
                // Get the parent menu item and its dropdown menu
                const parentItem = this.closest('.mobile-menu-item');
                const dropdown = parentItem.querySelector('.dropdown-menu');
                const isActive = parentItem.classList.contains('active');
                
                // First close all other dropdowns
                document.querySelectorAll('.mobile-menu-item.active').forEach(item => {
                    if (item !== parentItem) {
                        item.classList.remove('active');
                        
                        // Find and hide the dropdown
                        const otherDropdown = item.querySelector('.dropdown-menu');
                        if (otherDropdown) {
                            otherDropdown.style.display = 'none';
                        }
                        
                        // Rotate icon back
                        const otherIcon = item.querySelector('.dropdown-toggle i');
                        if (otherIcon) {
                            otherIcon.style.transform = 'rotate(0deg)';
                        }
                    }
                });
                
                // Toggle current dropdown
                parentItem.classList.toggle('active');
                
                if (!isActive) {
                    // Show dropdown
                    dropdown.style.display = 'block';
                    
                    // Rotate chevron
                    if (icon) {
                        icon.style.transform = 'rotate(180deg)';
                    }
                } else {
                    // Hide dropdown
                    dropdown.style.display = 'none';
                    
                    // Rotate chevron back
                    if (icon) {
                        icon.style.transform = 'rotate(0deg)';
                    }
                }
                
                return false;
            };
        });
    }
    
    // Desktop Navigation
    const desktopNav = document.querySelector('.desktop-nav');
    
    if (desktopNav) {
        const desktopDropdowns = desktopNav.querySelectorAll('.dropdown');
        
        // Add keyboard accessibility for desktop navigation dropdowns
        desktopDropdowns.forEach(dropdown => {
            const link = dropdown.querySelector('.dropdown-toggle');
            const menu = dropdown.querySelector('.dropdown-menu');
            const items = menu ? menu.querySelectorAll('.dropdown-item') : [];
            
            if (link && menu) {
                // Toggle dropdown on click as fallback for touch devices
                link.addEventListener('click', (e) => {
                    // Only prevent default if we're showing the menu
                    if (!dropdown.classList.contains('active')) {
                        e.preventDefault();
                    }
                    
                    // Toggle dropdown
                    dropdown.classList.toggle('active');
                    
                    // Close other dropdowns
                    desktopDropdowns.forEach(other => {
                        if (other !== dropdown && other.classList.contains('active')) {
                            other.classList.remove('active');
                        }
                    });
                });
                
                // Handle keyboard navigation
                link.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        dropdown.classList.toggle('active');
                        
                        if (dropdown.classList.contains('active') && items.length > 0) {
                            // Focus first item
                            items[0].focus();
                        }
                    }
                });
                
                // Close when clicking outside
                document.addEventListener('click', (e) => {
                    if (!dropdown.contains(e.target)) {
                        dropdown.classList.remove('active');
                    }
                });
            }
        });
    }
}

/**
 * Initialize animated counters
 */
function initCounters() {
    const counters = document.querySelectorAll('.counter');
    
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                const target = parseInt(counter.getAttribute('data-count'));
                const duration = 2000; // 2 seconds
                const step = Math.ceil(target / (duration / 16)); // 60fps
                
                let current = 0;
                const updateCounter = () => {
                    current += step;
                    if (current > target) current = target;
                    counter.textContent = current;
                    
                    if (current < target) {
                        requestAnimationFrame(updateCounter);
                    }
                };
                
                updateCounter();
                counterObserver.unobserve(counter);
            }
        });
    }, { threshold: 0.5 });
    
    counters.forEach(counter => {
        counterObserver.observe(counter);
    });
}

/**
 * Initialize before/after image slider
 */
function initBeforeAfterSlider() {
    const sliders = document.querySelectorAll('.before-after-slider');
    
    sliders.forEach(slider => {
        const sliderHandle = slider.querySelector('.slider-handle');
        const beforeImage = slider.querySelector('.before-image');
        
        if (!sliderHandle || !beforeImage) return;
        
        // Set initial position
        beforeImage.style.width = '50%';
        sliderHandle.style.left = '50%';
        
        // Handle mouse/touch events
        let isDragging = false;
        
        const startDrag = (e) => {
            isDragging = true;
            slider.classList.add('dragging');
            updateSliderPosition(e);
        };
        
        const endDrag = () => {
            isDragging = false;
            slider.classList.remove('dragging');
        };
        
        const updateSliderPosition = (e) => {
            if (!isDragging) return;
            
            let clientX;
            if (e.type === 'touchmove') {
                clientX = e.touches[0].clientX;
            } else {
                clientX = e.clientX;
            }
            
            const sliderRect = slider.getBoundingClientRect();
            const percentage = Math.max(0, Math.min(100, ((clientX - sliderRect.left) / sliderRect.width) * 100));
            
            beforeImage.style.width = `${percentage}%`;
            sliderHandle.style.left = `${percentage}%`;
        };
        
        // Mouse events
        sliderHandle.addEventListener('mousedown', startDrag);
        document.addEventListener('mouseup', endDrag);
        document.addEventListener('mousemove', updateSliderPosition);
        
        // Touch events
        sliderHandle.addEventListener('touchstart', startDrag);
        document.addEventListener('touchend', endDrag);
        document.addEventListener('touchmove', updateSliderPosition);
    });
}

/**
 * Initialize program cards swiping on mobile
 */
function initProgramCards() {
    const cardContainers = document.querySelectorAll('.swipeable-container');
    
    cardContainers.forEach(container => {
        let startX, currentTranslate = 0, prevTranslate = 0, isDragging = false;
        const cards = container.querySelectorAll('.program-card');
        const cardWidth = cards.length > 0 ? cards[0].offsetWidth + 16 : 0; // Card width + gap
        
        // Touch events for mobile swiping
        container.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
            isDragging = true;
            container.classList.add('dragging');
        });
        
        container.addEventListener('touchmove', (e) => {
            if (!isDragging) return;
            
            const currentX = e.touches[0].clientX;
            const diff = currentX - startX;
            currentTranslate = prevTranslate + diff;
            
            // Limit translation to prevent swiping too far
            const minTranslate = -((cards.length - 1) * cardWidth);
            const maxTranslate = 0;
            currentTranslate = Math.max(minTranslate, Math.min(maxTranslate, currentTranslate));
            
            updateCardsPosition();
        });
        
        container.addEventListener('touchend', () => {
            isDragging = false;
            container.classList.remove('dragging');
            
            // Snap to nearest card
            const cardIndex = Math.round(Math.abs(currentTranslate) / cardWidth);
            currentTranslate = -cardIndex * cardWidth;
            prevTranslate = currentTranslate;
            
            updateCardsPosition();
        });
        
        function updateCardsPosition() {
            container.style.transform = `translateX(${currentTranslate}px)`;
        }
    });
}

/**
 * Initialize testimonial carousel
 */
function initTestimonialCarousel() {
    const carousel = document.querySelector('.testimonial-carousel');
    if (!carousel) return;
    
    const cards = carousel.querySelectorAll('.testimonial-card');
    const totalCards = cards.length;
    let currentIndex = 0;
    
    // Create navigation dots
    const dotsContainer = document.createElement('div');
    dotsContainer.className = 'carousel-dots';
    
    for (let i = 0; i < totalCards; i++) {
        const dot = document.createElement('span');
        dot.className = 'carousel-dot';
        if (i === 0) dot.classList.add('active');
        
        dot.addEventListener('click', () => {
            goToSlide(i);
        });
        
        dotsContainer.appendChild(dot);
    }
    
    carousel.parentNode.appendChild(dotsContainer);
    
    // Create prev/next buttons for desktop
    const prevButton = document.createElement('button');
    prevButton.className = 'carousel-prev';
    prevButton.innerHTML = '<i class="fas fa-chevron-left"></i>';
    prevButton.addEventListener('click', () => {
        goToSlide(currentIndex - 1);
    });
    
    const nextButton = document.createElement('button');
    nextButton.className = 'carousel-next';
    nextButton.innerHTML = '<i class="fas fa-chevron-right"></i>';
    nextButton.addEventListener('click', () => {
        goToSlide(currentIndex + 1);
    });
    
    carousel.parentNode.appendChild(prevButton);
    carousel.parentNode.appendChild(nextButton);
    
    // Handle swipe on mobile
    let startX, isDragging = false;
    
    carousel.addEventListener('touchstart', (e) => {
        startX = e.touches[0].clientX;
        isDragging = true;
    });
    
    carousel.addEventListener('touchmove', (e) => {
        if (!isDragging) return;
    });
    
    carousel.addEventListener('touchend', (e) => {
        if (!isDragging) return;
        
        const endX = e.changedTouches[0].clientX;
        const diff = endX - startX;
        
        if (diff > 50) {
            // Swipe right - go to previous
            goToSlide(currentIndex - 1);
        } else if (diff < -50) {
            // Swipe left - go to next
            goToSlide(currentIndex + 1);
        }
        
        isDragging = false;
    });
    
    function goToSlide(index) {
        // Handle circular navigation
        if (index < 0) index = totalCards - 1;
        if (index >= totalCards) index = 0;
        
        currentIndex = index;
        
        // Update carousel position
        carousel.style.transform = `translateX(-${currentIndex * 100}%)`;
        
        // Update dots
        const dots = dotsContainer.querySelectorAll('.carousel-dot');
        dots.forEach((dot, i) => {
            dot.classList.toggle('active', i === currentIndex);
        });
    }
    
    // Auto-advance carousel
    let interval = setInterval(() => {
        goToSlide(currentIndex + 1);
    }, 5000);
    
    // Pause auto-advance on hover
    carousel.addEventListener('mouseenter', () => {
        clearInterval(interval);
    });
    
    carousel.addEventListener('mouseleave', () => {
        interval = setInterval(() => {
            goToSlide(currentIndex + 1);
        }, 5000);
    });
}

/**
 * Initialize FAQ accordion
 */
function initFaqAccordion() {
    const faqItems = document.querySelectorAll('.faq-item');
    
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        const answer = item.querySelector('.faq-answer');
        
        if (!question || !answer) return;
        
        question.addEventListener('click', () => {
            const isOpen = item.classList.contains('active');
            
            // Close all other items
            faqItems.forEach(otherItem => {
                if (otherItem !== item && otherItem.classList.contains('active')) {
                    otherItem.classList.remove('active');
                    otherItem.querySelector('.faq-answer').style.maxHeight = '0px';
                }
            });
            
            // Toggle current item
            item.classList.toggle('active');
            
            if (!isOpen) {
                answer.style.maxHeight = answer.scrollHeight + 'px';
            } else {
                answer.style.maxHeight = '0px';
            }
        });
    });
}

/**
 * Initialize toast messages
 */
function initToastMessages() {
    // Create toast container if it doesn't exist
    let toastContainer = document.querySelector('.gdkc-toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.className = 'gdkc-toast-container';
        document.body.appendChild(toastContainer);
    }
    
    // Add click event to all toast triggers
    const toastTriggers = document.querySelectorAll('.toast-trigger');
    
    toastTriggers.forEach(trigger => {
        trigger.addEventListener('click', () => {
            const toastType = trigger.getAttribute('data-toast');
            let message = 'Notification message';
            let type = 'info';
            
            // Set message and type based on data-toast attribute
            switch (toastType) {
                case 'anxiety-method':
                    message = 'We use counter-conditioning and desensitization to help dogs overcome anxiety by creating positive associations with triggers.';
                    type = 'info';
                    break;
                case 'aggression-method':
                    message = 'Our aggression protocol focuses on management, trigger identification, and behavior modification to create lasting change.';
                    type = 'info';
                    break;
                case 'leash-method':
                    message = 'We teach loose-leash walking through positive reinforcement and proper equipment selection.';
                    type = 'info';
                    break;
                case 'obedience-method':
                    message = 'Our obedience training uses marker training and positive reinforcement for reliable commands.';
                    type = 'info';
                    break;
                case 'reactivity-method':
                    message = 'We address reactivity through threshold training and systematic desensitization.';
                    type = 'info';
                    break;
                case 'form-success':
                    message = 'Thank you! Your information has been submitted successfully.';
                    type = 'success';
                    break;
                case 'form-error':
                    message = 'There was an error submitting your information. Please try again.';
                    type = 'error';
                    break;
            }
            
            showToast(message, type);
        });
    });
    
    // Function to show toast message
    window.showToast = function(message, type = 'info', duration = 3000) {
        const toast = document.createElement('div');
        toast.className = `gdkc-toast ${type}`;
        toast.textContent = message;
        
        toastContainer.appendChild(toast);
        
        // Trigger reflow to enable transition
        toast.offsetHeight;
        
        // Show toast
        setTimeout(() => {
            toast.classList.add('visible');
        }, 10);
        
        // Hide and remove toast after duration
        setTimeout(() => {
            toast.classList.remove('visible');
            
            // Remove from DOM after transition
            setTimeout(() => {
                toastContainer.removeChild(toast);
            }, 300);
        }, duration);
    };
}

/**
 * Initialize program matcher quiz
 */
function initProgramMatcher() {
    const quizCard = document.querySelector('.quiz-card');
    if (!quizCard) return;
    
    const progressSteps = quizCard.querySelectorAll('.step');
    const questionContainer = quizCard.querySelector('.question-container');
    const nextButton = quizCard.querySelector('.quiz-navigation .gdkc-button');
    const backButton = quizCard.querySelector('.quiz-navigation .gdkc-button-s');
    
    let currentStep = 0;
    const totalSteps = 3;
    const answers = [];
    
    // Questions and options
    const questions = [
        {
            question: "What's your biggest challenge with your dog?",
            options: ["Pulling on leash", "Anxiety/fear", "Aggression", "Basic commands", "Reactivity", "Other"]
        },
        {
            question: "How long have you been experiencing this issue?",
            options: ["Less than 1 month", "1-3 months", "3-6 months", "6-12 months", "Over a year"]
        },
        {
            question: "What's your training goal?",
            options: ["Quick improvement", "Lasting behavior change", "Better relationship", "Specific skill training"]
        }
    ];
    
    // Initialize first question
    renderQuestion(0);
    
    // Next button click
    nextButton.addEventListener('click', () => {
        const selectedOption = questionContainer.querySelector('.option-button.selected');
        
        if (!selectedOption && currentStep < totalSteps) {
            // Show error if no option selected
            showToast('Please select an option to continue', 'warning');
            return;
        }
        
        if (currentStep < totalSteps - 1) {
            // Save answer and go to next question
            answers[currentStep] = selectedOption ? selectedOption.textContent : null;
            currentStep++;
            renderQuestion(currentStep);
        } else if (currentStep === totalSteps - 1) {
            // Save final answer
            answers[currentStep] = selectedOption ? selectedOption.textContent : null;
            
            // Show results
            showQuizResults();
        }
    });
    
    // Back button click
    backButton.addEventListener('click', () => {
        if (currentStep > 0) {
            currentStep--;
            renderQuestion(currentStep);
        }
    });
    
    function renderQuestion(step) {
        // Update progress indicator
        progressSteps.forEach((stepEl, index) => {
            stepEl.classList.toggle('active', index <= step);
        });
        
        // Update back button state
        backButton.classList.toggle('disabled', step === 0);
        
        // Update next button text
        nextButton.textContent = step === totalSteps - 1 ? 'See Results' : 'Next';
        
        // Render question and options
        const question = questions[step];
        
        let optionsHTML = '';
        question.options.forEach(option => {
            const isSelected = answers[step] === option;
            optionsHTML += `
                <button class="option-button ${isSelected ? 'selected' : ''}">
                    ${option}
                </button>
            `;
        });
        
        questionContainer.innerHTML = `
            <h3>${question.question}</h3>
            <div class="options-grid">
                ${optionsHTML}
            </div>
        `;
        
        // Add click handlers to options
        const optionButtons = questionContainer.querySelectorAll('.option-button');
        optionButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Deselect all options
                optionButtons.forEach(btn => btn.classList.remove('selected'));
                // Select clicked option
                button.classList.add('selected');
            });
        });
    }
    
    function showQuizResults() {
        // Determine recommended program based on answers
        let recommendedProgram = '';
        
        // Simple logic for demonstration - in reality, this would be more complex
        if (answers[0] === 'Aggression' || answers[0] === 'Reactivity' || answers[1] === 'Over a year') {
            recommendedProgram = '8-Week Advanced';
        } else if (answers[0] === 'Basic commands' && answers[1] === 'Less than 1 month') {
            recommendedProgram = '4-Week Foundation';
        } else {
            recommendedProgram = '6-Week Transformation';
        }
        
        // Show results
        questionContainer.innerHTML = `
            <div class="quiz-results">
                <h3>Your Recommended Program</h3>
                <div class="recommended-program">
                    <h4>${recommendedProgram}</h4>
                    <p>Based on your answers, we recommend our ${recommendedProgram} program to address your specific needs.</p>
                </div>
                <div class="quiz-actions mt-4">
                    <a href="#training-solutions" class="gdkc-button">View Program Details</a>
                    <button class="gdkc-button-s restart-quiz">Restart Quiz</button>
                </div>
            </div>
        `;
        
        // Update progress and buttons
        progressSteps.forEach(step => step.classList.add('active'));
        nextButton.style.display = 'none';
        backButton.style.display = 'none';
        
        // Add restart handler
        const restartButton = questionContainer.querySelector('.restart-quiz');
        if (restartButton) {
            restartButton.addEventListener('click', () => {
                currentStep = 0;
                answers.length = 0;
                renderQuestion(0);
                nextButton.style.display = 'block';
                backButton.style.display = 'block';
            });
        }
    }
}

/**
 * Initialize issue buttons for problem-solution section
 */
function initIssueButtons() {
    const issueButtons = document.querySelectorAll('.issue-button');
    const issueContents = document.querySelectorAll('.issue-content');
    
    if (issueButtons.length === 0 || issueContents.length === 0) return;
    
    issueButtons.forEach(button => {
        button.addEventListener('click', () => {
            const issueType = button.getAttribute('data-issue');
            
            // Update active button
            issueButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            
            // Show corresponding content
            issueContents.forEach(content => {
                content.classList.remove('active');
                if (content.id === `${issueType}-content`) {
                    content.classList.add('active');
                }
            });
        });
    });
}

/**
 * Initialize expandable success stories
 */
function initExpandableStories() {
    const storyCards = document.querySelectorAll('.story-card.expandable');
    
    storyCards.forEach(card => {
        const expandButton = card.querySelector('.expand-button');
        const collapseButton = card.querySelector('.collapse-button');
        
        if (!expandButton || !collapseButton) return;
        
        expandButton.addEventListener('click', () => {
            card.classList.add('expanded');
        });
        
        collapseButton.addEventListener('click', () => {
            card.classList.remove('expanded');
        });
    });
}
