// public/js/summernote/blog-mail.js

// Check if dependencies are loaded
(function() {
    // Wait for DOM to be ready
    document.addEventListener('DOMContentLoaded', function() {
        // Check if jQuery is loaded
        if (typeof jQuery === 'undefined') {
            console.error('jQuery is not loaded');
            return;
        }
        
        // Check if Summernote is loaded
        if (typeof $.fn.summernote === 'undefined') {
            console.error('Summernote is not loaded');
            return;
        }
        
        // Check if Swal is loaded
        if (typeof Swal === 'undefined') {
            console.error('SweetAlert2 is not loaded');
            return;
        }
        
        // Initialize after a short delay to ensure everything is ready
        setTimeout(initializeBlogMail, 100);
    });
    
    function initializeBlogMail() {
        // Storage key for selected blogs
        const SELECTED_BLOGS_STORAGE_KEY = 'selectedBlogs';
        
        // Global variable to track Summernote state
        let summernoteInitialized = false;
        let isModalOpen = false;
        let summernoteInstance = null;
        let selectedFiles = [];
        
        // Function to get selected blogs from localStorage
        function getSelectedBlogs() {
            const stored = localStorage.getItem(SELECTED_BLOGS_STORAGE_KEY);
            return stored ? JSON.parse(stored) : [];
        }
        
        // Function to save selected blogs to localStorage
        function saveSelectedBlogs(selectedBlogs) {
            localStorage.setItem(SELECTED_BLOGS_STORAGE_KEY, JSON.stringify(selectedBlogs));
        }
        
        // Function to update selected count display
        function updateSelectedCount() {
            const selectedBlogs = getSelectedBlogs();
            const count = selectedBlogs.length;
            $('#selectedCount').text(count);
            $('#modalSelectedCount').text(count);
        }
        
        // Function to restore checkbox states on page load
        function restoreCheckboxStates() {
            const selectedBlogs = getSelectedBlogs();
            
            // Check checkboxes for selected blogs on current page
            $('.selectSiteCheckbox').each(function() {
                const blogId = $(this).val();
                if (selectedBlogs.includes(blogId)) {
                    $(this).prop('checked', true);
                    $(this).closest('tr').addClass('selected-row');
                } else {
                    $(this).prop('checked', false);
                    $(this).closest('tr').removeClass('selected-row');
                }
            });
            
            updateSelectedCount();
        }
        
        // Function to handle checkbox change
        function handleCheckboxChange() {
            const blogId = $(this).val();
            const isChecked = $(this).is(':checked');
            let selectedBlogs = getSelectedBlogs();
            
            if (isChecked) {
                // Add to selection if not already there
                if (!selectedBlogs.includes(blogId)) {
                    selectedBlogs.push(blogId);
                    $(this).closest('tr').addClass('selected-row');
                }
            } else {
                // Remove from selection
                selectedBlogs = selectedBlogs.filter(id => id !== blogId);
                $(this).closest('tr').removeClass('selected-row');
            }
            
            saveSelectedBlogs(selectedBlogs);
            updateSelectedCount();
        }
        
        // Function to clear all selections
        function clearAllSelections() {
            Swal.fire({
                title: 'Clear All Selections?',
                text: "This will remove all selected blogs across all pages.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, clear all!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    localStorage.removeItem(SELECTED_BLOGS_STORAGE_KEY);
                    $('.selectSiteCheckbox').prop('checked', false);
                    $('.main-row').removeClass('selected-row');
                    updateSelectedCount();
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Cleared!',
                        text: 'All selections have been cleared.',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            });
        }
        
        // Proper Summernote Lite initialization
        function initializeSummernote() {
            console.log('Initializing Summernote Lite...');
            
            // Destroy previous instance if exists
            if (summernoteInitialized && summernoteInstance) {
                try {
                    summernoteInstance.summernote('destroy');
                } catch (e) {
                    console.warn('Error destroying previous instance:', e);
                }
                summernoteInitialized = false;
                summernoteInstance = null;
            }
            
            // Clear and prepare the editor container
            $('#summernote-editor').empty().html('<textarea id="summernote-lite"></textarea>');
            
            // Initialize Summernote Lite
            try {
                setTimeout(() => {
                    summernoteInstance = $('#summernote-lite');
                    
                    summernoteInstance.summernote({
                        placeholder: 'Write your message...',
                        height: 200,
                        focus: false,
                        dialogsInBody: true,
                        disableResizeEditor: true,
                        toolbar: [
                            ['style', ['style']],
                            ['font', ['bold', 'italic', 'underline', 'clear']],
                            ['fontname', ['fontname']],
                            ['color', ['color']],
                            ['para', ['ul', 'ol', 'paragraph']],
                            ['height', ['height']],
                            ['insert', ['link', 'picture']],
                            ['view', ['fullscreen', 'codeview']]
                        ],
                        popover: {
                            image: [
                                ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
                                ['float', ['floatLeft', 'floatRight', 'floatNone']],
                                ['remove', ['removeMedia']]
                            ],
                            link: [
                                ['link', ['linkDialogShow', 'unlink']]
                            ]
                        },
                        callbacks: {
                            onInit: function() {
                                console.log('Summernote Lite initialized successfully');
                                summernoteInitialized = true;
                                
                                // Apply custom styling
                                setTimeout(() => {
                                    $('.note-editor').css({
                                        'border': '1px solid #d1d5db',
                                        'border-radius': '0.375rem'
                                    });
                                    
                                    $('.note-toolbar').css({
                                        'background-color': '#f9fafb',
                                        'border-bottom': '1px solid #d1d5db',
                                        'border-radius': '0.375rem 0.375rem 0 0'
                                    });
                                    
                                    $('.note-btn').css({
                                        'background': 'transparent',
                                        'border': '1px solid #d1d5db',
                                        'border-radius': '0.25rem',
                                        'margin': '1px'
                                    });
                                    
                                    $('.note-btn').removeAttr('title');
                                    $('.note-btn').off('mouseenter mouseleave');
                                    
                                    $('.note-editable').css({
                                        'min-height': '150px',
                                        'padding': '0.5rem'
                                    });
                                    
                                    $('.tooltip').remove();
                                }, 100);
                            },
                            onChange: function(contents) {
                                $('#summernote').val(contents);
                            },
                            onBlur: function() {
                                $('#summernote').val(summernoteInstance.summernote('code'));
                            }
                        }
                    });
                    
                }, 100);
                
            } catch (error) {
                console.error('Summernote Lite initialization error:', error);
                $('#summernote-editor').html('<textarea id="fallback-textarea" class="w-full h-48 border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Write your message..."></textarea>');
                $('#fallback-textarea').on('input', function() {
                    $('#summernote').val($(this).val());
                });
            }
        }
        
        // Clean up Summernote properly
        function destroySummernote() {
            console.log('Destroying Summernote...');
            
            if (summernoteInitialized && summernoteInstance) {
                try {
                    const content = summernoteInstance.summernote('code');
                    $('#summernote').val(content);
                    summernoteInstance.summernote('destroy');
                } catch (e) {
                    console.log('Error destroying Summernote:', e);
                } finally {
                    $('#summernote-editor').empty();
                    summernoteInitialized = false;
                    summernoteInstance = null;
                }
            }
        }
        
        // Modal functions
        function openModal() {
            console.log('Opening modal...');
            isModalOpen = true;
            
            const modal = document.getElementById('sendMailModal');
            modal.classList.remove('hidden');
            
            setTimeout(() => {
                modal.classList.add('active');
            }, 10);
            
            $('#sendMailForm')[0].reset();
            selectedFiles = [];
            $('#fileList').empty();
            $('#clearAttachmentsBtn').addClass('hidden');
            $('#summernote').val('');
            
            setTimeout(() => {
                if (isModalOpen) {
                    initializeSummernote();
                }
            }, 300);
        }
        
        function closeModal() {
            console.log('Closing modal...');
            isModalOpen = false;
            
            if (summernoteInstance && summernoteInitialized) {
                const content = summernoteInstance.summernote('code');
                $('#summernote').val(content);
            }
            
            const modal = document.getElementById('sendMailModal');
            modal.classList.remove('active');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                destroySummernote();
            }, 300);
        }
        
        // File attachment handling
        function updateFileInput() {
            const input = document.getElementById("attachments");
            const dataTransfer = new DataTransfer();
            selectedFiles.forEach(file => {
                dataTransfer.items.add(file);
            });
            input.files = dataTransfer.files;
        }
        
        // Event bindings
        $(document).ready(function() {
            console.log('Blog mail script initialized');
            
            // Restore checkbox states
            restoreCheckboxStates();
            
            // Handle checkbox changes
            $(document).on('change', '.selectSiteCheckbox', handleCheckboxChange);
            
            // Clear all selections button
            $('#clearSelectionBtn').click(clearAllSelections);
            
            // Open modal button
            $('#openMailModalBtn').click(function(event) {
                event.preventDefault();
                
                const availableMail = $(this).data('available-mail');
                const total_mail = $(this).data('total-mail');
                const selectedBlogs = getSelectedBlogs();
                
                if (selectedBlogs.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Please select at least one site!',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2500
                    });
                    return;
                }
                
                if (availableMail <= 0 && availableMail <= total_mail) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'No Mail Available!',
                        text: 'Please purchase a package to send emails',
                        confirmButtonText: 'Buy Now',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "#";
                        }
                    });
                    return;
                }
                
                if (availableMail > total_mail) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Mail Available Issue!',
                        text: 'Please check available mail and total mail',
                        confirmButtonText: 'Buy Now',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "#";
                        }
                    });
                    return;
                }
                
                if (selectedBlogs.length > availableMail && availableMail <= total_mail) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Mail Limit Exceeded!',
                        text: `You can only send ${availableMail} mails. You selected ${selectedBlogs.length}.`,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    return;
                }
                
                $('#selectedIdsInput').val(JSON.stringify(selectedBlogs));
                openModal();
            });
            
            // Individual row Send Mail button
            $('.rowMailBtn').click(function(event) {
                let availableMail = $(this).data('available-mail');
                let total_mail = $(this).data('total-mail');
                let url = $(this).data('url');
                
                if (availableMail > total_mail) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Mail Available Issue!',
                        text: 'Please check available mail and total mail',
                        confirmButtonText: 'Buy Now',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "#";
                        }
                    });
                    return;
                }
                
                if (availableMail <= 0 && availableMail <= total_mail) {
                    event.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'No Mail Available!',
                        text: 'Please purchase a package to send emails.',
                        confirmButtonText: 'Buy Now',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "#";
                        }
                    });
                } else {
                    window.location.href = url;
                }
            });
            
            // File attachment handling
            $('#attachments').on('change', function() {
                let files = Array.from(this.files);
                
                files.forEach(file => {
                    const fileExists = selectedFiles.some(f => f.name === file.name && f.size === file.size);
                    if (!fileExists) {
                        selectedFiles.push(file);
                        
                        $('#fileList').append(`
                            <div class="file-item" data-file-name="${file.name}">
                                <span class="text-sm text-gray-700">${file.name} (${(file.size / 1024).toFixed(1)} KB)</span>
                                <button type="button" 
                                        class="remove-file-btn"
                                        data-file-name="${file.name}">
                                    &times;
                                </button>
                            </div>
                        `);
                    }
                });
                
                updateFileInput();
                $('#clearAttachmentsBtn').toggleClass('hidden', selectedFiles.length === 0);
            });
            
            // Remove individual file
            $(document).on('click', '.remove-file-btn', function() {
                const fileName = $(this).data('file-name');
                selectedFiles = selectedFiles.filter(file => file.name !== fileName);
                $(`[data-file-name="${fileName}"]`).remove();
                updateFileInput();
                $('#clearAttachmentsBtn').toggleClass('hidden', selectedFiles.length === 0);
            });
            
            // Clear all files
            $('#clearAttachmentsBtn').click(function() {
                selectedFiles = [];
                $('#fileList').empty();
                updateFileInput();
                $(this).addClass('hidden');
            });
            
            // Toggle expandable row on main row click
            $('.main-row').click(function() {
                var targetId = $(this).data('target');
                var $targetRow = $(targetId);
                $('.expandable-row').not($targetRow).slideUp();
                $targetRow.slideToggle();
            });
            
            // Search functionality
            function filterBlogs() {
                let value = $("#searchInput").val().toLowerCase();
                let matched = 0;
                
                $("table tbody tr.main-row").each(function() {
                    let rowText = $(this).text().toLowerCase();
                    let targetRow = $($(this).data("target"));
                    
                    if (rowText.indexOf(value) > -1) {
                        $(this).show();
                        targetRow.hide();
                        matched++;
                    } else {
                        $(this).hide();
                        targetRow.hide();
                    }
                });
                
                if (matched === 0) {
                    $("#noResultsRow").show();
                } else {
                    $("#noResultsRow").hide();
                }
            }
            
            $("#searchBtn").click(filterBlogs);
            $("#searchInput").on("keyup", filterBlogs);
            
            // Form validation
            $('#sendMailForm').on('submit', function(e) {
                let isValid = true;
                const form = $(this);
                
                form.find('.text-red-600').addClass('hidden');
                form.find('input, textarea').removeClass('border-red-500').addClass('border-gray-300');
                
                const subject = form.find('input[name="subject"]').val().trim();
                if (!subject) {
                    form.find('input[name="subject"]').next('.text-red-600').removeClass('hidden');
                    form.find('input[name="subject"]').removeClass('border-gray-300').addClass('border-red-500');
                    isValid = false;
                }
                
                let message = $('#summernote').val().trim();
                if (!message || message === '<p><br></p>' || message === '<p></p>') {
                    form.find('textarea[name="message"]').next('.text-red-600').removeClass('hidden');
                    isValid = false;
                }
                
                if (!isValid) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Please fill in all required fields correctly.',
                        confirmButtonText: 'OK'
                    });
                    return false;
                }
                
                setTimeout(() => {
                    localStorage.removeItem(SELECTED_BLOGS_STORAGE_KEY);
                }, 1000);
            });
            
            // Close modal with Escape key
            $(document).keyup(function(e) {
                if (e.key === "Escape" && isModalOpen) {
                    closeModal();
                }
            });
            
            // Close modal when clicking outside
            $(document).on('click', '#sendMailModal .fixed.inset-0', function(e) {
                if (e.target === this && isModalOpen) {
                    closeModal();
                }
            });
        });
    }
})();