 @extends('layouts.web.main-layout')

@section('title', 'Payment Successful')

@section('content')
<div class="min-h-screen flex items-center justify-center">
    <div class="text-center">
        <div class="text-green-500 text-6xl mb-4">✓</div>
        <h1 class="text-3xl font-bold mb-4">Payment Successful!</h1>
        <p class="text-gray-600 mb-4">Your transaction ID: {{ $transactionId ?? 'N/A' }}</p>
        <a href="{{ route('home') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg">Return to Home</a>
    </div>
</div>
@endsection