/**
 * Pinterest Pin It Button Functionality
 */
(function() {
    'use strict';

    // Prevent Pinterest's own script from adding buttons
    window.pinterestNoScript = true;

    // Handle Pinterest button clicks
    document.addEventListener('click', function(e) {
        if (e.target.closest('.pinterest-pin-button')) {
            e.preventDefault();
            var button = e.target.closest('.pinterest-pin-button');
            var url = button.getAttribute('href');

            // Open Pinterest share in popup window
            window.open(
                url,
                'pinterest-share',
                'width=750,height=550,left=' + (screen.width / 2 - 375) + ',top=' + (screen.height / 2 - 275)
            );

            return false;
        }
    });

    // Add hover effect to image wrappers on touch devices
    if ('ontouchstart' in window) {
        document.addEventListener('touchstart', function(e) {
            var wrapper = e.target.closest('.pinterest-pin-wrapper');
            if (wrapper) {
                wrapper.classList.add('touch-active');
            }
        });

        document.addEventListener('touchend', function(e) {
            var wrappers = document.querySelectorAll('.pinterest-pin-wrapper.touch-active');
            wrappers.forEach(function(wrapper) {
                setTimeout(function() {
                    wrapper.classList.remove('touch-active');
                }, 3000);
            });
        });
    }
})();
