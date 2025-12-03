<x-filament-panels::page>
    @php
        $expiryDate = \Carbon\Carbon::parse($this->record->created_at)->addDays($record->plan->duration);
        $isActive = \Carbon\Carbon::now()->lessThanOrEqualTo($expiryDate);
        $badgeColor = $isActive ? 'success' : ($isActive === false ? 'gray' : 'danger');
        $badgeText = $isActive ? 'Active' : ($isActive === false ? 'Expired' : 'Unknown');
    @endphp

    <x-filament::section>
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                #{{ $this->record->id }}
                <x-filament::badge :color="$badgeColor" size="lg">
                    {{ $badgeText }}
                </x-filament::badge>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-filament::fieldset>
                    <dl class="space-y-3">
                        <div class="grid grid-cols-3 gap-4 py-1">
                            <dt class="text-sm font-medium text-gray-500">Order Date: {{ $this->record->created_at->format('M d, Y h:i A') }}</dt>
                        </div>
                        <div class="grid grid-cols-3 gap-4 py-1">
                            <dt class="text-sm font-medium text-gray-500">Plan Expiry: {{ $expiryDate->format('M d, Y h:i A') }}</dt>
                        </div>
                        <div class="grid grid-cols-3 gap-4 py-1">
                            <dt class="text-sm font-medium text-gray-500">Mail: {{ $record->MailAvailable['total_mail'] ?? '0' }}/day</dt>
                        </div>
                        <div class="grid grid-cols-3 gap-4 py-1">
                            <dt class="text-sm font-medium text-gray-500">Available Mail: {{ $record->mailAvailable['available_mail'] ?? '0' }}</dt>
                        </div>
                    </dl>
                </x-filament::fieldset>

                <x-filament::fieldset>
                    <dl class="space-y-3">
                        <div class="grid grid-cols-3 gap-4 py-1">
                            <dt class="text-sm font-medium text-gray-500">Plan: {{ $this->record->plan->name ?? 'N/A' }}</dt>
                        </div>
                        <div class="grid grid-cols-3 gap-4 py-1">
                            <dt class="text-sm font-medium text-gray-500">Amount: ${{ number_format($this->record->amount, 2) }}</dt>
                        </div>
                        <div class="grid grid-cols-3 gap-4 py-1">
                            <dt class="text-sm font-medium text-gray-500">Payment: <x-filament::badge
                                    :color="match($this->record->status) {
                                        'completed' => 'success',
                                        'pending' => 'warning',
                                        default => 'danger',
                                    }"
                                    size="sm"
                                >
                                    {{ ucfirst($this->record->status) }}
                                </x-filament::badge></dt>
                        </div>
                        <div class="grid grid-cols-3 gap-4 py-1">
                            <dt class="text-sm font-medium text-gray-500">Transaction ID: {{ $this->record->transaction_id ?? 'N/A' }}</dt>
                        </div>
                    </dl>
                </x-filament::fieldset>
            </div>
        </div>
    </x-filament::section>

    <x-filament::section>
        <x-slot name="heading">
            <h2 class="text-lg font-medium">
                Billing Address
            </h2>
        </x-slot>

        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-3">
                    <div class="space-y-1">
                        <p class="text-sm text-gray-900">
                            {{ ($this->record->billing_info['first_name'] ?? '') . ' ' . ($this->record->billing_info['last_name'] ?? '') }}
                        </p>
                        <p class="text-sm text-gray-500">{{ $this->record->billing_info['email'] ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-500">{{ $this->record->billing_info['phone'] ?? 'N/A' }}</p>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="space-y-1">
                        <p class="text-sm text-gray-500">{{ $this->record->billing_info['address1'] ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-500">
                            {{ ($this->record->billing_info['city'] ?? '') . ', ' . ($this->record->billing_info['state'] ?? '') . ' ' . ($this->record->billing_info['zip'] ?? '') }}
                        </p>
                        <p class="text-sm text-gray-500">{{ $this->record->billing_info['country'] ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-panels::page>
