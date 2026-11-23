{{-- Automatic follow-up status for one conversation (offer, order or campaign). --}}
@php $followupText = $thread ? $thread->followupStatusText() : null; @endphp
@if($followupText)
    <div class="mt-3 flex flex-wrap items-center justify-between gap-3 rounded-lg border border-gray-200 px-4 py-3 text-sm"
         style="background:#f8f6ff;">
        <span class="text-gray-700">{{ $followupText }}</span>
        @if($thread->followupsActive())
            <form method="POST" action="{{ route('mail.stop-followups', $thread->id) }}"
                  onsubmit="return confirm('Stop automatic follow-ups for this conversation?');">
                @csrf
                <button type="submit" class="rounded-md border border-gray-300 bg-white px-3 py-1 text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Stop follow-ups
                </button>
            </form>
        @endif
    </div>
@endif
@if(session('success'))
    <p class="mt-2 text-sm text-green-700">{{ session('success') }}</p>
@endif
