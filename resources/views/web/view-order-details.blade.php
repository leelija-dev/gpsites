@php
    use Illuminate\Support\Facades\Auth;
    $loggedUserId = Auth::id();

    $expiryDate = \Carbon\Carbon::parse($order->created_at)->addDays($order->plan->duration);
    $isActive = \Carbon\Carbon::now()->lessThanOrEqualTo($expiryDate);
    $sentMail = ($order->mailAvailable->total_mail ?? 0) - ($order->mailAvailable->available_mail ?? 0);
@endphp

<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-476 mx-auto">

            <!-- Main Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-8 py-6">
                    <h1 class="text-3xl font-bold">Order Details</h1>
                    <p class="text-indigo-100 mt-1">Order ID: #{{ $order->id }}</p>
                </div>

                <div class="p-8 space-y-10">

                    <!-- Order Summary Table -->
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                            <svg class="w-7 h-7 mr-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Order Summary
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                            <div class="space-y-5">
                                <div class="flex justify-between">
                                    <span class="text-gray-500 font-medium">Order ID</span>
                                    <span class="font-semibold text-gray-900">#{{ $order->id }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500 font-medium">Plan Name</span>
                                    <span class="font-semibold text-indigo-600">{{ $order->plan->name }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500 font-medium">Amount</span>
                                    <span class="font-bold text-xl text-green-600">
                                        {{ $order->currency }} {{ number_format($order->amount, 2) }}
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500 font-medium">Transaction ID</span>
                                    <span class="font-mono text-xs bg-gray-100 px-3 py-1 rounded">
                                        {{ $order->transaction_id ?? '—' }}
                                    </span>
                                </div>
                            </div>

                            <div class="space-y-5">
                                <div class="flex justify-between">
                                    <span class="text-gray-500 font-medium">Payment Status</span>
                                    <span class="px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider
                                        {{ $order->status === 'completed' 
                                            ? 'bg-green-100 text-green-800' 
                                            : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($order->status ?? 'Pending') }}
                                    </span>
                                </div>

                                <div class="flex justify-between">
                                    <span class="text-gray-500 font-medium">Plan Status</span>
                                    @if($order->status === 'completed')
                                        @if($isActive)
                                            <span class="px-4 py-2 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 uppercase">
                                                Active
                                            </span>
                                        @else
                                            <span class="px-4 py-2 rounded-full text-xs font-bold bg-red-100 text-red-800 uppercase">
                                                Expired
                                            </span>
                                        @endif
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </div>

                                <div class="flex justify-between">
                                    <span class="text-gray-500 font-medium">Payment Date</span>
                                    <span class="font-medium">
                                        {{ $order->paid_at ? $order->paid_at->format('M d, Y h:i A') : '—' }}
                                    </span>
                                </div>

                                <div class="flex justify-between">
                                    <span class="text-gray-500 font-medium">Expire Date</span>
                                    <span class="font-medium {{ $isActive ? 'text-green-600' : 'text-red-600' }}">
                                        @if($order->status === 'completed')
                                            {{ $expiryDate->format('M d, Y h:i A') }}
                                        @else
                                            —
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Mail Usage -->
                        <div class="mt-8 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-100">
                            <h3 class="font-bold text-lg text-gray-800 mb-4">Mail Usage</h3>
                            <div class="grid grid-cols-3 gap-6 text-center">
                                <div>
                                    <p class="text-gray-500 text-sm">Total Mail</p>
                                    <p class="text-3xl font-bold text-indigo-600">
                                        {{ $order->mailAvailable->total_mail ?? 0 }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Used</p>
                                    <p class="text-3xl font-bold text-orange-600">{{ $sentMail }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Available</p>
                                    <p class="text-3xl font-bold text-green-600">
                                        {{ $order->mailAvailable->available_mail ?? 0 }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Billing Details -->
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                            <svg class="w-7 h-7 mr-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Billing Information
                        </h2>

                        <div class="bg-gray-50 rounded-xl p-6 space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <span class="text-gray-500 font-medium">Name</span>
                                    <p class="font-semibold text-gray-900">
                                        {{ $order->billing_info['first_name'] ?? '' }} {{ $order->billing_info['last_name'] ?? '' }}
                                    </p>
                                </div>
                                <div>
                                    <span class="text-gray-500 font-medium">Email</span>
                                    <p class="font-semibold text-blue-600">{{ $order->billing_info['email'] ?? '—' }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-500 font-medium">Address</span>
                                    <p class="font-semibold text-gray-900">{{ $order->billing_info['address1'] ?? '—' }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-500 font-medium">City</span>
                                    <p class="font-semibold text-gray-900">{{ $order->billing_info['city'] ?? '—' }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-500 font-medium">State</span>
                                    <p class="font-semibold text-gray-900">{{ $order->billing_info['state'] ?? '—' }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-500 font-medium">Phone</span>
                                    <p class="font-semibold text-gray-900">{{ $order->billing_info['phone'] ?? '—' }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-500 font-medium">Pin Code</span>
                                    <p class="font-semibold text-gray-900">{{ $order->billing_info['zip'] ?? '—' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Back Button -->
                    <div class="pt-6 border-t border-gray-200">
                        <a href="{{ route('my-orders') }}"
                           class="inline-flex items-center px-6 py-3 bg-gray-800 hover:bg-gray-900 text-white font-medium rounded-lg shadow-lg transition transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to Orders
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>