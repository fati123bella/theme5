/**
 * Category Slider - Mobile Carousel with Auto-scroll
 * Vertical on desktop (no JS needed), horizontal carousel on mobile
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

        // Get settings from localized script
        const settings = window.categorySliderSettings || {};
        const autoScrollSpeed = parseInt(settings.autoScrollSpeed) || 3000;

        let currentIndex = 0;
        let autoScrollInterval = null;
        let isPaused = false;
        let isMobile = false;

        // Touch/drag variables
        let isDragging = false;
        let startX = 0;
        let currentX = 0;
        let startScrollLeft = 0;

        /**
         * Check if we're on mobile
         */
        function checkMobile() {
            isMobile = window.innerWidth <= 768;
        }

        /**
         * Get the width of one item plus gap
         */
        function getItemWidth() {
            if (items.length === 0) return 0;
            const itemStyle = window.getComputedStyle(items[0]);
            const itemWidth = items[0].offsetWidth;
            const gap = parseFloat(itemStyle.marginRight) || 16;
            return itemWidth + gap;
        }

        /**
         * Scroll to specific index (mobile only)
         */
        function scrollToIndex(index, smooth = true) {
            if (!isMobile) return;

            const itemWidth = getItemWidth();
            const scrollLeft = index * itemWidth;

            if (smooth) {
                track.scrollTo({
                    left: scrollLeft,
                    behavior: 'smooth'
                });
            } else {
                track.scrollLeft = scrollLeft;
            }
        }

        /**
         * Go to next item
         */
        function goToNext() {
            if (!isMobile || isPaused) return;

            currentIndex++;

            // Loop back to start when reaching the end
            // Show 2 items at a time, so max index is items.length - 2
            if (currentIndex >= items.length - 1) {
                currentIndex = 0;
            }

            scrollToIndex(currentIndex);
        }

        /**
         * Start auto-scroll
         */
        function startAutoScroll() {
            if (!isMobile) return;

            stopAutoScroll(); // Clear any existing interval

            autoScrollInterval = setInterval(function() {
                if (!isPaused && !isDragging) {
                    requestAnimationFrame(goToNext);
                }
            }, autoScrollSpeed);
        }

        /**
         * Stop auto-scroll
         */
        function stopAutoScroll() {
            if (autoScrollInterval) {
                clearInterval(autoScrollInterval);
                autoScrollInterval = null;
            }
        }

        /**
         * Pause auto-scroll temporarily
         */
        function pauseAutoScroll() {
            isPaused = true;
            stopAutoScroll();
        }

        /**
         * Resume auto-scroll
         */
        function resumeAutoScroll() {
            isPaused = false;
            if (isMobile) {
                startAutoScroll();
            }
        }

        /**
         * Handle mouse enter (pause on hover)
         */
        function handleMouseEnter() {
            if (!isMobile) return;
            pauseAutoScroll();
        }

        /**
         * Handle mouse leave (resume)
         */
        function handleMouseLeave() {
            if (!isMobile) return;
            resumeAutoScroll();
        }

        /**
         * Handle touch start
         */
        function handleTouchStart(e) {
            if (!isMobile) return;

            isDragging = true;
            startX = e.touches[0].clientX;
            startScrollLeft = track.scrollLeft;
            pauseAutoScroll();

            track.style.scrollSnapType = 'none'; // Disable snap during drag
        }

        /**
         * Handle touch move
         */
        function handleTouchMove(e) {
            if (!isMobile || !isDragging) return;

            currentX = e.touches[0].clientX;
            const deltaX = startX - currentX;
            track.scrollLeft = startScrollLeft + deltaX;
        }

        /**
         * Handle touch end
         */
        function handleTouchEnd() {
            if (!isMobile) return;

            isDragging = false;
            track.style.scrollSnapType = 'x mandatory'; // Re-enable snap

            // Update current index based on scroll position
            const itemWidth = getItemWidth();
            currentIndex = Math.round(track.scrollLeft / itemWidth);

            // Resume auto-scroll after a delay
            setTimeout(resumeAutoScroll, 2000);
        }

        /**
         * Handle mouse down (for desktop drag simulation)
         */
        function handleMouseDown(e) {
            if (!isMobile) return;

            isDragging = true;
            startX = e.clientX;
            startScrollLeft = track.scrollLeft;
            pauseAutoScroll();

            track.style.cursor = 'grabbing';
            track.style.scrollSnapType = 'none';

            e.preventDefault();
        }

        /**
         * Handle mouse move
         */
        function handleMouseMove(e) {
            if (!isMobile || !isDragging) return;

            currentX = e.clientX;
            const deltaX = startX - currentX;
            track.scrollLeft = startScrollLeft + deltaX;
        }

        /**
         * Handle mouse up
         */
        function handleMouseUp() {
            if (!isMobile) return;

            isDragging = false;
            track.style.cursor = 'grab';
            track.style.scrollSnapType = 'x mandatory';

            // Update current index
            const itemWidth = getItemWidth();
            currentIndex = Math.round(track.scrollLeft / itemWidth);

            // Resume auto-scroll after a delay
            setTimeout(resumeAutoScroll, 2000);
        }

        /**
         * Handle focus on items (pause auto-scroll)
         */
        function handleItemFocus() {
            if (!isMobile) return;
            pauseAutoScroll();
        }

        /**
         * Handle blur on items (resume auto-scroll)
         */
        function handleItemBlur() {
            if (!isMobile) return;
            setTimeout(resumeAutoScroll, 1000);
        }

        /**
         * Handle window resize
         */
        function handleResize() {
            const wasMobile = isMobile;
            checkMobile();

            if (wasMobile !== isMobile) {
                // Mode changed
                if (isMobile) {
                    // Switched to mobile
                    currentIndex = 0;
                    scrollToIndex(0, false);
                    startAutoScroll();
                } else {
                    // Switched to desktop
                    stopAutoScroll();
                    track.scrollLeft = 0;
                }
            }
        }

        /**
         * Initialize event listeners
         */
        function initEvents() {
            // Hover events
            slider.addEventListener('mouseenter', handleMouseEnter);
            slider.addEventListener('mouseleave', handleMouseLeave);

            // Touch events
            track.addEventListener('touchstart', handleTouchStart, { passive: true });
            track.addEventListener('touchmove', handleTouchMove, { passive: true });
            track.addEventListener('touchend', handleTouchEnd);

            // Mouse drag events (optional, for desktop testing)
            track.addEventListener('mousedown', handleMouseDown);
            document.addEventListener('mousemove', handleMouseMove);
            document.addEventListener('mouseup', handleMouseUp);

            // Focus events for accessibility
            items.forEach(function(item) {
                item.addEventListener('focus', handleItemFocus);
                item.addEventListener('blur', handleItemBlur);
            });

            // Resize with debounce
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(handleResize, 250);
            });

            // Pause when page becomes hidden
            document.addEventListener('visibilitychange', function() {
                if (document.hidden) {
                    pauseAutoScroll();
                } else if (isMobile && !isPaused) {
                    resumeAutoScroll();
                }
            });
        }

        /**
         * Initialize the slider
         */
        function init() {
            checkMobile();

            if (isMobile) {
                // Set initial scroll position
                scrollToIndex(0, false);

                // Start auto-scroll
                startAutoScroll();

                // Add grab cursor hint
                track.style.cursor = 'grab';
            }

            initEvents();
        }

        // Initialize on load
        init();

        // Re-initialize after fonts load (prevents layout shift)
        if (document.fonts && document.fonts.ready) {
            document.fonts.ready.then(function() {
                if (isMobile) {
                    scrollToIndex(currentIndex, false);
                }
            });
        }
    }

})();
