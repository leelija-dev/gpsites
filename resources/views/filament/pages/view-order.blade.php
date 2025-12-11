<x-filament-panels::page>

    <style>
        .space-y-4>*+* {
            margin-top: 1rem;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        @media (max-width: 768px) {
            .grid-2 {
                grid-template-columns: 1fr;
            }
        }

        .text-muted {
            font-size: 14px;
            /* color: #e3e3e3; */
            font-weight: 500;
        }
        .space-y-3>*+* {
            margin-top: 0.75rem;
        }

        .text-small {
            font-size: 14px;
        }
    </style>

    @php
        $expiryDate = \Carbon\Carbon::parse($this->record->created_at)->addDays($record->plan->duration);
        $isActive = \Carbon\Carbon::now()->lessThanOrEqualTo($expiryDate);
        $badgeColor = $isActive ? 'success' : ($isActive === false ? 'gray' : 'danger');
        $badgeText = $isActive ? 'Active' : ($isActive === false ? 'Expired' : 'Unknown');

        $paymentBadgeColor = $this->record->status == 'completed' ? 'success' : ($this->record->status == 'pending' ? 'warning' : 'danger');

    @endphp


    <x-filament::section>
        <x-slot name="heading">
            Order ID: <b> #{{ $this->record->id }}</b>
        </x-slot>

        <x-slot name="afterHeader">
            <x-filament::badge color="{{ $badgeColor }}">
                {{ $badgeText }}
            </x-filament::badge>
        </x-slot>

        <div class="space-y-4">

            <div class="grid-2">

                {{-- LEFT FIELDSET --}}
                <x-filament::section>

                    <dl class="space-y-3">

                        <div>
                            <dt class="text-muted">Order Date: {{ $this->record->created_at->format('M d, Y h:i A') }}
                            </dt>
                        </div>

                        <div>
                            <dt class="text-muted">Plan Expiry: {{ $this->record->expire_at->format('M d, Y h:i A') ?? '' }}</dt>
                        </div>

                        <div>
                            <dt class="text-muted">Mail: {{ $record->MailAvailable['total_mail'] ?? '0' }}/day</dt>
                        </div>

                        <div>
                            <dt class="text-muted">Available Mail: {{ $record->mailAvailable['available_mail'] ?? '0' }}
                            </dt>
                        </div>

                    </dl>
                </x-filament::section>

                {{-- RIGHT FIELDSET --}}
                <x-filament::section>
                    <dl class="space-y-3">

                        <div>
                            <dt class="text-muted">Plan: {{ $this->record->plan->name ?? 'N/A' }}</dt>
                        </div>

                        <div>
                            <dt class="text-muted">Amount: {{ config('app.currency') }}{{ number_format($this->record->amount, 2) }}</dt>
                        </div>

                        <div>
                            <dt class="text-muted">
                                Payment:
                                <x-filament::badge color="{{ $paymentBadgeColor }}">
                                    {{ ucfirst($this->record->status) }}
                                </x-filament::badge>
                            </dt>
                        </div>

                        <div>
                            <dt class="text-muted">Transaction ID: {{ $this->record->transaction_id ?? 'N/A' }}</dt>
                        </div>

                    </dl>
                </x-filament::section>

            </div>

        </div>
    </x-filament::section>


    <x-filament::section>
        <x-slot name="heading">
            Billing Address
        </x-slot>

        <div class="grid-2">

            <div class="space-y-3">
                <p class="text-small text-gray">
                    {{ ($this->record->billing_info['first_name'] ?? '') . ' ' . ($this->record->billing_info['last_name'] ?? '') }}
                </p>
                <p class="text-small text-gray">{{ $this->record->billing_info['email'] ?? 'N/A' }}</p>
                <p class="text-small text-gray">{{ $this->record->billing_info['phone'] ?? 'N/A' }}</p>
            </div>

            <div class="space-y-3">
                <p class="text-small text-gray">{{ $this->record->billing_info['address1'] ?? 'N/A' }}</p>
                <p class="text-small text-gray">
                    {{ ($this->record->billing_info['city'] ?? '') . ', ' . ($this->record->billing_info['state'] ?? '') . ' ' . ($this->record->billing_info['zip'] ?? '') }}
                </p>
                <p class="text-small text-gray">{{ $this->record->billing_info['country'] ?? 'N/A' }}</p>
            </div>

        </div>
    </x-filament::section>

</x-filament-panels::page>
