<x-filament-panels::page class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        {{-- <h2 class="text-2xl font-bold text-gray-800">
            Order Details
        </h2> --}}
    </div>

    {{-- Order Details Card --}}
    <div class="bg-white shadow-md rounded-xl p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4"><b>Order Summary</b></h3>

        <table class="w-full text-left border-separate border-spacing-y-3">
            <tr>
                <th class="text-gray-500 font-semibold w-1/4">Customer ID:</th>
                <td class="bg-gray-50 border border-gray-300 rounded-lg px-3 py-2">
                    {{ $this->record->user->id }}
                </td>
            </tr>
            <tr>
                <th class="text-gray-500 font-semibold w-1/4">Order ID:</th>
                <td class="bg-gray-50 border border-gray-300 rounded-lg px-3 py-2">
                    {{ $this->record->id }}
                </td>
            </tr>

            <tr>
                <th class="text-gray-500 font-semibold">Plan Name:</th>
                <td class="bg-gray-50 border border-gray-300 rounded-lg px-3 py-2">
                    {{ $this->record->plan->name ?? 'N/A' }}
                </td>
            </tr>

            <tr>
                <th class="text-gray-500 font-semibold">Amount:</th>
                <td class="bg-gray-50 border border-gray-300 rounded-lg px-3 py-2">
                    ${{ number_format($this->record->amount, 2) }}
                </td>
            </tr>

            <tr>
                <th class="text-gray-500 font-semibold">Status:</th>
                <td>
                <x-filament::badge
                :color="$this->record->status === 'completed'
                    ? 'success'
                    : ($this->record->status === 'pending' ? 'warning' : 'danger')">
                {{ ucfirst($this->record->status) }}
            </x-filament::badge>

            </td>

            </tr>

            <tr>
                <th class="text-gray-500 font-semibold">Transaction ID:</th>
                <td class="bg-gray-50 border border-gray-300 rounded-lg px-3 py-2">
                    {{ $this->record->transaction_id ?? '' }}
                </td>
            </tr>

            <tr>
                <th class="text-gray-500 font-semibold">Order Date:</th>
                <td class="bg-gray-50 border border-gray-300 rounded-lg px-3 py-2">
                    {{ $this->record->created_at->format('d-m-Y, h:i A') }}
                </td>
            </tr>
        </table>
    </div>

    {{-- Customer Details --}}
    <div class="bg-white shadow-md rounded-xl p-6 space-y-4">
        <h3 class="text-lg font-bold text-gray-800"><strong>Bill Details</strong></h3>

        <table class="w-full text-left border-separate border-spacing-y-3">
            <tr>
                <th class="text-gray-500 font-semibold w-1/4">Name:</th>
                <td class="bg-gray-50 border border-gray-300 rounded-lg px-3 py-2">
                    {{ ($this->record->billing_info['first_name']) .' '.($this->record->billing_info['last_name'])}}
                </td>
            </tr>

            <tr>
                <th class="text-gray-500 font-semibold">Email:</th>
                <td class="bg-gray-50 border border-gray-300 rounded-lg px-3 py-2">
                    {{ ($this->record->billing_info['email']) }}
                </td>
            </tr>
             <tr>
                <th class="text-gray-500 font-semibold">Mobile:</th>
                <td class="bg-gray-50 border border-gray-300 rounded-lg px-3 py-2">
                    {{ ($this->record->billing_info['phone']) }}
                </td>
            </tr>
             <tr>
                <th class="text-gray-500 font-semibold">Address :</th>
                <td class="bg-gray-50 border border-gray-300 rounded-lg px-3 py-2">
                    {{ ($this->record->billing_info['address1']) }}
                </td>
            </tr>
             <tr>
                <th class="text-gray-500 font-semibold">City:</th>
                <td class="bg-gray-50 border border-gray-300 rounded-lg px-3 py-2">
                    {{ ($this->record->billing_info['city']) }}
                </td>
            </tr>
             <tr>
                <th class="text-gray-500 font-semibold">State:</th>
                <td class="bg-gray-50 border border-gray-300 rounded-lg px-3 py-2">
                    {{ ($this->record->billing_info['state']) }}
                </td>
            </tr>
             <tr>
                <th class="text-gray-500 font-semibold">Zip Code:</th>
                <td class="bg-gray-50 border border-gray-300 rounded-lg px-3 py-2">
                    {{ ($this->record->billing_info['zip']) }}
                </td>
            </tr>
        </table>
    </div>

</x-filament-panels::page>
