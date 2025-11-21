/**
 * Categories Slider Functionality
 * Mobile: Shows 2 categories at a time with arrow navigation
 * Desktop: Shows all categories in a row
 *
 * @package CozyRecipes
 */

(function() {
    'use strict';

    // Wait for DOM to be fully loaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCategoriesSlider);
    } else {
        initCategoriesSlider();
    }

    function initCategoriesSlider() {
        const sliderWrapper = document.querySelector('.categories-slider-wrapper');
        if (!sliderWrapper) return;

        const slider = sliderWrapper.querySelector('.categories-slider');
        const track = sliderWrapper.querySelector('.categories-slider-track');
        const prevButton = sliderWrapper.querySelector('.category-slider-prev');
        const nextButton = sliderWrapper.querySelector('.category-slider-next');
        const slides = Array.from(track.querySelectorAll('.category-slide'));

        if (!track || !prevButton || !nextButton || slides.length === 0) return;

        let currentIndex = 0;
        let slidesToShow = 2; // Default for mobile
        let slideWidth = 0;
        let gap = 24; // 1.5rem = 24px

        // Update slider dimensions based on viewport
        function updateDimensions() {
            const isMobile = window.innerWidth <= 768;

            if (isMobile) {
                slidesToShow = 2;
                const containerWidth = slider.offsetWidth;
                slideWidth = (containerWidth - gap) / slidesToShow;

                // Show arrows on mobile
                prevButton.style.display = 'flex';
                nextButton.style.display = 'flex';
            } else {
                // Desktop: show all, hide arrows
                slidesToShow = slides.length;
                prevButton.style.display = 'none';
                nextButton.style.display = 'none';
                currentIndex = 0;
                updateSliderPosition(false);
            }

            updateButtons();
        }

        // Update slider position with smooth animation
        function updateSliderPosition(animate = true) {
            const isMobile = window.innerWidth <= 768;

            if (!isMobile) {
                track.style.transform = 'translateX(0)';
                return;
            }

            const offset = currentIndex * (slideWidth + gap);

            if (animate) {
                track.style.transition = 'transform 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
            } else {
                track.style.transition = 'none';
            }

            track.style.transform = `translateX(-${offset}px)`;
        }

        // Update button states (enabled/disabled)
        function updateButtons() {
            const isMobile = window.innerWidth <= 768;
            if (!isMobile) return;

            const maxIndex = Math.max(0, slides.length - slidesToShow);

            prevButton.disabled = currentIndex === 0;
            nextButton.disabled = currentIndex >= maxIndex;
        }

        // Navigate to previous slide
        function goToPrev() {
            const isMobile = window.innerWidth <= 768;
            if (!isMobile) return;

            if (currentIndex > 0) {
                currentIndex--;
                updateSliderPosition();
                updateButtons();
            }
        }

        // Navigate to next slide
        function goToNext() {
            const isMobile = window.innerWidth <= 768;
            if (!isMobile) return;

            const maxIndex = Math.max(0, slides.length - slidesToShow);

            if (currentIndex < maxIndex) {
                currentIndex++;
                updateSliderPosition();
                updateButtons();
            }
        }

        // Event listeners
        prevButton.addEventListener('click', goToPrev);
        nextButton.addEventListener('click', goToNext);

        // Keyboard navigation
        sliderWrapper.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowLeft') {
                e.preventDefault();
                goToPrev();
            } else if (e.key === 'ArrowRight') {
                e.preventDefault();
                goToNext();
            }
        });

        // Touch/swipe support for mobile
        let touchStartX = 0;
        let touchEndX = 0;
        const minSwipeDistance = 50;

        track.addEventListener('touchstart', function(e) {
            touchStartX = e.touches[0].clientX;
        }, { passive: true });

        track.addEventListener('touchmove', function(e) {
            touchEndX = e.touches[0].clientX;
        }, { passive: true });

        track.addEventListener('touchend', function() {
            const swipeDistance = touchStartX - touchEndX;

            if (Math.abs(swipeDistance) > minSwipeDistance) {
                if (swipeDistance > 0) {
                    // Swipe left - go to next
                    goToNext();
                } else {
                    // Swipe right - go to previous
                    goToPrev();
                }
            }

            touchStartX = 0;
            touchEndX = 0;
        });

        // Handle window resize with debounce
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                updateDimensions();
                updateSliderPosition(false);
            }, 250);
        });

        // Initialize
        updateDimensions();
        updateSliderPosition(false);

        // Auto-adjust on font load (prevents layout shift)
        if (document.fonts && document.fonts.ready) {
            document.fonts.ready.then(function() {
                updateDimensions();
                updateSliderPosition(false);
            });
        }
    }

})();
