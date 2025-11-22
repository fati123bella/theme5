/**
 * Category Slider - Horizontal Auto-scroll for All Devices
 * Works on both desktop and mobile
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
        const prevArrow = slider.querySelector('.category-slider__arrow--prev');
        const nextArrow = slider.querySelector('.category-slider__arrow--next');

        if (!track || items.length === 0) return;

        // Get settings from localized script
        const settings = window.categorySliderSettings || {};
        const autoScrollSpeed = parseInt(settings.autoScrollSpeed) || 3000;

        let currentIndex = 0;
        let autoScrollInterval = null;
        let isPaused = false;

        // Touch/drag variables
        let isDragging = false;
        let startX = 0;
        let currentX = 0;
        let startScrollLeft = 0;

        /**
         * Get the width of one item plus gap
         */
        function getItemWidth() {
            if (items.length === 0) return 0;
            const itemWidth = items[0].offsetWidth;
            const trackStyle = window.getComputedStyle(track);
            const gap = parseFloat(trackStyle.gap) || 32; // 2rem default
            return itemWidth + gap;
        }

        /**
         * Scroll to specific index
         */
        function scrollToIndex(index, smooth = true) {
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
            if (isPaused) return;

            currentIndex++;

            // Loop back to start when reaching the end
            if (currentIndex >= items.length) {
                currentIndex = 0;
            }

            scrollToIndex(currentIndex);
        }

        /**
         * Go to previous item
         */
        function goToPrevious() {
            currentIndex--;

            // Loop to end when at the start
            if (currentIndex < 0) {
                currentIndex = items.length - 1;
            }

            scrollToIndex(currentIndex);
        }

        /**
         * Update arrow visibility based on scroll overflow
         */
        function updateArrowVisibility() {
            if (!prevArrow || !nextArrow) return;

            // Check if content overflows
            const hasOverflow = track.scrollWidth > track.clientWidth;

            if (hasOverflow) {
                prevArrow.classList.remove('hidden');
                nextArrow.classList.remove('hidden');
            } else {
                prevArrow.classList.add('hidden');
                nextArrow.classList.add('hidden');
            }
        }

        /**
         * Start auto-scroll
         */
        function startAutoScroll() {
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
            startAutoScroll();
        }

        /**
         * Handle mouse enter (pause on hover)
         */
        function handleMouseEnter() {
            pauseAutoScroll();
        }

        /**
         * Handle mouse leave (resume)
         */
        function handleMouseLeave() {
            resumeAutoScroll();
        }

        /**
         * Handle touch start
         */
        function handleTouchStart(e) {
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
            if (!isDragging) return;

            currentX = e.touches[0].clientX;
            const deltaX = startX - currentX;
            track.scrollLeft = startScrollLeft + deltaX;
        }

        /**
         * Handle touch end
         */
        function handleTouchEnd() {
            isDragging = false;
            track.style.scrollSnapType = 'x mandatory'; // Re-enable snap

            // Update current index based on scroll position
            const itemWidth = getItemWidth();
            currentIndex = Math.round(track.scrollLeft / itemWidth);

            // Resume auto-scroll after a delay
            setTimeout(resumeAutoScroll, 2000);
        }

        /**
         * Handle mouse down (for drag)
         */
        function handleMouseDown(e) {
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
            if (!isDragging) return;

            currentX = e.clientX;
            const deltaX = startX - currentX;
            track.scrollLeft = startScrollLeft + deltaX;
        }

        /**
         * Handle mouse up
         */
        function handleMouseUp() {
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
            pauseAutoScroll();
        }

        /**
         * Handle blur on items (resume auto-scroll)
         */
        function handleItemBlur() {
            setTimeout(resumeAutoScroll, 1000);
        }

        /**
         * Handle window resize
         */
        function handleResize() {
            // Recalculate and adjust scroll position
            const itemWidth = getItemWidth();
            currentIndex = Math.round(track.scrollLeft / itemWidth);
            scrollToIndex(currentIndex, false);

            // Update arrow visibility
            updateArrowVisibility();
        }

        /**
         * Handle arrow button activation (click or keyboard)
         */
        function handlePrevious() {
            pauseAutoScroll();
            goToPrevious();
            setTimeout(resumeAutoScroll, 3000);
        }

        function handleNext() {
            pauseAutoScroll();
            goToNext();
            setTimeout(resumeAutoScroll, 3000);
        }

        /**
         * Initialize event listeners
         */
        function initEvents() {
            // Previous arrow events
            if (prevArrow) {
                // Click event
                prevArrow.addEventListener('click', handlePrevious);

                // Keyboard events (Enter and Space)
                prevArrow.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        handlePrevious();
                    }
                });
            }

            // Next arrow events
            if (nextArrow) {
                // Click event
                nextArrow.addEventListener('click', handleNext);

                // Keyboard events (Enter and Space)
                nextArrow.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        handleNext();
                    }
                });
            }

            // Hover events
            slider.addEventListener('mouseenter', handleMouseEnter);
            slider.addEventListener('mouseleave', handleMouseLeave);

            // Touch events
            track.addEventListener('touchstart', handleTouchStart, { passive: true });
            track.addEventListener('touchmove', handleTouchMove, { passive: true });
            track.addEventListener('touchend', handleTouchEnd);

            // Mouse drag events
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
                } else if (!isPaused) {
                    resumeAutoScroll();
                }
            });
        }

        /**
         * Initialize the slider
         */
        function init() {
            // Set initial scroll position
            scrollToIndex(0, false);

            // Update arrow visibility
            updateArrowVisibility();

            // Start auto-scroll
            startAutoScroll();

            // Add grab cursor hint
            track.style.cursor = 'grab';

            initEvents();
        }

        // Initialize on load
        init();

        // Re-initialize after fonts load (prevents layout shift)
        if (document.fonts && document.fonts.ready) {
            document.fonts.ready.then(function() {
                scrollToIndex(currentIndex, false);
            });
        }
    }

})();
