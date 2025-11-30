/**
 * Recipe Print Card JavaScript
 * Handles smooth scrolling and print functionality
 */

(function() {
  'use strict';

  /**
   * Initialize when DOM is ready
   */
  document.addEventListener('DOMContentLoaded', function() {
    initSmoothScroll();
    initPrintButton();
  });

  /**
   * Initialize smooth scroll for "Jump to Recipe" links
   */
  function initSmoothScroll() {
    const recipeCard = document.getElementById('recipe-print-card');

    if (!recipeCard) {
      return;
    }

    // Find all links that point to #recipe-print-card
    const jumpLinks = document.querySelectorAll('a[href="#recipe-print-card"]');

    jumpLinks.forEach(function(link) {
      link.addEventListener('click', function(e) {
        e.preventDefault();

        // Smooth scroll to the recipe card
        recipeCard.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });

        // Optional: Update URL hash without jumping
        if (history.pushState) {
          history.pushState(null, null, '#recipe-print-card');
        }

        // Optional: Focus on the card for accessibility
        recipeCard.setAttribute('tabindex', '-1');
        recipeCard.focus();
      });
    });

    // Also handle direct navigation to hash (e.g., page load with #recipe-print-card)
    if (window.location.hash === '#recipe-print-card') {
      setTimeout(function() {
        recipeCard.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }, 100);
    }
  }

  /**
   * Initialize print button
   */
  function initPrintButton() {
    const printButton = document.querySelector('.recipe-print-btn');

    if (!printButton) {
      return;
    }

    printButton.addEventListener('click', function(e) {
      e.preventDefault();
      window.print();
    });

    // Optional: Handle print event for analytics or other purposes
    if (window.matchMedia) {
      const mediaQueryList = window.matchMedia('print');

      mediaQueryList.addListener(function(mql) {
        if (mql.matches) {
          // Before print
          console.log('Recipe card is being printed');
        } else {
          // After print
          console.log('Recipe card print completed');
        }
      });
    }
  }

  /**
   * Optional: Pinterest Pin Button Enhancement
   * Adds additional functionality to Pinterest button if needed
   */
  function initPinterestButton() {
    const pinButton = document.querySelector('.recipe-pin-btn');

    if (!pinButton) {
      return;
    }

    // Pinterest button already works via href, but we can add analytics here
    pinButton.addEventListener('click', function() {
      console.log('Pinterest share initiated');
      // Add analytics tracking here if needed
    });
  }

  // Initialize Pinterest button enhancement
  document.addEventListener('DOMContentLoaded', function() {
    initPinterestButton();
  });

})();
