@php
use Illuminate\Support\Facades\Auth;
$loggedUserId = Auth::id();
// or Auth::user()->id
@endphp
<x-app-layout>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- include summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* Fix for Summernote Bootstrap 5 compatibility */
        .note-editor .dropdown-toggle::after {
            display: none !important;
        }

        .note-editor .dropdown-menu {
            z-index: 1050 !important;
        }

        /* Ensure Summernote editor is visible */
        .note-editor.note-frame {
            display: block !important;
            visibility: visible !important;
        }

        /* Remove underline from all links */
        a {
            text-decoration: none !important;
        }

        /* Optional: hover effect for links */
        a:hover {
            text-decoration: none !important;
        }

        /* Style for selected rows */
        .selected-row {
            background-color: #e8f4fd !important;
        }

        /* Summernote custom styles */
        .note-editor.note-frame {
            border: 1px solid #d1d5db !important;
            border-radius: 0.375rem !important;
        }

        .note-editor.note-frame .note-toolbar {
            background-color: #f9fafb !important;
            border-bottom: 1px solid #d1d5db !important;
        }

        /* Pagination styling */
        .pagination {
            display: flex;
            list-style: none;
            gap: 0.5rem;
        }

        .page-link {
            padding: 0.5rem 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            color: #374151;
            transition: all 0.2s;
        }

        .page-link:hover {
            background-color: #f3f4f6;
        }

        .page-item.active .page-link {
            background-color: #3b82f6;
            color: white;
            border-color: #3b82f6;
        }

        .page-item.disabled .page-link {
            color: #9ca3af;
            cursor: not-allowed;
        }

        /* File list styles */
        .file-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.5rem;
            background-color: #f9fafb;
            border-radius: 0.375rem;
            margin-bottom: 0.25rem;
        }

        .file-item:hover {
            background-color: #f3f4f6;
        }

        .remove-file-btn {
            color: #ef4444;
            cursor: pointer;
            font-size: 1.25rem;
            line-height: 1;
            padding: 0.125rem 0.5rem;
            border-radius: 0.25rem;
        }

        .remove-file-btn:hover {
            background-color: #fee2e2;
        }

        #pagina-wrapper .flex-fill {
            display: none !important;
        }

        #pagina-wrapper nav {
            width: 100% !important;
        }

        #pagina-wrapper nav .d-none {
            display: flex !important;
            justify-content: space-between !important;
            width: 100% !important;
            flex-direction: row !important;
        }

        @media screen and (max-width: 500px) {
            #pagina-wrapper nav .d-none {
                flex-direction: column !important;
                gap: 1rem;
                align-items: center !important;
            }

        }
    </style>

    <div class="min-h-screen bg-white">
        <!-- Main content -->
        <div class="p-4 md:p-6">
            @if ($isValidPlan)
            @if ($total_mail_available)
            <div class="space-y-4 md:space-y-0 md:flex md:items-center md:justify-between">
                <!-- Search Section -->
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <input type="text"
                            id="searchInput"
                            placeholder="Search"
                            class="w-full md:w-64 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                    </div>
                    <button id="searchBtn"
                        class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                        Search
                    </button>
                </div>

                <!-- Selection Controls -->
                <div class="flex items-center space-x-3">
                    <div class="flex items-center space-x-2">
                        <span class="font-bold text-lg text-gray-700">Selected site:</span>
                        <span id="selectedCount" class="text-lg font-semibold text-blue-600">0</span>
                    </div>
                    <button id="openMailModalBtn"
                        data-available-mail="{{ $total_mail_available ?? 0 }}"
                        data-total-mail="{{ $total_mail ?? 0 }}"
                        class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                        Send Mail
                    </button>
                    <button id="clearSelectionBtn"
                        class="px-4 py-2 border border-red-600 text-red-600 font-medium rounded-lg hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition">
                        Clear All
                    </button>
                </div>
            </div>

            <!-- Table Container -->
            <div class="mt-6 overflow-x-auto bg-white rounded-lg shadow border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-green-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider"></th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Website Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Site Url</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Website Niche</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">DA</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">DR</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Ahrefs Traffic</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Mail</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @if ($pagination->isNotEmpty())
                        @foreach ($pagination as $blog)
                        <!-- Main row -->
                        <tr class="main-row hover:bg-gray-50 cursor-pointer transition"
                            data-target="#expandRow{{ $blog['blog_id'] }}"
                            data-blog-id="{{ $blog['blog_id'] }}">
                            <td class="px-6 py-4 whitespace-nowrap text-center" onclick="event.stopPropagation();">
                                <input type="checkbox"
                                    class="selectSiteCheckbox h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                    value="{{ $blog['blog_id'] }}"
                                    onclick="event.stopPropagation();"
                                    autocomplete="off">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">
                                #{{ $blog['blog_id'] ?? '' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">
                                {{ $blog['website_name'] ?? '' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">
                                {{ $blog['site_url'] ?? '' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">
                                {{ $blog['website_niche'] ?? '' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">
                                {{ $blog['moz_da'] ?? '' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">
                                {{ $blog['ahrefs_dr'] ?? '' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">
                                {{ $blog['ahrefs_traffic'] ?? '' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm" onclick="event.stopPropagation();">
                                <button class="rowMailBtn px-3 py-1 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition"
                                    data-available-mail="{{ $total_mail_available ?? 0 }}"
                                    data-total-mail="{{ $total_mail ?? 0 }}"
                                    data-url="{{ route('blog.viewMail', encrypt($blog['blog_id'])) }}">
                                    Send Mail
                                </button>
                            </td>
                        </tr>

                        <!-- Expandable row (hidden by default) -->
                        <tr class="expandable-row bg-gray-50"
                            id="expandRow{{ $blog['blog_id'] }}"
                            style="display:none;">
                            <td colspan="9" class="px-6 py-4">
                                <div class="space-y-1">
                                    <div><b>Website Name:</b> {{ $blog['website_name'] ?? '—' }}</div>
                                    <div><b>Site URL:</b> {{ $blog['site_url'] ?? '—' }}</div>
                                    <div><b>Website Niche:</b> {{ $blog['website_niche'] ?? '—' }}</div>
                                    <div><b>Moz DA:</b> {{ $blog['moz_da'] ?? '—' }}</div>
                                    <div><b>DR:</b> {{ $blog['ahrefs_dr'] ?? '—' }}</div>
                                    <div><b>Ahrefs Traffic:</b> {{ $blog['ahrefs_traffic'] ?? '—' }}</div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="9" class="px-6 py-8 text-center text-gray-500">
                                No blog found.
                            </td>
                        </tr>
                        @endif
                        <tr id="noResultsRow" style="display: none;">
                            <td colspan="9" class="px-6 py-8 text-center text-gray-700 font-bold">
                                No blog found.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            @if (isset($pagination))
            <div id="pagina-wrapper" class="mt-6 flex justify-center">
                {{ $pagination->links('pagination::bootstrap-5') }}
            </div>
            @endif
            @else
            <div class="flex flex-col items-center justify-center p-8 bg-gray-50 rounded-lg">
                <h4 class="text-xl font-semibold text-gray-700 mb-4">
                    You have already used all mail services!
                </h4>
                <a href="/#pricing"
                    class="pricing-link text-gray-700 hover:text-blue-600 font-medium transition-colors duration-300">
                    <button class="px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                        Buy
                    </button>
                </a>
            </div>
            @endif
            @else
            <div class="flex flex-col items-center justify-center p-8 bg-gray-50 rounded-lg">
                <h4 class="text-xl font-semibold text-gray-700 mb-4">
                    You have not purchased any plan.
                </h4>
                <a href="/#pricing"
                    class="pricing-link text-gray-700 hover:text-blue-600 font-medium transition-colors duration-300">
                    <button class="px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                        Buy
                    </button>
                </a>
            </div>
            @endif
        </div>
    </div>

    <!-- Modal -->
    <div id="sendMailModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <!-- Modal panel -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                <form id="sendMailForm" class="mail-validation" method="POST" action="{{ route('blog.sendMail') }}"
                    enctype="multipart/form-data" novalidate>
                    @csrf
                    <input type="hidden" name="selected_ids" id="selectedIdsInput">
                    <input type="hidden" name="userId" id="userId" value="{{ $loggedUserId }}">
                    <input type="hidden" name="availableMail" id="availableMail"
                        value="{{ $total_mail_available->available_mail ?? 0 }}">

                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Send Mail
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 mb-4">
                                        Selected Site: <span id="modalSelectedCount" class="font-semibold">0</span>
                                    </p>

                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                Subject
                                            </label>
                                            <input type="text"
                                                name="subject"
                                                placeholder="Enter subject"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                                required>
                                            <div class="mt-1 text-sm text-red-600 hidden">Subject can not be blank!</div>
                                            @error('subject')
                                            <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                Message
                                            </label>
                                            <textarea id="summernote"
                                                name="message"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                                required></textarea>
                                            <div class="mt-1 text-sm text-red-600 hidden">Message can not be blank!</div>
                                            @error('message')
                                            <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                Attachments
                                            </label>
                                            <div class="flex items-center space-x-2">
                                                <input type="file"
                                                    name="attachments[]"
                                                    id="attachments"
                                                    multiple
                                                    class="block w-full text-sm text-gray-500
                                                              file:mr-4 file:py-2 file:px-4
                                                              file:rounded-md file:border-0
                                                              file:text-sm file:font-medium
                                                              file:bg-blue-50 file:text-blue-700
                                                              hover:file:bg-blue-100">
                                                <button type="button"
                                                    id="clearAttachmentsBtn"
                                                    class="px-3 py-2 text-sm text-red-600 hover:text-red-800 hidden">
                                                    Clear All
                                                </button>
                                            </div>
                                            <div id="fileList" class="mt-2 space-y-1"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm transition">
                            Send Mail
                        </button>
                        <button type="button"
                            id="closeModalBtn"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Storage key for selected blogs
        const SELECTED_BLOGS_STORAGE_KEY = 'selectedBlogs';

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

        // Summernote state management
        let summernoteInitialized = false;

        function initializeSummernote() {
            console.log('Initializing Summernote...');

            // Remove any existing Summernote instance first
            if ($('#summernote').summernote('instance')) {
                $('#summernote').summernote('destroy');
            }

            // Also remove any existing .note-editor divs
            $('.note-editor').remove();

            // Show the textarea
            $('#summernote').show().css('display', 'block');

            // Initialize Summernote
            $('#summernote').summernote({
                placeholder: 'Write your message...',
                height: 200,
                focus: true,
                dialogsInBody: true, // Important for modals
                toolbar: [
                    ['style', ['bold', 'italic', 'underline']],
                    ['font', ['fontname', 'fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture', 'video']]
                ],
                callbacks: {
                    onInit: function() {
                        console.log('Summernote initialized successfully');
                        summernoteInitialized = true;

                        // Fix for Bootstrap 5 compatibility
                        $('.note-editor .dropdown-toggle').attr('data-bs-toggle', 'dropdown');
                        $('.note-editor .dropdown-toggle').removeAttr('data-toggle');
                    },
                    onBlur: function() {
                        // Update the hidden textarea value
                        $('#summernote').val($('#summernote').summernote('code'));
                    }
                }
            });
        }

        function destroySummernote() {
            console.log('Destroying Summernote...');
            if ($('#summernote').summernote('instance')) {
                $('#summernote').summernote('destroy');
            }
            summernoteInitialized = false;
            // Make sure textarea is visible after destroying
            $('#summernote').show().css('display', 'block');
        }

        // Modal functions
        function openModal() {
            console.log('Opening modal...');

            // Show the modal
            const modal = document.getElementById('sendMailModal');
            modal.classList.remove('hidden');

            // Reset form
            $('#sendMailForm')[0].reset();
            selectedFiles = [];
            $('#fileList').empty();
            $('#clearAttachmentsBtn').addClass('hidden');

            // Initialize Summernote after a brief delay to ensure DOM is ready
            setTimeout(() => {
                initializeSummernote();
            }, 100);
        }

        function closeModal() {
            console.log('Closing modal...');

            // Hide the modal
            const modal = document.getElementById('sendMailModal');
            modal.classList.add('hidden');

            // Destroy Summernote
            destroySummernote();
        }

        // File attachment handling
        let selectedFiles = [];

        function updateFileInput() {
            const input = document.getElementById("attachments");
            const dataTransfer = new DataTransfer();
            selectedFiles.forEach(file => {
                dataTransfer.items.add(file);
            });
            input.files = dataTransfer.files;
        }

        $(document).ready(function() {
            console.log('Document ready...');

            // Initial debug check
            console.log('Summernote instances on load:', $('.note-editor').length);
            console.log('Textarea visible on load?', $('#summernote').is(':visible'));

            // Restore checkbox states when page loads
            restoreCheckboxStates();

            // Handle checkbox changes
            $('.selectSiteCheckbox').on('change', handleCheckboxChange);

            // Clear all selections button
            $('#clearSelectionBtn').click(clearAllSelections);

            // Open modal button
            $('#openMailModalBtn').click(function(event) {
                event.preventDefault();
                console.log('Open modal button clicked');

                const availableMail = $(this).data('available-mail');
                const total_mail = $(this).data('total-mail');
                const selectedBlogs = getSelectedBlogs();

                // Validation checks
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

                // Set selected IDs in hidden field and open modal
                $('#selectedIdsInput').val(JSON.stringify(selectedBlogs));
                openModal();
            });

            // Close modal button
            $('#closeModalBtn').click(closeModal);

            // Close modal when clicking outside
            document.getElementById('sendMailModal').addEventListener('click', function(e) {
                if (e.target.id === 'sendMailModal') {
                    closeModal();
                }
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

                        // Add to file list display
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

            $("#searchBtn").click(function() {
                filterBlogs();
            });

            $("#searchInput").on("keyup", function() {
                filterBlogs();
            });

            // Form validation
            $('#sendMailForm').on('submit', function(e) {
                let isValid = true;
                const form = $(this);

                // Reset previous validation
                form.find('.text-red-600').addClass('hidden');
                form.find('input, textarea').removeClass('border-red-500').addClass('border-gray-300');

                // Check subject
                const subject = form.find('input[name="subject"]').val().trim();
                if (!subject) {
                    form.find('input[name="subject"]').next('.text-red-600').removeClass('hidden');
                    form.find('input[name="subject"]').removeClass('border-gray-300').addClass('border-red-500');
                    isValid = false;
                }

                // Check message - get content from Summernote
                let message = '';
                if ($('#summernote').summernote('instance')) {
                    message = $('#summernote').summernote('code').replace(/<[^>]*>/g, '').trim();
                } else {
                    message = $('#summernote').val().trim();
                }

                if (!message) {
                    form.find('textarea[name="message"]').next('.text-red-600').removeClass('hidden');
                    isValid = false;
                }

                if (!isValid) {
                    e.preventDefault();
                    return false;
                }

                // Clear selections only if form is valid and will be submitted
                setTimeout(() => {
                    localStorage.removeItem(SELECTED_BLOGS_STORAGE_KEY);
                }, 1000);
            });

            // Debug function to check Summernote state
            window.debugSummernote = function() {
                console.log('Summernote debug:');
                console.log('Instance exists:', $('#summernote').summernote('instance'));
                console.log('Textarea visible:', $('#summernote').is(':visible'));
                console.log('Textarea value:', $('#summernote').val());
                console.log('Summernote HTML:', $('#summernote').summernote('code'));
                console.log('Note editor elements:', $('.note-editor').length);
            };
        });
    </script>

</x-app-layout>