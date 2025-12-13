/**
 * Pinterest Pin It Button
 * Adds a "Pin it" button badge to all images across the site
 */

(function() {
    'use strict';

    // Initialize on page load
    window.addEventListener('load', function() {
        console.log('Pinterest Pin It: Initializing...');
        initPinItButtons();
    });

    // Also initialize after a short delay for dynamically loaded content
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            console.log('Pinterest Pin It: Re-checking for new images...');
            initPinItButtons();
        }, 1000);
    });

    function initPinItButtons() {
        // Find ALL images on the page (very broad selector)
        const images = document.querySelectorAll('img');

        console.log('Pinterest Pin It: Found ' + images.length + ' total images');

        let processedCount = 0;

        images.forEach(function(img) {
            // Skip if already processed
            if (img.hasAttribute('data-pin-it-added')) {
                return;
            }

            // Skip if parent already has wrapper
            if (img.parentElement && img.parentElement.classList.contains('pin-it-wrapper')) {
                return;
            }

            // Process the image
            if (processImage(img)) {
                processedCount++;
            }
        });

        console.log('Pinterest Pin It: Added buttons to ' + processedCount + ' images');
    }

    function processImage(img) {
        // Wait for image to be loaded to check dimensions
        if (!img.complete) {
            img.addEventListener('load', function() {
                addPinButton(img);
            });
            return false;
        } else {
            return addPinButton(img);
        }
    }

    function addPinButton(img) {
        // Skip very small images (icons, avatars, etc.)
        if (img.naturalWidth < 150 || img.naturalHeight < 150) {
            console.log('Skipping small image:', img.src, img.naturalWidth + 'x' + img.naturalHeight);
            return false;
        }

        // Mark as processed
        img.setAttribute('data-pin-it-added', 'true');

        console.log('Adding Pin it button to:', img.src, img.naturalWidth + 'x' + img.naturalHeight);

        // Get the element to wrap (might be a link containing the image)
        let elementToWrap = img;
        if (img.parentElement && img.parentElement.tagName === 'A') {
            elementToWrap = img.parentElement;
        }

        // Create wrapper
        const wrapper = document.createElement('div');
        wrapper.className = 'pin-it-wrapper';

        // Insert wrapper before element
        elementToWrap.parentNode.insertBefore(wrapper, elementToWrap);
        // Move element into wrapper
        wrapper.appendChild(elementToWrap);

        // Create Pin it button
        const pinButton = document.createElement('button');
        pinButton.className = 'pin-it-button';
        pinButton.type = 'button';
        pinButton.setAttribute('aria-label', 'Pin this image to Pinterest');
        pinButton.textContent = 'Pin it';

        // Add click handler
        pinButton.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            pinImage(img);
        });

        wrapper.appendChild(pinButton);

        return true;
    }

    function pinImage(img) {
        console.log('Pinning image:', img.src);

        // Get image URL (use src or data-src for lazy loaded images)
        const imageUrl = img.getAttribute('data-src') || img.src;
        const pageUrl = window.location.href;
        const description = img.alt || document.title;

        // Build Pinterest share URL
        const pinterestUrl = 'https://pinterest.com/pin/create/button/' +
            '?url=' + encodeURIComponent(pageUrl) +
            '&media=' + encodeURIComponent(imageUrl) +
            '&description=' + encodeURIComponent(description);

        console.log('Opening Pinterest:', pinterestUrl);

        // Open Pinterest in popup window
        window.open(
            pinterestUrl,
            'pinterest-share',
            'width=750,height=550,menubar=no,toolbar=no,resizable=yes,scrollbars=yes'
        );
    }
})();
