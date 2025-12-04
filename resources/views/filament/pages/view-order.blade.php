<x-filament-panels::page>

    <style>
        .section-box {
          
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
            border: 1px solid #2f3031;
        }

        .flex-between {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .space-y-4 > * + * {
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

        .fieldset-box {
            border: 1px solid #2f3031;
            border-radius: 8px;
            padding: 16px;
        }

        .text-muted {
            font-size: 14px;
            color: #e3e3e3;
            font-weight: 500;
        }

        .badge {
            padding: 1px 12px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 13px;
            display: inline-block;
        }

        .badge-success {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-gray {
            background: #e5e7eb;
            color: #374151;
        } 

        .billing-heading {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .space-y-3 > * + * {
            margin-top: 0.75rem;
        }

        .text-small {
            font-size: 14px;
        }

        .text-gray {
            color: #e3e3e3;
        }
    </style>

    @php
        $expiryDate = \Carbon\Carbon::parse($this->record->created_at)->addDays($record->plan->duration);
        $isActive = \Carbon\Carbon::now()->lessThanOrEqualTo($expiryDate);
        $badgeColor = $isActive ? 'success' : ($isActive === false ? 'gray' : 'danger');
        $badgeText = $isActive ? 'Active' : ($isActive === false ? 'Expired' : 'Unknown');
    @endphp


    <div class="section-box">

        <div class="space-y-4">

            <div class="flex-between">
                <span><b>Order Id:</b> #{{ $this->record->id }}</span>

                <span class="badge badge-{{ $badgeColor }}">
                    {{ $badgeText }}
                </span>
            </div>

            <div class="grid-2">

                {{-- LEFT FIELDSET --}}
                <div class="fieldset-box">
                    <dl class="space-y-3">

                        <div>
                            <dt class="text-muted">Order Date: {{ $this->record->created_at->format('M d, Y h:i A') }}</dt>
                        </div>

                        <div>
                            <dt class="text-muted">Plan Expiry: {{ $expiryDate->format('M d, Y h:i A') }}</dt>
                        </div>

                        <div>
                            <dt class="text-muted">Mail: {{ $record->MailAvailable['total_mail'] ?? '0' }}/day</dt>
                        </div>

                        <div>
                            <dt class="text-muted">Available Mail: {{ $record->mailAvailable['available_mail'] ?? '0' }}</dt>
                        </div>

                    </dl>
                </div>

                {{-- RIGHT FIELDSET --}}
                <div class="fieldset-box">
                    <dl class="space-y-3">

                        <div>
                            <dt class="text-muted">Plan: {{ $this->record->plan->name ?? 'N/A' }}</dt>
                        </div>

                        <div>
                            <dt class="text-muted">Amount: ${{ number_format($this->record->amount, 2) }}</dt>
                        </div>

                        <div>
                            <dt class="text-muted">
                                Payment: 
                                <span class="badge 
                                    @if($this->record->status == 'completed') badge-success 
                                    @elseif($this->record->status == 'pending') badge-warning 
                                    @else badge-danger 
                                    @endif
                                ">
                                    {{ ucfirst($this->record->status) }}
                                </span>
                            </dt>
                        </div>

                        <div>
                            <dt class="text-muted">Transaction ID: {{ $this->record->transaction_id ?? 'N/A' }}</dt>
                        </div>

                    </dl>
                </div>

            </div>

        </div>
    </div>


    {{-- BILLING SECTION --}}
    <div class="section-box">

        <h2 class="billing-heading">Billing Address</h2>

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

    </div>

</x-filament-panels::page>
