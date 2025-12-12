/**
 * Pinterest Pin It Button
 * Adds a Pin it button overlay to all images on the site
 */

(function() {
    'use strict';

    // Wait for DOM to be ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initPinItButtons);
    } else {
        initPinItButtons();
    }

    function initPinItButtons() {
        // Find all content images (exclude icons, logos, small images)
        const images = document.querySelectorAll('.entry-content img, .post-thumbnail img, article img');

        images.forEach(function(img) {
            // Skip if image is too small (likely an icon or decoration)
            if (img.width < 200 || img.height < 200) {
                return;
            }

            // Skip if already has Pin it button
            if (img.parentElement.classList.contains('pin-it-wrapper')) {
                return;
            }

            // Create wrapper
            const wrapper = document.createElement('div');
            wrapper.className = 'pin-it-wrapper';

            // Wrap the image
            img.parentNode.insertBefore(wrapper, img);
            wrapper.appendChild(img);

            // Create Pin it button
            const pinButton = document.createElement('a');
            pinButton.className = 'pin-it-button';
            pinButton.href = '#';
            pinButton.setAttribute('aria-label', 'Pin this image');
            pinButton.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM12 20C7.59 20 4 16.41 4 12C4 7.59 7.59 4 12 4C16.41 4 20 7.59 20 12C20 16.41 16.41 20 12 20ZM13 7H11V11H7V13H11V17H13V13H17V11H13V7Z" fill="currentColor"/></svg><span>Pin</span>';

            // Add click handler
            pinButton.addEventListener('click', function(e) {
                e.preventDefault();
                pinImage(img);
            });

            wrapper.appendChild(pinButton);
        });
    }

    function pinImage(img) {
        // Get image details
        const imageUrl = img.src;
        const pageUrl = window.location.href;

        // Get image description (try alt text, then page title)
        let description = img.alt || document.title;

        // Build Pinterest URL
        const pinterestUrl = 'https://pinterest.com/pin/create/button/' +
            '?url=' + encodeURIComponent(pageUrl) +
            '&media=' + encodeURIComponent(imageUrl) +
            '&description=' + encodeURIComponent(description);

        // Open Pinterest sharing window
        window.open(
            pinterestUrl,
            'pinterest-share',
            'width=750,height=550,menubar=no,toolbar=no,resizable=yes,scrollbars=yes'
        );
    }

    // Re-initialize on dynamic content load (for AJAX-loaded content)
    if (typeof MutationObserver !== 'undefined') {
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.addedNodes.length) {
                    initPinItButtons();
                }
            });
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    }
})();
