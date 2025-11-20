/**
 * Navigation JavaScript
 *
 * Handles mobile menu toggle, submenu functionality, and header search
 * Optimized to prevent forced layout reflows
 */

(function() {
    'use strict';

    // Wait for DOM to be ready
    document.addEventListener('DOMContentLoaded', function() {

        // ========================================
        // MEDIA QUERY HELPERS (prevents layout reflows)
        // ========================================

        const mobileMediaQuery = window.matchMedia('(max-width: 767px)');
        const desktopMediaQuery = window.matchMedia('(min-width: 768px)');

        // ========================================
        // MOBILE MENU TOGGLE
        // ========================================

        const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
        const mainNavigation = document.querySelector('.main-navigation');
        const body = document.body;

        if (mobileMenuToggle && mainNavigation) {
            // Toggle mobile menu
            mobileMenuToggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const isExpanded = this.getAttribute('aria-expanded') === 'true';

                // Toggle aria-expanded
                this.setAttribute('aria-expanded', !isExpanded);

                // Toggle active class
                this.classList.toggle('active');
                mainNavigation.classList.toggle('active');

                // Toggle body class to prevent scrolling
                body.classList.toggle('mobile-menu-open');

                // Set focus to first menu item when opening
                if (!isExpanded) {
                    const firstMenuItem = mainNavigation.querySelector('a');
                    if (firstMenuItem) {
                        setTimeout(function() {
                            firstMenuItem.focus();
                        }, 300);
                    }
                }
            });

            // Close menu when clicking outside
            document.addEventListener('click', function(e) {
                if (mainNavigation.classList.contains('active')) {
                    if (!mainNavigation.contains(e.target) && !mobileMenuToggle.contains(e.target)) {
                        closeMobileMenu();
                    }
                }
            });

            // Close menu when pressing ESC key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && mainNavigation.classList.contains('active')) {
                    closeMobileMenu();
                    mobileMenuToggle.focus();
                }
            });

            // Function to close mobile menu
            function closeMobileMenu() {
                mobileMenuToggle.classList.remove('active');
                mobileMenuToggle.setAttribute('aria-expanded', 'false');
                mainNavigation.classList.remove('active');
                body.classList.remove('mobile-menu-open');
            }
        }

        // ========================================
        // MOBILE SUBMENU TOGGLE
        // ========================================

        const menuItemsWithChildren = document.querySelectorAll('.main-navigation .menu-item-has-children');

        function initMobileSubmenus() {
            if (mobileMediaQuery.matches) {
                menuItemsWithChildren.forEach(function(menuItem) {
                    const link = menuItem.querySelector('a');
                    const submenu = menuItem.querySelector('.sub-menu');

                    if (link && submenu) {
                        // Clone the link to remove existing event listeners
                        const newLink = link.cloneNode(true);
                        link.parentNode.replaceChild(newLink, link);

                        // Add click event to toggle submenu
                        newLink.addEventListener('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();

                            // Toggle active class on parent
                            menuItem.classList.toggle('active');

                            // Toggle submenu visibility
                            if (menuItem.classList.contains('active')) {
                                submenu.style.display = 'block';
                            } else {
                                submenu.style.display = 'none';
                            }
                        });
                    }
                });
            }
        }

        // Initialize on load
        initMobileSubmenus();

        // Handle media query changes using matchMedia listener
        desktopMediaQuery.addEventListener('change', function(e) {
            if (e.matches) {
                // Switched to desktop
                if (mainNavigation && mainNavigation.classList.contains('active')) {
                    closeMobileMenu();
                }

                // Remove inline styles from submenus
                const submenus = document.querySelectorAll('.main-navigation .sub-menu');
                submenus.forEach(function(submenu) {
                    submenu.style.display = '';
                });

                // Remove active classes from menu items
                menuItemsWithChildren.forEach(function(item) {
                    item.classList.remove('active');
                });
            }
        });

        // ========================================
        // HEADER SEARCH TOGGLE
        // ========================================

        const searchToggle = document.querySelector('.header-search-toggle');
        const searchForm = document.querySelector('.header-search-form');

        if (searchToggle && searchForm) {
            // Toggle search form
            searchToggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const isExpanded = this.getAttribute('aria-expanded') === 'true';

                // Toggle aria-expanded
                this.setAttribute('aria-expanded', !isExpanded);

                // Toggle active class
                searchForm.classList.toggle('active');

                // Focus on input when opening
                if (!isExpanded) {
                    const searchInput = searchForm.querySelector('input[type="search"]');
                    if (searchInput) {
                        setTimeout(function() {
                            searchInput.focus();
                        }, 100);
                    }
                }
            });

            // Close search form when clicking outside
            document.addEventListener('click', function(e) {
                if (searchForm.classList.contains('active')) {
                    if (!searchForm.contains(e.target) && !searchToggle.contains(e.target)) {
                        searchForm.classList.remove('active');
                        searchToggle.setAttribute('aria-expanded', 'false');
                    }
                }
            });

            // Close search form when pressing ESC key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && searchForm.classList.contains('active')) {
                    searchForm.classList.remove('active');
                    searchToggle.setAttribute('aria-expanded', 'false');
                    searchToggle.focus();
                }
            });
        }

        // ========================================
        // STICKY HEADER ON SCROLL (Optimized)
        // ========================================

        const siteHeader = document.querySelector('.site-header');
        let scrolling = false;
        let lastScrollTop = 0;

        if (siteHeader) {
            // Use passive event listener for better scroll performance
            window.addEventListener('scroll', function() {
                if (!scrolling) {
                    scrolling = true;
                    // Use requestAnimationFrame to batch DOM updates
                    requestAnimationFrame(updateHeaderOnScroll);
                }
            }, { passive: true });

            function updateHeaderOnScroll() {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

                // Use CSS class instead of inline styles to prevent layout reflows
                if (scrollTop > 10) {
                    siteHeader.classList.add('scrolled');
                } else {
                    siteHeader.classList.remove('scrolled');
                }

                lastScrollTop = scrollTop;
                scrolling = false;
            }
        }

        // ========================================
        // SMOOTH SCROLL FOR ANCHOR LINKS (Optimized)
        // ========================================

        const anchorLinks = document.querySelectorAll('a[href^="#"]');

        anchorLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');

                // Skip if it's just "#"
                if (href === '#') {
                    return;
                }

                const target = document.querySelector(href);

                if (target) {
                    e.preventDefault();

                    // Close mobile menu if open
                    if (mainNavigation && mainNavigation.classList.contains('active')) {
                        closeMobileMenu();
                    }

                    // Batch read operations first, then write
                    requestAnimationFrame(function() {
                        // Read phase
                        const headerHeight = siteHeader ? siteHeader.offsetHeight : 0;
                        const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - headerHeight;

                        // Write phase
                        window.scrollTo({
                            top: targetPosition,
                            behavior: 'smooth'
                        });

                        // Update focus
                        target.focus();

                        // Update URL
                        if (history.pushState) {
                            history.pushState(null, null, href);
                        }
                    });
                }
            });
        });

    });

})();
