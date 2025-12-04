@extends('layouts.web.main-layout')

@section('title', 'Order Successful - Thank You!')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-green-50 flex items-center justify-center py-4 px-4">
    <div class="max-w-lg w-full">
        <!-- Main Card -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-100">
            <!-- Success Header with Gradient Background -->
            <div class="bg-gradient-to-r from-darkPrimary to-secondary px-8 py-4 text-center">
               <div class="flex items-center justify-center bg-white overflow-hidden rounded-full mx-auto w-16 h-16 mt-3">
                 <div class="text-green-500 text-[3rem] ">
                    ✓
                </div>
               </div>
                <h1 class="text-4xl md:text-4xl font-extrabold text-white mt-3">
                    Order Successful!
                </h1>
                <p class="text-emerald-50 text-lg mt-3 opacity-90">
                    Thank you for your purchase. Your account is now active!
                </p>
            </div>

            <!-- Content Body -->
            <div class="px-8 py-6">
                @if($order)
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-6 border border-gray-200">
                    
                    <div class="space-y-4 text-gray-700">
                        <div class="flex xxs:flex-row flex-col items-center  xxs:justify-between">
                            <span class="font-medium">Transaction ID</span>
                            <span class="font-mono text-sm bg-gray-200 px-2 py-1 rounded">{{ $order->transaction_id }}</span>
                        </div>
                        <div class="flex xxs:flex-row flex-col items-center  xxs:justify-between">
                            <span class="font-medium">Plan</span>
                            <span class="text-primary font-semibold">{{ $order->plan->name }}</span>
                        </div>
                        <div class="flex xxs:flex-row flex-col items-center  xxs:justify-between text-lg font-bold">
                            <span>Amount</span>
                            <span class="text-primary">{{ $order->currency }} {{ number_format($order->amount, 2) }}</span>
                        </div>
                        <div class="flex xxs:flex-row flex-col items-center  xxs:justify-between">
                            <span class="font-medium">Status</span>
                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold 
                                    {{ $order->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <div class="flex xxs:flex-row flex-col items-center  xxs:justify-between text-sm">
                            <span class="font-medium">Paid On</span>
                            <span>{{ $order->paid_at?->format('d M Y \a\t h:i A') ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
                @else
                @if(session()->has('trial_completed'))
                <div class="text-center py-8">
                    <p class="text-xl font-semibold text-gray-800">Welcome aboard! 🎉</p>
                    <p class="text-gray-600 mt-2">Your free trial has been activated successfully.</p>
                </div>
                @else
                <p class="text-center text-gray-600">Transaction ID: <span class="font-mono">{{ $transactionId ?? 'N/A' }}</span></p>
                @endif
                @endif

                <!-- Action Buttons -->
                <div class="mt-6 space-y-4">
                    <a href="{{ route('dashboard') }}"
                        class="w-full block text-center bg-gradient-to-r from-secondary to-primary hover:from-primary hover:to-secondary text-white font-bold text-lg py-4 px-8 rounded-xl shadow-lg transform transition-all hover:scale-105 hover:shadow-xl">
                        
                        Go to Dashboard
                    </a>

                    <div class="text-center">
                        <a href="{{ route('home') }}" class="text-gray-600 hover:text-secondary font-medium transition-colors">
                          ← Back to Home
                        </a>
                    </div>
                </div>


            </div>
        </div>


    </div>
</div>

<!-- Add this CSS in your main-layout or a dedicated CSS file -->
<style>
    @keyframes bounce-once {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-20px);
        }
    }

    .animate-bounce-once {
        animation: bounce-once 1s ease-out;
    }
</style>

<!-- Optional: Add confetti effect (using canvas-confetti library) -->
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.2/dist/confetti.browser.min.js"></script>
<script>
    // Trigger confetti on page load
    setTimeout(() => {
        confetti({
            particleCount: 100,
            spread: 70,
            origin: {
                y: 0.6
            },
            colors: ['#10b981', '#14b8a6', '#06b6d4', '#3b82f6', '#8b5cf6']
        });
    }, 500);
</script>
@endsection