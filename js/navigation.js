/**
 * Navigation and Mobile Menu Functionality
 */
(function() {
    'use strict';

    // Mobile menu toggle
    var mobileToggle = document.querySelector('.mobile-menu-toggle');
    var mobileNav = document.querySelector('.main-navigation');
    var mobileBackdrop = document.querySelector('.mobile-menu-backdrop');
    var body = document.body;

    if (mobileToggle && mobileNav) {
        mobileToggle.addEventListener('click', function() {
            var isOpen = mobileNav.classList.contains('active');

            if (isOpen) {
                closeMenu();
            } else {
                openMenu();
            }
        });
    }

    if (mobileBackdrop) {
        mobileBackdrop.addEventListener('click', function() {
            closeMenu();
        });
    }

    // Handle ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && mobileNav && mobileNav.classList.contains('active')) {
            closeMenu();
        }
    });

    function openMenu() {
        mobileNav.classList.add('active');
        mobileBackdrop.classList.add('active');
        body.classList.add('mobile-menu-open');
        mobileToggle.setAttribute('aria-expanded', 'true');
        mobileToggle.innerHTML = '✕';

        // Focus first menu item
        var firstLink = mobileNav.querySelector('a');
        if (firstLink) {
            firstLink.focus();
        }
    }

    function closeMenu() {
        mobileNav.classList.remove('active');
        mobileBackdrop.classList.remove('active');
        body.classList.remove('mobile-menu-open');
        mobileToggle.setAttribute('aria-expanded', 'false');
        mobileToggle.innerHTML = '☰';
    }

    // Mobile submenu toggle
    var menuItemsWithChildren = document.querySelectorAll('.main-navigation .menu-item-has-children');

    menuItemsWithChildren.forEach(function(item) {
        // Only add toggle functionality on mobile
        var link = item.querySelector('a');
        if (link) {
            link.addEventListener('click', function(e) {
                // Check if we're in mobile view
                if (window.innerWidth <= 1024) {
                    e.preventDefault();
                    item.classList.toggle('active');
                }
            });
        }
    });

    // Header search toggle
    var searchToggle = document.querySelector('.header-search-toggle');
    var searchForm = document.querySelector('.header-search-form');

    if (searchToggle && searchForm) {
        searchToggle.addEventListener('click', function() {
            searchForm.classList.toggle('active');

            if (searchForm.classList.contains('active')) {
                var searchInput = searchForm.querySelector('input[type="search"]');
                if (searchInput) {
                    searchInput.focus();
                }
            }
        });

        // Close search when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchToggle.contains(e.target) && !searchForm.contains(e.target)) {
                searchForm.classList.remove('active');
            }
        });
    }

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
        anchor.addEventListener('click', function(e) {
            var href = this.getAttribute('href');
            if (href !== '#' && href !== '#0') {
                var target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });

    // Add dropdown indicator for menu items with children (desktop)
    if (window.innerWidth > 1024) {
        menuItemsWithChildren.forEach(function(item) {
            var link = item.querySelector('> a');
            if (link && !link.querySelector('.dropdown-indicator')) {
                var indicator = document.createElement('span');
                indicator.className = 'dropdown-indicator';
                indicator.innerHTML = ' ▼';
                indicator.style.fontSize = '0.7em';
                link.appendChild(indicator);
            }
        });
    }
})();
