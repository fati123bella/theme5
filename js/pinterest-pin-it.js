/**
 * Pinterest Pin It Button
 * Adds a Pin it button overlay to all images on the site
 */

(function() {
    'use strict';

    // Wait for DOM and images to be ready
    window.addEventListener('load', function() {
        initPinItButtons();
    });

    function initPinItButtons() {
        // Find all content images with broader selectors
        const images = document.querySelectorAll(
            '.single-recipe-content img, ' +
            '.single-recipe-image img, ' +
            'article img, ' +
            '.entry-content img, ' +
            '.post-thumbnail img, ' +
            '.wp-post-image, ' +
            'main img'
        );

        console.log('Pinterest Pin It: Found ' + images.length + ' images');

        images.forEach(function(img, index) {
            // Wait for image to load before processing
            if (!img.complete) {
                img.addEventListener('load', function() {
                    processImage(img, index);
                });
            } else {
                processImage(img, index);
            }
        });
    }

    function processImage(img, index) {
        console.log('Processing image ' + index + ':', img.src, 'Size:', img.width + 'x' + img.height);

        // Skip if already has Pin it button
        if (img.parentElement && img.parentElement.classList.contains('pin-it-wrapper')) {
            console.log('Image ' + index + ' already has Pin it button');
            return;
        }

        // Skip very small images (icons, avatars, etc.)
        if (img.width < 150 || img.height < 150) {
            console.log('Image ' + index + ' too small, skipping');
            return;
        }

        // Skip if parent is already a link (to avoid nested links issue)
        if (img.parentElement && img.parentElement.tagName === 'A') {
            console.log('Image ' + index + ' is inside a link, wrapping the link');
            wrapElement(img.parentElement);
        } else {
            wrapElement(img);
        }

        console.log('Added Pin it button to image ' + index);
    }

    function wrapElement(element) {
        // Create wrapper
        const wrapper = document.createElement('div');
        wrapper.className = 'pin-it-wrapper';

        // Wrap the element (image or link)
        element.parentNode.insertBefore(wrapper, element);
        wrapper.appendChild(element);

        // Create Pin it button
        const pinButton = document.createElement('button');
        pinButton.className = 'pin-it-button';
        pinButton.type = 'button';
        pinButton.setAttribute('aria-label', 'Pin this image to Pinterest');

        // Pinterest logo SVG
        pinButton.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">' +
            '<path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.162-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.401.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.354-.629-2.758-1.379l-.749 2.848c-.269 1.045-1.004 2.352-1.498 3.146 1.123.345 2.306.535 3.55.535 6.607 0 11.985-5.365 11.985-11.987C23.97 5.39 18.592.026 11.985.026L12.017 0z"/>' +
            '</svg><span>Pin</span>';

        // Add click handler
        pinButton.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            // Find the actual image (might be inside a link)
            const img = wrapper.querySelector('img');
            if (img) {
                pinImage(img);
            }
        });

        wrapper.appendChild(pinButton);
    }

    function pinImage(img) {
        console.log('Pinning image:', img.src);

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

        console.log('Opening Pinterest URL:', pinterestUrl);

        // Open Pinterest sharing window
        window.open(
            pinterestUrl,
            'pinterest-share',
            'width=750,height=550,menubar=no,toolbar=no,resizable=yes,scrollbars=yes'
        );
    }
})();
