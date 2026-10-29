<x-filament-panels::page>
    @php
        $logs = $this->getLogs();
        $customer = \App\Models\User::find($this->userId);

        $counts = \App\Models\UserMailHistory::where('user_id', $this->userId)
            ->selectRaw('mail_type, count(*) as c')
            ->groupBy('mail_type')
            ->pluck('c', 'mail_type');
        $cCampaign = $counts['campaign'] ?? 0;
        $cOffer = $counts['offer'] ?? 0;
        $cOrder = $counts['order'] ?? 0;
        $cTotal = $counts->sum();

        $badges = [
            'campaign' => ['Campaign', 'info'],
            'offer' => ['Offer', 'primary'],
            'order' => ['Order', 'success'],
            'blog' => ['Blog', 'warning'],
        ];
    @endphp

    <style>
        .mh {
            --mh-card: #fff;
            --mh-border: #e5e7eb;
            --mh-text: #111827;
            --mh-muted: #6b7280;
            --mh-tile: #f9fafb;
            --mh-head: #f3f4f6;
            --mh-hover: #f5f3ff;
            --mh-active: #eef2ff;
            color: var(--mh-text);
        }

        .dark .mh {
            --mh-card: #111827;
            --mh-border: #374151;
            --mh-text: #f3f4f6;
            --mh-muted: #9ca3af;
            --mh-tile: #1f2937;
            --mh-head: #1f2937;
            --mh-hover: #1e1b4b;
            --mh-active: #312e81;
        }

        .mh-banner {
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            border-radius: 16px;
            padding: 22px 24px;
            color: #fff;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 16px
        }

        .mh-eyebrow {
            font-size: 11px;
            letter-spacing: 1px;
            text-transform: uppercase;
            opacity: .8
        }

        .mh-title {
            font-size: 22px;
            font-weight: 800;
            margin-top: 2px
        }

        .mh-sub {
            font-size: 13px;
            color: #e0e7ff;
            margin-top: 4px;
            word-break: break-all
        }

        .mh-total {
            background: rgba(255, 255, 255, .16);
            border: 1px solid rgba(255, 255, 255, .35);
            border-radius: 12px;
            padding: 10px 18px;
            text-align: center
        }

        .mh-total b {
            display: block;
            font-size: 24px;
            line-height: 1.1
        }

        .mh-total span {
            font-size: 11px;
            opacity: .85
        }

        .mh-tiles {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-top: 14px
        }

        .mh-tile {
            all: unset;
            box-sizing: border-box;
            cursor: pointer;
            background: var(--mh-card);
            border: 1px solid var(--mh-border);
            border-radius: 12px;
            padding: 12px 14px;
            transition: all .15s
        }

        .mh-tile:hover {
            border-color: #7c3aed;
            transform: translateY(-1px)
        }

        .mh-tile.on {
            background: var(--mh-active);
            border-color: #7c3aed
        }

        .mh-tile b {
            display: block;
            font-size: 20px;
            line-height: 1.2
        }

        .mh-tile span {
            font-size: 12px;
            color: var(--mh-muted)
        }

        .mh-card {
            background: var(--mh-card);
            border: 1px solid var(--mh-border);
            border-radius: 16px;
            margin-top: 14px;
            overflow: hidden
        }

        .mh-tools {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: center;
            padding: 14px 16px;
            border-bottom: 1px solid var(--mh-border)
        }

        .mh-table {
            width: 100%;
            table-layout: fixed;
            border-collapse: separate;
            border-spacing: 0
        }

        .mh-table th {
            background: var(--mh-head);
            color: var(--mh-muted);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .8px;
            text-transform: uppercase;
            text-align: left;
            padding: 12px 14px;
            border-bottom: 1px solid var(--mh-border)
        }

        .mh-table td {
            padding: 14px;
            border-bottom: 1px solid var(--mh-border);
            vertical-align: middle;
            font-size: 13px;
            word-break: break-word;
            overflow-wrap: anywhere
        }

        .mh-table tbody tr:last-child td {
            border-bottom: 0
        }

        .mh-table tbody tr:hover {
            background: var(--mh-hover)
        }

        .mh-center {
            text-align: center !important
        }

        .mh-site {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0
        }

        .mh-av {
            flex: 0 0 34px;
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            color: #fff;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center
        }

        .mh-host {
            font-weight: 700
        }

        .mh-url {
            font-size: 11px;
            color: var(--mh-muted)
        }

        .mh-clamp1,
        .mh-clamp2 {
            display: -webkit-box;
            -webkit-box-orient: vertical;
            overflow: hidden
        }

        .mh-clamp1 {
            -webkit-line-clamp: 1
        }

        .mh-clamp2 {
            -webkit-line-clamp: 2
        }

        .mh-subject {
            font-weight: 700
        }

        .mh-msg {
            font-size: 12px;
            color: var(--mh-muted);
            margin-top: 2px
        }

        .mh-err {
            font-size: 11px;
            color: #dc2626;
            margin-top: 6px
        }

        .mh-file {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            color: #4f46e5;
            margin-top: 6px;
            text-decoration: none
        }

        .mh-file:hover {
            text-decoration: underline
        }

        .mh-date b {
            display: block;
            font-weight: 600
        }

        .mh-date span {
            font-size: 11px;
            color: var(--mh-muted)
        }

        .mh-empty {
            padding: 56px 16px;
            text-align: center;
            color: var(--mh-muted)
        }

        .mh-pager {
            padding: 14px 16px;
            border-top: 1px solid var(--mh-border)
        }

        @media (max-width:768px) {
            .mh-tiles {
                grid-template-columns: repeat(2, 1fr)
            }

            .mh-card {
                overflow-x: auto
            }

            .mh-table {
                min-width: 760px
            }
        }

        .mh-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap
        }

        .mh-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 16px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            background: rgba(255, 255, 255, .16);
            border: 1px solid rgba(255, 255, 255, .35);
            text-decoration: none;
            transition: background .15s
        }

        .mh-back:hover {
            background: rgba(255, 255, 255, .28)
        }

        .mh-back svg {
            width: 16px;
            height: 16px
        }
    </style>

    <div class="mh">

        {{-- Banner --}}
        <div class="mh-banner">
            <div>
                <div class="mh-eyebrow">Customer mail history</div>
                <div class="mh-title">{{ $customer?->name ?? 'Unknown customer' }}</div>
                <div class="mh-sub">{{ $customer?->email ?? '—' }}</div>
            </div>

            <div class="mh-actions">
                <a class="mh-back" href="{{ \App\Filament\Resources\Users\UsersResource::getUrl('index') }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to customers
                </a>

                <div class="mh-total"><b>{{ $cTotal }}</b><span>Total mails</span></div>
            </div>
        </div>

        {{-- Quick filter tiles --}}
        <div class="mh-tiles">
            <button type="button" class="mh-tile {{ $mailType === '' ? 'on' : '' }}" wire:click="$set('mailType', '')">
                <b>{{ $cTotal }}</b><span>All</span>
            </button>
            <button type="button" class="mh-tile {{ $mailType === 'campaign' ? 'on' : '' }}"
                wire:click="$set('mailType', 'campaign')">
                <b>{{ $cCampaign }}</b><span>Campaign</span>
            </button>
            <button type="button" class="mh-tile {{ $mailType === 'offer' ? 'on' : '' }}"
                wire:click="$set('mailType', 'offer')">
                <b>{{ $cOffer }}</b><span>Offer</span>
            </button>
            <button type="button" class="mh-tile {{ $mailType === 'order' ? 'on' : '' }}"
                wire:click="$set('mailType', 'order')">
                <b>{{ $cOrder }}</b><span>Order</span>
            </button>
        </div>

        {{-- Table card --}}
        <div class="mh-card">

            <div class="mh-tools">
                <div class="w-full md:max-w-sm">
                    <x-filament::input.wrapper prefix-icon="heroicon-m-magnifying-glass">
                        <x-filament::input type="text" wire:model.live.debounce.400ms="search"
                            placeholder="Search site, subject or email..." />
                    </x-filament::input.wrapper>
                </div>

                <div class="w-full md:w-48">
                    <x-filament::input.wrapper>
                        <x-filament::input.select wire:model.live="mailType">
                            <option value="">All types</option>
                            <option value="campaign">Campaign</option>
                            <option value="offer">Offer</option>
                            <option value="order">Order</option>
                        </x-filament::input.select>
                    </x-filament::input.wrapper>
                </div>

                @if ($search !== '' || $mailType !== '')
                    <x-filament::button color="gray" icon="heroicon-m-x-mark" wire:click="clearFilters">
                        Clear
                    </x-filament::button>
                @endif

                <div class="md:ml-auto text-sm" style="color:var(--mh-muted)">
                    Showing <strong>{{ $logs->count() }}</strong> of <strong>{{ $logs->total() }}</strong>
                </div>
            </div>

            <table class="mh-table">
                <colgroup>
                    <col style="width:5%">
                    <col style="width:20%">
                    <col style="width:27%">
                    <col style="width:10%">
                    <col style="width:12%">
                    <col style="width:12%">
                    <col style="width:14%">
                </colgroup>
                <thead>
                    <tr>
                        <th class="mh-center">#</th>
                        <th>Website</th>
                        <th>Subject</th>
                        <th class="mh-center">Mail Type</th>
                        <th class="mh-center">Status</th>
                        <th>Date</th>
                        <th class="mh-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $mail)
                        @php
                            $host = parse_url((string) $mail->site_url, PHP_URL_HOST) ?: $mail->site_url;
                            $letter = strtoupper(substr(preg_replace('/^www\./', '', (string) $host), 0, 1)) ?: '?';
                            $preview = trim(preg_replace('/\s+/', ' ', strip_tags((string) $mail->message)));
                            $mt = strtolower(trim($mail->mail_type ?? ''));
                            [$label, $color] = $badges[$mt] ?? [ucfirst($mt ?: 'N/A'), 'gray'];
                            $fileName = $mail->file ? str_replace('public/', '', $mail->file) : null;
                        @endphp
                        <tr>
                            <td class="mh-center" style="color:var(--mh-muted)">{{ $logs->firstItem() + $loop->index }}
                            </td>

                            <td>
                                <div class="mh-site">
                                    <div class="mh-av">{{ $letter }}</div>
                                    <div style="min-width:0">
                                        <div class="mh-host mh-clamp1" title="{{ $mail->site_url }}">
                                            {{ $host ?: '—' }}</div>
                                        <div class="mh-url mh-clamp1">{{ $mail->site_url }}</div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="mh-subject mh-clamp1" title="{{ $mail->subject }}">{{ $mail->subject }}
                                </div>
                                <div class="mh-msg mh-clamp2" title="{{ $preview }}">{{ $preview }}</div>
                                @if ($fileName)
                                    <a class="mh-file" href="{{ asset($fileName) }}" download>
                                        <svg width="12" height="12" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                        </svg>
                                        Attachment
                                    </a>
                                @endif
                            </td>

                            <td class="mh-center">
                                <x-filament::badge :color="$color">{{ $label }}</x-filament::badge>
                            </td>

                            <td class="mh-center">
                                @if ((int) $mail->status === 1)
                                    <x-filament::badge color="success">Sent</x-filament::badge>
                                @else
                                    <x-filament::badge color="danger">Failed</x-filament::badge>
                                    @if ($mail->description)
                                        <div class="mh-err mh-clamp2" title="{{ $mail->description }}">
                                            {{ $mail->description }}</div>
                                    @endif
                                @endif
                            </td>

                            <td class="mh-date">
                                <b>{{ $mail->created_at->format('d M Y') }}</b>
                                <span>{{ $mail->created_at->format('h:i A') }}</span>
                            </td>

                            <td class="mh-center">
                                @if ($mail->status)
                                    <x-filament::button tag="a" size="xs" color="gray"
                                        icon="heroicon-m-chat-bubble-left-right"
                                        style="background:#4f46e5;color:#fff;border:0;" :href="\App\Filament\Pages\ClientMailConversation::getUrl([
                                            'thread' => $mail->id,
                                        ])">
                                        Conversation
                                    </x-filament::button>
                                @else
                                    <span style="color:var(--mh-muted)">&mdash;</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="mh-empty">
                                    <div style="font-size:15px;font-weight:700">No mail history found</div>
                                    <div style="font-size:13px;margin-top:4px">Try a different search or clear the
                                        filters.</div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if ($logs->hasPages())
                <div class="mh-pager">
                    <x-filament::pagination :paginator="$logs" />
                </div>
            @endif
        </div>
    </div>
</x-filament-panels::page>
