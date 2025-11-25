/**
 * Category Slider - Modern Touch-Friendly Momentum Scrolling
 * No arrows, smooth inertial scrolling, and CSS snap alignment
 * Works on mobile (swipe) and desktop (click-drag)
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

        // Momentum scrolling variables
        let isDragging = false;
        let startX = 0;
        let currentX = 0;
        let startScrollLeft = 0;
        let velocity = 0;
        let lastX = 0;
        let lastTime = 0;
        let momentum = null;

        // Configuration
        const friction = 0.95; // Higher = more slide momentum (0.9-0.98)
        const minVelocity = 0.5; // Minimum velocity to trigger momentum

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
            startScrollLeft = track.scrollLeft;
            velocity = 0;

            // Stop any ongoing momentum
            if (momentum) {
                cancelAnimationFrame(momentum);
                momentum = null;
            }

            // Disable snap during drag for smooth sliding
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

            // Calculate velocity for momentum
            const now = Date.now();
            const timeDelta = now - lastTime;
            if (timeDelta > 0) {
                velocity = (lastX - currentX) / timeDelta;
            }
            lastX = currentX;
            lastTime = now;
        }

        /**
         * Handle mouse up - apply momentum
         */
        function handleMouseUp() {
            if (!isDragging) return;

            isDragging = false;
            track.style.cursor = 'grab';

            // Apply momentum scrolling
            applyMomentum(velocity);
        }

        /**
         * Handle touch start - start drag
         */
        function handleTouchStart(e) {
            isDragging = true;
            startX = e.touches[0].clientX;
            lastX = e.touches[0].clientX;
            lastTime = Date.now();
            startScrollLeft = track.scrollLeft;
            velocity = 0;

            // Stop any ongoing momentum
            if (momentum) {
                cancelAnimationFrame(momentum);
                momentum = null;
            }

            // Disable snap during drag for smooth sliding
            track.style.scrollSnapType = 'none';
        }

        /**
         * Handle touch move - drag scrolling
         */
        function handleTouchMove(e) {
            if (!isDragging) return;

            currentX = e.touches[0].clientX;
            const deltaX = startX - currentX;
            track.scrollLeft = startScrollLeft + deltaX;

            // Calculate velocity for momentum
            const now = Date.now();
            const timeDelta = now - lastTime;
            if (timeDelta > 0) {
                velocity = (lastX - currentX) / timeDelta;
            }
            lastX = currentX;
            lastTime = now;
        }

        /**
         * Handle touch end - apply momentum
         */
        function handleTouchEnd() {
            if (!isDragging) return;

            isDragging = false;

            // Apply momentum scrolling
            applyMomentum(velocity);
        }

        /**
         * Apply momentum scrolling with inertial deceleration
         */
        function applyMomentum(initialVelocity) {
            // Re-enable snap scrolling
            track.style.scrollSnapType = 'x mandatory';

            // Only apply momentum if velocity is significant enough
            if (Math.abs(initialVelocity) < minVelocity) {
                return;
            }

            let currentVelocity = initialVelocity;
            let lastScrollLeft = track.scrollLeft;

            function animate() {
                // Apply friction
                currentVelocity *= friction;

                // Stop animation if velocity is negligible
                if (Math.abs(currentVelocity) < 0.01) {
                    momentum = null;
                    return;
                }

                // Update scroll position
                const newScrollLeft = lastScrollLeft - (currentVelocity * 16); // 16ms typical frame time
                track.scrollLeft = newScrollLeft;
                lastScrollLeft = newScrollLeft;

                // Continue animation
                momentum = requestAnimationFrame(animate);
            }

            momentum = requestAnimationFrame(animate);
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

            // Prevent text selection while dragging
            track.addEventListener('selectstart', function(e) {
                if (isDragging) {
                    e.preventDefault();
                }
            });

            // Set initial cursor style
            track.style.cursor = 'grab';
        }

        /**
         * Initialize the slider
         */
        function init() {
            // Ensure smooth scrolling behavior
            track.style.scrollBehavior = 'auto';

            // Initialize events
            initEvents();
        }

        // Initialize on load
        init();

        // Re-initialize after fonts load (prevents layout shift)
        if (document.fonts && document.fonts.ready) {
            document.fonts.ready.then(function() {
                // Nothing special needed, just ensure layout is stable
            });
        }
    }

})();
