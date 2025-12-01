<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <div class="d-flex min-vh-100">
        <!-- Sidebar -->
        <div class="w-64 border-end p-4 bg-light">
            @include('web.sidebar')
        </div>
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
         <div class="flex-grow-1 p-4" style="background: white;">
            <div class="container">
                <p><?= $mail->site_url ?></p>
                <p><?= $mail->created_at->format('d-m-Y,h:i a') ?></p>
                <p><?= $mail->subject ?></p>
                <p><?= $mail->message ?></p><p>
                    @if($mail->file)
                        @php
                            $files = explode(',', $mail->file); // convert string back to array
                        @endphp
                        <ul>
                            @foreach($files as $file)
                                <li>
                                    <a href="{{ asset($file) }}" target="_blank">{{ basename($file) }}</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    </p>

            </div>
         </div>
        
    </div>
    
</x-app-layout>
