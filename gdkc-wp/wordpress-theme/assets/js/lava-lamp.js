/**
 * Good Dogz KC - Lava Lamp Animation
 * This script creates an animated lava lamp effect that can be applied to any container
 * 
 * Usage:
 * 1. Add class "gdkc-lava-container" to the container element
 * 2. Initialize with: document.addEventListener('DOMContentLoaded', initLavaAnimation);
 * 3. Optionally add data attributes to customize:
 *    - data-gdkc-lava-color-outer="#a08cff" (outer color)
 *    - data-gdkc-lava-color-mid="#6a3ad6" (middle color)
 *    - data-gdkc-lava-color-inner="#4b0082" (inner color)
 *    - data-gdkc-lava-bg="#0a0a2a" (background color)
 */

function initLavaAnimation() {
    // Find all containers with the lava animation class
    const lavaContainers = document.querySelectorAll('.gdkc-lava-container');
    
    // Apply animation to each container
    lavaContainers.forEach(container => {
        setupLavaAnimation(container);
    });
}

function setupLavaAnimation(container) {
    // Skip if container is already initialized
    if (container.querySelector('.lava-layer')) return;
    
    // Configuration
    const config = {
        // Blob pool for performance optimization
        blobPool: {
            background: [],
            middle: [],
            foreground: []
        },
        // Base density - blobs per 100px of width
        baseBlobDensity: 1,
        // Color settings - get from data attributes or use defaults
        colors: {
            outerColor: container.dataset.gdkcLavaColorOuter || '#a08cff',     // Light purple (outer gradient color)
            midColor: container.dataset.gdkcLavaColorMid || '#6a3ad6',         // Medium purple (middle gradient color)
            innerColor: container.dataset.gdkcLavaColorInner || '#4b0082',     // Indigo (inner gradient color)
            background: container.dataset.gdkcLavaBg || '#0a0a2a'              // Deep space blue
        },
        // Animation settings
        animation: {
            enabled: true,
            frameId: null
        },
        // Cursor position
        cursor: {
            x: 0,
            y: 0,
            active: false
        },
        // Particle system
        particles: {
            pool: [],
            maxParticles: 40,
            active: []
        }
    };

    // Animation settings
    const animationSettings = {
        cursorAttraction: false,
        parallax: true,
        particles: true,
        blobPop: true
    };

    // Add CSS variables to container
    container.style.setProperty('--primary-color', config.colors.outerColor);
    container.style.setProperty('--primary-color-end', config.colors.midColor);
    container.style.setProperty('--secondary-color', config.colors.innerColor);
    
    // Extract RGB components
    const midRgb = hexToRgb(config.colors.midColor);
    container.style.setProperty('--primary-color-transparent', `${hexToRgba(config.colors.midColor, 0.3)}`);
    container.style.setProperty('--primary-color-rgb', `${midRgb.r}, ${midRgb.g}, ${midRgb.b}`);
    
    // Make sure container has position relative if not already set
    if (getComputedStyle(container).position === 'static') {
        container.style.position = 'relative';
    }
    
    // Make sure container has overflow hidden
    container.style.overflow = 'hidden';

    // Create lava animation structure
    createLavaStructure(container);
    
    // Store DOM elements
    const blobContainerBg = container.querySelector('#dynamic-blobs-background');
    const blobContainerMid = container.querySelector('#dynamic-blobs-middle');
    const blobContainerFg = container.querySelector('#dynamic-blobs-foreground');
    const ambientGlow = container.querySelector('.ambient-glow');
    
    // Create blob layout
    createBlobLayout();
    
    // Handle window resize
    const resizeHandler = debounce(function() {
        createBlobLayout();
    }, 200);
    
    window.addEventListener('resize', resizeHandler);
    
    // Setup cursor tracking
    document.addEventListener('mousemove', function(e) {
        config.cursor.x = e.clientX;
        config.cursor.y = e.clientY;
        config.cursor.active = true;
    });

    document.addEventListener('mouseleave', function() {
        config.cursor.active = false;
    });

    // Handle blob click for pop effect
    container.addEventListener('click', function(e) {
        if (!animationSettings.blobPop) return;
        
        // Create pop effect
        createPopEffect(e.clientX, e.clientY);
    });

    // Initialize scroll effects
    if (animationSettings.parallax) {
        initParallaxEffect();
    }

    // Start animation loop
    startAnimationLoop();

    // Initialize particle system if enabled
    if (animationSettings.particles) {
        initParticleSystem();
    }

    // Create structure for lava animation
    function createLavaStructure(container) {
        // Apply base styles
        const containerStyles = document.createElement('style');
        containerStyles.textContent = `
            .lava-layer {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                overflow: hidden;
            }
            
            .lava-layer-background { z-index: 1; }
            .lava-layer-middle { z-index: 2; }
            .lava-layer-foreground { z-index: 3; }
            
            .lava-container-background {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                filter: blur(20px) contrast(3.8) saturate(1.05);
                opacity: 0.7;
                transform: scale(1.05);
            }
            
            .lava-container-middle {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                filter: blur(12px) contrast(4.2) saturate(1.1);
                opacity: 0.8;
                transform: scale(1.02);
            }
            
            .lava-container-foreground {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                filter: blur(7px) contrast(4.5) saturate(1.15);
                opacity: 0.9;
                transform: translate3d(0, 0, 0);
            }
            
            .ambient-glow {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: radial-gradient(circle at center, var(--primary-color-transparent, rgba(138, 43, 226, 0.1)) 0%, transparent 70%);
                opacity: 0.4;
                z-index: 0;
                transition: background 0.5s ease;
            }
            
            .lava-blob {
                position: absolute;
                background: radial-gradient(
                    circle at 35% 35%, 
                    var(--primary-color, #8A2BE2) 0%, 
                    color-mix(in srgb, var(--primary-color, #8A2BE2) 85%, var(--secondary-color, #4B0082)) 50%,
                    var(--secondary-color, #4B0082) 100%
                );
                transform-origin: center center;
                transition: border-radius 2s ease, transform 0.8s ease-out, opacity 0.8s ease;
                will-change: transform;
                box-shadow: 0 0 18px 5px rgba(var(--primary-color-rgb, 138, 43, 226), 0.12);
                background-blend-mode: normal;
                border-radius: 50%;
                transform: translate(0, 0);
            }
            
            .bg-blob { opacity: 0.8; }
            .middle-blob { opacity: 0.9; }
            .fg-blob { opacity: 1; }
            
            .particle {
                position: absolute;
                border-radius: 50%;
                opacity: 0;
                pointer-events: none;
                filter: blur(1px);
                z-index: 20;
                mix-blend-mode: screen;
            }
            
            .particle-light-purple {
                background-color: #a08cff;
                box-shadow: 0 0 6px #a08cff;
            }
            
            .particle-teal {
                background-color: #07edbe;
                box-shadow: 0 0 6px #07edbe;
            }
            
            .particle-medium-blue {
                background-color: #477ed6;
                box-shadow: 0 0 7px #477ed6;
            }
        `;
        
        document.head.appendChild(containerStyles);
        
        // Create ambient glow
        const ambientGlow = document.createElement('div');
        ambientGlow.className = 'ambient-glow';
        container.appendChild(ambientGlow);
        
        // Background layer (large, slow blobs)
        const bgLayer = document.createElement('div');
        bgLayer.className = 'lava-layer lava-layer-background';
        
        const bgContainer = document.createElement('div');
        bgContainer.className = 'lava-container-background';
        
        const bgBlobs = document.createElement('div');
        bgBlobs.id = 'dynamic-blobs-background';
        
        bgContainer.appendChild(bgBlobs);
        bgLayer.appendChild(bgContainer);
        container.appendChild(bgLayer);
        
        // Middle layer (medium blobs)
        const midLayer = document.createElement('div');
        midLayer.className = 'lava-layer lava-layer-middle';
        
        const midContainer = document.createElement('div');
        midContainer.className = 'lava-container-middle';
        
        const midBlobs = document.createElement('div');
        midBlobs.id = 'dynamic-blobs-middle';
        
        midContainer.appendChild(midBlobs);
        midLayer.appendChild(midContainer);
        container.appendChild(midLayer);
        
        // Foreground layer (small, fast blobs)
        const fgLayer = document.createElement('div');
        fgLayer.className = 'lava-layer lava-layer-foreground';
        
        const fgContainer = document.createElement('div');
        fgContainer.className = 'lava-container-foreground';
        
        const fgBlobs = document.createElement('div');
        fgBlobs.id = 'dynamic-blobs-foreground';
        
        fgContainer.appendChild(fgBlobs);
        fgLayer.appendChild(fgContainer);
        container.appendChild(fgLayer);
    }

    function createBlobLayout() {
        // Create new containers for the new blobs
        const newBgContainer = document.createElement('div');
        const newMidContainer = document.createElement('div');
        const newFgContainer = document.createElement('div');
        
        // Copy styles and setup from the original containers
        newBgContainer.id = 'dynamic-blobs-background-new';
        newMidContainer.id = 'dynamic-blobs-middle-new';
        newFgContainer.id = 'dynamic-blobs-foreground-new';
        
        // Simple container setup without clip-path which might be causing issues
        Object.assign(newBgContainer.style, {
            position: 'absolute',
            top: '0',
            left: '0',
            width: '100%',
            height: '100%',
            overflow: 'hidden'
        });
        
        Object.assign(newMidContainer.style, {
            position: 'absolute',
            top: '0',
            left: '0',
            width: '100%',
            height: '100%',
            overflow: 'hidden'
        });
        
        Object.assign(newFgContainer.style, {
            position: 'absolute',
            top: '0',
            left: '0',
            width: '100%',
            height: '100%',
            overflow: 'hidden'
        });
        
        // Make sure parent containers have proper overflow setting
        container.querySelector('.lava-container-background').style.overflow = 'hidden';
        container.querySelector('.lava-container-middle').style.overflow = 'hidden';
        container.querySelector('.lava-container-foreground').style.overflow = 'hidden';
        
        // Add new containers to the lava layers
        container.querySelector('.lava-container-background').appendChild(newBgContainer);
        container.querySelector('.lava-container-middle').appendChild(newMidContainer);
        container.querySelector('.lava-container-foreground').appendChild(newFgContainer);

        // Store old blob references before creating new ones
        const oldBlobsBg = [...config.blobPool.background];
        const oldBlobsMid = [...config.blobPool.middle];
        const oldBlobsFg = [...config.blobPool.foreground];
        
        // Reset blob pools for new blobs
        config.blobPool.background = [];
        config.blobPool.middle = [];
        config.blobPool.foreground = [];

        // Calculate number of blobs based on screen width
        const width = container.offsetWidth;
        const height = container.offsetHeight;
        
        // Make sure container has sufficient height for the animation
        if (height < 200) {
            container.style.minHeight = '200px';
        }
        
        // Create new blobs in each layer
        
        // Background layer (fewer, larger blobs)
        const bgCount = Math.max(5, Math.floor(width / 320));
        for (let i = 0; i < bgCount; i++) {
            const blob = createBlob('background', {
                minWidth: width * 0.15,
                maxWidth: width * 0.28,
                minHeight: height * 0.4,
                maxHeight: height * 0.7
            });
            
            // Position blobs throughout the container, including at the top
            let startingDepth;
            if (i % 3 === 0) {
                // Some blobs start at the bottom
                startingDepth = -blob.height * 1.2;
            } else if (i % 3 === 1) {
                // Some blobs start in the middle
                startingDepth = height * 0.4;
            } else {
                // Some blobs start at the top
                startingDepth = height - blob.height * 0.5;
            }
            
            blob.initialBottom = startingDepth;
            blob.bottom = startingDepth;
            blob.element.style.bottom = `${startingDepth}px`;
            
            // No initial transform to avoid issues
            blob.element.style.transform = '';
            
            newBgContainer.appendChild(blob.element);
            config.blobPool.background.push(blob);
        }
        
        // Middle layer (medium blobs)
        const midCount = Math.max(8, Math.floor(width / 160));
        for (let i = 0; i < midCount; i++) {
            const blob = createBlob('middle', {
                minWidth: width * 0.08,
                maxWidth: width * 0.18,
                minHeight: height * 0.2, 
                maxHeight: height * 0.45
            });
            
            // Position blobs throughout the container, including at the top
            let startingDepth;
            if (i % 3 === 0) {
                // Some blobs start at the bottom
                startingDepth = -blob.height * 1.2;
            } else if (i % 3 === 1) {
                // Some blobs start in the middle
                startingDepth = height * 0.3;
            } else {
                // Some blobs start at the top
                startingDepth = height - blob.height * 0.3;
            }
            
            blob.initialBottom = startingDepth;
            blob.bottom = startingDepth;
            blob.element.style.bottom = `${startingDepth}px`;
            
            // No initial transform to avoid issues
            blob.element.style.transform = '';
            
            newMidContainer.appendChild(blob.element);
            config.blobPool.middle.push(blob);
        }
        
        // Foreground layer (more, smaller blobs)
        const fgCount = Math.max(12, Math.floor(width / 80));
        for (let i = 0; i < fgCount; i++) {
            const blob = createBlob('foreground', {
                minWidth: width * 0.03,
                maxWidth: width * 0.1,
                minHeight: height * 0.1,
                maxHeight: height * 0.25
            });
            
            // Position blobs throughout the container, including at the top
            let startingDepth;
            if (i % 3 === 0) {
                // Some blobs start at the bottom
                startingDepth = -blob.height * 1.2;
            } else if (i % 3 === 1) {
                // Some blobs start in the middle
                startingDepth = height * 0.2;
            } else {
                // Some blobs start at the top
                startingDepth = height - blob.height * 0.2;
            }
            
            blob.initialBottom = startingDepth;
            blob.bottom = startingDepth;
            blob.element.style.bottom = `${startingDepth}px`;
            
            // No initial transform to avoid issues
            blob.element.style.transform = '';
            
            newFgContainer.appendChild(blob.element);
            config.blobPool.foreground.push(blob);
        }
        
        // Set all blobs to random starting positions in their animation cycle
        // This creates a more natural looking initial state
        config.blobPool.background.forEach((blob, i) => {
            blob.animationProgress = Math.random();
        });
        
        config.blobPool.middle.forEach((blob, i) => {
            blob.animationProgress = Math.random();
        });
        
        config.blobPool.foreground.forEach((blob, i) => {
            blob.animationProgress = Math.random();
        });
        
        // Now handle transitioning out old blobs while new ones come in
        // Use gentler transitions for both entry and exit
        if (oldBlobsBg.length > 0 || oldBlobsMid.length > 0 || oldBlobsFg.length > 0) {
            // First, prepare the new blobs - set them to be slightly transparent initially
            // Then they'll fade in as they rise
            [...config.blobPool.background, ...config.blobPool.middle, ...config.blobPool.foreground].forEach(blob => {
                // Set initial opacity lower so we can fade in
                const targetOpacity = blob.layer === 'background' ? '0.8' : (blob.layer === 'middle' ? '0.9' : '1');
                blob.element.style.opacity = '0.3'; // Start semi-transparent
                
                // After a delay, start fading in as they begin to rise
                setTimeout(() => {
                    blob.element.style.transition = 'opacity 2s ease-in';
                    blob.element.style.opacity = targetOpacity;
                }, 300);
            });
            
            // Now handle the old blobs - make them sink gradually with proper staging
            [...oldBlobsBg, ...oldBlobsMid, ...oldBlobsFg].forEach((blob, i) => {
                // Determine fall delay based on layer for more natural exiting
                // Background blobs exit first, then middle, then foreground
                let layerDelay = 0;
                if (blob.layer === 'middle') layerDelay = 300;
                if (blob.layer === 'foreground') layerDelay = 600;
                
                // Gradually make old blobs sink beyond the visible area
                setTimeout(() => {
                    // Longer transitions for smoother exit
                    blob.element.style.transition = 'bottom 2.5s ease-in, opacity 2s ease-out, transform 1.5s ease-in';
                    
                    // Move downward with a slight curve (using transform for smoother animation)
                    const currentTransform = blob.element.style.transform || '';
                    blob.element.style.transform = currentTransform + ' translateY(80px)';
                    
                    // Also move the actual position down
                    blob.element.style.bottom = `-${blob.height + 100}px`;
                    
                    // Fade out
                    blob.element.style.opacity = '0';
                }, i * 40 + layerDelay); // Stagger the exit with layer delay
            });
            
            // Remove old blobs after animation
            setTimeout(() => {
                [...oldBlobsBg, ...oldBlobsMid, ...oldBlobsFg].forEach(blob => {
                    if (blob.element.parentNode) {
                        blob.element.parentNode.removeChild(blob.element);
                    }
                });
                
                // Now move all new blobs to the original containers
                while (newBgContainer.firstChild) blobContainerBg.appendChild(newBgContainer.firstChild);
                while (newMidContainer.firstChild) blobContainerMid.appendChild(newMidContainer.firstChild);
                while (newFgContainer.firstChild) blobContainerFg.appendChild(newFgContainer.firstChild);
                
                // Remove the temporary containers
                newBgContainer.parentNode.removeChild(newBgContainer);
                newMidContainer.parentNode.removeChild(newMidContainer);
                newFgContainer.parentNode.removeChild(newFgContainer);
            }, 3000); // Longer wait time for smoother exit
        } else {
            // For first load, fade in the blobs as they rise
            [...config.blobPool.background, ...config.blobPool.middle, ...config.blobPool.foreground].forEach(blob => {
                // Start at lower opacity
                const targetOpacity = blob.layer === 'background' ? '0.8' : (blob.layer === 'middle' ? '0.9' : '1');
                blob.element.style.opacity = '0.3';
                
                // After a brief delay, fade in
                setTimeout(() => {
                    blob.element.style.transition = 'opacity 2s ease-in';
                    blob.element.style.opacity = targetOpacity;
                }, 300);
            });
            
            // Move blobs to containers
            while (newBgContainer.firstChild) blobContainerBg.appendChild(newBgContainer.firstChild);
            while (newMidContainer.firstChild) blobContainerMid.appendChild(newMidContainer.firstChild);
            while (newFgContainer.firstChild) blobContainerFg.appendChild(newFgContainer.firstChild);
            
            // Remove the temporary containers
            newBgContainer.parentNode.removeChild(newBgContainer);
            newMidContainer.parentNode.removeChild(newMidContainer);
            newFgContainer.parentNode.removeChild(newFgContainer);
        }
    }

    function createBlob(layer, sizeOptions) {
        // Create DOM element
        const element = document.createElement('div');
        element.classList.add('lava-blob');
        
        // Apply proper class and blend mode for each layer - use exactly like original
        if (layer === 'background') {
            element.classList.add('bg-blob');
            element.style.mixBlendMode = 'soft-light'; // Soft-light for background creates subtle base
        } else if (layer === 'middle') {
            element.classList.add('middle-blob');
            element.style.mixBlendMode = 'color-dodge'; // Changed from screen to color-dodge for smoother transitions
        } else if (layer === 'foreground') {
            element.classList.add('fg-blob');
            element.style.mixBlendMode = 'plus-lighter'; // Changed from lighten to plus-lighter for more natural overlaps
        }

        // Size - make blobs more perfectly circular with aspect ratio closer to 1
        const width = randomBetween(sizeOptions.minWidth, sizeOptions.maxWidth);
        const aspectRatio = randomBetween(0.95, 1.05); // Nearly perfect circles
        const height = width * aspectRatio;
        
        // Ensure height stays within bounds
        const finalHeight = Math.max(
            sizeOptions.minHeight,
            Math.min(height, sizeOptions.maxHeight)
        );
        
        // Position - horizontal position
        const left = randomBetween(0, 100);
        // Start blobs completely below the visible area, similar to original design
        const bottom = -randomBetween(sizeOptions.maxHeight * 0.6, sizeOptions.maxHeight * 1.2);
        
        // Use mostly circular shapes for stability
        const borderRadius = Math.random() > 0.7 ? createCircularBorderRadius() : '50%';
        
        // Set initial styles with minimal hardware acceleration hints
        element.style.width = `${width}px`;
        element.style.height = `${finalHeight}px`;
        element.style.left = `${left}%`;
        element.style.bottom = `${bottom}px`;
        element.style.borderRadius = borderRadius;
        
        // Start with full opacity
        element.style.opacity = layer === 'background' ? '0.8' : (layer === 'middle' ? '0.9' : '1');
        
        // Moderate animation speed - faster than before but still stable
        // Animation duration in seconds - longer for slower animation that's less likely to glitch
        const duration = randomBetween(
            layer === 'background' ? 30 : (layer === 'middle' ? 25 : 20),
            layer === 'background' ? 40 : (layer === 'middle' ? 35 : 30)
        );
        
        // Distribute animation starting points more evenly
        const startOffset = randomBetween(0, 1);
        
        // Create blob object with minimal wobble properties and individual speed factor
        const blob = {
            element,
            width,
            height: finalHeight,
            left,
            bottom,
            initialBottom: bottom,
            borderRadius,
            animationProgress: startOffset,
            animationDuration: duration,
            layer,
            // Individual speed factor for varied movement
            speedFactor: randomBetween(0.6, 1.0), // Random speed between 60% and 100% of max
            // Slightly increased wobble for more life, but still controlled
            wobble: {
                amplitude: randomBetween(0.1, 0.2), // Moderate amplitude for character
                frequency: randomBetween(0.001, 0.002), // Moderate frequency
                phase: Math.random() * Math.PI * 2
            },
            // Fallback position tracking
            lastValidPosition: {
                bottom: bottom,
                left: left,
                transform: ''
            }
        };
        
        return blob;
    }

    function startAnimationLoop() {
        // Animation function using requestAnimationFrame
        function animate() {
            // Update all blobs
            updateBlobs(config.blobPool.background, 'background');
            updateBlobs(config.blobPool.middle, 'middle');
            updateBlobs(config.blobPool.foreground, 'foreground');
            
            // Update particles if enabled
            if (animationSettings.particles) {
                updateParticles();
            }
            
            // Continue animation loop
            config.animation.frameId = requestAnimationFrame(animate);
        }
        
        // Start animation
        config.animation.frameId = requestAnimationFrame(animate);
    }

    function updateBlobs(blobs, layer) {
        // Use faster speeds for more dynamic flow that reaches the top
        const speedMultiplier = layer === 'background' ? 0.7 : (layer === 'middle' ? 0.9 : 1.2);
        const headerHeight = container.offsetHeight;
        
        // Get time for fluid simulation
        const time = performance.now() * 0.001; // seconds
        
        // Slightly stronger gentle global forces
        const globalForceX = Math.sin(time * 0.12) * 2.0;
        const globalForceY = Math.cos(time * 0.09) * 1.5;
        
        blobs.forEach(blob => {
            try {
                // Only update if blob is visible
                if (parseFloat(blob.element.style.opacity) <= 0) return;
                
                // Update animation progress - use individual blob speed factor for varied movement
                const progressStep = (1 / (blob.animationDuration * 80)) * speedMultiplier * blob.speedFactor;
                blob.animationProgress += progressStep;
                if (blob.animationProgress > 1) blob.animationProgress -= 1;
                
                // Simple elliptical path
                const t = blob.animationProgress * Math.PI * 2;
                
                // Use original quadratic easing for smoother motion at top/bottom turns
                const easeInOut = (t) => {
                    // Quadratic ease-in-out for more natural motion
                    return t < 0.5 ? 2 * t * t : 1 - Math.pow(-2 * t + 2, 2) / 2;
                };
                
                // Apply easing to sine wave for more natural movement
                const sineValue = Math.sin(t);
                const easedSine = sineValue * (1 - Math.abs(sineValue) * 0.2); // Slightly flatten peaks
                
                // Full range of motion to ensure lava reaches the top
                const newBottom = blob.initialBottom + (headerHeight * 1.2) * easedSine;
                
                // Remove top boundary limit to allow blobs to fully reach the top
                const topLimit = headerHeight + blob.height * 0.5; // Allow blobs to extend beyond the top
                const bottomLimit = -blob.height - 10;
                
                // Ensure within boundaries
                const clampedBottom = Math.max(bottomLimit, Math.min(topLimit, newBottom));
                
                // Update blob position
                blob.bottom = clampedBottom;
                blob.element.style.bottom = `${clampedBottom}px`;
                
                // Horizontal motion - use primary and secondary frequencies with reduced amplitude
                // This creates more organic motion without causing glitches
                const primaryFreq = Math.sin(t * 0.6 + blob.wobble.phase);
                const secondaryFreq = Math.sin(t * 0.3 + blob.wobble.phase * 1.7) * 0.2; // Reduced secondary influence
                const horizontalAmount = (primaryFreq + secondaryFreq) * (blob.width * 0.25); // Reduced amplitude from 0.35 to 0.25
                
                // Create transform with moderate but stable components
                const scale = 1 + 0.04 * Math.sin(t * 0.7 + blob.wobble.phase * 0.9);
                
                // Apply global forces with reduced influence
                const xWithForces = horizontalAmount + (globalForceX * 0.15); // Reduced from 0.3 to 0.15
                
                // Store the current position for interpolation
                const currentX = blob.lastX || 0;
                
                // Calculate target position
                const targetX = Math.round(xWithForces * 10) / 10;
                
                // Apply position interpolation to smooth transitions
                // Use easeInOutQuad for smoother transitions
                const interpolationFactor = 0.08; // Lower value = smoother but slower transitions
                const interpolatedX = currentX + (targetX - currentX) * interpolationFactor;
                
                // Store the new position for next frame
                blob.lastX = interpolatedX;
                
                // Round for stability but still smooth movement
                const transformX = Math.round(interpolatedX * 10) / 10;
                const scaleValue = Math.round(scale * 100) / 100;
                
                // Prepare transform - very minimal rotation added for character
                // but keep it small to avoid glitchiness
                const tinyRotate = Math.sin(t * 0.3 + blob.wobble.phase) * 0.5;
                const rotateValue = Math.round(tinyRotate * 10) / 10;
                
                // Simple transform with controlled movement
                const transformString = `translate(${transformX}px, 0) scale(${scaleValue}) rotate(${rotateValue}deg)`;
                
                // Apply the simplified transform
                blob.element.style.transform = transformString;
                
                // Store last valid position
                blob.lastValidPosition = {
                    bottom: clampedBottom,
                    left: blob.left,
                    transform: transformString
                };
                
                // Occasional shape changes but not too frequent
                if (Math.random() < 0.002) {
                    blob.element.style.borderRadius = createCircularBorderRadius();
                }
            } catch (error) {
                // Fallback to last valid position if any errors
                console.error("Animation error:", error);
                if (blob.lastValidPosition) {
                    blob.bottom = blob.lastValidPosition.bottom;
                    blob.element.style.bottom = `${blob.bottom}px`;
                    blob.element.style.transform = blob.lastValidPosition.transform;
                }
            }
        });
    }

    function createCircularBorderRadius() {
        // For cosmic theme, prefer more circular shapes for meatball effect
        
        // 70% chance to use circular shape
        if (Math.random() > 0.3) {
            return '50%'; // Perfect circle
        }
        
        // 20% chance to use slightly elliptical shape
        if (Math.random() > 0.1) {
            const radius = randomBetween(48, 52);
            return `${radius}%`;
        }
        
        // Generate gentle blob shapes - more conservative values for more circular look
        const base = randomBetween(48, 52);
        const variation = 4; // Very small variation for more circular shapes
        
        const tlh = base + randomBetween(-variation, variation);
        const tlv = base + randomBetween(-variation, variation);
        const trh = base + randomBetween(-variation, variation);
        const trv = base + randomBetween(-variation, variation);
        const brh = base + randomBetween(-variation, variation);
        const brv = base + randomBetween(-variation, variation);
        const blh = base + randomBetween(-variation, variation);
        const blv = base + randomBetween(-variation, variation);
        
        return `${tlh}% ${tlv}% ${trh}% ${trv}% ${brh}% ${brv}% ${blh}% ${blv}%`;
    }

    function createPopEffect(x, y) {
        // Get container bounds
        const containerRect = container.getBoundingClientRect();
        
        // Only create effect if click is within container
        if (y < containerRect.bottom && y > containerRect.top) {
            // Create shockwave effect with smoother appearance
            const shockwave = document.createElement('div');
            shockwave.style.position = 'absolute';
            shockwave.style.left = `${x - containerRect.left}px`;
            shockwave.style.top = `${y - containerRect.top}px`;
            shockwave.style.width = '10px';
            shockwave.style.height = '10px';
            shockwave.style.borderRadius = '50%';
            // Use gradients instead of solid colors for smoother appearance
            shockwave.style.background = `radial-gradient(circle at center, 
               rgba(255, 255, 255, 0.5), 
               ${hexToRgba(config.colors.outerColor, 0.4)} 60%, 
               ${hexToRgba(config.colors.outerColor, 0.1)} 80%, 
               transparent)`;
            shockwave.style.boxShadow = `0 0 20px 10px ${hexToRgba(config.colors.outerColor, 0.3)}`;
            shockwave.style.transform = 'translate(-50%, -50%)';
            shockwave.style.pointerEvents = 'none';
            shockwave.style.zIndex = '15';
            shockwave.style.transition = 'opacity 0.2s ease-out'; // Smooth initial fade in
            
            container.appendChild(shockwave);
            
            // Animate shockwave with smoother transitions
            const startTime = performance.now();
            const duration = 800;
            
            function animateShockwave() {
                const elapsed = performance.now() - startTime;
                const progress = Math.min(elapsed / duration, 1);
                
                // Use cubic easing for smoother expansion
                const easeOutCubic = 1 - Math.pow(1 - progress, 3);
                
                // Expand outward
                const size = 10 + 300 * easeOutCubic;
                shockwave.style.width = `${size}px`;
                shockwave.style.height = `${size}px`;
                
                // Smoother fade out with custom curve
                const opacityCurve = progress < 0.1 ? 
                    (progress / 0.1) : // Quick fade in
                    (1 - ((progress - 0.1) / 0.9)); // Gradual fade out
                
                shockwave.style.opacity = opacityCurve.toFixed(3); // Use precision to avoid flickering
                
                // Continue animation or remove
                if (progress < 1) {
                    requestAnimationFrame(animateShockwave);
                } else {
                    container.removeChild(shockwave);
                }
            }
            
            requestAnimationFrame(animateShockwave);
            
            // Create temporary particles for pop effect - more and more varied
            for (let i = 0; i < 20; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');
                
                // Random size with more variation
                const size = randomBetween(2, 10);
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                
                // Add random shape variety
                if (Math.random() > 0.7) {
                    particle.style.borderRadius = '50%'; // circle
                } else if (Math.random() > 0.5) {
                    particle.style.borderRadius = '30%'; // rounded square
                } else {
                    particle.style.borderRadius = '50% 50% 50% 0'; // teardrop
                }
                
                // Position at click point relative to container
                const relativeX = x - containerRect.left;
                const relativeY = y - containerRect.top;
                particle.style.left = `${relativeX}px`;
                particle.style.top = `${relativeY}px`;
                
                // Apply transition for smoother color changes
                particle.style.transition = 'background-color 0.3s ease, box-shadow 0.3s ease';
                
                // Apply smoother colors WITHOUT ANY PINK to prevent flicker
                let particleColor;
                if (Math.random() > 0.7) {
                    // Use secondary color (indigo) with no pink
                    particleColor = config.colors.innerColor;
                } else if (Math.random() > 0.3) {
                    // Use primary color (blueviolet) with subtle secondary blend
                    particleColor = color_mix_hex(config.colors.outerColor, config.colors.innerColor, 0.2);
                } else {
                    // Use white with subtle primary color blend
                    particleColor = color_mix_hex('#ffffff', config.colors.outerColor, 0.15);
                }
                
                // Apply calculated color
                particle.style.backgroundColor = particleColor;
                particle.style.boxShadow = `0 0 ${size}px ${size/2}px ${hexToRgba(particleColor, 0.4)}`;
                
                // Random direction - use more consistent speeds to avoid sudden movements
                const angle = Math.random() * Math.PI * 2;
                const speed = randomBetween(80, 150); // Narrower range for more consistent movement
                const vx = Math.cos(angle) * speed;
                const vy = Math.sin(angle) * speed;
                
                // Add to container
                container.appendChild(particle);
                
                // Animate with more physics
                const startTime = performance.now();
                const duration = randomBetween(600, 1200);
                const gravity = randomBetween(200, 400); // higher gravity for more natural arc
                const initialVy = Math.random() > 0.5 ? -randomBetween(100, 200) : 0; // initial upward velocity for some
                
                function animateParticle() {
                    const elapsed = performance.now() - startTime;
                    const progress = Math.min(elapsed / duration, 1);
                    const easeProgress = easeOutQuint(progress); // Apply easing
                    
                    // Position with physics
                    const currentX = relativeX + vx * easeProgress;
                    // Apply gravity effect with initial velocity
                    const currentY = relativeY + (vy * easeProgress) + 
                                   (initialVy * easeProgress) + 
                                   (0.5 * gravity * easeProgress * easeProgress);
                    
                    particle.style.left = `${currentX}px`;
                    particle.style.top = `${currentY}px`;
                    
                    // Add rotation
                    const rotation = 360 * progress * (Math.random() > 0.5 ? 1 : -1);
                    particle.style.transform = `rotate(${rotation}deg) scale(${1 - progress * 0.5})`;
                    
                    // Smoother fade in then out with cubic easing
                    const opacityCurve = progress < 0.2 ? 
                        Math.pow(progress / 0.2, 2) : // Quadratic ease in
                        Math.pow(1 - ((progress - 0.2) / 0.8), 2); // Quadratic ease out
                    
                    particle.style.opacity = opacityCurve;
                    
                    // Continue animation or remove
                    if (progress < 1) {
                        requestAnimationFrame(animateParticle);
                    } else {
                        container.removeChild(particle);
                    }
                }
                
                requestAnimationFrame(animateParticle);
            }
            
            // Enhanced wave effect with propagation delay through all blobs
            const allBlobs = [
                ...config.blobPool.background, 
                ...config.blobPool.middle, 
                ...config.blobPool.foreground
            ];
            
            // Sort blobs by distance to create wave propagation effect
            const sortedBlobs = allBlobs.map(blob => {
                // Calculate blob center in viewport coordinates
                const blobCenterX = containerRect.left + (blob.left / 100) * containerRect.width + blob.width / 2;
                const blobBottom = blob.bottom < 0 ? blob.bottom : 0; // Use actual position
                const blobCenterY = containerRect.bottom - blobBottom - blob.height / 2;
                
                // Calculate distance to click
                const dx = x - blobCenterX;
                const dy = y - blobCenterY;
                const distance = Math.sqrt(dx * dx + dy * dy);
                
                return { blob, distance, blobCenterX, blobCenterY };
            }).sort((a, b) => a.distance - b.distance);
            
            // Enhanced wave effect with propagation delay
            const effectRange = 250; // Larger effect range
            const waveSpeed = 0.5; // pixels per millisecond - controls how fast the wave propagates
            
            sortedBlobs.forEach(({ blob, distance, blobCenterX, blobCenterY }) => {
                // Apply effect if within range with propagation delay
                if (distance < effectRange) {
                    // Calculate propagation delay based on distance
                    const delay = distance / waveSpeed;
                    
                    // Different effects based on distance
                    setTimeout(() => {
                        // Scale effect based on distance
                        const distanceFactor = 1 - distance / effectRange;
                        const scale = 1 + 0.4 * distanceFactor;
                        
                        // Calculate push direction (push away from click point)
                        const pushDirX = (blobCenterX - x) / distance;
                        const pushDirY = (blobCenterY - y) / distance;
                        const pushAmount = 30 * distanceFactor; // max push distance
                        
                        // Apply advanced pulse animation with directional push
                        blob.element.style.transition = 'all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
                        
                        // Store original transform to restore later
                        const originalTransform = blob.element.style.transform;
                        
                        // Apply wave effect with both scale and push
                        blob.element.style.transform = `translate(${pushDirX * pushAmount}px, ${pushDirY * pushAmount}px) 
                                                       scale(${scale}) 
                                                       skew(${-pushDirX * 5}deg, ${-pushDirY * 5}deg)`;
                        
                        // Use simple brightness filter for a smooth, non-glitchy effect
                        const brightnessLevel = 1 + distanceFactor * 0.4;
                        blob.element.style.filter = `brightness(${brightnessLevel.toFixed(2)})`;
                        
                        // Ensure transitions are smooth
                        blob.element.style.transition = 'all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), filter 0.5s ease-out';
                        
                        // Reset after animation with smooth transition back
                        setTimeout(() => {
                            blob.element.style.transition = 'all 0.8s cubic-bezier(0.34, 1.56, 0.64, 1), filter 0.7s ease-out';
                            blob.element.style.transform = originalTransform;
                            blob.element.style.filter = ''; // Remove filter after animation
                        }, 300);
                    }, delay);
                }
            });
        }
    }

    function initParallaxEffect() {
        window.addEventListener('scroll', handleScroll);
        handleScroll(); // Initialize positions
    }

    function handleScroll() {
        const scrollY = window.scrollY;
        const containerRect = container.getBoundingClientRect();
        const containerTop = containerRect.top + scrollY;
        const containerHeight = containerRect.height;
        
        // Only apply parallax when container is visible
        if (scrollY < containerTop + containerHeight) {
            const scrollProgress = scrollY / (containerTop + containerHeight);
            
            // Apply gentler parallax rates to different layers
            container.querySelector('.lava-layer-background').style.transform = `translateY(${scrollY * 0.15}px)`;
            container.querySelector('.lava-layer-middle').style.transform = `translateY(${scrollY * 0.08}px)`;
            container.querySelector('.lava-layer-foreground').style.transform = `translateY(${scrollY * 0.04}px)`;
        }
    }

    function initParticleSystem() {
        // Create particle pool
        for (let i = 0; i < config.particles.maxParticles; i++) {
            const element = document.createElement('div');
            element.classList.add('particle');
            config.particles.pool.push({
                element,
                active: false
            });
        }
        
        // Start spawning particles
        spawnParticle();
    }

    function spawnParticle() {
        if (!animationSettings.particles) return;
        
        // Get an inactive particle from the pool
        const availableParticle = config.particles.pool.find(p => !p.active);
        
        if (availableParticle) {
            // Activate the particle
            availableParticle.active = true;
            
            // Configure particle - balanced size
            const containerRect = container.getBoundingClientRect();
            const size = randomBetween(2.5, 7);
            
            availableParticle.element.style.width = `${size}px`;
            availableParticle.element.style.height = `${size}px`;
            
            // Random position at bottom of container
            const x = randomBetween(0, containerRect.width);
            const y = containerRect.height;
            
            availableParticle.element.style.left = `${x}px`;
            availableParticle.element.style.top = `${y}px`;
            
            // Remove any existing classes
            availableParticle.element.classList.remove(
                'particle-light-purple',
                'particle-teal',
                'particle-medium-blue'
            );
            
            // Select cosmic colors for particles
            const cosmicColors = [
                'light-purple',  // Purples work well for cosmic theme
                'light-purple',  // Added twice for higher frequency
                'medium-blue',   // Blue for cosmic
                'medium-blue',   // Added twice for higher frequency
                'teal'          // A bit of teal for accent
            ];
            
            // Apply random cosmic color
            const selectedColor = cosmicColors[Math.floor(Math.random() * cosmicColors.length)];
            availableParticle.element.classList.add(`particle-${selectedColor}`);
            
            // Add to container
            container.appendChild(availableParticle.element);
            
            // Randomize particle shape
            if (Math.random() > 0.7) {
                // 30% chance for different shapes
                const shapes = [
                    '50% 50% 50% 50%', // circle
                    '50% 50% 30% 50%', // teardrop
                    '50% 30% 50% 50%', // inverted teardrop
                    '30% 70% 70% 30%'  // squished diamond
                ];
                availableParticle.element.style.borderRadius = shapes[Math.floor(Math.random() * shapes.length)];
            }
            
            // Setup animation - balanced animation speed
            const duration = randomBetween(2800, 5500); 
            const startTime = performance.now();
            const targetX = x + randomBetween(-80, 80); // reduced horizontal spread
            const amplitude = randomBetween(10, 25); // moderate side-to-side motion
            const waveFrequency = randomBetween(2, 4); // controls number of waves
            const rotationSpeed = randomBetween(-160, 160); // rotation during rise
            
            // Add to active particles
            const particle = {
                element: availableParticle.element,
                startTime,
                duration,
                startX: x,
                startY: y,
                targetX,
                amplitude,
                size,
                waveFrequency,
                rotationSpeed
            };
            
            config.particles.active.push(particle);
        }
        
        // Schedule next particle spawn - balanced frequency
        setTimeout(spawnParticle, randomBetween(100, 280));
    }

    function updateParticles() {
        const currentTime = performance.now();
        const particlesToRemove = [];
        
        config.particles.active.forEach((particle, index) => {
            const elapsed = currentTime - particle.startTime;
            const progress = Math.min(elapsed / particle.duration, 1);
            
            if (progress < 1) {
                // Update position - float upward with sine wave
                const currentX = particle.startX + (particle.targetX - particle.startX) * progress + 
                                Math.sin(progress * Math.PI * particle.waveFrequency) * particle.amplitude;
                
                // Cubic ease-out function gives more natural fluid movement
                const easeOutCubic = 1 - Math.pow(1 - progress, 3);
                const currentY = particle.startY - easeOutCubic * particle.startY * 1.2;
                
                particle.element.style.left = `${currentX}px`;
                particle.element.style.top = `${currentY}px`;
                
                // Add rotation for more interesting motion
                const rotation = progress * particle.rotationSpeed;
                particle.element.style.transform = `rotate(${rotation}deg)`;
                
                // Enhance brightness near the beginning for "just created" effect
                const brightnessBoost = progress < 0.2 ? 1 + (0.7 * (1 - progress/0.2)) : 1;
                particle.element.style.filter = `brightness(${brightnessBoost})`;
                
                // Fade in then out with balanced opacity
                const maxOpacity = 0.85; // More visible but not fully opaque
                particle.element.style.opacity = progress < 0.15 ? ((progress / 0.15) * maxOpacity) : (maxOpacity - ((progress - 0.15) / 0.85) * maxOpacity);
            } else {
                // Mark for removal
                particlesToRemove.push(index);
            }
        });
        
        // Remove completed particles
        for (let i = particlesToRemove.length - 1; i >= 0; i--) {
            const index = particlesToRemove[i];
            const particle = config.particles.active[index];
            
            // Remove from DOM
            if (particle.element.parentNode) {
                particle.element.parentNode.removeChild(particle.element);
            }
            
            // Mark as inactive in pool
            const poolParticle = config.particles.pool.find(p => p.element === particle.element);
            if (poolParticle) {
                poolParticle.active = false;
            }
            
            // Remove from active array
            config.particles.active.splice(index, 1);
        }
    }

    // Utility functions
    function hexToRgb(hex) {
        const r = parseInt(hex.slice(1, 3), 16);
        const g = parseInt(hex.slice(3, 5), 16);
        const b = parseInt(hex.slice(5, 7), 16);
        return { r, g, b };
    }

    function hexToRgba(hex, alpha) {
        const r = parseInt(hex.slice(1, 3), 16);
        const g = parseInt(hex.slice(3, 5), 16);
        const b = parseInt(hex.slice(5, 7), 16);
        return `rgba(${r}, ${g}, ${b}, ${alpha})`;
    }

    function color_mix_hex(color1, color2, ratio) {
        // For simplicity, if using variable, return the main color
        if (color2.startsWith('var')) return color1;
        if (color1.startsWith('var')) return color2;
        
        // Convert to RGB and mix
        const rgb1 = hexToRgb(color1);
        const rgb2 = hexToRgb(color2);
        
        const r = Math.round(rgb1.r * (1 - ratio) + rgb2.r * ratio);
        const g = Math.round(rgb1.g * (1 - ratio) + rgb2.g * ratio);
        const b = Math.round(rgb1.b * (1 - ratio) + rgb2.b * ratio);
        
        // Convert back to hex
        return `#${((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1)}`;
    }

    function easeOutQuint(x) {
        return 1 - Math.pow(1 - x, 5);
    }

    function randomBetween(min, max) {
        return min + Math.random() * (max - min);
    }

    function debounce(func, wait) {
        let timeout;
        return function() {
            const context = this;
            const args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(context, args), wait);
        };
    }
    
    // Return a cleanup function to stop animation and remove event listeners if needed
    return function cleanup() {
        if (config.animation.frameId) {
            cancelAnimationFrame(config.animation.frameId);
        }
        window.removeEventListener('resize', resizeHandler);
        window.removeEventListener('scroll', handleScroll);
    };
}

// Initialize all lava animations when the DOM is ready
document.addEventListener('DOMContentLoaded', initLavaAnimation);