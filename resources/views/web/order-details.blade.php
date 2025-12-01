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

                    <tr>
                        <th scope="col">SL No</th>
                        <th scope="col">Plan Name</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Payment Status</th>
                        <th scope="col">Total Mail</th>
                        <th scope="col">Mail Available</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Plan Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @if($orders->isNotEmpty())
                        
                        @foreach ($orders as $order)
                                @php
                                    $expiryDate = \Carbon\Carbon::parse($order->created_at)->addDays($order->plan->duration);
                                    $isActive = \Carbon\Carbon::now()->lessThanOrEqualTo($expiryDate);
                                @endphp
                                @if(!$isActive)
                                <tr class="table-secondary">
                                @else
                                <tr>
                                @endif
                                @php $page=isset($_GET['page'])?$_GET['page'] : 1; @endphp
                                <td class="text-center">{{ $page * 10 - 9 + $loop->iteration - 1 }}</td>
                                <td class="text-center">{{ $order->plan->name }}</td>
                                <td class="text-center " >$
                                    {{$order->amount}}
                                </td>
                                {{-- <td class="text-center">
                                    {{$order->status ?? 'incomplete'}}
                                </td> --}}
                                <td class="text-center">
                                <span @class([
                                    'px-3 py-1 rounded-full text-xs font-semibold',
                                    'bg-success text-white' => $order->status === 'completed',
                                    'bg-warning text-white' => $order->status === 'pending',
                                    'bg-danger text-white' => !in_array($order->status, ['completed','pending']),
                                ])>
                                    {{ ucfirst($order->status ?? 'incomplete') }}
                                </span>
                            </td>
                            <td class="text-center">{{$order->mailAvailable->total_mail ?? 0}}</td>
                                <td class="text-center">{{$order->mailAvailable->available_mail ?? 0}}</td>
                                <td class="text-center">{{ $order->created_at->format('d M Y') }}</td>
                                <td class="text-center" style="position: relative">
                                    @if($order->status == 'completed')
                                        @if($isActive)
                                       <span class="bg-success text-white text-xs px-3 py-1 rounded-full"> Active</span>
                                        @else
                                         <span class="bg-secondary text-white text-xs px-3 py-1 rounded-full"> Expired</span>
                                        @endif
                                    @else
                                     
                                    @endif

                                </td>
                                <td class="text-center"><a href="{{route('view-my-order',encrypt(['id'=>$order->id]))}}">view</a></td>
                                
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9" class="p-4 text-center">No order yet!</td>
                        </tr>
                    @endif

                </tbody>
                
            </table>
               <div class="d-flex justify-content-center mt-3">
                    {{ $orders->links('pagination::bootstrap-5') }}
                </div>


            </div>
            {{-- <div class="d-flex justify-content-center mt-3">
                {{ $mails->links('pagination::bootstrap-5') }}

            </div> --}}
        </div>
        </div>
    </div>
</x-app-layout>