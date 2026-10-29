@extends('layouts.app')
@section('title', 'My Orders')

@php
    $statusClasses = [
        'pending' => 'bg-yellow-100 text-yellow-800',
        'mailed'  => 'bg-green-100 text-green-800',
        'failed'  => 'bg-red-100 text-red-800',
    ];
@endphp

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">
        <h1 class="text-2xl font-bold text-gray-900">My Orders</h1>

        <form method="GET" class="flex flex-col sm:flex-row gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search site or service..."
                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg bg-white">
                <option value="">All status</option>
                @foreach (['pending', 'mailed', 'failed'] as $s)
                    <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Filter</button>
        </form>
    </div>

    <div class="overflow-x-auto bg-white rounded-lg shadow border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-600">#</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-600">Website</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-600">Service</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-600">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-600">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-600">Date</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold uppercase text-gray-600">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($orders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $order->id }}</td>
                        <td class="px-6 py-4 text-sm">
                            <div class="font-medium text-gray-900">{{ $order->website_name ?: '—' }}</div>
                            <a href="{{ $order->site_url }}" target="_blank" rel="nofollow noopener"
                               class="text-blue-600 hover:underline text-xs break-all">{{ $order->site_url }}</a>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $order->price_label }}</td>
                        <td class="px-6 py-4 text-sm font-semibold text-purple-700">
                            ${{ rtrim(rtrim(number_format($order->price, 2), '0'), '.') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                            {{ $order->created_at->format('d M Y, h:i A') }}
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <a href="{{ route('orders.show', base64_encode($order->id)) }}"
                               class="px-3 py-1.5 text-sm font-medium text-white bg-blue-600 rounded hover:bg-blue-700">View</a>
                            @if ($order->user_mail_history_id)
                                <a href="{{ route('view.order.conversation', encrypt($order->user_mail_history_id)) }}"
                                   class="px-3 py-1.5 text-sm font-medium text-purple-700 border border-purple-300 rounded hover:bg-purple-50">Show Conversation</a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center text-gray-500">No orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $orders->links('pagination::bootstrap-5') }}</div>
</div>
@endsection