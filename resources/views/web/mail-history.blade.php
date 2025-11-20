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
         <div class="flex-grow-1 p-4">

            <table class="table  table-hover bg-white">
                <thead class="table-success text-center">
                    
                        <tr>
                            <th scope="col">SL No</th>
                            <th scope="col">Site URL</th>
                            <th scope="col">Subject</th>
                            <th scope="col">Message</th>
                            <th scope="col">Sent At</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($mails)
                        @foreach($mails as $mail)
                        <tr>
                            @php $page=isset($_GET['page'])?$_GET['page'] : 1; @endphp
                            <td class="text-center">{{(((($page*10)-9)+$loop->iteration)-1)}}</td>
                            <td class="text-center">{{$mail->site_url}}</td>
                            <td class="text-center">
                                @if(strlen($mail->subject)>20)
                                {{substr($mail->subject,0,8).'...'.substr($mail->subject,-8)}}
                                @else
                                {{ $mail->subject }}
                                @endif
                            </td>
                            <td class="text-center">
                               <?php $message=strip_tags($mail->message)?>
                                @if(strlen($message)>20)
                                {{substr($message,0,8).'...'.substr( $message,-8)}}        
                                @else
                                {!! $message !!}
                                @endif
                            </td>
                            <td class="text-center">{{$mail->created_at->format('d M Y')}}</td>
                            <td class="text-center"><a href="{{route('blog.view-mail',encrypt($mail->id))}}" class="btn btn-primary" title="blog.view-mail">view</a></td>
                            
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="7" class="p-4 text-text-center">No mail history found.</td>
                        </tr>
                        @endif

                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-3">
                  {{ $mails->links('pagination::bootstrap-5') }}

                </div>
            </div>
        </div>
</x-app-layout>