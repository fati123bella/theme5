/**
 * Customizer Import/Export JavaScript
 * Handles export and import of theme settings
 */

(function($) {
    'use strict';

    wp.customize.bind('ready', function() {

        // ========================================
        // EXPORT FUNCTIONALITY
        // ========================================

        $('.cozyrecipes-export-btn').on('click', function(e) {
            e.preventDefault();

            var button = $(this);
            var originalText = button.val();

            // Disable button and show loading state
            button.prop('disabled', true).val(cozyrecipesCustomizer.strings.exporting);

            // Make AJAX request to export settings
            $.ajax({
                url: cozyrecipesCustomizer.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'cozyrecipes_export_settings',
                    nonce: cozyrecipesCustomizer.exportNonce
                },
                success: function(response) {
                    if (response.success) {
                        // Create JSON file and download it
                        var dataStr = JSON.stringify(response.data, null, 2);
                        var dataBlob = new Blob([dataStr], { type: 'application/json' });

                        // Create download link
                        var url = window.URL.createObjectURL(dataBlob);
                        var link = document.createElement('a');
                        link.href = url;

                        // Generate filename with date
                        var date = new Date();
                        var filename = 'cozyrecipes-settings-' +
                                     date.getFullYear() +
                                     ('0' + (date.getMonth() + 1)).slice(-2) +
                                     ('0' + date.getDate()).slice(-2) +
                                     '-' +
                                     ('0' + date.getHours()).slice(-2) +
                                     ('0' + date.getMinutes()).slice(-2) +
                                     '.json';

                        link.download = filename;
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                        window.URL.revokeObjectURL(url);

                        // Show success notification
                        showNotification('success', 'Settings exported successfully!');
                    } else {
                        showNotification('error', response.data.message || cozyrecipesCustomizer.strings.exportError);
                    }
                },
                error: function() {
                    showNotification('error', cozyrecipesCustomizer.strings.exportError);
                },
                complete: function() {
                    // Re-enable button
                    button.prop('disabled', false).val(originalText);
                }
            });
        });

        // ========================================
        // IMPORT FUNCTIONALITY
        // ========================================

        $('.cozyrecipes-import-btn').on('click', function(e) {
            e.preventDefault();

            var button = $(this);
            var textarea = $('.cozyrecipes-import-textarea');
            var importData = textarea.val().trim();

            // Validate import data
            if (!importData) {
                showNotification('error', cozyrecipesCustomizer.strings.importEmpty);
                return;
            }

            // Confirm before importing
            if (!confirm(cozyrecipesCustomizer.strings.confirmImport)) {
                return;
            }

            var originalText = button.val();

            // Disable button and show loading state
            button.prop('disabled', true).val(cozyrecipesCustomizer.strings.importing);
            textarea.prop('disabled', true);

            // Make AJAX request to import settings
            $.ajax({
                url: cozyrecipesCustomizer.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'cozyrecipes_import_settings',
                    nonce: cozyrecipesCustomizer.importNonce,
                    import_data: importData
                },
                success: function(response) {
                    if (response.success) {
                        showNotification('success', response.data.message || cozyrecipesCustomizer.strings.importSuccess);

                        // Reload customizer after a short delay to show changes
                        setTimeout(function() {
                            wp.customize.previewer.refresh();
                            location.reload();
                        }, 1500);
                    } else {
                        showNotification('error', response.data.message || cozyrecipesCustomizer.strings.importError);
                        button.prop('disabled', false).val(originalText);
                        textarea.prop('disabled', false);
                    }
                },
                error: function() {
                    showNotification('error', cozyrecipesCustomizer.strings.importError);
                    button.prop('disabled', false).val(originalText);
                    textarea.prop('disabled', false);
                }
            });
        });

        // ========================================
        // FILE UPLOAD HELPER
        // ========================================

        // Add file upload button after export button
        var fileUploadHtml = '<div style="margin-top: 15px;">' +
            '<label class="button button-secondary" for="cozyrecipes-import-file" style="display: inline-block; margin-right: 10px;">' +
            'Choose File' +
            '</label>' +
            '<input type="file" id="cozyrecipes-import-file" accept=".json" style="display: none;">' +
            '<span id="cozyrecipes-file-name" style="font-size: 12px; color: #666;"></span>' +
            '</div>';

        $('.cozyrecipes-export-btn').parent().after(fileUploadHtml);

        // Handle file upload
        $('#cozyrecipes-import-file').on('change', function(e) {
            var file = e.target.files[0];

            if (file) {
                $('#cozyrecipes-file-name').text(file.name);

                var reader = new FileReader();
                reader.onload = function(event) {
                    $('.cozyrecipes-import-textarea').val(event.target.result);
                };
                reader.readAsText(file);
            }
        });

        // ========================================
        // NOTIFICATION HELPER
        // ========================================

        function showNotification(type, message) {
            var notificationClass = type === 'success' ? 'notice-success' : 'notice-error';
            var notification = $('<div class="notice ' + notificationClass + ' is-dismissible"><p>' + message + '</p></div>');

            // Find customizer notifications area or create one
            var notificationsArea = $('.customize-notifications-area');
            if (notificationsArea.length === 0) {
                notificationsArea = $('<div class="customize-notifications-area"></div>');
                $('.wp-full-overlay-sidebar-content').prepend(notificationsArea);
            }

            notificationsArea.append(notification);

            // Add dismiss button functionality
            notification.find('.notice-dismiss').on('click', function() {
                notification.fadeOut(300, function() {
                    $(this).remove();
                });
            });

            // Auto-remove after 5 seconds
            setTimeout(function() {
                notification.fadeOut(300, function() {
                    $(this).remove();
                });
            }, 5000);
        }
    });

})(jQuery);
