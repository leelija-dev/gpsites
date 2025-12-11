@php
    use Carbon\Carbon;
    use Illuminate\Support\Str;
@endphp
<x-filament-panels::page>

    <style>
        .space-y-4>*+* {
            margin-top: 1rem;
        }

        .space-y-3>*+* {
            margin-top: 0.75rem;
        }

        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        @media (max-width: 768px) {
            .grid-2 {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .grid-3 {
                grid-template-columns: 1fr;
            }
        }

        .text-muted {
            font-size: 14px;
            font-weight: 500;
        }

        .text-small {
            font-size: 14px;
        }

        /* New class for the right column layout */
        .right-column-layout {
            display: grid;
            grid-template-rows: auto auto;
            gap: 16px;
            height: fit-content;
        }

        /* Table styling for proper spacing */
        .table-proper-spacing {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-proper-spacing th,
        .table-proper-spacing td {
            padding: 12px 16px;
            text-align: left;
            vertical-align: middle;
        }

        .table-proper-spacing th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            background-color: #f9fafb;
            border-bottom: 2px solid #e5e7eb;
        }

        .table-proper-spacing td {
            border-bottom: 1px solid #e5e7eb;
        }

        .table-proper-spacing tbody tr:hover {
            background-color: #f9fafb;
        }

        .dark .table-proper-spacing th {
            background-color: #1f2937;
            border-bottom: 2px solid #374151;
            color: #d1d5db;
        }

        .dark .table-proper-spacing td {
            border-bottom: 1px solid #374151;
            color: #e5e7eb;
        }

        .dark .table-proper-spacing tbody tr:hover {
            background-color: #374151;
        }
    </style>

    <!-- FIRST SECTION (3 CARDS) -->
    <div class="space-y-3">
        <div class="grid-3">
            <!-- Card 1 -->
            <x-filament::section>
                <a href="/admin/users">
                    <div class="space-y-3 text-center">
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div
                                style="display: flex; align-items: center; justify-content: center; background-color: #e6f0ff; border-radius: 50%; width: 40px; height: 40px;">
                                <svg xmlns="http://www.w3.org/2000/svg" style="color: #007bff; height: 25px; width: 25px;"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        
                            <dt class="text-muted">
                                <div>
                                <span class="text-muted font-semibold" style="font-size: 15px;">Users: </span>
                                <span class=" font-semibold text-success"
                                    style="font-size: 15px; font-color: success;   ">{{ $this->totalCustomers }}</span>
                                </div>
                                <div>
                                <span class="text-muted font-semibold" style="font-size: 11px;">Verified User: </span>
                                <span class=" font-semibold text-success"
                                    style="font-size: 11px; font-color: success;   ">{{ $this->verifiedUser }}</span>
                                </div>
                                </dt>
                        </div>
                    </div>
                </a>
            </x-filament::section>

            <!-- Card 2 -->
            <x-filament::section>
                @php
                    $activeOrders = 0;
                @endphp

                @foreach ($this->totalOrders as $order)
                    @php
                        // $expiryDate = Carbon::parse($order->created_at)->addDays($order->plan->duration);
                        $expiryDate = Carbon::parse($order->expire_at);
                        $isValid = Carbon::now()->lessThanOrEqualTo($expiryDate);
                        if ($isValid) {
                            $activeOrders++;
                        }
                    @endphp
                @endforeach

                <div class="space-y-3">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <div
                            style="display: flex; align-items: center; justify-content: center; background-color: #e6f0ff; border-radius: 50%; width: 40px; height: 40px;">
                            <svg xmlns="http://www.w3.org/2000/svg" style="color: #007bff; height: 25px; width: 25px;"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <div class="text-left">
                            <div class="text-muted" style="font-size: 15px;">Total Orders: <span
                                    class="text-danger font-semibold">{{ $this->totalOrders->count() }}</span></div>
                            <div class="text-muted" style="font-size: 11px;">Active Orders: <span
                                    class="text-success font-semibold">{{ $activeOrders }}</span></div>
                        </div>
                    </div>
                </div>
            </x-filament::section>

            <!-- Card 3 -->
            <x-filament::section>
                <div class="space-y-3">
                    @php
                        $totalMails = 0;
                    @endphp
                    @foreach ($this->totalMail as $mail)
                        @php
                            $totalMails += $mail->total_mail;
                        @endphp
                    @endforeach
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <div
                            style="display: flex; align-items: center; justify-content: center; background-color: #e6f0ff; border-radius: 50%; width: 40px; height: 40px;">
                            <svg xmlns="http://www.w3.org/2000/svg" style="color: #007bff; height: 25px; width: 25px;"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="text-left">
                            <div class="text-muted" style="font-size: 15px;">Total Mail: <span
                                    class="text-danger font-semibold">{{ $totalMails }}</span></div>
                            <div class="text-muted" style="font-size: 11px;">Mail Sent: <span
                                    class="text-success font-semibold">{{ $this->totalMailSent }}</span></div>
                        </div>
                    </div>
                </div>
            </x-filament::section>
        </div>
    </div>

    <!-- SECOND SECTION -->
    <div class="space-y-4 mt-6">
        <div class="grid-2">
            <!-- Latest Orders Table -->
            <div>
                <x-filament::section>
                    <x-slot name="heading">
                        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                            <span>Latest Orders</span>
                            <a href="/admin/orders" style="margin-left: auto; color: #007bff;">View all</a>
                        </div>
                    </x-slot>

                    @php
                        $count = 0;
                    @endphp

                    <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                        <table class="table-proper-spacing">
                            <thead>
                                <tr>
                            
                                    <th class="min-w-[150px]">User Name</th>
                                    <th class="min-w-[120px]">Plan</th>
                                    <th class="min-w-[100px]">Amount</th>
                                    <th class="min-w-[100px]">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($this->totalOrders->isNotEmpty())
                                @foreach ($this->totalOrders as $order)
                                    <tr>
                                        <td class="truncate max-w-[150px]">{{ $order->user->name }}</td>
                                        <td class="truncate max-w-[120px]">{{ $order->plan->name }}</td>
                                        <td>${{ number_format($order->amount, 2) }}</td>
                                        <td>{{ $order->created_at->format('d M Y') }}</td>
                                    </tr>
                                    @php
                                        $count++;
                                        if ($count == 10) {
                                            break;
                                        }
                                    @endphp
                                @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="p-4 text-center">No orders found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </x-filament::section>
            </div>

            <div class="right-column-layout">
                <!-- Recent Contact Table -->
                <x-filament::section>
                    <x-slot name="heading">
                        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                            <span>Recent Contact</span>
                            <a href="/admin/contacts" style="margin-left: auto; color: #007bff;">View all</a>
                        </div>
                    </x-slot>

                    <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                        <table class="table-proper-spacing">
                            <thead>
                                <tr>
                                    
                                    <th class="min-w-[150px]"></th>
                                    <th class="min-w-[180px]">Subject</th>
                                    
                                </tr>
                            </thead>
                            <tbody> 
                                @php
                                    $count = 0;
                                @endphp
                                @if($this->latestContact->isNotEmpty())
                                @foreach ($this->latestContact as $contact)
                                    <tr>
                                     
                                        <td class="truncate max-w-[120px]">
                                                {{ $contact->name }} <br>
                                                <span class="block text-sm " style="font-size: 12px">{{$contact->email}}</span>
                                            </td>
                                        <td class="truncate max-w-[180px]">
                                            {{ $contact->subject }}<br>
                                             <span style="font-size: 11px;">{{ $contact->created_at->format('d M Y') }} </span>
                                        </td>
                                        
                                    </tr>
                                    @php $count++; @endphp
                                    @if ($count == 5)
                                        @break
                                    @endif
                                @endforeach
                                @else
                                    <tr>
                                        <td colspan="2" class="p-4 text-center">No contact found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </x-filament::section>

                <!-- Plan Table -->
                <x-filament::section>
                    <x-slot name="heading">
                        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                            <span>Plans</span>
                            <a href="/admin/plans" style="margin-left: auto; color: #007bff;">View all</a>
                        </div>
                    </x-slot>
                    
                    <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                        <table class="table-proper-spacing">
                            <thead>
                                <tr>
                                    <th class="min-w-[150px]">Name</th>
                                    <th class="min-w-[100px]">Price</th>
                                    <th class="min-w-[100px]">Duration</th>
                                    <th class="min-w-[120px]">Mail/day</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($this->plans->isNotEmpty())
                                @foreach ($this->plans as $plan)
                                    <tr>
                                        <td class="truncate max-w-[150px]">{{ $plan->name }}</td>
                                        <td>${{ number_format($plan->price, 2) }}</td>
                                        <td>{{ $plan->duration }} days</td>
                                        <td>
                                            @if ($plan->price == 0)
                                                {{ $plan->mail_available }} (Total)
                                            @else
                                                {{ $plan->mail_available }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="4" class="text-center">No plans found.</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </x-filament::section>
            </div>
        </div>
    </div>

</x-filament-panels::page>