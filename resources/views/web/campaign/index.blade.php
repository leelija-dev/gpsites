@extends('layouts.app')
@section('title', 'Campaign')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Campaign (Group Mail)</h1>

        <form method="GET" class="flex flex-col sm:flex-row gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search site or subject..."
                   class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg bg-white">
                <option value="">All status</option>
                <option value="1" @selected(request('status') === '1')>Sent</option>
                <option value="0" @selected(request('status') === '0')>Failed</option>
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
                <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-600">Subject</th>
                <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-600">Status</th>
                <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-600">Date</th>
                <th class="px-6 py-3 text-center text-xs font-semibold uppercase text-gray-600">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse ($mails as $mail)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 text-sm text-blue-600 break-all">{{ $mail->site_url ?: '—' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-800">{{ \Illuminate\Support\Str::limit($mail->subject, 60) }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $mail->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $mail->status ? 'Sent' : 'Failed' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $mail->created_at->format('d M Y, h:i A') }}</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">
                        @if ($mail->status)
                            <a href="{{ route('view.campaign.conversation', encrypt($mail->id)) }}"
                               class="px-3 py-1.5 text-sm font-medium text-white bg-blue-600 rounded hover:bg-blue-700">
                                View Conversation
                            </a>
                        @else
                            <span class="text-xs text-gray-400" title="{{ $mail->description }}">Not sent</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-10 text-center text-gray-500">No mails found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $mails->links('pagination::bootstrap-5') }}</div>
</div>
@endsection