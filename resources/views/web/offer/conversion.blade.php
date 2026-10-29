@extends('layouts.app')

@section('title','View Mail')
@section('content')
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
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-gray-500">Site URL</p>
                            @if($mail->status == true)
                                <div class="flex flex-col items-start gap-1">
                                    <span class="px-3 rounded-full text-white bg-green-600 text-sm flex items-center"
                                        style="height: 20px; line-height: 20px;">
                                        Sent
                                    </span>

                                    <span class="text-xs text-gray-500">
                                        {{ $mail->created_at->format('d-m-Y, h:i A') }}
                                    </span>
                                </div>
                            @else
                                 <div class="flex flex-col items-start gap-1">
                                    <span class="px-3 rounded-full text-white bg-yellow-400 text-sm flex items-center"
                                        style="height: 20px; line-height: 20px;">
                                        Failed
                                    </span>

                                    <span class="text-xs text-gray-500">
                                        {{ $mail->created_at->format('d-m-Y, h:i A') }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        <p class="text-base text-gray-900 font-semibold truncate">{{ $mail->site_url }}</p>
                    </div>

                    

                    <!-- Subject -->
                    <div class="mb-4">
                        <p class="text-sm font-medium text-gray-500">Subject</p>
                        <p class="text-xl text-gray-900 font-bold">{{ $mail->subject }}</p>
                    </div>
                    
                    <!-- Message -->
                    <div class="mb-6">
    <p class="text-sm font-medium text-gray-500 mb-2">Conversation</p>

    <div id="chatBox"
         class="rounded-lg border border-gray-200 p-4 space-y-3 overflow-y-auto"
         style="background:#efeae2; ">

        @php $lastDate = null; @endphp

        @forelse($messages as $message)
            @php
                $time   = $message->sent_at ?? $message->created_at;
                $isMine = in_array($message->direction, ['initial', 'user_reply']);
                $day    = $time->format('Y-m-d');
            @endphp

            {{-- date label when the day changes --}}
            @if($lastDate !== $day)
                <div class="flex justify-center">
                    <span class="text-xs text-gray-600 px-3 py-1 rounded-lg shadow-sm"
                          style="background:#fff;">
                        {{ $time->isToday() ? 'Today' : ($time->isYesterday() ? 'Yesterday' : $time->format('d M Y')) }}
                    </span>
                </div>
                @php $lastDate = $day; @endphp
            @endif

            <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                <div class="px-3 py-2 shadow-sm text-sm text-gray-800"
                     style="max-width:80%;
                            background: {{ $isMine ? '#D3C8E8' : '#ffffff' }};
                            border-radius: {{ $isMine ? '12px 0 12px 12px' : '0 12px 12px 12px' }};">

                    <p class="text-xs font-semibold mb-1"
                       style="color: {{ $isMine ? '#15803d' : '#2563eb' }};">
                        {{ $isMine ? 'You' : ($message->from_name ?: $message->from_email) }}
                    </p>

                    <div class="break-words">{!! $message->body_html !!}</div>

                    <div class="text-right mt-1" style="font-size:11px; color:#6a717c;">
                        {{ $time->format('h:i A') }}
                        @if($message->status === 'failed')
                            <span style="color:#dc2626;">· failed</span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <p class="text-sm text-gray-500 text-center">No messages yet.</p>
        @endforelse
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
                    <!-- Timestamp -->
                    <div class="flex justify-center text-center">
                        <p class="text-sm text-gray-400 not-copy">
                            If your latest message doesn’t appear yet, please wait a moment. It will show up shortly.
                        </p>
                    </div>
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
    <script>
    // open the chat at the newest message, like WhatsApp
    (function () {
        var box = document.getElementById('chatBox');
        if (box) box.scrollTop = box.scrollHeight;
    })();
</script>
@endsection