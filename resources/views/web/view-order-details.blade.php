@php
    use Illuminate\Support\Facades\Auth;
    $loggedUserId = Auth::id();
@endphp

<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        a {
            text-decoration: none !important;
        }

        body {
            background-color: #f7f8fa;
        }
/* 
        .sidebar {
            width: 260px;
            background: #ffffff;
            border-right: 1px solid #e2e8f0;
            padding: 20px;
            border-radius: 10px;
            height: 100vh;
        } */

        .order-card {
            border-radius: 12px;
            border: none;
            box-shadow: 0px 5px 20px rgba(0,0,0,0.05);
        }

        .status-badge {
            padding: 6px 12px;
            font-weight: 600;
            border-radius: 50px;
            font-size: 13px;
        }
    </style>

    <div class="d-flex min-vh-100 p-3">
        
        <!-- Sidebar -->
        <div class="w-64 border-end p-4 bg-light">
            @include('web.sidebar')
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1 px-4">

            <div class="card order-card p-4 mt-3">
                <div class="d-flex  align-middle mb-3" >
                    <h4 class="fw-bold mb-0">Order Details</h4>
                    {{-- <h4 class="fw-bold mb-0">Billing Details</h4> --}}
                </div>

                <div class="table-responsive">
                    <table class="table table-borderless align-middle">
                        <tbody>
                            <tr>
                                <th class="text-secondary">Order ID:</th>
                                <td class="fw-medium">{{ $order->id }}</td>
                                <th class="text-secondary">Plan Name:</th>
                                <td class="fw-medium">{{ $order->plan->name }}</td>   
                            </tr>
                            <tr>
                                <th class="text-secondary">Amount:</th>
                                <td class="fw-medium">{{ $order->currency }} {{ number_format($order->amount, 2) }}</td>
                                <th class="text-secondary">Transaction ID:</th>
                                <td class="fw-medium">{{ $order->transaction_id ?? '' }}</td>
                            </tr>
                            {{-- <tr>
    
                            </tr> --}}
                            
                            <tr>
                                <th class="text-secondary">Payment:</th>
                                <td>
                                    <span class="status-badge 
                                        {{ $order->status === 'completed' ? 'bg-success text-white' : 'bg-warning text-dark' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>

                                </td>
                                <th class="text-secondary">Status:</th>
                                <td>
                                     <?php 
                                     $expiryDate = \Carbon\Carbon::parse($order->created_at)->addDays($order->plan->duration);
                                     $isActive = \Carbon\Carbon::now()->lessThanOrEqualTo($expiryDate); 
                                    ?>
                                        @if($order->status === 'completed')                              
                                            @if($isActive)
                                            <span class="status-badge bg-success">Active</span>
                                            @else
                                            <span class="status-badge bg-secondary">Expired</span>
                                            @endif
                                        
                                        @endif
                                </td>
                                
                            </tr>
                            <tr>
                                
                            </tr>
                            <tr>
                                <th class="text-secondary">Payment Date:</th>
                                <td class="fw-medium">
                                    {{ $order->paid_at ? $order->paid_at->format('M d, Y H:i') : '' }}
                                </td>
                                <th class="text-secondary">Expire Date:</th>
                                <td class="fw-medium">
                                @if($order->status === 'completed')
                                {{$expiryDate->format('M d, Y H:i')}}
                                @else
                                @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="text-secondary">Total Mail</th>
                                <td class="fw-medium">{{ $order->mailAvailable->total_mail ?? 0}}</td>
                                <th class="text-secondary">Sent Mail</th>
                                <td class="fw-medium">{{ (($order->mailAvailable->total_mail ?? 0) - ($order->mailAvailable->available_mail ?? 0) ) ?? 0}}</td>
                            </tr>
                            
                        </tbody>
                    </table>
                    <div class="d-flex  align-middle " >
                                <h4 class="fw-bold mb-0">Billing Details</h4>
                                {{-- <h4 class="fw-bold mb-0">Billing Details</h4> --}}
                    </div>
                    <table class="table table-borderless align-middle">
                    <tbody>
                        <tr>
                        <th class="text-secondary">Name:</th>
                        <td class="fw-medium">{{ $order->billing_info['first_name'] ?? '' }} {{ $order->billing_info['last_name'] ?? '' }}</td>
                        <th class="text-secondary">Email:</th>
                        <td class="fw-medium">{{ $order->billing_info['email'] ?? '' }}</td>
                        </tr>
                        <tr>
                            <th class="text-secondary">Address:</th>
                            <td class="fw-medium">{{ $order->billing_info['address1'] ?? '' }}</td>
                            <th class="text-secondary">City:</th>
                            <td class="fw-medium">{{ $order->billing_info['city'] ?? '' }}</td>
                        </tr>
                        <tr>
                            <th class="text-secondary">State:</th>
                            <td class="fw-medium">{{ $order->billing_info['state'] ?? '' }}</td>
                            <th class="text-secondary">Phone:</th>
                            <td class="fw-medium">{{ $order->billing_info['phone'] ?? '' }}</td>
                        </tr>
                        <tr>
                            <th class="text-secondary">Pin Code:</th>
                            <td class="fw-medium">{{ $order->billing_info['zip'] ?? '' }}</td>
                        </tr>
                    </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <a href="{{route('my-orders')}}" class="btn btn-outline-primary">
                        Back 
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
