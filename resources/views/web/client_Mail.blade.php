@php
    use Illuminate\Support\Facades\Auth;
    $loggedUserId = Auth::id(); // or Auth::user()->id
@endphp
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
            <form action="{{ route('blog.singleMail') }}" method="post" enctype="multipart/form-data" id="mailForm">
    @csrf
    <input type="hidden" id="id" value="{{ $id }}" name="id">
    <input type="hidden" id="userId" value="{{ $loggedUserId }}" name="userId">

    <div class="form-group">
        <label for="subject">Subject<sup class="text-danger">*</sup></label>
        <input type="text" class="form-control" name="subject" id="subject" required>
    </div>

    <div class="form-group">
        <label for="message">Message<sup class="text-danger">*</sup></label><br>
        <textarea id="summernote" name="message" placeholder="Write your message..." required></textarea>
        <!-- Multiple file input -->
        <input type="file" name="attachments[]" id="attachments" multiple style="display:none">
    </div>
    
    <!-- Display selected files for debugging -->
    <div id="selectedFiles" class="mt-2"></div>
    
    <button type="submit" class="btn btn-primary">Send Mail</button>
</form>
        </div>
    </div>
    {{-- <script>
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'Write your message...',
            height: 200,    // Editor height
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['fontname', 'fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'video','fileUpload']],
                // ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
// </script> --}}
<script>
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


</script>

</x-app-layout>