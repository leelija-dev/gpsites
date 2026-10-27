@extends('layouts.app')
@section('content')
<div class="max-w-3xl mx-auto p-6 space-y-4">
    <h2 class="text-xl font-bold">{{ $thread->site_url }}</h2>

    @foreach ($thread->messages as $msg)
        <div class="border rounded-lg p-4 {{ $msg->direction === 'blog_reply' ? 'bg-green-50' : 'bg-blue-50' }}">
            <div class="text-sm text-gray-600 mb-2">
                <strong>{{ $msg->from_name ?: $msg->from_email }}</strong>
                ({{ str_replace('_', ' ', $msg->direction) }})
                → {{ implode(', ', $msg->forwarded_to ?? $msg->to_emails ?? []) }}
                @if (!empty($msg->forwarded_cc)) · cc {{ implode(', ', $msg->forwarded_cc) }} @endif
                <span class="float-right">{{ optional($msg->sent_at ?? $msg->created_at)->format('d M Y, h:i A') }}</span>
            </div>
            <div>{!! $msg->body_html !!}</div>
            @if ($msg->status === 'failed')
                <div class="text-red-600 text-sm mt-2">Failed: {{ $msg->error }}</div>
            @endif
        </div>
    @endforeach
</div>
@endsection