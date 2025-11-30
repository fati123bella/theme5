/**
 * Category Slider - Solid Mobile Carousel
 * Simple, reliable scrolling with snap alignment
 * Mobile-first design with proper touch handling
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

        let touchStartX = 0;
        let touchEndX = 0;
        let isDragging = false;
        let scrollTimeout;

        /**
         * Get item width including gap
         */
        function getItemWidth() {
            if (items.length === 0) return 0;
            const itemWidth = items[0].offsetWidth;
            const trackStyle = window.getComputedStyle(track);
            const gap = parseFloat(trackStyle.gap) || 16;
            return itemWidth + gap;
        }

        /**
         * Snap to nearest item
         */
        function snapToItem() {
            const itemWidth = getItemWidth();
            const currentScroll = track.scrollLeft;
            const itemIndex = Math.round(currentScroll / itemWidth);
            const targetScroll = itemIndex * itemWidth;

            track.scrollTo({
                left: targetScroll,
                behavior: 'smooth',
                top: 0
            });

            updateIndicators(itemIndex);
        }

        /**
         * Handle touch start
         */
        function handleTouchStart(e) {
            isDragging = true;
            touchStartX = e.touches[0].clientX;

            // Cancel any pending snap
            if (scrollTimeout) {
                clearTimeout(scrollTimeout);
            }

            // Disable snap during drag
            track.style.scrollSnapType = 'none';
        }

        /**
         * Handle touch move - allow natural scrolling
         */
        function handleTouchMove(e) {
            // Native browser scrolling handles this
        }

        /**
         * Handle touch end - snap to item
         */
        function handleTouchEnd(e) {
            isDragging = false;
            touchEndX = e.changedTouches[0].clientX;

            // Re-enable snap scrolling
            track.style.scrollSnapType = 'x mandatory';

            // Snap to nearest item after brief delay
            if (scrollTimeout) {
                clearTimeout(scrollTimeout);
            }
            scrollTimeout = setTimeout(() => {
                snapToItem();
            }, 100);
        }

        /**
         * Update carousel indicators (dots)
         */
        function updateIndicators(currentIndex) {
            const indicators = slider.querySelectorAll('.carousel-indicator');
            indicators.forEach((indicator, index) => {
                if (index === currentIndex) {
                    indicator.classList.add('active');
                } else {
                    indicator.classList.remove('active');
                }
            });
        }

        /**
         * Handle scroll event for updating indicators
         */
        function handleScroll() {
            if (isDragging) return;

            const itemWidth = getItemWidth();
            const currentScroll = track.scrollLeft;
            const itemIndex = Math.round(currentScroll / itemWidth);
            updateIndicators(itemIndex);
        }

        /**
         * Create carousel indicator dots
         */
        function createIndicators() {
            const indicatorContainer = document.createElement('div');
            indicatorContainer.className = 'carousel-indicators';

            for (let i = 0; i < items.length; i++) {
                const dot = document.createElement('button');
                dot.type = 'button';
                dot.className = 'carousel-indicator';
                dot.setAttribute('aria-label', `Go to item ${i + 1}`);

                if (i === 0) {
                    dot.classList.add('active');
                }

                // Click to scroll to item
                dot.addEventListener('click', () => {
                    const itemWidth = getItemWidth();
                    const targetScroll = i * itemWidth;
                    track.scrollTo({
                        left: targetScroll,
                        behavior: 'smooth'
                    });
                    updateIndicators(i);
                });

                indicatorContainer.appendChild(dot);
            }

            return indicatorContainer;
        }

        /**
         * Initialize carousel
         */
        function init() {
            // Add touch event listeners
            track.addEventListener('touchstart', handleTouchStart, false);
            track.addEventListener('touchmove', handleTouchMove, { passive: true });
            track.addEventListener('touchend', handleTouchEnd, false);

            // Add scroll listener for indicator updates
            track.addEventListener('scroll', handleScroll, { passive: true });

            // Add mouse drag support for desktop
            let mouseDown = false;
            let mouseStartX = 0;
            let mouseScrollLeft = 0;

            track.addEventListener('mousedown', (e) => {
                mouseDown = true;
                mouseStartX = e.clientX;
                mouseScrollLeft = track.scrollLeft;
                track.style.cursor = 'grabbing';
                track.style.scrollSnapType = 'none';
            });

            document.addEventListener('mousemove', (e) => {
                if (!mouseDown) return;
                const deltaX = e.clientX - mouseStartX;
                track.scrollLeft = mouseScrollLeft - deltaX;
            });

            document.addEventListener('mouseup', () => {
                if (!mouseDown) return;
                mouseDown = false;
                track.style.cursor = 'grab';
                track.style.scrollSnapType = 'x mandatory';
                snapToItem();
            });

            // Set initial cursor
            track.style.cursor = 'grab';

            // Create and insert indicators
            const indicators = createIndicators();
            slider.appendChild(indicators);

            // Initial snap
            snapToItem();
        }

        // Initialize when ready
        init();
    }

})();
