<x-filament-panels::page>
    @php
        $thread   = $this->loadThread();
        $messages = $this->threadMessages($thread);
        $customer = $this->threadCustomer($thread);
        $lastDate = null;

        $type       = $thread->mail_type ?: 'campaign';
        $typeColors = ['campaign' => 'info', 'offer' => 'primary', 'order' => 'success'];
        $replyCount = $messages->where('direction', 'blog_reply')->count();
        $host       = parse_url($thread->site_url, PHP_URL_HOST) ?: $thread->site_url;
    @endphp

    <style>
        .cv-chat{
            --cv-bg:#efeae2; --cv-border:#e5e7eb; --cv-text:#1f2937; --cv-muted:#6b7280;
            --cv-me:#e4dcf5;  --cv-me-name:#15803d;
            --cv-them:#ffffff; --cv-them-name:#2563eb;
            --cv-pill-bg:#ffffff; --cv-pill-text:#4b5563;
            background:var(--cv-bg); border:1px solid var(--cv-border); border-radius:12px;
            padding:16px; max-height:68vh; overflow-y:auto; color:var(--cv-text);
        }
        .dark .cv-chat{
            --cv-bg:#111827; --cv-border:#374151; --cv-text:#e5e7eb; --cv-muted:#9ca3af;
            --cv-me:#3b2f63; --cv-me-name:#4ade80;
            --cv-them:#1f2937; --cv-them-name:#60a5fa;
            --cv-pill-bg:#1f2937; --cv-pill-text:#d1d5db;
        }
        .cv-day{display:flex;justify-content:center;margin:14px 0 10px}
        .cv-day span{font-size:11px;font-weight:600;padding:3px 12px;border-radius:999px;
            background:var(--cv-pill-bg);color:var(--cv-pill-text);box-shadow:0 1px 2px rgba(0,0,0,.08)}
        .cv-row{display:flex;gap:8px;margin-bottom:12px;align-items:flex-end}
        .cv-row.me{flex-direction:row-reverse}
        .cv-avatar{flex:0 0 30px;width:30px;height:30px;border-radius:50%;display:flex;align-items:center;
            justify-content:center;font-size:12px;font-weight:700;color:#fff}
        .cv-avatar.me{background:linear-gradient(135deg,#2563eb,#7c3aed)}
        .cv-avatar.them{background:linear-gradient(135deg,#0d9488,#0891b2)}
        .cv-bubble{max-width:82%;padding:8px 12px;font-size:14px;line-height:1.5;
            box-shadow:0 1px 2px rgba(0,0,0,.1);min-width:140px}
        .cv-bubble.me{background:var(--cv-me);border-radius:14px 14px 2px 14px}
        .cv-bubble.them{background:var(--cv-them);border-radius:14px 14px 14px 2px}
        .cv-name{font-size:12px;font-weight:700;margin-bottom:3px}
        .me .cv-name{color:var(--cv-me-name)} .them .cv-name{color:var(--cv-them-name)}
        .cv-body{word-break:break-word;overflow-wrap:anywhere;overflow-x:auto}
        .cv-body img,.cv-body table{max-width:100%}
        .cv-meta{display:flex;justify-content:flex-end;align-items:center;gap:8px;margin-top:4px;
            font-size:11px;color:var(--cv-muted)}
        .cv-fail{color:#dc2626;font-weight:600}
        .cv-details{margin-top:6px;font-size:11px;color:var(--cv-muted)}
        .cv-details summary{cursor:pointer;user-select:none;text-align:right}
        .cv-details div{margin-top:3px;word-break:break-all}
        .cv-empty{text-align:center;padding:40px 0;color:var(--cv-muted);font-size:14px}
        .hd{
        --hd-card:#ffffff; --hd-border:#e5e7eb; --hd-text:#111827; --hd-muted:#6b7280;
        --hd-tile:#f9fafb; --hd-icon-bg:#eef2ff; --hd-icon:#4f46e5;
        border:1px solid var(--hd-border); border-radius:16px; overflow:hidden; background:var(--hd-card); color:var(--hd-text);
    }
    .dark .hd{
        --hd-card:#111827; --hd-border:#374151; --hd-text:#f3f4f6; --hd-muted:#9ca3af;
        --hd-tile:#1f2937; --hd-icon-bg:#312e81; --hd-icon:#a5b4fc;
    }
    .hd-banner{background:linear-gradient(135deg,#2563eb,#7c3aed);padding:22px 24px;color:#fff;
        display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:16px}
    .hd-left{display:flex;align-items:center;gap:14px;min-width:0}
    .hd-avatar{flex:0 0 52px;width:52px;height:52px;border-radius:14px;background:rgba(255,255,255,.18);
        border:1px solid rgba(255,255,255,.35);display:flex;align-items:center;justify-content:center;
        font-size:22px;font-weight:800}
    .hd-eyebrow{font-size:11px;letter-spacing:1px;text-transform:uppercase;opacity:.8}
    .hd-title{font-size:20px;font-weight:800;line-height:1.3;margin-top:2px;word-break:break-word}
    .hd-site{display:inline-block;margin-top:4px;font-size:13px;color:#e0e7ff;text-decoration:none;word-break:break-all}
    .hd-site:hover{text-decoration:underline}
    .hd-back{display:inline-flex;align-items:center;gap:6px;padding:9px 16px;border-radius:10px;font-size:13px;
        font-weight:600;color:#fff;background:rgba(255,255,255,.16);border:1px solid rgba(255,255,255,.35);
        text-decoration:none;transition:background .15s}
    .hd-back:hover{background:rgba(255,255,255,.28)}
    .hd-back svg{width:16px;height:16px}

    .hd-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;padding:16px 24px 0}
    .hd-stat{background:var(--hd-tile);border:1px solid var(--hd-border);border-radius:12px;padding:12px 14px}
    .hd-stat b{display:block;font-size:20px;line-height:1.2}
    .hd-stat span{font-size:12px;color:var(--hd-muted)}
    .hd-stat.ok b{color:#16a34a} .hd-stat.warn b{color:#d97706}

    .hd-info{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;padding:12px 24px 22px}
    .hd-box{display:flex;gap:12px;align-items:flex-start;border:1px solid var(--hd-border);border-radius:12px;padding:14px;min-width:0}
    .hd-ico{flex:0 0 36px;width:36px;height:36px;border-radius:10px;background:var(--hd-icon-bg);color:var(--hd-icon);
        display:flex;align-items:center;justify-content:center}
    .hd-ico svg{width:18px;height:18px}
    .hd-label{font-size:11px;letter-spacing:.8px;text-transform:uppercase;color:var(--hd-muted)}
    .hd-value{font-size:14px;font-weight:700;margin-top:2px;word-break:break-word}
    .hd-sub{font-size:12px;color:var(--hd-muted);word-break:break-all;margin-top:1px}

    @media (max-width:768px){
        .hd-stats,.hd-info{grid-template-columns:1fr}
        .hd-banner,.hd-stats,.hd-info{padding-left:16px;padding-right:16px}
    }
    /* heading row with info icon */
.cv-head{display:flex;align-items:center;gap:10px;margin-bottom:12px}
.cv-head-title{font-size:16px;font-weight:700}
.cv-info{
    --in-bd:#d1d5db; --in-fg:#6b7280; --in-on-bg:#fef3c7; --in-on-fg:#b45309; --in-on-bd:#fcd34d;
    position:relative; width:26px; height:26px; border-radius:50%; cursor:pointer;
    display:flex; align-items:center; justify-content:center;
    background:transparent; border:1px solid var(--in-bd); color:var(--in-fg); transition:all .2s;
}
.dark .cv-info{--in-bd:#4b5563; --in-fg:#9ca3af; --in-on-bg:#2a2112; --in-on-fg:#fcd34d; --in-on-bd:#5b4a1f}
.cv-info:hover{border-color:#f59e0b;color:#f59e0b}
.cv-info.on{background:var(--in-on-bg);color:var(--in-on-fg);border-color:var(--in-on-bd)}
.cv-info svg{width:16px;height:16px}
.cv-info-dot{position:absolute;top:-2px;right:-2px;width:8px;height:8px;border-radius:50%;background:#f59e0b}

/* the notice */
.cv-note{
    --nt-bg:#fffbeb; --nt-border:#fde68a; --nt-text:#92400e; --nt-icon:#f59e0b;
    display:flex; gap:12px; align-items:flex-start; overflow:hidden;
    background:var(--nt-bg); border:1px solid var(--nt-border); border-left:4px solid var(--nt-icon);
    border-radius:12px; padding:12px 14px; margin-bottom:12px; color:var(--nt-text);
}
.dark .cv-note{--nt-bg:#2a2112; --nt-border:#5b4a1f; --nt-text:#fcd34d; --nt-icon:#f59e0b}
.cv-note-ico{flex:0 0 20px;width:20px;height:20px;margin-top:1px;color:var(--nt-icon)}
.cv-note-title{font-size:13px;font-weight:700}
.cv-note-text{font-size:12.5px;line-height:1.5;margin-top:2px;opacity:.95}
.cv-note-close{margin-left:auto;background:none;border:0;cursor:pointer;color:inherit;opacity:.6;
    font-size:18px;line-height:1;padding:0 2px}
.cv-note-close:hover{opacity:1}

/* shrink into the i icon (top-left) and come back out */
.cv-t-active{transition:all .35s cubic-bezier(.4,0,.2,1);transform-origin:top left}
.cv-t-shown{opacity:1;transform:scale(1) translateY(0);max-height:240px}
.cv-t-hidden{opacity:0;transform:scale(.08) translateY(-26px);max-height:0;
    margin-bottom:0;padding-top:0;padding-bottom:0;border-width:0}
    </style>

    {{-- Header --}}
   
    <div class="hd">

    {{-- Banner --}}
    <div class="hd-banner">
        <div class="hd-left">
            <div class="hd-avatar">{{ strtoupper(substr(preg_replace('/^www\./', '', (string) $host), 0, 1)) ?: '?' }}</div>
            <div style="min-width:0">
                <div class="hd-eyebrow">{{ ucfirst($type) }} conversation</div>
                <div class="hd-title">{{ $thread->subject }}</div>
                <a class="hd-site" href="{{ $thread->site_url }}" target="_blank" rel="nofollow noopener">{{ $host }} &#8599;</a>
            </div>
        </div>

        <a class="hd-back"
           href="{{ \App\Filament\Pages\ClientMailHistory::getUrl(['user_id' => $thread->user_id]) }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to history
        </a>
    </div>

    {{-- Stats --}}
    <div class="hd-stats">
        <div class="hd-stat">
            <b>{{ ucfirst($type) }}</b>
            <span>Mail type</span>
        </div>
        <div class="hd-stat">
            <b>{{ $messages->count() }}</b>
            <span>{{ \Illuminate\Support\Str::plural('Message', $messages->count()) }} in thread</span>
        </div>
        <div class="hd-stat {{ $replyCount ? 'ok' : 'warn' }}">
            <b>{{ $replyCount ?: 'None' }}</b>
            <span>{{ $replyCount ? \Illuminate\Support\Str::plural('Reply', $replyCount) . ' from blog owner' : 'No reply from blog owner yet' }}</span>
        </div>
    </div>

    {{-- Info --}}
    <div class="hd-info">
        <div class="hd-box">
            <div class="hd-ico">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
            <div style="min-width:0">
                <div class="hd-label">Customer</div>
                <div class="hd-value">{{ $customer?->name ?? '—' }}</div>
                <div class="hd-sub">{{ $customer?->email ?? '—' }}</div>
            </div>
        </div>

        <div class="hd-box">
            <div class="hd-ico">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.9 5.3a2 2 0 002.2 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
            <div style="min-width:0">
                <div class="hd-label">Blog owner</div>
                <div class="hd-value" style="word-break:break-all">{{ $thread->blog_email ?: '—' }}</div>
                <div class="hd-sub">{{ $host }}</div>
            </div>
        </div>

        <div class="hd-box">
            <div class="hd-ico">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 011 1v14a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1z"/></svg>
            </div>
            <div style="min-width:0">
                <div class="hd-label">Started</div>
                <div class="hd-value">{{ $thread->created_at->format('d M Y') }}</div>
                <div class="hd-sub">{{ $thread->created_at->format('h:i A') }} &middot; {{ $thread->created_at->diffForHumans() }}</div>
            </div>
        </div>
    </div>
</div>
    {{-- Conversation --}}
    <x-filament::section>
<div x-data="{ open: true }">

    {{-- Heading + info icon --}}
    <div class="cv-head">
        <span class="cv-head-title">Conversation</span>

        <button type="button" class="cv-info" :class="{ 'on': open }"
                @click="open = !open" title="About this conversation" aria-label="About this conversation">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="cv-info-dot" x-show="!open"></span>
        </button>
    </div>

    {{-- Notice --}}
    <div class="cv-note" x-show="open"
         x-transition:enter="cv-t-active" x-transition:enter-start="cv-t-hidden" x-transition:enter-end="cv-t-shown"
         x-transition:leave="cv-t-active" x-transition:leave-start="cv-t-shown" x-transition:leave-end="cv-t-hidden">
        <svg class="cv-note-ico" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 8v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
        </svg>

        <div>
            <div class="cv-note-title">Times may not be exact</div>
            <div class="cv-note-text">
                Messages are collected from the mailbox in the background and saved a little later.
                The time shown here is when the message was saved, so it can be a few minutes later than the
                time in your email app. Order and content are not affected.
            </div>
        </div>

        <button type="button" class="cv-note-close" @click="open = false" aria-label="Close">&times;</button>
    </div>
        <div class="cv-chat" x-data x-init="$nextTick(() => $el.scrollTop = $el.scrollHeight)">

            @forelse ($messages as $message)
                @php
                    $time   = $message->sent_at ?? $message->created_at;
                    $isUser = in_array($message->direction, ['initial', 'user_reply']);
                    $day    = $time->format('Y-m-d');
                    $name   = $isUser ? ($customer?->name ?? 'Customer') : ($message->from_name ?: $message->from_email);
                    $letter = strtoupper(mb_substr((string) $name, 0, 1)) ?: '?';
                    $dayLabel = $time->isToday() ? 'Today' : ($time->isYesterday() ? 'Yesterday' : $time->format('d M Y'));

                    $to  = implode(', ', $message->to_emails ?? []);
                    $cc  = implode(', ', $message->cc_emails ?? []);
                    $bcc = implode(', ', $message->bcc_emails ?? []);
                    $fwd = implode(', ', $message->forwarded_to ?? []);
                    $hasDetails = $to || $cc || $bcc || $fwd || $message->error;
                @endphp

                @if ($lastDate !== $day)
                    <div class="cv-day"><span>{{ $dayLabel }}</span></div>
                    @php $lastDate = $day; @endphp
                @endif

                <div class="cv-row {{ $isUser ? 'me' : 'them' }}">
                    <div class="cv-avatar {{ $isUser ? 'me' : 'them' }}">{{ $letter }}</div>

                    <div class="cv-bubble {{ $isUser ? 'me' : 'them' }}">
                        <div class="cv-name">{{ $name }}</div>

                        <div class="cv-body">{!! $message->body_html !!}</div>

                        <div class="cv-meta">
                            @if ($message->status === 'failed')
                                <span class="cv-fail">failed</span>
                            @endif
                            <span>{{ $time->format('h:i A') }}</span>
                        </div>

                        @if ($hasDetails)
                            <details class="cv-details">
                                <summary>Details</summary>
                                @if ($to)  <div><strong>To:</strong> {{ $to }}</div> @endif
                                @if ($cc)  <div><strong>CC:</strong> {{ $cc }}</div> @endif
                                @if ($bcc) <div><strong>BCC:</strong> {{ $bcc }}</div> @endif
                                @if ($fwd) <div><strong>Forwarded to:</strong> {{ $fwd }}</div> @endif
                                @if ($message->error) <div class="cv-fail"><strong>Error:</strong> {{ $message->error }}</div> @endif
                            </details>
                        @endif
                    </div>
                </div>
            @empty
                <div class="cv-empty">No messages yet.</div>
            @endforelse
        </div>
    </div>
    </x-filament::section>
</x-filament-panels::page>