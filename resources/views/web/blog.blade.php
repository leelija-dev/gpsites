@php
    use Illuminate\Support\Facades\Auth;
    $loggedUserId = Auth::id(); // or Auth::user()->id
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
    </style>
    <div class="d-flex min-vh-100">
        <!-- Sidebar -->
        <div class="w-64 border-end p-4 bg-light">
            @include('web.sidebar')
        </div>

        <!-- Main content -->
        <div class="flex-grow-1 p-4">

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
                            {{-- @if ($mail_available->available_mail <= 0)
                <button class="btn btn-primary ms-3" id="notMailAvailable">Send Mail</button>
                @else
                <button class="btn btn-primary ms-3" id="openMailModalBtn">Send Mail</button>
                @endif --}}
                            <button class="btn btn-primary ms-3" id="openMailModalBtn"
                                data-available-mail="{{ $mail_available->available_mail ?? 0 }}"
                                data-total-mail="{{ $mail_available->total_mail ?? 0 }}"
                                >
                                Send Mail
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
                            @foreach ($pagination['data'] as $blog)
                                <!-- Main row -->
                                <tr class="main-row cursor-pointer" data-target="#expandRow{{ $blog['blog_id'] }}">
                                    <td class="text-center" onclick="event.stopPropagation();">
                                        <input type="checkbox" class="selectSiteCheckbox" value="{{ $blog['blog_id'] }}"
                                            onclick="event.stopPropagation();">
                                    </td>
                                    <td class="text-center">#{{ $blog['blog_id'] ?? '' }}</td>
                                    <td class="text-center">{{ $blog['website_name'] ?? '' }}</td>
                                    <td class="text-center">{{ $blog['site_url'] ?? '' }} </td>
                                    <td class="text-center">{{ $blog['website_niche'] ?? ''}}</td>
                                    <td class="text-center">{{ $blog['moz_da'] ?? ''}}</td>
                                    <td class="text-center">{{ $blog['ahrefs_dr'] ?? ''}}</td>
                                    <td class="text-center">{{ $blog['ahrefs_traffic'] ?? ''}}</td>
                                    <td class="text-center" onclick="event.stopPropagation();">
                                        {{-- <a href="{{ route('blog.viewMail', encrypt($blog['created_by'])) }}"><button
                                            class="btn btn-primary btn-sm">Send Mail</button> </a> --}}

                                        <button class="btn btn-primary btn-sm rowMailBtn"
                                            data-available-mail="{{ $mail_available->available_mail ?? 0 }}"
                                            data-total-mail="{{ $mail_available->total_mail ?? 0 }}"
                                            id="openMailModalBtn"
                                            data-url="{{ route('blog.viewMail', encrypt($blog['blog_id'])) }}">
                                            Send Mail
                                        </button>

                                    </td>
                                </tr>

                                <!-- Expandable row (hidden by default) -->
                                <tr class="expandable-row" id="expandRow{{ $blog['blog_id'] }}" style="display:none;">
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
            
            {{-- @if (isset($pagination))
                <div class="d-flex justify-content-center mt-3">
                    {{ $pagination->links('pagination::bootstrap-5') }}
                </div>
            @endif --}}
                </table>
        </div>
    </div>

    <!-- Modal -->
    <!-- Modal -->
    <div class="modal fade" id="sendMailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Form pointing to your route -->
                <form id="sendMailForm" class="mail-validation" method="POST" action="{{ route('blog.sendMail') }}"
                   enctype="multipart/form-data" novalidate>
                    @csrf
                    <!-- Hidden input to hold selected blog IDs -->
                    <input type="hidden" name="selected_ids" id="selectedIdsInput">
                    <input type="hidden" name="userId" id="userId" value="{{ $loggedUserId }}">
                    <input type="hidden" name="availableMail" id="availableMail"
                        value="{{ $mail_available->available_mail ?? 0 }}">

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
                            <input type="file" name="attachments[]" id="attachments" multiple style="display:none">
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
        // $(document).ready(function() {
        //     // Update counter when checkbox changes
        //     $('.selectSiteCheckbox').on('change', function() {
        //         let count = $('.selectSiteCheckbox:checked').length;
        //         $('#selectedCount').text(count);
        //         $('#modalSelectedCount').text(count);
        //     });

        //     // Open modal button
        //     $('#openMailModalBtn').click(function() {
        //         let selectedIds = [];
        //         $('.selectSiteCheckbox:checked').each(function() {
        //             selectedIds.push($(this).val());
        //         });

        //         if (selectedIds.length === 0) {
        //             Swal.fire({
        //                 icon: 'warning',
        //                 title: 'Please select at least one site!',
        //                 toast: true,
        //                 position: 'top-end',
        //                 showConfirmButton: false,
        //                 timer: 2500
        //             });
        //             return;
        //         }

        //         // Set hidden input value
        //         $('#selectedIdsInput').val(JSON.stringify(selectedIds));

        //         // Show modal
        //         new bootstrap.Modal(document.getElementById('sendMailModal')).show();
        //     });

        //     // Submit Summernote content
        //     $('#sendMailForm').on('submit', function() {
        //         var content = $('#summernote').summernote('code');
        //         $(this).append('<input type="hidden" name="message_html" value="' + encodeURIComponent(
        //             content) + '">');
        //     });

        //     // Initialize Summernote
        //     $('#summernote').summernote({
        //         placeholder: 'Write your message...',
        //         height: 200
        //     });
        // });
        $(document).ready(function() {
            //Update counter when checkbox changes
            $('.selectSiteCheckbox').on('change', function() {
                let count = $('.selectSiteCheckbox:checked').length;
                $('#selectedCount').text(count);

            });
            $('#openMailModalBtn').click(function(event) {
                event.preventDefault(); // Prevent modal from auto opening
    
                let availableMail = $(this).data('available-mail');
                let total_mail=$(this).data('total-mail');
                let selectedIds = [];

                $('.selectSiteCheckbox:checked').each(function() {
                    selectedIds.push($(this).val());
                });

                // (1) Check selected list first
                if (selectedIds.length === 0) {
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

                // (2) Check mail availability
                if (availableMail <= 0 && availableMail <= total_mail) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'No Mail Available!',
                        text: 'Please purchase a package to send emails',
                        confirmButtonText: 'Buy Now',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "#"; // Replace with your purchase route
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
                            window.location.href = "#"; // Replace with your purchase route
                        }
                    });
                    return;
                }
                // (3) Selected exceeds available mail
                if (selectedIds.length > availableMail && availableMail <= total_mail) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Mail Limit Exceeded!',
                        text: `You can only send ${availableMail} mails. You selected ${selectedIds.length}.`,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    return;
                }

                // (3) If both pass -> open modal
                $('#selectedIdsInput').val(JSON.stringify(selectedIds));
                $('#modalSelectedCount').text(selectedIds.length);
                new bootstrap.Modal(document.getElementById('sendMailModal')).show();
            });
            // Submit Summernote content
            // $('#sendMailForm').on('submit', function() {
            //     var content = $('#summernote').summernote('code');
            //     $(this).append('<input type="hidden" name="message_html" value="' + encodeURIComponent(
            //         content) + '">');
            // });

            // Initialize Summernote
            // $('#summernote').summernote({
            //     placeholder: 'Write your message...',
            //     height: 200
            // });
            
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

let selectedFiles = [];

$('#attachments').on('change', function() {
    let files = this.files;
    
    for (let i = 0; i < files.length; i++) {
        let file = files[i];
        
        // Check if file already exists
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
                // Remove file from selectedFiles array
                selectedFiles = selectedFiles.filter(f => f !== file);
                container.remove();
                updateFileInput(); // Update the actual file input
            });

            container.appendChild(fileName);
            container.appendChild(removeBtn);

            $('#summernote').next('.note-editor').find('.note-editable').append(container).append(' ');
        }
    }
    
    updateFileInput(); // Update the actual file input after adding new files
});

// Function to update the actual file input with selected files
function updateFileInput() {
    const input = document.getElementById("attachments");
    const dataTransfer = new DataTransfer();
    
    selectedFiles.forEach(file => {
        dataTransfer.items.add(file);
    });
    
    input.files = dataTransfer.files;
    
    // Log for debugging
    console.log('Files in input:', input.files.length);
}

// Update file input before form submission
document.querySelector("mailForm").addEventListener("submit", function(e) {
    // Ensure files are updated before submission
    updateFileInput();
    
    // Optional: Add a small delay to ensure the update happens
    setTimeout(() => {
        console.log('Final files before submit:', $('#attachments')[0].files);
    }, 100);
});
        });

        $(document).ready(function() {
            // Toggle expandable row on main row click
            $('.main-row').click(function() {
                var targetId = $(this).data('target'); // e.g., #expandRow1
                var $targetRow = $(targetId);

                // Close all other rows (optional)
                $('.expandable-row').not($targetRow).slideUp();

                // Toggle this row
                $targetRow.slideToggle();
            });
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

            // Show or hide "No blog found" message
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
    </script>
    <script>
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
    {{-- <script>
    
$(document).ready(function () {
    $('#openMailModalBtn').click(function (event) {
        let availableMail = $(this).data('available-mail');

        // If no mail available -> Show alert & stop everything
        if (availableMail <= 0) {
            event.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'No Mail Available!',
                text: 'Please purchase a package to send emails.',
                confirmButtonText: 'Buy Now',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "#"; // Change your real route here
                }
            });
            return;
        }

        // Check selected sites AFTER checking available mail
        let selectedIds = [];
        $('.selectSiteCheckbox:checked').each(function () {
            selectedIds.push($(this).val());
        });

        if (selectedIds.length === 0) {
            event.preventDefault();
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

        // Set selected IDs in hidden field
        $('#selectedIdsInput').val(JSON.stringify(selectedIds));

        // Open Modal
        new bootstrap.Modal(document.getElementById('sendMailModal')).show();
    });
}); --}}

    {{-- </script> --}}
    <script>
        // For individual row Send Mail button
        $('.rowMailBtn').click(function(event) {
            let availableMail = $(this).data('available-mail');
            let total_mail =$(this).data('total-mail');
            let url = $(this).data('url');

            if (availableMail > total_mail) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Mail Available Issue!',
                        text: 'Please check available mail and total mail',
                        confirmButtonText: 'Buy Now',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "#"; // Replace with your purchase route
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
    </script>


</x-app-layout>
