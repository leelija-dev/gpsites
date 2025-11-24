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
        
    </style>
    <div class="d-flex min-vh-100" style="background: white;">
        <!-- Sidebar -->
        <div class="w-64 border-end p-4">
            @include('web.sidebar')
        </div>

        <!--Main content -->
        <div class="card-body">
                <h5 class="card-title">Order Details</h5>
            
                
        </div>

        <div class="flex-grow-1 p-4">
        </div>
    </div>

</x-app-layout>