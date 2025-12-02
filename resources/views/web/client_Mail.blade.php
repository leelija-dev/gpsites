@php
    use Illuminate\Support\Facades\Auth;
    $loggedUserId = Auth::id();
@endphp

<x-app-layout>
    <!-- jQuery (required for Summernote) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Summernote CSS & JS (Bootstrap-free version works fine with Tailwind) -->
  <!-- Use summernote-lite (no Bootstrap dependency) -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.js"></script>

    <div class="min-h-screen bg-gray-50 flex items-center justify-center px-4 py-4">
        <div class="w-full ">

            @if ($isValidPlan)
                @if ($total_mail_available != 0)
                    <!-- Mail Form Card -->
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
                        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-8 py-6">
                            <h2 class="text-2xl font-bold">Send New Mail</h2>
                            <p class="text-indigo-100">You have <strong>{{ $total_mail_available }}</strong> mail(s) available</p>
                        </div>

                        <div class="p-8">
                            <form action="{{ route('blog.singleMail') }}" method="POST" enctype="multipart/form-data" id="mailForm" class="space-y-8">
                                @csrf
                                <input type="hidden" name="id" value="{{ $id }}">
                                <input type="hidden" name="userId" value="{{ $loggedUserId }}">

                                <!-- Subject Field -->
                                <div>
                                    <label for="subject" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Subject <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="subject" id="subject" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-4 focus:ring-indigo-200 focus:border-indigo-500 transition duration-200 outline-none text-gray-800 placeholder-gray-400"
                                           placeholder="Enter email subject">
                                </div>

                                <!-- Message Editor -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Message <span class="text-red-500">*</span>
                                    </label>
                                    <textarea id="summernote" name="message" required></textarea>

                                    <!-- Hidden file input -->
                                    <input type="file" name="attachments[]" id="attachments" multiple class="hidden">
                                </div>

                                <!-- Submit Button -->
                                <div class="flex justify-end">
                                    <button type="submit"
                                            class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold text-lg rounded-xl shadow-lg transform hover:scale-105 transition duration-300">
                                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                        </svg>
                                        Send Mail
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- No Mail Available -->
                    <div class="text-center py-20 bg-white rounded-2xl shadow-xl">
                        <div class="max-w-md mx-auto">
                            <div class="bg-red-100 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6">
                                <svg class="w-16 h-16 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-4">No Mail Credits Left!</h3>
                            <p class="text-gray-600 mb-8">You've used all your available mail credits.</p>
                            <a href="/#pricing"
                               class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold rounded-xl shadow-lg transform hover:scale-105 transition">
                                Buy More Credits
                            </a>
                        </div>
                    </div>
                @endif
            @else
                <!-- No Active Plan -->
                <div class="text-center py-20 bg-white rounded-2xl shadow-xl">
                    <div class="max-w-md mx-auto">
                        <div class="bg-yellow-100 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6">
                            <svg class="w-16 h-16 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 3h18v18H3V3zM12 8v8m-4-4h8"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">No Active Plan Found</h3>
                        <p class="text-gray-600 mb-8">Please purchase a plan to start sending emails.</p>
                        <a href="/#pricing"
                           class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-bold rounded-xl shadow-lg transform hover:scale-105 transition">
                            View Pricing Plans
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Summernote + File Attachment Script (Enhanced & Clean) -->
    <script>
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'Write your message here...',
            height: 300,
            tabsize: 2,
            // THIS IS THE KEY: Disable Bootstrap tooltips completely
            disableDragAndDrop: false,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video', 'attachFile']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            buttons: {
                attachFile: function(context) {
                    var ui = $.summernote.ui;
                    var button = ui.button({
                        contents: '<i class="note-icon-paperclip"></i>',
                        tooltip: 'Attach files',
                        click: function() {
                            $('#attachments').trigger('click');
                        }
                    });
                    return button.render();
                }
            },
            // CRITICAL: Disable all Bootstrap tooltip/popover usage
            popover: {
                image: [],
                link: [],
                air: []
            },
            // Optional: Use native title instead of Bootstrap tooltips
            hint: false,
            // Prevent Summernote from trying to use Bootstrap tooltips
            callbacks: {
                onInit: function() {
                    // Force native browser tooltips (title attribute)
                    $('.note-toolbar btn').each(function() {
                        if ($(this).attr('data-original-title')) {
                            $(this).removeAttr('data-original-title');
                        }
                    });
                }
            }
        });

        // File attachment logic (unchanged)
        let selectedFiles = [];

        $('#attachments').on('change', function() {
            let files = this.files;
            for (let i = 0; i < files.length; i++) {
                let file = files[i];
                if (selectedFiles.find(f => f.name === file.name && f.size === file.size)) continue;

                selectedFiles.push(file);

                let badge = `
                    <span class="inline-block m-1 px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium border border-blue-300" contenteditable="false">
                        ${file.name} (${(file.size / 1024).toFixed(1)} KB)
                        <span class="ml-2 cursor-pointer text-red-600 hover:text-red-800" 
                              onclick="this.parentElement.remove(); selectedFiles = selectedFiles.filter(f => f.name !== '${file.name}' || f.size !== ${file.size})">×</span>
                    </span>`;

                $('#summernote').summernote('pasteHTML', badge + ' ');
            }
            updateFileInput();
        });

        function updateFileInput() {
            const input = document.getElementById('attachments');
            const dt = new DataTransfer();
            selectedFiles.forEach(f => dt.items.add(f));
            input.files = dt.files;
        }

        $('#mailForm').on('submit', function() {
            updateFileInput();
        });
    });
</script>
</x-app-layout>