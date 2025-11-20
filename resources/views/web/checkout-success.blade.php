@extends('layouts.web.main-layout')

@section('title', 'Payment Successful')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12">
    <div class="max-w-md w-full bg-white shadow-lg rounded-lg p-8 text-center">
        <div class="text-green-500 text-6xl mb-4">✓</div>
        <h1 class="text-3xl font-bold mb-4 text-gray-800">Payment Successful!</h1>
        
        @if($order)
        <div class="bg-gray-50 p-4 rounded-lg mb-6 text-left">
            <h3 class="font-semibold text-lg mb-2">Order Details</h3>
            <p><strong>Transaction ID:</strong> {{ $order->transaction_id }}</p>
            <p><strong>Plan:</strong> {{ $order->plan->name }}</p>
            <p><strong>Amount:</strong> {{ $order->currency }} {{ number_format($order->amount, 2) }}</p>
            <p><strong>Status:</strong> 
                <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full 
                    {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ ucfirst($order->status) }}
                </span>
            </p>
            <p><strong>Date:</strong> {{ $order->paid_at ? $order->paid_at->format('M d, Y H:i') : 'N/A' }}</p>
        </div>
        @else
        <p class="text-gray-600 mb-4">Your transaction ID: {{ $transactionId ?? 'N/A' }}</p>
        @endif
        
        <div class="space-y-3">
            <a href="{{ route('home') }}" class="block w-full bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                Back to Home
            </a>
            <a href="{{ route('dashboard') }}" class="block w-full bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                Go to Dashboard
            </a>
        </div>
    </div>
</div>
@endsection