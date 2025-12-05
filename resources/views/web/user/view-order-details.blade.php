@extends('layouts.app')

@section('title','Order Details')
@section('content')

@php
    use Illuminate\Support\Facades\Auth;
    use Carbon\Carbon;
    
    $loggedUserId = Auth::id();
    $expiryDate = Carbon::parse($order->created_at)->addDays($order->plan->duration);
    $isActive = Carbon::now()->lessThanOrEqualTo($expiryDate);
    $sentMail = ($order->mailAvailable->total_mail ?? 0) - ($order->mailAvailable->available_mail ?? 0);
    $availableMail = $order->mailAvailable->available_mail ?? 0;
    $totalMail = $order->mailAvailable->total_mail ?? 0;
@endphp


    <div class="min-h-screen bg-gray-50 py-8 px-6">
        <div class=" mx-auto">
            
            <!-- Header -->
            <div class="mb-8">
                <a href="{{ route('my-orders') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 mb-4">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Orders
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Order Details</h1>
                <p class="text-gray-500 mt-1">Order #{{ $order->id }}</p>
            </div>

            <!-- Status Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="bg-white p-5 rounded-xl shadow-sm border">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Payment Status</p>
                            <span class="text-lg font-semibold capitalize {{ $order->status === 'completed' ? 'text-green-600' : 'text-yellow-600' }}">
                                {{ $order->status ?? 'Pending' }}
                            </span>
                        </div>
                        <div class="p-2 rounded-lg {{ $order->status === 'completed' ? 'bg-green-100' : 'bg-yellow-100' }}">
                            <svg class="w-6 h-6 {{ $order->status === 'completed' ? 'text-green-600' : 'text-yellow-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-xl shadow-sm border">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Plan Status</p>
                            @if($order->status === 'completed')
                                @if($isActive)
                                    <span class="text-lg font-semibold text-green-600">Active</span>
                                @else
                                    <span class="text-lg font-semibold text-red-600">Expired</span>
                                @endif
                            @else
                                <span class="text-lg font-semibold text-gray-400">—</span>
                            @endif
                        </div>
                        <div class="p-2 rounded-lg {{ $isActive ? 'bg-green-100' : 'bg-red-100' }}">
                            <svg class="w-6 h-6 {{ $isActive ? 'text-green-600' : 'text-red-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-xl shadow-sm border">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Total Amount</p>
                            <span class="text-lg font-bold text-gray-900">{{ config('app.currency') }} {{ number_format($order->amount, 2) }}</span>
                        </div>
                        <div class="p-2 rounded-lg bg-blue-100">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="bg-white rounded-xl shadow-sm border mb-8">
                <div class="p-6 border-b">
                    <h2 class="text-xl font-semibold text-gray-800">Plan Information</h2>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Plan Details -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Plan Name</label>
                                <p class="mt-1 text-lg font-semibold text-indigo-600">{{ $order->plan->name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Transaction ID</label>
                                <p class="mt-1 font-mono text-gray-800">{{ $order->transaction_id ?? '—' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Payment Date</label>
                                <p class="mt-1 text-gray-800">{{ $order->paid_at ? $order->paid_at->format('M d, Y h:i A') : '—' }}</p>
                            </div>
                        </div>

                        <!-- Validity -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Expires On</label>
                                <p class="mt-1 text-lg font-semibold {{ $isActive ? 'text-green-600' : 'text-red-600' }}">
                                    @if($order->status === 'completed')
                                        {{ $expiryDate->format('M d, Y h:i A') }}
                                    @else
                                        —
                                    @endif
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Duration</label>
                                <p class="mt-1 text-gray-800">{{ $order->plan->duration }} days</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mail Usage -->
            <div class="bg-white rounded-xl shadow-sm border mb-8">
                <div class="p-6 border-b">
                    <h2 class="text-xl font-semibold text-gray-800">Email Usage</h2>
                </div>
                
                <div class="p-6">
                    <!-- Progress Bar -->
                    <div class="mb-6">
                        <div class="flex justify-between text-sm text-gray-600 mb-2">
                            <span>{{ $sentMail }} sent</span>
                            <span>{{ $availableMail }} remaining</span>
                        </div>
                        <div class="h-3 bg-gray-200 rounded-full overflow-hidden">
                            @if($totalMail > 0)
                                <div class="h-full bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full" 
                                     style="width: {{ ($sentMail / $totalMail) * 100 }}%">
                                </div>
                            @endif
                        </div>
                        <div class="text-right text-sm text-gray-500 mt-1">
                            of {{ $totalMail }} total
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="grid sm:grid-cols-3 grid-cols-1 gap-4 text-center">
                        <div class="p-4 bg-blue-50 rounded-lg">
                            <p class="text-2xl font-bold text-blue-600">{{ $totalMail }}</p>
                            @if($plan->price == 0)
                            <p class="text-sm text-gray-600 mt-1">Total Emails</p>
                            @else
                            <p class="text-sm text-gray-600 mt-1">Mails/day</p>
                            @endif
                        </div>
                        <div class="p-4 bg-green-50 rounded-lg">
                            <p class="text-2xl font-bold text-green-600">{{ $availableMail }}</p>
                            <p class="text-sm text-gray-600 mt-1">Available</p>
                        </div>
                        <div class="p-4 bg-orange-50 rounded-lg">
                            <p class="text-2xl font-bold text-orange-600">{{ $sentMail }}</p>
                            <p class="text-sm text-gray-600 mt-1">Used</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Billing Information -->
            <div class="bg-white rounded-xl shadow-sm border">
                <div class="p-6 border-b">
                    <h2 class="text-xl font-semibold text-gray-800">Billing Information</h2>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Name</label>
                            <p class="text-gray-900">{{ $order->billing_info['first_name'] ?? '' }} {{ $order->billing_info['last_name'] ?? '' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                            <p class="text-blue-600">{{ $order->billing_info['email'] ?? '—' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Phone</label>
                            <p class="text-gray-900">{{ $order->billing_info['phone'] ?? '—' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Address</label>
                            <p class="text-gray-900">{{ $order->billing_info['address1'] ?? '—' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">City</label>
                            <p class="text-gray-900">{{ $order->billing_info['city'] ?? '—' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Country</label>
                            <p class="text-gray-900">{{ $order->billing_info['country'] ?? '—' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">ZIP Code</label>
                            <p class="text-gray-900">{{ $order->billing_info['zip'] ?? '—' }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
