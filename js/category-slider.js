/**
 * Category Slider - Advanced Carousel with Momentum & Snap
 * Optimized for mobile touch and desktop drag interactions
 * Features: Smart snapping, momentum scrolling, swipe detection
 *
 * @package CozyRecipes
 */

(function() {
    'use strict';

    // Wait for DOM to be ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCategorySlider);
    } else {
        initCategorySlider();
    }

    function initCategorySlider() {
        const slider = document.querySelector('.category-slider');
        if (!slider) return;

        const track = slider.querySelector('.category-slider-track');
        const items = Array.from(track.querySelectorAll('.category-slider-item'));

        if (!track || items.length === 0) return;

        // Carousel state
        let isDragging = false;
        let startX = 0;
        let currentX = 0;
        let startScrollLeft = 0;
        let velocity = 0;
        let lastX = 0;
        let lastTime = 0;
        let lastTimestamp = 0;
        let momentum = null;

        // Get viewport width to determine mobile vs desktop
        const isMobile = () => window.innerWidth <= 768;

        // Configuration - adjusted for mobile and desktop
        const getMomentumConfig = () => {
            return {
                friction: isMobile() ? 0.92 : 0.95,      // More friction on mobile
                minVelocity: isMobile() ? 0.3 : 0.5,     // Lower threshold on mobile
                maxVelocity: isMobile() ? 3 : 5,         // Cap velocity
                snapThreshold: isMobile() ? 0.2 : 0.15,  // Snap distance
                decelerationFactor: 0.98                  // Smooth deceleration curve
            };
        };

        /**
         * Get the width of one item plus gap
         */
        function getItemWidth() {
            if (items.length === 0) return 0;
            const itemWidth = items[0].offsetWidth;
            const trackStyle = window.getComputedStyle(track);
            const gap = parseFloat(trackStyle.gap) || 16;
            return itemWidth + gap;
        }

        /**
         * Snap to the nearest item
         */
        function snapToNearestItem() {
            const config = getMomentumConfig();
            const itemWidth = getItemWidth();
            const currentScroll = track.scrollLeft;
            const nearestIndex = Math.round(currentScroll / itemWidth);
            const targetScroll = nearestIndex * itemWidth;

            // Only snap if distance is significant enough
            const distance = Math.abs(currentScroll - targetScroll);
            if (distance > 5) {
                // Smooth scroll to snap position
                track.scrollTo({
                    left: targetScroll,
                    behavior: 'smooth'
                });
            }
        }

        /**
         * Handle mouse down - start drag
         */
        function handleMouseDown(e) {
            // Only left mouse button
            if (e.button !== 0) return;

            isDragging = true;
            startX = e.clientX;
            lastX = e.clientX;
            lastTime = Date.now();
            lastTimestamp = Date.now();
            startScrollLeft = track.scrollLeft;
            velocity = 0;

            // Stop any ongoing momentum
            if (momentum) {
                cancelAnimationFrame(momentum);
                momentum = null;
            }

            // Disable snap during drag
            track.style.scrollSnapType = 'none';
            track.style.cursor = 'grabbing';

            e.preventDefault();
        }

        /**
         * Handle mouse move - drag scrolling
         */
        function handleMouseMove(e) {
            if (!isDragging) return;

            currentX = e.clientX;
            const deltaX = startX - currentX;
            track.scrollLeft = startScrollLeft + deltaX;

            // Calculate velocity - using weighted average for smoother motion
            const now = Date.now();
            const timeDelta = now - lastTime;

            if (timeDelta > 0 && timeDelta < 100) {
                const pixelsDelta = lastX - currentX;
                const currentVelocity = pixelsDelta / timeDelta;
                // Smooth velocity with weighted average
                velocity = velocity * 0.7 + currentVelocity * 0.3;
            }

            lastX = currentX;
            lastTime = now;
        }

        /**
         * Handle mouse up - apply momentum and snap
         */
        function handleMouseUp() {
            if (!isDragging) return;

            isDragging = false;
            track.style.cursor = 'grab';

            // Apply momentum then snap
            applyMomentumWithSnap(velocity);
        }

        /**
         * Handle touch start - start drag
         */
        function handleTouchStart(e) {
            isDragging = true;
            startX = e.touches[0].clientX;
            lastX = e.touches[0].clientX;
            lastTime = Date.now();
            lastTimestamp = Date.now();
            startScrollLeft = track.scrollLeft;
            velocity = 0;

            // Stop any ongoing momentum
            if (momentum) {
                cancelAnimationFrame(momentum);
                momentum = null;
            }

            // Disable snap during drag
            track.style.scrollSnapType = 'none';
        }

        /**
         * Handle touch move - drag scrolling with better velocity
         */
        function handleTouchMove(e) {
            if (!isDragging) return;

            currentX = e.touches[0].clientX;
            const deltaX = startX - currentX;
            track.scrollLeft = startScrollLeft + deltaX;

            // Calculate velocity with better time resolution
            const now = Date.now();
            const timeDelta = now - lastTime;

            if (timeDelta > 0 && timeDelta < 150) {
                const pixelsDelta = lastX - currentX;
                const currentVelocity = pixelsDelta / timeDelta;
                // Apply low-pass filter for smooth velocity
                velocity = velocity * 0.6 + currentVelocity * 0.4;
                // Cap velocity
                const config = getMomentumConfig();
                velocity = Math.max(-config.maxVelocity, Math.min(config.maxVelocity, velocity));
            }

            lastX = currentX;
            lastTime = now;
        }

        /**
         * Handle touch end - apply momentum and snap
         */
        function handleTouchEnd() {
            if (!isDragging) return;

            isDragging = false;

            // Apply momentum then snap
            applyMomentumWithSnap(velocity);
        }

        /**
         * Apply momentum scrolling with inertial deceleration, then snap
         */
        function applyMomentumWithSnap(initialVelocity) {
            const config = getMomentumConfig();

            // Re-enable snap scrolling
            track.style.scrollSnapType = 'x mandatory';

            // Check if velocity is significant
            if (Math.abs(initialVelocity) < config.minVelocity) {
                // Not enough velocity, just snap
                snapToNearestItem();
                return;
            }

            let currentVelocity = initialVelocity;
            let lastScrollLeft = track.scrollLeft;
            const maxScrollLeft = track.scrollWidth - track.clientWidth;

            function animate() {
                // Apply deceleration with smooth curve
                currentVelocity *= config.decelerationFactor;

                // Stop animation if velocity is negligible
                if (Math.abs(currentVelocity) < 0.01) {
                    momentum = null;
                    // Snap to nearest item when momentum stops
                    snapToNearestItem();
                    return;
                }

                // Calculate new scroll position
                const movement = currentVelocity * 16; // 16ms typical frame time
                let newScrollLeft = lastScrollLeft - movement;

                // Clamp to scroll boundaries
                newScrollLeft = Math.max(0, Math.min(maxScrollLeft, newScrollLeft));

                // If we hit the boundary, stop momentum
                if (newScrollLeft <= 0 || newScrollLeft >= maxScrollLeft) {
                    if (newScrollLeft <= 0 || newScrollLeft >= maxScrollLeft) {
                        currentVelocity = 0;
                    }
                }

                track.scrollLeft = newScrollLeft;
                lastScrollLeft = newScrollLeft;

                // Continue animation
                momentum = requestAnimationFrame(animate);
            }

            momentum = requestAnimationFrame(animate);
        }

        /**
         * Handle keyboard navigation (arrow keys)
         */
        function handleKeyDown(e) {
            const itemWidth = getItemWidth();

            switch(e.key) {
                case 'ArrowLeft':
                    e.preventDefault();
                    track.scrollLeft -= itemWidth;
                    snapToNearestItem();
                    break;
                case 'ArrowRight':
                    e.preventDefault();
                    track.scrollLeft += itemWidth;
                    snapToNearestItem();
                    break;
            }
        }

        /**
         * Initialize event listeners
         */
        function initEvents() {
            // Mouse events (desktop)
            track.addEventListener('mousedown', handleMouseDown);
            document.addEventListener('mousemove', handleMouseMove);
            document.addEventListener('mouseup', handleMouseUp);

            // Touch events (mobile)
            track.addEventListener('touchstart', handleTouchStart, { passive: true });
            track.addEventListener('touchmove', handleTouchMove, { passive: true });
            track.addEventListener('touchend', handleTouchEnd);

            // Keyboard navigation
            track.addEventListener('keydown', handleKeyDown);

            // Prevent text selection during drag
            track.addEventListener('selectstart', function(e) {
                if (isDragging) {
                    e.preventDefault();
                }
            });

            // Set initial cursor style
            track.style.cursor = 'grab';

            // Re-snap on window resize
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(() => {
                    snapToNearestItem();
                }, 250);
            });
        }

        /**
         * Initialize the carousel
         */
        function init() {
            // Ensure smooth scrolling behavior
            track.style.scrollBehavior = 'auto';

            // Snap to first item on load
            snapToNearestItem();

            // Initialize events
            initEvents();
        }

        // Initialize on load
        init();

        // Re-initialize after fonts load
        if (document.fonts && document.fonts.ready) {
            document.fonts.ready.then(function() {
                snapToNearestItem();
            });
        }
    }

})();
