@extends('layouts.app')
@section('title', 'Order #' . $order->id)

@php
    $statusClasses = [
        'pending' => 'bg-yellow-100 text-yellow-800',
        'mailed'  => 'bg-green-100 text-green-800',
        'failed'  => 'bg-red-100 text-red-800',
    ];
    $priceText = '$' . rtrim(rtrim(number_format($order->price, 2), '0'), '.');
@endphp

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">

    <a href="{{ route('orders.index') }}" class="text-sm text-blue-600 hover:underline">&larr; Back to orders</a>

    <div class="mt-3 bg-white rounded-xl shadow border border-gray-200 overflow-hidden">

        {{-- Header --}}
        <div class="p-6 text-white" style="background:linear-gradient(135deg,#2563eb,#7c3aed)">
            <div class="flex flex-wrap items-start justify-between gap-3">
                <div>
                   
                    <h1 class="text-2xl font-bold mt-1">{{ $order->website_name ?: $order->site_url }}</h1>
                    <a href="{{ $order->site_url }}" target="_blank" rel="nofollow noopener"
                       class="text-sm underline opacity-90 break-all">{{ $order->site_url }}</a>
                </div>
                <span class="px-3 py-1 text-xs font-bold rounded-full {{ $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-700' }}">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
        </div>

        <div class="p-6 space-y-6">

            {{-- Summary --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="p-4 rounded-lg bg-purple-50 border border-purple-200">
                    <div class="text-xs uppercase font-semibold text-gray-500">Service</div>
                    <div class="mt-1 font-bold text-gray-900">{{ $order->price_label }}</div>
                </div>
                <div class="p-4 rounded-lg bg-purple-50 border border-purple-200">
                    <div class="text-xs uppercase font-semibold text-gray-500">Price</div>
                    <div class="mt-1 text-2xl font-extrabold text-purple-700">{{ $priceText }}</div>
                </div>
            </div>

            {{-- Details --}}
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                
                <div>
                    <dt class="text-gray-500">Placed on</dt>
                    <dd class="font-medium text-gray-900">{{ $order->created_at->format('d M Y, h:i A') }}</dd>
                </div>
            </dl>

            {{-- Buyer content --}}
            <div>
                <h2 class="font-bold text-gray-900 mb-2">Your link / article</h2>
                <div class="p-4 bg-gray-50 border-l-4 border-purple-600 rounded prose max-w-none break-words">
                    {!! strip_tags($order->content, '<p><br><b><strong><i><em><u><ul><ol><li><a>') !!}
                </div>
            </div>

            {{-- Error --}}
            @if ($order->status === 'failed' && $order->error)
                <div class="p-4 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700">
                    <div class="font-semibold mb-1">Mail error</div>
                    {{ $order->error }}
                </div>
            @endif

            {{-- Actions --}}
            <div class="flex flex-wrap gap-3 pt-4 border-t border-gray-200">
                @if ($order->user_mail_history_id)
                    <a href="{{ route('view.order.conversation', encrypt($order->user_mail_history_id)) }}"
                       class="px-5 py-2.5 text-sm font-semibold text-white rounded-lg shadow hover:opacity-90"
                       style="background:linear-gradient(135deg,#2563eb,#7c3aed)">
                        Show full conversation
                    </a>
                @else
                    <span class="px-5 py-2.5 text-sm text-gray-500 bg-gray-100 rounded-lg">
                        No conversation yet (mail not sent)
                    </span>
                @endif
                <a href="{{ route('orders.index') }}"
                   class="px-5 py-2.5 text-sm font-medium text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">
                    Back
                </a>
            </div>
        </div>
    </div>
</div>
@endsection