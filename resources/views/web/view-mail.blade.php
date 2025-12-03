<x-app-layout>
    <style>
        /* Remove underline from all links */
        a {
            text-decoration: none !important;
        }

        /* Optional: hover effect for links */
        a:hover {
            text-decoration: none !important;
        }
        
        /* Summernote styling fix */
        .note-editor.note-frame {
            border: 1px solid #d1d5db !important;
            border-radius: 0.375rem !important;
        }
        
        .note-btn-group.note-style {
            display: none !important;
        }
    </style>

    <div class="flex min-h-screen">
      

        <!-- Main Content -->
        <div class="flex-1 p-4 bg-white">
            <div class="max-w-4xl mx-auto">
                <!-- Email details container -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <!-- Site URL -->
                    <div class="mb-4">
                        <p class="text-sm font-medium text-gray-500">Site URL</p>
                        <p class="text-base text-gray-900 font-semibold truncate">{{ $mail->site_url }}</p>
                    </div>

                    <!-- Timestamp -->
                    <div class="mb-4">
                        <p class="text-sm font-medium text-gray-500">Date & Time</p>
                        <p class="text-base text-gray-900">{{ $mail->created_at->format('d-m-Y, h:i a') }}</p>
                    </div>

                    <!-- Subject -->
                    <div class="mb-4">
                        <p class="text-sm font-medium text-gray-500">Subject</p>
                        <p class="text-xl text-gray-900 font-bold">{{ $mail->subject }}</p>
                    </div>

                    <!-- Message -->
                    <div class="mb-6">
                        <p class="text-sm font-medium text-gray-500 mb-2">Message</p>
                        <div class="prose max-w-none p-4 bg-gray-50 rounded-lg border border-gray-200">
                            {!! $mail->message !!}
                        </div>
                    </div>

                    <!-- Files -->
                    @if($mail->file)
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <p class="text-sm font-medium text-gray-500 mb-3">Attachments</p>
                            <ul class="space-y-2">
                                @php
                                    $files = explode(',', $mail->file);
                                @endphp
                                @foreach($files as $file)
                                    <li class="flex items-center p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                                        <svg class="w-5 h-5 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <a href="{{ asset($file) }}" target="_blank" class="text-blue-600 font-medium hover:text-blue-800 transition-colors">
                                            {{ basename($file) }}
                                        </a>
                                        <span class="ml-auto text-xs text-gray-500">
                                            {{ round(filesize(public_path($file)) / 1024, 1) }} KB
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

  
    
    <script>
        // Summernote initialization if needed
        $(document).ready(function() {
            // If you have any textareas that need Summernote
            $('.summernote').summernote({
                height: 200,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']]
                ]
            });
        });
    </script>
</x-app-layout>