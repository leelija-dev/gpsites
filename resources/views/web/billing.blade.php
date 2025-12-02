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
        <div class="w-64 border-end p-4 ">
            @include('web.sidebar')
        </div>

        <!-- Main content -->
        <div class="flex-grow-1 p-4">
            <div class="table-responsive">
                <table class="table  table-hover ">


                    <thead class="table-success text-center">
                         <tr><h1><strong>Billing<strong></h1>
                         </tr>
                        <tr>
                            <th scope="col">SL No</th>
                            <th scope="col">Order ID</th>
                            <th scope="col">Total Mail</th>
                            <th scope="col">Plan Status</th>
                            <th scop="col">Validity</th>
                            <th scope="col">Order Date</th>
                            <th scope="col">Plan Expiring </th>

                        </tr>
                    </thead>
                    <tbody>
                        @if($bills->isNotEmpty())
                        @foreach ($bills as $bill)
                            <?php
                            $expiryDate = \Carbon\Carbon::parse($bill->created_at)->addDays($bill->plan->duration);
                            $isActive = \Carbon\Carbon::now()->lessThanOrEqualTo($expiryDate);
                            ?>
                            @if ($isActive)
                                <tr>
                                @else
                                <tr class="table-secondary">
                            @endif
                            @php $page=isset($_GET['page'])?$_GET['page'] : 1; @endphp
                            <td class="text-center">{{ $page * 10 - 9 + $loop->iteration - 1 }}</td>
                            <td class="text-center">{{ $bill->id ?? '' }}</td>
                            <td class="text-center">{{ $bill->mailAvailable->total_mail ?? 0}}</td>

                            <td class="text-center">
                                @if ($isActive)
                                    <span class="bg-success text-white text-xs px-3 py-1 rounded-full">Active</span>
                                @else
                                   <span class="bg-secondary text-white text-xs px-3 py-1 rounded-full"> Expired</span>
                                @endif
                            </td>
                            <td class="text-center">{{$bill->plan->duration}} day</td>
                            <td class="text-center">{{ $bill->created_at->format( 'd-m-Y h:i a') ?? '' }}</td>
                            <td class="text-center">{{$expiryDate->format('d-m-Y h:i a') ?? ''}}</td>    
                        </tr>
                        @endforeach
                        @else
                            <tr><td colpan="7" class="p-4 text-center" >No Billing found!</td></tr>
                            
                        @endif
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-3">
                    {{ $bills->links('pagination::bootstrap-5') }}
                </div>


            </div>
        </div>
    </div>
</x-app-layout>
