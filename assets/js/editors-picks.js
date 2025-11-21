/**
 * Editor's Picks Section JavaScript
 *
 * Handles star rating animations using Intersection Observer
 * for performance and modern vanilla JavaScript.
 *
 * @package CozyRecipes
 */

(function() {
    'use strict';

    /**
     * Initialize star rating animations
     */
    function initStarAnimations() {
        const ratings = document.querySelectorAll('.pick-rating');

        if (!ratings.length) return;

        // Check if Intersection Observer is supported
        if (!('IntersectionObserver' in window)) {
            // Fallback: just show all stars immediately
            ratings.forEach(function(rating) {
                rating.classList.add('visible');
            });
            return;
        }

        // Create observer for animation trigger
        const observer = new IntersectionObserver(
            function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting && !entry.target.classList.contains('animated')) {
                        // Add animation class
                        entry.target.classList.add('animating');
                        entry.target.classList.add('animated');

                        // Remove animating class after animation completes
                        setTimeout(function() {
                            entry.target.classList.remove('animating');
                        }, 1000);

                        // Stop observing this element
                        observer.unobserve(entry.target);
                    }
                });
            },
            {
                threshold: 0.5,
                rootMargin: '0px'
            }
        );

        // Observe all rating elements
        ratings.forEach(function(rating) {
            observer.observe(rating);
        });
    }

    /**
     * Add hover effect to cards
     */
    function initCardHover() {
        const cards = document.querySelectorAll('.editors-pick-card');

        cards.forEach(function(card) {
            card.addEventListener('mouseenter', function() {
                const rating = this.querySelector('.pick-rating');
                if (rating && !rating.classList.contains('hovered')) {
                    rating.classList.add('hovered');
                }
            });

            card.addEventListener('mouseleave', function() {
                const rating = this.querySelector('.pick-rating');
                if (rating) {
                    rating.classList.remove('hovered');
                }
            });
        });
    }

    /**
     * Smooth scroll for recipe links (optional enhancement)
     */
    function initSmoothLinks() {
        const links = document.querySelectorAll('.pick-link');

        links.forEach(function(link) {
            link.addEventListener('click', function(e) {
                // Add a subtle click effect
                this.style.transform = 'scale(0.98)';
                setTimeout(function() {
                    link.style.transform = '';
                }, 150);
            });
        });
    }

    /**
     * Initialize all features when DOM is ready
     */
    function init() {
        // Wait for DOM to be fully loaded
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                initStarAnimations();
                initCardHover();
                initSmoothLinks();
            });
        } else {
            // DOM is already loaded
            initStarAnimations();
            initCardHover();
            initSmoothLinks();
        }
    }

    // Run initialization
    init();

})();
