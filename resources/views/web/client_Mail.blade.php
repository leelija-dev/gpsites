<x-app-layout>
{{-- <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script> --}}
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap 4 (required for Summernote) -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<!-- Summernote -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.js"></script>


    <div class="flex min-h-screen ">

        <!-- Sidebar -->
        <div class="w-64 border-r p-4 bg-gray-100">
            @include('web.sidebar')
            {{-- < ?php require_once ROOT .'..../web/sidebar.blade.php'; ?> --}}
            
        </div>


        <!-- Main content -->
        
        <div class="flex-1 p-6 " style="background: white;">
            <form action="{{ route('blog.sendMail', $email) }}" method="post">
                @csrf
            <input type="hidden" id="email" value="{{ $email }}" name="email">
        
             <div class="form-group">
                <label for="mailSubject">Subject<sup class="text-danger">*</sup></label>
                <input type="text" class="form-control" name="subject" id="subject" >
            </div>
    
            <div class="form-group">
                <label for="mailMessage">Message<sup class="text-danger">*</sup></label><br>
                <textarea id="summernote" name="message" placeholder="Write your message..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary" >Send Mail</button>
            </form>
        </div>
    </div>
    <script>
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'Write your message...',
            height: 200,    // Editor height
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['fontname', 'fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>

</x-app-layout>