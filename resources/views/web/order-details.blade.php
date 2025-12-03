@php
    use Illuminate\Support\Facades\Auth;
    $loggedUserId = Auth::id();
@endphp

<x-app-layout>
    

    <style>
        a { text-decoration: none !important; }
        a:hover { text-decoration: none !important; }
    </style>

    <div class="min-h-screen bg-white flex">
        <!-- Main Content Area -->
        <div class="flex-1 p-6 lg:p-8 w-full">
            <div class="">

                <!-- Table Container -->
                <div class="overflow-x-auto shadow-xl rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-[#f0f0f0] text-[#575757]">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">SL No</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Plan Name</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Payment Status</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Total Mail</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Mail Available</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Order Date</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Plan Expiring</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Plan Status</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            @if($orders->isNotEmpty())
                                @foreach ($orders as $order)
                                    @php
                                        $expiryDate = \Carbon\Carbon::parse($order->created_at)->addDays($order->plan->duration);
                                        $isActive = \Carbon\Carbon::now()->lessThanOrEqualTo($expiryDate);
                                        $isCompleted = $order->status === 'completed';
                                        $page = request()->get('page', 1);
                                        $serial = ($page - 1) * $orders->perPage() + $loop->iteration;
                                    @endphp

                                    <tr class="{{ !$isActive && $isCompleted ? 'bg-gray-100' : '' }} hover:bg-gray-50 transition-all duration-200">
                                        <td class="px-6 py-4 text-center text-sm font-medium text-gray-900">
                                            {{ $serial }}
                                        </td>
                                        <td class="px-6 py-4 text-center text-sm text-gray-700">
                                            {{ $order->plan->name }}
                                        </td>
                                        <td class="px-6 py-4 text-center text-sm font-semibold text-gray-800">
                                            ${{ number_format($order->amount, 2) }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if($order->status === 'completed')
                                                <span class="inline-flex px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800">
                                                    Completed
                                                </span>
                                            @else
                                                <span class="inline-flex px-3 py-1 text-xs font-bold rounded-full bg-yellow-100 text-yellow-800">
                                                    {{ ucfirst($order->status ?? 'Incomplete') }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center text-sm text-gray-700">
                                            {{ $order->mailAvailable->total_mail ?? 0 }}
                                        </td>
                                        <td class="px-6 py-4 text-center text-sm font-medium text-blue-600">
                                            {{ $order->mailAvailable->available_mail ?? 0 }}
                                        </td>
                                        <td class="px-6 py-4 text-center text-sm text-gray-600">
                                            {{ $order->created_at->format('d-m-Y, h:i A') }}
                                        </td>
                                        <td class="px-6 py-4 text-center text-sm text-gray-600">{{$expiryDate->format('d-m-Y, h:i A')}}</td>
                                        <td class="px-6 py-4 text-center">
                                            @if($isCompleted)
                                                @if($isActive)
                                                    <span class="inline-flex px-3 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-800">
                                                        Active
                                                    </span>
                                                @else
                                                    <span class="inline-flex px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-800">
                                                        Expired
                                                    </span>
                                                @endif
                                            @else
                                                <span class="text-gray-400 text-xs">—</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <a href="{{ route('view-my-order', encrypt(['id' => $order->id])) }}"
                                               class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition shadow">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" class="px-6 py-16 text-center text-gray-500 text-lg font-medium">
                                        No orders yet!
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($orders->hasPages())
                    <div class="mt-10 flex justify-center">
                        {{ $orders->onEachSide(2)->links() }}
                        <!-- Or use: {{ $orders->links('pagination::tailwind') }} for custom style -->
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>