@php
    use Illuminate\Support\Facades\Auth;
    $loggedUserId = Auth::id();
    // or Auth::user()->id
@endphp
<x-app-layout>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
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
    </style>
    <div class="d-flex min-vh-100" style="background: white;">
        <!-- Sidebar -->
        <div class="w-64 border-end p-4 bg-light">
            @include('web.sidebar')
        </div>

        <!-- Main content -->

        <div class="flex-grow-1 p-4">
            @if ($isValidPlan)
                @if ($total_mail_available)

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-6 d-flex justify-content-start mb-3" style="width:500px;">
                                    <input type="text" class="form-control" id="searchInput" placeholder="Search">
                                    <button class="btn btn-primary ms-3" id="searchBtn">Search</button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-end mb-3">
                                    <span class="fw-bold me-2" style="font-size:20px">Selected site:</span>
                                    <span id="selectedCount" style="font-size:20px">0</span>
                                    <button class="btn btn-primary ms-3" id="openMailModalBtn"
                                        data-available-mail="{{ $total_mail_available ?? 0 }}"
                                        data-total-mail="{{ $total_mail ?? 0 }}">
                                        Send Mail
                                    </button>
                                    <button class="btn btn-outline-danger ms-2" id="clearSelectionBtn">
                                        Clear All
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>


                    <table class="table  table-hover bg-white">
                        <div class="table-responsive">

                            <thead class="table-success text-center">
                                <tr>
                                    <th></th>
                                    <th>ID</th>
                                    <th>Website Name</th>
                                    <th>Site Url</th>
                                    <th>Website Niche</th>
                                    <th>DA</th>
                                    <th>DR</th>
                                    <th>Ahrefs Traffic</th>
                                    <th>Mail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($pagination)
                                    @foreach ($pagination as $blog)
                                        <!-- Main row -->
                                        <tr class="main-row cursor-pointer"
                                            data-target="#expandRow{{ $blog['blog_id'] }}"
                                            data-blog-id="{{ $blog['blog_id'] }}">
                                            <td class="text-center" onclick="event.stopPropagation();">
                                                <input type="checkbox" class="selectSiteCheckbox" 
                                                    value="{{ $blog['blog_id'] }}" onclick="event.stopPropagation();" autocomplete="off">
                                            </td>
                                            <td class="text-center">#{{ $blog['blog_id'] ?? '' }}</td>
                                            <td class="text-center">{{ $blog['website_name'] ?? '' }}</td>
                                            <td class="text-center">{{ $blog['site_url'] ?? '' }} </td>
                                            <td class="text-center">{{ $blog['website_niche'] ?? '' }}</td>
                                            <td class="text-center">{{ $blog['moz_da'] ?? '' }}</td>
                                            <td class="text-center">{{ $blog['ahrefs_dr'] ?? '' }}</td>
                                            <td class="text-center">{{ $blog['ahrefs_traffic'] ?? '' }}</td>
                                            <td class="text-center" onclick="event.stopPropagation();">
                                                <button class="btn btn-primary btn-sm rowMailBtn"
                                                    data-available-mail="{{ $total_mail_available ?? 0 }}"
                                                    data-total-mail="{{ $total_mail ?? 0 }}" id="openMailModalBtn"
                                                    data-url="{{ route('blog.viewMail', encrypt($blog['blog_id'])) }}">
                                                    Send Mail
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Expandable row (hidden by default) -->
                                        <tr class="expandable-row" id="expandRow{{ $blog['blog_id'] }}"
                                            style="display:none;">
                                            <td colspan="9" class="bg-light">
                                                <div>
                                                    <b>Website Name:</b> {{ $blog['website_name'] ?? '—' }} <br>
                                                    <b>Site URL:</b> {{ $blog['site_url'] ?? '—' }} <br>
                                                    <b>Website Niche:</b> {{ $blog['website_niche'] ?? '—' }} <br>
                                                    <b>Moz DA:</b> {{ $blog['moz_da'] ?? '—' }} <br>
                                                    <b>DR:</b> {{ $blog['ahrefs_dr'] ?? '—' }} <br>
                                                    <b>Ahrefs Traffic:</b> {{ $blog['ahrefs_traffic'] ?? '—' }}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="9" class="text-center" id="noResult">No blog found.</td>
                                    </tr>
                                @endif
                                <tr id="noResultsRow" style="display: none;">
                                    <td colspan="9" class="text-center  fw-bold">
                                        No blog found.
                                    </td>
                                </tr>
                            </tbody>
                        </div>
                    </table>
                    @if (isset($pagination))
                        <div class="d-flex justify-content-center mt-3">
                            {{ $pagination->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                @else
                <div
                    style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 20vh; text-align: center; gap: 5x;background:rgb(245, 243, 243);">
                    <p>
                    <h4>You have already used all mail services!</h4>
                    </p>
                    <a href="/#pricing"
                            id="nav-pricing"
                            class="pricing-link text-gray-700 hover:text-secondary font-medium transition-all duration-300 ease-in-out">
                                <button class="btn btn-primary" style="width: 100px; height: 40px;">Buy</button>
                    </a>
                </div>
                @endif
            @else
                <div
                    style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 20vh; text-align: center; gap: 5x;background:rgb(245, 243, 243);">
                    <p>
                    <h4>You have not purchased any plan.</h4>
                    </p>
                    <a href="/#pricing"
                            id="nav-pricing"
                            class="pricing-link text-gray-700 hover:text-secondary font-medium transition-all duration-300 ease-in-out">
                                <button class="btn btn-primary" style="width: 100px; height: 40px;">Buy</button>
                            </a>
                </div>
            @endif

        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="sendMailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="sendMailForm" class="mail-validation" method="POST" action="{{ route('blog.sendMail') }}"
                    enctype="multipart/form-data" novalidate>
                    @csrf
                    <input type="hidden" name="selected_ids" id="selectedIdsInput">
                    <input type="hidden" name="userId" id="userId" value="{{ $loggedUserId }}">
                    <input type="hidden" name="availableMail" id="availableMail"
                        value="{{ $total_mail_available->available_mail ?? 0 }}">

                    <div class="modal-header">
                        <h5 class="modal-title">Send Mail</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <p>Selected Site: <span id="modalSelectedCount">0</span></p>

                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <input type="text" class="form-control" name="subject" placeholder="Enter subject"
                                required>
                            <div class="invalid-feedback">Subject can not be blank!</div>
                            @error('subject')
                                {{ $message }}
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea id="summernote" name="message" required></textarea>
                            <input type="file" name="attachments[]" id="attachments" multiple
                                style="display:none">
                            <div class="invalid-feedback">Message can not be blank!</div>
                            @error('message')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Send Mail</button>
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

        $(document).ready(function() {
            // Restore checkbox states when page loads
            restoreCheckboxStates();

            // Handle checkbox changes
            $('.selectSiteCheckbox').on('change', handleCheckboxChange);

            // Clear all selections button
            $('#clearSelectionBtn').click(clearAllSelections);

            // Open modal button
            $('#openMailModalBtn').click(function(event) {
                event.preventDefault();

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
                new bootstrap.Modal(document.getElementById('sendMailModal')).show();
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

            // Summernote initialization
            $('#summernote').summernote({
                placeholder: 'Write your message...',
                height: 200,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline']],
                    ['font', ['fontname', 'fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture', 'video', 'fileUpload']]
                ],
                buttons: {
                    fileUpload: function(context) {
                        var ui = $.summernote.ui;
                        var button = ui.button({
                            contents: '<i class="fa fa-paperclip"/> File',
                            tooltip: 'Attach File',
                            click: function() {
                                $('#attachments').click();
                            }
                        });
                        return button.render();
                    }
                }
            });

            // File attachment handling
            let selectedFiles = [];
            $('#attachments').on('change', function() {
                let files = this.files;
                for (let i = 0; i < files.length; i++) {
                    let file = files[i];
                    const fileExists = selectedFiles.some(f => f.name === file.name && f.size === file.size);
                    if (!fileExists) {
                        selectedFiles.push(file);
                        // Create file badge in Summernote
                        var container = document.createElement('span');
                        container.style.cssText = 'display:inline-block;margin:2px 5px;padding:2px 5px;border:1px solid #ccc;border-radius:4px;background:#f1f1f1;';
                        container.setAttribute('contenteditable', 'false');

                        var fileName = document.createElement('span');
                        fileName.innerText = file.name;
                        fileName.style.marginRight = '5px';

                        var removeBtn = document.createElement('span');
                        removeBtn.innerHTML = '&times;';
                        removeBtn.style.color = 'red';
                        removeBtn.style.cursor = 'pointer';
                        removeBtn.style.marginLeft = '5px';
                        removeBtn.addEventListener('click', function() {
                            selectedFiles = selectedFiles.filter(f => f !== file);
                            container.remove();
                            updateFileInput();
                        });

                        container.appendChild(fileName);
                        container.appendChild(removeBtn);
                        $('#summernote').next('.note-editor').find('.note-editable').append(container).append(' ');
                    }
                }
                updateFileInput();
            });

            function updateFileInput() {
                const input = document.getElementById("attachments");
                const dataTransfer = new DataTransfer();
                selectedFiles.forEach(file => {
                    dataTransfer.items.add(file);
                });
                input.files = dataTransfer.files;
            }

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

            // Bootstrap validation
            (function() {
                'use strict'
                const forms = document.querySelectorAll('.mail-validation')
                Array.from(forms).forEach(form => {
                    form.addEventListener('submit', event => {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
            })();
        });

        // Clear selections when form is successfully submitted
        document.getElementById('sendMailForm').addEventListener('submit', function() {
            // Clear selections only if form is valid and will be submitted
            setTimeout(() => {
                localStorage.removeItem(SELECTED_BLOGS_STORAGE_KEY);
            }, 1000);
        });
    </script>

    <!-- SweetAlert for session messages -->
    <script>
        @if (Session::has('success'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: "{{ Session::get('success') }}",
                showConfirmButton: false,
                timer: 3000
            });
        @endif
        @if (Session::has('error'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: "{{ Session::get('error') }}",
                showConfirmButton: false,
                timer: 3000
            });
        @endif
    </script>

</x-app-layout>