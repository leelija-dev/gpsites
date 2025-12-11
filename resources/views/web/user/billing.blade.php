@extends('layouts.app')

@section('title','Billing')
@section('content')

@php
    use Illuminate\Support\Facades\Auth;
    use carbon\Carbon;
    $loggedUserId = Auth::id();
@endphp

    <div class="min-h-screen bg-gray-50">
        <!-- Main Content -->
        <div class="p-6 lg:p-10">
            <div class="max-w-7xl mx-auto">
               

                <!-- Responsive Table Container -->
                <div class="overflow-x-auto shadow-lg rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-[#f0f0f0] text-[#575757]">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">
                                    SL No
                                </th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">
                                    Plan Order ID
                                </th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">
                                    Mail/day
                                </th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">
                                    Plan Status
                                </th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">
                                    Validity
                                </th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">
                                    Order Date
                                </th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">
                                    Plan Expiring
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @if($bills->isNotEmpty())
                                @foreach ($bills as $bill)
                                    @php
                                        // $expiryDate = \Carbon\Carbon::parse($bill->created_at)->addDays($bill->duration);
                                        $expiryDate = \Carbon\Carbon::parse($bill->expire_at);
                                        $isActive = \Carbon\Carbon::now()->lessThanOrEqualTo($expiryDate);
                                        $page=$_GET['page'] ?? 1;
                                    @endphp
                                        
                                    <tr class="{{ $isActive ? 'bg-white hover:bg-gray-50' : 'bg-gray-100 hover:bg-gray-200' }} transition-colors">
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-medium text-gray-900">
                                            {{ ($page - 1) * 10 + $loop->index + 1 }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-700">
                                            #{{ $bill->id ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-700">
                                            @if($bill->plan->price == 0)
                                            {{ $bill->mailAvailable->total_mail ?? 0 }} (Total)
                                            @else
                                            {{ $bill->mailAvailable->total_mail ?? 0 }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @if($isActive)
                                                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                    Active
                                                </span>
                                            @else
                                                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                    Expired
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-700">
                                            {{-- {{ $bill->duration }} day{{ $bill->duration > 1 ? 's' : '' }} --}}
                                            @php 
                                            $duration = round(Carbon::parse($bill->created_at)
                                            ->floatDiffInDays(Carbon::parse($bill->expire_at))); 
                                            @endphp
                                            {{ $duration }} day{{ $duration > 1 ? 's' : '' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-700">
                                            {{ $bill->created_at->format('d-m-Y, h:i A') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-700">
                                            {{ $expiryDate->format('d-m-y, h:i A') }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-gray-500 text-lg">
                                        No Billing found!
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($bills->hasPages())
                    <div class="mt-8 flex justify-center">
                        {{ $bills->links() }} <!-- Default Tailwind pagination (works if you have ->links() configured) -->
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection