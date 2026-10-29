@extends('layouts.app')

@section('title','Mail History')
@section('content')

    <div class="min-h-screen bg-gray-50">
        <!-- Main Content -->
        <div class="p-6 lg:p-10">
            <div class="max-w-7xl mx-auto">

                <!-- Filter -->
                    <form method="GET" action="{{ url()->current() }}"
                        class="flex flex-col lg:flex-row lg:items-center gap-4 mb-6">

                        {{-- Left: title --}}
                        <div class="lg:w-1/3">
                            <h1 class="text-2xl font-bold text-gray-900">Mail History</h1>
                            <p class="text-sm text-gray-500 mt-1">
                                View all your sent campaigns, offers and orders.
                                <span class="font-semibold text-indigo-600">{{ $mails->total() }}</span>
                                {{ \Illuminate\Support\Str::plural('mail', $mails->total()) }} found
                                @if (request('type'))
                                    in <span class="font-semibold text-gray-700">{{ ucfirst(request('type')) }}</span>
                                @endif
                            </p>
                        </div>

                        {{-- Center: search --}}
                        <div class="lg:w-1/3 flex lg:justify-center">
                            <div class="relative w-full max-w-sm">
                                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
                                </svg>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Search site, subject or email..."
                                    class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl shadow-sm text-sm
                                            focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                            </div>
                        </div>

                        {{-- Right: filter --}}
                        <div class="lg:w-1/3 flex lg:justify-end">
                            <div class="inline-flex items-center gap-3 bg-white border border-gray-200 rounded-xl shadow-sm px-4 py-2.5">

                                <svg class="w-5 h-5 text-indigo-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h18l-7 8v6l-4 2v-8L3 4z" />
                                </svg>

                                <div class="relative">
                                    <select name="type" id="type" onchange="this.form.submit()"
                                            class="appearance-none cursor-pointer bg-indigo-50 text-indigo-700 font-semibold text-sm
                                                pl-4 pr-10 py-2 rounded-lg border border-indigo-100
                                                hover:bg-indigo-100 focus:ring-2 focus:ring-indigo-500 focus:outline-none transition">
                                        <option value="">All mails</option>
                                        <option value="campaign" @selected(request('type') === 'campaign')>Campaign</option>
                                        <option value="offer"    @selected(request('type') === 'offer')>Offer</option>
                                        <option value="order"    @selected(request('type') === 'order')>Order</option>
                                    </select>
                                    <svg class="w-4 h-4 text-indigo-600 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>

                                @if (request('type') || request('search'))
                                    <a href="{{ url()->current() }}"
                                    class="flex items-center gap-1 text-sm font-medium text-gray-500 hover:text-red-600 transition"
                                    title="Clear all filters">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Clear
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                <!-- Table Container -->
                <div class="bg-white shadow-xl rounded-xl overflow-hidden border border-gray-200">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-[#f0f0f0] text-[#575757]">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">SL No</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Site URL</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Subject</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Message</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Sent Date</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 bg-white">
                                @if($mails->isNotEmpty())
                                    @php
                                        $page = request()->get('page', 1);
                                        $perPage = $mails->perPage();
                                        $serialStart = ($page - 1) * $perPage;
                                    @endphp

                                    @foreach ($mails as $mail)
                                        @php
                                            $cleanMessage = strip_tags($mail->message);
                                            $shortSubject = strlen($mail->subject) > 30
                                                ? substr($mail->subject, 0, 15) . '...' . substr($mail->subject, -10)
                                                : $mail->subject;

                                            $shortMessage = strlen($cleanMessage) > 40
                                                ? substr($cleanMessage, 0, 20) . '...' . substr($cleanMessage, -15)
                                                : $cleanMessage;
                                        @endphp

                                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                            <td class="px-6 py-4 text-center text-sm font-medium text-gray-900">
                                                {{ $serialStart + $loop->iteration }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-700">
                                                <a href="{{ $mail->site_url }}" target="_blank" class="text-blue-600 hover:underline break-all">
                                                    {{ Str::limit($mail->site_url, 40) }}
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-800 font-medium" title="{{ $mail->subject }}">
                                                {{ $shortSubject }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-600" title="{{ $cleanMessage }}">
                                                {{ $shortMessage }}
                                            </td>
                                            <td class="px-6 py-4 text-center text-sm text-gray-600">
                                                @if($mail->status == 1)
                                                    <span class="px-2 py-1 rounded-full text-white bg-green-600" style="height: 10px; line-height: 10px;">Sent</span>
                                                @else
                                                    <span class="px-2 py-1 rounded-full text-white bg-yellow-400" style="height: 18px; line-height: 18px;">Failed</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-center text-sm text-gray-600">
                                                {{ $mail->created_at->format('d M Y') }}
                                                <span class="block text-xs text-gray-400">
                                                    {{ $mail->created_at->format('h:i A') }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <a href="{{ route('blog.view-mail', encrypt($mail->id)) }}"
                                                   class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm rounded-lg shadow-md transition transform hover:scale-105">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                    View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="px-6 py-16 text-center text-gray-500 text-lg font-medium">
                                            No mail history found.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($mails->hasPages())
                        <div class="bg-white px-6 py-5 border-t border-gray-200">
                            <div class="flex justify-center">
                                {{ $mails->onEachSide(2)->links() }}
                                <!-- Or: {{ $mails->links('pagination::tailwind') }} for custom style -->
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
